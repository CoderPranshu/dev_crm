@extends('index')

@push('title', get_phrase('Purchase Bill'))

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Bills') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.purchase.bills') }}">{{ get_phrase('Purchase Bills') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Bill Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="eSection-wrap">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="column-title mb-2">{{ get_phrase('Purchase Bills') }}</p>
                        <span class="badge bg-secondary eForm-label">
                            Status:
                            {{ strtoupper($bill->status) }}
                        </span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="eForm-label fw-bold">Supplier Details</h6>
                            <p class="mb-1 eForm-label"><strong class="eForm-label">Name:</strong>
                                {{ $bill->supplier->user->name }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-1 eForm-label"><strong>Bill No:</strong> {{ $bill->bill_no }}</p>
                            <p class="mb-1 eForm-label"><strong>Bill Date:</strong>
                                {{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    <table class="table table-bordered eForm-label">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th class="text-start">Product</th>
                                <th>Qty</th>
                                <th>Rate (₹)</th>
                                <th>Amount (₹)</th>
                                <th>HSN</th>
                                <th>GST %</th>
                                <th>GST Amt (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bill->items as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->rate, 2) }}</td>
                                    <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                                    <td class="text-center">{{ $item->hsn_code ?? '-' }}</td>
                                    <td class="text-center">{{ $item->gst_rate }}%</td>
                                    <td class="text-end">{{ number_format($item->gst_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row justify-content-end eForm-label">
                        <div class="col-md-4">
                            <table class="table table-sm">
                                <tr>
                                    <th>Taxable Amount</th>
                                    <td class="text-end">₹ {{ number_format($bill->taxable_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>CGST</th>
                                    <td class="text-end">₹ {{ number_format($bill->cgst_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>SGST</th>
                                    <td class="text-end">₹ {{ number_format($bill->sgst_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>IGST</th>
                                    <td class="text-end">₹ {{ number_format($bill->igst_amount, 2) }}</td>
                                </tr>
                                <tr class="table-light fw-bold">
                                    <th>Grand Total</th>
                                    <td class="text-end">₹ {{ number_format($bill->total_amount, 2) }}</td>
                                </tr>
                                <tr class="text-success">
                                    <th>Paid</th>
                                    <td class="text-end">₹ {{ number_format($bill->paid_amount, 2) }}</td>
                                </tr>
                                <tr class="text-danger fw-bold">
                                    <th>Due</th>
                                    <td class="text-end">₹ {{ number_format($bill->due_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @can('purchase-bill-pay')
                        @if ($bill->due_amount > 0)
                            <hr>
                            <h6 class="fw-bold eForm-label">Make Payment</h6>
                            <form method="POST" action="{{ route('admin.purchase-bills.pay', $bill) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="number" step="0.01" max="{{ $bill->due_amount }}" name="amount"
                                            class="form-control eForm-control" placeholder="Enter Amount" required>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="payment_mode" class="form-control eForm-control" required>
                                            <option value="">Select Mode</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Bank">Bank</option>
                                            <option value="UPI">UPI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-success btn-form w-100">
                                            Pay Now
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endcan

                    <hr>

                    {{-- ACTIONS --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.purchase-bills.pdf', $bill) }}" class="btn btn-primary btn-form py-2">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
