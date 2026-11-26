@extends('index')

@push('title', get_phrase('Backlinks'))

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

    .bce-page {

        --bce-primary: #0F8EA3;

        --bce-primary-light: #16B6C8;

        --bce-bg: #F8FAFC;

        --bce-card: #FFFFFF;

        --bce-border: #E8EDF3;

        --bce-text: #1F2937;

        --bce-text-soft: #6B7280;

        --bce-success: #22C55E;

        --bce-success-soft: #E9FBF0;

        --bce-danger: #EF4444;

        --bce-danger-soft: #FDECEC;

        --bce-warning: #F59E0B;

        --bce-warning-soft: #FEF6E7;

        --bce-radius-lg: 18px;

        --bce-radius-md: 12px;

        --bce-radius-sm: 8px;

        --bce-shadow-sm: 0 1px 2px rgba(15,23,42,.04);

        --bce-shadow-md: 0 6px 20px -8px rgba(15,23,42,.10);

        --bce-shadow-lg: 0 16px 40px -16px rgba(15,23,42,.16);

        /* background: var(--bce-bg); */

        color: var(--bce-text);

        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Inter, Roboto, Helvetica, Arial, sans-serif;

        /* padding: 28px clamp(16px, 3vw, 36px) 60px; */

        min-height: 100%;

    }

    .bce-page *, .bce-page *::before, .bce-page *::after { box-sizing: border-box; }

    .bce-page ::-webkit-scrollbar { width: 8px; height: 8px; }

    .bce-page ::-webkit-scrollbar-track { background: transparent; }

    .bce-page ::-webkit-scrollbar-thumb { background: #D7DEE8; border-radius: 999px; }

    .bce-page ::-webkit-scrollbar-thumb:hover { background: #C2CBDA; }

    @media (prefers-reduced-motion: reduce) {

        .bce-page * { animation: none !important; transition: none !important; }

    }

    /* ---------- Breadcrumb ---------- */

    .bce-crumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--bce-text-soft); margin-bottom: 14px; }

    .bce-crumb .bce-crumb-current { color: var(--bce-text); font-weight: 600; }

    .bce-crumb i { font-size: 10px; opacity: .6; }

    /* ---------- Sticky header ---------- */

    .bce-header {

        position: sticky; top: 0; z-index: 15; backdrop-filter: blur(10px);

        display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; flex-wrap: wrap;

        padding: 10px 0 22px; margin-bottom: 8px;

    }

    .bce-title { font-size: 26px; font-weight: 700; letter-spacing: -.02em; color: var(--bce-text); margin: 0 0 6px; }

    .bce-subtitle { font-size: 14.5px; color: var(--bce-text-soft); margin: 0; max-width: 520px; }

    .bce-header-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .bce-btn-gradient {

        display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px; color: #fff;

        background: linear-gradient(135deg, var(--bce-primary), var(--bce-primary-light));

        border: none; border-radius: 999px; padding: 11px 20px; box-shadow: 0 10px 24px -10px rgba(15,142,163,.55);

        transition: transform .16s ease, box-shadow .16s ease, filter .16s ease; text-decoration: none;

    }

    .bce-btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 16px 30px -12px rgba(15,142,163,.6); filter: brightness(1.04); color: #fff; }

    .bce-btn-gradient:active { transform: translateY(0); }

    .bce-btn-gradient-alt {

        display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px; color: #fff;

        background: linear-gradient(135deg, #16A34A, #22C55E);

        border: none; border-radius: 999px; padding: 11px 20px; box-shadow: 0 10px 24px -10px rgba(34,197,94,.5);

        transition: transform .16s ease, box-shadow .16s ease, filter .16s ease; text-decoration: none;

    }

    .bce-btn-gradient-alt:hover { transform: translateY(-2px); box-shadow: 0 16px 30px -12px rgba(34,197,94,.55); filter: brightness(1.04); color: #fff; }

    .bce-btn-gradient-alt:active { transform: translateY(0); }

    /* ---------- Analytics cards ---------- */

    .bce-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 26px; }

    @media (max-width: 1100px) { .bce-stats { grid-template-columns: repeat(2, 1fr); } }

    @media (max-width: 560px) { .bce-stats { grid-template-columns: 1fr; } }

    .bce-stat-card {

        background: var(--bce-card); border: 1px solid var(--bce-border); border-radius: var(--bce-radius-lg);

        box-shadow: var(--bce-shadow-sm); padding: 20px; position: relative; overflow: hidden;

        transition: transform .18s ease, box-shadow .18s ease; opacity: 0; animation: bceFadeUp .5s ease forwards;

    }

    .bce-stat-card:nth-child(1) { animation-delay: .02s; }

    .bce-stat-card:nth-child(2) { animation-delay: .08s; }

    .bce-stat-card:nth-child(3) { animation-delay: .14s; }

    .bce-stat-card:nth-child(4) { animation-delay: .20s; }

    .bce-stat-card:hover { transform: translateY(-3px); box-shadow: var(--bce-shadow-md); }

    .bce-stat-card::before {

        content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; border-radius: 4px 0 0 4px;

        background: var(--bce-accent, var(--bce-primary));

    }

    .bce-stat-card.is-total { --bce-accent: var(--bce-primary); }

    .bce-stat-card.is-available { --bce-accent: var(--bce-success); }

    .bce-stat-card.is-assigned { --bce-accent: var(--bce-warning); }

    .bce-stat-card.is-completed { --bce-accent: var(--bce-primary-light); }

    .bce-stat-top { display: flex; justify-content: space-between; align-items: flex-start; }

    .bce-stat-icon {

        width: 42px; height: 42px; border-radius: 13px; display: flex; align-items: center; justify-content: center;

        font-size: 16px; background: color-mix(in srgb, var(--bce-accent) 12%, white); color: var(--bce-accent);

    }

    .bce-stat-trend {

        font-size: 11.5px; font-weight: 600; color: var(--bce-accent); background: color-mix(in srgb, var(--bce-accent) 10%, white);

        border-radius: 999px; padding: 3px 9px; white-space: nowrap;

    }

    .bce-stat-number { font-size: 28px; font-weight: 700; letter-spacing: -.02em; margin: 14px 0 2px; color: var(--bce-text); }

    .bce-stat-label { font-size: 13px; color: var(--bce-text-soft); font-weight: 500; }

    @keyframes bceFadeUp {

        from { opacity: 0; transform: translateY(10px); }

        to { opacity: 1; transform: translateY(0); }

    }

    /* ---------- Search toolbar ---------- */

    .bce-toolbar {

        background: var(--bce-card); border: 1px solid var(--bce-border); border-radius: var(--bce-radius-lg);

        box-shadow: var(--bce-shadow-sm); padding: 16px 18px; margin-bottom: 22px;

    }

    .bce-toolbar-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }

    .bce-search-field { position: relative; flex: 1 1 260px; }

    .bce-search-field i {

        position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--bce-text-soft); font-size: 14px;

    }

    .bce-search-field input {

        width: 100%; border: 1px solid var(--bce-border); background: var(--bce-bg); border-radius: 999px;

        padding: 11px 16px 11px 40px; font-size: 14px; color: var(--bce-text); transition: all .15s ease;

    }

    .bce-search-field input:focus {

        outline: none; background: #fff; border-color: var(--bce-primary);

        box-shadow: 0 0 0 4px rgba(15,142,163,.12);

    }

    .bce-select-field { flex: 0 1 190px; min-width: 150px; }

    .bce-select-field select {

        width: 100%; border: 1px solid var(--bce-border); background: var(--bce-bg); border-radius: 999px;

        padding: 11px 34px 11px 16px; font-size: 13.5px; color: var(--bce-text); transition: all .15s ease;

        appearance: none; -webkit-appearance: none;

        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8' fill='none'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%236B7280' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");

        background-repeat: no-repeat; background-position: right 14px center;

    }

    .bce-select-field select:focus {

        outline: none; background-color: #fff; border-color: var(--bce-primary);

        box-shadow: 0 0 0 4px rgba(15,142,163,.12);

    }

    .bce-btn-search {

        border: none; border-radius: 999px; padding: 11px 22px; font-weight: 600; font-size: 14px; color: #fff;

        background: var(--bce-primary); transition: background .15s ease, transform .1s ease; flex: 0 0 auto;

    }

    .bce-btn-search:hover { background: #0C7688; color: #fff; }

    .bce-btn-search:active { transform: scale(.97); }

    .bce-btn-reset {

        border: 1px solid var(--bce-border); border-radius: 999px; padding: 11px 18px; font-weight: 600; font-size: 14px;

        color: var(--bce-text-soft); background: #fff; transition: all .15s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;

        flex: 0 0 auto;

    }

    .bce-btn-reset:hover { background: var(--bce-bg); color: var(--bce-text); border-color: #D7DEE8; }

    .bce-result-counter { font-size: 13px; color: var(--bce-text-soft); margin-top: 12px; padding-top: 12px; border-top: 1px dashed var(--bce-border); }

    .bce-result-counter strong { color: var(--bce-text); font-weight: 600; }

    /* ---------- Table ---------- */

    .bce-table-card {

        background: var(--bce-card); border: 1px solid var(--bce-border); border-radius: var(--bce-radius-lg);

        box-shadow: var(--bce-shadow-sm); overflow: hidden; opacity: 0; animation: bceFadeUp .5s ease .12s forwards;

    }

    .bce-table-wrap { overflow-x: auto; max-height: 640px; }

    .bce-table { width: 100%; border-collapse: collapse; min-width: 920px; }

    .bce-table thead th {

        position: sticky; top: 0; z-index: 2; background: #FBFCFE; text-align: left; font-size: 11.5px; font-weight: 600;

        letter-spacing: .06em; text-transform: uppercase; color: var(--bce-text-soft);

        padding: 14px 18px; border-bottom: 1px solid var(--bce-border); white-space: nowrap;

    }

    .bce-table tbody td { padding: 15px 18px; border-bottom: 1px solid var(--bce-border); vertical-align: middle; font-size: 14px; color: var(--bce-text); }

    .bce-table tbody tr:last-child td { border-bottom: none; }

    .bce-table tbody tr { transition: background .12s ease; }

    .bce-table tbody tr:nth-child(even) { background: #FAFBFD; }

    .bce-table tbody tr:hover { background: #F1F8FA; }

    .bce-row-num { color: var(--bce-text-soft); font-variant-numeric: tabular-nums; font-size: 13px; }

    .bce-site-cell { display: flex; align-items: center; gap: 10px; }

    .bce-site-icon {

        width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;

        background: color-mix(in srgb, var(--bce-primary) 12%, white); color: var(--bce-primary); font-size: 13px;

    }

    .bce-site-url { font-weight: 600; color: var(--bce-text); font-size: 14px; word-break: break-word; }

    .bce-site-visit { color: var(--bce-text-soft); font-size: 12px; margin-left: 4px; text-decoration: none; }

    .bce-site-visit:hover { color: var(--bce-primary); }

    .bce-cat-badge {

        display: inline-block; font-size: 12px; font-weight: 600; color: var(--bce-text-soft); background: var(--bce-bg);

        border: 1px solid var(--bce-border); border-radius: 999px; padding: 4px 11px;

    }

    /* Score badges (DA / PA) */

    .bce-score { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; font-size: 12.5px; font-weight: 700;

        border-radius: 999px; padding: 4px 10px; font-variant-numeric: tabular-nums; }

    .bce-score-high { background: var(--bce-success-soft); color: #16803D; }

    .bce-score-mid { background: var(--bce-warning-soft); color: #92620A; }

    .bce-score-low { background: #F1F3F6; color: #6B7280; }

    .bce-score-muted { background: #F1F3F6; color: #9CA3AF; }

    .bce-assignee { display: inline-flex; align-items: center; gap: 8px; font-size: 13.5px; color: var(--bce-text); }

    .bce-assignee-avatar {

        width: 26px; height: 26px; border-radius: 50%; background: var(--bce-primary-light); color: #fff; font-size: 11px; font-weight: 700;

        display: flex; align-items: center; justify-content: center; flex-shrink: 0;

    }

    .bce-assignee-empty { color: #C7CEDA; }

    /* Status pills */

    .bce-pill {

        display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; border-radius: 999px;

        padding: 5px 12px 5px 10px; white-space: nowrap;

    }

    .bce-pill .bce-dot { width: 7px; height: 7px; border-radius: 50%; }

    .bce-pill--available { background: var(--bce-success-soft); color: #16803D; }

    .bce-pill--available .bce-dot { background: var(--bce-success); }

    .bce-pill--assigned { background: var(--bce-warning-soft); color: #92620A; }

    .bce-pill--assigned .bce-dot { background: var(--bce-warning); }

    .bce-pill--completed { background: color-mix(in srgb, var(--bce-primary) 12%, white); color: var(--bce-primary); }

    .bce-pill--completed .bce-dot { background: var(--bce-primary); }

    /* Action menu */

    .bce-action-btn {

        width: 34px; height: 34px; border-radius: var(--bce-radius-sm); border: 1px solid var(--bce-border); background: #fff;

        color: var(--bce-text-soft); display: inline-flex; align-items: center; justify-content: center;

        transition: all .14s ease; box-shadow: var(--bce-shadow-sm);

    }

    .bce-action-btn:hover, .bce-action-btn:focus { background: var(--bce-bg); color: var(--bce-text); border-color: #D7DEE8; }

    .bce-action-btn:focus { outline: none; box-shadow: 0 0 0 3px rgba(15,142,163,.15); }

    .bce-page .dropdown-menu {

        border: 1px solid var(--bce-border); border-radius: var(--bce-radius-md); box-shadow: var(--bce-shadow-lg);

        padding: 6px; min-width: 170px;

    }

    .bce-page .dropdown-item {

        border-radius: var(--bce-radius-sm); padding: 9px 12px; font-size: 13.5px; font-weight: 500; display: flex; align-items: center;

        transition: background .12s ease;

    }

    .bce-page .dropdown-item:hover { background: var(--bce-bg); }

    .bce-page .dropdown-item.text-danger:hover { background: var(--bce-danger-soft); }

    .bce-page .dropdown-item i { width: 16px; }

    /* ---------- Empty state ---------- */

    .bce-empty { text-align: center; padding: 64px 20px; }

    .bce-empty img { width: 130px; opacity: .9; margin-bottom: 18px; }

    .bce-empty h5 { font-size: 18px; font-weight: 700; color: var(--bce-text); margin-bottom: 6px; }

    .bce-empty p { font-size: 14px; color: var(--bce-text-soft); margin-bottom: 20px; }

    .bce-empty-actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

    /* ---------- Uploaded files ---------- */

    .bce-files-section { margin-bottom: 26px; }

    .bce-section-head {
        display: flex; justify-content: space-between; align-items: flex-end; gap: 16px;
        margin-bottom: 14px;
    }

    .bce-section-title { margin: 0; font-size: 18px; font-weight: 750; color: var(--bce-text); }

    .bce-section-copy { margin: 4px 0 0; font-size: 13px; color: var(--bce-text-soft); }

    .bce-file-summary { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

    .bce-file-summary span {
        display: inline-flex; align-items: center; gap: 6px; padding: 7px 10px;
        border: 1px solid var(--bce-border); border-radius: 999px; background: #fff;
        color: var(--bce-text-soft); font-size: 12px; font-weight: 650;
    }

    .bce-files-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }

    .bce-file-card {
        min-width: 0; padding: 18px; background: var(--bce-card); border: 1px solid var(--bce-border);
        border-radius: var(--bce-radius-lg); box-shadow: var(--bce-shadow-sm);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .bce-file-card:hover {
        transform: translateY(-2px); border-color: color-mix(in srgb, var(--bce-primary) 30%, var(--bce-border));
        box-shadow: var(--bce-shadow-md);
    }

    .bce-file-top { display: flex; align-items: flex-start; gap: 12px; }

    .bce-file-icon {
        width: 44px; height: 44px; flex: 0 0 44px; display: grid; place-items: center;
        border-radius: 12px; background: #EAF8FA; color: var(--bce-primary); font-size: 20px;
    }

    .bce-file-icon.is-excel { background: var(--bce-success-soft); color: #168446; }

    .bce-file-main { min-width: 0; flex: 1; }

    .bce-file-name {
        display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        color: var(--bce-text); font-size: 14px; font-weight: 750;
    }

    .bce-file-meta { margin-top: 4px; color: var(--bce-text-soft); font-size: 12px; }

    .bce-file-status {
        display: inline-flex; align-items: center; gap: 5px; flex: 0 0 auto;
        padding: 5px 8px; border-radius: 999px; font-size: 11px; font-weight: 750;
        text-transform: capitalize;
    }

    .bce-file-status.is-completed { background: var(--bce-success-soft); color: #168446; }

    .bce-file-status.is-pending { background: var(--bce-warning-soft); color: #B36B00; }

    .bce-file-details {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
        padding: 13px 0; margin-top: 14px; border-top: 1px solid var(--bce-border);
        border-bottom: 1px solid var(--bce-border);
    }

    .bce-file-detail { min-width: 0; }

    .bce-file-detail strong { display: block; color: var(--bce-text); font-size: 13px; }

    .bce-file-detail span { color: var(--bce-text-soft); font-size: 11px; }

    .bce-file-actions { display: flex; gap: 8px; margin-top: 14px; }

    .bce-file-action {
        flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 7px;
        min-height: 38px; padding: 8px 10px; border: 1px solid var(--bce-border);
        border-radius: 10px; background: #fff; color: var(--bce-text); font-size: 12.5px;
        font-weight: 700; text-decoration: none; transition: all .15s ease;
    }

    .bce-file-action:hover { border-color: var(--bce-primary); color: var(--bce-primary); background: #F2FBFC; }

    .bce-file-action.is-primary { border-color: var(--bce-primary); background: var(--bce-primary); color: #fff; }

    .bce-file-action.is-primary:hover { background: #0B788B; color: #fff; }

    .bce-file-delete-form { display: flex; flex: 1; margin: 0; }

    .bce-file-action.is-danger { width: 100%; color: var(--bce-danger); cursor: pointer; }

    .bce-file-action.is-danger:hover {
        border-color: var(--bce-danger); background: var(--bce-danger-soft); color: var(--bce-danger);
    }

    .bce-files-empty {
        padding: 28px; text-align: center; background: #fff; border: 1px dashed #CBD5E1;
        border-radius: var(--bce-radius-lg); color: var(--bce-text-soft); font-size: 13px;
    }

    @media (max-width: 1100px) { .bce-files-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }

    @media (max-width: 680px) {
        .bce-section-head { align-items: flex-start; flex-direction: column; }
        .bce-files-grid { grid-template-columns: 1fr; }
    }

    /* ---------- Pagination ---------- */

    .bce-pagination-wrap { display: flex; justify-content: flex-end; margin-top: 20px; }

    .bce-pagination-wrap .pagination { gap: 6px; margin: 0; }

    .bce-pagination-wrap .page-item .page-link {

        border: 1px solid var(--bce-border); border-radius: 999px !important; color: var(--bce-text-soft);

        font-size: 13.5px; font-weight: 600; padding: 8px 14px; min-width: 38px; text-align: center; box-shadow: none;

        transition: all .14s ease;

    }

    .bce-pagination-wrap .page-item .page-link:hover { background: var(--bce-bg); color: var(--bce-text); }

    .bce-pagination-wrap .page-item.active .page-link {

        background: var(--bce-primary); border-color: var(--bce-primary); color: #fff;

    }

    .bce-pagination-wrap .page-item.disabled .page-link { opacity: .45; }

    @media (max-width: 640px) {

        .bce-page { padding: 18px 14px 50px; }

        .bce-title { font-size: 21px; }

        .bce-header { flex-direction: column; }

        .bce-header-actions { width: 100%; }

        .bce-header-actions a { flex: 1; justify-content: center; }

        .bce-pagination-wrap { justify-content: center; }

    }

</style>

@endpush

@section('content')

<div class="bce-page">

    @include('admin.backlinks.partials.alerts')

    <nav class="bce-crumb" aria-label="breadcrumb">

        <span>Dashboard</span>

        <i class="fa-solid fa-chevron-right"></i>

        <span>SEO</span>

        <i class="fa-solid fa-chevron-right"></i>

        <span class="bce-crumb-current">Backlinks</span>

    </nav>

    <div class="bce-header">

        <div>

            <h1 class="bce-title">Backlinks</h1>

            <p class="bce-subtitle">Manage your uploaded CSV and Excel backlink files.</p>

        </div>

        <div class="bce-header-actions">

            <a href="{{ route('admin.backlinks.upload') }}" class="bce-btn-gradient-alt">

                <i class="fa-solid fa-file-arrow-up"></i>

                Upload CSV / Excel

            </a>

            <a href="{{ route('admin.backlinks.create') }}" class="bce-btn-gradient">

                <i class="fa-solid fa-plus"></i>

                Add Backlink

            </a>

        </div>

    </div>

    {{-- ============ Analytics ============ --}}

    <div class="bce-stats">

        <div class="bce-stat-card is-total">

            <div class="bce-stat-top">

                <span class="bce-stat-icon"><i class="fa-solid fa-folder-open"></i></span>

                <span class="bce-stat-trend">All files</span>

            </div>

            <div class="bce-stat-number">{{ $totalUploadedFiles }}</div>

            <div class="bce-stat-label">Total Uploaded Files</div>

        </div>

        <div class="bce-stat-card is-available">

            <div class="bce-stat-top">

                <span class="bce-stat-icon"><i class="fa-solid fa-file-csv"></i></span>

            </div>

            <div class="bce-stat-number">{{ $csvUploadedFiles }}</div>

            <div class="bce-stat-label">CSV Files</div>

        </div>

        <div class="bce-stat-card is-assigned">

            <div class="bce-stat-top">

                <span class="bce-stat-icon"><i class="fa-solid fa-file-excel"></i></span>

            </div>

            <div class="bce-stat-number">{{ $excelUploadedFiles }}</div>

            <div class="bce-stat-label">Excel Files</div>

        </div>

        <div class="bce-stat-card is-completed">

            <div class="bce-stat-top">

                <span class="bce-stat-icon"><i class="fa-solid fa-hard-drive"></i></span>

            </div>

            <div class="bce-stat-number">
                @if($totalUploadedBytes >= 1048576)
                    {{ number_format($totalUploadedBytes / 1048576, 2) }} MB
                @else
                    {{ number_format($totalUploadedBytes / 1024, 1) }} KB
                @endif
            </div>

            <div class="bce-stat-label">Storage Used</div>

        </div>

    </div>

    {{-- ============ Uploaded CSV / Excel Files ============ --}}

    <section class="bce-files-section">

        <div class="bce-section-head">

            <div>

                <h2 class="bce-section-title">Uploaded CSV / Excel Files</h2>

                <p class="bce-section-copy">Files are stored in Backlink Uploads. Open or download the original file anytime.</p>

            </div>

            <div class="bce-file-summary">

                <span><i class="fa-solid fa-folder-open"></i> {{ $totalUploadedFiles }} Total</span>

            </div>

        </div>

        @if($uploads->count())

            <div class="bce-files-grid">

                @foreach($uploads as $upload)

                    @php

                        $isExcel = in_array(strtolower($upload->extension), ['xls', 'xlsx'], true);

                        $fileSize = (int) $upload->size;

                        $readableSize = $fileSize >= 1048576
                            ? number_format($fileSize / 1048576, 2) . ' MB'
                            : number_format(max($fileSize, 0) / 1024, 1) . ' KB';

                    @endphp

                    <article class="bce-file-card">

                        <div class="bce-file-top">

                            <span class="bce-file-icon {{ $isExcel ? 'is-excel' : '' }}">

                                <i class="fa-solid {{ $isExcel ? 'fa-file-excel' : 'fa-file-csv' }}"></i>

                            </span>

                            <div class="bce-file-main">

                                <span class="bce-file-name" title="{{ $upload->original_name }}">{{ $upload->original_name }}</span>

                                <div class="bce-file-meta">

                                    {{ strtoupper($upload->extension) }} · {{ $readableSize }} · {{ $upload->created_at?->format('d M Y, h:i A') }}

                                </div>

                            </div>

                            <span class="bce-file-status is-completed">

                                <i class="fa-solid fa-check"></i>

                                Uploaded

                            </span>

                        </div>

                        <div class="bce-file-details">

                            <div class="bce-file-detail">

                                <strong>{{ $upload->category->name ?? '—' }}</strong>

                                <span>Category</span>

                            </div>

                            <div class="bce-file-detail">

                                <strong>{{ strtoupper($upload->extension) }}</strong>

                                <span>File Type</span>

                            </div>

                            <div class="bce-file-detail">

                                <strong>{{ $readableSize }}</strong>

                                <span>File Size</span>

                            </div>

                        </div>

                        <div class="bce-file-actions">

                            <a href="{{ route('admin.backlinks.files.open', $upload) }}" target="_blank" rel="noopener" class="bce-file-action">

                                <i class="fa-solid fa-eye"></i> Open

                            </a>

                            <a href="{{ route('admin.backlinks.files.download', $upload) }}" class="bce-file-action">

                                <i class="fa-solid fa-download"></i> Download

                            </a>

                            <form
                                action="{{ route('admin.backlinks.files.destroy', $upload) }}"
                                method="POST"
                                class="bce-file-delete-form delete-upload-form">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="bce-file-action is-danger">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>

                            </form>

                        </div>

                    </article>

                @endforeach

            </div>

            <div class="bce-pagination-wrap">

                {{ $uploads->links() }}

            </div>

        @else

            <div class="bce-files-empty">

                <i class="fa-solid fa-cloud-arrow-up me-1"></i>

                No CSV or Excel file has been uploaded yet.

            </div>

        @endif

    </section>


</div>

@endsection

@push('js')

<script>

$(document).on('submit', '.delete-upload-form', function (e) {

    if (!confirm('Delete this uploaded file permanently?')) {

        e.preventDefault();

    }

});

</script>

@endpush







