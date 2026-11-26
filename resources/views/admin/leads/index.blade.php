@extends('index')
@push('title', get_phrase('Lead Management'))

@php
    $quoteProductsQuery = \App\Models\Product::query()->orderBy('name');

    if (!auth()->user()->hasRole('Admin') && !empty(auth()->user()->branch_id)) {
        $quoteProductsQuery->where('branch_id', auth()->user()->branch_id);
    }

    $quoteProducts = $quoteProductsQuery->get();

    /*
     * Reusable Detailed Quotation PDF Library.
     */
    // $detailedQuotations = \App\Models\DetailedQuotation::query()
    //     ->orderBy('name')
    //     ->get(['id', 'name']);

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
        * Modal mein sirf wahi categories show hongi
        * jinke andar quotation PDFs available hain.
        */
        $detailedQuotationCategories = $detailedQuotations
            ->pluck('category')
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();



    $quoteProductsJson = json_encode(
        $quoteProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sale_price' => $product->sale_price ?? 0,
            ];
        })->values()->toArray(),
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
    );
@endphp

@push('css')
<style>
    /* =========================================================
       01. TOKENS
       ========================================================= */
    :root{
        --blue:#0b74c4;
        --blue-dark:#075a99;
        --blue-50:#eaf4fc;
        --blue-100:#d9edfb;
        --red:#e5342a;
        --red-50:#fdecea;

        --ink-900:#111827;
        --ink-700:#374151;
        --ink-600:#4b5563;
        --ink-500:#6b7280;
        --ink-400:#9aa3af;

        --line:#e5e7eb;
        --line-strong:#eaecf0;

        --surface:#ffffff;
        --surface-2:#f9fafb;
        --page-bg:#f5f6f8;

        --success:#0f8a4b;
        --success-bg:#eafbf1;
        --warning:#a15c00;
        --warning-bg:#fff6e8;
        --danger:#c9271b;
        --danger-bg:#fdeceb;
        --info:#0b74c4;
        --info-bg:#eaf4fc;

        --radius-sm:8px;
        --radius-md:12px;
        --radius-lg:16px;

        --shadow-xs:0 1px 2px rgba(16,24,40,.04);
        --shadow-sm:0 2px 8px rgba(16,24,40,.06);

        --sp-1:4px;
        --sp-2:6px;
        --sp-3:8px;
        --sp-4:12px;
        --sp-5:16px;
        --sp-6:20px;
        --sp-7:24px;
        --sp-8:32px;
    }

    @media (max-width: 767.98px) {
    .lm-kpis {
        display: none !important;
    }
}


   @media (max-width: 767.98px) {
        .cs-premium-header-center {
            display: none !important;
          
        }

        .lm{
            margin-top: -65px !important;
        }
    }


    




    /* =========================================================
       02. BASE
       ========================================================= */
    .lm{ position:relative; color:var(--ink-700); }
    .lm *{ box-sizing:border-box; }
    .lm a, .lm button{ -webkit-tap-highlight-color:transparent; }
    .lm .tabular{ font-variant-numeric:tabular-nums; }

    .lm-card{
        background:var(--surface);
        border:1px solid var(--line);
        border-radius:var(--radius-lg);
        box-shadow:var(--shadow-xs);
    }

    /* =========================================================
   FOLLOW UP MODAL
   ========================================================= */

.lm-followup-modal{
    border:0;
    border-radius:18px;
    overflow:hidden;
    box-shadow:
        0 24px 70px rgba(15,23,42,.18);
}

.lm-followup-modal .modal-header{
    padding:18px 20px;
    border-bottom:1px solid #edf0f3;
    background:#fff;
}

.lm-followup-modal .modal-title{
    margin-top:3px;
    font-size:17px;
    font-weight:750;
    color:#111827;
}

.lm-followup-eyebrow{
    display:flex;
    align-items:center;
    gap:6px;
    color:#0b74c4;
    font-size:10px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.lm-followup-modal .modal-body{
    padding:20px;
    background:#fbfcfd;
}

.lm-followup-label{
    display:flex;
    align-items:center;
    gap:6px;
    margin-bottom:7px;
    color:#374151;
    font-size:11px;
    font-weight:700;
}

.lm-followup-label i{
    color:#0b74c4;
}

.lm-followup-input{
    min-height:44px;
    border:1px solid #dde3e9;
    border-radius:10px;
    background:#fff;
    font-size:12px;
    box-shadow:none !important;
}

textarea.lm-followup-input{
    min-height:100px;
    resize:vertical;
    padding-top:11px;
}

.lm-followup-input:focus{
    border-color:#8bc6eb;
    box-shadow:
        0 0 0 3px #eaf4fc !important;
}

.lm-followup-info{
    display:flex;
    gap:8px;
    margin-top:13px;
    padding:10px 12px;
    border:1px solid #d9ebf7;
    border-radius:10px;
    background:#eef8fe;
    color:#526273;
    font-size:10px;
    line-height:1.45;
}

.lm-followup-info i{
    color:#0b74c4;
    margin-top:1px;
}

.lm-followup-modal .modal-footer{
    padding:13px 20px;
    border-top:1px solid #edf0f3;
    background:#fff;
}

.lm-followup-modal .modal-footer .btn{
    min-height:39px;
    border-radius:9px;
    font-size:11px;
    font-weight:700;
}

.lm-followup-modal .btn-primary{
    background:#0b74c4;
    border-color:#0b74c4;
}

.lm-followup-modal .btn-primary:hover{
    background:#075a99;
    border-color:#075a99;
}


/* Mobile */

@media(max-width:575.98px){

    #leadFollowUpModal .modal-dialog{
        margin:10px;
        align-items:flex-end;
        min-height:calc(100% - 20px);
    }

    .lm-followup-modal{
        border-radius:18px;
    }

    .lm-followup-modal .modal-header{
        padding:15px 16px;
    }

    .lm-followup-modal .modal-body{
        padding:16px;
    }

    .lm-followup-modal .modal-footer{
        padding:12px 16px;
    }

    .lm-followup-modal .modal-footer .btn-primary{
        flex:1;
    }
}

    /* =========================================================
       03. HEADER
       ========================================================= */
    .lm-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:var(--sp-5);
        padding:var(--sp-6) var(--sp-7);
        margin-bottom:var(--sp-5);
    }

    .lm-header-title h1{
        font-size:20px;
        font-weight:700;
        letter-spacing:-.2px;
        color:var(--ink-900);
        margin:0;
        line-height:1.25;
    }

    .lm-header-title p{
        margin:2px 0 0;
        font-size:13px;
        color:var(--ink-500);
    }

    .lm-header-actions{
        display:flex;
        align-items:center;
        gap:var(--sp-3);
        flex-shrink:0;
    }

    .lm-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        height:38px;
        padding:0 14px;
        border-radius:var(--radius-sm);
        font-size:13px;
        font-weight:600;
        text-decoration:none;
        border:1px solid transparent;
        cursor:pointer;
        transition:background .15s ease, border-color .15s ease, transform .1s ease, color .15s ease;
        white-space:nowrap;
    }

    .lm-btn:active{ transform:translateY(1px); }

    .lm-btn-primary{
        background:var(--blue);
        color:#fff;
        box-shadow:var(--shadow-xs);
    }
    .lm-btn-primary:hover{ background:var(--blue-dark); color:#fff; }

    .lm-btn-secondary{
        background:#fff;
        border-color:var(--line);
        color:var(--ink-700);
    }
    .lm-btn-secondary:hover{ border-color:#d0d5dd; background:var(--surface-2); color:var(--ink-900); }

    /* =========================================================
       04. KPI STRIP
       ========================================================= */
    .lm-kpis{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:var(--sp-4);
        margin-bottom:var(--sp-5);
    }

    .lm-kpi{
        padding:var(--sp-5);
        display:flex;
        align-items:center;
        gap:var(--sp-4);
    }

    .lm-kpi-icon{
        width:36px;
        height:36px;
        border-radius:10px;
        display:grid;
        place-items:center;
        background:var(--blue-50);
        color:var(--blue);
        font-size:15px;
        flex-shrink:0;
    }
    .lm-kpi:nth-child(2) .lm-kpi-icon{ background:#f1eefe; color:#6d4fd6; }
    .lm-kpi:nth-child(3) .lm-kpi-icon{ background:var(--success-bg); color:var(--success); }
    .lm-kpi:nth-child(4) .lm-kpi-icon{ background:var(--warning-bg); color:var(--warning); }

    .lm-kpi-label{
        font-size:11px;
        font-weight:600;
        text-transform:uppercase;
        letter-spacing:.4px;
        color:var(--ink-500);
        margin-bottom:2px;
    }

    .lm-kpi-value{
        font-size:22px;
        font-weight:700;
        color:var(--ink-900);
        line-height:1;
    }

    /* =========================================================
       05. COMMAND CENTER
       ========================================================= */
    .lm-command{
        margin-bottom:var(--sp-4);
        overflow:hidden;
    }

    .lm-command-row{
        display:flex;
        align-items:center;
        gap:var(--sp-3);
        padding:var(--sp-4);
    }

    .lm-search{
        position:relative;
        flex:1 1 auto;
        min-width:0;
    }

    .lm-search i{
        position:absolute;
        left:13px;
        top:50%;
        transform:translateY(-50%);
        color:var(--ink-400);
        font-size:14px;
        pointer-events:none;
    }

    .lm-search input{
        width:100%;
        height:40px;
        border:1px solid var(--line);
        border-radius:var(--radius-sm);
        background:var(--surface-2);
        padding:0 12px 0 36px;
        font-size:13px;
        color:var(--ink-900);
        outline:none;
        transition:border-color .15s ease, background .15s ease, box-shadow .15s ease;
    }

    .lm-search input:focus{
        background:#fff;
        border-color:#a9d4ef;
        box-shadow:0 0 0 3px var(--blue-50);
    }

    .lm-command-actions{
        display:flex;
        align-items:center;
        gap:6px;
        flex-shrink:0;
    }

    .lm-icon-btn{
        height:40px;
        min-width:40px;
        padding:0 12px;
        border-radius:var(--radius-sm);
        border:1px solid var(--line);
        background:#fff;
        color:var(--ink-600);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        font-size:12px;
        font-weight:600;
        cursor:pointer;
        text-decoration:none;
        transition:background .15s ease, border-color .15s ease, color .15s ease;
    }

    .lm-icon-btn:hover, .lm-icon-btn.is-active{
        border-color:#bfe1f6;
        background:var(--blue-50);
        color:var(--blue-dark);
    }

    .lm-icon-btn.lm-export:hover{ border-color:#bfe9d3; background:var(--success-bg); color:var(--success); }
    .lm-icon-btn.lm-import:hover{ border-color:#bfe1f6; background:var(--blue-50); color:var(--blue-dark); }

    /* Filters panel */
    .lm-filters{
        max-height:0;
        overflow:hidden;
        border-top:1px solid transparent;
        transition:max-height .18s ease;
    }

    .lm-filters.is-open{
        max-height:220px;
        border-top-color:var(--line);
        transition:max-height .22s ease;
    }

    .lm-filters-inner{
        padding:var(--sp-4);
        background:var(--surface-2);
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr)) auto;
        gap:var(--sp-3);
        align-items:end;
    }

    .lm-field label{
        display:block;
        font-size:10px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.4px;
        color:var(--ink-500);
        margin-bottom:5px;
    }

    .lm-field select{
        width:100%;
        height:38px;
        border:1px solid var(--line);
        border-radius:var(--radius-sm);
        background:#fff;
        font-size:12.5px;
        color:var(--ink-700);
        padding:0 10px;
        outline:none;
    }

    .lm-field select:focus{ border-color:#a9d4ef; box-shadow:0 0 0 3px var(--blue-50); }

    .lm-filters-btns{ display:flex; gap:6px; }
    .lm-filters-btns .lm-btn{ height:38px; }

    /* =========================================================
       06. SOURCE SEGMENT + CATEGORY NAV
       ========================================================= */
    .lm-nav-row{
        display:flex;
        gap:var(--sp-4);
        margin-bottom:var(--sp-4);
        align-items:stretch;
    }

    .lm-segment{
        display:flex;
        gap:3px;
        padding:3px;
        flex-shrink:0;
    }

    .lm-segment a{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:8px 12px;
        border-radius:8px;
        font-size:12.5px;
        font-weight:600;
        color:var(--ink-600);
        text-decoration:none;
        white-space:nowrap;
        transition:background .15s ease, color .15s ease;
    }

    .lm-segment a:hover{ background:var(--surface-2); color:var(--ink-900); }

    .lm-segment a.active{
        background:var(--blue);
        color:#fff;
    }

    .lm-segment .lm-count{
        font-size:10px;
        font-weight:700;
        padding:1px 6px;
        border-radius:20px;
        background:rgba(0,0,0,.06);
    }

    .lm-segment a.active .lm-count{ background:rgba(255,255,255,.22); }

    .lm-categories{
        flex:1 1 auto;
        min-width:0;
        display:flex;
        align-items:center;
        overflow-x:auto;
        gap:6px;
        padding:8px 10px;
        scrollbar-width:none;
    }
    .lm-categories::-webkit-scrollbar{ display:none; }

    .lm-categories a{
        flex-shrink:0;
        display:inline-flex;
        align-items:center;
        padding:7px 12px;
        border-radius:8px;
        font-size:12px;
        font-weight:600;
        color:var(--ink-600);
        background:var(--surface-2);
        border:1px solid var(--line-strong);
        text-decoration:none;
        white-space:nowrap;
        transition:background .15s ease, color .15s ease, border-color .15s ease;
    }

    .lm-categories a:hover{ border-color:#d0d5dd; color:var(--ink-900); }

    .lm-categories a.active{
        background:var(--ink-900);
        border-color:var(--ink-900);
        color:#fff;
    }

    /* =========================================================
       07. STATUS + SOURCE BADGE SYSTEM
       ========================================================= */
    .lm-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:6px;
        padding:3px 8px;
        font-size:10.5px;
        font-weight:700;
        white-space:nowrap;
        letter-spacing:.1px;
    }

    .lm-badge-manual{ background:var(--success-bg); color:var(--success); }
    .lm-badge-csv{ background:var(--info-bg); color:var(--blue-dark); }

    .lm-status-pending{ background:var(--warning-bg); color:var(--warning); }
    .lm-status-accept{ background:var(--success-bg); color:var(--success); }
    .lm-status-reject{ background:var(--danger-bg); color:var(--danger); }
    .lm-status-call{ background:var(--info-bg); color:var(--blue-dark); }
    .lm-status-contacted{ background:#eaf4fc; color:#075a99; }



    /* =========================================================
       COMPACT STATUS DOT
       ========================================================= */
    .lm-status-dot{
        display:inline-block;
        width:10px;
        height:10px;
        border-radius:50%;
        vertical-align:middle;
    }

    .lm-status-dot.contacted{
        background:#16a34a;
        box-shadow:0 0 0 3px rgba(22,163,74,.12);
    }

    .lm-status-dot.pending{
        background:#dc2626;
        box-shadow:0 0 0 3px rgba(220,38,38,.12);
    }


    /* =========================================================
       BULK SELECT + DELETE
       ========================================================= */
    .lm-bulk-toolbar{
        display:none;
        align-items:center;
        gap:10px;
        margin-left:auto;
    }

    .lm-bulk-toolbar.is-visible{
        display:flex;
    }

    .lm-bulk-count{
        display:inline-flex;
        align-items:center;
        gap:6px;
        min-height:32px;
        padding:0 10px;
        border-radius:8px;
        background:#fff4f4;
        color:var(--danger);
        border:1px solid #f2cfcb;
        font-size:11px;
        font-weight:700;
    }

    .lm-bulk-delete-btn{
        min-height:32px;
        border:0;
        border-radius:8px;
        padding:0 11px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        background:var(--danger);
        color:#fff;
        font-size:11px;
        font-weight:700;
        cursor:pointer;
        transition:background .15s ease, transform .1s ease;
    }

    .lm-bulk-delete-btn:hover{
        background:#a91f16;
    }

    .lm-bulk-delete-btn:active{
        transform:scale(.97);
    }

    .lm-select-cell{
        width:38px;
        min-width:38px;
        max-width:38px;
        text-align:center !important;
        padding-left:7px !important;
        padding-right:7px !important;
    }

    .lm-select-check{
        appearance:none;
        -webkit-appearance:none;
        width:16px;
        height:16px;
        margin:0;
        border:1.5px solid #cbd5e1;
        border-radius:5px;
        background:#fff;
        display:inline-grid;
        place-content:center;
        cursor:pointer;
        vertical-align:middle;
        transition:background .13s ease, border-color .13s ease, box-shadow .13s ease;
    }

    .lm-select-check::before{
        content:"";
        width:8px;
        height:8px;
        transform:scale(0);
        transition:transform .1s ease;
        clip-path:polygon(14% 44%, 0 65%, 42% 100%, 100% 22%, 80% 4%, 40% 70%);
        background:#fff;
    }

    .lm-select-check:checked{
        background:var(--blue);
        border-color:var(--blue);
        box-shadow:0 0 0 3px rgba(11,116,196,.10);
    }

    .lm-select-check:checked::before{
        transform:scale(1);
    }

    .lm-select-check:indeterminate{
        background:var(--blue);
        border-color:var(--blue);
    }

    .lm-select-check:indeterminate::before{
        transform:scale(1);
        clip-path:none;
        width:8px;
        height:2px;
        border-radius:2px;
        background:#fff;
    }

    .lm-table tbody tr.is-selected{
        background:#f4f9fd;
    }

    .lm-mobile-select{
        position:absolute;
        top:11px;
        left:11px;
        z-index:3;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .lm-mcard.has-select{
        padding-left:38px;
    }

    .lm-mobile-bulkbar{
        display:none;
        position:sticky;
        top:8px;
        z-index:45;
        margin-bottom:8px;
        padding:8px 10px;
        border:1px solid #f1d0cd;
        border-radius:10px;
        background:#fff;
        box-shadow:0 6px 18px rgba(16,24,40,.09);
        align-items:center;
        justify-content:space-between;
        gap:8px;
    }

    .lm-mobile-bulkbar.is-visible{
        display:flex;
    }

    .lm-mobile-select-all{
        display:inline-flex;
        align-items:center;
        gap:7px;
        font-size:10.5px;
        font-weight:700;
        color:var(--ink-600);
    }

    @media(max-width:767.98px){
        .lm-bulk-toolbar{
            display:none !important;
        }
    }

    /* =========================================================
       SOURCE STRIP INDICATOR
       ========================================================= */
    .lm-source-strip-cell{
        width:7px;
        min-width:7px;
        max-width:7px;
        padding:0 !important;
        position:relative;
    }

    .lm-source-strip{
        display:block;
        width:5px;
        min-height:44px;
        height:100%;
        border-radius:0 4px 4px 0;
    }

    .lm-source-strip.bulk{
        background:#0b74c4;
    }

    .lm-source-strip.manual{
        background:#0f8a4b;
    }

    .lm-mcard-source-strip{
        position:absolute;
        top:10px;
        bottom:10px;
        left:0;
        width:4px;
        border-radius:0 4px 4px 0;
    }

    .lm-mcard-source-strip.bulk{
        background:#0b74c4;
    }

    .lm-mcard-source-strip.manual{
        background:#0f8a4b;
    }

    /* =========================================================
       08. DESKTOP DATA GRID
       ========================================================= */
    .lm-pipeline-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:var(--sp-4) var(--sp-5);
        border-bottom:1px solid var(--line);
    }

    .lm-pipeline-head h2{
        font-size:14px;
        font-weight:700;
        color:var(--ink-900);
        margin:0;
    }

    .lm-pipeline-head span{
        font-size:11.5px;
        color:var(--ink-400);
    }

    .lm-table-wrap{ overflow-x:auto; }

    .lm-table{
        width:100%;
        min-width:1160px;
        border-collapse:separate;
        border-spacing:0;
    }

    .lm-table thead th{
        position:sticky;
        top:0;
        background:var(--surface-2);
        border-bottom:1px solid var(--line);
        color:var(--ink-500);
        font-size:10.5px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.4px;
        text-align:left;
        padding:10px 12px;
        white-space:nowrap;
    }

    .lm-table thead th:nth-child(3){ padding-left:14px; }

    .lm-table tbody td{
        padding:12px;
        border-bottom:1px solid var(--line-strong);
        vertical-align:middle;
        font-size:12.5px;
        color:var(--ink-700);
    }

    .lm-table tbody td:nth-child(3){ padding-left:14px; color:var(--ink-400); }

    .lm-table tbody tr:last-child td{ border-bottom:0; }
    .lm-table tbody tr{ transition:background .12s ease; }
    .lm-table tbody tr:hover{ background:var(--surface-2); }
    .lm-table tbody tr:hover .lm-lead-name{ color:var(--blue-dark); }

    .lm-lead-name{ font-size:13px; font-weight:700; color:var(--ink-900); }
    .lm-lead-phone{ margin-top:2px; font-size:11px; color:var(--ink-400); }

    .lm-assignee{ display:flex; align-items:center; gap:8px; }

    .lm-avatar{
        width:26px; height:26px; flex-shrink:0;
        border-radius:7px;
        background:var(--blue-50);
        color:var(--blue-dark);
        display:grid; place-items:center;
        font-size:10.5px; font-weight:700;
    }

    .lm-assignee-name{ font-size:12px; font-weight:600; color:var(--ink-800, var(--ink-700)); }
    .lm-assignee-role{ font-size:10px; color:var(--ink-400); }

    .lm-unassigned{
        font-size:10.5px;
        font-weight:700;
        color:var(--ink-500);
        background:var(--surface-2);
        border:1px solid var(--line-strong);
        border-radius:6px;
        padding:3px 8px;
    }

    /* Actions cluster (desktop) */
    .lm-actions{
        display:inline-flex;
        align-items:center;
        gap:4px;
    }

    .lm-action{
        width:28px; height:28px;
        border-radius:7px;
        border:1px solid var(--line);
        background:#fff;
        color:var(--ink-500);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        cursor:pointer;
        transition:background .13s ease, color .13s ease, border-color .13s ease, transform .1s ease;
        font-size:12px;
    }

    .lm-action:active{ transform:scale(.94); }
    .lm-action.call:hover{ background:var(--info-bg); color:var(--blue-dark); border-color:#bfe1f6; }
    .lm-action.whatsapp:hover{ background:var(--success-bg); color:var(--success); border-color:#bfe9d3; }
    .lm-action.quote{ background:var(--blue); color:#fff; border-color:var(--blue); }
    .lm-action.quote:hover{ background:var(--blue-dark); }
    .lm-action.edit:hover{ background:var(--surface-2); color:var(--ink-900); }
    .lm-action.status:hover{ background:var(--surface-2); color:var(--ink-900); }
    .lm-action.delete:hover{ background:var(--danger-bg); color:var(--danger); border-color:#f6cfcb; }

    /* =========================================================
       09. MOBILE LEAD CARDS
       ========================================================= */
    .lm-mobile-list{ display:none; }

    .lm-mcard{
        position:relative;
        background:#fff;
        border:1px solid var(--line);
        border-radius:var(--radius-md);
        padding:11px 12px;
        margin-bottom:8px;
    }

    .lm-mcard-top{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:8px;
    }

    .lm-mcard-name{
        font-size:14px;
        font-weight:700;
        color:var(--ink-900);
        line-height:1.25;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
        max-width:200px;
    }

    .lm-mcard-phone{
        margin-top:1px;
        font-size:11px;
        color:var(--ink-400);
    }

    .lm-mcard-cat{
        display:inline-block;
        margin-top:6px;
        font-size:10.5px;
        font-weight:700;
        color:var(--blue-dark);
        max-width:100%;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .lm-mcard-req{
        margin-top:3px;
        font-size:11.5px;
        line-height:1.35;
        color:var(--ink-600);
        display:-webkit-box;
        -webkit-box-orient:vertical;
        -webkit-line-clamp:2;
        overflow:hidden;
    }

    .lm-mcard-meta{
        display:flex;
        flex-wrap:wrap;
        gap:4px 10px;
        margin-top:7px;
        font-size:10px;
        color:var(--ink-400);
    }

    .lm-mcard-meta span{ display:inline-flex; align-items:center; gap:3px; }

    .lm-mcard-actions{
        display:grid;
        grid-template-columns:1fr 1fr 1fr 32px;
        gap:6px;
        margin-top:9px;
    }

    .lm-maction{
        height:32px;
        border:0;
        border-radius:7px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:4px;
        font-size:10.5px;
        font-weight:700;
        text-decoration:none;
        padding:0 4px;
        cursor:pointer;
        white-space:nowrap;
        transition:filter .13s ease, transform .1s ease;
    }

    .lm-maction:active{ transform:scale(.96); }
    .lm-maction.call{ background:var(--info-bg); color:var(--blue-dark); }
    .lm-maction.whatsapp{ background:var(--success-bg); color:var(--success); }
    .lm-maction.quote{ background:var(--blue); color:#fff; }
    .lm-maction[disabled], .lm-maction.is-disabled{ opacity:.4; pointer-events:none; }

    .lm-more-wrap{ position:relative; }

    .lm-more-btn{
        width:32px; height:32px;
        border-radius:7px;
        border:1px solid var(--line);
        background:var(--surface-2);
        color:var(--ink-600);
        display:grid;
        place-items:center;
        cursor:pointer;
        transition:background .13s ease, border-color .13s ease, color .13s ease;
    }

    .lm-more-btn.is-active{ background:var(--blue-50); border-color:#bfe1f6; color:var(--blue-dark); }

    .lm-more-menu{
        display:none;
        position:absolute;
        right:0;
        bottom:38px;
        width:150px;
        padding:4px;
        background:#fff;
        border:1px solid var(--line);
        border-radius:10px;
        box-shadow:0 12px 30px rgba(16,24,40,.14);
        z-index:40;
    }

    .lm-more-menu.is-open{
        display:block;
        animation:lmMenuIn .13s ease-out;
    }

    @keyframes lmMenuIn{
        from{ opacity:0; transform:translateY(4px); }
        to{ opacity:1; transform:translateY(0); }
    }

    .lm-more-menu a{
        display:flex;
        align-items:center;
        gap:7px;
        padding:8px 9px;
        border-radius:7px;
        font-size:11.5px;
        font-weight:600;
        color:var(--ink-700);
        text-decoration:none;
    }

    .lm-more-menu a:hover{ background:var(--surface-2); }
    .lm-more-menu a.danger{ color:var(--danger); }


    /* =========================================================
       09B. LEAD ACTION PANEL
       ========================================================= */
    .lm-action-toggle-row{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:8px;
        margin-top:8px;
        padding-top:8px;
        border-top:1px solid var(--line-strong);
    }

    .lm-action-toggle{
        border:0;
        background:transparent;
        color:var(--blue-dark);
        font-size:10.5px;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        gap:5px;
        padding:2px 0;
        cursor:pointer;
    }

    .lm-action-toggle i{
        transition:transform .16s ease;
    }

    .lm-action-toggle.is-open i{
        transform:rotate(180deg);
    }

    .lm-action-last{
        font-size:9.5px;
        color:var(--ink-400);
        display:inline-flex;
        align-items:center;
        gap:4px;
    }

    .lm-action-panel{
        display:none;
        margin-top:8px;
        padding:9px;
        border:1px solid #d9e9f4;
        border-radius:10px;
        background:#f2f8fc;
    }

    .lm-action-panel.is-open{
        display:block;
        animation:lmActionPanelIn .15s ease-out;
    }

    @keyframes lmActionPanelIn{
        from{
            opacity:0;
            transform:translateY(-3px);
        }
        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .lm-action-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:6px;
    }

    .lm-lead-action-btn{
        min-height:35px;
        border:1px solid #dfe6ec;
        border-radius:7px;
        background:#fff;
        color:var(--ink-700);
        padding:6px 8px;
        display:flex;
        align-items:center;
        gap:6px;
        text-align:left;
        font-size:10px;
        line-height:1.2;
        font-weight:600;
        cursor:pointer;
        transition:
            border-color .14s ease,
            background .14s ease,
            color .14s ease,
            transform .1s ease,
            box-shadow .14s ease;
    }

    .lm-lead-action-btn:hover{
        border-color:#b7d8ed;
        background:#fbfdff;
        color:var(--blue-dark);
        box-shadow:0 1px 2px rgba(16,24,40,.03);
    }

    .lm-lead-action-btn:active{
        transform:scale(.98);
    }

    .lm-lead-action-btn i{
        width:16px;
        flex:0 0 16px;
        text-align:center;
        color:var(--blue-dark);
        font-size:11px;
    }

    .lm-lead-action-btn.is-saving{
        pointer-events:none;
        opacity:.65;
    }

    .lm-lead-action-btn.is-done{
        border-color:#b8e7cc;
        background:#effbf4;
        color:var(--success);
    }

    .lm-lead-action-btn.is-done i{
        color:var(--success);
    }

    .lm-lead-action-btn.action-deal{
        border-color:#cce8d8;
    }

    .lm-lead-action-btn.action-deal i{
        color:var(--success);
    }

    .lm-lead-action-btn.action-danger{
        border-color:#f0d6d3;
    }

    .lm-lead-action-btn.action-danger i{
        color:var(--danger);
    }

    .lm-action-feedback{
        display:none;
        margin-top:7px;
        padding:7px 8px;
        border-radius:7px;
        font-size:9.5px;
        font-weight:600;
    }

    .lm-action-feedback.success{
        display:block;
        background:var(--success-bg);
        color:var(--success);
        border:1px solid #cdeedb;
    }

    .lm-action-feedback.error{
        display:block;
        background:var(--danger-bg);
        color:var(--danger);
        border:1px solid #f3d3cf;
    }

    .lm-action-panel-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:8px;
        margin-bottom:7px;
    }

    .lm-action-panel-title{
        display:flex;
        align-items:center;
        gap:5px;
        font-size:10px;
        font-weight:700;
        color:var(--ink-700);
        text-transform:uppercase;
        letter-spacing:.35px;
    }

    .lm-action-panel-title i{
        color:var(--blue-dark);
    }

    .lm-action-panel-close{
        width:24px;
        height:24px;
        border:0;
        border-radius:6px;
        background:rgba(255,255,255,.75);
        color:var(--ink-500);
        display:grid;
        place-items:center;
        cursor:pointer;
    }

    .lm-action-panel-close:hover{
        background:#fff;
        color:var(--ink-900);
    }

    /*
    |--------------------------------------------------------------------------
    | DESKTOP LEAD ACTION PANEL — FLOAT ABOVE TABLE
    |--------------------------------------------------------------------------
    |
    | Previously .lm-action-panel lived in normal table-cell flow.
    | Opening it increased the entire <tr> height, creating the large
    | blank area visible in the Lead Index.
    |
    | On desktop it is now a viewport-positioned popover.
    | Mobile keeps the original inline accordion behaviour.
    |
    */

    @media (min-width:768px){

        .lm-actions-cell{
            position:relative;
            overflow:visible;
        }

        .lm-action-panel{
            position:fixed;
            display:none;
            width:320px;
            max-width:calc(100vw - 24px);
            max-height:calc(100vh - 24px);
            margin:0;
            overflow-y:auto;
            z-index:1080;
            box-shadow:
                0 18px 45px rgba(16,24,40,.18),
                0 3px 10px rgba(16,24,40,.08);
        }

        .lm-action-panel.is-open{
            display:block;
        }

        .lm-action-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
    }

    /* @media (min-width:768px){
        .lm-action-toggle-row,
        .lm-action-panel{
            display:none !important;
        }
    } */

    @media (max-width:430px){
        .lm-action-panel{
            padding:8px;
        }

        .lm-action-grid{
            gap:5px;
        }

        .lm-lead-action-btn{
            min-height:34px;
            padding:5px 7px;
            font-size:9.5px;
        }
    }

    /* =========================================================
       10. PAGINATION WRAP
       ========================================================= */
    .lm-pagination{
        padding:var(--sp-4) var(--sp-5);
        border-top:1px solid var(--line);
    }

    /* =========================================================
       11. QUICK QUOTATION MODAL
       ========================================================= */
    .lm-quote-modal{
        border:0;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 24px 60px rgba(16,24,40,.22);
    }

    .lm-quote-modal .modal-header{
        padding:16px 18px;
        border-bottom:1px solid var(--line);
        background:#fff;
    }

    .lm-quote-modal .modal-title{
        font-size:15px;
        font-weight:700;
        color:var(--ink-900);
    }

    .lm-quote-modal .modal-body{
        padding:16px 18px;
        max-height:66vh;
        overflow-y:auto;
        background:var(--surface-2);
    }

    .lm-quote-row{
        background:#fff;
        border:1px solid var(--line);
        border-radius:12px;
        padding:14px;
        margin-bottom:10px;
        position:relative;
        transition:border-color .13s ease;
    }
    .lm-quote-row:focus-within{ border-color:#a9d4ef; }

    .lm-quote-remove{
        position:absolute;
        right:8px; top:8px;
        width:26px; height:26px;
        border:0; border-radius:7px;
        background:var(--danger-bg);
        color:var(--danger);
        font-size:14px;
        line-height:1;
        cursor:pointer;
    }

    .lm-quote-row label{
        display:block;
        font-size:11px;
        font-weight:700;
        color:var(--ink-500);
        margin-bottom:5px;
    }

    .lm-quote-or{
        text-align:center;
        font-size:10.5px;
        font-weight:700;
        color:var(--ink-400);
        margin:10px 0;
        text-transform:uppercase;
        letter-spacing:.5px;
    }

    .lm-quote-add{
        display:inline-flex;
        align-items:center;
        gap:5px;
        border:0;
        background:none;
        color:var(--blue-dark);
        font-size:12.5px;
        font-weight:700;
        padding:6px 0;
        cursor:pointer;
    }

    .lm-quote-switch{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        min-height:56px;
        border:1px solid var(--line);
        border-radius:10px;
        background:#fff;
        padding:10px 12px;
    }

    .lm-quote-switch strong{ font-size:12.5px; color:var(--ink-900); display:block; }
    .lm-quote-switch small{ font-size:10.5px; color:var(--ink-400); }

    .lm-quote-summary{
        border-top:1px dashed #d5dae1;
        padding-top:12px;
        margin-top:16px;
    }

    .lm-quote-summary-row{
        display:flex;
        justify-content:space-between;
        font-size:12.5px;
        color:var(--ink-600);
        margin-bottom:6px;
    }

    .lm-quote-summary-row strong{ color:var(--ink-900); }

    .lm-quote-total{
        background:var(--ink-900);
        color:#fff;
        padding:14px 18px;
        display:flex;
        align-items:center;
        justify-content:space-between;
    }

    .lm-quote-total strong{ font-size:17px; font-variant-numeric:tabular-nums; }

    .lm-quote-status{
        display:none;
        font-size:11.5px;
        margin-bottom:9px;
        padding:8px 10px;
        border-radius:8px;
    }
    .lm-quote-status.success{ display:block; background:var(--success-bg); color:var(--success); }
    .lm-quote-status.error{ display:block; background:var(--danger-bg); color:var(--danger); }

    .lm-quote-modal .form-control{
        border-radius:8px;
        border-color:var(--line);
        font-size:12.5px;
    }
    .lm-quote-modal .form-control:focus{
        border-color:#a9d4ef;
        box-shadow:0 0 0 3px var(--blue-50);
    }
    .lm-quote-modal .input-group-text{
        border-color:var(--line);
        background:var(--surface-2);
        color:var(--ink-600);
    }

    .lm-quote-modal .btn-success{
        min-height:44px;
        border:0;
        border-radius:10px;
        background:var(--success);
        font-size:13px;
        font-weight:700;
    }
    .lm-quote-modal .btn-success:hover{ background:#0b6f3b; }


    /* =========================================================
       11B. DETAILED QUOTATION PDF LIBRARY MODAL
       ========================================================= */
    .lm-action.detail-quote{background:#f3efff;border-color:#ddd2ff;color:#6941c6;}
    .lm-action.detail-quote:hover{background:#ebe4ff;border-color:#cbbcff;color:#53389e;}
    .lm-maction.detail-quote{background:#f3efff;color:#6941c6;}

    .lm-detail-quote-modal{
        border:0;border-radius:18px;overflow:hidden;
        box-shadow:0 24px 70px rgba(15,23,42,.20);
    }
    .lm-detail-quote-modal .modal-header{
        padding:17px 19px;border-bottom:1px solid var(--line);background:#fff;
    }
    .lm-detail-quote-eyebrow{
        display:flex;align-items:center;gap:6px;margin-bottom:3px;color:#6941c6;
        font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.45px;
    }
    .lm-detail-quote-modal .modal-title{margin:0;color:var(--ink-900);font-size:16px;font-weight:750;}
    .lm-detail-quote-modal .modal-body{
        padding:16px 18px;background:#f8fafc;max-height:66vh;overflow-y:auto;
    }
    .lm-detail-quote-lead{
        display:flex;align-items:center;gap:10px;padding:10px 12px;margin-bottom:12px;
        border:1px solid #e3e8ef;border-radius:11px;background:#fff;
    }
    .lm-detail-quote-lead-icon{
        width:34px;height:34px;border-radius:9px;display:grid;place-items:center;
        flex:0 0 34px;background:var(--blue-50);color:var(--blue-dark);
    }
    .lm-detail-quote-lead strong{display:block;color:var(--ink-900);font-size:12px;}
    .lm-detail-quote-lead small{display:block;margin-top:1px;color:var(--ink-400);font-size:10.5px;}
    .lm-detail-quote-search{position:relative;margin-bottom:10px;}
    .lm-detail-quote-search i{
        position:absolute;left:12px;top:50%;transform:translateY(-50%);
        color:var(--ink-400);pointer-events:none;
    }
    .lm-detail-quote-search input{
        width:100%;height:40px;padding:0 12px 0 35px;border:1px solid var(--line);
        border-radius:9px;background:#fff;color:var(--ink-900);font-size:12px;outline:none;
    }
    .lm-detail-quote-search input:focus{border-color:#cbbcff;box-shadow:0 0 0 3px #f3efff;}
    .lm-detail-quote-list{display:grid;gap:8px;}
    .lm-detail-quote-item{position:relative;display:block;margin:0;cursor:pointer;}
    .lm-detail-quote-item input{position:absolute;opacity:0;pointer-events:none;}
    .lm-detail-quote-card{
        display:flex;align-items:center;gap:11px;min-height:58px;padding:10px 11px;
        border:1px solid #e1e6ec;border-radius:11px;background:#fff;
        transition:border-color .14s ease, box-shadow .14s ease, background .14s ease;
    }
    .lm-detail-quote-item:hover .lm-detail-quote-card{border-color:#cbbcff;}
    .lm-detail-quote-item input:checked + .lm-detail-quote-card{
        border-color:#8f6ee8;background:#faf8ff;box-shadow:0 0 0 3px rgba(105,65,198,.08);
    }
    .lm-detail-quote-pdf{
        width:38px;height:38px;flex:0 0 38px;border-radius:9px;display:grid;place-items:center;
        background:#fff1f2;color:#c9273a;font-size:18px;
    }
    .lm-detail-quote-copy{min-width:0;flex:1;}
    .lm-detail-quote-copy strong{
        display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
        color:var(--ink-900);font-size:12px;font-weight:700;
    }
    .lm-detail-quote-copy small{display:block;margin-top:2px;color:var(--ink-400);font-size:10px;}
    .lm-detail-quote-check{
        width:22px;height:22px;flex:0 0 22px;border:1.5px solid #d0d5dd;
        border-radius:50%;display:grid;place-items:center;color:transparent;font-size:11px;
    }
    .lm-detail-quote-item input:checked + .lm-detail-quote-card .lm-detail-quote-check{
        border-color:#6941c6;background:#6941c6;color:#fff;
    }
    .lm-detail-quote-empty{
        padding:28px 14px;border:1px dashed #d8dee7;border-radius:11px;
        background:#fff;text-align:center;color:var(--ink-500);font-size:12px;
    }
    .lm-detail-quote-preview{display:none;margin-top:11px;padding-top:11px;border-top:1px solid var(--line);}
    .lm-detail-quote-preview.is-visible{display:flex;}
    .lm-detail-quote-preview a{
        display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border:1px solid #d9e4ee;
        border-radius:8px;background:#fff;color:var(--blue-dark);font-size:11px;font-weight:700;text-decoration:none;
    }
    .lm-detail-quote-status{display:none;margin-top:10px;padding:8px 10px;border-radius:8px;font-size:11px;font-weight:600;}
    .lm-detail-quote-status.success{display:block;border:1px solid #cdeedb;background:var(--success-bg);color:var(--success);}
    .lm-detail-quote-status.error{display:block;border:1px solid #f3d3cf;background:var(--danger-bg);color:var(--danger);}
    .lm-detail-quote-modal .modal-footer{padding:12px 18px;border-top:1px solid var(--line);background:#fff;}
    .lm-detail-quote-send{
        min-height:42px;border:0;border-radius:9px;background:#0f8a4b;color:#fff;font-size:12px;font-weight:750;
    }
    .lm-detail-quote-send:hover{background:#0b6f3b;color:#fff;}

    @media(max-width:767.98px){
        .lm-mcard-actions{grid-template-columns:1fr 1fr 1fr 1fr 32px;}
        .lm-maction.detail-quote{font-size:9px;}
    }

    @media(max-width:430px){
        .lm-mcard-actions{grid-template-columns:1fr 1fr;}
        .lm-more-wrap{grid-column:2;}
        .lm-more-btn{width:100%;}
        .lm-more-menu{right:0;}
    }

    /* =========================================================
       12. ACCESSIBILITY
       ========================================================= */
    .lm a:focus-visible,
    .lm button:focus-visible{
        outline:2px solid var(--blue);
        outline-offset:2px;
    }

    @media (prefers-reduced-motion: reduce){
        .lm *, .lm *::before, .lm *::after{
            animation-duration:.001ms !important;
            transition-duration:.001ms !important;
        }
    }

    /* =========================================================
       13. TABLET
       ========================================================= */
    @media (max-width:1100px){
        .lm-nav-row{ flex-direction:column; }
        .lm-filters-inner{ grid-template-columns:repeat(2,minmax(0,1fr)); }
        .lm-filters-btns{ grid-column:1/-1; }
    }

    @media (max-width:991.98px){
        .lm-kpis{ grid-template-columns:repeat(2,minmax(0,1fr)); }
    }

    /* =========================================================
       14. MOBILE
       ========================================================= */
    @media (max-width:767.98px){
        body{ background:var(--page-bg); }

        .lm-header{
            padding:12px 14px;
            margin-bottom:8px;
            align-items:center;
        }
        .lm-header-title p{ display:none; }
        .lm-header-title h1{ font-size:16px; }
        .lm-btn{ height:34px; padding:0 11px; font-size:12px; }

        .lm-kpis{
            grid-template-columns:repeat(4,1fr);
            gap:0;
            margin-bottom:8px;
            border-radius:12px;
            overflow:hidden;
        }
        .lm-kpi{
            flex-direction:column;
            align-items:flex-start;
            justify-content:center;
            padding:8px 6px;
            gap:2px;
        }
        .lm-kpi:not(:last-child){ border-right:1px solid var(--line-strong); }
        .lm-kpi-icon{ display:none; }
        .lm-kpi-label{ font-size:7.5px; white-space:nowrap; }
        .lm-kpi-value{ font-size:15px; }

        .lm-command{ margin-bottom:8px; border-radius:12px; }
        .lm-command-row{ padding:8px; gap:6px; }
        .lm-search input{ height:36px; font-size:12px; }
        .lm-icon-btn{ height:36px; min-width:36px; padding:0 8px; }
        .lm-icon-btn span{ display:none; }

        .lm-filters-inner{ grid-template-columns:1fr; padding:10px; }
        .lm-filters-btns{ display:grid; grid-template-columns:1fr auto; }

        .lm-nav-row{ gap:6px; margin-bottom:8px; }
        .lm-segment{ display:grid; grid-template-columns:repeat(3,1fr); border-radius:11px; }
        .lm-segment a{ justify-content:center; padding:8px 4px; font-size:10.5px; }
        .lm-categories{ padding:6px 8px; }
        .lm-categories a{ padding:6px 10px; font-size:11px; }

        .lm-table-wrap{ display:none; }
        .lm-pipeline-head{ display:none; }
        .lm-mobile-list{ display:block; padding:2px; }
        .lm-pipeline-card{ background:transparent; border:0; box-shadow:none; }

        .lm-pagination{ background:#fff; border:1px solid var(--line); border-radius:12px; margin-top:8px; padding:10px; }
    }

    @media (max-width:430px){
        .lm-mcard-name{ max-width:170px; font-size:13px; }
        .lm-maction{ font-size:9.5px; }
        .lm-kpi-label{ font-size:6.5px; }
        .lm-kpi-value{ font-size:14px; }
    }

    

        /* Styles for Mobile Phones (screens up to 600px wide) */
    @media screen and (max-width: 600px) {
        .main_content {
            padding: 20px 7px 20px 7px;
        }
    }

    /* Styles for Tablets (screens between 601px and 1024px wide) */
    @media screen and (min-width: 601px) and (max-width: 1024px) {
        .main_content {
            padding: 20px 7px 20px 7px;
        }
    }

    /*  */

    .lm-page-size-control{
    display:flex;
    align-items:center;
    gap:7px;
    margin-left:14px;
}

.lm-page-size-label{
    font-size:10px !important;
    font-weight:700;
    color:var(--ink-500) !important;
    text-transform:uppercase;
    letter-spacing:.4px;
}

.lm-page-size-select{
    height:32px;
    min-width:78px;
    padding:0 28px 0 10px;
    border:1px solid var(--line);
    border-radius:8px;
    background:#fff;
    color:var(--ink-700);
    font-size:11px;
    font-weight:700;
    outline:none;
    cursor:pointer;
}

.lm-page-size-select:hover{
    border-color:#b8c7d5;
}

.lm-page-size-select:focus{
    border-color:var(--blue);
    box-shadow:0 0 0 3px var(--blue-50);
}

.lm-custom-page-size{
    display:flex;
    align-items:center;
    gap:5px;
}

.lm-custom-page-size input{
    width:78px;
    height:32px;
    border:1px solid var(--line);
    border-radius:8px;
    padding:0 9px;
    font-size:11px;
    outline:none;
}

.lm-custom-page-size input:focus{
    border-color:var(--blue);
    box-shadow:0 0 0 3px var(--blue-50);
}

.lm-custom-page-size button{
    height:32px;
    padding:0 10px;
    border:0;
    border-radius:8px;
    background:var(--blue);
    color:#fff;
    font-size:10px;
    font-weight:700;
    cursor:pointer;
}

.lm-custom-page-size button:hover{
    background:var(--blue-dark);
}



</style>

<style>
.required-outcome-grid,.required-reason-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}
.required-outcome-choice,.required-reason-choice{display:flex;align-items:center;gap:9px;padding:10px;border:1px solid #dae3ed;border-radius:9px;cursor:pointer;font-weight:600;font-size:13px;background:#fff}
.required-outcome-choice:has(input:checked),.required-reason-choice:has(input:checked){border-color:#1698ed;background:#eef8ff;color:#075b9b}
.required-outcome-choice input,.required-reason-choice input{accent-color:#1595e5;width:16px;height:16px;flex:none}
#requiredCallModal .modal-dialog{max-height:calc(100dvh - 2rem);margin:1rem auto}
#requiredCallModal .modal-content{max-height:calc(100dvh - 2rem);overflow:hidden}
#requiredCallForm{display:flex;flex-direction:column;min-height:0;max-height:calc(100dvh - 2rem)}
#requiredCallForm .modal-header,#requiredCallForm .modal-footer{flex:0 0 auto}
#requiredCallForm .modal-body{flex:1 1 auto;min-height:0;overflow-y:auto;overscroll-behavior:contain}
.required-calendar{border:1px solid #dbe5ef;border-radius:12px;padding:12px;background:#fbfdff}
.required-calendar-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px}
.required-calendar-top button{border:1px solid #dce5ef;border-radius:8px;background:#fff;color:#0875b9;width:34px;height:34px}
.required-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:3px;text-align:center}
.required-calendar-weekdays{font-size:11px;font-weight:700;color:#667085;margin-bottom:4px}
.required-calendar-grid button{width:100%;min-width:0;min-height:35px;border:0;border-radius:7px;background:transparent;color:#293e50}
.required-calendar-grid button:hover{background:#e2f2ff}.required-calendar-grid button.is-today{outline:1px solid #9bd5f8}
.required-calendar-grid button.is-selected{background:#0b84cf;color:#fff;font-weight:700}
.required-calendar-bottom{display:flex;align-items:center;justify-content:space-between;gap:12px;border-top:1px solid #e6edf4;margin-top:10px;padding-top:10px;font-size:12px}
.required-calendar-bottom label{display:flex;align-items:center;gap:8px;margin:0}.required-calendar-bottom input{width:115px}
.required-priority-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}
.required-priority-choice{display:flex;align-items:center;gap:7px;border:1px solid #dce5ee;padding:10px;border-radius:9px;cursor:pointer;font-weight:700;font-size:13px}
.required-priority-choice input{width:16px;height:16px;flex:none}.required-priority-choice.hot input{accent-color:#bf283a}.required-priority-choice.warm input{accent-color:#a05b00}.required-priority-choice.cold input{accent-color:#1565ae}
.required-priority-choice.hot:has(input:checked){background:#fff1f2;border-color:#f5aeb8;color:#b41f35}
.required-priority-choice.warm:has(input:checked){background:#fff7e6;border-color:#efcb8a;color:#985800}
.required-priority-choice.cold:has(input:checked){background:#eef6ff;border-color:#aad2fa;color:#155b9d}
@media(max-width:480px){.required-outcome-grid,.required-reason-grid{grid-template-columns:1fr}.required-priority-grid{gap:4px}.required-priority-choice{font-size:11px;padding:7px 4px}}
</style>
@endpush

@section('content')
<div class="lm">

    {{-- =====================================================
         HEADER
         ===================================================== --}}
    <header class="lm-card lm-header">
        <div class="lm-header-title">
            <h1>{{ get_phrase('Lead Management') }}</h1>
            <p>{{ get_phrase('Manage enquiries, assignments, follow-ups and quotations') }}</p>
        </div>

        <div class="lm-header-actions">
            <a href="{{ route('admin.dashboard') }}" class="lm-btn lm-btn-secondary">
                <i class="bi bi-grid"></i>
                <span class="d-none d-sm-inline">{{ get_phrase('Dashboard') }}</span>
            </a>

            @can('lead-create')
                <a href="#"
                   class="lm-btn lm-btn-primary"
                   onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/add']) }}','{{ get_phrase('Add new lead') }}'); return false;">
                    <i class="bi bi-plus-lg"></i>
                    <span>{{ get_phrase('Add Lead') }}</span>
                </a>
            @endcan
        </div>
    </header>

    {{-- =====================================================
         KPI STRIP
         ===================================================== --}}
    <section class="lm-kpis">
        <div class="lm-card lm-kpi">
            <div class="lm-kpi-icon"><i class="bi bi-people"></i></div>
            <div>
                <div class="lm-kpi-label">{{ get_phrase('Leads In Queue') }}</div>
                <div class="lm-kpi-value tabular">{{ number_format($totalLeads ?? 0) }}</div>
            </div>
        </div>

        <div class="lm-card lm-kpi">
            <div class="lm-kpi-icon"><i class="bi bi-cloud-arrow-up"></i></div>
            <div>
                <div class="lm-kpi-label">{{ get_phrase('Bulk Upload') }}</div>
                <div class="lm-kpi-value tabular">{{ number_format($csvLeads ?? 0) }}</div>
            </div>
        </div>

        <div class="lm-card lm-kpi">
            <div class="lm-kpi-icon"><i class="bi bi-person-plus"></i></div>
            <div>
                <div class="lm-kpi-label">{{ get_phrase('Manual Leads') }}</div>
                <div class="lm-kpi-value tabular">{{ number_format($manualLeads ?? 0) }}</div>
            </div>
        </div>

        <div class="lm-card lm-kpi">
            <div class="lm-kpi-icon"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="lm-kpi-label">{{ get_phrase('Pending') }}</div>
                <div class="lm-kpi-value tabular">{{ number_format($pendingLeads ?? 0) }}</div>
            </div>
        </div>
    </section>

    {{-- =====================================================
         COMMAND CENTER
         ===================================================== --}}
    <section class="lm-card lm-command">
        <form method="GET" action="{{ url()->current() }}">
            @if(request('source'))
                <input type="hidden" name="source" value="{{ request('source') }}">
            @endif

            <div class="lm-command-row">
                <div class="lm-search">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="{{ get_phrase('Search lead by name, phone, requirement or remarks') }}">
                </div>

                <div class="lm-command-actions">
                    <button type="submit" class="lm-icon-btn" title="{{ get_phrase('Search') }}">
                        <i class="bi bi-arrow-right"></i>
                        <span>{{ get_phrase('Search') }}</span>
                    </button>

                    <button type="button"
                            id="leadFilterToggleBtn"
                            class="lm-icon-btn"
                            aria-expanded="{{ request('status') || request('assigned_user') ? 'true' : 'false' }}"
                            onclick="toggleLeadFilters()"
                            title="{{ get_phrase('Advanced Filters') }}">
                        <i class="bi bi-sliders"></i>
                        <span>{{ get_phrase('Filters') }}</span>
                    </button>

                    <a href="{{ route('admin.leads.export', request()->route('id')) }}"
                       class="lm-icon-btn lm-export"
                       title="{{ get_phrase('Export CSV') }}">
                        <i class="bi bi-download"></i>
                        <span>{{ get_phrase('Export') }}</span>
                    </a>

                    <button type="button"
                            class="lm-icon-btn lm-import"
                            title="{{ get_phrase('Bulk Upload') }}"
                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/import']) }}','{{ get_phrase('Import Leads') }}')">
                        <i class="bi bi-upload"></i>
                        <span>{{ get_phrase('Upload') }}</span>
                    </button>
                </div>
            </div>

            <div id="leadAdvancedFilters"
                 class="lm-filters {{ request('status') || request('assigned_user') ? 'is-open' : '' }}">
                <div class="lm-filters-inner">

                    <div class="lm-field">
                        <label>{{ get_phrase('Status') }}</label>
                        <select name="status">
                            <option value="">{{ get_phrase('All Status') }}</option>
                            <option value="pending" {{ request('status')==='pending'?'selected':'' }}>{{ get_phrase('Pending') }}</option>
                        </select>
                    </div>

                    @if(auth()->user()->hasRole('Admin'))
                        <div class="lm-field">
                            <label>{{ get_phrase('Assigned Sales') }}</label>
                            <select name="assigned_user">
                                <option value="">{{ get_phrase('All Leads') }}</option>
                                <option value="unassigned" {{ request('assigned_user')==='unassigned'?'selected':'' }}>{{ get_phrase('Unassigned') }}</option>

                                @foreach($salesUsers ?? [] as $salesUser)
                                    <option value="{{ $salesUser->id }}"
                                        {{ (string)request('assigned_user') === (string)$salesUser->id ? 'selected':'' }}>
                                        {{ $salesUser->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="lm-field">
                        <label>{{ get_phrase('Source') }}</label>
                        <select name="source">
                            <option value="">{{ get_phrase('All Sources') }}</option>
                            <option value="manual" {{ request('source')==='manual'?'selected':'' }}>{{ get_phrase('Manual') }}</option>
                            <option value="csv" {{ request('source')==='csv'?'selected':'' }}>{{ get_phrase('Bulk Upload') }}</option>
                        </select>
                    </div>

                    <div class="lm-filters-btns">
                        <button type="submit" class="lm-btn lm-btn-primary">{{ get_phrase('Apply') }}</button>
                        <a href="{{ request()->url() }}" class="lm-btn lm-btn-secondary">{{ get_phrase('Reset') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    {{-- =====================================================
         SOURCE SEGMENT + CATEGORY NAVIGATION
         ===================================================== --}}
    <section class="lm-nav-row">
        <div class="lm-card lm-segment">
            <a class="{{ !request('source') ? 'active' : '' }}"
               href="{{ request()->fullUrlWithQuery(['source'=>null,'page'=>null]) }}">
                {{ get_phrase('All') }}
                <span class="lm-count">{{ $totalLeads ?? 0 }}</span>
            </a>

            <a class="{{ request('source') === 'manual' ? 'active' : '' }}"
               href="{{ request()->fullUrlWithQuery(['source'=>'manual','page'=>null]) }}">
                {{ get_phrase('Manual') }}
                <span class="lm-count">{{ $manualLeads ?? 0 }}</span>
            </a>

            <a class="{{ request('source') === 'csv' ? 'active' : '' }}"
               href="{{ request()->fullUrlWithQuery(['source'=>'csv','page'=>null]) }}">
                {{ get_phrase('Bulk') }}
                <span class="lm-count">{{ $csvLeads ?? 0 }}</span>
            </a>
        </div>

        <div class="lm-card lm-categories">
            <a class="{{ !request()->route('id') ? 'active' : '' }}"
               href="{{ route('admin.leads.index', array_filter([
                    'source'=>request('source'),
                    'search'=>request('search'),
                    'status'=>request('status'),
                    'assigned_user'=>auth()->user()->hasRole('Admin') ? request('assigned_user') : null
               ])) }}">
                {{ get_phrase('All Categories') }}
            </a>

            @foreach($categories ?? [] as $cat)
                <a class="{{ (string)request()->route('id') === (string)$cat->id ? 'active' : '' }}"
                   href="{{ route('admin.leads.index', array_filter([
                        'id'=>$cat->id,
                        'source'=>request('source'),
                        'search'=>request('search'),
                        'status'=>request('status'),
                        'assigned_user'=>auth()->user()->hasRole('Admin') ? request('assigned_user') : null
                   ])) }}">
                    {{ $cat->title }} ({{ $categoryCounts[$cat->id] ?? 0 }})
                </a>
            @endforeach
        </div>
    </section>

    {{-- =====================================================
         LEAD PIPELINE (DESKTOP GRID + MOBILE CARDS)
         ===================================================== --}}
    <section class="lm-card lm-pipeline-card">
        <div class="lm-pipeline-head">

            <div style="display: flex;">
                <h2>{{ get_phrase('Lead Pipeline') }}</h2>

                {{--  --}}

                <div class="lm-page-size-control">

                    <span class="lm-page-size-label">
                        {{ get_phrase('') }}
                    </span>

                    <select id="leadPerPage"
                            class="lm-page-size-select"
                            onchange="changeLeadPerPage(this.value)">

                        <option value="25"
                            {{ request('per_page', 25) == 25 ? 'selected' : '' }}>
                            25
                        </option>

                        <option value="100"
                            {{ request('per_page') == 100 ? 'selected' : '' }}>
                            100
                        </option>

                        <option value="200"
                            {{ request('per_page') == 200 ? 'selected' : '' }}>
                            200
                        </option>

                        <option value="500"
                            {{ request('per_page') == 500 ? 'selected' : '' }}>
                            500
                        </option>

                        <option value="custom"
                            {{ request('per_page') === 'custom' ? 'selected' : '' }}>
                            Custom
                        </option>

                    </select>

                    <div id="leadCustomPageSize"
                        class="lm-custom-page-size"
                        style="{{ request('per_page') === 'custom' ? '' : 'display:none;' }}">

                        <input type="number"
                            id="leadCustomPageInput"
                            min="1"
                            max="1000"
                            value="{{ request('custom_per_page', 100) }}"
                            placeholder="1–1000">

                        <button type="button"
                                onclick="applyCustomLeadPerPage()">
                            Apply
                        </button>

                    </div>

                </div>

            </div>


            {{--  --}}

            <div class="lm-bulk-toolbar"
                 id="leadBulkToolbar">

                <span class="lm-bulk-count">
                    <i class="bi bi-check2-square"></i>
                    <span id="leadBulkSelectedCount">0</span>
                    {{ get_phrase('selected') }}
                </span>

                <button type="button"
                        class="lm-bulk-delete-btn"
                        id="leadBulkDeleteButton"
                        onclick="deleteSelectedLeads()">
                    <i class="bi bi-trash3"></i>
                    {{ get_phrase('Delete Selected') }}
                </button>
            </div>

            <span id="leadPipelineShowingText">
                {{ get_phrase('Showing') }} {{ $leads->firstItem() ?? 0 }}&ndash;{{ $leads->lastItem() ?? 0 }}
                {{ get_phrase('of') }} {{ $leads->total() ?? 0 }} {{ get_phrase('leads') }}
            </span>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="lm-table-wrap">
            <table class="lm-table">
                <thead>
                    <tr>
                        <th class="lm-source-strip-cell"></th>

                        <th class="lm-select-cell">
                            <input type="checkbox"
                                   class="lm-select-check"
                                   id="leadSelectAllDesktop"
                                   aria-label="{{ get_phrase('Select all leads on this page') }}"
                                   onchange="toggleSelectAllLeads(this.checked)">
                        </th>

                        <th>#</th>
                        <th>{{ get_phrase('Lead') }}</th>
                        <th>{{ get_phrase('Phone no.') }}</th>
                        <th>{{ get_phrase('Category') }}</th>
                        <th>{{ get_phrase('Assigned Sales') }}</th>
                        <th>{{ get_phrase('Status') }}</th>
                        <th>{{ get_phrase('Date') }}</th>
                        <th class="text-center">{{ get_phrase('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($leads as $lead)
                        @php
                            $desktopPhone = preg_replace('/[^0-9]/', '', $lead->phone ?? '');
                            $desktopWhatsApp = $desktopPhone;

                            if (strlen($desktopWhatsApp) === 10) {
                                $desktopWhatsApp = '91' . $desktopWhatsApp;
                            }
                        @endphp

                        <tr>
                            <td class="lm-source-strip-cell"
                                title="{{ $lead->source === 'csv' ? get_phrase('Bulk Upload') : get_phrase('Manual') }}">
                                <span class="lm-source-strip {{ $lead->source === 'csv' ? 'bulk' : 'manual' }}"></span>
                            </td>

                            <td class="lm-select-cell">
                                <input type="checkbox"
                                       class="lm-select-check lead-row-checkbox"
                                       value="{{ $lead->id }}"
                                       aria-label="{{ get_phrase('Select lead') }} {{ $lead->name }}"
                                       onchange="syncLeadSelection(this)">
                            </td>

                            <td>
                                {{ ($leads->firstItem() ?? 1) + $loop->index }}
                                {{-- <div>#{{ $lead->id }}</div> --}}

                                  <div>
                                    <span class="badge bg-warning text-dark">
                                        #{{ $lead->id }}
                                    </span>
                                </div>

                            </td>

                            <td>
                                <div class="lm-lead-name">{{ $lead->name }}</div>
                                <div class="lm-lead-phone">{{ \Illuminate\Support\Str::limit($lead->requirement ?: '-', 42) }}</div>
                            </td>

                            

                            <td>{{ $lead->phone }}</td>


                            <td>{{ $lead->leadcat->title ?? 'No Category' }}</td>

                            <td>
                                @if($lead->assignedUser)
                                    <div class="lm-assignee">
                                        <div class="lm-avatar">{{ strtoupper(substr($lead->assignedUser->name,0,1)) }}</div>
                                        <div>
                                            <div class="lm-assignee-name">{{ $lead->assignedUser->name }}</div>
                                            <div class="lm-assignee-role">{{ get_phrase('Sales') }}</div>
                                        </div>
                                    </div>
                                @elseif(auth()->user()->hasRole('Admin'))
                                    <span class="lm-unassigned">{{ get_phrase('Unassigned') }}</span>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <div data-lead-status="{{ $lead->id }}">
                                    @if($lead->status === 'contacted')
                                        <span class="lm-status-dot contacted"
                                              title="{{ get_phrase('Contacted') }}"
                                              aria-label="{{ get_phrase('Contacted') }}"></span>
                                    @elseif(empty($lead->status) || $lead->status === 'pending')
                                        <span class="lm-status-dot pending"
                                              title="{{ get_phrase('Pending') }}"
                                              aria-label="{{ get_phrase('Pending') }}"></span>
                                    @elseif($lead->status === 'accept')
                                        <span class="lm-badge lm-status-accept">{{ get_phrase('Accepted') }}</span>
                                    @elseif($lead->status === 'reject')
                                        <span class="lm-badge lm-status-reject">{{ get_phrase('Rejected') }}</span>
                                    @elseif($lead->status === 'call')
                                        <span class="lm-badge lm-status-call">{{ get_phrase('Call') }}</span>
                                    @else
                                        <span class="lm-badge lm-status-pending">{{ ucfirst($lead->status ?: 'pending') }}</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                {{ $lead->lead_date
                                    ? \Carbon\Carbon::parse($lead->lead_date)->format('d M Y')
                                    : optional($lead->created_at)->format('d M Y') }}
                            </td>

                            <td class="text-center lm-actions-cell">
                                <div class="lm-actions">
                                    @if($desktopPhone)
                                        <button type="button"
                                                class="lm-action call"
                                                title="{{ get_phrase('Call') }}"
                                                onclick="callLeadAndMarkContacted(
                                                    {{ $lead->id }},
                                                    '{{ $desktopPhone }}',
                                                    this
                                                )">
                                            <i class="bi bi-telephone-fill"></i>
                                        </button>

                                        <a href="https://wa.me/{{ $desktopWhatsApp }}" target="_blank" class="lm-action whatsapp" title="{{ get_phrase('WhatsApp') }}">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    @endif

                                    <a href="javascript:void(0)"
                                       class="lm-action quote"
                                       title="{{ get_phrase('Quick Quotation') }}"
                                       onclick="openQuickQuotation('{{ $lead->id }}', @js($lead->name), @js($lead->phone))">
                                        <i class="fi-rr-document-signed"></i>
                                    </a>

                                    <button type="button"
                                            class="lm-action detail-quote"
                                            title="{{ get_phrase('Detailed Quotation') }}"
                                            onclick="openDetailedQuotationModal(
                                                {{ $lead->id }},
                                                @js($lead->name),
                                                @js($lead->phone)
                                            )">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </button>

                                    {{--  --}}

                                    <a href="#"
                                        class="lm-action"
                                        title="{{ get_phrase('Lead History') }}"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', [
                                                'view_path' => 'admin/leads/leadschat',
                                                'id' => $lead->id
                                            ]) }}',
                                            '{{ get_phrase('Lead History') }}'
                                        ); return false;">
                                            <i class="fi-rr-comments"></i>
                                        </a>

                                        <a href="#"
                                        class="lm-action"
                                        title="{{ get_phrase('Lead Notes') }}"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', [
                                                'view_path' => 'admin/leads/callagaindetails',
                                                'id' => $lead->id
                                            ]) }}',
                                            '{{ get_phrase('Lead Notes') }}'
                                        ); return false;">
                                            <i class="fi-rr-document"></i>
                                        </a>

                                    {{--  --}}

                                    <a href="#"
                                       class="lm-action edit"
                                       title="{{ get_phrase('Edit') }}"
                                       onclick="showRightModal('{{ route('right_modal', ['view_path'=>'admin/leads/edit','id'=>$lead->id]) }}','{{ get_phrase('Edit Lead') }}'); return false;">
                                        <i class="fi-rr-pencil"></i>
                                    </a>

                                    {{-- <a href="#"
                                       class="lm-action status"
                                       title="{{ get_phrase('Change Status') }}"
                                       onclick="showRightModal('{{ route('right_modal', ['view_path'=>'admin/leads/change_status','id'=>$lead->id]) }}','{{ get_phrase('Change Status') }}'); return false;">
                                        <i class="fi-rr-refresh"></i>
                                    </a> --}}

                                    <a href="#"
                                       class="lm-action delete"
                                       title="{{ get_phrase('Delete') }}"
                                       onclick="confirmModal('{{ route('admin.lead.delete',$lead->id) }}'); return false;">
                                        <i class="fi-rr-trash"></i>
                                    </a>
                                </div>

                                {{--  --}}

                                <div class="lm-action-toggle-row">
    <button type="button"
            class="lm-action-toggle"
            onclick="toggleLeadActionPanel(this)">
        <span>{{ get_phrase('Lead Actions') }}</span>
        <i class="bi bi-chevron-down"></i>
    </button>

    <span class="lm-action-last" id="lead-action-last-{{ $lead->id }}">
        <i class="bi bi-clock-history"></i>
        {{ get_phrase('Add activity') }}
    </span>
</div>

<div class="lm-action-panel"
     data-lead-action-panel="{{ $lead->id }}"
     data-lead-name="{{ $lead->name }}"
     data-lead-phone="{{ $lead->phone }}"
     data-action-url="{{ route('admin.leads.action.store', $lead->id) }}">

    <div class="lm-action-panel-header">

        <div class="lm-action-panel-title">
            <i class="bi bi-lightning-charge"></i>
            {{ get_phrase('Update Lead Action') }}
        </div>

        <button type="button"
                class="lm-action-panel-close"
                onclick="closeLeadActionPanel(this)"
                aria-label="{{ get_phrase('Close') }}">
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

    <div class="lm-action-grid">

        <button
            type="button"
            class="lm-lead-action-btn follow-up"
            onclick="openFollowUpModal(
                {{ $lead->id }},
                @js($lead->name),
                @js($lead->remarks ?? ''),
                '{{ $lead->user_id ?? '' }}',
                @js($lead->follow_up_priority ?? '')
            )"
        >
            <i class="bi bi-arrow-repeat"></i>
            {{ get_phrase('Follow Up') }}
        </button>

        <button type="button"
                class="lm-lead-action-btn action-deal"

                onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'deal_close',
    'Deal Close',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">


            <i class="bi bi-check-circle"></i>
            <span>{{ get_phrase('Deal Close') }}</span>
        </button>

        <button type="button"
                class="lm-lead-action-btn action-danger"
                onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'not_interested',
    'Not Interested',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
            <i class="bi bi-slash-circle"></i>
            <span>{{ get_phrase('Not Interested') }}</span>
        </button>

        <button type="button"
                class="lm-lead-action-btn"
                onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'not_contactable',
    'Not Contactable',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
            <i class="bi bi-telephone-x"></i>
            <span>{{ get_phrase('Not Contactable') }}</span>
        </button>

        <button type="button"
                class="lm-lead-action-btn"
                onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'wrong_category',
    'Wrong Category',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
            <i class="bi bi-diagram-2"></i>
            <span>{{ get_phrase('Wrong Category') }}</span>
        </button>

        <button type="button"
                class="lm-lead-action-btn"
                onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'out_of_area',
    'Out of Area',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
            <i class="bi bi-geo-alt"></i>
            <span>{{ get_phrase('Out of Area') }}</span>
        </button>

        <button type="button"
                class="lm-lead-action-btn"
                onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'marketing_job',
    'Marketing / Job',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
            <i class="bi bi-megaphone"></i>
            <span>{{ get_phrase('Marketing / Job') }}</span>
        </button>

    </div>

    <div class="lm-action-feedback"
         id="lead-action-feedback-{{ $lead->id }}">
    </div>

</div>


                                {{--  --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                {{ get_phrase('No leads found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARDS --}}
        <div class="lm-mobile-list">

            <div class="lm-mobile-bulkbar"
                 id="leadMobileBulkBar">

                <label class="lm-mobile-select-all">
                    <input type="checkbox"
                           class="lm-select-check"
                           id="leadSelectAllMobile"
                           onchange="toggleSelectAllLeads(this.checked)">

                    <span>
                        {{ get_phrase('Select All') }}
                        (<span id="leadMobileSelectedCount">0</span>)
                    </span>
                </label>

                <button type="button"
                        class="lm-bulk-delete-btn"
                        onclick="deleteSelectedLeads()">
                    <i class="bi bi-trash3"></i>
                    {{ get_phrase('Delete') }}
                </button>

            </div>
            @forelse($leads as $lead)
                @php
                    $mobilePhone = preg_replace('/[^0-9]/', '', $lead->phone ?? '');
                    $mobileWhatsApp = $mobilePhone;

                    if (strlen($mobileWhatsApp) === 10) {
                        $mobileWhatsApp = '91' . $mobileWhatsApp;
                    }

                    $mobileStatus = $lead->status ?: 'pending';

                    $mobileDate = $lead->lead_date
                        ? \Carbon\Carbon::parse($lead->lead_date)->format('d M')
                        : optional($lead->created_at)->format('d M');
                @endphp

                <article class="lm-mcard has-select">
                    <span class="lm-mcard-source-strip {{ $lead->source === 'csv' ? 'bulk' : 'manual' }}"></span>

                    <label class="lm-mobile-select"
                           title="{{ get_phrase('Select lead') }}">
                        <input type="checkbox"
                               class="lm-select-check lead-mobile-checkbox"
                               value="{{ $lead->id }}"
                               aria-label="{{ get_phrase('Select lead') }} {{ $lead->name }}"
                               onchange="syncLeadSelection(this)">
                    </label>

                    <div class="lm-mcard-top">
                        <div>
                            <div class="lm-mcard-name">{{ $lead->name ?: 'Unnamed Lead' }}</div>
                            <div class="lm-mcard-phone">{{ $lead->phone ?: 'No phone number' }}</div>
                        </div>

                        

                        <div data-lead-status="{{ $lead->id }}">
                            @if($mobileStatus === 'contacted')
                                <span class="lm-status-dot contacted"
                                      title="{{ get_phrase('Contacted') }}"
                                      aria-label="{{ get_phrase('Contacted') }}"></span>
                            @elseif($mobileStatus === 'pending')
                                <span class="lm-status-dot pending"
                                      title="{{ get_phrase('Pending') }}"
                                      aria-label="{{ get_phrase('Pending') }}"></span>
                            @elseif($mobileStatus === 'accept')
                                <span class="lm-badge lm-status-accept">{{ get_phrase('Accepted') }}</span>
                            @elseif($mobileStatus === 'reject')
                                <span class="lm-badge lm-status-reject">{{ get_phrase('Rejected') }}</span>
                            @elseif($mobileStatus === 'call')
                                <span class="lm-badge lm-status-call">{{ get_phrase('Call') }}</span>
                            @else
                                <span class="lm-badge lm-status-pending">{{ ucfirst($mobileStatus) }}</span>
                            @endif

                           
                        </div>

                        
                    </div>

                     {{-- <div class="xl:float-end">{{ $lead->id ?: 'Unnamed Lead' }}</div> --}}

                    <div style="float: right; margin-top: -20px;">#{{ $lead->id }}</div>




                    <div class="lm-mcard-cat">{{ $lead->leadcat->title ?? 'No Category' }}</div>

                    <div class="lm-mcard-req">
                        {{ $lead->requirement ?: ($lead->remarks ?: 'No requirement added') }}
                    </div>

                    <div class="lm-mcard-meta">
                        <span>
                            <i class="bi bi-person"></i>
                            {{ $lead->assignedUser->name ?? (auth()->user()->hasRole('Admin') ? 'Unassigned' : '-') }}
                        </span>
                        <span>
                            <i class="bi bi-calendar3"></i>
                            {{ $mobileDate ?: 'N/A' }}
                        </span>
                    </div>

                    <div class="lm-mcard-actions">
                        @if($mobilePhone)
                            <button type="button"
                                    class="lm-maction call"
                                    onclick="callLeadAndMarkContacted(
                                        {{ $lead->id }},
                                        '{{ $mobilePhone }}',
                                        this
                                    )">
                                <i class="bi bi-telephone-fill"></i>
                                Call
                            </button>
                            <a href="https://wa.me/{{ $mobileWhatsApp }}" target="_blank" class="lm-maction whatsapp">
                                <i class="bi bi-whatsapp"></i> {{ get_phrase('WhatsApp') }}
                            </a>
                        @else
                            <span class="lm-maction call is-disabled"><i class="bi bi-telephone-fill"></i> {{ get_phrase('Call') }}</span>
                            <span class="lm-maction whatsapp is-disabled"><i class="bi bi-whatsapp"></i> {{ get_phrase('WhatsApp') }}</span>
                        @endif

                        <button type="button"
                                class="lm-maction quote"
                                onclick="openQuickQuotation('{{ $lead->id }}', @js($lead->name), @js($lead->phone))">
                            <i class="fi-rr-document-signed"></i> {{ get_phrase('Quote') }}
                        </button>

                        <button type="button"
                                class="lm-maction detail-quote"
                                onclick="openDetailedQuotationModal(
                                    {{ $lead->id }},
                                    @js($lead->name),
                                    @js($lead->phone)
                                )">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                            {{ get_phrase('Details') }}
                        </button>

                        <div class="lm-more-wrap">
                            <button type="button" class="lm-more-btn" onclick="toggleLeadCardMenu(this)" aria-label="More actions">
                                <i class="bi bi-three-dots"></i>
                            </button>

                            <div class="lm-more-menu">
                                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path'=>'admin/leads/edit','id'=>$lead->id]) }}','{{ get_phrase('Edit Lead') }}'); return false;">
                                    <i class="fi-rr-pencil"></i> {{ get_phrase('Edit Lead') }}
                                </a>
                                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path'=>'admin/leads/change_status','id'=>$lead->id]) }}','{{ get_phrase('Change Status') }}'); return false;">
                                    <i class="fi-rr-refresh"></i> {{ get_phrase('Change Status') }}
                                </a>
                                <a href="#" class="danger" onclick="confirmModal('{{ route('admin.lead.delete',$lead->id) }}'); return false;">
                                    <i class="fi-rr-trash"></i> {{ get_phrase('Delete') }}
                                </a>

                                <a href="#"
                                    onclick="showRightModal(
                                        '{{ route('right_modal', [
                                            'view_path' => 'admin/leads/leadschat',
                                            'id' => $lead->id
                                        ]) }}',
                                        '{{ get_phrase('Lead History') }}'
                                    ); return false;">
                                        <i class="fi-rr-comments"></i>
                                        {{ get_phrase('Lead History') }}
                                    </a>

                                    <a href="#"
                                    onclick="showRightModal(
                                        '{{ route('right_modal', [
                                            'view_path' => 'admin/leads/callagaindetails',
                                            'id' => $lead->id
                                        ]) }}',
                                        '{{ get_phrase('Lead Notes') }}'
                                    ); return false;">
                                        <i class="fi-rr-document"></i>
                                        {{ get_phrase('Lead Notes') }}
                                    </a>



                                
                            </div>


                        </div>
                    </div>

                    <div class="lm-action-toggle-row">
                        <button type="button"
                                class="lm-action-toggle"
                                onclick="toggleLeadActionPanel(this)">
                            <span>{{ get_phrase('Lead Actions') }}</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <span class="lm-action-last" id="lead-action-last-{{ $lead->id }}">
                            <i class="bi bi-clock-history"></i>
                            {{ get_phrase('Add activity') }}
                        </span>
                    </div>

                    <div class="lm-action-panel"
                         data-lead-action-panel="{{ $lead->id }}"
                         data-lead-name="{{ $lead->name }}"
                         data-lead-phone="{{ $lead->phone }}"
                         data-action-url="{{ route('admin.leads.action.store', $lead->id) }}">

                        <div class="lm-action-panel-header">
                            <div class="lm-action-panel-title">
                                <i class="bi bi-lightning-charge"></i>
                                {{ get_phrase('Update Lead Action') }}
                            </div>

                            <button type="button"
                                    class="lm-action-panel-close"
                                    onclick="closeLeadActionPanel(this)"
                                    aria-label="{{ get_phrase('Close') }}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="lm-action-grid">
                           <button
                                type="button"
                                class="lm-lead-action-btn follow-up"
                                onclick="openFollowUpModal(
                                    {{ $lead->id }},
                                    @js($lead->name),
                                    @js($lead->remarks ?? ''),
                                    '{{ $lead->user_id ?? '' }}',
                @js($lead->follow_up_priority ?? '')
                                )"
                            >
                                <i class="bi bi-arrow-repeat"></i>

                                {{ get_phrase('Follow Up') }}
                            </button>

                            <button type="button"
                                    class="lm-lead-action-btn action-deal"
                                    onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'deal_close',
    'Deal Close',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
                                <i class="bi bi-check-circle"></i>
                                <span>{{ get_phrase('Deal Close') }}</span>
                            </button>

                            <button type="button"
                                    class="lm-lead-action-btn action-danger"
                                    onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'not_interested',
    'Not Interested',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
                                <i class="bi bi-slash-circle"></i>
                                <span>{{ get_phrase('Not Interested') }}</span>
                            </button>

                            <button type="button"
                                    class="lm-lead-action-btn"
                                    onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'not_contactable',
    'Not Contactable',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
                                <i class="bi bi-telephone-x"></i>
                                <span>{{ get_phrase('Not Contactable') }}</span>
                            </button>

                            <button type="button"
                                    class="lm-lead-action-btn"
                                    onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'wrong_category',
    'Wrong Category',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
                                <i class="bi bi-diagram-2"></i>
                                <span>{{ get_phrase('Wrong Category') }}</span>
                            </button>

                            <button type="button"
                                    class="lm-lead-action-btn"
                                    onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'out_of_area',
    'Out of Area',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ get_phrase('Out of Area') }}</span>
                            </button>

                            <button type="button"
                                    class="lm-lead-action-btn"
                                    onclick="openLeadActionNoteModal(
    {{ $lead->id }},
    @js($lead->name),
    'marketing_job',
    'Marketing / Job',
    this,
    '{{ route('right_modal', [
        'view_path' => 'admin/leads/callagaindetails',
        'id' => $lead->id
    ]) }}'
)">
                                <i class="bi bi-megaphone"></i>
                                <span>{{ get_phrase('Marketing / Job') }}</span>
                            </button>
                        </div>

                        <div class="lm-action-feedback"
                             id="lead-action-feedback-{{ $lead->id }}"></div>
                    </div>

                </article>
            @empty
                <div class="lm-mcard text-center text-muted py-4">
                    {{ get_phrase('No leads found.') }}
                </div>
            @endforelse
        </div>

        @if($leads->hasPages())
            <div class="lm-pagination">
                {{ $leads->withQueryString()->links() }}
            </div>
        @endif
    </section>

    {{-- =====================================================
         QUICK QUOTATION MODAL
         ===================================================== --}}

    <div class="modal fade" id="quickQuotationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content lm-quote-modal">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-0">{{ get_phrase('Quick Proforma') }}</h5>
                        <small class="text-muted" id="quoteCustomerName"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="quoteLeadId">
                    <input type="hidden" id="quotePhone">

                    <div id="quoteProductRows"></div>

                    <button type="button" class="lm-quote-add" onclick="addQuickQuoteProduct()">
                        <i class="bi bi-plus-circle"></i> {{ get_phrase('Add Product') }}
                    </button>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="lm-quote-switch">
                                <div>
                                    <strong>{{ get_phrase('Add GST') }}</strong>
                                    <small>18%</small>
                                </div>
                                <input type="checkbox" id="quoteGst" onchange="calculateQuickQuote()">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="lm-quote-switch">
                                <strong>{{ get_phrase('Add Discount') }}</strong>
                                <input type="checkbox" id="quoteDiscountSwitch" onchange="toggleQuickDiscount()">
                            </div>
                        </div>
                    </div>

                    <div id="quoteDiscountBox" class="mt-3" style="display:none;">
                        <label class="lm-field-label">{{ get_phrase('Discount %') }}</label>
                        <input type="number"
                               id="quoteDiscount"
                               class="form-control"
                               value="0"
                               min="0"
                               max="100"
                               oninput="calculateQuickQuote()">
                    </div>

                    <div class="mt-3">
                        <label class="lm-field-label">{{ get_phrase('Additional Note') }}</label>
                        <textarea id="quoteNote" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="lm-quote-summary">
                        <div class="lm-quote-summary-row">
                            <span>{{ get_phrase('Subtotal') }}</span>
                            <strong>₹<span id="quoteSubtotal">0.00</span></strong>
                        </div>

                        <div id="quoteDiscountSummary" class="lm-quote-summary-row" style="display:none;">
                            <span>{{ get_phrase('Discount') }}</span>
                            <strong>-₹<span id="quoteDiscountAmount">0.00</span></strong>
                        </div>

                        <div id="quoteGstSummary" class="lm-quote-summary-row" style="display:none;">
                            <span>{{ get_phrase('GST') }}</span>
                            <strong>₹<span id="quoteGstAmount">0.00</span></strong>
                        </div>
                    </div>
                </div>

                <div class="lm-quote-total">
                    <span>{{ get_phrase('Total') }}</span>
                    <strong>₹<span id="quoteGrandTotal">0.00</span>/-</strong>
                </div>

                <div class="modal-footer d-block">
                    <div id="quoteSaveStatus" class="lm-quote-status"></div>

                    <button type="button"
                            class="btn btn-success w-100"
                            id="quoteWhatsAppButton"
                            onclick="sendQuickQuotationWhatsApp()">
                        <i class="bi bi-whatsapp me-1"></i>
                        {{ get_phrase('Save & Send on WhatsApp') }}
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- =========================================================
         DETAILED QUOTATION PDF LIBRARY MODAL
         ========================================================= --}}
    <div class="modal fade" id="detailedQuotationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content lm-detail-quote-modal">
                <div class="modal-header">
                    <div>
                        <div class="lm-detail-quote-eyebrow">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                            {{ get_phrase('Detailed Proposal') }}
                        </div>
                        <h5 class="modal-title">{{ get_phrase('Select PDF Quotation') }}</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="detailQuoteLeadId">
                    <input type="hidden" id="detailQuotePhone">

                    <div class="lm-detail-quote-lead">
                        <div class="lm-detail-quote-lead-icon"><i class="bi bi-person"></i></div>
                        <div>
                            <strong id="detailQuoteLeadName">{{ get_phrase('Lead') }}</strong>
                            <small id="detailQuoteLeadPhone"></small>
                        </div>
                    </div>

                    <div class="lm-detail-quote-search">
                        <div class="mb-3">

                            <label
                                for="detailQuoteCategory"
                                class="lm-followup-label"
                            >
                                <i class="bi bi-folder2-open"></i>
                                {{ get_phrase('Select Category') }}
                            </label>

                            <select
                                id="detailQuoteCategory"
                                class="form-select lm-followup-input"
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

                        {{-- <i class="bi bi-search"></i>
                        <input type="text" id="detailQuoteSearch"
                               placeholder="{{ get_phrase('Search detailed quotation...') }}"
                               oninput="filterDetailedQuotations(this.value)"> --}}

                         <div
                                class="lm-detail-quote-search"
                                id="detailQuoteSearchBox"
                                style="display: none;"
                            >
                                <i class="bi bi-search"></i>

                                <input
                                    type="text"
                                    id="detailQuoteSearch"
                                    placeholder="{{ get_phrase('Search proposal PDF...') }}"
                                    oninput="filterDetailedQuotations()"
                                >
                        </div>


                    </div>

                    <div class="lm-detail-quote-list" id="detailQuoteList">

                        <div
                                class="lm-detail-quote-empty"
                                id="detailQuoteCategoryMessage"
                            >
                                <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>

                                {{ get_phrase('Please select a category to view proposal PDFs.') }}
                        </div>


                        @forelse($detailedQuotations as $detailedQuotation)
                           <label
                                    class="lm-detail-quote-item"
                                    data-category-id="{{ $detailedQuotation->category_id }}"
                                    data-quotation-name="{{ strtolower($detailedQuotation->name) }}"
                                    style="display: none;"
                                >
                                <input type="radio"
                                       name="detailed_quotation_id"
                                       value="{{ $detailedQuotation->id }}"
                                       data-name="{{ $detailedQuotation->name }}"
                                       data-view-url="{{ route('admin.detailed-quotations.show', $detailedQuotation->id) }}"
                                       onchange="selectDetailedQuotation(this)">
                                <span class="lm-detail-quote-card">
                                    <span class="lm-detail-quote-pdf">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </span>
                                    <span class="lm-detail-quote-copy">
                                        <strong>{{ $detailedQuotation->name }}</strong>

                                        <small>
                                            {{ $detailedQuotation->category?->name }}
                                            · {{ get_phrase('PDF quotation') }}
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

                    <div class="lm-detail-quote-preview" id="detailQuotePreview">
                        <a href="#" id="detailQuotePreviewLink" target="_blank">
                            <i class="bi bi-eye"></i>
                            {{ get_phrase('View Selected PDF') }}
                        </a>
                    </div>

                    <div id="detailQuoteStatus" class="lm-detail-quote-status"></div>
                </div>

                <div class="modal-footer d-block">
                    <button type="button"
                            class="btn lm-detail-quote-send w-100"
                            id="detailQuoteWhatsAppButton"
                            onclick="sendDetailedQuotationWhatsApp()">
                        <i class="bi bi-whatsapp me-1"></i>
                        {{ get_phrase('Send Selected PDF on WhatsApp') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{--  --}}

    {{-- =========================================================
     FOLLOW UP MODAL
     ========================================================= --}}

   

</div>

 <div class="modal fade"
        id="leadFollowUpModal"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content lm-followup-modal">

                {{-- HEADER --}}
                <div class="modal-header">

                    <div>
                        <div class="lm-followup-eyebrow">
                            <i class="bi bi-arrow-repeat"></i>
                            {{ get_phrase('Lead Follow Up') }}
                        </div>

                        <h5 class="modal-title"
                            id="followUpLeadName">
                            {{ get_phrase('Schedule Follow Up') }}
                        </h5>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    <form id="leadFollowUpForm">

                        @csrf

                        <input
                            type="hidden"
                            id="followUpLeadId"
                            value="">


                        {{-- DATE + TIME --}}
                        <div class="mb-3">

                            <label class="lm-followup-label">

                                <i class="bi bi-calendar-event"></i>

                                {{ get_phrase('Follow Up Date & Time') }}

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="datetime-local"
                                name="call_schedule"
                                id="followUpCallSchedule"
                                class="form-control lm-followup-input"
                                required>

                        </div>


                        {{-- ASSIGN USER --}}
                        @if(($salesUsers ?? collect())->isNotEmpty())

                            <div class="mb-3">

                                <label class="lm-followup-label">

                                    <i class="bi bi-person"></i>

                                    {{ get_phrase('Assign To') }}

                                </label>

                                <select
                                    name="user_id"
                                    id="followUpUserId"
                                    class="form-select lm-followup-input">

                                    <option value="">
                                        {{ get_phrase('Keep Current User') }}
                                    </option>

                                    @foreach($salesUsers ?? [] as $salesUser)

                                        <option
                                            value="{{ $salesUser->id }}">

                                            {{ $salesUser->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        @else

                            <input
                                type="hidden"
                                name="user_id"
                                id="followUpUserId"
                                value="{{ auth()->id() }}">

                        @endif


                        <div class="mb-3">
                            <label for="followUpPriority" class="lm-followup-label">Follow Up Category <span class="text-danger">*</span></label>
                            <select id="followUpPriority" name="follow_up_priority" class="form-select lm-followup-input" required>
                                <option value="">Select category</option>
                                <option value="hot">Hot</option>
                                <option value="warm">Warm</option>
                                <option value="cold">Cold</option>
                            </select>
                        </div>
                        {{-- REMARKS --}}
                        <div class="mb-2">

                            <label class="lm-followup-label">

                                <i class="bi bi-chat-left-text"></i>

                                {{ get_phrase('Remarks') }}

                            </label>

                            <textarea
                                name="remarks"
                                id="followUpRemarks"
                                rows="4"
                                maxlength="2000"
                                class="form-control lm-followup-input"
                                placeholder="{{ get_phrase('Enter follow up remarks...') }}"></textarea>

                        </div>


                        {{-- INFO --}}
                        <div class="lm-followup-info">

                            <i class="bi bi-info-circle"></i>

                            <div>
                                {{ get_phrase('After scheduling this follow up, lead status will change to Call Again.') }}
                            </div>

                        </div>

                    </form>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        {{ get_phrase('Cancel') }}

                    </button>


                    <button
                        type="button"
                        id="followUpSubmitBtn"
                        class="btn btn-primary"
                        onclick="submitLeadFollowUp()">

                        <i class="bi bi-calendar-check"></i>

                        {{ get_phrase('Schedule Follow Up') }}

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{--  --}}


    {{-- =========================================================
     LEAD ACTION NOTE MODAL
========================================================= --}}
<div
    class="modal fade"
    id="leadActionNoteModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content lm-followup-modal">

            {{-- HEADER --}}
            <div class="modal-header">

                <div>
                    <div class="lm-followup-eyebrow">
                        <i class="bi bi-journal-text"></i>
                        {{ get_phrase('Lead Note Required') }}
                    </div>

                    <h5
                        class="modal-title"
                        id="leadActionModalTitle"
                    >
                        {{ get_phrase('Update Lead Action') }}
                    </h5>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- BODY --}}
            <div class="modal-body">

                {{-- Hidden data --}}
                <input
                    type="hidden"
                    id="leadActionModalLeadId"
                >

                <input
                    type="hidden"
                    id="leadActionModalActionType"
                >


                {{-- Lead --}}
                <div class="mb-3">

                    <label class="lm-followup-label">
                        <i class="bi bi-person"></i>
                        {{ get_phrase('Lead') }}
                    </label>

                    <div
                        id="leadActionModalLeadName"
                        class="form-control lm-followup-input"
                        style="
                            display:flex;
                            align-items:center;
                            background:#f8fafc;
                            font-weight:700;
                        "
                    >
                        -
                    </div>

                </div>


                {{-- Selected Action --}}
                <div class="mb-3">

                    <label class="lm-followup-label">
                        <i class="bi bi-lightning-charge"></i>
                        {{ get_phrase('Selected Action') }}
                    </label>

                    <div
                        id="leadActionModalActionLabel"
                        class="form-control lm-followup-input"
                        style="
                            display:flex;
                            align-items:center;
                            background:#f8fafc;
                            font-weight:700;
                        "
                    >
                        -
                    </div>

                </div>


                {{-- NOTE --}}
                <div class="mb-2">

                    <label
                        for="leadActionModalNote"
                        class="lm-followup-label"
                    >
                        <i class="bi bi-chat-left-text"></i>

                        {{ get_phrase('Lead Note') }}

                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="leadActionModalNote"
                        rows="5"
                        maxlength="2000"
                        class="form-control lm-followup-input"
                        placeholder="{{ get_phrase('Write lead note before continuing...') }}"
                    ></textarea>

                    <div
                        id="leadActionModalNoteError"
                        class="text-danger mt-1"
                        style="
                            display:none;
                            font-size:10px;
                            font-weight:600;
                        "
                    >
                        {{ get_phrase('Lead Note is required.') }}
                    </div>

                </div>


                {{-- Existing Lead Notes --}}
                <button
                    type="button"
                    id="viewExistingLeadNotesBtn"
                    class="btn btn-light btn-sm mt-2"
                >
                    <i class="fi-rr-document me-1"></i>
                    {{ get_phrase('Previous Lead Notes') }}
                </button>


                <div class="lm-followup-info">

                    <i class="bi bi-info-circle"></i>

                    <div>
                        {{ get_phrase(
                            'Lead action will not be processed until this note is submitted.'
                        ) }}
                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
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
                    id="leadActionModalSubmitBtn"
                    class="btn btn-primary"
                    onclick="submitLeadActionNote()"
                >
                    <i class="bi bi-check2-circle me-1"></i>

                    {{ get_phrase('Submit & Continue') }}
                </button>

            </div>

        </div>

    </div>
</div>




{{-- Required call outcome, shared by desktop and mobile. Server flag restores it after reload. --}}
<div class="modal fade" id="requiredCallModal" tabindex="-1" aria-labelledby="requiredCallTitle" aria-modal="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:16px">
            <form id="requiredCallForm" onsubmit="submitRequiredCall(event)">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="requiredCallTitle">Call outcome is required</h5>
                        <small class="text-muted" id="requiredCallLeadName"></small>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="requiredCallLeadId">
                    <input type="hidden" id="requiredCallPhone">
                    <div class="mb-3">
                        <label class="form-label d-block">Send a quotation after the call</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-primary" onclick="openRequiredCallQuotation('quick')">Quick Quotation</button>
                            <button type="button" class="btn btn-outline-primary" onclick="openRequiredCallQuotation('detailed')">Detailed Quotation</button>
                        </div>
                        <small class="text-muted">Saving a quotation and opening WhatsApp completes this call action.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">What happened on the call?</label>
                        <input type="hidden" id="requiredCallOutcome">
                        <div class="required-outcome-grid" role="group" aria-label="Choose one call outcome">
                            @foreach([
                                'follow_up' => 'Schedule Follow Up', 'contacted' => 'Contacted',
                                'not_contactable' => 'Not Contactable', 'not_interested' => 'Not Interested',
                                'wrong_category' => 'Wrong Category', 'out_of_area' => 'Out of Area',
                                'marketing_job' => 'Marketing / Job', 'deal_close' => 'Deal Close',
                            ] as $outcomeValue => $outcomeLabel)
                                <label class="required-outcome-choice">
                                    <input type="checkbox" value="{{ $outcomeValue }}" onchange="chooseRequiredCallOutcome(this)">
                                    <span>{{ $outcomeLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div id="requiredCallReasonFields" class="mb-3" hidden>
                        <label class="form-label" id="requiredCallReasonTitle">Call result</label>
                        <div class="required-reason-grid" id="requiredCallReasonChoices"></div>
                    </div>
                    <div id="requiredCallFollowUpFields" hidden>
                        <div class="mb-3">
                            <label class="form-label">Follow Up Date & Time <span class="text-danger">*</span></label>
                            <input type="hidden" id="requiredCallSchedule">
                            <div class="required-calendar" aria-label="Follow Up calendar">
                                <div class="required-calendar-top">
                                    <button type="button" aria-label="Previous month" onclick="moveRequiredCallMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                                    <strong id="requiredCalendarMonth"></strong>
                                    <button type="button" aria-label="Next month" onclick="moveRequiredCallMonth(1)"><i class="bi bi-chevron-right"></i></button>
                                </div>
                                <div class="required-calendar-grid required-calendar-weekdays" aria-hidden="true">
                                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                                </div>
                                <div id="requiredCalendarDays" class="required-calendar-grid" role="group" aria-label="Select follow up date"></div>
                                <div class="required-calendar-bottom">
                                    <span id="requiredCalendarSelected" aria-live="polite">Select a date</span>
                                    <label for="requiredCallTime">Time
                                        <input type="time" id="requiredCallTime" class="form-control" onchange="syncRequiredCallSchedule()">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority <span class="text-danger">*</span></label>
                            <input type="hidden" id="requiredCallPriority">
                            <div class="required-priority-grid" role="group" aria-label="Choose one priority">
                                <label class="required-priority-choice hot"><input type="checkbox" value="hot" onchange="chooseRequiredCallPriority(this)"><span>🔥 Hot</span></label>
                                <label class="required-priority-choice warm"><input type="checkbox" value="warm" onchange="chooseRequiredCallPriority(this)"><span>☀️ Warm</span></label>
                                <label class="required-priority-choice cold"><input type="checkbox" value="cold" onchange="chooseRequiredCallPriority(this)"><span>❄️ Cold</span></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="requiredCallAssignee" class="form-label">Assigned To</label>
                            <select class="form-select" id="requiredCallAssignee">
                                <option value="">Keep current assignee</option>
                                @foreach($salesUsers ?? [] as $salesUser)
                                    <option value="{{ $salesUser->id }}">{{ $salesUser->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-2" id="requiredCallNoteFields" hidden>
                        <label for="requiredCallNote" class="form-label"><span id="requiredCallNoteLabel">Call note for Other</span> <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="requiredCallNote" rows="3" maxlength="2000" placeholder="Write the other reason..."></textarea>
                    </div>
                    <div class="alert alert-danger mt-2 mb-0" id="requiredCallError" role="alert" hidden></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-100" id="requiredCallSubmit" type="submit">Save call outcome</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    /* =====================================================
       BULK SELECT + DELETE
       ===================================================== */

    function selectedLeadIds() {
        const ids = new Set();

        document
            .querySelectorAll(
                '.lead-row-checkbox:checked, .lead-mobile-checkbox:checked'
            )
            .forEach(function(checkbox) {
                if (checkbox.value) {
                    ids.add(String(checkbox.value));
                }
            });

        return Array.from(ids);
    }


    function syncLeadSelection(changedCheckbox = null) {

        /*
         * Desktop and mobile render the same lead twice.
         * Keep both checkboxes synchronized.
         */

        if (changedCheckbox && changedCheckbox.value) {

            const leadId =
                String(changedCheckbox.value);

            const checked =
                changedCheckbox.checked;

            document
                .querySelectorAll(
                    `.lead-row-checkbox[value="${leadId}"], ` +
                    `.lead-mobile-checkbox[value="${leadId}"]`
                )
                .forEach(function(checkbox) {
                    checkbox.checked = checked;
                });
        }


        /*
         * Highlight selected desktop rows.
         */

        document
            .querySelectorAll('.lead-row-checkbox')
            .forEach(function(checkbox) {

                const row =
                    checkbox.closest('tr');

                if (row) {
                    row.classList.toggle(
                        'is-selected',
                        checkbox.checked
                    );
                }
            });


        const ids =
            selectedLeadIds();

        const selectedCount =
            ids.length;


        /*
         * Desktop bulk toolbar
         */

        const toolbar =
            document.getElementById(
                'leadBulkToolbar'
            );

        const pipelineText =
            document.getElementById(
                'leadPipelineShowingText'
            );

        const selectedCountElement =
            document.getElementById(
                'leadBulkSelectedCount'
            );

        if (selectedCountElement) {
            selectedCountElement.textContent =
                selectedCount;
        }

        if (toolbar) {
            toolbar.classList.toggle(
                'is-visible',
                selectedCount > 0
            );
        }

        if (pipelineText) {
            pipelineText.style.display =
                selectedCount > 0
                    ? 'none'
                    : '';
        }


        /*
         * Mobile bulk toolbar
         */

        const mobileBar =
            document.getElementById(
                'leadMobileBulkBar'
            );

        const mobileCount =
            document.getElementById(
                'leadMobileSelectedCount'
            );

        if (mobileCount) {
            mobileCount.textContent =
                selectedCount;
        }

        if (mobileBar) {
            mobileBar.classList.toggle(
                'is-visible',
                selectedCount > 0
            );
        }


        /*
         * Select All checkbox state
         */

        const desktopCheckboxes =
            Array.from(
                document.querySelectorAll(
                    '.lead-row-checkbox'
                )
            );

        const totalOnPage =
            desktopCheckboxes.length;

        const selectedOnPage =
            desktopCheckboxes.filter(
                function(checkbox) {
                    return checkbox.checked;
                }
            ).length;

        const allChecked =
            totalOnPage > 0 &&
            selectedOnPage === totalOnPage;

        const partiallyChecked =
            selectedOnPage > 0 &&
            selectedOnPage < totalOnPage;

        [
            document.getElementById(
                'leadSelectAllDesktop'
            ),

            document.getElementById(
                'leadSelectAllMobile'
            )
        ]
        .filter(Boolean)
        .forEach(function(selectAll) {

            selectAll.checked =
                allChecked;

            selectAll.indeterminate =
                partiallyChecked;
        });
    }


    function toggleSelectAllLeads(checked) {

        document
            .querySelectorAll(
                '.lead-row-checkbox, .lead-mobile-checkbox'
            )
            .forEach(function(checkbox) {
                checkbox.checked = checked;
            });

        syncLeadSelection();
    }


    async function deleteSelectedLeads() {

        const ids =
            selectedLeadIds();

        if (!ids.length) {
            alert(
                'Please select at least one lead.'
            );
            return;
        }


        const message =
            ids.length === 1
                ? 'Are you sure you want to delete this lead?'
                : `Are you sure you want to delete ${ids.length} selected leads?`;


        if (!window.confirm(message)) {
            return;
        }


        const buttons =
            document.querySelectorAll(
                '.lm-bulk-delete-btn'
            );

        buttons.forEach(function(button) {

            button.disabled = true;

            button.dataset.originalHtml =
                button.innerHTML;

            button.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true">
                </span>
                Deleting...
            `;
        });


        try {

            const response =
                await fetch(
                    "{{ route('admin.leads.bulk-delete') }}",
                    {
                        method: 'DELETE',

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
                                lead_ids: ids
                            })
                    }
                );


            let data = {};

            try {
                data =
                    await response.json();
            } catch (jsonError) {
                data = {};
            }


            if (
                !response.ok ||
                data.status === false
            ) {

                let errorMessage =
                    data.message ||
                    'Unable to delete selected leads.';


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
                        errorMessage =
                            firstError[0];
                    }
                }


                throw new Error(
                    errorMessage
                );
            }


            /*
             * Refresh is safest because:
             * - pagination changes
             * - KPI totals change
             * - category totals change
             * - source totals change
             */

            window.location.reload();


        } catch (error) {

            console.error(
                'Bulk lead delete failed:',
                error
            );

            alert(
                error.message ||
                'Unable to delete selected leads.'
            );


            buttons.forEach(
                function(button) {

                    button.disabled =
                        false;

                    if (
                        button.dataset
                            .originalHtml
                    ) {

                        button.innerHTML =
                            button.dataset
                                .originalHtml;
                    }
                }
            );
        }
    }


    /* =====================================================
       FILTERS TOGGLE
       ===================================================== */
    function toggleLeadFilters() {
        const panel = document.getElementById('leadAdvancedFilters');
        const btn = document.getElementById('leadFilterToggleBtn');

        if (!panel) return;

        const isOpen = panel.classList.toggle('is-open');

        if (btn) {
            btn.classList.toggle('is-active', isOpen);
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
    }

    /* =====================================================
       MOBILE CARD "MORE" MENU
       ===================================================== */
    function toggleLeadCardMenu(button) {
        const card = button.closest('.lm-mcard');
        if (!card) return;

        const menu = card.querySelector('.lm-more-menu');
        if (!menu) return;

        menu.classList.toggle('is-open');
        button.classList.toggle('is-active');
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.lm-more-wrap')) {
            document.querySelectorAll('.lm-more-menu.is-open')
                .forEach(function(menu) { menu.classList.remove('is-open'); });

            document.querySelectorAll('.lm-more-btn.is-active')
                .forEach(function(btn) { btn.classList.remove('is-active'); });
        }
    });

    /* =====================================================
       LEAD ACTION PANEL
       ===================================================== */

    function isDesktopLeadActionPanel()
    {
        return window.matchMedia(
            '(min-width: 768px)'
        ).matches;
    }


    function resetLeadActionPanelPosition(panel)
    {
        if (!panel) {
            return;
        }

        panel.style.top =
            '';

        panel.style.left =
            '';

        panel.style.right =
            '';

        panel.style.bottom =
            '';
    }


    function positionDesktopLeadActionPanel(
        button,
        panel
    )
    {
        if (
            !button
            ||
            !panel
            ||
            !isDesktopLeadActionPanel()
        ) {
            return;
        }


        const viewportPadding =
            12;

        const gap =
            8;


        /*
         * Use the complete Lead Actions toggle row as the anchor.
         * This keeps the popover visually aligned with the right
         * edge of the Actions column.
         */
        const anchor =
            button.closest(
                '.lm-action-toggle-row'
            ) || button;


        const anchorRect =
            anchor.getBoundingClientRect();


        const panelWidth =
            Math.min(
                320,
                window.innerWidth -
                    (viewportPadding * 2)
            );


        panel.style.width =
            panelWidth + 'px';


        /*
         * Temporarily place it so browser can calculate
         * the real rendered height.
         */
        panel.style.top =
            '0px';

        panel.style.left =
            '0px';


        const panelHeight =
            panel.offsetHeight;


        let left =
            anchorRect.right -
            panelWidth;


        if (
            left <
            viewportPadding
        ) {
            left =
                viewportPadding;
        }


        if (
            left +
            panelWidth >
            window.innerWidth -
            viewportPadding
        ) {
            left =
                window.innerWidth -
                panelWidth -
                viewportPadding;
        }


        let top =
            anchorRect.bottom +
            gap;


        /*
         * If there is not enough room below, open upward.
         */
        if (
            top +
            panelHeight >
            window.innerHeight -
            viewportPadding
        ) {

            const topAbove =
                anchorRect.top -
                panelHeight -
                gap;


            if (
                topAbove >=
                viewportPadding
            ) {
                top =
                    topAbove;
            } else {

                top =
                    Math.max(
                        viewportPadding,
                        window.innerHeight -
                            panelHeight -
                            viewportPadding
                    );
            }
        }


        panel.style.left =
            Math.round(left) +
            'px';

        panel.style.top =
            Math.round(top) +
            'px';
    }


    function closeAllLeadActionPanels(
        exceptPanel = null
    )
    {
        document
            .querySelectorAll(
                '.lm-action-panel.is-open'
            )
            .forEach(
                function(openPanel) {

                    if (
                        exceptPanel
                        &&
                        openPanel ===
                        exceptPanel
                    ) {
                        return;
                    }


                    openPanel.classList.remove(
                        'is-open'
                    );


                    resetLeadActionPanelPosition(
                        openPanel
                    );


                    const otherContainer =
                        openPanel.closest(
                            '.lm-mcard'
                        )
                        ||
                        openPanel.closest(
                            'td'
                        )
                        ||
                        openPanel.closest(
                            'tr'
                        );


                    const otherToggle =
                        otherContainer
                            ? otherContainer.querySelector(
                                '.lm-action-toggle'
                            )
                            : null;


                    if (otherToggle) {
                        otherToggle.classList.remove(
                            'is-open'
                        );
                    }

                }
            );
    }


    function toggleLeadActionPanel(button)
    {
        const container =
            button.closest(
                '.lm-mcard'
            )
            ||
            button.closest(
                'td'
            )
            ||
            button.closest(
                'tr'
            );


        if (!container) {
            return;
        }


        const panel =
            container.querySelector(
                '.lm-action-panel'
            );


        if (!panel) {
            return;
        }


        const willOpen =
            !panel.classList.contains(
                'is-open'
            );


        closeAllLeadActionPanels(
            panel
        );


        panel.classList.toggle(
            'is-open',
            willOpen
        );


        button.classList.toggle(
            'is-open',
            willOpen
        );


        if (!willOpen) {

            resetLeadActionPanelPosition(
                panel
            );

            return;
        }


        if (
            isDesktopLeadActionPanel()
        ) {

            /*
             * Wait one frame until display:block has rendered,
             * then calculate exact viewport position.
             */
            window.requestAnimationFrame(
                function() {

                    positionDesktopLeadActionPanel(
                        button,
                        panel
                    );

                }
            );

        } else {

            /*
             * Mobile remains a normal inline accordion.
             */
            resetLeadActionPanelPosition(
                panel
            );
        }
    }


    function closeLeadActionPanel(button)
    {
        const panel =
            button.closest(
                '.lm-action-panel'
            );


        if (!panel) {
            return;
        }


        panel.classList.remove(
            'is-open'
        );


        resetLeadActionPanelPosition(
            panel
        );


        const container =
            panel.closest(
                '.lm-mcard'
            )
            ||
            panel.closest(
                'td'
            )
            ||
            panel.closest(
                'tr'
            );


        const toggle =
            container
                ? container.querySelector(
                    '.lm-action-toggle'
                )
                : null;


        if (toggle) {
            toggle.classList.remove(
                'is-open'
            );
        }
    }


    /*
     * Close floating desktop panel if user clicks outside it.
     */
    document.addEventListener(
        'click',
        function(event) {

            if (
                event.target.closest(
                    '.lm-action-panel'
                )
                ||
                event.target.closest(
                    '.lm-action-toggle'
                )
            ) {
                return;
            }


            closeAllLeadActionPanels();
        }
    );


    /*
     * A fixed popover must not stay detached from its table row
     * while the page/table is being scrolled.
     */
    window.addEventListener(
        'scroll',
        function() {

            if (
                isDesktopLeadActionPanel()
            ) {
                closeAllLeadActionPanels();
            }

        },
        true
    );


    window.addEventListener(
        'resize',
        function() {

            closeAllLeadActionPanels();

        }
    );


    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key ===
                'Escape'
            ) {
                closeAllLeadActionPanels();
            }

        }
    );


    // async function saveLeadAction(leadId, actionType, button) {
    //     const panel = button.closest('.lm-action-panel');

    //     if (!panel) {
    //         return;
    //     }

    //     const actionUrl = panel.dataset.actionUrl;

    //     if (!actionUrl) {
    //         alert('Lead action URL is missing.');
    //         return;
    //     }

    //     const feedback = document.getElementById(
    //         `lead-action-feedback-${leadId}`
    //     );

    //     const originalHtml = button.innerHTML;

    //     if (feedback) {
    //         feedback.className = 'lm-action-feedback';
    //         feedback.textContent = '';
    //     }

    //     button.classList.add('is-saving');
    //     button.innerHTML = `
    //         <span class="spinner-border spinner-border-sm"
    //               role="status"
    //               aria-hidden="true"></span>
    //         <span>Saving...</span>
    //     `;

    //     try {
    //         const response = await fetch(actionUrl, {
    //             method: 'POST',

    //             headers: {
    //                 'Accept': 'application/json',
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'X-Requested-With': 'XMLHttpRequest'
    //             },

    //             body: JSON.stringify({
    //                 action_type: actionType
    //             })
    //         });

    //         let data = {};

    //         try {
    //             data = await response.json();
    //         } catch (jsonError) {
    //             data = {};
    //         }

    //         if (!response.ok || data.status === false) {
    //             throw new Error(
    //                 data.message ||
    //                 'Unable to save lead action.'
    //             );
    //         }

    //         button.classList.remove('is-saving');
    //         button.classList.add('is-done');

    //         const actionLabel =
    //             data.action && data.action.label
    //                 ? data.action.label
    //                 : leadActionLabel(actionType);

    //         button.innerHTML = `
    //             <i class="bi bi-check2-circle"></i>
    //             <span>${escapeLeadActionHtml(actionLabel)}</span>
    //         `;

    //         const lastAction =
    //             document.getElementById(
    //                 `lead-action-last-${leadId}`
    //             );

    //         if (lastAction) {
    //             lastAction.innerHTML = `
    //                 <i class="bi bi-check-circle"></i>
    //                 ${escapeLeadActionHtml(actionLabel)}
    //             `;
    //         }

    //         if (feedback) {
    //             feedback.className =
    //                 'lm-action-feedback success';

    //             feedback.textContent =
    //                 data.message ||
    //                 `${actionLabel} saved successfully.`;
    //         }

    //         if (data.lead_status) {
    //             updateLeadStatusBadge(
    //                 leadId,
    //                 data.lead_status
    //             );
    //         }

    //         window.setTimeout(function() {
    //             if (feedback) {
    //                 feedback.className =
    //                     'lm-action-feedback';

    //                 feedback.textContent = '';
    //             }
    //         }, 2200);

    //     } catch (error) {
    //         console.error(
    //             'Lead action save failed:',
    //             error
    //         );

    //         button.classList.remove('is-saving');
    //         button.innerHTML = originalHtml;

    //         if (feedback) {
    //             feedback.className =
    //                 'lm-action-feedback error';

    //             feedback.textContent =
    //                 error.message ||
    //                 'Something went wrong.';
    //         }
    //     }
    // }

    async function saveLeadAction(leadId, actionType, button) {

    const panel = button.closest('.lm-action-panel');

    if (!panel) {
        return false;
    }


    const actionUrl = panel.dataset.actionUrl;

    if (!actionUrl) {
        alert('Lead action URL is missing.');
        return false;
    }


    const feedback = document.getElementById(
        `lead-action-feedback-${leadId}`
    );


    const originalHtml = button.innerHTML;


    if (feedback) {
        feedback.className = 'lm-action-feedback';
        feedback.textContent = '';
    }


    button.classList.add('is-saving');

    button.innerHTML = `
        <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true">
        </span>

        <span>
            ${
                actionType === 'not_interested'
                    ? 'Rejecting...'
                    : 'Saving...'
            }
        </span>
    `;


    try {

        const response = await fetch(
            actionUrl,
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                body: JSON.stringify({
                    action_type: actionType
                })
            }
        );


        let data = {};

        try {
            data = await response.json();
        } catch (jsonError) {
            data = {};
        }


        if (
            !response.ok ||
            data.status === false
        ) {

            let message =
                data.message ||
                'Unable to save lead action.';


            if (data.errors) {

                const firstError =
                    Object.values(
                        data.errors
                    )[0];


                if (
                    Array.isArray(firstError) &&
                    firstError[0]
                ) {
                    message = firstError[0];
                }
            }


            throw new Error(message);
        }


        if (
            actionType === 'not_interested' &&
            data.lead_status === 'reject'
        ) {

            button.classList.remove('is-saving');

            button.innerHTML = `
                <i class="bi bi-check2-circle"></i>
                <span>Not Interested</span>
            `;


            if (feedback) {
                feedback.className =
                    'lm-action-feedback success';

                feedback.textContent =
                    data.message ||
                    'Lead marked as Not Interested.';
            }


            updateLeadStatusBadge(
                leadId,
                'reject'
            );


            window.setTimeout(
                function () {
                    window.location.reload();
                },
                500
            );


            return true;
        }


        button.classList.remove('is-saving');
        button.classList.add('is-done');


        const actionLabel =
            data.action &&
            data.action.label
                ? data.action.label
                : leadActionLabel(actionType);


        button.innerHTML = `
            <i class="bi bi-check2-circle"></i>
            <span>${escapeLeadActionHtml(actionLabel)}</span>
        `;


        const lastAction =
            document.getElementById(
                `lead-action-last-${leadId}`
            );


        if (lastAction) {
            lastAction.innerHTML = `
                <i class="bi bi-check-circle"></i>
                ${escapeLeadActionHtml(actionLabel)}
            `;
        }


        if (feedback) {
            feedback.className =
                'lm-action-feedback success';

            feedback.textContent =
                data.message ||
                `${actionLabel} saved successfully.`;
        }


        if (data.lead_status) {
            updateLeadStatusBadge(
                leadId,
                data.lead_status
            );
        }


        window.setTimeout(
            function () {
                if (feedback) {
                    feedback.className =
                        'lm-action-feedback';

                    feedback.textContent = '';
                }
            },
            2200
        );


        return true;

    } catch (error) {

        console.error(
            'Lead action save failed:',
            error
        );


        button.classList.remove('is-saving');
        button.innerHTML = originalHtml;


        if (feedback) {
            feedback.className =
                'lm-action-feedback error';

            feedback.textContent =
                error.message ||
                'Something went wrong.';
        }


        return false;
    }
}


function leadActionLabel(actionType) {
        const labels = {
            contacted: 'Contacted',
            follow_up: 'Follow Up',
            deal_close: 'Deal Close',
            not_interested: 'Not Interested',
            not_contactable: 'Not Contactable',
            wrong_category: 'Wrong Category',
            out_of_area: 'Out of Area',
            marketing_job: 'Marketing / Job',
            quotation_shared: 'Quotation Shared'
        };

        return labels[actionType] || actionType;
    }

    function updateLeadStatusBadge(
        leadId,
        status
    ) {
        const statusMap = {
            pending: {
                className: 'lm-status-dot pending',
                label: ''
            },

            contacted: {
                className: 'lm-status-dot contacted',
                label: ''
            },

            call: {
                className: 'lm-status-call',
                label: 'Call'
            },

            accept: {
                className: 'lm-status-accept',
                label: 'Accepted'
            },

            accepted: {
                className: 'lm-status-accept',
                label: 'Accepted'
            },

            reject: {
                className: 'lm-status-reject',
                label: 'Rejected'
            },

            rejected: {
                className: 'lm-status-reject',
                label: 'Rejected'
            }
        };

        const config =
            statusMap[status] || {
                className: 'lm-status-pending',
                label: status
                    ? status.charAt(0).toUpperCase() +
                      status.slice(1)
                    : 'Pending'
            };

        document
            .querySelectorAll(
                `[data-lead-status="${leadId}"]`
            )
            .forEach(function(container) {
                container.innerHTML = `
                    <span class="lm-badge ${config.className}">
                        ${escapeLeadActionHtml(config.label)}
                    </span>
                `;
            });
    }

    function escapeLeadActionHtml(value) {
        const div = document.createElement('div');
        div.textContent = value == null ? '' : String(value);
        return div.innerHTML;
    }

    /* =====================================================
       CALL LEAD + AUTO MARK CONTACTED
       ===================================================== */
    function showRequiredLeadAction(leadId) {
        if (requiredQuotationResolved) return;
        const modal = document.getElementById('requiredCallModal');
        if (!modal) return;
        document.getElementById('requiredCallLeadId').value = String(leadId);
        const name = document.querySelector(`[data-lead-action-panel="${leadId}"]`);
        document.getElementById('requiredCallLeadName').textContent = name?.dataset.leadName ||
            (@json(optional($pendingCallLead)->name) && String(@json(optional($pendingCallLead)->id)) === String(leadId)
                ? @json(optional($pendingCallLead)->name) : `Lead #${leadId}`);
        document.getElementById('requiredCallPhone').value = name?.dataset.leadPhone ||
            (String(@json(optional($pendingCallLead)->id)) === String(leadId)
                ? (@json(optional($pendingCallLead)->phone) || '') : '');
        if (window.bootstrap?.Modal) {
            bootstrap.Modal.getOrCreateInstance(modal, {backdrop: 'static', keyboard: false}).show();
        }
    }

    let requiredQuotationResolved = false;

    function openRequiredCallQuotation(kind) {
        const leadId = document.getElementById('requiredCallLeadId').value;
        const phone = document.getElementById('requiredCallPhone').value;
        const leadName = document.getElementById('requiredCallLeadName').textContent;
        const error = document.getElementById('requiredCallError');
        if (!leadId || !phone) {
            error.textContent = 'Lead phone number is required to share a quotation on WhatsApp.';
            error.hidden = false;
            return;
        }

        const quoteElement = document.getElementById(kind === 'quick' ? 'quickQuotationModal' : 'detailedQuotationModal');
        const callElement = document.getElementById('requiredCallModal');
        if (!quoteElement || !window.bootstrap?.Modal) return;
        requiredQuotationResolved = false;
        callElement.addEventListener('hidden.bs.modal', function handoff() {
            quoteElement.addEventListener('hidden.bs.modal', function returnToOutcome() {
                if (!requiredQuotationResolved) showRequiredLeadAction(leadId);
            }, {once: true});
            if (kind === 'quick') openQuickQuotation(leadId, leadName, phone);
            else openDetailedQuotationModal(leadId, leadName, phone);
        }, {once: true});
        bootstrap.Modal.getOrCreateInstance(callElement).hide();
    }

    function completeQuotationCall() {
        requiredQuotationResolved = true;
        sessionStorage.removeItem('requiredLeadAction');
        bootstrap.Modal.getInstance(document.getElementById('requiredCallModal'))?.hide();
        window.location.reload();
    }

    const requiredCallReasons = {
        contacted: [
            ['interested', 'Interested'], ['information_requested', 'Asked for Details'],
            ['follow_up_later', 'Will Decide Later'], ['discuss_internal', 'Will Discuss Internally'],
            ['other', 'Other']
        ],
        not_contactable: [
            ['busy', 'Busy'], ['no_answer', 'No Answer'], ['switched_off', 'Switched Off'],
            ['out_of_coverage', 'Out of Coverage'], ['invalid_number', 'Invalid Number'], ['other', 'Other']
        ]
    };

    function chooseRequiredCallOutcome(checkbox) {
        document.querySelectorAll('.required-outcome-choice input').forEach(item => {
            if (item !== checkbox) item.checked = false;
        });
        document.getElementById('requiredCallOutcome').value = checkbox.checked ? checkbox.value : '';
        toggleRequiredCallFields();
    }

    function chooseRequiredCallReason(checkbox) {
        document.querySelectorAll('.required-reason-choice input').forEach(item => {
            if (item !== checkbox) item.checked = false;
        });
        const noteFields = document.getElementById('requiredCallNoteFields');
        const note = document.getElementById('requiredCallNote');
        const outcome = document.getElementById('requiredCallOutcome').value;
        const needsNote = ['not_interested', 'deal_close'].includes(outcome) || (checkbox.checked && checkbox.value === 'other');
        noteFields.hidden = !needsNote;
        document.getElementById('requiredCallNoteLabel').textContent = ['not_interested', 'deal_close'].includes(outcome) ? 'Call note / remarks' : 'Call note for Other';
        note.required = needsNote;
        if (noteFields.hidden) note.value = '';
        else note.focus();
    }

    function toggleRequiredCallFields() {
        const outcome = document.getElementById('requiredCallOutcome').value;
        const followUp = outcome === 'follow_up';
        document.getElementById('requiredCallFollowUpFields').hidden = !followUp;
        const reasons = requiredCallReasons[outcome] || [];
        const container = document.getElementById('requiredCallReasonChoices');
        container.replaceChildren();
        reasons.forEach(([key, label]) => {
            const wrapper = document.createElement('label');
            wrapper.className = 'required-reason-choice';
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.value = key;
            input.onchange = () => chooseRequiredCallReason(input);
            wrapper.append(input, document.createTextNode(label));
            container.appendChild(wrapper);
        });
        document.getElementById('requiredCallReasonFields').hidden = !reasons.length;
        const needsNote = ['not_interested', 'deal_close'].includes(outcome);
        document.getElementById('requiredCallNoteFields').hidden = !needsNote;
        document.getElementById('requiredCallNoteLabel').textContent = needsNote ? 'Call note / remarks' : 'Call note for Other';
        document.getElementById('requiredCallNote').required = needsNote;
        document.getElementById('requiredCallNote').value = '';
        if (needsNote) document.getElementById('requiredCallNote').focus();
        if (followUp) renderRequiredCallCalendar();
    }

    let requiredCalendarMonth = new Date();
    let requiredCallSelectedDate = '';

    function renderRequiredCallCalendar() {
        const year = requiredCalendarMonth.getFullYear();
        const month = requiredCalendarMonth.getMonth();
        document.getElementById('requiredCalendarMonth').textContent =
            new Intl.DateTimeFormat('en-IN', {month: 'long', year: 'numeric'}).format(requiredCalendarMonth);
        const grid = document.getElementById('requiredCalendarDays');
        grid.replaceChildren();
        const offset = new Date(year, month, 1).getDay();
        const days = new Date(year, month + 1, 0).getDate();
        for (let i = 0; i < offset; i++) grid.appendChild(document.createElement('span'));
        const now = new Date();
        for (let day = 1; day <= days; day++) {
            const date = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = String(day);
            button.setAttribute('aria-label', date);
            button.setAttribute('aria-pressed', String(date === requiredCallSelectedDate));
            if (date === requiredCallSelectedDate) button.classList.add('is-selected');
            if (now.getFullYear() === year && now.getMonth() === month && now.getDate() === day) button.classList.add('is-today');
            button.onclick = () => selectRequiredCallDate(date);
            grid.appendChild(button);
        }
    }

    function moveRequiredCallMonth(delta) {
        requiredCalendarMonth = new Date(requiredCalendarMonth.getFullYear(), requiredCalendarMonth.getMonth() + delta, 1);
        renderRequiredCallCalendar();
    }

    function selectRequiredCallDate(date) {
        requiredCallSelectedDate = date;
        syncRequiredCallSchedule();
        renderRequiredCallCalendar();
    }

    function syncRequiredCallSchedule() {
        const time = document.getElementById('requiredCallTime').value;
        document.getElementById('requiredCallSchedule').value = requiredCallSelectedDate && time
            ? `${requiredCallSelectedDate}T${time}` : '';
        document.getElementById('requiredCalendarSelected').textContent = requiredCallSelectedDate || 'Select a date';
    }

    function chooseRequiredCallPriority(checkbox) {
        document.querySelectorAll('.required-priority-choice input').forEach(item => {
            if (item !== checkbox) item.checked = false;
        });
        document.getElementById('requiredCallPriority').value = checkbox.checked ? checkbox.value : '';
    }

    async function submitRequiredCall(event) {
        event.preventDefault();
        const leadId = document.getElementById('requiredCallLeadId').value;
        const outcome = document.getElementById('requiredCallOutcome').value;
        const note = document.getElementById('requiredCallNote').value.trim();
        const error = document.getElementById('requiredCallError');
        const button = document.getElementById('requiredCallSubmit');
        error.hidden = true;
        if (!leadId || !outcome) {
            error.textContent = 'Choose a call outcome.';
            error.hidden = false;
            return;
        }
        const followUp = outcome === 'follow_up';
        const schedule = document.getElementById('requiredCallSchedule').value;
        const priority = document.getElementById('requiredCallPriority').value;
        if (followUp && (!schedule || !priority)) {
            error.textContent = 'Follow Up date, time and priority are required.';
            error.hidden = false;
            return;
        }
        if (['not_interested', 'deal_close'].includes(outcome) && !note) {
            error.textContent = 'Write a call note for this outcome.';
            error.hidden = false;
            document.getElementById('requiredCallNote').focus();
            return;
        }
        const assignee = document.getElementById('requiredCallAssignee').value;
        const reasonInput = document.querySelector('.required-reason-choice input:checked');
        const reason = reasonInput?.value || '';
        if (requiredCallReasons[outcome] && (!reason || (reason === 'other' && !note))) {
            error.textContent = 'Select a call result. For Other, write the reason.';
            error.hidden = false;
            return;
        }
        const payload = followUp
            ? {call_schedule: schedule.replace('T', ' '), follow_up_priority: priority, ...(assignee ? {user_id: assignee} : {})}
            : {action_type: outcome, ...(reason ? {call_reason: reason} : {}), ...((reason === 'other' || ['not_interested', 'deal_close'].includes(outcome)) ? {note} : {})};
        const path = followUp ? 'follow-up' : 'action';
        const panel = document.querySelector(`[data-lead-action-panel="${leadId}"]`);
        const endpoint = !followUp && panel?.dataset.actionUrl
            ? panel.dataset.actionUrl
            : `{{ url('/admin/leads') }}/${encodeURIComponent(leadId)}/${path}`;
        button.disabled = true;
        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {'Accept': 'application/json', 'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest'},
                body: JSON.stringify(payload)
            });
            const result = await response.json();
            if (!response.ok || result.status === false) {
                const firstError = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(firstError || result.message || 'Could not save the call outcome.');
            }
            sessionStorage.removeItem('requiredLeadAction');
            window.location.reload();
        } catch (e) {
            error.textContent = e.message || 'Could not save the call outcome.';
            error.hidden = false;
            button.disabled = false;
        }
    }

    async function callLeadAndMarkContacted(leadId, phone, button) {
        if (!phone) {
            return;
        }

        const originalHtml = button ? button.innerHTML : '';
        const originalDisabled = button ? button.disabled : false;

        if (button) {
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        }

        try {
            const response = await fetch(
                `{{ url('/admin/leads') }}/${leadId}/mark-contacted`,
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                }
            );

            let data = {};

            try {
                data = await response.json();
            } catch (jsonError) {
                data = {};
            }

            if (!response.ok || data.status === false) {
                throw new Error(
                    data.message || 'Unable to update lead status.'
                );
            }

            updateLeadStatusBadge(
                leadId,
                data.lead_status || 'pending'
            );

            const lastAction =
                document.getElementById(
                    `lead-action-last-${leadId}`
                );

            if (lastAction) {
                lastAction.innerHTML = `
                    <i class="bi bi-telephone-fill"></i>
                    Call initiated · outcome required
                `;
            }

            sessionStorage.setItem('requiredLeadAction', String(leadId));
            window.addEventListener('focus', () => {
                if (sessionStorage.getItem('requiredLeadAction') === String(leadId)) {
                    showRequiredLeadAction(leadId);
                }
            }, {once: true});
            window.location.href = `tel:${phone}`;
            window.setTimeout(() => showRequiredLeadAction(leadId), 500);
        } catch (error) {
            console.error('Lead call status update failed:', error);

            alert(
                error.message ||
                'Unable to mark this lead as contacted. Please try again.'
            );
        } finally {
            if (button) {
                button.disabled = originalDisabled;
                button.innerHTML = originalHtml;
            }
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const serverPendingId = @json(optional($pendingCallLead)->id);
        if (serverPendingId) showRequiredLeadAction(serverPendingId);
        else sessionStorage.removeItem('requiredLeadAction');
    });

    /* =====================================================
       QUICK QUOTATION
       ===================================================== */
    let quickQuoteModal = null;

    const quickQuoteProducts = {!! $quoteProductsJson !!};

    function productOptions() {
        let html = '<option value="">Select Product</option>';

        quickQuoteProducts.forEach(function(product) {
            html += `<option value="${product.id}" data-price="${product.sale_price}">${product.name}</option>`;
        });

        return html;
    }

    function quoteRowHtml(remove = true) {
    return `
        <div class="lm-quote-row">
            ${remove ? `<button type="button"
                class="lm-quote-remove"
                onclick="removeQuickQuoteProduct(this)">×</button>` : ''}

            <div class="mb-3">
                <label>Product / Service</label>

                <select class="form-control quote-product"
                        onchange="handleQuickQuoteProductChange(this)">
                    ${productOptions()}
                </select>
            </div>

            <div class="lm-quote-or">OR</div>

            <div class="mb-3">
                <label>Custom Product / Service</label>

                <input type="text"
                       class="form-control quote-custom-description"
                       placeholder="Type custom product or service"
                       oninput="handleQuickQuoteCustomText(this)">
            </div>

            <div class="row g-2">

                <div class="col-md-4">
                    <label>HSN / SAC Code</label>
                    <select class="form-control quote-hsn"
                            onchange="handleQuickQuoteHsnChange(this)">
                        <option value="">Select a code</option>
                        <option value="000001">Sample 1 (000001)</option>
                        <option value="000002">Sample 2 (000002)</option>
                        <option value="000003">Sample 3 (000003)</option>
                        <option value="other">Other — enter code</option>
                    </select>
                    <input type="text"
                           class="form-control quote-hsn-custom mt-2"
                           placeholder="Enter your HSN / SAC code"
                           inputmode="numeric"
                           style="display:none">
                    <small class="text-muted">Select Other for a real quotation.</small>
                </div>

                <div class="col-md-4">
                    <label>Price / Unit</label>

                    <div class="input-group">
                        <span class="input-group-text">₹</span>

                        <input type="number"
                               class="form-control quote-price"
                               value="0"
                               min="0"
                               step="0.01"
                               oninput="calculateQuickQuote()">
                    </div>
                </div>

                <div class="col-md-4">
                    <label>Quantity</label>

                    <input type="number"
                           class="form-control quote-quantity"
                           value="1"
                           min="1"
                           step="1"
                           oninput="calculateQuickQuote()">
                </div>

            </div>
        </div>
    `;
}


    function openQuickQuotation(leadId, leadName, phone) {
        document.getElementById('quoteLeadId').value = leadId;
        document.getElementById('quotePhone').value = phone || '';
        document.getElementById('quoteCustomerName').innerText = 'For: ' + (leadName || '');

        document.getElementById('quoteGst').checked = false;
        document.getElementById('quoteDiscountSwitch').checked = false;
        document.getElementById('quoteDiscount').value = 0;
        document.getElementById('quoteDiscountBox').style.display = 'none';
        document.getElementById('quoteNote').value = '';
        document.getElementById('quoteProductRows').innerHTML = quoteRowHtml(false);

        calculateQuickQuote();

        quickQuoteModal = bootstrap.Modal.getOrCreateInstance(
            document.getElementById('quickQuotationModal')
        );

        quickQuoteModal.show();
    }

    function addQuickQuoteProduct() {
        document.getElementById('quoteProductRows')
            .insertAdjacentHTML('beforeend', quoteRowHtml(true));
    }

    function removeQuickQuoteProduct(button) {
        button.closest('.lm-quote-row').remove();
        calculateQuickQuote();
    }

    function handleQuickQuoteProductChange(select) {
        const row = select.closest('.lm-quote-row');
        const selected = select.options[select.selectedIndex];
        const price = parseFloat(selected?.dataset?.price || 0);

        row.querySelector('.quote-price').value = Number.isFinite(price) ? price : 0;

        if (select.value) {
            row.querySelector('.quote-custom-description').value = '';
        }

        calculateQuickQuote();
    }

    function handleQuickQuoteCustomText(input) {
        const row = input.closest('.lm-quote-row');

        if (input.value.trim() !== '') {
            row.querySelector('.quote-product').value = '';
        }

        calculateQuickQuote();
    }

    function handleQuickQuoteHsnChange(select) {
        const customInput = select.closest('.lm-quote-row').querySelector('.quote-hsn-custom');
        const useCustomCode = select.value === 'other';
        customInput.style.display = useCustomCode ? 'block' : 'none';
        customInput.required = useCustomCode;
        if (!useCustomCode) customInput.value = '';
    }

    function toggleQuickDiscount() {
        const enabled = document.getElementById('quoteDiscountSwitch').checked;
        document.getElementById('quoteDiscountBox').style.display = enabled ? 'block' : 'none';

        if (!enabled) {
            document.getElementById('quoteDiscount').value = 0;
        }

        calculateQuickQuote();
    }

    function getQuickQuotationData() {
        let products = [];
        let subtotal = 0;

        document.querySelectorAll('.lm-quote-row').forEach(function(row) {
            const select = row.querySelector('.quote-product');
            const customInput = row.querySelector('.quote-custom-description');

            const productId = select.value || null;
            const customDescription = customInput.value.trim();

            if (!productId && !customDescription) {
                return;
            }

            let productName = customDescription;

            if (productId) {
                productName = select.options[select.selectedIndex].text.trim();
            }

            const selectedHsn = row.querySelector('.quote-hsn').value;
            const hsnCode = selectedHsn === 'other'
                ? row.querySelector('.quote-hsn-custom').value.trim()
                : selectedHsn;

            const price =
                parseFloat(
                    row.querySelector('.quote-price').value
                ) || 0;

            const quantity =
                parseFloat(
                    row.querySelector('.quote-quantity').value
                ) || 0;

            const total =
                price * quantity;

            subtotal += total;

            products.push({
                product_id: productId,
                custom_description: customDescription || null,
                name: productName,

                hsn_code: hsnCode,

                price: price,
                quantity: quantity,
                total: total
            });
        });

        const discountPercentage = document.getElementById('quoteDiscountSwitch').checked
            ? (parseFloat(document.getElementById('quoteDiscount').value) || 0)
            : 0;

        const discountAmount = subtotal * discountPercentage / 100;
        const afterDiscount = subtotal - discountAmount;

        const gstPercent = document.getElementById('quoteGst').checked ? 18 : 0;
        const gstAmount = afterDiscount * gstPercent / 100;

        return {
            products: products,
            subtotal: subtotal,
            discountPercentage: discountPercentage,
            discountAmount: discountAmount,
            gstPercent: gstPercent,
            gstAmount: gstAmount,
            total: afterDiscount + gstAmount,
            note: document.getElementById('quoteNote').value.trim()
        };
    }

    function calculateQuickQuote() {
        const data = getQuickQuotationData();

        document.getElementById('quoteSubtotal').innerText = data.subtotal.toFixed(2);
        document.getElementById('quoteDiscountAmount').innerText = data.discountAmount.toFixed(2);
        document.getElementById('quoteGstAmount').innerText = data.gstAmount.toFixed(2);
        document.getElementById('quoteGrandTotal').innerText = data.total.toFixed(2);

        document.getElementById('quoteDiscountSummary').style.display = data.discountAmount > 0 ? 'flex' : 'none';
        document.getElementById('quoteGstSummary').style.display = data.gstAmount > 0 ? 'flex' : 'none';
    }

    function buildQuickQuotationMessage(quotationNo) {
        const data = getQuickQuotationData();

        if (!data.products.length) {
            alert('Please select a product or enter a custom product/service.');
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
         * WhatsApp card-style Proforma template.
         * This is normal WhatsApp pre-filled text,
         * so no WhatsApp Business API template is required.
         */

        let message =
            `━━━━━━━━━━━━━━━━━━━━━━━━\n` +
            `        *PROFORMA*\n` +
            `━━━━━━━━━━━━━━━━━━━━━━━━\n\n` +
            `Hello *${customerName || 'Customer'}* 👋\n\n` +
            `Your proforma has been prepared successfully.\n\n`;

        if (quotationNo) {
            message +=
                `*Proforma No:* ${quotationNo}\n\n`;
        }

        message +=
            `──────── *ITEMS* ────────\n`;

        data.products.forEach(function(product, index) {

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

        });

        message +=
            `\n────────────────────────\n` +
            `Subtotal: ₹${data.subtotal.toFixed(2)}\n`;

        if (data.discountAmount > 0) {
            message +=
                `Discount (${data.discountPercentage}%): -₹${data.discountAmount.toFixed(2)}\n`;
        }

        if (data.gstAmount > 0) {
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

    async function sendQuickQuotationWhatsApp() {
        const data = getQuickQuotationData();

        if (!data.products.length) {
            alert('Please select a product or enter a custom product/service.');
            return;
        }

        const missingHsn =
            data.products.some(function(product) {
                return !product.hsn_code;
            });

        if (missingHsn) {
            alert('Please select or enter an HSN / SAC code for all products.');
            return;
        }

        let phone = document.getElementById('quotePhone').value.replace(/\D/g,'');

        if (!phone) {
            alert('Lead phone number is not available.');
            return;
        }

        if (phone.length === 10) {
            phone = '91' + phone;
        }

        const button = document.getElementById('quoteWhatsAppButton');
        const oldHtml = button.innerHTML;

        button.disabled = true;
        button.innerHTML = 'Saving...';

        try {
            const response = await fetch(
                "{{ route('admin.leads.quick-proforma.store') }}",
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        lead_id: document.getElementById('quoteLeadId').value,
                        items: data.products.map(function(product) {
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
                        }),
                        discount: data.discountPercentage,
                        vat: data.gstPercent,
                        note: data.note
                    })
                }
            );

            const result = await response.json();

            if (!response.ok || !result.status) {
                throw new Error(result.message || 'Unable to save quotation.');
            }


            const message =
                buildQuickQuotationMessage(
                    result.proforma_no
                );

            window.open(
                'https://wa.me/' + phone + '?text=' + encodeURIComponent(message),
                '_blank'
            );

            document.getElementById('quoteSaveStatus').className = 'lm-quote-status success';
            document.getElementById('quoteSaveStatus').innerText = 'Proforma saved successfully.';

            completeQuotationCall();

        } catch (error) {
            document.getElementById('quoteSaveStatus').className = 'lm-quote-status error';
            document.getElementById('quoteSaveStatus').innerText = error.message;
        } finally {
            button.disabled = false;
            button.innerHTML = oldHtml;
        }
    }


    /* =====================================================
       DETAILED QUOTATION PDF LIBRARY
       ===================================================== */
    let detailedQuotationModalInstance = null;

    function openDetailedQuotationModal(leadId, leadName, phone) {
        const modalElement = document.getElementById('detailedQuotationModal');

        if (!modalElement) {
            alert('Detailed Quotation modal not found.');
            return;
        }

        document.getElementById('detailQuoteLeadId').value = leadId || '';
        document.getElementById('detailQuotePhone').value = phone || '';
        document.getElementById('detailQuoteLeadName').textContent = leadName || 'Lead';
        document.getElementById('detailQuoteLeadPhone').textContent = phone || 'Phone number not available';

        const categorySelect =
            document.getElementById('detailQuoteCategory');

        if (categorySelect) {
            categorySelect.value = '';
        }

        const searchInput = document.getElementById('detailQuoteSearch');
        if (searchInput) searchInput.value = '';

        document.querySelectorAll('input[name="detailed_quotation_id"]').forEach(function(input) {
            input.checked = false;
        });

       document
            .querySelectorAll('.lm-detail-quote-item')
            .forEach(function (item) {
                item.style.display = 'none';
            });


        const searchBox =
            document.getElementById('detailQuoteSearchBox');

        if (searchBox) {
            searchBox.style.display = 'none';
        }


        const categoryMessage =
            document.getElementById('detailQuoteCategoryMessage');

        if (categoryMessage) {
            categoryMessage.style.display = '';

            categoryMessage.innerHTML = `
                <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>
                Please select a category to view proposal PDFs.
            `;
        }

        const preview = document.getElementById('detailQuotePreview');
        if (preview) preview.classList.remove('is-visible');

        const previewLink = document.getElementById('detailQuotePreviewLink');
        if (previewLink) previewLink.href = '#';

        const status = document.getElementById('detailQuoteStatus');
        if (status) {
            status.className = 'lm-detail-quote-status';
            status.textContent = '';
        }

        detailedQuotationModalInstance =
            bootstrap.Modal.getOrCreateInstance(modalElement);

        detailedQuotationModalInstance.show();
    }

    function filterDetailedQuotations() {
        const categorySelect =
            document.getElementById('detailQuoteCategory');

        const searchInput =
            document.getElementById('detailQuoteSearch');

        const searchBox =
            document.getElementById('detailQuoteSearchBox');

        const categoryMessage =
            document.getElementById('detailQuoteCategoryMessage');


        const selectedCategoryId =
            String(categorySelect?.value || '');

        const searchValue =
            String(searchInput?.value || '')
                .trim()
                .toLowerCase();


        /*
        * Category change hone par previous
        * selected PDF ko reset karna hai.
        */

        document
            .querySelectorAll(
                'input[name="detailed_quotation_id"]'
            )
            .forEach(function (input) {
                input.checked = false;
            });


        const preview =
            document.getElementById('detailQuotePreview');

        if (preview) {
            preview.classList.remove('is-visible');
        }


        const previewLink =
            document.getElementById('detailQuotePreviewLink');

        if (previewLink) {
            previewLink.href = '#';
        }


        /*
        * Category select nahi hui.
        */

        if (!selectedCategoryId) {
            if (searchBox) {
                searchBox.style.display = 'none';
            }

            document
                .querySelectorAll('.lm-detail-quote-item')
                .forEach(function (item) {
                    item.style.display = 'none';
                });

            if (categoryMessage) {
                categoryMessage.style.display = '';

                categoryMessage.innerHTML = `
                    <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>
                    Please select a category to view proposal PDFs.
                `;
            }

            return;
        }


        /*
        * Category selected: search box show karo.
        */

        if (searchBox) {
            searchBox.style.display = '';
        }


        let visibleQuotationCount = 0;


        document
            .querySelectorAll('.lm-detail-quote-item')
            .forEach(function (item) {
                const itemCategoryId =
                    String(item.dataset.categoryId || '');

                const quotationName =
                    String(item.dataset.quotationName || '')
                        .toLowerCase();


                const categoryMatches =
                    itemCategoryId === selectedCategoryId;

                const searchMatches =
                    !searchValue ||
                    quotationName.includes(searchValue);


                const shouldShow =
                    categoryMatches && searchMatches;


                item.style.display =
                    shouldShow ? '' : 'none';


                if (shouldShow) {
                    visibleQuotationCount++;
                }
            });


        /*
        * Category mein PDF na mile.
        */

        if (categoryMessage) {
            if (visibleQuotationCount === 0) {
                categoryMessage.style.display = '';

                categoryMessage.innerHTML = `
                    <i class="bi bi-file-earmark-x fs-4 d-block mb-2"></i>
                    No proposal PDF found in this category.
                `;
            } else {
                categoryMessage.style.display = 'none';
            }
        }
    }

    function selectDetailedQuotation(input) {
        const preview = document.getElementById('detailQuotePreview');
        const previewLink = document.getElementById('detailQuotePreviewLink');

        if (!input || !input.checked) {
            if (preview) preview.classList.remove('is-visible');
            return;
        }

        if (previewLink) previewLink.href = input.dataset.viewUrl || '#';
        if (preview) preview.classList.add('is-visible');

        const status = document.getElementById('detailQuoteStatus');
        if (status) {
            status.className = 'lm-detail-quote-status';
            status.textContent = '';
        }
    }

    async function sendDetailedQuotationWhatsApp() {
        const selected = document.querySelector(
            'input[name="detailed_quotation_id"]:checked'
        );

        const status = document.getElementById('detailQuoteStatus');

        if (!selected) {
            if (status) {
                status.className = 'lm-detail-quote-status error';
                status.textContent = 'Please select a detailed quotation first.';
            }
            return;
        }

        const leadId = document.getElementById('detailQuoteLeadId').value;
        let phone = document.getElementById('detailQuotePhone').value.replace(/\D/g, '');

        if (!leadId) {
            alert('Lead not found.');
            return;
        }

        if (!phone) {
            if (status) {
                status.className = 'lm-detail-quote-status error';
                status.textContent = 'Lead phone number is not available.';
            }
            return;
        }

        if (phone.length === 10) phone = '91' + phone;

        const button = document.getElementById('detailQuoteWhatsAppButton');
        const originalHtml = button.innerHTML;

        button.disabled = true;
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"
                  role="status" aria-hidden="true"></span>
            Preparing PDF...
        `;

        if (status) {
            status.className = 'lm-detail-quote-status';
            status.textContent = '';
        }

        try {
            const response = await fetch(
                `{{ url('/admin/leads') }}/${leadId}/detailed-quotation/send`,
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        detailed_quotation_id: selected.value
                    })
                }
            );

            let data = {};
            try {
                data = await response.json();
            } catch (jsonError) {
                data = {};
            }

            if (!response.ok || data.status === false) {
                let message = data.message || 'Unable to prepare detailed quotation.';

                if (data.errors) {
                    const firstError = Object.values(data.errors)[0];
                    if (Array.isArray(firstError) && firstError[0]) {
                        message = firstError[0];
                    }
                }

                throw new Error(message);
            }

            const quotationName =
                data.quotation_name || selected.dataset.name || 'Detailed Quotation';

            const leadName =
                document.getElementById('detailQuoteLeadName').textContent || '';

            const pdfUrl = data.pdf_url || '';

            if (!pdfUrl) {
                throw new Error('PDF share link was not generated.');
            }

            /*
             * WhatsApp card-style Proposal template.
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
                'https://wa.me/' + phone + '?text=' + encodeURIComponent(message),
                '_blank'
            );

            const lastAction = document.getElementById(`lead-action-last-${leadId}`);

            if (lastAction) {
                lastAction.innerHTML = `
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    Quotation Shared
                `;
            }

            if (status) {
                status.className = 'lm-detail-quote-status success';
                status.textContent =
                    'Detailed quotation logged in Lead Actions. Opening WhatsApp...';
            }

            completeQuotationCall();

        } catch (error) {
            console.error('Detailed quotation WhatsApp send failed:', error);

            if (status) {
                status.className = 'lm-detail-quote-status error';
                status.textContent =
                    error.message || 'Unable to send detailed quotation.';
            }
        } finally {
            button.disabled = false;
            button.innerHTML = originalHtml;
        }
    }

    // 

    let leadFollowUpModalInstance = null;


/* =========================================================
   OPEN FOLLOW UP MODAL
   ========================================================= */

function openFollowUpModal(
    leadId,
    leadName,
    remarks,
    assignedUserId,
    priority = ''
) {
    /*
     * Follow Up may be launched from the desktop floating
     * Lead Actions popover. Close it before opening Bootstrap.
     */
    closeAllLeadActionPanels();


    const modalElement =
        document.getElementById(
            'leadFollowUpModal'
        );

    if (!modalElement) {

        alert(
            'Follow Up modal not found.'
        );

        return;
    }


    /*
     * Lead ID
     */

    document
        .getElementById(
            'followUpLeadId'
        )
        .value =
            leadId;


    /*
     * Lead Name
     */

    const nameElement =
        document.getElementById(
            'followUpLeadName'
        );

    if (nameElement) {

        nameElement.textContent =
            leadName
                ? `Follow Up — ${leadName}`
                : 'Schedule Follow Up';
    }


    /*
     * Existing Remarks
     */

    const remarksElement =
        document.getElementById(
            'followUpRemarks'
        );

    if (remarksElement) {

        remarksElement.value =
            remarks || '';
    }


    /*
     * Assigned Sales User
     */

    const userElement =
        document.getElementById(
            'followUpUserId'
        );

    if (
        userElement &&
        assignedUserId
    ) {

        userElement.value =
            String(assignedUserId);
    }


    /*
     * Default date/time
     *
     * Current date/time rounded forward.
     */

    const scheduleElement =
        document.getElementById(
            'followUpCallSchedule'
        );

    if (scheduleElement) {

        const now =
            new Date();

        now.setMinutes(
            now.getMinutes() -
            now.getTimezoneOffset()
        );

        scheduleElement.value =
            now
                .toISOString()
                .slice(0, 16);
    }


    document.getElementById('followUpPriority').value = priority || '';

    /*
     * Bootstrap Modal
     */

    leadFollowUpModalInstance =
        bootstrap.Modal.getOrCreateInstance(
            modalElement
        );

    leadFollowUpModalInstance.show();
}


/* =========================================================
   SUBMIT FOLLOW UP
   ========================================================= */

async function submitLeadFollowUp()
{
    const leadId =
        document
            .getElementById(
                'followUpLeadId'
            )
            .value;


    const schedule =
        document
            .getElementById(
                'followUpCallSchedule'
            )
            .value;


    const remarks =
        document.getElementById('followUpRemarks').value;
    const priority = document.getElementById('followUpPriority').value;


    const userElement =
        document
            .getElementById(
                'followUpUserId'
            );


    const userId =
        userElement
            ? userElement.value
            : null;


    /*
     * Validation
     */

    if (!leadId) {

        alert(
            'Lead not found.'
        );

        return;
    }


    if (!priority) { alert('Choose Hot, Warm or Cold.'); return; }

    if (!schedule) {

        alert(
            'Please select follow up date and time.'
        );

        return;
    }


    const submitButton =
        document.getElementById(
            'followUpSubmitBtn'
        );


    const originalHtml =
        submitButton.innerHTML;


    submitButton.disabled =
        true;


    submitButton.innerHTML = `
        <span
            class="spinner-border spinner-border-sm"
            role="status">
        </span>

        Scheduling...
    `;


    try {

        const response =
            await fetch(
                `{{ url('/admin/leads') }}/${leadId}/follow-up`,
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
                            follow_up_priority: priority,
                            call_schedule:
                                schedule,

                            remarks:
                                remarks,

                            user_id:
                                userId || null
                        })
                }
            );


        let data = {};


        try {

            data =
                await response.json();

        } catch (e) {

            data = {};
        }


        if (
            !response.ok ||
            data.status === false
        ) {

            let message =
                data.message ||
                'Unable to schedule follow up.';


            /*
             * Laravel validation errors
             */

            if (data.errors) {

                const firstError =
                    Object.values(
                        data.errors
                    )[0];

                if (
                    Array.isArray(
                        firstError
                    )
                ) {

                    message =
                        firstError[0];
                }
            }


            throw new Error(
                message
            );
        }


        if (sessionStorage.getItem('requiredLeadAction') === String(leadId)) sessionStorage.removeItem('requiredLeadAction');

        /*
         * Close Modal
         */

        if (
            leadFollowUpModalInstance
        ) {

            leadFollowUpModalInstance.hide();
        }


        /*
         * Since status becomes "call",
         * the lead must disappear from
         * Pending / Contacted Lead Index.
         *
         * Safest option is refresh because:
         * - KPI counts change
         * - Source counts may change
         * - Category counts change
         * - pagination changes
         */

        window.location.reload();


    } catch (error) {

        alert(
            error.message ||
            'Unable to schedule follow up.'
        );

    } finally {

        submitButton.disabled =
            false;

        submitButton.innerHTML =
            originalHtml;
    }
}



// 

function changeLeadPerPage(value) {

    const customBox =
        document.getElementById('leadCustomPageSize');

    if (value === 'custom') {
        customBox.style.display = 'flex';

        document
            .getElementById('leadCustomPageInput')
            .focus();

        return;
    }

    const url = new URL(window.location.href);

    url.searchParams.set('per_page', value);
    url.searchParams.delete('custom_per_page');
    url.searchParams.delete('page');

    window.location.href = url.toString();
}


function applyCustomLeadPerPage() {

    const input =
        document.getElementById('leadCustomPageInput');

    let value = parseInt(input.value, 10);

    if (!value || value < 1) {
        value = 1;
    }

    if (value > 1000) {
        value = 1000;
    }

    const url = new URL(window.location.href);

    url.searchParams.set('per_page', 'custom');
    url.searchParams.set('custom_per_page', value);
    url.searchParams.delete('page');

    window.location.href = url.toString();
}


// 


/*
|--------------------------------------------------------------------------
| SUBMIT LEAD NOTE → THEN ACTION AJAX
|--------------------------------------------------------------------------
*/

/* =========================================================
   LEAD ACTION NOTE GATE
   Follow Up is intentionally excluded from this flow.
   ========================================================= */

let leadActionNoteModalInstance = null;
let pendingLeadActionButton = null;
let pendingLeadNotesUrl = null;


function openLeadActionNoteModal(
    leadId,
    leadName,
    actionType,
    actionLabel,
    button,
    leadNotesUrl
) {
    /*
     * Close the table popover first.
     * The Bootstrap Lead Note modal will then open cleanly.
     */
    const sourceActionPanel =
        button
            ? button.closest(
                '.lm-action-panel'
            )
            : null;

    if (sourceActionPanel) {

        sourceActionPanel.classList.remove(
            'is-open'
        );

        resetLeadActionPanelPosition(
            sourceActionPanel
        );

        const sourceContainer =
            sourceActionPanel.closest(
                '.lm-mcard'
            )
            ||
            sourceActionPanel.closest(
                'td'
            )
            ||
            sourceActionPanel.closest(
                'tr'
            );

        const sourceToggle =
            sourceContainer
                ? sourceContainer.querySelector(
                    '.lm-action-toggle'
                )
                : null;

        if (sourceToggle) {
            sourceToggle.classList.remove(
                'is-open'
            );
        }
    }


    const modalElement =
        document.getElementById(
            'leadActionNoteModal'
        );

    if (!modalElement) {
        console.error(
            'Lead Action Note modal not found.'
        );

        alert(
            'Lead Action Note modal not found.'
        );

        return;
    }


    pendingLeadActionButton = button;
    pendingLeadNotesUrl = leadNotesUrl || null;


    document.getElementById(
        'leadActionModalLeadId'
    ).value = leadId;


    document.getElementById(
        'leadActionModalActionType'
    ).value = actionType;


    document.getElementById(
        'leadActionModalLeadName'
    ).textContent = leadName || 'Unnamed Lead';


    document.getElementById(
        'leadActionModalActionLabel'
    ).textContent = actionLabel || 'Lead Action';


    document.getElementById(
        'leadActionModalTitle'
    ).textContent = actionLabel || 'Update Lead Action';


    const noteInput =
        document.getElementById(
            'leadActionModalNote'
        );

    const errorBox =
        document.getElementById(
            'leadActionModalNoteError'
        );


    noteInput.value = '';
    noteInput.classList.remove('is-invalid');

    errorBox.style.display = 'none';
    errorBox.textContent = 'Lead Note is required.';


    noteInput.oninput = function () {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            errorBox.style.display = 'none';
        }
    };


    const notesButton =
        document.getElementById(
            'viewExistingLeadNotesBtn'
        );


    if (notesButton) {
        notesButton.onclick = function () {
            if (!pendingLeadNotesUrl) {
                return;
            }

            if (leadActionNoteModalInstance) {
                leadActionNoteModalInstance.hide();
            }

            showRightModal(
                pendingLeadNotesUrl,
                'Lead Notes'
            );
        };
    }


    if (
        typeof bootstrap === 'undefined' ||
        !bootstrap.Modal
    ) {
        console.error(
            'Bootstrap Modal JavaScript is not available.'
        );

        alert(
            'Modal component could not be loaded.'
        );

        return;
    }


    leadActionNoteModalInstance =
        bootstrap.Modal.getOrCreateInstance(
            modalElement
        );

    leadActionNoteModalInstance.show();


    modalElement.addEventListener(
        'shown.bs.modal',
        function focusLeadActionNote() {
            noteInput.focus();

            modalElement.removeEventListener(
                'shown.bs.modal',
                focusLeadActionNote
            );
        }
    );
}


async function submitLeadActionNote()
{
    const leadId =
        document
            .getElementById(
                'leadActionModalLeadId'
            )
            .value;


    const actionType =
        document
            .getElementById(
                'leadActionModalActionType'
            )
            .value;


    const noteInput =
        document.getElementById(
            'leadActionModalNote'
        );


    const errorBox =
        document.getElementById(
            'leadActionModalNoteError'
        );


    const submitButton =
        document.getElementById(
            'leadActionModalSubmitBtn'
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


    if (!leadId) {
        errorBox.style.display =
            'block';

        errorBox.textContent =
            'Lead not found.';

        return;
    }


    if (!pendingLeadActionButton) {
        errorBox.style.display =
            'block';

        errorBox.textContent =
            'Selected Lead Action not found.';

        return;
    }


    noteInput.classList.remove(
        'is-invalid'
    );

    errorBox.style.display =
        'none';


    const originalHtml =
        submitButton.innerHTML;


    submitButton.disabled = true;

    submitButton.innerHTML = `
        <span
            class="spinner-border spinner-border-sm me-1"
            role="status"
            aria-hidden="true">
        </span>
        Saving Note...
    `;


    try {

        /* ---------------------------------------------------------
           STEP 1: SAVE INTO EXISTING LEAD NOTES SYSTEM
           Route: admin.lead.notes
           Controller: LeadNoteController@store
           --------------------------------------------------------- */

        const now = new Date();

        const pad = function (value) {
            return String(value).padStart(2, '0');
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


        const noteResponse =
            await fetch(
                `{{ route('admin.lead.notes') }}`,
                {
                    method: 'POST',

                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    body: JSON.stringify({
                        lead_id: leadId,
                        description: note,
                        call_date: callDate
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
                    message = noteData.message;
                }

                if (noteData.errors) {
                    const firstError =
                        Object.values(
                            noteData.errors
                        )[0];

                    if (
                        Array.isArray(firstError) &&
                        firstError[0]
                    ) {
                        message = firstError[0];
                    }
                }
            } catch (jsonError) {
                // Keep default message.
            }


            throw new Error(message);
        }


        /* ---------------------------------------------------------
           STEP 2: ONLY AFTER NOTE SAVES, RUN EXISTING ACTION AJAX
           --------------------------------------------------------- */

        submitButton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
                aria-hidden="true">
            </span>
            Updating Lead...
        `;


        const actionSaved =
            await saveLeadAction(
                leadId,
                actionType,
                pendingLeadActionButton
            );


        if (!actionSaved) {
            throw new Error(
                'Lead Note was saved, but Lead Action could not be updated.'
            );
        }


        if (sessionStorage.getItem('requiredLeadAction') === String(leadId)) sessionStorage.removeItem('requiredLeadAction');
        if (leadActionNoteModalInstance) {
            leadActionNoteModalInstance.hide();
        }


        pendingLeadActionButton = null;
        pendingLeadNotesUrl = null;


    } catch (error) {

        console.error(
            'Lead Note / Lead Action Error:',
            error
        );


        errorBox.style.display =
            'block';

        errorBox.textContent =
            error.message ||
            'Something went wrong.';


    } finally {

        submitButton.disabled = false;
        submitButton.innerHTML = originalHtml;
    }
}


</script>
@endpush















