@extends('index')
@push('title', get_phrase('Proforma Payments'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Proforma Payments') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Proforma Payments') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Proforma Payments') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Recipt No</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Payment Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($payments as $p)
                                @php
                                    $received = $p->payment?->sum('amount');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->receipt_no }}</td>
                                    <td>{{ $p->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $p->payment_date }}</td>
                                    <td>₹{{ number_format($p->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $p->status === 'received' ? 'success' : 'danger' }}">{{ Str::ucfirst($p->status) }}</span>
                                    </td>
                                    <td>
                                        {{ Str::ucfirst($p->payment_method) }}
                                    </td>
                                    <td>
                                        @can('performa-show')
                                            <a href="{{ route('admin.proforma.recipt', $p->id) }}"
                                                class="btn-form py-2 me-2 btn-sm shadow-none btn-info">
                                                View
                                            </a>
                                        @endcan
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@stop
