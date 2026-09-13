@extends('index')

@push('title', get_phrase('Subscription Details'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h4>
                {{ get_phrase('Subscription Details') }}
            </h4>

        </div>

        <div>

            <a href="{{ route('admin.subscriptions.index') }}"
               class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

</div>

<div class="eSection-wrap">

    <div class="row">

        <div class="col-md-6 mb-3">

            <strong>Client Name :</strong>

            {{ $subscription->client_name }}

        </div>

        <div class="col-md-6 mb-3">

            <strong>Company Name :</strong>

            {{ $subscription->company_name }}

        </div>

        <div class="col-md-6 mb-3">

            <strong>Email :</strong>

            {{ $subscription->email }}

        </div>

        <div class="col-md-6 mb-3">

            <strong>Mobile :</strong>

            {{ $subscription->mobile }}

        </div>

        <div class="col-md-6 mb-3">

            <strong>Purchase Date :</strong>

            {{ $subscription->purchase_date }}

        </div>

        <div class="col-md-6 mb-3">

            <strong>Expiry Date :</strong>

            {{ $subscription->expiry_date }}

        </div>

        <div class="col-md-6 mb-3">

            <strong>Duration :</strong>

            {{ $subscription->duration_months }} Months

        </div>

        <div class="col-md-6 mb-3">

            <strong>Total Amount :</strong>

            ₹{{ number_format($subscription->total_amount,2) }}

        </div>

    </div>

</div>

<div class="eSection-wrap mt-4">

    <h5>

        Selected Services

    </h5>

    <div class="table-responsive">

        <table class="table eTable">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Category</th>

                    <th>Service Type</th>

                    <th>Price</th>

                </tr>

            </thead>

            <tbody>

                @foreach($subscription->items as $item)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $item->category->name ?? '-' }}

                        </td>

                        <td>

                            {{ $item->serviceType->name ?? '-' }}

                        </td>

                        <td>

                            ₹{{ number_format($item->price,2) }}

                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot>

                <tr>

                    <th colspan="3">

                        Total

                    </th>

                    <th>

                        ₹{{ number_format($subscription->total_amount,2) }}

                    </th>

                </tr>

            </tfoot>

        </table>

    </div>

    {{--  --}}

    <div class="eSection-wrap mt-4">

    <h5>
        Payment History
    </h5>

    <div class="table-responsive">

        <table class="table eTable">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Date</th>

                    <th>Amount</th>

                    <th>Method</th>

                    <th>Transaction ID</th>

                </tr>

            </thead>

            <tbody>

                @foreach($subscription->payments as $payment)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $payment->payment_date }}
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

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection

@push('js')
<script>

</script>
@endpush