<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt {{ $payment->receipt_no }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>

    <h3>{{ $company['name'] }}</h3>
    <p>{{ $company['address'] }}</p>
    <p>{{ $company['gst'] }}</p>

    <hr>

    <h4>PAYMENT RECEIPT</h4>

    <p><strong>Receipt No:</strong> {{ $payment->receipt_no }}</p>
    <p><strong>Invoice No:</strong> {{ $payment->invoice->invoice_no }}</p>
    <p><strong>Customer:</strong> {{ $payment->invoice->salesOrder->proforma->customer->name ?? $payment->customer->name}}</p>
    <p><strong>Payment Date:</strong> {{ $payment->payment_date }}</p>
    <p><strong>Payment Mode:</strong> {{ ucfirst($payment->payment_method) }}</p>

    <table>
        <tr>
            <th>Description</th>
            <th class="text-end">Amount</th>
        </tr>
        <tr>
            <td>Payment Received</td>
            <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
        </tr>
    </table>

    <br>

    <p><strong>Total Paid:</strong> ₹{{ number_format($payment->amount, 2) }}</p>

    <br><br>

    <table width="100%">
        <tr>
            <td>Customer Signature</td>
            <td class="text-end">For {{ $company['name'] }}</td>
        </tr>
    </table>

</body>

</html>
