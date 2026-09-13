<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Leave_application, FileUploader, LeaveType};
use Mail;

class LeaveApplicationController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:leave-report-list|leave-report-create|leave-report-edit|leave-report-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:leave-report-list', ['only' => ['create', 'store']]);
        $this->middleware('permission:leave-report-list', ['only' => ['change_status']]);
        $this->middleware('permission:leave-report-delete', ['only' => ['destroy']]);
    }

    function index(Request $request)
    {
        if (auth()->user()->hasRole('Admin')) {
            $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        } else {
            $page_data['users'] = User::where('id', auth()->user()->id)->get();
            // dd($page_data);
        }
        return view('admin.leave.index', $page_data);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $data['user_id'] = $request->user_id;
        } else {
            $data['user_id'] = auth()->user()->id;
        }
    
        // -----------------------------
        // VALIDATION
        // -----------------------------
        $this->validate($request, [
            'attachment' => 'nullable|mimes:pdf,jpg,jpeg,png,gif,svg,webp',
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after:from_date',
            'reason'    => 'required',
        ]);
    
        // -----------------------------
        // DATE CONVERSION
        // -----------------------------
        $start = \Carbon\Carbon::parse($request->from_date)->startOfDay();
        $end   = \Carbon\Carbon::parse($request->to_date)->endOfDay();
    
        // Store as timestamp
        $data['from_date'] = $start->timestamp;
        $data['to_date']   = $end->timestamp;
    
        // -----------------------------
        // ✅ CORRECT LEAVE DAYS
        // -----------------------------
        $leaveDays = $start->diffInDays($end) + 1;
    
        $data['days'] = $leaveDays; // 👈 use this column instead of working_day
    
        // -----------------------------
        // OTHER DATA
        // -----------------------------
        $data['status'] = 'pending';
        $data['reason'] = $request->reason;
    
        if ($request->attachment) {
            $data['attachment'] = FileUploader::upload($request->attachment, 'uploads/leave-attachment');
        }
    
        Leave_application::create($data);
    
        return redirect()->back()->with('success_message', get_phrase('Your request has been successfully submitted'));
    }

    function delete(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            Leave_application::where('id', $request->id)->delete();
        } else {
            Leave_application::where('id', $request->id)->where('user_id', auth()->user()->id)->delete();
        }
        return redirect()->back()->with('success_message', get_phrase('Leave request deleted successfully'));
    }

    function change_status($id, Request $request)
    {

        $leave_report = Leave_application::where('id', $id)->first();
        $to = User::where('id', $leave_report->user_id)->first();

        if ($request->status == 'approved') {
            $data['status'] = 'approved';
            $subject = get_phrase("Your Leave Request Has Been Approved");
        } elseif ($request->status == 'rejected') {
            $data['status'] = 'rejected';
            $subject = get_phrase("Leave Request Denied");
        } elseif ($request->status == 'pending') {
            $data['status'] = 'pending';
        }

        Leave_application::where('id', $id)->update($data);

        if ($request->message) {
            try {
                Mail::raw($request->message, function ($message) use ($subject, $to) {
                    $message->from(get_settings('system_email'), get_settings('website_title'))
                        ->to($to->email, $to->name)
                        ->subject($subject);
                });
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success_message', get_phrase('Request has been' . $request->status));
    }
}
