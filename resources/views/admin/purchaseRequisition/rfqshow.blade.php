@extends('index')
@push('title', get_phrase('Request For Quotation Show'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Requisition') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Request For Quotation Show') }}</a></li>
                </ul>
            </div>
            {{-- <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/proforma/add']) }}', '{{ get_phrase('Add new proforma invoice') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new purchase requisition') }}</span>
                </a>
            </div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">


                <h4 class="eForm-label">RFQ: {{ $rfq->rfq_number }}</h4>

                <h5 class="eForm-label">Items</h5>
                <table class="table ">
                    <thead>
                        <th>Product</th>
                        <th>Qty</th>
                    </thead>
                    @foreach ($rfq->items as $item)
                        <tr class="eForm-label">
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </table>

                <h5 class="eForm-label">Vendors</h5>
                <ul class="eForm-label">
                    @foreach ($rfq->vendors as $vendor)
                        <li>{{ $vendor->user->name }} ({{ $vendor->pivot->status }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("purchaseSearch");
            const tableBody = document.getElementById("purchaseTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const prNumber = row.querySelector(".purchase-pr")?.innerText.toLowerCase() ||
                        "";
                    const user = row.querySelector(".purchase-user")?.innerText.toLowerCase() || "";
                    const department = row.querySelector(".purchase-department")?.innerText
                        .toLowerCase() || "";
                    const reference = row.querySelector(".purchase-reference")?.innerText
                        .toLowerCase() || "";
                    const status = row.querySelector(".purchase-status")?.innerText.toLowerCase() ||
                        "";
                    const approved = row.querySelector(".purchase-approved")?.innerText
                        .toLowerCase() || "";

                    const match =
                        prNumber.includes(value) ||
                        user.includes(value) ||
                        department.includes(value) ||
                        reference.includes(value) ||
                        status.includes(value) ||
                        approved.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("purchaseNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "purchaseNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="8" class="text-center text-muted">
                        {{ get_phrase('No matching purchase requisition found') }}
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
