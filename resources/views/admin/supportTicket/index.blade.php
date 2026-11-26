@extends('index')
@push('title', get_phrase('Support Tickets'))

@push('css')
<style>
    /* Scoped to this page: no framework overrides or additional CSS libraries. */
    #support-workspace {
        --sp-ink: #172b45; --sp-muted: #607089; --sp-line: #e4eaf2;
        --sp-blue: #2459d3; --sp-soft: #eef4ff; --sp-bg: #f5f7fb;
        color: var(--sp-ink); background: var(--sp-bg); border-radius: 22px;
        /* padding: clamp(16px, 2.5vw, 32px); */
        margin: 18px 0;
        min-width: 0;
        font-size: 14px; line-height: 1.5;
    }
    #support-workspace *, #support-workspace *::before, #support-workspace *::after { box-sizing: border-box; }
    #support-workspace [hidden] { display: none !important; }
    #support-workspace a { text-decoration: none; }
    #support-workspace button, #support-workspace input, #support-workspace select { font: inherit; }
    #support-workspace button { cursor: pointer; }
    #support-workspace :is(button, a, input, select):focus-visible { outline: 3px solid #729cff; outline-offset: 3px; }
    #support-workspace .sp-breadcrumb { display: flex; flex-wrap: wrap; gap: 10px; color: var(--sp-muted); font-size: 12px; margin-bottom: 26px; }
    #support-workspace .sp-breadcrumb a { color: var(--sp-muted); }
    #support-workspace .sp-breadcrumb [aria-current] { color: var(--sp-ink); }
    #support-workspace .sp-heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 26px; }
    #support-workspace .sp-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: .14em; color: var(--sp-blue); margin: 0 0 6px; }
    #support-workspace h1 { font-size: clamp(25px, 3vw, 34px); font-weight: 700; letter-spacing: -.035em; line-height: 1.2; margin: 0 0 8px; color: var(--sp-ink); }
    #support-workspace .sp-description { margin: 0; color: var(--sp-muted); }
    #support-workspace .sp-button { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 42px; padding: 10px 16px; border-radius: 10px; border: 1px solid var(--sp-line); background: #fff; color: var(--sp-ink); font-weight: 600; white-space: nowrap; }
    #support-workspace .sp-button:hover { background: #f0f4fa; }
    #support-workspace .sp-primary { background: var(--sp-blue); border-color: var(--sp-blue); color: #fff; box-shadow: 0 4px 10px #2459d322; }
    #support-workspace .sp-primary:hover { background: #1949b8; color: #fff; }
    #support-workspace .sp-button:disabled { opacity: .45; cursor: not-allowed; }
    #support-workspace .sp-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
    #support-workspace .sp-stat { border: 1px solid var(--sp-line); background: #fff; border-radius: 15px; padding: 20px; position: relative; overflow: hidden; }
    #support-workspace .sp-stat-label { color: var(--sp-muted); font-size: 12px; font-weight: 600; padding-right: 40px; }
    #support-workspace .sp-stat-value { font-size: 30px; font-weight: 700; letter-spacing: -.04em; line-height: 1.3; margin: 9px 0 5px; }
    #support-workspace .sp-stat-note { font-size: 11px; color: var(--sp-muted); }
    #support-workspace .sp-stat-icon { position: absolute; right: 18px; top: 18px; width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center; background: #eef3ff; color: #2459d3; font-size: 17px; }
    #support-workspace .sp-stat-icon.sp-amber { background: #fff5df; color: #946000; }
    #support-workspace .sp-stat-icon.sp-green { background: #e7f6ef; color: #15734b; }
    #support-workspace .sp-panel { background: #fff; border: 1px solid var(--sp-line); border-radius: 16px; overflow: hidden; box-shadow: 0 6px 24px #1b365305; }
    #support-workspace .sp-panel-head { display: flex; justify-content: space-between; align-items: center; gap: 18px; padding: 22px 24px 18px; }
    #support-workspace h2 { color: var(--sp-ink); font-size: 17px; font-weight: 700; margin: 0 0 4px; letter-spacing: -.02em; }
    #support-workspace .sp-small { font-size: 12px; color: var(--sp-muted); margin: 0; }
    #support-workspace .sp-total-pill { background: var(--sp-soft); border-radius: 20px; padding: 5px 11px; font-size: 12px; color: #2459d3; font-weight: 600; white-space: nowrap; }
    #support-workspace .sp-tabs { display: flex; gap: 6px; overflow-x: auto; padding: 0 24px; border-bottom: 1px solid var(--sp-line); }
    #support-workspace .sp-tab { display: inline-flex; align-items: center; gap: 8px; min-height: 48px; padding: 12px 14px; border: 0; border-bottom: 3px solid transparent; background: transparent; font-size: 13px; font-weight: 600; color: var(--sp-muted); white-space: nowrap; }
    #support-workspace .sp-tab[aria-pressed="true"] { color: var(--sp-blue); border-bottom-color: var(--sp-blue); }
    #support-workspace .sp-tab span { font-size: 10px; background: #eef1f6; border-radius: 6px; padding: 2px 6px; color: var(--sp-muted); }
    #support-workspace .sp-tab[aria-pressed="true"] span { color: var(--sp-blue); background: var(--sp-soft); }
    #support-workspace .sp-toolbar { display: flex; align-items: flex-end; flex-wrap: wrap; gap: 12px; padding: 18px 24px; }
    #support-workspace .sp-field { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
    #support-workspace .sp-field label { font-size: 11px; font-weight: 600; margin: 0; color: var(--sp-muted); }
    #support-workspace .sp-search { flex: 1 1 280px; }
    #support-workspace .sp-search-wrap { position: relative; }
    #support-workspace .sp-search-wrap i { position: absolute; left: 13px; top: 12px; color: var(--sp-muted); pointer-events: none; }
    #support-workspace .sp-input { display: block; width: 100%; min-height: 42px; padding: 9px 12px; border: 1px solid #d8e1ee; background: #fff; color: var(--sp-ink); border-radius: 9px; font-size: 13px; }
    #support-workspace .sp-search .sp-input { padding-left: 36px; }
    #support-workspace .sp-input::placeholder { color: #73829a; }
    #support-workspace .sp-sort { flex: 0 1 175px; }
    #support-workspace .sp-filter-panel { background: #f8faff; border-top: 1px solid var(--sp-line); padding: 18px 24px; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
    #support-workspace .sp-filter-error { grid-column: 1 / -1; color: #a22a32; font-size: 12px; margin: 0; }
    #support-workspace .sp-table-wrap { overflow-x: auto; border-top: 1px solid var(--sp-line); }
    #support-workspace .sp-table { width: 100%; min-width: 1060px; border-collapse: collapse; margin: 0; text-align: left; }
    #support-workspace .sp-table th { padding: 13px 18px; background: #f8fafc; color: var(--sp-muted); font-size: 10px; font-weight: 700; letter-spacing: .065em; text-transform: uppercase; border-bottom: 1px solid var(--sp-line); white-space: nowrap; }
    #support-workspace .sp-table td { padding: 18px; border-bottom: 1px solid #edf1f7; font-size: 12px; vertical-align: middle; }
    #support-workspace .sp-table th:first-child, #support-workspace .sp-table td:first-child { padding-left: 24px; }
    #support-workspace .sp-table tbody tr[data-ticket]:hover { background: #f9fbff; }
    #support-workspace .sp-ticket-number { display: inline-block; color: var(--sp-blue); font-weight: 700; font-size: 12px; font-variant-numeric: tabular-nums; white-space: nowrap; }
    #support-workspace .sp-ticket-number:hover, #support-workspace .sp-subject:hover { text-decoration: underline; }
    #support-workspace .sp-subject { display: block; min-width: 170px; max-width: 290px; color: var(--sp-ink); font-size: 13px; font-weight: 600; overflow-wrap: anywhere; }
    #support-workspace .sp-person { display: flex; align-items: center; gap: 9px; min-width: 130px; }
    #support-workspace .sp-avatar { flex: 0 0 31px; width: 31px; height: 31px; display: grid; place-items: center; border-radius: 50%; color: #42608b; background: #eef2f8; font-size: 11px; font-weight: 700; }
    #support-workspace .sp-person-name { max-width: 140px; overflow-wrap: anywhere; }
    #support-workspace .sp-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 9px; border-radius: 7px; font-size: 11px; font-weight: 600; white-space: nowrap; }
    #support-workspace .sp-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    #support-workspace .sp-neutral { color: #586980; background: #f0f3f7; }
    #support-workspace .sp-blue { color: #2253b8; background: #edf3ff; }
    #support-workspace .sp-amber { color: #8a5a00; background: #fff5df; }
    #support-workspace .sp-green { color: #166443; background: #e8f6ef; }
    #support-workspace .sp-red { color: #ad3443; background: #fff0f1; }
    #support-workspace .sp-date { display: block; color: var(--sp-ink); font-size: 12px; font-weight: 600; white-space: nowrap; }
    #support-workspace .sp-time { display: block; color: var(--sp-muted); font-size: 11px; margin-top: 3px; white-space: nowrap; }
    #support-workspace .sp-action { display: inline-flex; align-items: center; gap: 5px; padding: 7px 9px; border: 1px solid var(--sp-line); border-radius: 7px; color: var(--sp-ink); font-size: 11px; font-weight: 600; white-space: nowrap; }
    #support-workspace .sp-action:hover { color: var(--sp-blue); border-color: #aac4fb; background: var(--sp-soft); }
    #support-workspace .sp-empty { text-align: center; padding: 52px 20px !important; }
    #support-workspace .sp-empty i { display: block; font-size: 28px; color: #8a9bb4; margin-bottom: 12px; }
    #support-workspace .sp-empty strong { display: block; font-size: 15px; margin-bottom: 6px; }
    #support-workspace .sp-empty p { color: var(--sp-muted); margin: 0; }
    #support-workspace .sp-footer { padding: 16px 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; }
    #support-workspace .sp-pagination { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; font-size: 12px; }
    #support-workspace .sp-pagination label { margin: 0; color: var(--sp-muted); }
    #support-workspace .sp-pagination select { width: 66px; min-height: 34px; padding: 5px 8px; }
    #support-workspace .sp-pagination .sp-button { min-height: 34px; padding: 6px 10px; font-size: 12px; }
    #support-workspace .sp-page-note { margin: 13px 3px 0; color: var(--sp-muted); font-size: 11px; }
    #support-workspace .sp-alert { border: 1px solid #b7decc; border-radius: 10px; padding: 13px 16px; margin-bottom: 18px; background: #eaf7f0; color: #155e40; }
    #support-workspace .sp-alert-error { border-color: #f1c9ce; background: #fff2f3; color: #9b2937; }
    @media (max-width: 1100px) {
        #support-workspace .sp-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        #support-workspace .sp-filter-panel { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 640px) {
        #support-workspace { border-radius: 12px; padding: 14px; }
        #support-workspace .sp-heading { align-items: flex-start; flex-direction: column; }
        #support-workspace .sp-heading > .sp-button { width: 100%; }
        #support-workspace .sp-stats { gap: 10px; }
        #support-workspace .sp-stat { padding: 14px; }
        #support-workspace .sp-stat-icon { display: none; }
        #support-workspace .sp-stat-label { padding: 0; }
        #support-workspace .sp-stat-value { font-size: 26px; }
        #support-workspace .sp-panel-head, #support-workspace .sp-toolbar, #support-workspace .sp-filter-panel, #support-workspace .sp-footer { padding: 16px; }
        #support-workspace .sp-tabs { padding: 0 10px; }
        #support-workspace .sp-sort { flex: 1 1 140px; }
        #support-workspace .sp-filter-panel { grid-template-columns: 1fr; }
        #support-workspace .sp-pagination { width: 100%; }
    }
    @media (prefers-reduced-motion: no-preference) {
        #support-workspace .sp-button, #support-workspace .sp-action { transition: background-color .15s, border-color .15s; }
    }

    /* Code Sparrow Brand Theme */
#support-workspace {
    --sp-brand: #137d83;
    --sp-accent: #15aebb;
    --sp-ink: #282828;
    --sp-muted: #607575;
    --sp-line: #deebeb;
    --sp-blue: var(--sp-brand);
    --sp-soft: #e8f5f5;
    --sp-bg: #f4f9f9;
}

/* Keyboard focus */
#support-workspace :is(button, a, input, select):focus-visible {
    outline-color: var(--sp-accent);
}

/* Buttons */
#support-workspace .sp-button:hover {
    background: var(--sp-soft);
}

#support-workspace .sp-primary {
    background: var(--sp-brand);
    border-color: var(--sp-brand);
    box-shadow: 0 4px 12px #137d8326;
}

#support-workspace .sp-primary:hover {
    background: #0c6469;
    border-color: #0c6469;
}

/* Brand accent on summary cards */
#support-workspace .sp-stat::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 3px;
    background: linear-gradient(
        90deg,
        var(--sp-brand),
        var(--sp-accent)
    );
}

/* Icons, ticket count, open status and avatars */
#support-workspace .sp-stat-icon:not(.sp-amber):not(.sp-green),
#support-workspace .sp-total-pill,
#support-workspace .sp-blue,
#support-workspace .sp-avatar {
    color: var(--sp-brand);
    background: var(--sp-soft);
}

/* Main panel */
#support-workspace .sp-panel {
    box-shadow: 0 6px 24px #137d8308;
}

/* Active tabs */
#support-workspace .sp-tab[aria-pressed="true"] {
    border-bottom-color: var(--sp-accent);
}

#support-workspace .sp-tab span,
#support-workspace .sp-neutral {
    background: #edf3f3;
    color: var(--sp-muted);
}

#support-workspace .sp-tab[aria-pressed="true"] span {
    color: var(--sp-brand);
    background: var(--sp-soft);
}

/* Form controls */
#support-workspace .sp-input {
    border-color: #d3e4e4;
}

#support-workspace .sp-input::placeholder,
#support-workspace .sp-empty i {
    color: #647e7e;
}

/* Table and filters */
#support-workspace .sp-filter-panel,
#support-workspace .sp-table th {
    background: #f4f9f9;
}

#support-workspace .sp-table td {
    border-bottom-color: #e9f1f1;
}

#support-workspace .sp-table tbody tr[data-ticket]:hover {
    background: #f2fafa;
}

#support-workspace .sp-action:hover {
    border-color: #82c5c9;
}


</style>
@endpush

@section('content')
@php
    // Compatible with your existing index() method, which returns ->get().
    // Load names in one query; do not change the controller's permission/user scope.
    if ($supports instanceof \Illuminate\Database\Eloquent\Collection) {
        $supports->loadMissing('raised');
    }
    $canCreateTicket = \App\Support\SubscriptionDomainAccess::domainItemsFor(Auth::user())->exists();
    $domainNames = $supports->pluck('domain_name')->filter()->unique()->sort()->values();
    $timezone = config('app.timezone', 'UTC');
    $totalCount = $supports->count();
    $openCount = $supports->where('status', 'open')->count();
    $progressCount = $supports->where('status', 'in_progress')->count();
    $closedCount = $supports->where('status', 'closed')->count();
    $statusColors = ['open' => 'sp-blue', 'in_progress' => 'sp-amber', 'closed' => 'sp-green'];
    $priorityColors = ['low' => 'sp-green', 'medium' => 'sp-amber', 'high' => 'sp-red', 'urgent' => 'sp-red'];
    $statusTabs = ['' => ['All tickets', $totalCount], 'open' => ['Open', $openCount], 'in_progress' => ['In progress', $progressCount], 'closed' => ['Closed', $closedCount]];
@endphp

<div id="support-workspace">
    <nav class="sp-breadcrumb" aria-label="{{ get_phrase('Breadcrumb') }}">
        <a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">{{ get_phrase('Support Tickets') }}</span>
    </nav>

    <header class="sp-heading">
        <div>
            <p class="sp-eyebrow">{{ get_phrase('SUPPORT WORKSPACE') }}</p>
            <h1>{{ get_phrase('Support tickets') }}</h1>
            <p class="sp-description">{{ get_phrase('Every request, clearly organized. Track conversations and keep work moving.') }}</p>
        </div>
        <button type="button" id="sp-create" class="sp-button sp-primary" @disabled(!$canCreateTicket)
            data-modal-url="{{ route('right_modal', ['view_path' => 'admin/supportTicket/add']) }}"
            data-modal-title="{{ get_phrase('Add New Support Ticket') }}">
            <i class="bi bi-plus-lg" aria-hidden="true"></i>{{ get_phrase('New ticket') }}
        </button>
    </header>

    @if (!$canCreateTicket)
        <div class="sp-alert sp-alert-error" role="status">
            {{ get_phrase('No active subscription domain is linked to your login. Check the subscription email or ask an administrator to activate the domain.') }}
        </div>
    @endif

    @if (session('success'))
        <div class="sp-alert" role="status">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="sp-alert sp-alert-error" role="alert">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="sp-alert sp-alert-error" role="alert">
            <strong>{{ get_phrase('Please check your ticket details.') }}</strong>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <div id="sp-modal-error" class="sp-alert sp-alert-error" role="alert" hidden>{{ get_phrase('The ticket form could not open. Please refresh the page and try again.') }}</div>

    <section class="sp-stats" aria-label="{{ get_phrase('Ticket overview') }}">
        <article class="sp-stat">
            <div class="sp-stat-icon"><i class="bi bi-ticket-perforated" aria-hidden="true"></i></div>
            <div class="sp-stat-label">{{ get_phrase('Total tickets') }}</div>
            <div class="sp-stat-value">{{ number_format($totalCount) }}</div>
            <div class="sp-stat-note">{{ get_phrase('All tickets available to you') }}</div>
        </article>
        <article class="sp-stat">
            <div class="sp-stat-icon"><i class="bi bi-inbox" aria-hidden="true"></i></div>
            <div class="sp-stat-label">{{ get_phrase('Open') }}</div>
            <div class="sp-stat-value">{{ number_format($openCount) }}</div>
            <div class="sp-stat-note">{{ get_phrase('Requests with open status') }}</div>
        </article>
        <article class="sp-stat">
            <div class="sp-stat-icon sp-amber"><i class="bi bi-hourglass-split" aria-hidden="true"></i></div>
            <div class="sp-stat-label">{{ get_phrase('In progress') }}</div>
            <div class="sp-stat-value">{{ number_format($progressCount) }}</div>
            <div class="sp-stat-note">{{ get_phrase('Work currently in progress') }}</div>
        </article>
        <article class="sp-stat">
            <div class="sp-stat-icon sp-green"><i class="bi bi-check2-circle" aria-hidden="true"></i></div>
            <div class="sp-stat-label">{{ get_phrase('Closed') }}</div>
            <div class="sp-stat-value">{{ number_format($closedCount) }}</div>
            <div class="sp-stat-note">{{ get_phrase('Tickets marked as closed') }}</div>
        </article>
    </section>

    <section class="sp-panel" aria-labelledby="sp-list-title">
        <div class="sp-panel-head">
            <div><h2 id="sp-list-title">{{ get_phrase('Ticket inbox') }}</h2><p class="sp-small">{{ get_phrase('Find a request and pick up the conversation.') }}</p></div>
            <span class="sp-total-pill">{{ number_format($totalCount) }} {{ get_phrase('tickets') }}</span>
        </div>
        <div class="sp-tabs" role="group" aria-label="{{ get_phrase('Filter by ticket status') }}" data-enhancement hidden>
            @foreach ($statusTabs as $value => $tab)
                <button type="button" class="sp-tab" data-status-filter="{{ $value }}" aria-pressed="{{ $value === '' ? 'true' : 'false' }}" aria-controls="sp-table-body">{{ get_phrase($tab[0]) }}<span>{{ $tab[1] }}</span></button>
            @endforeach
        </div>

        <div class="sp-toolbar" data-enhancement hidden>
            <div class="sp-field sp-search">
                <label for="sp-search">{{ get_phrase('Search tickets') }}</label>
                <div class="sp-search-wrap"><i class="bi bi-search" aria-hidden="true"></i><input id="sp-search" class="sp-input" type="search" placeholder="{{ get_phrase('Ticket number, subject, name or date...') }}" autocomplete="off" aria-controls="sp-table-body"></div>
            </div>
            <div class="sp-field sp-sort">
                <label for="sp-sort">{{ get_phrase('Sort by') }}</label>
                <select id="sp-sort" class="sp-input"><option value="newest">{{ get_phrase('Newest first') }}</option><option value="oldest">{{ get_phrase('Oldest first') }}</option><option value="priority">{{ get_phrase('Highest priority') }}</option><option value="subject">{{ get_phrase('Subject A–Z') }}</option></select>
            </div>
            <button type="button" id="sp-filter-toggle" class="sp-button" aria-expanded="false" aria-controls="sp-filter-panel"><i class="bi bi-sliders" aria-hidden="true"></i>{{ get_phrase('Filters') }}</button>
            <button type="button" id="sp-reset" class="sp-button">{{ get_phrase('Reset') }}</button>
        </div>

        <div id="sp-filter-panel" class="sp-filter-panel" hidden>
            <div class="sp-field"><label for="sp-priority">{{ get_phrase('Priority') }}</label><select id="sp-priority" class="sp-input"><option value="">{{ get_phrase('All priorities') }}</option>@foreach (['low', 'medium', 'high', 'urgent'] as $level)<option value="{{ $level }}">{{ get_phrase(ucfirst($level)) }}</option>@endforeach</select></div>
            <div class="sp-field"><label for="sp-domain">{{ get_phrase('Subscription Plan') }}</label><select id="sp-domain" class="sp-input"><option value="">{{ get_phrase('All domains') }}</option><option value="__none">{{ get_phrase('No domain') }}</option>@foreach ($domainNames as $name)<option value="{{ $name }}">{{ $name }}</option>@endforeach</select></div>
            <div class="sp-field"><label for="sp-from">{{ get_phrase('Created from') }}</label><input id="sp-from" class="sp-input" type="date" aria-describedby="sp-date-error"></div>
            <div class="sp-field"><label for="sp-to">{{ get_phrase('Created to') }}</label><input id="sp-to" class="sp-input" type="date" aria-describedby="sp-date-error"></div>
            <p id="sp-date-error" class="sp-filter-error" role="alert" hidden>{{ get_phrase('End date must be on or after the start date.') }}</p>
        </div>

        <div class="sp-table-wrap" tabindex="0" role="region" aria-label="{{ get_phrase('Support ticket table. Scroll horizontally to view all columns.') }}">
            <table class="sp-table">
                <thead><tr><th scope="col">{{ get_phrase('Ticket no.') }}</th><th scope="col">{{ get_phrase('Subject') }}</th><th scope="col">{{ get_phrase('Raised by') }}</th><th scope="col">{{ get_phrase('Priority') }}</th><th scope="col">{{ get_phrase('Status') }}</th><th scope="col">{{ get_phrase('Subscription Plan') }}</th><th scope="col">{{ get_phrase('Created date') }}</th><th scope="col">{{ get_phrase('Action') }}</th></tr></thead>
                <tbody id="sp-table-body">
                    @foreach ($supports as $support)
                        @php
                            $status = strtolower((string) ($support->status ?? 'open'));
                            $priority = strtolower((string) ($support->priority ?? 'medium'));
                            $domainName = trim((string) $support->domain_name);
                            $domainKey = $domainName !== '' ? $domainName : '__none';
                            $raisedName = optional($support->raised)->name ?: get_phrase('Unknown user');
                            $subject = $support->subject ?: get_phrase('Untitled ticket');
                            $ticketNumber = $support->ticket_no ? '#' . $support->ticket_no : get_phrase('Not assigned');
                            $created = $support->created_at ? \Carbon\Carbon::parse($support->created_at)->timezone($timezone) : null;
                            $dateLabel = $created ? $created->format('d M Y') : '—';
                            $timeLabel = $created ? $created->format('h:i A') : '';
                            $isoDate = $created ? $created->format('Y-m-d') : '';
                            $searchText = implode(' ', [$ticketNumber, $subject, $raisedName, $priority, str_replace('_', ' ', $status), $domainName, $dateLabel, $isoDate]);
                        @endphp
                        <tr data-ticket data-status="{{ $status }}" data-priority="{{ $priority }}" data-domain="{{ $domainKey }}" data-date="{{ $isoDate }}" data-created="{{ $created ? $created->timestamp : '' }}" data-subject="{{ $subject }}" data-search="{{ $searchText }}">
                            <td><a class="sp-ticket-number" href="{{ route('admin.support.show', $support->id) }}">{{ $ticketNumber }}</a></td>
                            <td><a class="sp-subject" href="{{ route('admin.support.show', $support->id) }}">{{ $subject }}</a></td>
                            <td><div class="sp-person"><span class="sp-avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($raisedName, 0, 1)) }}</span><span class="sp-person-name">{{ $raisedName }}</span></div></td>
                            <td><span class="sp-badge {{ $priorityColors[$priority] ?? 'sp-neutral' }}">{{ get_phrase(ucfirst($priority)) }}</span></td>
                            <td><span class="sp-badge {{ $statusColors[$status] ?? 'sp-neutral' }}">{{ get_phrase(ucfirst(str_replace('_', ' ', $status))) }}</span></td>
                            <td>{{ $domainName !== '' ? $domainName : '—' }}</td>
                            <td>@if ($created)<time class="sp-date" datetime="{{ $created->toIso8601String() }}">{{ $dateLabel }}<span class="sp-time">{{ $timeLabel }}</span></time>@else<span class="sp-small">—</span>@endif</td>
                            <td><a class="sp-action" href="{{ route('admin.support.show', $support->id) }}" aria-label="{{ get_phrase('View ticket') }} {{ $ticketNumber }}: {{ $subject }}">{{ get_phrase('View') }}<i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></td>
                        </tr>
                    @endforeach
                    <tr id="sp-empty" @if ($totalCount > 0) hidden @endif><td colspan="8" class="sp-empty"><i class="bi bi-inbox" aria-hidden="true"></i><strong>{{ get_phrase('No support tickets yet') }}</strong><p>{{ get_phrase('Create a new ticket to start a conversation.') }}</p></td></tr>
                    <tr id="sp-no-results" hidden><td colspan="8" class="sp-empty"><i class="bi bi-search" aria-hidden="true"></i><strong>{{ get_phrase('No matching tickets') }}</strong><p>{{ get_phrase('Try another search or reset your filters.') }}</p></td></tr>
                </tbody>
            </table>
        </div>
        <footer class="sp-footer" data-enhancement hidden>
            <p id="sp-result-count" class="sp-small" role="status" aria-live="polite" aria-atomic="true" data-template="{{ get_phrase('Showing :from–:to of :count tickets') }}" data-total-template="{{ get_phrase(':total total') }}"></p>
            <nav class="sp-pagination" aria-label="{{ get_phrase('Ticket pagination') }}">
                <label for="sp-page-size">{{ get_phrase('Rows') }}</label><select id="sp-page-size" class="sp-input"><option value="10">10</option><option value="25">25</option><option value="50">50</option></select>
                <button type="button" id="sp-prev" class="sp-button">{{ get_phrase('Previous') }}</button>
                <span id="sp-page-label" data-template="{{ get_phrase('Page :page of :pages') }}"></span>
                <button type="button" id="sp-next" class="sp-button">{{ get_phrase('Next') }}</button>
            </nav>
        </footer>
    </section>
    <p class="sp-page-note">{{ get_phrase('Dates and times shown in') }} {{ $timezone }}. {{ get_phrase('Summary cards show all tickets available to you; filters refine the list below.') }}</p>
    <noscript><p class="sp-page-note">{{ get_phrase('Enable JavaScript to create tickets, filter, sort and paginate. All available tickets are shown below the heading.') }}</p></noscript>
</div>
@endsection

@push('js')
<script>
(() => {
    'use strict';
    function initializeSupportWorkspace() {
        const root = document.getElementById('support-workspace');
        if (!root || root.dataset.initialized === 'true') return;
        root.dataset.initialized = 'true';
        const get = id => root.querySelector('#' + id);
        const body = get('sp-table-body');
        const records = Array.from(body.querySelectorAll('[data-ticket]')).map((row, index) => ({
            row, index, status: row.dataset.status, priority: row.dataset.priority,
            domain: row.dataset.domain, date: row.dataset.date,
            created: row.dataset.created === '' ? null : Number(row.dataset.created),
            subject: row.dataset.subject, search: row.dataset.search.toLocaleLowerCase()
        }));
        const tabs = Array.from(root.querySelectorAll('[data-status-filter]'));
        const search = get('sp-search'), sort = get('sp-sort'), priority = get('sp-priority');
        const domain = get('sp-domain'), from = get('sp-from'), to = get('sp-to');
        const size = get('sp-page-size'), count = get('sp-result-count'), pageLabel = get('sp-page-label');
        const ranks = { urgent: 4, high: 3, medium: 2, low: 1 };
        let status = '', page = 1, pages = 1;
        const format = (template, values) => template.replace(/:(from|to|count|total|page|pages)\b/g, (_, key) => String(values[key]));
        function dateOrder(a, b, direction) {
            if (a.created === null && b.created === null) return a.index - b.index;
            if (a.created === null) return 1;
            if (b.created === null) return -1;
            return direction * (a.created - b.created) || a.index - b.index;
        }
        function render() {
            const query = search.value.trim().toLocaleLowerCase();
            const invalidDates = Boolean(from.value && to.value && from.value > to.value);
            get('sp-date-error').hidden = !invalidDates;
            from.setAttribute('aria-invalid', String(invalidDates));
            to.setAttribute('aria-invalid', String(invalidDates));
            const matches = records.filter(record => !invalidDates &&
                (!query || record.search.includes(query)) &&
                (!status || record.status === status) &&
                (!priority.value || record.priority === priority.value) &&
                (!domain.value || record.domain === domain.value) &&
                (!from.value || (record.date && record.date >= from.value)) &&
                (!to.value || (record.date && record.date <= to.value))
            );
            matches.sort((a, b) => {
                if (sort.value === 'oldest') return dateOrder(a, b, 1);
                if (sort.value === 'priority') return ((ranks[b.priority] || 0) - (ranks[a.priority] || 0)) || dateOrder(a, b, -1);
                if (sort.value === 'subject') return a.subject.localeCompare(b.subject, undefined, { sensitivity: 'base' }) || dateOrder(a, b, -1);
                return dateOrder(a, b, -1);
            });
            const pageSize = Number(size.value);
            pages = Math.max(1, Math.ceil(matches.length / pageSize));
            page = Math.min(Math.max(1, page), pages);
            const offset = (page - 1) * pageSize;
            records.forEach(record => { record.row.hidden = true; });
            const fragment = document.createDocumentFragment();
            matches.slice(offset, offset + pageSize).forEach(record => {
                record.row.hidden = false;
                fragment.appendChild(record.row);
            });
            body.insertBefore(fragment, get('sp-empty'));
            get('sp-empty').hidden = records.length !== 0;
            get('sp-no-results').hidden = records.length === 0 || matches.length > 0;
            count.textContent = format(count.dataset.template, { from: matches.length ? offset + 1 : 0, to: Math.min(offset + pageSize, matches.length), count: matches.length });
            if (matches.length !== records.length) count.textContent += ' · ' + format(count.dataset.totalTemplate, { total: records.length });
            pageLabel.textContent = format(pageLabel.dataset.template, { page, pages });
            get('sp-prev').disabled = page <= 1;
            get('sp-next').disabled = page >= pages;
            tabs.forEach(tab => tab.setAttribute('aria-pressed', String(tab.dataset.statusFilter === status)));
        }
        tabs.forEach(tab => tab.addEventListener('click', () => { status = tab.dataset.statusFilter; page = 1; render(); }));
        search.addEventListener('input', () => { page = 1; render(); });
        [sort, priority, domain, from, to, size].forEach(control => control.addEventListener('change', () => { page = 1; render(); }));
        get('sp-prev').addEventListener('click', () => { page--; render(); });
        get('sp-next').addEventListener('click', () => { page++; render(); });
        get('sp-filter-toggle').addEventListener('click', () => {
            const expanded = get('sp-filter-toggle').getAttribute('aria-expanded') !== 'true';
            get('sp-filter-toggle').setAttribute('aria-expanded', String(expanded));
            get('sp-filter-panel').hidden = !expanded;
        });
        get('sp-reset').addEventListener('click', () => {
            search.value = ''; priority.value = ''; domain.value = ''; from.value = ''; to.value = '';
            status = ''; sort.value = 'newest'; page = 1; render();
        });
        get('sp-create').addEventListener('click', () => {
            const button = get('sp-create');
            get('sp-modal-error').hidden = true;
            if (typeof window.showRightModal !== 'function') {
                get('sp-modal-error').hidden = false;
                return;
            }
            window.showRightModal(button.dataset.modalUrl, button.dataset.modalTitle);
        });
        root.querySelectorAll('[data-enhancement]').forEach(element => { element.hidden = false; });
        render();
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initializeSupportWorkspace, { once: true });
    else initializeSupportWorkspace();
})();
</script>
@endpush


