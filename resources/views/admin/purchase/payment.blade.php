@extends('index')
@push('title', get_phrase('Purchase Bills'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Bills') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Bills') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Purchase Bills') }}</p>

                <hr>
                <h6 class="fw-bold">Payment Receipts</h6>

                @if ($bill->payments->count())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Receipt No</th>
                                <th>Date</th>
                                <th>Mode</th>
                                <th class="text-end">Amount (₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bill->payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>RCPT-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                    <td>{{ $payment->payment_mode }}</td>
                                    <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('purchase-receipts.pdf', $payment) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No payments recorded yet.</p>
                @endif
            </div>
        </div>
    </div>

@stop
