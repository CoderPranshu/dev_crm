<div class="eSection-wrap">

    <div class="row">

        <div class="col-md-12">

            <form action="{{ route('admin.payslip.store') }}" method="post" id="payslip-payroll-form">

@Csrf

                @php

                    $pay_to = \App\Models\User::where('id', $_GET['user_id'])->first();

                @endphp

                <input type="hidden" value="{{ $_GET['user_id'] }}" name="user_id">

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

                    <div class="col-md-12">

                        <div class="fbp-7">

                            <label class="eForm-label">{{ get_phrase('UAN Number') }}</label>

                            <input type="text" name="uan_no" class="form-control eForm-control">

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('ESI Number') }}</label>

                            <input type="text" name="esi_no" class="form-control eForm-control">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label for="net_salary" class="eForm-label">{{ get_phrase('Basic Salary') }}

                                ({{ currency() }})</label>

                            <input type="number" name="net_salary" value="{{ $pay_to->salary }}"

                                class="form-control eForm-control" id="net_salary" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('HRA') }}</label>

                            <input type="number" name="hra" class="form-control eForm-control" id="hra"

                                step="0.01">

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Conveyance Allowance') }}

                                ({{ currency() }})</label>

                            <input type="number" name="conveyance_allowance" class="form-control eForm-control"

                                id="conveyance_allowance" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Other Allowance') }}

                                ({{ currency() }})</label>

                            <input type="number" name="other_allowance" class="form-control eForm-control"

                                id="other_allowance" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Gross Salary') }} ({{ currency() }})</label>

                            <input type="number" name="gross_salary" class="form-control eForm-control"

                                id="gross_salary" placeholder="Auto Cal" step="0.01" readonly />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('PF') }} ({{ currency() }})</label>

                            <input type="number" id="pf" name="pf"

                                class="form-control eForm-control deduction-input" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('ESI') }} ({{ currency() }})</label>

                            <input type="number" id="esi" name="esi"

                                class="form-control eForm-control deduction-input" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Tax') }} ({{ currency() }})</label>

                            <input type="number" id="tax" name="tax"

                                class="form-control eForm-control deduction-input" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('TDS') }} ({{ currency() }})</label>

                            <input type="number" id="tds" name="tds"

                                class="form-control eForm-control deduction-input" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Other Deductions') }}

                                ({{ currency() }})</label>

                            <input type="number" id="other_deduc" name="other_deduc"

                                class="form-control eForm-control deduction-input" step="0.01" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Total Deductions') }}

                                ({{ currency() }})</label>

                            <input type="number" id="total_deduc" name="total_deduc"

                                class="form-control eForm-control" placeholder="Auto Ded" step="0.01" readonly />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Total Net') }} ({{ currency() }})</label>

                            <input type="number" id="total_net" name="total_net" class="form-control eForm-control"

                                placeholder="Auto calc from Basic - Deductions" step="0.01" readonly />

                        </div>

                    </div>

                    @php

                        use Carbon\Carbon;

                        use App\Models\Leave_application;

                        use App\Models\LeaveType;

                        $user = \App\Models\User::findOrFail(request('user_id'));

                        $year = (int) request()->get('year', date('Y'));

                        $month = (int) request()->get('month', date('n'));

                        $startDate = Carbon::createFromDate($year, $month, 1, 'Asia/Kolkata')->startOfMonth();

                        $endDate = $startDate->copy()->endOfMonth();
                        $selectedStart = request('period_start');
                        $selectedEnd = request('period_end');
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $selectedStart)
                            && preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $selectedEnd)) {
                            try {
                                $candidateStart = Carbon::createFromFormat('!Y-m-d', $selectedStart, 'Asia/Kolkata');
                                $candidateEnd = Carbon::createFromFormat('!Y-m-d', $selectedEnd, 'Asia/Kolkata');
                            } catch (\Throwable $e) {
                                $candidateStart = $candidateEnd = null;
                            }
                            if ($candidateStart && $candidateEnd
                                && $candidateStart->toDateString() === $selectedStart
                                && $candidateEnd->toDateString() === $selectedEnd
                                && $candidateEnd->gte($candidateStart)
                                && $candidateEnd->lte($candidateStart->copy()->addYear())
                                && $candidateEnd->lte(Carbon::today('Asia/Kolkata'))) {
                                $startDate = $candidateStart;
                                $endDate = $candidateEnd;
                            }
                        } elseif ($endDate->gt(Carbon::today('Asia/Kolkata'))) {
                            $endDate = Carbon::today('Asia/Kolkata');
                        }


                        $startTs = $startDate->timestamp;

                        $endTs = $endDate->timestamp;

                        $attendance = app(\App\Services\PayslipAttendance::class)->summary($user, $startDate, $endDate);
                        $monthlyWorkingDays = app(\App\Services\PayslipAttendance::class)
                            ->monthlyWorkingDayCounts($user, $startDate, $endDate);

                        $workingDates = $attendance['workingDates'];

                        $workingDays = $attendance['workingDays'];

                        $presentDates = $attendance['presentDates'];

                        $actualPresent = $attendance['presentDays'];

                        $overtimeHours = $attendance['overtimeHours'];

                        $fullDays = $attendance['fullDays'];

                        $halfDays = $attendance['halfDays'];

                        $effectivePresentDays = $attendance['effectivePresentDays'];

                        $lateMinutes = $attendance['lateMinutes'];

                        $otMinutes = $attendance['overtimeMinutes'];

                        $offsetMinutes = $attendance['offsetMinutes'];

                        $uncoveredLateMinutes = $attendance['uncoveredLateMinutes'];

                        $approvedLeaves = Leave_application::with('leavetype')

                            ->where('user_id', $user->id)

                            ->where('status', 'approved')

                            ->where(function ($q) use ($startTs, $endTs) {

// ANY overlap with month

                                $q->where('from_date', '<=', $endTs)->where('to_date', '>=', $startTs);

                            })

                            ->get();

// ----------------------------------------

// LEAVE CALC (DATE-WISE + DAYS CAP)

// ----------------------------------------

                        $leaveUsage = []; // used per leave type

                        $paidLeaveDates = collect(); // unique dates

                        $unpaidLeaveDates = collect();

                        foreach ($approvedLeaves as $leave) {

                            $type = $leave->leavetype;

                            if (!$type) {

                                continue;

                            }

                            $typeId = $type->id;

                            $allowed = $type->days;

                            if (!isset($leaveUsage[$typeId])) {

                                $leaveUsage[$typeId] = 0;

                            }

                            $start = Carbon::createFromTimestamp($leave->from_date)->startOfDay();

                            $end = Carbon::createFromTimestamp($leave->to_date)->endOfDay();

                            $countedDays = 0; // cap by leave->days

                            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {

                                $ds = $d->format('Y-m-d');

// only working days

                                if (!$workingDates->contains($ds)) {

                                    continue;

                                }

// skip if already present

                                if ($presentDates->contains($ds)) {

                                    continue;

                                }

// respect the applied days limit

                                if ($countedDays >= (int) $leave->days) {

                                    break;

                                }

                                $remaining = $allowed - $leaveUsage[$typeId];

                                if ($remaining > 0) {

                                    $paidLeaveDates->push($ds);

                                    $leaveUsage[$typeId]++;

                                } else {

                                    $unpaidLeaveDates->push($ds);

                                }

                                $countedDays++;

                            }

                        }

// ----------------------------------------

// FINAL COUNTS

// ----------------------------------------

                        $paidLeaveDays = $paidLeaveDates->unique()->count();

                        $unpaidLeaveDays = $unpaidLeaveDates->unique()->count();

                        $presentDays = $effectivePresentDays; // full days + half days / 2; paid leave is separate

                        $absentDays = $attendance['leaveWithoutPay'];

                        $unpaidEquivalentDays = $attendance['leaveWithoutPayEquivalent'];

// ----------------------------------------

// LEAVE SUMMARY (MONTH)

// ----------------------------------------

                        $totalLeaveTaken = $attendance['approvedLeaveDays'];

                        $totalLeaveAvailable = 0;

                        $leaveTypes = LeaveType::all();

                        foreach ($leaveTypes as $type) {

                            $typeId = $type->id;

                            $allowed = $type->days;

                            $used = $leaveUsage[$typeId] ?? 0;

                            $totalLeaveAvailable += max($allowed - $used, 0);

                        }

                    @endphp

                    <div class="col-md-6">

                        <label class="eForm-label">Leave Taken (Selected Period)</label>

                        <input type="number" value="{{ $totalLeaveTaken }}" class="form-control eForm-control"

                            readonly>

                    </div>

                    <div class="col-md-6">

                        <label class="eForm-label">Leave Available</label>

                        <input type="number" value="{{ $totalLeaveAvailable }}" class="form-control eForm-control"

                            readonly>

                    </div>

                    <div class="col-md-12">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Salary Period (Start - End)') }}</label>

                            <input type="text" name="brief_of_monthly_salary"

                                value="{{ $startDate->format('m/d/Y') }} - {{ $endDate->format('m/d/Y') }}"

                                class="eForm-control date-range-picker" data-loaded-range="{{ $startDate->format('m/d/Y') }} - {{ $endDate->format('m/d/Y') }}" required>
                            @error('brief_of_monthly_salary')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Working Days') }}</label>

                            <input type="number" name="working_days" value="{{ $workingDays }}"

                                class="form-control eForm-control" step="1" readonly />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">Paid present days (full + half × 0.5)</label>

                            <input type="number" name="present_days" id="present_days" value="{{ old('present_days', $presentDays) }}"

                                class="form-control eForm-control" step="0.5" readonly />

                        </div>

                    </div>

                    <div class="col-md-12"><div class="alert alert-info">

                        Punch days: {{ $actualPresent }} · Full days: {{ $fullDays }} · Half days: {{ $halfDays }}

                        · Paid present: {{ number_format($effectivePresentDays, 1) }}.

                        @if($attendance['singlePunchDays'] > 0) {{ $attendance['singlePunchDays'] }} single-punch day(s) counted as paid full days. @endif

                        @if($attendance['invalidPunchDays'] > 0) {{ $attendance['invalidPunchDays'] }} invalid punch day(s) need correction. @endif

                    </div></div>

                    <div class="col-md-12"><div class="alert alert-secondary">

                        Late: {{ intdiv($lateMinutes, 60) }}h {{ $lateMinutes % 60 }}m · OT: {{ intdiv($otMinutes, 60) }}h {{ $otMinutes % 60 }}m

                        · OT used against late: {{ intdiv($offsetMinutes, 60) }}h {{ $offsetMinutes % 60 }}m

                        · Uncovered late: {{ $uncoveredLateMinutes }} min = ₹{{ $uncoveredLateMinutes }} deduction.

                        Extra OT has no cash payment.

                    </div></div>

                    <div class="col-md-12"><div class="alert alert-light border" data-half-days="{{ $halfDays }}" data-late-balance="{{ $uncoveredLateMinutes }}"
                        data-working-dates='@json($workingDates->values())'
                        data-unpaid-dates='@json($attendance['leaveWithoutPayDates']->values())'
                        data-half-dates='@json($attendance['halfDayDates']->values())'
                        data-monthly-counts='@json($monthlyWorkingDays)'
                        id="payroll-breakdown">

                        <strong>Salary calculation</strong><br>

                        Absent: <span data-value="absence">—</span> · Half days: <span data-value="half">—</span>

                        · Late after OT: <span data-value="late">—</span> · OT payout: ₹0.00<br>

                        <strong>Final payable: <span data-value="final">—</span></strong>

                    </div></div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Leave Without Pay') }}</label>

                            <input type="number" id="leave_withoutpay_display" value="{{ $unpaidEquivalentDays }}"

                                class="form-control eForm-control" step="0.5" readonly />

                            <input type="hidden" name="leave_withoutpay" id="leave_withoutpay"

                                value="{{ max(0, $unpaidEquivalentDays - ($halfDays * 0.5)) }}" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">OT hours (late offset only, no payout)</label>

                            <input type="number" name="over_time" id="over_time" value="{{ old('over_time', $overtimeHours) }}"

                                class="form-control eForm-control" step="0.01" readonly />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label for="bonus" class="eForm-label">{{ get_phrase('Bonus') }}

                                ({{ currency() }})</label>

                            <input type="number" name="bonus" value="0" class="form-control eForm-control"

                                id="bonus" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label for="penalty" class="eForm-label">{{ get_phrase('Penalty') }}

                                ({{ currency() }})</label>

                            <input type="number" name="penalty" value="0" class="form-control eForm-control"

                                id="penalty" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Final Payable') }}

                                ({{ currency() }})</label>

                            <input type="number" id="final_payable" name="final_payable"

                                class="form-control eForm-control" placeholder="Final Auto cal" step="0.01"

                                readonly />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Payment Mode') }}</label>

                            <select name="payment_mode" class="form-select eForm-select">

                                <option value="">{{ get_phrase('Select payment mode') }}</option>

                                <option value="cash">{{ get_phrase('Cash') }}</option>

                                <option value="bank">{{ get_phrase('Bank Transfer') }}</option>

                                <option value="cheque">{{ get_phrase('Cheque') }}</option>

                                <option value="other">{{ get_phrase('Other') }}</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Payment Date') }}</label>

                            <input type="date" name="payment_date" class="form-control eForm-control" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Approved By') }}</label>

                            <input type="text" name="approved_by" class="form-control eForm-control" />

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="fpb-7">

                            <label class="eForm-label">{{ get_phrase('Payment Status') }}</label>

                            <select name="status" class="form-select eForm-select select2">

                                <option value="">{{ get_phrase('Select a invoice type') }}</option>

                                <option value="1">{{ get_phrase('Paid') }}</option>

                                <option value="0">{{ get_phrase('Unpaid') }}</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="fpb-7">

                            <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Note') }} <small

                                    class="text-muted">({{ get_phrase('Optional') }})</small></label>

                            <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>

                        </div>

                        <button type="submit" class="btn-form mt-2 mb-3 w-100">{{ get_phrase('Submit') }}</button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@include('admin.payslip.payroll-preview-script')




