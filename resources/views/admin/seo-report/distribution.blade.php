@extends('index')

@section('title', 'SEO Task Distribution')

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


@endpush

@section('content')

@php
    use Carbon\Carbon;

    $startCarbon = Carbon::parse($package->start_date);
    $endCarbon   = Carbon::parse($package->end_date);
    $todayCarbon = Carbon::now();

    $totalPlanDays = max($startCarbon->diffInDays($endCarbon), 1);

    if ($todayCarbon->lt($startCarbon)) {
        $progressPercent = 0;
    } elseif ($todayCarbon->gt($endCarbon)) {
        $progressPercent = 100;
    } else {
        $progressPercent = (int) round($startCarbon->diffInDays($todayCarbon) / $totalPlanDays * 100);
    }

    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];
@endphp

<div class="csp-page">

    {{-- ===========================================
        Page Header
    =========================================== --}}
    <div class="csp-topbar fade-up">
        <div class="csp-topbar-left">
            <a href="{{ url()->previous() }}" class="csp-back-btn" aria-label="Go back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="csp-heading">SEO Task Distribution</h1>
                <p class="csp-subheading">Assign Monday to Saturday SEO tasks to your team members.</p>
            </div>
        </div>

        <div class="csp-topbar-right">
            <button type="submit" form="distributionForm" class="csp-btn-primary" id="saveTopBtn">
                <span class="btn-label"><i class="fa-solid fa-floppy-disk"></i> Save Distribution</span>
                <span class="btn-loading d-none"><i class="fa-solid fa-spinner fa-spin"></i> Saving...</span>
            </button>
        </div>
    </div>

    <form id="distributionForm" action="{{ route('admin.seo.task.distribution.store', $package->id) }}" method="POST">
        @csrf

        {{-- ===========================================
            Client Overview Card
        =========================================== --}}
        <div class="csp-card csp-overview fade-up">
            <div class="csp-overview-left">
                <div class="csp-logo-wrap">
                    @if($package->company->logo)
                        <img src="{{ asset($package->company->logo) }}" class="csp-logo-img" alt="{{ $package->company->company_name }}">
                    @else
                        <div class="csp-logo-fallback">
                            {{ strtoupper(substr($package->company->company_name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="csp-overview-info">
                    <h2 class="csp-company-name">{{ $package->company->company_name }}</h2>
                    <span class="csp-plan-badge">
                        <i class="fa-solid fa-sparkles"></i> {{ $package->seoPlan->name }}
                    </span>

                    <div class="csp-person-row">
                        <div>
                            <small class="csp-label">SEO Head</small>
                            <span class="csp-value">{{ $package->assignedUser->name ?? '-' }}</span>
                        </div>
                        <div>
                            <small class="csp-label">Designation</small>
                            <span class="csp-value">{{ optional($package->assignedUser->designation)->title ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="csp-overview-right">
                <div class="csp-mini-stat">
                    <div class="csp-mini-icon"><i class="fa-solid fa-calendar-day"></i></div>
                    <small class="csp-label">Start Date</small>
                    <div class="csp-mini-value">{{ $startCarbon->format('d M Y') }}</div>
                </div>

                <div class="csp-mini-stat">
                    <div class="csp-mini-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <small class="csp-label">End Date</small>
                    <div class="csp-mini-value">{{ $endCarbon->format('d M Y') }}</div>
                </div>

                <div class="csp-mini-stat">
                    <div class="csp-mini-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                    <small class="csp-label">Duration</small>
                    <div class="csp-mini-value">{{ $package->seoPlan->duration }} Month</div>
                </div>

                <div class="csp-mini-stat csp-progress-stat">
                    <small class="csp-label">Plan Progress</small>
                    <div class="csp-progress-track">
                        <div class="csp-progress-fill" style="width: {{ $progressPercent }}%;"></div>
                    </div>
                    <div class="csp-mini-value">{{ $progressPercent }}%</div>
                </div>
            </div>
        </div>

        {{-- ===========================================
            Stats Section
        =========================================== --}}
        <div class="csp-stats-grid fade-up">
            <div class="csp-stat-card">
                <div class="csp-stat-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                <div>
                    <small class="csp-label">Total Tasks</small>
                    <h3 class="csp-stat-value" data-counter="{{ $totalTasks }}">0</h3>
                </div>
            </div>

            <div class="csp-stat-card">
                <div class="csp-stat-icon csp-stat-icon-success"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                    <small class="csp-label">Assigned</small>
                    <h3 class="csp-stat-value assignedCount" data-counter="{{ $assignedTasks }}">0</h3>
                </div>
            </div>

            <div class="csp-stat-card">
                <div class="csp-stat-icon csp-stat-icon-danger"><i class="fa-solid fa-circle-exclamation"></i></div>
                <div>
                    <small class="csp-label">Remaining</small>
                    <h3 class="csp-stat-value remainingCount" data-counter="{{ $remainingTasks }}">0</h3>
                </div>
            </div>

            <div class="csp-stat-card">
                <div class="csp-stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <small class="csp-label">SEO Executives</small>
                    <h3 class="csp-stat-value" data-counter="{{ $seoUsers->count() }}">0</h3>
                </div>
            </div>
        </div>

        {{-- ===========================================
            Toolbar - Search + Bulk Assign
        =========================================== --}}
        <div class="csp-card csp-toolbar fade-up">
            <div class="csp-search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="taskSearch" class="csp-search-input" placeholder="Search a task...">
            </div>

            <div class="csp-bulk-wrap">
                <select class="csp-select bulkAssign">
                    <option value="">Bulk Assign SEO Executive</option>
                    @foreach($seoUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ===========================================
            Weekly Accordion
        =========================================== --}}
        <div class="csp-accordion fade-up" id="weekAccordion">

            @foreach($days as $day)
                @php
                    $dayId = 'day' . $loop->index;
                    $dayTasks = $weeklyTasks[$day];
                @endphp

                <div class="csp-day-card">
                    <button type="button" class="csp-day-header" data-bs-toggle="collapse" data-bs-target="#{{ $dayId }}" aria-expanded="false" aria-controls="{{ $dayId }}" data-day="{{ $dayId }}">
                        <div class="csp-day-header-left">
                            <div class="csp-day-icon"><i class="fa-solid fa-calendar-day"></i></div>
                            <div>
                                <h5 class="csp-day-title">{{ $day }}</h5>
                                <small class="csp-day-sub">{{ $dayTasks->count() }} tasks available</small>
                            </div>
                        </div>
                        <div class="csp-day-header-right">
                            <span class="csp-count-badge">{{ $dayTasks->count() }} Tasks</span>
                            <i class="fa-solid fa-chevron-down csp-chevron"></i>
                        </div>
                    </button>

                    <div class="collapse" id="{{ $dayId }}" data-bs-parent="#weekAccordion">
                        <div class="csp-day-body">

                            @forelse($dayTasks as $index => $task)
                                <div class="csp-task-card task-card">
                                    <div class="csp-task-left">
                                        <span class="csp-task-number">{{ $index + 1 }}</span>
                                        <div>
                                            <div class="csp-task-title">{{ $task->task_title }}</div>
                                            <small class="csp-task-sub">SEO Task &middot; {{ $day }}</small>
                                        </div>
                                    </div>

                                    <div class="csp-task-center">
                                        <select class="csp-select task-user-select" name="tasks[{{ $task->id }}]">
                                            <option value="">Select SEO Executive</option>
                                            @foreach($seoUsers as $user)
                                                <option value="{{ $user->id }}" {{ ($assignedUsers[$task->id] ?? '') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="csp-task-right">
                                        @if($task->sort_order == 1)
                                            <span class="csp-pill csp-pill-high">High</span>
                                        @elseif($task->sort_order == 2)
                                            <span class="csp-pill csp-pill-medium">Medium</span>
                                        @else
                                            <span class="csp-pill csp-pill-low">Normal</span>
                                        @endif

                                        @if($task->status)
                                            <span class="csp-status csp-status-active">Active</span>
                                        @else
                                            <span class="csp-status csp-status-disabled">Disabled</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="csp-empty-state">
                                    <i class="fa-regular fa-calendar-xmark"></i>
                                    <div class="csp-empty-title">No tasks found</div>
                                    <small class="csp-empty-sub">There are no SEO tasks scheduled for {{ $day }}.</small>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Spacer so content isn't hidden behind sticky bar --}}
        <div style="height: 110px;"></div>

        {{-- ===========================================
            Sticky Bottom Bar
        =========================================== --}}
        <div class="csp-sticky-bar">
            <div class="csp-sticky-inner">
                <div class="csp-sticky-text">
                    <div class="csp-sticky-title">Distribution Summary</div>
                    <small class="csp-sticky-sub">Please assign every task before saving.</small>
                </div>

                <div class="csp-sticky-actions">
                    <span class="csp-sticky-chip csp-sticky-chip-success">
                        Assigned <strong class="assignedCount">{{ $assignedTasks }}</strong>
                    </span>
                    <span class="csp-sticky-chip csp-sticky-chip-danger">
                        Remaining <strong class="remainingCount">{{ $remainingTasks }}</strong>
                    </span>

                    <button type="submit" form="distributionForm" class="csp-btn-primary csp-btn-pill" id="saveStickyBtn">
                        <span class="btn-label"><i class="fa-solid fa-floppy-disk"></i> Save Distribution</span>
                        <span class="btn-loading d-none"><i class="fa-solid fa-spinner fa-spin"></i> Saving...</span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>


@endsection

@push('css')
<style>
:root{
    --csp-primary:#0F8EA3;
    --csp-secondary:#16B6C8;
    --csp-dark:#1F2937;
    --csp-bg:#FFFFFF;
    --csp-bg-soft:#F8FAFC;
    --csp-border:#E5E7EB;
    --csp-radius:20px;
    --csp-shadow:0 10px 30px rgba(15,142,163,.08);
}

.csp-page{
    font-family:'Inter','Segoe UI',sans-serif;
    color:var(--csp-dark);
    /* background:var(--csp-bg-soft); */
    background: white;
    padding:28px;
    border-radius:24px;
}

/* ---------- Header ---------- */
.csp-topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:24px;
    flex-wrap:wrap;
    gap:16px;
}
.csp-topbar-left{ display:flex; align-items:center; gap:16px; }
.csp-back-btn{
    width:44px; height:44px;
    display:flex; align-items:center; justify-content:center;
    background:#fff; border:1px solid var(--csp-border);
    border-radius:50%; color:var(--csp-dark);
    box-shadow:var(--csp-shadow);
    transition:all .2s ease;
}
.csp-back-btn:hover{ transform:translateY(-2px); color:var(--csp-primary); }
.csp-heading{ font-size:32px; font-weight:700; margin:0; letter-spacing:-0.02em; }
.csp-subheading{ font-size:15px; color:#6B7280; margin:2px 0 0; }

.csp-btn-primary{
    border:none;
    background:linear-gradient(135deg, var(--csp-primary), var(--csp-secondary));
    color:#fff;
    font-weight:600;
    font-size:14.5px;
    padding:13px 26px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(15,142,163,.25);
    transition:all .2s ease;
    position:relative;
    overflow:hidden;
}
.csp-btn-primary:hover{ transform:translateY(-2px); box-shadow:0 12px 26px rgba(15,142,163,.35); color:#fff; }
.csp-btn-primary .btn-label, .csp-btn-primary .btn-loading{ display:inline-flex; align-items:center; gap:8px; }
.csp-btn-pill{ border-radius:999px; }
.csp-ripple{
    position:absolute; border-radius:50%; background:rgba(255,255,255,.5);
    transform:scale(0); animation:csp-ripple .6s ease-out; pointer-events:none;
}
@keyframes csp-ripple{ to{ transform:scale(3); opacity:0; } }

/* ---------- Card base ---------- */
.csp-card{
    background:#fff;
    border:1px solid var(--csp-border);
    border-radius:var(--csp-radius);
    /* box-shadow:var(--csp-shadow); */
    padding:28px;
    margin-bottom:24px;
    transition:transform .25s ease, box-shadow .25s ease;
}

/* ---------- Overview ---------- */
.csp-overview{ display:flex; justify-content:space-between; align-items:center; gap:24px; flex-wrap:wrap; }
.csp-overview-left{ display:flex; align-items:center; gap:20px; }
.csp-logo-wrap img.csp-logo-img{
    width:76px; height:76px; border-radius:18px; object-fit:cover; border:1px solid var(--csp-border);
}
.csp-logo-fallback{
    width:76px; height:76px; border-radius:18px;
    background:linear-gradient(135deg, var(--csp-primary), var(--csp-secondary));
    color:#fff; display:flex; align-items:center; justify-content:center;
    font-size:28px; font-weight:700;
}
.csp-company-name{ font-size:20px; font-weight:700; margin:0 0 6px; }
.csp-plan-badge{
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(15,142,163,.08); color:var(--csp-primary);
    font-size:12.5px; font-weight:600;
    padding:6px 14px; border-radius:999px; margin-bottom:14px;
}
.csp-person-row{ display:flex; gap:36px; }
.csp-label{ display:block; font-size:13px; color:#9CA3AF; margin-bottom:2px; }
.csp-value{ font-weight:600; font-size:14.5px; }

.csp-overview-right{ display:flex; gap:14px; flex-wrap:wrap; }
.csp-mini-stat{
    background:var(--csp-bg-soft);
    border:1px solid var(--csp-border);
    border-radius:16px;
    padding:16px 18px;
    min-width:118px;
    text-align:center;
}
.csp-mini-icon{ color:var(--csp-primary); font-size:15px; margin-bottom:6px; }
.csp-mini-value{ font-weight:700; font-size:15px; margin-top:2px; }
.csp-progress-stat{ min-width:150px; }
.csp-progress-track{
    height:6px; border-radius:999px; background:var(--csp-border);
    margin:8px 0 6px; overflow:hidden;
}
.csp-progress-fill{
    height:100%; border-radius:999px;
    background:linear-gradient(90deg, var(--csp-primary), var(--csp-secondary));
    transition:width 1s ease;
}

/* ---------- Stats grid ---------- */
.csp-stats-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:20px;
    margin-bottom:24px;
}
.csp-stat-card{
    background:#fff; border:1px solid var(--csp-border); border-radius:var(--csp-radius);
    /* box-shadow:var(--csp-shadow); */
    padding:22px; display:flex; align-items:center; gap:16px;
    transition:transform .25s ease, box-shadow .25s ease;
}
.csp-stat-card:hover{ transform:translateY(-3px); box-shadow:0 16px 34px rgba(15,142,163,.14); }
.csp-stat-icon{
    width:48px; height:48px; border-radius:14px;
    background:rgba(15,142,163,.08); color:var(--csp-primary);
    display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;
}
.csp-stat-icon-success{ background:rgba(16,185,129,.1); color:#10B981; }
.csp-stat-icon-danger{ background:rgba(239,68,68,.08); color:#EF4444; }
.csp-stat-value{ font-size:24px; font-weight:700; margin:2px 0 0; }

/* ---------- Toolbar ---------- */
.csp-toolbar{ display:flex; align-items:center; gap:18px; flex-wrap:wrap; padding:18px 24px; }
.csp-search-wrap{
    flex:1; min-width:220px; display:flex; align-items:center; gap:10px;
    border:1px solid var(--csp-border); border-radius:12px; padding:12px 16px;
    background:var(--csp-bg-soft); transition:border-color .2s, box-shadow .2s;
}
.csp-search-wrap i{ color:#9CA3AF; }
.csp-search-wrap:focus-within{ border-color:var(--csp-primary); box-shadow:0 0 0 4px rgba(15,142,163,.12); background:#fff; }
.csp-search-input{ border:none; outline:none; background:transparent; width:100%; font-size:14.5px; }
.csp-bulk-wrap{ min-width:260px; }

/* ---------- Select / dropdown ---------- */
.csp-select{
    width:100%; height:48px; border-radius:12px;
    border:1px solid var(--csp-border);
    padding:0 16px; font-size:14.5px; background:#fff;
    transition:border-color .2s, box-shadow .2s;
}
.csp-select:focus{ outline:none; border-color:var(--csp-primary); box-shadow:0 0 0 4px rgba(15,142,163,.14); }

/* Choices.js theming */
.choices{ margin-bottom:0; }
.choices__inner{
    min-height:48px; border-radius:12px !important; border:1px solid var(--csp-border) !important;
    background:#fff !important; padding:8px 14px !important; font-size:14.5px;
}
.choices.is-focused .choices__inner{ border-color:var(--csp-primary) !important; box-shadow:0 0 0 4px rgba(15,142,163,.14); }
.choices__list--dropdown{ border-radius:12px !important; border-color:var(--csp-border) !important; overflow:hidden; }
.choices__list--dropdown .choices__item--selectable.is-highlighted{ background:rgba(15,142,163,.08) !important; color:var(--csp-primary); }
.choices__input{ background:#fff !important; }

/* ---------- Accordion ---------- */
.csp-day-card{
    background:#fff; border:1px solid var(--csp-border); border-radius:var(--csp-radius);
    /* box-shadow:var(--csp-shadow); */
    margin-bottom:18px;
}
.csp-day-header{
    width:100%; border:none; background:#fff; padding:22px 26px;
    display:flex; align-items:center; justify-content:space-between; cursor:pointer;
}
.csp-day-header-left{ display:flex; align-items:center; gap:16px; }
.csp-day-icon{
    width:48px; height:48px; border-radius:14px; background:rgba(15,142,163,.08); color:var(--csp-primary);
    display:flex; align-items:center; justify-content:center; font-size:17px;
}
.csp-day-title{ font-size:17px; font-weight:600; margin:0; text-align:left; }
.csp-day-sub{ color:#9CA3AF; font-size:13px; }
.csp-day-header-right{ display:flex; align-items:center; gap:14px; }
.csp-count-badge{
    background:rgba(15,142,163,.08); color:var(--csp-primary); font-weight:600;
    font-size:13px; padding:7px 16px; border-radius:999px;
}
.csp-chevron{ color:#9CA3AF; transition:transform .3s ease; }
.csp-day-header[aria-expanded="true"] .csp-chevron{ transform:rotate(180deg); color:var(--csp-primary); }

.csp-day-body{ padding:8px 24px 24px; display:flex; flex-direction:column; gap:14px; }

/* ---------- Task card ---------- */
.csp-task-card{
    display:flex; align-items:center; justify-content:space-between; gap:20px;
    background:var(--csp-bg-soft); border:1px solid var(--csp-border); border-radius:16px;
    padding:18px 20px; flex-wrap:wrap; transition:transform .2s ease, box-shadow .2s ease, border-color .2s;
}
.csp-task-card:hover{ 
    /* transform:translateY(-2px);  */
    box-shadow:0 10px 24px rgba(15,142,163,.1); border-color:rgba(15,142,163,.25); }
.csp-task-left{ display:flex; align-items:center; gap:14px; flex:1; min-width:220px; }
.csp-task-number{
    width:34px; height:34px; border-radius:10px; background:#fff; border:1px solid var(--csp-border);
    color:var(--csp-primary); font-weight:700; font-size:13.5px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.csp-task-title{ font-weight:600; font-size:14.5px; }
.csp-task-sub{ color:#9CA3AF; font-size:12.5px; }
.csp-task-center{ width:260px; flex-shrink:0; }
.csp-task-right{ display:flex; align-items:center; gap:10px; flex-shrink:0; }

/* Pills */
.csp-pill{ font-size:12px; font-weight:600; padding:6px 14px; border-radius:999px; }
.csp-pill-high{ background:rgba(239,68,68,.08); color:#DC2626; }
.csp-pill-medium{ background:rgba(245,158,11,.12); color:#B45309; }
.csp-pill-low{ background:rgba(59,130,246,.1); color:#2563EB; }

.csp-status{ font-size:12px; font-weight:600; padding:6px 14px; border-radius:999px; }
.csp-status-active{ background:rgba(16,185,129,.1); color:#059669; }
.csp-status-disabled{ background:#F3F4F6; color:#9CA3AF; }

/* Empty state */
.csp-empty-state{ text-align:center; padding:40px 10px; color:#9CA3AF; }
.csp-empty-state i{ font-size:30px; margin-bottom:10px; color:#D1D5DB; }
.csp-empty-title{ font-weight:600; color:var(--csp-dark); }
.csp-empty-sub{ font-size:13px; }

/* ---------- Sticky bar ---------- */
.csp-sticky-bar{
    position:fixed; left:50%; bottom:22px; transform:translateX(-50%);
    width:min(920px, 94%); z-index:1050;
}
.csp-sticky-inner{
    background:rgba(255,255,255,.75);
    backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
    border:1px solid rgba(229,231,235,.8);
    border-radius:999px; box-shadow:0 20px 50px rgba(15,142,163,.18);
    padding:14px 24px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;
}
.csp-sticky-title{ font-weight:600; font-size:14.5px; }
.csp-sticky-sub{ color:#9CA3AF; font-size:12.5px; }
.csp-sticky-actions{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.csp-sticky-chip{ font-size:13px; font-weight:600; padding:8px 14px; border-radius:999px; }
.csp-sticky-chip-success{ background:rgba(16,185,129,.1); color:#059669; }
.csp-sticky-chip-danger{ background:rgba(239,68,68,.08); color:#DC2626; }

/* ---------- Fade animation fallback (no-JS / reduced motion) ---------- */
.fade-up{ opacity:1; }
@media (prefers-reduced-motion: reduce){
    .csp-btn-primary, .csp-back-btn, .csp-stat-card, .csp-task-card{ transition:none !important; }
}

/* ---------- Responsive ---------- */
@media (max-width: 992px){
    .csp-stats-grid{ grid-template-columns:repeat(2, 1fr); }
    .csp-overview{ flex-direction:column; align-items:flex-start; }
    .csp-task-center{ width:100%; }
}
@media (max-width: 576px){
    .csp-page{ padding:16px; }
    .csp-stats-grid{ grid-template-columns:1fr; }
    .csp-heading{ font-size:24px; }
    .csp-sticky-inner{ flex-direction:column; align-items:flex-start; border-radius:24px; }
    .csp-task-card{ flex-direction:column; align-items:flex-start; }
    .csp-task-right{ width:100%; justify-content:space-between; }
}
</style>
@endpush

@push('js')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Entrance animation
    |--------------------------------------------------------------------------
    */
    if (window.gsap) {
        gsap.from('.fade-up', {
            y: 18,
            opacity: 0,
            duration: 0.5,
            stagger: 0.08,
            ease: 'power2.out'
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Searchable dropdowns (Choices.js)
    |--------------------------------------------------------------------------
    */
    document.querySelectorAll('.task-user-select').forEach(function (select) {
        if (window.Choices) {
            select._choices = new Choices(select, {
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: '',
                placeholder: true,
                searchPlaceholderValue: 'Search executive...'
            });
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Animated counters
    |--------------------------------------------------------------------------
    */
    function animateValue(el, end) {
        if (!el) return;
        var start = 0;
        var duration = 700;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            el.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.innerHTML = end;
            }
        }
        window.requestAnimationFrame(step);
    }

    document.querySelectorAll('[data-counter]').forEach(function (el) {
        animateValue(el, parseInt(el.getAttribute('data-counter'), 10) || 0);
    });

    /*
    |--------------------------------------------------------------------------
    | Search filter
    |--------------------------------------------------------------------------
    */
    var searchInput = document.getElementById('taskSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            var value = this.value.toLowerCase();
            document.querySelectorAll('.task-card').forEach(function (card) {
                card.style.display = card.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk assign
    |--------------------------------------------------------------------------
    */
    var bulkAssign = document.querySelector('.bulkAssign');
    if (bulkAssign) {
        bulkAssign.addEventListener('change', function () {
            var value = this.value;
            if (value === '') return;

            document.querySelectorAll('.task-user-select').forEach(function (select) {
                select.value = value;
                if (select._choices) {
                    select._choices.setChoiceByValue(value);
                }
                select.dispatchEvent(new Event('change'));
            });

            updateCounter();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Counter (assigned / remaining)
    |--------------------------------------------------------------------------
    */
    function updateCounter() {
        var total = document.querySelectorAll('.task-user-select').length;
        var assigned = 0;

        document.querySelectorAll('.task-user-select').forEach(function (select) {
            if (select.value !== '') {
                assigned++;
            }
        });

        var remaining = total - assigned;

        document.querySelectorAll('.assignedCount').forEach(function (item) {
            item.innerHTML = assigned;
        });

        document.querySelectorAll('.remainingCount').forEach(function (item) {
            item.innerHTML = remaining;
        });
    }

    document.querySelectorAll('.task-user-select').forEach(function (select) {
        select.addEventListener('change', updateCounter);
    });

    /*
    |--------------------------------------------------------------------------
    | Remember opened accordion day
    |--------------------------------------------------------------------------
    */
    var STORAGE_KEY = 'seo_distribution_open_day';
    var accordion = document.getElementById('weekAccordion');

    if (accordion) {
        var storedDay = null;
        try { storedDay = localStorage.getItem(STORAGE_KEY); } catch (e) {}

        var targetId = storedDay || 'day0';
        var targetHeader = accordion.querySelector('[data-day="' + targetId + '"]');
        var targetPanel = document.getElementById(targetId);

        if (targetPanel && window.bootstrap) {
            new bootstrap.Collapse(targetPanel, { toggle: true });
            if (targetHeader) targetHeader.setAttribute('aria-expanded', 'true');
        }

        accordion.querySelectorAll('.collapse').forEach(function (panel) {
            panel.addEventListener('shown.bs.collapse', function () {
                try { localStorage.setItem(STORAGE_KEY, panel.id); } catch (e) {}
                var header = accordion.querySelector('[data-day="' + panel.id + '"]');
                if (header) header.setAttribute('aria-expanded', 'true');
            });
            panel.addEventListener('hidden.bs.collapse', function () {
                var header = accordion.querySelector('[data-day="' + panel.id + '"]');
                if (header) header.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Button ripple effect
    |--------------------------------------------------------------------------
    */
    document.querySelectorAll('.csp-btn-primary').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var rect = btn.getBoundingClientRect();
            var ripple = document.createElement('span');
            var size = Math.max(rect.width, rect.height);
            ripple.className = 'csp-ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            btn.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 600);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Save validation + loading state
    |--------------------------------------------------------------------------
    */
    var form = document.getElementById('distributionForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            var pending = 0;

            document.querySelectorAll('.task-user-select').forEach(function (select) {
                if (select.value === '') {
                    pending++;
                }
            });

            if (pending > 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Distribution',
                    text: 'Please assign every SEO task before saving.',
                    confirmButtonColor: '#0F8EA3'
                });
                return;
            }

            document.querySelectorAll('.csp-btn-primary').forEach(function (btn) {
                btn.querySelector('.btn-label').classList.add('d-none');
                btn.querySelector('.btn-loading').classList.remove('d-none');
                btn.setAttribute('disabled', 'disabled');
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Initial counter
    |--------------------------------------------------------------------------
    */
    updateCounter();

});
</script>

@endpush