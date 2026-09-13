<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Waste Collection Receipt</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 10px 20px;
        }

        .header {
            text-align: center;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
        }

        .receipt-title {
            font-size: 16px;
            margin-top: 5px;
            color: #555;
        }

        .divider {
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }

        .row {
            width: 100%;
            margin-bottom: 10px;
        }

        .col-6 {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .box {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .label {
            font-weight: bold;
            color: #000;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .footer {
            margin-top: 40px;
        }

        .signature {
            width: 45%;
            display: inline-block;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 80%;
        }

        .text-right {
            text-align: right;
        }

        .receipt-no {
            font-size: 14px;
            font-weight: bold;
        }

        .small {
            font-size: 11px;
            color: #666;
        }

        .reason-badge {
            padding: 4px 8px;
            border: 1px solid #000;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="company-name">BMS Electronics Pvt Ltd.</div>
        <div class="receipt-title">Waste Collection Receipt</div>
    </div>

    <div class="divider"></div>

    <!-- Top Info -->
    <div class="row">
        <div class="col-6">
            <div class="box">
                <div class="receipt-no">
                    Receipt No: WST-{{ str_pad($return->id, 5, '0', STR_PAD_LEFT) }}
                </div>
                <div class="small">
                    Date: {{ $return->collected_at
                        ? \Carbon\Carbon::parse($return->collected_at)->format('d M Y, h:i A')
                        : now()->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        <div class="col-6 text-right">
            <div class="box">
                <div class="label">Vendor</div>
                {{ $return->vendor->name }}<br>
                <span class="small">{{ $return->vendor->email ?? '' }}</span>
            </div>
        </div>
    </div>

    <!-- Product Table -->
    <table class="table">
        <thead>
            <tr>
                <th style="width:10%">#</th>
                <th>Product</th>
                <th style="width:15%">Qty</th>
                <th style="width:25%">Reason</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $return->product->name }}</td>
                <td>{{ $return->quantity }}</td>
                <td>
                    <span class="reason-badge">
                        {{ ucfirst($return->reason) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Notes -->
    <div class="row" style="margin-top: 15px;">
        <div class="box">
            <span class="label">Note:</span>
            Items collected from vendor due to damage/defect/expiry.
        </div>
    </div>

    <!-- Footer / Signature -->
    <div class="footer">
        <div class="signature">
            Collected By:<br>
            <strong>{{ auth()->user()->name }}</strong>
            <div class="signature-line"></div>
        </div>

        <div class="signature text-right" style="float:right;">
            Vendor Signature
            <div class="signature-line"></div>
        </div>
    </div>

</div>

</body>
</html>
