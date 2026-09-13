@extends('index')

@section('title', 'SEO Reports')

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/seo-reports.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


<style>
    /* ==========================================================================
   Code Sparrow — SEO Reports Module
   Design system: Linear × Stripe × Notion × Vercel, tuned to brand tokens.
   ========================================================================== */

:root{
  /* ---- Brand ---- */
  --cs-charcoal: #222222;
  --cs-teal: #1D9AA6;
  --cs-teal-dark: #167179;
  --cs-emerald: #10B981;
  --cs-blue: #2563EB;
  --cs-amber: #F59E0B;
  --cs-red: #EF4444;

  /* ---- Surfaces ---- */
  --cs-bg: #F7F9FC;
  --cs-card: #FFFFFF;
  --cs-border: #EAEDF3;
  --cs-border-strong: #DEE3EC;

  /* ---- Text ---- */
  --cs-text-primary: #16181D;
  --cs-text-secondary: #5B6472;
  --cs-text-muted: #99A1AF;
  --cs-text-on-dark: #F5F7FA;

  /* ---- Radius / shadow ---- */
  --cs-radius-lg: 18px;
  --cs-radius-md: 14px;
  --cs-radius-sm: 10px;
  --cs-radius-pill: 999px;

  --cs-shadow-xs: 0 1px 2px rgba(16, 24, 40, .04);
  --cs-shadow-sm: 0 2px 8px rgba(16, 24, 40, .06);
  --cs-shadow-md: 0 8px 24px rgba(16, 24, 40, .08);
  --cs-shadow-lg: 0 20px 48px rgba(16, 24, 40, .12);
  --cs-shadow-teal-glow: 0 8px 28px rgba(29, 154, 166, .28);

  /* ---- Motion ---- */
  --cs-ease: cubic-bezier(.22, 1, .36, 1);
  --cs-duration: .6s;

  /* ---- Type ---- */
  --cs-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Dark mode variable overrides — toggled via [data-theme="dark"] on <html> */
[data-theme="dark"]{
  --cs-bg: #0E1116;
  --cs-card: #161A21;
  --cs-border: #262B34;
  --cs-border-strong: #333A46;
  --cs-text-primary: #F1F3F7;
  --cs-text-secondary: #9AA3B2;
  --cs-text-muted: #6B7383;
  --cs-shadow-xs: 0 1px 2px rgba(0, 0, 0, .3);
  --cs-shadow-sm: 0 2px 10px rgba(0, 0, 0, .35);
  --cs-shadow-md: 0 10px 28px rgba(0, 0, 0, .4);
  --cs-shadow-lg: 0 24px 56px rgba(0, 0, 0, .5);
}

/* ==========================================================================
   Base
   ========================================================================== */

.cs-scope{
  font-family: var(--cs-font);
  color: var(--cs-text-primary);
  /* background: var(--cs-bg); */
  font-weight: 500;
  -webkit-font-smoothing: antialiased;
}

.cs-scope h1, .cs-scope h2, .cs-scope h3,
.cs-scope h4, .cs-scope h5, .cs-scope h6{
  font-weight: 700;
  letter-spacing: -0.02em;
  color: var(--cs-text-primary);
}

.cs-scope .text-muted{ color: var(--cs-text-secondary) !important; }

.cs-scope a{ text-decoration: none; }

.cs-scope :focus-visible{
  outline: 2px solid var(--cs-teal);
  outline-offset: 2px;
  border-radius: 6px;
}

/* ==========================================================================
   Page header
   ========================================================================== */

.cs-page-header{
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 32px;
}

.cs-eyebrow{
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--cs-teal);
  margin-bottom: 8px;
}

.cs-eyebrow::before{
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--cs-teal);
  box-shadow: 0 0 0 4px rgba(29,154,166,.15);
}

.cs-page-title{
  font-size: 28px;
  margin-bottom: 4px;
}

.cs-page-subtitle{
  color: var(--cs-text-secondary);
  font-size: 15px;
  margin: 0;
}

/* Breadcrumb */
.cs-breadcrumb{
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: var(--cs-text-muted);
  margin-bottom: 18px;
}
.cs-breadcrumb a{ color: var(--cs-text-secondary); font-weight: 600; }
.cs-breadcrumb a:hover{ color: var(--cs-teal); }
.cs-breadcrumb .cs-current{ color: var(--cs-text-primary); font-weight: 600; }
.cs-breadcrumb i{ font-size: 10px; opacity: .6; }

/* ==========================================================================
   Summary analytics cards
   ========================================================================== */

.cs-summary-grid{
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 36px;
}

@media (max-width: 991px){
  .cs-summary-grid{ grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 575px){
  .cs-summary-grid{ grid-template-columns: 1fr; }
}

.cs-stat-card{
  background: var(--cs-card);
  border: 1px solid var(--cs-border);
  border-radius: var(--cs-radius-lg);
  padding: 22px 24px;
  box-shadow: var(--cs-shadow-xs);
  position: relative;
  overflow: hidden;
  transition: transform .35s var(--cs-ease), box-shadow .35s var(--cs-ease), border-color .35s var(--cs-ease);
}

.cs-stat-card::after{
  content: '';
  position: absolute;
  top: 0; right: 0;
  width: 90px; height: 90px;
  background: radial-gradient(circle at top right, var(--cs-stat-accent, var(--cs-teal)) 0%, transparent 70%);
  opacity: .10;
  pointer-events: none;
}

.cs-stat-card:hover{
  transform: translateY(-3px);
  box-shadow: var(--cs-shadow-md);
  border-color: var(--cs-border-strong);
}

.cs-stat-top{
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}

.cs-stat-icon{
  width: 40px; height: 40px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px;
  background: color-mix(in srgb, var(--cs-stat-accent, var(--cs-teal)) 12%, transparent);
  color: var(--cs-stat-accent, var(--cs-teal));
}

.cs-stat-label{
  font-size: 13px;
  font-weight: 600;
  color: var(--cs-text-secondary);
}

.cs-stat-value{
  font-size: 32px;
  font-weight: 700;
  line-height: 1;
  letter-spacing: -0.02em;
  margin-bottom: 12px;
}

.cs-stat-value .cs-suffix{
  font-size: 18px;
  color: var(--cs-text-muted);
  font-weight: 600;
  margin-left: 2px;
}

/* Animated progress bar (used in stat card + package cards) */
.cs-progress{
  width: 100%;
  height: 8px;
  border-radius: var(--cs-radius-pill);
  background: var(--cs-border);
  overflow: hidden;
}

.cs-progress-bar{
  height: 100%;
  width: 0%;
  border-radius: var(--cs-radius-pill);
  background: linear-gradient(90deg, var(--cs-teal), var(--cs-emerald));
  transition: width 1.1s var(--cs-ease);
  position: relative;
}

.cs-progress-bar::after{
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.5), transparent);
  width: 40px;
  animation: cs-progress-shimmer 1.8s ease-in-out infinite;
}

@keyframes cs-progress-shimmer{
  0%{ transform: translateX(-40px); }
  100%{ transform: translateX(220px); }
}

/* ==========================================================================
   Filter bar
   ========================================================================== */

.cs-filter-bar{
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
  justify-content: flex-end;
  margin-bottom: 28px;
}

.cs-filter-bar .cs-search{
  position: relative;
  flex: 1 1 220px;
  max-width: 280px;
}

.cs-filter-bar .cs-search input{
  width: 100%;
  padding: 10px 14px 10px 38px;
  border-radius: var(--cs-radius-sm);
  border: 1px solid var(--cs-border);
  background: var(--cs-card);
  font-size: 14px;
  font-weight: 500;
  color: var(--cs-text-primary);
  transition: border-color .2s, box-shadow .2s;
}
.cs-filter-bar .cs-search input:focus{
  outline: none;
  border-color: var(--cs-teal);
  box-shadow: 0 0 0 3px rgba(29,154,166,.14);
}
.cs-filter-bar .cs-search i{
  position: absolute;
  left: 13px; top: 50%; transform: translateY(-50%);
  color: var(--cs-text-muted);
  font-size: 13px;
}

.cs-select{
  padding: 10px 32px 10px 14px;
  border-radius: var(--cs-radius-sm);
  border: 1px solid var(--cs-border);
  background: var(--cs-card) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%235B6472' stroke-width='1.5' fill='none' fill-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 14px center;
  appearance: none;
  -webkit-appearance: none;
  font-size: 14px;
  font-weight: 600;
  color: var(--cs-text-primary);
  cursor: pointer;
  transition: border-color .2s, box-shadow .2s;
}
.cs-select:focus{
  outline: none;
  border-color: var(--cs-teal);
  box-shadow: 0 0 0 3px rgba(29,154,166,.14);
}

/* ==========================================================================
   Package card
   ========================================================================== */

.cs-package-card{
  background: var(--cs-card);
  border: 1px solid var(--cs-border);
  border-radius: var(--cs-radius-lg);
  box-shadow: var(--cs-shadow-sm);
  margin-bottom: 28px;
  overflow: hidden;
  opacity: 0;
  transition: box-shadow .35s var(--cs-ease), border-color .35s var(--cs-ease);
}

.cs-package-card:hover{
  box-shadow: var(--cs-shadow-md);
}

.cs-package-head{
  padding: 26px 28px;
  border-bottom: 1px solid var(--cs-border);
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 20px;
  background:
    radial-gradient(700px 140px at 0% 0%, rgba(29,154,166,.05), transparent 60%);
}

.cs-package-identity{ min-width: 240px; }

.cs-package-name{
  font-size: 19px;
  margin-bottom: 6px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.cs-package-icon{
  width: 34px; height: 34px;
  border-radius: 10px;
  background: linear-gradient(135deg, var(--cs-charcoal), var(--cs-teal));
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
}

.cs-package-client{
  font-size: 13.5px;
  color: var(--cs-text-secondary);
}
.cs-package-client strong{ color: var(--cs-text-primary); font-weight: 600; }

.cs-duration{
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: var(--cs-text-secondary);
  font-weight: 600;
}
.cs-duration .cs-date-pill{
  background: var(--cs-bg);
  border: 1px solid var(--cs-border);
  border-radius: var(--cs-radius-pill);
  padding: 5px 12px;
  color: var(--cs-text-primary);
}
.cs-duration i{ color: var(--cs-text-muted); font-size: 11px; }

.cs-status-badge{
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: var(--cs-radius-pill);
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .03em;
  text-transform: uppercase;
  white-space: nowrap;
}
.cs-status-badge .cs-dot{
  width: 6px; height: 6px;
  border-radius: 50%;
  background: currentColor;
}
.cs-status-badge.is-active{
  background: rgba(16,185,129,.12);
  color: var(--cs-emerald);
}
.cs-status-badge.is-active .cs-dot{
  animation: cs-pulse 1.6s ease-in-out infinite;
}
.cs-status-badge.is-completed{
  background: rgba(37,99,235,.10);
  color: var(--cs-blue);
}
.cs-status-badge.is-paused,
.cs-status-badge.is-pending{
  background: rgba(245,158,11,.12);
  color: var(--cs-amber);
}
.cs-status-badge.is-cancelled,
.cs-status-badge.is-expired{
  background: rgba(239,68,68,.10);
  color: var(--cs-red);
}

@keyframes cs-pulse{
  0%, 100%{ box-shadow: 0 0 0 0 rgba(16,185,129,.45); }
  50%{ box-shadow: 0 0 0 5px rgba(16,185,129,0); }
}

.cs-package-body{
  padding: 24px 28px 28px;
}

/* Package metrics row */
.cs-metrics-row{
  display: grid;
  grid-template-columns: 1.4fr .7fr .8fr .8fr;
  gap: 24px;
  align-items: center;
  margin-bottom: 22px;
}
@media (max-width: 767px){
  .cs-metrics-row{ grid-template-columns: 1fr 1fr; row-gap: 18px; }
}

.cs-progress-block .cs-progress-label{
  display: flex;
  justify-content: space-between;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--cs-text-secondary);
  margin-bottom: 8px;
}
.cs-progress-block .cs-progress-pct{
  font-size: 13px;
  font-weight: 700;
  color: var(--cs-text-primary);
}

.cs-mini-metric{ text-align: center; }
.cs-mini-metric .cs-mini-value{
  font-size: 24px;
  font-weight: 700;
  line-height: 1;
  margin-bottom: 4px;
}
.cs-mini-metric .cs-mini-label{
  font-size: 11.5px;
  font-weight: 600;
  color: var(--cs-text-muted);
  text-transform: uppercase;
  letter-spacing: .04em;
}
.cs-mini-metric.is-completed .cs-mini-value{ color: var(--cs-emerald); }
.cs-mini-metric.is-pending .cs-mini-value{ color: var(--cs-amber); }

/* ==========================================================================
   Report cards grid
   ========================================================================== */

.cs-report-grid{
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 16px;
}

.cs-report-card{
  background: var(--cs-card);
  border: 1px solid var(--cs-border);
  border-radius: var(--cs-radius-md);
  padding: 18px;
  opacity: 0;
  transition: transform .3s var(--cs-ease), box-shadow .3s var(--cs-ease), border-color .3s var(--cs-ease);
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.cs-report-card:hover{
  transform: translateY(-4px) scale(1.03);
  box-shadow: var(--cs-shadow-md);
  border-color: transparent;
}

.cs-report-top{
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
}

.cs-report-check{
  width: 32px; height: 32px;
  border-radius: 50%;
  background: rgba(16,185,129,.12);
  color: var(--cs-emerald);
  display: flex; align-items: center; justify-content: center;
  font-size: 14px;
  transition: transform .3s var(--cs-ease);
}
.cs-report-card:hover .cs-report-check{ transform: scale(1.12) rotate(-4deg); }

.cs-report-date{
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 2px;
}
.cs-report-day{
  font-size: 12.5px;
  color: var(--cs-text-muted);
  font-weight: 600;
}

/* Gradient shine "View Report" button */
.cs-btn-view{
  position: relative;
  overflow: hidden;
  width: 100%;
  border: none;
  padding: 11px 16px;
  border-radius: var(--cs-radius-sm);
  background: linear-gradient(100deg, var(--cs-charcoal) 0%, var(--cs-teal-dark) 55%, var(--cs-teal) 100%);
  background-size: 220% 100%;
  background-position: 0% 0%;
  color: #fff;
  font-weight: 700;
  font-size: 13.5px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  text-decoration: none;
  transition: background-position .5s var(--cs-ease), box-shadow .3s var(--cs-ease), transform .2s var(--cs-ease);
}
.cs-btn-view i{ transition: transform .3s var(--cs-ease); font-size: 12px; }
.cs-btn-view:hover{
  background-position: 100% 0%;
  box-shadow: var(--cs-shadow-teal-glow);
  color: #fff;
  transform: translateY(-1px);
}
.cs-btn-view:hover i{ transform: translateX(3px); }
.cs-btn-view::before{
  content: '';
  position: absolute;
  top: 0; left: -60%;
  width: 40%; height: 100%;
  background: linear-gradient(120deg, transparent, rgba(255,255,255,.35), transparent);
  transform: skewX(-20deg);
  transition: left .7s ease;
}
.cs-btn-view:hover::before{ left: 130%; }

/* ==========================================================================
   Empty state
   ========================================================================== */

.cs-empty-state{
  text-align: center;
  padding: 72px 24px;
  background: var(--cs-card);
  border: 1px dashed var(--cs-border-strong);
  border-radius: var(--cs-radius-lg);
}
.cs-empty-state svg{ width: 140px; height: auto; margin-bottom: 18px; }
.cs-empty-state h5{ margin-bottom: 6px; }
.cs-empty-state p{ color: var(--cs-text-secondary); font-size: 14px; margin: 0; }

/* ==========================================================================
   Report Detail — Hero
   ========================================================================== */

.cs-detail-hero{
  background: linear-gradient(135deg, var(--cs-charcoal) 0%, #1a3d40 55%, var(--cs-teal-dark) 100%);
  border-radius: var(--cs-radius-lg);
  padding: 34px 32px;
  color: var(--cs-text-on-dark);
  margin-bottom: 28px;
  position: relative;
  overflow: hidden;
}
.cs-detail-hero::before{
  content: '';
  position: absolute;
  width: 340px; height: 340px;
  right: -80px; top: -140px;
  background: radial-gradient(circle, rgba(29,154,166,.35), transparent 70%);
}
.cs-detail-hero-top{
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 20px;
  position: relative;
  z-index: 1;
}
.cs-detail-hero .cs-package-name{ color: #fff; font-size: 22px; }
.cs-detail-hero .cs-package-client{ color: rgba(255,255,255,.72); }
.cs-detail-hero .cs-package-icon{ background: rgba(255,255,255,.14); }

.cs-hero-stats{
  display: flex;
  gap: 34px;
  margin-top: 22px;
  flex-wrap: wrap;
  position: relative;
  z-index: 1;
}
.cs-hero-stat .cs-hero-stat-value{
  font-size: 26px;
  font-weight: 700;
}
.cs-hero-stat .cs-hero-stat-label{
  font-size: 12px;
  font-weight: 600;
  color: rgba(255,255,255,.6);
  text-transform: uppercase;
  letter-spacing: .04em;
}

/* Detail stat cards row */
.cs-detail-stats-grid{
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
  margin-bottom: 28px;
}
@media (max-width: 991px){ .cs-detail-stats-grid{ grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 575px){ .cs-detail-stats-grid{ grid-template-columns: repeat(2, 1fr); } }

/* Task table */
.cs-table-card{
  background: var(--cs-card);
  border: 1px solid var(--cs-border);
  border-radius: var(--cs-radius-lg);
  overflow: hidden;
  box-shadow: var(--cs-shadow-xs);
  margin-bottom: 28px;
}
.cs-table-card .cs-table-header{
  padding: 20px 24px;
  border-bottom: 1px solid var(--cs-border);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.cs-task-table{
  width: 100%;
  border-collapse: collapse;
  font-size: 13.5px;
}
.cs-task-table thead th{
  text-align: left;
  padding: 12px 24px;
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .04em;
  color: var(--cs-text-muted);
  background: var(--cs-bg);
  border-bottom: 1px solid var(--cs-border);
  white-space: nowrap;
}
.cs-task-table tbody td{
  padding: 16px 24px;
  border-bottom: 1px solid var(--cs-border);
  vertical-align: top;
  color: var(--cs-text-primary);
}
.cs-task-table tbody tr{ transition: background .2s; }
.cs-task-table tbody tr:hover{ background: var(--cs-bg); }
.cs-task-table tbody tr:last-child td{ border-bottom: none; }

.cs-task-name{ font-weight: 600; }

.cs-task-status{
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: var(--cs-radius-pill);
  font-size: 11.5px;
  font-weight: 700;
}
.cs-task-status.is-completed{ background: rgba(16,185,129,.12); color: var(--cs-emerald); }
.cs-task-status.is-pending{ background: rgba(245,158,11,.12); color: var(--cs-amber); }
.cs-task-status.is-inprogress{ background: rgba(37,99,235,.10); color: var(--cs-blue); }

.cs-link-pill{
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 12px;
  border-radius: var(--cs-radius-pill);
  background: rgba(37,99,235,.08);
  color: var(--cs-blue);
  font-weight: 600;
  font-size: 12.5px;
  max-width: 200px;
}
.cs-link-pill span{ overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.cs-link-pill:hover{ background: rgba(37,99,235,.14); color: var(--cs-blue); }

.cs-attach-actions{ display: flex; gap: 6px; }
.cs-icon-btn{
  width: 30px; height: 30px;
  border-radius: 8px;
  border: 1px solid var(--cs-border);
  background: var(--cs-card);
  display: flex; align-items: center; justify-content: center;
  color: var(--cs-text-secondary);
  font-size: 12px;
  transition: all .2s;
}
.cs-icon-btn:hover{ background: var(--cs-teal); border-color: var(--cs-teal); color: #fff; }

.cs-remark{
  max-width: 220px;
  font-size: 13px;
  color: var(--cs-text-secondary);
}
.cs-remark-toggle{
  color: var(--cs-teal);
  font-weight: 600;
  font-size: 12px;
  cursor: pointer;
  display: inline-block;
  margin-top: 2px;
}

/* Timeline */
.cs-timeline-card{
  background: var(--cs-card);
  border: 1px solid var(--cs-border);
  border-radius: var(--cs-radius-lg);
  padding: 26px 28px;
  box-shadow: var(--cs-shadow-xs);
}
.cs-timeline{
  position: relative;
  padding-left: 32px;
}
.cs-timeline::before{
  content: '';
  position: absolute;
  left: 9px; top: 6px; bottom: 6px;
  width: 2px;
  background: var(--cs-border);
}
.cs-timeline-item{
  position: relative;
  padding-bottom: 26px;
}
.cs-timeline-item:last-child{ padding-bottom: 0; }
.cs-timeline-dot{
  position: absolute;
  left: -32px; top: 2px;
  width: 20px; height: 20px;
  border-radius: 50%;
  background: var(--cs-card);
  border: 2px solid var(--cs-border-strong);
  display: flex; align-items: center; justify-content: center;
  font-size: 9px;
  color: var(--cs-text-muted);
}
.cs-timeline-item.is-done .cs-timeline-dot{
  border-color: var(--cs-emerald);
  background: var(--cs-emerald);
  color: #fff;
}
.cs-timeline-item.is-current .cs-timeline-dot{
  border-color: var(--cs-teal);
  color: var(--cs-teal);
  box-shadow: 0 0 0 4px rgba(29,154,166,.15);
}
.cs-timeline-title{ font-weight: 700; font-size: 14px; margin-bottom: 2px; }
.cs-timeline-meta{ font-size: 12px; color: var(--cs-text-muted); }

/* ==========================================================================
   Counter (used by GSAP / JS number animation)
   ========================================================================== */
.cs-counter{ font-variant-numeric: tabular-nums; }

/* ==========================================================================
   Modal (image / PDF preview)
   ========================================================================== */
.cs-preview-modal .modal-content{
  border-radius: var(--cs-radius-lg);
  border: none;
  overflow: hidden;
}
.cs-preview-modal .modal-header{
  border-bottom: 1px solid var(--cs-border);
  padding: 16px 22px;
}
.cs-preview-modal .modal-body{
  padding: 0;
  background: #0E1116;
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
.cs-preview-modal .modal-body img{
  max-width: 100%; max-height: 78vh; display: block; margin: auto;
}
.cs-preview-modal .modal-body iframe{
  width: 100%; height: 78vh; border: none;
}

/* ==========================================================================
   Reduced motion
   ========================================================================== */
@media (prefers-reduced-motion: reduce){
  .cs-scope *{ animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; }
}
</style>
@endpush

@section('content')

<div class="cs-scope">

    {{-- Page header --}}
    <div class="cs-page-header">
        <div>
            <span class="cs-eyebrow">Client Delivery</span>
            <h1 class="cs-page-title">SEO Reports</h1>
            <p class="cs-page-subtitle">View completed SEO reports package wise.</p>
        </div>
    </div>

    {{-- Top summary analytics --}}
    <div class="cs-summary-grid">

        <div class="cs-stat-card" style="--cs-stat-accent: var(--cs-teal);">
            <div class="cs-stat-top">
                <span class="cs-stat-label">Total Packages</span>
                <span class="cs-stat-icon"><i class="fa-solid fa-layer-group"></i></span>
            </div>
            <div class="cs-stat-value"><span class="cs-counter" data-count="{{ $totalPackages }}">0</span></div>
            <div class="cs-progress"><div class="cs-progress-bar" data-progress="100" style="background:linear-gradient(90deg,var(--cs-teal),var(--cs-teal-dark));"></div></div>
        </div>

        <div class="cs-stat-card" style="--cs-stat-accent: var(--cs-emerald);">
            <div class="cs-stat-top">
                <span class="cs-stat-label">Completed Tasks</span>
                <span class="cs-stat-icon"><i class="fa-solid fa-circle-check"></i></span>
            </div>
            <div class="cs-stat-value"><span class="cs-counter" data-count="{{ $completedReports }}">0</span></div>
            <div class="cs-progress"><div class="cs-progress-bar" data-progress="{{ ($completedReports + $pendingReports) ? round($completedReports / ($completedReports + $pendingReports) * 100) : 0 }}" style="background:linear-gradient(90deg,var(--cs-emerald),#059669);"></div></div>
        </div>

        <div class="cs-stat-card" style="--cs-stat-accent: var(--cs-amber);">
            <div class="cs-stat-top">
                <span class="cs-stat-label">Pending Tasks</span>
                <span class="cs-stat-icon"><i class="fa-solid fa-hourglass-half"></i></span>
            </div>
            <div class="cs-stat-value"><span class="cs-counter" data-count="{{ $pendingReports }}">0</span></div>
            <div class="cs-progress"><div class="cs-progress-bar" data-progress="{{ ($completedReports + $pendingReports) ? round($pendingReports / ($completedReports + $pendingReports) * 100) : 0 }}" style="background:linear-gradient(90deg,var(--cs-amber),#D97706);"></div></div>
        </div>

        <div class="cs-stat-card" style="--cs-stat-accent: var(--cs-blue);">
            <div class="cs-stat-top">
                <span class="cs-stat-label">Overall Progress</span>
                <span class="cs-stat-icon"><i class="fa-solid fa-gauge-high"></i></span>
            </div>
            <div class="cs-stat-value"><span class="cs-counter" data-count="{{ $overallProgress }}">0</span><span class="cs-suffix">%</span></div>
            <div class="cs-progress"><div class="cs-progress-bar" data-progress="{{ $overallProgress }}"></div></div>
        </div>

    </div>

    {{-- Filter bar --}}
    <div class="cs-filter-bar">
        <select class="cs-select" id="csFilterPackage">
            <option value="">All Packages</option>
            @foreach($planClients as $planClient)
                <option value="pkg-{{ $planClient->id }}">{{ $planClient->seoPlan->name }}</option>
            @endforeach
        </select>

        <select class="cs-select" id="csFilterMonth">
            <option value="">All Months</option>
            @php
                $months = $planClients
                    ->flatMap(fn($p) => $p->reports->map(fn($r) => \Carbon\Carbon::parse($r->work_date)->format('Y-m')))
                    ->unique()
                    ->sortDesc();
            @endphp
            @foreach($months as $month)
                <option value="{{ $month }}">{{ \Carbon\Carbon::parse($month.'-01')->format('F Y') }}</option>
            @endforeach
        </select>

        <select class="cs-select" id="csFilterStatus">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="completed">Completed</option>
            <option value="paused">Paused</option>
        </select>

        <div class="cs-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="csFilterSearch" placeholder="Search report date…">
        </div>
    </div>

    {{-- Package cards --}}
    @forelse($planClients as $planClient)

        @php
            $statusKey = strtolower($planClient->status);
        @endphp

        <div class="cs-package-card" data-package-id="pkg-{{ $planClient->id }}" data-status="{{ $statusKey }}">

            <div class="cs-package-head">
                <div class="cs-package-identity">
                    <div class="cs-package-name">
                        <span class="cs-package-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></span>
                        {{ $planClient->seoPlan->name }}
                    </div>
                    <div class="cs-package-client">Client: <strong>{{ $planClient->company->name ?? '—' }}</strong></div>
                </div>

                <div class="d-flex flex-column align-items-end gap-2">
                    <div>
                       <span class="cs-status-badge is-{{ $statusKey }}">
                          <span class="cs-dot"></span> {{ ucfirst($planClient->status) }}

                          
                      </span>

                      
                        <a href="{{ route('seo.dashboard', $planClient->id) }}">
                          <button class="btn btn-warning btn-sm" style="border-radius: 20px;">
                            Analyse Dashboard
                            </button>
                        </a>
                      


                    </div>
                   
                    <div class="cs-duration">
                        <span class="cs-date-pill">{{ \Carbon\Carbon::parse($planClient->start_date)->format('d M Y') }}</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                        <span class="cs-date-pill">{{ \Carbon\Carbon::parse($planClient->end_date)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="cs-package-body">

                <div class="cs-metrics-row">
                    <div class="cs-progress-block">
                        <div class="cs-progress-label">
                            <span>Progress</span>
                            <span class="cs-progress-pct"><span class="cs-counter" data-count="{{ $planClient->progress }}">0</span>%</span>
                        </div>
                        <div class="cs-progress"><div class="cs-progress-bar" data-progress="{{ $planClient->progress }}"></div></div>
                    </div>
                    <div class="cs-mini-metric">
                        <div class="cs-mini-value"><span class="cs-counter" data-count="{{ $planClient->total_reports }}">0</span></div>
                        <div class="cs-mini-label">Total Reports</div>
                    </div>
                    <div class="cs-mini-metric is-completed">
                        <div class="cs-mini-value"><span class="cs-counter" data-count="{{ $planClient->completed_reports }}">0</span></div>
                        <div class="cs-mini-label">Completed</div>
                    </div>
                    <div class="cs-mini-metric is-pending">
                        <div class="cs-mini-value"><span class="cs-counter" data-count="{{ $planClient->pending_reports }}">0</span></div>
                        <div class="cs-mini-label">Pending</div>
                    </div>
                </div>

                @if($planClient->reports->count())
                    <div class="cs-report-grid">
                        @foreach($planClient->reports as $report)
                            @php
                                $workDate = \Carbon\Carbon::parse($report->work_date);
                            @endphp
                            <div class="cs-report-card"
                                 data-month="{{ $workDate->format('Y-m') }}"
                                 data-date-label="{{ strtolower($workDate->format('d M Y l')) }}">
                                <div class="cs-report-top">
                                    <div>
                                        <div class="cs-report-date">{{ $workDate->format('d M Y') }}</div>
                                        <div class="cs-report-day">{{ $workDate->format('l') }}</div>
                                    </div>
                                    <span class="cs-report-check"><i class="fa-solid fa-check"></i></span>
                                </div>
                                <a href="{{ route('admin.vendor.seo.report.show', [$planClient->id, $report->work_date]) }}"
                                   class="cs-btn-view">
                                    View Report <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="cs-empty-state">
                        <svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="30" y="30" width="140" height="90" rx="14" fill="var(--cs-bg)" stroke="var(--cs-border-strong)" stroke-width="2"/>
                            <circle cx="100" cy="70" r="22" fill="rgba(29,154,166,.1)"/>
                            <path d="M91 70l6 6 12-13" stroke="var(--cs-teal)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="50" y="112" width="100" height="6" rx="3" fill="var(--cs-border)"/>
                        </svg>
                        <h5>No reports available</h5>
                        <p>Reports for this package will appear here once submitted.</p>
                    </div>
                @endif

            </div>
        </div>

    @empty

        <div class="cs-empty-state">
            <svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="30" y="30" width="140" height="90" rx="14" fill="var(--cs-bg)" stroke="var(--cs-border-strong)" stroke-width="2"/>
                <circle cx="100" cy="70" r="22" fill="rgba(29,154,166,.1)"/>
                <path d="M91 70l6 6 12-13" stroke="var(--cs-teal)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="50" y="112" width="100" height="6" rx="3" fill="var(--cs-border)"/>
            </svg>
            <h5>No active SEO package found</h5>
            <p>Once a package is assigned, its reports will show up here.</p>
        </div>

    @endforelse

    <div class="cs-empty-state" id="csFilterEmptyState" style="display:none;">
        <svg viewBox="0 0 200 140" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="30" y="30" width="140" height="90" rx="14" fill="var(--cs-bg)" stroke="var(--cs-border-strong)" stroke-width="2"/>
            <circle cx="100" cy="70" r="22" fill="rgba(29,154,166,.1)"/>
            <path d="M91 70l6 6 12-13" stroke="var(--cs-teal)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <rect x="50" y="112" width="100" height="6" rx="3" fill="var(--cs-border)"/>
        </svg>
        <h5>No reports found</h5>
        <p>Try adjusting your filters or search term.</p>
    </div>

</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="{{ asset('js/seo-reports.js') }}"></script>

<script>
/**
 * Code Sparrow — SEO Reports Module
 * Vanilla JS + GSAP. No jQuery.
 * Covers: page-load stagger, counters, animated progress bars,
 * package/report filtering, remarks expand, attachment preview modal.
 */

(function () {
  'use strict';

  var hasGSAP = typeof window.gsap !== 'undefined';

  document.addEventListener('DOMContentLoaded', function () {
    initPageAnimations();
    initCounters();
    initProgressBars();
    initFilters();
    initRemarkToggles();
    initAttachmentPreview();
    initReportCardStagger();
  });

  /* ----------------------------------------------------------------
   * Page load: fade-up stagger for stat cards + package cards
   * ---------------------------------------------------------------- */
  function initPageAnimations() {
    var statCards = document.querySelectorAll('.cs-stat-card');
    var packageCards = document.querySelectorAll('.cs-package-card');

    if (hasGSAP) {
      gsap.to(statCards, {
        opacity: 1,
        y: 0,
        duration: 0.6,
        stagger: 0.05,
        ease: 'power2.out',
        clearProps: 'transform'
      });
      gsap.fromTo(statCards, { y: 24 }, {
        y: 0, duration: 0.6, stagger: 0.05, ease: 'power2.out'
      });

      gsap.fromTo(packageCards, { opacity: 0, y: 28 }, {
        opacity: 1, y: 0, duration: 0.6, stagger: 0.05, ease: 'power2.out', delay: 0.15
      });
    } else {
      // Graceful fallback without GSAP
      statCards.forEach(function (el, i) {
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        el.style.transitionDelay = (i * 0.05) + 's';
        requestAnimationFrame(function () {
          el.style.opacity = 1;
          el.style.transform = 'translateY(0)';
        });
      });
      packageCards.forEach(function (el, i) {
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        el.style.transitionDelay = (0.15 + i * 0.05) + 's';
        requestAnimationFrame(function () {
          el.style.opacity = 1;
          el.style.transform = 'translateY(0)';
        });
      });
    }
  }

  /* Stagger reveal for report cards inside each package (also re-run on filter) */
  function initReportCardStagger(scope) {
    var root = scope || document;
    var groups = root.querySelectorAll('.cs-report-grid');

    groups.forEach(function (grid) {
      var cards = grid.querySelectorAll('.cs-report-card');
      if (hasGSAP) {
        gsap.fromTo(cards, { opacity: 0, y: 18 }, {
          opacity: 1, y: 0, duration: 0.5, stagger: 0.04, ease: 'power2.out', delay: 0.3
        });
      } else {
        cards.forEach(function (el, i) {
          el.style.transition = 'opacity .4s ease, transform .4s ease';
          el.style.transitionDelay = (0.2 + i * 0.04) + 's';
          requestAnimationFrame(function () {
            el.style.opacity = 1;
            el.style.transform = 'translateY(0)';
          });
        });
      }
    });
  }

  /* ----------------------------------------------------------------
   * Counter animation: count from 0 to data-count value
   * ---------------------------------------------------------------- */
  function initCounters() {
    var counters = document.querySelectorAll('.cs-counter[data-count]');

    counters.forEach(function (el) {
      var target = parseFloat(el.getAttribute('data-count')) || 0;
      var decimals = el.getAttribute('data-decimals') ? parseInt(el.getAttribute('data-decimals'), 10) : 0;
      var obj = { val: 0 };

      if (hasGSAP) {
        gsap.to(obj, {
          val: target,
          duration: 1.4,
          ease: 'power2.out',
          delay: 0.2,
          onUpdate: function () {
            el.textContent = obj.val.toFixed(decimals);
          }
        });
      } else {
        var start = null;
        var duration = 1200;
        function step(ts) {
          if (!start) start = ts;
          var progress = Math.min((ts - start) / duration, 1);
          el.textContent = (target * progress).toFixed(decimals);
          if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      }
    });
  }

  /* ----------------------------------------------------------------
   * Progress bars: animate width from 0 to data-progress %
   * ---------------------------------------------------------------- */
  function initProgressBars() {
    var bars = document.querySelectorAll('.cs-progress-bar[data-progress]');
    bars.forEach(function (bar) {
      var pct = bar.getAttribute('data-progress');
      requestAnimationFrame(function () {
        setTimeout(function () {
          bar.style.width = pct + '%';
        }, 150);
      });
    });
  }

  /* ----------------------------------------------------------------
   * Filtering: package / month / status dropdowns + search
   * ---------------------------------------------------------------- */
  function initFilters() {
    var packageSelect = document.getElementById('csFilterPackage');
    var monthSelect = document.getElementById('csFilterMonth');
    var statusSelect = document.getElementById('csFilterStatus');
    var searchInput = document.getElementById('csFilterSearch');

    if (!packageSelect && !monthSelect && !statusSelect && !searchInput) return;

    var packageCards = document.querySelectorAll('.cs-package-card');

    function applyFilters() {
      var pkgVal = packageSelect ? packageSelect.value : '';
      var monthVal = monthSelect ? monthSelect.value : '';
      var statusVal = statusSelect ? statusSelect.value : '';
      var searchVal = searchInput ? searchInput.value.trim().toLowerCase() : '';

      packageCards.forEach(function (card) {
        var cardPkg = card.getAttribute('data-package-id') || '';
        var cardStatus = (card.getAttribute('data-status') || '').toLowerCase();
        var pkgMatch = !pkgVal || pkgVal === cardPkg;
        var statusMatch = !statusVal || statusVal === cardStatus;

        var reportCards = card.querySelectorAll('.cs-report-card');
        var anyReportVisible = false;

        reportCards.forEach(function (rc) {
          var rcMonth = rc.getAttribute('data-month') || '';
          var rcDate = (rc.getAttribute('data-date-label') || '').toLowerCase();
          var monthMatch = !monthVal || monthVal === rcMonth;
          var searchMatch = !searchVal || rcDate.indexOf(searchVal) !== -1;
          var visible = monthMatch && searchMatch;
          rc.style.display = visible ? '' : 'none';
          if (visible) anyReportVisible = true;
        });

        var cardVisible = pkgMatch && statusMatch && (reportCards.length === 0 || anyReportVisible || (!monthVal && !searchVal));
        card.style.display = cardVisible ? '' : 'none';
      });

      toggleEmptyState();
    }

    function toggleEmptyState() {
      var visibleCards = Array.prototype.filter.call(packageCards, function (c) {
        return c.style.display !== 'none';
      });
      var emptyState = document.getElementById('csFilterEmptyState');
      if (emptyState) {
        emptyState.style.display = visibleCards.length === 0 ? '' : 'none';
      }
    }

    [packageSelect, monthSelect, statusSelect].forEach(function (el) {
      if (el) el.addEventListener('change', applyFilters);
    });
    if (searchInput) {
      var debounceTimer;
      searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(applyFilters, 180);
      });
    }
  }

  /* ----------------------------------------------------------------
   * Expandable remarks
   * ---------------------------------------------------------------- */
  function initRemarkToggles() {
    document.querySelectorAll('.cs-remark-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var wrapper = btn.closest('.cs-remark');
        var full = wrapper.querySelector('.cs-remark-full');
        var short = wrapper.querySelector('.cs-remark-short');
        var expanded = wrapper.classList.toggle('is-expanded');
        if (full && short) {
          full.style.display = expanded ? 'inline' : 'none';
          short.style.display = expanded ? 'none' : 'inline';
        }
        btn.textContent = expanded ? 'Show less' : 'Show more';
      });
    });
  }

  /* ----------------------------------------------------------------
   * Attachment preview modal (image / PDF)
   * ---------------------------------------------------------------- */
  function initAttachmentPreview() {
    var modalEl = document.getElementById('csPreviewModal');
    if (!modalEl) return;

    var modalBody = modalEl.querySelector('.cs-preview-body');
    var modalTitle = modalEl.querySelector('.cs-preview-title');
    var bsModal = window.bootstrap ? new bootstrap.Modal(modalEl) : null;

    document.querySelectorAll('[data-preview-url]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var url = btn.getAttribute('data-preview-url');
        var type = (btn.getAttribute('data-preview-type') || '').toLowerCase();
        var name = btn.getAttribute('data-preview-name') || 'Attachment preview';

        modalTitle.textContent = name;
        modalBody.innerHTML = '';

        if (type === 'pdf') {
          var iframe = document.createElement('iframe');
          iframe.src = url;
          modalBody.appendChild(iframe);
        } else {
          var img = document.createElement('img');
          img.src = url;
          img.alt = name;
          modalBody.appendChild(img);
        }

        if (bsModal) bsModal.show();
      });
    });
  }

  /* Expose for re-triggering animations after AJAX filter reloads, if ever needed */
  window.CSReports = {
    reanimateReportCards: initReportCardStagger
  };
})();
</script>
@endpush