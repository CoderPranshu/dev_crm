@extends('index')

@push('title', get_phrase('Lead Import History'))

@section('content')

<div class="container-fluid lead-import-history-page">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="cs-page-header mb-4">

        <nav class="cs-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('admin.leads.index') }}">Leads</a>
            <i class="bi bi-chevron-right"></i>
            <span>Import History</span>
        </nav>

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mt-2">

            <div class="cs-header-copy">

                <span class="cs-eyebrow">Data Management / Import Operations</span>

                <h4 class="cs-page-title mb-1">
                    Lead Import History
                </h4>

                <p class="import-page-subtitle mb-0">
                    Monitor uploaded lead files, processing status, imported records and assignment activity.
                </p>

            </div>


            <div class="d-flex align-items-center gap-2 flex-wrap">

                <a
                    href="{{ route('admin.leads.index') }}"
                    class="btn import-header-btn"
                >
                    <i class="bi bi-arrow-left"></i>
                    Back to Leads
                </a>


                @can('lead-create')

                    <button
                        type="button"
                        class="btn btn-primary import-header-primary-btn"
                        onclick="showRightModal(
                            '{{ route('right_modal', ['view_path' => 'admin/leads/import']) }}',
                            '{{ get_phrase('Import Leads') }}'
                        )"
                    >
                        <i class="bi bi-upload"></i>
                        New Import
                    </button>

                @endcan

            </div>

        </div>

    </div>


    {{-- =========================================================
        FLASH MESSAGES
    ========================================================== --}}

    @if(session('success_message'))

        <div class="alert alert-success import-alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success_message') }}
        </div>

    @endif


    @if(session('error_message'))

        <div class="alert alert-danger import-alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error_message') }}
        </div>

    @endif


    {{-- =========================================================
        IMPORT HEALTH — KPI STRIP
    ========================================================== --}}

    @php
        $csSuccessRate =
            ($totalImports ?? 0) > 0
                ? round((($completedImports ?? 0) / max(1, $totalImports)) * 100, 1)
                : 0;
    @endphp

    <div class="cs-kpi-strip mb-4">

        {{-- TOTAL --}}
        <div class="cs-kpi-card">

            <div class="cs-kpi-top">

                <span class="cs-kpi-label">Total Imports</span>

                <div class="cs-kpi-icon cs-kpi-icon-neutral">
                    <i class="bi bi-files"></i>
                </div>

            </div>

            <div class="cs-kpi-number">
                {{ number_format($totalImports ?? 0) }}
            </div>

            <div class="cs-kpi-desc">
                All uploaded lead files
            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="cs-kpi-card">

            <div class="cs-kpi-top">

                <span class="cs-kpi-label">Completed</span>

                <div class="cs-kpi-icon cs-kpi-icon-success">
                    <i class="bi bi-check-circle"></i>
                </div>

            </div>

            <div class="cs-kpi-number cs-kpi-number-success">
                {{ number_format($completedImports ?? 0) }}
            </div>

            <div class="cs-kpi-desc">
                {{ $csSuccessRate }}% success rate
            </div>

        </div>


        {{-- PENDING --}}
        <div class="cs-kpi-card">

            <div class="cs-kpi-top">

                <span class="cs-kpi-label">Pending</span>

                <div class="cs-kpi-icon cs-kpi-icon-warning">
                    <i class="bi bi-clock"></i>
                </div>

            </div>

            <div class="cs-kpi-number cs-kpi-number-warning">
                {{ number_format($pendingImports ?? 0) }}
            </div>

            <div class="cs-kpi-desc">
                Awaiting processing
            </div>

        </div>


        {{-- FAILED --}}
        <div class="cs-kpi-card">

            <div class="cs-kpi-top">

                <span class="cs-kpi-label">Failed</span>

                <div class="cs-kpi-icon cs-kpi-icon-danger">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

            </div>

            <div class="cs-kpi-number cs-kpi-number-danger">
                {{ number_format($failedImports ?? 0) }}
            </div>

            <div class="cs-kpi-desc">
                Requires attention
            </div>

        </div>

    </div>


    {{-- =========================================================
        FILTER TOOLBAR
    ========================================================== --}}

    @php
        $activeImportFilterCount = collect([
            request('search'),
            request('status'),
            request('category_id'),
            request('sales_user_id'),
        ])->filter(function ($value) {
            return $value !== null && $value !== '';
        })->count();

        $importFiltersActive = $activeImportFilterCount > 0;
    @endphp

    <div
        id="importFilterPanel"
        class="import-filter-collapse {{ $importFiltersActive ? 'is-open' : '' }}"
    >
    <div class="import-panel mb-4">

        <div class="import-panel-header">

            <div>

                <h5 class="import-panel-title">
                    Import Filters
                </h5>

                <p class="import-panel-subtitle">
                    Search and filter uploaded lead files
                </p>

            </div>

        </div>


        <form
            method="GET"
            action="{{ route('admin.leads.import.history') }}"
            class="import-filter-form"
        >

            <div class="row g-3 align-items-end">

                {{-- FILE SEARCH --}}
                <div class="col-xl-4 col-lg-4 col-md-6">

                    <label class="eForm-label">
                        File Name
                    </label>

                    <div class="import-input-wrap">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control eForm-control import-search-input"
                            placeholder="Search uploaded file..."
                        >

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="col-xl-2 col-lg-2 col-md-6">

                    <label class="eForm-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-control eForm-control"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="completed"
                            {{ request('status') === 'completed' ? 'selected' : '' }}
                        >
                            Completed
                        </option>

                        <option
                            value="pending"
                            {{ request('status') === 'pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="failed"
                            {{ request('status') === 'failed' ? 'selected' : '' }}
                        >
                            Failed
                        </option>

                    </select>

                </div>


                {{-- CATEGORY --}}
                <div class="col-xl-2 col-lg-3 col-md-6">

                    <label class="eForm-label">
                        Category
                    </label>

                    <select
                        name="category_id"
                        class="form-control eForm-control"
                    >

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories ?? [] as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}
                            >
                                {{ $category->title }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- SALES PERSON --}}
                @if(auth()->user()->hasRole('Admin'))

                    <div class="col-xl-2 col-lg-3 col-md-6">

                        <label class="eForm-label">
                            Sales Person
                        </label>

                        <select
                            name="sales_user_id"
                            class="form-control eForm-control"
                        >

                            <option value="">
                                All Sales
                            </option>

                            @foreach($salesUsers ?? [] as $salesUser)

                                <option
                                    value="{{ $salesUser->id }}"
                                    {{ (string) request('sales_user_id') === (string) $salesUser->id ? 'selected' : '' }}
                                >
                                    {{ $salesUser->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                @endif


                {{-- FILTER BUTTONS --}}
                <div class="col-xl-2 col-lg-3 col-md-6">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary import-filter-btn"
                        >
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>


                        <a
                            href="{{ route('admin.leads.import.history') }}"
                            class="btn import-reset-btn"
                            title="Reset Filters"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>
    </div>


    {{-- =========================================================
        IMPORT HISTORY
    ========================================================== --}}

    <div class="import-panel">

        {{-- PANEL HEADER --}}
        <div class="import-panel-header">

            <div>

                <h5 class="import-panel-title">
                    Upload History
                </h5>

                <p class="import-panel-subtitle">

                    {{ number_format($batches->total() ?? 0) }}

                    {{ ($batches->total() ?? 0) == 1 ? 'import record' : 'import records' }}

                </p>

            </div>


            <div class="import-history-header-actions">

                <div class="import-history-label">
                    <i class="bi bi-clock-history"></i>
                    Recent first
                </div>

                <button
                    type="button"
                    id="importFilterToggle"
                    class="import-filter-toggle {{ $importFiltersActive ? 'is-active' : '' }}"
                    aria-controls="importFilterPanel"
                    aria-expanded="{{ $importFiltersActive ? 'true' : 'false' }}"
                    onclick="toggleImportFilters()"
                >
                    <i class="bi bi-funnel"></i>
                    <span>Filters</span>

                    @if($activeImportFilterCount > 0)
                        <span class="import-filter-count">
                            {{ $activeImportFilterCount }}
                        </span>
                    @endif

                    <i class="bi bi-chevron-down import-filter-toggle-chevron"></i>
                </button>

            </div>

        </div>


        {{-- =====================================================
            CARD GRID
        ====================================================== --}}

        <div class="import-history-grid">

            @forelse($batches as $batch)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    $batchStatus = strtolower(
                        $batch->status ?? 'pending'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | FILE SIZE
                    |--------------------------------------------------------------------------
                    */

                    $fileSize = (int) ($batch->file_size ?? 0);

                    if ($fileSize >= 1048576) {

                        $formattedFileSize =
                            number_format(
                                $fileSize / 1048576,
                                2
                            ) . ' MB';

                    } elseif ($fileSize >= 1024) {

                        $formattedFileSize =
                            number_format(
                                $fileSize / 1024,
                                2
                            ) . ' KB';

                    } elseif ($fileSize > 0) {

                        $formattedFileSize =
                            $fileSize . ' B';

                    } else {

                        $formattedFileSize = '-';

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ROW COUNTS
                    |--------------------------------------------------------------------------
                    */

                    $totalRows =
                        (int) ($batch->total_rows ?? 0);

                    $importedRows =
                        (int) ($batch->imported_rows ?? 0);

                    $skippedRows =
                        (int) ($batch->skipped_rows ?? 0);


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS PERCENTAGE
                    |--------------------------------------------------------------------------
                    */

                    $successPercentage =
                        $totalRows > 0
                            ? round(
                                ($importedRows / $totalRows) * 100
                            )
                            : 0;

                    $successPercentage =
                        min(
                            100,
                            max(
                                0,
                                $successPercentage
                            )
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | FILE TYPE
                    |--------------------------------------------------------------------------
                    */

                    $fileType =
                        strtolower(
                            $batch->file_type ?? ''
                        );

                @endphp


                <article class="import-history-card">


                    {{-- =================================================
                        CARD HEADER
                    ================================================== --}}

                    <div class="import-card-top">

                        <div class="import-card-file-area">

                            {{-- FILE ICON --}}
                            <div
                                class="
                                    import-card-file-icon
                                    {{ in_array($fileType, ['xlsx', 'xls']) ? 'excel-file-icon' : 'csv-file-icon' }}
                                "
                            >

                                @if(in_array($fileType, ['xlsx', 'xls']))

                                    <i class="bi bi-file-earmark-excel"></i>

                                @else

                                    <i class="bi bi-file-earmark-text"></i>

                                @endif

                            </div>


                            {{-- FILE INFORMATION --}}
                            <div class="import-card-file-copy">

                                <div class="import-card-id">

                                    IMPORT #{{ $batch->id }}

                                </div>


                                <h5
                                    class="import-card-file-name"
                                    title="{{ $batch->original_file_name }}"
                                >

                                    {{ $batch->original_file_name }}

                                </h5>


                                <div class="import-card-file-meta">

                                    <span>
                                        {{ strtoupper($batch->file_type ?? '-') }}
                                    </span>

                                    <span class="import-meta-dot"></span>

                                    <span>
                                        {{ $formattedFileSize }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- RIGHT SIDE --}}
                        <div class="import-card-top-right">


                            {{-- STATUS --}}
                            @if($batchStatus === 'completed')

                                <span class="import-status import-status-success">

                                    <span class="import-status-dot"></span>

                                    Completed

                                </span>


                            @elseif($batchStatus === 'failed')

                                <span class="import-status import-status-danger">

                                    <span class="import-status-dot"></span>

                                    Failed

                                </span>


                            @else

                                <span class="import-status import-status-warning">

                                    <span class="import-status-dot"></span>

                                    Pending

                                </span>

                            @endif


                            {{-- MORE ACTION --}}
                            <div class="dropdown">

                                <button
                                    type="button"
                                    class="import-action-btn"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>


                                <ul class="dropdown-menu dropdown-menu-end import-action-menu">

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            disabled
                                        >

                                            <i class="bi bi-people"></i>

                                            View Leads

                                        </button>

                                    </li>


                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            disabled
                                        >

                                            <i class="bi bi-eye"></i>

                                            Open File

                                        </button>

                                    </li>


                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            disabled
                                        >

                                            <i class="bi bi-download"></i>

                                            Download File

                                        </button>

                                    </li>


                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>


                                    <li>

                                       <button
                                            type="button"
                                            class="dropdown-item text-danger"
                                            onclick="confirmImportDelete(
                                                {{ $batch->id }},
                                                @js($batch->original_file_name),
                                                {{ (int) $batch->imported_rows }}
                                            )"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Delete Import
                                        </button>

                                    </li>

                                </ul>

                                <form
                                    id="delete-import-form-{{ $batch->id }}"
                                    action="{{ route('admin.leads.import.history.delete', $batch->id) }}"
                                    method="POST"
                                    class="d-none"
                                >
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        UPLOAD DATE
                    ================================================== --}}

                    <div class="import-card-upload-date">

                        <i class="bi bi-calendar3"></i>

                        @if($batch->created_at)

                            <span>
                                Uploaded
                            </span>

                            <strong>
                                {{ $batch->created_at->format('d M Y') }}
                            </strong>

                            <span>
                                at
                            </span>

                            <strong>
                                {{ $batch->created_at->format('h:i A') }}
                            </strong>

                        @else

                            <span>
                                Upload date unavailable
                            </span>

                        @endif

                    </div>


                    {{-- =================================================
                        ASSIGNMENT INFORMATION
                    ================================================== --}}

                    <div class="import-card-info-grid">


                        {{-- CATEGORY --}}
                        <div class="import-card-info-box">

                            <div class="import-info-icon">

                                <i class="bi bi-tag"></i>

                            </div>


                            <div class="import-info-copy">

                                <span class="import-info-label">
                                    Lead Category
                                </span>

                                <strong
                                    class="import-info-value"
                                    title="{{ $batch->category->title ?? '-' }}"
                                >

                                    {{ $batch->category->title ?? '-' }}

                                </strong>

                            </div>

                        </div>


                        {{-- SALES PERSON --}}
                        <div class="import-card-info-box">

                            <div class="import-info-icon">

                                <i class="bi bi-person-check"></i>

                            </div>


                            <div class="import-info-copy">

                                <span class="import-info-label">
                                    Assigned Sales
                                </span>

                                <strong
                                    class="import-info-value"
                                    title="{{ $batch->salesUser->name ?? '-' }}"
                                >

                                    {{ $batch->salesUser->name ?? '-' }}

                                </strong>

                            </div>

                        </div>


                        {{-- UPLOADED BY --}}
                        <div class="import-card-info-box">

                            <div class="import-info-icon">

                                <i class="bi bi-cloud-arrow-up"></i>

                            </div>


                            <div class="import-info-copy">

                                <span class="import-info-label">
                                    Uploaded By
                                </span>

                                <strong
                                    class="import-info-value"
                                    title="{{ $batch->uploadedBy->name ?? '-' }}"
                                >

                                    {{ $batch->uploadedBy->name ?? '-' }}

                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        IMPORT COUNTS
                    ================================================== --}}

                    <div class="import-card-counts">


                        {{-- TOTAL --}}
                        <div class="import-card-count">

                            <div class="import-count-heading">

                                <span class="import-count-dot total-dot"></span>

                                <span class="import-count-label">
                                    Total Rows
                                </span>

                            </div>

                            <strong class="import-count-number">

                                {{ number_format($totalRows) }}

                            </strong>

                        </div>


                        {{-- IMPORTED --}}
                        <div class="import-card-count success">

                            <div class="import-count-heading">

                                <span class="import-count-dot success-dot"></span>

                                <span class="import-count-label">
                                    Imported
                                </span>

                            </div>

                            <strong class="import-count-number">

                                {{ number_format($importedRows) }}

                            </strong>

                        </div>


                        {{-- SKIPPED --}}
                        <div class="import-card-count warning">

                            <div class="import-count-heading">

                                <span class="import-count-dot warning-dot"></span>

                                <span class="import-count-label">
                                    Skipped
                                </span>

                            </div>

                            <strong class="import-count-number">

                                {{ number_format($skippedRows) }}

                            </strong>

                        </div>

                    </div>


                    {{-- =================================================
                        SUCCESS PROGRESS
                    ================================================== --}}

                    <div class="import-card-progress-area">

                        <div class="import-progress-header">

                            <div>

                                <span>
                                    Import Success
                                </span>

                                @if($batchStatus === 'completed')

                                    <small>
                                        {{ number_format($importedRows) }} of
                                        {{ number_format($totalRows) }} rows imported
                                    </small>

                                @elseif($batchStatus === 'failed')

                                    <small>
                                        Import failed
                                    </small>

                                @else

                                    <small>
                                        Waiting for import completion
                                    </small>

                                @endif

                            </div>


                            <strong>
                                {{ $successPercentage }}%
                            </strong>

                        </div>


                        <div class="import-progress-track">

                            <div
                                class="
                                    import-progress-fill
                                    {{ $batchStatus === 'failed' ? 'failed' : '' }}
                                "
                                style="width: {{ $successPercentage }}%;"
                            ></div>

                        </div>

                    </div>


                    {{-- =================================================
                        CARD FOOTER
                    ================================================== --}}

                    <div class="import-card-footer">


                        {{-- LINKED LEADS --}}
                        <div class="import-card-footer-note">

                            <i class="bi bi-database-check"></i>

                            <span>

                                <strong>
                                    {{ number_format($importedRows) }}
                                </strong>

                                leads linked with this import

                            </span>

                        </div>


                        {{-- ACTION BUTTONS --}}
                        <div class="import-card-footer-actions">


                            {{-- VIEW LEADS --}}
                            <a
                                    href="{{ route('admin.leads.import.history.leads', $batch->id) }}"
                                    class="import-card-btn"
                                >
                                    <i class="bi bi-people"></i>
                                    <span>View Leads</span>
                            </a>


                            {{-- OPEN --}}
                           <a
                                href="{{ route('admin.leads.import.history.open', $batch->id) }}"
                                class="import-card-btn"
                            >
                                <i class="bi bi-eye"></i>
                                <span>Open</span>
                            </a>


                            {{-- DOWNLOAD --}}
                           <a
                                href="{{ route('admin.leads.import.history.download', $batch->id) }}"
                                class="import-card-btn"
                            >
                                <i class="bi bi-download"></i>
                                <span>Download</span>
                            </a>

                        </div>

                    </div>

                </article>


            @empty


                {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}

                <div class="import-empty">

                    <div class="import-empty-icon">

                        <i class="bi bi-inbox"></i>

                    </div>


                    <h5>

                        @if(
                            request()->filled('search') ||
                            request()->filled('status') ||
                            request()->filled('category_id') ||
                            request()->filled('sales_user_id')
                        )

                            No matching imports

                        @else

                            No import history yet

                        @endif

                    </h5>


                    <p>

                        @if(
                            request()->filled('search') ||
                            request()->filled('status') ||
                            request()->filled('category_id') ||
                            request()->filled('sales_user_id')
                        )

                            Try adjusting your filters.

                        @else

                            Uploaded CSV and Excel lead files will appear here.

                        @endif

                    </p>


                    @if(
                        request()->filled('search') ||
                        request()->filled('status') ||
                        request()->filled('category_id') ||
                        request()->filled('sales_user_id')
                    )

                        <a
                            href="{{ route('admin.leads.import.history') }}"
                            class="btn import-empty-reset-btn"
                        >

                            <i class="bi bi-arrow-counterclockwise"></i>

                            Clear Filters

                        </a>

                    @endif

                </div>


            @endforelse

        </div>


        {{-- =====================================================
            PAGINATION
        ====================================================== --}}

        @if($batches->hasPages())

            <div class="import-pagination">

                {{ $batches->links() }}

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
    COMPLETE PAGE CSS — CODE SPARROW ENTERPRISE DESIGN SYSTEM
========================================================== --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | DESIGN TOKENS
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page {

        --cs-primary: #0F8EA3;
        --cs-primary-dark: #0B7386;
        --cs-secondary: #16B6C8;
        --cs-dark: #1F2937;
        --cs-bg: #F8FAFC;
        --cs-surface: #FFFFFF;
        --cs-border: #E5E7EB;
        --cs-muted: #64748B;
        --cs-success: #16A34A;
        --cs-success-bg: #F0FDF4;
        --cs-success-border: #BBF7D0;
        --cs-warning: #D97706;
        --cs-warning-bg: #FFFBEB;
        --cs-warning-border: #FDE68A;
        --cs-danger: #DC2626;
        --cs-danger-bg: #FEF2F2;
        --cs-danger-border: #FECACA;

        font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;

        padding-bottom: 30px;
        color: var(--cs-dark);
    }

    .lead-import-history-page * {
        box-sizing: border-box;
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE HEADER
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .cs-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;

        font-size: 11px;
        font-weight: 600;

        color: var(--cs-muted);
    }

    .lead-import-history-page .cs-breadcrumb a {
        color: var(--cs-muted);
        text-decoration: none;
        transition: color .15s ease;
    }

    .lead-import-history-page .cs-breadcrumb a:hover {
        color: var(--cs-primary);
    }

    .lead-import-history-page .cs-breadcrumb i {
        font-size: 9px;
        color: #C7CDD6;
    }

    .lead-import-history-page .cs-breadcrumb span {
        color: var(--cs-dark);
    }

    .lead-import-history-page .cs-eyebrow {
        display: inline-block;

        margin-bottom: 6px;

        color: var(--cs-primary);

        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .lead-import-history-page .cs-page-title {
        margin: 0 0 4px;

        color: var(--cs-dark);

        font-size: 26px;
        font-weight: 750;
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .lead-import-history-page .import-page-subtitle {
        color: var(--cs-muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .lead-import-history-page .import-alert {
        border-radius: 11px;
        font-size: 13px;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER BUTTONS
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-header-btn {
        height: 40px;
        padding: 0 14px;

        border: 1px solid var(--cs-border);
        border-radius: 9px;

        background: var(--cs-surface);
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        font-size: 12px;
        font-weight: 600;

        transition: background .15s ease, border-color .15s ease, color .15s ease;
    }

    .lead-import-history-page .import-header-btn:hover {
        background: #F8FAFC;
        color: var(--cs-dark);
        border-color: #D0D5DD;
    }

    .lead-import-history-page .import-header-primary-btn {
        height: 40px;
        padding: 0 16px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        border: none;
        border-radius: 9px;

        background: linear-gradient(180deg, var(--cs-primary) 0%, var(--cs-primary-dark) 100%);
        color: #fff;

        font-size: 12px;
        font-weight: 650;

        box-shadow: 0 1px 2px rgba(15, 142, 163, .18);

        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }

    .lead-import-history-page .import-header-primary-btn:hover {
        filter: brightness(1.04);
        box-shadow: 0 4px 10px rgba(15, 142, 163, .24);
    }


    /*
    |--------------------------------------------------------------------------
    | KPI STRIP
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .cs-kpi-strip {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .lead-import-history-page .cs-kpi-card {
        padding: 18px 19px;

        background: var(--cs-surface);

        border: 1px solid var(--cs-border);
        border-radius: 14px;

        box-shadow: 0 1px 2px rgba(16, 24, 40, .02);

        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .lead-import-history-page .cs-kpi-card:hover {
        border-color: #D8DEE8;
        box-shadow: 0 4px 14px rgba(16, 24, 40, .05);
    }

    .lead-import-history-page .cs-kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        margin-bottom: 12px;
    }

    .lead-import-history-page .cs-kpi-label {
        color: var(--cs-muted);

        font-size: 11px;
        font-weight: 650;
        letter-spacing: .02em;
    }

    .lead-import-history-page .cs-kpi-icon {
        width: 30px;
        height: 30px;

        border-radius: 8px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 13px;
    }

    .lead-import-history-page .cs-kpi-icon-neutral {
        background: #F1F5F9;
        color: #475467;
    }

    .lead-import-history-page .cs-kpi-icon-success {
        background: var(--cs-success-bg);
        color: var(--cs-success);
    }

    .lead-import-history-page .cs-kpi-icon-warning {
        background: var(--cs-warning-bg);
        color: var(--cs-warning);
    }

    .lead-import-history-page .cs-kpi-icon-danger {
        background: var(--cs-danger-bg);
        color: var(--cs-danger);
    }

    .lead-import-history-page .cs-kpi-number {
        color: var(--cs-dark);

        font-size: 28px;
        font-weight: 750;
        letter-spacing: -.01em;
        line-height: 1;
    }

    .lead-import-history-page .cs-kpi-number-success {
        color: var(--cs-success);
    }

    .lead-import-history-page .cs-kpi-number-warning {
        color: var(--cs-warning);
    }

    .lead-import-history-page .cs-kpi-number-danger {
        color: var(--cs-danger);
    }

    .lead-import-history-page .cs-kpi-desc {
        margin-top: 8px;

        color: #98A2B3;

        font-size: 11px;
    }


    /*
    |--------------------------------------------------------------------------
    | GENERAL PANEL
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-panel {
        background: var(--cs-surface);

        border: 1px solid var(--cs-border);
        border-radius: 15px;

        box-shadow: 0 1px 2px rgba(16, 24, 40, .02);

        overflow: visible;
    }

    .lead-import-history-page .import-panel-header {
        min-height: 66px;

        padding: 16px 20px;

        border-bottom: 1px solid #EDF0F4;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;
    }

    .lead-import-history-page .import-panel-title {
        margin: 0 0 3px;

        color: var(--cs-dark);

        font-size: 14px;
        font-weight: 700;
    }

    .lead-import-history-page .import-panel-subtitle {
        margin: 0;

        color: #98A2B3;

        font-size: 11px;
    }

    .lead-import-history-page .import-history-label {
        padding: 6px 10px;

        border: 1px solid #EAECF0;
        border-radius: 7px;

        background: #F9FAFB;

        color: #667085;

        display: flex;
        align-items: center;
        gap: 6px;

        font-size: 10.5px;
        font-weight: 600;
    }


    /*
    |--------------------------------------------------------------------------
    | COLLAPSIBLE FILTER TOOLBAR
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-filter-collapse {
        display: none;
    }

    .lead-import-history-page .import-filter-collapse.is-open {
        display: block;
        animation: importFilterReveal .18s ease;
    }

    @keyframes importFilterReveal {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .lead-import-history-page .import-history-header-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: wrap;
    }

    .lead-import-history-page .import-filter-toggle {
        min-height: 34px;
        padding: 0 11px;

        border: 1px solid #E4E7EC;
        border-radius: 8px;

        background: #FFFFFF;
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        font-size: 11px;
        font-weight: 650;

        cursor: pointer;
        transition:
            background .15s ease,
            border-color .15s ease,
            color .15s ease,
            box-shadow .15s ease;
    }

    .lead-import-history-page .import-filter-toggle:hover,
    .lead-import-history-page .import-filter-toggle.is-active {
        background: #F0FDFF;
        border-color: rgba(15, 142, 163, .35);
        color: var(--cs-primary-dark);
    }

    .lead-import-history-page .import-filter-toggle:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(15, 142, 163, .10);
    }

    .lead-import-history-page .import-filter-count {
        min-width: 18px;
        height: 18px;
        padding: 0 5px;

        border-radius: 100px;

        background: var(--cs-primary);
        color: #FFFFFF;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        font-size: 9px;
        font-weight: 800;
        line-height: 1;
    }

    .lead-import-history-page .import-filter-toggle-chevron {
        font-size: 9px;
        transition: transform .18s ease;
    }

    .lead-import-history-page .import-filter-toggle.is-active .import-filter-toggle-chevron {
        transform: rotate(180deg);
    }


    /*
    |--------------------------------------------------------------------------
    | FILTERS
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-filter-form {
        padding: 18px 20px 20px;
    }

    .lead-import-history-page .eForm-label {
        display: block;

        margin-bottom: 6px;

        color: #344054;

        font-size: 11px;
        font-weight: 650;
    }

    .lead-import-history-page .import-input-wrap {
        position: relative;
    }

    .lead-import-history-page .import-input-wrap > i {
        position: absolute;

        left: 13px;
        top: 50%;

        transform: translateY(-50%);

        z-index: 2;

        color: #98A2B3;

        font-size: 13px;
    }

    .lead-import-history-page .import-search-input {
        padding-left: 36px !important;
    }

    .lead-import-history-page .eForm-control {
        height: 42px;

        border: 1px solid var(--cs-border);
        border-radius: 9px;

        background: var(--cs-surface);
        color: var(--cs-dark);

        font-size: 12.5px;

        box-shadow: none;

        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .lead-import-history-page .eForm-control:focus {
        border-color: var(--cs-primary);
        box-shadow: 0 0 0 3px rgba(15, 142, 163, .12);
        outline: none;
    }

    .lead-import-history-page .import-filter-btn {
        height: 42px;

        flex: 1;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        border: none;
        border-radius: 9px;

        background: linear-gradient(180deg, var(--cs-primary) 0%, var(--cs-primary-dark) 100%);
        color: #fff;

        font-size: 12px;
        font-weight: 650;

        transition: filter .15s ease;
    }

    .lead-import-history-page .import-filter-btn:hover {
        filter: brightness(1.05);
    }

    .lead-import-history-page .import-reset-btn {
        width: 42px;
        height: 42px;

        padding: 0;

        border: 1px solid var(--cs-border);
        border-radius: 9px;

        background: #fff;
        color: #667085;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        transition: background .15s ease, color .15s ease;
    }

    .lead-import-history-page .import-reset-btn:hover {
        background: #F8FAFC;
        color: var(--cs-dark);
    }


    /*
    |--------------------------------------------------------------------------
    | HISTORY GRID
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-history-grid {
        padding: 18px;

        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 16px;
    }


    /*
    |--------------------------------------------------------------------------
    | HISTORY CARD
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-history-card {
        min-width: 0;

        background: var(--cs-surface);

        border: 1px solid #E6EAF0;
        border-radius: 14px;

        box-shadow: 0 1px 2px rgba(16, 24, 40, .02);

        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .lead-import-history-page .import-history-card:hover {
        transform: translateY(-2px);

        border-color: #D8DEE8;

        box-shadow: 0 10px 25px rgba(16, 24, 40, .06);
    }


    /*
    |--------------------------------------------------------------------------
    | CARD HEADER
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-card-top {
        padding: 16px 16px 13px;

        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;
    }

    .lead-import-history-page .import-card-file-area {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 11px;
    }

    .lead-import-history-page .import-card-file-icon {
        width: 42px;
        height: 42px;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 17px;
    }

    .lead-import-history-page .excel-file-icon {
        background: var(--cs-success-bg);
        color: var(--cs-success);
    }

    .lead-import-history-page .csv-file-icon {
        background: #ECFEFF;
        color: var(--cs-primary);
    }

    .lead-import-history-page .import-card-file-copy {
        min-width: 0;
    }

    .lead-import-history-page .import-card-id {
        margin-bottom: 2px;

        color: #98A2B3;

        font-size: 8.5px;
        font-weight: 800;

        letter-spacing: .09em;
    }

    .lead-import-history-page .import-card-file-name {
        max-width: 260px;

        margin: 0 0 3px;

        color: var(--cs-dark);

        font-size: 13.5px;
        font-weight: 700;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lead-import-history-page .import-card-file-meta {
        display: flex;
        align-items: center;

        gap: 5px;

        color: #98A2B3;

        font-size: 9.5px;
        font-weight: 600;
    }

    .lead-import-history-page .import-meta-dot {
        width: 3px;
        height: 3px;

        border-radius: 50%;

        background: #D0D5DD;
    }

    .lead-import-history-page .import-card-top-right {
        display: flex;
        align-items: center;

        gap: 6px;

        flex-shrink: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-status {
        padding: 5px 9px;

        border-radius: 100px;

        display: inline-flex;
        align-items: center;

        gap: 5px;

        font-size: 9.5px;
        font-weight: 700;

        white-space: nowrap;

        transition: background .2s ease, color .2s ease;
    }

    .lead-import-history-page .import-status-dot {
        width: 5px;
        height: 5px;

        border-radius: 50%;

        background: currentColor;
    }

    .lead-import-history-page .import-status-success {
        background: var(--cs-success-bg);
        color: var(--cs-success);
        border: 1px solid var(--cs-success-border);
    }

    .lead-import-history-page .import-status-warning {
        background: var(--cs-warning-bg);
        color: var(--cs-warning);
        border: 1px solid var(--cs-warning-border);
    }

    .lead-import-history-page .import-status-danger {
        background: var(--cs-danger-bg);
        color: var(--cs-danger);
        border: 1px solid var(--cs-danger-border);
    }


    /*
    |--------------------------------------------------------------------------
    | DROPDOWN ACTION
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-action-btn {
        width: 30px;
        height: 30px;

        padding: 0;

        border: 1px solid #E4E7EC;
        border-radius: 7px;

        background: var(--cs-surface);
        color: #667085;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        transition: background .15s ease, color .15s ease;
    }

    .lead-import-history-page .import-action-btn:hover {
        background: #F9FAFB;
        color: var(--cs-dark);
    }

    .lead-import-history-page .import-action-menu {
        min-width: 190px;

        padding: 5px;

        border: 1px solid #EAECF0;
        border-radius: 10px;

        box-shadow: 0 10px 30px rgba(16, 24, 40, .12);

        animation: csMenuFade .12s ease;
    }

    @keyframes csMenuFade {
        from { opacity: 0; transform: translateY(-3px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .lead-import-history-page .import-action-menu .dropdown-item {
        min-height: 34px;

        padding: 7px 9px;

        border-radius: 6px;

        display: flex;
        align-items: center;

        gap: 8px;

        font-size: 11.5px;
        font-weight: 500;
    }

    .lead-import-history-page .import-action-menu .dropdown-item:hover:not(:disabled) {
        background: #F8FAFC;
    }

    .lead-import-history-page .import-action-menu .dropdown-item.text-danger:hover {
        background: var(--cs-danger-bg);
    }

    .lead-import-history-page .import-action-menu .dropdown-item:disabled {
        opacity: .42;
        cursor: not-allowed;
    }


    /*
    |--------------------------------------------------------------------------
    | UPLOAD DATE
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-card-upload-date {
        margin: 0 16px;

        padding: 9px 11px;

        border: 1px solid #F0F2F5;
        border-radius: 8px;

        background: var(--cs-bg);

        color: #7C8799;

        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 4px;

        font-size: 10px;
    }

    .lead-import-history-page .import-card-upload-date > i {
        margin-right: 2px;

        color: #667085;
    }

    .lead-import-history-page .import-card-upload-date strong {
        color: #344054;

        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | INFORMATION
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-card-info-grid {
        padding: 13px 16px;

        display: grid;

        grid-template-columns: repeat(3, minmax(0, 1fr));

        gap: 9px;
    }

    .lead-import-history-page .import-card-info-box {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 7px;
    }

    .lead-import-history-page .import-info-icon {
        width: 30px;
        height: 30px;

        border-radius: 8px;

        background: #F5F7FA;
        color: #667085;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 12px;
    }

    .lead-import-history-page .import-info-copy {
        min-width: 0;
    }

    .lead-import-history-page .import-info-label {
        display: block;

        margin-bottom: 1px;

        color: #98A2B3;

        font-size: 8.5px;
        font-weight: 600;

        white-space: nowrap;
    }

    .lead-import-history-page .import-info-value {
        display: block;

        max-width: 120px;

        color: #344054;

        font-size: 10.5px;
        font-weight: 700;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /*
    |--------------------------------------------------------------------------
    | COUNTS
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-card-counts {
        padding: 2px 16px 13px;

        display: grid;

        grid-template-columns: repeat(3, minmax(0, 1fr));

        gap: 8px;
    }

    .lead-import-history-page .import-card-count {
        padding: 10px;

        border: 1px solid #EDF0F4;
        border-radius: 9px;

        background: var(--cs-bg);
    }

    .lead-import-history-page .import-card-count.success {
        border-color: var(--cs-success-border);
        background: var(--cs-success-bg);
    }

    .lead-import-history-page .import-card-count.warning {
        border-color: var(--cs-warning-border);
        background: var(--cs-warning-bg);
    }

    .lead-import-history-page .import-count-heading {
        display: flex;
        align-items: center;

        gap: 5px;

        margin-bottom: 5px;
    }

    .lead-import-history-page .import-count-dot {
        width: 5px;
        height: 5px;

        border-radius: 50%;

        flex-shrink: 0;
    }

    .lead-import-history-page .total-dot {
        background: #667085;
    }

    .lead-import-history-page .success-dot {
        background: var(--cs-success);
    }

    .lead-import-history-page .warning-dot {
        background: var(--cs-warning);
    }

    .lead-import-history-page .import-count-label {
        color: #98A2B3;

        font-size: 8.5px;
        font-weight: 600;
    }

    .lead-import-history-page .import-count-number {
        display: block;

        color: var(--cs-dark);

        font-size: 17px;
        font-weight: 750;

        line-height: 1;
    }


    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-card-progress-area {
        padding: 0 16px 14px;
    }

    .lead-import-history-page .import-progress-header {
        margin-bottom: 6px;

        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 10px;
    }

    .lead-import-history-page .import-progress-header > div > span {
        display: block;

        margin-bottom: 1px;

        color: #667085;

        font-size: 9.5px;
        font-weight: 650;
    }

    .lead-import-history-page .import-progress-header small {
        display: block;

        color: #98A2B3;

        font-size: 8.5px;
    }

    .lead-import-history-page .import-progress-header > strong {
        color: #344054;

        font-size: 10.5px;
        font-weight: 750;
    }

    .lead-import-history-page .import-progress-track {
        width: 100%;
        height: 5px;

        border-radius: 100px;

        background: #EAECF0;

        overflow: hidden;
    }

    .lead-import-history-page .import-progress-fill {
        height: 100%;

        border-radius: inherit;

        background: linear-gradient(90deg, var(--cs-primary) 0%, var(--cs-secondary) 100%);

        transition: width .4s ease;
    }

    .lead-import-history-page .import-progress-fill.failed {
        background: var(--cs-danger);
    }


    /*
    |--------------------------------------------------------------------------
    | CARD FOOTER
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-card-footer {
        min-height: 54px;

        padding: 11px 16px;

        border-top: 1px solid #EEF1F4;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;
    }

    .lead-import-history-page .import-card-footer-note {
        min-width: 0;

        color: #98A2B3;

        display: flex;
        align-items: center;

        gap: 5px;

        font-size: 9px;
    }

    .lead-import-history-page .import-card-footer-note i {
        color: #667085;

        font-size: 11.5px;
    }

    .lead-import-history-page .import-card-footer-note strong {
        color: #475467;
    }

    .lead-import-history-page .import-card-footer-actions {
        display: flex;
        align-items: center;

        gap: 5px;

        flex-shrink: 0;
    }

    .lead-import-history-page .import-card-btn {
        min-height: 30px;

        padding: 0 9px;

        border: 1px solid #E4E7EC;
        border-radius: 7px;

        background: var(--cs-surface);
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 4px;

        font-size: 10px;
        font-weight: 650;

        white-space: nowrap;

        text-decoration: none;

        transition: background .15s ease, border-color .15s ease, color .15s ease;
    }

    .lead-import-history-page .import-card-btn:not(.disabled):hover {
        background: #F8FCFD;
        border-color: var(--cs-primary);
        color: var(--cs-primary-dark);
        text-decoration: none;
    }

    .lead-import-history-page .import-card-btn.disabled {
        opacity: .42;
        cursor: not-allowed;
        pointer-events: none;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY STATE
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-history-grid > .import-empty {
        grid-column: 1 / -1;

        padding: 64px 20px;

        text-align: center;
    }

    .lead-import-history-page .import-empty-icon {
        width: 56px;
        height: 56px;

        margin: 0 auto 14px;

        border-radius: 14px;

        background: linear-gradient(180deg, #ECFEFF 0%, #F1F5F9 100%);
        color: var(--cs-primary);

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 22px;

        border: 1px solid var(--cs-border);
    }

    .lead-import-history-page .import-empty h5 {
        margin: 0 0 5px;

        color: var(--cs-dark);

        font-size: 14.5px;
        font-weight: 700;
    }

    .lead-import-history-page .import-empty p {
        margin: 0 auto;

        max-width: 380px;

        color: #98A2B3;

        font-size: 11.5px;
        line-height: 1.6;
    }

    .lead-import-history-page .import-empty-reset-btn {
        margin-top: 16px;

        height: 36px;

        padding: 0 14px;

        border: 1px solid var(--cs-border);
        border-radius: 8px;

        background: var(--cs-surface);
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        font-size: 11px;
        font-weight: 650;
    }

    .lead-import-history-page .import-empty-reset-btn:hover {
        background: #F8FAFC;
        border-color: #D0D5DD;
        color: var(--cs-dark);
    }


    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    .lead-import-history-page .import-pagination {
        padding: 14px 18px;

        border-top: 1px solid #EDF0F4;
    }

    .lead-import-history-page .import-pagination .page-link {
        border-color: var(--cs-border);
        color: #475467;
        font-size: 12px;
    }

    .lead-import-history-page .import-pagination .page-item.active .page-link {
        background-color: var(--cs-primary);
        border-color: var(--cs-primary);
    }


    /*
    |--------------------------------------------------------------------------
    | TABLET
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1199px) {

        .lead-import-history-page .cs-kpi-strip {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .lead-import-history-page .import-history-grid {
            grid-template-columns: 1fr;
        }

        .lead-import-history-page .import-card-file-name {
            max-width: 420px;
        }

        .lead-import-history-page .import-info-value {
            max-width: 200px;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .lead-import-history-page {
            padding-left: 8px;
            padding-right: 8px;
        }

        .lead-import-history-page .cs-kpi-strip {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .lead-import-history-page .cs-kpi-card {
            padding: 14px;
        }

        .lead-import-history-page .cs-kpi-number {
            font-size: 22px;
        }

        .lead-import-history-page .cs-page-title {
            font-size: 20px;
        }

        .lead-import-history-page .import-panel-header {
            min-height: auto;

            padding: 14px;
        }

        .lead-import-history-page .import-filter-form {
            padding: 14px;
        }

        .lead-import-history-page .import-history-grid {
            padding: 11px;

            grid-template-columns: 1fr;

            gap: 11px;
        }

        .lead-import-history-page .import-card-top {
            padding: 14px;
        }

        .lead-import-history-page .import-card-file-name {
            max-width: 190px;
        }

        .lead-import-history-page .import-card-upload-date {
            margin: 0 14px;
        }

        .lead-import-history-page .import-card-info-grid {
            padding: 13px 14px;

            grid-template-columns: 1fr;
        }

        .lead-import-history-page .import-info-value {
            max-width: none;
        }

        .lead-import-history-page .import-card-counts {
            padding-left: 14px;
            padding-right: 14px;
        }

        .lead-import-history-page .import-card-progress-area {
            padding-left: 14px;
            padding-right: 14px;
        }

        .lead-import-history-page .import-card-footer {
            padding: 11px 14px;

            align-items: flex-start;
            flex-direction: column;
        }

        .lead-import-history-page .import-card-footer-actions {
            width: 100%;
        }

        .lead-import-history-page .import-card-btn {
            flex: 1;
        }

        .lead-import-history-page .import-history-label {
            display: none;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | SMALL MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 480px) {

        .lead-import-history-page .cs-kpi-strip {
            grid-template-columns: 1fr;
        }

        .lead-import-history-page .cs-page-header > div {
            align-items: flex-start !important;
        }

        .lead-import-history-page .import-card-top {
            gap: 8px;
        }

        .lead-import-history-page .import-card-file-icon {
            width: 39px;
            height: 39px;

            font-size: 17px;
        }

        .lead-import-history-page .import-card-file-name {
            max-width: 135px;

            font-size: 12px;
        }

        .lead-import-history-page .import-status {
            padding: 4px 7px;

            font-size: 8.5px;
        }

        .lead-import-history-page .import-card-counts {
            grid-template-columns: 1fr 1fr;
        }

        .lead-import-history-page .import-card-count:first-child {
            grid-column: 1 / -1;
        }

        .lead-import-history-page .import-card-footer-actions {
            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .lead-import-history-page .import-card-btn {
            width: 100%;

            padding-left: 4px;
            padding-right: 4px;

            font-size: 8px;
        }

    }

</style>


<script>
    function toggleImportFilters() {
        const panel = document.getElementById('importFilterPanel');
        const button = document.getElementById('importFilterToggle');

        if (!panel || !button) {
            return;
        }

        const isOpen = panel.classList.toggle('is-open');

        button.classList.toggle('is-active', isOpen);
        button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
</script>

@endsection


@push('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmImportDelete(
        batchId,
        fileName,
        importedRows
    ) {

        Swal.fire({
            title: 'Delete this import?',
            html:
                '<div style="text-align:left;font-size:13px;line-height:1.7;">' +

                    '<div style="margin-bottom:10px;">' +
                        'You are about to permanently delete:' +
                    '</div>' +

                    '<div style="padding:12px;background:#F8FAFC;border:1px solid #E5E7EB;border-radius:8px;">' +

                        '<strong>File:</strong> ' +
                        escapeImportHtml(fileName) +

                        '<br>' +

                        '<strong>Imported Leads:</strong> ' +
                        importedRows +

                    '</div>' +

                    '<div style="margin-top:12px;color:#DC2626;">' +
                        'The imported leads, original uploaded file and this import history record will be removed.' +
                    '</div>' +

                '</div>',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Yes, Delete Import',

            cancelButtonText: 'Cancel',

            confirmButtonColor: '#DC2626',

            reverseButtons: true,

            focusCancel: true

        }).then(function (result) {

            if (!result.isConfirmed) {
                return;
            }


            const form =
                document.getElementById(
                    'delete-import-form-' +
                    batchId
                );


            if (form) {
                form.submit();
            }
        });
    }


    function escapeImportHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            value ?? '';

        return div.innerHTML;
    }
</script>
@endpush
