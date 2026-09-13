<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{EmailAutomation, EmailTemplate, Subscriber, EmailCampaign, CampaignSubscriber};
use DB;
use App\Jobs\SendEmailCampaignJob;

class EmailAutomationController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:email-automation-list|email-automation-create|email-automation-update|email-automation-delete', ['only' => ['index','store']]);
         $this->middleware('permission:email-automation-create', ['only' => ['create','store']]);
         $this->middleware('permission:email-automation-update', ['only' => ['edit','update']]);
         $this->middleware('permission:email-automation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $emails = DB::table('email_campaigns')->latest()->get();
        return view('admin.emailautomation.index', compact('emails'));
    }

    public function add(Request $request)
    {
        $branchId = auth()->user()->hasRole('Admin')
            ? $request->branch_id
            : auth()->user()->branch_id;

        $templates = [];
        $subscribers = [];

        if ($branchId) {
            $templates = EmailTemplate::where('branch_id', $branchId)->get();
            $subscribers = Subscriber::where('branch_id', $branchId)->get();
        }

        return view('admin.emailautomation.add', compact('templates', 'subscribers', 'branchId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'subject'       => 'required|string',
            'template_id'   => 'required|exists:email_templates,id',
            'subscribers'   => 'required|array',
            'branch_id' => 'nullable'
        ]);

        // Create Campaign
        $campaign = EmailCampaign::create([
            'name'          => $request->name,
            'subject'       => $request->subject,
            'template_id'   => $request->template_id,
            'schedule_time' => $request->schedule_time ?: null,
            'status'        => $request->schedule_time ? 'scheduled' : 'sent',
            'branch_id' => $request->branch_id
        ]);

        // Save subscribers (pivot)
        foreach ($request->subscribers as $subscriberId) {
            CampaignSubscriber::create([
                'campaign_id'   => $campaign->id,
                'subscriber_id' => $subscriberId
            ]);
        }

        // Send immediately if no schedule time
        if (!$request->schedule_time) {
            dispatch(new SendEmailCampaignJob($campaign->id));
        }

        return redirect()
            ->route('admin.emailautomation.index')
            ->with('success_message', 'Campaign created successfully.');
    }

    public function edit($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $templates = EmailTemplate::all();
        $subscribers = Subscriber::all();
        $selectedSubscribers = CampaignSubscriber::where('campaign_id', $campaign->id)
            ->pluck('subscriber_id')
            ->toArray();

        return view('admin.emailautomation.edit', compact('campaign', 'templates', 'subscribers', 'selectedSubscribers'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'subject'       => 'required|string',
            'template_id'   => 'required|exists:email_templates,id',
            'subscribers'   => 'required|array',
        ]);

        $campaign = EmailCampaign::findOrFail($id);

        // Update base data
        $campaign->update([
            'name'          => $request->name,
            'subject'       => $request->subject,
            'template_id'   => $request->template_id,
            'schedule_time' => $request->schedule_time ?: null,
            'status'        => $request->schedule_time ? 'scheduled' : $campaign->status,
        ]);

        // Delete previous subscriber entries
        CampaignSubscriber::where('campaign_id', $campaign->id)->delete();

        // Recreate pivot data
        foreach ($request->subscribers as $subscriberId) {
            CampaignSubscriber::create([
                'campaign_id'   => $campaign->id,
                'subscriber_id' => $subscriberId
            ]);
        }

        // If schedule removed, send now
        if (!$request->schedule_time && $campaign->status !== 'sent') {
            dispatch(new SendEmailCampaignJob($campaign->id));
        }

        return redirect()
            ->route('admin.emailautomation.edit', $campaign->id)
            ->with('success_message', 'Campaign updated successfully.');
    }

    public function destroy($id)
    {
        $campaign = EmailCampaign::find($id);

        if (! $campaign) {
            return redirect()->back()->with('error_message', 'Campaign not found.');
        }

        DB::beginTransaction();
        try {
            CampaignSubscriber::where('campaign_id', $campaign->id)->delete();
            $campaign->delete();
            DB::commit();

            return redirect()
                ->route('admin.emailautomation.index')
                ->with('success_message', 'Campaign deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_message', 'Failed to delete campaign.');
        }
    }

    public function getData(Request $request)
    {
        $branchId = $request->branch_id;

        $templates = EmailTemplate::where('branch_id', $branchId)->get();
        $subscribers = Subscriber::where('branch_id', $branchId)->get();

        return response()->json([
            'templates' => $templates,
            'subscribers' => $subscribers
        ]);
    }
}
