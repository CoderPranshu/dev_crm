<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance | CRM</title>
    <style>
        :root{--bg:#f3f6fc;--ink:#17233c;--muted:#64738c;--line:#e2e8f2;--blue:#304fe4;--good:#087d60;--warn:#ae6700;--bad:#b92b4a}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font:14px/1.5 system-ui,-apple-system,Segoe UI,sans-serif}
        a{color:var(--blue);text-decoration:none}button,input,select,textarea{font:inherit}button,.button{background:var(--blue);color:#fff;border:0;border-radius:9px;padding:10px 15px;cursor:pointer;display:inline-block}
        .ghost{background:#fff;color:var(--blue);border:1px solid #cbd5ef}.shell{max-width:1460px;margin:auto;padding:26px 24px 72px}
        header{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:24px}h1{margin:3px 0 4px;font-size:30px;letter-spacing:-.04em}h2{margin:0;font-size:19px}h3{margin:0 0 8px;font-size:16px}
        .muted,.sub{color:var(--muted)}.sub{font-size:12px}.eyebrow{font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.12em;font-size:11px}
        .card{background:#fff;border:1px solid var(--line);border-radius:15px;box-shadow:0 4px 18px rgba(23,35,60,.04);padding:19px;min-width:0}
        .grid{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));gap:16px;margin-bottom:16px}.span12{grid-column:span 12}.span8{grid-column:span 8}.span6{grid-column:span 6}.span4{grid-column:span 4}.span3{grid-column:span 3}
        .number{font-size:31px;font-weight:750;letter-spacing:-.05em;margin:5px 0}.small{font-size:12px}.flex{display:flex;align-items:center;gap:10px;flex-wrap:wrap}.between{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}
        .pill{display:inline-flex;border-radius:30px;padding:4px 9px;font-size:11px;font-weight:700;background:#edf1ff;color:#304fe4;white-space:nowrap}.pill.good{background:#e8f8f1;color:var(--good)}.pill.warn{background:#fff4df;color:var(--warn)}.pill.bad{background:#ffebef;color:var(--bad)}
        .filters{display:flex;flex-wrap:wrap;gap:10px;align-items:end}.field{display:flex;flex-direction:column;gap:5px;min-width:145px}.field label{font-size:12px;font-weight:650;color:#52617a}
        input,select,textarea{border:1px solid #d6ddec;border-radius:9px;background:#fff;color:var(--ink);padding:9px 11px;min-height:39px;max-width:100%}textarea{min-height:77px}.field input,.field select{width:100%}
        table{border-collapse:collapse;width:100%}th,td{text-align:left;padding:11px 9px;border-bottom:1px solid #edf0f5;vertical-align:middle}th{font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:#6c7890}tr:last-child td{border-bottom:0}.scroll{overflow-x:auto}
        .avatar{width:34px;height:34px;border-radius:50%;background:#e8ecff;color:var(--blue);display:grid;place-items:center;font-weight:750;object-fit:cover;flex:none}.rank{font-size:20px;font-weight:750;color:var(--blue);min-width:30px}
        .leader{padding:11px 0;border-bottom:1px solid var(--line)}.leader:last-child{border:0}.bar{height:7px;background:#edf1fa;border-radius:8px;overflow:hidden;margin-top:6px}.bar>span{display:block;height:100%;background:var(--blue);border-radius:8px}
        .timeline{padding:12px;border-radius:9px;background:#f7f9fe;margin-top:8px;color:#465570}.time{display:inline-block;padding:5px 9px;background:#e8eeff;border-radius:7px;margin:3px;font-weight:700}
        .calendar{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:6px}.day{min-height:74px;border:1px solid var(--line);padding:8px;border-radius:9px}.day b{display:block}.day .sub{font-size:11px}.day.future{opacity:.45}.day.late{background:#fff6e8}.day.present{background:#eaf8f3}.day.no-punch{background:#fff0f2}
        .notice{background:#edf7ff;border-left:4px solid var(--blue);border-radius:8px;padding:10px 13px;margin:13px 0}.error{background:#fff0f2;border-color:var(--bad)}
        details summary{cursor:pointer;color:var(--blue);font-weight:650}.formline{display:flex;gap:10px;flex-wrap:wrap;align-items:end}.formline .field{flex:1;min-width:130px}.sectionhead{margin:7px 0 14px}
        nav{display:flex;gap:8px;flex-wrap:wrap;margin:0 0 18px}nav a{background:#fff;border:1px solid var(--line);border-radius:18px;padding:6px 11px;color:#465570;font-weight:600}
        @media(max-width:1020px){.span8,.span6,.span4{grid-column:span 12}.span3{grid-column:span 6}}
        @media(max-width:630px){.shell{padding:17px 12px 55px}h1{font-size:25px}.span3{grid-column:span 12}.calendar{gap:3px}.day{min-height:55px;padding:5px}.day .sub{font-size:9px}header{display:block}}
    </style>
</head>
<body>
<div class="shell">
    <header>
        <div><div class="eyebrow">People / Biometric</div><h1>Attendance command center</h1><div class="muted">Machine punches, daily review and team performance · {{ $date->format('d M Y') }}</div></div>
        <div class="flex"><a class="button ghost" href="{{ route('admin.dashboard') }}">← Dashboard</a><a class="button ghost" href="{{ route('admin.attendance.export', ['date'=>$date->toDateString()]) }}">Daily CSV</a><a class="button" href="{{ route('admin.attendance.export', ['month'=>$month->format('Y-m')]) }}">Monthly CSV</a></div>
    </header>

    @if(session('message'))<div class="notice">{{ session('message') }}</div>@endif
    @if($errors->any())<div class="notice error">{{ $errors->first() }}</div>@endif
    <nav><a href="#today">Today</a><a href="#leaders">Top 3</a><a href="#daily">Daily attendance</a><a href="#calendar">Employee calendar</a><a href="#exceptions">Exceptions</a><a href="#requests">Corrections</a></nav>

    <section class="card sectionhead">
        <form class="filters" method="get" action="{{ route('admin.attendance') }}">
            <div class="field"><label for="date">Daily date</label><input id="date" type="date" name="date" value="{{ $date->toDateString() }}"></div>
            <div class="field"><label for="month">Calendar / monthly rank</label><input id="month" type="month" name="month" value="{{ $month->format('Y-m') }}"></div>
            <div class="field"><label for="employee">Employee calendar</label><select id="employee" name="employee"><option value="">All employees</option>@foreach($people as $p)<option value="{{ $p->id }}" @selected((string)request('employee')===(string)$p->id)>{{ $p->name }} · {{ $p->paycode }}</option>@endforeach</select></div>
            <div class="field"><label for="search">Search daily rows</label><input id="search" name="search" value="{{ request('search') }}" placeholder="Name or paycode"></div>
            <button type="submit">Apply filters</button><a class="button ghost" href="{{ route('admin.attendance') }}">Reset</a>
        </form>
    </section>

    @php
        $punched = $daily->filter(fn($r) => (bool) $r['first'])->count();
        $late = $daily->where('late',true)->count();
        $single = $daily->filter(fn($r) => in_array($r['status'],['Open / one punch','Missing last punch']))->count();
        $none = $daily->filter(fn($r) => ! $r['first'])->count();
        $lastPunch = $daily->flatMap(fn($r) => $r['punches'])->sort()->last();
    @endphp
    <section id="today" class="grid">
        <div class="card span3"><div class="muted">Employees with attendance</div><div class="number">{{ $punched }}</div><div class="sub">{{ $date->format('d M') }} · {{ $daily->count() }} visible employees; includes approved corrections</div></div>
        <div class="card span3"><div class="muted">Late first punches</div><div class="number">{{ $late }}</div><div class="sub">Compared with employee shift</div></div>
        <div class="card span3"><div class="muted">Single / open punch</div><div class="number">{{ $single }}</div><div class="sub">Review after shift ends</div></div>
        <div class="card span3"><div class="muted">No attendance yet</div><div class="number">{{ $none }}</div><div class="sub">{{ $date->isSameDay($today) ? 'Not marked absent while shift is open' : 'Review off days and leaves before marking absent' }}</div></div>
    </section>

    <section id="leaders" class="grid">
        @foreach([['This week · Top 3',$week],[$month->format('F Y').' · Top 3',$monthStats]] as [$title,$ranking])
            <div class="card span6"><div class="between"><h2>{{ $title }}</h2><span class="sub">Present days → on-time days → fewer late minutes</span></div>
                @forelse($ranking['top'] as $item)
                    <div class="leader flex"><div class="rank">#{{ $loop->iteration }}</div>
                        @if($item['person']->avatar_url)<img class="avatar" src="{{ $item['person']->avatar_url }}" alt="">@else<div class="avatar">{{ mb_strtoupper(mb_substr($item['person']->name,0,1)) }}</div>@endif
                        <div style="flex:1;min-width:100px"><b>{{ $item['person']->name }}</b><div class="sub">{{ $item['person']->paycode }}</div></div>
                        <div style="text-align:right"><strong>{{ $item['present'] }} days</strong><div class="sub">{{ $item['on_time'] }} on time · {{ $item['missing'] }} incomplete</div></div>
                    </div>
                @empty <p class="muted">No attendance in this period.</p> @endforelse
                <div class="sub" style="margin-top:8px">Ranking uses available punch days; leave and weekly-off policy is not connected yet.</div>
            </div>
        @endforeach
    </section>

    <section class="grid"><div class="card span8"><div class="between"><h2>Monthly attendance trend</h2><span class="sub">Employees with at least one punch</span></div>
        @php $maxTrend = max(1, $monthStats['trend']->max('present') ?: 1); @endphp
        <div style="max-height:250px;overflow:auto;margin-top:12px">
        @foreach($monthStats['trend'] as $point)<div class="flex" style="margin:7px 0"><span class="sub" style="width:45px">{{ $point['day'] }}</span><div class="bar" style="flex:1;margin:0"><span style="width:{{ round($point['present']/$maxTrend*100) }}%"></span></div><strong style="min-width:25px;text-align:right">{{ $point['present'] }}</strong></div>@endforeach
        </div></div>
        <div class="card span4"><h2>Device data received</h2><div class="number" style="font-size:22px">{{ $lastReceived ? \Carbon\Carbon::parse($lastReceived)->format('d M, h:i A') : 'No data' }}</div><div class="sub">Last database punch update, including repeated punches. This is not a Windows collector health check.</div><hr style="border:0;border-top:1px solid var(--line);margin:17px 0"><div class="muted">Latest punch on selected day</div><strong>{{ $lastPunch ?: 'No punch' }}</strong><div class="sub">Default shift 11:00–19:00 · personal overrides supported</div></div>
    </section>

    <section id="daily" class="card sectionhead"><div class="between"><div><h2>Daily attendance</h2><div class="sub">Click “Punch timeline” to see every raw device event. Approved corrections have a separate marker.</div></div><span class="pill">{{ $date->format('l, d M Y') }}</span></div>
        <div class="scroll"><table><thead><tr><th>Employee</th><th>Paycode</th><th>Shift</th><th>First punch</th><th>Last punch</th><th>Punches</th><th>Review</th><th>Detail</th></tr></thead><tbody>
        @forelse($daily as $r)<tr><td><div class="flex">@if($r['avatar'])<img class="avatar" src="{{ $r['avatar'] }}" alt="">@else<div class="avatar">{{ mb_strtoupper(mb_substr($r['name'],0,1)) }}</div>@endif<strong>{{ $r['name'] }}</strong></div></td>
            <td>{{ $r['paycode'] }}</td><td>{{ $r['shift'] }}</td><td><strong>{{ $r['first'] ?: '—' }}</strong></td><td><strong>{{ $r['last'] ?: '—' }}</strong></td><td>{{ $r['count'] }}</td>
            <td><span class="pill {{ ($r['late'] || $r['early']) ? 'warn' : (in_array($r['status'],['Missing last punch','No punch']) ? 'bad' : 'good') }}">{{ $r['status'] }}</span>@if($r['corrected'])<div class="sub">Approved correction</div>@endif</td>
            <td><details><summary>Punch timeline</summary><div class="timeline">@forelse($r['punches'] as $time)<span class="time">{{ $time }}</span>@empty No machine punch on this date. @endforelse</div></details></td>
        </tr>@empty<tr><td colspan="8" class="muted">No matching employee.</td></tr>@endforelse
        </tbody></table></div>
    </section>

    <section id="calendar" class="card sectionhead"><div class="between"><div><h2>Employee calendar · {{ $month->format('F Y') }}</h2><div class="sub">Choose an employee in filters to inspect a month. Blue-free dates require leave/off-day review.</div></div><span class="pill">{{ $calendarPerson?->name ?? 'No employee' }}</span></div>
        @if($calendarPerson)
            <div class="calendar" style="margin-top:15px">@foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $weekday)<div class="sub" style="text-align:center;font-weight:700">{{ $weekday }}</div>@endforeach
            @for($gap=1;$gap<$month->copy()->startOfMonth()->dayOfWeekIso;$gap++)<div></div>@endfor
            @foreach($calendar as $day)<div class="day {{ strtolower(str_replace(' ','-',$day['status'])) }} {{ $day['future']?'future':'' }}"><b>{{ $day['date']->day }}</b><span class="sub">{{ $day['status'] }}</span>@if(count($day['punches']))<div class="sub">{{ implode(', ',$day['punches']) }}</div>@endif @if($day['corrected'])<span class="sub">✓ corrected</span>@endif</div>@endforeach
            </div>
        @else <p class="muted">No matched active employee found.</p> @endif
    </section>

    <section id="exceptions" class="grid"><div class="card span6"><h2>Needs review</h2><div class="sub">Single punch and late/early events for selected date.</div>
        @php $issues=$daily->filter(fn($r)=>$r['late'] || $r['early'] || in_array($r['status'],['Missing last punch','Open / one punch'])); @endphp
        <div class="scroll"><table><thead><tr><th>Employee</th><th>Issue</th><th>First / last</th></tr></thead><tbody>@forelse($issues as $r)<tr><td>{{ $r['name'] }}</td><td>{{ $r['status'] }}</td><td>{{ $r['first'] ?: '—' }} / {{ $r['last'] ?: '—' }}</td></tr>@empty<tr><td colspan="3" class="muted">Nothing flagged.</td></tr>@endforelse</tbody></table></div></div>
        <div class="card span6"><h2>Unmatched machine IDs</h2><div class="sub">Add the 8-digit machine number to users.paycode to link employee names.</div>
            <div class="scroll"><table><thead><tr><th>Machine employee no.</th><th>Punches on selected date</th></tr></thead><tbody>@forelse($unmatched as $r)<tr><td>{{ $r['no'] }}</td><td>{{ $r['count'] }}</td></tr>@empty<tr><td colspan="2" class="muted">No unmatched IDs.</td></tr>@endforelse</tbody></table></div></div>
    </section>

    <section id="requests" class="grid"><div class="card span6"><h2>Request a correction</h2><p class="sub">Requests do not edit the machine log. After approval, the requested first/last times are shown in daily reports.</p>
        <form method="post" action="{{ route('admin.attendance.corrections.store') }}">@csrf
            <div class="formline">@if($isAdmin)<div class="field"><label>Employee</label><select name="user_id" required>@foreach($people as $p)<option value="{{ $p->id }}">{{ $p->name }} · {{ $p->paycode }}</option>@endforeach</select></div>@endif
                <div class="field"><label>Date</label><input type="date" name="attendance_date" value="{{ $date->toDateString() }}" max="{{ $today->toDateString() }}" required></div>
                <div class="field"><label>First time</label><input type="time" name="first_time" required></div>
                <div class="field"><label>Last time (optional)</label><input type="time" name="last_time"></div></div>
            <div class="field" style="margin:12px 0"><label>Reason</label><textarea name="reason" required minlength="5" maxlength="1000" placeholder="Explain the missing or incorrect punch"></textarea></div><button>Submit request</button>
        </form></div>
        <div class="card span6"><h2>Recent correction requests</h2><div class="scroll"><table><thead><tr><th>Employee</th><th>Date</th><th>Requested</th><th>Status / action</th></tr></thead><tbody>
            @forelse($requests as $req)<tr><td>{{ $req->employee_name }}<div class="sub">{{ $req->reason }}</div></td><td>{{ $req->attendance_date }}</td><td>{{ substr($req->first_time,0,5) }} / {{ $req->last_time ? substr($req->last_time,0,5) : '—' }}</td>
                <td><span class="pill">{{ ucfirst($req->status) }}</span>@if($isAdmin && $req->status==='pending')<div class="flex" style="margin-top:6px">@foreach(['approved'=>'Approve','rejected'=>'Reject'] as $state=>$label)<form method="post" action="{{ route('admin.attendance.corrections.review',$req->id) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $state }}"><button class="ghost" style="padding:5px 8px">{{ $label }}</button></form>@endforeach</div>@endif</td></tr>
            @empty<tr><td colspan="4" class="muted">No requests yet.</td></tr>@endforelse
        </tbody></table></div></div>
    </section>

    @if($isAdmin)<section class="card"><h2>Individual shift override</h2><p class="sub">Everyone uses 11:00–19:00 unless you save a different shift here. Overnight shifts are not supported in this version.</p>
        <form class="formline" method="post" action="{{ route('admin.attendance.shifts') }}">@csrf
            <div class="field"><label>Employee</label><select name="user_id" required>@foreach($people as $p)<option value="{{ $p->id }}">{{ $p->name }} · {{ $p->paycode }}</option>@endforeach</select></div>
            <div class="field"><label>Start</label><input type="time" name="start_time" value="11:00" required></div><div class="field"><label>End</label><input type="time" name="end_time" value="19:00" required></div><button>Save shift</button>
        </form></section>@endif
    <p class="sub" style="margin-top:18px">No-punch is not automatically an absence. Working span is not payable hours; breaks, holidays, weekly offs and approved leave need policy data before payroll or fair percentage rankings.</p>
</div>
</body>
</html>
