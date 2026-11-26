@extends('index')
@push('title', 'Today Meetings')

@push('css')
<style>
    .tm-page { --tm-ink:#13263b; --tm-muted:#66788d; --tm-line:#e5ebf2; --tm-blue:#1677c8; color:var(--tm-ink); }
    .tm-page [hidden] { display:none !important; }
    .tm-hero { background:linear-gradient(112deg,#122b47,#195985); color:white; border-radius:20px; padding:28px 32px; margin-bottom:22px; display:flex; justify-content:space-between; gap:20px; align-items:center; }
    .tm-eyebrow { font-size:11px; letter-spacing:.12em; text-transform:uppercase; opacity:.78; font-weight:700; }
    .tm-hero h2 { font-size:27px; font-weight:750; margin:7px 0 5px; color:#fff; }
    .tm-hero p { margin:0; color:#d4e5f2; font-size:13px; }
    .tm-date { border:1px solid rgba(255,255,255,.28); background:rgba(255,255,255,.1); border-radius:14px; padding:12px 18px; font-weight:650; white-space:nowrap; }
    .tm-metrics { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; margin-bottom:22px; }
    .tm-metric { background:white; border:1px solid var(--tm-line); border-radius:16px; padding:17px 20px; box-shadow:0 6px 22px rgba(17,45,76,.04); }
    .tm-metric span { color:var(--tm-muted); font-size:12px; font-weight:650; }
    .tm-metric strong { display:block; font-size:27px; line-height:1.2; margin-top:5px; }
    .tm-panel { background:#fff; border:1px solid var(--tm-line); border-radius:18px; overflow:hidden; box-shadow:0 10px 30px rgba(17,45,76,.05); }
    .tm-panel-head { padding:20px 22px; border-bottom:1px solid var(--tm-line); display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; }
    .tm-panel-head h3 { font-size:17px; font-weight:750; margin:0; }
    .tm-panel-head small { color:var(--tm-muted); }
    .tm-search { width:min(100%,280px); border:1px solid #dbe4ee; border-radius:10px; padding:10px 13px; outline:none; color:var(--tm-ink); }
    .tm-search:focus { border-color:var(--tm-blue); box-shadow:0 0 0 3px rgba(22,119,200,.12); }
    .tm-row { display:grid; grid-template-columns:125px minmax(0,1fr) auto; gap:20px; padding:20px 22px; align-items:center; border-top:1px solid #f0f3f7; }
    .tm-row:first-child { border-top:0; }
    .tm-time { font-size:19px; font-weight:750; white-space:nowrap; }
    .tm-time small { display:block; font-size:11px; font-weight:600; color:var(--tm-muted); margin-top:3px; }
    .tm-name { font-size:16px; font-weight:750; margin:0 0 7px; overflow-wrap:anywhere; }
    .tm-meta { display:flex; gap:8px 15px; flex-wrap:wrap; color:var(--tm-muted); font-size:12px; }
    .tm-tag { display:inline-flex; align-items:center; padding:4px 9px; background:#edf6fe; border-radius:99px; color:#1264a3; font-size:11px; font-weight:700; }
    .tm-state { display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:750; color:#237750; margin-left:8px; }
    .tm-state.past { color:#7d8897; }
    .tm-actions { display:flex; gap:8px; }
    .tm-action { border:1px solid #d9e4ee; border-radius:9px; padding:8px 11px; font-size:12px; font-weight:700; text-decoration:none; color:#135f9c; white-space:nowrap; }
    .tm-action:hover { background:#edf6fe; color:#0d5186; }
    .tm-empty { padding:62px 20px; text-align:center; }
    .tm-empty-icon { width:58px; height:58px; border-radius:18px; background:#edf6fe; color:#1677c8; display:grid; place-items:center; font-size:24px; margin:0 auto 14px; }
    .tm-empty h4 { font-size:17px; margin:0 0 6px; }
    .tm-empty p { margin:0; color:var(--tm-muted); font-size:13px; }
    @media(max-width:700px) {
        .tm-hero { padding:22px; align-items:flex-start; flex-direction:column; }
        .tm-hero h2 { font-size:23px; }
        .tm-metrics { gap:8px; }
        .tm-metric { padding:13px; }
        .tm-metric strong { font-size:22px; }
        .tm-row { grid-template-columns:1fr; gap:10px; padding:17px; }
        .tm-time small { display:inline; margin-left:6px; }
        .tm-actions { justify-content:flex-start; }
        .tm-panel-head { padding:17px; }
        .tm-search { width:100%; }
    }
</style>
@endpush

@section('content')
@php
    $upcomingCount = $meetings->filter(fn ($meeting) => $meeting['meeting_at']->gte($today))->count();
    $earlierCount = $meetings->count() - $upcomingCount;
@endphp
<div class="tm-page">
    <div class="tm-hero">
        <div>
            <div class="tm-eyebrow">Sales Pipeline · Meeting Schedule</div>
            <h2>Today Meetings</h2>
            <p>Leads and proformas scheduled for today in the Meeting stage.</p>
        </div>
        <div class="tm-date"><i class="bi bi-calendar-event me-2"></i>{{ $today->format('l, d M Y') }} · IST</div>
    </div>

    <div class="tm-metrics">
        <div class="tm-metric"><span>Total today</span><strong>{{ $meetings->count() }}</strong></div>
        <div class="tm-metric"><span>Upcoming</span><strong>{{ $upcomingCount }}</strong></div>
        <div class="tm-metric"><span>Time passed</span><strong>{{ $earlierCount }}</strong></div>
    </div>

    <div class="tm-panel">
        <div class="tm-panel-head">
            <div><h3>Meeting schedule</h3><small>Sorted by scheduled time</small></div>
            @if($meetings->isNotEmpty())
                <input class="tm-search" id="todayMeetingSearch" type="search" placeholder="Search name, phone or salesperson" aria-label="Search today's meetings">
            @endif
        </div>

        @forelse($meetings as $meeting)
            @php
                $phone = preg_replace('/\D+/', '', (string) $meeting['phone']);
                $waPhone = strlen($phone) === 10 ? '91' . $phone : $phone;
                $isPast = $meeting['meeting_at']->lt($today);
            @endphp
            <div class="tm-row" data-meeting-row data-search="{{ mb_strtolower($meeting['name'].' '.$meeting['phone'].' '.$meeting['salesperson'].' '.$meeting['reference']) }}">
                <div class="tm-time">
                    {{ $meeting['meeting_at']->format('h:i A') }}
                    <small>IST</small>
                </div>
                <div>
                    <h4 class="tm-name">{{ $meeting['name'] ?: 'Client' }}</h4>
                    <div class="tm-meta">
                        <span class="tm-tag">{{ $meeting['type'] }}</span>
                        <span>{{ $meeting['reference'] }}</span>
                        <span>Sales: {{ $meeting['salesperson'] }}</span>
                        <span class="tm-state {{ $isPast ? 'past' : '' }}">● {{ $isPast ? 'Time passed' : 'Upcoming' }}</span>
                    </div>
                </div>
                <div class="tm-actions">
                    @if($phone)
                        <a class="tm-action" href="tel:{{ $phone }}"><i class="bi bi-telephone me-1"></i>Call</a>
                        <a class="tm-action" href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a>
                    @else
                        <span class="text-muted small">No phone</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="tm-empty"><div class="tm-empty-icon"><i class="bi bi-calendar2-check"></i></div>
                <h4>No meetings scheduled for today</h4>
                <p>Set a date and time for a record in the Meeting stage of the Sales Pipeline.</p>
            </div>
        @endforelse

        @if($meetings->isNotEmpty())
            <div class="tm-empty" id="todayMeetingNoSearch" hidden><h4>No matching meetings found</h4><p>Try a different search.</p></div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
document.getElementById('todayMeetingSearch')?.addEventListener('input', function () {
    const search = this.value.trim().toLocaleLowerCase();
    let visible = 0;
    document.querySelectorAll('[data-meeting-row]').forEach(row => {
        row.hidden = !row.dataset.search.includes(search);
        if (!row.hidden) visible++;
    });
    document.getElementById('todayMeetingNoSearch').hidden = visible !== 0;
});
</script>
@endpush






