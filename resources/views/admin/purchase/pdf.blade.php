<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            padding: 20px;
        }

        .company-header {
            width: 100%;
            margin-bottom: 20px;
        }

        .company-header td {
            vertical-align: top;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #111;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            color: #333;
        }

        .sub-title {
            font-size: 11px;
            color: #666;
        }

        .section-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .section-table td {
            padding: 6px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .invoice-table th {
            background: #2d3748;
            color: #fff;
            padding: 8px;
            border: 1px solid #dcdcdc;
            font-size: 11px;
        }

        .invoice-table td {
            border: 1px solid #dcdcdc;
            padding: 7px;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-table {
            width: 40%;
            float: right;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .summary-table td,
        .summary-table th {
            border: 1px solid #dcdcdc;
            padding: 8px;
        }

        .summary-table th {
            background: #f5f5f5;
            text-align: left;
        }

        .grand-total {
            background: #2d3748;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
        }

        .amount-words {
            margin-top: 80px;
            border-top: 1px dashed #999;
            padding-top: 10px;
        }

        .footer {
            margin-top: 80px;
        }

        .signature-box {
            width: 250px;
            text-align: center;
            float: right;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .clearfix::after {
            content: "";
            display: block;
            clear: both;
        }
    </style>
</head>

<body>

    <div class="invoice-container">

        {{-- HEADER --}}
        <table class="company-header">
            <tr>
                <td width="60%">
                    <div class="company-name">
                        {{ $bill->branch->company_name ?? 'N/A' }}
                    </div>

                    <div class="sub-title">
                        {{ $bill->branch->address ?? 'N/A' }}<br>
                        GSTIN: {{ $bill->branch->gstin ?? 'N/A' }}<br>
                        Phone: {{ $bill->branch->phone_no ?? 'N/A' }}<br>
                    </div>
                </td>

                <td width="40%" class="text-right">
                    <div class="title">
                        PURCHASE BILL
                    </div>

                    <div class="sub-title">
                        Bill No: {{ $bill->bill_no }}<br>
                        Date:
                        {{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}
                    </div>
                </td>
            </tr>
        </table>

        {{-- SUPPLIER DETAILS --}}
        <table class="section-table">
            <tr>
                <td width="50%">
                    <span class="label">Supplier Details</span><br><br>

                    <strong>
                        {{ $bill->supplier->user->name ?? 'N/A' }}
                    </strong><br>

                    {{ $bill->supplier->address ?? '' }}<br>

                    GSTIN:
                    {{ $bill->supplier->gst_number ?? 'N/A' }}<br>

                    Phone:
                    {{ $bill->supplier->phone ?? 'N/A' }}
                </td>

                <td width="50%" class="text-right">
                    <span class="label">Payment Status</span><br><br>

                    <strong>
                        {{ strtoupper($bill->status) }}
                    </strong><br>

                    Paid:
                    ₹ {{ number_format($bill->paid_amount, 2) }}<br>

                    Due:
                    ₹ {{ number_format($bill->due_amount, 2) }}
                </td>
            </tr>
        </table>

        {{-- ITEMS TABLE --}}
        <table class="invoice-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="30%">Product</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Rate</th>
                    <th width="15%">Amount</th>
                    <th width="10%">GST %</th>
                    <th width="15%">GST Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($bill->items as $item)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->product->name ?? 'N/A' }}
                        </td>

                        <td class="text-center">
                            {{ $item->quantity }}
                        </td>

                        <td class="text-right">
                            ₹ {{ number_format($item->rate, 2) }}
                        </td>

                        <td class="text-right">
                            ₹ {{ number_format($item->amount, 2) }}
                        </td>

                        <td class="text-center">
                            {{ $item->gst_rate }}%
                        </td>

                        <td class="text-right">
                            ₹ {{ number_format($item->gst_amount, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTALS --}}
        <div class="clearfix">

            <table class="summary-table">
                <tr>
                    <th>Taxable Amount</th>
                    <td class="text-right">
                        ₹ {{ number_format($bill->taxable_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>CGST</th>
                    <td class="text-right">
                        ₹ {{ number_format($bill->cgst_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>SGST</th>
                    <td class="text-right">
                        ₹ {{ number_format($bill->sgst_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>IGST</th>
                    <td class="text-right">
                        ₹ {{ number_format($bill->igst_amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Total GST</th>
                    <td class="text-right">
                        ₹ {{ number_format($bill->total_tax, 2) }}
                    </td>
                </tr>

                <tr class="grand-total">
                    <td>
                        Grand Total
                    </td>

                    <td class="text-right">
                        ₹ {{ number_format($bill->total_amount, 2) }}
                    </td>
                </tr>
            </table>

        </div>

        {{-- AMOUNT IN WORDS --}}
        <div class="amount-words">
            <strong>Amount in Words:</strong><br>

            {{ ucfirst(\NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($bill->total_amount)) }}
            only.
        </div>

        {{-- FOOTER --}}
        <div class="footer clearfix">

            <div class="signature-box">

                <div class="signature-line">
                    Authorized Signatory
                </div>

            </div>

        </div>

    </div>

</body>

</html>
