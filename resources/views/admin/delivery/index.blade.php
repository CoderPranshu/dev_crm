@extends('index')
@push('title', get_phrase('Invoice Generate'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Invoice Generate') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.delivery.ready') }}">{{ get_phrase('Packing') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Invoice Generate') }}</p>
                    <div class="mb-3">
                        <input type="text" id="orderSearch" class="form-control eForm-control"
                            placeholder="Search SO / customer / status / amount...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SO Number</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Expected Delivery</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            @foreach ($readyOrders as $o)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="o-so">{{ $o->so_no }}</td>
                                    <td class="o-customer">{{ $o->proforma->customer->name ?? 'N/A' }}</td>
                                    <td class="o-amount">₹{{ number_format($o->total, 2) }}</td>
                                    <td class="o-date">{{ $o->expected_delivery_date }}</td>
                                    <td class="o-status">{{ ucfirst($o->status) }}</td>
                                    <td>
                                        @if ($o->status == 'billing')
                                            <a href="{{ route('admin.dispatch.form', $o->id) }}"
                                                class="btn-form py-2 btn-primary">
                                                Dispatch Now
                                            </a>
                                        @endif

                                        @if ($o->status == 'ready to dispatch')
                                            <a href="{{ route('admin.invoice.generate', $o->id) }}"
                                                class="btn-form py-2 btn-warning ms-2">
                                                Generate Invoice
                                            </a>
                                        @endif
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

            const searchInput = document.getElementById("orderSearch");
            const tableBody = document.getElementById("orderTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const so = row.querySelector(".o-so")?.innerText.toLowerCase() || "";
                    const customer = row.querySelector(".o-customer")?.innerText.toLowerCase() ||
                        "";
                    const amount = row.querySelector(".o-amount")?.innerText.toLowerCase() || "";
                    const date = row.querySelector(".o-date")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".o-status")?.innerText.toLowerCase() || "";

                    const match =
                        so.includes(value) ||
                        customer.includes(value) ||
                        amount.includes(value) ||
                        date.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("orderNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "orderNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="7" class="text-center text-muted">
                        No matching orders found
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
