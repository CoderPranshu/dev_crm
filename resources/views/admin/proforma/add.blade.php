@extends('index')
@push('title', get_phrase('Proforma Create'))
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
@php
    $id = request('id');
@endphp
    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Proforma Invoices') }}</p>
                <form action="{{ route('admin.proforma.store') }}" method="POST">
                    @Csrf
                    <input type="hidden" value="{{ $id }}" name="lead_id" id="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Customer') }}</label>
                                <select class="eForm-control form-control" name="customer_id" id="supplier_name" required>
                                    <option value="">{{ get_phrase('Select Customer') }}</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                     <option value="add_vendor">+ Add Company</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Proforma Date') }}</label>
                                <input type="date" name="proforma_date" class="eForm-control form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Branch') }}</label>
                                <select name="branch_id" id="branchSelect" class="eForm-control form-control">
                                    <option selected disabled>---Select Branch---</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->title }}</option>
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
                            <tr>
                                <td>
                                    <select name="product_id[]" class="eForm-control form-control" required>
                                        <option value="">{{ get_phrase('Select Product') }}</option>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.0001" name="quantity[]"
                                        class="eForm-control form-control" required></td>
                                <td><input type="number" step="0.01" name="price[]" class="eForm-control form-control"
                                        required></td>
                                <td>
                                    <select class="eForm-control form-control" name="hsn_code[]" id="">
                                        <option value="">--Select HSN--</option>
                                        @foreach ($hsn as $h)
                                            <option value="{{ $h->hsn_code }}">{{ $h->hsn_code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="gst[]" id="" class="eForm-control form-control">
                                        <option value="">--Select GST--</option>
                                        @foreach ($gsts as $g)
                                            <option value="{{ $g->rate }}">{{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><button type="button" class="btn-form btn-sm btn-danger removeRow">X</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" class="btn-sm btn-form btn-secondary mb-3" id="addRow">Add More</button>

                    <div class="col-md-12">
                            <div class="mb-3">
                                <label class="eForm-label">{{ get_phrase('Notes') }}</label>
                                <textarea class="form-control eForm-control" name="notes"></textarea>
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
            let currentOptions = document.querySelector('select[name="product_id[]"]').innerHTML;
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
                <select class="eForm-control form-control" name="hsn_code[]" id="">
                    <option value="">--Select HSN--</option>
                    @foreach ($hsn as $h)
                        <option value="{{ $h->hsn_code }}">{{ $h->hsn_code }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="gst[]" id="" class="eForm-control form-control">
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
document.addEventListener('DOMContentLoaded', function () {
    const supplierSelect = document.getElementById('supplier_name');

    supplierSelect.addEventListener('change', function () {
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
    let productData = [];

document.getElementById('branchSelect').addEventListener('change', function () {
    let branchId = this.value;

    fetch(`/admin/get-products-by-branch/${branchId}`)
        .then(res => res.json())
        .then(data => {

            productData = data.products;

            // -------------------
            // PRODUCT DROPDOWN
            // -------------------
            let productOptions = '<option value="">Select Product</option>';
            data.products.forEach(p => {
                productOptions += `<option value="${p.id}">${p.name}</option>`;
            });

            document.querySelectorAll('select[name="product_id[]"]').forEach(select => {
                select.innerHTML = productOptions;
            });

            // -------------------
            // HSN DROPDOWN
            // -------------------
            let hsnOptions = '<option value="">--Select HSN--</option>';
            data.hsn.forEach(h => {
                hsnOptions += `<option value="${h.hsn_code}">${h.hsn_code}</option>`;
            });

            document.querySelectorAll('select[name="hsn_code[]"]').forEach(select => {
                select.innerHTML = hsnOptions;
            });

            // -------------------
            // GST DROPDOWN
            // -------------------
            let gstOptions = '<option value="">--Select GST--</option>';
            data.gst.forEach(g => {
                gstOptions += `<option value="${g.rate}">${g.name}</option>`;
            });

            document.querySelectorAll('select[name="gst[]"]').forEach(select => {
                select.innerHTML = gstOptions;
            });

        });
});
</script>

@endpush
