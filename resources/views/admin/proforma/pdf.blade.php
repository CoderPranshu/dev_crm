<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Proforma Invoice {{ $proforma->proforma_no }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2,
        h3,
        h4,
        h5 {
            margin: 0;
            padding: 0;
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

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
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
            font-weight: bold;
        }

        .no-border td {
            border: none;
        }

        .total-table th {
            width: 60%;
        }

        .signature {
            margin-top: 50px;
        }
    </style>
</head>

<body>

    @php
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

        $fromAddress = strtolower($proforma->branch->address);
        $toAddress = strtolower($proforma->customer->address ?? '');

        $fromState = $toState = null;

        foreach ($states as $state) {
            if (!$fromState && str_contains($fromAddress, $state)) {
                $fromState = $state;
            }
            if (!$toState && str_contains($toAddress, $state)) {
                $toState = $state;
            }
        }

        $isInterState = $fromState && $toState && $fromState !== $toState;

        $subTotal = $igstTotal = $cgstTotal = $sgstTotal = 0;
    @endphp

    <!-- HEADER -->
    <div class="row mb-20">
        <div class="col-6">
            <h2>{{ $proforma->branch->company_name }}</h2>
        </div>

        <div class="col-6 text-end">
            <h3>PROFORMA INVOICE</h3>
            <p><strong>No:</strong> {{ $proforma->proforma_no }}</p>
            <p><strong>Date:</strong> {{ $proforma->proforma_date }}</p>
        </div>
    </div>

    <!-- BILL DETAILS -->
    <div class="row mb-20">
        <div class="col-6">
            <h4>Bill To</h4>
            <p>
                <strong>{{ $proforma->customer->name }}</strong><br>
                {{ $proforma->customer->address }}<br>
                Phone: {{ $proforma->customer->phone }}<br>
                <strong>GSTIN:</strong> {{$proforma->customer->gst_no}}
            </p>
        </div>

        <div class="col-6 text-end">
            <h4>Bill From</h4>
            <p>
                {{ $proforma->branch->address }}<br>
                Phone: {{ $proforma->branch->phone_no }} <br>
                <strong>GSTIN:</strong> {{$proforma->branch->gstin}}
            </p>
        </div>
    </div>

    <!-- ITEMS TABLE -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-end">Price</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Taxable</th>
                <th class="text-end">Tax</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proforma->items as $item)
                @php
                    $line = $item->price * $item->quantity;
                    $subTotal += $line;

                    if ($isInterState) {
                        $igst = ($line * $item->gst) / 100;
                        $igstTotal += $igst;
                        $taxAmount = $igst;
                    } else {
                        $cgst = ($line * ($item->gst / 2)) / 100;
                        $sgst = ($line * ($item->gst / 2)) / 100;
                        $cgstTotal += $cgst;
                        $sgstTotal += $sgst;
                        $taxAmount = $cgst + $sgst;
                    }

                    $finalAmount = $line + $taxAmount;
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-end">{{ $item->quantity }}</td>
                    <td class="text-end">₹{{ number_format($line, 2) }}</td>
                    <td class="text-end">
                        @if ($isInterState)
                            IGST ₹{{ number_format($taxAmount, 2) }} ({{ $item->gst }}%)
                        @else
                            CGST ₹{{ number_format($cgst, 2) }} ({{ $item->gst / 2 }}%)<br>
                            SGST ₹{{ number_format($sgst, 2) }} ({{ $item->gst / 2 }}%)
                        @endif
                    </td>
                    <td class="text-end">₹{{ number_format($finalAmount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALS -->
    <table class="total-table" style="margin-top:20px;">
        <tr>
            <th>Subtotal</th>
            <td class="text-end">₹{{ number_format($subTotal, 2) }}</td>
        </tr>

        @if ($isInterState)
            <tr>
                <th>IGST</th>
                <td class="text-end">₹{{ number_format($igstTotal, 2) }}</td>
            </tr>
        @else
            <tr>
                <th>CGST</th>
                <td class="text-end">₹{{ number_format($cgstTotal, 2) }}</td>
            </tr>
            <tr>
                <th>SGST</th>
                <td class="text-end">₹{{ number_format($sgstTotal, 2) }}</td>
            </tr>
        @endif

        <tr>
            <th>Total</th>
            <td class="text-end">
                <strong>₹{{ number_format($subTotal + $igstTotal + $cgstTotal + $sgstTotal, 2) }}</strong>
            </td>
        </tr>

        @if ($received && $received != '0')
            <tr>
                <th>Paid Amount</th>
                <td class="text-end">₹{{ number_format($received, 2) }}</td>
            </tr>
        @endif

        <tr>
            <th>Balance </th>
            <td class="text-end">₹{{ number_format(round($proforma->total - $received), 2) }}</td>
        </tr>
    </table>
    
    <h4 class="">Notes</h4>
    <p>{{$proforma->notes}}</p>

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
