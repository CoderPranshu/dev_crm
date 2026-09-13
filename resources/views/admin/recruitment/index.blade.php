@extends('index')
@push('title', get_phrase('Recruitment'))
@push('meta')
@endpush
@push('css')
    <style>


    </style>
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Recruitment') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Recruitment') }}</a></li>
                </ul>
            </div>
            @can('recuritment-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/recruitment/add']) }}', '{{ get_phrase('Add new recruitment') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new recruitment') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="d-flex gap-2 mb-3 justify-content-between">
                        <a href="{{ route('admin.recruitment.export') }}" class="export_btn_success btn-sm">
                            Export CSV
                        </a>

                        <button type="button" class="export_btn_primary" data-bs-toggle="modal"
                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/recruitment/import']) }}', '{{ get_phrase('Import CSV Sheet') }}')">
                            Import CSV
                        </button>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="recruitmentSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search title / department / branch / manager...') }}">
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Description') }}</th>
                                <th class="">{{ get_phrase('Department') }}</th>
                                <th class="">{{ get_phrase('Branch') }}</th>
                                <th class="">{{ get_phrase('Position') }}</th>
                                <th class="">{{ get_phrase('Start Date') }}</th>
                                <th class="">{{ get_phrase('End Date') }}</th>
                                <th class="">{{ get_phrase('Manager') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="recruitmentTableBody">
                            @forelse ($recruitment as $rec)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="r-title">{{ $rec->title }}</td>
                                    <td class="r-description">{{ $rec->description }}</td>
                                    <td class="r-department">{{ $rec->department->title ?? 'N/A' }}</td>
                                    <td class="r-branch">{{ $rec->branch->title ?? 'N/A' }}</td>
                                    <td class="r-designation">{{ $rec->designation->title ?? 'N/A' }}</td>
                                    <td class="r-start">{{ $rec->start_date }}</td>
                                    <td class="r-end">{{ $rec->end_date }}</td>
                                    <td class="r-manager">{{ $rec->manager->name ?? 'N/A' }}</td>

                                    <td class="text-center">
                                        @can('recuritment-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/recruitment/edit', 'id' => $rec->id]) }}', '{{ get_phrase('Edit recruitment') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('recuritment-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.recruitment.destroy', ['id' => $rec->id]) }}', 'undefined');"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan

                                        @can('recuritment-show')
                                            <a href="{{ route('admin.recruitment.show', $rec->id) }}" class="btn btn p-0 px-1"
                                                title="{{ get_phrase('View') }}" data-bs-toggle="tooltip">
                                                <i class="fi-rr-eye"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        {{ get_phrase('No recruitment found') }}
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

            const searchInput = document.getElementById("recruitmentSearch");
            const tableBody = document.getElementById("recruitmentTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".r-title")?.innerText.toLowerCase() || "";
                    const description = row.querySelector(".r-description")?.innerText
                        .toLowerCase() || "";
                    const department = row.querySelector(".r-department")?.innerText
                        .toLowerCase() || "";
                    const branch = row.querySelector(".r-branch")?.innerText.toLowerCase() || "";
                    const designation = row.querySelector(".r-designation")?.innerText
                        .toLowerCase() || "";
                    const manager = row.querySelector(".r-manager")?.innerText.toLowerCase() || "";
                    const start = row.querySelector(".r-start")?.innerText.toLowerCase() || "";
                    const end = row.querySelector(".r-end")?.innerText.toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        description.includes(value) ||
                        department.includes(value) ||
                        branch.includes(value) ||
                        designation.includes(value) ||
                        manager.includes(value) ||
                        start.includes(value) ||
                        end.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("recruitmentNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "recruitmentNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="10" class="text-center text-muted">
                        No matching recruitment found
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
