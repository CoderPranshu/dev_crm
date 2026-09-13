@extends('index')
@push('title', get_phrase('Quotation'))
@push('meta')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Quotation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Quotation') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="{{ route('admin.quotation.create') }}" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new quotation') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Quotation') }}</p>
                <div class="container">
                    <div class="row">
                        <div class="box-tools py-1">
                            <a href="/admin/quotation/edit/{{ $quotation->id }}">
                                <button type="button" class="btn btn-flat margin-bottom pull-right bg-blue"
                                    data-toggle="tooltip" title="{{ trans('Invoice::invoice.optional_title.edit') }}">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                            </a>
                            <a href="{{ route('admin.quotation.sendMail', $quotation->id) }}"
                                class="btn btn-flat margin-bottom bg-olive pull-right">
                                <i class="fa fa-envelope"></i> Send Email
                            </a>
                        </div>
                    </div>
                </div>
                <div id="page-wrap">

                    <div id="page-wrap-inner">

                        {{-- Header with Logo and Company Info --}}
                        <div class="quotation-header-top">
                            <div class="logo-area">
                                <img class="logo-lg" src="{{ get_image(get_settings('light_logo')) }}" width="175px" />
                            </div>
                            <div class="company-info">
                                <h2>{{ get_phrase('BMS Electronic') }}</h2>
                                <p>
                                    {{ get_settings('address') }}<br>
                                    Phone: {{ get_settings('phone') }}<br>
                                    Email: {{ get_settings('system_email') }}<br>
                                    {{-- Web: www.yourcompany.com --}}
                                </p>
                            </div>
                        </div>

                        {{-- Quotation Info --}}
                        <div class="quotation-header">
                            <div class="quotation-to">
                                <h4>Quotation To</h4>
                                <p class="eForm-label"><strong>{{ $quotation->client->name ?? 'n/a' }}</strong><br>
                                    {{ $quotation->client->company_name ?? 'n/a' }}<br>
                                    {{ $quotation->client->address ?? 'n/a' }}<br>
                                    {{ $quotation->client->phone ?? 'n/a' }}<br>
                                    {{ $quotation->client->email ?? 'n/a' }}</p>
                            </div>

                            <div class="quotation-info">
                                <h4>Quotation Info</h4>
                                <table class="info-table">
                                    <tr>
                                        <th class="eForm-label">Quotation ID:</th>
                                        <td class="eForm-label">#{{ $quotation->id }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th class="eForm-label">Payment Type:</th>
                                        <td class="eForm-label">{{ $quotation->paymentType->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="eForm-label">Payment Currency:</th>
                                        <td class="eForm-label">{{ $quotation->paymentCurrency->name ?? 'N/A' }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th class="eForm-label">Created Date:</th>
                                        <td class="eForm-label">
                                            {{ Carbon\Carbon::parse($quotation->create_date)->format('jS F Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- Items Table --}}
                        <table class="quotation-table">
                            <thead>
                                <tr>
                                    <th class="eForm-label">Description</th>
                                    <th class="eForm-label">Unit Price</th>
                                    <th class="eForm-label">Qty.</th>
                                    <th class="eForm-label">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotation->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Totals Section --}}
                        <div class="quotation-summary">
                            <table class="summary-table">
                                <tr>
                                    <th class="eForm-label">Sub Total:</th>
                                    <td class="eForm-label">{{ number_format($total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="eForm-label">GST %:</th>
                                    <td class="eForm-label">{{ number_format($quotation->vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="eForm-label">Discount:</th>
                                    <td class="eForm-label">{{ number_format($quotation->discount, 2) }}</td>
                                </tr>
                                <tr class="grand-total">
                                    <th class="eForm-label">Grand Total:</th>
                                    <td class="eForm-label">
                                        {{ number_format(($quotation->vat / 100 + 1) * ($total - $quotation->discount), 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- Notes and Terms --}}
                        <div class="quotation-notes">
                            @if ($quotation->note)
                                <p class="eForm-label"><strong>Note:</strong> {{ $quotation->note }}</p>
                            @endif
                            @if ($quotation->terms_condition)
                                <p class="eForm-label"><strong>Terms & Conditions:</strong>
                                    {{ $quotation->terms_condition }}</p>
                            @endif
                        </div>

                        {{-- Signature Section --}}
                        <div class="quotation-signature">
                            <div class="sig-block">
                                <hr><span class="eForm-label">Client Signature</span>
                            </div>
                            <div class="sig-block">
                                @if (\Illuminate\Support\Facades\Auth::user()->signature_path)
                                    <img src="{{ asset(\Illuminate\Support\Facades\Auth::user()->signature_path) }}"
                                        alt="Signature">
                                @endif
                                <hr><span class="eForm-label">Authority Signature</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        h4 {
            font-size: 16px;
            font-weight: 600;
            line-height: 26px;
            color: #181c32;
        }

        /* Main Wrapper */
        #page-wrap {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            border: 1px solid #d3d3d3;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px 40px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header */
        .quotation-header-top {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #1e3557;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .logo-area img {
            width: 120px;
            height: auto;
        }

        .company-info {
            text-align: right;
        }

        .company-info h2 {
            margin: 0;
            font-size: 22px;
            color: #1e3557;
        }

        .company-info p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #555;
        }

        /* Quotation Info Section */
        .quotation-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #1e3557;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .quotation-to,
        .quotation-info {
            width: 48%;
        }

        .quotation-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .quotation-info th {
            text-align: left;
            padding: 4px 0;
            color: #333;
        }

        .quotation-info td {
            text-align: right;
            color: #555;
        }

        /* Items Table */
        .quotation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .quotation-table th {
            background: #1e3557;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-weight: 500;
        }

        .quotation-table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .quotation-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* Totals */
        .quotation-summary {
            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .summary-table {
            width: 300px;
            border-collapse: collapse;
        }

        .summary-table th,
        .summary-table td {
            text-align: left;
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        .summary-table td {
            text-align: right;
            color: #333;
            font-weight: 500;
        }

        .grand-total th {
            background: #1e3557;
            color: #fff;
            font-weight: 700;
        }

        .grand-total td {
            background: #1e3557;
            color: #fff;
            font-weight: bold;
        }

        /* Notes & Signature */
        .quotation-notes {
            margin-top: 30px;
            font-size: 14px;
            color: #444;
        }

        .quotation-notes strong {
            color: #1e3557;
        }

        .quotation-signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .sig-block {
            width: 45%;
            text-align: center;
        }

        .sig-block img {
            max-width: 150px;
            height: auto;
            margin-bottom: 5px;
        }

        hr {
            border: none;
            border-top: 1px solid #888;
            margin: 20px 0 5px;
        }

        @media print {
            body {
                margin: 0;
            }

            #page-wrap {
                box-shadow: none;
                border: none;
            }

            .export-btn-area,
            .mainSection-title {
                display: none;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(function() {
            // Summernote
            $('.textarea').summernote()
        })

        function choose_template(e) {
            let btn = $('#send-email-btn');
            let spinner = btn.find('.spinner-border');
            spinner.removeClass('d-none');
            btn.attr('disabled', 'true');
            var template_id = e.target.value;
            var token = "<?php echo e(csrf_token()); ?>";
            var quotation_id = "<?php echo $quotation->id; ?>";
            var url = "/etemplate/template/quotation"
            $.ajax({
                    url: url,
                    type: 'post',
                    data: 'template_id=' + template_id + '&quotation_id=' + quotation_id + '&_token=' + token,
                    dataType: 'json'
                })
                .done(function(response) {
                    var subject = $('#subject');
                    var body = $('#bodyy');
                    subject.val(response.subject);
                    body.summernote('code', '<p></p>');
                    body.summernote('code', response.body);
                    btn.removeAttr('disabled');
                    spinner.addClass('d-none');
                })

        }
    </script>
@endpush
