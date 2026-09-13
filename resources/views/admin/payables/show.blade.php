@extends('index')
@push('title', get_phrase('Receipt Details'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Receipt Details') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Receipt Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="container mt-4">

                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0 column-title">Payment Receipt</h5>
                                <span class="badge bg-success">
                                    RCPT-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="eForm-label"><strong>Supplier:</strong> {{ $payment->bill->supplier->user->name }}</p>
                                    <p class="eForm-label"><strong>Purchase Bill No:</strong> {{ $payment->bill->bill_no }}</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="eForm-label"><strong>Payment Date:</strong>
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                    </p>
                                    <p class="eForm-label"><strong>Payment Mode:</strong> {{ $payment->payment_mode }}</p>
                                </div>
                            </div>

                            <table class="table table-bordered eForm-label">
                                <tr>
                                    <th>Amount Paid</th>
                                    <td class="text-end">
                                        ₹ {{ number_format($payment->amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bill Total</th>
                                    <td class="text-end">
                                        ₹ {{ number_format($payment->bill->total_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Paid Till Now</th>
                                    <td class="text-end text-success">
                                        ₹ {{ number_format($payment->bill->paid_amount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Balance Due</th>
                                    <td class="text-end text-danger fw-bold">
                                        ₹ {{ number_format($payment->bill->due_amount, 2) }}
                                    </td>
                                </tr>
                            </table>

                            <p class="mt-3 eForm-label">
                                <strong>Amount in Words:</strong><br>
                                {{ ucfirst(\NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($payment->amount)) }}
                                only
                            </p>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ url()->previous() }}" class="btn btn-form py-2 text-white btn-secondary">
                                    Back
                                </a>

                                <a href="{{ route('admin.purchase-receipts.pdf', $payment) }}" class="btn-form btn py-2 btn-primary">
                                    Generate PDF
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
