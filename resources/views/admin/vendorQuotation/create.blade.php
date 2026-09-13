@extends('index')
@push('title', get_phrase('Submit Quotation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Submit Quotation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Submit Quotation') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <form action="{{ route('admin.vendor.quotation.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="rfq_id" value="{{ $rfq->id }}">

                    <h4 class="eForm-label">RFQ Items</h4>

                    <table class="table">
                        <thead>
                            <tr class="eForm-label">
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Delivery Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rfq->items as $item)
                                <tr class="eForm-label">
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        {{ $item->quantity }}
                                        <input type="hidden" name="quantities[{{ $item->product_id }}]"
                                            value="{{ $item->quantity }}">
                                    </td>
                                    <td>
                                        <input type="number" name="prices[{{ $item->product_id }}]" class="form-control eForm-control"
                                            required>
                                    </td>
                                    <td>
                                        <input type="number" name="delivery_days[{{ $item->product_id }}]"
                                            class="form-control eForm-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <label class="eForm-label">Note</label>
                        <textarea name="note" class="form-control eForm-control"></textarea>
                    </div>

                    <button class="btn-form">Submit Quotation</button>
                </form>
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
