<?php

namespace App\Services;

use App\Models\Leave_application;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;

class PayslipDateLedger
{
    public function signature(array $ledger): string
    {
        return hash('sha256', json_encode($ledger['rows'], JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE));
    }

    public function build(User $user, Carbon $month, array $attendance): array
    {
        $tz = 'Asia/Kolkata';
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();
        $today = Carbon::now($tz)->toDateString();
        $working = $attendance['workingDates']->flip();
        $punched = $attendance['punchDates']->flip();
        $leaveDates = [];
        $leaveRequests = [];
        $leaveUsage = [];
        // LeaveApplicationController stores Unix timestamps using Laravel's app timezone.
        // Decode them in that same timezone before matching calendar dates.
        $leaveTz = config('app.timezone', 'UTC');
        $leaveMonthStart = Carbon::parse($start->toDateString(), $leaveTz)->startOfDay();
        $leaveMonthEnd = Carbon::parse($end->toDateString(), $leaveTz)->endOfDay();

        // Read every request, including pending/rejected, at render and again on save.
        $applications = Leave_application::with('leavetype')
            ->where('user_id', $user->id)
            ->where('from_date', '<=', $leaveMonthEnd->timestamp)
            ->where('to_date', '>=', $leaveMonthStart->timestamp)
            ->orderBy('id')->get();

        foreach ($applications as $leave) {
            $type = $leave->leavetype;
            $typeId = $type?->id;
            if ($typeId !== null) $leaveUsage[$typeId] = $leaveUsage[$typeId] ?? 0;
            $from = Carbon::createFromTimestamp((int) $leave->from_date, $leaveTz)->startOfDay();
            $to = Carbon::createFromTimestamp((int) $leave->to_date, $leaveTz)->startOfDay();
            $label = (string) ($type?->title ?? $type?->name ?? 'Leave');
            $decision = strtolower(trim((string) $leave->status));
            if ($decision === '' || $decision === '0' || str_starts_with($decision, 'pending')
                || $decision === 'requested') $decision = 'pending';
            for ($day = $from; $day->lte($to); $day->addDay()) {
                $date = $day->toDateString();
                if (!$working->has($date) || $date > $today) continue;
                $leaveRequests[$date][] = ['label' => $label, 'decision' => $decision];
                if ($decision !== 'approved' || $punched->has($date) || isset($leaveDates[$date])) continue;
                // The approval is the payroll decision; LeaveType.days is informational.
                // A missing type or exhausted display balance must not turn approved leave into LWP.
                $leaveDates[$date] = ['status' => 'paid_leave', 'label' => $label, 'leave_id' => $leave->id];
                if ($typeId !== null) $leaveUsage[$typeId]++;
            }
        }

        $rows = [];
        $counts = ['full' => 0, 'half' => 0, 'single' => 0, 'paid_leave' => 0,
            'unpaid_leave' => 0, 'pending_leave' => 0, 'absent' => 0, 'future' => 0];
        for ($day = $start; $day->lte($end); $day->addDay()) {
            $date = $day->toDateString();
            if (!$working->has($date)) {
                $status = $day->isSunday() ? 'sunday'
                    : ($user->join_date && $date < substr((string) $user->join_date, 0, 10) ? 'pre_join' : 'holiday');
                $record = ['status' => $status, 'first' => null, 'last' => null,
                    'punch_times' => $attendance['allPunchTimes'][$date] ?? [],
                    'worked_minutes' => 0, 'late_minutes' => 0, 'ot_minutes' => 0, 'source' => null];
            } else {
                $record = $attendance['dayRecords'][$date];
                $record['attendance_status'] = $record['status'];
                $record['leave_requests'] = $leaveRequests[$date] ?? [];
                if ($record['status'] === 'absent' && isset($leaveDates[$date])) {
                    $record['status'] = $leaveDates[$date]['status'];
                    $record['leave_label'] = $leaveDates[$date]['label'];
                } elseif ($record['status'] === 'absent' && in_array('pending',
                    array_column($record['leave_requests'], 'decision'), true)) {
                    $record['status'] = 'pending_leave';
                }
                $status = $record['status'];
                if (isset($counts[$status])) $counts[$status]++;
            }
            $rows[] = array_merge(['date' => $date, 'day' => $day->format('D'),
                'paid_units' => $status === 'full' || $status === 'paid_leave' ? 1
                    : ($status === 'half' ? 0.5 : 0)], $record);
        }

        $available = 0;
        foreach (LeaveType::all() as $type) {
            $available += max(0, (int) $type->days - ($leaveUsage[$type->id] ?? 0));
        }
        $requestedDates = 0;
        foreach ($leaveRequests as $requests) {
            if (array_intersect(['approved', 'pending'], array_column($requests, 'decision'))) $requestedDates++;
        }
        return [
            'rows' => $rows,
            'counts' => $counts,
            'paidLeaveDays' => $counts['paid_leave'],
            'leaveTaken' => $requestedDates,
            'leaveAvailable' => $available,
            'unpaidDays' => $counts['single'] + $counts['unpaid_leave'] + $counts['pending_leave'] + $counts['absent'],
            'payableDays' => $counts['full'] + $counts['half'] * 0.5 + $counts['paid_leave'],
        ];
    }
}
