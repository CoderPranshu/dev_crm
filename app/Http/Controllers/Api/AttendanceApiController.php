<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AttendanceApiController extends Controller
{
    /**
     * GET /api/attendance/today
     * Backward-compatible employee today endpoint.
     */
    public function today(Request $request)
    {
        $request->merge(['period' => 'today']);

        return $this->employeeAttendance($request);
    }

    /**
     * GET /api/employee/attendance?period=today
     * GET /api/employee/attendance?period=date&date=2026-10-09
     * GET /api/employee/attendance?period=month&month=2026-10
     *
     * Returns attendance ONLY for the authenticated employee.
     */
    public function employeeAttendance(Request $request)
    {
        $validated = $request->validate([
            'period' => ['required', 'in:today,date,month'],
            'date' => ['required_if:period,date', 'date_format:Y-m-d'],
            'month' => ['required_if:period,month', 'date_format:Y-m'],
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (empty($user->paycode)) {
            return response()->json([
                'success' => false,
                'message' => 'No paycode assigned to this employee.',
            ], 422);
        }

        if (!Schema::hasTable('biometric_punches')) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance table not found.',
            ], 500);
        }

        [$start, $end] = $this->attendanceDateRange($validated);

        $paycode = trim((string) $user->paycode);
        $normalizedPaycode = $this->normalizePaycode($paycode);

        // Fetch only this employee's biometric records.
        $punches = DB::table('biometric_punches')
            ->whereIn('employee_no', array_values(array_unique([
                $paycode,
                $normalizedPaycode,
            ])))
            ->where('punch_at', '>=', $start->format('Y-m-d H:i:s'))
            ->where('punch_at', '<', $end->format('Y-m-d H:i:s'))
            ->orderBy('punch_at')
            ->get([
                'id',
                'device_id',
                'employee_no',
                'punch_at',
                'verify_mode',
            ]);

        $attendance = $this->groupDailyAttendance($punches);

        // Fetch employee shift directly
        $shift = DB::table('biometric_attendance_shifts')
            ->where('user_id', $user->id)
            ->first(['start_time', 'end_time']);

        $shift = [
            'start_time' => $shift->start_time ?? null,
            'end_time' => $shift->end_time ?? null,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Employee attendance retrieved successfully.',
            'employee' => $user->name,
            'paycode' => $user->paycode,

            // Add shift timing here
            'shift' => $shift,

            'period' => $validated['period'],
            'from' => $start->toDateString(),
            'to' => $end->copy()->subDay()->toDateString(),
            'total_days_with_punches' => $attendance->count(),
            'data' => $attendance,
        ]);
    }

    /**
     * GET /api/admin/attendance?period=today
     * GET /api/admin/attendance?period=date&date=2026-10-09
     * GET /api/admin/attendance?period=month&month=2026-10
     * Optional: &employee=107
     *
     * Returns attendance for all users, or one selected user.
     * Only authorized admins may access this endpoint.
     */
    public function adminAttendance(Request $request)
    {
        $validated = $request->validate([
            'period' => ['required', 'in:today,date,month'],
            'date' => ['required_if:period,date', 'date_format:Y-m-d'],
            'month' => ['required_if:period,month', 'date_format:Y-m'],
            'employee' => ['nullable', 'integer', 'min:1'],
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        // Check the user's role using Spatie or the role column.
        $roleNames = method_exists($user, 'getRoleNames')
            ? $user->getRoleNames()->map(
                fn ($role) => strtolower($role)
            )
            : collect();

        $isAdmin = strtolower((string) ($user->role ?? '')) === 'admin'
            || $roleNames->contains('admin');

        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required.',
            ], 403);
        }

        if (!Schema::hasTable('biometric_punches')) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance table not found.',
            ], 500);
        }

        [$start, $end] = $this->attendanceDateRange($validated);

        // Do not filter by paycode here: users without a paycode
        // should also appear with empty attendance.
        $employees = DB::table('users')
            ->when(
                !empty($validated['employee']),
                fn ($query) => $query->where(
                    'id',
                    $validated['employee']
                )
            )
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
                'paycode',
            ]);

        // Retrieve punches for the requested date range.
        $allPunches = DB::table('biometric_punches')
            ->where('punch_at', '>=', $start->format('Y-m-d H:i:s'))
            ->where('punch_at', '<', $end->format('Y-m-d H:i:s'))
            ->orderBy('punch_at')
            ->get([
                'id',
                'device_id',
                'employee_no',
                'punch_at',
                'verify_mode',
            ]);

        // Group records using normalized biometric paycodes.
        $groupedPunches = $allPunches->groupBy(
            fn ($punch) => $this->normalizePaycode(
                $punch->employee_no
            )
        );

        $shifts = Schema::hasTable('biometric_attendance_shifts')
            ? DB::table('biometric_attendance_shifts')
                ->whereIn('user_id', $employees->pluck('id'))
                ->get(['user_id', 'start_time', 'end_time'])
                ->keyBy('user_id')
            : collect();

        $data = $employees->map(function ($employee) use (
            $groupedPunches,
            $shifts
        ) {
            if (empty($employee->paycode)) {
                $employeePunches = collect();
            } else {
                $normalizedPaycode = $this->normalizePaycode(
                    $employee->paycode
                );

                $employeePunches = $groupedPunches->get(
                    $normalizedPaycode,
                    collect()
                );
            }

            $dailyAttendance = $this->groupDailyAttendance(
                $employeePunches
            );

             $shift = $shifts->get($employee->id);

            return [
                'user_id' => $employee->id,
                'employee' => $employee->name,
                'email' => $employee->email,
                'paycode' => $employee->paycode,

                'shift' => [
                    'start_time' => $shift->start_time ?? null,
                    'end_time' => $shift->end_time ?? null,
                ],

                'total_days_with_punches' => $dailyAttendance->count(),
                'attendance' => $dailyAttendance,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Attendance retrieved successfully.',
            'period' => $validated['period'],
            'from' => $start->toDateString(),
            'to' => $end->copy()->subDay()->toDateString(),
            'total_employees' => $data->count(),
            'employees_with_punches' => $data->filter(
                fn ($employee) => $employee['total_days_with_punches'] > 0
            )->count(),
            'data' => $data->values(),
        ]);
    }

    /**
     * Group punch records by date and summarize each day.
     */
    private function groupDailyAttendance($punches)
    {
        return $punches
            ->groupBy(
                fn ($punch) => Carbon::parse(
                    $punch->punch_at,
                    'Asia/Kolkata'
                )->toDateString()
            )
            ->map(function ($dailyPunches, $date) {
                $dailyPunches = $dailyPunches->sortBy('punch_at')
                    ->values();

                return [
                    'date' => $date,
                    'first_punch' => $dailyPunches->first()->punch_at,
                    'last_punch' => $dailyPunches->last()->punch_at,
                    'total_punches' => $dailyPunches->count(),
                    'punch_records' => $dailyPunches,
                ];
            })
            ->values();
    }

    /**
     * Calculate the requested date range in Indian Standard Time.
     * The end timestamp is exclusive.
     */
    private function attendanceDateRange(array $validated): array
    {
        if ($validated['period'] === 'date') {
            $start = Carbon::createFromFormat(
                '!Y-m-d',
                $validated['date'],
                'Asia/Kolkata'
            );
        } elseif ($validated['period'] === 'month') {
            $start = Carbon::createFromFormat(
                '!Y-m',
                $validated['month'],
                'Asia/Kolkata'
            )->startOfMonth();
        } else {
            $start = now('Asia/Kolkata')->startOfDay();
        }

        $end = $validated['period'] === 'month'
            ? $start->copy()->addMonth()
            : $start->copy()->addDay();

        return [$start, $end];
    }

    /**
     * Treat paycodes such as "00000006" and "6" as equivalent.
     */
    private function normalizePaycode($value): string
    {
        $value = trim((string) $value);

        return ctype_digit($value)
            ? (ltrim($value, '0') ?: '0')
            : $value;
    }
}