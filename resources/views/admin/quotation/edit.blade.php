@extends('index')
@push('title', get_phrase('Edit Quotation'))
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
                    <li><a href="#">{{ get_phrase('Edit Quotation') }}</a></li>
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
                <p class="column-title mb-2">{{ get_phrase('Edit Quotation') }}</p>
                <form id="invoice_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-lg-4">
                            <div class="form-group">
                                <label for="client">Select Client</label>
                                <div class="row">
                                    <div class="col-lg-10">
                                        <select id="client" name="client_id"
                                            class="form-control client_id select2 w-100">
                                            <option>Select Client</option>
                                            @foreach ($clients as $client)
                                                <option
                                                    @if (isset($quotation)) @if ($quotation->client_id == $client->id)
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
                        </div> --}}

                        <div class="col-md-4">
                            <div class="fpb-7">
                                <label for="client" class="eForm-label">{{ get_phrase('Select Client') }}</label>
                                <select class="form-select eForm-select select2" id="client" name="client_id">
                                    <option value="" disabled selected>{{ get_phrase('Select a client') }}</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ $client->id == $quotation->client_id ? 'selected' : '' }}>
                                            {{ $client->contact_person }}
                                            ({{ $client->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="create-date" class="eForm-label">Create Date</label>
                                <div class="input-group date">
                                    <input value="{{ \Carbon\Carbon::parse($quotation->create_date)->format('Y-m-d') }}"
                                        name="create_date" type="date" class="form-control eForm-control" />

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="due-date" class="eForm-label">Due Date</label>
                                <div class="input-group date">
                                    <input
                                        @if (isset($quotation)) value="{{ \Carbon\Carbon::parse($quotation->due_date)->format('Y-m-d') }}" @endif
                                        id="" name="due_date" type="date" class="form-control eForm-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="form-group">
                                <label for="note" class="eForm-label">Note</label>
                                <textarea name="note" id="note" class="form-control eForm-control" rows="3"> @if (isset($quotation))
{{ $quotation->note }}
@endif
                                </textarea>
                                <span class="invalid-feedback note"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="form-group">
                                <label for="terms" class="eForm-label">Terms & Conditions</label>
                                <textarea name="terms_conditions" id="terms" class="form-control eForm-control" rows="3"> @if (isset($quotation))
{{ $quotation->terms_condition }}
@endif
                                </textarea>
                                <span class="invalid-feedback terms_conditions"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <div class="form-group">
                                <label for="discount" class="eForm-label">Discount</label>
                                <input @if (isset($quotation)) value="{{ $quotation->discount }}" @endif
                                    id="discount" name="discount" class="form-control discount eForm-control"
                                    value="0" placeholder="Discount">
                                <span class="invalid-feedback discount"></span>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <div class="form-group">
                                <label for="discount" class="eForm-label">GST %</label>
                                <select name="vat" id="vat" class="form-control eForm-control">
                                    @foreach ($gsts as $gst)
                                        <option value="{{ number_format($gst->rate) }}">{{ $gst->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback vat"></span>
                            </div>
                        </div>

                        {{-- <div class="col-lg-3">
                            <div class="form-group">
                                <label for="payment_status" class="eForm-label">Payment Status</label>
                                <select class="form-control payment_status" id="payment_status" name="payment_status">
                                    <option value="">Select Status</option>
                                    @foreach ($payment_status as $status)
                                        <option @if ($quotation->payment_status == $status->id) selected @endif value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback payment_status"></span>
                            </div>
                        </div> --}}
                        <div class="col-lg-12 items_wrapper mt-2">
                            @foreach ($quotation->items as $item)
                                <div class="row py-1" id="items_row_{{ $loop->index }}">
                                    <div class="col-lg-2">
                                        <input name="quantity[]" value="{{ $item->quantity }}"
                                            class="form-control eForm-control quantity quantity_{{ $loop->index }}"
                                            placeholder="Quantity">
                                        <span class="invalid-feedback quantity_{{ $loop->index }}"></span>
                                    </div>
                                    <div class="col-lg-5">
                                        <select name="description[]" id=""
                                            class="form-control eForm-control description_{{ $loop->index }} description">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    @if ($product->id == $item->product_id) selected @endif>{{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback description_{{ $loop->index }}"></span>
                                    </div>
                                    <div class="col-lg-2">
                                        <input name="unit_price[]" value="{{ $item->unit_price }}"
                                            class="form-control eForm-control unit_price unit_price_{{ $loop->index }}"
                                            placeholder="Unit Price">
                                        <span class="invalid-feedback unit_price_{{ $loop->index }}"></span>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control eForm-control"
                                            value="{{ $item->unit_price * $item->quantity }}" placeholder="Total Price"
                                            disabled>
                                    </div>
                                    <div class="col-lg-1">
                                        <button class="btn btn-danger remove_btn"><i class="fi-rr-trash"></i></button>
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
                                            <input @if (isset($quotation)) value="{{ $total_price }}" @endif
                                                id="total" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Vat</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input @if (isset($quotation)) value="{{ $quotation->vat }}" @endif
                                                id="vat_total" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Discount</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                @if (isset($quotation)) value="{{ $quotation->discount }}" @endif
                                                id="discountt" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-6">
                                            <span class="eForm-label">Grand Total</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                @if (isset($quotation)) value="{{ ($quotation->vat / 100 + 1) * ($total_price - $quotation->discount) }}" @endif
                                                id="grand_total" disabled class="form-control eForm-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="submit" class="btn-form btn-success" value="Update Invoice">
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
        $('#invoice_form').on('submit', function(e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('.loading-container').css('display', 'flex');
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('admin.quotation.update', ['id' => $quotation->id]) }}',
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
            var count = parseInt('{{ $quotation->items->count() - 1 }}');
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
                                    <input name="quantity[]" value="" class="form-control eForm-control quantity quantity_${count}"
                                           placeholder="Qty">
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
                                    <input class="form-control eForm-control total_price" placeholder="Total Price" disabled>
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

            $(wrapper).on('keyup', 'input.quantity', function() {
                calculate();
            });
            $(document).on('keyup', 'input#vat', function() {
                calculate();
            });
            $(wrapper).on('keyup', 'input.unit_price', function() {
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
                    grand_total = total - (discount ?? 0);
                    total_price.val(quantity.val() * unit_price.val());
                }
                let vat = $('#vat');
                let vat_total = $('#vat_total');
                vat_total.val(vat.val());

                discount_f.val(discount ?? 0);
                total_f.val(total);
                grand_total = ((vat.val() ?? 0) / 100 + 1) * grand_total;
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
@endpush
