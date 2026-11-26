@extends('index')

@push('title', 'Imported Leads')

@section('content')

<div class="container-fluid imported-leads-page">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="imported-leads-header">

        <div class="imported-leads-header-left">

            <a
                href="{{ route('admin.leads.import.history') }}"
                class="imported-back-btn"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>


            <div class="imported-title-wrap">

                <div class="imported-eyebrow">
                    Import Batch #{{ $batch->id }}
                </div>

                <h3 class="imported-page-title">
                    Imported Leads
                </h3>

                <div class="imported-page-subtitle">
                    {{ $batch->original_file_name }}
                </div>

            </div>

        </div>


        <div class="imported-header-actions">

            <a
                href="{{ route('admin.leads.import.history.open', $batch->id) }}"
                class="imported-action-btn"
            >
                <i class="bi bi-eye"></i>
                Open File
            </a>


            <a
                href="{{ route('admin.leads.import.history.download', $batch->id) }}"
                class="imported-action-btn imported-action-btn-primary"
            >
                <i class="bi bi-download"></i>
                Download
            </a>

        </div>

    </div>


    {{-- =========================================================
        BATCH SUMMARY
    ========================================================== --}}
    <div class="imported-summary-grid">

        {{-- TOTAL LEADS --}}
        <div class="imported-summary-card">

            <div class="imported-summary-icon">
                <i class="bi bi-people"></i>
            </div>

            <div>

                <span class="imported-summary-label">
                    Imported Leads
                </span>

                <strong class="imported-summary-value">
                    {{ number_format($leads->total()) }}
                </strong>

            </div>

        </div>


        {{-- CATEGORY --}}
        <div class="imported-summary-card">

            <div class="imported-summary-icon category">
                <i class="bi bi-tag"></i>
            </div>

            <div>

                <span class="imported-summary-label">
                    Category
                </span>

                <strong class="imported-summary-text">
                    {{ $batch->category->title ?? '-' }}
                </strong>

            </div>

        </div>


        {{-- SALES --}}
        <div class="imported-summary-card">

            <div class="imported-summary-icon sales">
                <i class="bi bi-person-check"></i>
            </div>

            <div>

                <span class="imported-summary-label">
                    Assigned Sales
                </span>

                <strong class="imported-summary-text">
                    {{ $batch->salesUser->name ?? '-' }}
                </strong>

            </div>

        </div>


        {{-- STATUS --}}
        <div class="imported-summary-card">

            <div class="imported-summary-icon status">
                <i class="bi bi-check-circle"></i>
            </div>

            <div>

                <span class="imported-summary-label">
                    Batch Status
                </span>

                @php
                    $batchStatus = strtolower($batch->status ?? 'pending');
                @endphp

                @if($batchStatus === 'completed')

                    <span class="imported-status imported-status-success">
                        <span class="imported-status-dot"></span>
                        Completed
                    </span>

                @elseif($batchStatus === 'failed')

                    <span class="imported-status imported-status-danger">
                        <span class="imported-status-dot"></span>
                        Failed
                    </span>

                @else

                    <span class="imported-status imported-status-warning">
                        <span class="imported-status-dot"></span>
                        Pending
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN TABLE PANEL
    ========================================================== --}}
    <div class="imported-table-panel">

        <div class="imported-table-panel-header">

            <div>

                <span class="imported-panel-eyebrow">
                    Batch Records
                </span>

                <h5 class="imported-panel-title">
                    Lead Data
                </h5>

                <p class="imported-panel-subtitle">
                    Showing leads linked with this import batch.
                </p>

            </div>


            <div class="imported-panel-count">

                <i class="bi bi-database"></i>

                <span>
                    {{ number_format($leads->total()) }}
                    {{ $leads->total() == 1 ? 'record' : 'records' }}
                </span>

            </div>

        </div>


        <div class="imported-table-scroll">

            <table class="imported-leads-table">

                <thead>

                    <tr>

                        <th class="col-id">
                            #
                        </th>

                        <th>
                            Lead Name
                        </th>

                        <th>
                            Phone
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Assigned Sales
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($leads as $lead)

                        @php
                            $status = strtolower($lead->status ?? '');

                            $statusClass = match ($status) {
                                'pending' => 'status-pending',
                                'contacted' => 'status-contacted',
                                'accept' => 'status-accept',
                                'reject' => 'status-reject',
                                'call' => 'status-call',
                                'quick-quotation' => 'status-quotation',
                                'detailed-quotation' => 'status-quotation',
                                default => 'status-neutral',
                            };
                        @endphp


                        <tr>

                            {{-- ID --}}
                            <td class="lead-id-cell">

                                <span class="lead-id-badge">
                                    {{ $lead->id }}
                                </span>

                            </td>


                            {{-- NAME --}}
                            <td>

                                <div class="lead-person">

                                    <div class="lead-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $lead->name ?? 'L',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <div class="lead-person-copy">

                                        <strong>
                                            {{ $lead->name ?? '-' }}
                                        </strong>

                                        <span>
                                            Lead #{{ $lead->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- PHONE --}}
                            <td>

                                <div class="lead-contact-cell">

                                    <i class="bi bi-telephone"></i>

                                    <span>
                                        {{ $lead->phone ?? '-' }}
                                    </span>

                                </div>

                            </td>


                            {{-- EMAIL --}}
                            <td>

                                <div class="lead-contact-cell">

                                    <i class="bi bi-envelope"></i>

                                    <span
                                        class="lead-email-text"
                                        title="{{ $lead->email ?? '-' }}"
                                    >
                                        {{ $lead->email ?? '-' }}
                                    </span>

                                </div>

                            </td>


                            {{-- CATEGORY --}}
                            <td>

                                <span class="lead-category-badge">

                                    <i class="bi bi-tag"></i>

                                    {{ $lead->leadcat->title ?? '-' }}

                                </span>

                            </td>


                            {{-- SALES --}}
                            <td>

                                <div class="lead-sales-cell">

                                    <div class="lead-sales-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $lead->assignedUser->name ?? 'S',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>

                                    <span>
                                        {{ $lead->assignedUser->name ?? '-' }}
                                    </span>

                                </div>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span class="lead-status-badge {{ $statusClass }}">

                                    <span class="lead-status-dot"></span>

                                    {{ ucfirst(
                                        str_replace(
                                            '-',
                                            ' ',
                                            $lead->status ?? '-'
                                        )
                                    ) }}

                                </span>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="imported-empty-cell"
                            >

                                <div class="imported-empty-state">

                                    <div class="imported-empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>

                                    <strong>
                                        No imported leads found
                                    </strong>

                                    <span>
                                        This batch does not currently have linked lead records.
                                    </span>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
            FOOTER / PAGINATION
        ====================================================== --}}
        <div class="imported-table-footer">

            <div class="imported-pagination-info">

                @if($leads->total() > 0)

                    Showing
                    <strong>
                        {{ $leads->firstItem() ?? 0 }}
                    </strong>

                    to

                    <strong>
                        {{ $leads->lastItem() ?? 0 }}
                    </strong>

                    of

                    <strong>
                        {{ $leads->total() }}
                    </strong>

                    leads

                @else

                    No records

                @endif

            </div>


            @if($leads->hasPages())

                <div class="imported-pagination">

                    {{ $leads->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<style>

    /*
    |--------------------------------------------------------------------------
    | ROOT
    |--------------------------------------------------------------------------
    */

    .imported-leads-page {

        --imp-primary: #0F8EA3;
        --imp-primary-dark: #0B7386;

        --imp-dark: #1F2937;

        --imp-border: #E5E7EB;
        --imp-bg: #F8FAFC;

        --imp-muted: #667085;
        --imp-light: #98A2B3;

        padding-bottom: 30px;

        color: var(--imp-dark);
    }


    .imported-leads-page * {
        box-sizing: border-box;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    .imported-leads-header {
        margin-bottom: 18px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        flex-wrap: wrap;
    }


    .imported-leads-header-left {
        min-width: 0;

        display: flex;
        align-items: center;

        gap: 14px;
    }


    .imported-back-btn {
        width: 40px;
        height: 40px;

        border: 1px solid var(--imp-border);
        border-radius: 9px;

        background: #fff;
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        text-decoration: none;

        flex-shrink: 0;

        transition:
            background .15s ease,
            color .15s ease,
            border-color .15s ease;
    }


    .imported-back-btn span {
        display: none;
    }


    .imported-back-btn:hover {
        background: #F8FAFC;
        color: var(--imp-dark);

        border-color: #D0D5DD;
    }


    .imported-title-wrap {
        min-width: 0;
    }


    .imported-eyebrow {
        color: var(--imp-primary);

        font-size: 9px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .08em;
    }


    .imported-page-title {
        margin: 3px 0 2px;

        color: var(--imp-dark);

        font-size: 24px;
        font-weight: 750;

        letter-spacing: -.02em;
    }


    .imported-page-subtitle {
        max-width: 650px;

        color: var(--imp-muted);

        font-size: 11px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    .imported-header-actions {
        display: flex;
        align-items: center;

        gap: 7px;
    }


    .imported-action-btn {
        min-height: 39px;

        padding: 0 13px;

        border: 1px solid var(--imp-border);
        border-radius: 8px;

        background: #fff;
        color: #475467;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        text-decoration: none;

        font-size: 10px;
        font-weight: 650;

        transition:
            background .15s ease,
            color .15s ease,
            border-color .15s ease;
    }


    .imported-action-btn:hover {
        background: #F8FAFC;
        color: var(--imp-dark);
    }


    .imported-action-btn-primary {
        border-color: var(--imp-primary-dark);

        background:
            linear-gradient(
                180deg,
                var(--imp-primary) 0%,
                var(--imp-primary-dark) 100%
            );

        color: #fff;

        box-shadow:
            0 1px 2px
            rgba(15, 142, 163, .16);
    }


    .imported-action-btn-primary:hover {
        color: #fff;

        filter: brightness(1.05);
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY
    |--------------------------------------------------------------------------
    */

    .imported-summary-grid {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0, 1fr)
            );

        gap: 12px;

        margin-bottom: 18px;
    }


    .imported-summary-card {
        min-height: 92px;

        padding: 15px;

        border: 1px solid var(--imp-border);
        border-radius: 12px;

        background: #fff;

        display: flex;
        align-items: center;

        gap: 11px;

        box-shadow:
            0 1px 2px
            rgba(16, 24, 40, .02);
    }


    .imported-summary-icon {
        width: 38px;
        height: 38px;

        border-radius: 10px;

        background: #F1F5F9;
        color: #475467;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 15px;
    }


    .imported-summary-icon.category {
        background: #ECFEFF;
        color: var(--imp-primary);
    }


    .imported-summary-icon.sales {
        background: #EFF6FF;
        color: #2563EB;
    }


    .imported-summary-icon.status {
        background: #F0FDF4;
        color: #16A34A;
    }


    .imported-summary-label {
        display: block;

        margin-bottom: 3px;

        color: var(--imp-light);

        font-size: 9px;
        font-weight: 650;
    }


    .imported-summary-value {
        display: block;

        color: var(--imp-dark);

        font-size: 21px;
        font-weight: 750;

        line-height: 1;
    }


    .imported-summary-text {
        display: block;

        max-width: 180px;

        color: #344054;

        font-size: 11px;
        font-weight: 700;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    .imported-status,
    .lead-status-badge {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        border-radius: 100px;

        white-space: nowrap;
    }


    .imported-status {
        padding: 5px 8px;

        font-size: 9px;
        font-weight: 700;
    }


    .imported-status-dot,
    .lead-status-dot {
        width: 5px;
        height: 5px;

        border-radius: 50%;

        background: currentColor;

        flex-shrink: 0;
    }


    .imported-status-success {
        background: #F0FDF4;
        color: #16A34A;
    }


    .imported-status-warning {
        background: #FFFBEB;
        color: #D97706;
    }


    .imported-status-danger {
        background: #FEF2F2;
        color: #DC2626;
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE PANEL
    |--------------------------------------------------------------------------
    */

    .imported-table-panel {
        overflow: hidden;

        border: 1px solid var(--imp-border);
        border-radius: 14px;

        background: #fff;

        box-shadow:
            0 1px 2px
            rgba(16, 24, 40, .02);
    }


    .imported-table-panel-header {
        min-height: 72px;

        padding: 15px 18px;

        border-bottom: 1px solid #EDF0F4;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;
    }


    .imported-panel-eyebrow {
        color: var(--imp-primary);

        font-size: 8px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .08em;
    }


    .imported-panel-title {
        margin: 2px 0;

        color: var(--imp-dark);

        font-size: 14px;
        font-weight: 700;
    }


    .imported-panel-subtitle {
        margin: 0;

        color: var(--imp-light);

        font-size: 9px;
    }


    .imported-panel-count {
        padding: 6px 9px;

        border: 1px solid #EAECF0;
        border-radius: 7px;

        background: #F9FAFB;
        color: #667085;

        display: flex;
        align-items: center;

        gap: 6px;

        font-size: 9px;
        font-weight: 600;
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    .imported-table-scroll {
        width: 100%;

        overflow-x: auto;
    }


    .imported-leads-table {
        width: 100%;

        min-width: 1000px;

        margin: 0;

        border-collapse: separate;
        border-spacing: 0;

        color: #344054;

        font-size: 10px;
    }


    .imported-leads-table thead th {
        position: sticky;
        top: 0;

        z-index: 3;

        padding: 11px 13px;

        border-bottom: 1px solid #DDE2E8;

        background: #F8FAFC;
        color: #667085;

        text-align: left;

        font-size: 8.5px;
        font-weight: 750;

        text-transform: uppercase;
        letter-spacing: .04em;

        white-space: nowrap;
    }


    .imported-leads-table tbody td {
        padding: 11px 13px;

        border-bottom: 1px solid #EEF1F4;

        background: #fff;

        vertical-align: middle;
    }


    .imported-leads-table tbody tr:last-child td {
        border-bottom: none;
    }


    .imported-leads-table tbody tr {
        transition: background .15s ease;
    }


    .imported-leads-table tbody tr:hover td {
        background: #FCFDFE;
    }


    .col-id {
        width: 70px;
    }


    /*
    |--------------------------------------------------------------------------
    | ID
    |--------------------------------------------------------------------------
    */

    .lead-id-badge {
        min-width: 34px;
        height: 27px;

        padding: 0 7px;

        border: 1px solid #E4E7EC;
        border-radius: 6px;

        background: #F9FAFB;
        color: #667085;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        font-size: 9px;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | LEAD PERSON
    |--------------------------------------------------------------------------
    */

    .lead-person {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    .lead-avatar {
        width: 31px;
        height: 31px;

        border-radius: 8px;

        background:
            linear-gradient(
                180deg,
                #ECFEFF,
                #DDF7FA
            );

        color: var(--imp-primary-dark);

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 10px;
        font-weight: 800;
    }


    .lead-person-copy {
        min-width: 0;
    }


    .lead-person-copy strong {
        display: block;

        max-width: 200px;

        color: #344054;

        font-size: 10.5px;
        font-weight: 700;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    .lead-person-copy span {
        display: block;

        margin-top: 1px;

        color: #98A2B3;

        font-size: 8px;
    }


    /*
    |--------------------------------------------------------------------------
    | CONTACT
    |--------------------------------------------------------------------------
    */

    .lead-contact-cell {
        display: flex;
        align-items: center;

        gap: 6px;

        color: #475467;
    }


    .lead-contact-cell i {
        color: #98A2B3;

        font-size: 10px;
    }


    .lead-email-text {
        display: block;

        max-width: 210px;

        overflow: hidden;

        text-overflow: ellipsis;
        white-space: nowrap;
    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    .lead-category-badge {
        padding: 5px 7px;

        border: 1px solid #D7F0F4;
        border-radius: 6px;

        background: #F3FCFD;
        color: var(--imp-primary-dark);

        display: inline-flex;
        align-items: center;

        gap: 4px;

        font-size: 8.5px;
        font-weight: 650;

        white-space: nowrap;
    }


    /*
    |--------------------------------------------------------------------------
    | SALES
    |--------------------------------------------------------------------------
    */

    .lead-sales-cell {
        display: flex;
        align-items: center;

        gap: 6px;
    }


    .lead-sales-avatar {
        width: 27px;
        height: 27px;

        border-radius: 50%;

        background: #EFF6FF;
        color: #2563EB;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 8px;
        font-weight: 800;
    }


    .lead-sales-cell span {
        max-width: 150px;

        color: #475467;

        font-size: 9px;
        font-weight: 600;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /*
    |--------------------------------------------------------------------------
    | LEAD STATUS
    |--------------------------------------------------------------------------
    */

    .lead-status-badge {
        padding: 5px 7px;

        font-size: 8.5px;
        font-weight: 700;
    }


    .status-pending {
        background: #FFFBEB;
        color: #D97706;
    }


    .status-contacted {
        background: #EFF6FF;
        color: #2563EB;
    }


    .status-accept {
        background: #F0FDF4;
        color: #16A34A;
    }


    .status-reject {
        background: #FEF2F2;
        color: #DC2626;
    }


    .status-call {
        background: #F5F3FF;
        color: #7C3AED;
    }


    .status-quotation {
        background: #F0FDFA;
        color: #0F766E;
    }


    .status-neutral {
        background: #F2F4F7;
        color: #667085;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY
    |--------------------------------------------------------------------------
    */

    .imported-empty-cell {
        padding: 50px 20px !important;
    }


    .imported-empty-state {
        text-align: center;
    }


    .imported-empty-icon {
        width: 50px;
        height: 50px;

        margin: 0 auto 10px;

        border-radius: 12px;

        background: #F1F5F9;
        color: #667085;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 19px;
    }


    .imported-empty-state strong {
        display: block;

        color: #344054;

        font-size: 11px;
    }


    .imported-empty-state span {
        display: block;

        margin-top: 3px;

        color: #98A2B3;

        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | FOOTER
    |--------------------------------------------------------------------------
    */

    .imported-table-footer {
        min-height: 56px;

        padding: 10px 16px;

        border-top: 1px solid #EDF0F4;

        background: #FCFDFE;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;
    }


    .imported-pagination-info {
        color: #98A2B3;

        font-size: 9px;
    }


    .imported-pagination-info strong {
        color: #475467;
    }


    .imported-pagination {
        margin-left: auto;
    }


    .imported-pagination .pagination {
        margin: 0;
    }


    .imported-pagination .page-link {
        color: #475467;

        font-size: 10px;

        border-color: var(--imp-border);
    }


    .imported-pagination .page-item.active .page-link {
        border-color: var(--imp-primary);

        background: var(--imp-primary);

        color: #fff;
    }


    /*
    |--------------------------------------------------------------------------
    | TABLET
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1199px) {

        .imported-summary-grid {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .imported-leads-page {
            padding-left: 8px;
            padding-right: 8px;
        }


        .imported-leads-header {
            align-items: flex-start;
        }


        .imported-leads-header-left {
            width: 100%;

            align-items: flex-start;
        }


        .imported-page-title {
            font-size: 20px;
        }


        .imported-page-subtitle {
            max-width: 230px;
        }


        .imported-header-actions {
            width: 100%;
        }


        .imported-action-btn {
            flex: 1;
        }


        .imported-summary-grid {
            grid-template-columns: 1fr;
        }


        .imported-table-panel-header {
            align-items: flex-start;

            flex-direction: column;
        }


        .imported-table-footer {
            align-items: flex-start;

            flex-direction: column;
        }


        .imported-pagination {
            width: 100%;

            margin-left: 0;
        }

    }

</style>

@endsection