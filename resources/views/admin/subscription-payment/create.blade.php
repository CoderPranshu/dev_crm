@extends('index')

@push('title', get_phrase('Add Payment'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center">

        <h4>
            {{ get_phrase('Subscription Payment') }}
        </h4>

        <a href="{{ route('admin.subscriptions.show',$subscription->id) }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

<div class="eSection-wrap">

    <form action="{{ route('admin.subscription-payments.store') }}"
          method="POST">

        @csrf

        <input type="hidden"
               name="subscription_id"
               value="{{ $subscription->id }}">

        <div class="row">

            <div class="col-md-4 mb-3">

                <label>
                    Client Name
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $subscription->client_name }}"
                       readonly>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Total Amount
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $subscription->total_amount }}"
                       readonly>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Paid Amount
                </label>

                <input type="text"
                       class="form-control"
                       value="{{ $subscription->paid_amount }}"
                       readonly>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Due Amount
                </label>

                <input type="text"
                       id="dueAmount"
                       class="form-control"
                       value="{{ $subscription->due_amount }}"
                       readonly>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Payment Amount
                </label>

                <input type="number"
                       step="0.01"
                       name="amount"
                       id="paymentAmount"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Payment Date
                </label>

                <input type="date"
                       name="payment_date"
                       value="{{ date('Y-m-d') }}"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Payment Method
                </label>

                <select name="payment_method"
                        class="form-select">

                    <option value="">
                        Select Method
                    </option>

                    <option value="Cash">
                        Cash
                    </option>

                    <option value="UPI">
                        UPI
                    </option>

                    <option value="Bank Transfer">
                        Bank Transfer
                    </option>

                    <option value="Cheque">
                        Cheque
                    </option>

                </select>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Transaction ID
                </label>

                <input type="text"
                       name="transaction_id"
                       class="form-control">

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Remarks
                </label>

                <textarea name="remarks"
                          class="form-control"
                          rows="1"></textarea>

            </div>

        </div>

        <button type="submit"
                class="btn btn-primary">

            Save Payment

        </button>

    </form>

</div>

@endsection

@push('js')

<script>

$('#paymentAmount').on(
    'keyup change',
    function(){

        let payment =
            parseFloat(
                $(this).val()
            ) || 0;

        let due =
            parseFloat(
                $('#dueAmount').val()
            ) || 0;

        if(payment > due){

            alert(
                'Payment amount cannot exceed due amount'
            );

            $(this).val('');

        }

    }
);

</script>

@endpush