@extends('index')
@push('title', get_phrase('Edit Invoice'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Invoice') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Edit Invoice') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Edit Invoice') }}</p>
                <form id="invoice_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="client" class="eForm-label">Select Client</label>
                                <div class="row">

                                    <div class="col-lg-10">
                                        <select id="client" name="client_id"
                                            class="form-select eForm-select  select2">
                                            <option>Select Client</option>
                                            @foreach ($clients as $client)
                                                <option
                                                    @if (isset($invoice)) @if ($invoice->client_id == $client->id)
                                                        selected @endif
                                                    @endif
                                                    value="{{ $client->id }}">{{ $client->contact_person }}
                                                    ({{ $client->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback client_id"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="create-date" class="eForm-label">Create Date</label>
                                <div class="input-group date">
                                    <input
                                        @if (isset($invoice)) value="{{ \Carbon\Carbon::parse($invoice->create_date)->format('m/d/y') }}" @endif
                                        name="create_date" type="date" class="form-control eForm-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="due-date" class="eForm-label">Due Date</label>
                                <div class="input-group date">
                                    <input
                                         value="{{ \Carbon\Carbon::parse($invoice->due_date)->format('m/d/y') }}"
                                        name="due_date" type="date" class="form-control eForm-control" />
                                </div>
                                <span class="invalid-feedback due_date"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label for="note" class="eForm-label">Note</label>
                                <textarea name="note" id="note" class="form-control eForm-control note" rows="3"> @if (isset($invoice)) {{ $invoice->note }} @endif
</textarea>
                                <span class="invalid-feedback note"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label for="terms" class="eForm-label">Terms & Conditions</label>
                                <textarea name="terms_conditions" id="terms" class="form-control eForm-control terms_conditions" rows="3"> @if (isset($invoice)) {{ $invoice->terms_condition }} @endif
</textarea>
                                <span class="invalid-feedback terms_conditions"></span>
                            </div>
                        </div>
                        <div class="col-lg-2 mt-3">
                            <div class="form-group">
                                <label for="discount" class="eForm-label">Discount</label>
                                <input @if (isset($invoice)) value="{{ $invoice->discount }}" @endif
                                    id="discount" name="discount" class="form-control eForm-control discount" value="0"
                                    placeholder="Discount">
                                <span class="invalid-feedback discount"></span>
                            </div>
                        </div>
                        <div class="col-lg-2 mt-3">
                            <div class="form-group">
                                <label for="discount" class="eForm-label">Vat %</label>
                                <input @if (isset($invoice)) value="{{ $invoice->vat }}" @endif id="vat"
                                    name="vat" class="form-control eForm-control vat" value="0" placeholder="Vat %">
                                <span class="invalid-feedback vat"></span>
                            </div>
                        </div>
                        <div class="col-lg-2 mt-3">
                            <div class="form-group">
                                <label for="payment_currency" class="eForm-label">Payment Currency</label>
                                <select class="form-select eForm-select select2" id="payment_currency" name="payment_currency">
                                    <option value="">Select Currency</option>
                                    @foreach ($payment_currency as $currency)
                                        <option @if ($invoice->payment_currency == $currency->id) selected @endif
                                            value="{{ $currency->id }}">{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback payment_currency"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-3">
                            <div class="form-group">
                                <label for="payment_type" class="eForm-label">Payment Type</label>
                                <select class="form-select eForm-select select2" id="payment_type" name="payment_type">
                                    <option value="">Select Type</option>
                                    @foreach ($payment_type as $type)
                                        <option @if ($invoice->payment_type == $type->id) selected @endif
                                            value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback payment_type"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-3">
                            <div class="form-group">
                                <label for="payment_status" class="eForm-label">Payment Status</label>
                                <select class="form-select eForm-select select2" id="payment_status" name="payment_status">
                                    <option value="">Select Status</option>
                                    @foreach ($payment_status as $status)
                                        <option @if ($invoice->payment_status == $status->id) selected @endif
                                            value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback payment_status"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 items_wrapper mt-3">
                            @foreach ($invoice->items as $item)
                                <div class="row py-1" id="items_row_{{ $loop->index }}">
                                    <div class="col-lg-2">
                                        <input name="quantity[]" value="{{ $item->quantity }}"
                                            class="form-control eForm-control quantity quantity_{{ $loop->index }}"
                                            placeholder="Quantity">
                                        <span class="invalid-feedback quantity_{{ $loop->index }}"></span>
                                    </div>
                                    <div class="col-lg-5">
                                        <input name="description[]" value="{{ $item->description }}"
                                            class="form-control eForm-control description_{{ $loop->index }} description"
                                            placeholder="Description">
                                        <span class="invalid-feedback description_{{ $loop->index }}"></span>
                                    </div>
                                    <div class="col-lg-2">
                                        <input name="unit_price[]" value="{{ $item->unit_price }}"
                                            class="form-control eForm-control unit_price unit_price_{{ $loop->index }}"
                                            placeholder="Unit Price">
                                        <span class="invalid-feedback unit_price_{{ $loop->index }}"></span>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control eForm-control" value="{{ $item->unit_price * $item->quantity }}"
                                            placeholder="Total Price" disabled>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-danger remove_btn btn-sm"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-12 mt-2">
                            <button type="button" class="btn btn-primary add_btn"><i class="bi bi-plus"></i></button>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-7"></div>
                                <div class="col-lg-5">
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Total</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input @if (isset($invoice)) value="{{ $total_price }}" @endif
                                                id="total" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Total</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input @if (isset($invoice)) value="{{ $invoice->vat }}" @endif
                                                id="vat_total" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Discount</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                @if (isset($invoice)) value="{{ $invoice->discount }}" @endif
                                                id="discountt" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Grand Total</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                @if (isset($invoice)) value="{{ ($invoice->vat / 100 + 1) * ($total_price - $invoice->discount) }}" @endif
                                                id="grand_total" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="submit" class="btn-form mb-3 btn-success" value="Update Invoice">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_client" tabindex="-1" role="dialog" aria-labelledby="add client"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/client/save" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5>Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="add-client-form">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input class="form-control" id="name" name="name" placeholder="client name">
                            </div>
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input class="form-control" id="company_name" name="company_name"
                                    placeholder="company name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input class="form-control" id="phone" name="phone" placeholder="company phone">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input class="form-control" id="address" name="address" placeholder="company address">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input class="form-control" id="email" name="email"
                                    placeholder="company email address">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#invoice_form').on('submit', function(e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('.loading-container').css('display', 'flex');
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('admin.invoice.update', ['id' => $invoice->id]) }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.loading-container').hide();
                    window.location.href = response.redirect;
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('AJAX Error:', errorThrown);
                    console.log('Response:', xhr.responseText);
                },
            });
        });

        $(document).ready(function() {
            var count = parseInt('{{ $invoice->items->count() - 1 }}');
            var total = 0;
            var grand_total = 0;
            var discount = 0;
            var addBtn = '.add_btn';
            var wrapper = '.items_wrapper';
            var total_f = $('#total');
            var grand_total_f = $('#grand_total');
            var discount_f = $('#discountt');
            var discount_ff = $('#discount');

            $(addBtn).click(function() {
                count++;
                $(wrapper).append(
                    `<div class="row py-1" id="items_row_${count}">
                                <div class="col-lg-2">
                                    <input name="quantity[]" value="1" class="form-control quantity quantity_${count}"
                                           placeholder="Quantity">
                                    <span class="invalid-feedback quantity_${count}"></span>
                                </div>
                                <div class="col-lg-5">
                                    <input name="description[]" class="form-control description_${count}"
                                           placeholder="Description">
                                    <span class="invalid-feedback description_${count}"></span>
                                </div>
                                <div class="col-lg-2">
                                    <input name="unit_price[]" class="form-control unit_price unit_price_${count}"
                                           placeholder="Unit Price">
                                    <span class="invalid-feedback unit_price_${count}"></span>
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control total_price" placeholder="Total Price" disabled>
                                </div>
                            </div>`
                )
            })

            $(wrapper).on('click', '.remove_btn', function(e) {
                e.preventDefault();
                count--;
                $(this).parent('div').remove();
                calculate();
            })

            $(wrapper).on('keyup', '.quantity', function() {
                calculate();
            });
            $(document).on('keyup', '#vat', function() {
                calculate();
            });
            $(wrapper).on('keyup', '.unit_price', function() {
                calculate();
            });
            $('#discount').keyup(function() {
                calculate();
            })

            function calculate() {
                total = 0;
                grand_total = 0;
                discount = discount_ff.val();
                for (let i = 0; i < count + 1; i++) {
                    var wrap = $('#items_row_' + i);
                    var quantity = wrap.find('.quantity');
                    var unit_price = wrap.find('.unit_price');
                    var total_price = wrap.find('.total_price');
                    total = total + (quantity.val() * unit_price.val())
                    grand_total = total - discount;
                    total_price.val(quantity.val() * unit_price.val())
                }
                let vat = $('#vat');
                let vat_total = $('#vat_total');
                vat_total.val(vat.val());

                discount_f.val(discount);
                total_f.val(total);
                grand_total = (vat.val() / 100 + 1) * grand_total;
                grand_total = Math.round(grand_total * 100) / 100;
                // grand_total_f.val(grand_total);
                const myInput = document.getElementById('grand_total');


                myInput.value = grand_total;
            }
        })


        //Date range picker
        $('#create-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: true,
            startDate: moment().subtract(6, 'days')
        });

        //Date range picker
        $('#due-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: true,
            startDate: moment().subtract(6, 'days')
        });
    </script>
@endpush
