@php
    $payslip = \App\Models\Payslip::findOrFail($invoice_id);
    $user = \App\Models\User::findOrFail($payslip->user_id);
    $payer = \App\Models\User::where('role', 'admin')->first();
@endphp
<div style="margin:0 auto;border:1px solid #cdcdcd;max-width:700px;padding:35px 30px;font-family:Arial,sans-serif;">
    <table style="width:100%;max-width:600px;margin:auto;">
        <tr><td style="text-align:center"><img src="{{ url('public/assets/images/favicon.png') }}" alt="" style="width:37px"></td></tr>
        <tr><td style="text-align:center"><h3>{{ get_phrase('Payslip') }}</h3></td></tr>
    </table>
    <table style="width:100%;max-width:600px;margin:auto;">
        <tr><td style="width:50%;text-align:right">{{ get_phrase('Name') }}</td><td>:</td><td style="width:50%">{{ $user->name }}</td></tr>
        <tr><td style="text-align:right">{{ get_phrase('Designation') }}</td><td>:</td><td>{{ $user->designation }}</td></tr>
        <tr><td style="text-align:right">{{ get_phrase('Paycode') }}</td><td>:</td><td>{{ $user->paycode }}</td></tr>
    </table>
    <h3 style="text-align:center">{{ get_phrase('Brief of monthly salary') }} ({{ date('1 M - t M, Y', strtotime($payslip->month_of_salary)) }})</h3>
    <table style="width:100%;max-width:600px;margin:auto;border-collapse:collapse">
        <tr><th style="text-align:left;border:1px solid;padding:6px">{{ get_phrase('Subject') }}</th><th style="text-align:left;border:1px solid;padding:6px">{{ get_phrase('Value') }}</th></tr>
        <tr><td style="border:1px solid;padding:6px">Working days (Sunday / holidays / pre-join excluded)</td><td style="border:1px solid;padding:6px">{{ $payslip->working_days ?? 0 }}</td></tr>
        <tr><td style="border:1px solid;padding:6px">Punch days</td><td style="border:1px solid;padding:6px">{{ $payslip->punch_day_count ?? $payslip->present_days ?? 0 }}</td></tr>
        <tr><td style="border:1px solid;padding:6px">Full / half days</td><td style="border:1px solid;padding:6px">{{ $payslip->full_day_count ?? '—' }} / {{ $payslip->half_day_count ?? '—' }}</td></tr>
        <tr><td style="border:1px solid;padding:6px">Paid present days (half = 0.5)</td><td style="border:1px solid;padding:6px">{{ $payslip->present_days ?? 0 }}</td></tr>
        <tr><td style="border:1px solid;padding:6px">Leave without pay</td><td style="border:1px solid;padding:6px">{{ $payslip->leave_withoutpay ?? 0 }}</td></tr>
        <tr><td style="border:1px solid;padding:6px">Late / OT / offset / uncovered (minutes)</td><td style="border:1px solid;padding:6px">{{ $payslip->late_minutes ?? '—' }} / {{ $payslip->ot_minutes ?? '—' }} / {{ $payslip->ot_offset_minutes ?? '—' }} / {{ $payslip->late_minutes === null ? '—' : max(0, $payslip->late_minutes - $payslip->ot_offset_minutes) }}</td></tr>
        <tr><td style="border:1px solid;padding:6px">OT cash payment</td><td style="border:1px solid;padding:6px">₹0.00 (offsets late minutes only)</td></tr>
        <tr><td style="border:1px solid;padding:6px">{{ get_phrase('Basic Salary') }}</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->net_salary, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">Gross salary (including allowances)</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->gross_salary, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">Absent day deduction</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->absence_deduction, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">Half day deduction</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->half_day_deduction, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">Uncovered late deduction (₹1/min)</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->late_deduction, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">Other deductions (PF, ESI, tax, TDS, other)</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->pf + (float) $payslip->esi + (float) $payslip->tax + (float) $payslip->tds + (float) $payslip->other_deduc, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">{{ get_phrase('Bonus') }}</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->bonus, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px">{{ get_phrase('Penalty deductions') }}</td><td style="border:1px solid;padding:6px">{{ number_format((float) $payslip->penalty, 2) }} /=</td></tr>
        <tr><td style="border:1px solid;padding:6px"><b>{{ get_phrase('Net salary payable') }}</b></td><td style="border:1px solid;padding:6px"><b>{{ number_format((float) $payslip->final_payable, 2) }} /=</b></td></tr>
    </table>
    <table style="width:100%;max-width:600px;margin:30px auto 0"><tr>
        <td style="width:50%;text-align:left"><h3><u>{{ get_phrase('Paid By') }}</u></h3><strong>{{ $payer?->name ?? 'Admin' }}</strong><p>{{ get_settings('system_name') }}</p></td>
        <td style="width:50%;text-align:right"><h3><u>{{ get_phrase('Paid To') }}</u></h3><strong>{{ $user->name }}</strong><p>{{ get_settings('system_name') }}</p></td>
    </tr></table>
</div>
