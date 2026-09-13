@extends('index')
@push('title', get_phrase('Create Invoice'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

@php
    $branches = App\Models\Branch::get();
@endphp
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Invoice') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Create Invoice') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Create Invoice') }}</p>

                <form action="{{ route('admin.invoice.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="eForm-label">Customer</label>
                            <select name="customer_id" class="eForm-control" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="eForm-label">Invoice Date</label>
                            <input type="date" name="invoice_date" class="eForm-control form-control" required>
                        </div>
                         @if (auth()->user()->hasRole('Admin'))
                                <div class="col-md-4 mb-3">
                                    <label for="" class="eForm-label">{{ get_phrase('Branch') }}</label>
                                    <select name="branch_id" class="form-control eForm-control" id="branch_id">
                                        @foreach ($branches as $b)
                                            <option value="{{ $b->id }}">{{ $b->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" id="branch_id" name="branch_id" value="{{ auth()->user()->branch_id }}" readonly>
                            @endif

                        <div class="col-md-4" id="dueDateWrapper" style="display:none;">
                            <label class="eForm-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="eForm-control form-control">
                        </div>

                    </div>

                    <table class="table table-bordered" id="invoiceTable">
                        <thead>
                            <tr class="eForm-label">
                                <th>Product</th>
                                <th class="100">HSN</th>
                                <th width="120">Qty</th>
                                <th width="120">Price</th>
                                <th width="120">Tax</th>
                                <th width="60">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="product_id[]" class="eForm-control form-control product_select" required>
                                        <option value="">Select Product</option>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="hsn_id[]" class="eForm-control form-control hsn_select" required>
                                        <option value="">Select HSN</option>
                                        @foreach ($hsns as $h)
                                            <option value="{{ $h->id }}">{{ $h->hsn_code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="quantity[]"
                                        class="eForm-control form-control" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="price[]" class="eForm-control form-control"
                                        required>
                                </td>
                                <td>
                                    <select name="tax_rate[]" class="eForm-control form-control tax_select" required>
                                        <option value="">Select Tax</option>
                                        @foreach ($taxes as $t)
                                            <option value="{{ $t->rate }}">{{ $t->name }}
                                                ({{ $t->rate }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger removeRow">X</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="addRow" class="btn-form shadow-none btn-secondary mb-3">
                        + Add More
                    </button>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="eForm-label">Notes(Optional)</label>
                            <textarea name="decleration" class="form-control eForm-control" id="" cols="30" rows="1"
                                placeholder="Enter the notes"></textarea>
                        </div>

                        <div class="col-md-3">
                            <label for="" class="eForm-label">{{ get_phrase('Payment Status') }}</label>
                            <select name="status" class="eForm-control form-control" id="payment_status">
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="" class="eForm-label">{{ get_phrase('Bank Details') }}</label>
                            <select name="acc_details" class="eForm-control form-control" id="bank_details">
                                @foreach ($bankDetails as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }} - {{ $bank->ac_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn-form btn-success w-100">
                        Save Invoice
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
<script>

    // ==============================
    // GLOBAL STORE
    // ==============================
    let branchData = {
        products: [],
        hsns: [],
        taxes: []
    };

    // ==============================
    // ADD ROW
    // ==============================
    document.getElementById('addRow').onclick = function () {

        let productHtml = '<option value="">Select Product</option>';
        branchData.products.forEach(p => {
            productHtml += `<option value="${p.id}">${p.name}</option>`;
        });

        let hsnHtml = '<option value="">Select HSN</option>';
        branchData.hsns.forEach(h => {
            hsnHtml += `<option value="${h.id}">${h.hsn_code}</option>`;
        });

        let taxHtml = '<option value="">Select Tax</option>';
        branchData.taxes.forEach(t => {
            taxHtml += `<option value="${t.rate}">
                ${t.name} (${t.rate}%)
            </option>`;
        });

        const row = `
        <tr>
            <td>
                <select name="product_id[]" class="eForm-control form-control product_select" required>
                    ${productHtml}
                </select>
            </td>
            <td>
                <select name="hsn_id[]" class="eForm-control form-control hsn_select" required>
                    ${hsnHtml}
                </select>
            </td>
            <td><input type="number" step="0.01" name="quantity[]" class="eForm-control form-control" required></td>
            <td><input type="number" step="0.01" name="price[]" class="eForm-control form-control" required></td>
            <td>
                <select name="tax_rate[]" class="eForm-control form-control tax_select" required>
                    ${taxHtml}
                </select>
            </td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>
        `;

        document.querySelector('#invoiceTable tbody').insertAdjacentHTML('beforeend', row);
    };

    // ==============================
    // REMOVE ROW
    // ==============================
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    });

    // ==============================
    // UPDATE ALL ROWS
    // ==============================
    function updateAllRows() {

        let productHtml = '<option value="">Select Product</option>';
        branchData.products.forEach(p => {
            productHtml += `<option value="${p.id}">${p.name}</option>`;
        });

        let hsnHtml = '<option value="">Select HSN</option>';
        branchData.hsns.forEach(h => {
            hsnHtml += `<option value="${h.id}">${h.hsn_code}</option>`;
        });

        let taxHtml = '<option value="">Select Tax</option>';
        branchData.taxes.forEach(t => {
            taxHtml += `<option value="${t.rate}">
                ${t.name} (${t.rate}%)
            </option>`;
        });

        $('.product_select').each(function () {
            $(this).html(productHtml);
        });

        $('.hsn_select').each(function () {
            $(this).html(hsnHtml);
        });

        $('.tax_select').each(function () {
            $(this).html(taxHtml);
        });
    }

    // ==============================
    // FETCH BRANCH DATA (COMMON)
    // ==============================
    function loadBranchData(branchId) {

        if (!branchId) return;

        $.ajax({
            url: '/admin/get-branch-data/' + branchId,
            type: 'GET',
            success: function (res) {

                branchData.products = res.products || [];
                branchData.hsns = res.hsns || [];
                branchData.taxes = res.taxes || [];

                // BANKS
                let bankHtml = '';
                res.banks.forEach(function (bank) {
                    bankHtml += `<option value="${bank.id}">
                        ${bank.bank_name} - ${bank.ac_no}
                    </option>`;
                });
                $('#bank_details').html(bankHtml);

                // UPDATE TABLE
                updateAllRows();
            }
        });
    }

    // ==============================
    // BRANCH CHANGE (ADMIN)
    // ==============================
    $(document).on('change', '#branch_id', function () {
        let branchId = $(this).val();
        loadBranchData(branchId);
    });

    // ==============================
    // PAYMENT STATUS
    // ==============================
    document.addEventListener('DOMContentLoaded', function() {

        const paymentStatus = document.getElementById('payment_status');
        const dueDateWrapper = document.getElementById('dueDateWrapper');
        const dueDateInput = document.getElementById('due_date');

        function toggleDueDate() {
            if (paymentStatus.value === '0') {
                dueDateWrapper.style.display = 'block';
                dueDateInput.setAttribute('required', 'required');
            } else {
                dueDateWrapper.style.display = 'none';
                dueDateInput.removeAttribute('required');
                dueDateInput.value = '';
            }
        }

        paymentStatus.addEventListener('change', toggleDueDate);
        toggleDueDate();

        // ==============================
        // AUTO LOAD (ADMIN + NON-ADMIN)
        // ==============================
        let branchInput = document.getElementById('branch_id');

        if (branchInput) {
            let branchId = branchInput.value;
            loadBranchData(branchId);
        }

    });

</script>
@endpush