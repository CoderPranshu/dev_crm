@extends('index')
@push('title', get_phrase('Receivable'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Receivable') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.invoice.index') }}">{{ get_phrase('Invoices') }}</a></li>
                    <li><a href="#">{{ get_phrase('Invoice Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Invoice') }}</p>


                <div class="row mb-4">

                    <!--  TOTAL INVOICE -->
                    <div class="col-md-4">
                        <div class="card text-center border-primary">
                            <div class="card-body">
                                <h6 class="eForm-label">Total Invoice Amount</h6>
                                <h3 class="eForm-label">₹ {{ number_format($totalInvoices, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- OTAL RECEIVED -->
                    <div class="col-md-4">
                        <div class="card text-center border-success">
                            <div class="card-body">
                                <h6 class="eForm-label">Total Payment Received</h6>
                                <h3 class="eForm-label">₹ {{ number_format($totalReceived, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL RECEIVABLE -->
                    <div class="col-md-4">
                        <div class="card text-center border-danger">
                            <div class="card-body">
                                <h6 class="eForm-label">Total Receivable Amount</h6>
                                <h3 class="text-danger eForm-label">
                                    ₹ {{ number_format($totalReceivable, 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- USTOMER WISE RECEIVABLE TABLE -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="eForm-label">Customer Wise Receivable Summary</h5>
                    </div>

                    <div class="card-body p-3">
                        <table class="table eTable mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th class="text-end">Total Invoice</th>
                                    <th class="text-end">Received</th>
                                    <th class="text-end text-danger">Receivable</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($customerReceivables as $c)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $c->customer->name ?? 'N/A' }}</td>
                                        <td class="text-end">₹ {{ number_format($c->total_invoice, 2) }}</td>
                                        <td class="text-end text-success">₹ {{ number_format($c->received, 2) }}</td>
                                        <td class="text-end text-danger">₹ {{ number_format($c->due, 2) }}</td>
                                        <td class="text-center">
                                            @if ($c->payment_id)
                                                <a href="{{ route('admin.payment.view', $c->payment_id) }}">
                                                    <i class="fi-rr-eye"></i>
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">No receivables found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>




            </div>
        </div>
    </div>
@endsection
