@extends('index')
@push('title', get_phrase('Vendor Bills'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Vendor Bills') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Vendor Bills') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="container">

                    <h4 class="mb-3 column-title">Bills – {{ $supplier }}</h4>

                    <table class="table table-bordered eForm-label">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bill No</th>
                                <th>Date</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Paid</th>
                                <th class="text-end">Due</th>
                                <th>Status</th>
                                <th>Receipts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bills as $bill)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{route('admin.purchase-bills.show', $bill->id)}}">{{ $bill->bill_no }}</a></td>
                                    <td>{{ $bill->bill_date }}</td>
                                    <td class="text-end">₹ {{ number_format($bill->total_amount, 2) }}</td>
                                    <td class="text-end text-success">₹ {{ number_format($bill->paid_amount, 2) }}</td>
                                    <td class="text-end text-danger">₹ {{ number_format($bill->due_amount, 2) }}</td>
                                    <td>{{ ucfirst($bill->status) }}</td>
                                    <td>
                                        @foreach ($bill->payments as $payment)
                                            <a href="{{ route('admin.purchase-receipts.show', $payment) }}"
                                                class="btn btn-sm btn-outline-primary mb-1">
                                                Receipt
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
