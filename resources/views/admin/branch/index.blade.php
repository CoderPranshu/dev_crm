@extends('index')
@push('title', get_phrase('Branch'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Branches') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Branch') }}</a></li>
                </ul>
            </div>
            @can('branch-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/branch/add']) }}', '{{ get_phrase('Add new branch') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new branch') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-content-center">
                    <p class="column-title mb-2">{{ get_phrase('Branches') }}</p>
                    <div class="mb-3">
                        <input type="text" id="branchSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search branch / description / serial...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Branch name') }}</th>
                                <th class="">{{ get_phrase('Description') }}</th>
                                <th class="">{{ get_phrase('Machine Serial Number') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="branchTableBody">
                            @foreach (App\Models\Branch::orderBy('title')->get() as $key => $branch)
                                <tr>
                                    <td>{{ ++$key }}</td>

                                    <td class="b-title">
                                        {{ $branch->title }}
                                    </td>

                                    <td class="b-description">
                                        {{ $branch->description }}
                                    </td>

                                    <td class="b-serial">
                                        {{ $branch->machine_serial_no }}
                                    </td>

                                    <td class="text-center">
                                        @can('branch-edit')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/branch/edit', 'id' => $branch->id]) }}', '{{ get_phrase('Edit branch') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('branch-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.branch.delete', $branch->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
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
            const searchInput = document.getElementById("branchSearch");
            const tableBody = document.getElementById("branchTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const title = row.querySelector(".b-title")?.innerText.toLowerCase() || "";
                    const description = row.querySelector(".b-description")?.innerText
                        .toLowerCase() || "";
                    const serial = row.querySelector(".b-serial")?.innerText.toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        description.includes(value) ||
                        serial.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("branchNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "branchNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="5" class="text-center text-muted">
                        No matching branches found
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
