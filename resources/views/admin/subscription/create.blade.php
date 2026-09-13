@extends('index')

@push('title', get_phrase('Add Subscription'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="mainSection-title">

    <h4>
        {{ get_phrase('Add Subscription') }}
    </h4>

</div>

<div class="eSection-wrap">

    <form action="{{ route('admin.subscriptions.store') }}"
          method="POST">

        @csrf

        <div class="row">

            

            <div class="col-md-4 mb-3">

                <label>
                    Company
                </label>

                <select name="company_id"
                        id="company_id"
                        class="form-select"
                        required>

                    <option value="">
                        Select Company
                    </option>

                    @foreach($companies as $company)

                        <option value="{{ $company->id }}">

                            {{ $company->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Client Name
                </label>

                <input type="text"
                       name="client_name"
                       id="client_name"
                       class="form-control"
                       required>

            </div>


            <div class="col-md-4 mb-3">

                <label>
                    Mobile
                </label>

                <input type="text"
                    name="mobile"
                    id="mobile"
                    class="form-control">

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Email
                </label>

                <input type="email"
                    name="email"
                    id="email"
                    class="form-control">

            </div>

            {{--  --}}



            <div class="col-md-4 mb-3">

                <label>
                    Purchase Date
                </label>

                <input type="date"
                       name="purchase_date"
                       value="{{ date('Y-m-d') }}"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label>
                    Duration (Months)
                </label>

                <input type="number"
                       name="duration_months"
                       value="12"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-12 mb-3">

                <label>
                    Renew Before Days
                </label>

                <input type="number"
                       name="renew_before_days"
                       value="3"
                       class="form-control">

            </div>

        </div>

        <hr>

        <h5>
            Services
        </h5>

        <div id="serviceRows">

            <div class="row serviceRow mb-3">

                <div class="col-md-4">

                    <select name="category_id[]"
                            class="form-select categorySelect"
                            required>

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <select name="service_type_id[]"
                            class="form-select serviceTypeSelect"
                            required>

                        <option value="">
                            Select Service
                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <input type="number"
                           step="0.01"
                           name="price[]"
                           class="form-control priceInput"
                           readonly>

                </div>

                <div class="col-md-1">

                    <button type="button"
                            class="btn btn-danger removeRow">

                        X

                    </button>

                </div>

            </div>

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
                       readonly
                       value="0">

            </div>

        </div>

        <br>

        <button type="submit"
                class="btn btn-primary">

            Save Subscription

        </button>

    </form>

</div>

@endsection

@push('js')
<script>

$('#addMore').click(function(){

    let row = $('.serviceRow:first').clone();

    row.find('select').val('');

    row.find('input').val('');

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

        total += parseFloat(
            $(this).val()
        ) || 0;

    });

    $('#totalAmount').val(total);
}

$(document).on(
    'keyup change',
    '.priceInput',
    function(){

        calculateTotal();

    }
);

$(document).on(
    'change',
    '.categorySelect',
    function(){

        let categoryId = $(this).val();

        let serviceDropdown = $(this)
            .closest('.serviceRow')
            .find('.serviceTypeSelect');

        serviceDropdown.html(
            '<option value="">Loading...</option>'
        );

        $.ajax({

            url:
            "{{ url('admin/get-service-types') }}/"
            + categoryId,

            type: "GET",

            success: function(response){

                let options =
                    '<option value="">Select Service</option>';

                $.each(
                    response,
                    function(index,item){

                        options +=
                        `<option
                            value="${item.id}"
                            data-price="${item.price}">
                            ${item.name}
                        </option>`;

                    }
                );

                serviceDropdown.html(
                    options
                );

            }

        });

    }
);

$(document).on(
    'change',
    '.serviceTypeSelect',
    function(){

        let price = $(this)
            .find(':selected')
            .data('price');

        $(this)
            .closest('.serviceRow')
            .find('.priceInput')
            .val(price);

        calculateTotal();

    }
);

// 

$('#company_id').change(function(){

    let companyId = $(this).val();

    $.ajax({

        url:
        "{{ url('admin/company-details') }}/"
        + companyId,

        type:'GET',

        success:function(response){

            $('#mobile')
                .val(response.phone);

            $('#email')
                .val(response.email);

            $('#client_name')
                .val(response.name);    

        }

    });

});

</script>
@endpush