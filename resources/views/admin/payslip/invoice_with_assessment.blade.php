<div style="margin: 0 auto; max-width: 700px; background-color: #fff; color: #333; font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #333; padding: 25px;">
    @php
        $user = App\Models\User::where('id', $user_id)->first();
        $payslip = App\Models\Payslip::where('id', $invoice_id)->first();
        $gross_salary = ($payslip->net_salary ?? 0) + ($payslip->bonus ?? 0);
        $total_deductions = ($payslip->pf ?? 0) + ($payslip->esi ?? 0) + ($payslip->tax ?? 0) + ($payslip->tds ?? 0) + ($payslip->other_deduc ?? 0);
        $net_salary = $gross_salary - $total_deductions;
    @endphp

    <!-- Header -->
    <div style="display: flex; align-items: center; gap: 15px; border-bottom: 2px solid #444; padding-bottom: 10px;">
        <div style="background-color: #fff; padding: 10px; border-radius: 4px;">
            <img src="{{ asset('uploads/company-logo.png') }}" alt="Logo" style="width: 50px; height: 50px;">
        </div>
        <div>
            <h2 style="margin: 0; font-size: 18px;">{{ get_settings('system_name') ?? 'Company Name' }}</h2>
            <p style="margin: 0; color: #ccc;">{{ get_settings('system_address') ?? 'Company Address' }}</p>
            <p style="margin: 5px 0 0; color: #ccc;">Pay Slip for {{ date('F Y', strtotime($payslip->month_of_salary)) }}</p>
        </div>
    </div>

    <!-- Employee Info -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="width: 50%; padding: 4px;">Employee ID : <b>{{ $user->id }}</b></td>
            <td style="width: 50%; padding: 4px;">UAN : <b>{{ $user->uan_no ?? '-' }}</b></td>
        </tr>
        <tr>
            <td style="padding: 4px;">Employee Name : <b>{{ $user->name }}</b></td>
            <td style="padding: 4px;">PF No. : <b>{{ $payslip->pf_no ?? '-' }}</b></td>
        </tr>
        <tr>
            <td style="padding: 4px;">Designation : <b>{{ $user->designation }}</b></td>
            <td style="padding: 4px;">ESI No. : <b>{{ $payslip->esi_no ?? '-' }}</b></td>
        </tr>
        <tr>
            <td style="padding: 4px;">Department : <b>{{ $user->department ?? '-' }}</b></td>
            <td style="padding: 4px;">Bank : <b>{{ $user->bank_name ?? '-' }}</b></td>
        </tr>
        <tr>
            <td style="padding: 4px;">Date of Joining : <b>{{ $user->joining_date ? date('d M Y', strtotime($user->joining_date)) : '-' }}</b></td>
            <td style="padding: 4px;">Account No. : <b>{{ $user->account_no ?? '-' }}</b></td>
        </tr>
    </table>

    <!-- Salary Summary -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #444;">
        <tr>
            <td style="padding: 6px; border: 1px solid #444;">Gross Wages</td>
            <td style="padding: 6px; border: 1px solid #444;">INR{{ number_format($gross_salary, 2) }}</td>
            <td style="padding: 6px; border: 1px solid #444;">Total Working Days</td>
            <td style="padding: 6px; border: 1px solid #444;">{{ $payslip->working_days ?? 0 }}</td>
        </tr>
        <tr>
            <td style="padding: 6px; border: 1px solid #444;">LOP Days</td>
            <td style="padding: 6px; border: 1px solid #444;">{{ $payslip->leave_withoutpay ?? 0 }}</td>
            <td style="padding: 6px; border: 1px solid #444;">Paid Days</td>
            <td style="padding: 6px; border: 1px solid #444;">{{ $payslip->present_days ?? 0 }}</td>
        </tr>
    </table>

    <!-- Earnings & Deductions -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #fff; color: #333;">
                <th style="width: 50%; border: 1px solid #444; padding: 8px;">Earnings</th>
                <th style="width: 50%; border: 1px solid #444; padding: 8px;">Deductions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #444; padding: 6px;">Basic: INR{{ number_format($payslip->net_salary ?? 0, 2) }}</td>
                <td style="border: 1px solid #444; padding: 6px;">EPF: INR{{ number_format($payslip->pf ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #444; padding: 6px;">HRA: INR{{ number_format($payslip->hra ?? 0, 2) }}</td>
                <td style="border: 1px solid #444; padding: 6px;">ESI: INR{{ number_format($payslip->esi ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #444; padding: 6px;">Conveyance: INR{{ number_format($payslip->conveyance_allowance ?? 0, 2) }}</td>
                <td style="border: 1px solid #444; padding: 6px;">Professional Tax: INR{{ number_format($payslip->tax ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #444; padding: 6px;">Other Allowance: INR{{ number_format($payslip->other_allowance ?? 0, 2) }}</td>
                <td style="border: 1px solid #444; padding: 6px;">Other Deductions: INR{{ number_format($payslip->other_deduc ?? 0, 2) }}</td>
            </tr>
            <tr style="background-color: #fff;">
                <td style="border: 1px solid #444; padding: 6px;"><b>Total Earnings: INR{{ number_format($gross_salary, 2) }}</b></td>
                <td style="border: 1px solid #444; padding: 6px;"><b>Total Deductions: INR{{ number_format($total_deductions, 2) }}</b></td>
            </tr>
            <tr style="background-color: #fff; color: #333;">
                <td colspan="2" style="border: 1px solid #444; padding: 8px; text-align: center; font-weight: bold;">
                    Net Salary: INR{{ number_format($payslip->total_net, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
