@extends('index')
@push('title', get_phrase('Vendor'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Vendor') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Vendor') }}</a></li>
                </ul>
            </div>
            @can('vendor-list')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendor/add']) }}', '{{ get_phrase('Add new vendor') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new vendor') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Vendor') }}</p>
                    <div class="mb-3">
                        <input type="text" id="vendorSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search name / company / tax / status / rating...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="">{{ get_phrase('Tax') }}</th>
                                <th class="">{{ get_phrase('Company') }}</th>
                                <th class="">{{ get_phrase('Status') }}</th>
                                <th class="">{{ get_phrase('Rating') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="vendorTableBody">
                            @forelse ($vendors as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="v-name">{{ $cat->user->name }}</td>

                                    <td class="v-tax">{{ $cat->tax_id }}</td>

                                    <td class="v-company">{{ $cat->company }}</td>

                                    <td class="v-status">{{ $cat->status }}</td>

                                    <td class="v-rating">
                                        @php
                                            $avgRating = \App\Models\VendorRate::where('vendor_id', $cat->id)->avg(
                                                'rating',
                                            );
                                        @endphp

                                        @if ($avgRating)
                                            {{ number_format($avgRating, 1) }} ★
                                        @else
                                            No Rating
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @can('vendor-rate')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendor/rating', 'id' => $cat->id]) }}', '{{ get_phrase('Rate vendor') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Rate') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-star"></i>
                                            </a>
                                        @endcan

                                        @can('vendor-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendor/edit', 'id' => $cat->id]) }}', '{{ get_phrase('Edit vendor') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('vendor-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.vendor.delete', $cat->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        {{ get_phrase('No vendors found') }}
                                    </td>
                                </tr>
                            @endforelse
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
