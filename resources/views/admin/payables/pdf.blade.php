<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 6px;
        }

        .no-border td {
            border: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h3>PAYMENT RECEIPT</h3>
    </div>

    <table class="no-border">
        <tr>
            <td>
                <strong>Supplier:</strong><br>
                {{ $payment->bill->supplier->user->name }}
            </td>
            <td class="text-right">
                <strong>Receipt No:</strong>
                RCPT-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}<br>
                <strong>Date:</strong>
                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <th>Purchase Bill No</th>
            <td>{{ $payment->bill->bill_no }}</td>
        </tr>
        <tr>
            <th>Payment Mode</th>
            <td>{{ $payment->payment_mode }}</td>
        </tr>
        <tr>
            <th>Amount Paid</th>
            <td class="text-right">
                ₹ {{ number_format($payment->amount, 2) }}
            </td>
        </tr>
    </table>

    <br>

    <p>
        <strong>Amount in Words:</strong><br>
        {{ ucfirst(\NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($payment->amount)) }} only
    </p>

    <br><br>

    <table class="no-border">
        <tr>
            <td>Authorized Signatory</td>
            <td class="text-right">For Company</td>
        </tr>
    </table>

</body>

</html>
