@extends('index')

@push('title', 'Purchase Order Detail')

@push('css')
    <style>
        .card {
            border-radius: 12px;
            border: none;
        }

        .info-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
        }

        .section-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .table th {
            font-size: 13px;
            background: #f1f3f5;
        }

        .table td {
            font-size: 14px;
        }

        .badge-status {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Order') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.purchaseorder.index') }}">{{ get_phrase('Purchase Order') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Order Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0">

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="eForm-label">Purchase Order: {{ $po->po_number }}</h3>

                <p class="eForm-label">Vendor: {{ $po->vendor->user->name ?? 'N/A' }}</p>
                <p class="eForm-label">Total: ₹{{ $po->total_amount }}</p>

                <table class="table">
                    <thead>
                        <tr class="eForm-label">
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($po->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? '' }}</td>
                                <td>{{ $item->order_qty }}</td>
                                <td>₹{{ $item->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
