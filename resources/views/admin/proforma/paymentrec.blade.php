@extends('index')

@push('title', get_phrase('Payment Receipt'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Payment Receipt') ?? 'N/A' }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') ?? 'N/A' }}</a></li>
                    <li><a href="#">{{ get_phrase('Payment Receipt') ?? 'N/A' }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Proforma Invoices') ?? 'N/A' }}</p>

                <div class="card">
                    <div class="card-body">

                        {{-- ===================== HEADER ===================== --}}
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0 column-title">Payment Receipt</h5>
                            <span class="badge bg-success">
                                {{ $payment->receipt_no ?? 'N/A' }}
                            </span>
                        </div>

                        <hr>

                        {{-- ===================== BASIC DETAILS ===================== --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="eForm-label">
                                    <strong>Customer:</strong>
                                    {{ $payment->customer->name ?? 'N/A' }}
                                </p>

                                <p class="eForm-label">
                                    <strong>Proforma No:</strong>
                                    {{ $payment->proforma->proforma_no ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="col-md-6 text-end">
                                <p class="eForm-label">
                                    <strong>Payment Date:</strong>
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') ?? 'N/A' }}
                                </p>

                                <p class="eForm-label">
                                    <strong>Payment Mode:</strong>
                                    {{ Str::ucfirst($payment->payment_method ?? 'N/A') }}
                                </p>
                            </div>
                        </div>

                        {{-- ===================== CALCULATION LOGIC ===================== --}}
                        @php
                            $billTotal = $payment->proforma->total ?? 0;

                            // Sum of payments before this receipt
                            $previousReceived = $payment->proforma->payment
                                ->where('id', '<', $payment->id)
                                ->sum('amount');

                            $currentPayment = $payment->amount ?? 0;

                            $balanceDue = $billTotal - ($previousReceived + $currentPayment);

                            $statusText = $balanceDue <= 0
                                ? 'Paid'
                                : ($previousReceived > 0 ? 'Partially Paid' : 'Unpaid');

                            $statusClass = $balanceDue <= 0 ? 'bg-success' : 'bg-warning';
                        @endphp

                        {{-- ===================== PAYMENT TABLE ===================== --}}
                        <table class="table table-bordered eForm-label">
                            <tr>
                                <th>Bill Total</th>
                                <td class="text-end">
                                    ₹ {{ number_format($billTotal, 2) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Amount Received Earlier</th>
                                <td class="text-end text-success">
                                    ₹ {{ number_format($previousReceived, 2) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Current Payment</th>
                                <td class="text-end">
                                    ₹ {{ number_format($currentPayment, 2) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Transaction ID</th>
                                <td class="text-end text-success">
                                    {{ $payment->transaction_id ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <th><strong>Balance Due</strong></th>
                                <td class="text-end fw-bold {{ $balanceDue <= 0 ? 'text-success' : 'text-danger' }}">
                                    ₹ {{ number_format(max($balanceDue, 0), 2) }}
                                </td>
                            </tr>
                        </table>

                        {{-- ===================== AMOUNT IN WORDS ===================== --}}
                        <p class="mt-3 eForm-label">
                            <strong>Amount in Words:</strong><br>
                            {{ ucfirst(\NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($currentPayment)) }}
                            only
                        </p>

                        <hr>

                        {{-- ===================== STATUS & ACTIONS ===================== --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>

                            <div>
                                <a href="{{ url()->previous() }}" class="btn btn-form py-2 text-white btn-secondary">
                                    Back
                                </a>

                                <a href="{{ route('admin.payment.receipt.pdf', $payment->id) }}"
                                   class="btn-form btn py-2 btn-primary">
                                    Generate PDF
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@stop
