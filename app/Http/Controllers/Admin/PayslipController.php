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

use App\Services\PayslipAttendance;

use App\Services\PayslipPayroll;
use Illuminate\Validation\ValidationException;

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

            'brief_of_monthly_salary' => 'required|string',

            'net_salary' => 'required|numeric',

            'bonus' => 'nullable|numeric',

            'penalty' => 'nullable|numeric|min:0',

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

            'leave_withoutpay' => 'nullable|numeric|min:0',

            'over_time' => 'nullable|numeric',

            'final_payable' => 'nullable|numeric',

            'payment_mode' => 'nullable|string',

            'payment_date' => 'nullable|date',

            'approved_by' => 'nullable|string',

            'note' => 'nullable|string'

        ]);

// Extract first date from date range

        [$salaryStart, $salaryEnd] = $this->parseSalaryRange($request->brief_of_monthly_salary);

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

        $data['month_of_salary'] = $salaryStart->copy()->startOfMonth()->format('Y-m-d 00:00:00');
        $data['period_start'] = $salaryStart->toDateString();
        $data['period_end'] = $salaryEnd->toDateString();

// The browser fields are previews. Payroll amounts and attendance are calculated on the server.

        $payUser = User::findOrFail($data['user_id']);
        $this->ensureNoOverlappingPayslip($payUser->id, $salaryStart, $salaryEnd);

        $attendance = app(PayslipAttendance::class)->summary(

            $payUser, $salaryStart, $salaryEnd

        );
        if ($attendance['workingDays'] === 0) {
            throw ValidationException::withMessages(['brief_of_monthly_salary' => 'This period has no working days for the employee.']);
        }

        $unpaidDays = max(0, (float) $attendance['leaveWithoutPayEquivalent']

            - ((int) $attendance['halfDays'] * 0.5));

        $data['working_days'] = $attendance['workingDays'];

        $data['present_days'] = $attendance['effectivePresentDays'];

        $data['punch_day_count'] = $attendance['presentDays'];

        $data['full_day_count'] = $attendance['fullDays'];

        $data['half_day_count'] = $attendance['halfDays'];

        $data['late_minutes'] = $attendance['lateMinutes'];

        $data['ot_minutes'] = $attendance['overtimeMinutes'];

        $data['ot_offset_minutes'] = $attendance['offsetMinutes'];

        $data['over_time'] = round($attendance['overtimeMinutes'] / 60, 2);

        $data['leave_withoutpay'] = $attendance['leaveWithoutPayEquivalent'];

        $data['gross_salary'] = round((float) $data['net_salary'] + (float) $data['hra']

            + (float) $data['conveyance_allowance'] + (float) $data['other_allowance'], 2);

        $otherDeductions = (float) $data['pf'] + (float) $data['esi'] + (float) $data['tax']

            + (float) $data['tds'] + (float) $data['other_deduc'];

        $payroll = app(PayslipPayroll::class)->calculateForRange(
            $data['gross_salary'], $attendance['workingDates'], $attendance['leaveWithoutPayDates'],
            $attendance['halfDayDates'],
            app(PayslipAttendance::class)->monthlyWorkingDayCounts($payUser, $salaryStart, $salaryEnd),
            $attendance['uncoveredLateMinutes'], $otherDeductions,
            (float) $data['bonus'], (float) $data['penalty']
        );
        $data['gross_salary'] = $payroll['period_gross'];
        unset($payroll['period_gross']);

        $data = array_merge($data, $payroll);

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

        $period = $request->validate([

            'user_id' => 'required|integer|exists:users,id',

            'year' => 'nullable|integer|between:2020,2100',

            'month' => 'nullable|integer|between:1,12',

        ]);

        $startDate = Carbon::createFromDate(

            (int) ($period['year'] ?? now('Asia/Kolkata')->year),

            (int) ($period['month'] ?? now('Asia/Kolkata')->month), 1, 'Asia/Kolkata'

        )->startOfMonth();

// Attendance comes from SDK-synced CRM tables, not the old external API.

        $attendance = app(PayslipAttendance::class)->summary($user, $startDate);

        $workingDays = $attendance['workingDays'];

        $presentDays = $attendance['effectivePresentDays'];

        $overtimeHours = $attendance['overtimeHours']; // display only; never paid

        $leaveWithoutPay = max(0, (float) $attendance['leaveWithoutPayEquivalent']

            - ((int) $attendance['halfDays'] * 0.5));

// A current/future month's missing punches must not silently become a salary deduction.

        if (!$attendance['isCompleteMonth']) {

            return back()->with('error_message', 'Auto approval is available after the salary month ends. Review attendance first.');

        }

        if ($attendance['presentDays'] === 0 || $attendance['invalidPunchDays'] > 0) {

            return back()->with('error_message', 'Missing punches or invalid punch times. Review attendance and prepare the payslip manually.');

        }

        if (Payslip::where('user_id', $user->id)

            ->where('period_start', '<=', $startDate->copy()->endOfMonth()->toDateString())
            ->where('period_end', '>=', $startDate->toDateString())->exists()) {

            return back()->with('error_message', 'Payslip for this employee and month already exists.');

        }

        $monthlySalary = $user->salary ?? 0;

        $payslip = new Payslip();

        $payslip->user_id = $user->id;

        $payslip->status = 1;

// Earnings

        $payslip->net_salary = $monthlySalary;

        $payslip->gross_salary = $monthlySalary;

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

        $payslip->punch_day_count = $attendance['presentDays'];

        $payslip->full_day_count = $attendance['fullDays'];

        $payslip->half_day_count = $attendance['halfDays'];

        $payslip->late_minutes = $attendance['lateMinutes'];

        $payslip->ot_minutes = $attendance['overtimeMinutes'];

        $payslip->ot_offset_minutes = $attendance['offsetMinutes'];

        $payslip->leave_withoutpay = $attendance['leaveWithoutPayEquivalent'];

        $payslip->over_time = $overtimeHours;

// Final Pay

        $payroll = app(PayslipPayroll::class)->calculate(

            (float) $monthlySalary, $workingDays, $leaveWithoutPay,

            $attendance['halfDays'], $attendance['uncoveredLateMinutes']

        );

        $payslip->absence_deduction = $payroll['absence_deduction'];

        $payslip->half_day_deduction = $payroll['half_day_deduction'];

        $payslip->late_deduction = $payroll['late_deduction'];

        $payslip->total_deduc = $payroll['total_deduc'];

        $payslip->total_net = $payroll['total_net'];

        $payslip->final_payable = $payroll['final_payable'];

// Meta

        $payslip->bonus = 0;

        $payslip->penalty = 0;

        $payslip->payment_mode = 'other';

        $payslip->payment_date = now()->format('Y-m-d');

        $payslip->approved_by = auth()->user()->name;

        $payslip->month_of_salary = $startDate->format('Y-m-01');
        $payslip->period_start = $startDate->toDateString();
        $payslip->period_end = $startDate->copy()->endOfMonth()->toDateString();

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

            'leave_withoutpay' => 'nullable|numeric|min:0',

            'bonus' => 'nullable|numeric|min:0',

            'penalty' => 'nullable|numeric|min:0',

        ]);

// Extract and format month of salary

        [$salaryStart, $salaryEnd] = $this->parseSalaryRange($request->brief_of_monthly_salary);
        $month_of_salary = $salaryStart->copy()->startOfMonth()->format('Y-m-d 00:00:00');

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
            'period_start'          => $salaryStart->toDateString(),
            'period_end'            => $salaryEnd->toDateString(),

            'note'                  => $request->note,

            'total_net'             => $request->total_net ?? 0,

        ];

// Auto-calculate derived values (safety check)

        $data['gross_salary'] =

            $data['net_salary'] +

            $data['hra'] +

            $data['conveyance_allowance'] +

            $data['other_allowance'];

        $existing = Payslip::findOrFail($id);

        $employee = User::findOrFail($existing->user_id);
        $this->ensureNoOverlappingPayslip($employee->id, $salaryStart, $salaryEnd, (int) $existing->id);

        $attendance = app(PayslipAttendance::class)->summary(

            $employee, $salaryStart, $salaryEnd

        );
        if ($attendance['workingDays'] === 0) {
            throw ValidationException::withMessages(['brief_of_monthly_salary' => 'This period has no working days for the employee.']);
        }

        $data['working_days'] = $attendance['workingDays'];

        $data['present_days'] = $attendance['effectivePresentDays'];

        $data['punch_day_count'] = $attendance['presentDays'];

        $data['full_day_count'] = $attendance['fullDays'];

        $data['half_day_count'] = $attendance['halfDays'];

        $data['late_minutes'] = $attendance['lateMinutes'];

        $data['ot_minutes'] = $attendance['overtimeMinutes'];

        $data['ot_offset_minutes'] = $attendance['offsetMinutes'];

        $data['over_time'] = $attendance['overtimeHours'];

        $data['leave_withoutpay'] = $attendance['leaveWithoutPayEquivalent'];

        $otherDeductions = (float) $data['pf'] + (float) $data['esi'] + (float) $data['tax']

            + (float) $data['tds'] + (float) $data['other_deduc'];

        $payroll = app(PayslipPayroll::class)->calculateForRange(
            (float) $data['gross_salary'], $attendance['workingDates'],
            $attendance['leaveWithoutPayDates'], $attendance['halfDayDates'],
            app(PayslipAttendance::class)->monthlyWorkingDayCounts($employee, $salaryStart, $salaryEnd),
            $attendance['uncoveredLateMinutes'], $otherDeductions,
            (float) $data['bonus'], (float) $data['penalty']
        );
        $data['gross_salary'] = $payroll['period_gross'];
        unset($payroll['period_gross']);

        $data = array_merge($data, $payroll);

// Update record

Payslip::where('id', $id)->update($data);

        return redirect()->back()->with('success_message', __('Payslip updated successfully'));

    }

    private function parseSalaryRange(string $range): array
    {
        if (!preg_match('~^\s*(\d{2}/\d{2}/\d{2,4})\s+-\s+(\d{2}/\d{2}/\d{2,4})\s*$~', $range, $matches)) {
            throw ValidationException::withMessages(['brief_of_monthly_salary' => 'Select a start and end date (MM/DD/YYYY).']);
        }
        $dates = [];
        foreach ([$matches[1], $matches[2]] as $value) {
            $format = strlen(substr(strrchr($value, '/'), 1)) === 2 ? 'm/d/y' : 'm/d/Y';
            try {
                $date = Carbon::createFromFormat('!'.$format, $value, 'Asia/Kolkata');
            } catch (\Throwable $e) {
                $date = null;
            }
            if (!$date || $date->format($format) !== $value) {
                throw ValidationException::withMessages(['brief_of_monthly_salary' => 'Select valid salary dates.']);
            }
            $dates[] = $date->startOfDay();
        }
        if ($dates[1]->lt($dates[0]) || $dates[1]->gt(Carbon::now('Asia/Kolkata')->startOfDay())
            || $dates[1]->gt($dates[0]->copy()->addYear())) {
            throw ValidationException::withMessages(['brief_of_monthly_salary' => 'Choose a past or current period of at most one year.']);
        }
        return $dates;
    }

    private function ensureNoOverlappingPayslip(int $userId, Carbon $start, Carbon $end, ?int $exceptId = null): void
    {
        $query = Payslip::where('user_id', $userId)
            ->where('period_start', '<=', $end->toDateString())
            ->where('period_end', '>=', $start->toDateString());
        if ($exceptId !== null) $query->where('id', '!=', $exceptId);
        if ($query->exists()) {
            throw ValidationException::withMessages(['brief_of_monthly_salary' => 'Another payslip already covers these dates.']);
        }
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
