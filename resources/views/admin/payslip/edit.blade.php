<div class="eSection-wrap">
    <div class="row">
        <div class="col-md-12">

            @php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Http;
    use App\Models\Branch;
    use App\Models\User;
    use App\Models\Payslip;

    $payslip = Payslip::findOrFail($_GET['id']);
    $pay_to  = User::findOrFail($payslip->user_id);

    // Salary month
    $monthTs = strtotime($payslip->month_of_salary);
    $startOfMonth = Carbon::createFromTimestamp($monthTs)->startOfMonth();
    $endOfMonth   = Carbon::createFromTimestamp($monthTs)->endOfMonth();

    // Branch + machine
    $branch = Branch::find($pay_to->branch_id);

    // ----------------------------
    // FETCH ATTENDANCE FROM API
    // ----------------------------
    $response = Http::post('http://ta.biumetrics.com/api/transaction/GetRowData', [
        'TXN_NAME' => 'GetRowData',
        'DATA' => json_encode([
            'Company_Code'    => '17',
            'ReportDate_From' => $startOfMonth->format('Y/m/d'),
            'ReportDate_To'   => $endOfMonth->format('Y/m/d'),
            'MachineSerialNo' => $branch->machine_series,
        ])
    ]);

    $rows = collect($response->json()['data'] ?? []);

    // Only this user (PAYCODE)
    $userRows = $rows->where('PAYCODE', $pay_to->paycode);

    // ----------------------------
    // GROUP BY ACTUAL PUNCH DATE
    // ----------------------------
    $grouped = $userRows->groupBy(function ($row) {
        return substr($row['OFFICEPUNCH'], 0, 10);
    });

    $presentDays = 0;
    $overtimeHours = 0;

    foreach ($grouped as $punches) {

        $punches = $punches->sortBy('OFFICEPUNCH')->values();

        // Present if punch-in exists
        if ($punches->count() >= 1) {
            $presentDays++;

            // Overtime if punch-out exists
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

    // ----------------------------
    // WORKING DAYS (MON–SAT)
    // ----------------------------
    $workingDays = 0;
    for ($d = $startOfMonth->copy(); $d->lte($endOfMonth); $d->addDay()) {
        if ($d->dayOfWeekIso !== 7) {
            $workingDays++;
        }
    }

    $leaveWithoutPay = max($workingDays - $presentDays, 0);

    // ----------------------------
    // SALARY CALCULATION (PREVIEW)
    // ----------------------------
    $monthlySalary = $payslip->net_salary;

    if ($workingDays > 0) {
        $perDaySalary  = $monthlySalary / $workingDays;
        $perHourSalary = $perDaySalary / 8;

        $absentDeduction = $leaveWithoutPay * $perDaySalary;
        $overtimeAmount  = $overtimeHours * $perHourSalary;
    } else {
        $absentDeduction = 0;
        $overtimeAmount  = 0;
    }

    $calculatedFinalPay = round(
        ($monthlySalary - $absentDeduction + $overtimeAmount),
        2
    );
@endphp

            <form action="{{ route('admin.payslip.update', $payslip->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center mt-3">
                            <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $pay_to->photo) }}"
                                width="40px">
                            <div class="text-start ps-3">
                                <p class="text-dark text-13px">{{ $pay_to->name }}</p>
                                <small class="badge bg-secondary text-10px">{{ $pay_to->designation }}</small>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <input type="hidden" name="user_id" value="{{ $pay_to->id }}">

                    <!-- UAN & ESI -->
                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('UAN Number') }}</label>
                            <input type="text" name="uan_no" class="form-control eForm-control"
                                value="{{ $payslip->uan_no }}" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('ESI Number') }}</label>
                            <input type="text" name="esi_no" class="form-control eForm-control"
                                value="{{ $payslip->esi_no }}" required>
                        </div>
                    </div>

                    <!-- Salary Fields -->
                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Basic Salary') }} ({{ currency() }})</label>
                            <input type="number" name="net_salary" value="{{ $payslip->net_salary }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('HRA') }}</label>
                            <input type="number" name="hra" value="{{ $payslip->hra }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Conveyance Allowance') }}</label>
                            <input type="number" name="conveyance_allowance"
                                value="{{ $payslip->conveyance_allowance }}" class="form-control eForm-control"
                                step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Other Allowance') }}</label>
                            <input type="number" name="other_allowance" value="{{ $payslip->other_allowance }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Gross Salary') }}</label>
                            <input type="number" name="gross_salary" value="{{ $payslip->gross_salary }}"
                                class="form-control eForm-control" readonly>
                        </div>
                    </div>

                    <!-- Deductions -->
                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('PF') }}</label>
                            <input type="number" name="pf" value="{{ $payslip->pf }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('ESI') }}</label>
                            <input type="number" name="esi" value="{{ $payslip->esi }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Tax') }}</label>
                            <input type="number" name="tax" value="{{ $payslip->tax }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('TDS') }}</label>
                            <input type="number" name="tds" value="{{ $payslip->tds }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Other Deductions') }}</label>
                            <input type="number" name="other_deduc" value="{{ $payslip->other_deduc }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Total Deductions') }}</label>
                            <input type="number" name="total_deduc" value="{{ $payslip->total_deduc }}"
                                class="form-control eForm-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Total Net') }}</label>
                            <input type="number" name="total_net" value="{{ $payslip->total_net }}"
                                class="form-control eForm-control" readonly>
                        </div>
                    </div>

                    <!-- Monthly Salary Range -->
                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Brief of monthly salary') }}</label>
                            <input type="text" name="brief_of_monthly_salary"
                                value="{{ date('m/d/y', strtotime($payslip->month_of_salary)) }} - {{ date('m/t/y', strtotime($payslip->month_of_salary)) }}"
                                class="eForm-control date-range-picker">
                        </div>
                    </div>

                    <!-- Attendance -->
                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Working Days') }}</label>
                            <input type="number" name="working_days" value="{{ $workingDays }}"
                                class="form-control eForm-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Present Days') }}</label>
                            <input type="number" name="present_days"
                                value="{{ old('present_days', $payslip->present_days ?? $presentDays) }}"
                                class="form-control eForm-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Leave Without Pay') }}</label>
                            <input type="number" name="leave_withoutpay"
                                value="{{ old('leave_withoutpay', $payslip->leave_withoutpay ?? $leaveWithoutPay) }}"
                                class="form-control eForm-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Over Time (hrs)') }}</label>
                            <input type="number" name="over_time"
                                value="{{ old('over_time', $payslip->over_time ?? $overtimeHours) }}"
                                class="form-control eForm-control" step="0.01">
                        </div>
                    </div>

                    <!-- Bonus, Penalty, Final -->
                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Bonus') }}</label>
                            <input type="number" name="bonus" value="{{ $payslip->bonus }}"
                                class="form-control eForm-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Penalty') }}</label>
                            <input type="number" name="penalty" value="{{ $payslip->penalty }}"
                                class="form-control eForm-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Final Payable') }}</label>
                            <input type="number" name="final_payable"
       value="{{ $payslip->final_payable ?? $calculatedFinalPay }}"
       class="form-control eForm-control" readonly>

                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Payment Mode') }}</label>
                            <select name="payment_mode" class="form-select eForm-select">
                                <option value="">{{ get_phrase('Select payment mode') }}</option>
                                <option value="cash" @selected($payslip->payment_mode == 'cash')>{{ get_phrase('Cash') }}</option>
                                <option value="bank" @selected($payslip->payment_mode == 'bank')>{{ get_phrase('Bank Transfer') }}
                                </option>
                                <option value="cheque" @selected($payslip->payment_mode == 'cheque')>{{ get_phrase('Cheque') }}
                                </option>
                                <option value="other" @selected($payslip->payment_mode == 'other')>{{ get_phrase('Other') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Payment Date') }}</label>
                            <input type="date" name="payment_date" value="{{ $payslip->payment_date }}"
                                class="form-control eForm-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Approved By') }}</label>
                            <input type="text" name="approved_by" value="{{ $payslip->approved_by }}"
                                class="form-control eForm-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Payment Status') }}</label>
                            <select name="status" class="form-select eForm-select select2" required>
                                <option value="">{{ get_phrase('Select a invoice type') }}</option>
                                <option value="1" @if ($payslip->status == '1') selected @endif>
                                    {{ get_phrase('Paid') }}</option>
                                <option value="0" @if ($payslip->status == '0') selected @endif>
                                    {{ get_phrase('Unpaid') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="col-md-12">
                        <div class="fpb-7">
                            <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Note') }} <small
                                    class="text-muted">({{ get_phrase('Optional') }})</small></label>
                            <textarea name="note" class="form-control" rows="2">{{ $payslip->note }}</textarea>
                        </div>
                        <button type="submit"
                            class="btn-form mt-2 mb-3 w-100">{{ get_phrase('Save Changes') }}</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

@include('payslipjs')
