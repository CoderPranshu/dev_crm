@extends('index')

@push('title', get_phrase('Renew Subscription'))

@section('content')

<div class="eSection-wrap">

<form action="{{ route('admin.renewals.store') }}"
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
                Current Expiry Date
            </label>

            <input type="text"
                   class="form-control"
                   value="{{ $subscription->expiry_date }}"
                   readonly>

        </div>

        <div class="col-md-4 mb-3">

            <label>
                Renewal Duration
            </label>

            <input type="number"
                   name="duration_months"
                   value="12"
                   class="form-control"
                   required>

        </div>

        <div class="col-md-4 mb-3">

            <label>
                Renewal Amount
            </label>

            <input type="number"
                   step="0.01"
                   name="amount"
                   value="{{ $subscription->total_amount }}"
                   class="form-control"
                   required>

        </div>

        <div class="col-md-4 mb-3">

            <label>
                Renewal Date
            </label>

            <input type="date"
                   name="renewal_date"
                   value="{{ date('Y-m-d') }}"
                   class="form-control">

        </div>

        <div class="col-md-4 mb-3">

            <label>
                Remarks
            </label>

            <textarea name="remarks"
                      class="form-control"></textarea>

        </div>

        {{--  --}}

        <div class="col-md-4 mb-3">

            <label>
                Payment Method
            </label>

            <select name="payment_method"
                    class="form-select">

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


        {{--  --}}

    </div>

    <button type="submit"
            class="btn btn-success">

        Renew Subscription

    </button>

</form>

</div>

@endsection