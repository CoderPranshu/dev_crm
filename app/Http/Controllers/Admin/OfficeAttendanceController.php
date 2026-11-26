<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfficeAttendanceController extends Controller
{
    public function index()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $date = Carbon::now('Asia/Kolkata')->toDateString();
        $deskIds = [];
        foreach (['IT' => 8, 'SEO' => 6, 'CALL' => 2] as $prefix => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $deskIds[] = sprintf('%s-%02d', $prefix, $i);
            }
        }

        // Seat allocation belongs to users. The map's 16 desk positions are fixed.
        $employees = DB::table('users')
            ->where('status', 'active')
            ->whereIn('allocate_sit_no', $deskIds)
            ->orderBy('id')
            ->get(['id', 'name', 'role', 'paycode', 'allocate_sit_no']);

        // A duplicate allocation should not cause the same desk to render twice.
        $assigned = $employees->unique('allocate_sit_no')->values();
        $punches = DB::table('biometric_punches')
            ->where('punch_at', '>=', $date.' 00:00:00')
            ->where('punch_at', '<', Carbon::parse($date, 'Asia/Kolkata')->addDay()->toDateString().' 00:00:00')
            ->orderBy('punch_at')
            ->get(['employee_no', 'punch_at']);

        $officeMapData = [
            'date' => $date,
            'users' => $assigned->map(fn ($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'role' => $u->role,
                'paycode' => (string) $u->paycode,
            ])->all(),
            'allocations' => $assigned->map(fn ($u) => [
                'desk_id' => $u->allocate_sit_no,
                'user_id' => $u->id,
            ])->all(),
            // The map normalizes 00000001 and 1 to the same employee code.
            'punches' => $punches->map(fn ($p) => [
                'employee_no' => (string) $p->employee_no,
                'punched_at' => $p->punch_at,
            ])->all(),
        ];

        return view('admin.office-attendance.index', compact('officeMapData', 'date'));
    }
}