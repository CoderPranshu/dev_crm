<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{VendorContract, User};
use Mail;
use Carbon\Carbon;

class VendorContractController extends Controller
{

    public function __construct()
    {
        // $this->sendContractReminders();

        $this->middleware('permission:vendor-contract-list|vendor-contract-create|vendor-contract-update|vendor-contract-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:vendor-contract-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vendor-contract-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vendor-contract-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $vendorCon = VendorContract::latest()->get();

        $ven = VendorContract::where('end_date', '<', now())->where('status', 'active')->update(['status' => 'expired']);

        return view('admin.vendorContract.index', compact('vendorCon'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'vendor_id' => 'nullable',
            'description' => 'nullable',
            'doc' => 'nullable|mimes:pdf',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('doc')) {
            $filename = uniqid() . '.' . $request->doc->getClientOriginalExtension();
            $request->doc->move(public_path('uploads/vendorcont/'), $filename);
            $data['doc'] = $filename;
        }

        $res = VendorContract::create($data);

        if ($res) {
            return back()->with('success_message', 'Vendor contract created successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $con = VendorContract::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'title' => 'nullable',
            'vendor_id' => 'nullable',
            'description' => 'nullable',
            'doc' => 'nullable|mimes:pdf',
            'status' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable'
        ]);

        if ($request->hasFile('doc')) {
            $filename = uniqid() . '.' . $request->doc->getClientOriginalExtension();
            $request->doc->move(public_path('uploads/vendorcont/'), $filename);
            $data['doc'] = $filename;
        }

        $res = $con->update($data);

        if ($res) {
            return back()->with('success_message', 'Vendor contract updated successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $con = VendorContract::where('id', $id)->firstOrFail();

        $res = $con->delete();

        if ($res) {
            return back()->with('success_message', 'VendorContract deleted successfully');
        }
    }

    // public function sendContractReminders()
    // {
    //     $contracts = VendorContract::with('vendor.user')->get();

    //     foreach ($contracts as $contract) {

    //         if (!$contract->end_date) {
    //             continue;
    //         }

    //         $today = Carbon::today();
    //         $endDate = Carbon::parse($contract->end_date);

    //         $diff = $today->diffInDays($endDate, false);

    //         // Get already sent reminders
    //         $sent = $contract->reminder_sent ? json_decode($contract->reminder_sent, true) : [];

    //         // Recipients: Admin + Vendor
    //         $mailRecipients = [];

    //         // Admin (you can customize role logic)
    //         $admins = User::where('role', 'admin')->get();
    //         foreach ($admins as $admin) {
    //             $mailRecipients[] = $admin;
    //         }

    //         // Vendor
    //         if ($contract->vendor && $contract->vendor->user) {
    //             $mailRecipients[] = $contract->vendor->user;
    //         }

    //         // FUNCTION TO SEND MAIL
    //         $sendMail = function ($subject, $messageKey) use ($mailRecipients, $contract) {
    //             foreach ($mailRecipients as $user) {

    //                 $mailData = [
    //                     'subject' => $subject,
    //                     'name' => $user->name,
    //                     'message' => "
    //                         Contract No: {$contract->contract_number}
    //                         Vendor: {$contract->vendor->user->name}
    //                         Expiry Date: {$contract->end_date->format('d M, Y')}

    //                         {$messageKey}
    //                 ",
    //                 ];

    //                 Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
    //             }
    //         };

    //         //  2 Days Before
    //         if ($diff == 2 && !in_array('2_days', $sent)) {

    //             $sendMail(
    //                 'Contract Expiring in 2 Days',
    //                 'This contract will expire in 2 days. Please review for renewal.'
    //             );

    //             $sent[] = '2_days';
    //         }

    //         //  1 Day Before
    //         if ($diff == 1 && !in_array('1_day', $sent)) {

    //             $sendMail(
    //                 'Contract Expiring Tomorrow',
    //                 'This contract will expire tomorrow. Please take action.'
    //             );

    //             $sent[] = '1_day';
    //         }

    //         //  Same Day
    //         if ($diff == 0 && !in_array('same_day', $sent)) {

    //             $sendMail(
    //                 'Contract Expiring Today',
    //                 'This contract is expiring today. Immediate action required.'
    //             );

    //             $sent[] = 'same_day';
    //         }

    //         // Save sent reminders
    //         $contract->update([
    //             'reminder_sent' => json_encode($sent)
    //         ]);
    //     }
    // }
}
