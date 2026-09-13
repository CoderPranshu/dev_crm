@extends('index')

@push('title', get_phrase('Quotation'))

@push('meta')
@endpush

@push('css')
    <style>
        .quotation-filter-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .quotation-type-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .quotation-type-regular {
            background: #e8f0ff;
            color: #2457c5;
        }

        .quotation-type-quick {
            background: #fff1e7;
            color: #d56500;
        }

        .quotation-type-detailed {
            background: #f3efff;
            color: #6941c6;
        }

        .quotation-total {
            font-weight: 700;
            white-space: nowrap;
        }

        .quotation-client-name {
            font-weight: 600;
            color: #252525;
        }

        .quotation-client-phone {
            display: block;
            margin-top: 2px;
            font-size: 12px;
            color: #777;
        }

        .quotation-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            text-decoration: none;
            transition: .2s ease;
        }

        .quotation-action-btn:hover {
            background: #f1f4f8;
        }

        .quotation-search-form .form-control,
        .quotation-search-form .form-select {
            min-height: 42px;
        }

        @media (max-width: 767px) {
            .quotation-filter-card {
                padding: 12px;
            }
        }
    </style>
@endpush


@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">

            <div class="d-flex flex-column">

                <h4>
                    {{ get_phrase('Quotation') }}
                </h4>

                <ul class="d-flex align-items-center eBreadcrumb-2">

                    <li>
                        <a href="#">
                            {{ get_phrase('Dashboard') }}
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            {{ get_phrase('Quotation') }}
                        </a>
                    </li>

                </ul>

            </div>


            <div class="export-btn-area">

                <a href="{{ route('admin.quotation.create') }}"
                   class="export_btn">

                    <i class="bi bi-plus"></i>

                    <span class="d-none d-sm-inline-block">
                        {{ get_phrase('Add new quotation') }}
                    </span>

                </a>

            </div>

        </div>
    </div>



    {{-- FILTERS --}}
    <div class="quotation-filter-card">

        <form method="GET"
              action="{{ route('admin.quotation.index') }}"
              class="quotation-search-form">

            <div class="row g-2 align-items-end">


                {{-- SEARCH --}}
                <div class="col-lg-4 col-md-6">

                    <label class="form-label">
                        {{ get_phrase('Search') }}
                    </label>

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Quotation, company, lead or phone"
                           value="{{ request('search') }}">

                </div>



                {{-- TYPE --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        {{ get_phrase('Quotation Type') }}
                    </label>

                    <select name="type"
                            class="form-select">

                        <option value="">
                            {{ get_phrase('All Quotations') }}
                        </option>

                        <option value="regular"
                            {{ request('type') === 'regular' ? 'selected' : '' }}>
                            {{ get_phrase('Regular Quotation') }}
                        </option>

                        <option value="quick"
                            {{ request('type') === 'quick' ? 'selected' : '' }}>
                            {{ get_phrase('Quick Quotation') }}
                        </option>

                        <option value="detailed"
                            {{ request('type') === 'detailed' ? 'selected' : '' }}>
                            {{ get_phrase('Detailed Quotation') }}
                        </option>

                    </select>

                </div>



                {{-- DATE FROM --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        {{ get_phrase('From Date') }}
                    </label>

                    <input type="date"
                           name="from_date"
                           class="form-control"
                           value="{{ request('from_date') }}">

                </div>



                {{-- DATE TO --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        {{ get_phrase('To Date') }}
                    </label>

                    <input type="date"
                           name="to_date"
                           class="form-control"
                           value="{{ request('to_date') }}">

                </div>



                {{-- FILTER BUTTON --}}
                <div class="col-lg-1 col-md-6">

                    <button type="submit"
                            class="btn btn-primary w-100">

                        <i class="fi-rr-filter"></i>

                    </button>

                </div>

            </div>


            @if(
                request()->filled('search') ||
                request()->filled('type') ||
                request()->filled('from_date') ||
                request()->filled('to_date')
            )

                <div class="mt-2">

                    <a href="{{ route('admin.quotation.index') }}"
                       class="btn btn-sm btn-light">

                        <i class="fi-rr-refresh"></i>
                        Reset Filters

                    </a>

                </div>

            @endif

        </form>

    </div>



    <div class="row">

        <div class="col-md-12">

            <div class="eSection-wrap">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <p class="column-title mb-0">
                        {{ get_phrase('Quotation List') }}
                    </p>

                    @if(method_exists($quotations, 'total'))

                        <span class="text-muted small">
                            Total: {{ $quotations->total() }}
                        </span>

                    @endif

                </div>



                <div class="table-responsive">

                    <table class="table eTable align-middle">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>
                                    {{ get_phrase('Quotation') }}
                                </th>

                                <th>
                                    {{ get_phrase('Customer / Lead') }}
                                </th>

                                <th>
                                    {{ get_phrase('Type') }}
                                </th>

                                <th>
                                    {{ get_phrase('Created By') }}
                                </th>

                                <th>
                                    {{ get_phrase('Date') }}
                                </th>

                                <th>
                                    {{ get_phrase('Due Date') }}
                                </th>

                                <th>
                                    {{ get_phrase('Sales Credit') }}
                                </th>

                                <th>
                                    {{ get_phrase('Total') }}
                                </th>

                                <th class="text-center">
                                    {{ get_phrase('Action') }}
                                </th>

                            </tr>

                        </thead>



                        <tbody>

                            @forelse ($quotations as $quotation)

                                @php

                                    /*
                                    |--------------------------------------------------------------------------
                                    | QUOTATION TYPE
                                    |--------------------------------------------------------------------------
                                    |
                                    | Detailed quotations also have lead_id, so lead_id alone
                                    | must not decide the quotation type.
                                    |
                                    */

                                    $quotationType =
                                        !empty($quotation->quotation_type)
                                            ? strtolower($quotation->quotation_type)
                                            : (!empty($quotation->lead_id) ? 'quick' : 'regular');

                                    $isDetailedQuotation =
                                        $quotationType === 'detailed';

                                    $isQuickQuotation =
                                        $quotationType === 'quick';

                                    $isRegularQuotation =
                                        $quotationType === 'regular';


                                    /*
                                    |--------------------------------------------------------------------------
                                    | CUSTOMER / LEAD NAME
                                    |--------------------------------------------------------------------------
                                    |
                                    | Quick and Detailed quotations both use lead_id.
                                    |
                                    */

                                    $isLeadQuotation = !empty($quotation->lead_id);

                                    if ($isLeadQuotation) {

                                        $customerName =
                                            $quotation->lead->name
                                            ?? 'Lead #' . $quotation->lead_id;

                                        $customerPhone =
                                            $quotation->lead->phone
                                            ?? '';

                                    } else {

                                        $customerName =
                                            $quotation->client->name
                                            ?? 'N/A';

                                        $customerPhone =
                                            $quotation->client->phone
                                            ?? '';

                                    }


                                    /*
                                    |--------------------------------------------------------------------------
                                    | TOTAL CALCULATION
                                    |--------------------------------------------------------------------------
                                    */

                                    $subtotal = 0;

                                    foreach ($quotation->items ?? [] as $item) {

                                        $subtotal +=
                                            ((float) $item->unit_price)
                                            *
                                            ((float) $item->quantity);

                                    }


                                    $discountPercent =
                                        (float) ($quotation->discount ?? 0);


                                    $discountAmount =
                                        ($subtotal * $discountPercent) / 100;


                                    $afterDiscount =
                                        $subtotal - $discountAmount;


                                    $vatPercent =
                                        (float) ($quotation->vat ?? 0);


                                    $vatAmount =
                                        ($afterDiscount * $vatPercent) / 100;


                                    $grandTotal =
                                        $afterDiscount + $vatAmount;


                                    /*
                                    |--------------------------------------------------------------------------
                                    | SERIAL NUMBER
                                    |--------------------------------------------------------------------------
                                    */

                                    if(method_exists($quotations, 'currentPage')) {

                                        $serial =
                                            (($quotations->currentPage() - 1)
                                            *
                                            $quotations->perPage())
                                            +
                                            $loop->iteration;

                                    } else {

                                        $serial = $loop->iteration;

                                    }


                                    /*
                                    |--------------------------------------------------------------------------
                                    | QUOTATION NUMBER
                                    |--------------------------------------------------------------------------
                                    */

                                    $quotationNumber =
                                        'QT-' .
                                        str_pad(
                                            $quotation->id,
                                            5,
                                            '0',
                                            STR_PAD_LEFT
                                        );

                                @endphp



                                <tr>

                                    {{-- SERIAL --}}
                                    <td>
                                        {{ $serial }}
                                    </td>



                                    {{-- QUOTATION NUMBER --}}
                                    <td>

                                        <strong>
                                            {{ $quotationNumber }}
                                        </strong>

                                    </td>



                                    {{-- CUSTOMER / LEAD --}}
                                    <td>

                                        <span class="quotation-client-name">

                                            {{ $customerName }}

                                        </span>


                                        @if(!empty($customerPhone))

                                            <span class="quotation-client-phone">

                                                {{ $customerPhone }}

                                            </span>

                                        @endif

                                    </td>



                                    {{-- TYPE --}}
                                    <td>

                                        @if($isDetailedQuotation)

                                            <span class="
                                                quotation-type-badge
                                                quotation-type-detailed
                                            ">
                                                {{ get_phrase('Detailed Quotation') }}
                                            </span>

                                        @elseif($isQuickQuotation)

                                            <span class="
                                                quotation-type-badge
                                                quotation-type-quick
                                            ">
                                                {{ get_phrase('Quick Quotation') }}
                                            </span>

                                        @else

                                            <span class="
                                                quotation-type-badge
                                                quotation-type-regular
                                            ">
                                                {{ get_phrase('Regular Quotation') }}
                                            </span>

                                        @endif

                                    </td>



                                    {{-- CREATED BY --}}
                                    <td>

                                        {{ $quotation->user->name ?? 'N/A' }}

                                    </td>



                                    {{-- CREATE DATE --}}
                                    <td>

                                        @if($quotation->create_date)

                                            {{ \Carbon\Carbon::parse(
                                                $quotation->create_date
                                            )->format('d M Y') }}

                                        @else

                                            N/A

                                        @endif

                                    </td>



                                    {{-- DUE DATE --}}
                                    <td>

                                        @if($quotation->due_date)

                                            {{ \Carbon\Carbon::parse(
                                                $quotation->due_date
                                            )->format('d M Y') }}

                                        @else

                                            N/A

                                        @endif

                                    </td>



                                    {{-- SALES CREDIT --}}
                                    <td>

                                        {{ $quotation->salesCredit->name ?? 'N/A' }}

                                    </td>



                                    {{-- GRAND TOTAL --}}
                                    <td>

                                        <span class="quotation-total">

                                            ₹{{ number_format(
                                                $grandTotal,
                                                2
                                            ) }}

                                        </span>

                                    </td>



                                    {{-- ACTIONS --}}
                                    <td class="text-center text-nowrap">


                                        {{-- VIEW --}}
                                        <a href="{{ route(
                                                'admin.quotation.view',
                                                $quotation->id
                                            ) }}"
                                           class="
                                               btn
                                               p-0
                                               px-1
                                               quotation-action-btn
                                           "
                                           title="{{ get_phrase('View') }}"
                                           data-bs-toggle="tooltip">

                                            <i class="fi-rr-eye"></i>

                                        </a>



                                        {{-- CREATE PROFORMA --}}
                                        <form action="{{ route(
                                                'admin.proforma.createFromQuotation',
                                                $quotation->id
                                            ) }}"
                                              method="POST"
                                              style="display:inline;">

                                            @csrf


                                            <button type="submit"
                                                    class="
                                                        btn
                                                        p-0
                                                        px-1
                                                        quotation-action-btn
                                                    "
                                                    title="{{ get_phrase(
                                                        'Create Performa'
                                                    ) }}"
                                                    data-bs-toggle="tooltip">

                                                <i class="fi-rr-file-invoice"></i>

                                            </button>

                                        </form>



                                        {{-- EDIT --}}
                                        <a href="{{ route(
                                                'admin.quotation.edit',
                                                $quotation->id
                                            ) }}"
                                           class="
                                               btn
                                               p-0
                                               px-1
                                               quotation-action-btn
                                           "
                                           title="{{ get_phrase('Edit') }}"
                                           data-bs-toggle="tooltip">

                                            <i class="fi-rr-pencil"></i>

                                        </a>



                                        {{-- WHATSAPP --}}
                                        @if(!empty($customerPhone))

                                            @php

                                                $whatsappPhone =
                                                    preg_replace(
                                                        '/[^0-9]/',
                                                        '',
                                                        $customerPhone
                                                    );


                                                if (
                                                    strlen($whatsappPhone) === 10
                                                ) {

                                                    $whatsappPhone =
                                                        '91' . $whatsappPhone;

                                                }


                                                $whatsappMessage =
                                                    "Quotation "
                                                    . $quotationNumber
                                                    . "\n"
                                                    . "Total: ₹"
                                                    . number_format(
                                                        $grandTotal,
                                                        2
                                                    );

                                            @endphp


                                            <a href="https://wa.me/{{ $whatsappPhone }}?text={{ urlencode($whatsappMessage) }}"
                                               target="_blank"
                                               class="
                                                   btn
                                                   p-0
                                                   px-1
                                                   quotation-action-btn
                                               "
                                               title="Send WhatsApp"
                                               data-bs-toggle="tooltip">

                                                <i class="bi bi-whatsapp"></i>

                                            </a>

                                        @endif



                                        {{-- DELETE --}}
                                        <a href="#"
                                           onclick="confirmModal(
                                               '{{ route(
                                                   'admin.quotation.delete',
                                                   $quotation->id
                                               ) }}'
                                           )"
                                           class="
                                               btn
                                               p-0
                                               px-1
                                               quotation-action-btn
                                           "
                                           title="{{ get_phrase('Delete') }}"
                                           data-bs-toggle="tooltip">

                                            <i class="fi-rr-trash"></i>

                                        </a>


                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="10"
                                        class="text-center text-muted py-4">

                                        No quotation found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>



                {{-- PAGINATION --}}
                @if(method_exists($quotations, 'links'))

                    <div class="mt-3">

                        {{ $quotations->withQueryString()->links() }}

                    </div>

                @endif


            </div>

        </div>

    </div>

@endsection





