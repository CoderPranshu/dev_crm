@extends('index')
@push('title', get_phrase('GRN Creation'))
@push('meta')
@endpush
@push('css')

    <style>
        .detail-label {
            font-weight: 400;
            color: #727171;
            font-size: 13px;
        }

        /* Remove all borders in the tfoot */
        .no-footer-border th,
        .no-footer-border td,
        .no-footer-border tr {
            border: none !important;
        }

        table tfoot {
            border-top: none !important;
        }
    </style>


@endpush

@section('content')
        <div class="mainSection-title">
            <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                <div class="d-flex flex-column">
                    <h4>{{ get_phrase('GRN Details') }}</h4>
                    <ul class="d-flex align-items-center eBreadcrumb-2">
                        <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.grn.index') }}">{{ get_phrase('GRN') }}</a></li>
                        <li><a href="#">{{ get_phrase('GRN Details') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <div class="d-flex">
        <div class="card p-3 border-0 rounded-3" >
            <div class="row">
                <div class="col-12 p-3">
                    <div class="d-flex justify-content-between mb-3" style="border-bottom: 2px solid #111111;">
                        <img src="{{ asset('assets/images/bms.svg') }}" alt="" style="width: 150px;">

                        <div class="px-1" style="display: flex; align-items: center; color: black;">
                            <h4 style="font-weight: 600;" class="eForm-labe">GOODS RECEIVED NOTE</h4>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-12">
                    <div class="row mb-3">
                        <div class="mb-3">
                            <p class="eForm-label">GRN Number : <span>{{ $grn->grn_no }}</span></p>
                            <p class="eForm-label">Date : <span>{{ $grn->grn_date }}</span></p>
                            <p class="eForm-label">P.O Number<span></span></p>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 p-3" style="background-color: #f5fafc;">
                                <p>
                                    <span class="eForm-label">
                                        Supplier Name:
                                    </span>
                                    <span class="detail-label">
                                        {{ $grn->supplier_name }}
                                    </span>
                                </p>
                                <p>
                                    <span class="eForm-label">
                                        GRN Number:
                                    </span>
                                    <span class="detail-label">
                                        {{ $grn->grn_no }}
                                    </span>
                                </p>
                                <p>
                                    <span class="eForm-label">
                                        Receipt Date:
                                    </span>
                                    <span class="detail-label">
                                        {{ $grn->grn_date }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card border-0 p-3" style="background-color: #f5fafc;">
                                <p> <span class="eForm-label">
                                        Warehouse:
                                    </span>
                                    <span class="detail-label">
                                        {{ $grn->branch->title}}
                                    </span>
                                </p>
                                <p>
                                    <span class="eForm-label">
                                        Address:
                                    </span>
                                    <span class="detail-label">
                                        {{ $grn->branch->address}}
                                    </span>
                                </p>
                                <p>
                                    <span class="eForm-label">
                                        Contact:
                                    </span>
                                    <span class="detail-label">
                                        {{ get_settings('phone') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 border-0">
                        <div class="card-header" style="background-color: #f5fafc;">
                            <h5 class="eForm-label">Items Received</h5>
                        </div>
                        <div class="card-body">
                            <table class="table eTable">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php
                                        $subTotal = 0;
                                        $totalItems = 0;
                                        $totalQuantity = 0;
                                    @endphp

                                    @foreach ($grn->items as $item)
                                        @php
                                            $itemTotal = $item->rate * $item->quantity;
                                            $subTotal += $itemTotal;

                                            $totalItems++;
                                            $totalQuantity += $item->quantity;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->rate }}</td>
                                            <td>{{ $itemTotal }}</td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $gst = $subTotal * 0.18;
                                        $grandTotal = $subTotal + $gst;
                                    @endphp
                                </tbody>
                                <tfoot class="no-footer-border table-light">
                                    <tr>
                                        <th colspan="4" class=""><strong>Subtotal</strong></th>
                                        <th><strong>₹ &nbsp;{{ $subTotal }}</strong></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 d-flex justify-content-end">
                    <div class="">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Subtotal price: <span
                                        class="detail-label">{{ $subTotal }}</span></li>
                                <li class="list-group-item">18% GST: <span class="detail-label">{{ $gst }}</span>
                                </li>
                                <li class="list-group-item">Grand Total: <span
                                        class="detail-label">{{ $grandTotal }}</span></li>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
