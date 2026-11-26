@extends('index')
@push('title', get_phrase('Lead Actions'))

@php
    $actionLabels = [
        'call' => 'Call',
        'whatsapp' => 'WhatsApp',
        'contacted' => 'Contacted',
        'follow_up' => 'Follow Up',
        'deal_close' => 'Deal Close',
        'not_interested' => 'Not Interested',
        'not_contactable' => 'Not Contactable',
        'wrong_category' => 'Wrong Category',
        'out_of_area' => 'Out of Area',
        'marketing_job' => 'Marketing / Job',
        'quotation_shared' => 'Quotation Shared',
    ];

    $actionIcons = [
        'call' => 'bi-telephone-fill',
        'whatsapp' => 'bi-whatsapp',
        'contacted' => 'bi-person-check-fill',
        'follow_up' => 'bi-arrow-repeat',
        'deal_close' => 'bi-check-circle-fill',
        'not_interested' => 'bi-slash-circle',
        'not_contactable' => 'bi-telephone-x',
        'wrong_category' => 'bi-diagram-2',
        'out_of_area' => 'bi-geo-alt',
        'marketing_job' => 'bi-megaphone',
        'quotation_shared' => 'bi-file-earmark-text-fill',
    ];

    $actionClasses = [
        'call' => 'la-call',
        'whatsapp' => 'la-whatsapp',
        'contacted' => 'la-contacted',
        'follow_up' => 'la-followup',
        'deal_close' => 'la-deal',
        'not_interested' => 'la-danger',
        'not_contactable' => 'la-muted',
        'wrong_category' => 'la-warning',
        'out_of_area' => 'la-warning',
        'marketing_job' => 'la-marketing',
        'quotation_shared' => 'la-quote',
    ];
@endphp

@push('css')
<style>
    :root{
        --la-blue:#0b74c4;
        --la-blue-dark:#075a99;
        --la-blue-50:#eaf4fc;
        --la-blue-100:#d9edfb;

        --la-red:#e5342a;
        --la-red-50:#fdeceb;

        --la-green:#0f8a4b;
        --la-green-50:#eafbf1;

        --la-orange:#a15c00;
        --la-orange-50:#fff6e8;

        --la-purple:#694fd7;
        --la-purple-50:#f1eefe;

        --la-ink-950:#0f172a;
        --la-ink-900:#111827;
        --la-ink-700:#374151;
        --la-ink-600:#4b5563;
        --la-ink-500:#6b7280;
        --la-ink-400:#9aa3af;

        --la-line:#e5e7eb;
        --la-line-soft:#eef1f4;

        --la-surface:#fff;
        --la-surface-2:#f9fafb;
        --la-page:#f5f6f8;

        --la-radius-sm:8px;
        --la-radius-md:12px;
        --la-radius-lg:16px;

        --la-shadow-xs:0 1px 2px rgba(16,24,40,.04);
        --la-shadow-sm:0 3px 12px rgba(16,24,40,.055);
    }

    .la{
        position:relative;
        color:var(--la-ink-700);
    }

    .la *{
        box-sizing:border-box;
    }

    .la-card{
        background:var(--la-surface);
        border:1px solid var(--la-line);
        border-radius:var(--la-radius-lg);
        box-shadow:var(--la-shadow-xs);
    }

    /* =========================================================
       HEADER
       ========================================================= */

    .la-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        padding:20px 24px;
        margin-bottom:16px;
    }

    .la-title h1{
        margin:0;
        color:var(--la-ink-900);
        font-size:20px;
        font-weight:750;
        letter-spacing:-.25px;
    }

    .la-title p{
        margin:3px 0 0;
        color:var(--la-ink-500);
        font-size:12.5px;
    }

    .la-header-actions{
        display:flex;
        align-items:center;
        gap:7px;
    }

    .la-btn{
        height:38px;
        padding:0 13px;
        border-radius:var(--la-radius-sm);
        border:1px solid var(--la-line);
        background:#fff;
        color:var(--la-ink-700);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        font-size:12px;
        font-weight:650;
        text-decoration:none;
        cursor:pointer;
        transition:.15s ease;
        white-space:nowrap;
    }

    .la-btn:hover{
        border-color:#cfd6de;
        background:var(--la-surface-2);
        color:var(--la-ink-900);
    }

    .la-btn-primary{
        border-color:var(--la-blue);
        background:var(--la-blue);
        color:#fff;
    }

    .la-btn-primary:hover{
        border-color:var(--la-blue-dark);
        background:var(--la-blue-dark);
        color:#fff;
    }

    /* =========================================================
       KPI STRIP
       ========================================================= */

    .la-kpis{
        display:grid;
        grid-template-columns:repeat(7,minmax(0,1fr));
        gap:10px;
        margin-bottom:14px;
    }

    .la-kpi{
        min-height:88px;
        padding:15px;
        display:flex;
        align-items:center;
        gap:11px;
    }

    .la-kpi-icon{
        width:36px;
        height:36px;
        flex:0 0 36px;
        border-radius:10px;
        display:grid;
        place-items:center;
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
        font-size:14px;
    }

    .la-kpi:nth-child(2) .la-kpi-icon{
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
    }

    .la-kpi:nth-child(3) .la-kpi-icon{
        background:#f5f0ff;
        color:#6847c7;
    }

    .la-kpi:nth-child(4) .la-kpi-icon{
        background:#eefaf3;
        color:var(--la-green);
    }

    .la-kpi:nth-child(5) .la-kpi-icon{
        background:#fff3ef;
        color:var(--la-red);
    }

    .la-kpi-label{
        color:var(--la-ink-500);
        font-size:9.5px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.4px;
        white-space:nowrap;
    }

    .la-kpi-value{
        margin-top:3px;
        color:var(--la-ink-900);
        font-size:21px;
        line-height:1;
        font-weight:750;
        font-variant-numeric:tabular-nums;
    }

    /* =========================================================
       COMMAND / FILTER BAR
       ========================================================= */

    .la-command{
        margin-bottom:12px;
        overflow:hidden;
    }

    .la-command-row{
        display:flex;
        gap:8px;
        align-items:center;
        padding:11px;
    }

    .la-search{
        position:relative;
        flex:1 1 auto;
        min-width:0;
    }

    .la-search i{
        position:absolute;
        top:50%;
        left:13px;
        transform:translateY(-50%);
        color:var(--la-ink-400);
        pointer-events:none;
        font-size:13px;
    }

    .la-search input{
        width:100%;
        height:40px;
        border:1px solid var(--la-line);
        border-radius:var(--la-radius-sm);
        background:var(--la-surface-2);
        color:var(--la-ink-900);
        font-size:12.5px;
        padding:0 12px 0 37px;
        outline:none;
    }

    .la-search input:focus{
        background:#fff;
        border-color:#aad4ef;
        box-shadow:0 0 0 3px var(--la-blue-50);
    }

    .la-command-actions{
        display:flex;
        align-items:center;
        gap:6px;
        flex-shrink:0;
    }

    .la-icon-btn{
        min-width:40px;
        height:40px;
        padding:0 11px;
        border:1px solid var(--la-line);
        border-radius:var(--la-radius-sm);
        background:#fff;
        color:var(--la-ink-600);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        font-size:11.5px;
        font-weight:650;
        text-decoration:none;
        cursor:pointer;
        transition:.15s ease;
    }

    .la-icon-btn:hover,
    .la-icon-btn.is-active{
        border-color:#bddff4;
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
    }

    .la-filters{
        max-height:0;
        overflow:hidden;
        border-top:1px solid transparent;
        transition:max-height .22s ease;
    }

    .la-filters.is-open{
        max-height:300px;
        border-top-color:var(--la-line);
    }

    .la-filter-grid{
        padding:11px;
        background:var(--la-surface-2);
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr)) auto;
        gap:8px;
        align-items:end;
    }

    .la-field label{
        display:block;
        margin-bottom:4px;
        color:var(--la-ink-500);
        font-size:9px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.35px;
    }

    .la-field select,
    .la-field input{
        width:100%;
        height:38px;
        border:1px solid var(--la-line);
        border-radius:var(--la-radius-sm);
        background:#fff;
        color:var(--la-ink-700);
        padding:0 9px;
        font-size:11.5px;
        outline:none;
    }

    .la-field select:focus,
    .la-field input:focus{
        border-color:#aad4ef;
        box-shadow:0 0 0 3px var(--la-blue-50);
    }

    .la-filter-actions{
        display:flex;
        gap:6px;
    }

    .la-filter-actions .la-btn{
        height:38px;
    }

    /* =========================================================
       ACTION TYPE SEGMENTS
       ========================================================= */

    .la-segments{
        display:flex;
        gap:5px;
        padding:6px;
        margin-bottom:12px;
        overflow-x:auto;
        scrollbar-width:none;
    }

    .la-segments::-webkit-scrollbar{
        display:none;
    }

    .la-segments a{
        flex:0 0 auto;
        min-height:34px;
        padding:6px 10px;
        border-radius:8px;
        border:1px solid transparent;
        background:transparent;
        color:var(--la-ink-600);
        display:inline-flex;
        align-items:center;
        gap:6px;
        text-decoration:none;
        font-size:10.5px;
        font-weight:650;
        white-space:nowrap;
    }

    .la-segments a:hover{
        background:var(--la-surface-2);
        color:var(--la-ink-900);
    }

    .la-segments a.active{
        background:var(--la-ink-900);
        color:#fff;
    }

    .la-segment-count{
        min-width:20px;
        height:20px;
        padding:0 5px;
        border-radius:20px;
        background:rgba(0,0,0,.06);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:9px;
        font-weight:700;
    }

    .la-segments a.active .la-segment-count{
        background:rgba(255,255,255,.16);
    }

    /* =========================================================
       ACTION BADGES
       ========================================================= */

    .la-action-badge{
        display:inline-flex;
        align-items:center;
        gap:5px;
        min-height:27px;
        padding:5px 8px;
        border-radius:7px;
        font-size:10px;
        line-height:1;
        font-weight:700;
        white-space:nowrap;
    }

    .la-call{
        background:#eaf4fc;
        color:#075a99;
    }

    .la-whatsapp{
        background:#eafbf1;
        color:#0f8a4b;
    }

    .la-contacted{
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
    }

    .la-followup{
        background:#f5f0ff;
        color:#6244bd;
    }

    .la-deal{
        background:var(--la-green-50);
        color:var(--la-green);
    }

    .la-danger{
        background:var(--la-red-50);
        color:#ba291f;
    }

    .la-muted{
        background:#f3f4f6;
        color:#596273;
    }

    .la-warning{
        background:var(--la-orange-50);
        color:var(--la-orange);
    }

    .la-marketing{
        background:#fff4e8;
        color:#b35f00;
    }

    .la-quote{
        background:#edf5ff;
        color:#0b67ad;
    }


    /* =========================================================
       DIRECT LEAD CONTACT ACTIONS
       ========================================================= */
    .la-contact-actions{
        display:flex;
        align-items:center;
        gap:5px;
        flex-wrap:nowrap;
    }

    .la-contact-btn{
        height:30px;
        min-width:30px;
        padding:0 8px;
        border:1px solid var(--la-line);
        border-radius:7px;
        background:#fff;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:5px;
        font-size:9.5px;
        font-weight:700;
        cursor:pointer;
        transition:.14s ease;
        white-space:nowrap;
    }

    .la-contact-btn.call{
        border-color:#cce5f6;
        background:#eef8fe;
        color:var(--la-blue-dark);
    }

    .la-contact-btn.call:hover{
        background:var(--la-blue);
        border-color:var(--la-blue);
        color:#fff;
    }

    .la-contact-btn.whatsapp{
        border-color:#ccebd9;
        background:#effbf4;
        color:var(--la-green);
    }

    .la-contact-btn.whatsapp:hover{
        background:var(--la-green);
        border-color:var(--la-green);
        color:#fff;
    }

    .la-contact-btn:disabled{
        opacity:.55;
        cursor:not-allowed;
    }

    .la-mcard-contact-actions{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:6px;
        margin-top:9px;
    }

    .la-mcard-contact-actions .la-contact-btn{
        width:100%;
        min-height:34px;
    }


    /* =========================================================
       UPDATE LEAD ACTION MENU
       ========================================================= */
    .la-update-wrap{
        position:relative;
    }

    .la-update-toggle{
        height:30px;
        padding:0 9px;
        border:1px solid var(--la-line);
        border-radius:7px;
        background:#fff;
        color:var(--la-blue-dark);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:5px;
        font-size:9.5px;
        font-weight:750;
        cursor:pointer;
        white-space:nowrap;
    }

    .la-update-toggle:hover,
    .la-update-toggle.is-open{
        background:var(--la-blue-50);
        border-color:#bcdff5;
    }

    .la-update-panel{
        display:none;
        margin-top:7px;
        width:290px;
        padding:10px;
        border:1px solid #d9e3eb;
        border-radius:12px;
        background:#f8fbfd;
        box-shadow:0 12px 28px rgba(15,23,42,.12);
    }

    .la-update-panel.is-open{
        display:block;
    }

    .la-update-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:8px;
        color:var(--la-ink-700);
        font-size:10px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.35px;
    }

    .la-update-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:6px;
    }

    .la-update-option{
        min-height:39px;
        padding:0 9px;
        border:1px solid var(--la-line);
        border-radius:8px;
        background:#fff;
        color:var(--la-ink-700);
        display:flex;
        align-items:center;
        gap:7px;
        text-align:left;
        font-size:10px;
        font-weight:700;
        cursor:pointer;
    }

    .la-update-option:hover{
        border-color:#acd7f0;
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
    }

    .la-update-option:disabled{
        opacity:.55;
        cursor:not-allowed;
    }

    .la-update-option i{
        width:18px;
        text-align:center;
        color:var(--la-blue-dark);
    }

    .la-mobile-update{
        margin-top:9px;
    }

    .la-mobile-update .la-update-toggle{
        width:100%;
        min-height:35px;
    }

    .la-mobile-update .la-update-panel{
        width:100%;
        box-shadow:none;
    }


    /*
    |--------------------------------------------------------------------------
    | DESKTOP UPDATE LEAD ACTION PANEL — FLOATING POPOVER
    |--------------------------------------------------------------------------
    |
    | Earlier the panel stayed in normal <td> flow.
    | Because of that, opening Lead Actions increased the whole
    | table row height and created the large blank area.
    |
    | Desktop now uses position:fixed.
    | Mobile keeps the existing inline accordion layout.
    |
    */

    @media (min-width:768px){

        .la-update-wrap{
            position:relative;
            overflow:visible;
        }

        .la-update-panel{
            position:fixed;
            display:none;
            width:320px;
            max-width:calc(100vw - 24px);
            max-height:calc(100vh - 24px);
            margin:0;
            overflow-y:auto;
            z-index:1090;
            background:#f8fbfd;
            box-shadow:
                0 20px 48px rgba(15,23,42,.18),
                0 4px 12px rgba(15,23,42,.08);
        }

        .la-update-panel.is-open{
            display:block;
        }

        .la-update-grid{
            grid-template-columns:1fr 1fr;
        }
    }


    /* =========================================================
       DESKTOP TABLE
       ========================================================= */

    .la-list-card{
        overflow:hidden;
    }

    .la-list-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        padding:13px 16px;
        border-bottom:1px solid var(--la-line);
    }

    .la-list-head h2{
        margin:0;
        color:var(--la-ink-900);
        font-size:13.5px;
        font-weight:750;
    }

    .la-list-head span{
        color:var(--la-ink-400);
        font-size:10.5px;
    }

    .la-table-wrap{
        overflow-x:auto;
    }

    .la-table{
        width:100%;
        min-width:1180px;
        border-collapse:separate;
        border-spacing:0;
    }

    .la-table thead th{
        position:sticky;
        top:0;
        z-index:2;
        background:var(--la-surface-2);
        border-bottom:1px solid var(--la-line);
        color:var(--la-ink-500);
        padding:10px 11px;
        font-size:9px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:.4px;
        white-space:nowrap;
        text-align:left;
    }

    .la-table tbody td{
        padding:11px;
        border-bottom:1px solid var(--la-line-soft);
        color:var(--la-ink-700);
        font-size:11.5px;
        vertical-align:middle;
    }

    .la-table tbody tr:last-child td{
        border-bottom:0;
    }

    .la-table tbody tr:hover{
        background:#fbfcfd;
    }

    .la-lead-name{
        color:var(--la-ink-900);
        font-size:12.5px;
        font-weight:700;
    }

    .la-lead-phone{
        margin-top:2px;
        color:var(--la-ink-400);
        font-size:10px;
    }

    .la-user{
        display:flex;
        align-items:center;
        gap:7px;
    }

    .la-avatar{
        width:27px;
        height:27px;
        border-radius:7px;
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
        display:grid;
        place-items:center;
        flex:0 0 27px;
        font-size:9.5px;
        font-weight:750;
    }

    .la-user-name{
        color:var(--la-ink-700);
        font-size:11px;
        font-weight:650;
    }

    .la-user-role{
        color:var(--la-ink-400);
        font-size:9px;
    }

    .la-note{
        max-width:280px;
        color:var(--la-ink-600);
        line-height:1.35;
    }

    .la-quotation{
        display:inline-flex;
        align-items:center;
        gap:5px;
        color:var(--la-blue-dark);
        font-size:10.5px;
        font-weight:700;
    }

    .la-date{
        white-space:nowrap;
        color:var(--la-ink-600);
        font-size:10.5px;
    }

    .la-time{
        display:block;
        margin-top:2px;
        color:var(--la-ink-400);
        font-size:9.5px;
    }

    /* =========================================================
       MOBILE ACTION CARDS
       ========================================================= */

    .la-mobile-list{
        display:none;
    }

    .la-mcard{
        position:relative;
        background:#fff;
        border:1px solid var(--la-line);
        border-radius:var(--la-radius-md);
        margin-bottom:7px;
        padding:11px 12px;
    }

    .la-mcard-top{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:8px;
    }

    .la-mcard-lead{
        min-width:0;
    }

    .la-mcard-name{
        color:var(--la-ink-900);
        font-size:13px;
        line-height:1.25;
        font-weight:750;
        max-width:190px;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }

    .la-mcard-phone{
        color:var(--la-ink-400);
        font-size:10px;
        margin-top:2px;
    }

    .la-mcard-note{
        margin-top:8px;
        color:var(--la-ink-600);
        font-size:10.5px;
        line-height:1.4;
    }

    .la-mcard-meta{
        display:flex;
        flex-wrap:wrap;
        gap:5px 10px;
        margin-top:8px;
        color:var(--la-ink-400);
        font-size:9px;
    }

    .la-mcard-meta span{
        display:inline-flex;
        align-items:center;
        gap:4px;
    }

    .la-mcard-bottom{
        margin-top:8px;
        padding-top:8px;
        border-top:1px solid var(--la-line-soft);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:8px;
    }

    .la-mcard-user{
        display:flex;
        align-items:center;
        gap:6px;
        min-width:0;
    }

    .la-mcard-user .la-avatar{
        width:25px;
        height:25px;
        flex-basis:25px;
    }

    .la-mcard-quotation{
        color:var(--la-blue-dark);
        font-size:9.5px;
        font-weight:700;
        white-space:nowrap;
    }

    /* =========================================================
       EMPTY STATE
       ========================================================= */

    .la-empty{
        padding:48px 20px;
        text-align:center;
        color:var(--la-ink-500);
    }

    .la-empty-icon{
        width:48px;
        height:48px;
        margin:0 auto 10px;
        border-radius:14px;
        background:var(--la-blue-50);
        color:var(--la-blue-dark);
        display:grid;
        place-items:center;
        font-size:19px;
    }

    .la-empty h3{
        margin:0;
        color:var(--la-ink-900);
        font-size:14px;
        font-weight:700;
    }

    .la-empty p{
        margin:4px 0 0;
        font-size:11px;
    }

    /* =========================================================
       PAGINATION
       ========================================================= */

    .la-pagination{
        padding:12px 15px;
        border-top:1px solid var(--la-line);
    }

    /* =========================================================
       TABLET
       ========================================================= */

    @media(max-width:1100px){
        .la-kpis{
            grid-template-columns:repeat(3,minmax(0,1fr));
        }

        .la-filter-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }

        .la-filter-actions{
            grid-column:1/-1;
        }
    }

    /* =========================================================
       MOBILE
       ========================================================= */

    @media(max-width:767.98px){
        body{
            background:var(--la-page);
        }

        .la-header{
            padding:12px 13px;
            margin-bottom:8px;
            border-radius:12px;
        }

        .la-title h1{
            font-size:16px;
        }

        .la-title p{
            display:none;
        }

        .la-header-actions .la-btn:not(.la-btn-primary){
            display:none;
        }

        .la-header-actions .la-btn-primary{
            height:34px;
            padding:0 10px;
            font-size:10.5px;
        }

        .la-kpis{
            grid-template-columns:repeat(7,1fr);
            gap:0;
            margin-bottom:8px;
            background:#fff;
            border:1px solid var(--la-line);
            border-radius:12px;
            overflow:hidden;
        }

        .la-kpi{
            min-height:0;
            padding:8px 3px;
            border:0;
            border-radius:0;
            box-shadow:none;
            display:block;
            text-align:center;
        }

        .la-kpi:not(:last-child){
            border-right:1px solid var(--la-line-soft);
        }

        .la-kpi-icon{
            display:none;
        }

        .la-kpi-label{
            font-size:6px;
            white-space:nowrap;
        }

        .la-kpi-value{
            font-size:14px;
            margin-top:2px;
        }

        .la-command{
            margin-bottom:8px;
            border-radius:12px;
        }

        .la-command-row{
            padding:7px;
            gap:5px;
        }

        .la-search input{
            height:36px;
            font-size:11px;
        }

        .la-command-actions{
            gap:4px;
        }

        .la-icon-btn{
            width:36px;
            min-width:36px;
            height:36px;
            padding:0;
        }

        .la-icon-btn span{
            display:none;
        }

        .la-filter-grid{
            grid-template-columns:1fr;
            padding:9px;
        }

        .la-filter-actions{
            display:grid;
            grid-template-columns:1fr auto;
        }

        .la-segments{
            padding:4px;
            margin-bottom:8px;
            border-radius:11px;
        }

        .la-segments a{
            min-height:31px;
            padding:5px 8px;
            font-size:9px;
        }

        .la-list-head,
        .la-table-wrap{
            display:none;
        }

        .la-list-card{
            border:0;
            background:transparent;
            box-shadow:none;
            overflow:visible;
        }

        .la-mobile-list{
            display:block;
        }

        .la-pagination{
            margin-top:8px;
            border:1px solid var(--la-line);
            border-radius:11px;
            background:#fff;
            padding:9px;
        }
    }

    @media(max-width:390px){
        .la-mcard-name{
            max-width:165px;
        }

        .la-kpi-label{
            font-size:5.5px;
        }

        .la-kpi-value{
            font-size:13px;
        }
    }

    @media(prefers-reduced-motion:reduce){
        .la *,
        .la *::before,
        .la *::after{
            transition-duration:.001ms !important;
            animation-duration:.001ms !important;
        }
    }


    /* =========================================================
       LEAD ACTION NOTE MODAL
       ========================================================= */

    .la-note-modal{
        border:0;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 24px 70px rgba(15,23,42,.18);
    }

    .la-note-modal .modal-header{
        padding:18px 20px;
        border-bottom:1px solid var(--la-line-soft);
        background:#fff;
    }

    .la-note-modal .modal-title{
        margin:3px 0 0;
        color:var(--la-ink-900);
        font-size:17px;
        font-weight:750;
    }

    .la-note-eyebrow{
        display:flex;
        align-items:center;
        gap:6px;
        color:var(--la-blue);
        font-size:10px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.5px;
    }

    .la-note-modal .modal-body{
        padding:20px;
        background:#fbfcfd;
    }

    .la-note-label{
        display:flex;
        align-items:center;
        gap:6px;
        margin-bottom:7px;
        color:var(--la-ink-700);
        font-size:11px;
        font-weight:700;
    }

    .la-note-label i{
        color:var(--la-blue);
    }

    .la-note-input{
        min-height:44px;
        border:1px solid #dde3e9;
        border-radius:10px;
        background:#fff;
        font-size:12px;
        box-shadow:none !important;
    }

    textarea.la-note-input{
        min-height:110px;
        resize:vertical;
        padding-top:11px;
    }

    .la-note-input:focus{
        border-color:#8bc6eb;
        box-shadow:0 0 0 3px var(--la-blue-50) !important;
    }

    .la-note-info{
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

    .la-note-info i{
        color:var(--la-blue);
        margin-top:1px;
    }

    .la-note-modal .modal-footer{
        padding:13px 20px;
        border-top:1px solid var(--la-line-soft);
        background:#fff;
    }

    .la-note-modal .modal-footer .btn{
        min-height:39px;
        border-radius:9px;
        font-size:11px;
        font-weight:700;
    }

    @media(max-width:575.98px){
        #leadActionUpdateNoteModal .modal-dialog{
            margin:10px;
        }

        .la-note-modal .modal-header{
            padding:15px 16px;
        }

        .la-note-modal .modal-body{
            padding:16px;
        }

        .la-note-modal .modal-footer{
            padding:12px 16px;
        }

        .la-note-modal .modal-footer .btn-primary{
            flex:1;
        }
    }

</style>
@endpush

@section('content')
<div class="la">

    {{-- =====================================================
         HEADER
         ===================================================== --}}
    <header class="la-card la-header">
        <div class="la-title">
            <h1>{{ get_phrase('Lead Actions') }}</h1>
            <p>{{ get_phrase('Complete activity and sales follow-up history across your leads') }}</p>
        </div>

        <div class="la-header-actions">
            <a href="{{ route('admin.leads.index') }}"
               class="la-btn">
                <i class="bi bi-arrow-left"></i>
                {{ get_phrase('Lead Management') }}
            </a>

            <a href="{{ route('admin.leads.index') }}"
               class="la-btn la-btn-primary">
                <i class="bi bi-people"></i>
                {{ get_phrase('View Leads') }}
            </a>
        </div>
    </header>

    {{-- =====================================================
         KPI
         ===================================================== --}}
    <section class="la-kpis">
        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-activity"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('Total Actions') }}</div>
                <div class="la-kpi-value">{{ number_format($totalActions ?? 0) }}</div>
            </div>
        </div>

        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-telephone-fill"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('Calls') }}</div>
                <div class="la-kpi-value">{{ number_format($callActions ?? 0) }}</div>
            </div>
        </div>

        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-whatsapp"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('WhatsApp') }}</div>
                <div class="la-kpi-value">{{ number_format($whatsappActions ?? 0) }}</div>
            </div>
        </div>

        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('Contacted') }}</div>
                <div class="la-kpi-value">{{ number_format($contactedActions ?? 0) }}</div>
            </div>
        </div>

        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('Follow Ups') }}</div>
                <div class="la-kpi-value">{{ number_format($followUpActions ?? 0) }}</div>
            </div>
        </div>

        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('Quotations') }}</div>
                <div class="la-kpi-value">{{ number_format($quotationActions ?? 0) }}</div>
            </div>
        </div>

        <div class="la-card la-kpi">
            <div class="la-kpi-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <div class="la-kpi-label">{{ get_phrase('Deals Closed') }}</div>
                <div class="la-kpi-value">{{ number_format($dealClosedActions ?? 0) }}</div>
            </div>
        </div>
    </section>

    {{-- =====================================================
         SEARCH + FILTERS
         ===================================================== --}}
    <section class="la-card la-command">
        <form method="GET" action="{{ url()->current() }}">

            <div class="la-command-row">
                <div class="la-search">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="{{ get_phrase('Search lead, phone, action, note or salesperson') }}">
                </div>

                <div class="la-command-actions">
                    <button type="submit"
                            class="la-icon-btn"
                            title="{{ get_phrase('Search') }}">
                        <i class="bi bi-arrow-right"></i>
                        <span>{{ get_phrase('Search') }}</span>
                    </button>

                    <button type="button"
                            id="leadActionFilterToggle"
                            class="la-icon-btn"
                            onclick="toggleLeadActionFilters()"
                            title="{{ get_phrase('Filters') }}">
                        <i class="bi bi-sliders"></i>
                        <span>{{ get_phrase('Filters') }}</span>
                    </button>
                </div>
            </div>

            <div id="leadActionFilters"
                 class="la-filters {{ request('action_type') || request('user_id') || request('from_date') || request('to_date') ? 'is-open' : '' }}">

                <div class="la-filter-grid">

                    <div class="la-field">
                        <label>{{ get_phrase('Action Type') }}</label>
                        <select name="action_type">
                            <option value="">{{ get_phrase('All Actions') }}</option>

                            @foreach($actionLabels as $value => $label)
                                <option value="{{ $value }}"
                                    {{ request('action_type') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(auth()->user()->hasRole('Admin'))
                        <div class="la-field">
                            <label>{{ get_phrase('Sales User') }}</label>
                            <select name="user_id">
                                <option value="">{{ get_phrase('All Users') }}</option>

                                @foreach($salesUsers ?? [] as $salesUser)
                                    <option value="{{ $salesUser->id }}"
                                        {{ (string) request('user_id') === (string) $salesUser->id ? 'selected' : '' }}>
                                        {{ $salesUser->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="la-field">
                        <label>{{ get_phrase('From Date') }}</label>
                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}">
                    </div>

                    <div class="la-field">
                        <label>{{ get_phrase('To Date') }}</label>
                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}">
                    </div>

                    <div class="la-filter-actions">
                        <button type="submit"
                                class="la-btn la-btn-primary">
                            {{ get_phrase('Apply') }}
                        </button>

                        <a href="{{ request()->url() }}"
                           class="la-btn">
                            {{ get_phrase('Reset') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    {{-- =====================================================
         ACTION TYPE SEGMENTS
         ===================================================== --}}
    <section class="la-card la-segments">
        <a href="{{ request()->fullUrlWithQuery(['action_type'=>null,'page'=>null]) }}"
           class="{{ !request('action_type') ? 'active' : '' }}">
            {{ get_phrase('All') }}
            <span class="la-segment-count">{{ $totalActions ?? 0 }}</span>
        </a>

        @foreach($actionLabels as $type => $label)
            <a href="{{ request()->fullUrlWithQuery(['action_type'=>$type,'page'=>null]) }}"
               class="{{ request('action_type') === $type ? 'active' : '' }}">
                <i class="bi {{ $actionIcons[$type] ?? 'bi-activity' }}"></i>
                {{ $label }}
                <span class="la-segment-count">{{ $actionCounts[$type] ?? 0 }}</span>
            </a>
        @endforeach
    </section>

    {{-- =====================================================
         LIST
         ===================================================== --}}
    <section class="la-card la-list-card">

        <div class="la-list-head">
            <h2>{{ get_phrase('Activity History') }}</h2>

            <span>
                {{ get_phrase('Showing') }}
                {{ $actions->firstItem() ?? 0 }}–{{ $actions->lastItem() ?? 0 }}
                {{ get_phrase('of') }}
                {{ $actions->total() ?? 0 }}
                {{ get_phrase('actions') }}
            </span>
        </div>

        {{-- DESKTOP --}}
        <div class="la-table-wrap">
            <table class="la-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ get_phrase('Lead') }}</th>
                        <th>{{ get_phrase('Contact') }}</th>
                        <th>{{ get_phrase('Action') }}</th>
                        <th>{{ get_phrase('Sales User') }}</th>
                        <th>{{ get_phrase('Note') }}</th>
                        <th>{{ get_phrase('Quotation') }}</th>
                        <th>{{ get_phrase('Call Count') }}</th>
                        <th>{{ get_phrase('Update Action') }}</th>
                        <th>{{ get_phrase('Date / Time') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($actions as $action)
                        @php
                            $type = $action->action_type;
                            $label = $action->action_label
                                ?: ($actionLabels[$type] ?? ucfirst(str_replace('_',' ', $type)));

                            $icon = $actionIcons[$type] ?? 'bi-activity';
                            $badgeClass = $actionClasses[$type] ?? 'la-muted';

                            $actionDate = $action->action_at ?: $action->created_at;

                            $quotationNumber = $action->quotation_id
                                ? 'QT-' . str_pad($action->quotation_id, 5, '0', STR_PAD_LEFT)
                                : null;
                        @endphp

                        <tr>
                            <td>
                                {{ ($actions->firstItem() ?? 1) + $loop->index }}
                                
                                 <div>
                                    <span class="badge bg-warning text-dark">
                                        #{{ $action->lead->id ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <div class="la-lead-name">
                                    {{ $action->lead->name ?? 'Deleted / Unknown Lead' }}
                                </div>

                                <div class="la-lead-phone">
                                    {{ $action->lead->phone ?? '-' }}
                                </div>
                            </td>

                            <td>
                                @php
                                    $desktopPhone = preg_replace('/[^0-9]/', '', $action->lead->phone ?? '');
                                    $desktopWhatsApp = $desktopPhone;

                                    if (strlen($desktopWhatsApp) === 10) {
                                        $desktopWhatsApp = '91' . $desktopWhatsApp;
                                    }
                                @endphp

                                @if($action->lead && $desktopPhone)
                                    <div class="la-contact-actions">
                                        <button type="button"
                                                class="la-contact-btn call"
                                                onclick="leadActionCall(
                                                    {{ $action->lead->id }},
                                                    '{{ $desktopPhone }}',
                                                    this
                                                )"
                                                title="{{ get_phrase('Call') }}">
                                            <i class="bi bi-telephone-fill"></i>
                                            {{ get_phrase('Call') }}
                                        </button>

                                        <button type="button"
                                                class="la-contact-btn whatsapp"
                                                onclick="leadActionWhatsApp(
                                                    {{ $action->lead->id }},
                                                    '{{ $desktopWhatsApp }}',
                                                    this
                                                )"
                                                title="{{ get_phrase('WhatsApp') }}">
                                            <i class="bi bi-whatsapp"></i>
                                            {{ get_phrase('WhatsApp') }}
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <span class="la-action-badge {{ $badgeClass }}">
                                    <i class="bi {{ $icon }}"></i>
                                    {{ $label }}
                                </span>
                            </td>

                            <td>
                                @if($action->user)
                                    <div class="la-user">
                                        <div class="la-avatar">
                                            {{ strtoupper(substr($action->user->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="la-user-name">
                                                {{ $action->user->name }}
                                            </div>

                                            <div class="la-user-role">
                                                {{ get_phrase('Sales Activity') }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>

                            <td>
                                <div class="la-note">
                                    {{ \Illuminate\Support\Str::limit($action->note ?: '-', 90) }}
                                </div>
                            </td>

                            <td>
                                @if($quotationNumber)
                                    <span class="la-quotation">
                                        <i class="bi bi-file-earmark-text"></i>
                                        {{ $quotationNumber }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <span class="la-action-badge la-call">
                                    <i class="bi bi-telephone-fill"></i>
                                    {{ $callCountsByLead[$action->lead_id] ?? 0 }}
                                </span>
                            </td>

                            <td>
                                <div class="la-update-wrap">
                                    <button type="button"
                                            class="la-update-toggle"
                                            onclick="toggleLeadActionUpdatePanel(
                                                'desktop-update-{{ $action->id }}',
                                                this
                                            )">
                                        <i class="bi bi-lightning-charge"></i>
                                        {{ get_phrase('Lead Actions') }}
                                        <i class="bi bi-chevron-down"></i>
                                    </button>

                                    <div class="la-update-panel"
                                         id="desktop-update-{{ $action->id }}"
                                         data-update-url="{{ route('admin.leads.actions.update', $action->id) }}">
                                        <div class="la-update-head">
                                            <span>{{ get_phrase('Update Lead Action') }}</span>
                                            <button type="button"
                                                    class="btn p-0 border-0 bg-transparent"
                                                    onclick="closeLeadActionUpdatePanel('desktop-update-{{ $action->id }}')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>

                                        <div class="la-update-grid">
                                            <button type="button" class="la-update-option"
                                                    onclick="openActionFollowUpModal({{ $action->lead_id }})">
                                                <i class="bi bi-arrow-repeat"></i>
                                                {{ get_phrase('Follow Up') }}
                                            </button>

                                            <button type="button" class="la-update-option"
                                                    onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'deal_close',
    'Deal Close',
    this
)">
                                                <i class="bi bi-check-circle"></i>
                                                {{ get_phrase('Deal Close') }}
                                            </button>

                                            <button type="button" class="la-update-option"
                                                    onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'not_interested',
    'Not Interested',
    this
)">
                                                <i class="bi bi-slash-circle"></i>
                                                {{ get_phrase('Not Interested') }}
                                            </button>

                                            <button type="button" class="la-update-option"
                                                    onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'not_contactable',
    'Not Contactable',
    this
)">
                                                <i class="bi bi-telephone-x"></i>
                                                {{ get_phrase('Not Contactable') }}
                                            </button>

                                            <button type="button" class="la-update-option"
                                                    onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'wrong_category',
    'Wrong Category',
    this
)">
                                                <i class="bi bi-diagram-2"></i>
                                                {{ get_phrase('Wrong Category') }}
                                            </button>

                                            <button type="button" class="la-update-option"
                                                    onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'out_of_area',
    'Out of Area',
    this
)">
                                                <i class="bi bi-geo-alt"></i>
                                                {{ get_phrase('Out of Area') }}
                                            </button>

                                            <button type="button" class="la-update-option"
                                                    onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'marketing_job',
    'Marketing / Job',
    this
)">
                                                <i class="bi bi-megaphone"></i>
                                                {{ get_phrase('Marketing / Job') }}
                                            </button>
                                            @if($action->lead)
                                                <button type="button" class="la-update-option" onclick="openActionTransferModal({{ $action->lead_id }})">
                                                    <i class="bi bi-arrow-left-right"></i> Transfer Lead
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="la-date">
                                    {{ optional($actionDate)->format('d M Y') }}

                                    <span class="la-time">
                                        {{ optional($actionDate)->format('h:i A') }}
                                    </span>
                                </span>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="la-empty">
                                    <div class="la-empty-icon">
                                        <i class="bi bi-activity"></i>
                                    </div>

                                    <h3>{{ get_phrase('No lead actions found') }}</h3>

                                    <p>
                                        {{ get_phrase('Activity will appear here when your sales team starts working on leads.') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="la-mobile-list">
            @forelse($actions as $action)
                @php
                    $type = $action->action_type;

                    $label = $action->action_label
                        ?: ($actionLabels[$type] ?? ucfirst(str_replace('_',' ', $type)));

                    $icon = $actionIcons[$type] ?? 'bi-activity';
                    $badgeClass = $actionClasses[$type] ?? 'la-muted';

                    $actionDate = $action->action_at ?: $action->created_at;

                    $quotationNumber = $action->quotation_id
                        ? 'QT-' . str_pad($action->quotation_id, 5, '0', STR_PAD_LEFT)
                        : null;

                    $mobilePhone = preg_replace('/[^0-9]/', '', $action->lead->phone ?? '');
                    $mobileWhatsApp = $mobilePhone;

                    if (strlen($mobileWhatsApp) === 10) {
                        $mobileWhatsApp = '91' . $mobileWhatsApp;
                    }
                @endphp

                <article class="la-mcard">
                    <div class="la-mcard-top">
                        <div class="la-mcard-lead">
                            <div class="la-mcard-name">
                                {{ $action->lead->name ?? 'Deleted / Unknown Lead' }}
                            </div>

                            <div class="la-mcard-phone">
                                {{ $action->lead->phone ?? '-' }}
                            </div>
                        </div>

                        <span class="la-action-badge {{ $badgeClass }}">
                            <i class="bi {{ $icon }}"></i>
                            {{ $label }}
                        </span>
                    </div>

                    @if($action->note)
                        <div class="la-mcard-note">
                            {{ $action->note }}
                        </div>
                    @endif

                    <div class="la-mcard-meta">
                        <span>
                            <i class="bi bi-calendar3"></i>
                            {{ optional($actionDate)->format('d M Y') }}
                        </span>

                        <span>
                            <i class="bi bi-clock"></i>
                            {{ optional($actionDate)->format('h:i A') }}
                        </span>

                        @if($quotationNumber)
                            <span>
                                <i class="bi bi-file-earmark-text"></i>
                                {{ $quotationNumber }}
                            </span>
                        @endif

                        <span>
                            <i class="bi bi-telephone-fill"></i>
                            {{ get_phrase('Calls') }}: {{ $callCountsByLead[$action->lead_id] ?? 0 }}
                        </span>
                    </div>

                    @if($action->lead && $mobilePhone)
                        <div class="la-mcard-contact-actions">
                            <button type="button"
                                    class="la-contact-btn call"
                                    onclick="leadActionCall(
                                        {{ $action->lead->id }},
                                        '{{ $mobilePhone }}',
                                        this
                                    )">
                                <i class="bi bi-telephone-fill"></i>
                                {{ get_phrase('Call') }}
                            </button>

                            <button type="button"
                                    class="la-contact-btn whatsapp"
                                    onclick="leadActionWhatsApp(
                                        {{ $action->lead->id }},
                                        '{{ $mobileWhatsApp }}',
                                        this
                                    )">
                                <i class="bi bi-whatsapp"></i>
                                {{ get_phrase('WhatsApp') }}
                            </button>
                        </div>
                    @endif

                    <div class="la-mobile-update">
                        <button type="button"
                                class="la-update-toggle"
                                onclick="toggleLeadActionUpdatePanel(
                                    'mobile-update-{{ $action->id }}',
                                    this
                                )">
                            <i class="bi bi-lightning-charge"></i>
                            {{ get_phrase('Lead Actions') }}
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div class="la-update-panel"
                             id="mobile-update-{{ $action->id }}"
                             data-update-url="{{ route('admin.leads.actions.update', $action->id) }}">
                            <div class="la-update-head">
                                <span>{{ get_phrase('Update Lead Action') }}</span>
                                <button type="button"
                                        class="btn p-0 border-0 bg-transparent"
                                        onclick="closeLeadActionUpdatePanel('mobile-update-{{ $action->id }}')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="la-update-grid">
                                <button type="button" class="la-update-option"
                                        onclick="openActionFollowUpModal({{ $action->lead_id }})">
                                    <i class="bi bi-arrow-repeat"></i>
                                    {{ get_phrase('Follow Up') }}
                                </button>

                                <button type="button" class="la-update-option"
                                        onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'deal_close',
    'Deal Close',
    this
)">
                                    <i class="bi bi-check-circle"></i>
                                    {{ get_phrase('Deal Close') }}
                                </button>

                                <button type="button" class="la-update-option"
                                        onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'not_interested',
    'Not Interested',
    this
)">
                                    <i class="bi bi-slash-circle"></i>
                                    {{ get_phrase('Not Interested') }}
                                </button>

                                <button type="button" class="la-update-option"
                                        onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'not_contactable',
    'Not Contactable',
    this
)">
                                    <i class="bi bi-telephone-x"></i>
                                    {{ get_phrase('Not Contactable') }}
                                </button>

                                <button type="button" class="la-update-option"
                                        onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'wrong_category',
    'Wrong Category',
    this
)">
                                    <i class="bi bi-diagram-2"></i>
                                    {{ get_phrase('Wrong Category') }}
                                </button>

                                <button type="button" class="la-update-option"
                                        onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'out_of_area',
    'Out of Area',
    this
)">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ get_phrase('Out of Area') }}
                                </button>

                                <button type="button" class="la-update-option"
                                        onclick="openLeadActionUpdateNoteModal(
    {{ $action->id }},
    {{ $action->lead_id }},
    @js($action->lead->name ?? 'Deleted / Unknown Lead'),
    'marketing_job',
    'Marketing / Job',
    this
)">
                                    <i class="bi bi-megaphone"></i>
                                    {{ get_phrase('Marketing / Job') }}
                                </button>
                                @if($action->lead)
                                    <button type="button" class="la-update-option" onclick="openActionTransferModal({{ $action->lead_id }})">
                                        <i class="bi bi-arrow-left-right"></i> Transfer Lead
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="la-mcard-bottom">
                        <div class="la-mcard-user">
                            @if($action->user)
                                <div class="la-avatar">
                                    {{ strtoupper(substr($action->user->name, 0, 1)) }}
                                </div>

                                <div>
                                    <div class="la-user-name">
                                        {{ $action->user->name }}
                                    </div>

                                    <div class="la-user-role">
                                        {{ get_phrase('Action by') }}
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">
                                    {{ get_phrase('System') }}
                                </span>
                            @endif
                        </div>

                        @if($quotationNumber)
                            <div class="la-mcard-quotation">
                                {{ $quotationNumber }}
                            </div>
                        @endif
                    </div>
                </article>

            @empty
                <div class="la-mcard">
                    <div class="la-empty">
                        <div class="la-empty-icon">
                            <i class="bi bi-activity"></i>
                        </div>

                        <h3>{{ get_phrase('No lead actions found') }}</h3>
                    </div>
                </div>
            @endforelse
        </div>

        @if($actions->hasPages())
            <div class="la-pagination">
                {{ $actions->withQueryString()->links() }}
            </div>
        @endif
    </section>
</div>

{{-- =========================================================
     UPDATE LEAD ACTION — LEAD NOTE MODAL
========================================================= --}}
<div class="modal fade"
     id="leadActionUpdateNoteModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content la-note-modal">

            <div class="modal-header">
                <div>
                    <div class="la-note-eyebrow">
                        <i class="bi bi-journal-text"></i>
                        {{ get_phrase('Lead Note Required') }}
                    </div>

                    <h5 class="modal-title"
                        id="leadActionUpdateModalTitle">
                        {{ get_phrase('Update Lead Action') }}
                    </h5>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <input type="hidden"
                       id="leadActionUpdateActionId">

                <input type="hidden"
                       id="leadActionUpdateLeadId">

                <input type="hidden"
                       id="leadActionUpdateActionType">

                <div class="mb-3">
                    <label class="la-note-label">
                        <i class="bi bi-person"></i>
                        {{ get_phrase('Lead') }}
                    </label>

                    <div id="leadActionUpdateLeadName"
                         class="form-control la-note-input"
                         style="display:flex;align-items:center;background:#f8fafc;font-weight:700;">
                        -
                    </div>
                </div>

                <div class="mb-3">
                    <label class="la-note-label">
                        <i class="bi bi-lightning-charge"></i>
                        {{ get_phrase('Selected Action') }}
                    </label>

                    <div id="leadActionUpdateActionLabel"
                         class="form-control la-note-input"
                         style="display:flex;align-items:center;background:#f8fafc;font-weight:700;">
                        -
                    </div>
                </div>

                <div class="mb-2">
                    <label for="leadActionUpdateNote"
                           class="la-note-label">
                        <i class="bi bi-chat-left-text"></i>
                        {{ get_phrase('Lead Note') }}
                        <span class="text-danger">*</span>
                    </label>

                    <textarea id="leadActionUpdateNote"
                              rows="5"
                              maxlength="2000"
                              class="form-control la-note-input"
                              placeholder="{{ get_phrase('Write lead note before continuing...') }}"></textarea>

                    <div id="leadActionUpdateNoteError"
                         class="text-danger mt-1"
                         style="display:none;font-size:10px;font-weight:600;">
                        {{ get_phrase('Lead Note is required.') }}
                    </div>
                </div>

                <div class="la-note-info">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        {{ get_phrase('Lead Action will be updated only after this Lead Note is saved.') }}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    {{ get_phrase('Cancel') }}
                </button>

                <button type="button"
                        id="leadActionUpdateNoteSubmitBtn"
                        class="btn btn-primary"
                        onclick="submitLeadActionUpdateNote()">
                    <i class="bi bi-check2-circle me-1"></i>
                    {{ get_phrase('Submit & Continue') }}
                </button>
            </div>

        </div>
    </div>
</div>

<section class="la-card" style="margin-top:16px;padding:18px">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="font-size:16px;font-weight:750;margin:0">Lead Transfer History</h2>
        <span class="text-muted" style="font-size:11px">Latest 100 records · follows selected date/user/search filters</span>
    </div>
    <div class="table-responsive"><table class="table table-sm align-middle">
        <thead><tr><th>Lead</th><th>From</th><th>To</th><th>By</th><th>Source</th><th>Reason</th><th>Date</th></tr></thead>
        <tbody>
        @forelse($transferHistory as $transfer)
            <tr><td>{{ $transfer->lead_name }}</td><td>{{ $transfer->old_name ?? 'Unassigned' }}</td>
                <td>{{ $transfer->new_name }}</td><td>{{ $transfer->actor_name }}</td>
                <td>{{ str_replace('_', ' ', ucfirst($transfer->source)) }}</td><td>{{ $transfer->reason ?: '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('d M Y, h:i A') }}</td></tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-3">No lead transfers in this view.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</section>

<div class="modal fade" id="leadScheduleTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 id="leadScheduleTransferTitle" class="modal-title">Lead</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <input type="hidden" id="leadScheduleTransferId">
            <div id="leadScheduleFields">
                <label for="leadScheduleDate" class="form-label">Follow Up Date &amp; Time</label>
                <input id="leadScheduleDate" type="datetime-local" class="form-control mb-3">
                <label for="leadSchedulePriority" class="form-label">Follow Up Category</label>
                <select id="leadSchedulePriority" class="form-select mb-3"><option value="">Select</option><option value="hot">Hot</option><option value="warm">Warm</option><option value="cold">Cold</option></select>
            </div>
            <label for="leadTransferTarget" class="form-label">Assign To</label>
            <select id="leadTransferTarget" class="form-select mb-3"><option value="">Keep current owner</option>
                @foreach($salesUsers ?? [] as $salesUser)<option value="{{ $salesUser->id }}">{{ $salesUser->name }}</option>@endforeach
            </select>
            <label for="leadScheduleReason" class="form-label">Remarks / Transfer Reason</label>
            <textarea id="leadScheduleReason" class="form-control" maxlength="2000" rows="3"></textarea>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="button" id="leadScheduleTransferSubmit" class="btn btn-primary" onclick="submitActionFollowUpOrTransfer()">Save</button></div>
    </div></div>
</div>

@endsection

@push('js')
<script>
    async function logDirectLeadAction(
        leadId,
        actionType
    ) {
        const response = await fetch(
            `{{ url('/admin/leads') }}/${leadId}/action`,
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
        } catch (e) {
            data = {};
        }

        if (!response.ok || data.status === false) {
            throw new Error(
                data.message ||
                'Unable to save lead action.'
            );
        }

        return data;
    }

    function leadActionCall(
        leadId,
        phone,
        button
    ) {
        if (!phone) {
            alert('Phone number not available.');
            return;
        }

        const cleanPhone = String(phone)
            .replace(/[^\d+]/g, '');

        if (!cleanPhone) {
            alert('Invalid phone number.');
            return;
        }

        /*
         * Open the device dialer immediately.
         * Logging happens separately in the background.
         */
        window.location.href = `tel:${cleanPhone}`;

        /*
         * Every click creates one separate "call" action.
         * This is what increases the per-lead call count.
         */
        fetch(
            `{{ url('/admin/leads') }}/${leadId}/action`,
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                body: JSON.stringify({
                    action_type: 'call',
                    note: 'Call initiated from Lead Actions page.'
                }),

                keepalive: true
            }
        )
        .then(async response => {
            let data = {};

            try {
                data = await response.json();
            } catch (e) {
                data = {};
            }

            if (!response.ok || data.status === false) {
                console.error(
                    'Call action could not be saved:',
                    data
                );
            }
        })
        .catch(error => {
            console.error(
                'Call logging error:',
                error
            );
        });
    }

    async function leadActionWhatsApp(
        leadId,
        whatsappPhone,
        button
    ) {
        if (!whatsappPhone) {
            return;
        }

        const originalHtml = button.innerHTML;

        button.disabled = true;
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"></span>
            WhatsApp
        `;

        try {
            await logDirectLeadAction(
                leadId,
                'whatsapp'
            );

            window.open(
                `https://wa.me/${whatsappPhone}`,
                '_blank'
            );

        } catch (error) {
            console.error(
                'WhatsApp action failed:',
                error
            );

            alert(
                error.message ||
                'Unable to log WhatsApp action.'
            );
        } finally {
            button.disabled = false;
            button.innerHTML = originalHtml;
        }
    }

    function isDesktopLeadActionUpdatePanel()
    {
        return window.matchMedia(
            '(min-width: 768px)'
        ).matches;
    }


    function resetLeadActionUpdatePanelPosition(
        panel
    )
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

        panel.style.width =
            '';
    }


    function findLeadActionUpdateToggle(
        panel
    )
    {
        if (!panel) {
            return null;
        }

        const wrapper =
            panel.closest(
                '.la-update-wrap'
            );

        return wrapper
            ? wrapper.querySelector(
                '.la-update-toggle'
            )
            : null;
    }


    function positionDesktopLeadActionUpdatePanel(
        button,
        panel
    )
    {
        if (
            !button
            ||
            !panel
            ||
            !isDesktopLeadActionUpdatePanel()
        ) {
            return;
        }


        const viewportPadding =
            12;

        const gap =
            8;


        const anchorRect =
            button.getBoundingClientRect();


        const panelWidth =
            Math.min(
                320,
                window.innerWidth -
                    (viewportPadding * 2)
            );


        panel.style.width =
            panelWidth + 'px';


        /*
         * Put panel at a measurable position first.
         */
        panel.style.left =
            '0px';

        panel.style.top =
            '0px';


        const panelHeight =
            panel.offsetHeight;


        /*
         * Align right edge of panel with right edge of
         * the Lead Actions button.
         */
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


        /*
         * Prefer opening below the button.
         */
        let top =
            anchorRect.bottom +
            gap;


        /*
         * Not enough room below:
         * open above the button.
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


    function closeAllLeadActionUpdatePanels(
        exceptPanel = null
    )
    {
        document
            .querySelectorAll(
                '.la-update-panel.is-open'
            )
            .forEach(function(openPanel) {

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


                resetLeadActionUpdatePanelPosition(
                    openPanel
                );


                const toggle =
                    findLeadActionUpdateToggle(
                        openPanel
                    );


                if (toggle) {
                    toggle.classList.remove(
                        'is-open'
                    );
                }

            });
    }


    function toggleLeadActionUpdatePanel(
        panelId,
        button
    )
    {
        const panel =
            document.getElementById(
                panelId
            );


        if (!panel) {
            return;
        }


        const willOpen =
            !panel.classList.contains(
                'is-open'
            );


        /*
         * Keep only one action popover open.
         */
        closeAllLeadActionUpdatePanels(
            panel
        );


        panel.classList.toggle(
            'is-open',
            willOpen
        );


        if (button) {

            button.classList.toggle(
                'is-open',
                willOpen
            );

        }


        if (!willOpen) {

            resetLeadActionUpdatePanelPosition(
                panel
            );

            return;
        }


        if (
            isDesktopLeadActionUpdatePanel()
        ) {

            /*
             * Wait for display:block before measuring.
             */
            window.requestAnimationFrame(
                function() {

                    positionDesktopLeadActionUpdatePanel(
                        button,
                        panel
                    );

                }
            );

        } else {

            /*
             * Mobile remains inline.
             */
            resetLeadActionUpdatePanelPosition(
                panel
            );
        }
    }


    function closeLeadActionUpdatePanel(
        panelId
    )
    {
        const panel =
            document.getElementById(
                panelId
            );


        if (!panel) {
            return;
        }


        panel.classList.remove(
            'is-open'
        );


        resetLeadActionUpdatePanelPosition(
            panel
        );


        const toggle =
            findLeadActionUpdateToggle(
                panel
            );


        if (toggle) {
            toggle.classList.remove(
                'is-open'
            );
        }
    }


    /*
     * Click outside → close.
     */
    document.addEventListener(
        'click',
        function(event) {

            if (
                event.target.closest(
                    '.la-update-panel'
                )
                ||
                event.target.closest(
                    '.la-update-toggle'
                )
            ) {
                return;
            }


            closeAllLeadActionUpdatePanels();

        }
    );


    /*
     * When the page/table scrolls, close the floating
     * popover so it never remains detached from its row.
     */
    window.addEventListener(
        'scroll',
        function() {

            if (
                isDesktopLeadActionUpdatePanel()
            ) {
                closeAllLeadActionUpdatePanels();
            }

        },
        true
    );


    /*
     * Close on viewport resize.
     */
    window.addEventListener(
        'resize',
        function() {

            closeAllLeadActionUpdatePanels();

        }
    );


    /*
     * Escape key → close.
     */
    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key ===
                'Escape'
            ) {
                closeAllLeadActionUpdatePanels();
            }

        }
    );



    /* =========================================================
       UPDATE LEAD ACTION — LEAD NOTE GATE
       Follow Up remains untouched.
       ========================================================= */

    let leadActionUpdateNoteModalInstance = null;
    let pendingLeadActionUpdateButton = null;


    function openLeadActionUpdateNoteModal(
        actionId,
        leadId,
        leadName,
        actionType,
        actionLabel,
        button
    ) {
        /*
         * Action came from the desktop floating menu.
         * Close that menu before showing Bootstrap modal.
         */
        closeAllLeadActionUpdatePanels();


        const modalElement =
            document.getElementById(
                'leadActionUpdateNoteModal'
            );

        if (!modalElement) {
            alert(
                'Lead Action Note modal not found.'
            );

            return;
        }


        pendingLeadActionUpdateButton =
            button;


        document
            .getElementById(
                'leadActionUpdateActionId'
            )
            .value =
                actionId;


        document
            .getElementById(
                'leadActionUpdateLeadId'
            )
            .value =
                leadId;


        document
            .getElementById(
                'leadActionUpdateActionType'
            )
            .value =
                actionType;


        document
            .getElementById(
                'leadActionUpdateLeadName'
            )
            .textContent =
                leadName || 'Unnamed Lead';


        document
            .getElementById(
                'leadActionUpdateActionLabel'
            )
            .textContent =
                actionLabel || 'Lead Action';


        document
            .getElementById(
                'leadActionUpdateModalTitle'
            )
            .textContent =
                actionLabel || 'Update Lead Action';


        const noteInput =
            document.getElementById(
                'leadActionUpdateNote'
            );


        const errorBox =
            document.getElementById(
                'leadActionUpdateNoteError'
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
            function () {
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


        leadActionUpdateNoteModalInstance =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        leadActionUpdateNoteModalInstance.show();


        modalElement.addEventListener(
            'shown.bs.modal',
            function focusUpdateLeadNote() {
                noteInput.focus();

                modalElement.removeEventListener(
                    'shown.bs.modal',
                    focusUpdateLeadNote
                );
            }
        );
    }


    async function submitLeadActionUpdateNote()
    {
        const actionId =
            document
                .getElementById(
                    'leadActionUpdateActionId'
                )
                .value;


        const leadId =
            document
                .getElementById(
                    'leadActionUpdateLeadId'
                )
                .value;


        const actionType =
            document
                .getElementById(
                    'leadActionUpdateActionType'
                )
                .value;


        const noteInput =
            document.getElementById(
                'leadActionUpdateNote'
            );


        const errorBox =
            document.getElementById(
                'leadActionUpdateNoteError'
            );


        const submitButton =
            document.getElementById(
                'leadActionUpdateNoteSubmitBtn'
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
            !actionId
            ||
            !leadId
            ||
            !actionType
            ||
            !pendingLeadActionUpdateButton
        ) {

            errorBox.style.display =
                'block';

            errorBox.textContent =
                'Lead Action information is missing.';

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
                aria-hidden="true">
            </span>

            Saving Note...
        `;


        try {

            /*
             * Use local current date/time for LeadNote.call_date.
             */

            const now =
                new Date();


            const pad =
                function (value) {
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
            | STEP 1 — SAVE IN EXISTING LeadNoteController
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
                                    leadId,

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
                            Array.isArray(firstError)
                            &&
                            firstError[0]
                        ) {
                            message =
                                firstError[0];
                        }
                    }

                } catch (e) {
                    // Keep default message.
                }


                throw new Error(
                    message
                );
            }


            /*
            |--------------------------------------------------------------------------
            | STEP 2 — NOW UPDATE THE EXISTING LEAD ACTION
            |--------------------------------------------------------------------------
            */

            submitButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                    aria-hidden="true">
                </span>

                Updating Lead...
            `;


            const actionUpdated =
                await updateExistingLeadAction(
                    actionId,
                    actionType,
                    pendingLeadActionUpdateButton
                );


            if (!actionUpdated) {

                throw new Error(
                    'Lead Note was saved, but Lead Action could not be updated.'
                );
            }


            if (
                leadActionUpdateNoteModalInstance
            ) {
                leadActionUpdateNoteModalInstance.hide();
            }


            pendingLeadActionUpdateButton =
                null;


        } catch (error) {

            console.error(
                'Lead Action update failed:',
                error
            );


            errorBox.style.display =
                'block';

            errorBox.textContent =
                error.message
                || 'Something went wrong.';


        } finally {

            submitButton.disabled =
                false;

            submitButton.innerHTML =
                originalHtml;
        }
    }


    async function updateExistingLeadAction(
        actionId,
        actionType,
        button
    ) {
        const panel =
            button.closest('.la-update-panel');

        if (!panel) {
            return false;
        }


        /*
         * Keep the panel available for its data-update-url and
         * button state, but remove it from view immediately.
         */
        panel.classList.remove(
            'is-open'
        );


        resetLeadActionUpdatePanelPosition(
            panel
        );


        const panelToggle =
            findLeadActionUpdateToggle(
                panel
            );


        if (panelToggle) {
            panelToggle.classList.remove(
                'is-open'
            );
        }


        const updateUrl =
            panel.dataset.updateUrl;

        if (!updateUrl) {
            alert('Lead action update URL is missing.');
            return false;
        }

        const originalHtml =
            button.innerHTML;

        panel
            .querySelectorAll('.la-update-option')
            .forEach(option => {
                option.disabled = true;
            });

        button.innerHTML = `
            <span class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"></span>
            Updating...
        `;

        try {
            const response =
                await fetch(
                    updateUrl,
                    {
                        method: 'PATCH',

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
                data =
                    await response.json();
            } catch (e) {
                data = {};
            }

            if (
                !response.ok ||
                data.status === false
            ) {
                throw new Error(
                    data.message ||
                    'Unable to update lead action.'
                );
            }

            /*
             * Reload because changing action_type affects:
             * KPI counts, segment counts, filters and badge.
             */
            window.location.reload();

            return true;

        } catch (error) {
            alert(
                error.message ||
                'Unable to update lead action.'
            );

            panel
                .querySelectorAll('.la-update-option')
                .forEach(option => {
                    option.disabled = false;
                });

            button.innerHTML =
                originalHtml;

            return false;
        }
    }

    function toggleLeadActionFilters() {
        const filters =
            document.getElementById(
                'leadActionFilters'
            );

        const button =
            document.getElementById(
                'leadActionFilterToggle'
            );

        if (!filters) {
            return;
        }

        const isOpen =
            filters.classList.toggle(
                'is-open'
            );

        if (button) {
            button.classList.toggle(
                'is-active',
                isOpen
            );
        }
    }

    let actionLeadMode = 'followup';
    function openActionFollowUpModal(leadId) { openActionLeadModal(leadId, 'followup'); }
    function openActionTransferModal(leadId) { openActionLeadModal(leadId, 'transfer'); }
    function openActionLeadModal(leadId, mode) {
        actionLeadMode = mode;
        document.getElementById('leadScheduleTransferId').value = leadId;
        document.getElementById('leadScheduleTransferTitle').textContent = mode === 'followup' ? 'Schedule Follow Up' : 'Transfer Lead';
        document.getElementById('leadScheduleFields').style.display = mode === 'followup' ? '' : 'none';
        document.getElementById('leadScheduleDate').value = '';
        document.getElementById('leadSchedulePriority').value = '';
        document.getElementById('leadTransferTarget').value = '';
        document.getElementById('leadScheduleReason').value = '';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('leadScheduleTransferModal')).show();
    }
    async function submitActionFollowUpOrTransfer() {
        const leadId = document.getElementById('leadScheduleTransferId').value;
        const userId = document.getElementById('leadTransferTarget').value;
        const reason = document.getElementById('leadScheduleReason').value.trim();
        const schedule = document.getElementById('leadScheduleDate').value;
        const priority = document.getElementById('leadSchedulePriority').value;
        if (actionLeadMode === 'transfer' && (!userId || !reason)) { alert('Select a Sales user and add a reason.'); return; }
        if (actionLeadMode === 'followup' && (!schedule || !priority)) { alert('Select a date/time and Hot, Warm or Cold.'); return; }
        const button = document.getElementById('leadScheduleTransferSubmit');
        button.disabled = true;
        try {
            const url = actionLeadMode === 'transfer'
                ? `{{ url('/admin/leads') }}/${leadId}/transfer`
                : `{{ url('/admin/leads') }}/${leadId}/follow-up`;
            const body = actionLeadMode === 'transfer'
                ? {user_id: userId, reason: reason}
                : {user_id: userId || null, remarks: reason, call_schedule: schedule, follow_up_priority: priority};
            const response = await fetch(url, {method:'POST',headers:{'Accept':'application/json','Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest'},body:JSON.stringify(body)});
            const result = await response.json();
            if (!response.ok || result.status === false) throw new Error(result.message || Object.values(result.errors || {})[0]?.[0] || 'Unable to save.');
            window.location.reload();
        } catch (error) { alert(error.message); button.disabled = false; }
    }
</script>
@endpush












