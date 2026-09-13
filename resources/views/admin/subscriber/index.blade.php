@extends('index')
@push('title', get_phrase('Subscriber'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Subscriber') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Subscriber') }}</a></li>
                </ul>
            </div>
            @can('subscriber-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/subscriber/add']) }}', '{{ get_phrase('Add new subscriber') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new subscriber') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Subscriber') }}</p>
                    <div class="mb-3">
                        <input type="text" id="subscriberSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search name / email / status...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="">{{ get_phrase('Email') }}</th>
                                <th class="">{{ get_phrase('Status') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="subscriberTableBody">
                            @forelse ($subscribers as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="s-name">{{ $cat->name }}</td>
                                    <td class="s-email">{{ $cat->email }}</td>
                                    <td class="s-status">{{ $cat->status }}</td>
                                    <td class="text-center">
                                        @can('subscriber-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/subscriber/edit', 'id' => $cat->id]) }}', '{{ get_phrase('Edit subscriber') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('subscriber-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.subscriber.delete', $cat->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        {{ get_phrase('No subscribers found') }}
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
            const searchInput = document.getElementById("subscriberSearch");
            const tableBody = document.getElementById("subscriberTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const name = row.querySelector(".s-name")?.innerText.toLowerCase() || "";
                    const email = row.querySelector(".s-email")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".s-status")?.innerText.toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        email.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("subscriberNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "subscriberNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="5" class="text-center text-muted">
                        No matching subscribers found
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
