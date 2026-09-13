@extends('index')
@push('title', get_phrase('Vendor Payment'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Vendor Payment') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Vendor Payment') }}</a></li>
                </ul>
            </div>
            @can('payment-terms-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendorpayment/add']) }}', '{{ get_phrase('Add new Payment') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Payment') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Vendor Payment') }}</p>
                    <div class="mb-3">
                        <input type="text" id="paymentTermSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search title / description / vendor...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Description') }}</th>
                                <th class="">{{ get_phrase('Document') }}</th>
                                <th class="">{{ get_phrase('Vendor') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTermTableBody">
                            @forelse ($paymentterms as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="pt-title">
                                        {{ $p->title ?? '' }}
                                    </td>

                                    <td class="pt-description">
                                        {{ $p->description ?? '' }}
                                    </td>

                                    <td class="pt-doc">
                                        <a href="{{ asset('uploads/vendor/paymentterm/' . $p->doc) }}" target="_blank"
                                            class="eForm-label text-info">
                                            {{ get_phrase('View Document') }}
                                        </a>
                                    </td>

                                    <td class="pt-vendor">
                                        {{ $p->vendor->user->name ?? '' }}
                                    </td>

                                    <td class="text-center">
                                        @can('payment-terms-edit')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendorpayment/edit', 'id' => $p->id]) }}', '{{ get_phrase('Edit vendor') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('payment-terms-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.vendorterm.delete', $p->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        {{ get_phrase('No payment terms found') }}
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

            const searchInput = document.getElementById("paymentTermSearch");
            const tableBody = document.getElementById("paymentTermTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".pt-title")?.innerText.toLowerCase() || "";
                    const description = row.querySelector(".pt-description")?.innerText
                    .toLowerCase() || "";
                    const vendor = row.querySelector(".pt-vendor")?.innerText.toLowerCase() || "";
                    const doc = row.querySelector(".pt-doc")?.innerText.toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        description.includes(value) ||
                        vendor.includes(value) ||
                        doc.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("paymentTermNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "paymentTermNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted">
                        No matching payment terms found
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
