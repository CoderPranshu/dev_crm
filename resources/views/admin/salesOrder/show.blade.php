@extends('index')
@push('title', get_phrase('Sales Orders'))
@push('meta')
@endpush
@push('css')
    <style>
        /* ===============================
                   SALES ORDER DETAIL PAGE
                ================================ */

        .info-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 12px;
            color: #212529;
        }

        .card {
            background: #ffffff;
        }

        .card-body {
            /* padding: 1.75rem; */
        }

        /* Header Section */
        .bg-light {
            background-color: #f8f9fc !important;
            border-radius: 10px;
        }

        h5.fw-bold {
            letter-spacing: 0.3px;
        }

        /* Status Badge */
        .badge {
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.4px;
        }

        /* Section Titles */
        h6.text-uppercase {
            font-size: 0.78rem;
            letter-spacing: 0.8px;
        }

        /* Info Labels */
        small.fw-semibold {
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        /* Info Values */
        .row>div>div {
            font-size: 14px;
            font-weight: 500;
            color: black;
        }

        /* Table Styling */
        .table {
            border-color: #e6e8eb;
        }

        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #222425;
            background-color: #f9fafb;
            border-bottom: #eef0f2;
        }

        .table tbody td {
            font-size: 0.88rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f5f7fa;
        }

        /* Price Alignment */
        .table td.text-end {
            font-variant-numeric: tabular-nums;
        }

        /* Summary Box */
        .bg-light.rounded-3 {
            background-color: #f9fafb !important;
            border: 1px solid #eef0f2;
        }

        .bg-light.rounded-3 table th,
        .bg-light.rounded-3 table td {
            font-size: 0.9rem;
        }

        .bg-light.rounded-3 table th {
            font-weight: 600;
        }

        .table-active {
            background-color: #eef2ff !important;
        }

        /* Grand Total */
        .table-active td {
            font-size: 1rem;
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.25rem;
            }

            h5.fw-bold {
                font-size: 1.05rem;
            }

            .badge {
                margin-top: 0.5rem;
            }
        }

        /* Smooth UI */
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="mainSection-title">
            <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                <div class="d-flex flex-column">
                    <h4>{{ get_phrase('Sales Order Details') }}</h4>
                    <ul class="d-flex align-items-center eBreadcrumb-2">
                        <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.salesorders.index') }}">{{ get_phrase('Sales Order') }}</a></li>
                        <li><a href="#">{{ get_phrase('Sales Order Details') }}</a></li>
                    </ul>
                </div>

            </div>
        </div>


        <div class="card shadow-sm border-0" style="border-radius: 10px;">
            <div class="card-body">

                {{-- ================= HEADER ================= --}}
                <div class="bg-light mb-4" style="padding: 18px 22px;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="lh-sm">
                            <h6 class="mb-1" style="font-weight: 600; color: black;">
                                Sales Order #{{ $salesOrder->so_no }}
                            </h6>
                            <small class="text-muted">
                                Order Date:
                                {{ \Carbon\Carbon::parse($salesOrder->created_at)->format('d M Y') }}
                                • Expected Delivery:
                                {{ \Carbon\Carbon::parse($salesOrder->expected_delivery_date)->format('d M Y') }}
                            </small>
                        </div>
                        @if ($salesOrder->status == 'processing')
                            <a href="{{ route('admin.invoice.generate', $salesOrder->id) }}"
                                class="btn-form py-2 btn-sm btn-warning">
                                Generate Invoice
                            </a>
                        @endif
                        <span
                            class="badge
                        @if ($salesOrder->status == 'dispatched') bg-success
                        @elseif($salesOrder->status == 'processing') bg-warning
                        @else bg-secondary @endif
                        px-3 py-2 rounded-pill text-capitalize">
                            {{ $salesOrder->status }}
                        </span>
                    </div>
                </div>

                {{-- ================= CUSTOMER & ORDER INFO ================= --}}
                <div class="row g-4 mb-4" style="margin-left: 0px;">

                    {{-- Order Overview --}}
                    <div class="col-lg-12">
                        <h6 class="section-title mb-3">
                            Order Overview
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Proforma No</small>
                                <div>{{ $salesOrder->proforma->proforma_no }}</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted fw-semibold">Proforma Date</small>
                                <div>
                                    {{ \Carbon\Carbon::parse($salesOrder->proforma->proforma_date)->format('d M Y') }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- ================= ORDER ITEMS ================= --}}
                <hr style="color: black;">
                <h6 class="text-uppercase fw-bold text-secondary mb-3" style="margin-left: 5px;">
                    Order Items
                </h6>

                <div class="table-responsive mb-4" style="margin-left: 5px;">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Unit</th>
                                <th>GRN Details</th>
                                <th class="text-end">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesOrder->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->product->sku }}</td>
                                    <td>{{ $item->product->unit }}</td>
                                    <td>
                                        @forelse ($item->product->bom as $bom)
                                                    <ul class="small mb-2">
                                                        @foreach ($bom->items as $bomItem)
                                                            @php
                                                                $base = $bomItem->quantity * $item->quantity;
                                                                $wastage = ($base * $bomItem->wastage_percent) / 100;
                                                                $total = $base + $wastage;
                                                            @endphp

                                                            <li>
                                                                <b>{{ $loop->iteration }}.</b>
                                                                {{ $bomItem->product->name ?? 'Raw #' . $bomItem->raw_product_id }}
                                                                — Per Unit: {{ number_format($bomItem->quantity, 2) }}
                                                                — Wastage: {{ $bomItem->wastage_percent }}%
                                                                — Total:
                                                                <span
                                                                    class="text-success">{{ number_format($total, 2) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @empty
                                                    <span class="text-muted">No BOM Found</span>
                                                @endforelse
                                    </td>
                                    <td class="text-end">{{ rtrim(rtrim($item->quantity, '0'), '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
