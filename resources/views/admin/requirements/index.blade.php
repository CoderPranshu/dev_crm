@extends('index')

@section('title','Requirements')

push('css')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

    .req-dashboard {
        --c-primary: #0F8EA3;
        --c-accent: #16B6C8;
        --c-bg: #F8FAFC;
        --c-border: #E5E7EB;
        --c-text: #1F2937;
        --c-muted: #6B7280;
        --c-surface: #FFFFFF;

        --c-success: #10B981;
        --c-success-bg: #ECFDF5;
        --c-danger: #EF4444;
        --c-danger-bg: #FEF2F2;
        --c-warning: #D97706;
        --c-warning-bg: #FFFBEB;
        --c-info: #2563EB;
        --c-info-bg: #EFF6FF;
        --c-secondary: #6B7280;
        --c-secondary-bg: #F1F5F9;
        --c-primary-bg: #E6F6F8;

        --radius: 14px;
        --radius-sm: 8px;
        --shadow-sm: 0 1px 2px rgba(15,23,42,.04), 0 1px 3px rgba(15,23,42,.05);
        --shadow-md: 0 8px 24px rgba(15,23,42,.07), 0 2px 6px rgba(15,23,42,.04);

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--c-text);
        background: var(--c-bg);
        padding: 28px clamp(12px, 3vw, 32px) 60px;
        border-radius: 18px;
        animation: reqFadeIn .35s ease both;
    }

    @keyframes reqFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .req-dashboard * { box-sizing: border-box; }
    .req-dashboard a { text-decoration: none; color: inherit; }
    .req-dashboard .req-num { font-variant-numeric: tabular-nums; }

    /* ---------- Header ---------- */
    .req-breadcrumb { font-size: 13px; color: var(--c-muted); margin-bottom: 6px; font-weight: 500; }
    .req-breadcrumb a:hover { color: var(--c-primary); }

    .req-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; flex-wrap: wrap; margin-bottom: 28px;
    }
    .req-title {
        font-size: 26px; font-weight: 800; letter-spacing: -0.02em; margin: 0 0 4px;
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .req-title-sub { font-size: 15px; font-weight: 500; color: var(--c-muted); }
    .req-subtitle { font-size: 14px; color: var(--c-muted); margin: 0; font-weight: 500; }

    .req-header-actions { display: flex; align-items: center; gap: 10px; }

    .req-blocked-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--c-danger-bg); color: var(--c-danger);
        font-size: 12.5px; font-weight: 600; padding: 7px 14px; border-radius: 999px;
        border: 1px solid rgba(239,68,68,.18);
    }
    .req-blocked-pill::before {
        content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--c-danger);
        animation: reqPulse 1.6s infinite;
    }

    @keyframes reqPulse {
        0% { box-shadow: 0 0 0 0 rgba(239,68,68,.45); }
        70% { box-shadow: 0 0 0 6px rgba(239,68,68,0); }
        100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
    }

    .req-btn {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 14px; font-weight: 600; padding: 10px 18px;
        border-radius: var(--radius-sm); border: 1px solid transparent;
        cursor: pointer; transition: all .15s ease; white-space: nowrap;
    }
    .req-btn-primary {
        background: linear-gradient(135deg, var(--c-primary), var(--c-accent));
        color: #fff; box-shadow: var(--shadow-sm);
    }
    .req-btn-primary:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); color: #fff; }
    .req-btn-outline {
        background: var(--c-surface); color: var(--c-text); border-color: var(--c-border);
    }
    .req-btn-outline:hover { border-color: var(--c-primary); color: var(--c-primary); }
    .req-btn-sm { padding: 7px 13px; font-size: 13px; }
    .req-btn:disabled { opacity: .5; cursor: not-allowed; }

    /* ---------- Stat cards ---------- */
    .req-stats-grid {
        display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px; margin-bottom: 24px;
    }
    @media (max-width: 1200px) { .req-stats-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 700px) { .req-stats-grid { grid-template-columns: repeat(2, 1fr); } }

    .req-stat-card {
        background: var(--c-surface); border: 1px solid var(--c-border); border-radius: var(--radius);
        padding: 16px; box-shadow: var(--shadow-sm); transition: box-shadow .15s ease, transform .15s ease;
    }
    .req-stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .req-stat-label {
        font-size: 12px; font-weight: 600; color: var(--c-muted);
        text-transform: uppercase; letter-spacing: .04em; margin-bottom: 8px;
    }
    .req-stat-value { font-size: 26px; font-weight: 800; letter-spacing: -0.02em; }
    .req-stat-card.is-critical .req-stat-value { color: var(--c-danger); }
    .req-stat-card.is-blocked .req-stat-value { color: var(--c-danger); }
    .req-stat-card.is-completed .req-stat-value { color: var(--c-success); }

    /* ---------- Filter bar ---------- */
    .req-filter-bar {
        background: var(--c-surface); border: 1px solid var(--c-border); border-radius: var(--radius);
        box-shadow: var(--shadow-sm); padding: 14px 16px; margin-bottom: 22px;
        display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
    }
    .req-filter-bar input,
    .req-filter-bar select {
        border: 1px solid var(--c-border); border-radius: var(--radius-sm);
        padding: 9px 12px; font-size: 13.5px; color: var(--c-text);
        background: #fff; font-family: inherit; transition: border-color .15s ease;
    }
    .req-filter-bar input:focus,
    .req-filter-bar select:focus {
        outline: none; border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-bg);
    }
    .req-filter-search { flex: 1 1 220px; min-width: 180px; }
    .req-filter-bar select { flex: 0 0 auto; min-width: 130px; }
    .req-filter-bar .req-filter-icon {
        color: var(--c-muted); font-size: 15px; margin-right: -30px; pointer-events: none; z-index: 1;
        position: relative; left: 10px;
    }

    /* ---------- Badges ---------- */
    .req-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 999px;
        white-space: nowrap; line-height: 1.4;
    }
    .req-badge-secondary { background: var(--c-secondary-bg); color: var(--c-secondary); }
    .req-badge-info { background: var(--c-info-bg); color: var(--c-info); }
    .req-badge-primary { background: var(--c-primary-bg); color: var(--c-primary); }
    .req-badge-warning { background: var(--c-warning-bg); color: var(--c-warning); }
    .req-badge-success { background: var(--c-success-bg); color: var(--c-success); }
    .req-badge-danger { background: var(--c-danger-bg); color: var(--c-danger); }

    .req-badge-blocker { background: var(--c-danger-bg); color: var(--c-danger); }
    .req-badge-unread { background: var(--c-primary); color: #fff; }

    /* ---------- Requirement cards ---------- */
    .req-list { display: flex; flex-direction: column; gap: 12px; }

    .req-card {
        background: var(--c-surface); border: 1px solid var(--c-border); border-radius: var(--radius);
        box-shadow: var(--shadow-sm); padding: 18px 20px; position: relative; overflow: hidden;
        transition: box-shadow .18s ease, transform .18s ease, border-color .18s ease;
    }
    .req-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); border-color: #DCE3E9; }

    .req-card::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
    }
    .req-card.priority-low::before { background: var(--c-secondary); }
    .req-card.priority-medium::before { background: var(--c-info); }
    .req-card.priority-high::before { background: var(--c-warning); }
    .req-card.priority-critical::before { background: var(--c-danger); }

    .req-card-top {
        display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 10px;
    }
    .req-card-title {
        font-size: 15.5px; font-weight: 700; margin: 0 0 6px; letter-spacing: -0.01em;
        transition: color .15s ease;
    }
    .req-card-title:hover { color: var(--c-primary); }
    .req-card-badges { display: flex; gap: 6px; flex-wrap: wrap; }

    .req-card-meta {
        display: flex; flex-wrap: wrap; gap: 14px; font-size: 12.5px; color: var(--c-muted);
        font-weight: 500; margin-bottom: 14px;
    }
    .req-card-meta span { display: inline-flex; align-items: center; gap: 5px; }
    .req-card-meta i { font-size: 13px; }

    /* mini status stepper (derived only from ->status, no extra query) */
    .req-stepper { display: flex; align-items: center; gap: 4px; margin-bottom: 14px; }
    .req-stepper .req-step {
        width: 22px; height: 4px; border-radius: 3px; background: var(--c-border);
    }
    .req-stepper .req-step.is-done { background: var(--c-primary); }
    .req-stepper .req-step.is-rejected { background: var(--c-danger); }

    .req-card-footer {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        padding-top: 12px; border-top: 1px dashed var(--c-border); flex-wrap: wrap;
    }
    .req-card-actions { display: flex; gap: 8px; }

    /* ---------- Empty state ---------- */
    .req-empty {
        background: var(--c-surface); border: 1px dashed var(--c-border); border-radius: var(--radius);
        text-align: center; padding: 60px 20px; color: var(--c-muted);
    }
    .req-empty i { font-size: 34px; color: var(--c-border); margin-bottom: 10px; display: block; }
    .req-empty strong { display: block; color: var(--c-text); font-size: 15px; margin-bottom: 4px; }

    /* ---------- Pagination ---------- */
    .req-pagination { margin-top: 22px; }
    .req-pagination nav > div:first-child { display: none; } /* hide default "showing x of y" text if noisy */
    .req-pagination .pagination { gap: 4px; }
    .req-pagination .page-link {
        border-radius: var(--radius-sm) !important; border-color: var(--c-border) !important;
        color: var(--c-text) !important; font-weight: 600; font-size: 13px;
    }
    .req-pagination .page-item.active .page-link {
        background: var(--c-primary) !important; border-color: var(--c-primary) !important;
    }

    /* ---------- Modal restyle ---------- */
    .req-dashboard ~ .modal .modal-content { border-radius: var(--radius); border: 1px solid var(--c-border); }
    .req-modal-body label { font-size: 13px; font-weight: 600; color: var(--c-text); margin-bottom: 6px; }

</style>


endpush


@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Local view-only helpers (nothing here touches controller data).
    | Mirrors the pattern already used in show.blade.php.
    |--------------------------------------------------------------------------
    */
    $isLead = $module->project->assigned_to === auth()->id();
    $isAdmin = auth()->user()->hasRole('Admin');
    $canAct = $isLead || $isAdmin;

    $priorityColors = [
        'Low' => 'secondary',
        'Medium' => 'info',
        'High' => 'warning',
        'Critical' => 'danger',
    ];

    $statusColors = [
        'Pending' => 'secondary',
        'Seen' => 'info',
        'In Progress' => 'primary',
        'Waiting Admin' => 'warning',
        'Waiting Client' => 'warning',
        'Completed' => 'success',
        'Rejected' => 'danger',
    ];

    $statusSteps = ['Pending', 'Seen', 'In Progress', 'Waiting Admin / Client', 'Completed'];

    // Summary counts — derived from the module's own requirements relation,
    // not from the paginated $requirements list, so they reflect the whole set.
    $allReq = $module->requirements();
    $totalCount = (clone $allReq)->count();
    $pendingCount = (clone $allReq)->where('status', 'Pending')->count();
    $waitingClientCount = (clone $allReq)->where('status', 'Waiting Client')->count();
    $waitingAdminCount = (clone $allReq)->where('status', 'Waiting Admin')->count();
    $completedCount = (clone $allReq)->where('status', 'Completed')->count();
    $criticalCount = (clone $allReq)->where('priority', 'Critical')->count();
    $blockedCount = (clone $allReq)->where('is_blocker', true)->whereNotIn('status', ['Completed', 'Rejected'])->count();
@endphp





<div class="req-dashboard">

    {{-- ========================= Header ========================= --}}
    <div class="req-header">

        <div>
            <div class="req-breadcrumb">
                {{ $module->project->project_name ?? '-' }} <span style="margin:0 4px;">/</span> {{ $module->module_name }}
            </div>

            <h1 class="req-title">
                Requirements
                <span class="req-title-sub">— {{ $module->module_name }}</span>
            </h1>

            <p class="req-subtitle">Track everything the developer needs to ship this module.</p>
        </div>

        <div class="req-header-actions">

            @if($module->isBlocked())
                <span class="req-blocked-pill">Module Blocked</span>
            @endif

            @if($module->assigned_to === auth()->id())
                <button class="req-btn req-btn-primary" data-bs-toggle="modal" data-bs-target="#raiseRequirementModal">
                    <i class="bi bi-plus-lg"></i> Raise Requirement
                </button>
            @endif

        </div>

    </div>

    {{-- ========================= Summary Cards ========================= --}}
    <div class="req-stats-grid">

        <div class="req-stat-card">
            <div class="req-stat-label">Total</div>
            <div class="req-stat-value req-num">{{ $totalCount }}</div>
        </div>

        <div class="req-stat-card">
            <div class="req-stat-label">Pending</div>
            <div class="req-stat-value req-num">{{ $pendingCount }}</div>
        </div>

        <div class="req-stat-card">
            <div class="req-stat-label">Waiting Client</div>
            <div class="req-stat-value req-num">{{ $waitingClientCount }}</div>
        </div>

        <div class="req-stat-card">
            <div class="req-stat-label">Waiting Admin</div>
            <div class="req-stat-value req-num">{{ $waitingAdminCount }}</div>
        </div>

        <div class="req-stat-card is-completed">
            <div class="req-stat-label">Completed</div>
            <div class="req-stat-value req-num">{{ $completedCount }}</div>
        </div>

        <div class="req-stat-card is-critical">
            <div class="req-stat-label">Critical</div>
            <div class="req-stat-value req-num">{{ $criticalCount }}</div>
        </div>

        <div class="req-stat-card is-blocked">
            <div class="req-stat-label">Blocked</div>
            <div class="req-stat-value req-num">{{ $blockedCount }}</div>
        </div>

    </div>

    {{-- ========================= Filter Bar ========================= --}}
    {{-- Visual filter bar. Wire these query params into the controller's
         index() query whenever you want them to actually filter results. --}}
    <form class="req-filter-bar" method="GET" action="{{ route('admin.requirements.index', $module->id) }}">

        <input type="text" name="search" class="req-filter-search" placeholder="Search requirements..." value="{{ request('search') }}">

        <select name="status">
            <option value="">All Status</option>
            @foreach(['Pending','Seen','In Progress','Waiting Admin','Waiting Client','Completed','Rejected'] as $statusOption)
                <option value="{{ $statusOption }}" @selected(request('status') === $statusOption)>{{ $statusOption }}</option>
            @endforeach
        </select>

        <select name="priority">
            <option value="">All Priority</option>
            @foreach(['Low','Medium','High','Critical'] as $priorityOption)
                <option value="{{ $priorityOption }}" @selected(request('priority') === $priorityOption)>{{ $priorityOption }}</option>
            @endforeach
        </select>

        <select name="requirement_type_id">
            <option value="">All Types</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}" @selected((string) request('requirement_type_id') === (string) $type->id)>{{ $type->name }}</option>
            @endforeach
        </select>

        <select name="developer">
            <option value="">All Developers</option>
            <option value="{{ $module->assigned_to }}" @selected(request('developer') == $module->assigned_to)>
                {{ $module->developer->name ?? '-' }}
            </option>
        </select>

        <input type="date" name="date" value="{{ request('date') }}">

        <button type="submit" class="req-btn req-btn-outline req-btn-sm">
            <i class="bi bi-funnel"></i> Filter
        </button>

    </form>

    {{-- ========================= Requirement Cards ========================= --}}
    <div class="req-list">

        @forelse($requirements as $requirement)

            @php
                $priorityKey = strtolower($requirement->priority);
            @endphp

            <div class="req-card priority-{{ $priorityKey }}">

                <div class="req-card-top">

                    <div>
                        <a href="{{ route('admin.requirements.show', $requirement->id) }}" class="req-card-title">
                            {{ $requirement->title }}
                        </a>

                        <div class="req-card-badges">

                            <span class="req-badge req-badge-{{ $statusColors[$requirement->status] ?? 'secondary' }}">
                                {{ $requirement->status }}
                            </span>

                            <span class="req-badge req-badge-{{ $priorityColors[$requirement->priority] ?? 'secondary' }}">
                                {{ $requirement->priority }}
                            </span>

                            @if($requirement->is_blocker)
                                <span class="req-badge req-badge-blocker">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Blocker
                                </span>
                            @endif

                            @if(!$requirement->isSeen())
                                <span class="req-badge req-badge-unread">New</span>
                            @endif

                        </div>
                    </div>

                </div>

                <div class="req-card-meta">
                    <span><i class="bi bi-tag"></i> {{ $requirement->type->name ?? '-' }}</span>
                    <span><i class="bi bi-person"></i> {{ $requirement->raisedBy->name ?? '-' }}</span>
                    <span><i class="bi bi-clock"></i> {{ $requirement->created_at->diffForHumans() }}</span>
                    @if($requirement->isSeen())
                        <span style="color:var(--c-success);"><i class="bi bi-check2-all"></i> Seen by {{ $requirement->seenByUser->name ?? '-' }}</span>
                    @endif
                </div>

                {{-- Mini status stepper — a lightweight timeline preview built
                     only from the current status, no extra query per card. --}}
                <div class="req-stepper" title="{{ $requirement->status }}">
                    @php
                        $stepOrder = ['Pending', 'Seen', 'In Progress', 'Waiting', 'Completed'];
                        $currentIndex = match(true) {
                            in_array($requirement->status, ['Waiting Admin', 'Waiting Client']) => 3,
                            $requirement->status === 'Completed' => 4,
                            $requirement->status === 'Rejected' => -1,
                            default => array_search($requirement->status, $stepOrder),
                        };
                    @endphp
                    @for($i = 0; $i < 5; $i++)
                        <div class="req-step {{ $currentIndex === -1 ? 'is-rejected' : ($i <= $currentIndex ? 'is-done' : '') }}"></div>
                    @endfor
                </div>

                <div class="req-card-footer">

                    <div class="req-card-actions">

                        <a href="{{ route('admin.requirements.show', $requirement->id) }}" class="req-btn req-btn-outline req-btn-sm">
                            <i class="bi bi-eye"></i> View
                        </a>

                        <a href="{{ route('admin.requirements.show', $requirement->id) }}#req-comments" class="req-btn req-btn-outline req-btn-sm">
                            <i class="bi bi-reply"></i> Reply
                        </a>

                        @if($canAct && !in_array($requirement->status, ['Completed', 'Rejected']))
                            <form action="{{ route('admin.requirements.complete', $requirement->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="req-btn req-btn-outline req-btn-sm" style="color:var(--c-success); border-color:rgba(16,185,129,.3);">
                                    <i class="bi bi-check-circle"></i> Complete
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="req-empty">
                <i class="bi bi-inbox"></i>
                <strong>No requirements raised yet</strong>
                Raise one above to ask for API keys, credentials, hosting, or anything else you need.
            </div>

        @endforelse

    </div>

    {{-- ========================= Pagination ========================= --}}
    <div class="req-pagination">
        {{ $requirements->links() }}
    </div>

</div>

{{-- ========================================= --}}
{{-- Raise Requirement Modal — untouched form action / fields --}}
{{-- ========================================= --}}
@if($module->assigned_to === auth()->id())

<div class="modal fade" id="raiseRequirementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.requirements.store', $module->id) }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Raise Requirement</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body req-modal-body">

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="requirement_type_id" required>
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4"></textarea>
                    </div>

                    <div class="row">

                        <div class="col-6 mb-3">
                            <label class="form-label">Priority</label>
                            <select class="form-select" name="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>

                        <div class="col-6 mb-3 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_blocker" value="1" id="isBlocker">
                                <label class="form-check-label" for="isBlocker">
                                    This is blocking my work
                                </label>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    <button class="req-btn req-btn-primary">Raise Requirement</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endif

@endsection