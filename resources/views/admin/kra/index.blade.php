@extends('index')
@push('title', get_phrase('Kra Index'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Kra Index') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Kra Index') }}</a></li>
                </ul>
            </div>
            @can('kra-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/kra/add']) }}', '{{ get_phrase('Add new kra') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new KRA') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">

            <div class="card kra-card">

                {{-- ===================== Card Header / Tabs ===================== --}}
                <div class="kra-card-header">
                    <ul class="nav kra-tabs" role="tablist">
                        @foreach ($departments as $department)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($loop->first) active @endif"
                                    data-bs-toggle="tab" data-bs-target="#department-{{ $department->id }}" type="button"
                                    role="tab">
                                    {{ $department->title }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- ===================== Card Body / Content ===================== --}}
                <div class="kra-card-body">
                    <div class="tab-content">

                        @foreach ($departments as $department)
                            <div class="tab-pane fade @if ($loop->first) show active @endif"
                                id="department-{{ $department->id }}" role="tabpanel">

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="column-title mb-3">
                                        {{ get_phrase('Kra Index') }} – {{ $department->title }}
                                    </p>

                                    <div class="mb-3">
                                        <input type="text" id="kraSearch" class="form-control eForm-control"
                                            placeholder="{{ get_phrase('Search KRA...') }}">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table eTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ get_phrase('Title') }}</th>
                                                <th>{{ get_phrase('Description') }}</th>
                                                <th>{{ get_phrase('Branch') }}</th>
                                                <th>{{ get_phrase('Department') }}</th>
                                                <th class="text-center">{{ get_phrase('Action') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody id="kraTableBody">
                                            @php
                                                $departmentKras = $kras->where('department_id', $department->id);
                                            @endphp

                                            @forelse ($departmentKras as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="kra-title">{{ $k->title }}</td>
                                                    <td class="kra-description">{{ $k->description }}</td>
                                                    <td class="kra-branch">{{ $k->branch->title ?? 'N/A' }}</td>
                                                    <td class="kra-department">{{ $k->department->title }}</td>
                                                    <td class="text-center">
                                                        @can('kra-edit')
                                                            <a href="#"
                                                                onclick="showRightModal(
                       '{{ route('right_modal', ['view_path' => 'admin/kra/edit', 'id' => $k->id]) }}',
                       '{{ get_phrase('Edit KRA') }}'
                   )"
                                                                class="btn p-0 px-1" data-bs-toggle="tooltip"
                                                                title="{{ get_phrase('Edit') }}">
                                                                <i class="fi-rr-pencil"></i>
                                                            </a>
                                                        @endcan

                                                        @can('kra-delete')
                                                            <a href="#"
                                                                onclick="confirmModal('{{ route('admin.kra.delete', $k->id) }}')"
                                                                class="btn p-0 px-1" data-bs-toggle="tooltip"
                                                                title="{{ get_phrase('Delete') }}">
                                                                <i class="fi-rr-trash"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        {{ get_phrase('No KRA found for this department') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('css')
    <style>
        .kra-tabs {
            border-bottom: 1px solid #e5e7eb;
        }

        .kra-tabs .nav-link {
            border: none !important;
            background: transparent;
            color: #6b7280;
            font-weight: 500;
            padding: 12px 18px;
            position: relative;
        }

        .kra-tabs .nav-link.active {
            color: #0d6efd;
            font-weight: 600;
        }

        .kra-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 4px 4px 0 0;
        }

        .kra-card {
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .kra-card-header {
            padding: 18px 24px 0;
        }

        .kra-card-body {
            padding: 24px;
        }
    </style>
@endpush


@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("kraSearch");
            const tableBody = document.getElementById("kraTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    // skip empty row
                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".kra-title")?.innerText.toLowerCase() || "";
                    const description = row.querySelector(".kra-description")?.innerText
                        .toLowerCase() || "";
                    const branch = row.querySelector(".kra-branch")?.innerText.toLowerCase() || "";
                    const department = row.querySelector(".kra-department")?.innerText
                        .toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        description.includes(value) ||
                        branch.includes(value) ||
                        department.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("kraNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "kraNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted">
                        {{ get_phrase('No matching KRA found') }}
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
