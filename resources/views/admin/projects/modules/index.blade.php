@extends('index') {{-- adjust to your actual admin layout name --}}

@section('title', 'My Modules')

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    /* ============================================================
       CODE SPARROW ERP — "MY MODULES" — DESIGN TOKENS
       ============================================================ */
    :root {
        --cs-primary:        #16879A;
        --cs-primary-soft:   #E4F3F5;
        --cs-secondary:      #2DB8D2;
        --cs-accent:         #0E5C6B;
        --cs-dark:           #0F172A;
        --cs-bg:             #F8FAFC;
        --cs-card:           #FFFFFF;
        --cs-border:         #E7ECF2;
        --cs-text:           #0F172A;
        --cs-text-muted:     #64748B;
        --cs-text-faint:     #94A3B8;

        --cs-amber:  #F59E0B; --cs-amber-bg:  #FEF3C7; --cs-amber-tx:  #92400E;
        --cs-blue:   #3B82F6; --cs-blue-bg:   #DBEAFE; --cs-blue-tx:   #1D4ED8;
        --cs-purple: #8B5CF6; --cs-purple-bg: #EDE4FF; --cs-purple-tx: #6D28D9;
        --cs-green:  #22C55E; --cs-green-bg:  #DCFCE7; --cs-green-tx:  #15803D;
        --cs-red:    #EF4444; --cs-red-bg:    #FEE2E2; --cs-red-tx:    #B91C1C;
        --cs-cyan:   #2DB8D2; --cs-cyan-bg:   #DFF7FA; --cs-cyan-tx:   #0E6273;
        --cs-emerald:#10B981; --cs-emerald-bg:#D1FAE5; --cs-emerald-tx:#047857;

        --cs-radius-lg: 1.25rem;
        --cs-radius-md: 0.875rem;
        --cs-radius-sm: 0.6rem;

        --cs-shadow-xs: 0 1px 2px rgba(15,23,42,.04);
        --cs-shadow-sm: 0 2px 8px -2px rgba(15,23,42,.06), 0 1px 2px rgba(15,23,42,.04);
        --cs-shadow-md: 0 12px 28px -10px rgba(15,23,42,.12);
        --cs-shadow-lg: 0 24px 56px -18px rgba(14,92,107,.28);

        --cs-font: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --cs-mono: 'JetBrains Mono', ui-monospace, 'SFMono-Regular', Menlo, monospace;
    }

    @media (prefers-reduced-motion: reduce) {
        * { animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; scroll-behavior: auto !important; }
    }

    .csd-wrap { font-family: var(--cs-font); color: var(--cs-text);
    /* background: var(--cs-bg); */
    }
    .csd-wrap .container-fluid { padding-top: 1.5rem; padding-bottom: 3rem; }
    .csd-mono { font-family: var(--cs-mono); font-variant-numeric: tabular-nums; }
    .csd-wrap [x-cloak] { display: none !important; }

    /* ============================================================
       HERO
       ============================================================ */
    .csd-hero {
        position: relative;
        border-radius: var(--cs-radius-lg);
        padding: 2.25rem 2.5rem;
        margin-bottom: 1.75rem;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(120% 180% at 100% 0%, rgba(45,184,210,.55) 0%, transparent 55%),
            radial-gradient(90% 140% at 0% 110%, rgba(22,135,154,.55) 0%, transparent 55%),
            linear-gradient(135deg, var(--cs-dark) 0%, #0B2530 55%, var(--cs-accent) 130%);
        box-shadow: var(--cs-shadow-lg);
        border: 1px solid rgba(255,255,255,.08);
    }
    .csd-hero::before {
        content: "";
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
        background-size: 36px 36px;
        -webkit-mask-image: radial-gradient(ellipse 85% 100% at 30% 0%, #000 25%, transparent 78%);
        mask-image: radial-gradient(ellipse 85% 100% at 30% 0%, #000 25%, transparent 78%);
        pointer-events: none;
    }
    .csd-hero-row { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; gap: 1.75rem; flex-wrap: wrap; }
    .csd-hero-brand { display: flex; align-items: center; gap: .9rem; margin-bottom: 1.1rem; }
    .csd-hero-logo { height: 34px; width: auto; display: block; filter: drop-shadow(0 4px 10px rgba(0,0,0,.35)); }
    .csd-hero-brandname { font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.55); }

    .csd-hero-eyebrow { display: inline-flex; align-items: center; gap: .45rem; font-size: .7rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--cs-secondary); margin-bottom: .65rem; }
    .csd-hero-eyebrow .dot { width: 6px; height: 6px; border-radius: 50%; background: #34D399; box-shadow: 0 0 0 3px rgba(52,211,153,.25); animation: csd-pulse-dot 2s ease-in-out infinite; }
    .csd-hero h3 { font-weight: 800; font-size: clamp(1.6rem, 2.4vw, 2.15rem); letter-spacing: -.02em; margin-bottom: .4rem; }
    .csd-hero p { opacity: .68; margin-bottom: 0; font-size: .93rem; font-weight: 450; max-width: 46ch; }

    .csd-hero-side { position: relative; z-index: 1; display: flex; align-items: center; gap: 1.5rem; }
    .csd-hero-stat { text-align: right; }
    .csd-hero-stat .num { display: block; font-family: var(--cs-mono); font-weight: 700; font-size: 1.55rem; line-height: 1.1; }
    .csd-hero-stat .label { font-size: .68rem; color: rgba(255,255,255,.5); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
    .csd-hero-divider { width: 1px; height: 38px; background: rgba(255,255,255,.14); }
    .csd-hero-clock { text-align: right; }
    .csd-hero-clock .time { font-family: var(--cs-mono); font-weight: 700; font-size: 1.15rem; }
    .csd-hero-clock .date { font-size: .72rem; color: rgba(255,255,255,.5); font-weight: 500; }
    .csd-avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, var(--cs-secondary) 0%, var(--cs-primary) 100%);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .85rem; color: #fff;
        border: 2px solid rgba(255,255,255,.2);
        box-shadow: 0 4px 14px -4px rgba(45,184,210,.6);
    }
    @keyframes csd-pulse-dot { 0%,100% { opacity: 1; } 50% { opacity: .35; } }

    /* ============================================================
       KPI / STAT CARDS
       ============================================================ */
    .csd-stat-card {
        position: relative; background: var(--cs-card); border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius-md); padding: 1.15rem 1.25rem;
        display: flex; align-items: center; gap: .95rem; height: 100%;
        box-shadow: var(--cs-shadow-xs);
        transition: transform .2s cubic-bezier(.2,.8,.2,1), box-shadow .2s ease, border-color .2s ease;
        overflow: hidden;
    }
    .csd-stat-card::after {
        content: ""; position: absolute; inset: 0; border-radius: inherit; padding: 1px;
        background: linear-gradient(135deg, var(--cs-secondary), transparent 45%);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor; mask-composite: exclude;
        opacity: 0; transition: opacity .2s ease;
    }
    .csd-stat-card:hover { transform: translateY(-4px); box-shadow: var(--cs-shadow-md); }
    .csd-stat-card:hover::after { opacity: 1; }
    .csd-stat-icon {
        width: 46px; height: 46px; border-radius: .8rem; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.05rem;
        box-shadow: 0 8px 18px -6px var(--icon-shadow, rgba(22,135,154,.5));
    }
    .csd-stat-icon.i-primary  { background: linear-gradient(135deg, var(--cs-primary), var(--cs-secondary));   --icon-shadow: rgba(22,135,154,.55); }
    .csd-stat-icon.i-amber    { background: linear-gradient(135deg, #F59E0B, #FBBF24); --icon-shadow: rgba(245,158,11,.5); }
    .csd-stat-icon.i-blue     { background: linear-gradient(135deg, #3B82F6, #60A5FA); --icon-shadow: rgba(59,130,246,.5); }
    .csd-stat-icon.i-green    { background: linear-gradient(135deg, #16A34A, #4ADE80); --icon-shadow: rgba(34,197,94,.5); }
    .csd-stat-icon.i-red      { background: linear-gradient(135deg, #DC2626, #F87171); --icon-shadow: rgba(239,68,68,.5); }
    .csd-stat-num { font-family: var(--cs-mono); font-weight: 700; font-size: 1.4rem; line-height: 1; display: block; letter-spacing: -.01em; }
    .csd-stat-label { font-size: .72rem; color: var(--cs-text-muted); font-weight: 600; margin-top: .2rem; }

    /* ============================================================
       CHART PANELS
       ============================================================ */
    .csd-panel {
        background: var(--cs-card); border: 1px solid var(--cs-border); border-radius: var(--cs-radius-md);
        padding: 1.35rem 1.4rem; box-shadow: var(--cs-shadow-xs); height: 100%;
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .csd-panel:hover { box-shadow: var(--cs-shadow-md); }
    .csd-panel-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: .9rem; }
    .csd-panel-title { font-weight: 700; font-size: .92rem; color: var(--cs-text); }
    .csd-panel-sub { font-size: .74rem; color: var(--cs-text-faint); font-weight: 500; margin-top: .1rem; }
    .csd-panel-icon { width: 32px; height: 32px; border-radius: .6rem; background: var(--cs-primary-soft); color: var(--cs-primary); display: flex; align-items: center; justify-content: center; font-size: .82rem; }
    .csd-radial-center { position: relative; }
    .csd-radial-center .figure { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .csd-radial-center .figure strong { font-family: var(--cs-mono); font-size: 1.5rem; color: var(--cs-text); }
    .csd-radial-center .figure span { font-size: .66rem; text-transform: uppercase; letter-spacing: .04em; color: var(--cs-text-faint); font-weight: 700; }

    /* ============================================================
       SEGMENTED TABS (STATUS FILTER)
       ============================================================ */
    .csd-tabs {
        display: flex; flex-wrap: wrap; gap: .4rem; padding: .4rem;
        background: rgba(255,255,255,.7); backdrop-filter: blur(10px);
        border: 1px solid var(--cs-border); border-radius: 999px; box-shadow: var(--cs-shadow-xs);
        margin-bottom: 1.1rem; width: fit-content; max-width: 100%;
    }
    .csd-tab {
        position: relative; border: none; background: transparent; cursor: pointer;
        display: inline-flex; align-items: center; gap: .5rem;
        font-size: .82rem; font-weight: 700; color: var(--cs-text-muted);
        padding: .55rem 1.05rem; border-radius: 999px; white-space: nowrap;
        transition: color .2s ease;
    }
    .csd-tab i { font-size: .78rem; }
    .csd-tab .csd-tab-badge {
        font-family: var(--cs-mono); font-size: .68rem; font-weight: 700;
        background: rgba(15,23,42,.06); color: var(--cs-text-muted);
        border-radius: 999px; padding: .1rem .42rem; line-height: 1.4;
    }
    .csd-tab.is-active { color: #fff; }
    .csd-tab.is-active .csd-tab-badge { background: rgba(255,255,255,.25); color: #fff; }
    .csd-tab-indicator {
        position: absolute; top: 4px; bottom: 4px; left: 0; border-radius: 999px;
        background: linear-gradient(135deg, var(--cs-primary), var(--cs-accent));
        box-shadow: 0 6px 16px -4px rgba(22,135,154,.55);
        transition: transform .32s cubic-bezier(.2,.8,.2,1), width .32s cubic-bezier(.2,.8,.2,1);
        z-index: 0;
    }
    .csd-tab { z-index: 1; }

    /* ============================================================
       FILTER BAR
       ============================================================ */
    .csd-filter-card {
        background: rgba(255,255,255,.86); backdrop-filter: blur(14px) saturate(160%);
        -webkit-backdrop-filter: blur(14px) saturate(160%);
        border: 1px solid var(--cs-border); border-radius: var(--cs-radius-md);
        padding: 1.15rem 1.3rem; margin: 1.5rem 0; box-shadow: var(--cs-shadow-xs);
    }
    .csd-filter-card label { font-size: .71rem; font-weight: 700; color: var(--cs-text-muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: .35rem; display: block; }
    .csd-filter-card .form-control, .csd-filter-card .form-select {
        border-radius: var(--cs-radius-sm); font-size: .87rem; border-color: var(--cs-border);
        background: #FBFDFE; padding: .5rem .75rem;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .csd-filter-card .form-control:focus, .csd-filter-card .form-select:focus {
        border-color: var(--cs-primary); background: #fff; box-shadow: 0 0 0 3px rgba(22,135,154,.14);
    }
    .csd-search-wrap { position: relative; }
    .csd-search-wrap i { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--cs-text-faint); font-size: .8rem; }
    .csd-search-wrap input { padding-left: 2.1rem; }

    .csd-btn-primary {
        background: linear-gradient(135deg, var(--cs-primary), var(--cs-accent));
        border: none; color: #fff; font-weight: 600; font-size: .84rem;
        border-radius: var(--cs-radius-sm); padding: .55rem 1.1rem;
        box-shadow: 0 8px 18px -6px rgba(22,135,154,.5);
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
        position: relative; overflow: hidden;
    }
    .csd-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 12px 22px -6px rgba(22,135,154,.55); filter: brightness(1.05); color: #fff; }
    .csd-btn-primary:active { transform: translateY(0); }
    .csd-btn-ghost {
        background: #fff; border: 1px solid var(--cs-border); color: var(--cs-text-muted);
        font-weight: 600; font-size: .84rem; border-radius: var(--cs-radius-sm); padding: .55rem 1.1rem;
        transition: all .15s ease;
    }
    .csd-btn-ghost:hover { background: var(--cs-bg); color: var(--cs-text); border-color: #D8E0E8; }

    /* ripple */
    .csd-ripple { position: relative; overflow: hidden; }
    .csd-ripple span.ripple-dot {
        position: absolute; border-radius: 50%; transform: scale(0);
        background: rgba(255,255,255,.55); animation: csd-ripple .55s ease-out;
        pointer-events: none;
    }
    .csd-btn-ghost span.ripple-dot { background: rgba(22,135,154,.18); }
    @keyframes csd-ripple { to { transform: scale(2.6); opacity: 0; } }

    /* ============================================================
       MODULE CARDS
       ============================================================ */
    .mc-card {
        position: relative; background: var(--cs-card); border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius-lg); margin-bottom: 1.15rem; box-shadow: var(--cs-shadow-xs);
        display: flex; overflow: hidden;
        transition: transform .2s cubic-bezier(.2,.8,.2,1), box-shadow .2s ease, border-color .2s ease;
        opacity: 0; animation: csd-card-in .5s ease forwards;
    }
    .mc-card:hover { transform: translateY(-4px); box-shadow: var(--cs-shadow-md); border-color: #D6E4E8; }
    @keyframes csd-card-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .mc-strip { width: 5px; flex-shrink: 0; background: #316c71; }
    .mc-card.is-critical .mc-strip {
        background: linear-gradient(180deg, var(--cs-red), #F87171);
        box-shadow: 0 0 12px 1px rgba(239,68,68,.55);
        animation: csd-strip-pulse 1.8s ease-in-out infinite;
    }
    @keyframes csd-strip-pulse { 0%,100% { opacity: 1; } 50% { opacity: .55; } }

    .mc-body { padding: 1.3rem 1.45rem; flex: 1; min-width: 0; }
    .mc-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: .9rem; }
    .mc-title-wrap { display: flex; align-items: flex-start; gap: 1rem; min-width: 0; }
    .mc-icon-ring { position: relative; width: 52px; height: 52px; flex-shrink: 0; }
    .mc-icon {
        position: absolute; inset: 5px; border-radius: .7rem;
        display: flex; align-items: center; justify-content: center; font-size: .95rem; color: #2f6053;
        /* background: linear-gradient(135deg, var(--accent, var(--cs-primary)) 0%, color-mix(in srgb, var(--accent, var(--cs-primary)) 65%, white) 100%); */
    }
    .mc-name { font-weight: 700; font-size: 1.04rem; color: var(--cs-text); letter-spacing: -.01em; line-height: 1.3; }
    .mc-meta { font-size: .8rem; color: var(--cs-text-muted); margin-top: .2rem; }
    .mc-meta i { margin-right: .3rem; opacity: .75; }
    .mc-meta .sep { margin: 0 .4rem; opacity: .5; }

    .mc-req-btn {
        flex-shrink: 0; display: inline-flex; align-items: center; gap: .4rem;
        font-size: .78rem; font-weight: 700; color: var(--cs-primary);
        background: var(--cs-primary-soft); border: 1px solid #CFE9EC;
        border-radius: 999px; padding: .42rem .9rem; text-decoration: none;
        transition: all .15s ease; white-space: nowrap;
    }
    .mc-req-btn:hover { background: var(--cs-primary); color: #fff; border-color: var(--cs-primary); transform: translateY(-1px); }

    .mc-badges { display: flex; flex-wrap: wrap; gap: .4rem; margin-bottom: 1.05rem; }
    .badge-soft { border-radius: 999px; font-weight: 700; font-size: .7rem; padding: .38rem .78rem; display: inline-flex; align-items: center; gap: .35rem; letter-spacing: .01em; }
    .badge-soft .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .badge-priority-critical { background: var(--cs-red-bg);    color: var(--cs-red-tx); }
    .badge-priority-critical .dot { animation: csd-pulse-dot 1.4s ease-in-out infinite; }
    .badge-priority-high     { background: var(--cs-amber-bg);  color: var(--cs-amber-tx); }
    .badge-priority-medium   { background: var(--cs-blue-bg);   color: var(--cs-blue-tx); }
    .badge-priority-low      { background: var(--cs-green-bg);  color: var(--cs-green-tx); }

    .badge-status-pending      { background: var(--cs-amber-bg);  color: var(--cs-amber-tx); }
    .badge-status-in-progress  { background: var(--cs-blue-bg);   color: var(--cs-blue-tx); }
    .badge-status-completed    { background: var(--cs-green-bg);  color: var(--cs-green-tx); }
    .badge-status-on-hold      { background: #EEF1F6;             color: #475467; }
    .badge-status-cancelled    { background: var(--cs-red-bg);    color: var(--cs-red-tx); }
    .badge-status-testing      { background: var(--cs-purple-bg); color: var(--cs-purple-tx); }
    .badge-status-planning     { background: var(--cs-cyan-bg);   color: var(--cs-cyan-tx); }
    .badge-status-generic      { background: #EEF1F6;             color: #475467; }

    /* progress bar */
    .csd-progress-wrap { margin-bottom: 1.05rem; }
    .csd-progress-label { display: flex; justify-content: space-between; font-size: .74rem; font-weight: 700; color: var(--cs-text-muted); margin-bottom: .4rem; text-transform: uppercase; letter-spacing: .03em; }
    .csd-progress-track { position: relative; height: 20px; border-radius: 999px; background: #EEF2F6; overflow: hidden; }
    .csd-progress-fill {
        position: relative; height: 100%; border-radius: 999px; width: 0;
        background: linear-gradient(90deg, var(--cs-primary) 0%, var(--cs-secondary) 60%, #7FE0EE 100%);
        background-size: 200% 100%;
        transition: width 1.1s cubic-bezier(.16,1,.3,1);
        display: flex; align-items: center; justify-content: flex-end;
        animation: csd-progress-sheen 2.6s linear infinite;
    }
    .csd-progress-fill.pf-danger  { background: linear-gradient(90deg, var(--cs-red), #F87171 60%, #FCA5A5); }
    .csd-progress-fill.pf-warning { background: linear-gradient(90deg, var(--cs-amber), #FBBF24 60%, #FCD34D); }
    .csd-progress-fill.pf-success { background: linear-gradient(90deg, #16A34A, #22C55E 60%, #4ADE80); }
    @keyframes csd-progress-sheen { 0% { background-position: 0% 0; } 100% { background-position: 200% 0; } }
    .csd-progress-pct { font-family: var(--cs-mono); font-size: .68rem; font-weight: 700; color: #fff; padding-right: .55rem; text-shadow: 0 1px 2px rgba(0,0,0,.18); white-space: nowrap; }
    .csd-progress-pct.pct-outside { color: var(--cs-text-muted); text-shadow: none; padding-right: 0; padding-left: .5rem; }

    /* meta grid */
    .csd-meta-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: .55rem; margin-bottom: 1.1rem; }
    .csd-meta-item { text-align: center; background: var(--cs-bg); border: 1px solid var(--cs-border); border-radius: var(--cs-radius-sm); padding: .58rem .35rem; transition: background .15s ease; }
    .csd-meta-item strong { display: block; font-family: var(--cs-mono); font-size: .88rem; color: var(--cs-text); font-weight: 700; }
    .csd-meta-item span { font-size: .62rem; color: var(--cs-text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .03em; }

    .csd-card-footer { display: flex; align-items: center; justify-content: flex-end; gap: .6rem; border-top: 1px solid var(--cs-border); padding-top: 1.05rem; flex-wrap: wrap; }
    .btn-workspace {
        background: #fff; border: 1px solid var(--cs-border); color: var(--cs-text);
        font-weight: 600; font-size: .82rem; border-radius: var(--cs-radius-sm);
        padding: .52rem 1rem; display: inline-flex; align-items: center; gap: .45rem;
        transition: all .15s ease; text-decoration: none;
    }
    .btn-workspace:hover { background: var(--cs-bg); border-color: #D8E0E8; color: var(--cs-text); transform: translateY(-1px); }
    .btn-update-progress {
        background: linear-gradient(135deg, var(--cs-primary), var(--cs-accent));
        border: none; color: #fff; font-weight: 700; font-size: .84rem;
        border-radius: var(--cs-radius-sm); padding: .58rem 1.2rem;
        display: inline-flex; align-items: center; gap: .5rem;
        box-shadow: 0 10px 22px -6px rgba(22,135,154,.55);
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
        position: relative; overflow: hidden;
    }
    .btn-update-progress:hover { transform: translateY(-2px); box-shadow: 0 14px 28px -6px rgba(22,135,154,.6); filter: brightness(1.06); color: #fff; }
    .btn-update-progress:active { transform: translateY(0); }

    /* empty state */
    .csd-empty-state { text-align: center; padding: 4.5rem 1.5rem; background: radial-gradient(ellipse at center, #FBFDFE 0%, var(--cs-card) 70%); border: 1.5px dashed #D9E2EA; border-radius: var(--cs-radius-lg); }
    .csd-empty-icon { width: 84px; height: 84px; margin: 0 auto 1.25rem; border-radius: 1.25rem; background: linear-gradient(135deg, var(--cs-primary-soft), #CFEFF3); display: flex; align-items: center; justify-content: center; font-size: 2.1rem; color: var(--cs-primary); animation: csd-float 3.2s ease-in-out infinite; }
    @keyframes csd-float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }
    .csd-empty-state h5 { font-weight: 700; color: var(--cs-text); margin-bottom: .4rem; }
    .csd-empty-state p { color: var(--cs-text-muted); font-size: .9rem; max-width: 380px; margin: 0 auto 1.25rem; }

    .csd-pagination-wrap { margin-top: 1.5rem; }
    .csd-pagination-wrap .pagination { gap: .3rem; }
    .csd-pagination-wrap .page-link { border-radius: var(--cs-radius-sm) !important; border: 1px solid var(--cs-border); color: var(--cs-text); font-weight: 600; font-size: .85rem; margin: 0 !important; }
    .csd-pagination-wrap .page-item.active .page-link { background: var(--cs-primary); border-color: var(--cs-primary); }
    .csd-pagination-wrap .page-link:hover { background: var(--cs-bg); }

    /* shimmer (used while apex mounts) */
    .csd-shimmer { position: relative; overflow: hidden; background: #EEF2F6; border-radius: var(--cs-radius-sm); }
    .csd-shimmer::after { content: ""; position: absolute; inset: 0; transform: translateX(-100%); background: linear-gradient(90deg, transparent, rgba(255,255,255,.6), transparent); animation: csd-shimmer 1.4s infinite; }
    @keyframes csd-shimmer { 100% { transform: translateX(100%); } }

    @media (max-width: 991.98px) {
        .csd-hero-row { flex-direction: column; align-items: flex-start; }
        .csd-hero-side { width: 100%; justify-content: space-between; }
    }
    @media (max-width: 767.98px) {
        .csd-hero { padding: 1.6rem; }
        .csd-meta-grid { grid-template-columns: repeat(2, 1fr); }
        .csd-hero-side { flex-wrap: wrap; gap: 1rem; }
        .mc-top { flex-direction: column; }
        .mc-req-btn { align-self: flex-start; }
    }
</style>
@endpush

@section('content')
<div class="csd-wrap"
     x-data="csModulesDashboard()"
     x-init="init()">
<div class="container-fluid">

    {{-- ======================= HERO ======================= --}}
    <div class="csd-hero">
        <div class="csd-hero-row">
            <div>
                <div class="csd-hero-brand">
                    <img src="{{ asset('images/code-sparrow-logo.png') }}" alt="Code Sparrow" class="csd-hero-logo" onerror="this.style.display='none'">
                    <span class="csd-hero-brandname">Code Sparrow &middot; ERP</span>
                </div>
                <div class="csd-hero-eyebrow"><span class="dot"></span> Workspace &middot; Live</div>
                <h3>
                    @php
                        $csHour = now()->hour;
                        $csGreeting = $csHour < 12 ? 'Good morning' : ($csHour < 17 ? 'Good afternoon' : 'Good evening');
                    @endphp
                    {{ $csGreeting }}{{ auth()->check() ? ', ' . explode(' ', auth()->user()->name)[0] : '' }}
                </h3>
                <p>Here's everything assigned to you across every project, in one workspace.</p>
            </div>
            <div class="csd-hero-side">
                <div class="csd-hero-stat">
                    <span class="num csd-mono" data-count="{{ $totalAssigned }}">0</span>
                    <span class="label">Total Modules</span>
                </div>
                <div class="csd-hero-divider"></div>
                <div class="csd-hero-clock">
                    <div class="time csd-mono" id="csClockTime">--:--:--</div>
                    <div class="date" id="csClockDate">Loading date&hellip;</div>
                </div>
                @auth
                    <div class="csd-hero-divider"></div>
                    <div class="csd-avatar" title="{{ auth()->user()->name }}">
                        {{ collect(explode(' ', auth()->user()->name))->map(fn($p) => Str::substr($p, 0, 1))->take(2)->implode('') }}
                    </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- ======================= KPI STAT CARDS ======================= --}}
    <div class="row g-3">
        <div class="col-6 col-md-4 col-xl">
            <div class="csd-stat-card">
                <span class="csd-stat-icon i-primary"><i class="fa-solid fa-diagram-project"></i></span>
                <span><span class="csd-stat-num" data-count="{{ $totalAssigned }}">0</span><span class="csd-stat-label">Total Assigned</span></span>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="csd-stat-card">
                <span class="csd-stat-icon i-amber"><i class="fa-solid fa-hourglass-half"></i></span>
                <span><span class="csd-stat-num" data-count="{{ $pendingCount }}">0</span><span class="csd-stat-label">Pending</span></span>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="csd-stat-card">
                <span class="csd-stat-icon i-blue"><i class="fa-solid fa-rotate"></i></span>
                <span><span class="csd-stat-num" data-count="{{ $inProgressCount }}">0</span><span class="csd-stat-label">In Progress</span></span>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="csd-stat-card">
                <span class="csd-stat-icon i-green"><i class="fa-solid fa-circle-check"></i></span>
                <span><span class="csd-stat-num" data-count="{{ $completedCount }}">0</span><span class="csd-stat-label">Completed</span></span>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="csd-stat-card">
                <span class="csd-stat-icon i-red"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <span><span class="csd-stat-num" data-count="{{ $criticalCount }}">0</span><span class="csd-stat-label">Critical Priority</span></span>
            </div>
        </div>
    </div>

    {{-- ======================= CHARTS ======================= --}}
    @php
        // These charts are derived entirely from data already available on this
        // page ($modules, the KPI counters) — no controller/route changes.
        // Note: $modules reflects the *current page* of results, since it is a
        // paginated collection.
        $csStatusCounts = $modules->groupBy('status')->map->count();
        $csPriorityOrder = ['Critical', 'High', 'Medium', 'Low'];
        $csPriorityCounts = collect($csPriorityOrder)->mapWithKeys(fn ($p) => [$p => $modules->where('priority', $p)->count()]);
        $csAvgProgress = $modules->count() ? round($modules->avg('progress')) : 0;
        $csUpcoming = $modules->filter(fn ($m) => !empty($m->deadline))
            ->sortBy('deadline')
            ->take(6)
            ->map(fn ($m) => [
                'name' => Str::limit($m->module_name, 18),
                'days' => \Illuminate\Support\Carbon::parse($m->deadline)->diffInDays(now(), false) * -1,
            ]);
    @endphp
    <div class="row g-3 mt-1">
        <div class="col-lg-3 col-md-6">
            <div class="csd-panel">
                <div class="csd-panel-head">
                    <div>
                        <div class="csd-panel-title">Status Distribution</div>
                        <div class="csd-panel-sub">Current page</div>
                    </div>
                    <span class="csd-panel-icon"><i class="fa-solid fa-chart-pie"></i></span>
                </div>
                <div id="csChartStatus"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="csd-panel">
                <div class="csd-panel-head">
                    <div>
                        <div class="csd-panel-title">Priority Breakdown</div>
                        <div class="csd-panel-sub">Current page</div>
                    </div>
                    <span class="csd-panel-icon"><i class="fa-solid fa-layer-group"></i></span>
                </div>
                <div id="csChartPriority"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="csd-panel">
                <div class="csd-panel-head">
                    <div>
                        <div class="csd-panel-title">Avg. Completion</div>
                        <div class="csd-panel-sub">Across shown modules</div>
                    </div>
                    <span class="csd-panel-icon"><i class="fa-solid fa-bullseye"></i></span>
                </div>
                <div id="csChartCompletion"></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="csd-panel">
                <div class="csd-panel-head">
                    <div>
                        <div class="csd-panel-title">Deadline Outlook</div>
                        <div class="csd-panel-sub">Days remaining</div>
                    </div>
                    <span class="csd-panel-icon"><i class="fa-solid fa-calendar-days"></i></span>
                </div>
                <div id="csChartDeadlines"></div>
            </div>
        </div>
    </div>

    {{-- ======================= STATUS TABS (client-side filter) ======================= --}}
    <div class="csd-tabs mt-4" x-ref="tabWrap" x-cloak>
        <div class="csd-tab-indicator" :style="indicatorStyle"></div>
        <button type="button" class="csd-tab" :class="{ 'is-active': active === 'all' }" @click="setActive('all', $event)">
            <i class="fa-solid fa-border-all"></i> All <span class="csd-tab-badge">{{ $modules->count() }}</span>
        </button>
        @foreach ($statusOptions as $statusOption)
            <button type="button" class="csd-tab" :class="{ 'is-active': active === '{{ $statusOption }}' }" @click="setActive('{{ $statusOption }}', $event)">
                <i class="fa-solid {{ match($statusOption) {
                    'In Progress' => 'fa-rotate',
                    'Completed' => 'fa-circle-check',
                    'On Hold' => 'fa-pause',
                    'Cancelled' => 'fa-ban',
                    'Testing' => 'fa-flask',
                    'Planning' => 'fa-compass-drafting',
                    'Pending' => 'fa-hourglass-half',
                    default => 'fa-circle-dot',
                } }}"></i>
                {{ $statusOption }}
                <span class="csd-tab-badge">{{ $modules->where('status', $statusOption)->count() }}</span>
            </button>
        @endforeach
    </div>

    {{-- ======================= FILTERS ======================= --}}
    <div class="csd-filter-card">
        <form action="{{ route('admin.modules.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4 col-lg-3">
                    <label>Search</label>
                    <div class="csd-search-wrap">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" class="form-control" placeholder="Module or project name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach ($statusOptions as $statusOption)
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
                <div class="col-md-6 col-lg-2">
                    <label>Department</label>
                    <select name="department_id" class="form-select">
                        <option value="">All Departments</option>
                        @foreach ($departmentOptions as $department)
                            <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label>Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">All Projects</option>
                        @foreach ($projectOptions as $projectOption)
                            <option value="{{ $projectOption->id }}" @selected((string) request('project_id') === (string) $projectOption->id)>{{ $projectOption->project_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 col-lg-3">
                    <label>Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="latest" @selected(request('sort_by', 'latest') === 'latest')>Newest First</option>
                        <option value="deadline" @selected(request('sort_by') === 'deadline')>Deadline (Earliest)</option>
                        <option value="priority" @selected(request('sort_by') === 'priority')>Priority (Critical First)</option>
                        <option value="progress" @selected(request('sort_by') === 'progress')>Progress (Highest)</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                    <a href="{{ route('admin.modules.index') }}" class="csd-btn-ghost csd-ripple">
                        <i class="fa-solid fa-arrow-rotate-left me-1"></i> Reset Filters
                    </a>
                    <button type="submit" class="csd-btn-primary csd-ripple">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ======================= MODULE LIST ======================= --}}
    @if ($modules->isEmpty())
        <div class="csd-empty-state">
            <div class="csd-empty-icon"><i class="fa-solid fa-inbox"></i></div>
            <h5>No Modules Assigned</h5>
            <p>You don't have any modules assigned to you yet{{ request()->hasAny(['search', 'status', 'priority', 'department_id', 'project_id']) ? ' matching these filters' : '' }}.</p>
            @if (request()->hasAny(['search', 'status', 'priority', 'department_id', 'project_id']))
                <a href="{{ route('admin.modules.index') }}" class="csd-btn-primary csd-ripple">
                    <i class="fa-solid fa-arrow-rotate-left me-1"></i> Clear Filters
                </a>
            @endif
        </div>
    @else
        @php
            $priorityBadgeClass = fn ($priority) => match ($priority) {
                'Critical' => 'badge-priority-critical',
                'High' => 'badge-priority-high',
                'Medium' => 'badge-priority-medium',
                default => 'badge-priority-low',
            };

            $statusBadgeClass = fn ($status) => match ($status) {
                'In Progress' => 'badge-status-in-progress',
                'Completed' => 'badge-status-completed',
                'On Hold' => 'badge-status-on-hold',
                'Cancelled' => 'badge-status-cancelled',
                'Testing' => 'badge-status-testing',
                'Planning' => 'badge-status-planning',
                'Pending' => 'badge-status-pending',
                default => 'badge-status-generic',
            };

            $progressBarClass = fn ($value) => match (true) {
                $value <= 25 => 'pf-danger',
                $value <= 50 => 'pf-warning',
                $value <= 75 => '',
                default => 'pf-success',
            };
        @endphp

        <div class="row">
            @foreach ($modules as $module)
                @php
                    $latestAssignment = $module->assignments->first();
                    $assignedDate = $latestAssignment->assigned_at ?? $module->created_at;
                    $isCritical = $module->priority === 'Critical';
                @endphp

                <div class="col-xl-12" x-show="active === 'all' || active === '{{ $module->status }}'" x-transition.opacity.duration.200ms>
                    <div class="mc-card {{ $isCritical ? 'is-critical' : '' }}"
                         style="--accent: {{ $module->color ?: '#16879A' }}; animation-delay: {{ $loop->index * 0.04 }}s;">
                        <div class="mc-strip"></div>
                        <div class="mc-body">
                            <div class="mc-top">
                                <div class="mc-title-wrap">
                                    <div class="mc-icon-ring">
                                        <svg viewBox="0 0 52 52" width="52" height="52" style="position:absolute; inset:0; transform: rotate(-90deg);">
                                            <circle cx="26" cy="26" r="23" fill="none" stroke="#EEF2F6" stroke-width="4"></circle>
                                            <circle cx="26" cy="26" r="23" fill="none" stroke="{{ $module->color ?: '#16879A' }}" stroke-width="4"
                                                    stroke-linecap="round"
                                                    stroke-dasharray="144.5"
                                                    stroke-dashoffset="{{ 144.5 - (144.5 * min(100, max(0, $module->progress)) / 100) }}"></circle>
                                        </svg>
                                        <div class="mc-icon"><i class="fa-solid fa-cubes"></i></div>
                                    </div>
                                    <div>
                                        <div class="mc-name">{{ $module->module_name }}</div>
                                        <div class="mc-meta">
                                            <i class="fa-regular fa-folder-open"></i>{{ $module->project->project_name ?? '—' }}
                                            @if ($module->department)
                                                <span class="sep">&middot;</span><i class="fa-regular fa-building"></i>{{ $module->department->title }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <a class="mc-req-btn" href="{{ route('admin.requirements.index', ['module' => $module->id]) }}">
                                    <i class="fa-regular fa-clipboard"></i> Requirements
                                </a>
                            </div>

                            <div class="mc-badges">
                                <span class="badge-soft {{ $priorityBadgeClass($module->priority) }}"><span class="dot"></span>{{ $module->priority }}</span>
                                <span class="badge-soft {{ $statusBadgeClass($module->status) }}"><span class="dot"></span>{{ $module->status }}</span>
                            </div>

                            <div class="csd-progress-wrap">
                                <div class="csd-progress-label">
                                    <span>Progress</span>
                                    <span class="csd-mono">{{ $module->progress }}%</span>
                                </div>
                                <div class="csd-progress-track">
                                    <div class="csd-progress-fill {{ $progressBarClass($module->progress) }}"
                                         data-progress-width="{{ $module->progress }}"
                                         role="progressbar"
                                         aria-valuenow="{{ $module->progress }}" aria-valuemin="0" aria-valuemax="100">
                                        @if ($module->progress >= 18)
                                            <span class="csd-progress-pct csd-mono">{{ $module->progress }}%</span>
                                        @endif
                                    </div>
                                    @if ($module->progress < 18)
                                        <span class="csd-progress-pct pct-outside csd-mono" style="position:absolute; left: calc({{ $module->progress }}% + 8px); top: 0; line-height: 20px;">{{ $module->progress }}%</span>
                                    @endif
                                </div>
                            </div>

                            <div class="csd-meta-grid">
                                <div class="csd-meta-item">
                                    <strong>{{ rtrim(rtrim(number_format($module->estimated_hours, 1), '0'), '.') ?: 0 }}h</strong>
                                    <span>Estimated</span>
                                </div>
                                <div class="csd-meta-item">
                                    <strong>{{ rtrim(rtrim(number_format($module->actual_hours, 1), '0'), '.') ?: 0 }}h</strong>
                                    <span>Actual</span>
                                </div>
                                <div class="csd-meta-item">
                                    <strong>{{ $module->deadline ? \Illuminate\Support\Carbon::parse($module->deadline)->format('d M') : '—' }}</strong>
                                    <span>Deadline</span>
                                </div>
                                <div class="csd-meta-item">
                                    <strong>{{ $assignedDate ? \Illuminate\Support\Carbon::parse($assignedDate)->format('d M') : '—' }}</strong>
                                    <span>Assigned</span>
                                </div>
                            </div>

                            <div class="csd-card-footer">
                                <a href="{{ route('admin.projects.show', $module->project_id) }}#modules" class="btn-workspace">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Workspace
                                </a>

                                <a href="{{ url('modules/'.$module->id.'/submodules/submodules') }}" class="btn-update-progress csd-ripple">
                                    <i class="fa-solid fa-chart-line"></i> Update Progress
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center csd-pagination-wrap">
            {{ $modules->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    // Alpine component driving the segmented status tabs + client-side card filter.
    function csModulesDashboard() {
        return {
            active: 'all',
            indicatorStyle: '',
            init() {
                this.$nextTick(() => this.moveIndicator(this.$refs.tabWrap?.querySelector('.csd-tab.is-active')));
                window.addEventListener('resize', () => {
                    this.moveIndicator(this.$refs.tabWrap?.querySelector('.csd-tab.is-active'));
                });
            },
            setActive(value, evt) {
                this.active = value;
                this.$nextTick(() => this.moveIndicator(evt.currentTarget));
            },
            moveIndicator(btn) {
                if (!btn || !this.$refs.tabWrap) return;
                const wrapRect = this.$refs.tabWrap.getBoundingClientRect();
                const btnRect = btn.getBoundingClientRect();
                this.indicatorStyle =
                    'width:' + btnRect.width + 'px;' +
                    'transform: translateX(' + (btnRect.left - wrapRect.left - 4) + 'px);';
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        'use strict';

        if (window.lucide) { lucide.createIcons(); }

        // Progress-bar widths, applied post-render so the fill animates in.
        var progressBars = document.querySelectorAll('[data-progress-width]');
        requestAnimationFrame(function () {
            progressBars.forEach(function (bar) {
                var value = parseInt(bar.dataset.progressWidth, 10) || 0;
                bar.style.width = value + '%';
            });
        });

        // Animated count-up for KPI + hero statistics.
        document.querySelectorAll('[data-count]').forEach(function (el) {
            var target = parseInt(el.dataset.count, 10) || 0;
            var duration = 900;
            var start = null;
            function step(timestamp) {
                if (!start) start = timestamp;
                var progress = Math.min((timestamp - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(eased * target);
                if (progress < 1) window.requestAnimationFrame(step);
                else el.textContent = target;
            }
            window.requestAnimationFrame(step);
        });

        // Live workspace clock.
        var timeEl = document.getElementById('csClockTime');
        var dateEl = document.getElementById('csClockDate');
        if (timeEl && dateEl) {
            var dateFmt = new Intl.DateTimeFormat(undefined, { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' });
            function tick() {
                var now = new Date();
                timeEl.textContent = now.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                dateEl.textContent = dateFmt.format(now);
            }
            tick();
            setInterval(tick, 1000);
        }

        // GSAP entrance for hero + stat cards (fade / slide / scale).
        if (window.gsap) {
            gsap.from('.csd-hero', { opacity: 0, y: -14, duration: .6, ease: 'power3.out' });
            gsap.from('.csd-stat-card', { opacity: 0, y: 16, scale: .97, duration: .5, stagger: .06, ease: 'power3.out', delay: .1 });
            gsap.from('.csd-panel', { opacity: 0, y: 16, duration: .5, stagger: .07, ease: 'power3.out', delay: .25 });
        }

        // Ripple micro-interaction on primary/ghost/update-progress buttons.
        document.querySelectorAll('.csd-ripple').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                var rect = btn.getBoundingClientRect();
                var dot = document.createElement('span');
                var size = Math.max(rect.width, rect.height);
                dot.className = 'ripple-dot';
                dot.style.width = dot.style.height = size + 'px';
                dot.style.left = (e.clientX - rect.left - size / 2) + 'px';
                dot.style.top = (e.clientY - rect.top - size / 2) + 'px';
                btn.appendChild(dot);
                setTimeout(function () { dot.remove(); }, 550);
            });
        });

        // "Update Progress" isn't wired to a backend endpoint yet — hook this up
        // to a real route/modal when that feature is built.
        document.querySelectorAll('[data-update-progress]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                alert('Update Progress needs to be connected to a backend endpoint.');
            });
        });

        // ================= APEXCHARTS =================
        if (!window.ApexCharts) return;

        var brand = { primary: '#16879A', secondary: '#2DB8D2', accent: '#0E5C6B', amber: '#F59E0B', red: '#EF4444', blue: '#3B82F6', purple: '#8B5CF6', green: '#22C55E', muted: '#94A3B8' };

        var statusLabels = @json($csStatusCounts->keys());
        var statusValues = @json($csStatusCounts->values());
        if (statusValues.length) {
            new ApexCharts(document.querySelector('#csChartStatus'), {
                chart: { type: 'donut', height: 220, fontFamily: 'Plus Jakarta Sans, sans-serif' },
                labels: statusLabels,
                series: statusValues,
                colors: [brand.blue, brand.green, brand.amber, brand.purple, '#475467', brand.red, brand.secondary],
                legend: { position: 'bottom', fontSize: '11px' },
                dataLabels: { enabled: false },
                stroke: { width: 2, colors: ['#fff'] },
                plotOptions: { pie: { donut: { size: '68%', labels: { show: true, total: { show: true, label: 'Modules', fontSize: '11px' } } } } }
            }).render();
        } else {
            document.querySelector('#csChartStatus').innerHTML = '<div class="text-center text-muted small py-4">No data on this page</div>';
        }

        var priorityLabels = @json($csPriorityCounts->keys());
        var priorityValues = @json($csPriorityCounts->values());
        new ApexCharts(document.querySelector('#csChartPriority'), {
            chart: { type: 'bar', height: 220, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
            series: [{ name: 'Modules', data: priorityValues }],
            xaxis: { categories: priorityLabels, labels: { style: { fontSize: '11px' } } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '55%', distributed: true } },
            colors: [brand.red, brand.amber, brand.blue, brand.green],
            legend: { show: false },
            dataLabels: { enabled: false },
            grid: { borderColor: '#EEF2F6' }
        }).render();

        new ApexCharts(document.querySelector('#csChartCompletion'), {
            chart: { type: 'radialBar', height: 220, fontFamily: 'Plus Jakarta Sans, sans-serif' },
            series: [{{ $csAvgProgress }}],
            labels: ['Avg. Completion'],
            colors: [brand.primary],
            plotOptions: { radialBar: { hollow: { size: '62%' }, dataLabels: { value: { fontSize: '20px', fontWeight: 700, formatter: function (v) { return v + '%'; } }, name: { fontSize: '11px', color: '#64748B' } } } },
            fill: { type: 'gradient', gradient: { shade: 'light', type: 'horizontal', gradientToColors: [brand.secondary], stops: [0, 100] } }
        }).render();

        var deadlineNames = @json($csUpcoming->pluck('name'));
        var deadlineDays = @json($csUpcoming->pluck('days'));
        if (deadlineNames.length) {
            new ApexCharts(document.querySelector('#csChartDeadlines'), {
                chart: { type: 'bar', height: 220, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
                series: [{ name: 'Days remaining', data: deadlineDays }],
                xaxis: { categories: deadlineNames, labels: { style: { fontSize: '10px' } } },
                plotOptions: { bar: { borderRadius: 5, horizontal: true, barHeight: '55%' } },
                colors: [brand.accent],
                dataLabels: { enabled: true, style: { fontSize: '10px' } },
                grid: { borderColor: '#EEF2F6' }
            }).render();
        } else {
            document.querySelector('#csChartDeadlines').innerHTML = '<div class="text-center text-muted small py-4">No upcoming deadlines</div>';
        }
    });
</script>
@endpush