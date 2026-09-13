@extends('index')
@push('title', get_phrase('Proforma Edit'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    @php
        $branches = \App\Models\Branch::get();
    @endphp
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Proforma create') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Proforma Create') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Proforma Invoices') }}</p>
                <form action="{{ route('admin.proforma.update', $proforma->id) }}" method="POST">
                    @Csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Customer') }}</label>
                                <select id="supplier_name" class="eForm-control form-control" name="customer_id" required>
                                    <option value="">{{ get_phrase('Select Customer') }}</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}"
                                            {{ $c->id == $proforma->customer_id ? 'selected' : '' }}>{{ $c->name }}
                                        </option>
                                    @endforeach

                                    <option value="add_vendor">+ Add Vendor</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Proforma Date') }}</label>
                                <input type="date" name="proforma_date" class="eForm-control form-control"
                                    value="{{ $proforma->proforma_date }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Branch') }}</label>
                                <select name="branch_id" id="branchSelect" class="eForm-control form-control">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $branch->id == $proforma->branch_id ? 'selected' : '' }}>
                                            {{ $branch->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="eForm-label">{{ get_phrase('Products') }}</h5>

                    <table class="table table-bordered" id="itemsTable">
                        <thead>
                            <tr class="eForm-label">
                                <th class="">{{ get_phrase('Product') }}</th>
                                <th width="120" class="">{{ get_phrase('Qty') }}</th>
                                <th width="120" class="">{{ get_phrase('Price') }}</th>
                                <th width="120" class="">{{ get_phrase('Hsn Code') }}</th>
                                <th width="120" class="">{{ get_phrase('GST') }}</th>
                                <th width="120" class="">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($proforma->items as $item)
                                <tr>
                                    <td>
                                        <select name="product_id[]" class="eForm-control form-control productSelect"
                                            required data-selected="{{ $item->product_id }}">
                                            <option value="">Select Product</option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" step="0.0001" name="quantity[]"
                                            value="{{ number_format($item->quantity) }}" class="eForm-control form-control"
                                            required>
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" name="price[]"
                                            value="{{ number_format($item->price) }}" class="eForm-control form-control"
                                            required>
                                    </td>

                                    <td>
                                        <select class="eForm-control form-control hsnSelect" name="hsn_code[]">
                                            <option value="">--Select HSN--</option>
                                            @foreach ($hsn as $h)
                                                <option value="{{ $h->hsn_code }}"
                                                    {{ $h->hsn_code == $item->hsn_code ? 'selected' : '' }}>
                                                    {{ $h->hsn_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <select name="gst[]" class="eForm-control form-control gstSelect">
                                            <option value="">--Select GST--</option>
                                            @foreach ($gsts as $g)
                                                <option value="{{ $g->rate }}"
                                                    {{ $g->rate == $item->gst ? 'selected' : '' }}>
                                                    {{ $g->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <button type="button" class="btn-form btn-sm btn-danger removeRow">X</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="button" class="btn-sm btn-form btn-secondary mb-3" id="addRow">Add More</button>
                    
                    <div class="col-md-12">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Notes') }}</label>
                                <textarea class="form-control eForm-control" name="notes">{{$proforma->notes}}</textarea>
                            </div>
                        </div>

                    <button class="btn-form btn-sm btn-primary w-100">Save Proforma</button>
                </form>

            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        document.getElementById('addRow').onclick = function() {
            let currentOptions = document.querySelector('.productSelect').innerHTML;

            let row = `
        <tr>
            <td>
                <select name="product_id[]" class="eForm-control form-control" required>
                    <option value="">{{ get_phrase('Select Product') }}</option>
                    ${currentOptions}
                </select>
            </td>
            <td><input type="number" step="0.0001" name="quantity[]" class="eForm-control form-control" required></td>
            <td><input type="number" step="0.01" name="price[]" class="eForm-control form-control" required></td>
            <td>
                <select class="eForm-control form-control hsnSelect" name="hsn_code[]" id="">
                    <option value="">--Select HSN--</option>
                    @foreach ($hsn as $h)
                        <option value="{{ $h->hsn_code }}">{{ $h->hsn_code }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="gst[]" id="" class="eForm-control form-control gstSelect">
                    <option value="">--Select GST--</option>
                    @foreach ($gsts as $g)
                        <option value="{{ $g->rate }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><button type="button" class="btn-form btn-sm btn-danger removeRow">X</button></td>
        </tr>
    `;
            document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);
        };

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
            }
        });
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

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const branchSelect = document.getElementById('branchSelect');

    function loadProducts(branchId) {
        fetch(`/admin/get-products-by-branch/${branchId}`)
            .then(res => res.json())
            .then(data => {

                // -----------------------
                // PRODUCT OPTIONS
                // -----------------------
                let productOptions = '<option value="">Select Product</option>';
                data.products.forEach(p => {
                    productOptions += `<option value="${p.id}">${p.name}</option>`;
                });

                document.querySelectorAll('.productSelect').forEach(select => {
                    let selected = select.getAttribute('data-selected');
                    select.innerHTML = productOptions;
                    if (selected) select.value = selected;
                });

                // -----------------------
                // HSN OPTIONS
                // -----------------------
                let hsnOptions = '<option value="">--Select HSN--</option>';
                data.hsn.forEach(h => {
                    hsnOptions += `<option value="${h.hsn_code}">${h.hsn_code}</option>`;
                });

                document.querySelectorAll('.hsnSelect').forEach(select => {
                    let selected = select.getAttribute('data-selected');
                    select.innerHTML = hsnOptions;
                    if (selected) select.value = selected;
                });

                // -----------------------
                // GST OPTIONS
                // -----------------------
                let gstOptions = '<option value="">--Select GST--</option>';
                data.gst.forEach(g => {
                    gstOptions += `<option value="${g.rate}">${g.name}</option>`;
                });

                document.querySelectorAll('.gstSelect').forEach(select => {
                    let selected = select.getAttribute('data-selected');
                    select.innerHTML = gstOptions;
                    if (selected) select.value = selected;
                });

            });
    }

    // Branch change
    branchSelect.addEventListener('change', function () {
        loadProducts(this.value);
    });

    // Load on page load (EDIT MODE)
    if (branchSelect.value) {
        loadProducts(branchSelect.value);
    }

    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    });

});
</script>

@endpush
