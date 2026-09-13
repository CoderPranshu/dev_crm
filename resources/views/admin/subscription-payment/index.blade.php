@extends('index')

@push('title', get_phrase('Payment History'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="container-fluid">

    @php

        $totalPaid = $payments->sum('amount');

        $dueAmount =
            $subscription->amount
            - $totalPaid;

    @endphp

    <div class="card mb-3">

        <div class="card-header">
            Subscription Details
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <strong>Client</strong><br>
                    {{ $subscription->client_name }}
                </div>

                <div class="col-md-3">
                    <strong>Domain</strong><br>
                    {{ $subscription->domain_name }}
                </div>

                <div class="col-md-2">
                    <strong>Total Amount</strong><br>
                    ₹{{ number_format($subscription->amount,2) }}
                </div>

                <div class="col-md-2">
                    <strong>Paid Amount</strong><br>
                    ₹{{ number_format($totalPaid,2) }}
                </div>

                <div class="col-md-2">
                    <strong>Due Amount</strong><br>

                    <span class="text-danger">
                        ₹{{ number_format($dueAmount,2) }}
                    </span>
                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Payment History
            </h5>

            @if($dueAmount > 0)

                <a href="{{ route('subscription-payments.create',['subscription_id'=>$subscription->id]) }}"
                   class="btn btn-primary">
                    Add Payment
                </a>

            @endif

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Payment Date</th>

                            <th>Amount</th>

                            <th>Method</th>

                            <th>Transaction ID</th>

                            <th>Remarks</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($payments as $key => $payment)

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ date('d M Y', strtotime($payment->payment_date)) }}
                                </td>

                                <td>
                                    ₹{{ number_format($payment->amount,2) }}
                                </td>

                                <td>
                                    {{ $payment->payment_method }}
                                </td>

                                <td>
                                    {{ $payment->transaction_id }}
                                </td>

                                <td>
                                    {{ $payment->remarks }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center">

                                    No Payment Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@push('js')
<script>

</script>
@endpush