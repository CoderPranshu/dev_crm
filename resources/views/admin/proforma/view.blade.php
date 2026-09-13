@extends('index')
@push('title', get_phrase('Proforma Invoices'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Proforma Invoices') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.proforma.index') }}">{{ get_phrase('Proforma') }}</a></li>
                    <li><a href="#">{{ get_phrase('Proforma Invoices') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

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

        // Normalize addresses
        $fromAddress = strtolower($proforma->branch->address); 
        $toAddress = strtolower($proforma->customer->address);

        $fromState = null;
        $toState = null;

        // Detect states
        foreach ($states as $state) {
            if (!$fromState && str_contains($fromAddress, $state)) {
                $fromState = $state;
            }
            if (!$toState && str_contains($toAddress, $state)) {
                $toState = $state;
            }
        }

        // GST type
        $isInterState = $fromState && $toState && $fromState !== $toState;

        // Totals
        $subTotal = 0;
        $igstTotal = 0;
        $cgstTotal = 0;
        $sgstTotal = 0;
    @endphp



    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Proforma Invoices') }}</p>

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="eForm-label">Proforma Invoice #{{ $proforma->proforma_no }}</h4>
                        <p class="eForm-label"><b>Status:</b>
                            @if ($received && $received != '0' && $received != $proforma->total)
                                <span class="badge bg-warning">
                                    Partial Pay
                                </span>
                            @elseif ($received && $received != '0' && $received == $proforma->total)
                                <span class="badge bg-success">
                                    Paid
                                </span>
                            @elseif ($received == '0')
                                <span class="badge bg-danger">
                                    UnPaid
                                </span>
                            @endif
                        </p>
                        <a href="{{ route('admin.proforma.pdf', $proforma->id) }}" target="_blank"
                            class="btn-form py-2 btn-secondary">
                            Print PDF
                        </a>
                    </div>

                    <div class="card-body">

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="eForm-label">Bill To</h5>
                                <p class="eForm-label">
                                    <strong>{{ $proforma->customer->name }}</strong><br>
                                    {{ $proforma->customer->address ?? '' }}<br>
                                    Phone: {{ $proforma->customer->phone ?? '' }}
                                </p>
                                <p class="eForm-label">
                                    <strong>GSTIN: </strong>{{$proforma->customer->gst_no}}
                                </p>
                            </div>

                            <div class="col-md-6 text-end">
                                <p class="eForm-label">
                                    <strong>Proforma Date:</strong> {{ $proforma->proforma_date }}<br>
                                    {{-- <strong>Status:</strong> {{ ucfirst($proforma->status) }} --}}

                                </p>
                                <h5 class="eForm-label">Bill From</h5>
                                <p class="eForm-label">
                                    <strong>{{$proforma->branch->company_name}}</strong> <br>
                                    {{ $proforma->branch->address }} <br>
                                    Phone: {{ $proforma->branch->phone_no }} <br>
                                    <strong>GSTIN:</strong> {{$proforma->customer->gst_no}}
                                </p>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr class="eForm-label">
                                    <th>#</th>
                                    <th>Product</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Qty</th>

                                    <th class="text-end">Taxable Amount</th>
                                    <th class="text-end">{{ get_phrase('Tax') }}</th>
                                    <th class="text-end">{{ get_phrase('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proforma->items as $item)
                                    @php
                                        $line = $item->price * $item->quantity;
                                        $subTotal += $line;

                                        if ($isInterState) {
                                            // IGST
                                            $igst = ($line * $item->gst) / 100;
                                            $igstTotal += $igst;
                                            $taxAmount = $igst;
                                        } else {
                                            // CGST + SGST
                                            $cgst = ($line * ($item->gst / 2)) / 100;
                                            $sgst = ($line * ($item->gst / 2)) / 100;
                                            $cgstTotal += $cgst;
                                            $sgstTotal += $sgst;
                                            $taxAmount = $cgst + $sgst;
                                        }

                                        $finalamount = $line + $taxAmount;
                                    @endphp


                                    <tr class="eForm-label">
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

                                        <td class="text-end">₹{{ number_format($finalamount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="eForm-label">Notes:</h6>
                                <p class="eForm-label">
                                    {{$proforma->notes ?? 'N/A'}}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr class="eForm-label">
                                        <th>Subtotal</th>
                                        <td class="text-end">₹{{ number_format($subTotal, 2) }}</td>
                                    </tr>

                                    @if ($isInterState)
                                        <tr class="eForm-label">
                                            <th>IGST</th>
                                            <td class="text-end">₹{{ number_format($igstTotal, 2) }}</td>
                                        </tr>
                                    @else
                                        <tr class="eForm-label">
                                            <th>CGST</th>
                                            <td class="text-end">₹{{ number_format($cgstTotal, 2) }}</td>
                                        </tr>
                                        <tr class="eForm-label">
                                            <th>SGST</th>
                                            <td class="text-end">₹{{ number_format($sgstTotal, 2) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="eForm-label">
                                        <th>Total</th>
                                        <td class="text-end">
                                            <strong>
                                                ₹{{ number_format($subTotal + $igstTotal + $cgstTotal + $sgstTotal, 2) }}
                                            </strong>
                                        </td>
                                    </tr>

                                    @if ($received && $received != '0')
                                        <tr class="eForm-label">
                                            <th>Paid Amount</th>
                                            <td class="text-end">₹{{ number_format($received, 2) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="eForm-label">
                                        <th>Balance </th>
                                        <td class="text-end">₹{{ number_format(round($proforma->total - $received), 2) }}
                                        </td>
                                    </tr>
                                </table>

                            </div>

                            @if ($received != $proforma->total)
                                <form action="{{ route('admin.proforma.payment') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="proforma_id" value="{{ $proforma->id }}">

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <input type="number" value="{{ $proforma->total - $received }}" step="0.01"
                                                name="amount" class="eForm-control form-control"
                                                max="{{ $proforma->total - $received }}" required placeholder="Amount">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="payment_method" class="eForm-control form-control" required>
                                                <option value="cash">Cash</option>
                                                <option value="upi">UPI</option>
                                                <option value="card">Card</option>
                                                <option value="bank">Bank Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="transaction_id" class="eForm-control form-control"
                                                placeholder="Transaction ID">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" name="payment_date" class="eForm-control form-control"
                                                required>
                                        </div>
                                    </div>

                                    <button class="btn-form btn-success mt-3 w-100">
                                        Receive Payment
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>

@stop
