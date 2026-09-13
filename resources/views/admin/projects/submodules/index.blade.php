@extends('index')

@push('title', 'My Tasks')

@section('content')

<div class="container-fluid cs-workspace">

    <!-- ============================================================
         PAGE HEADER
    ============================================================= -->

    <div class="cs-header d-flex justify-content-between align-items-end mb-4">

        <div class="cs-header-copy">

            <span class="cs-eyebrow">
                <i class="fas fa-puzzle-piece"></i>
                MY WORKSPACE
            </span>

            <h3 class="cs-title">My Tasks</h3>

            <p class="cs-subtitle">
                Project&nbsp;<strong>{{ $module->project->project_name ?? 'N/A' }}</strong>
                <span class="cs-dot">&bull;</span>
                Module&nbsp;<strong>{{ $module->module_name }}</strong>
                <span class="cs-dot">&bull;</span>
                @include('admin.projects.submodules.partials.status-badge', ['status' => $module->status])
            </p>

        </div>

        <div class="cs-header-actions">

            <a href="{{ route('admin.modules.show',$module->id) }}"
               class="cs-btn cs-btn-ghost">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <a href="{{ route('submodules.create',$module->id) }}"
               class="cs-btn cs-btn-primary">
                <i class="fas fa-plus"></i>
                Create Submodules
            </a>

        </div>

    </div>


    <!-- ============================================================
         TASK OVERVIEW — compact metric strip (no giant dashboard cards)
    ============================================================= -->

    <div class="cs-overview mb-4">

        <div class="cs-metric">
            <span class="cs-metric-value">{{ $module->subModules->count() }}</span>
            <span class="cs-metric-label">Total</span>
        </div>

        <span class="cs-metric-sep"></span>

        <div class="cs-metric">
            <span class="cs-metric-value cs-text-progress">{{ $module->subModules->where('status','In Progress')->count() }}</span>
            <span class="cs-metric-label">In Progress</span>
        </div>

        <span class="cs-metric-sep"></span>

        <div class="cs-metric">
            <span class="cs-metric-value cs-text-pending">{{ $module->subModules->where('status','Pending')->count() }}</span>
            <span class="cs-metric-label">Pending</span>
        </div>

        <span class="cs-metric-sep"></span>

        <div class="cs-metric">
            <span class="cs-metric-value cs-text-approved">{{ $module->approvedSubModulesCount() }}</span>
            <span class="cs-metric-label">Approved</span>
        </div>

        <span class="cs-metric-sep"></span>

        <div class="cs-metric">
            <span class="cs-metric-value cs-text-waiting">{{ $module->waitingReviewSubModulesCount() }}</span>
            <span class="cs-metric-label">Waiting Review</span>
        </div>

        <span class="cs-metric-sep"></span>

        <div class="cs-metric">
            <span class="cs-metric-value cs-text-changes">{{ $module->changesRequestedSubModulesCount() }}</span>
            <span class="cs-metric-label">Changes Requested</span>
        </div>

        <span class="cs-metric-sep"></span>

        <div class="cs-metric cs-metric-status">
            <span class="cs-metric-label mb-1 d-block">Module Status</span>
            @include('admin.projects.submodules.partials.status-badge', ['status' => $module->status])
        </div>

    </div>


    <!-- ============================================================
         FILTER / CONTROL BAR — same IDs, same behaviour, new skin
    ============================================================= -->

    <div class="cs-filterbar mb-4">

        <div class="row g-2 align-items-center">

            <div class="col-md-5">
                <div class="cs-input-icon">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="Search sub module&hellip;">
                </div>
            </div>

            <div class="col-md-3">
                <select id="statusFilter" class="form-select">
                    <option value="">All Status</option>
                    <option>Pending</option>
                    <option>Planning</option>
                    <option>In Progress</option>
                    <option>Testing</option>
                    <option>Ready For Review</option>
                    <option>Changes Requested</option>
                    <option>Approved</option>
                    <option>On Hold</option>
                    <option>Cancelled</option>
                </select>
            </div>

            <div class="col-md-3">
                <select id="priorityFilter" class="form-select">
                    <option value="">All Priority</option>
                    <option>Low</option>
                    <option>Medium</option>
                    <option>High</option>
                    <option>Critical</option>
                </select>
            </div>

            <div class="col-md-1">
                <button class="cs-btn cs-btn-primary w-100 justify-content-center" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </div>

    </div>


    <!-- ============================================================
         TASK LIST
    ============================================================= -->

    <div class="cs-panel">

        <div class="cs-panel-header">
            <h5 class="mb-0">
                <i class="fas fa-list-check"></i>
                My Tasks
            </h5>
        </div>

        <div class="cs-panel-body">

            <div class="table-responsive">

                <table class="table eTable align-middle cs-task-table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sub Module</th>
                            <th>Developer</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Progress</th>
                            <th>Deadline</th>
                            <th width="230">Review</th>
                        </tr>
                    </thead>

                    <tbody id="subModuleTable">

                    @forelse($submodules as $submodule)

<tr class="cs-task-row cs-priority-{{ strtolower($submodule->priority ?? 'low') }}">

    <td>
        <span class="cs-index">{{ sprintf('%02d', $loop->iteration) }}</span>
    </td>

    <td>

        <div class="cs-task-main">

            <div class="cs-task-path">
                {{ $module->project->project_name ?? 'Project' }}
                <i class="fas fa-chevron-right"></i>
                {{ $module->module_name }}
            </div>

            <div class="cs-task-title">
                {{ $submodule->sub_module_name }}
            </div>

            @if($submodule->description)
                <div class="cs-task-desc">
                    {{ \Illuminate\Support\Str::limit($submodule->description,60) }}
                </div>
            @endif

            @if($submodule->status === 'Changes Requested' && optional($submodule->reviews->last())->remarks)
                <div class="cs-task-remark">
                    <i class="bi bi-chat-left-text"></i>
                    {{ \Illuminate\Support\Str::limit($submodule->reviews->last()->remarks, 70) }}
                </div>
            @endif

        </div>

    </td>

    <td>

        @if($submodule->assignedTo)
            <span class="cs-dev-chip">
                <span class="cs-dev-avatar">{{ strtoupper(substr($submodule->assignedTo->name, 0, 1)) }}</span>
                {{ $submodule->assignedTo->name }}
            </span>
        @else
            <span class="cs-dev-chip cs-dev-chip-empty">
                <i class="fas fa-user-slash"></i>
                Not Assigned
            </span>
        @endif

    </td>

    <td>
        <div class="cs-status-cell">
            @include('admin.projects.submodules.partials.status-badge', ['status' => $submodule->status])
        </div>
    </td>

    <td>

        @switch($submodule->priority)

            @case('Critical')
                <span class="cs-priority-tag cs-priority-tag-critical">
                    <span class="cs-priority-dot"></span> Critical
                </span>
                @break

            @case('High')
                <span class="cs-priority-tag cs-priority-tag-high">
                    <span class="cs-priority-dot"></span> High
                </span>
                @break

            @case('Medium')
                <span class="cs-priority-tag cs-priority-tag-medium">
                    <span class="cs-priority-dot"></span> Medium
                </span>
                @break

            @default
                <span class="cs-priority-tag cs-priority-tag-low">
                    <span class="cs-priority-dot"></span> Low
                </span>

        @endswitch

    </td>

    <td style="width:170px;">

        <div class="cs-progress">
            <div class="cs-progress-bar

                @if($submodule->progress>=100)
                    cs-progress-complete
                @elseif($submodule->progress>=60)
                    cs-progress-good
                @elseif($submodule->progress>=30)
                    cs-progress-mid
                @else
                    cs-progress-low
                @endif

            "
            role="progressbar"
            style="width: {{ $submodule->progress }}%;">
            </div>
        </div>

        <small class="cs-progress-label">{{ $submodule->progress }}%</small>

    </td>

    <td>

        @if($submodule->deadline)

            @php
                $days=\Carbon\Carbon::today()->diffInDays($submodule->deadline,false);
            @endphp

            @if($days<0)
                <span class="cs-deadline cs-deadline-overdue">
                    <i class="fas fa-triangle-exclamation"></i> Expired
                </span>
            @elseif($days<=2)
                <span class="cs-deadline cs-deadline-overdue">
                    <i class="fas fa-clock"></i> {{ $days }} Day Left
                </span>
            @elseif($days<=7)
                <span class="cs-deadline cs-deadline-soon">
                    <i class="fas fa-clock"></i> {{ $days }} Days
                </span>
            @else
                <span class="cs-deadline cs-deadline-normal">
                    {{ \Carbon\Carbon::parse($submodule->deadline)->format('d M Y') }}
                </span>
            @endif

        @else
            <span class="cs-deadline-none">&mdash;</span>
        @endif

    </td>

    <td>

        @php
    $currentUserId = auth()->id();

    // Project ka assigned_to hi Lead Developer hai
    $leadDeveloperId = $submodule->module->project->assigned_to ?? null;

    // Current user Lead Developer hai ya nahi
    $isLeadDeveloper = $leadDeveloperId == $currentUserId;

    // Current user Admin hai ya nahi
    $isAdmin = auth()->user()->hasRole('Admin');

    // Task kisi developer ko assigned hai
    $assignedDeveloperId = $submodule->assigned_to ?? null;

    // Lead Developer ka apna task
    $isLeadDeveloperOwnTask =
        $isLeadDeveloper &&
        $assignedDeveloperId == $currentUserId;

    // Kya current user ko review karne ki permission hai?
    $canReviewTask =
        $isAdmin ||
        ($isLeadDeveloper && !$isLeadDeveloperOwnTask);
@endphp


@if($canReviewTask)

    {{-- ============================================================
        ADMIN / LEAD DEVELOPER
        Approve / Changes Requested
    ============================================================= --}}

    <div class="cs-review-actions">

        @include(
            'admin.projects.submodules.partials.review-actions',
            ['submodule' => $submodule]
        )

    </div>


@else

    {{-- ============================================================
        DEVELOPER / LEAD DEVELOPER OWN TASK
        Status Update
    ============================================================= --}}

    <select
        class="form-select form-select-sm cs-status-select submodule-status"
        data-id="{{ $submodule->id }}"
        @if($submodule->isLocked()) disabled @endif
    >

        @foreach([
            'Pending',
            'Planning',
            'In Progress',
            'Testing',
            'Ready For Review',
            'On Hold',
            'Cancelled'
        ] as $status)

            <option
                value="{{ $status }}"
                @selected($submodule->status === $status)
            >
                {{ $status }}
            </option>

        @endforeach

    </select>


    @if($submodule->isLocked())

        <small class="cs-locked-note">
            <i class="bi bi-lock-fill"></i>
            Approved &amp; locked
        </small>

    @endif


    <a
        href="{{ route('admin.project-submodules.review.history', $submodule->id) }}"
        class="cs-review-history-link"
    >
        <i class="bi bi-clock-history"></i>
        Review History
    </a>

@endif



    </td>

</tr>

@empty

<tr>

    <td colspan="8">

        <div class="cs-empty-state">

            <div class="cs-empty-icon">
                <img src="{{ asset('assets/images/empty.svg') }}" width="170" alt="">
            </div>

            <h5>No sub modules found</h5>

            <p class="text-muted">
                Click &ldquo;Create Submodules&rdquo; to add the first sub module to this task board.
            </p>

        </div>

    </td>

</tr>

@endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if(method_exists($submodules,'links'))

        <div class="cs-panel-footer">
            {{ $submodules->links() }}
        </div>

        @endif

    </div>

</div>

@endsection


@push('css')

<style>

:root{
    --cs-primary:#0F8EA3;
    --cs-secondary:#16B6C8;
    --cs-dark:#172033;
    --cs-dark-2:#1F2937;
    --cs-bg:#F6F8FB;
    --cs-bg-2:#F8FAFC;
    --cs-border:#E5E7EB;
    --cs-white:#FFFFFF;

    --cs-amber:#B45309;
    --cs-amber-bg:#FEF3E2;
    --cs-red:#C4293A;
    --cs-red-bg:#FDECEE;
    --cs-green:#15803D;
    --cs-green-bg:#EAF7EF;
    --cs-violet:#7C3AED;
    --cs-violet-bg:#F3EEFD;
    --cs-blue:#0F8EA3;
    --cs-blue-bg:#E7F5F7;
}

.cs-workspace{
    font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--cs-dark-2);
    animation: csFadeUp .5s ease both;
}

@keyframes csFadeUp{
    from{ opacity:0; transform: translateY(10px); }
    to{ opacity:1; transform: translateY(0); }
}

/* ---------- Header ---------- */

.cs-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:11px;
    font-weight:700;
    letter-spacing:.14em;
    color: var(--cs-primary);
    margin-bottom:6px;
}

.cs-title{
    font-weight:700;
    font-size:26px;
    color: var(--cs-dark);
    margin:0 0 4px 0;
}

.cs-subtitle{
    font-size:13.5px;
    color:#6B7280;
    margin:0;
}

.cs-subtitle strong{
    color: var(--cs-dark-2);
    font-weight:600;
}

.cs-dot{
    margin:0 6px;
    color:#C7CDD6;
}

.cs-header-actions{
    display:flex;
    gap:10px;
}

.cs-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-size:13.5px;
    font-weight:600;
    padding:9px 16px;
    border-radius:10px;
    border:1px solid transparent;
    text-decoration:none;
    transition:.2s ease;
    white-space:nowrap;
}

.cs-btn-ghost{
    background: var(--cs-white);
    color: var(--cs-dark-2);
    border-color: var(--cs-border);
}

.cs-btn-ghost:hover{
    border-color: var(--cs-primary);
    color: var(--cs-primary);
    transform: translateY(-1px);
}

.cs-btn-primary{
    background: linear-gradient(135deg, var(--cs-primary), var(--cs-secondary));
    color: var(--cs-white);
    box-shadow: 0 6px 16px rgba(15,142,163,.25);
}

.cs-btn-primary:hover{
    color: var(--cs-white);
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(15,142,163,.32);
}

/* ---------- Overview strip ---------- */

.cs-overview{
    display:flex;
    align-items:center;
    background: var(--cs-white);
    border:1px solid var(--cs-border);
    border-radius:14px;
    padding:16px 22px;
    overflow-x:auto;
    box-shadow: 0 1px 2px rgba(16,24,40,.03);
}

.cs-metric{
    display:flex;
    flex-direction:column;
    gap:2px;
    padding-right:22px;
    min-width:max-content;
}

.cs-metric-value{
    font-size:20px;
    font-weight:700;
    color: var(--cs-dark);
    line-height:1.1;
}

.cs-metric-label{
    font-size:11px;
    font-weight:600;
    letter-spacing:.04em;
    color:#8A93A3;
    text-transform:uppercase;
}

.cs-metric-sep{
    width:1px;
    align-self:stretch;
    background: var(--cs-border);
    margin:0 20px;
    flex-shrink:0;
}

.cs-metric-status{
    padding-right:0;
}

.cs-text-progress{ color: var(--cs-blue); }
.cs-text-pending{ color: var(--cs-amber); }
.cs-text-approved{ color: var(--cs-green); }
.cs-text-waiting{ color: var(--cs-violet); }
.cs-text-changes{ color: var(--cs-red); }

/* ---------- Filter bar ---------- */

.cs-filterbar{
    background: var(--cs-white);
    border:1px solid var(--cs-border);
    border-radius:14px;
    padding:14px 18px;
}

.cs-input-icon{
    position:relative;
}

.cs-input-icon i{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#9AA4B2;
    font-size:13px;
}

.cs-input-icon input{
    padding-left:36px;
}

.cs-filterbar .form-control,
.cs-filterbar .form-select{
    height:40px;
    border-radius:10px;
    border-color: var(--cs-border);
    font-size:13.5px;
}

.cs-filterbar .form-control:focus,
.cs-filterbar .form-select:focus{
    border-color: var(--cs-primary);
    box-shadow: 0 0 0 3px rgba(15,142,163,.12);
}

/* ---------- Panel ---------- */

.cs-panel{
    background: var(--cs-white);
    border:1px solid var(--cs-border);
    border-radius:16px;
    overflow:hidden;
    box-shadow: 0 1px 2px rgba(16,24,40,.03);
}

.cs-panel-header{
    padding:16px 20px;
    border-bottom:1px solid var(--cs-border);
}

.cs-panel-header h5{
    font-size:14.5px;
    font-weight:700;
    color: var(--cs-dark);
    display:flex;
    align-items:center;
    gap:8px;
}

.cs-panel-header i{
    color: var(--cs-primary);
}

.cs-panel-body{
    padding:16px 14px 4px 14px;
}

.cs-panel-footer{
    padding:14px 20px;
    border-top:1px solid var(--cs-border);
    background: var(--cs-bg-2);
}

/* ---------- Task table styled as elevated rows ---------- */

.cs-task-table{
    border-collapse:separate;
    border-spacing:0 12px;
}

.cs-task-table thead th{
    border:none;
    background:transparent;
    font-size:11px;
    font-weight:700;
    letter-spacing:.06em;
    text-transform:uppercase;
    color:#9AA4B2;
    padding:0 16px 8px 16px;
    white-space:nowrap;
}

.cs-task-row{
    animation: csRowIn .4s ease both;
}

.cs-task-row:nth-child(1){ animation-delay: .02s; }
.cs-task-row:nth-child(2){ animation-delay: .05s; }
.cs-task-row:nth-child(3){ animation-delay: .08s; }
.cs-task-row:nth-child(4){ animation-delay: .11s; }
.cs-task-row:nth-child(5){ animation-delay: .14s; }
.cs-task-row:nth-child(n+6){ animation-delay: .16s; }

@keyframes csRowIn{
    from{ opacity:0; transform: translateY(6px); }
    to{ opacity:1; transform: translateY(0); }
}

.cs-task-row td{
    background: var(--cs-white);
    border-top:1px solid var(--cs-border);
    border-bottom:1px solid var(--cs-border);
    padding:16px;
    vertical-align:middle;
    transition: box-shadow .2s ease, transform .2s ease;
}

.cs-task-row td:first-child{
    border-left:1px solid var(--cs-border);
    border-top-left-radius:12px;
    border-bottom-left-radius:12px;
    border-left-width:4px;
}

.cs-task-row td:last-child{
    border-right:1px solid var(--cs-border);
    border-top-right-radius:12px;
    border-bottom-right-radius:12px;
}

.cs-task-row:hover td{
    box-shadow: 0 6px 18px rgba(15,142,163,.10);
    transform: translateY(-2px);
}

/* priority accent rail on first cell */
.cs-priority-critical td:first-child{ border-left-color: var(--cs-red); }
.cs-priority-high td:first-child{ border-left-color: var(--cs-amber); }
.cs-priority-medium td:first-child{ border-left-color: var(--cs-blue); }
.cs-priority-low td:first-child{ border-left-color: #C7CDD6; }

.cs-index{
    font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    font-size:12px;
    color:#9AA4B2;
    font-weight:600;
}

.cs-task-path{
    font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    font-size:11px;
    color:#9AA4B2;
    margin-bottom:4px;
    display:flex;
    align-items:center;
    gap:6px;
}

.cs-task-path i{
    font-size:8px;
    color:#C7CDD6;
}

.cs-task-title{
    font-size:14.5px;
    font-weight:700;
    color: var(--cs-dark);
}

.cs-task-desc{
    font-size:12.5px;
    color:#8A93A3;
    margin-top:2px;
}

.cs-task-remark{
    margin-top:6px;
    font-size:12px;
    color: var(--cs-red);
    background: var(--cs-red-bg);
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 9px;
    border-radius:8px;
}

.cs-dev-chip{
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-size:12.5px;
    font-weight:600;
    color: var(--cs-dark-2);
    background: var(--cs-bg-2);
    border:1px solid var(--cs-border);
    padding:5px 10px 5px 5px;
    border-radius:999px;
}

.cs-dev-avatar{
    width:22px;
    height:22px;
    border-radius:50%;
    background: linear-gradient(135deg, var(--cs-primary), var(--cs-secondary));
    color:#fff;
    font-size:10.5px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
}

.cs-dev-chip-empty{
    color:#9AA4B2;
    padding:5px 10px;
}

.cs-status-cell .badge{
    font-weight:600;
    font-size:11.5px;
    padding:5px 10px;
    border-radius:999px;
}

/* soften loud bootstrap semantic badge colors wherever the status
   partial happens to use them, without touching its markup */
.cs-status-cell .bg-success{ background-color: var(--cs-green-bg) !important; color: var(--cs-green) !important; }
.cs-status-cell .bg-danger{ background-color: var(--cs-red-bg) !important; color: var(--cs-red) !important; }
.cs-status-cell .bg-warning{ background-color: var(--cs-amber-bg) !important; color: var(--cs-amber) !important; }
.cs-status-cell .bg-primary{ background-color: var(--cs-blue-bg) !important; color: var(--cs-blue) !important; }
.cs-status-cell .bg-info{ background-color: var(--cs-blue-bg) !important; color: var(--cs-blue) !important; }
.cs-status-cell .bg-secondary{ background-color: var(--cs-bg-2) !important; color:#6B7280 !important; }

.cs-priority-tag{
    display:inline-flex;
    align-items:center;
    gap:7px;
    font-size:12.5px;
    font-weight:600;
    color: var(--cs-dark-2);
}

.cs-priority-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:#C7CDD6;
}

.cs-priority-tag-critical .cs-priority-dot{ background: var(--cs-red); box-shadow:0 0 0 3px var(--cs-red-bg); }
.cs-priority-tag-high .cs-priority-dot{ background: var(--cs-amber); box-shadow:0 0 0 3px var(--cs-amber-bg); }
.cs-priority-tag-medium .cs-priority-dot{ background: var(--cs-blue); box-shadow:0 0 0 3px var(--cs-blue-bg); }
.cs-priority-tag-low .cs-priority-dot{ background:#C7CDD6; }

.cs-progress{
    height:5px;
    border-radius:20px;
    background: var(--cs-bg-2);
    overflow:hidden;
}

.cs-progress-bar{
    height:100%;
    border-radius:20px;
    transition: width .4s ease;
}

.cs-progress-complete{ background: var(--cs-green); }
.cs-progress-good{ background: var(--cs-primary); }
.cs-progress-mid{ background: var(--cs-amber); }
.cs-progress-low{ background: var(--cs-red); }

.cs-progress-label{
    display:block;
    margin-top:5px;
    font-size:11.5px;
    font-weight:700;
    color:#6B7280;
}

.cs-deadline{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:12.5px;
    font-weight:700;
}

.cs-deadline i{ font-size:11px; }

.cs-deadline-overdue{ color: var(--cs-red); }
.cs-deadline-soon{ color: var(--cs-amber); }
.cs-deadline-normal{ color: var(--cs-green); font-weight:600; }
.cs-deadline-none{ color:#C7CDD6; }

.cs-status-select{
    border-radius:9px;
    font-size:12.5px;
    border-color: var(--cs-border);
}

.cs-status-select:focus{
    border-color: var(--cs-primary);
    box-shadow: 0 0 0 3px rgba(15,142,163,.12);
}

.cs-locked-note{
    display:block;
    margin-top:6px;
    color: var(--cs-green);
    font-size:11.5px;
}

.cs-review-history-link{
    display:inline-flex;
    align-items:center;
    gap:5px;
    margin-top:7px;
    font-size:11.5px;
    color: var(--cs-primary);
    text-decoration:none;
}

.cs-review-history-link:hover{
    text-decoration:underline;
}

.cs-review-actions{
    display:flex;
    align-items:center;
    gap:6px;
}

/* ---------- Empty state ---------- */

.cs-empty-state{
    text-align:center;
    padding:56px 20px;
}

.cs-empty-icon{
    opacity:.85;
    margin-bottom:10px;
}

.cs-empty-state h5{
    font-weight:700;
    color: var(--cs-dark);
    margin-bottom:6px;
}

/* ---------- Misc / preserved base rules ---------- */

.btn-sm{
    border-radius:8px;
}

@media (max-width: 768px){
    .cs-header{
        flex-direction:column;
        align-items:flex-start;
        gap:14px;
    }

    .cs-header-actions{
        width:100%;
    }

    .cs-header-actions .cs-btn{
        flex:1;
        justify-content:center;
    }

    .cs-overview{
        flex-wrap:wrap;
        gap:14px 0;
    }

    .cs-metric{
        padding-right:16px;
    }

    .cs-metric-sep{
        display:none;
    }
}

@media (prefers-reduced-motion: reduce){
    .cs-workspace,
    .cs-task-row{
        animation:none !important;
    }
    .cs-task-row:hover td{
        transform:none;
    }
}

</style>

@endpush



@push('js')

<script>

document.addEventListener('DOMContentLoaded',function(){

    const search=document.getElementById('searchInput');

    const status=document.getElementById('statusFilter');

    const priority=document.getElementById('priorityFilter');

    function filterTable(){

        let keyword=search.value.toLowerCase();

        let statusValue=status.value.toLowerCase();

        let priorityValue=priority.value.toLowerCase();

        let rows=document.querySelectorAll('#subModuleTable tr');

        rows.forEach(function(row){

            let text=row.innerText.toLowerCase();

            let show=true;

            if(keyword && !text.includes(keyword)){
                show=false;
            }

            if(statusValue && !text.includes(statusValue)){
                show=false;
            }

            if(priorityValue && !text.includes(priorityValue)){
                show=false;
            }

            row.style.display=show ? '' : 'none';

        });

    }

    search.addEventListener('keyup',filterTable);

    status.addEventListener('change',filterTable);

    priority.addEventListener('change',filterTable);

});

// Developer status dropdown — unchanged endpoint, now also skips
// locked (disabled) selects automatically since the browser won't
// fire change events on a disabled <select>.
document.addEventListener('change', function (e) {

    if (!e.target.classList.contains('submodule-status')) return;

    let id = e.target.dataset.id;

    fetch('/admin/project-submodules/' + id + '/status', {

        method: 'PATCH',

        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },

        body: JSON.stringify({
            status: e.target.value
        })

    })
    .then(res => {
        if (!res.ok) {
            return res.json().then(err => { throw err; });
        }
        return res.json();
    })
    .then(res => {
        location.reload();
    })
    .catch(err => {
        alert(err.message || 'Could not update status.');
        location.reload();
    });

});

</script>

@endpush
