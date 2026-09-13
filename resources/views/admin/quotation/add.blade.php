@extends('index')
@push('title', get_phrase('Create Quotation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Quotation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Create Quotation') }}</a></li>
                </ul>
            </div>
            {{-- <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/add']) }}', '{{ get_phrase('Add new quotation') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new quotation') }}</span>
                </a>
            </div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Quotation') }}</p>

                <form id="quote_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" value="{{ $id }}" name="id">
                        {{-- <div class="col-lg-4">
                            <div class="fpb-7">
                                <label for="client" class="eForm-label">Select Client</label>
                                <div class="row">
                                    <div class="col-lg-10">
                                        <select id="client" name="client_id"
                                            class="form-control form-select client_id eForm-control select2 w-100">
                                            <option value="">Select Client</option>
                                            @foreach ($companies as $client)
                                                <option value="{{ $client->id }}">{{ $client->contact_person }}
                                                    ({{ $client->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback client_id"></span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-4">
                            <div class="fpb-7">
                                <label for="client" class="eForm-label">{{ get_phrase('Select Client') }}</label>
                                <select class="form-select eForm-select select2" id="client" name="client_id">
                                    <option value="" disabled selected>{{ get_phrase('Select a client') }}</option>
                                    @foreach ($companies as $client)
                                        <option value="{{ $client->id }}">{{ $client->contact_person }}
                                            ({{ $client->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <label for="client" class="eForm-label">{{ get_phrase('Select Client') }}</label>

                            <select class="eForm-control form-control" name="client_id" id="supplier_name" required>
                                <option value="">{{ get_phrase('Select Customer') }}</option>
                                @foreach ($companies as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                                <option value="add_vendor">+ Add Company</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            {{-- <div class="form-group">
                                <label for="create-date" class="eForm-label">Create Date</label>
                                <div class="input-group date" data-target-input="nearest">
                                    <input value="" id="create-date" name="create_date" type="date"
                                        class="form-control eForm-control"
                                        data-target="#create-date" />
                                </div>
                                <span class="invalid-feedback create_date"></span>
                            </div> --}}
                            <div class="fpb-7">
                                <label for="" class="eForm-label">{{ get_phrase('Create Date') }}</label>
                                <input type="date" name="create_date" value="{{ now()->format('Y-m-d') }}"
                                    class="eForm-control form-control">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            {{-- <div class="form-group">
                                <label for="due-date" class="eForm-label">Due Date</label>
                                <input value="" id="due-date" name="due_date" type="date"
                                        class="form-control  eForm-control"/>
                                <span class="invalid-feedback due_date"></span>
                            </div> --}}
                            <div class="fpb-7">
                                <label for="" class="eForm-label">{{ get_phrase('Due Date') }}</label>
                                <input type="date" class="eForm-control form-control" name="due_date">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label for="note" class="eForm-label">Note</label>
                                <textarea name="note" id="note" class="form-control note eForm-control" rows="3"> </textarea>
                                <span class="invalid-feedback note"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label for="terms" class="eForm-label">Terms & Conditions</label>
                                <textarea name="terms_conditions" id="terms" class="eForm-control form-control terms_conditions" rows="3"></textarea>
                                <span class="invalid-feedback terms_conditions"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-3">
                            <div class="form-group">
                                <label for="discount" class="eForm-label">Discount</label>
                                <input value="" id="discount" name="discount"
                                    class="eForm-control form-control discount" placeholder="Discount">
                                <span class="invalid-feedback discount"></span>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label for="" class="eForm-label">Sales Credit</label>
                                <select name="sales_credit" class="form-control eForm-control" id="">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-3">
                            <div class="form-group">
                                <label for="discount" class="eForm-label">GST %</label>
                                <select name="vat" class="form-control eForm-control" id="vat">
                                    @foreach ($gsts as $gst)
                                        <option value="{{ number_format($gst->rate) }}">{{ $gst->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback vat"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 items_wrapper mt-3">
                            <div class="row py-1" id="items_row_0">
                                <div class="col-lg-2">
                                    <input name="quantity[]" value="" placeholder="Qty"
                                        class="eForm-control form-control quantity quantity_0" placeholder="Quantity">
                                    <span class="invalid-feedback quantity_0"></span>
                                </div>
                                <div class="col-lg-5">
                                    <select name="description[]" id="" class="form-control eForm-control">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback description_0"></span>
                                </div>
                                <div class="col-lg-2">
                                    <input name="unit_price[]" class="eForm-control form-control unit_price unit_price_0"
                                        placeholder="Unit Price">
                                    <span class="invalid-feedback unit_price_0"></span>
                                </div>
                                <div class="col-lg-2">
                                    <input class="eForm-control form-control total_price" placeholder="Total Price"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <button type="button" class="btn btn-primary add_btn"><i class="bi bi-plus"></i></button>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-7"></div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Total</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input name="total" id="total" disabled
                                                class="eForm-control form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">GST %</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input name="vat_total" id="vat_total" disabled
                                                class="eForm-control form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Discount</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input name="discount" id="discountt" disabled
                                                class="eForm-control form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Grand Total</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input name="grand_total" id="grand_total" disabled
                                                class="eForm-control form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="submit" class="btn-form mb-3 btn-success" value="Save Quotation">
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
        let products = @json($products);
    </script>

    <script>
        $('#quote_form').on('submit', function(e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('.loading-container').css('display', 'flex');
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('admin.quotation.save') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('.loading-container').hide();
                    window.location.href = response.redirect;
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('AJAX Error:', errorThrown);
                    console.log('Response:', xhr.responseText);
                }
            });
        });

        $(document).ready(function() {
            var count = 0;
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

                let productOptions = '';

                products.forEach(product => {
                    productOptions += `<option value="${product.id}" data-price="${product.price}">
                        ${product.name}
                    </option>`;
                });
                $(wrapper).append(
                    `<div class="row py-1" id="items_row_${count}">
                                <div class="col-lg-2">
                                    <input name="quantity[]" value="" placeholder="Qty" class="form-control eForm-control quantity quantity_${count}"
                                           placeholder="Quantity">
                                    <span class="invalid-feedback quantity_${count}"></span>
                                </div>
                                <div class="col-lg-5">
                                     <select name="description[]" class="form-control eForm-control product_select">
                                        <option value="">Select Product</option>
                                        ${productOptions}
                                    </select>
                                    <span class="invalid-feedback description_${count}"></span>
                                </div>
                                <div class="col-lg-2">
                                    <input name="unit_price[]" class="form-control eForm-control unit_price unit_price_${count}"
                                           placeholder="Unit Price">
                                    <span class="invalid-feedback unit_price_${count}"></span>
                                </div>
                                <div class="col-lg-2">
                                    <input class="form-control total_price eForm-control" placeholder="Total Price" disabled>
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

            // EVENTS
            $(wrapper).on('keyup', '.quantity, .unit_price', function() {
                calculate();
            });

            $(document).on('change', '#vat', function() {
                calculate();
            });

            $('#discount').on('keyup change', function() {
                calculate();
            });


            // CALCULATION FUNCTION
            function calculate() {
                let total = 0;
                let discount = parseFloat(discount_ff.val()) || 0;

                for (let i = 0; i <= count; i++) {
                    let wrap = $('#items_row_' + i);

                    if (wrap.length) {
                        let quantity = parseFloat(wrap.find('.quantity').val()) || 0;
                        let unit_price = parseFloat(wrap.find('.unit_price').val()) || 0;

                        let row_total = quantity * unit_price;

                        total += row_total;

                        wrap.find('.total_price').val(row_total.toFixed(2));
                    }
                }

                let grand_total = total - discount;

                let vat = parseFloat($('#vat').val()) || 0;

                $('#vat_total').val(vat);
                discount_f.val(discount);
                total_f.val(total.toFixed(2));

                // Apply GST
                grand_total = grand_total * (1 + vat / 100);

                grand_total = Math.round(grand_total * 100) / 100;

                $('#grand_total').val(grand_total.toFixed(2));
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


    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#note'), {
            ui: {
                viewportOffset: {
                    top: 10,
                    bottom: 10
                }
            }
        }).then(editor => {
            editor.editing.view.document.getRoot().setAttribute('style', 'min-height: 300px;');
        }).catch(error => console.error(error));
    </script>

    <script>
        ClassicEditor.create(document.querySelector('#terms'), {
            ui: {
                viewportOffset: {
                    top: 10,
                    bottom: 10
                }
            }
        }).then(editor => {
            editor.editing.view.document.getRoot().setAttribute('style', 'min-height: 300px;');
        }).catch(error => console.error(error));
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const supplierSelect = document.getElementById('supplier_name');

            supplierSelect.addEventListener('change', function() {
                if (this.value === 'add_vendor') {
                    this.value = '';
                    showRightModal(
                        "{{ route('right_modal', ['view_path' => 'admin/company/add']) }}",
                        "Add Company"
                    );
                }
            });
        });
    </script>
@endpush
