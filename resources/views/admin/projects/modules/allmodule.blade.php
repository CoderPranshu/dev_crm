@extends('index')

@section('title','My Modules')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root{
        --cs-primary:#138A9E;
        --cs-accent:#17B7CF;
        --cs-success:#16C784;
        --cs-danger:#EF4444;
        --cs-warning:#F59E0B;
        --cs-bg:#F8FAFC;
        --cs-card:#FFFFFF;
        --cs-border:#E5E7EB;
        --cs-radius:20px;
        --cs-radius-sm:12px;
        --cs-ink:#0F172A;
        --cs-muted:#64748B;
        --cs-shadow: 0 1px 2px rgba(15,23,42,.04), 0 12px 32px -16px rgba(19,138,158,.18);
    }

    #cs-modules{
        background:var(--cs-bg);
        font-family:'Inter',sans-serif;
        color:var(--cs-ink);
        padding:28px clamp(4px,2vw,8px) 60px;
    }
    #cs-modules .cs-num{ font-family:'JetBrains Mono',monospace; font-weight:600; }
    #cs-modules h1, #cs-modules h2, #cs-modules h3, #cs-modules .cs-display{
        font-family:'Plus Jakarta Sans',sans-serif;
    }

    /* ---------- Hero ---------- */
    .cs-hero{
        position:relative;
        border-radius:var(--cs-radius);
        padding:32px clamp(20px,4vw,40px);
        margin-bottom:24px;
        overflow:hidden;
        background:linear-gradient(120deg,#0F2E36 0%, #0B4B5C 45%, #0E7C93 100%);
        color:#fff;
        box-shadow:var(--cs-shadow);
    }
    .cs-hero::before{
        content:"";
        position:absolute; inset:0;
        background:
            radial-gradient(600px 240px at 85% -10%, rgba(23,183,207,.35), transparent 60%),
            radial-gradient(400px 200px at 100% 100%, rgba(22,199,132,.18), transparent 60%);
        pointer-events:none;
    }
    .cs-hero-top{ position:relative; z-index:1; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:flex-end; gap:16px; }
    .cs-hero-eyebrow{ font-size:.72rem; letter-spacing:.14em; text-transform:uppercase; color:rgba(255,255,255,.65); font-weight:600; margin-bottom:6px; }
    .cs-hero-title{ font-size:clamp(1.5rem,2.4vw,2rem); font-weight:700; margin:0; }
    .cs-hero-title span{ color:#7EE8D6; }
    .cs-hero-date{ font-size:.85rem; color:rgba(255,255,255,.75); font-weight:500; margin-top:4px; }
    .cs-hero-badge{
        display:inline-flex; align-items:center; gap:8px;
        background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18);
        backdrop-filter:blur(8px);
        border-radius:999px; padding:8px 16px; font-size:.8rem; font-weight:600;
    }
    .cs-hero-badge i{ color:#7EE8D6; }

    /* ---------- Stat cards ---------- */
    .cs-stats{ display:grid; grid-template-columns:repeat(auto-fit,minmax(168px,1fr)); gap:14px; margin-top:22px; position:relative; z-index:1; }
    .cs-stat{
        position:relative;
        border-radius:16px;
        padding:1px;
        background:linear-gradient(135deg, rgba(255,255,255,.5), rgba(255,255,255,.06));
        transition:transform .25s ease;
    }
    .cs-stat:hover{ transform:translateY(-4px); }
    .cs-stat-inner{
        background:rgba(255,255,255,.07);
        backdrop-filter:blur(10px);
        border-radius:15px;
        padding:16px 18px;
        height:100%;
    }
    .cs-stat-icon{
        width:34px; height:34px; border-radius:10px;
        display:flex; align-items:center; justify-content:center;
        background:rgba(255,255,255,.14);
        margin-bottom:10px; font-size:.9rem;
    }
    .cs-stat-value{ font-size:1.6rem; font-weight:700; line-height:1; }
    .cs-stat-label{ font-size:.74rem; color:rgba(255,255,255,.7); margin-top:6px; font-weight:500; }

    /* ---------- Section shell ---------- */
    .cs-panel{
        background:var(--cs-card);
        border:1px solid var(--cs-border);
        border-radius:var(--cs-radius);
        box-shadow:var(--cs-shadow);
    }
    .cs-panel-pad{ padding:22px clamp(14px,3vw,26px); }

    /* ---------- Analytics row ---------- */
    .cs-analytics{ display:grid; grid-template-columns:1.3fr 1fr; gap:16px; margin-bottom:20px; }
    @media(max-width:991px){ .cs-analytics{ grid-template-columns:1fr; } }
    .cs-chart-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; }
    .cs-chart-head h6{ font-weight:700; margin:0; font-size:.92rem; }
    .cs-chart-head p{ margin:0; font-size:.76rem; color:var(--cs-muted); }
    .cs-legend-dot{ width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:6px; }

    /* ---------- Filter bar ---------- */
    .cs-filterbar{
        display:flex; flex-wrap:wrap; gap:10px; align-items:center;
        background:rgba(255,255,255,.6);
        backdrop-filter:blur(14px);
        border:1px solid var(--cs-border);
        border-radius:999px;
        padding:10px 12px;
        margin-bottom:18px;
        box-shadow:var(--cs-shadow);
    }
    .cs-filter-search{
        flex:1 1 220px; display:flex; align-items:center; gap:8px;
        background:var(--cs-bg); border:1px solid var(--cs-border);
        border-radius:999px; padding:8px 14px;
    }
    .cs-filter-search input{ border:0; background:transparent; outline:none; font-size:.85rem; width:100%; }
    .cs-filter-search i{ color:var(--cs-muted); font-size:.8rem; }
    .cs-pill-select{
        border:1px solid var(--cs-border); background:var(--cs-bg);
        border-radius:999px; padding:8px 14px; font-size:.8rem; font-weight:500;
        color:var(--cs-ink); outline:none;
    }
    .cs-btn-ghost-pill{
        border:1px solid var(--cs-border); background:#fff; border-radius:999px;
        padding:8px 14px; font-size:.8rem; font-weight:600; color:var(--cs-muted);
        display:inline-flex; align-items:center; gap:6px; transition:.2s;
    }
    .cs-btn-ghost-pill:hover{ border-color:var(--cs-primary); color:var(--cs-primary); }
    .cs-btn-solid-pill{
        border:0; border-radius:999px; padding:8px 16px; font-size:.8rem; font-weight:600;
        background:linear-gradient(135deg,var(--cs-primary),var(--cs-accent)); color:#fff;
        display:inline-flex; align-items:center; gap:6px;
        box-shadow:0 8px 18px -8px rgba(19,138,158,.55);
    }
    .cs-view-toggle{ display:inline-flex; border:1px solid var(--cs-border); border-radius:999px; padding:3px; background:#fff; }
    .cs-view-toggle button{
        border:0; background:transparent; padding:6px 12px; border-radius:999px; font-size:.78rem; font-weight:600;
        color:var(--cs-muted); display:inline-flex; align-items:center; gap:6px;
    }
    .cs-view-toggle button.active{ background:var(--cs-ink); color:#fff; }

    /* ---------- Tabs ---------- */
    .cs-tabs{ display:flex; gap:4px; overflow-x:auto; border-bottom:1px solid var(--cs-border); margin-bottom:20px; }
    .cs-tabs .nav-link{
        border:0 !important; background:transparent !important; color:var(--cs-muted) !important;
        font-weight:600; font-size:.86rem; padding:12px 16px; position:relative;
        display:flex; align-items:center; gap:8px; white-space:nowrap;
    }
    .cs-tabs .nav-link .badge{
        background:var(--cs-bg); color:var(--cs-muted); border:1px solid var(--cs-border);
        font-weight:600; font-size:.68rem; border-radius:999px; padding:2px 8px;
    }
    .cs-tabs .nav-link.active{ color:var(--cs-ink) !important; }
    .cs-tabs .nav-link.active .badge{ background:var(--cs-primary); color:#fff; border-color:var(--cs-primary); }
    .cs-tabs .nav-link::after{
        content:""; position:absolute; left:14px; right:14px; bottom:-1px; height:2px;
        background:linear-gradient(90deg,var(--cs-primary),var(--cs-accent));
        border-radius:2px; transform:scaleX(0); transition:transform .25s ease;
    }
    .cs-tabs .nav-link.active::after{ transform:scaleX(1); }

    /* ---------- Module cards ---------- */
    .cs-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px; }
    .cs-grid.cs-list-view{ grid-template-columns:1fr; }

    .cs-mcard{
        background:#fff; border:1px solid var(--cs-border); border-radius:16px;
        padding:16px; transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        position:relative; overflow:hidden;
    }
    .cs-mcard::before{
        content:""; position:absolute; inset:0 0 auto 0; height:3px;
        background:linear-gradient(90deg,var(--cs-primary),var(--cs-accent));
        opacity:0; transition:.2s;
    }
    .cs-mcard:hover{ transform:translateY(-3px); box-shadow:0 16px 32px -18px rgba(15,23,42,.22); border-color:#d7dee3; }
    .cs-mcard:hover::before{ opacity:1; }

    .cs-mcard-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .cs-mcard-icon{
        width:38px; height:38px; border-radius:11px; flex-shrink:0;
        background:linear-gradient(135deg, rgba(19,138,158,.12), rgba(23,183,207,.12));
        color:var(--cs-primary); display:flex; align-items:center; justify-content:center; font-size:1rem;
    }
    .cs-mcard-title{ font-weight:700; font-size:.92rem; margin:0; }
    .cs-mcard-sub{ font-size:.74rem; color:var(--cs-muted); margin:2px 0 0; }

    .cs-pill{ font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:999px; display:inline-flex; align-items:center; gap:5px; }
    .cs-pill-pending{ background:#FEF3E2; color:#B45309; }
    .cs-pill-success{ background:#E7F9F1; color:#0F9D63; }
    .cs-pill-danger{ background:#FEECEC; color:#C0362C; }
    .cs-pill-muted{ background:#F1F5F9; color:#475569; }
    .cs-pill-info{ background:#E8F8FB; color:#0E7C93; }

    .cs-avatar{
        width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,var(--cs-primary),var(--cs-accent));
        color:#fff; font-size:.68rem; font-weight:700; display:inline-flex; align-items:center; justify-content:center;
    }

    .cs-progress{ height:6px; border-radius:999px; background:#EEF2F5; overflow:hidden; margin-top:12px; }
    .cs-progress-bar{ height:100%; border-radius:999px; background:linear-gradient(90deg,var(--cs-primary),var(--cs-accent)); width:0%; transition:width 1s ease; }

    .cs-mcard-foot{ display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:12px; border-top:1px dashed var(--cs-border); }
    .cs-meta{ font-size:.72rem; color:var(--cs-muted); display:flex; align-items:center; gap:5px; }

    .cs-btn-accept{
        border:0; background:linear-gradient(135deg,var(--cs-success),#0FB077); color:#fff;
        font-size:.76rem; font-weight:700; padding:7px 14px; border-radius:10px;
        display:inline-flex; align-items:center; gap:6px; transition:.2s;
    }
    .cs-btn-accept:hover{ filter:brightness(1.05); transform:translateY(-1px); }
    .cs-btn-reject{
        border:1px solid #FBD5D5; background:#fff; color:var(--cs-danger);
        font-size:.76rem; font-weight:700; padding:7px 14px; border-radius:10px;
        display:inline-flex; align-items:center; gap:6px; transition:.2s;
    }
    .cs-btn-reject:hover{ background:#FEF2F2; }

    .cs-empty{
        grid-column:1/-1; text-align:center; padding:60px 20px; color:var(--cs-muted);
        border:1.5px dashed var(--cs-border); border-radius:16px; background:#fbfdfe;
    }
    .cs-empty i{ font-size:1.6rem; color:var(--cs-accent); margin-bottom:10px; display:block; }

    /* accepted / rejected variants */
    .cs-mcard.is-accepted{ border-color:#CFF3E4; background:linear-gradient(180deg,#F5FFFB,#fff 40%); }
    .cs-mcard.is-rejected{ border-color:#FBD9D6; background:linear-gradient(180deg,#FFF6F5,#fff 40%); }

    /* reassign select */
    .cs-select-shell{
        display:flex; align-items:center; gap:8px; border:1px solid var(--cs-border);
        border-radius:12px; padding:6px 10px; background:var(--cs-bg);
    }
    .cs-select-shell select{ border:0; background:transparent; outline:none; font-size:.82rem; flex:1; }
    .cs-select-shell i{ color:var(--cs-muted); font-size:.78rem; }

    /* modal polish (Bootstrap modal, untouched structure/logic) */
    #cs-modules .modal-content{ border-radius:18px; border:1px solid var(--cs-border); overflow:hidden; }
    #cs-modules .modal-header{ border-bottom:1px solid var(--cs-border); }
    #cs-modules .modal-footer{ border-top:1px solid var(--cs-border); }

    .cs-skel{ position:relative; overflow:hidden; background:#EEF2F5; border-radius:16px; height:150px; }
    .cs-skel::after{
        content:""; position:absolute; inset:0; transform:translateX(-100%);
        background:linear-gradient(90deg, transparent, rgba(255,255,255,.7), transparent);
        animation:cs-shimmer 1.3s infinite;
    }
    @keyframes cs-shimmer{ 100%{ transform:translateX(100%); } }

    [data-cs-reveal]{ opacity:0; transform:translateY(14px); }
</style>

<div id="cs-modules">

    {{-- ======================================================= --}}
    {{-- HERO --}}
    {{-- ======================================================= --}}
    <div class="cs-hero" data-cs-reveal>
        <div class="cs-hero-top">
            <div>
                <div class="cs-hero-eyebrow">Code Sparrow &middot; Module Workspace</div>
                <h1 class="cs-hero-title">Good {{ now()->format('H') < 12 ? 'Morning' : (now()->format('H') < 17 ? 'Afternoon' : 'Evening') }}, <span>{{ auth()->user()->name ?? 'Developer' }}</span></h1>
                <div class="cs-hero-date"><i class="fa-regular fa-calendar me-1"></i>{{ now()->format('l, d F Y') }}</div>
            </div>
            <div class="cs-hero-badge">
                <i class="fa-solid fa-bolt"></i>
                {{ $assigned->count() }} module{{ $assigned->count() == 1 ? '' : 's' }} awaiting your review
            </div>
        </div>

        @php
            $csTotalTracked = $assigned->count() + $accepted->count() + $rejected->count();
            $csAcceptRate = $csTotalTracked > 0 ? round(($accepted->count() / $csTotalTracked) * 100) : 0;
        @endphp

        <div class="cs-stats">
            <div class="cs-stat"><div class="cs-stat-inner">
                <div class="cs-stat-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="cs-stat-value" data-cs-count="{{ $assigned->count() }}">0</div>
                <div class="cs-stat-label">Assigned</div>
            </div></div>
            <div class="cs-stat"><div class="cs-stat-inner">
                <div class="cs-stat-icon"><i class="fa-solid fa-check"></i></div>
                <div class="cs-stat-value" data-cs-count="{{ $accepted->count() }}">0</div>
                <div class="cs-stat-label">Accepted</div>
            </div></div>
            <div class="cs-stat"><div class="cs-stat-inner">
                <div class="cs-stat-icon"><i class="fa-solid fa-xmark"></i></div>
                <div class="cs-stat-value" data-cs-count="{{ $rejected->count() }}">0</div>
                <div class="cs-stat-label">Rejected</div>
            </div></div>
            @if($isAdmin || $isLeadDeveloper)
            <div class="cs-stat"><div class="cs-stat-inner">
                <div class="cs-stat-icon"><i class="fa-solid fa-arrows-rotate"></i></div>
                <div class="cs-stat-value" data-cs-count="{{ $reassignRequests->count() }}">0</div>
                <div class="cs-stat-label">Reassign Requests</div>
            </div></div>
            <div class="cs-stat"><div class="cs-stat-inner">
                <div class="cs-stat-icon"><i class="fa-solid fa-diagram-project"></i></div>
                <div class="cs-stat-value" data-cs-count="{{ $allModules->count() }}">0</div>
                <div class="cs-stat-label">Total Modules</div>
            </div></div>
            @endif
            <div class="cs-stat"><div class="cs-stat-inner">
                <div class="cs-stat-icon"><i class="fa-solid fa-gauge-high"></i></div>
                <div class="cs-stat-value"><span data-cs-count="{{ $csAcceptRate }}">0</span>%</div>
                <div class="cs-stat-label">Acceptance Rate</div>
            </div></div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- STATUS DONUT (built only from real counts already passed to the view) --}}
    {{-- ======================================================= --}}
    <div class="cs-analytics" data-cs-reveal>
        <div class="cs-panel cs-panel-pad">
            <div class="cs-chart-head">
                <div>
                    <h6>Status Distribution</h6>
                    <p>Live split of your tracked modules</p>
                </div>
            </div>
            <div id="csDonutChart"></div>
        </div>
        <div class="cs-panel cs-panel-pad d-flex flex-column justify-content-center">
            <h6 class="mb-3">At a glance</h6>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="cs-meta"><span class="cs-legend-dot" style="background:var(--cs-warning)"></span>Assigned</span>
                <span class="cs-num">{{ $assigned->count() }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="cs-meta"><span class="cs-legend-dot" style="background:var(--cs-success)"></span>Accepted</span>
                <span class="cs-num">{{ $accepted->count() }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="cs-meta"><span class="cs-legend-dot" style="background:var(--cs-danger)"></span>Rejected</span>
                <span class="cs-num">{{ $rejected->count() }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="cs-meta"><span class="cs-legend-dot" style="background:var(--cs-primary)"></span>Acceptance Rate</span>
                <span class="cs-num">{{ $csAcceptRate }}%</span>
            </div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- FILTER BAR (client-side only — filters the cards already rendered below) --}}
    {{-- ======================================================= --}}
    <div class="cs-filterbar">
        <div class="cs-filter-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="csSearchInput" placeholder="Search module or project...">
        </div>
        <select class="cs-pill-select" id="csPriorityFilter">
            <option value="">All Priorities</option>
        </select>
        <button type="button" class="cs-btn-ghost-pill" id="csResetFilters"><i class="fa-solid fa-rotate-left"></i>Reset</button>
        <div class="cs-view-toggle" id="csViewToggle">
            <button type="button" class="active" data-view="grid"><i class="fa-solid fa-grip"></i>Grid</button>
            <button type="button" data-view="list"><i class="fa-solid fa-list"></i>List</button>
        </div>
    </div>

    <div class="cs-panel">

        <div class="cs-panel-pad pb-0">
            <ul class="nav cs-tabs" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#assigned" type="button">
                        Assigned
                        <span class="badge">{{ $assigned->count() }}</span>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#accepted" type="button">
                        Accepted
                        <span class="badge">{{ $accepted->count() }}</span>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                        Rejected
                        <span class="badge">{{ $rejected->count() }}</span>
                    </button>
                </li>

                @if($isAdmin || $isLeadDeveloper)

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reassign" type="button">
                        Reassign Requests
                        <span class="badge">{{ $reassignRequests->count() }}</span>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allmodules" type="button">
                        All Modules
                        <span class="badge">{{ $allModules->count() }}</span>
                    </button>
                </li>

                @endif

            </ul>
        </div>

        <div class="tab-content cs-panel-pad pt-3">

            {{-- ========================= --}}
            {{-- Assigned Modules --}}
            {{-- ========================= --}}
            <div class="tab-pane fade show active" id="assigned">

                <div class="cs-grid" id="csAssignedGrid">

                    @forelse($assigned as $assignment)

                        <div class="cs-mcard" data-cs-card
                             data-search="{{ strtolower(($assignment->module->module_name ?? '').' '.($assignment->module->project->project_name ?? '')) }}">

                            <div class="cs-mcard-top">
                                <div class="d-flex gap-2">
                                    <div class="cs-mcard-icon"><i class="fa-solid fa-cubes"></i></div>
                                    <div>
                                        <p class="cs-mcard-title">{{ $assignment->module->module_name }}</p>
                                        <p class="cs-mcard-sub">{{ $assignment->module->project->project_name ?? '-' }}</p>
                                    </div>
                                </div>
                                <span class="cs-pill cs-pill-pending"><i class="fa-solid fa-circle-notch fa-spin" style="font-size:.6rem"></i>Pending</span>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <span class="cs-pill cs-pill-info"><i class="fa-solid fa-layer-group"></i>{{ $assignment->module->department->title ?? 'General' }}</span>
                                <span class="cs-pill cs-pill-muted"><i class="fa-regular fa-user"></i>{{ $assignment->assignedBy->name ?? '-' }}</span>
                            </div>

                            <div class="cs-mcard-foot">
                                <span class="cs-meta"><i class="fa-regular fa-calendar"></i>{{ optional($assignment->assigned_at)->format('d M Y') }}</span>
                                <span class="cs-meta">{{ optional($assignment->assigned_at)->format('h:i A') }}</span>
                            </div>

                            <div class="d-flex gap-2 mt-3">

                                {{-- Accept — untouched route/logic --}}
                                <form action="{{ route('admin.modules.requests.accept', $assignment->id) }}" method="POST" class="flex-fill">
                                    @csrf
                                    <button class="cs-btn-accept w-100 justify-content-center"><i class="fa-solid fa-check"></i>Accept</button>
                                </form>

                                {{-- Reject — untouched route/logic --}}
                                <button
                                    class="cs-btn-reject flex-fill justify-content-center"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal{{ $assignment->id }}">
                                    <i class="fa-solid fa-xmark"></i>Reject
                                </button>

                            </div>

                        </div>

                        {{-- Reject Modal — structure/logic untouched --}}
                        <div class="modal fade" id="rejectModal{{ $assignment->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('admin.modules.requests.reject',$assignment->id) }}" method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Module</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Reject Reason</label>
                                                <textarea class="form-control" name="reason" rows="4" required style="border-radius:12px;"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button" style="border-radius:10px;">Close</button>
                                            <button class="cs-btn-reject" style="border-radius:10px;">Reject Module</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    @empty

                        <div class="cs-empty">
                            <i class="fa-regular fa-clipboard"></i>
                            No assigned modules right now.
                        </div>

                    @endforelse

                </div>

            </div>

            {{-- ========================================= --}}
            {{-- Accepted Tab --}}
            {{-- ========================================= --}}
            <div class="tab-pane fade" id="accepted">

                <div class="cs-grid">

                @forelse($accepted as $assignment)

                    <div class="cs-mcard is-accepted"
                         data-search="{{ strtolower(($assignment->module->module_name ?? '').' '.($assignment->module->project->project_name ?? '')) }}">

                        <div class="cs-mcard-top">
                            <div class="d-flex gap-2">
                                <div class="cs-mcard-icon" style="background:linear-gradient(135deg, rgba(22,199,132,.14), rgba(22,199,132,.06)); color:var(--cs-success);"><i class="fa-solid fa-cubes"></i></div>
                                <div>
                                    <p class="cs-mcard-title">{{ $assignment->module->module_name }}</p>
                                    <p class="cs-mcard-sub">{{ $assignment->module->project->project_name ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="cs-pill cs-pill-success"><i class="fa-solid fa-check"></i>Accepted</span>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="cs-pill cs-pill-info"><i class="fa-solid fa-layer-group"></i>{{ $assignment->module->department->title ?? 'General' }}</span>
                        </div>

                        <div class="cs-mcard-foot">
                            <span class="cs-meta"><i class="fa-regular fa-calendar-check"></i>Accepted {{ optional($assignment->accepted_at)->format('d M Y h:i A') }}</span>
                        </div>

                    </div>

                @empty

                    <div class="cs-empty">
                        <i class="fa-regular fa-circle-check"></i>
                        No accepted modules yet.
                    </div>

                @endforelse

                </div>

            </div>

            {{-- ========================================= --}}
            {{-- Rejected Tab (history — every rejection by this developer) --}}
            {{-- ========================================= --}}
            <div class="tab-pane fade" id="rejected">

                <div class="cs-grid">

                @forelse($rejected as $assignment)

                    <div class="cs-mcard is-rejected"
                         data-search="{{ strtolower(($assignment->module->module_name ?? '').' '.($assignment->module->project->project_name ?? '')) }}">

                        <div class="cs-mcard-top">
                            <div class="d-flex gap-2">
                                <div class="cs-mcard-icon" style="background:linear-gradient(135deg, rgba(239,68,68,.12), rgba(239,68,68,.05)); color:var(--cs-danger);"><i class="fa-solid fa-cubes"></i></div>
                                <div>
                                    <p class="cs-mcard-title">{{ $assignment->module->module_name }}</p>
                                    <p class="cs-mcard-sub">{{ $assignment->module->project->project_name ?? '-' }}</p>
                                </div>
                            </div>
                            @if($assignment->is_current)
                                <span class="cs-pill cs-pill-danger"><i class="fa-solid fa-xmark"></i>Rejected</span>
                            @else
                                <span class="cs-pill cs-pill-muted"><i class="fa-solid fa-clock-rotate-left"></i>Reassigned</span>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="cs-pill cs-pill-info"><i class="fa-solid fa-layer-group"></i>{{ $assignment->module->department->title ?? 'General' }}</span>
                        </div>

                        <p class="cs-meta mt-3 mb-0" style="line-height:1.5;"><i class="fa-regular fa-comment-dots me-1"></i>{{ $assignment->reason }}</p>

                        <div class="cs-mcard-foot">
                            <span class="cs-meta"><i class="fa-regular fa-calendar-xmark"></i>{{ optional($assignment->rejected_at)->format('d M Y h:i A') }}</span>
                        </div>

                    </div>

                @empty

                    <div class="cs-empty">
                        <i class="fa-regular fa-circle-xmark"></i>
                        No rejected modules.
                    </div>

                @endforelse

                </div>

            </div>

            {{-- ========================================= --}}
            {{-- Reassign Requests Tab --}}
            {{-- $reassignRequests = ProjectModuleAssignment rows, rejected + is_current=true --}}
            {{-- covers ALL projects the Admin/Lead has access to --}}
            {{-- ========================================= --}}
            @if($isAdmin || $isLeadDeveloper)

            <div class="tab-pane fade" id="reassign">

                <div class="cs-grid">

                @forelse($reassignRequests as $assignment)

                    <div class="cs-mcard is-rejected"
                         data-search="{{ strtolower(($assignment->module->module_name ?? '').' '.($assignment->module->project->project_name ?? '')) }}">

                        <div class="cs-mcard-top">
                            <div class="d-flex gap-2">
                                <div class="cs-mcard-icon" style="background:linear-gradient(135deg, rgba(239,68,68,.12), rgba(239,68,68,.05)); color:var(--cs-danger);"><i class="fa-solid fa-arrows-rotate"></i></div>
                                <div>
                                    <p class="cs-mcard-title">{{ $assignment->module->module_name }}</p>
                                    <p class="cs-mcard-sub">{{ $assignment->module->project->project_name ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="cs-pill cs-pill-danger"><i class="fa-solid fa-xmark"></i>Rejected</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-3">
                            <span class="cs-avatar">{{ strtoupper(substr($assignment->assignedTo->name ?? '?',0,1)) }}</span>
                            <span class="cs-meta">Rejected by <strong>{{ $assignment->assignedTo->name ?? '-' }}</strong> &middot; {{ optional($assignment->rejected_at)->format('d M Y h:i A') }}</span>
                        </div>

                        <p class="cs-meta mt-3 mb-0" style="line-height:1.5;"><i class="fa-regular fa-comment-dots me-1"></i>{{ $assignment->reason }}</p>

                        {{-- Reassign — form action/route/select fields exactly as before --}}
                        <form action="{{ route('developer.modules.reassign',$assignment->id) }}" method="POST" class="mt-3">
                            @csrf

                            <div class="cs-select-shell mb-2">
                                <i class="fa-regular fa-user"></i>
                                <select class="form-select-sm" name="assigned_to" required style="border:0;background:transparent;outline:none;font-size:.82rem;flex:1;">
                                    <option value="">Select Developer</option>
                                    @foreach($developers as $developer)
                                        <option value="{{ $developer->id }}">
                                            {{ $developer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="cs-btn-solid-pill w-100 justify-content-center"><i class="fa-solid fa-arrows-rotate"></i>Reassign Module</button>

                        </form>

                    </div>

                @empty

                    <div class="cs-empty">
                        <i class="fa-solid fa-inbox"></i>
                        No reassign requests.
                    </div>

                @endforelse

                </div>

            </div>

            @endif

            {{-- ========================================= --}}
            {{-- All Modules Tab (Admin / Lead) --}}
            {{-- $allModules = ProjectModule rows with ->currentAssignment loaded --}}
            {{-- Admin: every module of every project. Lead: every module across ALL projects they lead. --}}
            {{-- ========================================= --}}
            @if($isAdmin || $isLeadDeveloper)

            <div class="tab-pane fade" id="allmodules">

                <div class="cs-grid" id="csAllModulesGrid">

                @forelse($allModules as $module)

                    @php
                        $status = $module->currentAssignment->status ?? 'unassigned';
                        $statusMap = [
                            'pending'    => ['cs-pill-pending','fa-circle-notch fa-spin','Pending'],
                            'accepted'   => ['cs-pill-success','fa-check','Accepted'],
                            'rejected'   => ['cs-pill-danger','fa-xmark','Rejected'],
                        ];
                        [$csClass,$csIcon,$csLabel] = $statusMap[$status] ?? ['cs-pill-muted','fa-minus','Unassigned'];
                    @endphp

                    <div class="cs-mcard"
                         data-search="{{ strtolower($module->module_name.' '.($module->project->project_name ?? '')) }}">

                        <div class="cs-mcard-top">
                            <div class="d-flex gap-2">
                                <div class="cs-mcard-icon"><i class="fa-solid fa-cubes"></i></div>
                                <div>
                                    <p class="cs-mcard-title">{{ $module->module_name }}</p>
                                    <p class="cs-mcard-sub">{{ $module->project->project_name ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="cs-pill {{ $csClass }}"><i class="fa-solid {{ $csIcon }}" style="font-size:.6rem"></i>{{ $csLabel }}</span>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="cs-pill cs-pill-info"><i class="fa-solid fa-layer-group"></i>{{ $module->department->title ?? 'General' }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-3">
                            <span class="cs-avatar">{{ strtoupper(substr($module->currentAssignment->assignedTo->name ?? '?',0,1)) }}</span>
                            <span class="cs-meta">{{ $module->currentAssignment->assignedTo->name ?? 'Unassigned' }}</span>
                        </div>

                        <div class="cs-mcard-foot">
                            <span class="cs-meta"><i class="fa-regular fa-calendar"></i>{{ optional($module->currentAssignment?->assigned_at)->format('d M Y h:i A') ?? '-' }}</span>
                        </div>

                    </div>

                @empty

                    <div class="cs-empty">
                        <i class="fa-solid fa-diagram-project"></i>
                        No modules found.
                    </div>

                @endforelse

                </div>

            </div>

            @endif

        </div> {{-- tab-content --}}

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (window.lucide) { lucide.createIcons(); }

    /* ---------- Count-up stats ---------- */
    document.querySelectorAll('[data-cs-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-cs-count'), 10) || 0;
        var obj = { val: 0 };
        if (window.gsap) {
            gsap.to(obj, {
                val: target, duration: 1.1, ease: 'power2.out',
                onUpdate: function () { el.textContent = Math.round(obj.val); }
            });
        } else {
            el.textContent = target;
        }
    });

    /* ---------- Reveal ---------- */
    if (window.gsap) {
        gsap.to('[data-cs-reveal]', { opacity: 1, y: 0, duration: .6, ease: 'power2.out', stagger: .08 });
        gsap.to('.cs-mcard', { opacity: 1, y: 0, duration: .45, ease: 'power2.out', stagger: .03, delay: .1 });
    }

    /* ---------- Donut chart (real data only) ---------- */
    var donutEl = document.querySelector('#csDonutChart');
    if (donutEl && window.ApexCharts) {
        var donutData = [{{ $assigned->count() }}, {{ $accepted->count() }}, {{ $rejected->count() }}];
        new ApexCharts(donutEl, {
            chart: { type: 'donut', height: 260, fontFamily: 'Inter, sans-serif' },
            series: donutData,
            labels: ['Pending', 'Accepted', 'Rejected'],
            colors: ['#F59E0B', '#16C784', '#EF4444'],
            legend: { position: 'bottom', fontSize: '12px' },
            dataLabels: { style: { fontSize: '11px' } },
            stroke: { width: 3, colors: ['#fff'] },
            plotOptions: { pie: { donut: { size: '72%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '12px' } } } } }
        }).render();
    }

    /* ---------- Filter bar: search + priority (client-side, no backend calls) ---------- */
    var searchInput = document.getElementById('csSearchInput');
    var priorityFilter = document.getElementById('csPriorityFilter');
    var resetBtn = document.getElementById('csResetFilters');

    function applyFilters() {
        var term = (searchInput.value || '').toLowerCase().trim();
        document.querySelectorAll('.tab-pane.active [data-search]').forEach(function (card) {
            var matches = !term || card.getAttribute('data-search').indexOf(term) !== -1;
            card.style.display = matches ? '' : 'none';
        });
    }
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (resetBtn) resetBtn.addEventListener('click', function () {
        searchInput.value = '';
        if (priorityFilter) priorityFilter.value = '';
        applyFilters();
    });
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (t) {
        t.addEventListener('shown.bs.tab', applyFilters);
    });

    /* ---------- Grid / list toggle ---------- */
    var toggle = document.getElementById('csViewToggle');
    if (toggle) {
        toggle.addEventListener('click', function (e) {
            var btn = e.target.closest('button');
            if (!btn) return;
            toggle.querySelectorAll('button').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var isList = btn.getAttribute('data-view') === 'list';
            document.querySelectorAll('.cs-grid').forEach(function (g) {
                g.classList.toggle('cs-list-view', isList);
            });
        });
    }
});
</script>

@endsection