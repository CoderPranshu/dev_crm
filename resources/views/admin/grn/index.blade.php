@extends('index')
@push('title', get_phrase('GRN Creation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('GRN Creation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('GRN Creation') }}</a></li>
                </ul>
            </div>
            @can('grn-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.grn.create') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new GRN') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('GRN Creation') }}</p>
                    <div class="mb-3">
                        <input type="text" id="grnSearch" class="form-control eForm-control"
                            placeholder="Search GRN / supplier / warehouse / date...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>GRN No</th>
                                <th>Supplier</th>
                                <th>GRN Date</th>
                                <th>Warehouse</th>
                                <th>Total Items</th>
                                <th>Total Qty</th>
                                @can('grn-show')
                                    <th class="text-center">{{ get_phrase('Action') }}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody id="grnTableBody">
                            @foreach ($grns as $grn)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="g-grn">{{ $grn->grn_no }}</td>
                                    <td class="g-supplier">{{ $grn->supplier->user->name ?? $grn->supplier_name ?? '-' }}</td>
                                    <td class="g-date">{{ date('d M Y', strtotime($grn->grn_date)) }}</td>
                                    <td class="g-warehouse">{{ $grn->branch->title ?? 'N/A' }}</td>
                                    <td class="g-items">
                                        @foreach ($grn->items as $item)
                                            {{ $item->product->name ?? 'N/A' }}@if (!$loop->last),@endif

                                        @endforeach
                                    </td>
                                    <td class="g-qty">{{ number_format($grn->items->sum('quantity'), ) }}</td>

                                    @can('grn-show')
                                        <td class="text-center">
                                            <a href="{{ route('admin.grn.show', $grn->id) }}" class="btn btn p-0 px-1"
                                                title="{{ get_phrase('View') }}" data-bs-toggle="tooltip">
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
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("grnSearch");
            const tableBody = document.getElementById("grnTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const grn = row.querySelector(".g-grn")?.innerText.toLowerCase() || "";
                    const supplier = row.querySelector(".g-supplier")?.innerText.toLowerCase() ||
                        "";
                    const date = row.querySelector(".g-date")?.innerText.toLowerCase() || "";
                    const warehouse = row.querySelector(".g-warehouse")?.innerText.toLowerCase() ||
                        "";
                    const items = row.querySelector(".g-items")?.innerText.toLowerCase() || "";
                    const qty = row.querySelector(".g-qty")?.innerText.toLowerCase() || "";

                    const match =
                        grn.includes(value) ||
                        supplier.includes(value) ||
                        date.includes(value) ||
                        warehouse.includes(value) ||
                        items.includes(value) ||
                        qty.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("grnNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "grnNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="8" class="text-center text-muted">
                        No matching GRN found
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
