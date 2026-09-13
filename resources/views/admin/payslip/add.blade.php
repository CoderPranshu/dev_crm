<div class="eSection-wrap">
    <div class="row">
        <div class="col-md-12">


            <form action="{{ route('admin.payslip.store') }}" method="post">
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
                        use Illuminate\Support\Facades\Http;
                        use App\Models\Branch;
                        use App\Models\Leave_application;
                        use App\Models\Holiday;
                        use App\Models\LeaveType;

                        // ----------------------------------------
                        // USER + DATE
                        // ----------------------------------------
                        $user = \App\Models\User::find(request('user_id'));

                        $year = request()->get('year', date('Y'));
                        $month = str_pad(request()->get('month', date('m')), 2, '0', STR_PAD_LEFT);

                        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                        $endDate = $startDate->copy()->endOfMonth();

                        $startTs = $startDate->timestamp;
                        $endTs = $endDate->timestamp;

                        // ----------------------------------------
                        // HOLIDAYS (YYYY-MM-DD list)
                        // ----------------------------------------
                        $holidays = Holiday::whereBetween('date', [
                            $startDate->format('Y-m-d'),
                            $endDate->format('Y-m-d'),
                        ])
                            ->pluck('date')
                            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'));

                        // ----------------------------------------
                        // WORKING DATES (exclude Sunday + holidays)
                        // ----------------------------------------
                        $workingDates = collect();

                        for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
                            $ds = $d->format('Y-m-d');

                            if ($d->dayOfWeekIso == 7) {
                                continue;
                            } // Sunday
                            if ($holidays->contains($ds)) {
                                continue;
                            }

                            $workingDates->push($ds);
                        }

                        $workingDays = $workingDates->count();

                        // ----------------------------------------
                        // ATTENDANCE (date-wise)
                        // ----------------------------------------
                        $branch = Branch::find($user->branch_id);

                        $response = Http::post('http://ta.biumetrics.com/api/transaction/GetRowData', [
                            'TXN_NAME' => 'GetRowData',
                            'DATA' => json_encode([
                                'Company_Code' => '17',
                                'ReportDate_From' => $startDate->format('Y/m/d'),
                                'ReportDate_To' => $endDate->format('Y/m/d'),
                                'MachineSerialNo' => $branch->machine_serial_no ?? '',
                            ]),
                        ]);

                        $rows = collect($response->json()['data'] ?? []);
                        $userRows = $rows->where('PAYCODE', $user->paycode);

                        $grouped = $userRows->groupBy(fn($r) => substr($r['OFFICEPUNCH'], 0, 10));

                        // only count present on working dates
                        $presentDates = $grouped->keys()->filter(fn($d) => $workingDates->contains($d));
                        $actualPresent = $presentDates->count();

                        // ----------------------------------------
                        // OVERTIME (>=45 min = 1 hr)
                        // ----------------------------------------
                        $overtimeHours = 0;

                        foreach ($grouped as $date => $punches) {
                            if (!$workingDates->contains($date)) {
                                continue;
                            }

                            $punches = collect($punches)->sortBy('OFFICEPUNCH')->values();

                            if ($punches->count() >= 2) {
                                $in = Carbon::parse($punches[0]['OFFICEPUNCH']);
                                $out = Carbon::parse($punches[1]['OFFICEPUNCH']);

                                $workedMin = $out->diffInMinutes($in);

                                if ($workedMin > 480) {
                                    $extra = $workedMin - 480;

                                    if ($extra >= 45) {
                                        $overtimeHours += ceil($extra / 60);
                                    }
                                }
                            }
                        }

                        // ----------------------------------------
                        // LEAVES (FIXED QUERY: timestamp overlap)
                        // ----------------------------------------
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

                        $presentDays = min($workingDays, $actualPresent + $paidLeaveDays);
                        $absentDays = max($workingDays - $presentDays, 0);

                        // ----------------------------------------
                        // LEAVE SUMMARY (MONTH)
                        // ----------------------------------------
                        $totalLeaveTaken = $paidLeaveDays + $unpaidLeaveDays;

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
                        <label class="eForm-label">Leave Taken (Month)</label>
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
                            <label class="eForm-label">{{ get_phrase('Brief of monthly salary') }}</label>
                            <input type="text" name="brief_of_monthly_salary"
                                value="{{ date('m/d/y', $timestamp_of_first_date) }} - {{ date('m/t/y', $timestamp_of_first_date) }}"
                                class="eForm-control date-range-picker">
                        </div>
                    </div>


                    {{-- @php
                        use Carbon\Carbon;
                        use Illuminate\Support\Facades\Http;
                        use App\Models\Branch;
                        use App\Models\User;

                        // User
                        $user = \App\Models\User::find($_GET['user_id']);

                        // Month range (current month)
                        $startDate = Carbon::now()->startOfMonth();
                        $endDate = Carbon::now()->endOfMonth();

                        // Branch + machine
                        $branch = Branch::find($user->branch_id);

                        // dd($branch);

                        // Fetch attendance data
                        $response = Http::post('http://ta.biumetrics.com/api/transaction/GetRowData', [
                            'TXN_NAME' => 'GetRowData',
                            'DATA' => json_encode([
                                'Company_Code' => '17',
                                'ReportDate_From' => $startDate->format('Y/m/d'),
                                'ReportDate_To' => $endDate->format('Y/m/d'),
                                'MachineSerialNo' => $branch->machine_serial_no ?? '',
                            ]),
                        ]);

                        // dd($response);

                        $rows = collect($response->json()['data'] ?? []);

                        // dd($rows);

                        // Filter only this user
                        $userRows = $rows->where('PAYCODE', $user->paycode);

                        // Group by actual punch date
                        $grouped = $userRows->groupBy(function ($row) {
                            return substr($row['OFFICEPUNCH'], 0, 10);
                        });

                        $presentDays = 0;
                        $overtimeHours = 0;

                        foreach ($grouped as $date => $punches) {
                            $punches = $punches->sortBy('OFFICEPUNCH')->values();

                            // Present if punch-in exists
                            if ($punches->count() >= 1) {
                                $presentDays++;

                                // Calculate overtime only if punch-out exists
                                if ($punches->count() >= 2) {
                                    $in = Carbon::parse($punches[0]['OFFICEPUNCH']);
                                    $out = Carbon::parse($punches[1]['OFFICEPUNCH']);

                                    $workedHours = $out->diffInMinutes($in) / 60;

                                    if ($workedHours > 8) {
                                        $overtimeHours += $workedHours - 8;
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

                        // Absent days
                        $absentDays = max($workingDays - $presentDays, 0);

                        // dd($presentDays);

                    @endphp --}}

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Working Days') }}</label>
                            <input type="number" name="working_days" value="{{ $workingDays }}"
                                class="form-control eForm-control" step="1" readonly />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Present Days') }}</label>
                            <input type="number" name="present_days" id="present_days" value="{{ $presentDays }}"
                                class="form-control eForm-control" step="1" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Leave Without Pay') }}</label>
                            <input type="number" name="leave_withoutpay" id="leave_withoutpay"
                                value="{{ $absentDays }}" class="form-control eForm-control" step="1" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fpb-7">
                            <label class="eForm-label">{{ get_phrase('Over Time (hrs)') }}</label>
                            <input type="number" name="over_time" id="over_time" value="{{ $overtimeHours }}"
                                class="form-control eForm-control" step="1" />
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

@include('payslipjs')
