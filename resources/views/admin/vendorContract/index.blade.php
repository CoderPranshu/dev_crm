@extends('index')
@push('title', get_phrase('Vendor Contract'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Vendor Contract') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Vendor Contract') }}</a></li>
                </ul>
            </div>
            @can('vendor-contract-list')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendorContract/add']) }}', '{{ get_phrase('Add new Contract') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Contract') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Vendor Contract') }}</p>
                    <div class="mb-3">
                        <input type="text" id="vendorContractSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search title / vendor / description...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Vendor') }}</th>
                                <th class="">{{ get_phrase('Start Date') }}</th>
                                <th class="">{{ get_phrase('End Date') }}</th>
                                <th class="">{{ get_phrase('Status') }}</th>
                                <th class="">{{ get_phrase('Document') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="vendorContractTableBody">
                            @forelse ($vendorCon as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="vc-title">{{ $cat->title }}</td>

                                    <td class="vc-vendor">
                                        {{ $cat->vendor->user->name }}
                                    </td>
                                    <td>
                                        {{ $cat->start_date->format('d M, Y') }}
                                    </td>
                                    <td>
                                        {{ $cat->end_date->format('d M, Y') }}
                                    </td>
                                    <td class="vc-status">
                                        @if ($cat->status == 'draft')
                                            <span class="badge bg-warning text-capitalize">{{ $cat->status }}</span>
                                        @elseif ($cat->status == 'active')
                                            <span class="badge bg-success text-capitalize">{{ $cat->status }}</span>
                                        @elseif ($cat->status == 'expired')
                                            <span class="badge bg-danger text-capitalize">{{ $cat->status }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a class="text-info" href="{{ asset('uploads/vendorcont/' . $cat->doc) }}"
                                            target="_blank">
                                            View Document
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        @can('vendor-contract-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendorContract/edit', 'id' => $cat->id]) }}', '{{ get_phrase('Edit vendor contract') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('vendor-contract-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.vendor.contract.delete', $cat->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        {{ get_phrase('No vendor contracts found') }}
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

            const searchInput = document.getElementById("vendorContractSearch");
            const tableBody = document.getElementById("vendorContractTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".vc-title")?.innerText.toLowerCase() || "";
                    const vendor = row.querySelector(".vc-vendor")?.innerText.toLowerCase() || "";
                    const description = row.querySelector(".vc-description")?.innerText
                        .toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        vendor.includes(value) ||
                        description.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("vendorContractNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "vendorContractNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted">
                        No matching contracts found
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
