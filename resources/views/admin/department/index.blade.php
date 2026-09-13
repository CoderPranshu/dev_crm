@extends('index')
@push('title', get_phrase('Department'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Department') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Department') }}</a></li>
                </ul>
            </div>
            @can('department-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/department/add']) }}', '{{ get_phrase('Add new department') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Department') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="column-title mb-2">{{ get_phrase('Departments') }}</p>
                    <div class="mb-3">
                        <input type="text" id="departmentSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search department / branch...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Branch') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="departmentTableBody">
                            @forelse ($departments as $depart)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="d-title">{{ $depart->title }}</td>
                                    <td class="d-branch">{{ $depart->branches->title ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @can('department-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/department/edit', 'id' => $depart->id]) }}', '{{ get_phrase('Edit Department') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('department-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.department.delete', ['id' => $depart->id]) }}', 'undefined');"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        {{ get_phrase('No departments found') }}
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
            const searchInput = document.getElementById("departmentSearch");
            const tableBody = document.getElementById("departmentTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".d-title")?.innerText.toLowerCase() || "";
                    const branch = row.querySelector(".d-branch")?.innerText.toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        branch.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("departmentNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "departmentNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="4" class="text-center text-muted">
                        No matching departments found
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
