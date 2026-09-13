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
        ->orderBy('name')
        ->get([
            'id',
            'name',
        ]);


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
@endphp


@push('css')
<style>

    /* =========================================================
       PIPELINE
       ========================================================= */

    .pipeline-wrapper {
        padding: 10px;
        min-height: 85vh;
        display: flex;
        gap: 16px;
        overflow-x: auto;
        align-items: flex-start;
    }

    .pipeline-column {
        min-width: 300px;
        width: 300px;
        background: #f8f9fc;
        border-radius: 12px;
        padding: 10px;
        border: 1px solid #e3e6f0;
        display: flex;
        flex-direction: column;
    }

    .pipeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
    }

    .pipeline-header h6 {
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .pipeline-body {
        min-height: 100px;
        max-height: 70vh;
        overflow-y: auto;
        padding-right: 4px;
    }

    .pipeline-body::-webkit-scrollbar {
        width: 5px;
    }

    .pipeline-body::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }


    /* =========================================================
       CARD
       ========================================================= */

    .pipeline-card {
        background: #fff;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 10px;
        border: 1px solid #e6e6e6;
        transition: .2s;
        cursor: grab;
    }

    .pipeline-card:hover {
        border-color: #1496D4;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
    }

    .pipeline-card:active {
        cursor: grabbing;
    }

    .dragging {
        opacity: .5;
        background: #e9ecef;
    }

    .lead-name {
        font-weight: 700;
        font-size: 14px;
        color: #111;
        margin-bottom: 5px;
    }

    .lead-info {
        font-size: 12px;
        color: #555;
        margin-bottom: 8px;
    }

    .lead-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .lead-user {
        font-size: 12px;
        color: #444;
    }

    .lead-value {
        font-size: 12px;
        font-weight: 700;
        color: #28a745;
    }

    .quotation-number {
        font-size: 11px;
        font-weight: 700;
        color: #1496D4;
    }

    .quotation-type {
        font-size: 10px;
        padding: 3px 7px;
        border-radius: 20px;
        background: #EAF7FD;
        color: #0876aa;
        font-weight: 700;
        text-transform: capitalize;
    }

    .lead-actions a {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }


    /* =========================================================
       QUOTATION PENDING ACTIONS
       ========================================================= */

    .pending-quotation-actions {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .pending-quotation-actions small {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: #6b7280;
    }

    .pending-quotation-buttons {
        display: flex;
        gap: 7px;
    }

    .pending-quotation-buttons .btn {
        flex: 1;
        font-size: 11px;
        white-space: nowrap;
    }


    /* =========================================================
       QUICK QUOTATION
       ========================================================= */

    .lm-quote-modal {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
    }

    .lm-quote-row {
        position: relative;
        padding: 15px;
        margin-bottom: 12px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .lm-quote-remove {
        position: absolute;
        right: 8px;
        top: 8px;
        border: 0;
        background: #fff0ee;
        color: #F12617;
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
        color: #9ca3af;
        margin: 5px 0 10px;
    }

    .lm-quote-add {
        border: 0;
        background: transparent;
        color: #1496D4;
        padding: 5px 0;
        font-weight: 600;
    }

    .lm-quote-switch {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .lm-quote-switch small {
        display: block;
        color: #6b7280;
    }

    .lm-field-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .lm-quote-summary {
        margin-top: 18px;
        border-top: 1px solid #eee;
        padding-top: 12px;
    }

    .lm-quote-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 7px;
        font-size: 13px;
    }

    .lm-quote-total {
        background: #EAF7FD;
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        font-size: 16px;
    }

    .lm-quote-status {
        font-size: 13px;
        margin-bottom: 8px;
    }

    .lm-quote-status.success {
        color: #198754;
    }

    .lm-quote-status.error {
        color: #dc3545;
    }


    /* =========================================================
       DETAILED QUOTATION
       ========================================================= */

    .lm-detail-quote-modal {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
    }

    .lm-detail-quote-eyebrow {
        color: #F12617;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .lm-detail-quote-lead {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #EAF7FD;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
    }

    .lm-detail-quote-lead-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #1496D4;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lm-detail-quote-lead small {
        display: block;
        color: #6b7280;
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
        color: #9ca3af;
    }

    .lm-detail-quote-search input {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px 12px 10px 38px;
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
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 11px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .lm-detail-quote-item input:checked + .lm-detail-quote-card {
        border-color: #1496D4;
        background: #EAF7FD;
    }

    .lm-detail-quote-pdf {
        color: #F12617;
        font-size: 22px;
    }

    .lm-detail-quote-copy {
        flex: 1;
    }

    .lm-detail-quote-copy strong,
    .lm-detail-quote-copy small {
        display: block;
    }

    .lm-detail-quote-copy small {
        color: #6b7280;
    }

    .lm-detail-quote-check {
        color: #1496D4;
    }

    .lm-detail-quote-preview {
        display: none;
        margin-top: 12px;
    }

    .lm-detail-quote-preview.is-visible {
        display: block;
    }

    .lm-detail-quote-preview a {
        color: #1496D4;
        font-weight: 600;
        text-decoration: none;
    }

    .lm-detail-quote-status {
        font-size: 13px;
        margin-top: 10px;
    }

    .lm-detail-quote-status.success {
        color: #198754;
    }

    .lm-detail-quote-status.error {
        color: #dc3545;
    }

    .lm-detail-quote-send {
        background: #25D366;
        color: white;
    }

    .lm-detail-quote-send:hover {
        background: #1fb85a;
        color: white;
    }

    .lm-detail-quote-empty {
        padding: 20px;
        text-align: center;
        color: #6b7280;
    }

</style>
@endpush


@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">

        <div class="d-flex flex-column">

            <h4>{{ get_phrase('Sales Pipeline') }}</h4>

            <ul class="d-flex align-items-center eBreadcrumb-2">

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        {{ get_phrase('Dashboard') }}
                    </a>
                </li>

                <li>
                    <a href="#">
                        {{ get_phrase('Sales Pipeline') }}
                    </a>
                </li>

            </ul>

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
        @endphp

        <div class="pipeline-column">

            <div class="pipeline-header">
                <h6>{{ $stage }}</h6>

                <span class="badge bg-dark">
                    {{ $stageCount }}
                </span>
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
                    >

                        <div class="d-flex justify-content-between align-items-center gap-2 mb-1">

                            <div class="lead-name">
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
                            <i class="fi-rr-phone-call pe-2"></i>
                            {{ $lead->phone ?: 'No Phone' }}
                        </div>

                        <div class="lead-footer">
                            <span class="lead-user">
                                {{ $lead->userlead->name ?? 'Unassigned' }}
                            </span>
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

                            <span class="quotation-type">
                                Proforma
                            </span>

                        </div>

                        <div class="lead-name">
                            {{ \Illuminate\Support\Str::limit($proformaCustomerName, 22) }}
                        </div>

                        @if($proformaPhone)
                            <div class="lead-info">
                                <i class="fi-rr-phone-call pe-2"></i>
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
                            <i class="fi-rr-calendar pe-2"></i>
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

                        <select
                            class="form-select form-select-sm change-proforma-stage"
                            data-id="{{ $proforma->id }}"
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
                                @if(strtolower($quotation->quotation_type ?? '') === 'quick')
                                    Quick Proposal
                                @else
                                    Detailed Proposal
                                @endif
                            </span>

                        </div>

                        <div class="lead-name">
                            {{ \Illuminate\Support\Str::limit($customerName, 22) }}
                        </div>

                        @if($customerPhone)
                            <div class="lead-info">
                                <i class="fi-rr-phone-call pe-2"></i>
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
                            <i class="fi-rr-calendar pe-2"></i>
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

                @endforeach


                @if($stageCount === 0)
                    <p class="text-muted small pipeline-empty">
                        {{ get_phrase('No records') }}
                    </p>
                @endif

            </div>

        </div>

    @endforeach

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


                <div class="lm-detail-quote-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="detailQuoteSearch"
                        placeholder="{{ get_phrase('Search detailed quotation...') }}"
                        oninput="filterDetailedQuotations(this.value)"
                    >

                </div>


                <div
                    class="lm-detail-quote-list"
                    id="detailQuoteList"
                >

                   @forelse ($detailedQuotations as $detailedQuotation)

                        <label
                            class="lm-detail-quote-item"
                            data-quotation-name="{{ strtolower($detailedQuotation->name) }}"
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


        let message =
            `*PROFORMA*\n`;


        if (proformaNo) {

            message +=
                `*Proforma No: ${proformaNo}*\n`;

        }


        message +=
            `\nDear ${customerName},\n\n`;


        data.products.forEach(
            function(product, index) {

                message +=
                    `*${index + 1}. ${product.name}*\n`;

                message +=
                    `HSN: ${product.hsn_code}\n`;

                message +=
                    `Price: ₹${product.price.toFixed(2)}\n`;

                message +=
                    `Quantity: ${product.quantity}\n`;

                message +=
                    `Amount: ₹${product.total.toFixed(2)}\n\n`;

            }
        );


        message +=
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
            `*Total: ₹${data.total.toFixed(2)}/-*\n`;


        if (data.note) {

            message +=
                `\nNote: ${data.note}`;

        }


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
                    '';

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


    function filterDetailedQuotations(
        searchValue
    )
    {
        const search =
            String(
                searchValue || ''
            )
            .trim()
            .toLowerCase();


        document
            .querySelectorAll(
                '.lm-detail-quote-item'
            )
            .forEach(function(item) {

                const name =
                    String(
                        item.dataset
                            .quotationName ||
                        ''
                    )
                    .toLowerCase();


                item.style.display =
                    !search ||
                    name.includes(search)
                        ? ''
                        : 'none';

            });
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


            const message =
                `Hello ${leadName},\n\n` +
                `Please find the *${quotationName}* detailed quotation below:\n\n` +
                `${pdfUrl}\n\n` +
                `Thank you.`;



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

                    updateLeadStage(
                        leadId,
                        newStage
                    );
                }
            );
        });


    async function updateLeadStage(
        leadId,
        newStage
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

                    updateProformaStage(
                        this.dataset.id,
                        this.value
                    );
                }
            );
        });


    async function updateProformaStage(
        proformaId,
        newStage
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

                    updateQuotationStage(
                        quotationId,
                        newStage
                    );
                }
            );
        });


    async function updateQuotationStage(
        quotationId,
        newStage
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

        // 

</script>

@endpush
