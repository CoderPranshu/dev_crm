@extends('index')
@push('title', get_phrase('Support Ticket'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Support Ticket') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Support Ticket') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/supportTicket/add']) }}', '{{ get_phrase('Add new support ticket') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new support ticket') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Support Ticket') }}</p>
                    <div class="mb-3">
                        <input type="text" id="supportSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search support ticket...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Subject') }}</th>
                                <th class="">{{ get_phrase('Raised By') }}</th>
                                <th class="">{{ get_phrase('Priority') }}</th>
                                <th class="">{{ get_phrase('Status') }}</th>
                                <th class="">{{ get_phrase('Department') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="supportTableBody">
                            @foreach ($supports as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="support-subject">{{ $s->subject }}</td>
                                    <td class="support-raised">{{ $s->raised->name }}</td>
                                    <td class="support-priority">{{ $s->priority }}</td>
                                    <td class="support-status">{{ $s->status }}</td>
                                    <td class="support-department">{{ $s->department->name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.support.show', $s->id) }}" class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Show') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-eye"></i>
                                        </a>
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
            const searchInput = document.getElementById("supportSearch");
            const tableBody = document.getElementById("supportTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const subject = row.querySelector(".support-subject")?.innerText
                        .toLowerCase() || "";
                    const raised = row.querySelector(".support-raised")?.innerText.toLowerCase() ||
                        "";
                    const priority = row.querySelector(".support-priority")?.innerText
                        .toLowerCase() || "";
                    const status = row.querySelector(".support-status")?.innerText.toLowerCase() ||
                        "";
                    const department = row.querySelector(".support-department")?.innerText
                        .toLowerCase() || "";

                    const match =
                        subject.includes(value) ||
                        raised.includes(value) ||
                        priority.includes(value) ||
                        status.includes(value) ||
                        department.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("supportNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "supportNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="7" class="text-center text-muted">
                        {{ get_phrase('No matching support found') }}
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
