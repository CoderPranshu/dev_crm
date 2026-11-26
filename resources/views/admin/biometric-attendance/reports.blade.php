<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $reports[$type] }} | Attendance reports</title>
    <style>
        :root{--ink:#263b47;--muted:#718c98;--line:#dcebf0;--teal:#197a83;--bg:#f3fafb}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font:14px/1.5 system-ui,-apple-system,Segoe UI,sans-serif}
        a{color:var(--teal);text-decoration:none}.shell{width:100%;padding:24px clamp(12px,2vw,32px) 54px}
        header{display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap;margin-bottom:19px}
        header img{width:175px;height:auto;max-width:100%}h1{font-size:28px;margin:0}h2{font-size:19px;margin:0 0 12px}
        .muted{color:var(--muted)}.card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:18px;margin-bottom:16px;box-shadow:0 4px 18px #197a830a}
        .button,button{display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--teal);border-radius:8px;background:var(--teal);color:#fff;font:inherit;font-weight:700;padding:8px 13px;cursor:pointer}
        .button.ghost{background:#fff;color:var(--teal)}.actions{display:flex;gap:8px;flex-wrap:wrap}
        .tabs{display:flex;gap:8px;flex-wrap:wrap;margin:0 0 16px}.tabs a{padding:8px 12px;background:#fff;border:1px solid var(--line);border-radius:8px;font-weight:650}.tabs a.active{background:var(--teal);border-color:var(--teal);color:#fff}
        .filters{display:flex;gap:12px;align-items:end;flex-wrap:wrap}.field{display:flex;flex-direction:column;gap:5px;min-width:155px}.field label{font-size:12px;font-weight:700;color:#546b76}
        input,select{min-height:39px;background:#fff;border:1px solid #cde1e6;border-radius:8px;padding:8px;color:var(--ink);font:inherit}
        .help{font-size:12px;color:#587783;margin:8px 0 0}.key{display:flex;flex-wrap:wrap;gap:6px 14px}.key span{white-space:nowrap}
        .table-wrap{width:100%;overflow:auto;border:1px solid var(--line);border-radius:10px}table{border-collapse:separate;border-spacing:0;width:100%;min-width:960px}
        th,td{text-align:left;border-right:1px solid #e7eff2;border-bottom:1px solid #e7eff2;padding:8px 9px;white-space:nowrap;vertical-align:top}
        th:last-child,td:last-child{border-right:0}tr:last-child td{border-bottom:0}thead th{background:#eaf6f7;color:#245964;font-size:11px;position:sticky;top:0;z-index:2}
        tbody tr:hover{background:#f5fbfb}td:nth-child(2){font-weight:650}.matrix th,.matrix td{font-size:11px;text-align:center;padding:7px 5px;min-width:35px}
        .matrix th:nth-child(-n+3),.matrix td:nth-child(-n+3){text-align:left;min-width:120px}.matrix td:nth-child(2){min-width:155px}
        .employee-block{border:1px solid var(--line);border-radius:10px;margin:16px 0 22px;overflow:hidden;background:white}.employee-summary{display:flex;align-items:center;gap:20px;flex-wrap:wrap;padding:13px 15px;background:#f4fafb;border-bottom:1px solid var(--line)}.employee-name{min-width:190px;flex:1}.employee-name strong{display:block;font-size:16px}.employee-stats{display:flex;gap:14px 20px;flex-wrap:wrap}.employee-stats span{font-size:11px;color:var(--muted)}.employee-stats b{display:block;font-size:13px;color:var(--ink)}.employee-grid{overflow-x:auto}.employee-grid table{table-layout:fixed;min-width:2010px;width:max(100%,2010px)}.employee-grid th,.employee-grid td{text-align:center;font-size:11px;padding:6px 4px;min-width:37px;white-space:nowrap}.employee-grid th:first-child,.employee-grid td:first-child{position:sticky;left:0;z-index:1;min-width:118px;width:118px;text-align:left;background:#f7fbfc;font-weight:700}.employee-grid thead th:first-child{z-index:3}.employee-grid tr:hover td:first-child{background:#eaf6f7}.report-note{font-size:12px;color:var(--muted);margin:0 0 14px}
        td[data-status="A"]{background:#fff0f2;color:#ad3550;font-weight:800}td[data-status="MP"]{background:#fff2e5;color:#a46518;font-weight:800}
        td[data-status="WO"]{background:#edf3f6;color:#5c7581}td[data-status="H"]{background:#f1edff;color:#6546a1;font-weight:800}td[data-status="HW"]{background:#e7f7ef;color:#0d7456;font-weight:800}td[data-status="P"]{background:#e7f7ef;color:#0d7456;font-weight:700}
        td[data-status="PLT"],td[data-status="PEG"],td[data-status="PLTEG"]{background:#fff8e9;color:#936314;font-weight:750}
        .empty{padding:30px;text-align:center;color:var(--muted)}
        .report-heading{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}.report-total{display:flex;align-items:center;gap:12px;border:1px solid #b9dfe1;background:#eaf7f7;border-radius:10px;padding:8px 14px;color:#245964;font-weight:700}.report-total strong{font-size:20px;color:#116b75}
        @media(max-width:700px){h1{font-size:22px}.shell{padding:14px 10px 35px}.card{padding:12px}.field{flex:1;min-width:125px}}
        @media print{body{background:white;font:10px/1.3 Arial,sans-serif}.shell{padding:0}.card{box-shadow:none;border:0;padding:0}.controls,.actions,.tabs,.filters,.help{display:none!important}.table-wrap,.employee-grid{overflow:visible;border:0}table,.employee-grid table{min-width:0;width:100%}th,td,.matrix th,.matrix td,.employee-grid th,.employee-grid td{padding:3px 2px;font-size:7px;white-space:normal;min-width:0}thead th{position:static}.employee-grid th:first-child,.employee-grid td:first-child{position:static;min-width:0;width:auto}thead{display:table-header-group}tr,.employee-block{page-break-inside:avoid}@page{size:landscape;margin:8mm}}
    </style>
</head>
<body>
<div class="shell">
    <header>
        <div><img src="{{ asset('uploads/code-sparrow-logo.png') }}" alt="CodeSparrow"><h1>Attendance reports</h1><div class="muted">{{ $reports[$type] }} · {{ $type === 'daily' ? $date->format('d M Y') : $month->format('F Y') }}</div></div>
        <div class="actions controls"><a class="button ghost" href="{{ route('admin.attendance') }}">← Attendance page</a><a class="button" href="{{ route('admin.attendance.reports.download', request()->only('type','date','month','employee','department')) }}">Download CSV</a><button type="button" class="button ghost" onclick="window.print()">Print</button></div>
    </header>

    <section class="card controls">
        <form class="filters" method="get" action="{{ route('admin.attendance.reports') }}">
            <div class="field"><label for="type">Report</label><select id="type" name="type">@foreach($reports as $key=>$label)<option value="{{ $key }}" @selected($type === $key)>{{ $label }}</option>@endforeach</select></div>
            <div class="field"><label for="date">Daily report date</label><input id="date" type="date" name="date" value="{{ $date->toDateString() }}" max="{{ $today->toDateString() }}"></div>
            <div class="field"><label for="month">Monthly report month</label><input id="month" type="month" name="month" value="{{ $month->format('Y-m') }}" max="{{ $today->format('Y-m') }}"></div>
            <div class="field"><label for="employee">Employee</label><select id="employee" name="employee"><option value="">All employees</option>@foreach($allPeople as $person)<option value="{{ $person->id }}" @selected((string) request('employee') === (string) $person->id)>{{ $person->name }} · {{ $person->paycode }}</option>@endforeach</select></div>
            @if($hasSeat)<div class="field"><label for="department">Department</label><select id="department" name="department"><option value="">All departments</option>@foreach(['IT'=>'IT', 'SEO'=>'SEO', 'CALL'=>'Calling'] as $code=>$name)<option value="{{ $code }}" @selected(request('department') === $code)>{{ $name }}</option>@endforeach</select></div>@endif
            <button type="submit">Show report</button>
        </form>
    </section>

    <section class="card">
        <div class="report-heading"><h2>{{ $reports[$type] }}</h2>@if($report['total'] ?? null)<div class="report-total"><span>{{ $report['total']['label'] }}</span><strong>{{ $report['total']['value'] }}</strong></div>@endif</div>
        <div class="help key"><span><b>P</b> punch pair</span><span><b>PLT</b> late</span><span><b>PEG</b> early exit</span><span><b>PLTEG</b> late + early</span><span><b>MP</b> single punch</span><span><b>A</b> no punch</span><span><b>WO</b> Sunday off</span><span><b>H</b> office holiday</span><span><b>HW</b> worked on holiday</span><span><b>*</b> approved correction</span></div>
        @if($holidays->isNotEmpty())<p class="help">Office holidays: @foreach($holidays as $holiday){{ \Carbon\Carbon::parse($holiday->holiday_date)->format('d M') }} · {{ $holiday->name }}{{ $loop->last ? '' : ' | ' }}@endforeach</p>@endif
        <p class="help">Work hours are first-to-last punch span, including breaks. OT is span above 8 hours when both punches exist. Today remains pending until the shift ends.</p>
        @if($type === 'employee' && count($report['blocks'] ?? []))
            <p class="report-note">Har employee ka summary aur poore month ki 6 rows. Dates dekhne ke liye table horizontal scroll karein.</p>
            @foreach($report['blocks'] as $block)
                <section class="employee-block" aria-label="{{ $block['name'] }} attendance">
                    <div class="employee-summary"><div class="employee-name"><strong>{{ $block['name'] }}</strong><span class="muted">{{ $block['code'] }} · {{ $block['department'] }}</span></div>
                        <div class="employee-stats"><div><span>Present</span><b>{{ $block['present'] }}</b></div><div><span>Absent</span><b>{{ $block['absent'] }}</b></div><div><span>Sunday off</span><b>{{ $block['weekly_off'] }}</b></div><div><span>Missing</span><b>{{ $block['missing'] }}</b></div><div><span>Work hours</span><b>{{ $block['work_hours'] }}</b></div><div><span>OT after 8h</span><b>{{ $block['overtime'] }}</b></div></div>
                    </div>
                    <div class="employee-grid"><table><thead><tr><th>Detail / date</th>@foreach($days as $day)<th>{{ $day->format('d') }}</th>@endforeach</tr></thead><tbody>
                        @foreach($block['rows'] as $metric=>$cells)<tr><td>{{ $metric }}</td>@foreach($cells as $cell)@php($statusCell = rtrim((string) $cell, ' *'))<td @if($metric === 'Status' && in_array($statusCell, ['A','MP','WO','H','HW','P','PLT','PEG','PLTEG'], true)) data-status="{{ $statusCell }}" @endif @if($metric === 'Shift') title="{{ $block['shift_full'][$loop->index] }}" @endif>{{ $cell }}</td>@endforeach</tr>@endforeach
                    </tbody></table></div>
                </section>
            @endforeach
        @elseif(count($report['rows']))
            <div class="table-wrap"><table class="{{ $report['matrix'] ? 'matrix' : '' }}">
                <thead><tr>@foreach($report['headers'] as $heading)<th scope="col">{{ $heading }}</th>@endforeach</tr></thead>
                <tbody>
                @foreach($report['rows'] as $row)
                    <tr>@foreach($row as $cell)@php($statusCell = rtrim((string) $cell, ' *'))<td @if(in_array($statusCell, ['A','MP','WO','H','HW','P','PLT','PEG','PLTEG'], true)) data-status="{{ $statusCell }}" @endif>{{ $cell }}</td>@endforeach</tr>
                @endforeach
                </tbody>
            </table></div>
        @else
            <div class="empty">Is filter mein koi employee nahi mila.</div>
        @endif
        <p class="help">{{ $type === 'employee' ? count($report['blocks']) . ' employees' : count($report['rows']) . ' rows' }} · Machine ID is matched to users.paycode with leading zeros normalized.</p>
    </section>
</div>
</body>
</html>
