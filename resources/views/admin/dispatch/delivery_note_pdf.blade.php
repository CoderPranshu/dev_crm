<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Note - {{ $delivery->delivery_no }}</title>
    <style>
        body { font-family: DejaVu Sans, Helvetica, Arial, sans-serif; color: #222; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }

        .header { display:flex; justify-content:space-between; align-items:flex-start; }
        .company h2 { margin:0; font-size:18px; }
        .meta { text-align: right; }

        .section { margin-top: 15px; }

        table { width:100%; border-collapse: collapse; }
        th, td { padding:8px; border: 1px solid #ddd; }
        th { background: #f5f5f5; text-align:left; }

        .no-border td { border: none; padding:4px; }

        .small { font-size:11px; color:#555; }
        .right { text-align:right; }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align:center;
            font-size:11px;
            color:#777;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div class="company">
            <h2>{{ $delivery->branch->company_name }}</h2>
            <div class="small">{{ $delivery->branch->address }}</div>
            <div class="small">Phone: {{ $delivery->branch->phone_no }}</div>
            <div class="small">{{ $delivery->branch->gstin }}</div>
        </div>

        <div class="meta">
            <h3>Delivery Note</h3>
            <div><strong>No:</strong> {{ $delivery->delivery_no }}</div>
            <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($delivery->dispatch_date)->format('d M, Y') }}</div>
        </div>
    </div>

    <!-- DELIVERY + COURIER -->
    <div class="section">
        <table class="no-border">
            <tr>
                <td style="width:50%; vertical-align:top;">
                    <strong>Deliver To</strong><br>
                    @php
                        $cust = optional($delivery->salesOrder)->customer;
                    @endphp
                    <div>{{ optional($cust)->name ?? 'N/A' }}</div>
                    <div class="small">{{ optional($cust)->address ?? 'N/A' }}</div>
                    <div class="small">Phone: {{ optional($cust)->phone ?? 'N/A' }}</div>
                </td>

                <td style="width:50%; vertical-align:top; text-align:right;">
                    <strong>Courier Details</strong><br>
                    <div>Courier: {{ $delivery->courier_name ?? '-' }}</div>
                    <div>Tracking No: {{ $delivery->tracking_no ?? '-' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- PRODUCT TABLE (NO PRICING) -->
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:35%;">Product</th>
                    <th style="width:20%;">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($delivery->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SIGNATURE -->
    <div style="margin-top:40px;">
        <table class="no-border">
            <tr>
                <td style="width:50%; text-align:left;">
                    <div style="margin-top:50px;">__________________________</div>
                    <div class="small">Prepared by</div>
                </td>

                <td style="width:50%; text-align:right;">
                    <div style="margin-top:50px;">__________________________</div>
                    <div class="small">Signed for & on behalf of {{ $company['name'] }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

<footer>
    This is computer generated | Delivery note generated at {{ $generated_at->format('d M Y, h:i A') }} • {{ $company['name'] }}
</footer>

</body>
</html>