@extends('index')

@push('title', get_phrase('Rejected leads'))

@push('css')
<style>
    .rj-page {
        --rj-primary: #0F8EA3;
        --rj-primary-dark: #0B7386;
        --rj-danger: #DC2626;
        --rj-danger-dark: #B91C1C;
        --rj-danger-bg: #FEF2F2;
        --rj-success: #15803D;
        --rj-border: #E5E7EB;
        --rj-bg: #F8FAFC;
        --rj-text: #1F2937;
        --rj-muted: #667085;
        --rj-light: #98A2B3;
        padding-bottom: 32px;
    }

    .rj-page * { box-sizing: border-box; }

    .rj-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .rj-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: var(--rj-danger);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .rj-title {
        margin: 0;
        color: var(--rj-text);
        font-size: 25px;
        font-weight: 750;
        letter-spacing: -.02em;
    }

    .rj-subtitle {
        margin: 5px 0 0;
        color: var(--rj-muted);
        font-size: 11px;
    }

    .rj-summary {
        min-height: 38px;
        padding: 0 12px;
        border: 1px solid #FECACA;
        border-radius: 9px;
        background: var(--rj-danger-bg);
        color: var(--rj-danger-dark);
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 10px;
        font-weight: 700;
    }

    .rj-shell {
        overflow: hidden;
        border: 1px solid var(--rj-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .03);
    }

    .rj-toolbar {
        padding: 14px 16px;
        border-bottom: 1px solid #EDF0F4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .rj-toolbar-left,
    .rj-toolbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .rj-btn {
        min-height: 38px;
        padding: 0 12px;
        border: 1px solid transparent;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none !important;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .rj-btn-export {
        border-color: #BBF7D0;
        background: #F0FDF4;
        color: var(--rj-success);
    }

    .rj-btn-primary {
        border-color: var(--rj-primary);
        background: linear-gradient(180deg, var(--rj-primary), var(--rj-primary-dark));
        color: #fff;
    }

    .rj-btn-danger {
        border-color: var(--rj-danger);
        background: linear-gradient(180deg, #EF4444, var(--rj-danger-dark));
        color: #fff;
    }

    .rj-btn-danger:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    .rj-search {
        position: relative;
        width: min(340px, 100%);
    }

    .rj-search > i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--rj-light);
        font-size: 12px;
    }

    .rj-search input {
        height: 38px;
        padding-left: 34px;
        border: 1px solid var(--rj-border);
        border-radius: 8px;
        box-shadow: none !important;
        font-size: 10px;
    }

    .rj-search input:focus {
        border-color: var(--rj-primary);
    }

    .rj-per-page {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rj-per-page label {
        margin: 0;
        color: var(--rj-muted);
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .rj-per-page select {
        width: 82px;
        height: 38px;
        border: 1px solid var(--rj-border);
        border-radius: 8px;
        background: #fff;
        color: #344054;
        padding: 0 8px;
        font-size: 10px;
        box-shadow: none;
    }

    .rj-custom-page {
        display: none;
        align-items: center;
        gap: 5px;
    }

    .rj-custom-page.show { display: flex; }

    .rj-custom-page input {
        width: 82px;
        height: 38px;
        border: 1px solid var(--rj-border);
        border-radius: 8px;
        padding: 0 8px;
        font-size: 10px;
        box-shadow: none;
    }

    .rj-custom-page button {
        height: 38px;
        padding: 0 10px;
        border: 0;
        border-radius: 8px;
        background: var(--rj-primary);
        color: #fff;
        font-size: 9px;
        font-weight: 700;
    }

    .rj-tabs-wrap {
        overflow-x: auto;
        padding: 9px 12px 0;
        border-bottom: 1px solid #EDF0F4;
        scrollbar-width: thin;
    }

    .rj-tabs {
        display: flex;
        flex-wrap: nowrap;
        gap: 4px;
        min-width: max-content;
        border: 0;
    }

    .rj-tabs .nav-link {
        padding: 8px 10px;
        border: 0;
        border-bottom: 2px solid transparent;
        color: #667085;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .rj-tabs .nav-link span {
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        background: #F2F4F7;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
    }

    .rj-tabs .nav-link.active {
        border-bottom-color: var(--rj-danger);
        background: #FFF7F7;
        color: var(--rj-danger-dark);
    }

    .rj-bulk-strip {
        display: none;
        min-height: 46px;
        padding: 7px 14px;
        border-bottom: 1px solid #FECACA;
        background: #FFF7F7;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .rj-bulk-strip.show { display: flex; }

    .rj-selected-text {
        color: var(--rj-danger-dark);
        font-size: 10px;
        font-weight: 700;
    }

    .rj-clear-selection {
        border: 0;
        background: transparent;
        color: #667085;
        font-size: 9px;
        font-weight: 700;
        cursor: pointer;
    }

    .rj-table {
        min-width: 1140px;
        margin: 0;
        font-size: 10px;
    }

    .rj-table thead th {
        padding: 10px 11px;
        border-bottom: 1px solid #DDE2E8;
        background: #F8FAFC;
        color: #667085;
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        vertical-align: middle;
        white-space: nowrap;
    }

    .rj-table tbody td {
        padding: 10px 11px;
        border-bottom: 1px solid #EEF1F4;
        background: #fff;
        color: #475467;
        vertical-align: middle;
    }

    .rj-table tbody tr:hover td { background: #FCFDFE; }

    .rj-checkbox {
        width: 16px;
        height: 16px;
        margin: 0;
        border: 1px solid #D0D5DD;
        border-radius: 4px;
        accent-color: var(--rj-danger);
        cursor: pointer;
    }

    .rj-number {
        min-width: 28px;
        height: 25px;
        padding: 0 6px;
        border: 1px solid #E4E7EC;
        border-radius: 6px;
        background: #F9FAFB;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #667085;
        font-size: 8px;
        font-weight: 700;
    }

    .rj-person {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .rj-avatar {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #FEF2F2;
        color: var(--rj-danger);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 9px;
        font-weight: 800;
    }

    .rj-person strong {
        display: block;
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #344054;
        font-size: 10px;
        font-weight: 700;
    }

    .rj-phone {
        color: #344054;
        text-decoration: none;
        white-space: nowrap;
    }

    .rj-phone i {
        margin-right: 5px;
        color: var(--rj-primary);
    }

    .rj-cut {
        display: block;
        max-width: 210px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .rj-category {
        padding: 4px 7px;
        border: 1px solid #E4E7EC;
        border-radius: 6px;
        background: #F9FAFB;
        color: #475467;
        font-size: 8px;
        font-weight: 700;
        white-space: nowrap;
    }

    .rj-status {
        padding: 5px 8px;
        border: 1px solid #FECACA;
        border-radius: 999px;
        background: #FEF2F2;
        color: var(--rj-danger);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none !important;
        font-size: 8px;
        font-weight: 800;
        white-space: nowrap;
    }

    .rj-status span {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .rj-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .rj-action {
        width: 29px;
        height: 29px;
        border: 1px solid #E4E7EC;
        border-radius: 7px;
        background: #fff;
        color: #667085;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
    }

    .rj-action:hover {
        border-color: var(--rj-primary);
        background: #F3FCFD;
        color: var(--rj-primary-dark);
    }

    .rj-action-danger:hover {
        border-color: #FECACA;
        background: #FEF2F2;
        color: var(--rj-danger);
    }

    .rj-mobile { display: none; }

    .rj-footer {
        min-height: 58px;
        padding: 10px 14px;
        border-top: 1px solid #EDF0F4;
        background: #FCFDFE;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .rj-footer-info {
        color: var(--rj-light);
        font-size: 9px;
    }

    .rj-footer-info strong { color: #475467; }

    .rj-pagination .pagination { margin: 0; }
    .rj-pagination .page-link {
        border-color: var(--rj-border);
        color: #475467;
        font-size: 10px;
    }
    .rj-pagination .page-item.active .page-link {
        border-color: var(--rj-primary);
        background: var(--rj-primary);
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .rj-page { padding-left: 0px; padding-right: 0px; }

        .rj-header {
            align-items: flex-start;
            margin-bottom: 13px;
        }

        .rj-title { font-size: 21px; }

        .rj-summary {
            width: 100%;
            justify-content: center;
        }

        .rj-toolbar {
            padding: 11px;
            align-items: stretch;
            flex-direction: column;
        }

        .rj-toolbar-left,
        .rj-toolbar-right {
            width: 100%;
        }

        .rj-toolbar-left .rj-btn {
            flex: 1;
        }

        .rj-search {
            width: 100%;
            order: 1;
        }

        .rj-per-page {
            flex: 1;
        }

        .rj-per-page select {
            flex: 1;
            width: auto;
        }

        .rj-custom-page {
            width: 100%;
        }

        .rj-custom-page input {
            flex: 1;
            width: auto;
        }

        .rj-bulk-strip {
            align-items: stretch;
            flex-direction: column;
            padding: 10px 12px;
        }

        .rj-bulk-strip .rj-btn {
            width: 100%;
        }

        .rj-desktop { display: none; }

        .rj-mobile {
            display: grid;
            gap: 10px;
            padding: 10px;
            background: var(--rj-bg);
        }

        .rj-mobile-card {
            overflow: hidden;
            border: 1px solid #E5E7EB;
            border-radius: 13px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(16,24,40,.02);
        }

        .rj-mobile-top {
            padding: 12px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
        }

        .rj-mobile-select-wrap {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            min-width: 0;
        }

        .rj-avatar-mobile {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            font-size: 11px;
        }

        .rj-mobile-name {
            min-width: 0;
        }

        .rj-mobile-name strong {
            display: block;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #344054;
            font-size: 11px;
            font-weight: 750;
        }

        .rj-mobile-name small {
            display: block;
            margin-top: 2px;
            color: var(--rj-light);
            font-size: 8px;
        }

        .rj-mobile-phone {
            margin: 0 12px;
            padding: 9px;
            border: 1px solid #D8F0F3;
            border-radius: 9px;
            background: #F4FCFD;
            color: var(--rj-primary-dark);
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none !important;
        }

        .rj-mobile-phone-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--rj-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .rj-mobile-phone > div:nth-child(2) { flex: 1; }

        .rj-mobile-phone small,
        .rj-mobile-info small,
        .rj-mobile-copy small {
            display: block;
            color: var(--rj-light);
            font-size: 7px;
            font-weight: 700;
        }

        .rj-mobile-phone strong {
            display: block;
            margin-top: 1px;
            color: #344054;
            font-size: 11px;
        }

        .rj-mobile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
            padding: 10px 12px 0;
        }

        .rj-mobile-info {
            min-width: 0;
            padding: 8px;
            border: 1px solid #EDF0F4;
            border-radius: 8px;
            background: #FAFBFC;
        }

        .rj-mobile-info strong {
            display: block;
            margin-top: 2px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #344054;
            font-size: 9px;
        }

        .rj-mobile-copy {
            margin: 8px 12px 0;
            padding: 8px 9px;
            border-top: 1px solid #EEF1F4;
        }

        .rj-mobile-copy p {
            margin: 3px 0 0;
            color: #475467;
            font-size: 9px;
            line-height: 1.5;
            word-break: break-word;
        }

        .rj-mobile-actions {
            display: grid;
            grid-template-columns: repeat(4, minmax(0,1fr));
            gap: 5px;
            margin-top: 9px;
            padding: 9px 12px;
            border-top: 1px solid #EEF1F4;
            background: #FCFDFE;
        }

        .rj-mobile-action {
            min-height: 39px;
            border: 1px solid #E4E7EC;
            border-radius: 8px;
            background: #fff;
            color: #667085;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 3px;
            text-decoration: none !important;
            font-size: 7px;
            font-weight: 700;
        }

        .rj-mobile-action i { font-size: 11px; }

        .rj-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .rj-pagination { width: 100%; overflow-x: auto; }
    }

    @media (max-width: 390px) {
        .rj-mobile-top { flex-direction: column; }
        .rj-mobile-grid { grid-template-columns: 1fr; }
        .rj-mobile-actions { grid-template-columns: repeat(2, minmax(0,1fr)); }
    }
</style>
@endpush

@section('content')

<div class=" rj-page">

    <div class="rj-header">
        <div>
            <span class="rj-eyebrow">Lead Archive / Rejected</span>
            <h4 class="rj-title">{{ get_phrase('Rejected Leads') }}</h4>
            <p class="rj-subtitle">Review, manage and bulk-delete rejected leads assigned to your account.</p>
        </div>

        <div class="rj-summary">
            <i class="bi bi-x-circle"></i>
            {{ number_format($totalRejected ?? $leads->total()) }} Rejected Leads
        </div>
    </div>

    <div class="rj-shell">

        <form id="bulkDeleteRejectedForm" method="POST" action="{{ route('admin.lead.rejected.bulk-delete') }}">
            @csrf
            @method('DELETE')

            <div class="rj-toolbar">

                <div class="rj-toolbar-left">
                    <a
                        href="{{ route('admin.leads.export', request()->route('id')) }}"
                        class="rj-btn rj-btn-export"
                    >
                        <i class="bi bi-file-earmark-arrow-down"></i>
                        Export CSV
                    </a>

                    @can('lead-create')
                        <button
                            type="button"
                            class="rj-btn rj-btn-primary"
                            onclick="showRightModal(
                                '{{ route('right_modal', ['view_path' => 'admin/leads/import']) }}',
                                '{{ get_phrase('Import leads') }}'
                            )"
                        >
                            <i class="bi bi-upload"></i>
                            Import CSV
                        </button>
                    @endcan
                </div>

                <div class="rj-toolbar-right">

                    <div class="rj-search">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            id="leadSearch"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search name, phone, requirement, category..."
                            form="rejectedFilterForm"
                        >
                    </div>

                    <div class="rj-per-page">
                        <label for="perPageSelect">Rows</label>
                        <select id="perPageSelect" name="per_page" form="rejectedFilterForm">
                            <option value="50" {{ (int) request('per_page', 50) === 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ (int) request('per_page') === 100 ? 'selected' : '' }}>100</option>
                            <option value="200" {{ (int) request('per_page') === 200 ? 'selected' : '' }}>200</option>
                            <option value="custom" {{ request('per_page') === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    <div id="customPerPageWrap" class="rj-custom-page {{ request('per_page') === 'custom' ? 'show' : '' }}">
                        <input
                            type="number"
                            id="customPerPage"
                            name="custom_per_page"
                            value="{{ request('custom_per_page', 50) }}"
                            min="1"
                            max="500"
                            form="rejectedFilterForm"
                            placeholder="1-500"
                        >
                        <button type="submit" form="rejectedFilterForm">Apply</button>
                    </div>

                </div>

            </div>

            <div class="rj-tabs-wrap">
                <ul class="nav rj-tabs">

                    <li class="nav-item">
                        <a
                            class="nav-link {{ !request()->route('id') ? 'active' : '' }}"
                            href="{{ route('admin.lead.rejected', array_filter([
                                'per_page' => request('per_page', 50),
                                'custom_per_page' => request('custom_per_page'),
                                'search' => request('search')
                            ])) }}"
                        >
                            All
                            <span>{{ $totalRejected ?? 0 }}</span>
                        </a>
                    </li>

                    @foreach ($categories as $cat)
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->route('id') == $cat->id ? 'active' : '' }}"
                                href="{{ route('admin.lead.rejected', array_filter([
                                    'id' => $cat->id,
                                    'per_page' => request('per_page', 50),
                                    'custom_per_page' => request('custom_per_page'),
                                    'search' => request('search')
                                ])) }}"
                            >
                                {{ $cat->title }}
                                <span>{{ $categoryCounts[$cat->id] ?? 0 }}</span>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>

            @can('lead-delete')
                <div id="bulkStrip" class="rj-bulk-strip">
                    <div class="rj-selected-text">
                        <span id="selectedCount">0</span> lead(s) selected
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" id="clearSelectionBtn" class="rj-clear-selection">
                            Clear selection
                        </button>

                        <button type="button" id="bulkDeleteBtn" class="rj-btn rj-btn-danger" disabled>
                            <i class="bi bi-trash3"></i>
                            Delete Selected
                        </button>
                    </div>
                </div>
            @endcan

            <div class="rj-desktop">
                <div class="table-responsive">
                    <table class="table rj-table">
                        <thead>
                            <tr>
                                @can('lead-delete')
                                    <th style="width:42px;">
                                        <input
                                            type="checkbox"
                                            id="selectAllRejected"
                                            class="rj-checkbox"
                                            aria-label="Select all visible rejected leads"
                                        >
                                    </th>
                                @endcan

                                <th>#</th>
                                <th>{{ get_phrase('Title') }}</th>
                                <th>{{ get_phrase('Phone') }}</th>
                                <th>{{ get_phrase('Requirement') }}</th>
                                <th>{{ get_phrase('Category') }}</th>
                                <th>{{ get_phrase('Status') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody id="leadTableBody">
                            @forelse ($leads as $lead)
                                <tr>
                                    @can('lead-delete')
                                        <td>
                                            <input
                                                type="checkbox"
                                                name="lead_ids[]"
                                                value="{{ $lead->id }}"
                                                class="rj-checkbox rejected-lead-checkbox"
                                                aria-label="Select {{ $lead->name ?? 'lead' }}"
                                            >
                                        </td>
                                    @endcan

                                    <td>
                                        <span class="rj-number">
                                            {{ ($leads->firstItem() ?? 1) + $loop->index }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="rj-person">
                                            <div class="rj-avatar">
                                                {{ strtoupper(substr($lead->name ?? 'L', 0, 1)) }}
                                            </div>
                                            <strong>{{ $lead->name ?? '-' }}</strong>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="tel:{{ $lead->phone }}" class="rj-phone">
                                            <i class="bi bi-telephone"></i>
                                            {{ $lead->phone ?? '-' }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="rj-cut" title="{{ $lead->requirement ?? '-' }}">
                                            {{ $lead->requirement ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="rj-category">
                                            {{ $lead->leadcat->title ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <a
                                            href="javascript:void(0)"
                                            onclick="showRightModal(
                                                '{{ route('right_modal', ['view_path' => 'admin/leads/change_status', 'id' => $lead->id]) }}',
                                                '{{ get_phrase('Change status') }}'
                                            )"
                                            class="rj-status"
                                        >
                                            <span></span>
                                            Rejected
                                        </a>
                                    </td>

                                    <td>
                                        <div class="rj-actions">
                                            <a
                                                href="javascript:void(0)"
                                                class="rj-action"
                                                title="{{ get_phrase('Lead History') }}"
                                                onclick="showRightModal(
                                                    '{{ route('right_modal', ['view_path' => 'admin/leads/leadschat', 'id' => $lead->id]) }}',
                                                    '{{ get_phrase('Lead History') }}'
                                                )"
                                            >
                                                <i class="fi-rr-comments"></i>
                                            </a>

                                            <a
                                                href="javascript:void(0)"
                                                class="rj-action"
                                                title="{{ get_phrase('Lead Notes') }}"
                                                onclick="showRightModal(
                                                    '{{ route('right_modal', ['view_path' => 'admin/leads/callagaindetails', 'id' => $lead->id]) }}',
                                                    '{{ get_phrase('Lead Notes') }}'
                                                )"
                                            >
                                                <i class="fi-rr-document"></i>
                                            </a>

                                            @can('lead-edit')
                                                <a
                                                    href="javascript:void(0)"
                                                    class="rj-action"
                                                    title="{{ get_phrase('Edit lead') }}"
                                                    onclick="showRightModal(
                                                        '{{ route('right_modal', ['view_path' => 'admin/leads/edit', 'id' => $lead->id]) }}',
                                                        '{{ get_phrase('Edit lead') }}'
                                                    )"
                                                >
                                                    <i class="fi-rr-pencil"></i>
                                                </a>

                                                <a
                                                    href="javascript:void(0)"
                                                    class="rj-action"
                                                    title="{{ get_phrase('Change status') }}"
                                                    onclick="showRightModal(
                                                        '{{ route('right_modal', ['view_path' => 'admin/leads/change_status', 'id' => $lead->id]) }}',
                                                        '{{ get_phrase('Change status') }}'
                                                    )"
                                                >
                                                    <i class="fi-rr-refresh"></i>
                                                </a>
                                            @endcan

                                            @can('lead-delete')
                                                <a
                                                    href="javascript:void(0)"
                                                    class="rj-action rj-action-danger"
                                                    title="{{ get_phrase('Delete') }}"
                                                    onclick="confirmModal('{{ route('admin.lead.delete', $lead->id) }}')"
                                                >
                                                    <i class="fi-rr-trash"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="{{ auth()->user()->can('lead-delete') ? 8 : 7 }}"
                                        class="text-center text-muted py-5"
                                    >
                                        No rejected leads found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rj-mobile">
                @forelse ($leads as $lead)
                    <article class="rj-mobile-card">

                        <div class="rj-mobile-top">

                            <div class="rj-mobile-select-wrap">
                                @can('lead-delete')
                                    <input
                                        type="checkbox"
                                        name="lead_ids[]"
                                        value="{{ $lead->id }}"
                                        class="rj-checkbox rejected-lead-checkbox mobile-lead-checkbox"
                                        aria-label="Select {{ $lead->name ?? 'lead' }}"
                                    >
                                @endcan

                                <div class="rj-avatar rj-avatar-mobile">
                                    {{ strtoupper(substr($lead->name ?? 'L', 0, 1)) }}
                                </div>

                                <div class="rj-mobile-name">
                                    <strong>{{ $lead->name ?? 'Unnamed Lead' }}</strong>
                                    <small>Lead #{{ $lead->id }}</small>
                                </div>
                            </div>

                            <span class="rj-status">
                                <span></span>
                                Rejected
                            </span>

                        </div>

                        <a href="tel:{{ $lead->phone }}" class="rj-mobile-phone">
                            <div class="rj-mobile-phone-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>

                            <div>
                                <small>Phone</small>
                                <strong>{{ $lead->phone ?? 'No phone number' }}</strong>
                            </div>

                            <i class="bi bi-chevron-right"></i>
                        </a>

                        <div class="rj-mobile-grid">
                            <div class="rj-mobile-info">
                                <small>Category</small>
                                <strong>{{ $lead->leadcat->title ?? '-' }}</strong>
                            </div>

                            <div class="rj-mobile-info">
                                <small>Status</small>
                                <strong>Rejected</strong>
                            </div>
                        </div>

                        <div class="rj-mobile-copy">
                            <small>Requirement</small>
                            <p>{{ $lead->requirement ?? '-' }}</p>
                        </div>

                        <div class="rj-mobile-actions">
                            <a
                                href="javascript:void(0)"
                                class="rj-mobile-action"
                                onclick="showRightModal(
                                    '{{ route('right_modal', ['view_path' => 'admin/leads/leadschat', 'id' => $lead->id]) }}',
                                    '{{ get_phrase('Lead History') }}'
                                )"
                            >
                                <i class="fi-rr-comments"></i>
                                <span>History</span>
                            </a>

                            <a
                                href="javascript:void(0)"
                                class="rj-mobile-action"
                                onclick="showRightModal(
                                    '{{ route('right_modal', ['view_path' => 'admin/leads/callagaindetails', 'id' => $lead->id]) }}',
                                    '{{ get_phrase('Lead Notes') }}'
                                )"
                            >
                                <i class="fi-rr-document"></i>
                                <span>Notes</span>
                            </a>

                            @can('lead-edit')
                                <a
                                    href="javascript:void(0)"
                                    class="rj-mobile-action"
                                    onclick="showRightModal(
                                        '{{ route('right_modal', ['view_path' => 'admin/leads/edit', 'id' => $lead->id]) }}',
                                        '{{ get_phrase('Edit lead') }}'
                                    )"
                                >
                                    <i class="fi-rr-pencil"></i>
                                    <span>Edit</span>
                                </a>

                                <a
                                    href="javascript:void(0)"
                                    class="rj-mobile-action"
                                    onclick="showRightModal(
                                        '{{ route('right_modal', ['view_path' => 'admin/leads/change_status', 'id' => $lead->id]) }}',
                                        '{{ get_phrase('Change status') }}'
                                    )"
                                >
                                    <i class="fi-rr-refresh"></i>
                                    <span>Status</span>
                                </a>
                            @endcan
                        </div>

                    </article>
                @empty
                    <div class="text-center text-muted py-5">
                        No rejected leads found.
                    </div>
                @endforelse
            </div>

        </form>

        <form
            id="rejectedFilterForm"
            method="GET"
            action="{{ url()->current() }}"
            class="d-none"
        ></form>

        <div class="rj-footer">
            <div class="rj-footer-info">
                @if($leads->total() > 0)
                    Showing
                    <strong>{{ $leads->firstItem() }}</strong>
                    to
                    <strong>{{ $leads->lastItem() }}</strong>
                    of
                    <strong>{{ number_format($leads->total()) }}</strong>
                    rejected leads
                @else
                    No rejected leads
                @endif
            </div>

            @if($leads->hasPages())
                <div class="rj-pagination">
                    {{ $leads->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const perPageSelect = document.getElementById('perPageSelect');
    const customWrap = document.getElementById('customPerPageWrap');
    const filterForm = document.getElementById('rejectedFilterForm');
    const searchInput = document.getElementById('leadSearch');

    if (perPageSelect) {
        perPageSelect.addEventListener('change', function () {
            if (this.value === 'custom') {
                customWrap?.classList.add('show');
                document.getElementById('customPerPage')?.focus();
                return;
            }

            customWrap?.classList.remove('show');

            if (filterForm) {
                filterForm.submit();
            }
        });
    }

    let searchTimer = null;

    if (searchInput && filterForm) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                filterForm.submit();
            }, 550);
        });
    }

    const allCheckboxes = Array.from(
        document.querySelectorAll('.rejected-lead-checkbox')
    );

    const desktopCheckboxes = Array.from(
        document.querySelectorAll(
            '.rejected-lead-checkbox:not(.mobile-lead-checkbox)'
        )
    );

    const mobileCheckboxes = Array.from(
        document.querySelectorAll('.mobile-lead-checkbox')
    );

    const selectAll = document.getElementById('selectAllRejected');
    const bulkStrip = document.getElementById('bulkStrip');
    const selectedCount = document.getElementById('selectedCount');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const clearSelectionBtn = document.getElementById('clearSelectionBtn');
    const bulkForm = document.getElementById('bulkDeleteRejectedForm');

    function syncDuplicateCheckboxes(changed) {
        const value = changed.value;

        allCheckboxes.forEach(function (checkbox) {
            if (checkbox.value === value && checkbox !== changed) {
                checkbox.checked = changed.checked;
            }
        });
    }

    function selectedIds() {
        return [
            ...new Set(
                allCheckboxes
                    .filter(cb => cb.checked)
                    .map(cb => cb.value)
            )
        ];
    }

    function refreshBulkUi() {
        const ids = selectedIds();
        const count = ids.length;

        if (selectedCount) {
            selectedCount.textContent = count;
        }

        bulkStrip?.classList.toggle('show', count > 0);

        if (bulkDeleteBtn) {
            bulkDeleteBtn.disabled = count === 0;
        }

        if (selectAll) {
            const source = window.innerWidth <= 767.98
                ? mobileCheckboxes
                : desktopCheckboxes;

            const checkedCount = source.filter(cb => cb.checked).length;

            selectAll.checked =
                source.length > 0 &&
                checkedCount === source.length;

            selectAll.indeterminate =
                checkedCount > 0 &&
                checkedCount < source.length;
        }
    }

    allCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            syncDuplicateCheckboxes(this);
            refreshBulkUi();
        });
    });

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            desktopCheckboxes.forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
                syncDuplicateCheckboxes(checkbox);
            });

            refreshBulkUi();
        });
    }

    clearSelectionBtn?.addEventListener('click', function () {
        allCheckboxes.forEach(cb => cb.checked = false);

        if (selectAll) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        }

        refreshBulkUi();
    });

    bulkDeleteBtn?.addEventListener('click', function () {
        const ids = selectedIds();

        if (!ids.length || !bulkForm) {
            return;
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete selected rejected leads?',
                text: ids.length + ' selected lead(s) will be deleted permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#DC2626'
            }).then(function (result) {
                if (result.isConfirmed) {
                    submitBulkForm(ids);
                }
            });

            return;
        }

        if (confirm('Delete ' + ids.length + ' selected rejected lead(s)?')) {
            submitBulkForm(ids);
        }
    });

    function submitBulkForm(ids) {
        bulkForm
            .querySelectorAll('input[data-bulk-hidden="1"]')
            .forEach(el => el.remove());

        /*
         * Desktop + mobile duplicate checkboxes have the same lead IDs.
         * Disable visible checkbox inputs before submit and send one unique
         * hidden input per selected lead.
         */
        allCheckboxes.forEach(cb => cb.disabled = true);

        ids.forEach(function (id) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'lead_ids[]';
            input.value = id;
            input.dataset.bulkHidden = '1';
            bulkForm.appendChild(input);
        });

        bulkForm.submit();
    }

    refreshBulkUi();
});
</script>
@endpush


@push('css')
<style>
/* ============================================================
   CODE SPARROW — REJECTED LEADS / ULTRA ENTERPRISE UI LAYER
   Visual-only enhancement. Existing routes, forms, permissions,
   pagination, bulk selection and JavaScript remain unchanged.
============================================================ */
.rj-page{
    --rju-ink:#101828;
    --rju-sub:#475467;
    --rju-muted:#98A2B3;
    --rju-line:#E8ECF2;
    --rju-soft:#F8FAFC;
    --rju-danger:#D92D20;
    --rju-danger2:#B42318;
    --rju-cyan:#087F8C;
    --rju-cyan2:#066A75;
    position:relative;
    max-width:100%;
}
.rj-page:before{
    content:"";
    position:absolute;
    z-index:-1;
    top:-28px; left:-24px; right:-24px;
    height:190px;
    background:
        radial-gradient(circle at 8% 10%,rgba(8,127,140,.08),transparent 34%),
        radial-gradient(circle at 92% 15%,rgba(217,45,32,.065),transparent 30%);
    pointer-events:none;
}
.rj-header{
    position:relative;
    align-items:center;
    margin-bottom:20px;
    padding:19px 20px;
    border:1px solid rgba(228,231,236,.92);
    border-radius:18px;
    background:rgba(255,255,255,.94);
    box-shadow:0 14px 40px rgba(16,24,40,.055),0 1px 2px rgba(16,24,40,.025);
}
.rj-header:after{
    content:"";
    position:absolute;
    left:20px; bottom:-1px;
    width:72px; height:2px;
    border-radius:999px;
    background:linear-gradient(90deg,var(--rju-cyan),var(--rju-danger));
}
.rj-eyebrow{
    width:max-content;
    padding:5px 8px;
    margin-bottom:7px;
    border:1px solid #FECACA;
    border-radius:999px;
    background:#FFF6F5;
    color:var(--rju-danger);
    font-size:8px;
    letter-spacing:.12em;
}
.rj-title{
    font-size:27px;
    line-height:1.08;
    color:var(--rju-ink);
    font-weight:800;
}
.rj-subtitle{
    margin-top:7px;
    max-width:680px;
    color:#667085;
    font-size:10.5px;
    line-height:1.55;
}
.rj-summary{
    min-height:44px;
    padding:0 14px;
    border-color:#FECACA;
    border-radius:11px;
    background:linear-gradient(180deg,#FFF8F7,#FFF1F0);
    color:var(--rju-danger2);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.8);
}
.rj-summary i{
    width:24px;height:24px;
    border-radius:7px;
    background:#fff;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 1px 4px rgba(180,35,24,.10);
}
.rj-shell{
    border-color:#E4E7EC;
    border-radius:18px;
    box-shadow:0 16px 44px rgba(16,24,40,.06),0 2px 5px rgba(16,24,40,.025);
}
.rj-toolbar{
    position:relative;
    padding:14px 15px;
    background:linear-gradient(180deg,#FFFFFF 0%,#FCFDFE 100%);
}
.rj-toolbar:after{
    content:"";
    position:absolute;
    left:15px; right:15px; bottom:-1px;
    height:1px;
    background:linear-gradient(90deg,transparent,#E4E7EC 10%,#E4E7EC 90%,transparent);
}
.rj-btn{
    min-height:39px;
    padding:0 13px;
    border-radius:9px;
    font-size:9.5px;
    letter-spacing:.01em;
    transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease;
}
.rj-btn:hover{transform:translateY(-1px)}
.rj-btn-export{
    border-color:#D0D5DD;
    background:#fff;
    color:#344054;
    box-shadow:0 1px 2px rgba(16,24,40,.03);
}
.rj-btn-export:hover{
    border-color:#A6F4C5;
    background:#F6FEF9;
    color:#067647;
}
.rj-btn-primary{
    border-color:var(--rju-cyan);
    background:linear-gradient(135deg,#0A8D9B,#076F7A);
    box-shadow:0 5px 12px rgba(8,127,140,.14);
}
.rj-btn-danger{
    background:linear-gradient(135deg,#E5484D,#B42318);
    box-shadow:0 5px 12px rgba(217,45,32,.15);
}
.rj-search{width:min(390px,100%)}
.rj-search input,
.rj-per-page select,
.rj-custom-page input{
    height:40px;
    border-color:#DDE2E8;
    border-radius:9px;
    background:#fff;
    transition:border-color .15s ease,box-shadow .15s ease;
}
.rj-search input:focus,
.rj-per-page select:focus,
.rj-custom-page input:focus{
    border-color:#66C5CE;
    box-shadow:0 0 0 3px rgba(8,127,140,.07)!important;
}
.rj-tabs-wrap{
    padding:10px 14px 0;
    background:#fff;
}
.rj-tabs{gap:3px}
.rj-tabs .nav-link{
    min-height:37px;
    padding:8px 11px;
    border-radius:8px 8px 0 0;
    transition:background .15s ease,color .15s ease;
}
.rj-tabs .nav-link:hover{background:#F8FAFC;color:#344054}
.rj-tabs .nav-link.active{
    border-bottom-color:var(--rju-danger);
    background:linear-gradient(180deg,#FFF,#FFF5F4);
    color:var(--rju-danger2);
}
.rj-tabs .nav-link.active span{
    background:#FEE4E2;
    color:var(--rju-danger2);
}
.rj-bulk-strip{
    min-height:50px;
    padding:8px 15px;
    background:linear-gradient(90deg,#FFF4F3,#FFFAFA);
    border-bottom-color:#FECDCA;
}
.rj-selected-text{
    display:flex;
    align-items:center;
    gap:7px;
    font-size:9.5px;
}
.rj-selected-text:before{
    content:"";
    width:7px;height:7px;border-radius:50%;
    background:var(--rju-danger);
    box-shadow:0 0 0 4px rgba(217,45,32,.08);
}
.rj-table{font-size:9.5px}
.rj-table thead th{
    height:43px;
    padding:10px 12px;
    border-bottom-color:#DDE2E8;
    background:#F7F9FC;
    color:#667085;
    font-size:7.5px;
    letter-spacing:.065em;
}
.rj-table tbody td{
    height:54px;
    padding:9px 12px;
    border-bottom-color:#EEF1F5;
}
.rj-table tbody tr{
    transition:box-shadow .15s ease;
}
.rj-table tbody tr:hover td{
    background:#FBFDFE;
}
.rj-table tbody tr:hover{
    box-shadow:inset 3px 0 0 #65C7D0;
}
.rj-checkbox{
    width:15px;height:15px;
    border-radius:4px;
}
.rj-number{
    min-width:29px;
    height:26px;
    border-color:#EAECF0;
    background:#FCFCFD;
    color:#667085;
}
.rj-avatar{
    width:31px;height:31px;
    border:1px solid #FEE4E2;
    background:linear-gradient(145deg,#FFF7F6,#FEECEB);
    color:var(--rju-danger2);
}
.rj-person strong{
    color:#253047;
    font-weight:750;
}
.rj-phone{font-weight:600}
.rj-category{
    border-color:#DDE2E8;
    background:#F8FAFC;
    color:#475467;
}
.rj-status{
    padding:5px 8px;
    border-color:#FECDCA;
    background:#FFF4F3;
    color:var(--rju-danger2);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.8);
}
.rj-action{
    width:30px;height:30px;
    border-color:#E4E7EC;
    border-radius:8px;
    box-shadow:0 1px 2px rgba(16,24,40,.02);
    transition:transform .14s ease,box-shadow .14s ease,border-color .14s ease;
}
.rj-action:hover{
    transform:translateY(-1px);
    border-color:#9EDBE0;
    background:#F4FCFD;
    color:var(--rju-cyan2);
    box-shadow:0 4px 10px rgba(8,127,140,.07);
}
.rj-action-danger:hover{
    border-color:#FDA29B;
    background:#FFF4F3;
    color:var(--rju-danger);
    box-shadow:0 4px 10px rgba(217,45,32,.07);
}
.rj-footer{
    min-height:62px;
    padding:11px 15px;
    background:linear-gradient(180deg,#FCFDFE,#F9FAFB);
}
.rj-pagination .page-link{
    min-width:31px;
    min-height:31px;
    border-color:#E4E7EC;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:9px;
}
.rj-pagination .page-item.active .page-link{
    border-color:var(--rju-cyan);
    background:var(--rju-cyan);
    box-shadow:0 3px 8px rgba(8,127,140,.12);
}

/* Premium mobile workspace */
@media(max-width:767.98px){
    .rj-page{padding-left: 0px;padding-right: 0px}
    .rj-header{
        margin-bottom:12px;
        padding:15px;
        border-radius:14px;
        box-shadow:0 7px 20px rgba(16,24,40,.045);
    }
    .rj-header:after{left:15px}
    .rj-title{font-size:22px}
    .rj-summary{min-height:39px}
    .rj-shell{border-radius:14px}
    .rj-toolbar{
        padding:10px;
        gap:9px;
    }
    .rj-toolbar-left{display:grid;grid-template-columns:1fr 1fr;gap:6px}
    .rj-toolbar-left .rj-btn{width:100%}
    .rj-toolbar-right{gap:7px}
    .rj-search{order:0}
    .rj-per-page{
        width:100%;
        padding:7px 8px;
        border:1px solid #EAECF0;
        border-radius:9px;
        background:#F9FAFB;
    }
    .rj-per-page label{min-width:max-content}
    .rj-tabs-wrap{padding:8px 9px 0}
    .rj-tabs .nav-link{min-height:35px;padding:7px 9px}
    .rj-mobile{
        gap:9px;
        padding:9px;
        background:#F6F8FB;
    }
    .rj-mobile-card{
        position:relative;
        border-color:#E3E8EF;
        border-radius:14px;
        box-shadow:0 5px 14px rgba(16,24,40,.035);
    }
    .rj-mobile-card:before{
        content:"";
        position:absolute;
        top:0;bottom:0;left:0;
        width:3px;
        background:linear-gradient(180deg,#E5484D,#B42318);
    }
    .rj-mobile-top{padding:12px 12px 10px 14px}
    .rj-avatar-mobile{
        width:37px;height:37px;
        box-shadow:0 3px 8px rgba(180,35,24,.07);
    }
    .rj-mobile-phone{
        margin:0 12px 0 14px;
        border-color:#D5EEF1;
        background:linear-gradient(180deg,#F6FDFE,#EFFAFC);
    }
    .rj-mobile-phone-icon{
        background:linear-gradient(145deg,#0A8D9B,#066A75);
        box-shadow:0 4px 9px rgba(8,127,140,.13);
    }
    .rj-mobile-grid{padding-left:14px;padding-right:12px}
    .rj-mobile-info{
        border-color:#E7EBF0;
        background:#FAFBFC;
    }
    .rj-mobile-copy{margin-left:14px;margin-right:12px}
    .rj-mobile-actions{
        padding-left:14px;
        padding-right:12px;
        background:#FBFCFD;
    }
    .rj-mobile-action{
        border-color:#E4E7EC;
        background:#fff;
        box-shadow:0 1px 2px rgba(16,24,40,.02);
    }
    .rj-footer{
        padding:11px;
        background:#FAFBFC;
    }
}
@media(max-width:390px){
    .rj-toolbar-left{grid-template-columns:1fr}
}
</style>
@endpush




