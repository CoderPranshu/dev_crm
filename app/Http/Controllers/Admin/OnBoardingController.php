<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Stage, Recruitment, OnBoarding, Candidate};
use Mail;
use Symfony\Component\Mime\Part\TextPart;
use App\Mail\StageMail;

class OnBoardingController extends Controller
{
    public function index()
    {
        $stages = OnBoarding::orderBy('created_at', 'asc')->get();
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $recruitments = Recruitment::orderBy('created_at', 'asc')->get();
        } elseif ($user->is_manager == 1) {
            $recruitments = Recruitment::where('manager_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $recruitments = Recruitment::where('branch_id', $user->branch_id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('admin.onboarding.index', compact('stages', 'recruitments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'email_template' => 'nullable|string',
        ]);

        $rec =  OnBoarding::create($request->only('title', 'description', 'email_template'));

        if ($rec) {
            return redirect()->back()->with('success_message', __('New onboarding added successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }


    public function getStageTemplate($id)
    {
        $stage = OnBoarding::find($id);

        return response()->json([
            'subject'  => $stage->title . ' - Update',
            'template' => $stage->email_template,
        ]);
    }

    // 2. Send email
    public function sendStageMail(Request $request)
    {
        $candidateIds = explode(',', $request->candidate_ids);
        $subject = $request->subject;
        $messageHtml = $request->message;

        $candidates = Candidate::whereIn('id', $candidateIds)->get();

        foreach ($candidates as $candi) {

            $finalMessage = str_replace(
                ['[[name]]', '[[stage]]', '[[upload_link]]'],
                [$candi->name, $candi->stage->title ?? '', url('/upload-documents/' . $candi->id)],
                $messageHtml
            );

            if (trim($finalMessage) === '') {
                $finalMessage = 'Hello ' . $candi->name . ', you have a new stage update.';
            }

            Mail::to($candi->email)->send(new StageMail($subject, $finalMessage));
        }




        return response()->json([
            'status' => true,
            'message' => "Email sent successfully!"
        ]);
    }

    public function updateStage(Request $request, $candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);
        $stageId = $request->input('onboarding');

        $stage = OnBoarding::findOrFail($stageId);

        // Validate stage belongs to candidate's recruitment
        // if ($stage->recruitment_id != $candidate->recruitment_id) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Selected stage does not belong to this candidate\'s recruitment.'
        //     ], 400);
        // }

        $candidate->onboarding = $stageId;
        $candidate->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate stage updated successfully.'
        ]);
    }

    public function SelectedCandi()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $candidates = Candidate::where('cand_type', 'selected')
                ->whereNull('is_emp')
                ->get();
        } elseif ($user->is_manager == 1) {
            $candidates = Candidate::where('cand_type', 'selected')
                ->whereNull('is_emp')
                ->whereHas('recruitment', function ($query) use ($user) {
                    $query->where('manager_id', $user->id);
                })
                ->get();
        } else {
            $candidates = Candidate::where('cand_type', 'selected')
                ->whereNull('is_emp')
                ->whereHas('recruitment', function ($query) use ($user) {
                    $query->where('branch_id', $user->branch_id);
                })
                ->get();
        }

        return view('admin.onboarding.selected', compact('candidates'));
    }

    public function rejectedCandi()
    {
        if (auth()->user()->hasRole('Admin')) {
            $candidates = Candidate::where('cand_type', 'rejected')
                ->whereNull('is_emp')
                ->get();
        } else {
            $candidates = Candidate::where('cand_type', 'rejected')
                ->whereNull('is_emp')
                ->whereHas('recruitment', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                })->get();
        }
        return view('admin.onboarding.rejected', compact('candidates'));
    }

    public function onbordingstage(Request $request, $id)
    {
        $candi = Candidate::where('id', $id)->first();

        $data = $request->validate([
            'onboarding' => 'required'
        ]);

        $res = $candi->update($data);

        if ($res) {
            return back()->with('success_message', 'Candidate updated successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        // dd
        $candi = Candidate::find($id);
        // dd($candi);
        $data = $request->validate([
            'cand_type' => 'required',
        ]);

        // dd($data);

        $candi->update($data);

        return back()->with('success_message', 'Candidate setted as the awaiting again');
    }
}
