<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Receipt {{ $payment->receipt_no }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2,
        h3,
        h4 {
            margin: 0;
        }

        .row {
            width: 100%;
            clear: both;
        }

        .col-6 {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .text-end {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        .no-border td {
            border: none;
        }

        .signature {
            margin-top: 50px;
        }
    </style>
</head>

<body>

    @php
        $proforma = $payment->proforma;

        $billTotal = $proforma->total ?? 0;

        // Payments received BEFORE this receipt
        $previousReceived = $proforma->payment->where('id', '<', $payment->id)->sum('amount');

        $currentPayment = $payment->amount ?? 0;

        $totalReceived = $previousReceived + $currentPayment;

        $balanceDue = $billTotal - $totalReceived;

        $status = $balanceDue <= 0 ? 'PAID' : ($previousReceived > 0 ? 'PARTIALLY PAID' : 'UNPAID');
    @endphp

    <!-- HEADER -->
    <div class="row">
        <div class="col-6">
            <h2>{{ get_settings('system_name') }}</h2>
            <p>{{ get_settings('address') }}</p>
            <p>Phone: {{ get_settings('phone') }}</p>
            <p>GST: {{ get_settings('gst') }}</p>
        </div>

        <div class="col-6 text-end">
            <h3>PAYMENT RECEIPT</h3>
            <p><strong>Receipt No:</strong> {{ $payment->receipt_no }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p>
            <p><strong>Status:</strong> {{ $status }}</p>
        </div>
    </div>

    <hr>

    <!-- CUSTOMER DETAILS -->
    <div class="row">
        <div class="col-6">
            <h4>Received From</h4>
            <p>
                <strong>{{ $payment->customer->name }}</strong><br>
                {{ $payment->customer->address }}<br>
                Phone: {{ $payment->customer->phone }}
            </p>
        </div>

        <div class="col-6 text-end">
            <h4>Against Proforma</h4>
            <p>
                <strong>No:</strong> {{ $proforma->proforma_no }}<br>
                <strong>Date:</strong> {{ $proforma->proforma_date }}
            </p>
        </div>
    </div>

    <!-- PAYMENT SUMMARY -->
    <table>
        <tr>
            <th>Bill Total</th>
            <td class="text-end">₹{{ number_format($billTotal, 2) }}</td>
        </tr>

        <tr>
            <th>Amount Received Earlier</th>
            <td class="text-end">₹{{ number_format($previousReceived, 2) }}</td>
        </tr>

        <tr>
            <th>Current Payment</th>
            <td class="text-end">₹{{ number_format($currentPayment, 2) }}</td>
        </tr>

        <tr>
            <th>Transaction ID</th>
            <td class="text-end">{{ $payment->transaction_id ?? 'N/A' }}</td>
        </tr>

        <tr>
            <th><strong>Balance Due</strong></th>
            <td class="text-end">
                <strong>₹{{ number_format(max($balanceDue, 0), 2) }}</strong>
            </td>
        </tr>
    </table>

    <!-- AMOUNT IN WORDS -->
    <p style="margin-top:15px;">
        <strong>Amount in Words:</strong><br>
        {{ $amountInWords }}
    </p>

    <!-- SIGNATURE -->
    <div class="row signature">
        <div class="col-6">
            Customer Signature
        </div>
        <div class="col-6 text-end">
            For {{ get_settings('system_name') }}
        </div>
    </div>

</body>

</html>
