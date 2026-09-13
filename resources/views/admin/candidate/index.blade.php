@extends('index')
@push('title', get_phrase('Candidate'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Candidate') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Candidate') }}</a></li>
                </ul>
            </div>
            @can('candidate-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/candidate/add']) }}', '{{ get_phrase('Add new candidate') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new candidate') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-3 d-flex gap-2">
                        <a href="{{ route('admin.candidate.export') }}" class="export_btn_success">
                            Export CSV
                        </a>

                           <button type="button" class="export_btn_primary" data-bs-toggle="modal"
                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/candidate/import']) }}', '{{ get_phrase('Import CSV Sheet') }}')">
                            Import CSV
                        </button>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="candidateSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search name / email / phone / state / recruitment...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="">{{ get_phrase('Email') }}</th>
                                <th>{{ get_phrase('Phone') }}</th>
                                <th>{{ get_phrase('Address') }}</th>
                                <th>{{ get_phrase('Source') }}</th>
                                <th>{{ get_phrase('State') }}</th>
                                <th>{{ get_phrase('DOB') }}</th>
                                <th>{{ get_phrase('Resume') }}</th>
                                <th>{{ get_phrase('Recruitment') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="candidateTableBody">
                            @foreach ($candidates as $candi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="c-name">{{ $candi->name }}</td>
                                    <td class="c-email">{{ $candi->email }}</td>
                                    <td class="c-phone">{{ $candi->phone }}</td>
                                    <td class="c-address">{{ $candi->address }}</td>
                                    <td class="c-source">{{ $candi->source }}</td>
                                    <td class="c-state">{{ $candi->state }}</td>
                                    <td class="c-dob">{{ $candi->dob }}</td>
                                    <td>
                                        <a href="{{ asset('uploads/resume/' . $candi->resume) }}" target="_blank"
                                            class="text-info">Download Resume</a>
                                    </td>
                                    <td class="c-recruitment">{{ $candi->recruitment->title ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @can('candidate-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/candidate/edit', 'id' => $candi->id]) }}', '{{ get_phrase('Edit Candidates') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('candidate-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.candidate.delete', $candi->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan

                                        @can('candidate-show')
                                            <a href="{{ route('admin.candidate.show', $candi->id) }}" class="btn btn p-0 px-1"
                                                title="{{ get_phrase('View') }}" data-bs-toggle="tooltip">
                                                <i class="fi-rr-eye"></i>
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
@stop

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("candidateSearch");
            const tableBody = document.getElementById("candidateTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const name = row.querySelector(".c-name")?.innerText.toLowerCase() || "";
                    const email = row.querySelector(".c-email")?.innerText.toLowerCase() || "";
                    const phone = row.querySelector(".c-phone")?.innerText.toLowerCase() || "";
                    const address = row.querySelector(".c-address")?.innerText.toLowerCase() || "";
                    const source = row.querySelector(".c-source")?.innerText.toLowerCase() || "";
                    const state = row.querySelector(".c-state")?.innerText.toLowerCase() || "";
                    const dob = row.querySelector(".c-dob")?.innerText.toLowerCase() || "";
                    const recruitment = row.querySelector(".c-recruitment")?.innerText
                        .toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        email.includes(value) ||
                        phone.includes(value) ||
                        address.includes(value) ||
                        source.includes(value) ||
                        state.includes(value) ||
                        dob.includes(value) ||
                        recruitment.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("candidateNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "candidateNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="11" class="text-center text-muted">
                        No matching candidates found
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
