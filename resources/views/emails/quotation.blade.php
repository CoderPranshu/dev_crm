<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Quotation</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;">

    <div style="max-width:900px; margin:auto; background:#fff; padding:30px; border-radius:8px; border:1px solid #ddd;">

        <!-- Header -->
        <div style="display:flex; justify-content:space-between; border-bottom:2px solid #1e3557; padding-bottom:15px;">
            <div>
                <img src="{{ get_image(get_settings('light_logo')) }}" width="120">
            </div>

            <div style="text-align:right;">
                <h2 style="margin:0; color:#1e3557;">BMS Electronic</h2>
                <p style="font-size:13px; color:#555;">
                    {{ get_settings('address') }}<br>
                    Phone: {{ get_settings('phone') }}<br>
                    Email: {{ get_settings('system_email') }}
                </p>
            </div>
        </div>

        <!-- Quotation Info -->
        <div
            style="display:flex; justify-content:space-between; margin-top:20px; border-bottom:2px solid #1e3557; padding-bottom:15px;">

            <div style="width:48%;">
                <h4>Quotation To</h4>
                <p>
                    <strong>{{ $quotation->client->name ?? 'n/a' }}</strong><br>
                    {{ $quotation->client->company_name ?? 'n/a' }}<br>
                    {{ $quotation->client->address ?? 'n/a' }}<br>
                    {{ $quotation->client->phone ?? 'n/a' }}<br>
                    {{ $quotation->client->email ?? 'n/a' }}
                </p>
            </div>

            <div style="width:48%; text-align:right;">
                <h4>Quotation Info</h4>
                <p><strong>ID:</strong> #{{ $quotation->id }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($quotation->create_date)->format('jS F Y') }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <table width="100%" cellpadding="8" cellspacing="0" style="margin-top:20px; border-collapse:collapse;">
            <thead>
                <tr style="background:#1e3557; color:#fff;">
                    <th align="left">Description</th>
                    <th align="left">Unit Price</th>
                    <th align="left">Qty</th>
                    <th align="left">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($quotation->items as $item)
                    <tr>
                        <td style="border:1px solid #ddd;">{{ $item->product->name }}</td>
                        <td style="border:1px solid #ddd;">{{ number_format($item->unit_price, 2) }}</td>
                        <td style="border:1px solid #ddd;">{{ $item->quantity }}</td>
                        <td style="border:1px solid #ddd;">
                            {{ number_format($item->quantity * $item->unit_price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div style="margin-top:20px; text-align:right;">
            <table width="300px" align="right" cellpadding="8">
                <tr>
                    <td>Sub Total:</td>
                    <td>{{ number_format($total, 2) }}</td>
                </tr>
                <tr>
                    <td>GST %:</td>
                    <td>{{ number_format($quotation->vat, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td>{{ number_format($quotation->discount, 2) }}</td>
                </tr>
                <tr style="background:#1e3557; color:#fff; font-weight:bold;">
                    <td>Grand Total:</td>
                    <td>
                        {{ number_format(($quotation->vat / 100 + 1) * ($total - $quotation->discount), 2) }}
                    </td>
                </tr>
            </table>
        </div>

        <div style="clear:both;"></div>

        <!-- Notes -->
        <div style="margin-top:30px;">
            @if ($quotation->note)
                <p><strong>Note:</strong> {{ $quotation->note }}</p>
            @endif

            @if ($quotation->terms_condition)
                <p><strong>Terms & Conditions:</strong> {{ $quotation->terms_condition }}</p>
            @endif
        </div>

        <!-- Footer -->
        <div style="margin-top:40px; text-align:center; font-size:13px; color:#777;">
            Thank you for your business!
        </div>

    </div>

</body>

</html>
