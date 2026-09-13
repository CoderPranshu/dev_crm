@extends('index')
@push('title', get_phrase('Production Manufacturing'))
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
                <h4>{{ get_phrase('Production Manufacturing') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Production Manufacturing') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Products') }}</p>
                    <div class="mb-3">
                        <input type="text" id="manufactureSearch" class="form-control eForm-control"
                            placeholder="Search SO / product / quantity / status / BOM...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Sales Order') }}</th>
                                <th>{{ get_phrase('Products') }}</th>
                                <th>{{ get_phrase('Quantity') }}</th>
                                <th>{{ get_phrase('Raw material') }}</th>
                                <th>{{ get_phrase('Meta') }}</th>
                                <th>{{ get_phrase('Manufacture') }}</th>
                            </tr>
                        </thead>

                        <tbody id="manufactureTableBody">
                            @forelse ($salesOrder as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="m-so">{{ $product->so_no }}</td>

                                    <td class="m-product">
                                        @foreach ($product->items as $item)
                                            <div>
                                                {{ $item->product->name }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            </div>
                                        @endforeach
                                    </td>

                                    <td class="m-qty">
                                        @foreach ($product->items as $item)
                                            <div>{{ number_format($item->quantity, 2) }}</div>
                                        @endforeach
                                    </td>

                                    <td class="m-status">
                                        <span class="badge bg-success">{{ $product->production_status }}</span>
                                    </td>

                                    <td class="m-bom">
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
                                                                $wastage = ($base * $bomItem->wastage_percent) / 100;
                                                                $total = $base + $wastage;
                                                            @endphp

                                                            <li>
                                                                <b>{{ $loop->iteration }}.</b>
                                                                {{ $bomItem->product->name ?? 'Raw #' . $bomItem->raw_product_id }}
                                                                — Per Unit: {{ number_format($bomItem->quantity, 2) }}
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

                                    <td>
                                        @can('production-consumption-create')
                                            @if ($product->status == 'manufacturing' && $product->manufactured == 'processing')
                                                <div class="export-btn-area">
                                                    <a href="#"
                                                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/productionconsumption/manuwarehouse', 'id' => $product->id]) }}', '{{ get_phrase('Get the manufacture details') }}')"
                                                        class="export_btn">
                                                        <span
                                                            class="d-none d-sm-inline-block">{{ get_phrase('Manufacture') }}</span>
                                                    </a>
                                                </div>
                                            @elseif($product->manufactured == 'manufactured')
                                                <span class="badge bg-info">{{ get_phrase('Manufactured') }}</span>
                                            @else
                                                <span class="badge bg-danger">Manufacturing Not Started</span>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">{{ get_phrase('No products found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        @stop


        @push('js')
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const searchInput = document.getElementById("manufactureSearch");
                    const tableBody = document.getElementById("manufactureTableBody");

                    if (!searchInput || !tableBody) return;

                    searchInput.addEventListener("keyup", function() {
                        const value = this.value.toLowerCase().trim();
                        const rows = tableBody.querySelectorAll("tr");
                        let visibleCount = 0;

                        rows.forEach(row => {
                            if (row.querySelector("td[colspan]")) return;

                            const so = row.querySelector(".m-so")?.innerText.toLowerCase() || "";
                            const product = row.querySelector(".m-product")?.innerText.toLowerCase() || "";
                            const qty = row.querySelector(".m-qty")?.innerText.toLowerCase() || "";
                            const status = row.querySelector(".m-status")?.innerText.toLowerCase() || "";
                            const bom = row.querySelector(".m-bom")?.innerText.toLowerCase() || "";

                            const match =
                                so.includes(value) ||
                                product.includes(value) ||
                                qty.includes(value) ||
                                status.includes(value) ||
                                bom.includes(value);

                            if (match) {
                                row.style.display = "";
                                visibleCount++;
                            } else {
                                row.style.display = "none";
                            }
                        });

                        let noResultRow = document.getElementById("manufactureNoResultRow");

                        if (visibleCount === 0) {
                            if (!noResultRow) {
                                noResultRow = document.createElement("tr");
                                noResultRow.id = "manufactureNoResultRow";
                                noResultRow.innerHTML = `
                    <td colspan="12" class="text-center text-muted">
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
