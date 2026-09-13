@extends('index')

@section('title', 'Project Dashboard')

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root{
        --cs-teal-deep:#0F7F8C;
        --cs-teal-bright:#12A8B8;
        --cs-teal-cyan:#18C3D3;
        --cs-charcoal:#17212B;
        --cs-text:#182230;
        --cs-text-2:#667085;
        --cs-bg:#F5F8FA;
        --cs-card:#FFFFFF;
        --cs-border:#E5EAF0;
        --cs-radius-lg:14px;
        --cs-radius-md:10px;
        --cs-radius-sm:7px;
        --cs-shadow-sm:0 1px 2px rgba(23,33,43,.05);
        --cs-shadow-md:0 2px 4px rgba(23,33,43,.04), 0 10px 24px -14px rgba(23,33,43,.14);
        --cs-font-display:'Plus Jakarta Sans', sans-serif;
        --cs-font-body:'Inter', sans-serif;
    }

    #csDashboard{
        font-family:var(--cs-font-body);
        color:var(--cs-text);
        background:var(--cs-bg);
        margin:-1.5rem -1.5rem -1.5rem -1.5rem;
        padding:1.75rem;
    }
    #csDashboard *{ box-sizing:border-box; }
    #csDashboard h1, #csDashboard h2, #csDashboard h3, #csDashboard h4{
        font-family:var(--cs-font-display);
        color:var(--cs-text);
        letter-spacing:-.01em;
    }
    #csDashboard .cs-eyebrow{
        font-size:.68rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase;
        color:var(--cs-teal-deep); display:flex; align-items:center; gap:.4rem; margin-bottom:.5rem;
    }
    #csDashboard .cs-eyebrow .cs-mark{
        width:16px; height:16px; display:inline-flex; color:var(--cs-teal-bright);
    }
    #csDashboard .cs-mono{ font-variant-numeric:tabular-nums; }

    /* ============ Layout shell ============ */
    .cs-section{ margin-bottom:1.5rem; }
    .cs-surface{
        background:var(--cs-card); border:1px solid var(--cs-border); border-radius:var(--cs-radius-lg);
        box-shadow:var(--cs-shadow-sm);
    }

    /* ============ Header ============ */
    .cs-topbar{
        display:flex; align-items:flex-start; justify-content:space-between; gap:1.5rem;
        flex-wrap:wrap; margin-bottom:1.75rem;
    }
    .cs-topbar h1{ font-size:1.7rem; font-weight:800; margin:0 0 .35rem; }
    .cs-topbar p{ color:var(--cs-text-2); font-size:.88rem; max-width:46ch; margin:0; line-height:1.5; }
    .cs-topbar-actions{ display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }

    .cs-search{
        position:relative; display:flex; align-items:center;
    }
    .cs-search i{ position:absolute; left:.75rem; color:var(--cs-text-2); font-size:.78rem; pointer-events:none; }
    .cs-search input{
        font-family:var(--cs-font-body); font-size:.83rem; padding:.5rem .75rem .5rem 2rem;
        border:1px solid var(--cs-border); border-radius:var(--cs-radius-sm); background:#fff;
        width:220px; color:var(--cs-text); transition:border-color .15s ease, box-shadow .15s ease;
    }
    .cs-search input:focus{ outline:none; border-color:var(--cs-teal-bright); box-shadow:0 0 0 3px rgba(18,168,184,.12); }

    .cs-view-switch{
        display:flex; align-items:center; background:#fff; border:1px solid var(--cs-border); border-radius:var(--cs-radius-sm);
        padding:.2rem; gap:.15rem;
    }
    .cs-view-switch a{
        display:flex; align-items:center; gap:.35rem; font-size:.78rem; font-weight:600; color:var(--cs-text-2);
        padding:.36rem .65rem; border-radius:6px; text-decoration:none; transition:all .15s ease;
    }
    .cs-view-switch a.active{ background:var(--cs-charcoal); color:#fff; }
    .cs-view-switch a:not(.active):hover{ background:var(--cs-bg); color:var(--cs-text); }

    .cs-icon-btn{
        display:inline-flex; align-items:center; gap:.4rem; font-size:.8rem; font-weight:600;
        background:#fff; border:1px solid var(--cs-border); color:var(--cs-text); border-radius:var(--cs-radius-sm);
        padding:.5rem .75rem; text-decoration:none; transition:all .15s ease; cursor:pointer;
    }
    .cs-icon-btn:hover{ border-color:var(--cs-teal-bright); color:var(--cs-teal-deep); background:#F2FBFC; }
    .cs-icon-btn.cs-primary{
        background:var(--cs-charcoal); border-color:var(--cs-charcoal); color:#fff;
    }
    .cs-icon-btn.cs-primary:hover{ background:var(--cs-teal-deep); border-color:var(--cs-teal-deep); color:#fff; }

    /* ============ Executive overview ============ */
    .cs-overview{
        display:grid; grid-template-columns:minmax(320px, 1.05fr) 2fr; gap:1rem;
    }
    .cs-health-card{
        padding:1.5rem; display:flex; flex-direction:column; gap:1.1rem;
    }
    .cs-health-top{ display:flex; align-items:center; justify-content:space-between; }
    .cs-health-title{ font-size:.86rem; font-weight:700; }
    .cs-health-title span{ display:block; font-size:.68rem; font-weight:600; color:var(--cs-text-2); text-transform:uppercase; letter-spacing:.08em; margin-bottom:.15rem; }
    .cs-health-body{ display:flex; align-items:center; gap:1.25rem; }
    .cs-radial{ position:relative; width:132px; height:132px; flex-shrink:0; }
    .cs-radial-value{
        position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;
    }
    .cs-radial-value strong{ font-family:var(--cs-font-display); font-size:1.55rem; font-weight:800; line-height:1; }
    .cs-radial-value small{ font-size:.63rem; color:var(--cs-text-2); font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-top:.2rem; }
    .cs-health-stats{ flex:1; display:flex; flex-direction:column; gap:.6rem; }
    .cs-health-stat-row{ display:flex; align-items:center; justify-content:space-between; font-size:.8rem; padding-bottom:.55rem; border-bottom:1px dashed var(--cs-border); }
    .cs-health-stat-row:last-child{ border-bottom:none; padding-bottom:0; }
    .cs-health-stat-row .cs-dot{ width:7px; height:7px; border-radius:50%; display:inline-block; margin-right:.5rem; }
    .cs-health-stat-row strong{ font-family:var(--cs-font-display); font-weight:700; }

    .cs-metric-grid{ display:grid; grid-template-columns:repeat(3, 1fr); gap:.85rem; }
    .cs-metric{
        padding:1rem 1.1rem; display:flex; flex-direction:column; gap:.4rem; position:relative; overflow:hidden;
    }
    .cs-metric::before{
        content:''; position:absolute; left:0; top:0; bottom:0; width:3px; background:var(--m-color, var(--cs-teal-bright));
    }
    .cs-metric i{ font-size:.85rem; color:var(--m-color, var(--cs-teal-bright)); }
    .cs-metric strong{ font-family:var(--cs-font-display); font-size:1.5rem; font-weight:800; line-height:1; }
    .cs-metric span{ font-size:.7rem; font-weight:600; color:var(--cs-text-2); text-transform:uppercase; letter-spacing:.05em; }

    /* ============ Analytics ============ */
    .cs-analytics-grid{
        display:grid; grid-template-columns:repeat(12, 1fr); gap:1rem;
    }
    .cs-chart-card{ padding:1.25rem 1.35rem 1rem; }
    .cs-chart-card .cs-chart-head{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:.5rem; }
    .cs-chart-card h3{ font-size:.85rem; font-weight:700; margin:0; }
    .cs-chart-card p.cs-chart-sub{ font-size:.72rem; color:var(--cs-text-2); margin:.15rem 0 0; }
    .cs-span-8{ grid-column:span 8; }
    .cs-span-4{ grid-column:span 4; }
    .cs-span-6{ grid-column:span 6; }
    .cs-span-12{ grid-column:span 12; }
    @media (max-width:1199.98px){
        .cs-span-8, .cs-span-4, .cs-span-6{ grid-column:span 12; }
        .cs-overview{ grid-template-columns:1fr; }
    }

    .cs-perf-table{ width:100%; border-collapse:collapse; font-size:.79rem; }
    .cs-perf-table th{
        text-align:left; font-size:.66rem; text-transform:uppercase; letter-spacing:.06em; color:var(--cs-text-2);
        font-weight:700; padding:.4rem .5rem; border-bottom:1px solid var(--cs-border);
    }
    .cs-perf-table td{ padding:.55rem .5rem; border-bottom:1px solid var(--cs-border); vertical-align:middle; }
    .cs-perf-table tr:last-child td{ border-bottom:none; }
    .cs-perf-table .cs-perf-name{ font-weight:700; color:var(--cs-text); }
    .cs-perf-bar{ width:80px; height:5px; border-radius:99px; background:#ECEFF3; overflow:hidden; display:inline-block; vertical-align:middle; margin-right:.4rem; }
    .cs-perf-bar span{ display:block; height:100%; background:var(--cs-teal-bright); border-radius:99px; }

    /* ============ Health / status pills ============ */
    .cs-pill{
        display:inline-flex; align-items:center; gap:.35rem; font-size:.68rem; font-weight:700;
        padding:.28rem .6rem; border-radius:99px; letter-spacing:.01em;
    }
    .cs-pill .cs-dot{ width:6px; height:6px; border-radius:50%; display:inline-block; }
    .cs-pill-healthy{ background:#EAF9F1; color:#12825A; }
    .cs-pill-healthy .cs-dot{ background:#12825A; }
    .cs-pill-risk{ background:#FFF4E5; color:#B4650C; }
    .cs-pill-risk .cs-dot{ background:#B4650C; }
    .cs-pill-critical{ background:#FDECEF; color:#C0134A; }
    .cs-pill-critical .cs-dot{ background:#C0134A; }
    .cs-pill-done{ background:#EEF1FE; color:#4A4FCF; }
    .cs-pill-done .cs-dot{ background:#4A4FCF; }

    .cs-badge{
        display:inline-flex; align-items:center; font-size:.67rem; font-weight:700; padding:.28rem .55rem;
        border-radius:6px; text-transform:capitalize;
    }
    .cs-badge-priority-critical{ background:#7f1d1d; color:#fff; }
    .cs-badge-priority-high{ background:#FDECEF; color:#C0134A; }
    .cs-badge-priority-medium{ background:#FFF4E5; color:#B4650C; }
    .cs-badge-priority-low{ background:#EAF9F1; color:#12825A; }
    .cs-badge-status{ background:#EEF1F5; color:var(--cs-text-2); }
    .cs-badge-status-in-progress{ background:#E7F6F8; color:var(--cs-teal-deep); }
    .cs-badge-status-completed{ background:#EAF9F1; color:#12825A; }
    .cs-badge-status-on-hold{ background:var(--cs-charcoal); color:#fff; }
    .cs-badge-status-cancelled{ background:#FDECEF; color:#C0134A; }

    /* ============ Filter toolbar ============ */
    .cs-filter-bar{
        display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:.85rem 1.1rem;
        flex-wrap:wrap;
    }
    .cs-filter-bar-left{ display:flex; align-items:center; gap:.6rem; flex-wrap:wrap; }
    .cs-chip{
        display:inline-flex; align-items:center; gap:.4rem; font-size:.72rem; font-weight:600;
        background:#F2FBFC; color:var(--cs-teal-deep); border:1px solid #CFEFF3; padding:.28rem .5rem .28rem .65rem;
        border-radius:99px;
    }
    .cs-chip a{ color:var(--cs-teal-deep); opacity:.6; text-decoration:none; font-weight:800; }
    .cs-chip a:hover{ opacity:1; }
    .cs-filter-drawer{
        display:none; border-top:1px solid var(--cs-border); padding:1.1rem;
    }
    .cs-filter-drawer.cs-open{ display:block; }
    .cs-filter-drawer label{ font-size:.7rem; font-weight:700; color:var(--cs-text-2); text-transform:uppercase; letter-spacing:.04em; margin-bottom:.3rem; display:block; }
    .cs-filter-drawer .form-control, .cs-filter-drawer .form-select{
        border-radius:var(--cs-radius-sm); font-size:.83rem; border-color:var(--cs-border);
    }
    .cs-filter-drawer .form-control:focus, .cs-filter-drawer .form-select:focus{
        border-color:var(--cs-teal-bright); box-shadow:0 0 0 3px rgba(18,168,184,.12);
    }

    /* ============ Project workspace rows ============ */
    .cs-workspace-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:.85rem; }
    .cs-workspace-head h2{ font-size:1rem; font-weight:800; margin:0; }
    .cs-workspace-head span{ font-size:.76rem; color:var(--cs-text-2); }

    .cs-row{
        display:flex; align-items:center; gap:1rem; padding:1rem 1.1rem; border:1px solid var(--cs-border);
        border-radius:var(--cs-radius-md); background:#fff; margin-bottom:.65rem; transition:box-shadow .18s ease, border-color .18s ease, transform .18s ease;
        flex-wrap:wrap;
    }
    .cs-row:hover{ border-color:var(--cs-teal-bright); box-shadow:var(--cs-shadow-md); transform:translateY(-1px); }
    .cs-row-id{ display:flex; align-items:center; gap:.75rem; flex:1 1 240px; min-width:0; }
    .cs-row-icon{
        width:40px; height:40px; border-radius:10px; background:var(--cs-charcoal); color:var(--cs-teal-cyan);
        display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0;
    }
    .cs-row-name{ font-weight:700; font-size:.9rem; color:var(--cs-text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .cs-row-sub{ font-size:.74rem; color:var(--cs-text-2); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

    .cs-row-progress{ flex:1 1 150px; min-width:130px; }
    .cs-row-progress .cs-progress-label{ display:flex; justify-content:space-between; font-size:.68rem; font-weight:700; color:var(--cs-text-2); margin-bottom:.3rem; }
    .cs-row-progress .progress{ height:6px; border-radius:99px; background:#ECEFF3; }
    .cs-row-progress .progress-bar{ border-radius:99px; background:var(--cs-teal-bright); transition:width 1s cubic-bezier(.4,0,.2,1); }

    .cs-row-meta{ display:flex; align-items:center; gap:1.4rem; flex-wrap:wrap; }
    .cs-row-meta-item{ display:flex; flex-direction:column; gap:.2rem; min-width:64px; }
    .cs-row-meta-item span{ font-size:.63rem; font-weight:700; color:var(--cs-text-2); text-transform:uppercase; letter-spacing:.05em; }
    .cs-row-meta-item strong{ font-size:.78rem; font-weight:700; color:var(--cs-text); }

    .cs-row-actions{ display:flex; align-items:center; gap:.6rem; margin-left:auto; }
    .cs-row-actions-btns{ display:flex; gap:.3rem; opacity:0; transform:translateX(4px); transition:all .18s ease; }
    .cs-row:hover .cs-row-actions-btns{ opacity:1; transform:translateX(0); }
    .cs-row-actions .btn{ border-radius:7px; }
    .cs-dev-avatar{
        width:28px; height:28px; border-radius:50%; background:var(--cs-teal-deep); color:#fff;
        display:inline-flex; align-items:center; justify-content:center; font-size:.65rem; font-weight:700; flex-shrink:0;
    }

    /* ============ Table view ============ */
    .cs-table-wrap{ overflow-x:auto; }
    .cs-table{ width:100%; border-collapse:collapse; font-size:.82rem; }
    .cs-table thead th{
        text-align:left; font-size:.66rem; text-transform:uppercase; letter-spacing:.06em; color:var(--cs-text-2);
        font-weight:700; padding:.85rem 1rem; border-bottom:1px solid var(--cs-border); background:#FAFBFC;
    }
    .cs-table tbody td{ padding:.85rem 1rem; border-bottom:1px solid var(--cs-border); }
    .cs-table tbody tr:last-child td{ border-bottom:none; }
    .cs-table tbody tr{ transition:background .15s ease; }
    .cs-table tbody tr:hover{ background:#FAFDFD; }

    /* ============ Kanban ============ */
    .cs-kanban-col{ min-width:270px; max-width:290px; }
    .cs-kanban-head{ display:flex; align-items:center; justify-content:space-between; padding:0 .2rem .6rem; }
    .cs-kanban-head span.cs-kanban-title{ font-size:.78rem; font-weight:700; color:var(--cs-text); }
    .cs-kanban-count{ font-size:.68rem; font-weight:700; color:var(--cs-text-2); background:#EEF1F5; border-radius:99px; padding:.1rem .5rem; }
    .cs-kanban-card{ padding:.9rem; }
    .cs-kanban-card .cs-row-icon{ width:32px; height:32px; font-size:.85rem; border-radius:8px; }

    /* ============ Sidebar: timeline / deadlines / quick actions ============ */
    .cs-side-card{ padding:1.15rem 1.25rem; }
    .cs-side-head{ display:flex; align-items:center; justify-content:between; gap:.5rem; margin-bottom:1rem; }
    .cs-side-head h3{ font-size:.83rem; font-weight:700; margin:0; display:flex; align-items:center; gap:.5rem; }
    .cs-side-head i{ color:var(--cs-teal-bright); font-size:.85rem; }

    .cs-timeline{ position:relative; margin-left:.35rem; padding-left:1.1rem; border-left:2px solid var(--cs-border); }
    .cs-timeline-item{ position:relative; padding-bottom:1.05rem; }
    .cs-timeline-item:last-child{ padding-bottom:0; }
    .cs-timeline-item::before{
        content:''; position:absolute; left:-1.42rem; top:.2rem; width:9px; height:9px; border-radius:50%;
        background:var(--cs-teal-bright); box-shadow:0 0 0 3px #E7F6F8;
    }
    .cs-timeline-title{ font-size:.8rem; font-weight:700; color:var(--cs-text); margin-bottom:.1rem; }
    .cs-timeline-sub{ font-size:.72rem; color:var(--cs-text-2); }

    .cs-deadline-row{
        display:flex; align-items:center; justify-content:space-between; gap:.6rem; padding:.6rem 0;
        border-bottom:1px solid var(--cs-border);
    }
    .cs-deadline-row:last-child{ border-bottom:none; padding-bottom:0; }
    .cs-deadline-row:first-child{ padding-top:0; }
    .cs-deadline-name{ font-size:.8rem; font-weight:700; color:var(--cs-text); }
    .cs-deadline-sub{ font-size:.71rem; color:var(--cs-text-2); }

    .cs-quick-btn{
        display:flex; align-items:center; gap:.6rem; width:100%; text-align:left; background:#fff;
        border:1px solid var(--cs-border); border-radius:var(--cs-radius-sm); padding:.6rem .8rem; margin-bottom:.5rem;
        font-size:.81rem; font-weight:600; color:var(--cs-text); transition:all .15s ease;
    }
    .cs-quick-btn:last-child{ margin-bottom:0; }
    .cs-quick-btn:hover{ border-color:var(--cs-teal-bright); background:#F2FBFC; color:var(--cs-teal-deep); }
    .cs-quick-btn i:first-child{ width:26px; height:26px; border-radius:7px; background:var(--cs-bg); display:inline-flex;
        align-items:center; justify-content:center; color:var(--cs-teal-deep); font-size:.75rem; flex-shrink:0; }
    .cs-quick-btn i.cs-chevron{ margin-left:auto; color:var(--cs-text-2); font-size:.68rem; }

    .cs-empty{
        text-align:center; padding:3.5rem 1.5rem; background:#fff; border:1.5px dashed var(--cs-border); border-radius:var(--cs-radius-lg);
    }
    .cs-empty i{ font-size:2.75rem; color:var(--cs-teal-bright); opacity:.3; margin-bottom:.85rem; }
    .cs-empty h5{ font-weight:800; font-size:1rem; }
    .cs-empty p{ color:var(--cs-text-2); font-size:.85rem; }

    @media (max-width:767.98px){
        #csDashboard{ margin:-1rem; padding:1rem; }
        .cs-topbar{ flex-direction:column; }
        .cs-topbar-actions{ width:100%; }
        .cs-search input{ width:100%; }
        .cs-metric-grid{ grid-template-columns:repeat(2,1fr); }
        .cs-row{ flex-direction:column; align-items:stretch; }
        .cs-row-actions{ margin-left:0; width:100%; justify-content:space-between; }
    }

    [data-cs-anim]{ opacity:0; }
</style>
@endpush

@section('content')
<div id="csDashboard">

    @php
        $view = request('view', 'cards');

        // Shared per-project computed values, reused across cards / table / kanban / workspace views.
        $computeProjectMeta = function ($project) {
            $moduleCount = $project->modules->count();
            $estimatedHours = $project->modules->sum('estimated_hours');
            $completedHours = $project->modules->sum('actual_hours');
            $completedModules = $project->modules->where('progress', '>=', 100)->count();
            $avgProgress = $moduleCount > 0 ? (int) round($project->modules->avg('progress')) : 0;

            $progressClass = match (true) {
                $avgProgress <= 25 => 'bg-danger',
                $avgProgress <= 50 => 'bg-warning',
                $avgProgress <= 75 => 'bg-primary',
                default => 'bg-success',
            };

            $priorityClass = match ($project->priority) {
                'Critical' => 'cs-badge-priority-critical',
                'High' => 'cs-badge-priority-high',
                'Medium' => 'cs-badge-priority-medium',
                default => 'cs-badge-priority-low',
            };

            $statusClass = match ($project->status) {
                'In Progress' => 'cs-badge-status-in-progress',
                'Completed' => 'cs-badge-status-completed',
                'On Hold' => 'cs-badge-status-on-hold',
                'Cancelled' => 'cs-badge-status-cancelled',
                default => 'cs-badge-status',
            };

            $deadlineBadge = null;
            $daysLeft = null;
            if ($project->deadline) {
                $deadline = \Illuminate\Support\Carbon::parse($project->deadline)->startOfDay();
                $today = \Illuminate\Support\Carbon::today();
                if ($deadline->lt($today) && !in_array($project->status, ['Completed', 'Cancelled'])) {
                    $deadlineBadge = ['label' => 'Overdue', 'class' => 'cs-pill-critical'];
                } elseif ($deadline->eq($today)) {
                    $deadlineBadge = ['label' => 'Today', 'class' => 'cs-pill-risk'];
                } else {
                    $daysLeft = $today->diffInDays($deadline, false);
                    $deadlineBadge = ['label' => $daysLeft . ' days left', 'class' => 'cs-pill-healthy'];
                }
            }

            // Derived project health, based on real status / progress / deadline data.
            if ($project->status === 'Completed') {
                $health = 'Completed';
            } elseif ($deadlineBadge && $deadlineBadge['label'] === 'Overdue') {
                $health = 'Critical';
            } elseif ($project->status === 'Cancelled') {
                $health = 'Critical';
            } elseif ($daysLeft !== null && $daysLeft <= 5 && $avgProgress < 60) {
                $health = 'At Risk';
            } elseif ($deadlineBadge && $deadlineBadge['label'] === 'Today' && $avgProgress < 90) {
                $health = 'At Risk';
            } else {
                $health = 'Healthy';
            }

            $initials = $project->assignedTo
                ? collect(explode(' ', $project->assignedTo->name))->map(fn ($part) => strtoupper($part[0] ?? ''))->take(2)->implode('')
                : '--';

            return compact('moduleCount', 'estimatedHours', 'completedHours', 'completedModules', 'avgProgress', 'progressClass', 'priorityClass', 'statusClass', 'deadlineBadge', 'daysLeft', 'health', 'initials');
        };

        // Aggregate analytics derived entirely from the currently loaded $projects set — no invented data.
        $priorityCounts = ['Critical' => 0, 'High' => 0, 'Medium' => 0, 'Low' => 0];
        $healthCounts = ['Healthy' => 0, 'At Risk' => 0, 'Critical' => 0, 'Completed' => 0];
        $workload = [];
        $trendLabels = [];
        $trendProgress = [];

        foreach ($projects as $__p) {
            $__meta = $computeProjectMeta($__p);

            if (isset($priorityCounts[$__p->priority])) {
                $priorityCounts[$__p->priority]++;
            }
            $healthCounts[$__meta['health']] = ($healthCounts[$__meta['health']] ?? 0) + 1;

            $__dev = $__p->assignedTo->name ?? 'Unassigned';
            $workload[$__dev] = ($workload[$__dev] ?? 0) + 1;

            $trendLabels[] = $__p->start_date ? \Illuminate\Support\Carbon::parse($__p->start_date)->format('d M') : \Illuminate\Support\Str::limit($__p->project_name, 10);
            $trendProgress[] = $__meta['avgProgress'];
        }
        arsort($workload);
        $workload = array_slice($workload, 0, 8, true);

        $statusDonutSeries = [(int) $activeProjects, (int) $pendingProjects, (int) $completedProjects, (int) $onHoldProjects, (int) $cancelledProjects];

        // Active filter chips, built from the real request query string.
        $activeFilters = [];
        $deptTitle = $departments->firstWhere('id', (int) request('department_id'))->title ?? null;
        $devName = $developers->firstWhere('id', (int) request('assigned_to'))->name ?? null;
        foreach ([
            'search' => 'Search',
            'status' => 'Status',
            'priority' => 'Priority',
            'client_name' => 'Client',
            'source' => 'Source',
            'from_date' => 'From',
            'to_date' => 'To',
        ] as $__key => $__label) {
            if (request($__key)) {
                $activeFilters[] = ['key' => $__key, 'label' => $__label . ': ' . request($__key)];
            }
        }
        if (request('department_id') && $deptTitle) {
            $activeFilters[] = ['key' => 'department_id', 'label' => 'Dept: ' . $deptTitle];
        }
        if (request('assigned_to') && $devName) {
            $activeFilters[] = ['key' => 'assigned_to', 'label' => 'Dev: ' . $devName];
        }

        $removeFilterQuery = function ($key) {
            $q = request()->query();
            unset($q[$key]);
            return $q;
        };
    @endphp

    {{-- ======================= TOP COMMAND BAR ======================= --}}
    <div class="cs-topbar" data-cs-anim="up">
        <div>
            <div class="cs-eyebrow">
                <svg class="cs-mark" viewBox="0 0 24 24" fill="none"><path d="M3 8L9 4M3 8L9 12M3 8H15M15 4L21 8M15 12L21 8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Project Management &middot; Code Sparrow
            </div>
            <h1>Project Command Center</h1>
            <p>Monitor delivery, team workload, project health and deadlines from one intelligent workspace.</p>
        </div>
        <div class="cs-topbar-actions">
            <form action="{{ route('admin.projects.index') }}" method="GET" class="cs-search">
                <input type="hidden" name="view" value="{{ $view }}">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" placeholder="Search projects, clients..." value="{{ request('search') }}">
            </form>

            <div class="cs-view-switch">
                <a href="{{ route('admin.projects.index', array_merge(request()->query(), ['view' => 'cards'])) }}" class="{{ $view === 'cards' ? 'active' : '' }}"><i class="fa-solid fa-grip"></i> Cards</a>
                <a href="{{ route('admin.projects.index', array_merge(request()->query(), ['view' => 'table'])) }}" class="{{ $view === 'table' ? 'active' : '' }}"><i class="fa-solid fa-table-list"></i> Table</a>
                <a href="{{ route('admin.projects.index', array_merge(request()->query(), ['view' => 'kanban'])) }}" class="{{ $view === 'kanban' ? 'active' : '' }}"><i class="fa-solid fa-columns"></i> Kanban</a>
            </div>

            <button type="button" class="cs-icon-btn" id="csFilterToggle"><i class="fa-solid fa-sliders"></i> Filters</button>
            <a href="{{ route('admin.projects.index') }}" class="cs-icon-btn" title="Refresh"><i class="fa-solid fa-rotate-right"></i></a>
            <button type="button" class="cs-icon-btn" id="csExportBtn"><i class="fa-solid fa-file-export"></i> Export</button>

            @can('project-create')
                <a href="{{ route('admin.projects.create') }}" class="cs-icon-btn cs-primary"><i class="fa-solid fa-plus"></i> New Project</a>
            @endcan
        </div>
    </div>

    {{-- ======================= EXECUTIVE OVERVIEW ======================= --}}
    <div class="cs-section cs-overview" data-cs-anim="up">
        <div class="cs-surface cs-health-card">
            <div class="cs-health-top">
                <div class="cs-health-title"><span>Portfolio Health</span>Overall Progress</div>
                <span class="cs-pill cs-pill-healthy"><span class="cs-dot"></span>{{ $activeProjects }} Active</span>
            </div>
            <div class="cs-health-body">
                <div class="cs-radial" id="csRadialGauge"></div>
                <div class="cs-health-stats">
                    <div class="cs-health-stat-row"><span><span class="cs-dot" style="background:var(--cs-teal-bright)"></span>Active Projects</span><strong>{{ $activeProjects }}</strong></div>
                    <div class="cs-health-stat-row"><span><span class="cs-dot" style="background:#12825A"></span>Completed</span><strong>{{ $completedProjects }}</strong></div>
                    <div class="cs-health-stat-row"><span><span class="cs-dot" style="background:#C0134A"></span>Overdue</span><strong>{{ $overdueProjects }}</strong></div>
                </div>
            </div>
        </div>

        <div class="cs-metric-grid">
            <div class="cs-surface cs-metric" style="--m-color:var(--cs-teal-deep)"><i class="fa-solid fa-layer-group"></i><strong class="cs-mono" data-count="{{ $totalProjects }}">0</strong><span>Total Projects</span></div>
            <div class="cs-surface cs-metric" style="--m-color:#B4650C"><i class="fa-solid fa-hourglass-half"></i><strong class="cs-mono" data-count="{{ $pendingProjects }}">0</strong><span>Pending</span></div>
            <div class="cs-surface cs-metric" style="--m-color:var(--cs-charcoal)"><i class="fa-solid fa-pause"></i><strong class="cs-mono" data-count="{{ $onHoldProjects }}">0</strong><span>On Hold</span></div>
            <div class="cs-surface cs-metric" style="--m-color:#C0134A"><i class="fa-solid fa-ban"></i><strong class="cs-mono" data-count="{{ $cancelledProjects }}">0</strong><span>Cancelled</span></div>
            <div class="cs-surface cs-metric" style="--m-color:#B4650C"><i class="fa-solid fa-calendar-day"></i><strong class="cs-mono" data-count="{{ $todayDeadlineProjects }}">0</strong><span>Due Today</span></div>
            <div class="cs-surface cs-metric" style="--m-color:var(--cs-teal-bright)"><i class="fa-solid fa-user-gear"></i><strong class="cs-mono" data-count="{{ $totalDevelopers }}">0</strong><span>Developers</span></div>
            <div class="cs-surface cs-metric" style="--m-color:var(--cs-teal-cyan)" ><i class="fa-solid fa-users"></i><strong class="cs-mono" data-count="{{ $totalClients }}">0</strong><span>Clients</span></div>
            <div class="cs-surface cs-metric" style="--m-color:#12825A"><i class="fa-solid fa-circle-check"></i><strong class="cs-mono" data-count="{{ $completedProjects }}">0</strong><span>Completed</span></div>
            <div class="cs-surface cs-metric" style="--m-color:#C0134A"><i class="fa-solid fa-triangle-exclamation"></i><strong class="cs-mono" data-count="{{ $overdueProjects }}">0</strong><span>Overdue</span></div>
        </div>
    </div>

    {{-- ======================= ANALYTICS ======================= --}}
    <div class="cs-section cs-analytics-grid" data-cs-anim="up">
        <div class="cs-surface cs-chart-card cs-span-8">
            <div class="cs-chart-head">
                <div><h3>Project Health Trend</h3><p class="cs-chart-sub">Progress by project, ordered by start date</p></div>
            </div>
            <div id="csTrendChart"></div>
        </div>

        <div class="cs-surface cs-chart-card cs-span-4">
            <div class="cs-chart-head">
                <div><h3>Project Status</h3><p class="cs-chart-sub">Distribution across the portfolio</p></div>
            </div>
            <div id="csStatusDonut"></div>
        </div>

        <div class="cs-surface cs-chart-card cs-span-4">
            <div class="cs-chart-head">
                <div><h3>Team Workload</h3><p class="cs-chart-sub">Assigned projects per developer</p></div>
            </div>
            <div id="csWorkloadChart"></div>
        </div>

        <div class="cs-surface cs-chart-card cs-span-4">
            <div class="cs-chart-head">
                <div><h3>Priority Matrix</h3><p class="cs-chart-sub">Projects grouped by priority</p></div>
            </div>
            <div id="csPriorityChart"></div>
        </div>

        <div class="cs-surface cs-chart-card cs-span-4">
            <div class="cs-chart-head">
                <div><h3>Deadline Radar</h3><p class="cs-chart-sub">Days remaining, upcoming projects</p></div>
            </div>
            <div id="csDeadlineChart"></div>
        </div>

        <div class="cs-surface cs-chart-card cs-span-12">
            <div class="cs-chart-head">
                <div><h3>Project Performance</h3><p class="cs-chart-sub">Progress, health and deadline at a glance</p></div>
            </div>
            <div class="cs-table-wrap">
                <table class="cs-perf-table">
                    <thead><tr><th>Project</th><th>Progress</th><th>Health</th><th>Deadline</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($projects->take(6) as $project)
                            @php $meta = $computeProjectMeta($project); extract($meta); @endphp
                            <tr>
                                <td class="cs-perf-name">{{ $project->project_name }}</td>
                                <td><span class="cs-perf-bar"><span style="width:{{ $avgProgress }}%"></span></span>{{ $avgProgress }}%</td>
                                <td>
                                    @php $healthPillClass = ['Healthy'=>'cs-pill-healthy','At Risk'=>'cs-pill-risk','Critical'=>'cs-pill-critical','Completed'=>'cs-pill-done'][$health]; @endphp
                                    <span class="cs-pill {{ $healthPillClass }}"><span class="cs-dot"></span>{{ $health }}</span>
                                </td>
                                <td>{{ $project->deadline ? \Illuminate\Support\Carbon::parse($project->deadline)->format('d M Y') : '—' }}</td>
                                <td><span class="cs-badge {{ $statusClass }}">{{ $project->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No projects to display.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ======================= FILTER TOOLBAR ======================= --}}
    <div class="cs-surface cs-section" id="csFilterCard" data-cs-anim="up">
        <div class="cs-filter-bar">
            <div class="cs-filter-bar-left">
                @forelse ($activeFilters as $chip)
                    <span class="cs-chip">{{ $chip['label'] }}
                        <a href="{{ route('admin.projects.index', $removeFilterQuery($chip['key'])) }}">&times;</a>
                    </span>
                @empty
                    <span style="font-size:.78rem; color:var(--cs-text-2);">No active filters</span>
                @endforelse
            </div>
            <div style="display:flex; gap:.5rem;">
                @if (count($activeFilters))
                    <a href="{{ route('admin.projects.index') }}" class="cs-icon-btn"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                @endif
                <button type="button" class="cs-icon-btn cs-primary" id="csFilterToggle2"><i class="fa-solid fa-sliders"></i> Edit Filters</button>
            </div>
        </div>

        <div class="cs-filter-drawer" id="csFilterDrawer">
            <form action="{{ route('admin.projects.index') }}" method="GET" id="filterForm">
                <input type="hidden" name="view" value="{{ $view }}">
                <div class="row g-3">
                    <div class="col-md-4 col-lg-3">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Project, client, phone, email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            @foreach (['Pending', 'In Progress', 'Completed', 'On Hold', 'Cancelled'] as $statusOption)
                                <option value="{{ $statusOption }}" @selected(request('status') === $statusOption)>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label>Priority</label>
                        <select name="priority" class="form-select">
                            <option value="">All Priority</option>
                            @foreach (['Low', 'Medium', 'High', 'Critical'] as $priorityOption)
                                <option value="{{ $priorityOption }}" @selected(request('priority') === $priorityOption)>{{ $priorityOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label>Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">All Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <label>Developer</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">All Developers</option>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->id }}" @selected((string) request('assigned_to') === (string) $developer->id)>{{ $developer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-lg-3">
                        <label>Client</label>
                        <select name="client_name" class="form-select">
                            <option value="">All Clients</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client }}" @selected(request('client_name') === $client)>{{ $client }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label>Project Source</label>
                        <select name="source" class="form-select">
                            <option value="">All Sources</option>
                            <option value="manual" @selected(request('source') === 'manual')>Manual</option>
                            <option value="lead" @selected(request('source') === 'lead')>Lead</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label>From Date</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label>To Date</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <label>Sort By</label>
                        <select name="sort_by" class="form-select">
                            <option value="latest" @selected(request('sort_by', 'latest') === 'latest')>Newest First</option>
                            <option value="oldest" @selected(request('sort_by') === 'oldest')>Oldest First</option>
                            <option value="deadline_asc" @selected(request('sort_by') === 'deadline_asc')>Deadline (Earliest)</option>
                            <option value="deadline_desc" @selected(request('sort_by') === 'deadline_desc')>Deadline (Latest)</option>
                            <option value="priority" @selected(request('sort_by') === 'priority')>Priority (Critical First)</option>
                            <option value="name_asc" @selected(request('sort_by') === 'name_asc')>Project Name (A-Z)</option>
                            <option value="name_desc" @selected(request('sort_by') === 'name_desc')>Project Name (Z-A)</option>
                        </select>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('admin.projects.index') }}" class="cs-icon-btn"><i class="fa-solid fa-rotate-left"></i> Reset Filters</a>
                        <button type="submit" class="cs-icon-btn cs-primary"><i class="fa-solid fa-magnifying-glass"></i> Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ======================= MAIN CONTENT ======================= --}}
    <div class="row g-4">
        <div class="col-lg-8">

            @if ($projects->isEmpty())
                <div class="cs-empty" data-cs-anim="up">
                    <i class="fa-solid fa-folder-open"></i>
                    <h5>No projects found</h5>
                    <p>Try adjusting your filters, or create your first project to get started.</p>
                    <a href="{{ route('admin.projects.create') }}" class="cs-icon-btn cs-primary"><i class="fa-solid fa-plus"></i> Create First Project</a>
                </div>

            @elseif ($view === 'table')
                <div class="cs-surface cs-table-wrap" data-cs-anim="up">
                    <table class="cs-table">
                        <thead>
                            <tr>
                                <th>Project</th><th>Client</th><th>Department</th><th>Developer</th>
                                <th>Priority</th><th>Status</th><th style="width:140px;">Progress</th>
                                <th>Deadline</th><th>Health</th><th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                @php $meta = $computeProjectMeta($project); extract($meta); $healthPillClass = ['Healthy'=>'cs-pill-healthy','At Risk'=>'cs-pill-risk','Critical'=>'cs-pill-critical','Completed'=>'cs-pill-done'][$health]; @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold" style="font-size:.83rem;">{{ $project->project_name }}</div>
                                        <div style="font-size:.71rem; color:var(--cs-text-2);">{{ $moduleCount }} modules &middot; {{ $project->attachments->count() }} files</div>
                                    </td>
                                    <td>{{ $project->client_name }}</td>
                                    <td>{{ $project->department->title ?? '—' }}</td>
                                    <td>{{ $project->assignedTo->name ?? 'Unassigned' }}</td>
                                    <td><span class="cs-badge {{ $priorityClass }}">{{ $project->priority }}</span></td>
                                    <td><span class="cs-badge {{ $statusClass }}">{{ $project->status }}</span></td>
                                    <td>
                                        <span class="cs-perf-bar" style="width:60px;"><span style="width:{{ $avgProgress }}%"></span></span>
                                        <span style="font-size:.72rem; color:var(--cs-text-2);">{{ $avgProgress }}%</span>
                                    </td>
                                    <td>{{ $project->deadline ? \Illuminate\Support\Carbon::parse($project->deadline)->format('d M Y') : '—' }}</td>
                                    <td><span class="cs-pill {{ $healthPillClass }}"><span class="cs-dot"></span>{{ $health }}</span></td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            @can('project-show')
                                                <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fa-solid fa-eye"></i></a>
                                            @endcan
                                            @can('project-edit')
                                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                            @endcan
                                            @can('project-delete')
                                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project? This cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">{{ $projects->onEachSide(1)->links() }}</div>

            @elseif ($view === 'kanban')
                @php
                    $kanbanColumns = ['Pending', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];
                    $grouped = $projects->groupBy('status');
                @endphp
                <div class="row flex-nowrap overflow-auto pb-2" style="gap: 1rem;" data-cs-anim="up">
                    @foreach ($kanbanColumns as $column)
                        <div class="cs-kanban-col">
                            <div class="cs-kanban-head">
                                <span class="cs-kanban-title">{{ $column }}</span>
                                <span class="cs-kanban-count">{{ $grouped->get($column, collect())->count() }}</span>
                            </div>
                            <div class="d-flex flex-column" style="gap:.65rem;">
                                @forelse ($grouped->get($column, collect()) as $project)
                                    @php $meta = $computeProjectMeta($project); extract($meta); $healthPillClass = ['Healthy'=>'cs-pill-healthy','At Risk'=>'cs-pill-risk','Critical'=>'cs-pill-critical','Completed'=>'cs-pill-done'][$health]; @endphp
                                    <div class="cs-surface cs-kanban-card">
                                        <div style="display:flex; align-items:flex-start; gap:.6rem; margin-bottom:.65rem;">
                                            <span class="cs-row-icon"><i class="fa-solid fa-diagram-project"></i></span>
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="cs-row-name" style="font-size:.82rem;">{{ $project->project_name }}</div>
                                                <div class="cs-row-sub">{{ $project->client_name }}</div>
                                            </div>
                                        </div>
                                        <div style="display:flex; gap:.35rem; flex-wrap:wrap; margin-bottom:.6rem;">
                                            <span class="cs-badge {{ $priorityClass }}">{{ $project->priority }}</span>
                                            <span class="cs-pill {{ $healthPillClass }}"><span class="cs-dot"></span>{{ $health }}</span>
                                        </div>
                                        <div class="progress mb-2" style="height:5px; border-radius:99px; background:#ECEFF3;">
                                            <div class="progress-bar" style="width: {{ $avgProgress }}%; background:var(--cs-teal-bright); border-radius:99px;"></div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="cs-dev-avatar">{{ $initials }}</span>
                                            @can('project-show')
                                                <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                            @endcan
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted text-center" style="font-size:.76rem;">No projects</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
                <p style="font-size:.75rem; color:var(--cs-text-2); margin-top:.85rem;">
                    <i class="fa-solid fa-circle-info"></i> Kanban shows up to 300 matching projects grouped by status (not paginated). Switch to Table or Cards view to page through larger result sets.
                </p>

            @else
                <div class="cs-workspace-head">
                    <h2>Project Workspace</h2>
                    <span>{{ $projects->count() }} of {{ $totalProjects }} projects</span>
                </div>

                @foreach ($projects as $project)
                    @php $meta = $computeProjectMeta($project); extract($meta); $healthPillClass = ['Healthy'=>'cs-pill-healthy','At Risk'=>'cs-pill-risk','Critical'=>'cs-pill-critical','Completed'=>'cs-pill-done'][$health]; @endphp
                    <div class="cs-row" data-cs-anim="up">
                        <div class="cs-row-id">
                            <span class="cs-row-icon"><i class="fa-solid fa-diagram-project"></i></span>
                            <div class="min-w-0">
                                <div class="cs-row-name">{{ $project->project_name }}</div>
                                <div class="cs-row-sub">
                                    {{ $project->client_name }}@if ($project->department) &middot; {{ $project->department->title }}@endif
                                </div>
                            </div>
                        </div>

                        <div class="cs-row-progress">
                            <div class="cs-progress-label"><span>Progress</span><span>{{ $avgProgress }}%</span></div>
                            <div class="progress"><div class="progress-bar" style="width: {{ $avgProgress }}%"></div></div>
                        </div>

                        <div class="cs-row-meta">
                            <div class="cs-row-meta-item"><span>Health</span><span class="cs-pill {{ $healthPillClass }}"><span class="cs-dot"></span>{{ $health }}</span></div>
                            <div class="cs-row-meta-item"><span>Priority</span><span class="cs-badge {{ $priorityClass }}">{{ $project->priority }}</span></div>
                            <div class="cs-row-meta-item"><span>Deadline</span><strong>{{ $project->deadline ? \Illuminate\Support\Carbon::parse($project->deadline)->format('d M') : '—' }}</strong></div>
                            <div class="cs-row-meta-item"><span>Modules</span><strong>{{ $completedModules }} / {{ $moduleCount }}</strong></div>
                        </div>

                        <div class="cs-row-actions">
                            <span class="cs-dev-avatar" title="{{ $project->assignedTo->name ?? 'Unassigned' }}">{{ $initials }}</span>
                            <div class="cs-row-actions-btns">
                                @can('project-show')
                                    <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fa-solid fa-eye"></i></a>
                                @endcan
                                @can('project-edit')
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                @endcan
                                @can('module-create')
                                    <a href="{{ route('admin.projects.modules.create', $project->id) }}" class="btn btn-sm btn-outline-info" title="Modules"><i class="fa-solid fa-sitemap"></i></a>
                                @endcan
                                @if(auth()->user()->hasRole('Admin') || $project->assigned_to == auth()->id())
                                    <a href="{{ route('admin.projects.chat', $project->id) }}" class="btn btn-sm btn-outline-success" title="Project Chat"><i class="fa-solid fa-comments"></i></a>
                                @endif
                                @can('project-delete')
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-2">{{ $projects->onEachSide(1)->links() }}</div>
            @endif
        </div>

        {{-- ======================= SIDEBAR ======================= --}}
        <div class="col-lg-4">

            <div class="cs-surface cs-side-card cs-section" data-cs-anim="up">
                <div class="cs-side-head"><h3><i class="fa-solid fa-bolt"></i> Recent Activity</h3></div>
                <div class="cs-timeline">
                    @forelse ($recentActivities as $activity)
                        <div class="cs-timeline-item">
                            <div class="cs-timeline-title">{{ $activity->createdBy->name ?? 'System' }} created a project</div>
                            <div class="cs-timeline-sub">{{ $activity->project_name }} &middot; {{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p class="text-muted mb-0" style="font-size:.82rem;">No recent activity.</p>
                    @endforelse
                </div>
            </div>

            <div class="cs-surface cs-side-card cs-section" data-cs-anim="up">
                <div class="cs-side-head"><h3><i class="fa-solid fa-calendar-days"></i> Upcoming Deadlines</h3></div>
                @forelse ($upcomingDeadlines as $deadlineProject)
                    @php
                        $dl = \Illuminate\Support\Carbon::parse($deadlineProject->deadline)->startOfDay();
                        $daysTo = \Illuminate\Support\Carbon::today()->diffInDays($dl, false);
                        $dlHealth = $daysTo <= 2 ? 'cs-pill-risk' : 'cs-pill-healthy';
                        $dlLabel = $daysTo === 0 ? 'Due today' : ($daysTo < 0 ? 'Overdue' : 'Due in ' . $daysTo . ' day' . ($daysTo > 1 ? 's' : ''));
                    @endphp
                    <div class="cs-deadline-row">
                        <div>
                            <a href="{{ route('admin.projects.show', $deadlineProject->id) }}" class="cs-deadline-name text-decoration-none">{{ $deadlineProject->project_name }}</a>
                            <div class="cs-deadline-sub">{{ $dlLabel }} &middot; {{ $dl->format('d M Y') }}</div>
                        </div>
                        <span class="cs-pill {{ $dlHealth }}"><span class="cs-dot"></span></span>
                    </div>
                @empty
                    <p class="text-muted mb-0" style="font-size:.82rem;">No upcoming deadlines.</p>
                @endforelse
            </div>

            <div class="cs-surface cs-side-card cs-section" data-cs-anim="up">
                <div class="cs-side-head"><h3><i class="fa-solid fa-clock-rotate-left"></i> Recently Added</h3></div>
                @forelse ($recentProjects as $recent)
                    <div class="cs-deadline-row">
                        <div>
                            <a href="{{ route('admin.projects.show', $recent->id) }}" class="cs-deadline-name text-decoration-none">{{ $recent->project_name }}</a>
                            <div class="cs-deadline-sub">{{ $recent->client_name }} &middot; {{ $recent->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0" style="font-size:.82rem;">No projects yet.</p>
                @endforelse
            </div>

            <div class="cs-surface cs-side-card" data-cs-anim="up">
                <div class="cs-side-head"><h3><i class="fa-solid fa-terminal"></i> Quick Actions</h3></div>
                @can('project-create')
                    <a href="{{ route('admin.projects.create') }}" class="cs-quick-btn"><i class="fa-solid fa-plus"></i> New Project <i class="fa-solid fa-chevron-right cs-chevron"></i></a>
                @endcan
                <a href="{{ route('admin.projects.index', ['status' => 'Pending']) }}" class="cs-quick-btn"><i class="fa-solid fa-hourglass-half"></i> View Pending <i class="fa-solid fa-chevron-right cs-chevron"></i></a>
                <a href="{{ route('admin.projects.index', ['sort_by' => 'deadline_asc']) }}" class="cs-quick-btn"><i class="fa-solid fa-calendar-day"></i> Upcoming Deadlines <i class="fa-solid fa-chevron-right cs-chevron"></i></a>
                <a href="{{ route('admin.projects.index', ['view' => 'table']) }}" class="cs-quick-btn"><i class="fa-solid fa-chart-simple"></i> Reports View <i class="fa-solid fa-chevron-right cs-chevron"></i></a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.1/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* =========================================================
       1. DASHBOARD CONFIGURATION
    ========================================================= */
    const csColors = {
        tealDeep: '#0F7F8C',
        tealBright: '#12A8B8',
        cyan: '#18C3D3',
        charcoal: '#17212B',
        text: '#182230',
        muted: '#667085',
        border: '#E5EAF0',
        warning: '#B4650C',
        danger: '#C0134A',
        success: '#12825A',
    };
    const csFontFamily = "'Inter', sans-serif";
    const csOverallProgress = {{ (int) $overallProgress }};

    const csTrendData = {
        labels: @json($trendLabels),
        progress: @json($trendProgress),
    };
    const csStatusDonut = {
        labels: ['Active', 'Pending', 'Completed', 'On Hold', 'Cancelled'],
        series: @json($statusDonutSeries),
    };
    const csWorkload = {
        labels: @json(array_keys($workload)),
        series: @json(array_values($workload)),
    };
    const csPriority = {
        labels: @json(array_keys($priorityCounts)),
        series: @json(array_values($priorityCounts)),
    };
    const csDeadline = {
        labels: @json($upcomingDeadlines->pluck('project_name')->map(fn($n) => \Illuminate\Support\Str::limit($n, 14))->values()),
        days: @json($upcomingDeadlines->map(function($p){
                $d = \Illuminate\Support\Carbon::parse($p->deadline)->startOfDay();
                return \Illuminate\Support\Carbon::today()->diffInDays($d, false);
            })->values()),
    };

    /* =========================================================
       2. APEXCHARTS
    ========================================================= */
    if (typeof ApexCharts !== 'undefined') {

        // Portfolio health radial gauge
        new ApexCharts(document.querySelector('#csRadialGauge'), {
            chart: { type: 'radialBar', height: 132, sparkline: { enabled: true }, animations: { enabled: true, speed: 700 } },
            series: [csOverallProgress],
            colors: [csColors.tealBright],
            plotOptions: {
                radialBar: {
                    hollow: { size: '68%' },
                    track: { background: '#EEF1F5', strokeWidth: '100%' },
                    dataLabels: {
                        name: { show: false },
                        value: { show: false },
                    },
                }
            },
            stroke: { lineCap: 'round' },
        }).render().then(() => {
            const wrap = document.createElement('div');
            wrap.className = 'cs-radial-value';
            wrap.innerHTML = `<strong>${csOverallProgress}%</strong><small>Progress</small>`;
            document.querySelector('#csRadialGauge').appendChild(wrap);
        });

        // Project health trend
        new ApexCharts(document.querySelector('#csTrendChart'), {
            chart: { type: 'area', height: 230, toolbar: { show: false }, fontFamily: csFontFamily,
                animations: { enabled: true, easing: 'easeinout', speed: 500 } },
            series: [{ name: 'Progress', data: csTrendData.progress }],
            xaxis: { categories: csTrendData.labels, labels: { style: { colors: csColors.muted, fontSize: '11px' } },
                axisBorder: { color: csColors.border }, axisTicks: { color: csColors.border } },
            yaxis: { max: 100, labels: { style: { colors: csColors.muted, fontSize: '11px' }, formatter: v => v + '%' } },
            grid: { borderColor: csColors.border, strokeDashArray: 4, padding: { left: 8, right: 8 } },
            colors: [csColors.tealBright],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02, stops: [0, 90, 100] } },
            stroke: { curve: 'smooth', width: 2.5 },
            markers: { size: 3, colors: ['#fff'], strokeColors: csColors.tealBright, strokeWidth: 2, hover: { size: 5 } },
            dataLabels: { enabled: false },
            tooltip: { theme: 'light', y: { formatter: v => v + '%' } },
        }).render();

        // Status donut
        new ApexCharts(document.querySelector('#csStatusDonut'), {
            chart: { type: 'donut', height: 230, fontFamily: csFontFamily, animations: { enabled: true, speed: 500 } },
            series: csStatusDonut.series,
            labels: csStatusDonut.labels,
            colors: [csColors.tealBright, csColors.warning, csColors.success, csColors.charcoal, csColors.danger],
            legend: { position: 'bottom', fontSize: '11px', labels: { colors: csColors.muted }, markers: { width: 7, height: 7, radius: 6 }, itemMargin: { horizontal: 8, vertical: 3 } },
            dataLabels: { enabled: false },
            stroke: { width: 2, colors: ['#fff'] },
            plotOptions: { pie: { donut: { size: '72%', labels: {
                show: true,
                total: { show: true, label: 'Total', color: csColors.muted, fontSize: '11px',
                    formatter: () => csStatusDonut.series.reduce((a,b)=>a+b,0) },
                value: { color: csColors.text, fontSize: '20px', fontWeight: 800 },
            } } } },
            tooltip: { theme: 'light' },
        }).render();

        // Team workload
        const workloadHasData = csWorkload.labels.length > 0;
        new ApexCharts(document.querySelector('#csWorkloadChart'), {
            chart: { type: 'bar', height: 230, toolbar: { show: false }, fontFamily: csFontFamily, animations: { enabled: true, speed: 500 } },
            series: [{ name: 'Projects', data: workloadHasData ? csWorkload.series : [0] }],
            xaxis: { categories: workloadHasData ? csWorkload.labels : ['No data'], labels: { style: { colors: csColors.muted, fontSize: '11px' } },
                axisBorder: { color: csColors.border }, axisTicks: { color: csColors.border } },
            plotOptions: { bar: { horizontal: true, borderRadius: 5, barHeight: '55%', distributed: false } },
            colors: [csColors.tealDeep],
            grid: { borderColor: csColors.border, strokeDashArray: 4 },
            dataLabels: { enabled: true, style: { colors: [csColors.text], fontSize: '11px', fontWeight: 700 }, offsetX: 6 },
            tooltip: { theme: 'light' },
        }).render();

        // Priority matrix
        new ApexCharts(document.querySelector('#csPriorityChart'), {
            chart: { type: 'bar', height: 230, toolbar: { show: false }, fontFamily: csFontFamily, animations: { enabled: true, speed: 500 } },
            series: [{ name: 'Projects', data: csPriority.series }],
            xaxis: { categories: csPriority.labels, labels: { style: { colors: csColors.muted, fontSize: '11px' } },
                axisBorder: { color: csColors.border }, axisTicks: { color: csColors.border } },
            yaxis: { labels: { style: { colors: csColors.muted, fontSize: '11px' } } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '48%', distributed: true } },
            colors: ['#7f1d1d', csColors.danger, csColors.warning, csColors.success],
            legend: { show: false },
            grid: { borderColor: csColors.border, strokeDashArray: 4 },
            dataLabels: { enabled: false },
            tooltip: { theme: 'light' },
        }).render();

        // Deadline radar
        const deadlineHasData = csDeadline.labels.length > 0;
        new ApexCharts(document.querySelector('#csDeadlineChart'), {
            chart: { type: 'bar', height: 230, toolbar: { show: false }, fontFamily: csFontFamily, animations: { enabled: true, speed: 500 } },
            series: [{ name: 'Days remaining', data: deadlineHasData ? csDeadline.days : [0] }],
            xaxis: { categories: deadlineHasData ? csDeadline.labels : ['No upcoming deadlines'], labels: { style: { colors: csColors.muted, fontSize: '10px' }, rotate: -20, trim: true },
                axisBorder: { color: csColors.border }, axisTicks: { color: csColors.border } },
            plotOptions: { bar: { borderRadius: 5, columnWidth: '45%',
                colors: { ranges: [
                    { from: -9999, to: 0, color: csColors.danger },
                    { from: 1, to: 3, color: csColors.warning },
                    { from: 4, to: 9999, color: csColors.tealBright },
                ] } } },
            grid: { borderColor: csColors.border, strokeDashArray: 4 },
            dataLabels: { enabled: true, style: { colors: [csColors.text], fontSize: '10px', fontWeight: 700 }, offsetY: -18 },
            tooltip: { theme: 'light', y: { formatter: v => v + ' day(s)' } },
        }).render();
    }

    /* =========================================================
       3. ANIMATION INITIALIZATION
    ========================================================= */
    if (typeof gsap !== 'undefined') {
        const els = document.querySelectorAll('[data-cs-anim="up"]');
        gsap.to(els, {
            opacity: 1, y: 0, duration: .5, ease: 'power2.out', stagger: .06,
            onStart: () => els.forEach(el => el.style.transform = ''),
        });
        gsap.set(els, { y: 14 });
        gsap.to(els, { opacity: 1, y: 0, duration: .5, ease: 'power2.out', stagger: .06 });

        // Animated KPI counters
        document.querySelectorAll('.cs-mono[data-count]').forEach(el => {
            const target = parseInt(el.getAttribute('data-count'), 10) || 0;
            const counter = { val: 0 };
            gsap.to(counter, {
                val: target, duration: .9, ease: 'power1.out', delay: .15,
                onUpdate: () => el.textContent = Math.round(counter.val),
            });
        });
    } else {
        document.querySelectorAll('[data-cs-anim="up"]').forEach(el => el.style.opacity = 1);
        document.querySelectorAll('.cs-mono[data-count]').forEach(el => el.textContent = el.getAttribute('data-count'));
    }

    /* =========================================================
       4. FILTERS
    ========================================================= */
    const filterDrawer = document.getElementById('csFilterDrawer');
    const filterToggles = [document.getElementById('csFilterToggle'), document.getElementById('csFilterToggle2')].filter(Boolean);
    filterToggles.forEach(btn => {
        btn.addEventListener('click', function () {
            filterDrawer.classList.toggle('cs-open');
            if (filterDrawer.classList.contains('cs-open')) {
                filterDrawer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    });

    const exportBtn = document.getElementById('csExportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function () {
            const params = new URLSearchParams(window.location.search);
            params.set('export', '1');
            window.location.href = '{{ route('admin.projects.index') }}?' + params.toString();
        });
    }

    /* =========================================================
       5. MICRO INTERACTIONS
    ========================================================= */
    if (typeof gsap !== 'undefined') {
        document.querySelectorAll('.cs-row').forEach(row => {
            row.addEventListener('mouseenter', () => gsap.to(row, { y: -2, duration: .18, ease: 'power1.out' }));
            row.addEventListener('mouseleave', () => gsap.to(row, { y: 0, duration: .18, ease: 'power1.out' }));
        });
    }
});
</script>
@endpush