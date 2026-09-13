@php
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    $month = request('month', now()->month);
    $year = request('year', now()->year);

    $kpis = App\Models\Kpi::where('department_id', $user->department)->get();

    // current month points
    $currentPoints = DB::table('kpi_user')
        ->where('user_id', $user->id)
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->pluck('points', 'kpi_id');

    // previous month points
    $previousPoints = DB::table('kpi_user')
        ->where('user_id', $user->id)
        ->where(function ($q) use ($year, $month) {
            $q->whereYear('created_at', '<', $year)->orWhere(function ($q2) use ($year, $month) {
                $q2->whereYear('created_at', $year)->whereMonth('created_at', '<', $month);
            });
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('kpi_id')
        ->map(fn($rows) => $rows->first()->points);
@endphp

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.employee.kpi.export', [
        'user_id' => $user->id,
        'month' => $month,
        'year' => $year,
    ]) }}"
        class="btn btn-sm btn-success">
        Export CSV
    </a>
</div>

<form method="GET" action="">
    <div class="row mb-3">
        <div class="col-md-3">
            <label class="eForm-label">Month</label>
            <select name="month" class="form-control eForm-control" onchange="this.form.submit()">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="eForm-label">Year</label>
            <select name="year" class="form-control eForm-control" onchange="this.form.submit()">
                @foreach (range(now()->year - 5, now()->year) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>


<form action="{{ route('admin.employee.kpi.store') }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <input type="hidden" name="month" value="{{ $month }}">
    <input type="hidden" name="year" value="{{ $year }}">

    <table class="table">
        <thead>
            <tr>
                <th class="eForm-label">#</th>
                <th class="eForm-label">KPI</th>
                <th class="eForm-label">Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kpis as $kpi)
                <tr class="eForm-label">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kpi->title }}</td>
                    <td>
                        @php
                            $hasCurrent = isset($currentPoints[$kpi->id]);
                            $value = $hasCurrent ? $currentPoints[$kpi->id] : $previousPoints[$kpi->id] ?? '';
                        @endphp

                        <input type="number" name="points[{{ $kpi->id }}]" class="eForm-control form-control"
                            min="0" placeholder="Enter points" value="{{ $value }}"
                            {{ $hasCurrent ? 'readonly' : '' }}>

                        @if ($hasCurrent)
                            <small class="text-muted">Locked (already submitted)</small>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn-form">
        Save KPI Points
    </button>
</form>
