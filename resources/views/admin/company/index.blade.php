@extends('index')
@push('title', get_phrase('Company'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Company') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Company') }}</a></li>
                </ul>
            </div>
            @can('organization-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/add']) }}', '{{ get_phrase('Add new company') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new company') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Companies') }}</p>
                    <div class="mb-3">
                        <input type="text" id="companySearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search company / contact / phone / email / GST / rating...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Company Name') }}</th>
                                {{-- <th>{{ get_phrase('Contact Person') }}</th> --}}
                                <th>{{ get_phrase('Phone') }}</th>
                                <th>{{ get_phrase('Email') }}</th>
                                {{-- <th>{{ get_phrase('Address') }}</th> --}}
                                {{-- <th>{{ get_phrase('Shipping Address') }}</th> --}}
                                <th>{{ get_phrase('GST no') }}</th>
                                {{-- <th>{{ get_phrase('Turn Around Time') }}</th> --}}
                                <th>{{ get_phrase('Ledger') }}</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="companyTableBody">
                            @forelse ($companies as $company)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="c-name">{{ $company->name }}</td>
                                    {{-- <td class="c-contact">{{ $company->user->name ?? ($company->contact_person ?? 'N/A') }}
                                    </td> --}}
                                    <td class="c-phone">{{ $company->phone }}</td>
                                    <td class="c-email">{{ $company->email ?? 'N/A' }}</td>
                                    {{-- <td class="c-address">{{ $company->address }}</td> --}}
                                    {{-- <td class="c-shipping">{{ $company->shipping ?? 'N/A' }}</td> --}}
                                    <td class="c-gst">{{ $company->gst_no ?? 'N/A' }}</td>
                                    {{-- <td class="c-frequency">
                                        {{ isset($company->avg_order_frequency) ? round($company->avg_order_frequency) : 'N/A' }}
                                        days
                                    </td> --}}
                                    <td>
                                        <a href="{{ route('admin.ledger.show', $company->id) }}"
                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="View Ledger"><i class="fi-rr-eye"></i></a>
                                    </td>
                                    <td class="c-rating">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/rate', 'id' => $company->id]) }}', '{{ get_phrase('Rate Company') }}')"
                                            class="btn btn-primary btn-sm p-0 px-1" title="{{ get_phrase('Rate') }}"
                                            data-bs-toggle="tooltip">
                                            {{ $company->rating }} Stars
                                        </a>
                                    </td>
                                    <td class="c-status">
                                        <form action="{{ route('admin.company.block', $company->id) }}" method="POST">
                                            @csrf

                                            @if ($company->is_blocked)
                                                <button class="btn btn-danger btn-sm">
                                                    Blocked
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm">
                                                    Active
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        @can('organization-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/edit', 'id' => $company->id]) }}', '{{ get_phrase('Edit company') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('organization-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.company.delete', $company->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan

                                        <a href="{{ route('admin.company.products', ['vendor_id' => $company->id]) }}" class="btn btn p-o px-1"
                                            title="{{ get_phrase('Vendor Inventory') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-clipboard-list"></i>
                                        </a>

                                         <a href="{{ route('admin.staff.profile', ['info', $company->user->id]) }}"
                                            class="btn btn p-o px-1"
                                            title="{{ get_phrase('View profile info') }}"
                                            data-bs-toggle="tooltip">
                                           <i class="fi-rr-eye"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-muted">
                                        No organization found in this category.
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
            const searchInput = document.getElementById("companySearch");
            const tableBody = document.getElementById("companyTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const name = row.querySelector(".c-name")?.innerText.toLowerCase() || "";
                    const contact = row.querySelector(".c-contact")?.innerText.toLowerCase() || "";
                    const phone = row.querySelector(".c-phone")?.innerText.toLowerCase() || "";
                    const email = row.querySelector(".c-email")?.innerText.toLowerCase() || "";
                    const address = row.querySelector(".c-address")?.innerText.toLowerCase() || "";
                    const shipping = row.querySelector(".c-shipping")?.innerText.toLowerCase() ||
                        "";
                    const gst = row.querySelector(".c-gst")?.innerText.toLowerCase() || "";
                    const frequency = row.querySelector(".c-frequency")?.innerText.toLowerCase() ||
                        "";
                    const rating = row.querySelector(".c-rating")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".c-status")?.innerText.toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        contact.includes(value) ||
                        phone.includes(value) ||
                        email.includes(value) ||
                        address.includes(value) ||
                        shipping.includes(value) ||
                        gst.includes(value) ||
                        frequency.includes(value) ||
                        rating.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("companyNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "companyNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="13" class="text-center text-muted">
                        No matching company found
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






