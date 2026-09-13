@extends('index')
@push('title', get_phrase('Purchase Bills'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Bills') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Bills') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Purchase Bills') }}</p>
                    <div class="mb-3">
                        <input type="text" id="purchaseSearch" class="eForm-control form-control"
                            placeholder="Search purchase bill...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PB No</th>
                                <th>Bill Date</th>
                                <th>Supplier</th>
                                <th>Payable Amount</th>
                                <th>Status</th>
                                @can('purchase-bill-show')
                                    <th>Action</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody id="purchaseTableBody">
                            @foreach ($purchases as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="pb-no">{{ $p->bill_no }}</td>
                                    <td class="pb-date">{{ $p->bill_date }}</td>
                                    <td class="pb-supplier">{{ $p->supplier->user->name }}</td>
                                    <td class="pb-amount">{{ number_format($p->total_amount, 2) }}</td>
                                    <td class="pb-status">
                                        @if ($p->status == 'paid')
                                            <span class="bg-success text-white rounded p-1">Paid</span>
                                        @else
                                            <span class="bg-danger text-white rounded p-1">Unpaid</span>
                                        @endif
                                    </td>

                                    @can('purchase-bill-show')
                                        <td>
                                            <a href="{{ route('admin.purchase-bills.show', $p->id) }}"
                                                class="btn-form py-2 btn-sm btn-primary">
                                                <i class="fi-rr-eye"></i>
                                            </a>
                                        </td>
                                    @endcan
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

            const searchInput = document.getElementById("purchaseSearch");
            const tableBody = document.getElementById("purchaseTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const billNo = row.querySelector(".pb-no")?.innerText.toLowerCase() || "";
                    const date = row.querySelector(".pb-date")?.innerText.toLowerCase() || "";
                    const supplier = row.querySelector(".pb-supplier")?.innerText.toLowerCase() ||
                        "";
                    const amount = row.querySelector(".pb-amount")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".pb-status")?.innerText.toLowerCase() || "";

                    const match =
                        billNo.includes(value) ||
                        date.includes(value) ||
                        supplier.includes(value) ||
                        amount.includes(value) ||
                        status.includes(value);

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
                    <td colspan="7" class="text-center text-muted">
                        No matching records found
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
