<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** Read-only device punches. Approved corrections are stored separately. */
class BiometricAttendanceController extends Controller
{
    private const TZ = 'Asia/Kolkata';
    private const DEFAULT_START = '11:00';
    private const DEFAULT_END = '19:00';

    public function index(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d'],
            'month' => ['nullable', 'date_format:Y-m'],
            'employee' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string', 'max:100'],
            'daily_status' => ['nullable', Rule::in(['all', 'complete', 'open', 'no_punch', 'late', 'early'])],
            'min_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
        ]);

        $today = Carbon::now(self::TZ)->startOfDay();
        $date = $request->filled('date') ? Carbon::createFromFormat('!Y-m-d', $request->date, self::TZ) : $today->copy();
        $month = $request->filled('month') ? Carbon::createFromFormat('!Y-m', $request->month, self::TZ) : $date->copy()->startOfMonth();
        abort_if($date->gt($today->copy()->addDay()) || $month->gt($today->copy()->addMonth()), 422);

        $people = $this->people();
        $shifts = DB::table('biometric_attendance_shifts')->get()->keyBy('user_id');
        $approved = DB::table('biometric_attendance_corrections')
            ->where('status', 'approved')->orderBy('id')->get()->keyBy(fn ($r) => $r->user_id.'|'.$r->attendance_date);

        $daily = $this->daily($people, $shifts, $approved, $date, $today);
        if ($request->filled('search')) {
            $needle = mb_strtolower(trim($request->search));
            $daily = $daily->filter(fn ($r) => str_contains(mb_strtolower($r['name'].' '.$r['paycode']), $needle))->values();
        }

        $visiblePeople = $people;
        if ($request->filled('employee')) {
            $employeeId = (int) $request->employee;
            $visiblePeople = $people->filter(fn ($p) => (int) $p->id === $employeeId)->values();
            abort_if($visiblePeople->isEmpty(), 404);
            $daily = $daily->filter(fn ($r) => $r['user_id'] === $employeeId)->values();
        }
        $daily = match ($request->input('daily_status', 'all')) {
            'complete' => $daily->filter(fn ($r) => $r['hours_minutes'] !== null),
            'open' => $daily->filter(fn ($r) => $r['first'] && ! $r['last']),
            'no_punch' => $daily->filter(fn ($r) => ! $r['first']),
            'late' => $daily->filter(fn ($r) => $r['late']),
            'early' => $daily->filter(fn ($r) => $r['early']),
            default => $daily,
        };
        if ($request->filled('min_hours')) {
            $minimumMinutes = (float) $request->min_hours * 60;
            $daily = $daily->filter(fn ($r) => $r['hours_minutes'] !== null && $r['hours_minutes'] >= $minimumMinutes);
        }
        $daily = $daily->values();

        $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $today->copy()->endOfWeek(Carbon::SUNDAY);
        $week = $this->periodStats($people, $shifts, $approved, $weekStart, $weekEnd, $today);
        $monthStats = $this->periodStats($people, $shifts, $approved, $month->copy()->startOfMonth(), $month->copy()->endOfMonth(), $today);

        $calendarPerson = $visiblePeople->first();
        $calendar = $calendarPerson ? $this->calendar($calendarPerson, $shifts, $approved, $month, $today) : collect();
        $unmatched = $this->unmatched($date, $people);
        $requests = DB::table('biometric_attendance_corrections as c')
            ->join('users as u', 'u.id', '=', 'c.user_id')
            ->when(! $this->isAdmin(), fn ($q) => $q->where('c.user_id', auth()->id()))
            ->select('c.*', 'u.name as employee_name')->orderByDesc('c.id')->limit(30)->get();
        $lastReceived = DB::table('biometric_punches')->max('updated_at');
        $officeSeatColumnReady = Schema::hasColumn('users', 'allocate_sit_no');
        $officeMapData = $this->isAdmin() && $officeSeatColumnReady
            ? $this->officeMapData($today)
            : ['date' => $today->toDateString(), 'users' => [], 'allocations' => [], 'punches' => []];

        return view('admin.biometric-attendance.index', [
            'today' => $today, 'date' => $date, 'month' => $month, 'people' => $visiblePeople,
            'daily' => $daily, 'week' => $week, 'monthStats' => $monthStats,
            'calendarPerson' => $calendarPerson, 'calendar' => $calendar,
            'unmatched' => $unmatched, 'requests' => $requests,
            'lastReceived' => $lastReceived, 'isAdmin' => $this->isAdmin(),
            'officeMapData' => $officeMapData, 'officeSeatColumnReady' => $officeSeatColumnReady,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $request->validate([
            'date' => ['nullable', 'required_without:month', 'date_format:Y-m-d'],
            'month' => ['nullable', 'date_format:Y-m'],
        ]);
        $date = $request->filled('month')
            ? Carbon::createFromFormat('!Y-m', $request->month, self::TZ)->startOfMonth()
            : Carbon::createFromFormat('!Y-m-d', $request->date, self::TZ);
        $today = Carbon::now(self::TZ)->startOfDay();
        abort_if($date->gt($today), 422);
        $people = $this->people();
        $shifts = DB::table('biometric_attendance_shifts')->get()->keyBy('user_id');
        $approved = DB::table('biometric_attendance_corrections')->where('status', 'approved')->orderBy('id')->get()
            ->keyBy(fn ($r) => $r->user_id.'|'.$r->attendance_date);
        $end = $request->filled('month') ? $date->copy()->endOfMonth()->min($today) : $date->copy();

        return response()->streamDownload(function () use ($people, $shifts, $approved, $date, $end, $today) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Name', 'Paycode', 'Shift', 'First punch', 'Last punch', 'Working span (HH:MM)', 'Count', 'Status', 'All device punches']);
            for ($day = $date->copy(); $day->lte($end); $day->addDay()) {
                foreach ($this->daily($people, $shifts, $approved, $day, $today) as $r) {
                // Avoid spreadsheet formula execution when a user-controlled name is exported.
                $safe = static fn ($s) => preg_match('/^[=+\-@\t\r]/u', (string) $s) ? "'".$s : $s;
                fputcsv($out, [
                    $day->toDateString(), $safe($r['name']), $safe($r['paycode']),
                    $r['shift'], $r['first'] ?? '', $r['last'] ?? '', $r['hours_minutes'] === null ? '' : sprintf('%02d:%02d', intdiv($r['hours_minutes'], 60), $r['hours_minutes'] % 60), $r['count'],
                    $r['status'], implode(' | ', $r['punches']),
                ]);
                }
            }
            fclose($out);
        }, 'attendance-'.$date->toDateString().($request->filled('month') ? '-month' : '').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function saveShift(Request $request)
    {
        abort_unless($this->isAdmin(), 403);
        $data = $request->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'different:start_time'],
        ]);
        // This version supports day shifts only; overnight shifts need date-aware grouping.
        abort_if($data['end_time'] <= $data['start_time'], 422, 'Overnight shift is not configured.');
        DB::table('biometric_attendance_shifts')->updateOrInsert(
            ['user_id' => $data['user_id']],
            ['start_time' => $data['start_time'], 'end_time' => $data['end_time'], 'updated_at' => now(), 'created_at' => now()]
        );
        return back()->with('message', 'Employee shift saved.');
    }

    public function requestCorrection(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'attendance_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'first_time' => ['required', 'date_format:H:i'],
            'last_time' => ['nullable', 'date_format:H:i', 'after:first_time'],
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);
        $userId = $this->isAdmin() ? (int) ($data['user_id'] ?? auth()->id()) : auth()->id();
        DB::table('biometric_attendance_corrections')->insert([
            'user_id' => $userId, 'attendance_date' => $data['attendance_date'],
            'first_time' => $data['first_time'], 'last_time' => $data['last_time'] ?? null,
            'reason' => $data['reason'], 'status' => 'pending', 'requested_by' => auth()->id(),
            'created_at' => now(), 'updated_at' => now(),
        ]);
        return back()->with('message', 'Correction request sent for review.');
    }

    public function reviewCorrection(Request $request, int $id)
    {
        abort_unless($this->isAdmin(), 403);
        $data = $request->validate(['status' => ['required', Rule::in(['approved', 'rejected'])]]);
        $changed = DB::transaction(function () use ($id, $data) {
            $entry = DB::table('biometric_attendance_corrections')->where('id', $id)->lockForUpdate()->first();
            if (! $entry || $entry->status !== 'pending') return 0;
            if ($data['status'] === 'approved') {
                DB::table('biometric_attendance_corrections')->where('user_id', $entry->user_id)
                    ->where('attendance_date', $entry->attendance_date)->where('status', 'approved')
                    ->update(['status' => 'superseded', 'updated_at' => now()]);
            }
            return DB::table('biometric_attendance_corrections')->where('id', $id)
                ->update(['status' => $data['status'], 'reviewed_by' => auth()->id(), 'reviewed_at' => now(), 'updated_at' => now()]);
        });
        abort_unless($changed, 404);
        return back()->with('message', 'Request '.$data['status'].'. Raw machine punches remain unchanged.');
    }

    private function isAdmin(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    private function people()
    {
        $photo = collect(['photo', 'image', 'profile_photo_path'])->first(fn ($c) => Schema::hasColumn('users', $c));
        $columns = ['id', 'name', 'paycode'];
        if ($photo) $columns[] = $photo;
        $people = User::query()->where('role', '!=', 'admin')->where('status', 'active')
            ->orderBy('name')->get($columns);
        if (! $this->isAdmin()) $people = $people->where('id', auth()->id())->values();
        return $people->map(function ($p) use ($photo) {
            $path = $photo ? $p->{$photo} : null;
            $p->avatar_url = $path ? (filter_var($path, FILTER_VALIDATE_URL) ? $path : asset('storage/'.ltrim($path, '/'))) : null;
            return $p;
        });
    }

    private function paycode($value): string
    {
        $value = trim((string) $value);
        return ctype_digit($value) ? str_pad(ltrim($value, '0') ?: '0', 8, '0', STR_PAD_LEFT) : $value;
    }

    private function punches(Carbon $start, Carbon $end)
    {
        return DB::table('biometric_punches')->where('punch_at', '>=', $start->format('Y-m-d H:i:s'))
            ->where('punch_at', '<', $end->format('Y-m-d H:i:s'))
            ->orderBy('punch_at')->get(['employee_no', 'punch_at', 'device_id']);
    }

    private function shift($person, $shifts): array
    {
        $override = $shifts->get($person->id);
        return [substr($override->start_time ?? self::DEFAULT_START, 0, 5), substr($override->end_time ?? self::DEFAULT_END, 0, 5)];
    }

    private function daily($people, $shifts, $approved, Carbon $date, Carbon $today)
    {
        $dateString = $date->toDateString();
        $byCode = $this->punches($date, $date->copy()->addDay())
            ->groupBy(fn ($p) => $this->paycode($p->employee_no));

        return $people->map(function ($person) use ($shifts, $approved, $dateString, $date, $today, $byCode) {
            [$start, $end] = $this->shift($person, $shifts);
            $raw = $byCode->get($this->paycode($person->paycode), collect());
            $punches = $raw->map(fn ($p) => substr($p->punch_at, 11, 5))->values()->all();
            $count = count($punches);
            $correction = $approved->get($person->id.'|'.$dateString);
            $first = $correction ? substr($correction->first_time, 0, 5) : ($punches[0] ?? null);
            $last = $correction ? ($correction->last_time ? substr($correction->last_time, 0, 5) : null) : ($count > 1 ? end($punches) : null);
            $now = Carbon::now(self::TZ);
            $isToday = $date->isSameDay($today);
            $firstAt = $first ? Carbon::parse($dateString.' '.$first, self::TZ) : null;
            $lastAt = $last ? Carbon::parse($dateString.' '.$last, self::TZ) : null;
            // A completed pair is the known first-to-last span; a single punch can only give an estimate.
            $hoursMinutes = $firstAt && $lastAt ? max(0, (int) $firstAt->diffInMinutes($lastAt, false)) : null;
            $elapsedMinutes = $firstAt && ! $lastAt && $isToday
                ? max(0, (int) $firstAt->diffInMinutes($now, false)) : null;
            $isLate = $first && $first > $start;
            $isEarly = $last && (! $isToday || $now->format('H:i') >= $end) && $last < $end;
            if (! $first) $status = $isToday && $now->format('H:i') < $end ? 'Awaiting punch' : 'No punch';
            elseif (! $last) $status = $isToday && $now->format('H:i') < $end ? 'Open / one punch' : 'Missing last punch';
            elseif ($isLate && $isEarly) $status = 'Late + early exit';
            elseif ($isLate) $status = 'Late';
            elseif ($isEarly) $status = 'Early exit';
            else $status = 'On time';
            return [
                'user_id' => (int) $person->id, 'name' => $person->name, 'paycode' => $person->paycode,
                'avatar' => $person->avatar_url, 'shift' => $start.'–'.$end, 'start' => $start, 'end' => $end,
                'first' => $first, 'last' => $last, 'count' => $count, 'punches' => $punches,
                'hours_minutes' => $hoursMinutes, 'elapsed_minutes' => $elapsedMinutes,
                'status' => $status, 'late' => (bool) $isLate, 'early' => (bool) $isEarly,
                'corrected' => (bool) $correction,
            ];
        })->values();
    }

    private function periodStats($people, $shifts, $approved, Carbon $start, Carbon $end, Carbon $today): array
    {
        $end = $end->min($today)->copy();
        $result = ['top' => collect(), 'trend' => collect(), 'total' => $people->count()];
        if ($start->gt($end)) return $result;
        $byDay = $this->punches($start, $end->copy()->addDay())->groupBy(fn ($p) => substr($p->punch_at, 0, 10));
        $known = $people->keyBy(fn ($p) => $this->paycode($p->paycode));
        $scores = [];
        foreach ($people as $person) $scores[$person->id] = ['person' => $person, 'present' => 0, 'on_time' => 0, 'late_minutes' => 0, 'missing' => 0];
        $trend = collect();
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $dayPunches = $byDay->get($day->toDateString(), collect())->groupBy(fn ($p) => $this->paycode($p->employee_no));
            $dayCount = 0;
            foreach ($people as $person) {
                $raw = $dayPunches->get($this->paycode($person->paycode), collect());
                $correction = $approved->get($person->id.'|'.$day->toDateString());
                $first = $correction ? substr($correction->first_time, 0, 5) : ($raw->isNotEmpty() ? substr($raw->first()->punch_at, 11, 5) : null);
                if (! $first) continue;
                $dayCount++;
                $scores[$person->id]['present']++;
                [$shiftStart] = $this->shift($person, $shifts);
                if ($first <= $shiftStart) $scores[$person->id]['on_time']++;
                else $scores[$person->id]['late_minutes'] += Carbon::parse($shiftStart)->diffInMinutes(Carbon::parse($first));
                if ($raw->count() < 2 && ! ($correction && $correction->last_time)) $scores[$person->id]['missing']++;
            }
            $trend->push(['day' => $day->format('d M'), 'present' => $dayCount]);
        }
        $top = collect($scores)->filter(fn ($item) => $item['present'] > 0)->sort(function ($a, $b) {
            return ($b['present'] <=> $a['present']) ?: ($b['on_time'] <=> $a['on_time'])
                ?: ($a['late_minutes'] <=> $b['late_minutes']) ?: strcmp($a['person']->name, $b['person']->name);
        })->take(3)->values();
        return ['top' => $top, 'trend' => $trend, 'total' => $known->count()];
    }

    private function calendar($person, $shifts, $approved, Carbon $month, Carbon $today)
    {
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();
        $daily = collect();
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $daily->put($d->toDateString(), ['date' => $d->copy(), 'future' => $d->gt($today)]);
        }
        $raw = $this->punches($start, $end->copy()->addDay())
            ->filter(fn ($p) => $this->paycode($p->employee_no) === $this->paycode($person->paycode))
            ->groupBy(fn ($p) => substr($p->punch_at, 0, 10));
        return $daily->map(function ($item, $key) use ($person, $shifts, $approved, $raw) {
            [$start] = $this->shift($person, $shifts);
            $punches = $raw->get($key, collect())->map(fn ($p) => substr($p->punch_at, 11, 5))->all();
            $correction = $approved->get($person->id.'|'.$key);
            $first = $correction ? substr($correction->first_time, 0, 5) : ($punches[0] ?? null);
            $status = $item['future'] ? 'Future' : (! $first ? 'No punch' : ($first > $start ? 'Late' : 'Present'));
            return $item + ['status' => $status, 'punches' => $punches, 'corrected' => (bool) $correction];
        })->values();
    }

    private function unmatched(Carbon $date, $people)
    {
        if (! $this->isAdmin()) return collect();
        $known = $people->map(fn ($p) => $this->paycode($p->paycode))->flip();
        return $this->punches($date, $date->copy()->addDay())
            ->filter(fn ($p) => ! $known->has($this->paycode($p->employee_no)))
            ->groupBy('employee_no')->map(fn ($items, $no) => ['no' => $no, 'count' => $items->count()])->values();
    }

    private function officeMapData(Carbon $today): array
    {
        $deskIds = [];
        foreach (['IT' => 8, 'SEO' => 6, 'CALL' => 2] as $prefix => $count) {
            for ($i = 1; $i <= $count; $i++) $deskIds[] = sprintf('%s-%02d', $prefix, $i);
        }

        $employees = DB::table('users')->where('status', 'active')
            ->whereIn('allocate_sit_no', $deskIds)->orderBy('id')
            ->get(['id', 'name', 'role', 'paycode', 'allocate_sit_no', 'gender'])
            ->unique('allocate_sit_no')->values();
        $date = $today->toDateString();
        $punches = DB::table('biometric_punches')
            ->where('punch_at', '>=', $date.' 00:00:00')
            ->where('punch_at', '<', $today->copy()->addDay()->toDateString().' 00:00:00')
            ->orderBy('punch_at')->get(['employee_no', 'punch_at']);

        return [
            'date' => $date,
            'users' => $employees->map(fn ($u) => [
                'id' => $u->id, 'name' => $u->name, 'role' => $u->role,
                'paycode' => (string) $u->paycode, 'gender' => (string) ($u->gender ?? ''),
            ])->all(),
            'allocations' => $employees->map(fn ($u) => [
                'desk_id' => $u->allocate_sit_no, 'user_id' => $u->id,
            ])->all(),
            'punches' => $punches->map(fn ($p) => [
                'employee_no' => (string) $p->employee_no, 'punched_at' => $p->punch_at,
            ])->all(),
        ];
    }
}
