@extends('index')

@section('title', $project->project_name . ' - Project Workspace')

@push('css')
    <style>
        :root{
            --cs-primary:#0F8EA3;
            --cs-bright:#16B6C8;
            --cs-dark:#102A33;
            --cs-bg:#F5F8FA;
            --cs-white:#FFFFFF;
            --cs-text:#17202A;
            --cs-muted:#6B7280;
            --cs-border:#E6ECEF;
        }

        .main_content{
            padding: 0px;
        }

        .submodule-status:disabled {
            opacity: 1;
            cursor: not-allowed;
            color: inherit;
            background-color: inherit;
        }

        .csw{
            background:var(--cs-bg);
            color:var(--cs-text);
            font-family:'Inter',-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
        }

        .csw *{ box-sizing:border-box; }

        /* ================= COMMAND BAR ================= */
        .csw-command{
            position:sticky;
            top:0;
            z-index:40;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
            padding:.85rem 1.25rem;
            background:rgba(255,255,255,.88);
            backdrop-filter:blur(10px);
            border:1px solid var(--cs-border);
            border-radius:14px;
            margin-bottom:1.25rem;
        }

        .csw-command-left{
            display:flex;
            align-items:center;
            gap:.9rem;
            min-width:0;
        }

        .csw-back{
            width:34px;
            height:34px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:var(--cs-bg);
            border:1px solid var(--cs-border);
            color:var(--cs-text);
            flex:0 0 auto;
            transition:.2s ease;
        }
        .csw-back:hover{ background:#EAF6F8; color:var(--cs-primary); border-color:var(--cs-primary); }

        .csw-crumb{
            font-size:.82rem;
            color:var(--cs-muted);
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .csw-crumb strong{ color:var(--cs-text); font-weight:600; }

        .csw-command-right{ display:flex; align-items:center; gap:.5rem; flex:0 0 auto; }

        .csw-icon-btn{
            width:34px;
            height:34px;
            border-radius:10px;
            border:1px solid var(--cs-border);
            background:var(--cs-white);
            color:var(--cs-text);
            display:flex;
            align-items:center;
            justify-content:center;
            transition:.2s ease;
        }
        .csw-icon-btn:hover{ border-color:var(--cs-primary); color:var(--cs-primary); }

        .csw-btn-primary{
            background:var(--cs-primary);
            color:#fff;
            border:1px solid var(--cs-primary);
            border-radius:10px;
            padding:.4rem .9rem;
            font-size:.82rem;
            font-weight:600;
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            transition:.2s ease;
        }
        .csw-btn-primary:hover{ background:var(--cs-bright); border-color:var(--cs-bright); color:#fff; }

        /* ================= HERO ================= */
        .csw-hero{
            position:relative;
            border-radius:18px;
            padding:2.1rem 2.2rem;
            background:
                radial-gradient(650px 260px at 85% -10%, rgba(22,182,200,.35), transparent 60%),
                linear-gradient(150deg, var(--cs-dark) 0%, #0C222A 55%, #091920 100%);
            color:#fff;
            overflow:hidden;
            margin-bottom:1.25rem;
            opacity:0;
            transform:translateY(10px);
            animation:cswFadeUp .55s ease forwards;
        }

        @keyframes cswFadeUp{
            to{ opacity:1; transform:translateY(0); }
        }

        .csw-hero::after{
            content:"";
            position:absolute;
            inset:0;
            background-image:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size:34px 34px;
            pointer-events:none;
        }

        .csw-hero-grid{
            position:relative;
            z-index:2;
            display:grid;
            grid-template-columns:1fr 220px;
            gap:1.5rem;
            align-items:center;
        }

        .csw-eyebrow{
            display:inline-flex;
            align-items:center;
            gap:.5rem;
            font-size:.72rem;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#9FD9E1;
            margin-bottom:.6rem;
        }

        .csw-eyebrow span.dot{
            width:6px;height:6px;border-radius:50%;background:var(--cs-bright);
            box-shadow:0 0 0 4px rgba(22,182,200,.25);
        }

        .csw-hero h1{
            font-size:2rem;
            font-weight:700;
            letter-spacing:-.02em;
            margin:0 0 .35rem;
            line-height:1.15;
        }

        .csw-hero-sub{
            color:#B9CDD3;
            font-size:.86rem;
            margin-bottom:1.4rem;
        }

        .csw-pill{
            display:inline-flex;
            align-items:center;
            gap:.35rem;
            padding:.3rem .7rem;
            border-radius:20px;
            font-size:.72rem;
            font-weight:600;
            letter-spacing:.02em;
            border:1px solid rgba(255,255,255,.18);
            background:rgba(255,255,255,.06);
        }

        .csw-pill.priority-Low{ color:#BFD3D8; }
        .csw-pill.priority-Medium{ color:#8FDDEA; border-color:rgba(22,182,200,.4); background:rgba(22,182,200,.12); }
        .csw-pill.priority-High{ color:#FFD08A; border-color:rgba(255,171,64,.4); background:rgba(255,171,64,.12); }
        .csw-pill.priority-Critical{ color:#FF9E9E; border-color:rgba(255,90,90,.4); background:rgba(255,90,90,.12); }

        .csw-pill.status-Pending{ color:#BFD3D8; }
        .csw-pill.status-Planning{ color:#8FDDEA; border-color:rgba(22,182,200,.4); background:rgba(22,182,200,.12); }
        .csw-pill.status-InProgress{ color:#8FDDEA; border-color:rgba(22,182,200,.5); background:rgba(22,182,200,.16); }
        .csw-pill.status-Testing{ color:#FFD08A; border-color:rgba(255,171,64,.4); background:rgba(255,171,64,.12); }
        .csw-pill.status-OnHold{ color:#FFD08A; border-color:rgba(255,171,64,.4); background:rgba(255,171,64,.12); }
        .csw-pill.status-Completed{ color:#8CE3B0; border-color:rgba(76,201,140,.4); background:rgba(76,201,140,.12); }
        .csw-pill.status-Cancelled{ color:#FF9E9E; border-color:rgba(255,90,90,.4); background:rgba(255,90,90,.12); }

        .csw-hero-meta{
            display:flex;
            flex-wrap:wrap;
            gap:1.8rem;
            margin-top:1.4rem;
        }

        .csw-hero-meta-item .k{
            font-size:.68rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:#8CA6AC;
            margin-bottom:.2rem;
        }
        .csw-hero-meta-item .v{
            font-size:.92rem;
            font-weight:600;
            color:#fff;
        }

        .csw-hero-radial{
            position:relative;
            z-index:2;
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .csw-radial-label{
            margin-top:.4rem;
            font-size:.72rem;
            color:#9FD9E1;
            text-transform:uppercase;
            letter-spacing:.06em;
        }

        /* ================= DELIVERY STRIP ================= */
        .csw-strip{
            display:flex;
            flex-wrap:wrap;
            background:var(--cs-white);
            border:1px solid var(--cs-border);
            border-radius:16px;
            margin-bottom:1.25rem;
            overflow:hidden;
        }

        .csw-strip-item{
            flex:1 1 12%;
            padding:1.1rem 1.3rem;
            border-right:1px solid var(--cs-border);
            min-width:118px;
            opacity:0;
            animation:cswFadeUp .45s ease forwards;
        }
        .csw-strip-item:last-child{ border-right:none; }

        .csw-strip-item .k{
            font-size:.68rem;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:var(--cs-muted);
            margin-bottom:.3rem;
        }
        .csw-strip-item .v{
            font-size:1.45rem;
            font-weight:700;
            color:var(--cs-text);
        }
        .csw-strip-item .v small{
            font-size:.85rem;
            font-weight:600;
            color:var(--cs-muted);
        }

        /* ================= SECTION HEADERS ================= */
        .csw-section-title{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:.9rem;
        }
        .csw-section-title h2{
            font-size:1.05rem;
            font-weight:700;
            margin:0;
            display:flex;
            align-items:center;
            gap:.5rem;
            color:var(--cs-text);
        }
        .csw-section-title h2 i{ color:var(--cs-primary); font-size:.95rem; }
        .csw-section-title .count{
            font-size:.78rem;
            color:var(--cs-muted);
            font-weight:500;
        }

        /* ================= PANEL ================= */
        .csw-panel{
            background:var(--cs-white);
            border:1px solid var(--cs-border);
            border-radius:16px;
            padding:1.3rem;
            margin-bottom:1.25rem;
        }
        .csw-panel h3{
            font-size:.9rem;
            font-weight:700;
            margin:0 0 .9rem;
            color:var(--cs-text);
        }

        /* ================= HEALTH ROWS ================= */
        .csw-health-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:.6rem 0;
            border-bottom:1px solid var(--cs-border);
            font-size:.85rem;
        }
        .csw-health-row:last-child{ border-bottom:none; }
        .csw-health-row .label{ color:var(--cs-muted); display:flex; align-items:center; gap:.5rem; }
        .csw-health-tag{
            font-size:.72rem;
            font-weight:700;
            padding:.22rem .6rem;
            border-radius:20px;
        }
        .csw-health-tag.good{ color:#1C8A5A; background:#E5F7EE; }
        .csw-health-tag.warn{ color:#B4700A; background:#FFF3E0; }
        .csw-health-tag.bad{ color:#C4302B; background:#FDEAEA; }
        .csw-health-tag.neutral{ color:var(--cs-muted); background:#F1F4F6; }

        /* ================= MODULES / DELIVERY BOARD ================= */
        .csw-module{
            position:relative;
            background:var(--cs-white);
            border:1px solid var(--cs-border);
            border-radius:14px;
            padding:1.1rem 1.2rem 1.1rem 1.5rem;
            margin-bottom:.85rem;
            transition:.2s ease;
        }
        .csw-module:hover{
            box-shadow:0 8px 22px rgba(15,142,163,.08);
            transform:translateY(-1px);
        }
        .csw-module::before{
            content:"";
            position:absolute;
            left:0; top:.7rem; bottom:.7rem;
            width:4px;
            border-radius:4px;
            background:var(--module-color, var(--cs-primary));
        }

        .csw-module-top{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:1rem;
            flex-wrap:wrap;
        }

        .csw-module-id{
            display:flex;
            align-items:center;
            gap:.85rem;
        }
        .csw-module-num{
            width:34px;height:34px;
            border-radius:9px;
            background:#EAF6F8;
            color:var(--cs-primary);
            font-weight:700;
            font-size:.82rem;
            display:flex;align-items:center;justify-content:center;
            flex:0 0 auto;
        }
        .csw-module-name{ font-size:.98rem; font-weight:700; color:var(--cs-text); margin:0; }
        .csw-module-type{
            font-size:.68rem;
            color:var(--cs-muted);
            border:1px solid var(--cs-border);
            border-radius:20px;
            padding:.1rem .5rem;
            margin-left:.4rem;
        }

        .csw-module-badges{ display:flex; gap:.4rem; flex-wrap:wrap; }
        .csw-badge{
            font-size:.68rem;
            font-weight:700;
            padding:.2rem .55rem;
            border-radius:20px;
            letter-spacing:.02em;
        }
        .csw-badge.p-Low{ color:#6B7280; background:#F1F4F6; }
        .csw-badge.p-Medium{ color:#0F8EA3; background:#E4F5F7; }
        .csw-badge.p-High{ color:#B4700A; background:#FFF3E0; }
        .csw-badge.p-Critical{ color:#C4302B; background:#FDEAEA; }

        .csw-badge.s-Pending{ color:#6B7280; background:#F1F4F6; }
        .csw-badge.s-Planning{ color:#0F8EA3; background:#E4F5F7; }
        .csw-badge.s-InProgress{ color:#0F8EA3; background:#DAF1F4; }
        .csw-badge.s-Testing{ color:#B4700A; background:#FFF3E0; }
        .csw-badge.s-OnHold{ color:#B4700A; background:#FFF3E0; }
        .csw-badge.s-Completed{ color:#1C8A5A; background:#E5F7EE; }
        .csw-badge.s-Cancelled{ color:#C4302B; background:#FDEAEA; }

        .csw-module-meta{
            display:flex;
            flex-wrap:wrap;
            gap:1.4rem;
            margin-top:.85rem;
            font-size:.78rem;
            color:var(--cs-muted);
        }
        .csw-module-meta span i{ color:#9AA7AC; margin-right:.35rem; }

        .csw-module-progress{ margin-top:.9rem; }
        .csw-module-progress-top{
            display:flex; justify-content:space-between; font-size:.75rem; margin-bottom:.3rem; color:var(--cs-muted);
        }
        .csw-progress-track{
            height:6px;
            border-radius:6px;
            background:#EEF2F4;
            overflow:hidden;
        }
        .csw-progress-fill{
            height:100%;
            border-radius:6px;
            background:var(--module-color, var(--cs-primary));
            width:0;
            transition:width 1s cubic-bezier(.22,1,.36,1);
        }

        .csw-module-tags{ margin-top:.7rem; }
        .csw-tag{
            font-size:.68rem;
            color:var(--cs-muted);
            border:1px solid var(--cs-border);
            border-radius:20px;
            padding:.1rem .5rem;
            margin-right:.3rem;
            display:inline-block;
        }

        .csw-module-footer{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-top:.9rem;
            flex-wrap:wrap;
            gap:.5rem;
        }

        .csw-expand-btn{
            font-size:.78rem;
            font-weight:600;
            color:var(--cs-primary);
            background:#EAF6F8;
            border:1px solid transparent;
            border-radius:9px;
            padding:.4rem .75rem;
            display:inline-flex;
            align-items:center;
            gap:.4rem;
            cursor:pointer;
        }
        .csw-expand-btn:hover{ background:#DDF0F2; }
        .csw-expand-btn i{ transition:.25s ease; }
        .csw-expand-btn.open i{ transform:rotate(180deg); }

        .csw-add-sub-link{
            font-size:.78rem;
            font-weight:600;
            color:var(--cs-muted);
        }
        .csw-add-sub-link:hover{ color:var(--cs-primary); }

        .csw-reject-alert{
            display:flex;
            align-items:center;
            gap:.5rem;
            font-size:.8rem;
            color:#C4302B;
            background:#FDEAEA;
            border-radius:10px;
            padding:.55rem .8rem;
            margin-bottom:.7rem;
        }

        /* ================= SUBMODULES ================= */
        .csw-submodules{
            margin-top:.9rem;
            padding-top:.9rem;
            border-top:1px dashed var(--cs-border);
            display:grid;
            gap:.55rem;
        }
        .csw-sub-row{
            background:#FAFCFD;
            border:1px solid var(--cs-border);
            border-radius:10px;
            padding:.7rem .9rem;
            display:grid;
            grid-template-columns:1.4fr 1fr 1fr .8fr .8fr 1fr;
            gap:.75rem;
            align-items:center;
            font-size:.78rem;
            transition:.15s ease;
        }
        .csw-sub-row:hover{ border-color:var(--cs-primary); background:#F3FBFC; }
        .csw-sub-name{ font-weight:600; color:var(--cs-text); }
        .csw-sub-label{ font-size:.65rem; text-transform:uppercase; letter-spacing:.05em; color:#9AA7AC; display:block; margin-bottom:.15rem; }
        .csw-sub-progress{ width:100%; }
        .csw-sub-progress .csw-progress-track{ height:5px; }

        .csw-sub-status-select{
            font-size:.75rem;
            border:1px solid var(--cs-border);
            border-radius:8px;
            padding:.25rem .4rem;
            background:#fff;
            color:var(--cs-text);
        }

        @media (max-width: 992px){
            .csw-sub-row{ grid-template-columns:1fr 1fr; }
        }

        /* ================= TEAM ================= */
        .csw-team-row{
            display:flex;
            align-items:center;
            gap:.75rem;
            padding:.6rem 0;
            border-bottom:1px solid var(--cs-border);
        }
        .csw-team-row:last-child{ border-bottom:none; }
        .csw-avatar{
            width:34px;height:34px;
            border-radius:50%;
            background:linear-gradient(135deg,var(--cs-primary),var(--cs-bright));
            color:#fff;
            font-size:.75rem;
            font-weight:700;
            display:flex;align-items:center;justify-content:center;
            flex:0 0 auto;
        }
        .csw-team-name{ font-size:.85rem; font-weight:600; color:var(--cs-text); }
        .csw-team-role{ font-size:.7rem; color:var(--cs-muted); }

        /* ================= FILES ================= */
        .csw-file-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:.7rem .3rem;
            border-bottom:1px solid var(--cs-border);
        }
        .csw-file-row:last-child{ border-bottom:none; }
        .csw-file-icon{
            width:36px;height:36px;
            border-radius:9px;
            background:#EAF6F8;
            color:var(--cs-primary);
            display:flex;align-items:center;justify-content:center;
            font-size:1rem;
            flex:0 0 auto;
        }
        .csw-file-name{ font-size:.85rem; font-weight:600; color:var(--cs-text); }
        .csw-file-meta{ font-size:.72rem; color:var(--cs-muted); }
        .csw-file-download{
            width:32px;height:32px;
            border-radius:8px;
            border:1px solid var(--cs-border);
            display:flex;align-items:center;justify-content:center;
            color:var(--cs-primary);
        }
        .csw-file-download:hover{ background:#EAF6F8; }

        /* ================= ACTIVITY ================= */
        .csw-activity{ position:relative; padding-left:1.3rem; }
        .csw-activity::before{
            content:"";
            position:absolute;
            left:5px; top:2px; bottom:2px;
            width:1.5px;
            background:var(--cs-border);
        }
        .csw-activity-item{ position:relative; padding-bottom:1rem; }
        .csw-activity-item:last-child{ padding-bottom:0; }
        .csw-activity-dot{
            position:absolute;
            left:-1.3rem; top:.15rem;
            width:11px;height:11px;
            border-radius:50%;
            background:var(--cs-primary);
            border:2px solid #fff;
            box-shadow:0 0 0 1px var(--cs-border);
        }
        .csw-activity-title{ font-size:.82rem; font-weight:600; color:var(--cs-text); }
        .csw-activity-meta{ font-size:.72rem; color:var(--cs-muted); }

        /* ================= TIMELINE (dates) ================= */
        .csw-datetrack{
            display:flex;
            align-items:center;
            gap:0;
            margin-top:.5rem;
        }
        .csw-datenode{
            display:flex;
            flex-direction:column;
            align-items:center;
            flex:0 0 auto;
            min-width:90px;
        }
        .csw-datenode .dot{
            width:12px;height:12px;border-radius:50%;
            background:var(--cs-primary);
            margin-bottom:.4rem;
        }
        .csw-datenode.muted .dot{ background:#C6D3D6; }
        .csw-datenode .lbl{ font-size:.68rem; text-transform:uppercase; letter-spacing:.04em; color:var(--cs-muted); }
        .csw-datenode .val{ font-size:.78rem; font-weight:700; color:var(--cs-text); margin-top:.1rem; }
        .csw-dateline{
            flex:1 1 auto;
            height:2px;
            background:repeating-linear-gradient(90deg, var(--cs-border) 0 6px, transparent 6px 11px);
            margin:0 -6px;
            margin-bottom:1.4rem;
        }

        @media (max-width: 768px){
            .csw-datetrack{ flex-direction:column; align-items:flex-start; }
            .csw-dateline{ width:2px; height:26px; margin:0 0 0 5px; background:var(--cs-border); }
        }

        /* ================= QUICK ACTIONS ================= */
        .csw-qa-btn{
            display:flex;
            align-items:center;
            gap:.6rem;
            width:100%;
            text-align:left;
            padding:.6rem .8rem;
            border-radius:10px;
            border:1px solid var(--cs-border);
            background:#fff;
            font-size:.82rem;
            font-weight:600;
            color:var(--cs-text);
            margin-bottom:.5rem;
            transition:.15s ease;
        }
        .csw-qa-btn:last-child{ margin-bottom:0; }
        .csw-qa-btn:hover{ border-color:var(--cs-primary); color:var(--cs-primary); background:#F5FBFC; }
        .csw-qa-btn i{ color:var(--cs-primary); }

        /* ================= EMPTY STATES ================= */
        .csw-empty{
            text-align:center;
            padding:2.4rem 1rem;
            color:var(--cs-muted);
            font-size:.85rem;
        }
        .csw-empty i{ font-size:1.6rem; display:block; margin-bottom:.5rem; color:#C6D3D6; }

        /* ================= FOOTER ================= */
        .csw-footer{
            display:flex;
            flex-wrap:wrap;
            gap:.6rem;
            padding:1rem 1.2rem;
            background:var(--cs-white);
            border:1px solid var(--cs-border);
            border-radius:14px;
            margin-top:.5rem;
            margin-bottom:2rem;
        }
        .csw-footer .btn{ font-size:.8rem; border-radius:9px; }

        /* stagger */
        .csw-strip-item:nth-child(1){ animation-delay:.05s; }
        .csw-strip-item:nth-child(2){ animation-delay:.1s; }
        .csw-strip-item:nth-child(3){ animation-delay:.15s; }
        .csw-strip-item:nth-child(4){ animation-delay:.2s; }
        .csw-strip-item:nth-child(5){ animation-delay:.25s; }
        .csw-strip-item:nth-child(6){ animation-delay:.3s; }
        .csw-strip-item:nth-child(7){ animation-delay:.35s; }
        .csw-strip-item:nth-child(8){ animation-delay:.4s; }

        @media (prefers-reduced-motion: reduce){
            .csw-hero, .csw-strip-item{ animation:none !important; opacity:1 !important; transform:none !important; }
            .csw-progress-fill{ transition:none !important; }
        }

        @media (max-width: 992px){
            .csw-hero-grid{ grid-template-columns:1fr; }
            .csw-hero-radial{ align-items:flex-start; margin-top:1rem; }
        }

        @media (max-width: 768px){
            .csw-strip{ overflow-x:auto; flex-wrap:nowrap; }
            .csw-strip-item{ border-right:1px solid var(--cs-border); flex:0 0 44%; }
        }
    </style>
@endpush

@section('content')
    @php
        $priorityColors = [
            'Low' => 'secondary',
            'Medium' => 'info',
            'High' => 'warning',
            'Critical' => 'danger',
        ];

        $statusColors = [
            'Pending' => 'secondary',
            'Planning' => 'info',
            'In Progress' => 'primary',
            'Testing' => 'warning',
            'On Hold' => 'warning',
            'Completed' => 'success',
            'Cancelled' => 'danger',
        ];

        $priorityColor = $priorityColors[$project->priority] ?? 'secondary';
        $statusColor = $statusColors[$project->status] ?? 'secondary';
        $statusSlug = str_replace(' ', '', $project->status);

        $health = 'Healthy';
        $healthColor = 'success';

        if (!is_null($remainingDays) && $remainingDays < 0 && $project->status !== 'Completed') {
            $health = 'Overdue';
            $healthColor = 'danger';
        } elseif (
            !is_null($remainingDays) &&
            $remainingDays <= 3 &&
            $overallProgress < 80 &&
            $project->status !== 'Completed'
        ) {
            $health = 'At Risk';
            $healthColor = 'warning';
        } elseif ($totalEstimatedHours > 0 && $totalActualHours > $totalEstimatedHours) {
            $health = 'Over Budget';
            $healthColor = 'warning';
        }

        $healthTagClass = ['success' => 'good', 'warning' => 'warn', 'danger' => 'bad'][$healthColor] ?? 'neutral';

        // Derived (view-only) chart datasets built strictly from existing relations/vars
        $moduleNames = $project->modules->pluck('module_name')->map(fn($n) => \Illuminate\Support\Str::limit($n, 14))->values();
        $moduleProgress = $project->modules->pluck('progress')->values();

        $subStatusCounts = $project->modules
            ->flatMap(fn($m) => $m->subModules)
            ->groupBy('status')
            ->map->count();

        // Developer workload derived purely from existing module estimated_hours + developer relation
        $developerWorkload = $project->modules
            ->filter(fn($m) => $m->developer)
            ->groupBy(fn($m) => $m->developer->name)
            ->map(fn($rows) => $rows->sum('estimated_hours'));

        $reviewWaitingCount = $project->modules
            ->flatMap(fn($m) => $m->assignments ?? collect())
            ->where('status', 'rejected')
            ->count();
    @endphp

    <div class="csw">
        <div class="container-fluid py-3">

            {{-- ================= COMMAND BAR ================= --}}
            <div class="csw-command">
                <div class="csw-command-left">
                    <a href="{{ url()->previous() }}" class="csw-back"><i class="bi bi-arrow-left"></i></a>
                    <div class="csw-crumb">
                        <i class="bi bi-diagram-3 me-1"></i> Projects / <strong>{{ $project->project_name }}</strong>
                    </div>
                </div>
                <div class="csw-command-right">
                    <button type="button" class="csw-icon-btn" title="Search"><i class="bi bi-search"></i></button>
                    @can('project-edit')
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="csw-btn-primary">
                            <i class="bi bi-pencil-square"></i> Edit Project
                        </a>
                    @endcan
                    <button type="button" class="csw-icon-btn" title="More actions"><i class="bi bi-three-dots"></i></button>
                </div>
            </div>

            {{-- ================= HERO ================= --}}
            <div class="csw-hero">
                <div class="csw-hero-grid">
                    <div>
                        <div class="csw-eyebrow"><span class="dot"></span> PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</div>
                        <h1>{{ $project->project_name }}</h1>
                        <div class="csw-hero-sub">
                            <i class="bi bi-building me-1"></i>{{ $project->department->title ?? '—' }}
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <span class="csw-pill status-{{ $statusSlug }}"><i class="bi bi-record-fill" style="font-size:.55rem;"></i>{{ $project->status }}</span>
                            <span class="csw-pill priority-{{ $project->priority }}"><i class="bi bi-flag-fill" style="font-size:.6rem;"></i>{{ $project->priority }} Priority</span>
                        </div>

                        <div class="csw-hero-meta">
                            <div class="csw-hero-meta-item">
                                <div class="k">Client</div>
                                <div class="v">{{ $project->client_name ?? '—' }}</div>
                            </div>
                            <div class="csw-hero-meta-item">
                                <div class="k">Lead Developer</div>
                                <div class="v">{{ $project->assignedTo->name ?? '—' }}</div>
                            </div>
                            <div class="csw-hero-meta-item">
                                <div class="k">Timeline</div>
                                <div class="v">
                                    {{ optional($project->start_date)->format('d M Y') ?? '—' }}
                                    <i class="bi bi-arrow-right mx-1" style="font-size:.7rem;"></i>
                                    {{ optional($project->deadline)->format('d M Y') ?? '—' }}
                                </div>
                            </div>
                            <div class="csw-hero-meta-item">
                                <div class="k">Remaining</div>
                                <div class="v">
                                    @if (is_null($remainingDays))
                                        —
                                    @elseif($remainingDays < 0)
                                        {{ abs($remainingDays) }}d overdue
                                    @else
                                        {{ $remainingDays }}d left
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="csw-hero-radial">
                        <div id="csw-chart-radial"></div>
                        <div class="csw-radial-label">Overall Progress</div>
                    </div>
                </div>
            </div>

            {{-- ================= DELIVERY STRIP ================= --}}
            <div class="csw-strip">
                <div class="csw-strip-item"><div class="k">Modules</div><div class="v">{{ $totalModules }}</div></div>
                <div class="csw-strip-item"><div class="k">Submodules</div><div class="v">{{ $totalSubModules }}</div></div>
                <div class="csw-strip-item"><div class="k">Developers</div><div class="v">{{ $developersCount }}</div></div>
                <div class="csw-strip-item"><div class="k">Completed</div><div class="v">{{ $completedModules }}</div></div>
                <div class="csw-strip-item"><div class="k">Pending</div><div class="v">{{ $pendingModules }}</div></div>
                <div class="csw-strip-item"><div class="k">Files</div><div class="v">{{ $attachmentsCount }}</div></div>
                <div class="csw-strip-item"><div class="k">Est. Hours</div><div class="v">{{ number_format($totalEstimatedHours, 1) }}<small>h</small></div></div>
                <div class="csw-strip-item"><div class="k">Remaining Hours</div><div class="v">{{ number_format($remainingHours, 1) }}<small>h</small></div></div>
            </div>

            <div class="row g-4">
                {{-- ================= MAIN WORKSPACE ================= --}}
                <div class="col-12 col-lg-8">

                    {{-- Project Overview --}}
                    <div class="csw-panel">
                        <div class="csw-section-title">
                            <h2><i class="bi bi-info-circle"></i>Project Overview</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="csw-health-row"><span class="label">Client</span><span>{{ $project->client_name ?? '—' }}</span></div>
                                <div class="csw-health-row"><span class="label">Phone</span><span>{{ $project->phone ?? '—' }}</span></div>
                                <div class="csw-health-row"><span class="label">Email</span><span>{{ $project->email ?? '—' }}</span></div>
                                <div class="csw-health-row"><span class="label">Department</span><span>{{ $project->department->title ?? '—' }}</span></div>
                            </div>
                            <div class="col-md-6">
                                <div class="csw-health-row"><span class="label">Lead Developer</span><span>{{ $project->assignedTo->name ?? '—' }}</span></div>
                                <div class="csw-health-row"><span class="label">Priority</span><span class="csw-badge p-{{ $project->priority }}">{{ $project->priority }}</span></div>
                                <div class="csw-health-row"><span class="label">Status</span><span class="csw-badge s-{{ $statusSlug }}">{{ $project->status }}</span></div>
                                <div class="csw-health-row"><span class="label">Source</span><span class="text-capitalize">{{ $project->source ?? '—' }}</span></div>
                            </div>
                        </div>

                        @if ($project->remarks)
                            <hr>
                            <div class="mb-2">
                                <div class="csw-sub-label mb-1">Remarks</div>
                                <div class="small">{{ $project->remarks }}</div>
                            </div>
                        @endif

                        @if ($project->project_description)
                            <hr>
                            <div>
                                <div class="csw-sub-label mb-1">Description</div>
                                <div class="small">{{ $project->project_description }}</div>
                            </div>
                        @endif
                    </div>

                    {{-- Project Intelligence --}}
                    <div class="csw-section-title mt-1">
                        <h2><i class="bi bi-graph-up-arrow"></i>Project Intelligence</h2>
                    </div>
                    <div class="row g-4 mb-1">
                        <div class="col-md-7">
                            <div class="csw-panel h-100">
                                <h3>Delivery Progress</h3>
                                @if ($totalModules > 0)
                                    <div id="csw-chart-modules"></div>
                                @else
                                    <div class="csw-empty"><i class="bi bi-bar-chart"></i>No modules yet to chart progress.</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="csw-panel h-100">
                                <h3>Submodule Status</h3>
                                @if ($totalSubModules > 0)
                                    <div id="csw-chart-substatus"></div>
                                @else
                                    <div class="csw-empty"><i class="bi bi-pie-chart"></i>No submodules yet.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($developerWorkload->count() > 0)
                        <div class="csw-panel">
                            <h3>Developer Workload (Estimated Hours)</h3>
                            <div id="csw-chart-workload"></div>
                        </div>
                    @endif

                    {{-- ================= MODULES ================= --}}
                    <div class="csw-section-title mt-1">
                        <h2><i class="bi bi-kanban"></i>Modules <span class="count">({{ $totalModules }})</span></h2>
                        @can('module-create')
                            <a href="{{ url('admin/projects/' . $project->id . '/modules/create') }}" class="csw-btn-primary">
                                <i class="bi bi-plus-lg"></i> Add Module
                            </a>
                        @endcan
                    </div>

                    @forelse($project->modules as $index => $module)
                        @php
                            $modulePriorityColor = $priorityColors[$module->priority] ?? 'secondary';
                            $moduleStatusColor = $statusColors[$module->status] ?? 'secondary';
                            $moduleStatusSlug = str_replace(' ', '', $module->status);

                            $rejectedAssignment = $module->assignments
                                ->where('status', 'rejected')
                                ->sortByDesc('id')
                                ->first();
                        @endphp
                        <div class="csw-module" style="--module-color: {{ $module->color ?? '#0F8EA3' }};">

                            <!-- @if(auth()->user()->hasRole('Admin') || $project->assigned_to == auth()->id())
                                @if($rejectedAssignment)
                                    <div class="csw-reject-alert">
                                        <i class="bi bi-x-circle-fill"></i>
                                        <span>Rejected by <strong>{{ $rejectedAssignment->assignedTo->name ?? 'Developer' }}</strong></span>
                                    </div>
                                @endif
                            @endif -->

                            <div class="csw-module-top">
                                <div class="csw-module-id">
                                    <div class="csw-module-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div>
                                        <h4 class="csw-module-name">
                                            {{ $module->module_name }}
                                            @if ($module->module_type)
                                                <span class="csw-module-type">{{ $module->module_type }}</span>
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                                <div class="csw-module-badges">
                                    <span class="csw-badge p-{{ $module->priority }}">{{ $module->priority }}</span>
                                    <span class="csw-badge s-{{ $moduleStatusSlug }}">{{ $module->status }}</span>
                                </div>
                            </div>

                            <div class="csw-module-meta">
                                <span><i class="bi bi-person"></i>{{ $module->developer->name ?? 'Unassigned' }}</span>
                                <span><i class="bi bi-building"></i>{{ $module->department->title ?? '—' }}</span>
                                <span><i class="bi bi-calendar-event"></i>{{ optional($module->start_date)->format('d M Y') ?? '—' }}</span>
                                <span><i class="bi bi-calendar-check"></i>{{ optional($module->deadline)->format('d M Y') ?? '—' }}</span>
                                <span><i class="bi bi-clock"></i>Est {{ number_format($module->estimated_hours, 1) }}h</span>
                                <span><i class="bi bi-clock-history"></i>Actual {{ number_format($module->actual_hours, 1) }}h</span>
                                <span><i class="bi bi-diagram-2"></i>{{ $module->subModules->count() }} Submodules</span>
                            </div>

                            @if (!empty($module->tags))
                                <div class="csw-module-tags">
                                    @foreach ($module->tags as $tag)
                                        <span class="csw-tag">#{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="csw-module-progress">
                                <div class="csw-module-progress-top">
                                    <span>Progress</span>
                                    <span class="fw-semibold" style="color:var(--cs-text);">{{ $module->progress }}%</span>
                                </div>
                                <div class="csw-progress-track">
                                    <div class="csw-progress-fill" data-target="{{ $module->progress }}" style="width:0;"></div>
                                </div>
                            </div>

                            <div class="csw-module-footer">
                                @if ($module->subModules->count() > 0)
                                    <button class="csw-expand-btn" type="button" data-bs-toggle="collapse" data-bs-target="#submodules-{{ $module->id }}">
                                        <!-- <span>{{ $module->subModules->where('status', 'Completed')->count() }} / {{ $module->subModules->count() }} completed w</span> -->
                                         <span>
                                            {{ $module->subModules->whereIn('status', ['Completed', 'Approved'])->count() }}
                                            / {{ $module->subModules->count() }} completed
                                        </span>
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                @else
                                    <span></span>
                                @endif

                                <a href="{{ url('modules/' . $module->id . '/submodules/create') }}" class="csw-add-sub-link">
                                    <i class="bi bi-plus-lg me-1"></i>Add Submodule
                                </a>
                            </div>

                            @if ($module->subModules->count() > 0)
                                <div class="collapse" id="submodules-{{ $module->id }}">
                                    <div class="csw-submodules">
                                        @foreach ($module->subModules as $subModule)
                                            @php
                                                $subPriorityColor = $priorityColors[$subModule->priority] ?? 'secondary';
                                            @endphp
                                            <div class="csw-sub-row">
                                                <div>
                                                    <span class="csw-sub-label">Submodule</span>
                                                    <span class="csw-sub-name">{{ $subModule->sub_module_name }}</span>
                                                </div>
                                                <div>
                                                    <span class="csw-sub-label">Developer</span>
                                                    {{ $subModule->assignedTo->name ?? 'Unassigned' }}
                                                </div>
                                                <div>
                                                    <span class="csw-sub-label">Priority</span>
                                                    <span class="csw-badge p-{{ $subModule->priority }}">{{ $subModule->priority }}</span>
                                                </div>
                                                <div>
                                                    <span class="csw-sub-label">Deadline</span>
                                                    {{ optional($subModule->deadline)->format('d M Y') ?? '—' }}
                                                </div>
                                                <div class="csw-sub-progress">
                                                    <span class="csw-sub-label">Progress {{ $subModule->progress }}%</span>
                                                    <div class="csw-progress-track">
                                                        <div class="csw-progress-fill" data-target="{{ $subModule->progress }}" style="width:0;"></div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="csw-sub-label">Status</span>
                                                    <form action="{{ route('admin.project-submodules.status', $subModule->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <!-- <select class="csw-sub-status-select submodule-status" data-id="{{ $subModule->id }}" readonly>
                                                            @foreach (['Pending', 'Planning', 'In Progress', 'Testing', 'Completed', 'On Hold', 'Cancelled', 'Approved'] as $status)
                                                                <option value="{{ $status }}" @selected($subModule->status == $status)>{{ $status }}</option>
                                                            @endforeach
                                                        </select> -->

                                                        <select class="csw-sub-status-select submodule-status"
                                                                data-id="{{ $subModule->id }}"
                                                                onclick="return false;"
                                                                onmousedown="return false;">
                                                            @foreach (['Pending', 'Planning', 'In Progress', 'Testing', 'Completed', 'On Hold', 'Cancelled', 'Approved'] as $status)
                                                                <option value="{{ $status }}" @selected($subModule->status == $status)>
                                                                    {{ $status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="csw-panel">
                            <div class="csw-empty"><i class="bi bi-inbox"></i>No modules have been added to this project yet.</div>
                        </div>
                    @endforelse

                    {{-- ================= TIMELINE (dates) ================= --}}
                    @if ($project->start_date || $project->deadline)
                        <div class="csw-panel">
                            <h3><i class="bi bi-signpost-split me-2 text-primary"></i>Project Timeline</h3>
                            <div class="csw-datetrack">
                                <div class="csw-datenode">
                                    <div class="dot"></div>
                                    <div class="lbl">Start</div>
                                    <div class="val">{{ optional($project->start_date)->format('d M') ?? '—' }}</div>
                                </div>
                                <div class="csw-dateline"></div>
                                <div class="csw-datenode {{ $project->status === 'Pending' ? 'muted' : '' }}">
                                    <div class="dot"></div>
                                    <div class="lbl">Development</div>
                                    <div class="val">&nbsp;</div>
                                </div>
                                <div class="csw-dateline"></div>
                                <div class="csw-datenode {{ !in_array($project->status, ['Testing','Completed']) ? 'muted' : '' }}">
                                    <div class="dot"></div>
                                    <div class="lbl">Review</div>
                                    <div class="val">&nbsp;</div>
                                </div>
                                <div class="csw-dateline"></div>
                                <div class="csw-datenode {{ $project->status !== 'Completed' ? 'muted' : '' }}">
                                    <div class="dot"></div>
                                    <div class="lbl">Approval</div>
                                    <div class="val">&nbsp;</div>
                                </div>
                                <div class="csw-dateline"></div>
                                <div class="csw-datenode">
                                    <div class="dot"></div>
                                    <div class="lbl">Deadline</div>
                                    <div class="val">{{ optional($project->deadline)->format('d M') ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ================= ACTIVITY ================= --}}
                    @php
                        $timelineEvents = collect();

                        $timelineEvents->push([
                            'icon' => 'bi-flag',
                            'title' => 'Project Created',
                            'meta' => $project->creator->name ?? 'System',
                            'date' => $project->created_at,
                        ]);

                        foreach ($project->modules as $module) {
                            $timelineEvents->push([
                                'icon' => 'bi-diagram-3',
                                'title' => 'Module Added: ' . $module->module_name,
                                'meta' => $module->developer->name ?? null,
                                'date' => $module->created_at,
                            ]);

                            if ($module->assigned_to) {
                                $timelineEvents->push([
                                    'icon' => 'bi-person-check',
                                    'title' => 'Developer Assigned to ' . $module->module_name,
                                    'meta' => $module->developer->name ?? null,
                                    'date' => $module->updated_at,
                                ]);
                            }
                        }

                        foreach ($project->attachments as $attachment) {
                            $timelineEvents->push([
                                'icon' => 'bi-paperclip',
                                'title' => 'File Uploaded: ' . $attachment->original_name,
                                'meta' => $attachment->uploadedBy->name ?? null,
                                'date' => $attachment->created_at,
                            ]);
                        }

                        $timelineEvents->push([
                            'icon' => 'bi-flag-fill',
                            'title' => 'Status Changed to ' . $project->status,
                            'meta' => null,
                            'date' => $project->updated_at,
                        ]);

                        $timelineEvents = $timelineEvents
                            ->filter(fn($e) => $e['date'])
                            ->sortByDesc('date')
                            ->take(8);
                    @endphp

                    <div class="csw-panel">
                        <div class="csw-section-title">
                            <h2><i class="bi bi-activity"></i>Activity</h2>
                        </div>
                        @if ($timelineEvents->count())
                            <div class="csw-activity">
                                @foreach ($timelineEvents as $event)
                                    <div class="csw-activity-item">
                                        <span class="csw-activity-dot"></span>
                                        <div class="csw-activity-title"><i class="bi {{ $event['icon'] }} me-1"></i>{{ $event['title'] }}</div>
                                        <div class="csw-activity-meta">
                                            @if ($event['meta'])
                                                {{ $event['meta'] }} &middot;
                                            @endif
                                            {{ $event['date']->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="csw-empty"><i class="bi bi-activity"></i>No activity recorded yet.</div>
                        @endif
                    </div>

                </div>

                {{-- ================= RIGHT INTELLIGENCE PANEL ================= --}}
                <div class="col-12 col-lg-4">

                    <div class="csw-panel">
                        <h3><i class="bi bi-heart-pulse me-2 text-primary"></i>Project Health</h3>
                        <div class="csw-health-row">
                            <span class="label">Progress</span>
                            <span class="csw-health-tag {{ $overallProgress >= 80 ? 'good' : ($overallProgress >= 40 ? 'warn' : 'bad') }}">{{ $overallProgress }}%</span>
                        </div>
                        <div class="csw-health-row">
                            <span class="label">Deadline</span>
                            <span class="csw-health-tag {{ is_null($remainingDays) ? 'neutral' : ($remainingDays < 0 ? 'bad' : ($remainingDays <= 3 ? 'warn' : 'good')) }}">
                                @if (is_null($remainingDays)) — @elseif($remainingDays < 0) Overdue @elseif($remainingDays <= 3) At Risk @else On Track @endif
                            </span>
                        </div>
                        <div class="csw-health-row">
                            <span class="label">Review</span>
                            <span class="csw-health-tag {{ $reviewWaitingCount > 0 ? 'warn' : 'good' }}">{{ $reviewWaitingCount > 0 ? 'Waiting' : 'Clear' }}</span>
                        </div>
                        <div class="csw-health-row">
                            <span class="label">Hours</span>
                            <span class="csw-health-tag {{ $totalEstimatedHours > 0 && $totalActualHours > $totalEstimatedHours ? 'warn' : 'good' }}">
                                {{ $totalEstimatedHours > 0 && $totalActualHours > $totalEstimatedHours ? 'Over Budget' : 'Healthy' }}
                            </span>
                        </div>
                        <div class="csw-health-row">
                            <span class="label">Overall</span>
                            <span class="csw-health-tag {{ $healthTagClass }}">{{ $health }}</span>
                        </div>
                    </div>

                    <div class="csw-panel">
                        <h3><i class="bi bi-calendar-event me-2 text-primary"></i>Deadline</h3>
                        @if ($project->deadline)
                            <div class="fw-bold" style="font-size:1.1rem;">{{ $project->deadline->format('d M Y') }}</div>
                            <div class="text-muted small mt-1">
                                @if ($remainingDays < 0)
                                    <span class="text-danger fw-semibold">{{ abs($remainingDays) }} days overdue</span>
                                @else
                                    {{ $remainingDays }} days remaining
                                @endif
                            </div>
                        @else
                            <div class="text-muted small">No deadline set.</div>
                        @endif
                    </div>

                    <div class="csw-panel">
                        <h3><i class="bi bi-people me-2 text-primary"></i>Team</h3>
                        <div class="csw-team-row">
                            <div class="csw-avatar">{{ strtoupper(substr($project->assignedTo->name ?? '-', 0, 1)) }}</div>
                            <div>
                                <div class="csw-team-name">{{ $project->assignedTo->name ?? 'Unassigned' }}</div>
                                <div class="csw-team-role">Lead Developer</div>
                            </div>
                        </div>
                        @foreach ($project->modules->pluck('developer')->filter()->unique('id') as $dev)
                            @if (!$project->assignedTo || $dev->id != $project->assignedTo->id)
                                <div class="csw-team-row">
                                    <div class="csw-avatar">{{ strtoupper(substr($dev->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="csw-team-name">{{ $dev->name }}</div>
                                        <div class="csw-team-role">Developer</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="csw-health-row mt-2">
                            <span class="label">Created By</span>
                            <span>{{ $project->creator->name ?? '—' }}</span>
                        </div>
                    </div>

                    <div class="csw-panel">
                        <div class="csw-section-title">
                            <h2><i class="bi bi-paperclip"></i>Files <span class="count">({{ $attachmentsCount }})</span></h2>
                        </div>
                        @forelse($project->attachments as $attachment)
                            <div class="csw-file-row">
                                <div class="d-flex align-items-center gap-2" style="min-width:0;">
                                    <div class="csw-file-icon">
                                        <i class="bi bi-file-earmark-{{ in_array(strtolower($attachment->extension), ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (strtolower($attachment->extension) === 'pdf' ? 'pdf' : 'text') }}"></i>
                                    </div>
                                    <div style="min-width:0;">
                                        <div class="csw-file-name text-truncate">{{ $attachment->original_name }}</div>
                                        <div class="csw-file-meta text-truncate">
                                            {{ number_format(($attachment->file_size ?? 0) / 1024, 1) }} KB &middot; {{ $attachment->uploadedBy->name ?? 'Unknown' }}
                                        </div>
                                    </div>
                                </div>
                                <!-- <a href="{{ Storage::disk($attachment->disk ?? 'public')->url($attachment->file_path) }}" class="csw-file-download" download>
                                    <i class="bi bi-download"></i>
                                </a> -->

                                 <a href="{{ asset($attachment->file_path) }}"
                                    class="csw-file-download"
                                    download>
                                        <i class="bi bi-download"></i>
                                </a>
                            </div>
                        @empty
                            <div class="csw-empty"><i class="bi bi-folder2-open"></i>No files have been uploaded yet.</div>
                        @endforelse
                    </div>

                    <div class="csw-panel">
                        <div class="csw-section-title">
                            <h2><i class="bi bi-clock-history"></i>Recent Activity</h2>
                        </div>
                        @php $recent = $timelineEvents->take(4); @endphp
                        @if($recent->count())
                            <div class="csw-activity">
                                @foreach($recent as $event)
                                    <div class="csw-activity-item">
                                        <span class="csw-activity-dot"></span>
                                        <div class="csw-activity-title" style="font-size:.78rem;"><i class="bi {{ $event['icon'] }} me-1"></i>{{ $event['title'] }}</div>
                                        <div class="csw-activity-meta">{{ $event['date']->diffForHumans() }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="csw-empty" style="padding:1rem;"><i class="bi bi-activity"></i>No recent activity.</div>
                        @endif
                    </div>

                    <div class="csw-panel mb-0">
                        <div class="csw-section-title">
                            <h2><i class="bi bi-lightning-charge"></i>Quick Actions</h2>
                        </div>
                        @can('module-create')
                            <a href="{{ url('admin/projects/' . $project->id . '/modules/create') }}" class="csw-qa-btn"><i class="bi bi-plus-lg"></i>Add Module</a>
                        @endcan
                        <a href="#modules-top" class="csw-qa-btn"><i class="bi bi-list-task"></i>Manage Modules</a>
                        <button type="button" class="csw-qa-btn"><i class="bi bi-upload"></i>Upload File</button>
                        <button type="button" class="csw-qa-btn"><i class="bi bi-file-earmark-arrow-down"></i>Export Report</button>
                    </div>

                </div>
            </div>

            {{-- ================= FOOTER SETTINGS ================= --}}
            <div class="csw-footer">
                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square me-1"></i>Edit Project</a>
                <button type="button" class="btn btn-outline-danger btn-sm"><i class="bi bi-archive me-1"></i>Archive Project</button>
                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-share me-1"></i>Manage Sharing</button>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.45.1/apexcharts.min.js"></script>
    <script>
        (function () {
            var CS_PRIMARY = '#0F8EA3';
            var CS_BRIGHT = '#16B6C8';
            var CS_MUTED = '#6B7280';
            var CS_BORDER = '#E6ECEF';

            // Animate progress bars
            document.querySelectorAll('.csw-progress-fill').forEach(function (bar) {
                var target = bar.getAttribute('data-target') || 0;
                requestAnimationFrame(function () {
                    setTimeout(function () { bar.style.width = target + '%'; }, 150);
                });
            });

            // Stagger the delivery strip
            document.querySelectorAll('.csw-strip-item').forEach(function (el, i) {
                el.style.animationDelay = (0.05 * i) + 's';
            });

            document.querySelectorAll('.csw-expand-btn').forEach(function (btn) {
                var targetSel = btn.getAttribute('data-bs-target');
                var target = document.querySelector(targetSel);
                if (!target) return;
                target.addEventListener('show.bs.collapse', function () { btn.classList.add('open'); });
                target.addEventListener('hide.bs.collapse', function () { btn.classList.remove('open'); });
            });

            // ================= Overall Progress Radial =================
            if (document.querySelector('#csw-chart-radial')) {
                new ApexCharts(document.querySelector('#csw-chart-radial'), {
                    chart: { type: 'radialBar', height: 190, sparkline: { enabled: true } },
                    series: [{{ (float) $overallProgress }}],
                    labels: ['Progress'],
                    colors: [CS_BRIGHT],
                    plotOptions: {
                        radialBar: {
                            hollow: { size: '62%' },
                            track: { background: 'rgba(255,255,255,.12)' },
                            dataLabels: {
                                name: { show: false },
                                value: {
                                    color: '#fff',
                                    fontSize: '26px',
                                    fontWeight: 700,
                                    formatter: function (val) { return Math.round(val) + '%'; }
                                }
                            }
                        }
                    },
                    stroke: { lineCap: 'round' }
                }).render();
            }

            // ================= Module Completion (horizontal bar) =================
            @if ($totalModules > 0)
            if (document.querySelector('#csw-chart-modules')) {
                new ApexCharts(document.querySelector('#csw-chart-modules'), {
                    chart: { type: 'bar', height: Math.max(180, {{ $totalModules }} * 42), toolbar: { show: false } },
                    series: [{ name: 'Progress', data: {!! $moduleProgress->toJson() !!} }],
                    xaxis: {
                        categories: {!! $moduleNames->toJson() !!},
                        max: 100,
                        labels: { style: { colors: CS_MUTED, fontSize: '11px' } }
                    },
                    yaxis: { labels: { style: { colors: '#17202A', fontSize: '12px', fontWeight: 600 } } },
                    plotOptions: {
                        bar: { horizontal: true, borderRadius: 5, barHeight: '55%', distributed: false }
                    },
                    colors: [CS_PRIMARY],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) { return val + '%'; },
                        style: { colors: ['#fff'], fontSize: '11px', fontWeight: 700 }
                    },
                    grid: { borderColor: CS_BORDER, xaxis: { lines: { show: true } }, yaxis: { lines: { show: false } } },
                    legend: { show: false }
                }).render();
            }
            @endif

            // ================= Submodule Status Donut =================
            @if ($totalSubModules > 0)
            if (document.querySelector('#csw-chart-substatus')) {
                new ApexCharts(document.querySelector('#csw-chart-substatus'), {
                    chart: { type: 'donut', height: 230 },
                    series: {!! $subStatusCounts->values()->toJson() !!},
                    labels: {!! $subStatusCounts->keys()->toJson() !!},
                    colors: ['#0F8EA3', '#16B6C8', '#B4700A', '#C4302B', '#1C8A5A', '#6B7280', '#9AA7AC'],
                    legend: { position: 'bottom', fontSize: '11px', labels: { colors: '#6B7280' } },
                    dataLabels: { enabled: false },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    total: { show: true, label: 'Submodules', color: '#6B7280', fontSize: '11px' }
                                }
                            }
                        }
                    },
                    stroke: { width: 0 }
                }).render();
            }
            @endif

            // ================= Developer Workload =================
            @if ($developerWorkload->count() > 0)
            if (document.querySelector('#csw-chart-workload')) {
                new ApexCharts(document.querySelector('#csw-chart-workload'), {
                    chart: { type: 'bar', height: Math.max(160, {{ $developerWorkload->count() }} * 46), toolbar: { show: false } },
                    series: [{ name: 'Estimated Hours', data: {!! $developerWorkload->values()->toJson() !!} }],
                    xaxis: {
                        categories: {!! $developerWorkload->keys()->toJson() !!},
                        labels: { style: { colors: CS_MUTED, fontSize: '11px' } }
                    },
                    plotOptions: { bar: { horizontal: true, borderRadius: 5, barHeight: '50%' } },
                    colors: [CS_BRIGHT],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) { return val + 'h'; },
                        style: { colors: ['#102A33'], fontSize: '11px', fontWeight: 700 }
                    },
                    grid: { borderColor: CS_BORDER },
                    legend: { show: false }
                }).render();
            }
            @endif

            // Submodule status update (unchanged behaviour)
            document.querySelectorAll('.submodule-status').forEach(function (select) {
                select.addEventListener('change', function () {
                    var id = this.dataset.id;
                    fetch('/admin/project-submodules/' + id + '/status', {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: this.value })
                    })
                        .then(function (res) { return res.json(); })
                        .then(function () { location.reload(); });
                });
            });
        })();
    </script>
@endpush