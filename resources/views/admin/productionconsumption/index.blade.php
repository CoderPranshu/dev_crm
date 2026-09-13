@extends('index')
@push('title', get_phrase('Production Consumptions'))
@push('meta')
@endpush
@push('css')
    <style>
        .nav-link {
            display: block;
            padding: 0rem 1rem !important;
            color: #181c32;
            text-decoration: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
        }
    </style>
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Production Consumptions') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Production Consumptions') }}</a></li>
                </ul>
            </div>
            @can('production-consumption-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/productionconsumption/add']) }}', '{{ get_phrase('Add new production consumption') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new production consumption') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="column-title mb-2">{{ get_phrase('Products') }}</p>
                    <div class="mb-3">
                        <input type="text" id="usageSearch" class="form-control eForm-control"
                            placeholder="Search production / product / warehouse...">
                    </div>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link eForm-label active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Production Order</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link eForm-label" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Sales Order(Manufacturing)</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            <table class="table eTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Production Order') }}</th>
                                        <th>{{ get_phrase('Raw Product Id') }}</th>
                                        <th>{{ get_phrase('Quantity Used') }}</th>
                                        <th>{{ get_phrase('Warehouse') }}</th>
                                    </tr>
                                </thead>

                                <tbody id="productionUsageTableBody">
                                    @forelse ($usage as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="u-production">{{ $product->productOrder->production_no }}</td>
                                            <td class="u-product">{{ $product->procutionCom->name ?? 'N/A' }}</td>
                                            <td class="u-qty">{{ number_format($product->quantity_used, 2) }}</td>
                                            <td class="u-warehouse">{{ $product->branch->title ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">{{ get_phrase('No products found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="table-responsive">
                            <table class="table eTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Sales Order') }}</th>
                                        <th>{{ get_phrase('Raw Product Id') }}</th>
                                        <th>{{ get_phrase('Quantity Used') }}</th>
                                        <th>{{ get_phrase('Warehouse') }}</th>
                                        <th>{{ get_phrase('Status') }}</th>
                                    </tr>
                                </thead>

                                <tbody id="salesUsageTableBody">
                                    @forelse ($salesOrder as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="u-production">{{ $product->salesOrder->so_no }}</td>
                                            <td class="u-product">{{ $product->procutionCom->name ?? 'N/A' }}</td>
                                            <td class="u-qty">{{ number_format($product->quantity_used, 2) }}</td>
                                            <td class="u-warehouse">{{ $product->warehouse->name ?? 'N/A' }}</td>
                                            <td class="u-status">
                                                <span class="badge bg-info">{{ $product->salesOrder->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center">{{ get_phrase('No products found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("usageSearch");

            if (!searchInput) return;

            function getActiveTableBody() {
                const activePane = document.querySelector(".tab-pane.active.show");

                if (!activePane) return null;

                if (activePane.id === "pills-home") {
                    return document.getElementById("productionUsageTableBody");
                }

                if (activePane.id === "pills-contact") {
                    return document.getElementById("salesUsageTableBody");
                }

                return null;
            }

            function filterActiveTable() {
                const value = searchInput.value.toLowerCase().trim();
                const tableBody = getActiveTableBody();

                if (!tableBody) return;

                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const production = row.querySelector(".u-production")?.innerText.toLowerCase() || "";
                    const product = row.querySelector(".u-product")?.innerText.toLowerCase() || "";
                    const qty = row.querySelector(".u-qty")?.innerText.toLowerCase() || "";
                    const warehouse = row.querySelector(".u-warehouse")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".u-status")?.innerText.toLowerCase() || "";

                    const match =
                        production.includes(value) ||
                        product.includes(value) ||
                        qty.includes(value) ||
                        warehouse.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                const oldNoResult = tableBody.querySelector(".usage-no-result-row");
                if (oldNoResult) oldNoResult.remove();

                if (visibleCount === 0) {
                    const colCount = tableBody.id === "productionUsageTableBody" ? 5 : 6;
                    const noResultRow = document.createElement("tr");
                    noResultRow.classList.add("usage-no-result-row");
                    noResultRow.innerHTML = `
                <td colspan="${colCount}" class="text-center text-muted">
                    No matching records found
                </td>
            `;
                    tableBody.appendChild(noResultRow);
                }
            }

            function resetOtherTables() {
                const allBodies = [
                    document.getElementById("productionUsageTableBody"),
                    document.getElementById("salesUsageTableBody")
                ];

                allBodies.forEach(tableBody => {
                    if (!tableBody) return;

                    tableBody.querySelectorAll("tr").forEach(row => {
                        if (!row.classList.contains("usage-no-result-row")) {
                            row.style.display = "";
                        }
                    });

                    const noResultRow = tableBody.querySelector(".usage-no-result-row");
                    if (noResultRow) noResultRow.remove();
                });
            }

            searchInput.addEventListener("keyup", function() {
                resetOtherTables();
                filterActiveTable();
            });

            document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
                tab.addEventListener("shown.bs.tab", function() {
                    resetOtherTables();
                    filterActiveTable();
                });
            });
        });
    </script>
@endpush
