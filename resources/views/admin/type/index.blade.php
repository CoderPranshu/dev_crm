@extends('index')
@push('title', get_phrase('Leave Type'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Type') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Leave Type') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/type/add']) }}', '{{ get_phrase('Add new type') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new type') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Leave Type') }}</p>
                    <div class="mb-3">
                        <input type="text" id="typeSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search name / days...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Days') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="typeTableBody">
                            @forelse ($types as $type)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="t-name">{{ $type->name }}</td>
                                    <td class="t-days">{{ $type->days }} Days</td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/type/edit', 'id' => $type->id]) }}', '{{ get_phrase('Edit Candidates') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#"
                                            onclick="confirmModal('{{ route('admin.type.delete', $type->id) }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        {{ get_phrase('No types found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("typeSearch");
            const tableBody = document.getElementById("typeTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const name = row.querySelector(".t-name")?.innerText.toLowerCase() || "";
                    const days = row.querySelector(".t-days")?.innerText.toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        days.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("typeNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "typeNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="4" class="text-center text-muted">
                        No matching types found
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
