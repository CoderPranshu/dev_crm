@extends('index')
@push('title', get_phrase('Invoice'))

@section('content')
<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div>
            <h4>{{ get_phrase('Invoice') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Invoice') }}</a></li>
            </ul>
        </div>
        <a href="{{ route('admin.invoice.create') }}" class="export_btn">
            <i class="bi bi-plus"></i>
            {{ get_phrase('Add new invoice') }}
        </a>
    </div>
</div>

@php
if ($invoice->salesOrder && $invoice->salesOrder->proforma && $invoice->salesOrder->proforma->customer) {
$customer = $invoice->salesOrder->proforma->customer;
} else {
$customer = $invoice->customer;
}

$states = [
'andhra pradesh',
'arunachal pradesh',
'assam',
'bihar',
'chhattisgarh',
'goa',
'gujarat',
'haryana',
'himachal pradesh',
'jharkhand',
'karnataka',
'kerala',
'madhya pradesh',
'maharashtra',
'manipur',
'meghalaya',
'mizoram',
'nagaland',
'odisha',
'punjab',
'rajasthan',
'sikkim',
'tamil nadu',
'telangana',
'tripura',
'uttar pradesh',
'uttarakhand',
'west bengal',
'delhi',
'new delhi',
'chandigarh',
'puducherry',
'ladakh',
'jammu and kashmir',
'dadra and nagar haveli',
'daman and diu',
'andaman and nicobar',
];

$companyState = strtolower($invoice->branch->address);
$customerState = strtolower($customer->address);

$fromState = null;
$toState = null;

foreach ($states as $state) {
if (!$fromState && str_contains($companyState, $state)) {
$fromState = $state;
}
if (!$toState && str_contains($customerState, $state)) {
$toState = $state;
}
}

$isInterState = $fromState && $toState && $fromState !== $toState;

$subTotal = 0;
$cgstTotal = 0;
$sgstTotal = 0;
$igstTotal = 0;

$paidFromPayments = $invoice->payments->sum('amount');

if ($invoice->status == 'paid') {
$totalPaid = $invoice->total;
$remainingAmount = 0;
} else {
$totalPaid = $paidFromPayments;
$remainingAmount = max($invoice->total - $totalPaid, 0);
}
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="eForm-label">Invoice #{{ $invoice->invoice_no }}</h4>
                    <a href="{{ route('admin.invoice.pdf', $invoice->id) }}" target="_blank"
                        class="btn-form btn-sm btn-secondary">
                        Print PDF
                    </a>
                </div>

                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="eForm-label">Bill To</h6>
                            <p class="eForm-label">
                                <strong>{{ $customer->name ?? '' }}</strong><br>
                                {{ $customer->address ?? '' }}<br>
                                Phone: {{ $customer->phone ?? '' }}<br>
                                State: {{ $customerState }}
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="eForm-label">
                                <strong>Invoice Date:</strong> {{ $invoice->invoice_date }}<br>
                                <strong>Payment Status:</strong>
                                {{ $invoice->status == 'paid' ? 'Paid' : 'Unpaid' }}
                            </p>
                            <h6 class="eForm-label">Bill From</h6>
                            <p class="eForm-label">
                                <strong>{{ $invoice->branch->company_name }}</strong>
                            </p>
                            <p class="eForm-label">
                                {{ $invoice->branch->address }} <br>
                                Phone: {{ get_settings('phone') }} <br>
                                <strong>GSTIN:</strong> {{$invoice->branch->gstin}}
                            </p>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="eForm-label">
                                <th>#</th>
                                <th>Product</th>
                                <th>HSN</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Taxable Amount</th>
                                <th class="text-end">Tax</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $item)
                            {{-- @php
                            $baseAmount = $item->price * $item->quantity;
                            $taxRate = $item->tax_id ?? 0;
                            $taxAmount = ($baseAmount * $taxRate) / 100;

                            if ($isInterState) {
                            $igst += $taxAmount;
                            } else {
                            $cgst += $taxAmount / 2;
                            $sgst += $taxAmount / 2;
                            }

                            $lineTotal = $baseAmount + $taxAmount;
                            @endphp --}}

                            @php
                            $line = $item->price * $item->quantity;
                            $subTotal += $line;

                            // ===== TAX FALLBACK LOGIC =====
                            $taxRate = 0;

                            if (!empty($item->tax_rate)) {
                            $taxRate = (float) $item->tax_rate;
                            } elseif (!empty($item->tax_id)) {
                            $taxRate = (float) $item->tax_id; // assuming it's % in some cases
                            }

                            if ($isInterState) {
                            // IGST
                            $igst = ($line * $taxRate) / 100;
                            $igstTotal += $igst;
                            $taxAmount = $igst;
                            } else {
                            // CGST + SGST
                            $cgst = ($line * ($taxRate / 2)) / 100;
                            $sgst = ($line * ($taxRate / 2)) / 100;

                            $cgstTotal += $cgst;
                            $sgstTotal += $sgst;

                            $taxAmount = $cgst + $sgst;
                            }

                            $finalamount = $line + $taxAmount;
                            @endphp
                            <tr class="eForm-label">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->hsn_code }}</td>
                                <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">₹{{ number_format($line, 2) }}</td>
                                <td class="text-end">
                                    @if ($isInterState)
                                    IGST ₹{{ number_format($taxAmount, 2) }} ({{ $taxRate }}%)
                                    @else
                                    CGST ₹{{ number_format($cgst, 2) }} ({{ $taxRate / 2 }}%)<br>
                                    SGST ₹{{ number_format($sgst, 2) }} ({{ $taxRate / 2 }}%)
                                    @endif
                                </td>
                                <td class="text-end">₹{{ number_format($finalamount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="eForm-label"><b>Notes</b></p>
                                    <p class="eForm-label">{{ $invoice->decleration ?? 'N/A' }}</p>
                                </div>

                                @if ($invoice->status != 'paid')
                                <div class="col-md-12">
                                    <p class="eForm-label"><b>Bank Details</b></p>
                                    <p class="eForm-label">
                                        Account Name: {{ $invoice->account->ac_holder_name ?? 'N/A' }}<br>
                                        Account Number: {{ $invoice->account->ac_no ?? 'N/A' }}<br>
                                        IFSC Code: {{ $invoice->account->ifsc_code ?? 'N/A' }}<br>
                                        Bank Name: {{ $invoice->account->bank_name ?? 'N/A' }}<br>
                                        Branch Name: {{ $invoice->account->branch_name ?? 'N/A' }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr class="eForm-label">
                                    <th>Subtotal</th>
                                    <td class="text-end">₹{{ number_format($invoice->subtotal, 2) }}</td>
                                </tr>

                                @if ($isInterState)
                                <tr class="eForm-label">
                                    <th>IGST</th>
                                    <td class="text-end">₹{{ number_format($igstTotal, 2) }}</td>
                                </tr>
                                @else
                                <tr class="eForm-label">
                                    <th>CGST</th>
                                    <td class="text-end">₹{{ number_format($cgstTotal, 2) }}</td>
                                </tr>
                                <tr class="eForm-label">
                                    <th>SGST</th>
                                    <td class="text-end">₹{{ number_format($sgstTotal, 2) }}</td>
                                </tr>
                                @endif

                                <tr class="eForm-label">
                                    <th>Total</th>
                                    <td class="text-end">
                                        <strong>₹{{ number_format($invoice->total, 2) }}</strong>
                                    </td>
                                </tr>
                                <tr class="eForm-label">
                                    <th>Paid</th>
                                    <td class="text-end">₹{{ number_format($totalPaid, 2) }}</td>
                                </tr>
                                <tr class="eForm-label">
                                    <th>Balance</th>
                                    <td class="text-end">
                                        ₹{{ number_format($remainingAmount, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($remainingAmount > 0)
                    <form action="{{ route('admin.payment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <input type="number" step="0.01" name="amount" class="eForm-control"
                                    max="{{ $remainingAmount }}" required placeholder="Amount">
                            </div>
                            <div class="col-md-3">
                                <select name="payment_method" class="eForm-control" required>
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="card">Card</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="transaction_id" class="eForm-control"
                                    placeholder="Transaction ID">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="payment_date" class="eForm-control" required>
                            </div>
                        </div>

                        <button class="btn-form btn-success mt-3 w-100">
                            Receive Payment
                        </button>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection