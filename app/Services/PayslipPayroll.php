<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PayslipPayroll
{
    /**
     * Monthly gross is a salary rate. The range is valued one working day at a
     * time, so a 1st–15th payslip never receives a full month's gross.
     */
    public function calculateForRange(
        float $monthlyGross,
        Collection $workingDates,
        Collection $unpaidDates,
        Collection $halfDayDates,
        array $monthlyWorkingDays,
        int $uncoveredLateMinutes,
        float $otherDeductions = 0,
        float $bonus = 0,
        float $penalty = 0
    ): array {
        $rate = function (string $date) use ($monthlyGross, $monthlyWorkingDays): float {
            $month = substr($date, 0, 7);
            $days = $monthlyWorkingDays[$month] ?? 0;
            return $days > 0 ? $monthlyGross / $days : 0;
        };

        $periodGross = $workingDates->sum(fn ($date) => $rate($date));
        $absence = $unpaidDates->sum(fn ($date) => $rate($date));
        $half = $halfDayDates->sum(fn ($date) => $rate($date) * 0.5);
        $late = max(0, $uncoveredLateMinutes);
        $other = max(0, $otherDeductions);
        $total = round($absence + $half + $late + $other, 2);

        return [
            'period_gross' => round($periodGross, 2),
            'absence_deduction' => round($absence, 2),
            'half_day_deduction' => round($half, 2),
            'late_deduction' => $late,
            'total_deduc' => $total,
            'total_net' => round($periodGross - $total, 2),
            'final_payable' => round($periodGross - $total + $bonus - $penalty, 2),
        ];
    }

    /** All amounts are rounded only when the final ledger is saved. OT never earns cash. */
    public function calculate(float $grossSalary, int $workingDays, float $unpaidDays, int $halfDays,
        int $uncoveredLateMinutes, float $statutoryAndOtherDeductions = 0, float $bonus = 0,
        float $penalty = 0): array
    {
        $dailyRate = $workingDays > 0 ? $grossSalary / $workingDays : 0;
        $absence = round($dailyRate * max(0, $unpaidDays), 2);
        $half = round($dailyRate * max(0, $halfDays) * 0.5, 2);
        $late = max(0, $uncoveredLateMinutes); // ₹1 per uncovered minute
        $other = round(max(0, $statutoryAndOtherDeductions), 2);
        $total = round($other + $absence + $half + $late, 2);

        return [
            'absence_deduction' => $absence,
            'half_day_deduction' => $half,
            'late_deduction' => $late,
            'total_deduc' => $total,
            'total_net' => round($grossSalary - $total, 2),
            'final_payable' => round($grossSalary - $total + $bonus - $penalty, 2),
        ];
    }
}
