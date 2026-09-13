@extends('index')
@push('title', get_phrase('Requested Quotation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Requested Quotation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.rfq.index') }}">{{ get_phrase('RFQ') }}</a></li>
                    <li><a href="#">{{ get_phrase('Requested Quotation') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <table class="table">
                    <thead>
                        <tr class="eForm-label">
                            <th>Vendor</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotations as $q)
                            <tr class="eForm-label">
                                <td>{{ $q->vendor->user->name ?? 'N/A' }}</td>
                                <td>{{ $q->total_amount }}</td>
                                <td>{{ $q->status }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-info"
                                        href="{{ route('admin.vendor.quotation.view', $q->id) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("vendorSearch");
            const tableBody = document.getElementById("vendorTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const name = row.querySelector(".v-name")?.innerText.toLowerCase() || "";
                    const tax = row.querySelector(".v-tax")?.innerText.toLowerCase() || "";
                    const company = row.querySelector(".v-company")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".v-status")?.innerText.toLowerCase() || "";
                    const rating = row.querySelector(".v-rating")?.innerText.toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        tax.includes(value) ||
                        company.includes(value) ||
                        status.includes(value) ||
                        rating.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("vendorNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "vendorNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="7" class="text-center text-muted">
                        No matching vendors found
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
