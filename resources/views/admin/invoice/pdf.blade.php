<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice {{ $invoice->invoice_no }}</title>

<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #333;
}

.container {
    padding: 20px;
}

/* HEADER */
.header-table {
    width: 100%;
    border-bottom: 3px solid #0f766e;
    margin-bottom: 20px;
}

.invoice-title {
    font-size: 24px;
    font-weight: bold;
}

.invoice-meta {
    text-align: right;
    font-size: 13px;
}

/* BILLING */
.billing-row table {
    width: 100%;
}

.billing-row td {
    width: 50%;
    vertical-align: top;
    padding-right: 10px;
}

.card {
    background: #f1f5f9;
    padding: 15px;
    border-radius: 6px;
}

.card-title {
    font-size: 14px;
    font-weight: bold;
    color: #0f766e;
    margin-bottom: 8px;
}

/* ITEMS TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th {
    background: #0f766e;
    color: #fff;
    padding: 10px;
    font-size: 12px;
    text-align: left;
}

td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.text-end {
    text-align: right;
}

/* TOTALS */
.totals {
    width: 35%;
    margin-left: auto;
    margin-top: 20px;
}

.totals td {
    padding: 6px;
}

.total-final {
    font-size: 15px;
    font-weight: bold;
    border-top: 2px solid #000;
}

/* FOOTER */
.footer {
    margin-top: 40px;
    font-size: 11px;
    display: flex;
    justify-content: space-between;
}
</style>
</head>

<body>

<div class="container">

@php
$companyState = 'Delhi';
$customerState = $invoice->customer->state ?? '';
$isInterState = $companyState !== $customerState;

$cgstTotal = 0;
$sgstTotal = 0;
$igstTotal = 0;
@endphp

<!-- HEADER WITH LOGO -->
<table class="header-table">
<tr>

    <!-- LEFT: LOGO + TITLE -->
    <td style="width:60%;">
        <table style="width:100%;">
            <tr>
                <td style="width:70px;">
                    @if(!empty($invoice->branch->logo))
                        <img src="{{ public_path('businesslogo/'.$invoice->branch->logo) }}" alt="" style="height:50px;">
                    @endif
                </td>
                
            </tr>
        </table>
    </td>

    <!-- RIGHT: META -->
    <td class="invoice-meta" style="width:40%;">
       <table style="width:100%;">
           <tr>
               <td>
                    <div class="invoice-title">INVOICE</div>
                </td>
              
           </tr>
           <tr>
                <td>
                    Invoice No: {{ $invoice->invoice_no }}<br>
        Date: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}
               </td>
           </tr>
       </table>
    </td>

</tr>
</table>

<!-- BILLING -->
<div class="billing-row">
    <table>
        <tr>
            <!-- BILLED BY -->
            <td>
                <div class="card">
                    <div class="card-title">Billed By</div>
                    <strong>{{ $invoice->branch->company_name }}</strong><br>
                    {{ $invoice->branch->address }}<br>
                    GSTIN: {{ $invoice->branch->gstin }}<br>
                    Phone: {{ $invoice->branch->phone_no }}
                </div>
            </td>

            <!-- BILLED TO -->
            <td>
                <div class="card">
                    <div class="card-title">Billed To</div>
                    <strong>{{ $invoice->customer->name }}</strong><br>
                    {{ $invoice->customer->address }}<br>
                    Phone: {{ $invoice->customer->phone }}<br>
                    GSTIN: {{ $invoice->customer->gst_no ?? '-' }}
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- ITEMS -->
<table>
<thead>
<tr>
    <th>#</th>
    <th>Item</th>
    <th>HSN</th>
    <th class="text-end">Qty</th>
    <th class="text-end">Rate</th>
    <th class="text-end">Amount</th>
    <th class="text-end">Tax</th>
    <th class="text-end">Total</th>
</tr>
</thead>

<tbody>
@foreach ($invoice->items as $item)
@php
$line = $item->price * $item->quantity;
$taxRate = $item->tax_rate ?? 0;
$taxAmount = $line * $taxRate / 100;

if ($isInterState) {
    $igstTotal += $taxAmount;
} else {
    $cgstTotal += $taxAmount / 2;
    $sgstTotal += $taxAmount / 2;
}

$total = $line + $taxAmount;
@endphp

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->product->name }}</td>
    <td>{{ $item->hsn->hsn_code ?? '-' }}</td>
    <td class="text-end">{{ $item->quantity }}</td>
    <td class="text-end">₹{{ number_format($item->price,2) }}</td>
    <td class="text-end">₹{{ number_format($line,2) }}</td>
    <td class="text-end">₹{{ number_format($taxAmount,2) }}</td>
    <td class="text-end">₹{{ number_format($total,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<!-- TOTALS -->
<table class="totals">
<tr>
    <td>Subtotal</td>
    <td class="text-end">₹{{ number_format($invoice->subtotal,2) }}</td>
</tr>

@if($isInterState)
<tr>
    <td>IGST</td>
    <td class="text-end">₹{{ number_format($igstTotal,2) }}</td>
</tr>
@else
<tr>
    <td>CGST</td>
    <td class="text-end">₹{{ number_format($cgstTotal,2) }}</td>
</tr>
<tr>
    <td>SGST</td>
    <td class="text-end">₹{{ number_format($sgstTotal,2) }}</td>
</tr>
@endif

<tr class="total-final">
    <td>Total Amount</td>
    <td class="text-end">
        ₹{{ number_format($invoice->subtotal + $cgstTotal + $sgstTotal + $igstTotal,2) }}
    </td>
</tr>
</table>

<!-- FOOTER -->
<div class="footer">
    <div>
        Total (in words): <strong>{{ $invoice->amount_in_words ?? '' }}</strong>
    </div>

    <div>
        This is an electronically generated document, no signature required
    </div>
</div>

</div>

</body>
</html>