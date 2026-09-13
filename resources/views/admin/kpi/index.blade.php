@extends('index')
@push('title', get_phrase('Kpi Index'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Kpi Index') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Kpi Index') }}</a></li>
                </ul>
            </div>
            @can('kpi-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/kpi/add']) }}', '{{ get_phrase('Add new Kpi') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Kpi') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card Kpi-card">

                {{-- ===================== Card Header / Tabs ===================== --}}
                <div class="Kpi-card-header">
                    <ul class="nav Kpi-tabs" role="tablist">
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
                <div class="Kpi-card-body">
                    <div class="tab-content">

                        @foreach ($departments as $department)
                            <div class="tab-pane fade @if ($loop->first) show active @endif"
                                id="department-{{ $department->id }}" role="tabpanel">

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="column-title mb-3">
                                        {{ get_phrase('Kpi Index') }} - {{ $department->title }}
                                    </p>

                                    <div class="mb-3">
                                        <input type="text" id="kpiSearch" class="eForm-control form-control"
                                            placeholder="{{ get_phrase('Search KPI...') }}">
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

                                        <tbody id="kpiTableBody">
                                            @php
                                                $departmentkpis = $kpis->where('department_id', $department->id);
                                            @endphp

                                            @forelse ($departmentkpis as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="kpi-title">{{ $k->title }}</td>
                                                    <td class="kpi-description">{{ $k->description }}</td>
                                                    <td class="kpi-branch">{{ $k->branch->title ?? 'N/A' }}</td>
                                                    <td class="kpi-department">{{ $k->department->title }}</td>
                                                    <td class="text-center">
                                                        @can('kpi-edit')
                                                            <a href="#"
                                                                onclick="showRightModal(
                       '{{ route('right_modal', ['view_path' => 'admin/kpi/edit', 'id' => $k->id]) }}',
                       '{{ get_phrase('Edit Kpi') }}'
                   )"
                                                                class="btn p-0 px-1" data-bs-toggle="tooltip"
                                                                title="{{ get_phrase('Edit') }}">
                                                                <i class="fi-rr-pencil"></i>
                                                            </a>
                                                        @endcan

                                                        @can('kpi-delete')
                                                            <a href="#"
                                                                onclick="confirmModal('{{ route('admin.kpi.delete', $k->id) }}')"
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
                                                        {{ get_phrase('No Kpi found for this department') }}
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
        .Kpi-tabs {
            border-bottom: 1px solid #e5e7eb;
        }

        .Kpi-tabs .nav-link {
            border: none !important;
            background: transparent;
            color: #6b7280;
            font-weight: 500;
            padding: 12px 18px;
            position: relative;
        }

        .Kpi-tabs .nav-link.active {
            color: #0d6efd;
            font-weight: 600;
        }

        .Kpi-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 4px 4px 0 0;
        }

        .Kpi-card {
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .Kpi-card-header {
            padding: 18px 24px 0;
        }

        .Kpi-card-body {
            padding: 24px;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("kpiSearch");
            const tableBody = document.getElementById("kpiTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".kpi-title")?.innerText.toLowerCase() || "";
                    const description = row.querySelector(".kpi-description")?.innerText
                        .toLowerCase() || "";
                    const branch = row.querySelector(".kpi-branch")?.innerText.toLowerCase() || "";
                    const department = row.querySelector(".kpi-department")?.innerText
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

                let noResultRow = document.getElementById("kpiNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "kpiNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted">
                        {{ get_phrase('No matching KPI found') }}
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
