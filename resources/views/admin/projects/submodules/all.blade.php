@extends('index')

@push('title', 'All Sub Modules')

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

<style>
    /* ===================== CODE SPARROW / DEV WORKSPACE — DESIGN TOKENS ===================== */
    :root{
        --cs-primary:#0F8EA3;
        --cs-secondary:#16B6C8;
        --cs-ink:#172033;
        --cs-text:#273449;
        --cs-bg:#F6F8FB;
        --cs-card:#FFFFFF;
        --cs-border:#E5EAF0;
        --cs-muted:#6B7280;
        --cs-success:#16A879;
        --cs-warning:#F59E0B;
        --cs-danger:#EF476F;
        --cs-info:#2563EB;
        --cs-slate:#475467;
        --cs-radius:16px;
        --cs-radius-sm:10px;
        --cs-radius-xs:8px;
        --cs-shadow-xs:0 1px 2px rgba(23,32,51,.04);
        --cs-shadow-sm:0 1px 2px rgba(23,32,51,.04), 0 6px 16px -10px rgba(23,32,51,.10);
        --cs-shadow-md:0 10px 24px -12px rgba(15,142,163,.20), 0 2px 6px rgba(23,32,51,.05);
        --cs-shadow-lg:0 18px 40px -18px rgba(15,142,163,.24), 0 4px 10px rgba(23,32,51,.05);
    }

    #cs-workspace{
        font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
        color:var(--cs-ink);
        background:var(--cs-bg);
        border-radius:18px;
        font-size:.9rem;
    }
    #cs-workspace h1,#cs-workspace h2,#cs-workspace h3,#cs-workspace h4,
    #cs-workspace .cs-font-display{ font-family:'Manrope',sans-serif; letter-spacing:-0.01em; }

    /* ===================== HERO (compact, dark charcoal-teal) ===================== */
    .cs-hero{
        position:relative;
        overflow:hidden;
        border-radius:var(--cs-radius);
        padding:1.5rem 1.75rem;
        margin:0 0 1rem;
        background:
            radial-gradient(600px 200px at 100% -10%, rgba(22,182,200,.22) 0%, transparent 60%),
            linear-gradient(160deg, #101826 0%, #142230 55%, #0E2B31 100%);
        border:1px solid rgba(255,255,255,.06);
        color:#fff;
    }
    .cs-hero-top{ position:relative; display:flex; align-items:flex-start; justify-content:space-between; gap:1.25rem; flex-wrap:wrap; }
    .cs-hero-eyebrow{
        display:inline-flex; align-items:center; gap:.4rem;
        font-size:.65rem; font-weight:700; letter-spacing:.09em; text-transform:uppercase;
        color:rgba(255,255,255,.6);
        margin-bottom:.5rem;
    }
    .cs-hero-eyebrow i{ color:var(--cs-secondary); font-size:.62rem; }
    .cs-hero h1{ font-size:1.5rem; font-weight:800; margin:0 0 .3rem; color:#fff; }
    .cs-hero p{ font-size:.83rem; opacity:.68; margin:0; max-width:460px; line-height:1.5; }

    .cs-hero-actions{ position:relative; display:flex; align-items:center; gap:.55rem; flex-wrap:wrap; }
    .cs-last-updated{
        display:inline-flex; align-items:center; gap:.4rem;
        font-size:.72rem; font-weight:600; color:rgba(255,255,255,.7);
        background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.10);
        padding:.4rem .7rem; border-radius:var(--cs-radius-xs);
    }
    .cs-refresh-btn{
        background:rgba(255,255,255,.08) !important; color:#fff !important;
        border:1px solid rgba(255,255,255,.14) !important;
        font-size:.76rem !important; padding:.4rem .75rem !important;
    }
    .cs-refresh-btn:hover{ background:rgba(255,255,255,.16) !important; }
    .cs-refresh-btn i{ transition:transform .4s ease; font-size:.72rem; }
    .cs-refresh-btn:hover i{ transform:rotate(180deg); }

    /* ===================== KPI STRIP (unified, not colorful boxes) ===================== */
    .cs-kpi-strip{
        display:grid; grid-template-columns:repeat(5,1fr);
        background:var(--cs-card); border:1px solid var(--cs-border); border-radius:var(--cs-radius);
        box-shadow:var(--cs-shadow-xs);
        margin-bottom:1rem; overflow:hidden;
    }
    .cs-kpi-item{
        position:relative; padding:.95rem 1.1rem;
        border-right:1px solid var(--cs-border);
        transition:background .18s ease;
    }
    .cs-kpi-item:last-child{ border-right:none; }
    .cs-kpi-item:hover{ background:#FAFCFD; }
    .cs-kpi-top{ display:flex; align-items:center; gap:.45rem; margin-bottom:.4rem; }
    .cs-kpi-icon{
        width:22px; height:22px; border-radius:6px; display:flex; align-items:center; justify-content:center;
        font-size:.68rem; flex-shrink:0;
    }
    .cs-kpi-label{ font-size:.64rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--cs-muted); }
    .cs-kpi-num{ font-size:1.5rem; font-weight:800; line-height:1; font-family:'Manrope',sans-serif; color:var(--cs-ink); }
    @media (max-width:900px){ .cs-kpi-strip{ grid-template-columns:repeat(3,1fr); } .cs-kpi-item:nth-child(3){ border-right:none; } }
    @media (max-width:560px){ .cs-kpi-strip{ grid-template-columns:repeat(2,1fr); overflow-x:auto; } }

    /* ===================== PANEL (generic — used by empty state / pagination wrapper) ===================== */
    .cs-panel{
        background:var(--cs-card);
        border:1px solid var(--cs-border);
        border-radius:var(--cs-radius);
        box-shadow:var(--cs-shadow-xs);
        padding:1.1rem 1.2rem;
        margin-bottom:1rem;
    }
    .cs-panel-title{ font-size:.86rem; font-weight:800; margin:0; color:var(--cs-ink); letter-spacing:-.01em; }
    .cs-panel-sub{ font-size:.72rem; color:var(--cs-muted); margin:.1rem 0 0; }

    /* ===================== EXECUTIVE INTELLIGENCE ===================== */
    .cs-intel-section{ margin-bottom:.4rem; }
    .cs-intel-header{ display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:.5rem; margin-bottom:.75rem; }
    .cs-intel-eyebrow{ font-size:.68rem; font-weight:800; letter-spacing:.09em; text-transform:uppercase; color:var(--cs-primary); margin:0 0 .2rem; display:flex; align-items:center; gap:.35rem; }
    .cs-intel-eyebrow::before{ content:''; width:5px; height:5px; border-radius:50%; background:var(--cs-primary); display:inline-block; }
    .cs-intel-title{ font-size:1.05rem; font-weight:800; color:var(--cs-ink); margin:0; letter-spacing:-.01em; }
    .cs-intel-sub{ font-size:.76rem; color:var(--cs-muted); margin:.15rem 0 0; }

    .cs-intel-card{
        background:var(--cs-card);
        border:1px solid var(--cs-border);
        border-radius:var(--cs-radius-sm);
        box-shadow:var(--cs-shadow-xs);
        padding:1rem 1.1rem;
        transition:border-color .18s ease, box-shadow .18s ease;
    }
    .cs-intel-card:hover{ border-color:#D6E4E8; box-shadow:var(--cs-shadow-sm); }
    .cs-card-label{ font-size:.66rem; font-weight:800; letter-spacing:.06em; text-transform:uppercase; color:var(--cs-muted); margin-bottom:.15rem; }
    .cs-card-caption{ font-size:.68rem; color:var(--cs-muted); margin-bottom:.7rem; }

    /* ---- primary asymmetric row: Delivery Health (large) + Task Health Matrix (compact) ---- */
    .cs-intel-row-primary{
        display:grid; grid-template-columns:minmax(0,1.35fr) minmax(280px,.65fr);
        gap:.85rem; margin-bottom:.85rem;
    }
    @media (max-width:980px){ .cs-intel-row-primary{ grid-template-columns:1fr; } }

    /* ---- Delivery Health hero card ---- */
    .cs-health-card{ display:flex; flex-direction:column; }
    .cs-health-top{ display:flex; align-items:baseline; gap:.6rem; margin:.2rem 0 .75rem; }
    .cs-health-percent{ font-size:2.3rem; font-weight:800; font-family:'Manrope',sans-serif; color:var(--cs-ink); line-height:1; }
    .cs-health-percent span{ font-size:1.1rem; font-weight:700; color:var(--cs-muted); margin-left:.1rem; }
    .cs-health-caption{ font-size:.72rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase; color:var(--cs-muted); }

    .cs-health-track{ display:flex; height:10px; border-radius:999px; overflow:hidden; background:#EEF1F5; margin-bottom:.9rem; }
    .cs-health-seg{ height:100%; width:0; transition:width 1.1s cubic-bezier(.22,1,.36,1); }
    .cs-health-seg + .cs-health-seg{ border-left:2px solid #fff; }

    .cs-health-stats{ display:grid; grid-template-columns:repeat(4,1fr); gap:.6rem; margin-bottom:.85rem; }
    .cs-health-stat{ display:flex; flex-direction:column; gap:.15rem; }
    .cs-health-stat-top{ display:flex; align-items:center; gap:.35rem; }
    .cs-health-dot{ width:7px; height:7px; border-radius:50%; flex-shrink:0; }
    .cs-health-stat-label{ font-size:.66rem; font-weight:600; color:var(--cs-muted); }
    .cs-health-stat-num{ font-size:1.05rem; font-weight:800; font-family:'Manrope',sans-serif; color:var(--cs-ink); }

    .cs-health-rate{
        display:flex; align-items:center; gap:.4rem; font-size:.74rem; font-weight:600; color:var(--cs-success);
        background:#EFFBF6; border:1px solid #D3F0E4; border-radius:var(--cs-radius-xs);
        padding:.5rem .7rem; margin-top:auto;
    }

    /* ---- Task Health Matrix (segmented rows, replaces donut) ---- */
    .cs-matrix-row{ margin-bottom:.6rem; }
    .cs-matrix-row:last-child{ margin-bottom:0; }
    .cs-matrix-top{ display:flex; align-items:center; justify-content:space-between; font-size:.72rem; margin-bottom:.3rem; }
    .cs-matrix-name{ display:flex; align-items:center; gap:.35rem; font-weight:600; color:var(--cs-text); }
    .cs-matrix-num{ font-weight:800; color:var(--cs-ink); font-family:'Manrope',sans-serif; }
    .cs-matrix-track{ height:6px; border-radius:999px; background:#EEF1F5; overflow:hidden; }
    .cs-matrix-fill{ height:100%; border-radius:999px; width:0; transition:width 1s cubic-bezier(.22,1,.36,1); }

    /* ---- secondary analytics row ---- */
    .cs-intel-row-secondary{ display:grid; grid-template-columns:repeat(3,1fr); gap:.85rem; margin-bottom:.85rem; }
    @media (max-width:980px){ .cs-intel-row-secondary{ grid-template-columns:1fr 1fr; } }
    @media (max-width:640px){ .cs-intel-row-secondary{ grid-template-columns:1fr; } }

    /* ---- Delivery Risk (deadline chart) ---- */
    .cs-risk-foot{ display:flex; align-items:center; justify-content:space-between; margin-top:.35rem; font-size:.68rem; color:var(--cs-muted); }
    .cs-risk-foot b{ color:var(--cs-ink); font-weight:700; }

    /* ---- Priority Mix micro-bars ---- */
    .cs-micro-row{ display:flex; align-items:center; gap:.6rem; margin-bottom:.55rem; }
    .cs-micro-row:last-child{ margin-bottom:0; }
    .cs-micro-label{ font-size:.72rem; font-weight:600; color:var(--cs-text); width:52px; flex-shrink:0; }
    .cs-micro-track{ flex:1; height:6px; border-radius:999px; background:#EEF1F5; overflow:hidden; }
    .cs-micro-fill{ height:100%; border-radius:999px; width:0; transition:width 1s cubic-bezier(.22,1,.36,1); }
    .cs-micro-num{ font-size:.72rem; font-weight:800; color:var(--cs-ink); width:20px; text-align:right; flex-shrink:0; }

    /* ---- Developer Capacity ---- */
    .cs-dev-row{ display:flex; align-items:center; gap:.6rem; margin-bottom:.65rem; }
    .cs-dev-row:last-child{ margin-bottom:0; }
    .cs-dev-avatar{
        width:26px; height:26px; border-radius:8px; display:flex; align-items:center; justify-content:center;
        font-size:.64rem; font-weight:700; color:#fff; background:linear-gradient(135deg,var(--cs-primary),var(--cs-secondary));
        flex-shrink:0;
    }
    .cs-dev-body{ flex:1; min-width:0; }
    .cs-dev-top{ display:flex; align-items:center; justify-content:space-between; margin-bottom:.25rem; }
    .cs-dev-name{ font-size:.74rem; font-weight:700; color:var(--cs-ink); }
    .cs-dev-count{ font-size:.68rem; font-weight:700; color:var(--cs-muted); }
    .cs-dev-track{ height:6px; border-radius:999px; background:#EEF1F5; overflow:hidden; margin-bottom:.2rem; }
    .cs-dev-fill{ height:100%; border-radius:999px; background:linear-gradient(90deg,var(--cs-primary),var(--cs-secondary)); width:0; transition:width 1s cubic-bezier(.22,1,.36,1); }
    .cs-dev-tag{ font-size:.62rem; font-weight:600; color:var(--cs-muted); }

    /* ---- Review Pipeline (full-width flow) ---- */
    .cs-pipeline-card{ margin-bottom:.85rem; }
    .cs-pipeline{ display:flex; align-items:center; gap:0; margin-top:.3rem; }
    .cs-pipeline-node{
        text-align:center; flex:1; min-width:0; padding:.6rem .4rem; border-radius:var(--cs-radius-xs);
        transition:background .2s ease;
    }
    .cs-pipeline-node.is-active{ background:#FFFBEB; box-shadow:0 0 0 1px #FDE9BE inset; animation:cs-pulse 2.2s ease-in-out infinite; }
    @keyframes cs-pulse{ 0%,100%{ box-shadow:0 0 0 1px #FDE9BE inset; } 50%{ box-shadow:0 0 0 1px #FDE9BE inset, 0 0 0 5px rgba(245,158,11,.10); } }
    .cs-pipeline-num{ font-size:1.3rem; font-weight:800; font-family:'Manrope',sans-serif; line-height:1; }
    .cs-pipeline-label{ font-size:.64rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:var(--cs-muted); margin-top:.25rem; }
    .cs-pipeline-arrow{ color:var(--cs-border); font-size:.75rem; flex-shrink:0; padding:0 .2rem; }
    @media (max-width:640px){ .cs-pipeline{ flex-wrap:wrap; } .cs-pipeline-arrow{ display:none; } .cs-pipeline-node{ flex:1 1 40%; } }

    /* ---- Workflow Signals strip ---- */
    .cs-signals-strip{
        display:grid; grid-template-columns:repeat(4,1fr); gap:0;
        background:var(--cs-card); border:1px solid var(--cs-border); border-radius:var(--cs-radius-sm);
        box-shadow:var(--cs-shadow-xs); overflow:hidden;
    }
    .cs-signal{ display:flex; align-items:center; gap:.5rem; padding:.75rem .9rem; border-right:1px solid var(--cs-border); }
    .cs-signal:last-child{ border-right:none; }
    .cs-signal-dot{ width:8px; height:8px; border-radius:50%; flex-shrink:0; }
    .cs-signal-label{ font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:var(--cs-muted); }
    .cs-signal-value{ font-size:.78rem; font-weight:700; color:var(--cs-ink); }
    @media (max-width:900px){ .cs-signals-strip{ grid-template-columns:1fr 1fr; } .cs-signal:nth-child(2){ border-right:none; } .cs-signal:nth-child(3),.cs-signal:nth-child(4){ border-top:1px solid var(--cs-border); } }
    @media (max-width:480px){ .cs-signals-strip{ grid-template-columns:1fr; } .cs-signal{ border-right:none !important; border-top:1px solid var(--cs-border); } .cs-signal:first-child{ border-top:none; } }

    /* ---- section divider before Task Explorer ---- */
    .cs-section-divider{ border-top:1px solid var(--cs-border); padding-top:1rem; margin:1.35rem 0 1rem; }
    .cs-section-divider-title{ font-size:.78rem; font-weight:800; letter-spacing:.05em; text-transform:uppercase; color:var(--cs-primary); margin:0; }
    .cs-section-divider-sub{ font-size:.72rem; color:var(--cs-muted); margin:.15rem 0 0; }

    /* ===================== FILTER / TASK EXPLORER ===================== */
    .cs-filter-bar{
        position:sticky; top:.75rem; z-index:20;
        background:rgba(255,255,255,.92);
        backdrop-filter:blur(12px) saturate(160%);
        border:1px solid var(--cs-border);
        border-radius:var(--cs-radius);
        box-shadow:var(--cs-shadow-xs);
        padding:1rem 1.1rem;
        margin-bottom:1rem;
    }
    .cs-explorer-title{ display:flex; align-items:center; gap:.4rem; font-size:.68rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:var(--cs-primary); margin-bottom:.75rem; }
    .cs-field label{ font-size:.66rem; font-weight:700; color:var(--cs-muted); text-transform:uppercase; letter-spacing:.03em; margin-bottom:.28rem; display:flex; align-items:center; gap:.3rem; }
    .cs-field label i{ font-size:.65rem; opacity:.6; }
    .cs-field .form-control, .cs-field .form-select{
        border-radius:var(--cs-radius-xs); border:1px solid var(--cs-border); font-size:.82rem;
        padding:.5rem .7rem; background:#fff; color:var(--cs-ink);
    }
    .cs-field .form-control:focus, .cs-field .form-select:focus{
        border-color:var(--cs-primary); box-shadow:0 0 0 3px rgba(15,142,163,.12); outline:none;
    }
    .cs-btn{
        border-radius:var(--cs-radius-xs); font-weight:600; font-size:.8rem; padding:.5rem .95rem;
        display:inline-flex; align-items:center; gap:.4rem; border:1px solid transparent; transition:all .18s ease;
    }
    .cs-btn-primary{ background:var(--cs-primary); color:#fff; }
    .cs-btn-primary:hover{ background:#0C7889; color:#fff; }
    .cs-btn-ghost{ background:#fff; border-color:var(--cs-border); color:var(--cs-slate); }
    .cs-btn-ghost:hover{ background:var(--cs-bg); color:var(--cs-ink); }

    .cs-filter-summary{
        display:flex; align-items:center; flex-wrap:wrap; gap:.45rem;
        margin-top:.85rem; padding-top:.75rem; border-top:1px dashed var(--cs-border);
    }
    .cs-filter-count{
        font-size:.7rem; font-weight:700; color:var(--cs-primary);
        background:#EFFAFB; border:1px solid #D3EFF3; padding:.26rem .6rem; border-radius:7px;
    }
    .cs-filter-chip{
        display:inline-flex; align-items:center; gap:.3rem;
        font-size:.7rem; font-weight:600; color:var(--cs-slate);
        background:var(--cs-bg); border:1px solid var(--cs-border);
        padding:.26rem .5rem .26rem .65rem; border-radius:999px;
    }
    .cs-filter-chip b{ color:var(--cs-ink); font-weight:700; }
    .cs-filter-chip-clear{
        font-size:.7rem; font-weight:700; color:var(--cs-danger);
        display:inline-flex; align-items:center; gap:.3rem; text-decoration:none;
        margin-left:.15rem;
    }
    .cs-filter-chip-clear:hover{ text-decoration:underline; }

    /* ===================== TASK CARDS (premium row workspace) ===================== */
    .cs-task-card{
        position:relative;
        background:#fff;
        border:1px solid var(--cs-border);
        border-radius:var(--cs-radius-sm);
        padding:.85rem 1.1rem .85rem 1.25rem;
        margin-bottom:.6rem;
        overflow:hidden;
        transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .cs-task-card::before{
        content:''; position:absolute; left:0; top:0; bottom:0; width:3px;
        background:var(--bar-color, var(--cs-border));
        transition:opacity .18s ease;
        opacity:.75;
    }
    .cs-task-card:hover{
        transform:translateY(-2px);
        box-shadow:var(--cs-shadow-md);
        border-color:#D7E2E8;
    }
    .cs-task-card:hover::before{ opacity:1; }
    .cs-task-icon{
        width:36px; height:36px; border-radius:9px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center; font-size:.85rem;
        background:#EFFAFB;
        color:var(--cs-primary);
        transition:transform .2s ease;
    }
    .cs-task-card:hover .cs-task-icon{ transform:scale(1.06); }
    .cs-task-title{ font-weight:700; font-size:.87rem; color:var(--cs-ink); margin-bottom:.12rem; }
    .cs-task-path{ font-size:.72rem; color:var(--cs-muted); display:flex; align-items:center; gap:.32rem; flex-wrap:wrap; }
    .cs-task-path .dot{ width:3px; height:3px; border-radius:50%; background:#C7CCD4; display:inline-block; }

    .cs-col-label{ font-size:.6rem; font-weight:700; letter-spacing:.05em; text-transform:uppercase; color:var(--cs-muted); margin-bottom:.22rem; display:block; }

    .cs-pill{
        display:inline-flex; align-items:center; gap:.32rem;
        font-size:.68rem; font-weight:700; padding:.24rem .58rem; border-radius:999px; white-space:nowrap;
        border:1px solid transparent;
    }
    .cs-avatar{
        width:26px; height:26px; border-radius:8px; display:flex; align-items:center; justify-content:center;
        font-size:.66rem; font-weight:700; color:#fff; background:linear-gradient(135deg,var(--cs-primary),var(--cs-secondary));
        flex-shrink:0;
    }
    .cs-progress-track{ height:6px; border-radius:999px; background:#EEF1F5; overflow:hidden; width:100%; }
    .cs-progress-fill{
        height:100%; border-radius:999px;
        width:0%;
        transition:width 1s cubic-bezier(.22,1,.36,1);
    }
    .cs-meta-chip{
        font-size:.68rem; color:var(--cs-slate); display:inline-flex; align-items:center; gap:.28rem;
        background:var(--cs-bg); border:1px solid var(--cs-border); padding:.24rem .5rem; border-radius:var(--cs-radius-xs);
    }
    .cs-action-btn{
        width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center;
        border:1px solid var(--cs-border); background:#fff; color:var(--cs-slate); font-size:.72rem;
        transition:all .16s ease;
    }
    .cs-action-btn:hover{ background:var(--cs-primary); border-color:var(--cs-primary); color:#fff; transform:translateX(2px); }

    .cs-status-select.form-select{
        border-radius:var(--cs-radius-xs); font-size:.74rem; padding:.36rem .55rem; border-color:var(--cs-border); min-width:150px;
    }

    /* Status bar colors */
    .bar-pending{--bar-color:#94A3B8;}
    .bar-planning{--bar-color:#94A3B8;}
    .bar-inprogress{--bar-color:var(--cs-info);}
    .bar-testing{--bar-color:var(--cs-info);}
    .bar-ready{--bar-color:var(--cs-warning);}
    .bar-changes{--bar-color:var(--cs-danger);}
    .bar-approved{--bar-color:var(--cs-success);}
    .bar-onhold{--bar-color:#7C3AED;}
    .bar-cancelled{--bar-color:#111827;}

    /* ===================== EMPTY STATE ===================== */
    .cs-empty{ text-align:center; padding:3rem 1rem; }
    .cs-empty svg{ width:96px; height:96px; margin-bottom:.9rem; }
    .cs-empty h4{ font-weight:800; margin-bottom:.3rem; font-size:1.05rem; }
    .cs-empty p{ color:var(--cs-muted); font-size:.85rem; }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width:768px){
        .cs-hero{ padding:1.25rem 1.1rem; }
        .cs-hero h1{ font-size:1.3rem; }
        .cs-hero-top{ flex-direction:column; }
        .cs-filter-bar{ position:static; }
        .cs-task-card .cs-actions-row{ justify-content:flex-start !important; }
    }
</style>
@endpush

@section('content')
<div id="cs-workspace" class="container-fluid">

    {{-- ======================= HERO ======================= --}}
    <div class="cs-hero" data-aos="">
        <div class="cs-hero-top">
            <div>
                <span class="cs-hero-eyebrow"><i class="fa-solid fa-circle"></i> DEVELOPER WORKSPACE</span>
                <h1>All Tasks</h1>
                <p>Monitor development progress, reviews and delivery health across every project.</p>
            </div>

            <div class="cs-hero-actions">
                <span class="cs-last-updated"><i class="fa-regular fa-clock"></i> Updated <span id="cs-last-updated-time">just now</span></span>
                <button type="button" class="cs-btn cs-btn-ghost cs-refresh-btn" onclick="location.reload()">
                    <i class="fa-solid fa-rotate-right"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    {{-- ======================= KPI STRIP ======================= --}}
    <div class="cs-kpi-strip" data-aos="fade-up" data-aos-delay="30">
        <div class="cs-kpi-item">
            <div class="cs-kpi-top">
                <span class="cs-kpi-icon" style="background:#EFFAFB;color:var(--cs-primary);"><i class="fa-solid fa-layer-group"></i></span>
                <span class="cs-kpi-label">Total Tasks</span>
            </div>
            <span class="cs-kpi-num" data-count="{{ $totalCount }}">0</span>
        </div>
        <div class="cs-kpi-item">
            <div class="cs-kpi-top">
                <span class="cs-kpi-icon" style="background:#EFF6FF;color:var(--cs-info);"><i class="fa-solid fa-arrows-rotate"></i></span>
                <span class="cs-kpi-label">In Progress</span>
            </div>
            <span class="cs-kpi-num" data-count="{{ $inProgressCount }}">0</span>
        </div>
        <div class="cs-kpi-item">
            <div class="cs-kpi-top">
                <span class="cs-kpi-icon" style="background:#FFFBEB;color:var(--cs-warning);"><i class="fa-solid fa-hourglass-half"></i></span>
                <span class="cs-kpi-label">Waiting Review</span>
            </div>
            <span class="cs-kpi-num" data-count="{{ $waitingReviewCount }}">0</span>
        </div>
        <div class="cs-kpi-item">
            <div class="cs-kpi-top">
                <span class="cs-kpi-icon" style="background:#FFF1F2;color:var(--cs-danger);"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <span class="cs-kpi-label">Changes Requested</span>
            </div>
            <span class="cs-kpi-num" data-count="{{ $changesRequestedCount }}">0</span>
        </div>
        <div class="cs-kpi-item">
            <div class="cs-kpi-top">
                <span class="cs-kpi-icon" style="background:#ECFDF5;color:var(--cs-success);"><i class="fa-solid fa-circle-check"></i></span>
                <span class="cs-kpi-label">Approved</span>
            </div>
            <span class="cs-kpi-num" data-count="{{ $approvedCount }}">0</span>
        </div>
    </div>

    {{-- ======================= EXECUTIVE INTELLIGENCE (computed from current page collection only — pagination scope unchanged) ======================= --}}
    @php
        $__statusCounts = $submodules->getCollection()->groupBy('status')->map->count();
        $__priorityCounts = $submodules->getCollection()->groupBy('priority')->map->count();
        $__devWorkload = $submodules->getCollection()->groupBy(fn($s) => $s->assignedTo->name ?? 'Not Assigned')->map->count()->sortDesc()->take(7);
        $__avgProgress = $submodules->getCollection()->count() ? round($submodules->getCollection()->avg('progress')) : 0;

        $__deadlineBuckets = collect(range(0, 29))->map(function($i) use ($submodules){
            $date = \Carbon\Carbon::today()->addDays($i);
            $count = $submodules->getCollection()->filter(function($s) use ($date){
                return $s->deadline && \Carbon\Carbon::parse($s->deadline)->isSameDay($date);
            })->count();
            return ['date' => $date->format('d M'), 'count' => $count];
        });
        $__hasDeadlineData = $__deadlineBuckets->sum('count') > 0;
        $__dueNext7 = $__deadlineBuckets->take(7)->sum('count');
        $__dueToday = $__deadlineBuckets->first()['count'] ?? 0;

        $__pageTotal = $submodules->getCollection()->count();
        $__approvedPage = $__statusCounts['Approved'] ?? 0;
        $__reviewPage = $__statusCounts['Ready For Review'] ?? 0;
        $__changesPage = $__statusCounts['Changes Requested'] ?? 0;
        $__pendingPage = ($__statusCounts['Pending'] ?? 0) + ($__statusCounts['Planning'] ?? 0);
        $__otherPage = max($__pageTotal - $__approvedPage - $__reviewPage - $__changesPage - $__pendingPage, 0);
        $__approvalRate = $__pageTotal ? round(($__approvedPage / $__pageTotal) * 100) : 0;
        $__overdueCount = $submodules->getCollection()->filter(fn($s) => $s->deadline && \Carbon\Carbon::parse($s->deadline)->isPast() && !\Carbon\Carbon::parse($s->deadline)->isToday())->count();
        $__dominantPriority = $__priorityCounts->sortDesc()->keys()->first();
        $__priorityTotal = max($__priorityCounts->sum(), 1);
        $__workloadMax = max($__devWorkload->max() ?? 0, 1);

        $__statusColorMap = [
            'Approved' => '#16A879', 'Ready For Review' => '#F59E0B', 'Changes Requested' => '#EF476F',
            'In Progress' => '#2563EB', 'Testing' => '#2563EB', 'On Hold' => '#7C3AED', 'Cancelled' => '#111827',
            'Pending' => '#94A3B8', 'Planning' => '#94A3B8',
        ];
    @endphp
    <div class="cs-intel-section" data-aos="fade-up" data-aos-delay="60">

        <div class="cs-intel-header">
            <div>
                <p class="cs-intel-eyebrow">Executive Intelligence</p>
                <p class="cs-intel-title mb-0">Development health</p>
                <p class="cs-intel-sub">{{ $__pageTotal }} task{{ $__pageTotal === 1 ? '' : 's' }} · {{ $__avgProgress }}% completion · {{ $waitingReviewCount }} awaiting review</p>
            </div>
        </div>

        {{-- Row 1 — Delivery Health (hero) + Task Health Matrix (compact) --}}
        <div class="cs-intel-row-primary">

            {{-- Delivery Health --}}
            <div class="cs-intel-card cs-health-card">
                <div class="cs-health-top">
                    <div class="cs-health-percent js-health-num" data-value="{{ $__avgProgress }}">0<span>%</span></div>
                    <div class="cs-health-caption">Delivery Health</div>
                </div>

                <div class="cs-health-track">
                    <div class="cs-health-seg js-health-seg" data-width="{{ $__pageTotal ? round($__approvedPage / $__pageTotal * 100) : 0 }}" style="background:var(--cs-success);"></div>
                    <div class="cs-health-seg js-health-seg" data-width="{{ $__pageTotal ? round($__reviewPage / $__pageTotal * 100) : 0 }}" style="background:var(--cs-warning);"></div>
                    <div class="cs-health-seg js-health-seg" data-width="{{ $__pageTotal ? round($__changesPage / $__pageTotal * 100) : 0 }}" style="background:var(--cs-danger);"></div>
                    <div class="cs-health-seg js-health-seg" data-width="{{ $__pageTotal ? round(($__pendingPage + $__otherPage) / $__pageTotal * 100) : 0 }}" style="background:#94A3B8;"></div>
                </div>

                <div class="cs-health-stats">
                    <div class="cs-health-stat">
                        <div class="cs-health-stat-top"><span class="cs-health-dot" style="background:var(--cs-success);"></span><span class="cs-health-stat-label">Approved</span></div>
                        <span class="cs-health-stat-num">{{ $__approvedPage }}</span>
                    </div>
                    <div class="cs-health-stat">
                        <div class="cs-health-stat-top"><span class="cs-health-dot" style="background:var(--cs-warning);"></span><span class="cs-health-stat-label">Review</span></div>
                        <span class="cs-health-stat-num">{{ $__reviewPage }}</span>
                    </div>
                    <div class="cs-health-stat">
                        <div class="cs-health-stat-top"><span class="cs-health-dot" style="background:var(--cs-danger);"></span><span class="cs-health-stat-label">Changes</span></div>
                        <span class="cs-health-stat-num">{{ $__changesPage }}</span>
                    </div>
                    <div class="cs-health-stat">
                        <div class="cs-health-stat-top"><span class="cs-health-dot" style="background:#94A3B8;"></span><span class="cs-health-stat-label">Pending</span></div>
                        <span class="cs-health-stat-num">{{ $__pendingPage + $__otherPage }}</span>
                    </div>
                </div>

                <div class="cs-health-rate">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    {{ $__approvalRate }}% approval rate across tracked tasks
                </div>
            </div>

            {{-- Task Health Matrix --}}
            <div class="cs-intel-card">
                <div class="cs-card-label">Task Health Matrix</div>
                <div class="cs-card-caption">Status distribution</div>
                @forelse ($__statusCounts->sortDesc() as $__statusName => $__statusCount)
                    @php $__statusPct = $__pageTotal ? round($__statusCount / $__pageTotal * 100) : 0; @endphp
                    <div class="cs-matrix-row">
                        <div class="cs-matrix-top">
                            <span class="cs-matrix-name">
                                <span class="cs-health-dot" style="background:{{ $__statusColorMap[$__statusName] ?? '#94A3B8' }};"></span>
                                {{ $__statusName }}
                            </span>
                            <span class="cs-matrix-num">{{ $__statusCount }}</span>
                        </div>
                        <div class="cs-matrix-track">
                            <div class="cs-matrix-fill js-matrix-fill" data-width="{{ $__statusPct }}" style="background:{{ $__statusColorMap[$__statusName] ?? '#94A3B8' }};"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No activity data available.</p>
                @endforelse
            </div>
        </div>

        {{-- Row 2 — Delivery Risk / Priority Mix / Developer Capacity --}}
        <div class="cs-intel-row-secondary">

            {{-- Delivery Risk --}}
            <div class="cs-intel-card">
                <div class="cs-card-label">Delivery Risk</div>
                <div class="cs-card-caption">Upcoming deadlines &amp; delivery pressure</div>
                <div id="cs-chart-risk"></div>
                <div class="cs-risk-foot">
                    <span>Due today: <b>{{ $__dueToday }}</b></span>
                    <span>Next 7 days: <b>{{ $__dueNext7 }}</b></span>
                </div>
            </div>

            {{-- Priority Mix --}}
            <div class="cs-intel-card">
                <div class="cs-card-label">Priority Mix</div>
                <div class="cs-card-caption">Critical → Low</div>
                @foreach (['Critical' => '#EF476F', 'High' => '#F59E0B', 'Medium' => '#2563EB', 'Low' => '#94A3B8'] as $__pName => $__pColor)
                    @php $__pCount = $__priorityCounts[$__pName] ?? 0; $__pPct = round($__pCount / $__priorityTotal * 100); @endphp
                    <div class="cs-micro-row">
                        <span class="cs-micro-label">{{ $__pName }}</span>
                        <div class="cs-micro-track">
                            <div class="cs-micro-fill js-micro-fill" data-width="{{ $__pPct }}" style="background:{{ $__pColor }};"></div>
                        </div>
                        <span class="cs-micro-num">{{ $__pCount }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Developer Capacity --}}
            <div class="cs-intel-card">
                <div class="cs-card-label">Developer Capacity</div>
                <div class="cs-card-caption">Tasks per developer</div>
                @forelse ($__devWorkload as $__devName => $__devCount)
                    @php
                        $__devPct = round($__devCount / $__workloadMax * 100);
                        $__devTag = $__devPct >= 70 ? 'High utilization' : ($__devPct >= 35 ? 'Balanced' : 'Light load');
                        $__devInitials = $__devName === 'Not Assigned' ? '—' : strtoupper(substr($__devName, 0, 2));
                    @endphp
                    <div class="cs-dev-row">
                        <span class="cs-dev-avatar">{{ $__devInitials }}</span>
                        <div class="cs-dev-body">
                            <div class="cs-dev-top">
                                <span class="cs-dev-name">{{ $__devName }}</span>
                                <span class="cs-dev-count">{{ $__devCount }} task{{ $__devCount === 1 ? '' : 's' }}</span>
                            </div>
                            <div class="cs-dev-track">
                                <div class="cs-dev-fill js-dev-fill" data-width="{{ $__devPct }}"></div>
                            </div>
                            <span class="cs-dev-tag">{{ $__devName === 'Not Assigned' ? 'Unassigned' : $__devTag }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No workload data available.</p>
                @endforelse
            </div>
        </div>

        {{-- Row 3 — Review Pipeline (full width flow) --}}
        <div class="cs-intel-card cs-pipeline-card">
            <div class="cs-card-label">Review Pipeline</div>
            <div class="cs-card-caption">Where tasks stand right now</div>
            <div class="cs-pipeline">
                <div class="cs-pipeline-node">
                    <div class="cs-pipeline-num" style="color:var(--cs-ink);">{{ $totalCount }}</div>
                    <div class="cs-pipeline-label">Total</div>
                </div>
                <i class="fa-solid fa-chevron-right cs-pipeline-arrow"></i>
                <div class="cs-pipeline-node {{ $waitingReviewCount > 0 ? 'is-active' : '' }}">
                    <div class="cs-pipeline-num" style="color:var(--cs-warning);">{{ $waitingReviewCount }}</div>
                    <div class="cs-pipeline-label">In Review</div>
                </div>
                <i class="fa-solid fa-chevron-right cs-pipeline-arrow"></i>
                <div class="cs-pipeline-node">
                    <div class="cs-pipeline-num" style="color:var(--cs-danger);">{{ $changesRequestedCount }}</div>
                    <div class="cs-pipeline-label">Changes</div>
                </div>
                <i class="fa-solid fa-chevron-right cs-pipeline-arrow"></i>
                <div class="cs-pipeline-node">
                    <div class="cs-pipeline-num" style="color:var(--cs-success);">{{ $approvedCount }}</div>
                    <div class="cs-pipeline-label">Approved</div>
                </div>
            </div>
        </div>

        {{-- Row 4 — Workflow Signals strip --}}
        <div class="cs-signals-strip">
            <div class="cs-signal">
                <span class="cs-signal-dot" style="background:{{ ($__overdueCount > 0 || $__changesPage > 0) ? 'var(--cs-warning)' : 'var(--cs-success)' }};"></span>
                <div>
                    <div class="cs-signal-label">Delivery</div>
                    <div class="cs-signal-value">{{ ($__overdueCount > 0 || $__changesPage > 0) ? 'At Risk' : 'Healthy' }}</div>
                </div>
            </div>
            <div class="cs-signal">
                <span class="cs-signal-dot" style="background:{{ $waitingReviewCount > 0 ? 'var(--cs-warning)' : 'var(--cs-success)' }};"></span>
                <div>
                    <div class="cs-signal-label">Review Queue</div>
                    <div class="cs-signal-value">{{ $waitingReviewCount }} task{{ $waitingReviewCount === 1 ? '' : 's' }} waiting</div>
                </div>
            </div>
            <div class="cs-signal">
                <span class="cs-signal-dot" style="background:{{ $__overdueCount > 0 ? 'var(--cs-danger)' : ($__dueToday > 0 ? 'var(--cs-warning)' : 'var(--cs-success)') }};"></span>
                <div>
                    <div class="cs-signal-label">Deadlines</div>
                    <div class="cs-signal-value">{{ $__overdueCount > 0 ? $__overdueCount . ' overdue' : $__dueToday . ' due today' }}</div>
                </div>
            </div>
            <div class="cs-signal">
                <span class="cs-signal-dot" style="background:var(--cs-primary);"></span>
                <div>
                    <div class="cs-signal-label">Priority</div>
                    <div class="cs-signal-value">{{ $__dominantPriority ?? '—' }}-heavy</div>
                </div>
            </div>
        </div>
    </div>

    <div class="cs-section-divider">
        <p class="cs-section-divider-title mb-0">Task Explorer</p>
        <p class="cs-section-divider-sub">Manage and review development tasks</p>
    </div>

    {{-- ======================= FILTER BAR / TASK EXPLORER (fields/route unchanged) ======================= --}}
    @php
        $__activeFilters = [];
        if (request('search')) { $__activeFilters[] = ['label' => 'Search', 'value' => request('search')]; }
        if (request('status')) { $__activeFilters[] = ['label' => 'Status', 'value' => request('status')]; }
        if (request('priority')) { $__activeFilters[] = ['label' => 'Priority', 'value' => request('priority')]; }
        if (request('project_id')) {
            $__selectedProject = $projectOptions->firstWhere('id', request('project_id'));
            $__activeFilters[] = ['label' => 'Project', 'value' => $__selectedProject->project_name ?? request('project_id')];
        }
        if (request('module_id')) {
            $__selectedModule = $moduleOptions->firstWhere('id', request('module_id'));
            $__activeFilters[] = ['label' => 'Module', 'value' => $__selectedModule->module_name ?? request('module_id')];
        }
    @endphp
    <div class="cs-filter-bar" data-aos="fade-up" data-aos-delay="90">
        <div class="cs-explorer-title"><i class="fa-solid fa-sliders"></i> Task Explorer</div>
        <form action="{{ route('admin.submodules.all') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4 col-lg-3 cs-field">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Sub module, module or project..." value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-4 col-lg-2 cs-field">
                    <label><i class="fa-solid fa-circle-dot"></i> Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach (['Pending', 'Planning', 'In Progress', 'Testing', 'Ready For Review', 'Changes Requested', 'Approved', 'On Hold', 'Cancelled'] as $statusOption)
                            <option value="{{ $statusOption }}" @selected(request('status') === $statusOption)>{{ $statusOption }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-4 col-lg-2 cs-field">
                    <label><i class="fa-solid fa-flag"></i> Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All Priority</option>
                        @foreach (['Low', 'Medium', 'High', 'Critical'] as $priorityOption)
                            <option value="{{ $priorityOption }}" @selected(request('priority') === $priorityOption)>{{ $priorityOption }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-6 col-lg-2 cs-field">
                    <label><i class="fa-regular fa-folder"></i> Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">All Projects</option>
                        @foreach ($projectOptions as $projectOption)
                            <option value="{{ $projectOption->id }}" @selected((string) request('project_id') === (string) $projectOption->id)>{{ $projectOption->project_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-6 col-lg-2 cs-field">
                    <label><i class="fa-solid fa-sitemap"></i> Module</label>
                    <select name="module_id" class="form-select">
                        <option value="">All Modules</option>
                        @foreach ($moduleOptions as $moduleOption)
                            <option value="{{ $moduleOption->id }}" @selected((string) request('module_id') === (string) $moduleOption->id)>{{ $moduleOption->module_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-lg-2 cs-field">
                    <label><i class="fa-solid fa-arrow-down-wide-short"></i> Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="latest" @selected(request('sort_by', 'latest') === 'latest')>Newest First</option>
                        <option value="deadline" @selected(request('sort_by') === 'deadline')>Deadline (Earliest)</option>
                        <option value="priority" @selected(request('sort_by') === 'priority')>Priority (Critical First)</option>
                        <option value="progress" @selected(request('sort_by') === 'progress')>Progress (Highest)</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 flex-wrap mt-1">
                    <a href="{{ route('admin.submodules.all') }}" class="cs-btn cs-btn-ghost">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                    <button type="submit" class="cs-btn cs-btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i> Apply Filters
                    </button>
                </div>
            </div>
        </form>

        @if(count($__activeFilters))
            <div class="cs-filter-summary">
                <span class="cs-filter-count">Filters ({{ count($__activeFilters) }})</span>
                @foreach ($__activeFilters as $filter)
                    <span class="cs-filter-chip"><b>{{ $filter['label'] }}:</b> {{ \Illuminate\Support\Str::limit($filter['value'], 24) }}</span>
                @endforeach
                <a href="{{ route('admin.submodules.all') }}" class="cs-filter-chip-clear">
                    <i class="fa-solid fa-xmark"></i> Clear All
                </a>
            </div>
        @endif
    </div>

    {{-- ======================= TASK CARDS (loop / vars unchanged) ======================= --}}
    <div id="allSubModuleTable">
        @forelse ($submodules as $submodule)
            @php
                $lastReview = $submodule->reviews->first();
                $reviewCount = $submodule->reviews->count();

                $statusBarClass = match($submodule->status){
                    'Pending' => 'bar-pending',
                    'Planning' => 'bar-planning',
                    'In Progress' => 'bar-inprogress',
                    'Testing' => 'bar-testing',
                    'Ready For Review' => 'bar-ready',
                    'Changes Requested' => 'bar-changes',
                    'Approved' => 'bar-approved',
                    'On Hold' => 'bar-onhold',
                    'Cancelled' => 'bar-cancelled',
                    default => 'bar-pending',
                };

                $priorityStyle = match($submodule->priority){
                    'Critical' => ['bg' => '#FFF1F2', 'fg' => '#BE123C', 'border' => '#FECDD3', 'icon' => 'fa-fire'],
                    'High' => ['bg' => '#FFF7ED', 'fg' => '#C2410C', 'border' => '#FED7AA', 'icon' => 'fa-arrow-up'],
                    'Medium' => ['bg' => '#EFF6FF', 'fg' => '#1D4ED8', 'border' => '#BFDBFE', 'icon' => 'fa-minus'],
                    default => ['bg' => '#F1F5F9', 'fg' => '#475467', 'border' => '#E2E8F0', 'icon' => 'fa-arrow-down'],
                };

                $progressColorStart = $submodule->progress >= 100 ? '#0F9D6B'
                    : ($submodule->progress >= 60 ? '#2563EB'
                    : ($submodule->progress >= 30 ? '#D97706' : '#E11D48'));
                $progressColorEnd = $submodule->progress >= 100 ? '#16C784'
                    : ($submodule->progress >= 60 ? 'var(--cs-secondary)'
                    : ($submodule->progress >= 30 ? '#F59E0B' : '#F43F5E'));
            @endphp
            <div class="cs-task-card {{ $statusBarClass }}" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 25, 250) }}">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    {{-- icon --}}
                    <div class="cs-task-icon"><i class="fa-solid fa-diagram-project"></i></div>

                    {{-- title + path --}}
                    <div class="flex-grow-1" style="min-width:220px;">
                        <div class="cs-task-title">{{ $submodule->sub_module_name }}</div>
                        <div class="cs-task-path">
                            <span><i class="fa-regular fa-folder"></i> {{ $submodule->module->project->project_name ?? '—' }}</span>
                            <span class="dot"></span>
                            <span><i class="fa-solid fa-sitemap"></i> {{ $submodule->module->module_name ?? '—' }}</span>
                        </div>
                        @if($submodule->status === 'Changes Requested' && $lastReview?->remarks)
                            <div class="cs-meta-chip mt-2" style="color:var(--cs-danger); border-color:#FECDD3; background:#FFF1F2;">
                                <i class="fa-solid fa-comment-dots"></i>
                                {{ \Illuminate\Support\Str::limit($lastReview->remarks, 70) }}
                            </div>
                        @endif
                    </div>

                    {{-- developer --}}
                    <div style="min-width:150px;">
                        <span class="cs-col-label">Developer</span>
                        <div class="d-flex align-items-center gap-2">
                            @if($submodule->assignedTo)
                                <span class="cs-avatar">{{ strtoupper(substr($submodule->assignedTo->name, 0, 2)) }}</span>
                                <span class="small fw-semibold">{{ $submodule->assignedTo->name }}</span>
                            @else
                                <span class="cs-pill" style="background:#F1F5F9;color:#64748B;">Not Assigned</span>
                            @endif
                        </div>
                    </div>

                    {{-- priority --}}
                    <div style="min-width:110px;">
                        <span class="cs-col-label">Priority</span>
                        <span class="cs-pill" style="background:{{ $priorityStyle['bg'] }};color:{{ $priorityStyle['fg'] }};border-color:{{ $priorityStyle['border'] }};">
                            <i class="fa-solid {{ $priorityStyle['icon'] }}"></i> {{ $submodule->priority }}
                        </span>
                    </div>

                    {{-- progress --}}
                    <div style="min-width:150px;">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="cs-col-label mb-0">Progress</span>
                            <span class="small fw-bold">{{ $submodule->progress }}%</span>
                        </div>
                        <div class="cs-progress-track">
                            <div class="cs-progress-fill js-progress" data-width="{{ $submodule->progress }}" style="background:linear-gradient(90deg,{{ $progressColorStart }},{{ $progressColorEnd }});"></div>
                        </div>
                    </div>

                    {{-- deadline --}}
                    <div style="min-width:120px;">
                        <span class="cs-col-label">Deadline</span>
                        @if($submodule->deadline)
                            @php $days = \Carbon\Carbon::today()->diffInDays($submodule->deadline, false); @endphp
                            @if($days < 0)
                                <span class="cs-pill" style="background:#FFF1F2;color:#BE123C;"><i class="fa-solid fa-circle-exclamation"></i> Expired</span>
                            @elseif($days <= 2)
                                <span class="cs-pill" style="background:#FFF1F2;color:#BE123C;"><i class="fa-solid fa-clock"></i> {{ $days }} Day Left</span>
                            @elseif($days <= 7)
                                <span class="cs-pill" style="background:#FFFBEB;color:#92400E;"><i class="fa-solid fa-clock"></i> {{ $days }} Days</span>
                            @else
                                <span class="cs-meta-chip"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($submodule->deadline)->format('d M Y') }}</span>
                            @endif
                        @else
                            <span class="cs-meta-chip text-muted">No deadline</span>
                        @endif
                    </div>

                    {{-- status / review / actions --}}
                    <div style="min-width:230px;">
                        <span class="cs-col-label">Status</span>
                        <div class="mb-2">
                            @include('admin.projects.submodules.partials.status-badge', ['status' => $submodule->status])
                        </div>

                        @if($submodule->assigned_to == auth()->id())
                            {{-- apna khud ka task hai → status dropdown pehle dikhaye --}}
                            <select class="form-select form-select-sm cs-status-select submodule-status"
                                    data-id="{{ $submodule->id }}"
                                    @if($submodule->isLocked()) disabled @endif>

                                @php
                                    $statuses = ['Pending', 'Planning', 'In Progress', 'Testing', 'Ready For Review', 'On Hold', 'Cancelled'];
                                @endphp

                                {{-- Current status agar list mein nahi hai --}}
                                @if(!in_array($submodule->status, $statuses))
                                    <option value="{{ $submodule->status }}" selected>
                                        {{ $submodule->status }}
                                    </option>
                                @endif

                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected($submodule->status == $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            <a href="{{ route('admin.project-submodules.review.history', $submodule->id) }}" class="d-inline-flex align-items-center gap-1 mt-2 small text-decoration-none" style="color:var(--cs-primary);">
                                <i class="fa-solid fa-clock-rotate-left"></i> Review History
                                @if($reviewCount > 0)
                                    <span class="cs-pill" style="background:#EFFAFB;color:var(--cs-primary);border-color:#D3EFF3;padding:.06rem .4rem;font-size:.62rem;">{{ $reviewCount }}</span>
                                @endif
                            </a>

                        @elseif(auth()->user()->hasRole('Admin') || ($submodule->module->project->assigned_to ?? null) == auth()->id())
                            @include('admin.projects.submodules.partials.review-actions', ['submodule' => $submodule])
                        @else
                            <a href="{{ route('admin.project-submodules.review.history', $submodule->id) }}" class="d-inline-flex align-items-center gap-1 small text-decoration-none" style="color:var(--cs-primary);">
                                <i class="fa-solid fa-clock-rotate-left"></i> View History
                                @if($reviewCount > 0)
                                    <span class="cs-pill" style="background:#EFFAFB;color:var(--cs-primary);border-color:#D3EFF3;padding:.06rem .4rem;font-size:.62rem;">{{ $reviewCount }}</span>
                                @endif
                            </a>
                        @endif
                    </div>

                    {{-- quick actions --}}
                    <div class="d-flex align-items-center gap-2 cs-actions-row ms-auto">
                        <a href="{{ route('admin.project-submodules.review.history', $submodule->id) }}" class="cs-action-btn" title="History">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="cs-panel">
                <div class="cs-empty">
                    <svg viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="30" y="40" width="140" height="90" rx="16" fill="#F0FAFB" stroke="#CDEFF3" stroke-width="2"/>
                        <rect x="52" y="64" width="96" height="10" rx="5" fill="#CDEFF3"/>
                        <rect x="52" y="84" width="70" height="10" rx="5" fill="#E5F7F9"/>
                        <circle cx="150" cy="34" r="18" fill="#0F8EA3"/>
                        <path d="M143 34l5 5 9-10" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h4>No Tasks Found</h4>
                    <p>{{ request()->hasAny(['search','status','priority','project_id','module_id']) ? "Nothing matches these filters — try adjusting them." : "You're all caught up." }}</p>
                    @if(request()->hasAny(['search','status','priority','project_id','module_id']))
                        <a href="{{ route('admin.submodules.all') }}" class="cs-btn cs-btn-primary mt-2">
                            <i class="fa-solid fa-rotate-left"></i> Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @if($submodules->hasPages())
        <div class="cs-panel py-3">
            {{ $submodules->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- FIX: modals ko card se nikaal ke body me daalo ---------- */
    document.querySelectorAll('#allSubModuleTable .modal').forEach(function (modalEl) {
        document.body.appendChild(modalEl);
    });

    if (window.AOS) { AOS.init({ duration: 450, once: true, offset: 30 }); }

    /* ---------- last updated timestamp (client-side, real current time — not fake data) ---------- */
    var __lastUpdatedEl = document.getElementById('cs-last-updated-time');
    if (__lastUpdatedEl) {
        __lastUpdatedEl.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    /* ---------- animated KPI counters ---------- */
    document.querySelectorAll('.cs-kpi-num').forEach(function (el) {
        var target = parseInt(el.dataset.count || '0', 10);
        var obj = { val: 0 };
        if (window.gsap) {
            gsap.to(obj, {
                val: target, duration: .9, ease: 'power2.out',
                onUpdate: function () { el.textContent = Math.round(obj.val).toLocaleString(); }
            });
        } else {
            el.textContent = target.toLocaleString();
        }
    });

    /* ---------- Delivery Health number count-up ---------- */
    var __healthEl = document.querySelector('.js-health-num');
    if (__healthEl) {
        var __healthTarget = parseInt(__healthEl.dataset.value || '0', 10);
        var __healthObj = { val: 0 };
        var __healthSuffix = __healthEl.querySelector('span');
        if (window.gsap) {
            gsap.to(__healthObj, {
                val: __healthTarget, duration: 1, ease: 'power2.out',
                onUpdate: function () { __healthEl.childNodes[0].nodeValue = Math.round(__healthObj.val); }
            });
        } else {
            __healthEl.childNodes[0].nodeValue = __healthTarget;
        }
        if (__healthSuffix) { __healthEl.appendChild(__healthSuffix); }
    }

    /* ---------- segmented / micro / matrix / workload bar animations ---------- */
    ['.js-health-seg', '.js-matrix-fill', '.js-micro-fill', '.js-dev-fill'].forEach(function (sel) {
        document.querySelectorAll(sel).forEach(function (bar) {
            var w = bar.dataset.width || 0;
            requestAnimationFrame(function () { bar.style.width = w + '%'; });
        });
    });

    /* ---------- animated progress bars ---------- */
    document.querySelectorAll('.js-progress').forEach(function (bar) {
        var w = bar.dataset.width || 0;
        requestAnimationFrame(function () { bar.style.width = w + '%'; });
    });

    /* ---------- page entrance ---------- */
    if (window.gsap) {
        gsap.from('.cs-hero', { y: -12, opacity: 0, duration: .5, ease: 'power2.out' });
    }

    /* ---------- ApexCharts — Delivery Risk (data derived from the tasks on this page — same pagination scope as before) ---------- */
    /* Task Health Matrix, Priority Mix and Developer Capacity are rendered as custom premium bars above (animated via the loop below), not chart-library widgets. */
    if (window.ApexCharts) {
        var brand = { primary: '#0F8EA3', secondary: '#16B6C8', success: '#16A879', warning: '#F59E0B', danger: '#EF476F', info: '#2563EB', gray: '#94A3B8' };
        var baseChart = { fontFamily: 'Inter', toolbar: { show: false }, animations: { enabled: true, easing: 'easeout', speed: 550 } };

        var riskBuckets = @json($__deadlineBuckets);
        var riskHasData = @json($__hasDeadlineData);
        if (riskHasData) {
            new ApexCharts(document.querySelector('#cs-chart-risk'), Object.assign({}, baseChart, {
                chart: Object.assign({}, baseChart, { type: 'area', height: 110, sparkline: { enabled: true } }),
                series: [{ name: 'Tasks Due', data: riskBuckets.map(function (d) { return d.count; }) }],
                stroke: { curve: 'smooth', width: 2.25 },
                colors: [brand.primary],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: .38, opacityTo: .03, stops: [0, 90, 100] } },
                dataLabels: { enabled: false },
                tooltip: {
                    theme: 'light',
                    x: { formatter: function (val) { return riskBuckets[val - 1] ? riskBuckets[val - 1].date : ''; } },
                    y: { formatter: function (val) { return val + ' task' + (val === 1 ? '' : 's') + ' due'; } }
                }
            })).render();
        } else {
            document.querySelector('#cs-chart-risk').innerHTML = '<p class="text-muted small mb-0">No upcoming deadlines.</p>';
        }
    }

    /* ---------- status change (endpoint / payload unchanged) ---------- */
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
            body: JSON.stringify({ status: e.target.value })
        })
        .then(res => {
            if (!res.ok) return res.json().then(err => { throw err; });
            return res.json();
        })
        .then(() => location.reload())
        .catch(err => {
            alert(err.message || 'Could not update status.');
            location.reload();
        });
    });
});
</script>
@endpush


