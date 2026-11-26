<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;

class PayslipAttendance
{
    public function summary(User $user, Carbon $month, ?Carbon $through = null): array
    {
        $tz = 'Asia/Kolkata';
        $start = $through ? $month->copy()->startOfDay() : $month->copy()->startOfMonth();
        $end = $through ? $through->copy()->endOfDay() : $month->copy()->endOfMonth();
        if ($end->lt($start)) {
            throw new InvalidArgumentException('The salary end date must be on or after the start date.');
        }
        $today = Carbon::now($tz)->startOfDay();
        $join = $user->join_date ? Carbon::parse($user->join_date, $tz)->startOfDay() : null;

        $code = trim((string) $user->paycode);
        if ($code === '') {
            throw new InvalidArgumentException('Employee paycode is empty; set it before generating a payslip.');
        }
        $codes = [$code];
        if (ctype_digit($code)) {
            $codes[] = ltrim($code, '0') ?: '0';
        }

        $holidays = Schema::hasTable('holidays')
            ? DB::table('holidays')->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->where(function ($q) use ($user) {
                    $q->whereNull('branch_id');
                    if ($user->branch_id) $q->orWhere('branch_id', $user->branch_id);
                })->pluck('date')->map(fn ($date) => substr((string) $date, 0, 10))->flip()
            : collect();

        $workingDates = collect();
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            if ($day->isSunday() || ($join && $day->lt($join)) || $holidays->has($day->toDateString())) continue;
            $workingDates->push($day->toDateString());
        }

        $punches = DB::table('biometric_punches')->whereIn('employee_no', array_unique($codes))
            ->where('punch_at', '>=', $start->format('Y-m-d H:i:s'))
            ->where('punch_at', '<', $end->copy()->addDay()->startOfDay()->format('Y-m-d H:i:s'))
            ->orderBy('punch_at')->get(['punch_at'])->groupBy(fn ($p) => substr($p->punch_at, 0, 10));

        $corrections = Schema::hasTable('biometric_attendance_corrections')
            ? DB::table('biometric_attendance_corrections')->where('user_id', $user->id)
                ->where('status', 'approved')->whereBetween('attendance_date', [$start->toDateString(), $end->toDateString()])
                ->orderBy('id')->get(['attendance_date', 'first_time', 'last_time'])->keyBy('attendance_date')
            : collect();

        $presentDates = collect();
        $singlePunchDates = collect();
        $invalidPunchDates = collect();
        $otMinutes = 0;
        $lateMinutes = 0;
        $fullDays = 0;
        $halfDays = 0;
        $halfDayDates = collect();
        $shift = Schema::hasTable('biometric_attendance_shifts')
            ? DB::table('biometric_attendance_shifts')->where('user_id', $user->id)->first(['start_time'])
            : null;
        $shiftStart = substr((string) ($shift->start_time ?? '11:00:00'), 0, 8);
        foreach ($workingDates as $date) {
            if ($date > $today->toDateString()) continue;
            $dayPunches = $punches->get($date, collect());
            $correction = $corrections->get($date);
            if (!$dayPunches->count() && !$correction) continue;
            $presentDates->push($date);
            $first = $correction ? $date.' '.$correction->first_time : $dayPunches->first()->punch_at;
            $last = $correction ? ($correction->last_time ? $date.' '.$correction->last_time : null)
                : ($dayPunches->count() > 1 ? $dayPunches->last()->punch_at : null);
            if ($last === null) {
                // Payroll policy: one punch is one paid full day.
                // No work span is known, so there is no overtime calculation.
                $singlePunchDates->push($date);
                $fullDays++;
                continue;
            }
            $firstAt = Carbon::parse($first, $tz);
            $lastAt = Carbon::parse($last, $tz);
            if ($lastAt->lte($firstAt)) { $invalidPunchDates->push($date); continue; }
            $spanSeconds = $lastAt->getTimestamp() - $firstAt->getTimestamp();
            $shiftAt = Carbon::parse($date.' '.$shiftStart, $tz);
            $lateSeconds = max(0, $firstAt->getTimestamp() - $shiftAt->getTimestamp());
            $lateMinutes += (int) ceil($lateSeconds / 60);
            if ($spanSeconds < 8 * 3600) {
                $halfDays++;
                $halfDayDates->push($date);
            } else {
                $fullDays++;
                $otMinutes += intdiv($spanSeconds - 8 * 3600, 60);
            }
        }

        // Single punches are paid full days. Invalid reversed times still
        // need review and are not paid until corrected.
        $paidPunchDates = $presentDates->diff($invalidPunchDates);
        $absentDates = $workingDates->filter(fn ($date) =>
            $date <= $today->toDateString() && !$paidPunchDates->contains($date)
        )->values();
        $absentLookup = $absentDates->flip();
        $approvedLeaveDates = collect();
        $approvedLeaves = DB::table('leave_applications')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('from_date', '<=', $end->timestamp)
            ->where('to_date', '>=', $start->timestamp)
            ->get(['from_date', 'to_date']);

        foreach ($approvedLeaves as $leave) {
            $leaveStart = Carbon::createFromTimestamp((int) $leave->from_date, $tz)->startOfDay();
            $leaveEnd = Carbon::createFromTimestamp((int) $leave->to_date, $tz)->startOfDay();
            if ($leaveStart->lt($start)) $leaveStart = $start->copy()->startOfDay();
            if ($leaveEnd->gt($end)) $leaveEnd = $end->copy()->startOfDay();
            for ($day = $leaveStart->copy(); $day->lte($leaveEnd); $day->addDay()) {
                if ($absentLookup->has($day->toDateString())) {
                    $approvedLeaveDates->push($day->toDateString());
                }
            }
        }
        $approvedLeaveDates = $approvedLeaveDates->unique()->values();
        $leaveWithoutPayDates = $absentDates->diff($approvedLeaveDates)->values();
        $offsetMinutes = min($lateMinutes, $otMinutes);

        return [
            'workingDays' => $workingDates->count(),
            'workingDates' => $workingDates,
            'presentDates' => $presentDates,
            'presentDays' => $presentDates->count(),
            'fullDays' => $fullDays,
            'halfDays' => $halfDays,
            'halfDayDates' => $halfDayDates,
            'effectivePresentDays' => $fullDays + ($halfDays * 0.5),
            'lateMinutes' => $lateMinutes,
            'overtimeMinutes' => $otMinutes,
            'offsetMinutes' => $offsetMinutes,
            'uncoveredLateMinutes' => $lateMinutes - $offsetMinutes,
            'approvedLeaveDates' => $approvedLeaveDates,
            'approvedLeaveDays' => $approvedLeaveDates->count(),
            'leaveWithoutPayDates' => $leaveWithoutPayDates,
            'leaveWithoutPay' => $leaveWithoutPayDates->count(),
            // Display/store full unpaid dates plus the unpaid half of each short day.
            // Payroll receives leaveWithoutPay (full dates) and halfDays separately.
            'leaveWithoutPayEquivalent' => $leaveWithoutPayDates->count() + ($halfDays * 0.5),
            'overtimeHours' => round($otMinutes / 60, 2),
            'singlePunchDays' => $singlePunchDates->count(),
            'singlePunchDates' => $singlePunchDates,
            'invalidPunchDays' => $invalidPunchDates->count(),
            'incompleteDays' => $singlePunchDates->count() + $invalidPunchDates->count(),
            'incompleteDates' => $singlePunchDates->merge($invalidPunchDates)->values(),
            'isCompleteMonth' => $end->lt($today),
        ];
    }

    public function monthlyWorkingDayCounts(User $user, Carbon $start, Carbon $end): array
    {
        $first = $start->copy()->startOfMonth();
        $last = $end->copy()->endOfMonth();
        $holidays = Schema::hasTable('holidays')
            ? DB::table('holidays')->whereBetween('date', [$first->toDateString(), $last->toDateString()])
                ->where(function ($q) use ($user) {
                    $q->whereNull('branch_id');
                    if ($user->branch_id) $q->orWhere('branch_id', $user->branch_id);
                })->pluck('date')->map(fn ($date) => substr((string) $date, 0, 10))->flip()
            : collect();

        $counts = [];
        for ($day = $first; $day->lte($last); $day->addDay()) {
            $key = $day->format('Y-m');
            if (!isset($counts[$key])) $counts[$key] = 0;
            if (!$day->isSunday() && !$holidays->has($day->toDateString())) $counts[$key]++;
        }
        return $counts;
    }
}
