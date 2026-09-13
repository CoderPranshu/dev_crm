@extends('index')
@push('title', get_phrase('Purchase Order'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Order') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Order') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Purchase Order') }}</p>
                    <div class="mb-3">
                        <input type="text" id="poSearch" class="eForm-control form-control"
                            placeholder="Search PO / Vendor / Amount...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PO No</th>
                                <th>Vendor</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="poTableBody">
                            @foreach ($purchaseorders as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="po-number">
                                        {{ $p->po_number }}
                                    </td>

                                    <td class="po-vendor">
                                        {{ $p->vendor->user->name ?? 'N/A' }}
                                    </td>

                                    <td class="po-amount">
                                        ₹ {{ number_format($p->total_amount, 2) ?? 'N/A' }}
                                    </td>

                                    <td>
                                        @php
                                            $statuses = ['Pending', 'Processing', 'Completed', 'Cancelled'];
                                        @endphp

                                        <select class="form-select form-select-sm status-change"
                                            data-id="{{ $p->id }}">

                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    {{ $p->status == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="d-flex gap-2">

                                        @if ($p->status == 'Processing')
                                            <a href="{{ route('admin.grn.create', ['id' => $p->id]) }}"
                                                class="btn-form py-2 me-2 btn-sm btn-success shadow-none">
                                                Create GRN
                                            </a>
                                        @endif

                                        @can('purchase-order-show')
                                            <a href="{{ route('admin.po.show', $p->id) }}"
                                                class="btn-form py-2 me-2 btn-sm btn-info shadow-none">
                                                View
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

@stop


@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("poSearch");
            const tableBody = document.getElementById("poTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const po = row.querySelector(".po-number")?.innerText.toLowerCase() || "";
                    const vendor = row.querySelector(".po-vendor")?.innerText.toLowerCase() || "";
                    const amount = row.querySelector(".po-amount")?.innerText.toLowerCase() || "";

                    const match =
                        po.includes(value) ||
                        vendor.includes(value) ||
                        amount.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("poNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "poNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="5" class="text-center text-muted">
                        No matching purchase order found
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


    <script>
        $(document).ready(function() {

            $('.status-change').change(function() {

                let status = $(this).val();
                let id = $(this).data('id');

                $.ajax({
                    url: "/admin/purchase-order/status/" + id,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },

                    success: function(response) {

                        toastr.success(response.message);

                    },

                    error: function() {

                        toastr.error('Something went wrong');

                    }
                });

            });

        });
    </script>
@endpush
