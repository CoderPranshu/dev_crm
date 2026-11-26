<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BiometricAttendanceReportsController extends Controller
{
    private const TZ = 'Asia/Kolkata';
    private const REPORTS = [
        'daily' => 'Daily attendance',
        'monthly' => 'Monthly attendance',
        'absent' => 'Monthly absent',
        'missing' => 'Missing punches',
        'early' => 'Early going',
        'hours' => 'Monthly work hours (punch span)',
        'employee' => 'Employee day by day',
    ];

    public function index(Request $request)
    {
        $context = $this->context($request);
        return view('admin.biometric-attendance.reports', $context + ['reports' => self::REPORTS]);
    }

    public function download(Request $request): StreamedResponse
    {
        $context = $this->context($request);
        $report = $context['report'];
        $filename = 'attendance-'.$context['type'].'-'
            .($context['type'] === 'daily' ? $context['date']->toDateString() : $context['month']->format('Y-m')).'.csv';

        return response()->streamDownload(function () use ($report, $context) {
            $out = fopen('php://output', 'w');
            $safe = static function ($value) {
                $value = (string) ($value ?? '');
                return preg_match('/^[=+\-@\t\r]/u', $value) ? "'".$value : $value;
            };
            if ($context['type'] === 'employee') {
                fputcsv($out, array_merge(['Employee code', 'Name', 'Department', 'Detail'],
                    array_map(fn ($day) => $day->format('d'), $context['days']),
                    ['Present', 'Absent', 'Sunday off', 'Missing', 'Work hours', 'OT after 8h']));
                foreach ($report['blocks'] as $block) {
                    foreach ($block['rows'] as $metric => $cells) {
                        fputcsv($out, array_map($safe, array_merge(
                            [$block['code'], $block['name'], $block['department'], $metric], $cells,
                            [$block['present'], $block['absent'], $block['weekly_off'], $block['missing'], $block['work_hours'], $block['overtime']]
                        )));
                    }
                }
                fclose($out);
                return;
            }
            fputcsv($out, $report['headers']);
            foreach ($report['rows'] as $row) {
                // Names and paycodes can be edited by users; neutralize spreadsheet formulas.
                fputcsv($out, array_map($safe, $row));
            }
            if (isset($report['total'])) {
                $totalRow = array_fill(0, count($report['headers']), '');
                $totalRow[0] = $report['total']['label'];
                $totalRow[count($totalRow) - 1] = $report['total']['value'];
                fputcsv($out, $totalRow);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function context(Request $request): array
    {
        $data = $request->validate([
            'type' => ['nullable', Rule::in(array_keys(self::REPORTS))],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'month' => ['nullable', 'date_format:Y-m'],
            'employee' => ['nullable', 'integer', 'min:1'],
            'department' => ['nullable', Rule::in(['IT', 'SEO', 'CALL'])],
        ]);
        $type = $data['type'] ?? 'daily';
        $today = Carbon::now(self::TZ)->startOfDay();
        $date = isset($data['date']) ? Carbon::createFromFormat('!Y-m-d', $data['date'], self::TZ) : $today->copy();
        $month = isset($data['month']) ? Carbon::createFromFormat('!Y-m', $data['month'], self::TZ)->startOfMonth() : $date->copy()->startOfMonth();
        abort_if($date->gt($today) || $month->gt($today->copy()->startOfMonth()), 422, 'Choose a current or past date.');

        $hasSeat = Schema::hasColumn('users', 'allocate_sit_no');
        $columns = ['id', 'name', 'paycode'];
        if ($hasSeat) $columns[] = 'allocate_sit_no';
        $allPeople = DB::table('users')->where('role', '!=', 'admin')->where('status', 'active')
            ->when(auth()->user()?->role !== 'admin', fn ($q) => $q->where('id', auth()->id()))
            ->orderBy('name')->get($columns);
        $people = $allPeople;
        if (isset($data['employee'])) {
            $people = $people->where('id', (int) $data['employee'])->values();
            abort_if($people->isEmpty(), 404);
        }
        if (isset($data['department'])) {
            $people = $people->filter(fn ($person) => $hasSeat
                && str_starts_with((string) $person->allocate_sit_no, $data['department'].'-'))->values();
        }
        $start = $type === 'daily' ? $date->copy() : $month->copy();
        $end = $type === 'daily' ? $date->copy() : $month->copy()->endOfMonth()->startOfDay();
        $queryEnd = $end->min($today)->copy();

        $shiftRows = DB::table('biometric_attendance_shifts')->whereIn('user_id', $people->pluck('id'))
            ->get(['user_id', 'start_time', 'end_time'])->keyBy('user_id');
        $corrections = DB::table('biometric_attendance_corrections')
            ->where('status', 'approved')->whereIn('user_id', $people->pluck('id'))
            ->whereBetween('attendance_date', [$start->toDateString(), $queryEnd->toDateString()])
            ->orderBy('id')->get(['id', 'user_id', 'attendance_date', 'first_time', 'last_time'])
            ->keyBy(fn ($row) => $row->user_id.'|'.$row->attendance_date);
        $punches = DB::table('biometric_punches')
            ->where('punch_at', '>=', $start->format('Y-m-d H:i:s'))
            ->where('punch_at', '<', $queryEnd->copy()->addDay()->format('Y-m-d H:i:s'))
            ->orderBy('punch_at')->get(['employee_no', 'punch_at'])
            ->groupBy(fn ($row) => substr($row->punch_at, 0, 10).'|'.$this->paycode($row->employee_no));

        $days = [];
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) $days[] = $day->copy();
        $records = [];
        foreach ($people as $person) {
            $shift = $shiftRows->get($person->id);
            $shiftStart = substr((string) ($shift->start_time ?? '11:00'), 0, 5);
            $shiftEnd = substr((string) ($shift->end_time ?? '19:00'), 0, 5);
            foreach ($days as $day) {
                $key = $day->toDateString();
                $raw = $punches->get($key.'|'.$this->paycode($person->paycode), collect());
                $correction = $corrections->get($person->id.'|'.$key);
                $records[$person->id][$key] = $this->record(
                    $day, $today, $raw, $correction, $shiftStart, $shiftEnd
                );
            }
        }

        $report = $this->makeReport($type, $people, $days, $records, $date);
        if ($type === 'employee') $report['blocks'] = $this->employeeBlocks($people, $days, $records);

        return compact('type', 'date', 'month', 'today', 'allPeople', 'people', 'days', 'records', 'hasSeat', 'report');
    }

    private function record(Carbon $day, Carbon $today, $raw, $correction, string $start, string $end): array
    {
        $times = $raw->map(fn ($p) => substr($p->punch_at, 11, 5))->values()->all();
        $first = $correction ? substr($correction->first_time, 0, 5) : ($times[0] ?? null);
        $last = $correction ? ($correction->last_time ? substr($correction->last_time, 0, 5) : null)
            : (count($times) >= 2 ? end($times) : null);
        $startMinutes = $this->minutes($start);
        $endMinutes = $this->minutes($end);
        $late = $first ? max(0, $this->minutes($first) - $startMinutes) : 0;
        $span = $first && $last ? max(0, $this->minutes($last) - $this->minutes($first)) : null;
        $early = $last && ($day->lt($today) || Carbon::now(self::TZ)->format('H:i') >= $end)
            ? max(0, $endMinutes - $this->minutes($last)) : 0;
        $afterEnd = $last ? max(0, $this->minutes($last) - $endMinutes) : 0;
        if ($day->gt($today)) $code = '';
        elseif ($first && ! $last) $code = $day->isSameDay($today)
            && Carbon::now(self::TZ)->format('H:i') < $end ? 'Open' : 'MP';
        elseif ($first) $code = $late && $early ? 'PLTEG' : ($late ? 'PLT' : ($early ? 'PEG' : 'P'));
        elseif ($day->isSunday()) $code = 'WO';
        elseif ($day->isSameDay($today) && Carbon::now(self::TZ)->format('H:i') < $end) $code = 'Pending';
        else $code = 'A';

        return [
            'code' => $code, 'first' => $first, 'last' => $last, 'count' => count($times),
            'times' => $times, 'late' => $late, 'early' => $early,
            'span' => $span, 'after_end' => $afterEnd, 'shift' => $start.'–'.$end,
            'corrected' => (bool) $correction,
        ];
    }

    private function makeReport(string $type, $people, array $days, array $records, Carbon $date): array
    {
        $base = ['Employee code', 'Name', 'Department'];
        $dayHead = array_map(fn ($d) => $d->format('d'), $days);
        $headers = match ($type) {
            'daily' => array_merge($base, ['Shift', 'First punch', 'Last punch', 'Punches', 'Late', 'Early', 'Punch span', 'Status', 'Timeline']),
            'monthly' => array_merge($base, $dayHead, ['Present', 'Absent', 'Weekly off', 'Missing punch']),
            'absent' => array_merge($base, $dayHead, ['Absent days']),
            'missing' => array_merge($base, $dayHead, ['Missing days']),
            'early' => array_merge($base, $dayHead, ['Early total']),
            'hours' => array_merge($base, ['Complete days', 'Punch span total', 'OT', 'Late total', 'Missing days']),
            'employee' => array_merge($base, ['Detail'], $dayHead, ['Present', 'Absent', 'Sunday off', 'Missing', 'Work hours', 'OT after 8h']),
        };
        $rows = [];
        $allAbsent = 0;
        $allEarlyMinutes = 0;
        foreach ($people as $person) {
            $prefix = [$this->paycode($person->paycode), $person->name, $this->department($person)];
            $items = array_map(fn ($day) => $records[$person->id][$day->toDateString()], $days);
            $present = count(array_filter($items, fn ($r) => $r['first'] !== null));
            $absent = count(array_filter($items, fn ($r) => $r['code'] === 'A'));
            $weekly = count(array_filter($items, fn ($r) => $r['code'] === 'WO'));
            $missing = count(array_filter($items, fn ($r) => $r['code'] === 'MP'));
            if ($type === 'daily') {
                $r = $records[$person->id][$date->toDateString()];
                $rows[] = array_merge($prefix, [$r['shift'], $r['first'], $r['last'], $r['count'],
                    $this->duration($r['late']), $this->duration($r['early']), $this->duration($r['span']),
                    $r['code'].($r['corrected'] ? ' *' : ''), implode(' | ', $r['times'])]);
            } elseif ($type === 'monthly') {
                $rows[] = array_merge($prefix, array_map(fn ($r) => $r['code'].($r['corrected'] ? '*' : ''), $items), [$present, $absent, $weekly, $missing]);
            } elseif ($type === 'absent') {
                $rows[] = array_merge($prefix, array_map(fn ($r) => $r['code'] === 'A' ? 'A' : '', $items), [$absent]);
                $allAbsent += $absent;
            } elseif ($type === 'missing') {
                $rows[] = array_merge($prefix, array_map(fn ($r) => $r['code'] === 'MP' ? 'MP' : '', $items), [$missing]);
            } elseif ($type === 'early') {
                $earlyMinutes = array_sum(array_column($items, 'early'));
                $rows[] = array_merge($prefix, array_map(fn ($r) => $r['early'] ? $this->duration($r['early']) : '', $items),
                    [$this->duration($earlyMinutes)]);
                $allEarlyMinutes += $earlyMinutes;
            } elseif ($type === 'hours') {
                $complete = count(array_filter($items, fn ($r) => $r['span'] !== null));
                $span = array_sum(array_filter(array_column($items, 'span'), fn ($n) => $n !== null));
                $rows[] = array_merge($prefix, [$complete, $this->duration($span),
                    $this->duration(array_sum(array_map(static fn ($r) => $r['span'] === null ? 0 : max(0, $r['span'] - 480), $items))),
                    $this->duration(array_sum(array_column($items, 'late'))), $missing]);
            }
        }
        $total = match ($type) {
            'absent' => ['label' => 'Shown employees · absent days', 'value' => $allAbsent],
            'early' => ['label' => 'Shown employees · early total', 'value' => $this->duration($allEarlyMinutes)],
            default => null,
        };
        return ['headers' => $headers, 'rows' => $rows, 'total' => $total,
            'matrix' => in_array($type, ['monthly', 'absent', 'missing', 'early'], true)];
    }

    private function department($person): string
    {
        $seat = (string) ($person->allocate_sit_no ?? '');
        $prefix = strtoupper(explode('-', $seat)[0]);
        return ['IT' => 'IT', 'SEO' => 'SEO', 'CALL' => 'Calling'][$prefix] ?? 'Unassigned';
    }

    private function employeeBlocks($people, array $days, array $records): array
    {
        $blocks = [];
        foreach ($people as $person) {
            $items = array_map(fn ($day) => $records[$person->id][$day->toDateString()], $days);
            $sum = static fn (string $key) => array_sum(array_column($items, $key));
            $overtime = array_sum(array_map(static fn ($r) => $r['span'] === null ? 0 : max(0, $r['span'] - 480), $items));
            $blocks[] = [
                'code' => $this->paycode($person->paycode),
                'name' => $person->name,
                'department' => $this->department($person),
                'present' => count(array_filter($items, static fn ($r) => $r['first'] !== null)),
                'absent' => count(array_filter($items, static fn ($r) => $r['code'] === 'A')),
                'weekly_off' => count(array_filter($items, static fn ($r) => $r['code'] === 'WO')),
                'missing' => count(array_filter($items, static fn ($r) => $r['code'] === 'MP')),
                'work_hours' => $this->duration($sum('span')),
                'overtime' => $this->duration($overtime),
                'shift_full' => array_map(static fn ($r) => $r['code'] === 'WO' ? 'Sunday off' : $r['shift'], $items),
                'rows' => [
                    'Arrived time' => array_map(static fn ($r) => $r['first'] ?? '—', $items),
                    'Depart time' => array_map(static fn ($r) => $r['last'] ?? '—', $items),
                    'Working hours' => array_map(fn ($r) => $r['span'] === null ? '—' : $this->duration($r['span']), $items),
                    'OT after 8h' => array_map(fn ($r) => $r['span'] === null ? '—' : $this->duration(max(0, $r['span'] - 480)), $items),
                    'Status' => array_map(static fn ($r) => $r['code'].($r['corrected'] ? '*' : ''), $items),
                    'Shift' => array_map(fn ($r) => $r['code'] === 'WO' ? 'OFF' : $this->shortShift($r['shift']), $items),
                ],
            ];
        }
        return $blocks;
    }

    private function paycode($value): string
    {
        $value = trim((string) $value);
        return ctype_digit($value) ? str_pad(ltrim($value, '0') ?: '0', 8, '0', STR_PAD_LEFT) : $value;
    }

    private function shortShift(string $shift): string
    {
        [$start, $end] = explode('–', $shift, 2);
        $short = static function (string $time): string {
            [$hour, $minute] = array_map('intval', explode(':', $time));
            $hour = $hour % 12 ?: 12;
            return $minute ? sprintf('%d:%02d', $hour, $minute) : (string) $hour;
        };
        return $short($start).'–'.$short($end);
    }

    private function minutes(string $time): int
    {
        [$hours, $minutes] = array_map('intval', explode(':', $time));
        return $hours * 60 + $minutes;
    }

    private function duration(?int $minutes): string
    {
        return $minutes === null ? '' : sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }
}
