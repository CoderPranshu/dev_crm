@extends('index')

@push('title', get_phrase('Edit Subscription'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h4>
                {{ get_phrase('Edit Subscription') }}
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

    <form action="{{ route('admin.subscriptions.update',$subscription->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-4 mb-3">

                <label>
                    Client Name
                </label>

                <input type="text"
                       name="client_name"
                       class="form-control"
                       value="{{ $subscription->client_name }}"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Company Name
                </label>

                <input type="text"
                       name="company_name"
                       class="form-control"
                       value="{{ $subscription->company_name }}">

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Mobile
                </label>

                <input type="text"
                       name="mobile"
                       class="form-control"
                       value="{{ $subscription->mobile }}">

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ $subscription->email }}">

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Purchase Date
                </label>

                <input type="date"
                       name="purchase_date"
                       class="form-control"
                       value="{{ $subscription->purchase_date }}"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Duration (Months)
                </label>

                <input type="number"
                       name="duration_months"
                       class="form-control"
                       value="{{ $subscription->duration_months }}"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Renew Before Days
                </label>

                <input type="number"
                       name="renew_before_days"
                       class="form-control"
                       value="{{ $subscription->renew_before_days }}">

            </div>

            <div class="col-md-8 mb-3">

                <label>
                    Remarks
                </label>

                <textarea name="remarks"
                          class="form-control"
                          rows="2">{{ $subscription->remarks }}</textarea>

            </div>

        </div>

        <hr>

        <h5>
            Services
        </h5>

        <div id="serviceRows">

            @foreach($subscription->items as $item)

            <div class="row serviceRow mb-3">

                <div class="col-md-4">

                    <select name="category_id[]"
                            class="form-select categorySelect"
                            required>

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ $item->subscription_category_id == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <select name="service_type_id[]"
                            class="form-select serviceTypeSelect"
                            required>

                        <option value="{{ $item->serviceType->id }}">

                            {{ $item->serviceType->name }}

                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <input type="number"
                           step="0.01"
                           name="price[]"
                           class="form-control priceInput"
                           value="{{ $item->price }}"
                           readonly>

                </div>

                <div class="col-md-1">

                    <button type="button"
                            class="btn btn-danger removeRow">

                        X

                    </button>

                </div>

            </div>

            @endforeach

        </div>

        <button type="button"
                id="addMore"
                class="btn btn-success mb-3">

            Add More

        </button>

        <div class="row">

            <div class="col-md-4">

                <label>
                    Total Amount
                </label>

                <input type="text"
                       id="totalAmount"
                       class="form-control"
                       value="{{ $subscription->total_amount }}"
                       readonly>

            </div>

        </div>

        <br>

        <button type="submit"
                class="btn btn-primary">

            Update Subscription

        </button>

    </form>

</div>

@endsection

@push('js')

<script>

$('#addMore').click(function(){

    let row = $('.serviceRow:first').clone();

    row.find('select').val('');

    row.find('input.priceInput').val('');

    $('#serviceRows').append(row);

});

$(document).on(
    'click',
    '.removeRow',
    function(){

        if($('.serviceRow').length > 1){

            $(this)
            .closest('.serviceRow')
            .remove();

            calculateTotal();
        }

    }
);

function calculateTotal()
{
    let total = 0;

    $('.priceInput').each(function(){

        total += parseFloat($(this).val()) || 0;

    });

    $('#totalAmount').val(total);
}

$(document).on(
    'change',
    '.categorySelect',
    function(){

        let categoryId = $(this).val();

        let serviceDropdown = $(this)
            .closest('.serviceRow')
            .find('.serviceTypeSelect');

        $.ajax({

            url:
            "{{ url('admin/get-service-types') }}/"
            + categoryId,

            type: "GET",

            success:function(response){

                let options =
                '<option value="">Select Service</option>';

                $.each(
                    response,
                    function(index,item){

                        options +=
                        `<option value="${item.id}"
                                 data-price="${item.price}">
                                 ${item.name}
                         </option>`;

                    }
                );

                serviceDropdown.html(options);

            }

        });

    }
);

$(document).on(
    'change',
    '.serviceTypeSelect',
    function(){

        let price =
        $(this)
        .find(':selected')
        .data('price');

        $(this)
        .closest('.serviceRow')
        .find('.priceInput')
        .val(price);

        calculateTotal();

    }
);

</script>

@endpush