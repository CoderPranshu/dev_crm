@extends('index')
@push('title', get_phrase('Products'))
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
                <h4>{{ get_phrase('Products') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Products') }}</a></li>
                </ul>
            </div>
            @can('product-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/products/add']) }}', '{{ get_phrase('Add new product') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new product') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="column-title mb-0">{{ get_phrase('Products') }}</p>
                    <div style="min-width: 320px;">
                        <input type="text" id="productTabSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search name / sku / category / unit / stock...') }}">
                    </div>
                </div>

                <!-- MAIN TABS -->
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item">
                        <button class="nav-link eForm-label active" data-bs-toggle="pill" data-bs-target="#rawTab">
                            Raw Materials
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link eForm-label" data-bs-toggle="pill" data-bs-target="#finishedTab">
                            Finished Goods
                        </button>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- ================= RAW MATERIAL ================= -->
                    <div class="tab-pane fade show active" id="rawTab">

                        <!-- Branch Tabs -->
                        <ul class="nav nav-tabs mb-3">
                            @foreach ($branches as $branch)
                                <li class="nav-item">
                                    <button class="nav-link eForm-label {{ $loop->first ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#raw-branch-{{ $branch->id }}">
                                        {{ $branch->title }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Content -->
                        <div class="tab-content">
                            @foreach ($branches as $branch)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="raw-branch-{{ $branch->id }}">

                                    <div class="table-responsive">
                                        <table class="table eTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ get_phrase('Name') }}</th>
                                                    <th>{{ get_phrase('SKU') }}</th>
                                                    <th>{{ get_phrase('Category') }}</th>
                                                    <th>{{ get_phrase('Unit') }}</th>
                                                    <th>{{ get_phrase('Cost Price') }}</th>
                                                    <th>{{ get_phrase('Sale Price') }}</th>
                                                    <th>{{ get_phrase('Opening Stock') }}</th>
                                                    <th>{{ get_phrase('Min Stock') }}</th>
                                                    <th>{{ get_phrase('Stock Item?') }}</th>
                                                    <th>{{ get_phrase('Avl. Stock') }}</th>
                                                    <th class="text-center">{{ get_phrase('Action') }}</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($rawproducts[$branch->id] ?? [] as $product)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->sku }}</td>
                                                        <td>{{ $product->category?->title ?? 'No Category' }}</td>
                                                        <td>{{ $product->unit }}</td>
                                                        <td>{{ number_format($product->cost_price, 2) }}</td>
                                                        <td>{{ number_format($product->sale_price, 2) }}</td>
                                                        <td>{{ number_format($product->opening_stock, 2) }}</td>
                                                        <td>{{ number_format($product->min_stock, 2) }}</td>
                                                        <td>
                                                            @if ($product->is_stock_item)
                                                                <span class="badge bg-success">Yes</span>
                                                            @else
                                                                <span class="badge bg-danger">No</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($product->stock, 2) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @can('product-update')
                                                                <a href="#"
                                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/products/edit', 'id' => $product->id]) }}', '{{ get_phrase('Edit Product') }}')"
                                                                    class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="fi-rr-pencil"></i>
                                                                </a>
                                                            @endcan
                                                            @can('product-delete')
                                                                <a href="#"
                                                                    onclick="confirmModal('{{ route('admin.product.delete', $product->id) }}')"
                                                                    class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="fi-rr-trash"></i>
                                                                </a>
                                                            @endcan

                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="12" class="text-center">No products</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- ================= FINISHED GOODS ================= -->
                    <div class="tab-pane fade" id="finishedTab">

                        <!-- Branch Tabs -->
                        <ul class="nav nav-tabs mb-3">
                            @foreach ($branches as $branch)
                                <li class="nav-item">
                                    <button class="nav-link eForm-label {{ $loop->first ? 'active' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#finished-branch-{{ $branch->id }}">
                                        {{ $branch->title }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Content -->
                        <div class="tab-content">
                            @foreach ($branches as $branch)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="finished-branch-{{ $branch->id }}">

                                    <div class="table-responsive">
                                        <table class="table eTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ get_phrase('Name') }}</th>
                                                    <th>{{ get_phrase('SKU') }}</th>
                                                    <th>{{ get_phrase('Category') }}</th>
                                                    <th>{{ get_phrase('Unit') }}</th>
                                                    <th>{{ get_phrase('Cost Price') }}</th>
                                                    <th>{{ get_phrase('Sale Price') }}</th>
                                                    <th>{{ get_phrase('Opening Stock') }}</th>
                                                    <th>{{ get_phrase('Min Stock') }}</th>
                                                    <th>{{ get_phrase('Stock Item?') }}</th>
                                                    <th>{{ get_phrase('Avl. Stock') }}</th>
                                                    <th class="text-center">{{ get_phrase('Action') }}</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($finishedProducts[$branch->id] ?? [] as $product)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->sku }}</td>
                                                        <td>{{ $product->category?->title ?? 'No Category' }}</td>
                                                        <td>{{ $product->unit }}</td>
                                                        <td>{{ number_format($product->cost_price, 2) }}</td>
                                                        <td>{{ number_format($product->sale_price, 2) }}</td>
                                                        <td>{{ number_format($product->opening_stock, 2) }}</td>
                                                        <td>{{ number_format($product->min_stock, 2) }}</td>
                                                        <td>
                                                            @if ($product->is_stock_item)
                                                                <span class="badge bg-success">Yes</span>
                                                            @else
                                                                <span class="badge bg-danger">No</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($product->stock, 2) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @can('product-update')
                                                                <a href="#"
                                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/products/edit', 'id' => $product->id]) }}', '{{ get_phrase('Edit Product') }}')"
                                                                    class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="fi-rr-pencil"></i>
                                                                </a>
                                                            @endcan
                                                            @can('product-delete')
                                                                <a href="#"
                                                                    onclick="confirmModal('{{ route('admin.product.delete', $product->id) }}')"
                                                                    class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="fi-rr-trash"></i>
                                                                </a>
                                                            @endcan

                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="12" class="text-center">No products</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endforeach
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
            const searchInput = document.getElementById("productTabSearch");

            if (!searchInput) return;

            function getActiveTableBody() {
                const activePane = document.querySelector(".tab-pane.active.show");
                if (!activePane) return null;

                if (activePane.id === "pills-home") {
                    return document.getElementById("rawProductsTableBody");
                }

                if (activePane.id === "pills-profile") {
                    return document.getElementById("finishedProductsTableBody");
                }

                return null;
            }

            function resetAllTables() {
                const tableBodies = [
                    document.getElementById("rawProductsTableBody"),
                    document.getElementById("finishedProductsTableBody")
                ];

                tableBodies.forEach(tableBody => {
                    if (!tableBody) return;

                    tableBody.querySelectorAll("tr").forEach(row => {
                        if (!row.classList.contains("product-no-result-row")) {
                            row.style.display = "";
                        }
                    });

                    const noResult = tableBody.querySelector(".product-no-result-row");
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

                    const name = row.querySelector(".p-name")?.innerText.toLowerCase() || "";
                    const sku = row.querySelector(".p-sku")?.innerText.toLowerCase() || "";
                    const category = row.querySelector(".p-category")?.innerText.toLowerCase() || "";
                    const unit = row.querySelector(".p-unit")?.innerText.toLowerCase() || "";
                    const cost = row.querySelector(".p-cost")?.innerText.toLowerCase() || "";
                    const sale = row.querySelector(".p-sale")?.innerText.toLowerCase() || "";
                    const opening = row.querySelector(".p-opening")?.innerText.toLowerCase() || "";
                    const min = row.querySelector(".p-min")?.innerText.toLowerCase() || "";
                    const stockItem = row.querySelector(".p-stock-item")?.innerText.toLowerCase() || "";
                    const stock = row.querySelector(".p-stock")?.innerText.toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        sku.includes(value) ||
                        category.includes(value) ||
                        unit.includes(value) ||
                        cost.includes(value) ||
                        sale.includes(value) ||
                        opening.includes(value) ||
                        min.includes(value) ||
                        stockItem.includes(value) ||
                        stock.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                const oldNoResult = tableBody.querySelector(".product-no-result-row");
                if (oldNoResult) oldNoResult.remove();

                if (visibleCount === 0) {
                    const colCount = tableBody.id === "rawProductsTableBody" ? 12 : 11;
                    const noResultRow = document.createElement("tr");
                    noResultRow.classList.add("product-no-result-row");
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
