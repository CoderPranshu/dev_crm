@extends('index')

@push('title', 'Open Import File')

@section('content')

@php
    $fileType = strtolower($batch->file_type ?? pathinfo($batch->original_file_name ?? '', PATHINFO_EXTENSION));

    $isExcel = in_array($fileType, ['xlsx', 'xls']);
    $isCsv = in_array($fileType, ['csv', 'txt']);

    $columnLetter = function ($index) {
        $index = $index + 1;
        $letters = '';

        while ($index > 0) {
            $mod = ($index - 1) % 26;
            $letters = chr(65 + $mod) . $letters;
            $index = intdiv($index - 1, 26);
        }

        return $letters;
    };
@endphp


<div class="container-fluid import-file-viewer">

    {{-- =========================================================
        TOP HEADER
    ========================================================== --}}
    <div class="viewer-header">

        <div class="viewer-header-left">

            <a
                href="{{ route('admin.leads.import.history') }}"
                class="viewer-back-btn"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>


            <div class="viewer-file-heading">

                <div
                    class="
                        viewer-file-icon
                        {{ $isExcel ? 'excel' : 'csv' }}
                    "
                >
                    @if($isExcel)
                        <i class="bi bi-file-earmark-excel"></i>
                    @else
                        <i class="bi bi-filetype-csv"></i>
                    @endif
                </div>


                <div>

                    <div class="viewer-file-type-label">

                        @if($isExcel)
                            Microsoft Excel Spreadsheet
                        @else
                            CSV Data File
                        @endif

                    </div>

                    <h4 class="viewer-file-title">
                        {{ $batch->original_file_name }}
                    </h4>

                    <div class="viewer-file-meta">

                        <span>
                            {{ strtoupper($fileType ?: '-') }}
                        </span>

                        <span class="viewer-meta-dot"></span>

                        <span>
                            {{ count($previewRows) }}
                            of
                            {{ $totalRows }}
                            rows shown
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="viewer-header-actions">

            <a
                href="{{ route('admin.leads.import.history.download', $batch->id) }}"
                class="
                    viewer-download-btn
                    {{ $isExcel ? 'excel' : 'csv' }}
                "
            >
                <i class="bi bi-download"></i>

                <span>
                    Download Original
                </span>
            </a>

        </div>

    </div>


    {{-- =========================================================
        APP-LIKE TOOLBAR
    ========================================================== --}}
    <div
        class="
            viewer-toolbar
            {{ $isExcel ? 'excel' : 'csv' }}
        "
    >

        <div class="viewer-toolbar-brand">

            @if($isExcel)

                <div class="viewer-toolbar-logo excel">
                    X
                </div>

                <strong>
                    Excel Preview
                </strong>

            @else

                <div class="viewer-toolbar-logo csv">
                    CSV
                </div>

                <strong>
                    CSV Preview
                </strong>

            @endif

        </div>


        <div class="viewer-toolbar-menu">

            @if($isExcel)

                <span class="active">
                    Home
                </span>

                <span>
                    Insert
                </span>

                <span>
                    Data
                </span>

                <span>
                    View
                </span>

            @else

                <span class="active">
                    Data
                </span>

                <span>
                    Columns
                </span>

                <span>
                    Rows
                </span>

                <span>
                    Preview
                </span>

            @endif

        </div>


        <div class="viewer-toolbar-info">

            <i class="bi bi-table"></i>

            <span>
                {{ count($headers) }} columns
            </span>

        </div>

    </div>


    {{-- =========================================================
        FORMULA / FILE INFO BAR
    ========================================================== --}}
    @if($isExcel)

        <div class="excel-formula-bar">

            <div class="excel-name-box">
                A1
            </div>

            <div class="excel-fx">
                fx
            </div>

            <div class="excel-formula-input">
                {{ $headers[0] ?? '' }}
            </div>

        </div>

    @else

        <div class="csv-info-bar">

            <div class="csv-info-item">

                <i class="bi bi-braces"></i>

                <span>
                    Delimiter:
                </span>

                <strong>
                    Comma (,)
                </strong>

            </div>


            <div class="csv-info-item">

                <i class="bi bi-layout-three-columns"></i>

                <span>
                    Columns:
                </span>

                <strong>
                    {{ count($headers) }}
                </strong>

            </div>


            <div class="csv-info-item">

                <i class="bi bi-list-ol"></i>

                <span>
                    Rows:
                </span>

                <strong>
                    {{ $totalRows }}
                </strong>

            </div>

        </div>

    @endif


    {{-- =========================================================
        DATA SHEET
    ========================================================== --}}
    <div
        class="
            data-sheet-container
            {{ $isExcel ? 'excel-sheet' : 'csv-sheet' }}
        "
    >

        <div class="data-sheet-scroll">

            <table class="data-sheet-table">

                {{-- COLUMN LETTERS --}}
                @if($isExcel)

                    <thead>

                        <tr class="excel-column-letters">

                            <th class="excel-corner-cell">
                                <i class="bi bi-caret-down-fill"></i>
                            </th>

                            @foreach($headers as $index => $header)

                                <th>
                                    {{ $columnLetter($index) }}
                                </th>

                            @endforeach

                        </tr>


                        <tr class="excel-header-row">

                            <th class="excel-row-number">
                                1
                            </th>

                            @foreach($headers as $header)

                                <th>
                                    {{ $header ?: '-' }}
                                </th>

                            @endforeach

                        </tr>

                    </thead>

                @else

                    <thead>

                        <tr class="csv-header-row">

                            <th class="csv-row-number-head">
                                #
                            </th>

                            @foreach($headers as $index => $header)

                                <th>

                                    <div class="csv-header-cell">

                                        <span class="csv-column-index">
                                            C{{ $index + 1 }}
                                        </span>

                                        <span>
                                            {{ $header ?: '-' }}
                                        </span>

                                    </div>

                                </th>

                            @endforeach

                        </tr>

                    </thead>

                @endif


                <tbody>

                    @forelse($previewRows as $rowIndex => $row)

                        <tr>

                            {{-- ROW NUMBER --}}
                            <td
                                class="
                                    sheet-row-number
                                    {{ $isExcel ? 'excel-row-number' : 'csv-row-number' }}
                                "
                            >
                                {{ $isExcel ? $rowIndex + 2 : $rowIndex + 1 }}
                            </td>


                            @foreach($headers as $index => $header)

                                <td
                                    class="
                                        sheet-data-cell
                                        {{ $isExcel ? 'excel-data-cell' : 'csv-data-cell' }}
                                    "
                                >
                                    {{ $row[$index] ?? '' }}
                                </td>

                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ max(2, count($headers) + 1) }}"
                                class="viewer-empty"
                            >

                                <div class="viewer-empty-icon">

                                    @if($isExcel)
                                        <i class="bi bi-file-earmark-excel"></i>
                                    @else
                                        <i class="bi bi-filetype-csv"></i>
                                    @endif

                                </div>

                                <strong>
                                    No data rows found
                                </strong>

                                <span>
                                    This file does not contain previewable records.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
            BOTTOM SHEET BAR
        ====================================================== --}}
        <div
            class="
                sheet-bottom-bar
                {{ $isExcel ? 'excel' : 'csv' }}
            "
        >

            <div class="sheet-bottom-left">

                @if($isExcel)

                    <button
                        type="button"
                        class="sheet-nav-btn"
                    >
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <button
                        type="button"
                        class="sheet-nav-btn"
                    >
                        <i class="bi bi-chevron-right"></i>
                    </button>


                    <div class="excel-sheet-tab active">

                        <i class="bi bi-grid-3x3-gap"></i>

                        Sheet1

                    </div>


                    <button
                        type="button"
                        class="excel-sheet-add"
                    >
                        <i class="bi bi-plus-lg"></i>
                    </button>

                @else

                    <div class="csv-bottom-label">

                        <i class="bi bi-filetype-csv"></i>

                        Raw CSV Data

                    </div>

                @endif

            </div>


            <div class="sheet-bottom-right">

                <span>
                    Showing
                    {{ count($previewRows) }}
                    /
                    {{ $totalRows }}
                    rows
                </span>


                <span class="sheet-bottom-divider"></span>


                <span>
                    {{ count($headers) }}
                    columns
                </span>

            </div>

        </div>

    </div>

</div>


<style>

    /*
    |--------------------------------------------------------------------------
    | BASE
    |--------------------------------------------------------------------------
    */

    .import-file-viewer {

        --viewer-border: #dfe4ea;
        --viewer-text: #202124;
        --viewer-muted: #6b7280;

        padding-bottom: 30px;
    }


    .import-file-viewer * {
        box-sizing: border-box;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    .viewer-header {
        margin-bottom: 15px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        flex-wrap: wrap;
    }


    .viewer-header-left {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 15px;
    }


    .viewer-back-btn {
        width: 38px;
        height: 38px;

        border: 1px solid #e5e7eb;
        border-radius: 9px;

        background: #fff;
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        text-decoration: none;

        box-shadow: 0 1px 2px rgba(16, 24, 40, .03);
    }


    .viewer-back-btn span {
        display: none;
    }


    .viewer-back-btn:hover {
        background: #f8fafc;
        color: #111827;
    }


    .viewer-file-heading {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 11px;
    }


    .viewer-file-icon {
        width: 46px;
        height: 46px;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 20px;
    }


    .viewer-file-icon.excel {
        background: #e8f5ee;
        color: #107c41;

        border: 1px solid #cfe9da;
    }


    .viewer-file-icon.csv {
        background: #eaf6fb;
        color: #087ea4;

        border: 1px solid #cfe9f3;
    }


    .viewer-file-type-label {
        color: #98a2b3;

        font-size: 9px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .06em;
    }


    .viewer-file-title {
        max-width: 680px;

        margin: 2px 0 3px;

        color: #1f2937;

        font-size: 18px;
        font-weight: 700;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    .viewer-file-meta {
        display: flex;
        align-items: center;

        gap: 6px;

        color: #8a94a6;

        font-size: 10px;
    }


    .viewer-meta-dot {
        width: 3px;
        height: 3px;

        border-radius: 50%;

        background: #c4cbd5;
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD
    |--------------------------------------------------------------------------
    */

    .viewer-download-btn {
        min-height: 39px;

        padding: 0 14px;

        border-radius: 8px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        text-decoration: none;

        font-size: 11px;
        font-weight: 650;
    }


    .viewer-download-btn.excel {
        background: #107c41;
        color: #fff;

        border: 1px solid #0d6937;
    }


    .viewer-download-btn.csv {
        background: #087ea4;
        color: #fff;

        border: 1px solid #076d8e;
    }


    .viewer-download-btn:hover {
        color: #fff;

        filter: brightness(1.05);
    }


    /*
    |--------------------------------------------------------------------------
    | TOOLBAR
    |--------------------------------------------------------------------------
    */

    .viewer-toolbar {
        min-height: 48px;

        padding: 0 14px;

        border: 1px solid var(--viewer-border);
        border-bottom: none;

        display: flex;
        align-items: center;

        gap: 20px;
    }


    .viewer-toolbar.excel {
        background: #107c41;
        color: #fff;
    }


    .viewer-toolbar.csv {
        background: #0d718a;
        color: #fff;
    }


    .viewer-toolbar-brand {
        display: flex;
        align-items: center;

        gap: 8px;

        font-size: 12px;
    }


    .viewer-toolbar-logo {
        min-width: 27px;
        height: 27px;

        padding: 0 5px;

        border-radius: 5px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 10px;
        font-weight: 800;
    }


    .viewer-toolbar-logo.excel {
        background: rgba(255, 255, 255, .18);
    }


    .viewer-toolbar-logo.csv {
        background: rgba(255, 255, 255, .18);
    }


    .viewer-toolbar-menu {
        display: flex;
        align-items: center;

        gap: 19px;

        font-size: 10px;
        font-weight: 500;
    }


    .viewer-toolbar-menu span {
        position: relative;

        opacity: .86;

        cursor: default;
    }


    .viewer-toolbar-menu span.active {
        opacity: 1;

        font-weight: 700;
    }


    .viewer-toolbar-menu span.active::after {
        content: "";

        position: absolute;

        left: 0;
        right: 0;
        bottom: -15px;

        height: 2px;

        background: #fff;
    }


    .viewer-toolbar-info {
        margin-left: auto;

        display: flex;
        align-items: center;

        gap: 6px;

        font-size: 9px;

        opacity: .9;
    }


    /*
    |--------------------------------------------------------------------------
    | EXCEL FORMULA BAR
    |--------------------------------------------------------------------------
    */

    .excel-formula-bar {
        min-height: 36px;

        border: 1px solid #d7dce2;
        border-bottom: none;

        background: #f8f9fa;

        display: flex;
        align-items: center;
    }


    .excel-name-box {
        width: 70px;

        align-self: stretch;

        border-right: 1px solid #d7dce2;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #4b5563;

        font-size: 10px;
    }


    .excel-fx {
        width: 40px;

        align-self: stretch;

        border-right: 1px solid #d7dce2;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #64748b;

        font-style: italic;
        font-size: 11px;
        font-weight: 700;
    }


    .excel-formula-input {
        flex: 1;

        padding: 0 10px;

        color: #374151;

        font-size: 10px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /*
    |--------------------------------------------------------------------------
    | CSV INFO BAR
    |--------------------------------------------------------------------------
    */

    .csv-info-bar {
        min-height: 38px;

        padding: 0 13px;

        border: 1px solid #dce5ea;
        border-bottom: none;

        background: #f7fbfd;

        display: flex;
        align-items: center;

        gap: 22px;

        color: #607080;
    }


    .csv-info-item {
        display: flex;
        align-items: center;

        gap: 5px;

        font-size: 9px;
    }


    .csv-info-item i {
        color: #087ea4;
    }


    .csv-info-item strong {
        color: #344054;
    }


    /*
    |--------------------------------------------------------------------------
    | SHEET CONTAINER
    |--------------------------------------------------------------------------
    */

    .data-sheet-container {
        border: 1px solid var(--viewer-border);

        background: #fff;

        box-shadow:
            0 1px 2px rgba(16, 24, 40, .03),
            0 5px 15px rgba(16, 24, 40, .04);
    }


    .data-sheet-scroll {
        width: 100%;

        overflow: auto;

        max-height: 66vh;
    }


    .data-sheet-table {
        min-width: 100%;

        width: max-content;

        border-collapse: separate;
        border-spacing: 0;

        table-layout: auto;

        color: #202124;

        font-size: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | EXCEL GRID
    |--------------------------------------------------------------------------
    */

    .excel-column-letters th {
        position: sticky;
        top: 0;

        z-index: 5;

        min-width: 110px;
        height: 24px;

        padding: 3px 7px;

        border-right: 1px solid #d5d9de;
        border-bottom: 1px solid #cdd1d6;

        background: #f3f3f3;
        color: #555;

        text-align: center;

        font-size: 9px;
        font-weight: 500;
    }


    .excel-column-letters .excel-corner-cell {
        min-width: 42px;
        width: 42px;

        left: 0;

        z-index: 7;

        color: #9aa0a6;
    }


    .excel-header-row th {
        position: sticky;
        top: 24px;

        z-index: 4;

        min-width: 110px;
        max-width: 250px;
        height: 30px;

        padding: 6px 8px;

        border-right: 1px solid #d5d9de;
        border-bottom: 1px solid #cdd1d6;

        background: #ffffff;
        color: #202124;

        text-align: left;

        font-weight: 600;

        white-space: nowrap;
    }


    .excel-header-row .excel-row-number {
        position: sticky;
        left: 0;
        top: 24px;

        z-index: 8;

        width: 42px;
        min-width: 42px;

        background: #f3f3f3;

        text-align: center;

        font-weight: 500;
    }


    .excel-row-number {
        position: sticky;
        left: 0;

        z-index: 3;

        width: 42px;
        min-width: 42px;

        padding: 5px;

        border-right: 1px solid #cdd1d6;
        border-bottom: 1px solid #d9dde1;

        background: #f3f3f3;
        color: #5f6368;

        text-align: center;

        font-size: 9px;
    }


    .excel-data-cell {
        min-width: 110px;
        max-width: 280px;

        padding: 5px 8px;

        border-right: 1px solid #e0e3e7;
        border-bottom: 1px solid #e0e3e7;

        background: #fff;

        color: #202124;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    .excel-sheet tbody tr:hover .excel-data-cell {
        background: #f7fbf8;
    }


    .excel-sheet tbody tr:hover .excel-row-number {
        background: #e7f2eb;
    }


    /*
    |--------------------------------------------------------------------------
    | CSV GRID
    |--------------------------------------------------------------------------
    */

    .csv-header-row th {
        position: sticky;
        top: 0;

        z-index: 4;

        min-width: 140px;

        padding: 8px 10px;

        border-right: 1px solid #d8e6ec;
        border-bottom: 1px solid #cddde4;

        background: #eaf6fa;
        color: #12465a;

        text-align: left;

        white-space: nowrap;
    }


    .csv-header-row .csv-row-number-head {
        position: sticky;
        left: 0;

        z-index: 7;

        width: 50px;
        min-width: 50px;

        background: #dceff5;

        text-align: center;
    }


    .csv-header-cell {
        display: flex;
        align-items: center;

        gap: 7px;
    }


    .csv-column-index {
        min-width: 24px;
        height: 20px;

        padding: 0 5px;

        border-radius: 4px;

        background: #d5ebf2;
        color: #087ea4;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        font-size: 8px;
        font-weight: 800;
    }


    .csv-row-number {
        position: sticky;
        left: 0;

        z-index: 3;

        width: 50px;
        min-width: 50px;

        padding: 7px;

        border-right: 1px solid #d8e6ec;
        border-bottom: 1px solid #e3edf1;

        background: #f4fafc;
        color: #6c8792;

        text-align: center;

        font-size: 9px;
        font-weight: 600;
    }


    .csv-data-cell {
        min-width: 140px;
        max-width: 320px;

        padding: 7px 10px;

        border-right: 1px solid #e3edf1;
        border-bottom: 1px solid #e3edf1;

        background: #fff;

        color: #344054;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    .csv-sheet tbody tr:nth-child(even) .csv-data-cell {
        background: #fbfdfe;
    }


    .csv-sheet tbody tr:hover .csv-data-cell {
        background: #f2f9fc;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY
    |--------------------------------------------------------------------------
    */

    .viewer-empty {
        padding: 55px 20px !important;

        text-align: center;

        background: #fff;
    }


    .viewer-empty-icon {
        width: 48px;
        height: 48px;

        margin: 0 auto 10px;

        border-radius: 12px;

        background: #f1f5f9;
        color: #64748b;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 19px;
    }


    .viewer-empty strong {
        display: block;

        color: #344054;

        font-size: 12px;
    }


    .viewer-empty span {
        display: block;

        margin-top: 4px;

        color: #98a2b3;

        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | BOTTOM BAR
    |--------------------------------------------------------------------------
    */

    .sheet-bottom-bar {
        min-height: 37px;

        padding: 0 9px;

        border-top: 1px solid #d7dce2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;
    }


    .sheet-bottom-bar.excel {
        background: #f3f3f3;
    }


    .sheet-bottom-bar.csv {
        background: #f7fbfd;
    }


    .sheet-bottom-left,
    .sheet-bottom-right {
        display: flex;
        align-items: center;

        gap: 6px;
    }


    .sheet-nav-btn {
        width: 25px;
        height: 25px;

        padding: 0;

        border: none;

        background: transparent;
        color: #60646c;

        display: flex;
        align-items: center;
        justify-content: center;
    }


    .excel-sheet-tab {
        min-width: 86px;
        height: 31px;

        padding: 0 10px;

        border-bottom: 3px solid transparent;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        color: #444;

        font-size: 9px;
    }


    .excel-sheet-tab.active {
        border-bottom-color: #107c41;

        background: #fff;

        color: #107c41;

        font-weight: 700;
    }


    .excel-sheet-add {
        width: 25px;
        height: 25px;

        padding: 0;

        border: 1px solid transparent;
        border-radius: 4px;

        background: transparent;
        color: #475467;

        display: flex;
        align-items: center;
        justify-content: center;
    }


    .excel-sheet-add:hover {
        background: #e9ecef;
    }


    .csv-bottom-label {
        display: flex;
        align-items: center;

        gap: 6px;

        color: #087ea4;

        font-size: 9px;
        font-weight: 700;
    }


    .sheet-bottom-right {
        color: #7c8799;

        font-size: 8px;
    }


    .sheet-bottom-divider {
        width: 1px;
        height: 14px;

        background: #d8dde3;
    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .viewer-header {
            align-items: flex-start;
        }


        .viewer-header-left {
            width: 100%;

            align-items: flex-start;
        }


        .viewer-file-title {
            max-width: 220px;

            font-size: 15px;
        }


        .viewer-header-actions {
            width: 100%;
        }


        .viewer-download-btn {
            width: 100%;
        }


        .viewer-toolbar {
            overflow-x: auto;

            gap: 13px;
        }


        .viewer-toolbar-menu {
            gap: 13px;

            white-space: nowrap;
        }


        .viewer-toolbar-info {
            display: none;
        }


        .csv-info-bar {
            overflow-x: auto;

            white-space: nowrap;
        }


        .data-sheet-scroll {
            max-height: 62vh;
        }


        .sheet-bottom-bar {
            align-items: flex-start;

            flex-direction: column;

            padding-top: 6px;
            padding-bottom: 6px;
        }

    }

</style>

@endsection


