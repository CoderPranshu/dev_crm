@extends('index')

@push('title', get_phrase('Sales Pipeline'))

@php
    /*
    |--------------------------------------------------------------------------
    | QUICK QUOTATION PRODUCTS
    |--------------------------------------------------------------------------
    */

    $quoteProductsQuery = \App\Models\Product::query()
        ->orderBy('name');

    if (
        !auth()->user()->hasRole('Admin') &&
        !empty(auth()->user()->branch_id)
    ) {
        $quoteProductsQuery->where(
            'branch_id',
            auth()->user()->branch_id
        );
    }

    $quoteProducts = $quoteProductsQuery->get();


    /*
    |--------------------------------------------------------------------------
    | DETAILED QUOTATION LIBRARY
    |--------------------------------------------------------------------------
    */

    $detailedQuotations = \App\Models\DetailedQuotation::query()
        ->with([
            'category:id,name',
        ])
        ->whereNotNull('category_id')
        ->orderBy('name')
        ->get([
            'id',
            'name',
            'category_id',
        ]);


    /*
    |--------------------------------------------------------------------------
    | Categories having proposal PDFs
    |--------------------------------------------------------------------------
    */

    $detailedQuotationCategories = $detailedQuotations
        ->pluck('category')
        ->filter()
        ->unique('id')
        ->sortBy('name')
        ->values();


    /*
    |--------------------------------------------------------------------------
    | PRODUCTS JSON
    |--------------------------------------------------------------------------
    */

    $quoteProductsJson = json_encode(
        $quoteProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sale_price' => $product->sale_price ?? 0,
            ];
        })->values()->toArray(),

        JSON_HEX_TAG |
        JSON_HEX_APOS |
        JSON_HEX_AMP |
        JSON_HEX_QUOT
    );


    /*
    |--------------------------------------------------------------------------
    | COLUMN DISPLAY ORDER
    |--------------------------------------------------------------------------
    */

    $stageDisplayOrder = [
        'New Lead',
        'Contacted',
        'Proposal Pending',
        'Proposal Sent',
        'Negotiation',
        'Proforma Pending',
        'Send Proforma',
        'Payment Waiting',
        'Won',
        'Lost',
    ];

    $orderedStages = collect($stageDisplayOrder)
        ->intersect($stages)
        ->values();

    $remainingStages = collect($stages)
        ->diff($orderedStages)
        ->values();

    $stages = $orderedStages
        ->merge($remainingStages)
        ->values()
        ->all();


    /*
    |--------------------------------------------------------------------------
    | PIPELINE INSIGHTS (derived from the exact same collections used
    | below to render the board — nothing here is invented, it mirrors
    | the per-column counting logic already used inside the @foreach).
    |--------------------------------------------------------------------------
    */

    $stageCounts = [];

    foreach ($stages as $stage) {

        $stageLeadsCount = $leads->where('stage', $stage)->count();

        $stageProformasCount = $proformas->where('stage', $stage)->count();

        $stageQuotationsCount = $quotations->filter(function ($quotation) use ($stage) {
            return optional($quotation->lead)->stage === $stage;
        })->count();

        $stageCounts[$stage] = $stageLeadsCount + $stageProformasCount + $stageQuotationsCount;
    }

    $maxStageCount = !empty($stageCounts) ? max($stageCounts) : 0;

    $totalLeadsCount = $leads->count();
    $totalProformasCount = $proformas->count();
    $totalQuotationsCount = $quotations->count();

    $totalPipelineItems = $totalLeadsCount + $totalProformasCount + $totalQuotationsCount;

    $wonCount = $stageCounts['Won'] ?? 0;
    $lostCount = $stageCounts['Lost'] ?? 0;
    $activeCount = max(0, $totalPipelineItems - $wonCount - $lostCount);

    $proposalPendingCount = $stageCounts['Proposal Pending'] ?? 0;
    $proformaPendingCount = $stageCounts['Proforma Pending'] ?? 0;
    $proposalSentCount = $stageCounts['Proposal Sent'] ?? 0;

    $conversionRate = $totalPipelineItems > 0
        ? round(($wonCount / $totalPipelineItems) * 100, 1)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | STAGE DESIGN MAP — one colour + one icon per stage, used to give every
    | column its own identity (icon badge, top accent bar, health-bar colour)
    | the way the reference "deals system" screenshot does it. Purely visual
    | metadata — does not touch $stages, routes, or any stage value used by
    | the JS/backend.
    |--------------------------------------------------------------------------
    */

    $stageDesign = [
        'New Lead' => ['color' => 'slate', 'icon' => 'fi-rr-users'],
        'Contacted' => ['color' => 'blue', 'icon' => 'fi-rr-phone-call'],
        'Proposal Pending' => ['color' => 'violet', 'icon' => 'fi-rr-file-signature'],
        'Proforma Pending' => ['color' => 'cyan', 'icon' => 'fi-rr-receipt'],
        'Send Proforma' => ['color' => 'teal', 'icon' => 'fi-rr-paper-plane'],
        'Proposal Sent' => ['color' => 'orange', 'icon' => 'fi-rr-share'],
        'Negotiation' => ['color' => 'amber', 'icon' => 'fi-rr-handshake'],
        'Payment Waiting' => ['color' => 'gold', 'icon' => 'fi-rr-wallet'],
        'Won' => ['color' => 'success', 'icon' => 'fi-rr-badge-check'],
        'Lost' => ['color' => 'danger', 'icon' => 'fi-rr-cross-circle'],
    ];

    $defaultStageDesign = ['color' => 'accent', 'icon' => 'fi-rr-flag'];

    $stageAccentMap = collect($stageDesign)->mapWithKeys(function ($design, $stage) {
        return [$stage => $design['color']];
    })->toArray();
@endphp


@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>

    @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Public+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600;700&display=swap');

    /* =========================================================
       CS SALES PIPELINE — "LEDGER DESK" DESIGN SYSTEM
       An editorial, data-desk aesthetic built for a sales
       operations tool: an ink-dark command band up top, a warm
       paper working surface below, and monospace figures
       wherever a number needs to be scanned at speed. Every rule
       lives under .cs-sales-pipeline so nothing leaks onto the
       rest of the ERP.
       ========================================================= */

    :root {
        --sp-bg: #F5F4EF;
        --sp-surface: #FFFFFF;
        --sp-surface-2: #EFEDE4;
        --sp-surface-3: #E7E4D8;
        --sp-border: #E1DED2;
        --sp-border-strong: #CFCABA;
        --sp-text: #171A16;
        --sp-text-soft: #2B2E27;
        --sp-muted: #6B6656;
        --sp-muted-2: #99937E;

        --sp-primary: #0F6E5F;
        --sp-primary-soft: #E3EFEA;
        --sp-accent: #2B5C7E;
        --sp-accent-soft: #E5EDF2;
        --sp-blue: #2B5C7E;
        --sp-blue-soft: #E5EDF2;
        --sp-success: #1B7A4D;
        --sp-success-soft: #E5F1E9;
        --sp-warning: #B07A1E;
        --sp-warning-soft: #F5EDDA;
        --sp-danger: #A8402F;
        --sp-danger-soft: #F4E5E1;

        --sp-slate: #3E4536;
        --sp-slate-soft: #E7E6DB;
        --sp-violet: #6B4C7E;
        --sp-violet-soft: #EEE7F1;
        --sp-cyan: #276E77;
        --sp-cyan-soft: #E1EEEC;
        --sp-teal: #0F6E5F;
        --sp-teal-soft: #E3EFEA;
        --sp-orange: #AD5A26;
        --sp-orange-soft: #F3E7DC;
        --sp-amber: #B07A1E;
        --sp-amber-soft: #F5EDDA;
        --sp-gold: #9C7A26;
        --sp-gold-soft: #F1E9D2;

        --sp-ink: #14181A;
        --sp-ink-2: #1E2422;
        --sp-ink-line: rgba(245, 243, 234, .14);
        --sp-ink-text: #F4F2E8;
        --sp-ink-muted: rgba(244, 242, 232, .6);

        --sp-radius-sm: 6px;
        --sp-radius-md: 10px;
        --sp-radius-lg: 16px;
        --sp-radius-pill: 999px;

        --sp-shadow-xs: 0 1px 1px rgba(20, 24, 20, .04);
        --sp-shadow-sm: 0 1px 2px rgba(20, 24, 20, .05), 0 1px 1px rgba(20, 24, 20, .04);
        --sp-shadow-card: 0 2px 4px rgba(20, 24, 20, .06), 0 10px 22px rgba(20, 24, 20, .07);

        --sp-font-display: 'Fraunces', 'Georgia', serif;
        --sp-font-sans: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --sp-font-mono: 'IBM Plex Mono', 'SFMono-Regular', Menlo, monospace;
    }

    .main_content{
        padding: 10px;
    }

    .cs-sales-pipeline {
        color: var(--sp-text);
        /* background: var(--sp-bg); */
        background: white;
        padding: 10px;
        border-radius: var(--sp-radius-lg);
        /* padding: 0 0 20px; */
        font-family: var(--sp-font-sans);
    }

    .cs-sales-pipeline * {
        box-sizing: border-box;
    }

    .cs-sales-pipeline .sp-subtitle {
        margin: 2px 0 0;
        font-size: 13px;
        color: var(--sp-muted);
        font-weight: 500;
    }


    /* =========================================================
       HERO — ink command band with breadcrumb, serif title and
       a single headline metric, closing on a ledger strip of
       the numbers that matter most.
       ========================================================= */

    .sp-hero {
        background: var(--sp-ink);
        border-radius: var(--sp-radius-lg);
        padding: 22px 26px 0;
        margin-bottom: 18px;
        color: var(--sp-ink-text);
    }

    .sp-hero-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        padding-bottom: 20px;
    }

    .sp-crumb {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        color: var(--sp-ink-muted);
        margin-bottom: 12px;
    }

    .sp-crumb a {
        color: var(--sp-ink-muted);
        text-decoration: none;
    }

    .sp-crumb a:hover {
        color: var(--sp-ink-text);
    }

    .sp-hero-title {
        font-family: var(--sp-font-display);
        font-weight: 600;
        font-size: 34px;
        line-height: 1.1;
        letter-spacing: -.01em;
        margin: 0 0 6px;
        color: var(--sp-ink-text);
    }

    .sp-hero-subtitle {
        font-size: 14px;
        color: var(--sp-ink-muted);
        margin: 0;
        max-width: 46ch;
    }

    .sp-hero-metric {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 2px;
        text-align: right;
    }

    .sp-hero-metric-label {
        font-size: 11.5px;
        color: var(--sp-ink-muted);
        font-weight: 600;
    }

    .sp-hero-metric-value {
        font-family: var(--sp-font-mono);
        font-size: 38px;
        font-weight: 600;
        line-height: 1;
        color: var(--sp-ink-text);
    }

    .sp-hero-metric-value small {
        font-size: 18px;
        font-weight: 500;
        color: var(--sp-ink-muted);
        margin-left: 2px;
    }

    .sp-hero-metric-hint {
        font-size: 11.5px;
        color: var(--sp-ink-muted);
        margin-top: 2px;
    }

    .sp-ledger {
        display: flex;
        flex-wrap: wrap;
        border-top: 1px solid var(--sp-ink-line);
    }

    .sp-ledger-item {
        flex: 1 1 120px;
        padding: 14px 18px;
        border-right: 1px solid var(--sp-ink-line);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .sp-ledger-item:last-child {
        border-right: 0;
    }

    .sp-ledger-value {
        font-family: var(--sp-font-mono);
        font-size: 21px;
        font-weight: 600;
        color: var(--sp-ink-text);
        line-height: 1;
    }

    .sp-ledger-item.is-positive .sp-ledger-value {
        color: #8FCBA8;
    }

    .sp-ledger-item.is-negative .sp-ledger-value {
        color: #E3A79A;
    }

    .sp-ledger-label {
        font-size: 11.5px;
        color: var(--sp-ink-muted);
        font-weight: 500;
    }


    /* =========================================================
       PIPELINE FLOW — one proportional distribution bar plus a
       scan-friendly legend, replacing a grid of duplicate cards.
       ========================================================= */

    .sp-flow {
        background: var(--sp-surface);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 16px 18px;
        margin-bottom: 14px;
        box-shadow: var(--sp-shadow-xs);
    }

    .sp-flow-head {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .sp-flow-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--sp-text);
    }

    .sp-flow-hint {
        font-size: 11.5px;
        color: var(--sp-muted-2);
    }

    .sp-flow-bar {
        display: flex;
        width: 100%;
        height: 10px;
        border-radius: var(--sp-radius-pill);
        overflow: hidden;
        background: var(--sp-surface-2);
        margin-bottom: 14px;
    }

    .sp-flow-seg {
        height: 100%;
        min-width: 3px;
    }

    .sp-flow-legend {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 8px 14px;
    }

    .sp-flow-legend-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        color: var(--sp-text-soft);
        min-width: 0;
    }

    .sp-flow-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .sp-flow-legend-label {
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sp-flow-legend-count {
        font-family: var(--sp-font-mono);
        font-weight: 600;
        color: var(--sp-muted);
        margin-left: auto;
    }


    /* =========================================================
       TOOLBAR
       ========================================================= */

    .sp-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .sp-search-box {
        position: relative;
        max-width: 320px;
        width: 100%;
    }

    .sp-search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--sp-muted-2);
        font-size: 13px;
    }

    .sp-search-box input {
        width: 100%;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 8px 12px 8px 32px;
        font-size: 13px;
        font-family: var(--sp-font-sans);
        background: var(--sp-surface);
        color: var(--sp-text);
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .sp-search-box input:focus {
        outline: none;
        border-color: var(--sp-accent);
        box-shadow: 0 0 0 3px var(--sp-accent-soft);
    }

    .sp-toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sp-density-toggle {
        display: inline-flex;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        overflow: hidden;
        background: var(--sp-surface);
    }

    .sp-density-btn {
        border: 0;
        background: transparent;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
        font-family: var(--sp-font-sans);
        color: var(--sp-muted);
        cursor: pointer;
        transition: background .15s ease, color .15s ease;
    }

    .sp-density-btn.is-active {
        background: var(--sp-primary-soft);
        color: var(--sp-primary);
    }

    .sp-result-count {
        font-size: 12px;
        font-family: var(--sp-font-mono);
        color: var(--sp-muted-2);
        font-weight: 600;
        white-space: nowrap;
    }


    /* =========================================================
       PIPELINE BOARD
       ========================================================= */

    .pipeline-wrapper {
        padding: 6px 2px 14px;
        min-height: 60vh;
        display: flex;
        gap: 14px;
        overflow-x: auto;
        align-items: flex-start;
        scroll-behavior: smooth;
    }

    .pipeline-wrapper::-webkit-scrollbar {
        height: 7px;
    }

    .pipeline-wrapper::-webkit-scrollbar-thumb {
        background: var(--sp-border-strong);
        border-radius: var(--sp-radius-pill);
    }

    .pipeline-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .pipeline-column {
        position: relative;
        min-width: 306px;
        width: 306px;
        background: color-mix(in srgb, var(--lane-accent, var(--sp-muted-2)) 6%, var(--sp-surface));
        border-radius: var(--sp-radius-lg);
        padding: 13px 10px 10px;
        border: 1px solid color-mix(in srgb, var(--lane-accent, var(--sp-border-strong)) 26%, var(--sp-border));
        box-shadow: 0 1px 2px color-mix(in srgb, var(--lane-accent, transparent) 8%, transparent);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        overflow: hidden;
        transition: box-shadow .2s ease, border-color .2s ease;
    }

    .pipeline-column:hover {
        border-color: color-mix(in srgb, var(--lane-accent, var(--sp-border-strong)) 45%, var(--sp-border));
        box-shadow: 0 4px 14px color-mix(in srgb, var(--lane-accent, transparent) 14%, transparent);
    }

    .sp-column-accent-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .pipeline-header {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin: -13px -10px 8px;
        padding: 16px 12px 14px;
        background: color-mix(in srgb, var(--lane-accent, transparent) 13%, transparent);
        border-bottom: 1px solid color-mix(in srgb, var(--lane-accent, var(--sp-border-strong)) 30%, var(--sp-border));
    }

    .sp-seal {
        position: relative;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        margin: -4px 0 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(
            circle at 34% 28%,
            color-mix(in srgb, var(--lane-accent, var(--sp-accent)) 45%, white) 0%,
            var(--lane-accent, var(--sp-accent)) 55%,
            color-mix(in srgb, var(--lane-accent, var(--sp-accent)) 72%, black) 100%
        );
        box-shadow:
            0 0 0 3px var(--sp-surface),
            0 0 0 4px color-mix(in srgb, var(--lane-accent, var(--sp-accent)) 55%, white),
            0 7px 14px color-mix(in srgb, var(--lane-accent, var(--sp-accent)) 35%, transparent);
    }

    .sp-seal::after {
        content: "";
        position: absolute;
        top: 5px;
        left: 9px;
        width: 56%;
        height: 36%;
        border-radius: 50%;
        background: linear-gradient(180deg, rgba(255, 255, 255, .6), rgba(255, 255, 255, 0));
        pointer-events: none;
    }

    .sp-seal i {
        position: relative;
        z-index: 1;
        color: #fff;
        font-size: 19px;
        filter: drop-shadow(0 1px 1px rgba(0, 0, 0, .3));
    }

    .sp-seal.is-crown {
        background: radial-gradient(circle at 34% 28%, #E8CE8A 0%, #B7912F 55%, #7A5E1C 100%);
        box-shadow:
            0 0 0 3px var(--sp-surface),
            0 0 0 4px #C9A542,
            0 0 0 6px color-mix(in srgb, #C9A542 35%, transparent),
            0 8px 16px rgba(154, 118, 30, .4);
    }

    .sp-seal.is-crown i {
        color: #FFF6DE;
    }

    .pipeline-header h6 {
        font-weight: 700;
        font-size: 13.5px;
        color: var(--sp-text);
        margin: 0;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sp-lane-count {
        position: absolute;
        top: 12px;
        right: 12px;
        font-family: var(--sp-font-mono);
        background: var(--sp-surface);
        color: var(--sp-text-soft);
        border: 1px solid var(--sp-border-strong);
        font-weight: 700;
        font-size: 11px;
        border-radius: var(--sp-radius-pill);
        padding: 3px 9px;
        flex-shrink: 0;
    }

    .sp-lane-volume {
        height: 3px;
        border-radius: var(--sp-radius-pill);
        background: var(--sp-surface-3);
        margin: 0 4px 10px;
        overflow: hidden;
    }

    .sp-lane-volume span {
        display: block;
        height: 100%;
        border-radius: var(--sp-radius-pill);
    }

    .pipeline-body {
        min-height: 80px;
        max-height: 72vh;
        overflow-y: auto;
        padding: 2px 4px 4px;
    }

    .pipeline-body::-webkit-scrollbar {
        width: 5px;
    }

    .pipeline-body::-webkit-scrollbar-thumb {
        background: var(--sp-border-strong);
        border-radius: var(--sp-radius-pill);
    }


    /* =========================================================
       CARD — SHARED
       ========================================================= */

    .pipeline-card {
        background: var(--sp-surface);
        padding: 13px 13px 13px 12px;
        border-radius: var(--sp-radius-md);
        margin-bottom: 9px;
        border: 1px solid var(--sp-border);
        border-left: 3px solid var(--sp-border-strong);
        box-shadow: var(--sp-shadow-xs);
        transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        cursor: grab;
        position: relative;
    }

    .pipeline-card[data-type="lead"] {
        border-left-color: var(--sp-slate);
    }

    .pipeline-card[data-type="proforma"] {
        border-left-color: var(--sp-blue);
    }

    .pipeline-card[data-type="quotation"] {
        border-left-color: var(--sp-primary);
    }

    .pipeline-card:hover {
        border-color: var(--sp-accent);
        border-left-color: var(--sp-accent);
        box-shadow: var(--sp-shadow-card);
        transform: translateY(-1px);
    }

    .pipeline-card[data-type="lead"]:hover {
        border-color: var(--sp-slate);
        box-shadow: 0 10px 22px color-mix(in srgb, var(--sp-slate) 20%, transparent);
    }

    .pipeline-card[data-type="proforma"]:hover {
        border-color: var(--sp-blue);
        box-shadow: 0 10px 22px color-mix(in srgb, var(--sp-blue) 20%, transparent);
    }

    .pipeline-card[data-type="quotation"]:hover {
        border-color: var(--sp-primary);
        box-shadow: 0 10px 22px color-mix(in srgb, var(--sp-primary) 20%, transparent);
    }

    .pipeline-card:active {
        cursor: grabbing;
    }

    .cs-sales-pipeline.sp-density-compact .pipeline-card {
        padding: 9px 11px 9px 10px;
        margin-bottom: 7px;
    }

    .dragging {
        opacity: .55;
        background: var(--sp-surface-2);
        transform: rotate(-.6deg);
    }

    .sp-drop-highlight {
        outline: 1.5px dashed var(--sp-accent);
        outline-offset: -3px;
        background: var(--sp-accent-soft) !important;
    }

    .lead-name {
        font-weight: 700;
        font-size: 13.5px;
        color: var(--sp-text);
        margin-bottom: 4px;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .lead-info {
        font-size: 12px;
        color: var(--sp-muted);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .lead-info i {
        color: var(--sp-muted-2);
        font-size: 12px;
        width: 13px;
        text-align: center;
    }

    .lead-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-top: 2px;
    }

    .sp-person-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--sp-text-soft);
    }

    .sp-person-avatar {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--sp-primary-soft);
        color: var(--sp-primary);
        font-family: var(--sp-font-mono);
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .sp-person-chip.is-unassigned {
        color: var(--sp-warning);
    }

    .sp-person-chip.is-unassigned .sp-person-avatar {
        background: var(--sp-warning-soft);
        color: var(--sp-warning);
    }

    .lead-user {
        font-size: 12px;
        color: var(--sp-muted);
    }

    .lead-value {
        font-family: var(--sp-font-mono);
        font-size: 12px;
        font-weight: 700;
        color: var(--sp-success);
    }

    .quotation-number {
        font-family: var(--sp-font-mono);
        font-size: 11px;
        font-weight: 700;
        color: var(--sp-accent);
        letter-spacing: .03em;
    }

    .quotation-type {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: var(--sp-radius-pill);
        background: var(--sp-accent-soft);
        color: var(--sp-accent);
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .sp-card-type-icon {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .sp-card-type-icon.is-quotation {
        background: var(--sp-accent-soft);
        color: var(--sp-accent);
    }

    .sp-card-type-icon.is-proforma {
        background: var(--sp-blue-soft);
        color: var(--sp-blue);
    }

    .sp-stage-pill {
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: var(--sp-radius-pill);
        white-space: nowrap;
        text-transform: capitalize;
    }

    .sp-stage-pill.is-success {
        background: var(--sp-success-soft);
        color: var(--sp-success);
    }

    .sp-stage-pill.is-danger {
        background: var(--sp-danger-soft);
        color: var(--sp-danger);
    }

    .sp-stage-pill.is-warning {
        background: var(--sp-warning-soft);
        color: var(--sp-warning);
    }

    .sp-stage-pill.is-accent {
        background: var(--sp-accent-soft);
        color: var(--sp-accent);
    }

    .sp-stage-pill.is-primary {
        background: var(--sp-primary-soft);
        color: var(--sp-primary);
    }

    .sp-stage-pill.is-muted {
        background: var(--sp-surface-2);
        color: var(--sp-muted);
    }

    .lead-actions {
        display: flex;
        gap: 6px;
    }

    .lead-actions a {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--sp-radius-sm);
        background: var(--sp-surface-2);
        color: var(--sp-text-soft);
        border: 1px solid transparent;
        transition: background .15s ease, border-color .15s ease, color .15s ease;
    }

    .lead-actions a:hover {
        background: var(--sp-primary-soft);
        border-color: var(--sp-primary);
        color: var(--sp-primary);
    }

    .sp-card-select-wrap {
        margin-top: 8px;
    }

    .pipeline-card select.form-select {
        appearance: none;
        -webkit-appearance: none;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-sm);
        background-color: var(--sp-surface-2);
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236B6656' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 9px center;
        background-size: 9px 6px;
        padding-right: 24px;
        font-family: var(--sp-font-sans);
        font-weight: 600;
        color: var(--sp-text-soft);
        cursor: pointer;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .pipeline-card select.form-select:hover {
        border-color: var(--sp-border-strong);
    }

    .pipeline-card select.form-select:focus {
        outline: none;
        border-color: var(--sp-accent);
        box-shadow: 0 0 0 3px var(--sp-accent-soft);
    }


    /* =========================================================
       QUOTATION PENDING ACTIONS
       ========================================================= */

    .pending-quotation-actions {
        margin-top: 11px;
        padding-top: 10px;
        border-top: 1px dashed var(--sp-border);
    }

    .pending-quotation-actions small {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: var(--sp-muted);
        font-size: 11.5px;
    }

    .pending-quotation-buttons {
        display: flex;
        gap: 7px;
    }

    .pending-quotation-buttons .btn {
        flex: 1;
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
        border-radius: var(--sp-radius-sm);
        padding: 7px 10px;
    }

    .pending-quotation-buttons .btn-primary {
        background: var(--sp-primary);
        border-color: var(--sp-primary);
    }

    .pending-quotation-buttons .btn-outline-primary {
        border-color: var(--sp-primary);
        color: var(--sp-primary);
    }

    .pending-quotation-buttons .btn-outline-primary:hover {
        background: var(--sp-primary);
        border-color: var(--sp-primary);
    }

    .pending-quotation-buttons .btn-success {
        background: var(--sp-success);
        border-color: var(--sp-success);
    }


    /* =========================================================
       EMPTY STATE
       ========================================================= */

    .sp-empty-state {
        text-align: center;
        padding: 26px 12px;
        color: var(--sp-muted-2);
    }

    .sp-empty-state i {
        font-size: 20px;
        color: var(--sp-border-strong);
        margin-bottom: 8px;
        display: block;
    }

    .sp-empty-state strong {
        display: block;
        font-size: 12.5px;
        color: var(--sp-muted);
        margin-bottom: 2px;
    }

    .sp-empty-state span {
        font-size: 11.5px;
        color: var(--sp-muted-2);
    }

    .sp-no-search-results {
        display: none;
        text-align: center;
        padding: 30px 12px;
        color: var(--sp-muted-2);
        font-size: 13px;
    }


    /* =========================================================
       QUICK QUOTATION MODAL
       ========================================================= */

    .lm-quote-modal {
        border: 0;
        border-radius: var(--sp-radius-lg);
        overflow: hidden;
        font-family: var(--sp-font-sans);
    }

    .lm-quote-modal .modal-header {
        border-bottom: 1px solid var(--sp-border);
        padding: 16px 20px;
    }

    .lm-quote-modal .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--sp-text);
    }

    .lm-quote-modal .modal-body {
        padding: 18px 20px;
    }

    .lm-quote-row {
        position: relative;
        padding: 15px;
        margin-bottom: 12px;
        background: var(--sp-surface-2);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
    }

    .lm-quote-row label {
        font-size: 12px;
        font-weight: 600;
        color: var(--sp-muted);
        margin-bottom: 4px;
        display: block;
    }

    .lm-quote-remove {
        position: absolute;
        right: 8px;
        top: 8px;
        border: 0;
        background: var(--sp-danger-soft);
        color: var(--sp-danger);
        width: 27px;
        height: 27px;
        border-radius: 50%;
        font-size: 18px;
        line-height: 20px;
        z-index: 2;
    }

    .lm-quote-or {
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: var(--sp-muted-2);
        margin: 5px 0 10px;
    }

    .lm-quote-add {
        border: 0;
        background: transparent;
        color: var(--sp-primary);
        padding: 5px 0;
        font-weight: 700;
        font-size: 13px;
    }

    .lm-quote-switch {
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--sp-surface);
    }

    .lm-quote-switch strong {
        font-size: 13px;
        color: var(--sp-text);
    }

    .lm-quote-switch small {
        display: block;
        color: var(--sp-muted);
    }

    .lm-field-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--sp-text-soft);
    }

    .lm-quote-summary {
        margin-top: 18px;
        border-top: 1px solid var(--sp-border);
        padding-top: 12px;
    }

    .lm-quote-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 7px;
        font-size: 13px;
        color: var(--sp-muted);
    }

    .lm-quote-total {
        background: var(--sp-primary-soft);
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        color: var(--sp-text);
        font-weight: 700;
        font-family: var(--sp-font-mono);
    }

    .lm-quote-status {
        font-size: 13px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .lm-quote-status.success {
        color: var(--sp-success);
    }

    .lm-quote-status.error {
        color: var(--sp-danger);
    }


    /* =========================================================
       DETAILED QUOTATION MODAL
       ========================================================= */

    .lm-detail-quote-modal {
        border: 0;
        border-radius: var(--sp-radius-lg);
        overflow: hidden;
        font-family: var(--sp-font-sans);
    }

    .lm-detail-quote-modal .modal-header {
        border-bottom: 1px solid var(--sp-border);
        padding: 16px 20px;
    }

    .lm-detail-quote-modal .modal-body {
        padding: 18px 20px;
    }

    .lm-detail-quote-eyebrow {
        color: var(--sp-accent);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .lm-detail-quote-modal .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--sp-text);
    }

    .lm-detail-quote-lead {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--sp-accent-soft);
        border-radius: var(--sp-radius-md);
        padding: 12px;
        margin-bottom: 15px;
    }

    .lm-detail-quote-lead-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--sp-accent);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .lm-detail-quote-lead strong {
        color: var(--sp-text);
    }

    .lm-detail-quote-lead small {
        display: block;
        color: var(--sp-muted);
    }

    .lm-detail-quote-search {
        position: relative;
        margin-bottom: 12px;
    }

    .lm-detail-quote-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--sp-muted-2);
    }

    .lm-detail-quote-search input {
        width: 100%;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 10px 12px 10px 38px;
        font-family: var(--sp-font-sans);
    }

    .lm-detail-quote-search input:focus {
        outline: none;
        border-color: var(--sp-accent);
        box-shadow: 0 0 0 3px var(--sp-accent-soft);
    }

    .lm-detail-quote-list {
        max-height: 330px;
        overflow-y: auto;
    }

    .lm-detail-quote-item {
        display: block;
        cursor: pointer;
        margin-bottom: 8px;
    }

    .lm-detail-quote-item input {
        display: none;
    }

    .lm-detail-quote-card {
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        padding: 11px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: border-color .15s ease, background .15s ease;
    }

    .lm-detail-quote-item input:checked + .lm-detail-quote-card {
        border-color: var(--sp-accent);
        background: var(--sp-accent-soft);
    }

    .lm-detail-quote-pdf {
        color: var(--sp-danger);
        font-size: 22px;
    }

    .lm-detail-quote-copy {
        flex: 1;
    }

    .lm-detail-quote-copy strong,
    .lm-detail-quote-copy small {
        display: block;
    }

    .lm-detail-quote-copy strong {
        color: var(--sp-text);
        font-size: 13.5px;
    }

    .lm-detail-quote-copy small {
        color: var(--sp-muted);
    }

    .lm-detail-quote-check {
        color: var(--sp-accent);
        opacity: 0;
    }

    .lm-detail-quote-item input:checked + .lm-detail-quote-card .lm-detail-quote-check {
        opacity: 1;
    }

    .lm-detail-quote-preview {
        display: none;
        margin-top: 12px;
    }

    .lm-detail-quote-preview.is-visible {
        display: block;
    }

    .lm-detail-quote-preview a {
        color: var(--sp-accent);
        font-weight: 600;
        text-decoration: none;
    }

    .lm-detail-quote-status {
        font-size: 13px;
        margin-top: 10px;
        font-weight: 600;
    }

    .lm-detail-quote-status.success {
        color: var(--sp-success);
    }

    .lm-detail-quote-status.error {
        color: var(--sp-danger);
    }

    .lm-detail-quote-send {
        background: #25D366;
        color: white;
        border-radius: var(--sp-radius-sm);
        font-weight: 700;
    }

    .lm-detail-quote-send:hover {
        background: #1fb85a;
        color: white;
    }

    .lm-detail-quote-empty {
        padding: 20px;
        text-align: center;
        color: var(--sp-muted-2);
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1024px) {
        .pipeline-column {
            min-width: 288px;
            width: 288px;
        }
    }

    @media (max-width: 768px) {
        .sp-hero-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .sp-hero-metric {
            align-items: flex-start;
            text-align: left;
        }

        .sp-ledger-item {
            flex: 1 1 45%;
        }

        .sp-flow-legend {
            grid-template-columns: repeat(2, 1fr);
        }

        .sp-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .sp-search-box {
            max-width: none;
        }
    }

    @media (max-width: 480px) {
        .sp-hero {
            padding: 18px 16px 0;
        }

        .sp-hero-title {
            font-size: 26px;
        }

        .sp-hero-metric-value {
            font-size: 28px;
        }

        .sp-ledger-item {
            flex: 1 1 100%;
            border-right: 0;
            border-bottom: 1px solid var(--sp-ink-line);
            padding: 12px 4px;
        }

        .pipeline-wrapper {
            gap: 10px;
            scroll-snap-type: x mandatory;
        }

        .pipeline-column {
            min-width: 87vw;
            width: 87vw;
            scroll-snap-align: start;
        }

        .sp-toolbar-right {
            width: 100%;
            justify-content: space-between;
        }
    }


    /* =========================================================
       PIPELINE LEAD NOTE MODAL
       ========================================================= */

    .sp-note-modal {
        border: 0;
        border-radius: var(--sp-radius-lg);
        overflow: hidden;
        font-family: var(--sp-font-sans);
        box-shadow: 0 22px 65px rgba(20, 24, 20, .18);
    }

    .sp-note-modal .modal-header {
        padding: 17px 20px;
        border-bottom: 1px solid var(--sp-border);
        background: var(--sp-surface);
    }

    .sp-note-eyebrow {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--sp-primary);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .45px;
    }

    .sp-note-modal .modal-title {
        margin: 3px 0 0;
        color: var(--sp-text);
        font-size: 17px;
        font-weight: 700;
    }

    .sp-note-modal .modal-body {
        padding: 18px 20px;
        background: #fbfbf8;
    }

    .sp-note-label {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
        color: var(--sp-text-soft);
        font-size: 11px;
        font-weight: 700;
    }

    .sp-note-label i {
        color: var(--sp-primary);
    }

    .sp-note-field {
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-md);
        background: var(--sp-surface);
        font-family: var(--sp-font-sans);
        font-size: 12px;
        box-shadow: none !important;
    }

    textarea.sp-note-field {
        min-height: 115px;
        resize: vertical;
        padding-top: 10px;
    }

    .sp-note-field:focus {
        border-color: var(--sp-primary);
        box-shadow: 0 0 0 3px var(--sp-primary-soft) !important;
    }

    .sp-note-summary {
        min-height: 42px;
        display: flex;
        align-items: center;
        padding: 9px 11px;
        font-weight: 700;
        color: var(--sp-text-soft);
        background: var(--sp-surface-2);
    }

    .sp-note-info {
        display: flex;
        gap: 8px;
        margin-top: 13px;
        padding: 10px 12px;
        border: 1px solid #cfe1da;
        border-radius: var(--sp-radius-md);
        background: var(--sp-primary-soft);
        color: var(--sp-muted);
        font-size: 10.5px;
        line-height: 1.45;
    }

    .sp-note-info i {
        color: var(--sp-primary);
        margin-top: 1px;
    }

    .sp-note-modal .modal-footer {
        padding: 13px 20px;
        border-top: 1px solid var(--sp-border);
        background: var(--sp-surface);
    }

    .sp-note-modal .modal-footer .btn {
        min-height: 39px;
        border-radius: var(--sp-radius-sm);
        font-size: 11.5px;
        font-weight: 700;
    }

    @media (max-width: 575.98px) {
        #pipelineLeadNoteModal .modal-dialog {
            margin: 10px;
        }

        .sp-note-modal .modal-body {
            padding: 16px;
        }

        .sp-note-modal .modal-footer .btn-primary {
            flex: 1;
        }
    }


</style>
@endpush


@section('content')

<div class="cs-sales-pipeline">

    {{-- =========================================================
         HERO — breadcrumb, serif title, headline conversion
         metric and a closing ledger strip. Every figure below is
         read straight from the same collections the board itself
         renders from, nothing here is invented.
         ========================================================= --}}

    <div class="sp-hero">

        <div class="sp-hero-top">

            <div class="sp-hero-heading">

                <nav class="sp-crumb">
                    <a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a>
                    <span>/</span>
                    <span>{{ get_phrase('Sales Pipeline') }}</span>
                </nav>

                <h1 class="sp-hero-title">{{ get_phrase('Sales Pipeline') }}</h1>

                <p class="sp-hero-subtitle">
                    {{ get_phrase('Manage leads, proposals and conversions in one workspace.') }}
                </p>

            </div>

            <div class="sp-hero-metric">
                <span class="sp-hero-metric-label">{{ get_phrase('Conversion Rate') }}</span>
                <span class="sp-hero-metric-value">{{ $conversionRate }}<small>%</small></span>
                <span class="sp-hero-metric-hint">
                    {{ $wonCount }} {{ get_phrase('won of') }} {{ $totalPipelineItems }}
                </span>
            </div>

        </div>

        <div class="sp-ledger">

            <div class="sp-ledger-item">
                <span class="sp-ledger-value">{{ $totalPipelineItems }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Total Pipeline') }}</span>
            </div>

            <div class="sp-ledger-item">
                <span class="sp-ledger-value">{{ $activeCount }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Active') }}</span>
            </div>

            <div class="sp-ledger-item">
                <span class="sp-ledger-value">{{ $proposalPendingCount }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Proposal Pending') }}</span>
            </div>

            <div class="sp-ledger-item">
                <span class="sp-ledger-value">{{ $proformaPendingCount }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Proforma Pending') }}</span>
            </div>

            <div class="sp-ledger-item">
                <span class="sp-ledger-value">{{ $proposalSentCount }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Proposal Sent') }}</span>
            </div>

            <div class="sp-ledger-item is-positive">
                <span class="sp-ledger-value">{{ $wonCount }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Won') }}</span>
            </div>

            <div class="sp-ledger-item is-negative">
                <span class="sp-ledger-value">{{ $lostCount }}</span>
                <span class="sp-ledger-label">{{ get_phrase('Lost') }}</span>
            </div>

        </div>

    </div>


    {{-- =========================================================
         PIPELINE FLOW — a single proportional distribution bar
         plus a legend, in place of a repeated progress-bar list.
         ========================================================= --}}

    <div class="sp-flow">

        <div class="sp-flow-head">
            <span class="sp-flow-title">{{ get_phrase('Pipeline Health') }}</span>
            <span class="sp-flow-hint">{{ get_phrase('Distribution across stages') }}</span>
        </div>

        <div class="sp-flow-bar">

            @foreach($stages as $stage)

                @php
                    $stageTotalForChart = $stageCounts[$stage] ?? 0;

                    $stageSharePercent = $totalPipelineItems > 0
                        ? round(($stageTotalForChart / $totalPipelineItems) * 100, 2)
                        : 0;

                    $stageAccent = $stageAccentMap[$stage] ?? 'accent';
                @endphp

                @if($stageTotalForChart > 0)
                    <span
                        class="sp-flow-seg"
                        style="width: {{ $stageSharePercent }}%; background: var(--sp-{{ $stageAccent }});"
                        title="{{ $stage }}: {{ $stageTotalForChart }}"
                    ></span>
                @endif

            @endforeach

        </div>

        <div class="sp-flow-legend">

            @foreach($stages as $stage)

                @php
                    $stageTotalForChart = $stageCounts[$stage] ?? 0;
                    $stageAccent = $stageAccentMap[$stage] ?? 'accent';
                @endphp

                <div class="sp-flow-legend-item">
                    <span class="sp-flow-dot" style="background: var(--sp-{{ $stageAccent }});"></span>
                    <span class="sp-flow-legend-label" title="{{ $stage }}">{{ $stage }}</span>
                    <span class="sp-flow-legend-count">{{ $stageTotalForChart }}</span>
                </div>

            @endforeach

        </div>

    </div>


    {{-- =========================================================
         TOOLBAR — client-side search only; it filters cards that
         are already rendered below, no new backend call.
         ========================================================= --}}

    <div class="sp-toolbar">

        <div class="sp-search-box">
            <i class="fi-rr-search"></i>
            <input
                type="text"
                id="pipelineSearchInput"
                placeholder="{{ get_phrase('Search by name or phone...') }}"
                oninput="filterPipelineCards(this.value)"
            >
        </div>

        <div class="sp-toolbar-right">

            <span class="sp-result-count" id="pipelineResultCount"></span>

            <div class="sp-density-toggle">
                <button
                    type="button"
                    class="sp-density-btn is-active"
                    id="spDensityComfortable"
                    onclick="setPipelineDensity('comfortable')"
                >
                    {{ get_phrase('Comfortable') }}
                </button>
                <button
                    type="button"
                    class="sp-density-btn"
                    id="spDensityCompact"
                    onclick="setPipelineDensity('compact')"
                >
                    {{ get_phrase('Compact') }}
                </button>
            </div>

        </div>

    </div>


    {{-- =========================================================
         PIPELINE
         ========================================================= --}}

    <div class="pipeline-wrapper">

        @foreach($stages as $stage)

            @php
                $stageLeads = $leads->where('stage', $stage);

                $stageProformas = $proformas->where('stage', $stage);

                $stageQuotations = $quotations->filter(function ($quotation) use ($stage) {
                    return optional($quotation->lead)->stage === $stage;
                });

                $stageCount =
                    $stageLeads->count()
                    + $stageProformas->count()
                    + $stageQuotations->count();

                $columnDesign = $stageDesign[$stage] ?? $defaultStageDesign;
                $columnAccent = $columnDesign['color'];
                $columnIcon = $columnDesign['icon'];

                $laneVolumePercent = $maxStageCount > 0
                    ? max($stageCount > 0 ? 4 : 0, round(($stageCount / $maxStageCount) * 100))
                    : 0;
            @endphp

            <div class="pipeline-column" style="--lane-accent: var(--sp-{{ $columnAccent }});">

                <span class="sp-column-accent-bar" style="background: var(--sp-{{ $columnAccent }});"></span>

                <div class="pipeline-header">

                    <span class="sp-lane-count">
                        {{ $stageCount }}
                    </span>

                    <div class="sp-seal {{ $stage === 'Won' ? 'is-crown' : '' }}">
                        <i class="{{ $columnIcon }}"></i>
                    </div>

                    <h6 title="{{ $stage }}">{{ $stage }}</h6>

                </div>

                <div class="sp-lane-volume">
                    <span style="width: {{ $laneVolumePercent }}%; background: var(--sp-{{ $columnAccent }});"></span>
                </div>

                <div
                    class="pipeline-body pipeline-sortable"
                    data-stage="{{ $stage }}"
                >

                    {{-- =================================================
                         LEADS
                         ================================================= --}}

                    @foreach($stageLeads as $lead)

                        <div
                            class="pipeline-card lead-pipeline-card"
                            data-type="lead"
                            data-id="{{ $lead->id }}"
                            data-lead-id="{{ $lead->id }}"
                            data-name="{{ $lead->name }}"
                            data-phone="{{ $lead->phone }}"
                            data-salesperson="{{ $lead->userlead->name ?? '' }}"
                        >

                            <div class="d-flex justify-content-between align-items-center gap-2 mb-1">

                                <div class="lead-name" title="{{ $lead->name }}">
                                    {{ \Illuminate\Support\Str::limit($lead->name, 18) }}
                                </div>

                                <select
                                    class="form-select form-select-sm change-lead-stage"
                                    data-id="{{ $lead->id }}"
                                    data-name="{{ $lead->name }}"
                                    data-phone="{{ $lead->phone }}"
                                    data-current-stage="{{ $lead->stage }}"
                                    style="width:145px;font-size:11px;"
                                >
                                    @foreach($stages as $pipelineStage)
                                        <option
                                            value="{{ $pipelineStage }}"
                                            {{ $lead->stage === $pipelineStage ? 'selected' : '' }}
                                        >
                                            {{ $pipelineStage }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="lead-info">
                                <i class="fi-rr-phone-call"></i>
                                {{ $lead->phone ?: 'No Phone' }}
                            </div>

                            <div class="lead-footer">
                                @if($lead->userlead && $lead->userlead->name)
                                    <span class="sp-person-chip">
                                        <span class="sp-person-avatar">
                                            {{ \Illuminate\Support\Str::substr($lead->userlead->name, 0, 1) }}
                                        </span>
                                        {{ $lead->userlead->name }}
                                    </span>
                                @else
                                    <span class="sp-person-chip is-unassigned">
                                        <span class="sp-person-avatar">
                                            <i class="fi-rr-user" style="font-size:9px;"></i>
                                        </span>
                                        {{ get_phrase('Unassigned') }}
                                    </span>
                                @endif
                            </div>

                            <div class="lead-actions mt-2 d-flex gap-2">

                                <a
                                    href="#"
                                    onclick="showRightModal(
                                        '{{ route('right_modal', [
                                            'view_path' => 'admin/leads/leadschat',
                                            'id' => $lead->id
                                        ]) }}',
                                        '{{ get_phrase('History Chats') }}'
                                    ); return false;"
                                    class="btn btn-sm btn-light"
                                    title="Chat History"
                                >
                                    <i class="fi-rr-comments"></i>
                                </a>

                                <a
                                    href="#"
                                    onclick="showRightModal(
                                        '{{ route('right_modal', [
                                            'view_path' => 'admin/leads/callagaindetails',
                                            'id' => $lead->id
                                        ]) }}',
                                        '{{ get_phrase('Call Notes') }}'
                                    ); return false;"
                                    class="btn btn-sm btn-light"
                                    title="Call Notes"
                                >
                                    <i class="fi-rr-document"></i>
                                </a>

                            </div>

                            @if($lead->stage === 'Proposal Pending')

                                <div class="pending-quotation-actions">

                                    <small>
                                        {{ get_phrase('Select Quotation Type') }}
                                    </small>

                                    <div class="pending-quotation-buttons">

                                        {{-- <button
                                            type="button"
                                            class="btn btn-primary"
                                            onclick="openQuickQuotation(
                                                {{ $lead->id }},
                                                @js($lead->name),
                                                @js($lead->phone)
                                            )"
                                        >
                                            Quick Quotation
                                        </button> --}}

                                        <button
                                            type="button"
                                            class="btn btn-outline-primary"
                                            onclick="openDetailedQuotationModal(
                                                {{ $lead->id }},
                                                @js($lead->name),
                                                @js($lead->phone)
                                            )"
                                        >
                                            Detailed Proposal
                                        </button>

                                    </div>

                                </div>

                            @endif

                            @if($lead->stage === 'Proforma Pending')

                                <div class="pending-quotation-actions">

                                    <small>
                                        {{ get_phrase('Proforma Ready to Create') }}
                                    </small>

                                    <button
                                        type="button"
                                        class="btn btn-success w-100"
                                        onclick="openQuickQuotation(
                                            {{ $lead->id }},
                                            @js($lead->name),
                                            @js($lead->phone)
                                        )"
                                    >
                                        Send Proforma
                                    </button>

                                </div>

                            @endif

                        </div>

                    @endforeach


                    {{-- =================================================
                         PROFORMAS
                         ================================================= --}}

                    @foreach($stageProformas as $proforma)

                        @php
                            $proformaNumber = $proforma->proforma_no
                                ?: 'PF-' . str_pad($proforma->id, 5, '0', STR_PAD_LEFT);

                            $proformaCustomerName = optional($proforma->lead)->name
                                ?? data_get($proforma->customer, 'company_name')
                                ?? data_get($proforma->customer, 'name')
                                ?? 'Lead Proforma';

                            $proformaPhone = optional($proforma->lead)->phone ?? null;
                        @endphp

                        <div
                            class="pipeline-card proforma-pipeline-card"
                            data-type="proforma"
                            data-id="{{ $proforma->id }}"
                            data-lead-id="{{ $proforma->lead_id }}"
                            data-name="{{ $proformaCustomerName }}"
                            data-phone="{{ $proformaPhone }}"
                        >

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="quotation-number">
                                    {{ $proformaNumber }}
                                </span>

                                <span class="quotation-type" style="background:var(--sp-blue-soft);color:var(--sp-blue);">
                                    Proforma
                                </span>

                            </div>

                            <div class="lead-name" title="{{ $proformaCustomerName }}">
                                {{ \Illuminate\Support\Str::limit($proformaCustomerName, 22) }}
                            </div>

                            @if($proformaPhone)
                                <div class="lead-info">
                                    <i class="fi-rr-phone-call"></i>
                                    {{ $proformaPhone }}
                                </div>
                            @endif

                            {{--  --}}

                            @if($proforma->lead)

                                <div class="lead-actions mt-2 mb-2 d-flex gap-2">

                                    <a
                                        href="#"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', [
                                                'view_path' => 'admin/leads/leadschat',
                                                'id' => $proforma->lead->id
                                            ]) }}',
                                            '{{ get_phrase('History Chats') }}'
                                        ); return false;"
                                        class="btn btn-sm btn-light"
                                        title="Chat History"
                                    >
                                        <i class="fi-rr-comments"></i>
                                    </a>

                                    <a
                                        href="#"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', [
                                                'view_path' => 'admin/leads/callagaindetails',
                                                'id' => $proforma->lead->id
                                            ]) }}',
                                            '{{ get_phrase('Call Notes') }}'
                                        ); return false;"
                                        class="btn btn-sm btn-light"
                                        title="Call Notes"
                                    >
                                        <i class="fi-rr-document"></i>
                                    </a>

                                </div>

                            @endif


                            {{--  --}}

                            <div class="lead-info">
                                <i class="fi-rr-calendar"></i>
                                {{ optional($proforma->proforma_date)->format('d M Y') ?? $proforma->proforma_date ?? '-' }}
                            </div>

                            {{-- @if($proforma->items->count())
                                <div class="lead-info">
                                    <strong>{{ get_phrase('Items') }}:</strong>
                                    {{ $proforma->items->count() }}
                                </div>
                            @endif --}}

                            {{-- <div class="lead-footer mb-2">

                                <span class="lead-user">
                                    {{ optional(optional($proforma->lead)->userlead)->name ?? 'Unknown' }}
                                </span>

                                <span class="lead-value">
                                    ₹{{ number_format((float) ($proforma->total ?? 0), 2) }}
                                </span>

                            </div> --}}

                            <div class="sp-card-select-wrap">
                                <select
                                    class="form-select form-select-sm change-proforma-stage"
                                    data-id="{{ $proforma->id }}"
                                    data-lead-id="{{ $proforma->lead_id }}"
                                    data-name="{{ $proformaCustomerName }}"
                                    data-current-stage="{{ $proforma->stage }}"
                                    style="font-size:11px;"
                                >
                                    @foreach($stages as $pipelineStage)
                                        <option
                                            value="{{ $pipelineStage }}"
                                            {{ $proforma->stage === $pipelineStage ? 'selected' : '' }}
                                        >
                                            {{ $pipelineStage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    @endforeach


                    {{-- =================================================
                         DETAILED QUOTATIONS
                         ================================================= --}}

                    @foreach($stageQuotations as $quotation)

                        @php
                            $quotationNumber =
                                'QT-' . str_pad($quotation->id, 5, '0', STR_PAD_LEFT);

                            $customerName =
                                optional($quotation->lead)->name
                                ?? data_get($quotation->client, 'company_name')
                                ?? data_get($quotation->client, 'name')
                                ?? 'Custom Quotation';

                            $customerPhone =
                                optional($quotation->lead)->phone
                                ?? data_get($quotation->client, 'phone')
                                ?? null;

                            $subtotal = $quotation->items->sum(function($item) {
                                return (float) $item->unit_price * (float) $item->quantity;
                            });

                            $discountPercent = (float) ($quotation->discount ?? 0);
                            $discountAmount = ($subtotal * $discountPercent) / 100;
                            $afterDiscount = $subtotal - $discountAmount;
                            $vatPercent = (float) ($quotation->vat ?? 0);
                            $vatAmount = ($afterDiscount * $vatPercent) / 100;
                            $grandTotal = $afterDiscount + $vatAmount;

                            $isQuickQuotation = strtolower($quotation->quotation_type ?? '') === 'quick';
                        @endphp

                        <div
                            class="pipeline-card quotation-pipeline-card"
                            data-type="quotation"
                            data-id="{{ $quotation->id }}"
                            data-lead-id="{{ $quotation->lead_id }}"
                            data-name="{{ $customerName }}"
                            data-phone="{{ $customerPhone }}"
                        >

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="quotation-number">
                                    {{ $quotationNumber }}
                                </span>

                                {{-- <span class="quotation-type">
                                    {{ $quotation->quotation_type ?? 'detailed' }}
                                </span> --}}

                                <span class="quotation-type">
                                    @if($isQuickQuotation)
                                        Quick Proposal
                                    @else
                                        Detailed Proposal
                                    @endif
                                </span>

                            </div>

                            <div class="lead-name" title="{{ $customerName }}">
                                {{ \Illuminate\Support\Str::limit($customerName, 22) }}
                            </div>

                            @if($customerPhone)
                                <div class="lead-info">
                                    <i class="fi-rr-phone-call"></i>
                                    {{ $customerPhone }}
                                </div>
                            @endif

                            {{--  --}}

                            @if($quotation->lead)

                                <div class="lead-actions mt-2 mb-2 d-flex gap-2">

                                    <a
                                        href="#"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', [
                                                'view_path' => 'admin/leads/leadschat',
                                                'id' => $quotation->lead->id
                                            ]) }}',
                                            '{{ get_phrase('History Chats') }}'
                                        ); return false;"
                                        class="btn btn-sm btn-light"
                                        title="Chat History"
                                    >
                                        <i class="fi-rr-comments"></i>
                                    </a>

                                    <a
                                        href="#"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', [
                                                'view_path' => 'admin/leads/callagaindetails',
                                                'id' => $quotation->lead->id
                                            ]) }}',
                                            '{{ get_phrase('Call Notes') }}'
                                        ); return false;"
                                        class="btn btn-sm btn-light"
                                        title="Call Notes"
                                    >
                                        <i class="fi-rr-document"></i>
                                    </a>

                                </div>

                            @endif


                            {{--  --}}

                            <div class="lead-info">
                                <i class="fi-rr-calendar"></i>
                                {{ optional($quotation->create_date)->format('d M Y') ?? '-' }}
                            </div>

                            @if($quotation->items->count())
                                {{-- <div class="lead-info">
                                    <strong>{{ get_phrase('Items') }}:</strong>
                                    {{ $quotation->items->count() }}
                                </div> --}}
                            @endif

                            <div class="lead-footer mb-2">

                                <span class="lead-user">
                                    {{-- {{ optional($quotation->user)->name ?? 'Unknown' }} --}}
                                </span>

                                <span class="lead-value">
                                    {{-- ₹{{ number_format($grandTotal, 2) }} --}}
                                </span>

                            </div>

                            <div class="sp-card-select-wrap">
                                <select
                                    class="form-select form-select-sm change-quotation-stage"
                                    data-id="{{ $quotation->id }}"
                                    data-lead-id="{{ $quotation->lead_id }}"
                                    data-name="{{ $customerName }}"
                                    data-phone="{{ $customerPhone }}"
                                    data-current-stage="{{ optional($quotation->lead)->stage }}"
                                    style="font-size:11px;"
                                >
                                    @foreach($stages as $pipelineStage)
                                        <option
                                            value="{{ $pipelineStage }}"
                                            {{ optional($quotation->lead)->stage === $pipelineStage ? 'selected' : '' }}
                                        >
                                            {{ $pipelineStage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    @endforeach


                    @if($stageCount === 0)
                        <div class="sp-empty-state pipeline-empty">
                            <i class="fi-rr-inbox"></i>
                            <strong>{{ get_phrase('No records') }}</strong>
                            <span>{{ get_phrase('Move a lead here as it progresses.') }}</span>
                        </div>
                    @endif

                    <div class="sp-no-search-results">
                        {{ get_phrase('No matching records in this stage.') }}
                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- =========================================================
     QUICK QUOTATION MODAL
     ========================================================= --}}

<div
    class="modal fade"
    id="quickQuotationModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content lm-quote-modal">

            <div class="modal-header">

                <div>

                    <h5 class="modal-title mb-0">
                        {{ get_phrase('Quick Proforma') }}
                    </h5>

                    <small
                        class="text-muted"
                        id="quoteCustomerName"
                    ></small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="quoteLeadId"
                >

                <input
                    type="hidden"
                    id="quotePhone"
                >


                <div id="quoteProductRows"></div>


                <button
                    type="button"
                    class="lm-quote-add"
                    onclick="addQuickQuoteProduct()"
                >
                    <i class="bi bi-plus-circle"></i>

                    {{ get_phrase('Add Product') }}
                </button>


                <hr>


                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="lm-quote-switch">

                            <div>

                                <strong>
                                    {{ get_phrase('Add GST') }}
                                </strong>

                                <small>18%</small>

                            </div>

                            <input
                                type="checkbox"
                                id="quoteGst"
                                onchange="calculateQuickQuote()"
                            >

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="lm-quote-switch">

                            <strong>
                                {{ get_phrase('Add Discount') }}
                            </strong>

                            <input
                                type="checkbox"
                                id="quoteDiscountSwitch"
                                onchange="toggleQuickDiscount()"
                            >

                        </div>

                    </div>

                </div>


                <div
                    id="quoteDiscountBox"
                    class="mt-3"
                    style="display:none;"
                >

                    <label class="lm-field-label">
                        {{ get_phrase('Discount %') }}
                    </label>

                    <input
                        type="number"
                        id="quoteDiscount"
                        class="form-control"
                        value="0"
                        min="0"
                        max="100"
                        oninput="calculateQuickQuote()"
                    >

                </div>


                <div class="mt-3">

                    <label class="lm-field-label">
                        {{ get_phrase('Additional Note') }}
                    </label>

                    <textarea
                        id="quoteNote"
                        class="form-control"
                        rows="3"
                    ></textarea>

                </div>


                <div class="lm-quote-summary">

                    <div class="lm-quote-summary-row">

                        <span>
                            {{ get_phrase('Subtotal') }}
                        </span>

                        <strong>
                            ₹<span id="quoteSubtotal">0.00</span>
                        </strong>

                    </div>


                    <div
                        id="quoteDiscountSummary"
                        class="lm-quote-summary-row"
                        style="display:none;"
                    >

                        <span>
                            {{ get_phrase('Discount') }}
                        </span>

                        <strong>
                            -₹<span id="quoteDiscountAmount">0.00</span>
                        </strong>

                    </div>


                    <div
                        id="quoteGstSummary"
                        class="lm-quote-summary-row"
                        style="display:none;"
                    >

                        <span>
                            {{ get_phrase('GST') }}
                        </span>

                        <strong>
                            ₹<span id="quoteGstAmount">0.00</span>
                        </strong>

                    </div>

                </div>

            </div>


            <div class="lm-quote-total">

                <span>
                    {{ get_phrase('Total') }}
                </span>

                <strong>
                    ₹<span id="quoteGrandTotal">0.00</span>/-
                </strong>

            </div>


            <div class="modal-footer d-block">

                <div
                    id="quoteSaveStatus"
                    class="lm-quote-status"
                ></div>


                <button
                    type="button"
                    class="btn btn-success w-100"
                    id="quoteWhatsAppButton"
                    onclick="sendQuickQuotationWhatsApp()"
                >

                    <i class="bi bi-whatsapp me-1"></i>

                    {{ get_phrase('Save & Send on WhatsApp') }}

                </button>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     DETAILED QUOTATION MODAL
     ========================================================= --}}

<div
    class="modal fade"
    id="detailedQuotationModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content lm-detail-quote-modal">

            <div class="modal-header">

                <div>

                    <div class="lm-detail-quote-eyebrow">

                        <i class="bi bi-file-earmark-pdf-fill"></i>

                        {{ get_phrase('Detailed Proposal') }}

                    </div>

                    <h5 class="modal-title">

                        {{ get_phrase('Select PDF Proposal') }}

                    </h5>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="detailQuoteLeadId"
                >

                <input
                    type="hidden"
                    id="detailQuotePhone"
                >


                <div class="lm-detail-quote-lead">

                    <div class="lm-detail-quote-lead-icon">

                        <i class="bi bi-person"></i>

                    </div>


                    <div>

                        <strong id="detailQuoteLeadName">
                            {{ get_phrase('Lead') }}
                        </strong>

                        <small id="detailQuoteLeadPhone"></small>

                    </div>

                </div>


                <div class="mb-3">

                    <label
                        for="detailQuoteCategory"
                        class="lm-field-label"
                    >
                        <i class="bi bi-folder2-open"></i>
                        {{ get_phrase('Select Category') }}
                    </label>

                    <select
                        id="detailQuoteCategory"
                        class="form-select"
                        onchange="filterDetailedQuotations()"
                    >
                        <option value="">
                            {{ get_phrase('Select Proposal Category') }}
                        </option>

                        @foreach($detailedQuotationCategories as $quotationCategory)
                            <option value="{{ $quotationCategory->id }}">
                                {{ $quotationCategory->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div
                    class="lm-detail-quote-search"
                    id="detailQuoteSearchBox"
                    style="display:none;"
                >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="detailQuoteSearch"
                        placeholder="{{ get_phrase('Search proposal PDF...') }}"
                        oninput="filterDetailedQuotations()"
                    >

                </div>


                <div
                    class="lm-detail-quote-list"
                    id="detailQuoteList"
                >

                    <div
                        class="lm-detail-quote-empty"
                        id="detailQuoteCategoryMessage"
                    >
                        <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>
                        {{ get_phrase('Please select a category to view proposal PDFs.') }}
                    </div>

                   @forelse ($detailedQuotations as $detailedQuotation)

                        <label
                            class="lm-detail-quote-item"
                            data-category-id="{{ $detailedQuotation->category_id }}"
                            data-quotation-name="{{ strtolower($detailedQuotation->name) }}"
                            style="display:none;"
                        >

                            <input
                                type="radio"
                                name="detailed_quotation_id"
                                value="{{ $detailedQuotation->id }}"
                                data-name="{{ $detailedQuotation->name }}"
                                data-view-url="{{ route(
                                    'admin.detailed-quotations.show',
                                    $detailedQuotation->id
                                ) }}"
                                onchange="selectDetailedQuotation(this)"
                            >


                            <span class="lm-detail-quote-card">

                                <span class="lm-detail-quote-pdf">

                                    <i class="bi bi-file-earmark-pdf-fill"></i>

                                </span>


                                <span class="lm-detail-quote-copy">

                                    <strong>
                                        {{ $detailedQuotation->name }}
                                    </strong>

                                    <small>
                                        {{ $detailedQuotation->category?->name }}
                                        ·
                                        {{ get_phrase('PDF quotation') }}
                                    </small>

                                </span>


                                <span class="lm-detail-quote-check">

                                    <i class="bi bi-check-lg"></i>

                                </span>

                            </span>

                        </label>

                         @empty

                            <div class="lm-detail-quote-empty">

                                <i class="bi bi-file-earmark-x fs-4 d-block mb-2"></i>

                                {{ get_phrase('No detailed quotations have been uploaded yet.') }}

                            </div>

                        @endforelse

                </div>


                <div
                    class="lm-detail-quote-preview"
                    id="detailQuotePreview"
                >

                    <a
                        href="#"
                        id="detailQuotePreviewLink"
                        target="_blank"
                    >

                        <i class="bi bi-eye"></i>

                        {{ get_phrase('View Selected PDF') }}

                    </a>

                </div>


                <div
                    id="detailQuoteStatus"
                    class="lm-detail-quote-status"
                ></div>

            </div>


            <div class="modal-footer d-block">

                <button
                    type="button"
                    class="btn lm-detail-quote-send w-100"
                    id="detailQuoteWhatsAppButton"
                    onclick="sendDetailedQuotationWhatsApp()"
                >

                    <i class="bi bi-whatsapp me-1"></i>

                    {{ get_phrase('Send Selected PDF on WhatsApp') }}

                </button>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     PIPELINE LEAD NOTE MODAL
     Required only for:
     Contacted, Proposal Pending, Proforma Pending,
     Payment Waiting, Won, Lost
========================================================= --}}

<div
    class="modal fade"
    id="pipelineLeadNoteModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content sp-note-modal">

            <div class="modal-header">

                <div>
                    <div class="sp-note-eyebrow">
                        <i class="bi bi-journal-text"></i>
                        {{ get_phrase('Lead Note Required') }}
                    </div>

                    <h5
                        class="modal-title"
                        id="pipelineLeadNoteTitle"
                    >
                        {{ get_phrase('Update Pipeline Stage') }}
                    </h5>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <div class="modal-body">

                <div class="mb-3">

                    <label class="sp-note-label">
                        <i class="bi bi-person"></i>
                        {{ get_phrase('Lead') }}
                    </label>

                    <div
                        id="pipelineLeadNoteLeadName"
                        class="form-control sp-note-field sp-note-summary"
                    >
                        -
                    </div>

                </div>

                <div class="mb-3">

                    <label class="sp-note-label">
                        <i class="bi bi-flag"></i>
                        {{ get_phrase('Move To Stage') }}
                    </label>

                    <div
                        id="pipelineLeadNoteStage"
                        class="form-control sp-note-field sp-note-summary"
                    >
                        -
                    </div>

                </div>

                <div>

                    <label
                        for="pipelineLeadNoteInput"
                        class="sp-note-label"
                    >
                        <i class="bi bi-chat-left-text"></i>
                        {{ get_phrase('Lead Note') }}
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="pipelineLeadNoteInput"
                        rows="5"
                        maxlength="2000"
                        class="form-control sp-note-field"
                        placeholder="{{ get_phrase('Write lead note before changing the stage...') }}"
                    ></textarea>

                    <div
                        id="pipelineLeadNoteError"
                        class="text-danger mt-1"
                        style="display:none;font-size:10.5px;font-weight:600;"
                    >
                        {{ get_phrase('Lead Note is required.') }}
                    </div>

                </div>

                <div class="sp-note-info">
                    <i class="bi bi-info-circle"></i>

                    <div>
                        {{ get_phrase('The Lead Note will be saved first. The pipeline stage will change only after the note is saved successfully.') }}
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    {{ get_phrase('Cancel') }}
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="pipelineLeadNoteSubmitBtn"
                    onclick="submitPipelineLeadNote()"
                >
                    <i class="bi bi-check2-circle me-1"></i>
                    {{ get_phrase('Save Note & Continue') }}
                </button>

            </div>

        </div>

    </div>
</div>

@endsection



@push('js')

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


<script>

    /* =========================================================
       QUICK QUOTATION
       ========================================================= */

    let quickQuoteModal = null;

    const quickQuoteProducts = {!! $quoteProductsJson !!};


    function productOptions()
    {
        let html =
            '<option value="">Select Product</option>';

        quickQuoteProducts.forEach(function(product) {

            html += `
                <option
                    value="${product.id}"
                    data-price="${product.sale_price}"
                >
                    ${product.name}
                </option>
            `;

        });

        return html;
    }


    function quoteRowHtml(remove = true)
    {
        return `

            <div class="lm-quote-row">

                ${remove
                    ? `
                        <button
                            type="button"
                            class="lm-quote-remove"
                            onclick="removeQuickQuoteProduct(this)"
                        >
                            ×
                        </button>
                    `
                    : ''
                }

                <div class="mb-3">
                    <label>Product / Service</label>

                    <select
                        class="form-control quote-product"
                        onchange="handleQuickQuoteProductChange(this)"
                    >
                        ${productOptions()}
                    </select>
                </div>

                <div class="lm-quote-or">OR</div>

                <div class="mb-3">
                    <label>Custom Product / Service</label>

                    <input
                        type="text"
                        class="form-control quote-custom-description"
                        placeholder="Type custom product or service"
                        oninput="handleQuickQuoteCustomText(this)"
                    >
                </div>

                <div class="row g-2">

                    <div class="col-md-4">
                        <label>HSN Code</label>

                        <input
                            type="text"
                            class="form-control quote-hsn"
                            placeholder="Enter HSN code"
                        >
                    </div>

                    <div class="col-md-4">
                        <label>Price / Unit</label>

                        <div class="input-group">
                            <span class="input-group-text">₹</span>

                            <input
                                type="number"
                                class="form-control quote-price"
                                value="0"
                                min="0"
                                step="0.01"
                                oninput="calculateQuickQuote()"
                            >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label>Quantity</label>

                        <input
                            type="number"
                            class="form-control quote-quantity"
                            value="1"
                            min="1"
                            step="1"
                            oninput="calculateQuickQuote()"
                        >
                    </div>

                </div>

            </div>

        `;
    }


    function openQuickQuotation(
        leadId,
        leadName,
        phone
    )
    {
        document.getElementById(
            'quoteLeadId'
        ).value = leadId;

        document.getElementById(
            'quotePhone'
        ).value = phone || '';

        document.getElementById(
            'quoteCustomerName'
        ).innerText =
            'For: ' + (leadName || '');


        document.getElementById(
            'quoteGst'
        ).checked = false;

        document.getElementById(
            'quoteDiscountSwitch'
        ).checked = false;

        document.getElementById(
            'quoteDiscount'
        ).value = 0;

        document.getElementById(
            'quoteDiscountBox'
        ).style.display = 'none';

        document.getElementById(
            'quoteNote'
        ).value = '';

        document.getElementById(
            'quoteSaveStatus'
        ).innerText = '';

        document.getElementById(
            'quoteProductRows'
        ).innerHTML =
            quoteRowHtml(false);


        calculateQuickQuote();


        quickQuoteModal =
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById(
                    'quickQuotationModal'
                )
            );

        quickQuoteModal.show();
    }


    function addQuickQuoteProduct()
    {
        document.getElementById(
            'quoteProductRows'
        ).insertAdjacentHTML(
            'beforeend',
            quoteRowHtml(true)
        );
    }


    function removeQuickQuoteProduct(button)
    {
        button
            .closest('.lm-quote-row')
            .remove();

        calculateQuickQuote();
    }


    function handleQuickQuoteProductChange(select)
    {
        const row =
            select.closest('.lm-quote-row');

        const selected =
            select.options[
                select.selectedIndex
            ];

        const price =
            parseFloat(
                selected?.dataset?.price || 0
            );


        row.querySelector(
            '.quote-price'
        ).value =
            Number.isFinite(price)
                ? price
                : 0;


        if (select.value) {

            row.querySelector(
                '.quote-custom-description'
            ).value = '';

        }

        calculateQuickQuote();
    }


    function handleQuickQuoteCustomText(input)
    {
        const row =
            input.closest('.lm-quote-row');

        if (
            input.value.trim() !== ''
        ) {

            row.querySelector(
                '.quote-product'
            ).value = '';

        }

        calculateQuickQuote();
    }


    function toggleQuickDiscount()
    {
        const enabled =
            document.getElementById(
                'quoteDiscountSwitch'
            ).checked;


        document.getElementById(
            'quoteDiscountBox'
        ).style.display =
            enabled
                ? 'block'
                : 'none';


        if (!enabled) {

            document.getElementById(
                'quoteDiscount'
            ).value = 0;

        }

        calculateQuickQuote();
    }


    function getQuickQuotationData()
    {
        let products = [];

        let subtotal = 0;


        document
            .querySelectorAll(
                '.lm-quote-row'
            )
            .forEach(function(row) {

                const select =
                    row.querySelector(
                        '.quote-product'
                    );

                const customInput =
                    row.querySelector(
                        '.quote-custom-description'
                    );


                const productId =
                    select.value || null;

                const customDescription =
                    customInput.value.trim();


                const hsnCode =
                    row.querySelector(
                        '.quote-hsn'
                    ).value.trim();


                if (
                    !productId &&
                    !customDescription
                ) {
                    return;
                }


                let productName =
                    customDescription;


                if (productId) {

                    productName =
                        select.options[
                            select.selectedIndex
                        ].text.trim();

                }


                const price =
                    parseFloat(
                        row.querySelector(
                            '.quote-price'
                        ).value
                    ) || 0;


                const quantity =
                    parseFloat(
                        row.querySelector(
                            '.quote-quantity'
                        ).value
                    ) || 0;


                const total =
                    price * quantity;


                subtotal += total;


                products.push({

                    product_id:
                        productId,

                    custom_description:
                        customDescription || null,

                    hsn_code:
                        hsnCode,

                    name:
                        productName,

                    price:
                        price,

                    quantity:
                        quantity,

                    total:
                        total

                });

            });


        const discountPercentage =
            document.getElementById(
                'quoteDiscountSwitch'
            ).checked
                ? (
                    parseFloat(
                        document.getElementById(
                            'quoteDiscount'
                        ).value
                    ) || 0
                )
                : 0;


        const discountAmount =
            subtotal *
            discountPercentage /
            100;


        const afterDiscount =
            subtotal -
            discountAmount;


        const gstPercent =
            document.getElementById(
                'quoteGst'
            ).checked
                ? 18
                : 0;


        const gstAmount =
            afterDiscount *
            gstPercent /
            100;


        return {

            products:
                products,

            subtotal:
                subtotal,

            discountPercentage:
                discountPercentage,

            discountAmount:
                discountAmount,

            gstPercent:
                gstPercent,

            gstAmount:
                gstAmount,

            total:
                afterDiscount +
                gstAmount,

            note:
                document.getElementById(
                    'quoteNote'
                ).value.trim()

        };
    }


    function calculateQuickQuote()
    {
        const data =
            getQuickQuotationData();


        document.getElementById(
            'quoteSubtotal'
        ).innerText =
            data.subtotal.toFixed(2);


        document.getElementById(
            'quoteDiscountAmount'
        ).innerText =
            data.discountAmount.toFixed(2);


        document.getElementById(
            'quoteGstAmount'
        ).innerText =
            data.gstAmount.toFixed(2);


        document.getElementById(
            'quoteGrandTotal'
        ).innerText =
            data.total.toFixed(2);


        document.getElementById(
            'quoteDiscountSummary'
        ).style.display =
            data.discountAmount > 0
                ? 'flex'
                : 'none';


        document.getElementById(
            'quoteGstSummary'
        ).style.display =
            data.gstAmount > 0
                ? 'flex'
                : 'none';
    }


    function buildQuickQuotationMessage(
        proformaNo
    )
    {
        const data =
            getQuickQuotationData();


        if (!data.products.length) {

            alert(
                'Please select a product or enter a custom product/service.'
            );

            return null;
        }


        const customerName =
            document.getElementById(
                'quoteCustomerName'
            ).innerText.replace(
                'For: ',
                ''
            );


        /*
         * WhatsApp card-style template.
         * Unicode dash separators keep the message clean
         * without depending on WhatsApp Business API templates.
         */

        let message =
            `━━━━━━━━━━━━━━━━━━━━━━━━\n` +
            `        *PROFORMA*\n` +
            `━━━━━━━━━━━━━━━━━━━━━━━━\n\n` +
            `Hello *${customerName || 'Customer'}* 👋\n\n` +
            `Your proforma has been prepared successfully.\n\n`;


        if (proformaNo) {

            message +=
                `*Proforma No:* ${proformaNo}\n\n`;

        }


        message +=
            `──────── *ITEMS* ────────\n`;


        data.products.forEach(
            function(product, index) {

                message +=
                    `\n*${index + 1}. ${product.name}*\n`;

                message +=
                    `HSN: ${product.hsn_code || '-'}\n`;

                message +=
                    `Price: ₹${product.price.toFixed(2)}\n`;

                message +=
                    `Qty: ${product.quantity}\n`;

                message +=
                    `Amount: ₹${product.total.toFixed(2)}\n`;

            }
        );


        message +=
            `\n────────────────────────\n` +
            `Subtotal: ₹${data.subtotal.toFixed(2)}\n`;


        if (
            data.discountAmount > 0
        ) {

            message +=
                `Discount (${data.discountPercentage}%): -₹${data.discountAmount.toFixed(2)}\n`;

        }


        if (
            data.gstAmount > 0
        ) {

            message +=
                `GST (${data.gstPercent}%): ₹${data.gstAmount.toFixed(2)}\n`;

        }


        message +=
            `────────────────────────\n` +
            `*Total: ₹${data.total.toFixed(2)}/-*\n` +
            `━━━━━━━━━━━━━━━━━━━━━━━━\n`;


        if (data.note) {

            message +=
                `\n*Note:* ${data.note}\n`;

        }


        message +=
            `\nThank you for your business. 🙏`;


        return message;
    }


    async function sendQuickQuotationWhatsApp()
    {
        const data =
            getQuickQuotationData();


        if (!data.products.length) {

            alert(
                'Please select a product or enter a custom product/service.'
            );

            return;
        }


        const missingHsn =
            data.products.some(function(product) {
                return !product.hsn_code;
            });

        if (missingHsn) {
            alert('Please enter HSN code for all products.');
            return;
        }


        let phone =
            document.getElementById(
                'quotePhone'
            ).value.replace(
                /\D/g,
                ''
            );


        if (!phone) {

            alert(
                'Lead phone number is not available.'
            );

            return;
        }


        if (
            phone.length === 10
        ) {
            phone =
                '91' + phone;
        }


        const button =
            document.getElementById(
                'quoteWhatsAppButton'
            );

        const oldHtml =
            button.innerHTML;


        button.disabled =
            true;

        button.innerHTML =
            'Saving...';


        try {

            const response =
                await fetch(

                    "{{ route('admin.leads.quick-proforma.store') }}",

                    {

                        method:
                            'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                "{{ csrf_token() }}"

                        },

                        body:
                            JSON.stringify({

                                lead_id:
                                    document.getElementById(
                                        'quoteLeadId'
                                    ).value,

                                items:
                                    data.products.map(
                                        function(product) {

                                            return {

                                                product_id:
                                                    product.product_id,

                                                custom_description:
                                                    product.custom_description,

                                                hsn_code:
                                                    product.hsn_code,

                                                quantity:
                                                    product.quantity,

                                                unit_price:
                                                    product.price

                                            };

                                        }
                                    ),

                                discount:
                                    data.discountPercentage,

                                vat:
                                    data.gstPercent,

                                note:
                                    data.note

                            })

                    }

                );


            const result =
                await response.json();


            if (
                !response.ok ||
                !result.status
            ) {

                throw new Error(
                    result.message ||
                    'Unable to save proforma.'
                );

            }


            const message =
                buildQuickQuotationMessage(
                    result.proforma_no
                );


            window.open(
                'https://wa.me/' +
                phone +
                '?text=' +
                encodeURIComponent(
                    message
                ),
                '_blank'
            );


            document.getElementById(
                'quoteSaveStatus'
            ).className =
                'lm-quote-status success';


            document.getElementById(
                'quoteSaveStatus'
            ).innerText =
                'Proforma saved successfully.';


            setTimeout(
                function() {

                    quickQuoteModal?.hide();

                    /*
                     * Refresh pipeline.
                     *
                     * Lead Quotation Pending se remove hogi
                     * aur actual quotation Quotation Sent
                     * me appear hogi.
                     */

                    window.location.reload();

                },
                600
            );


        } catch(error) {

            document.getElementById(
                'quoteSaveStatus'
            ).className =
                'lm-quote-status error';


            document.getElementById(
                'quoteSaveStatus'
            ).innerText =
                error.message;

        } finally {

            button.disabled =
                false;

            button.innerHTML =
                oldHtml;

        }
    }



    /* =========================================================
       DETAILED QUOTATION
       ========================================================= */

    let detailedQuotationModalInstance =
        null;


    function openDetailedQuotationModal(
        leadId,
        leadName,
        phone
    )
    {
        const modalElement =
            document.getElementById(
                'detailedQuotationModal'
            );


        if (!modalElement) {

            alert(
                'Detailed Quotation modal not found.'
            );

            return;
        }


        document.getElementById(
            'detailQuoteLeadId'
        ).value =
            leadId || '';


        document.getElementById(
            'detailQuotePhone'
        ).value =
            phone || '';


        document.getElementById(
            'detailQuoteLeadName'
        ).textContent =
            leadName || 'Lead';


        document.getElementById(
            'detailQuoteLeadPhone'
        ).textContent =
            phone ||
            'Phone number not available';


        const categorySelect =
            document.getElementById(
                'detailQuoteCategory'
            );

        if (categorySelect) {
            categorySelect.value = '';
        }


        const searchInput =
            document.getElementById(
                'detailQuoteSearch'
            );


        if (searchInput) {
            searchInput.value = '';
        }


        document
            .querySelectorAll(
                'input[name="detailed_quotation_id"]'
            )
            .forEach(function(input) {

                input.checked =
                    false;

            });


        document
            .querySelectorAll(
                '.lm-detail-quote-item'
            )
            .forEach(function(item) {

                item.style.display =
                    'none';

            });


        const searchBox =
            document.getElementById(
                'detailQuoteSearchBox'
            );

        if (searchBox) {
            searchBox.style.display =
                'none';
        }


        const categoryMessage =
            document.getElementById(
                'detailQuoteCategoryMessage'
            );

        if (categoryMessage) {
            categoryMessage.style.display = '';

            categoryMessage.innerHTML = `
                <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>
                Please select a category to view proposal PDFs.
            `;
        }


        const preview =
            document.getElementById(
                'detailQuotePreview'
            );


        if (preview) {

            preview.classList.remove(
                'is-visible'
            );

        }


        const previewLink =
            document.getElementById(
                'detailQuotePreviewLink'
            );


        if (previewLink) {

            previewLink.href =
                '#';

        }


        const status =
            document.getElementById(
                'detailQuoteStatus'
            );


        if (status) {

            status.className =
                'lm-detail-quote-status';

            status.textContent =
                '';

        }


        detailedQuotationModalInstance =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        detailedQuotationModalInstance.show();
    }


    function filterDetailedQuotations()
    {
        const categorySelect =
            document.getElementById(
                'detailQuoteCategory'
            );

        const searchInput =
            document.getElementById(
                'detailQuoteSearch'
            );

        const searchBox =
            document.getElementById(
                'detailQuoteSearchBox'
            );

        const categoryMessage =
            document.getElementById(
                'detailQuoteCategoryMessage'
            );


        const selectedCategoryId =
            String(
                categorySelect?.value || ''
            );


        const searchValue =
            String(
                searchInput?.value || ''
            )
            .trim()
            .toLowerCase();


        document
            .querySelectorAll(
                'input[name="detailed_quotation_id"]'
            )
            .forEach(function(input) {
                input.checked = false;
            });


        const preview =
            document.getElementById(
                'detailQuotePreview'
            );

        if (preview) {
            preview.classList.remove(
                'is-visible'
            );
        }


        const previewLink =
            document.getElementById(
                'detailQuotePreviewLink'
            );

        if (previewLink) {
            previewLink.href = '#';
        }


        if (!selectedCategoryId) {

            if (searchBox) {
                searchBox.style.display =
                    'none';
            }


            document
                .querySelectorAll(
                    '.lm-detail-quote-item'
                )
                .forEach(function(item) {

                    item.style.display =
                        'none';

                });


            if (categoryMessage) {
                categoryMessage.style.display =
                    '';

                categoryMessage.innerHTML = `
                    <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>
                    Please select a category to view proposal PDFs.
                `;
            }


            return;
        }


        if (searchBox) {
            searchBox.style.display =
                '';
        }


        let visibleQuotationCount =
            0;


        document
            .querySelectorAll(
                '.lm-detail-quote-item'
            )
            .forEach(function(item) {

                const itemCategoryId =
                    String(
                        item.dataset.categoryId ||
                        ''
                    );


                const quotationName =
                    String(
                        item.dataset.quotationName ||
                        ''
                    )
                    .toLowerCase();


                const categoryMatches =
                    itemCategoryId ===
                    selectedCategoryId;


                const searchMatches =
                    !searchValue ||
                    quotationName.includes(
                        searchValue
                    );


                const shouldShow =
                    categoryMatches &&
                    searchMatches;


                item.style.display =
                    shouldShow
                        ? ''
                        : 'none';


                if (shouldShow) {
                    visibleQuotationCount++;
                }

            });


        if (categoryMessage) {

            if (
                visibleQuotationCount ===
                0
            ) {

                categoryMessage.style.display =
                    '';

                categoryMessage.innerHTML = `
                    <i class="bi bi-file-earmark-x fs-4 d-block mb-2"></i>
                    No proposal PDF found in this category.
                `;

            } else {

                categoryMessage.style.display =
                    'none';

            }
        }
    }


    function selectDetailedQuotation(
        input
    )
    {
        const preview =
            document.getElementById(
                'detailQuotePreview'
            );


        const previewLink =
            document.getElementById(
                'detailQuotePreviewLink'
            );


        if (
            !input ||
            !input.checked
        ) {

            if (preview) {

                preview.classList.remove(
                    'is-visible'
                );

            }

            return;
        }


        if (previewLink) {

            previewLink.href =
                input.dataset.viewUrl ||
                '#';

        }


        if (preview) {

            preview.classList.add(
                'is-visible'
            );

        }


        const status =
            document.getElementById(
                'detailQuoteStatus'
            );


        if (status) {

            status.className =
                'lm-detail-quote-status';

            status.textContent =
                '';

        }
    }


    async function sendDetailedQuotationWhatsApp()
    {
        const selected =
            document.querySelector(
                'input[name="detailed_quotation_id"]:checked'
            );


        const status =
            document.getElementById(
                'detailQuoteStatus'
            );


        if (!selected) {

            if (status) {

                status.className =
                    'lm-detail-quote-status error';

                status.textContent =
                    'Please select a detailed quotation first.';

            }

            return;
        }


        const leadId =
            document.getElementById(
                'detailQuoteLeadId'
            ).value;


        let phone =
            document.getElementById(
                'detailQuotePhone'
            ).value.replace(
                /\D/g,
                ''
            );


        if (!leadId) {

            alert(
                'Lead not found.'
            );

            return;
        }


        if (!phone) {

            if (status) {

                status.className =
                    'lm-detail-quote-status error';

                status.textContent =
                    'Lead phone number is not available.';

            }

            return;
        }


        if (
            phone.length === 10
        ) {
            phone =
                '91' + phone;
        }


        const button =
            document.getElementById(
                'detailQuoteWhatsAppButton'
            );


        const originalHtml =
            button.innerHTML;


        button.disabled =
            true;


        button.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
            ></span>
            Preparing PDF...
        `;


        try {

            const response =
                await fetch(

                    `{{ url('/admin/leads') }}/${leadId}/detailed-quotation/send`,

                    {

                        method:
                            'POST',

                        headers: {

                            'Accept':
                                'application/json',

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        body:
                            JSON.stringify({

                                detailed_quotation_id:
                                    selected.value

                            })

                    }

                );


            let data = {};


            try {

                data =
                    await response.json();

            } catch(jsonError) {

                data = {};

            }


            if (
                !response.ok ||
                data.status === false
            ) {

                let message =
                    data.message ||
                    'Unable to prepare detailed quotation.';


                if (data.errors) {

                    const firstError =
                        Object.values(
                            data.errors
                        )[0];


                    if (
                        Array.isArray(
                            firstError
                        ) &&
                        firstError[0]
                    ) {

                        message =
                            firstError[0];

                    }

                }


                throw new Error(
                    message
                );
            }


            const quotationName =
                data.quotation_name ||
                selected.dataset.name ||
                'Detailed Quotation';


            const leadName =
                document.getElementById(
                    'detailQuoteLeadName'
                ).textContent || '';


            const pdfUrl =
                data.pdf_url || '';


            if (!pdfUrl) {

                throw new Error(
                    'PDF share link was not generated.'
                );

            }


            /*
             * WhatsApp card-style Proposal Sent template.
             * No Lead Note is requested here.
             */

            const message =
                `━━━━━━━━━━━━━━━━━━━━━━━━\n` +
                `      *PROPOSAL READY*\n` +
                `━━━━━━━━━━━━━━━━━━━━━━━━\n\n` +
                `Hello *${leadName || 'Customer'}* 👋\n\n` +
                `Your proposal is ready for review.\n\n` +
                `*Proposal:* ${quotationName}\n\n` +
                `──────── *VIEW PDF* ────────\n` +
                `${pdfUrl}\n` +
                `────────────────────────\n\n` +
                `Please review the proposal and let us know if you have any questions.\n\n` +
                `Thank you. 🙏`;



            window.open(
                'https://wa.me/' +
                phone +
                '?text=' +
                encodeURIComponent(
                    message
                ),
                '_blank'
            );


            if (status) {

                status.className =
                    'lm-detail-quote-status success';

                status.textContent =
                    'Detailed quotation saved successfully. Opening WhatsApp...';

            }


            setTimeout(
                function() {

                    detailedQuotationModalInstance?.hide();

                    /*
                     * Pending lead disappears.
                     * New actual quotation appears
                     * in Quotation Sent.
                     */

                    window.location.reload();

                },
                700
            );


        } catch(error) {

            console.error(
                'Detailed quotation WhatsApp send failed:',
                error
            );


            if (status) {

                status.className =
                    'lm-detail-quote-status error';

                status.textContent =
                    error.message ||
                    'Unable to send detailed quotation.';

            }

        } finally {

            button.disabled =
                false;

            button.innerHTML =
                originalHtml;

        }
    }





    /* =========================================================
       PIPELINE LEAD NOTE GATE
       =========================================================
       Lead Note REQUIRED:
       - Contacted
       - Proposal Pending
       - Proforma Pending
       - Payment Waiting
       - Won
       - Lost

       NO Lead Note:
       - Proposal Sent
       - Send Proforma
       - New Lead
       - Negotiation
       ========================================================= */

    const pipelineLeadNoteStages = [
        'Contacted',
        'Proposal Pending',
        'Proforma Pending',
        'Payment Waiting',
        'Won',
        'Lost'
    ];


    let pipelineLeadNoteModalInstance =
        null;


    let pendingPipelineStageChange =
        null;


    function pipelineStageNeedsLeadNote(
        stage
    )
    {
        return pipelineLeadNoteStages
            .includes(stage);
    }


    function openPipelineLeadNoteModal(
        recordType,
        recordId,
        leadId,
        leadName,
        newStage
    )
    {
        if (
            !pipelineStageNeedsLeadNote(
                newStage
            )
        ) {
            return false;
        }


        if (!leadId) {
            alert(
                'Lead is not linked with this pipeline record. Lead Note cannot be saved.'
            );

            return true;
        }


        const modalElement =
            document.getElementById(
                'pipelineLeadNoteModal'
            );


        if (!modalElement) {
            alert(
                'Lead Note modal not found.'
            );

            return true;
        }


        pendingPipelineStageChange = {
            recordType:
                recordType,

            recordId:
                recordId,

            leadId:
                leadId,

            leadName:
                leadName || 'Lead',

            newStage:
                newStage
        };


        document.getElementById(
            'pipelineLeadNoteLeadName'
        ).textContent =
            leadName || 'Lead';


        document.getElementById(
            'pipelineLeadNoteStage'
        ).textContent =
            newStage;


        document.getElementById(
            'pipelineLeadNoteTitle'
        ).textContent =
            'Move to ' + newStage;


        const noteInput =
            document.getElementById(
                'pipelineLeadNoteInput'
            );


        const errorBox =
            document.getElementById(
                'pipelineLeadNoteError'
            );


        noteInput.value =
            '';

        noteInput.classList.remove(
            'is-invalid'
        );


        errorBox.style.display =
            'none';

        errorBox.textContent =
            'Lead Note is required.';


        noteInput.oninput =
            function() {

                if (
                    this.value.trim()
                ) {

                    this.classList.remove(
                        'is-invalid'
                    );

                    errorBox.style.display =
                        'none';

                }
            };


        pipelineLeadNoteModalInstance =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        pipelineLeadNoteModalInstance.show();


        modalElement.addEventListener(
            'shown.bs.modal',
            function focusPipelineNote() {

                noteInput.focus();

                modalElement.removeEventListener(
                    'shown.bs.modal',
                    focusPipelineNote
                );
            }
        );


        return true;
    }


    async function submitPipelineLeadNote()
    {
        const pending =
            pendingPipelineStageChange;


        const noteInput =
            document.getElementById(
                'pipelineLeadNoteInput'
            );


        const errorBox =
            document.getElementById(
                'pipelineLeadNoteError'
            );


        const submitButton =
            document.getElementById(
                'pipelineLeadNoteSubmitBtn'
            );


        const note =
            noteInput.value.trim();


        if (!note) {

            noteInput.classList.add(
                'is-invalid'
            );

            errorBox.style.display =
                'block';

            errorBox.textContent =
                'Lead Note is required.';

            noteInput.focus();

            return;
        }


        if (
            !pending
            ||
            !pending.leadId
            ||
            !pending.newStage
        ) {

            errorBox.style.display =
                'block';

            errorBox.textContent =
                'Pipeline stage information is missing.';

            return;
        }


        noteInput.classList.remove(
            'is-invalid'
        );

        errorBox.style.display =
            'none';


        const originalHtml =
            submitButton.innerHTML;


        submitButton.disabled =
            true;


        submitButton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
                aria-hidden="true"
            ></span>
            Saving Note...
        `;


        try {

            const now =
                new Date();


            const pad =
                function(value) {
                    return String(value)
                        .padStart(2, '0');
                };


            const callDate =
                now.getFullYear()
                + '-'
                + pad(now.getMonth() + 1)
                + '-'
                + pad(now.getDate())
                + ' '
                + pad(now.getHours())
                + ':'
                + pad(now.getMinutes())
                + ':'
                + pad(now.getSeconds());


            /*
            |--------------------------------------------------------------------------
            | STEP 1 — SAVE THROUGH EXISTING LeadNoteController
            |--------------------------------------------------------------------------
            */

            const noteResponse =
                await fetch(
                    `{{ route('admin.lead.notes') }}`,
                    {
                        method:
                            'POST',

                        headers: {
                            'Accept':
                                'application/json',

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}',

                            'X-Requested-With':
                                'XMLHttpRequest'
                        },

                        body:
                            JSON.stringify({
                                lead_id:
                                    pending.leadId,

                                description:
                                    note,

                                call_date:
                                    callDate
                            })
                    }
                );


            if (!noteResponse.ok) {

                let message =
                    'Unable to save Lead Note.';


                try {

                    const noteData =
                        await noteResponse.json();


                    if (noteData.message) {
                        message =
                            noteData.message;
                    }


                    if (noteData.errors) {

                        const firstError =
                            Object.values(
                                noteData.errors
                            )[0];


                        if (
                            Array.isArray(
                                firstError
                            )
                            &&
                            firstError[0]
                        ) {

                            message =
                                firstError[0];

                        }
                    }

                } catch(error) {
                    // Keep default error message.
                }


                throw new Error(
                    message
                );
            }


            /*
            |--------------------------------------------------------------------------
            | STEP 2 — NOTE SAVED, NOW CHANGE PIPELINE STAGE
            |--------------------------------------------------------------------------
            */

            submitButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                    aria-hidden="true"
                ></span>
                Updating Stage...
            `;


            if (
                pending.recordType ===
                'lead'
            ) {

                await updateLeadStage(
                    pending.recordId,
                    pending.newStage,
                    true
                );

                return;
            }


            if (
                pending.recordType ===
                'proforma'
            ) {

                await updateProformaStage(
                    pending.recordId,
                    pending.newStage,
                    true
                );

                return;
            }


            if (
                pending.recordType ===
                'quotation'
            ) {

                await updateQuotationStage(
                    pending.recordId,
                    pending.newStage,
                    true
                );

                return;
            }


            throw new Error(
                'Unknown pipeline record type.'
            );


        } catch(error) {

            console.error(
                'Pipeline Lead Note error:',
                error
            );


            errorBox.style.display =
                'block';

            errorBox.textContent =
                error.message ||
                'Something went wrong.';


        } finally {

            submitButton.disabled =
                false;

            submitButton.innerHTML =
                originalHtml;
        }
    }


    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const modalElement =
                document.getElementById(
                    'pipelineLeadNoteModal'
                );


            if (!modalElement) {
                return;
            }


            modalElement.addEventListener(
                'hidden.bs.modal',
                function() {

                    const noteInput =
                        document.getElementById(
                            'pipelineLeadNoteInput'
                        );


                    const errorBox =
                        document.getElementById(
                            'pipelineLeadNoteError'
                        );


                    if (noteInput) {
                        noteInput.value =
                            '';

                        noteInput.classList.remove(
                            'is-invalid'
                        );
                    }


                    if (errorBox) {
                        errorBox.style.display =
                            'none';
                    }

                }
            );

        }
    );


    /* =========================================================
       PIPELINE STAGE HELPERS
       ========================================================= */

    const allPipelineStages = [
        'New Lead',
        'Contacted',
        'Proposal Pending',
        'Proforma Pending',
        'Send Proforma',
        'Proposal Sent',
        'Negotiation',
        'Payment Waiting',
        'Won',
        'Lost'
    ];

    const leadStageUrlTemplate =
        "{{ url('/admin/leads/pipeline/lead-stage/__ID__') }}";

    const proformaStageUrlTemplate =
        "{{ url('/admin/leads/pipeline/proforma-stage/__ID__') }}";

    const quotationStageUrlTemplate =
        "{{ url('/admin/leads/pipeline/quotation-stage/__ID__') }}";


    function pipelineUrl(template, id)
    {
        return template.replace('__ID__', id);
    }


    async function postPipelineStage(url, stage)
    {
        const response = await fetch(
            url,
            {
                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                body: JSON.stringify({
                    stage: stage
                })
            }
        );

        let data = {};

        try {
            data = await response.json();
        } catch (error) {
            data = {};
        }

        if (
            !response.ok ||
            data.success === false
        ) {
            throw new Error(
                data.message ||
                'Unable to update pipeline stage.'
            );
        }

        return data;
    }


    function openSendProformaModal(
        leadId,
        leadName,
        phone
    )
    {
        if (!leadId) {
            alert('Lead is not linked with this record.');
            return;
        }

        openQuickQuotation(
            leadId,
            leadName || '',
            phone || ''
        );
    }


    /*
     * Proposal Sent is also an ACTION for a Lead.
     * Proposal ko bina actually send kiye direct stage update nahi karna.
     * Existing Detailed Proposal / Detailed Quotation modal reuse hota hai.
     */
    function openSendProposalModal(
        leadId,
        leadName,
        phone
    )
    {
        if (!leadId) {
            alert('Lead is not linked with this record.');
            return;
        }

        openDetailedQuotationModal(
            leadId,
            leadName || '',
            phone || ''
        );
    }


    /* =========================================================
       LEAD STAGE DROPDOWN
       ========================================================= */

    document
        .querySelectorAll('.change-lead-stage')
        .forEach(function(select) {

            select.addEventListener(
                'change',
                function() {

                    const leadId =
                        this.dataset.id;

                    const leadName =
                        this.dataset.name || '';

                    const phone =
                        this.dataset.phone || '';

                    const oldStage =
                        this.dataset.currentStage || '';

                    const newStage =
                        this.value;

                    /*
                     * Lead -> Send Proforma is an ACTION.
                     * Directly leads.stage = Send Proforma nahi karna.
                     * Quick Proforma modal open hoga.
                     */
                    if (newStage === 'Send Proforma') {

                        this.value =
                            oldStage;

                        openSendProformaModal(
                            leadId,
                            leadName,
                            phone
                        );

                        return;
                    }

                    /*
                     * Lead -> Proposal Sent direct stage change nahi hoga.
                     * Proposal/Detailed Quotation modal open hoga.
                     * Actual proposal send hone ke baad backend Lead.stage
                     * ko Proposal Sent karega.
                     */
                    if (newStage === 'Proposal Sent') {

                        this.value =
                            oldStage;

                        openSendProposalModal(
                            leadId,
                            leadName,
                            phone
                        );

                        return;
                    }

                    if (
                        pipelineStageNeedsLeadNote(
                            newStage
                        )
                    ) {

                        this.value =
                            oldStage;

                        openPipelineLeadNoteModal(
                            'lead',
                            leadId,
                            leadId,
                            leadName,
                            newStage
                        );

                        return;
                    }


                    updateLeadStage(
                        leadId,
                        newStage
                    );
                }
            );
        });


    async function updateLeadStage(
        leadId,
        newStage,
        leadNoteAlreadySaved = false
    )
    {
        const allowedStages =
            allPipelineStages.filter(
                function(stage) {
                    return (
                        stage !== 'Send Proforma'
                        &&
                        stage !== 'Proposal Sent'
                    );
                }
            );

        if (!allowedStages.includes(newStage)) {
            return;
        }

        try {

            await postPipelineStage(
                pipelineUrl(
                    leadStageUrlTemplate,
                    leadId
                ),
                newStage
            );

            window.location.reload();

        } catch (error) {

            alert(
                error.message ||
                'Failed to update lead stage.'
            );

            window.location.reload();
        }
    }


    /* =========================================================
       PROFORMA STAGE DROPDOWN
       ========================================================= */

    document
        .querySelectorAll('.change-proforma-stage')
        .forEach(function(select) {

            select.addEventListener(
                'change',
                function() {

                    const proformaId =
                        this.dataset.id;

                    const leadId =
                        this.dataset.leadId;

                    const leadName =
                        this.dataset.name || '';

                    const oldStage =
                        this.dataset.currentStage || '';

                    const newStage =
                        this.value;


                    /*
                     * Proposal Sent / Send Proforma:
                     * NO Lead Note required.
                     */

                    if (
                        pipelineStageNeedsLeadNote(
                            newStage
                        )
                    ) {

                        this.value =
                            oldStage;

                        openPipelineLeadNoteModal(
                            'proforma',
                            proformaId,
                            leadId,
                            leadName,
                            newStage
                        );

                        return;
                    }


                    updateProformaStage(
                        proformaId,
                        newStage
                    );
                }
            );
        });


    async function updateProformaStage(
        proformaId,
        newStage,
        leadNoteAlreadySaved = false
    )
    {
        if (!allPipelineStages.includes(newStage)) {
            return;
        }

        try {

            await postPipelineStage(
                pipelineUrl(
                    proformaStageUrlTemplate,
                    proformaId
                ),
                newStage
            );

            window.location.reload();

        } catch (error) {

            alert(
                error.message ||
                'Failed to update proforma stage.'
            );

            window.location.reload();
        }
    }


    /* =========================================================
       QUOTATION STAGE DROPDOWN
       ========================================================= */

    document
        .querySelectorAll('.change-quotation-stage')
        .forEach(function(select) {

            select.addEventListener(
                'change',
                function() {

                    const quotationId =
                        this.dataset.id;

                    const leadId =
                        this.dataset.leadId;

                    const leadName =
                        this.dataset.name || '';

                    const phone =
                        this.dataset.phone || '';

                    const oldStage =
                        this.dataset.currentStage || '';

                    const newStage =
                        this.value;

                    /*
                     * Detailed quotation se Send Proforma choose hua
                     * to linked Lead ka Quick Proforma modal open hoga.
                     */
                    if (newStage === 'Send Proforma') {

                        this.value =
                            oldStage;

                        openSendProformaModal(
                            leadId,
                            leadName,
                            phone
                        );

                        return;
                    }

                    if (
                        pipelineStageNeedsLeadNote(
                            newStage
                        )
                    ) {

                        this.value =
                            oldStage;

                        openPipelineLeadNoteModal(
                            'quotation',
                            quotationId,
                            leadId,
                            leadName,
                            newStage
                        );

                        return;
                    }


                    updateQuotationStage(
                        quotationId,
                        newStage
                    );
                }
            );
        });


    async function updateQuotationStage(
        quotationId,
        newStage,
        leadNoteAlreadySaved = false
    )
    {
        const allowedStages =
            allPipelineStages.filter(
                function(stage) {
                    return stage !== 'Send Proforma';
                }
            );

        if (!allowedStages.includes(newStage)) {
            return;
        }

        try {

            await postPipelineStage(
                pipelineUrl(
                    quotationStageUrlTemplate,
                    quotationId
                ),
                newStage
            );

            window.location.reload();

        } catch (error) {

            alert(
                error.message ||
                'Failed to update quotation stage.'
            );

            window.location.reload();
        }
    }


    /* =========================================================
       ONE DRAG & DROP PIPELINE
       ========================================================= */

    function restoreDraggedCard(evt)
    {
        const children =
            Array.from(
                evt.from.querySelectorAll(
                    ':scope > .pipeline-card'
                )
            );

        const target =
            children[evt.oldDraggableIndex] || null;

        if (target) {
            evt.from.insertBefore(
                evt.item,
                target
            );
        } else {
            evt.from.appendChild(
                evt.item
            );
        }
    }


    document
        .querySelectorAll('.pipeline-sortable')
        .forEach(function(column) {

            new Sortable(
                column,
                {
                    group:
                        'sales-pipeline',

                    draggable:
                        '.pipeline-card',

                    animation:
                        200,

                    ghostClass:
                        'dragging',

                    filter:
                        'select,button,a,input,textarea',

                    preventOnFilter:
                        false,

                    onEnd:
                        function(evt) {

                            const card =
                                evt.item;

                            const type =
                                card.dataset.type;

                            const recordId =
                                card.dataset.id;

                            const leadId =
                                card.dataset.leadId;

                            const leadName =
                                card.dataset.name || '';

                            const phone =
                                card.dataset.phone || '';

                            const newStage =
                                evt.to.dataset.stage;

                            const oldStage =
                                evt.from.dataset.stage;

                            if (
                                !newStage ||
                                newStage === oldStage
                            ) {
                                return;
                            }

                            /*
                             * Lead / Detailed Quotation dragged to
                             * Send Proforma = modal action.
                             */
                            if (
                                newStage === 'Send Proforma'
                                &&
                                (
                                    type === 'lead'
                                    ||
                                    type === 'quotation'
                                )
                            ) {

                                restoreDraggedCard(evt);

                                openSendProformaModal(
                                    leadId,
                                    leadName,
                                    phone
                                );

                                return;
                            }

                            /*
                             * Lead ko Proposal Sent column me drag karne par
                             * stage direct save nahi hoga.
                             * Pehle Proposal modal open hoga.
                             */
                            if (
                                newStage === 'Proposal Sent'
                                &&
                                type === 'lead'
                            ) {

                                restoreDraggedCard(evt);

                                openSendProposalModal(
                                    leadId,
                                    leadName,
                                    phone
                                );

                                return;
                            }

                            /*
                             * These stages require a Lead Note first.
                             * Restore the dragged card to its old lane,
                             * save the note, then run the existing stage AJAX.
                             */
                            if (
                                pipelineStageNeedsLeadNote(
                                    newStage
                                )
                            ) {

                                restoreDraggedCard(
                                    evt
                                );


                                const noteRecordId =
                                    recordId;


                                openPipelineLeadNoteModal(
                                    type,
                                    noteRecordId,
                                    leadId,
                                    leadName,
                                    newStage
                                );

                                return;
                            }


                            if (type === 'lead') {

                                updateLeadStage(
                                    recordId,
                                    newStage
                                );

                                return;
                            }

                            if (type === 'proforma') {

                                updateProformaStage(
                                    recordId,
                                    newStage
                                );

                                return;
                            }

                            if (type === 'quotation') {

                                updateQuotationStage(
                                    recordId,
                                    newStage
                                );

                                return;
                            }

                            window.location.reload();
                        }
                }
            );
        });


    /* =========================================================
       NEW: CLIENT-SIDE PIPELINE SEARCH
       Pure presentation filter — does not touch stage data,
       does not remove cards from the DOM (so Sortable / drag &
       drop keep working normally), just toggles visibility.
       ========================================================= */

    function filterPipelineCards(searchValue)
    {
        const search = String(searchValue || '').trim().toLowerCase();

        const resultCountEl =
            document.getElementById('pipelineResultCount');

        let visibleCount = 0;
        let totalCount = 0;

        document
            .querySelectorAll('.pipeline-column')
            .forEach(function(column) {

                let visibleInColumn = 0;

                const cards =
                    column.querySelectorAll('.pipeline-card');

                cards.forEach(function(card) {

                    totalCount++;

                    const name =
                        String(card.dataset.name || '').toLowerCase();

                    const phone =
                        String(card.dataset.phone || '').toLowerCase();

                    const salesperson =
                        String(card.dataset.salesperson || '').toLowerCase();

                    const matches =
                        !search ||
                        name.includes(search) ||
                        phone.includes(search) ||
                        salesperson.includes(search);

                    card.style.display = matches ? '' : 'none';

                    if (matches) {
                        visibleInColumn++;
                        visibleCount++;
                    }

                });

                const emptyState =
                    column.querySelector('.sp-empty-state');

                const noResultsState =
                    column.querySelector('.sp-no-search-results');

                if (noResultsState) {

                    const hasCards =
                        cards.length > 0;

                    noResultsState.style.display =
                        (search && hasCards && visibleInColumn === 0)
                            ? 'block'
                            : 'none';

                }

                if (emptyState) {

                    emptyState.style.display =
                        search ? 'none' : '';

                }

            });

        if (resultCountEl) {

            resultCountEl.textContent =
                search
                    ? visibleCount + ' / ' + totalCount + ' matching'
                    : '';

        }
    }


    /* =========================================================
       NEW: VIEW DENSITY TOGGLE (Comfortable / Compact)
       Pure CSS class toggle, remembered locally per browser.
       ========================================================= */

    function setPipelineDensity(mode)
    {
        const wrapper =
            document.querySelector('.cs-sales-pipeline');

        if (!wrapper) {
            return;
        }

        const comfortableBtn =
            document.getElementById('spDensityComfortable');

        const compactBtn =
            document.getElementById('spDensityCompact');

        if (mode === 'compact') {

            wrapper.classList.add('sp-density-compact');

            compactBtn?.classList.add('is-active');

            comfortableBtn?.classList.remove('is-active');

        } else {

            wrapper.classList.remove('sp-density-compact');

            comfortableBtn?.classList.add('is-active');

            compactBtn?.classList.remove('is-active');

        }

        try {
            window.localStorage.setItem('sp_pipeline_density', mode);
        } catch (error) {
            // Storage unavailable — density preference simply won't persist.
        }
    }


    (function restorePipelineDensity() {

        let savedMode = 'comfortable';

        try {
            savedMode =
                window.localStorage.getItem('sp_pipeline_density') || 'comfortable';
        } catch (error) {
            savedMode = 'comfortable';
        }

        setPipelineDensity(savedMode);

    })();

</script>

@endpush

