@extends('index')
@section('title','SEO Health Dashboard')

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale-subtle.css">

<style>

  .user-avatar{
    width: 15px;
    height:42px;
}

.user-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.avatar-placeholder{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#1E88E5,#00BCD4);
    color:#fff;
    font-weight:700;
    border-radius:50%;
}
/* ==========================================================================
   DESIGN TOKENS — Code Sparrow ERP · premium SaaS surface
========================================================================== */
:root{
  --blue:        #2563EB;
  --blue-2:      #3B82F6;
  --blue-soft:   rgba(37,99,235,.08);
  --teal:        #0D9488;
  --teal-2:      #14B8A6;
  --teal-soft:   rgba(13,148,136,.08);
  /* --brand-grad:  linear-gradient(135deg, var(--blue) 0%, var(--teal) 100%); */
  --brand-grad: linear-gradient(135deg, #197a83 0%, #747474 100%);

  --ink:         #0B0F19;
  --ink-2:       #1C2333;
  --muted:       #667085;
  --faint:       #98A2B3;

  --white:       #FFFFFF;
  --bg:          #FAFBFC;
  --surface:     #FFFFFF;
  --line:        #EAECF0;
  --line-soft:   #F2F4F7;

  --success:     #12B76A;
  --success-soft:#ECFDF3;
  --warning:     #F79009;
  --warning-soft:#FFFAEB;
  --orange:      #F97066;
  --orange-soft: #FEF6EE;
  --danger:      #F04438;
  --danger-soft: #FEF3F2;
  --future:      #D0D5DD;

  --r-2xl: 24px; --r-xl: 20px; --r-lg: 16px; --r-md: 12px; --r-full: 999px;

  --shadow-xs: 0 1px 2px rgba(16,24,40,.05);
  --shadow-sm: 0 1px 3px rgba(16,24,40,.1), 0 1px 2px rgba(16,24,40,.06);
  --shadow-md: 0 4px 6px -2px rgba(16,24,40,.05), 0 10px 15px -3px rgba(16,24,40,.08);
  --shadow-lg: 0 8px 10px -6px rgba(16,24,40,.06), 0 24px 32px -8px rgba(16,24,40,.12);
  --shadow-glow: 0 0 0 1px rgba(37,99,235,.06), 0 16px 40px -10px rgba(37,99,235,.30);

  --font-display: 'Manrope', 'Inter', sans-serif;
  --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

*{ box-sizing:border-box; }

.seo-dash{
  position:relative;
  font-family:var(--font);
  color:var(--ink);
  background: #f3f3f6;
  margin:-1.5rem;
  padding:40px clamp(20px, 4vw, 15px) 100px;
  -webkit-font-smoothing:antialiased;
  overflow:hidden;
}

@media (prefers-reduced-motion: reduce){
  .seo-dash *{ animation-duration:.001ms !important; transition-duration:.001ms !important; scroll-behavior:auto !important; }
}

.seo-dash .container{ position:relative; z-index:1; max-width:1320px; margin:0 auto; }

/* ambient wash — soft, low-opacity, no hero block */
.ambient{ position:absolute; inset:0; z-index:0; pointer-events:none; }
.ambient span{ position:absolute; border-radius:50%; filter:blur(110px); opacity:.5; }
.ambient .a1{ width:520px; height:520px; background:radial-gradient(circle, var(--blue-soft), transparent 70%); top:-220px; left:-120px; }
.ambient .a2{ width:460px; height:460px; background:radial-gradient(circle, var(--teal-soft), transparent 70%); top:-160px; right:-80px; }

/* ==========================================================================
   SKELETON LOADING
========================================================================== */
.skeleton-shimmer{
  position:absolute; inset:0; border-radius:inherit; z-index:5;
  background:linear-gradient(100deg, var(--line-soft) 30%, #FFFFFF 50%, var(--line-soft) 70%);
  background-size:250% 100%; animation:shimmer 1.5s ease infinite;
  opacity:1; transition:opacity .5s ease;
}
@keyframes shimmer{ 0%{ background-position:120% 0; } 100%{ background-position:-20% 0; } }
.seo-dash.is-loading .kpi-card > *:not(.skeleton-shimmer),
.seo-dash.is-loading .vendor-card > *:not(.skeleton-shimmer){ opacity:0; }
.skeleton-shimmer.is-hidden{ opacity:0; pointer-events:none; }

/* ==========================================================================
   PAGE HEADER
========================================================================== */
.dash-header{
  display:flex; align-items:flex-end; justify-content:space-between; gap:24px;
  padding-bottom:18px; margin-bottom:22px; border-bottom:1px solid var(--line);
}
.dash-header-left{ display:flex; align-items:center; gap:16px; }
.dash-logo-img{ height:28px; width:auto; display:block; }
.dash-header-titles{ padding-left:16px; border-left:1px solid var(--line); }
.dash-eyebrow{ display:flex; align-items:center; gap:6px; font-size:11px; font-weight:700; letter-spacing:.09em; text-transform:uppercase; color:var(--teal); margin-bottom:6px; }
.dash-eyebrow::before{ content:''; width:5px; height:5px; border-radius:50%; background:var(--teal); }
.dash-title{ font-family:var(--font-display); font-weight:800; font-size:28px; line-height:1.15; color:var(--ink); margin:0 0 5px; letter-spacing:-.02em; overflow:hidden; }
.dash-subtitle{ font-size:14px; color:var(--muted); margin:0; }

.dash-header-right{ display:flex; align-items:center; gap:10px; flex-shrink:0; }
.dash-date{
  display:flex; align-items:center; gap:8px; font-size:13px; font-weight:500; color:var(--muted);
  background:var(--surface); border:1px solid var(--line); border-radius:var(--r-full); padding:9px 16px 9px 14px;
  box-shadow:var(--shadow-xs);
}
.dash-date svg{ width:14px; height:14px; color:var(--faint); }
.dash-btn{
  position:relative; display:inline-flex; align-items:center; gap:8px; font-family:var(--font); font-size:13px; font-weight:600; color:var(--ink-2);
  background:var(--surface); border:1px solid var(--line); border-radius:var(--r-full); padding:9px 18px; cursor:pointer;
  box-shadow:var(--shadow-xs); transition:border-color .25s ease, box-shadow .25s ease, color .25s ease;
  overflow:hidden;
}
.dash-btn:hover{ border-color:var(--blue); color:var(--blue); box-shadow:var(--shadow-glow); }
.dash-btn-icon{ padding:9px 12px; }
.dash-btn svg{ width:14px; height:14px; }

/* ==========================================================================
   KPI ROW
========================================================================== */
.kpi-row{ display:grid; grid-template-columns:repeat(4, 1fr); gap:18px; margin-bottom:24px; }
.kpi-card{
  position:relative; background:var(--surface); border:1px solid var(--line); border-radius:var(--r-xl);
  padding:24px 26px;
  /* box-shadow:var(--shadow-sm); */
  min-height:180px;
  display:flex; flex-direction:column; justify-content:space-between; overflow:hidden;
}
.kpi-card::after{
  content:''; position:absolute; inset:0; border-radius:inherit; padding:1px; opacity:0; pointer-events:none;
  background:var(--brand-grad); -webkit-mask:linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
  -webkit-mask-composite:xor; mask-composite:exclude; transition:opacity .35s ease;
}
.kpi-card:hover::after{ opacity:.5; }
.kpi-card:hover{ box-shadow:var(--shadow-glow); }
.kpi-icon{
  width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center;
  color:var(--blue); background:var(--blue-soft);
}
.kpi-icon svg{ width:17px; height:17px; }
.kpi-card.accent-teal .kpi-icon{ color:var(--teal); background:var(--teal-soft); }
.kpi-value{ font-family:var(--font-display); font-weight:800; font-size:32px; line-height:1; color:var(--ink); letter-spacing:-.02em; }
.kpi-label{ margin-top:6px; font-size:13px; font-weight:600; color:var(--muted); }

.kpi-gauge-card{ flex-direction:row; align-items:center; gap:16px; }
.kpi-gauge-chart{ width:96px; height:96px; flex:0 0 auto; margin:-8px; }
.kpi-gauge-copy .kpi-label{ margin-top:2px; }
.kpi-gauge-copy .kpi-sub{ font-size:12px; color:var(--faint); margin-top:4px; }

/* ==========================================================================
   VENDOR CARDS
========================================================================== */
.vendors{ display:grid; grid-template-columns:repeat(1, 1fr); gap:24px; }
.vendor-card{
  position:relative; background:var(--surface);
  /* border:1px solid var(--line); */
  border-radius:var(--r-2xl);
  padding: 20px 24px 18px;
  /* box-shadow:var(--shadow-sm); */
  overflow:hidden;
}

.vendor-card:hover{ box-shadow:var(--shadow-lg); }

.vc-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:16px;}
.vc-top-actions{ flex:0 0 auto; display:flex; align-items:center; gap:10px; }
.vc-identity{ display:flex; align-items:center; gap:14px; min-width:0; }
.vc-avatar{
  flex:0 0 auto; width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center;
  font-family:var(--font-display); font-weight:700; font-size:15px; color:#fff;
  background:var(--brand-grad); box-shadow:0 8px 18px rgba(13,148,136,.24);
}
.vc-name{ line-height: 1.6; font-family:var(--font-display); font-size:16px; font-weight:700; color:var(--ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.vc-plan{ display:inline-block; font-size: 10px; font-weight:700; padding: 0px 11px; border-radius:var(--r-full); background:var(--teal-soft); color:var(--teal); letter-spacing:.01em; margin-top: -10px; }
.vc-status{
  flex:0 0 auto; display:inline-flex; align-items:center; gap:6px; font-size:11px; font-weight:700; letter-spacing:.04em;
  text-transform:uppercase; color:var(--success); padding:7px 13px 7px 10px; border-radius:var(--r-full); background:var(--success-soft);
}
.vc-status i{ width:6px; height:6px; border-radius:50%; background:var(--success); display:inline-block; animation:breathe 2.4s ease-in-out infinite; }
@keyframes breathe{ 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:.45; transform:scale(.7); } }

.vc-metrics-row{ display:flex; align-items:center; gap:22px; margin-bottom:14px; }
.vc-health-inline{ flex:1 1 auto; min-width:0; }
.vc-health-head{ display:flex; justify-content:space-between; align-items:baseline; margin-bottom:6px; font-size:12px; font-weight:600; color:var(--muted); }
.vc-health-value{ font-family:var(--font-display); font-size:14px; font-weight:800; color:var(--ink); }
.vc-progress{ height:6px; border-radius:var(--r-full); background:var(--line-soft); overflow:hidden; position:relative; }
.vc-progress-fill{ height:100%; width:0%; border-radius:var(--r-full); position:relative; overflow:hidden; }
.vc-progress-shine{ position:absolute; inset:0; background:linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent); transform:translateX(-100%); }
.health-success{ background:linear-gradient(90deg, #0E9F5C, var(--success)); }
.health-warning{ background:linear-gradient(90deg, #C77700, var(--warning)); }
.health-orange{  background:linear-gradient(90deg, #E35A3C, var(--orange)); }
.health-danger{  background:linear-gradient(90deg, #D42D20, var(--danger)); }

.vc-stats-inline{ flex:0 0 auto; display:flex; flex-wrap:wrap; gap:8px; }
.vc-pill{
  display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:var(--r-full);
  background:var(--bg); border:1px solid var(--line); font-size:11.5px; font-weight:600; color:var(--muted);
  transition:border-color .25s ease, transform .25s ease;
}
.vc-pill:hover{ border-color:var(--blue); transform:translateY(-1px); }
.vc-pill-dot{ width:6px; height:6px; border-radius:50%; }
.vc-pill.is-completed .vc-pill-dot{ background:var(--success); }
.vc-pill.is-pending .vc-pill-dot{ background:var(--warning); }
.vc-pill.is-total .vc-pill-dot{ background:var(--blue); }
.vc-pill strong{ font-family:var(--font-display); font-weight:800; font-size:12.5px; color:var(--ink); }

/* .vc-weekly-head{ margin-bottom:8px; } */
.vc-weekly-head h4{ font-family:var(--font-display); font-size:14px; font-weight:700; margin:0; color:var(--ink); }
.btn-view-report{
  position:relative; display:inline-flex; align-items:center; gap:8px; border:1px solid var(--line); cursor:pointer;
  padding:8px 15px; border-radius:var(--r-full); font-size:12px; font-weight:700; color:var(--white);
  background:var(--brand-grad); text-decoration:none; box-shadow:var(--shadow-xs); overflow:hidden; flex:0 0 auto;
}
.btn-view-report svg{ width:13px; height:13px; }
.btn-view-report:hover{ box-shadow:var(--shadow-glow); }
.btn-view-report .ripple{ position:absolute; border-radius:50%; background:rgba(255,255,255,.5); transform:scale(0); pointer-events:none; }

/* ---------- weekly legend ---------- */
.weekly-legend{ display:flex; flex-wrap:wrap; gap:12px; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid var(--line-soft); }
.legend-item{ display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:500; color:var(--muted); }
.legend-dot{ width:6px; height:6px; border-radius:50%; display:inline-block; }
.legend-dot.status-success{ background:var(--success); }
.legend-dot.status-good{ background:var(--blue); }
.legend-dot.status-average{ background:var(--warning); }
.legend-dot.status-poor{ background:var(--danger); }
.legend-dot.status-upcoming{ background:var(--future); }

/* ---------- floating mini panels ---------- */
.weekly-panels-wrap{ overflow-x:auto; overflow-y:visible; padding:2px 4px 6px; margin:0 -4px -4px; }
.weekly-panels-wrap::-webkit-scrollbar{ height:5px; }
.weekly-panels-wrap::-webkit-scrollbar-thumb{ background:var(--line); border-radius:var(--r-full); }
.weekly-panels{ display:flex; gap: 3px; min-width:max-content; padding:2px; }

.week-panel{
  position:relative;
  flex:0 0 auto;
  width:110px;
  height:145px; 
  display:flex;
  flex-direction:column; 
  align-items:center;
  justify-content:center;
  text-align:center;
  padding:12px 8px;
  border-radius:18px; 
  background:var(--surface);
  /* border:1px solid var(--line); */
  /* box-shadow:var(--shadow-xs); */
  cursor:pointer;
  transition:border-color .3s ease, box-shadow .3s ease;
}
.week-panel::before{
  content:''; position:absolute; top:0; left:12px; right:12px; height:1px;
  background:linear-gradient(90deg, transparent, rgba(255,255,255,.9), transparent); opacity:.6;
}
.week-panel:hover{ border-color:var(--blue); box-shadow:var(--shadow-glow); }

.week-panel-ring{ position:relative; width:64px; height:64px; margin-bottom:8px; }
.week-panel-ring svg{ width: 50px; height: 50px; transform:rotate(-90deg); }
.week-ring-track{ fill:none; stroke:var(--line-soft); stroke-width:6; }
.week-ring-fill{ fill:none; stroke-width:6; stroke-linecap:round; }
.week-ring-fill.status-success{ stroke:var(--success); }
.week-ring-fill.status-good{ stroke:var(--blue); }
.week-ring-fill.status-average{ stroke:var(--warning); }
.week-ring-fill.status-poor{ stroke:var(--danger); }
.week-panel.is-future .week-ring-fill{ stroke:var(--future); }
.week-panel-value{
  position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
  font-family:var(--font-display); font-weight:800; font-size: 12px; color:var(--ink); letter-spacing:-.01em;
}
.week-panel.is-future .week-panel-value{ font-size:10.5px; font-weight:700; color:var(--faint); }

.week-panel-badge{
  display:inline-flex; align-items:center; font-size:9.5px; font-weight:700; padding: 0px 6px; border-radius:var(--r-full);
  margin-bottom:6px; transition:box-shadow .3s ease;
}
.week-panel-badge.status-success{ color:var(--success); background:var(--success-soft); }
.week-panel-badge.status-good{ color:var(--blue); background:var(--blue-soft); }
.week-panel-badge.status-average{ color:var(--warning); background:var(--warning-soft); }
.week-panel-badge.status-poor{ color:var(--danger); background:var(--danger-soft); }
.week-panel-badge.status-upcoming{ color:var(--faint); background:var(--line-soft); }
.week-panel:hover .week-panel-badge.status-success{ box-shadow:0 0 0 4px var(--success-soft); }
.week-panel:hover .week-panel-badge.status-good{ box-shadow:0 0 0 4px var(--blue-soft); }
.week-panel:hover .week-panel-badge.status-average{ box-shadow:0 0 0 4px var(--warning-soft); }
.week-panel:hover .week-panel-badge.status-poor{ box-shadow:0 0 0 4px var(--danger-soft); }

.week-panel-num{ font-family:var(--font-display); font-size:11px; font-weight:700; color:var(--ink); margin-bottom:1px; }
.week-panel-range{ font-size:9.5px; color:var(--faint); margin-top: -10px; }

/* ---------- tippy premium theme ---------- */
.tippy-box[data-theme~='sparrow']{
  background:var(--ink); color:#fff; border-radius:var(--r-md); font-family:var(--font);
  box-shadow:0 20px 40px rgba(11,15,25,.3);
}
.tippy-box[data-theme~='sparrow'] .tippy-arrow{ color:var(--ink); }
.tt-week{ font-family:var(--font-display); font-weight:700; font-size:13px; margin-bottom:2px; }
.tt-range{ color:rgba(255,255,255,.5); font-size:11px; margin-bottom:9px; }
.tt-row{ display:flex; justify-content:space-between; gap:16px; padding:2.5px 0; font-size:12px; color:rgba(255,255,255,.85); }
.tt-health{ display:flex; justify-content:space-between; margin-top:7px; padding-top:7px; border-top:1px solid rgba(255,255,255,.14); font-size:12px; color:#5EEAD4; font-weight:700; }

/* ==========================================================================
   RESPONSIVE
========================================================================== */
@media (max-width: 1280px){ .vendors{ grid-template-columns:1fr; } }
@media (max-width: 1100px){ .kpi-row{ grid-template-columns:repeat(2,1fr); } }
@media (max-width: 768px){
  .seo-dash{ padding:28px 16px 60px; }
  .dash-header{ flex-direction:column; align-items:flex-start; gap:18px; }
  .dash-header-right{ width:100%; justify-content:flex-start; flex-wrap:wrap; }
  .dash-header-titles{ padding-left:14px; }
  .vendor-card{ padding:18px 16px; }
  .vc-top{ flex-wrap:wrap; }
  .vc-top-actions{ width:100%; justify-content:space-between; }
  .vc-metrics-row{ flex-direction:column; align-items:stretch; gap:10px; }
  .kpi-gauge-card{ flex-direction:column; align-items:flex-start; text-align:left; }
}
@media (max-width: 480px){ .kpi-row{ grid-template-columns:1fr; } }


.main_content {
    padding: 20px 10px 20px;
}
</style>
@endpush

@section('content')

@php
    // ------------------------------------------------------------------
    // KPI roll-ups derived from $packages (already annotated by the
    // controller with total_tasks / completed_tasks / pending_tasks /
    // overall_health / weeks — see SeoReportController@dashboard)
    // ------------------------------------------------------------------
    $totalVendors    = $packages->pluck('company.company_name')->unique()->count();
    $activePackages  = $packages->count();
    $avgHealth       = $activePackages ? (int) round($packages->avg('overall_health')) : 0;
    $completedTasks  = (int) $packages->sum('completed_tasks');
    $ringCircumference = 2 * M_PI * 52; // matches r=52 on the SVG ring below

    // Overall package health -> success/warning/orange/danger, reusing
    // the exact thresholds the controller already uses for weekly color.
    $healthClass = function ($health) {
        if ($health >= 90) return 'success';
        if ($health >= 70) return 'warning';
        if ($health >= 40) return 'orange';
        return 'danger';
    };
@endphp

@php
    // Display-only label map for the Weekly Health status badges.
    // Purely presentational — reuses the existing $week['color'] values
    // (success/warning/orange/danger) computed by the controller.
    $weekStatusMap = [
        'success' => ['label' => 'Excellent', 'class' => 'status-success'],
        'warning' => ['label' => 'Good',      'class' => 'status-good'],
        'orange'  => ['label' => 'Average',   'class' => 'status-average'],
        'danger'  => ['label' => 'Poor',      'class' => 'status-poor'],
    ];

 @endphp   

<div class="seo-dash is-loading" id="seoDash">
  <div class="ambient" aria-hidden="true"><span class="a1"></span><span class="a2"></span></div>

  <div class="container">

    {{-- ============================================================
         PAGE HEADER
    ============================================================ --}}
    <header class="dash-header">
      <div class="dash-header-left">
        <img src="{{ asset('uploads/code-sparrow-logo.png') }}" alt="Code Sparrow" class="dash-logo-img">
        <div class="dash-header-titles">
          <span class="dash-eyebrow">Client Performance</span>
          <h1 class="dash-title" id="heroTitle">SEO Health Dashboard</h1>
          <p class="dash-subtitle">Vendor packages, weekly health, and delivery status at a glance</p>
        </div>
      </div>
      <div class="dash-header-right">
        <div class="dash-date"><i data-lucide="calendar"></i><span>{{ now()->format('l, F j') }}</span></div>
        <button class="dash-btn dash-btn-icon magnetic" type="button" id="refreshBtn" aria-label="Refresh"><i data-lucide="refresh-cw"></i></button>
        <button class="dash-btn magnetic" type="button"><i data-lucide="sliders-horizontal"></i><span>Filter</span></button>
      </div>
    </header>

    {{-- ---------- KPI ROW ---------- --}}
    <section class="kpi-row" aria-label="Key metrics">

      <div class="kpi-card">
        <div class="skeleton-shimmer"></div>
        <div class="kpi-icon"><i data-lucide="building-2"></i></div>
        <div>
          <div class="kpi-value" data-countup="{{ $totalVendors }}">0</div>
          <div class="kpi-label">Total Vendors</div>
        </div>
      </div>

      <div class="kpi-card accent-teal">
        <div class="skeleton-shimmer"></div>
        <div class="kpi-icon"><i data-lucide="layers"></i></div>
        <div>
          <div class="kpi-value" data-countup="{{ $activePackages }}">0</div>
          <div class="kpi-label">Active SEO Packages</div>
        </div>
      </div>

      <div class="kpi-card kpi-gauge-card">
        <div class="skeleton-shimmer"></div>
        <div class="kpi-gauge-chart" id="avgHealthGauge" data-value="{{ $avgHealth }}"></div>
        <div class="kpi-gauge-copy">
          <div class="kpi-label">Average SEO Health</div>
          <div class="kpi-sub">Across all active packages</div>
        </div>
      </div>

      <div class="kpi-card accent-teal">
        <div class="skeleton-shimmer"></div>
        <div class="kpi-icon"><i data-lucide="circle-check-big"></i></div>
        <div>
          <div class="kpi-value" data-countup="{{ $completedTasks }}">0</div>
          <div class="kpi-label">Completed Tasks</div>
        </div>
      </div>

    </section>

    {{-- ---------- VENDOR CARDS ---------- --}}
    <section class="vendors" aria-label="Vendor SEO packages">
      @foreach($packages as $package)
        @php
            $initials = collect(explode(' ', $package->company->name))
                ->map(fn ($w) => strtoupper($w[0] ?? ''))
                ->take(2)
                ->implode('');
            $overallClass = $healthClass($package->overall_health);
        @endphp

        <article class="vendor-card">
          <div class="skeleton-shimmer"></div>

          <div class="vc-top">
            <div class="vc-identity">
              <div class="vc-avatar">{{ $initials }}</div>
              <div style="min-width:0;">
                <h3 class="vc-name">{{ $package->company->name }}</h3>
                <span class="vc-plan">{{ $package->seoPlan->name }}</span>
              </div>

             



            </div>
            <div class="vc-top-actions">

              

              <span class="vc-status"><i></i> Active</span>

               <a href="{{ route('seo.dashboard', $package->id) }}">
                  <button class="btn btn-warning btn-sm" style="border-radius: 20px;">
                    Analyse Dashboard
                    </button>
                </a>

              <!-- <a href="" class="btn-view-report magnetic">
                <span>View Report</span>
                <i data-lucide="arrow-up-right"></i>
              </a> -->

              <a href="{{ route('admin.seo.reports', $package->id) }}"
                class="btn-view-report magnetic">

                  <span>View Report</span>

                  <i data-lucide="arrow-up-right"></i>

              </a>
            </div>
          </div>


         
          

          <div class="vc-metrics-row">
            <div class="vc-health-inline">
              <div class="vc-health-head">
                <span>Overall SEO Health</span>
                <strong class="vc-health-value">{{ $package->overall_health }}%</strong>
              </div>
              <div class="vc-progress">
                <div class="vc-progress-fill health-{{ $overallClass }}" data-target="{{ $package->overall_health }}">
                  <span class="vc-progress-shine"></span>
                </div>
              </div>
            </div>

            <div class="vc-stats-inline">
              <span class="vc-pill is-completed"><i class="vc-pill-dot"></i>Completed <strong data-countup="{{ $package->completed_tasks }}">0</strong></span>
              <span class="vc-pill is-pending"><i class="vc-pill-dot"></i>Pending <strong data-countup="{{ $package->pending_tasks }}">0</strong></span>
              <span class="vc-pill is-total"><i class="vc-pill-dot"></i>Total <strong data-countup="{{ $package->total_tasks }}">0</strong></span>
            </div>
          </div>

          <div class="vc-weekly">
            <div class="vc-weekly-head">
              <h4>Weekly Health</h4>
            </div>

             <div style="display: flex; justify-content: space-between;">
            <div class="weekly-legend">
              <span class="legend-item"><i class="legend-dot status-success"></i>Excellent</span>
              <span class="legend-item"><i class="legend-dot status-good"></i>Good</span>
              <span class="legend-item"><i class="legend-dot status-average"></i>Average</span>
              <span class="legend-item"><i class="legend-dot status-poor"></i>Poor</span>
              <span class="legend-item"><i class="legend-dot status-upcoming"></i>Upcoming</span>
            </div>

            <!--  -->
         
            <div class="d-flex align-items-center">
                <div class="user-avatar">
                  👤
                </div>
                <div class="ms-2" style="margin-top: -10px;">
                    <span class="fw-semibold" style="font-size: 12px;">
                          {{ $package->assignedUser->name ?? 'Not Assigned' }}
                    </span>
                    <small class="text-muted d-block" style="font-size: 10px; margin-top: -10px;">
                        {{ $package->assignedUser->designation->title ?? 'SEO Executive' }}
                    </small>
                </div>
            </div>
          </div>

          <!--  -->

            <div class="weekly-panels-wrap">
              <div class="weekly-panels">
                @foreach($package->weeks as $week)

                  @php
                      $r = 27; $c = 2 * M_PI * $r;
                      $status = $week['future'] ? ['label' => 'Upcoming', 'class' => 'status-upcoming'] : ($weekStatusMap[$week['color']] ?? ['label' => 'Average', 'class' => 'status-average']);
                  @endphp
                  <div class="week-panel {{ $week['future'] ? 'is-future' : '' }}"
                       data-week="{{ $week['week'] }}"
                       data-start="{{ $week['start'] }}"
                       data-end="{{ $week['end'] }}"
                       data-expected="{{ $week['expected'] }}"
                       data-completed="{{ $week['completed'] }}"
                       data-remaining="{{ $week['remaining'] }}"
                       data-health="{{ $week['health'] }}"
                       data-future="{{ $week['future'] ? 'true' : 'false' }}">
                    <div class="week-panel-ring">
                      <svg viewBox="0 0 64 64">
                        <circle class="week-ring-track" cx="32" cy="32" r="{{ $r }}"></circle>
                        <circle class="week-ring-fill {{ $week['future'] ? '' : $status['class'] }}" cx="32" cy="32" r="{{ $r }}"
                                style="stroke-dasharray:{{ $c }};stroke-dashoffset:{{ $c }};"
                                data-target-pct="{{ $week['future'] ? 0 : $week['health'] }}" data-circumference="{{ $c }}"></circle>
                      </svg>
                      <span class="week-panel-value">{{ $week['future'] ? '--' : '0%' }}</span>
                    </div>
                    <span class="week-panel-badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                    <div class="week-panel-num">Week {{ $week['week'] }}</div>
                    <div class="week-panel-range" data-range-for="{{ $week['week'] }}"></div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          

        </article>
      @endforeach
    </section>

  </div>
</div>

@endsection

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/split-type@0.3.4/umd/index.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>
(function () {
  const dash = document.getElementById('seoDash');

  /* ------------------------------------------------------------------
     Icons
  ------------------------------------------------------------------ */
  if (window.lucide) lucide.createIcons();

  gsap.registerPlugin(ScrollTrigger);

  /* ------------------------------------------------------------------
     Count-up (CountUp.js)
  ------------------------------------------------------------------ */
  function animateCount(el) {
    const raw = el.dataset.countup;
    if (raw === undefined) return;
    const target = parseFloat(raw) || 0;
    if (window.countUp && window.countUp.CountUp) {
      const cu = new window.countUp.CountUp(el, target, { duration: 1.3 });
      if (!cu.error) { cu.start(); return; }
    }
    el.textContent = target;
  }

  /* ------------------------------------------------------------------
     ApexCharts — Average SEO Health radial gauge
  ------------------------------------------------------------------ */
  const gaugeEl = document.getElementById('avgHealthGauge');
  if (gaugeEl && window.ApexCharts) {
    const val = parseFloat(gaugeEl.dataset.value) || 0;
    new ApexCharts(gaugeEl, {
      chart: { type: 'radialBar', height: 96, width: 96, sparkline: { enabled: true } },
      series: [val],
      colors: ['#2563EB'],
      fill: { type: 'gradient', gradient: { shade: 'light', gradientToColors: ['#0D9488'], shadeIntensity: 0.5, type: 'horizontal' } },
      stroke: { lineCap: 'round' },
      plotOptions: {
        radialBar: {
          hollow: { size: '58%' },
          track: { background: '#F2F4F7' },
          dataLabels: {
            show: true,
            value: { offsetY: 5, fontSize: '15px', fontWeight: 800, fontFamily: 'Manrope, Inter, sans-serif', color: '#0B0F19', formatter: (v) => Math.round(v) + '%' }
          }
        }
      }
    }).render();
  }

  /* ------------------------------------------------------------------
     SVG ring fill — tween stroke-dashoffset + the percent label
  ------------------------------------------------------------------ */
  function animateWeekRing(circle, delay) {
    const c = parseFloat(circle.dataset.circumference);
    const target = parseFloat(circle.dataset.targetPct) || 0;
    const panel = circle.closest('.week-panel');
    const label = panel.querySelector('.week-panel-value');
    const isFuture = panel.classList.contains('is-future');
    const obj = { pct: 0 };
    gsap.to(obj, {
      pct: target, duration: 1.1, delay: delay || 0, ease: 'power2.out',
      onUpdate: () => {
        circle.style.strokeDashoffset = c - (obj.pct / 100) * c;
        if (!isFuture) label.textContent = Math.round(obj.pct) + '%';
      }
    });
  }

  /* ------------------------------------------------------------------
     Fill the visible "22 Jul – 28 Jul" range under each week panel
  ------------------------------------------------------------------ */
  function fmtDate(iso) {
    return new Date(iso + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
  }
  document.querySelectorAll('.week-panel').forEach((panel) => {
    const rangeEl = panel.querySelector('.week-panel-range');
    if (rangeEl) rangeEl.textContent = fmtDate(panel.dataset.start) + ' – ' + fmtDate(panel.dataset.end);
  });

  /* ------------------------------------------------------------------
     Tippy.js — rich hover popovers on each week panel
  ------------------------------------------------------------------ */
  
  if (window.tippy) {
    tippy('.week-panel', {
      theme: 'sparrow',
      animation: 'scale-subtle',
      allowHTML: true,
      placement: 'top',
      content: (ref) => {
        const d = ref.dataset;
        const future = d.future === 'true';
        return `
          <div class="tt-week">Week ${d.week}</div>
          <div class="tt-range">${fmtDate(d.start)} – ${fmtDate(d.end)}</div>
          <div class="tt-row"><span>Completed Tasks</span><strong>${future ? '—' : d.completed}</strong></div>
          <div class="tt-row"><span>Pending Tasks</span><strong>${future ? '—' : d.remaining}</strong></div>
          <div class="tt-row"><span>Total Tasks</span><strong>${future ? '—' : d.expected}</strong></div>
          <div class="tt-health"><span>Health</span><strong>${future ? 'Upcoming' : d.health + '%'}</strong></div>
        `;
      }
    });
  }

  /* ------------------------------------------------------------------
     Magnetic buttons
  ------------------------------------------------------------------ */
  document.querySelectorAll('.magnetic').forEach((btn) => {
    const xTo = gsap.quickTo(btn, 'x', { duration: 0.4, ease: 'power3.out' });
    const yTo = gsap.quickTo(btn, 'y', { duration: 0.4, ease: 'power3.out' });
    btn.addEventListener('mousemove', (e) => {
      const r = btn.getBoundingClientRect();
      xTo((e.clientX - r.left - r.width / 2) * 0.3);
      yTo((e.clientY - r.top - r.height / 2) * 0.3);
    });
    btn.addEventListener('mouseleave', () => { xTo(0); yTo(0); });
  });

  /* ------------------------------------------------------------------
     Hover lift for cards + nodes
  ------------------------------------------------------------------ */
  function hoverLift(selector, { y = -4, scale = 1 } = {}) {
    document.querySelectorAll(selector).forEach((el) => {
      el.addEventListener('mouseenter', () => gsap.to(el, { y, scale, duration: 0.35, ease: 'power2.out' }));
      el.addEventListener('mouseleave', () => gsap.to(el, { y: 0, scale: 1, duration: 0.35, ease: 'power2.out' }));
    });
  }
  hoverLift('.kpi-card', { y: -4 });
  hoverLift('.vendor-card', { y: -2 });
  hoverLift('.week-panel', { y: -6, scale: 1.04 });

  /* ------------------------------------------------------------------
     Ripple on "View Report" click
  ------------------------------------------------------------------ */
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-view-report');
    if (!btn) return;
    const rect = btn.getBoundingClientRect();
    const ripple = document.createElement('span');
    ripple.className = 'ripple';
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
    btn.appendChild(ripple);
    gsap.fromTo(ripple, { scale: 0, opacity: 0.5 }, { scale: 3, opacity: 0, duration: 0.6, ease: 'power2.out', onComplete: () => ripple.remove() });
  });

  /* ------------------------------------------------------------------
     Refresh icon spin
  ------------------------------------------------------------------ */
  const refreshBtn = document.getElementById('refreshBtn');
  if (refreshBtn) {
    refreshBtn.addEventListener('click', () => {
      const icon = refreshBtn.querySelector('svg');
      gsap.to(icon, { rotate: 360, duration: 0.6, ease: 'power2.inOut' });
      gsap.set(icon, { rotate: 0, delay: 0.6 });
    });
  }

  /* ------------------------------------------------------------------
     Entrance sequence: skeleton -> heading split-reveal -> KPI cards
     -> vendor cards on scroll
  ------------------------------------------------------------------ */
  window.addEventListener('load', () => {
    let titleSplit = null;
    if (window.SplitType) {
      titleSplit = new SplitType('#heroTitle', { types: 'words,chars' });
      gsap.set(titleSplit.chars, { yPercent: 120 });
    }

    setTimeout(() => {
      dash.classList.remove('is-loading');
      document.querySelectorAll('.skeleton-shimmer').forEach((s) => s.classList.add('is-hidden'));

      const tl = gsap.timeline({ defaults: { ease: 'power2.out' } });
      if (titleSplit) {
        tl.to(titleSplit.chars, { yPercent: 0, duration: 0.8, ease: 'power4.out', stagger: 0.02 });
      }
      tl.from('.dash-eyebrow, .dash-subtitle', { opacity: 0, y: 10, duration: 0.5, stagger: 0.08 }, '-=0.5')
        .from('.dash-header-right', { opacity: 0, y: 10, duration: 0.5 }, '-=0.4')
        .from('.kpi-card', { opacity: 0, y: 20, duration: 0.55, stagger: 0.08 }, '-=0.3')
        .from('.kpi-icon', { scale: 0, duration: 0.5, ease: 'back.out(2.2)', stagger: 0.08 }, '-=0.5')
        .add(() => document.querySelectorAll('.kpi-card [data-countup]').forEach(animateCount), '-=0.3');
    }, 650);

    document.querySelectorAll('.vendor-card').forEach((card) => {
      gsap.from(card, {
        opacity: 0, y: 28, filter: 'blur(6px)', duration: 0.65, ease: 'power2.out',
        scrollTrigger: { trigger: card, start: 'top 88%' }
      });

      ScrollTrigger.create({
        trigger: card, start: 'top 85%', once: true,
        onEnter: () => {
          const fill = card.querySelector('.vc-progress-fill');
          gsap.to(fill, { width: fill.dataset.target + '%', duration: 1.2, ease: 'power2.out' });
          gsap.fromTo(card.querySelector('.vc-progress-shine'), { xPercent: -100 }, { xPercent: 200, duration: 1.4, ease: 'power2.inOut' });
          card.querySelectorAll('.vc-pill [data-countup]').forEach(animateCount);
        }
      });

      ScrollTrigger.create({
        trigger: card, start: 'top 80%', once: true,
        onEnter: () => {
          gsap.from(card.querySelectorAll('.week-panel'), {
            opacity: 0, y: 20, scale: 0.9, duration: 0.5, ease: 'back.out(1.6)', stagger: 0.07
          });
          card.querySelectorAll('.week-ring-fill').forEach((c, i) => animateWeekRing(c, 0.2 + i * 0.06));
        }
      });
    });
  });
})();


</script>

@endpush