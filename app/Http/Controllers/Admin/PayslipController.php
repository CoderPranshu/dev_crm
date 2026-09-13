<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance, Payslip, Branch};
use Session, Image;
use Dompdf\Dompdf;
use Mail;
use Carbon\Carbon;
use Http;

class PayslipController extends Controller
{

function index(Request $request)
{
    // Selected Month & Year
    $selected_year = $request->get('year', date('Y'));
    $selected_month = $request->get('month', date('m'));
    $selected_month = str_pad($selected_month, 2, '0', STR_PAD_LEFT);

    // Build month start/end
    $monthStart = "$selected_year-$selected_month-01";
    $monthEnd   = date("Y-m-t", strtotime($monthStart));

    $user = auth()->user();

    // Base query
    if ($user->role == 'admin') {
        $query = User::where('status', 'active')->orderBy('sort');
    } else {
        $query = User::where('status', 'active')
            ->where('branch_id', $user->branch_id)
            ->orderBy('sort');
    }

    // Apply approved leave count
    $page_data['users'] = $query->withCount([
        'leave as approved_leave_count' => function ($q) use ($monthStart, $monthEnd) {
            $q->where('status', 'approved')
              ->where(function ($q2) use ($monthStart, $monthEnd) {
                  $q2->whereBetween('from_date', [$monthStart, $monthEnd])
                     ->orWhereBetween('to_date', [$monthStart, $monthEnd])
                     ->orWhere(function ($q3) use ($monthStart, $monthEnd) {
                         $q3->where('from_date', '<=', $monthStart)
                            ->where('to_date', '>=', $monthEnd);
                     });
              });
        }
    ])->get();

    $page_data['month'] = $selected_month;
    $page_data['year'] = $selected_year;

    return view('admin.payslip.index', $page_data);
}


    public function store(Request $request)
    {
        // Role-based user ID assignment
        if (auth()->user()->role == 'admin') {
            $data['user_id'] = $request->user_id;
        } elseif (auth()->user()->role == 'staff') {
            $data['user_id'] = auth()->user()->id;
        }

        // Validation rules
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'brief_of_monthly_salary' => 'nullable|string',
            'net_salary' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'penalty' => 'required|numeric',
            'status' => 'required|numeric|min:0|max:1',
            'uan_no' => 'nullable|string',
            'esi_no' => 'nullable|string',
            'hra' => 'nullable|numeric',
            'conveyance_allowance' => 'nullable|numeric',
            'other_allowance' => 'nullable|numeric',
            'gross_salary' => 'nullable|numeric',
            'pf' => 'nullable|numeric',
            'esi' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'tds' => 'nullable|numeric',
            'other_deduc' => 'nullable|numeric',
            'total_deduc' => 'nullable|numeric',
            'total_net' => 'nullable|numeric',
            'working_days' => 'nullable|numeric',
            'present_days' => 'nullable|numeric',
            'leave_withoutpay' => 'nullable|numeric',
            'over_time' => 'nullable|numeric',
            'final_payable' => 'nullable|numeric',
            'payment_mode' => 'nullable|string',
            'payment_date' => 'nullable|date',
            'approved_by' => 'nullable|string',
            'note' => 'nullable|string'
        ]);

        // Extract first date from date range
        $brief_of_monthly_salary = strtotime(explode(' - ', $request->brief_of_monthly_salary)[0]);

        // Assign data from request
        $data['uan_no'] = $request->uan_no;
        $data['esi_no'] = $request->esi_no;
        $data['net_salary'] = $request->net_salary;
        $data['hra'] = $request->hra;
        $data['conveyance_allowance'] = $request->conveyance_allowance;
        $data['other_allowance'] = $request->other_allowance;
        $data['gross_salary'] = $request->gross_salary;
        $data['pf'] = $request->pf;
        $data['esi'] = $request->esi;
        $data['tax'] = $request->tax;
        $data['tds'] = $request->tds;
        $data['other_deduc'] = $request->other_deduc;
        $data['total_deduc'] = $request->total_deduc;
        $data['total_net'] = $request->total_net;
        $data['working_days'] = $request->working_days;
        $data['present_days'] = $request->present_days;
        $data['leave_withoutpay'] = $request->leave_withoutpay;
        $data['over_time'] = $request->over_time;
        $data['bonus'] = $request->bonus;
        $data['penalty'] = $request->penalty;
        $data['final_payable'] = $request->final_payable;
        $data['payment_mode'] = $request->payment_mode;
        $data['payment_date'] = $request->payment_date;
        $data['approved_by'] = $request->approved_by;
        $data['status'] = $request->status;
        $data['note'] = $request->note;

        // Store salary month as start of month
        $data['month_of_salary'] = date('Y-m-d 00:00:00', $brief_of_monthly_salary);

        // Insert data into payslip table
        $invoice_id = Payslip::insertGetId($data);

        // Fetch created payslip and employee
        $payslip = Payslip::find($invoice_id);
        $user = User::find($data['user_id']);

        if ($payslip && $user) {
            $salaryMonth = \Carbon\Carbon::parse($payslip->month_of_salary)->format('F Y');

            // ---------------- SYSTEM NOTIFICATION ----------------
            $systemRecipients = getNotificationRecipients(
                type: 'salary_ready',
                channel: 'system'
            );

            // ---------------- MAIL NOTIFICATION ----------------
            $mailRecipients = getNotificationRecipients(
                type: 'salary_ready',
                channel: 'mail'
            )->filter(fn($recipient) => !empty($recipient->email));

            // Also send to employee
            $systemRecipients = collect($systemRecipients)->push($user)->unique('id');

            if (!empty($user->email)) {
                $mailRecipients = collect($mailRecipients)->push($user)->unique('id');
            }

            // ---------------- SEND SYSTEM ----------------
            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Payslip Created',
                    message: 'Payslip for ' . $salaryMonth . ' has been created for ' . $user->name . '. Final payable amount: ₹' . number_format($payslip->final_payable, 2) . '.',
                    type: 'salary_ready',
                    url: route('admin.payslip'),
                    extra: [
                        'payslip_id' => $payslip->id,
                        'user_id' => $user->id,
                        'month_of_salary' => $payslip->month_of_salary,
                        'final_payable' => $payslip->final_payable
                    ]
                );
            }

            // ---------------- SEND MAIL ----------------
            foreach ($mailRecipients as $recipient) {
                $mailData = [
                    'subject' => 'Payslip Created - ' . $salaryMonth,
                    'name' => $recipient->name,
                    'message' => $recipient->id == $user->id
                        ? 'Dear ' . $user->name . ', your payslip for ' . $salaryMonth . ' has been created successfully. Your final payable amount is ₹' . number_format($payslip->final_payable, 2) . '. Please review your payslip for complete details.'
                        : 'This is to inform you that the payslip for employee ' . $user->name . ' has been created for ' . $salaryMonth . '. Final payable amount: ₹' . number_format($payslip->final_payable, 2) . '.',
                    'employee_name' => $user->name,
                    'salary_month' => $salaryMonth,
                    'final_payable' => number_format($payslip->final_payable, 2),
                    'present_days' => $payslip->present_days,
                    'working_days' => $payslip->working_days,
                    'leave_withoutpay' => $payslip->leave_withoutpay,
                    'over_time' => $payslip->over_time,
                ];

                Mail::to($recipient->email)->queue(new \App\Mail\GenericMail($mailData));
            }
        }

        return redirect()->back()->with('success_message', __('Payslip created successfully'));
    }

    public function approve(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // Month range (current month)
        $startDate = Carbon::now()->startOfMonth();
        $endDate   = Carbon::now()->endOfMonth();

        // Branch & machine
        $branch = Branch::find($user->branch_id);

        // Fetch attendance from API
        $response = Http::post('http://ta.biumetrics.com/api/transaction/GetRowData', [
            'TXN_NAME' => 'GetRowData',
            'DATA' => json_encode([
                'Company_Code'     => '17',
                'ReportDate_From'  => $startDate->format('Y/m/d'),
                'ReportDate_To'    => $endDate->format('Y/m/d'),
                'MachineSerialNo'  => $branch->machine_serial_no,
            ])
        ]);

        $rows = collect($response->json()['data'] ?? []);

        // Filter this user by PAYCODE
        $userRows = $rows->where('PAYCODE', $user->paycode);

        // Group by punch date
        $grouped = $userRows->groupBy(function ($row) {
            return substr($row['OFFICEPUNCH'], 0, 10);
        });

        $presentDays = 0;
        $overtimeHours = 0;

        foreach ($grouped as $date => $punches) {
            $punches = $punches->sortBy('OFFICEPUNCH')->values();

            if ($punches->count() >= 1) {
                $presentDays++;

                if ($punches->count() >= 2) {
                    $in  = Carbon::parse($punches[0]['OFFICEPUNCH']);
                    $out = Carbon::parse($punches[1]['OFFICEPUNCH']);

                    $workedHours = $out->diffInMinutes($in) / 60;

                    if ($workedHours > 8) {
                        $overtimeHours += ($workedHours - 8);
                    }
                }
            }
        }

        $overtimeHours = round($overtimeHours, 2);

        // Working days (Mon–Sat)
        $workingDays = 0;
        for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
            if ($d->dayOfWeekIso !== 7) {
                $workingDays++;
            }
        }

        $leaveWithoutPay = max($workingDays - $presentDays, 0);

        $monthlySalary = $user->salary ?? 0;

        if ($workingDays > 0) {
            $perDaySalary  = $monthlySalary / $workingDays;
            $perHourSalary = $perDaySalary / 8;

            $absentDeduction = $leaveWithoutPay * $perDaySalary;
            $overtimeAmount  = $overtimeHours * $perHourSalary;
        } else {
            $absentDeduction = 0;
            $overtimeAmount  = 0;
        }

        $payslip = new Payslip();
        $payslip->user_id = $user->id;
        $payslip->status = 1;

        // Earnings
        $payslip->net_salary = $monthlySalary;
        $payslip->hra = 0;
        $payslip->conveyance_allowance = 0;
        $payslip->other_allowance = 0;

        // Deductions
        $payslip->pf = 0;
        $payslip->esi = 0;
        $payslip->tax = 0;
        $payslip->tds = 0;
        $payslip->other_deduc = 0;
        $payslip->total_deduc = 0;

        // Attendance based
        $payslip->working_days = $workingDays;
        $payslip->present_days = $presentDays;
        $payslip->leave_withoutpay = $leaveWithoutPay;
        $payslip->over_time = $overtimeHours;

        // Final Pay
        $payslip->total_net = round(
            ($monthlySalary - $absentDeduction + $overtimeAmount),
            2
        );
        $payslip->final_payable = $payslip->total_net;

        // Meta
        $payslip->bonus = 0;
        $payslip->penalty = 0;
        $payslip->payment_mode = 'other';
        $payslip->payment_date = now()->format('Y-m-d');
        $payslip->approved_by = auth()->user()->name;
        $payslip->month_of_salary = $startDate->format('Y-m-01');
        $payslip->note = 'Auto approved';

        $payslip->save();

        // ================= NOTIFICATION RECIPIENTS =================
        $systemRecipients = getNotificationRecipients(
            type: 'salary_ready',
            channel: 'system'
        );

        $mailRecipients = getNotificationRecipients(
            type: 'salary_ready',
            channel: 'mail'
        )->filter(fn($recipient) => !empty($recipient->email));

        // Also send to employee
        if ($user) {
            $systemRecipients = collect($systemRecipients)->push($user)->unique('id');

            if (!empty($user->email)) {
                $mailRecipients = collect($mailRecipients)->push($user)->unique('id');
            }
        }

        // ================= MESSAGE DATA =================
        $salaryMonth = Carbon::parse($payslip->month_of_salary)->format('F Y');

        $systemTitle = 'Salary Processed';
        $systemMessage = 'Payslip for ' . $salaryMonth . ' has been generated for ' . $user->name . '. Final payable amount: ₹' . number_format($payslip->final_payable, 2) . '.';

        $mailSubject = 'Salary Payslip Generated - ' . $salaryMonth;

        // ================= SEND SYSTEM NOTIFICATION =================
        if ($systemRecipients->isNotEmpty()) {
            sendSystemNotification(
                users: $systemRecipients->all(),
                title: $systemTitle,
                message: $systemMessage,
                type: 'salary_ready',
                url: route('admin.payslip'), // change if needed
                extra: [
                    'payslip_id' => $payslip->id,
                    'user_id' => $user->id,
                    'month_of_salary' => $payslip->month_of_salary,
                    'final_payable' => $payslip->final_payable
                ]
            );
        }

        // ================= SEND MAIL =================
        foreach ($mailRecipients as $recipient) {
            $mailData = [
                'subject' => $mailSubject,
                'name' => $recipient->name,
                'message' => $recipient->id == $user->id
                    ? 'Dear ' . $user->name . ', your salary for ' . $salaryMonth . ' has been processed successfully. Your final payable amount is ₹' . number_format($payslip->final_payable, 2) . '. Please check your payslip for complete details.'
                    : 'This is to inform you that the salary for employee ' . $user->name . ' has been processed for ' . $salaryMonth . '. Final payable amount: ₹' . number_format($payslip->final_payable, 2) . '.',
                'employee_name' => $user->name,
                'salary_month' => $salaryMonth,
                'final_payable' => number_format($payslip->final_payable, 2),
                'present_days' => $payslip->present_days,
                'working_days' => $payslip->working_days,
                'leave_withoutpay' => $payslip->leave_withoutpay,
                'over_time' => $payslip->over_time,
            ];

            Mail::to($recipient->email)->queue(new \App\Mail\GenericMail($mailData));
        }

        return back()->with('success', 'Payslip auto-approved with attendance calculation');
    }


    public function update($id = "", Request $request)
    {
        $this->validate($request, [
            'brief_of_monthly_salary' => 'required',
            'net_salary' => 'required|numeric',
            'status' => 'required|numeric|min:0|max:1',
        ]);

        // Extract and format month of salary
        $brief_of_monthly_salary = explode(' - ', $request->brief_of_monthly_salary);
        $month_start = strtotime($brief_of_monthly_salary[0]);
        $month_of_salary = date('Y-m-d 00:00:00', $month_start);

        // Prepare the data for update
        $data = [
            // Salary details
            'net_salary'            => $request->net_salary,
            'hra'                   => $request->hra ?? 0,
            'conveyance_allowance'  => $request->conveyance_allowance ?? 0,
            'other_allowance'       => $request->other_allowance ?? 0,
            'gross_salary'          => $request->gross_salary ?? 0,

            // Deductions
            'pf'                    => $request->pf ?? 0,
            'esi'                   => $request->esi ?? 0,
            'tax'                   => $request->tax ?? 0,
            'tds'                   => $request->tds ?? 0,
            'other_deduc'           => $request->other_deduc ?? 0,
            'total_deduc'           => $request->total_deduc ?? 0,

            // Attendance-related
            'working_days'          => $request->working_days ?? 0,
            'present_days'          => $request->present_days ?? 0,
            'leave_withoutpay'      => $request->leave_withoutpay ?? 0,
            'over_time'             => $request->over_time ?? 0,

            // Bonus & penalties
            'bonus'                 => $request->bonus ?? 0,
            'penalty'               => $request->penalty ?? 0,
            'final_payable'         => $request->final_payable ?? 0,

            // Payment details
            'payment_mode'          => $request->payment_mode,
            'payment_date'          => $request->payment_date,
            'approved_by'           => $request->approved_by,
            'status'                => $request->status,

            // UAN / ESI details
            'uan_no'                => $request->uan_no,
            'esi_no'                => $request->esi_no,

            // Common fields
            'month_of_salary'       => $month_of_salary,
            'note'                  => $request->note,
            'total_net'             => $request->total_net ?? 0,
        ];

        // Auto-calculate derived values (safety check)
        $data['gross_salary'] =
            $data['net_salary'] +
            $data['hra'] +
            $data['conveyance_allowance'] +
            $data['other_allowance'];

        $data['total_deduc'] =
            $data['pf'] +
            $data['esi'] +
            $data['tax'] +
            $data['tds'] +
            $data['other_deduc'];

        $data['total_net'] = $data['gross_salary'] - $data['total_deduc'];

        $data['final_payable'] = ($data['total_net'] + $data['bonus']) - $data['penalty'];

        // Update record
        Payslip::where('id', $id)->update($data);

        return redirect()->back()->with('success_message', __('Payslip updated successfully'));
    }

    function delete(Request $request)
    {
        Payslip::where('id', $request->id)->delete();
        return redirect()->back()->with('success_message', get_phrase('Invoice deleted successfully'));
    }

    function payslip_download(Request $request)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html_content = view('admin.payslip.invoice_with_assessment', ['invoice_id' => $request->invoice_id, 'user_id' => $request->user_id])->render();
        $dompdf->loadHtml($html_content);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $payslip = Payslip::where('id', $request->invoice_id)->first();
        $dompdf->stream('Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.pdf');
    }

    function payslip_send_to_email(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $payslip = Payslip::where('id', $request->invoice_id)->first();
        $page_data['invoice_id'] = $request->invoice_id;
        $page_data['user_id'] = $request->user_id;

        $dompdf = new Dompdf();
        $html_content = view('admin.payslip.invoice', ['invoice_id' => $request->invoice_id, 'user_id' => $request->user_id])->render();
        $dompdf->loadHtml($html_content); // Load the HTML content
        $dompdf->render(); // Render the PDF

        try {
            Mail::send('admin.payslip.invoice_with_assessment', $page_data, function ($message) use ($payslip, $user, $dompdf) {
                $message->to($user->email, $user->name)
                    ->subject('Monthly Salary of ' . date('1 M - t M, Y', strtotime($payslip->month_of_salary)) . ' - BMS Electronic')
                    ->attachData($dompdf->output(), 'Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.pdf');
            });
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }


        Payslip::where('id', $payslip->id)->update(['email_sent' => 1]);

        return redirect()->back()->with('success_message', get_phrase('Invoice sent successfully'));
    }
}
