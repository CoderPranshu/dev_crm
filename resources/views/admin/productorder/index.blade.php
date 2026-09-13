@extends('index')
@push('title', get_phrase('Production Orders'))
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
                <h4>{{ get_phrase('Production Orders') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Production Orders') }}</a></li>
                </ul>
            </div>
            @can('production-order-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/productorder/add']) }}', '{{ get_phrase('Add new production order') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new production order') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="column-title mb-0">{{ get_phrase('Production Order') }}</p>
                    <div style="min-width: 320px;">
                        <input type="text" id="productionSearch" class="form-control eForm-control"
                            placeholder="Search sales order / product / status / bom...">
                    </div>
                </div>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link eForm-label active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Sales Order</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link eForm-label" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Pre Planned </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                        tabindex="0">
                        <div class="table-responsive">
                            <table class="table eTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Sales Order') }}</th>
                                        <th>{{ get_phrase('Product Id') }}</th>
                                        <th>{{ get_phrase('Quantity') }}</th>
                                        <th>{{ get_phrase('Order Status') }}</th>
                                        <th>{{ get_phrase('Meta') }}</th>
                                        <th>{{ get_phrase('Production Status') }}</th>
                                        {{-- <th class="text-center">{{ get_phrase('Action') }}</th> --}}
                                    </tr>
                                </thead>

                                <tbody id="salesOrderTableBody">
                                    @forelse ($salesOrder as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td class="ps-order">{{ $product->so_no }}</td>

                                            <td class="ps-product">
                                                @foreach ($product->items as $item)
                                                    <div>
                                                        {{ $item->product->name }}@if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </td>

                                            <td class="ps-qty">
                                                @foreach ($product->items as $item)
                                                    <div>{{ number_format($item->quantity, 2) }}</div>
                                                @endforeach
                                            </td>

                                            <td class="ps-status">
                                                <span class="badge bg-primary">{{ $product->status }}</span>
                                            </td>

                                            <td class="ps-meta">
                                                @foreach ($product->items as $item)
                                                    <div class="mb-2">
                                                        <strong class="text-primary">
                                                            {{ $item->product->name }}
                                                        </strong>

                                                        @forelse ($item->product->bom as $bom)
                                                            <ul class="small mb-2">
                                                                @foreach ($bom->items as $bomItem)
                                                                    @php
                                                                        $base = $bomItem->quantity * $item->quantity;
                                                                        $wastage =
                                                                            ($base * $bomItem->wastage_percent) / 100;
                                                                        $total = $base + $wastage;
                                                                    @endphp

                                                                    <li>
                                                                        <b>{{ $loop->iteration }}.</b>
                                                                        {{ $bomItem->product->name ?? 'Raw #' . $bomItem->raw_product_id }}
                                                                        — Per Unit:
                                                                        {{ number_format($bomItem->quantity, 2) }}
                                                                        — Wastage: {{ $bomItem->wastage_percent }}%
                                                                        — Total:
                                                                        <span
                                                                            class="text-success">{{ number_format($total, 2) }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @empty
                                                            <span class="text-muted">No BOM Found</span>
                                                        @endforelse
                                                    </div>
                                                @endforeach
                                            </td>

                                            <td class="ps-production-status">
                                                @if ($product->production_status == 'approved')
                                                    <span
                                                        class="badge badge-success bg-success">{{ get_phrase('Approved') }}</span>
                                                @else
                                                    <form action="{{ route('admin.approved.order', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="production_status" value="approved">
                                                        <button
                                                            onclick="return confirm('Are you sure you want to approve this order?')"
                                                            class="btn btn-primary btn-sm">Approve</button>
                                                    </form>
                                                @endif
                                            </td>

                                            {{-- <td class="text-center">
                                                <div class="d-flex">
                                                    @can('production-order-update')
                                                        <a href="#"
                                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/productorder/edit', 'id' => $product->id]) }}', '{{ get_phrase('Edit Product') }}')"
                                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fi-rr-pencil"></i>
                                                        </a>
                                                    @endcan
                                                    @can('production-order-delete')
                                                        <a href="#"
                                                            onclick="confirmModal('{{ route('admin.productionorder.delete', $product->id) }}')"
                                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fi-rr-trash"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td> --}}
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">{{ get_phrase('No products found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                            tabindex="0">
                            <div class="table-responsive">
                                <table class="table eTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ get_phrase('PO No') }}</th>
                                            <th>{{ get_phrase('Bom') }}</th>
                                            <th>{{ get_phrase('Product Id') }}</th>
                                            <th>{{ get_phrase('Quantity') }}</th>
                                            <th>{{ get_phrase('Status') }}</th>
                                            <th>{{ get_phrase('Meta') }}</th>
                                            <th>{{ get_phrase('Branch') }}</th>
                                            <th class="text-center">{{ get_phrase('Action') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody id="prePlannedTableBody">
                                        @forelse ($productionorders as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="pp-po">{{ $product->production_no }}</td>
                                                <td class="pp-bom">BOM #{{ $product->bom_id }}</td>
                                                <td class="pp-product">{{ $product->finishedProduct->name }}</td>
                                                <td class="pp-qty">{{ number_format($product->quantity, 2) }}</td>
                                                <td class="pp-status">{{ $product->status }}</td>

                                                <td class="pp-meta">
                                                    @php
                                                        $meta = json_decode($product->meta, true);
                                                    @endphp

                                                    @if (isset($meta['planned_materials']) && count($meta['planned_materials']) > 0)
                                                        <ul class="mb-0">
                                                            @foreach ($meta['planned_materials'] as $item)
                                                                <li class="small">
                                                                    <strong>{{ $item['raw_product_name'] ?: 'Raw #' . $item['raw_product_id'] }}</strong>
                                                                    — {{ $item['qty_per_unit'] }} per unit,
                                                                    Wastage: {{ $item['wastage_percent'] }}%,
                                                                    <span class="text-primary">Total:
                                                                        {{ $item['total_required'] }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">No Planned Data</span>
                                                    @endif
                                                </td>

                                                <td>{{ $product->branch->title }}</td>

                                                <td class="text-center">
                                                    @can('production-order-update')
                                                        <a href="#"
                                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/productorder/edit', 'id' => $product->id]) }}', '{{ get_phrase('Edit Product') }}')"
                                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fi-rr-pencil"></i>
                                                        </a>
                                                    @endcan
                                                    @can('production-order-delete')
                                                        <a href="#"
                                                            onclick="confirmModal('{{ route('admin.productionorder.delete', $product->id) }}')"
                                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fi-rr-trash"></i>
                                                        </a>
                                                    @endcan
                                                    @can('production-order-show')
                                                        <a href="{{ route('admin.productionorder.show', $product->id) }}"
                                                            class="btn btn p-0 px-1" title="{{ get_phrase('View') }}"
                                                            data-bs-toggle="tooltip">
                                                            <i class="fi-rr-eye"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ get_phrase('No products found') }}
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
                const searchInput = document.getElementById("productionSearch");

                if (!searchInput) return;

                function getActiveTableBody() {
                    const activePane = document.querySelector(".tab-pane.active.show");
                    if (!activePane) return null;

                    if (activePane.id === "pills-home") {
                        return document.getElementById("salesOrderTableBody");
                    }

                    if (activePane.id === "pills-profile") {
                        return document.getElementById("prePlannedTableBody");
                    }

                    return null;
                }

                function resetAllTables() {
                    const tableBodies = [
                        document.getElementById("salesOrderTableBody"),
                        document.getElementById("prePlannedTableBody")
                    ];

                    tableBodies.forEach(tableBody => {
                        if (!tableBody) return;

                        tableBody.querySelectorAll("tr").forEach(row => {
                            if (!row.classList.contains("production-no-result-row")) {
                                row.style.display = "";
                            }
                        });

                        const noResult = tableBody.querySelector(".production-no-result-row");
                        if (noResult) noResult.remove();
                    });
                }

                function filterActiveTable() {
                    const value = searchInput.value.toLowerCase().trim();
                    const tableBody = getActiveTableBody();
                    if (!tableBody) return;

                    const rows = tableBody.querySelectorAll("tr");
                    let visibleCount = 0;

                    rows.forEach(row => {
                        if (row.querySelector("td[colspan]")) return;

                        const salesOrder = row.querySelector(".ps-order")?.innerText.toLowerCase() || "";
                        const salesProduct = row.querySelector(".ps-product")?.innerText.toLowerCase() || "";
                        const salesQty = row.querySelector(".ps-qty")?.innerText.toLowerCase() || "";
                        const salesStatus = row.querySelector(".ps-status")?.innerText.toLowerCase() || "";
                        const salesMeta = row.querySelector(".ps-meta")?.innerText.toLowerCase() || "";
                        const productionStatus = row.querySelector(".ps-production-status")?.innerText
                            .toLowerCase() || "";

                        const preBom = row.querySelector(".pp-bom")?.innerText.toLowerCase() || "";
                        const preProduct = row.querySelector(".pp-product")?.innerText.toLowerCase() || "";
                        const preQty = row.querySelector(".pp-qty")?.innerText.toLowerCase() || "";
                        const preStatus = row.querySelector(".pp-status")?.innerText.toLowerCase() || "";
                        const preMeta = row.querySelector(".pp-meta")?.innerText.toLowerCase() || "";

                        const match =
                            salesOrder.includes(value) ||
                            salesProduct.includes(value) ||
                            salesQty.includes(value) ||
                            salesStatus.includes(value) ||
                            salesMeta.includes(value) ||
                            productionStatus.includes(value) ||
                            preBom.includes(value) ||
                            preProduct.includes(value) ||
                            preQty.includes(value) ||
                            preStatus.includes(value) ||
                            preMeta.includes(value);

                        if (match) {
                            row.style.display = "";
                            visibleCount++;
                        } else {
                            row.style.display = "none";
                        }
                    });

                    const oldNoResult = tableBody.querySelector(".production-no-result-row");
                    if (oldNoResult) oldNoResult.remove();

                    if (visibleCount === 0) {
                        const colCount = tableBody.id === "salesOrderTableBody" ? 8 : 7;
                        const noResultRow = document.createElement("tr");
                        noResultRow.classList.add("production-no-result-row");
                        noResultRow.innerHTML = `
                <td colspan="${colCount}" class="text-center text-muted">
                    No matching records found
                </td>
            `;
                        tableBody.appendChild(noResultRow);
                    }
                }

                searchInput.addEventListener("keyup", function() {
                    resetAllTables();
                    filterActiveTable();
                });

                document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
                    tab.addEventListener("shown.bs.tab", function() {
                        resetAllTables();
                        filterActiveTable();
                    });
                });
            });
        </script>
    @endpush
