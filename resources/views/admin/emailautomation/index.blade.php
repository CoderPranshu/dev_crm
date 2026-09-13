@extends('index')
@push('title', get_phrase('Email Automation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Email Automation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Email Automation') }}</a></li>
                </ul>
            </div>
            @can('email-automation-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.emailautomation.add') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new email automation') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Email Automation') }}</p>
                    <div class="mb-3">
                        <input type="text" id="emailAutomationSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search subject or status...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Subject') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="emailAutomationTableBody">
                            @foreach ($emails as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="ea-subject">{{ $cat->subject }}</td>
                                    <td class="ea-status">{{ $cat->status }}</td>
                                    <td class="text-center">
                                        @can('email-automation-update')
                                            <a href="{{ route('admin.emailautomation.edit', $cat->id) }}"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('email-automation-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.emailautomation.delete', $cat->id) }}')"
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
            const searchInput = document.getElementById("emailAutomationSearch");
            const tableBody = document.getElementById("emailAutomationTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const subject = row.querySelector(".ea-subject")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".ea-status")?.innerText.toLowerCase() || "";

                    const match = subject.includes(value) || status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("emailAutomationNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "emailAutomationNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="4" class="text-center text-muted">
                        {{ get_phrase('No matching records found') }}
                    </td>
                `;
                        tableBody.appendChild(noResultRow);
                    }
                } else {
                    if (noResultRow) noResultRow.remove();
                }
            });
        });
    </script>
@endpush
