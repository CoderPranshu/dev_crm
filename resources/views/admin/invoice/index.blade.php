@extends('index')
@push('title', get_phrase('Invoice Dispatch'))
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
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Invoice Dispatch') }}</a></li>
                </ul>
            </div>
            @can('invoice-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.invoice.create') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new invoice') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Invoice') }}</p>
                    <div class="mb-3">
                        <input type="text" id="invoiceSearch" class="form-control eForm-control" placeholder="Search invoice...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                            @foreach ($invoices as $inv)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="inv-no">{{ $inv->invoice_no }}</td>
                                    <td class="inv-customer">
                                        {{ $inv->salesOrder->proforma->customer->name ?? $inv->customer->name }}
                                    </td>
                                    <td class="inv-total">₹{{ number_format($inv->total, 2) }}</td>
                                    <td class="inv-date">{{ $inv->invoice_date }}</td>
                                    <td class="inv-status">{{ ucfirst($inv->status) }}</td>
                                    <td>
                                        @if ($inv->o_status != 'dispatched')
                                            <a href="{{ route('admin.dispatch.form', $inv->id) }}"
                                                class="btn-form py-2 me-3 btn-primary">
                                                Dispatch Now
                                            </a>
                                        @endif

                                        @can('invoice-show')
                                            <a href="{{ route('admin.invoice.view', $inv->id) }}"
                                                class="btn-form py-2 me-2 btn-sm btn-info">
                                                View
                                            </a>

                                            <a href="{{ route('admin.invoice.pdf', $inv->id) }}" target="_blank"
                                                class="btn-form py-2 me-2 btn-sm btn-secondary">
                                                Print
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("invoiceSearch");
            const tableBody = document.getElementById("invoiceTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const invNo = row.querySelector(".inv-no")?.innerText.toLowerCase() || "";
                    const customer = row.querySelector(".inv-customer")?.innerText.toLowerCase() ||
                        "";
                    const total = row.querySelector(".inv-total")?.innerText.toLowerCase() || "";
                    const date = row.querySelector(".inv-date")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".inv-status")?.innerText.toLowerCase() || "";

                    const match =
                        invNo.includes(value) ||
                        customer.includes(value) ||
                        total.includes(value) ||
                        date.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("invoiceNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "invoiceNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="7" class="text-center text-muted">
                        No matching invoices found
                    </td>
                `;
                        tableBody.appendChild(noResultRow);
                    }
                } else {
                    if (noResultRow) {
                        noResultRow.remove();
                    }
                }

            });

        });
    </script>
@endpush
