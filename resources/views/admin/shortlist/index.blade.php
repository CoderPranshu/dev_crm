@extends('index')
@push('title', get_phrase('Short List'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Short List') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Short List') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                {{-- <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/shortlist/add']) }}', '{{ get_phrase('Add new short list') }}')" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new short list') }}</span>
                </a> --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.shortlist.export') }}" class="export_btn_success mb-3">
                        Export CSV
                    </a>
                    <div class="mb-3">
                        <input type="text" id="shortlistSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search name / email / phone / source / country / recruitment...') }}">
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
                                <th>{{ get_phrase('Country') }}</th>
                                <th>{{ get_phrase('State') }}</th>
                                <th>{{ get_phrase('DOB') }}</th>
                                <th>{{ get_phrase('Resume') }}</th>
                                <th>{{ get_phrase('Recruitment') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="shortlistTableBody">
                            @forelse ($shortlists as $candi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="sl-name">{{ $candi->name }}</td>
                                    <td class="sl-email">{{ $candi->email }}</td>
                                    <td class="sl-phone">{{ $candi->phone }}</td>
                                    <td class="sl-address">{{ $candi->address }}</td>
                                    <td class="sl-source">{{ $candi->source }}</td>
                                    <td class="sl-country">{{ $candi->country }}</td>
                                    <td class="sl-state">{{ $candi->state }}</td>
                                    <td class="sl-dob">{{ $candi->dob }}</td>
                                    <td>
                                        <a href="{{ asset('uploads/resume/' . $candi->resume) }}" target="_blank"
                                            class="text-info">
                                            Download Resume
                                        </a>
                                    </td>
                                    <td class="sl-recruitment">{{ $candi->recruitment->title ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/candidate/edit', 'id' => $candi->id]) }}', '{{ get_phrase('Edit Candidates') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/shortlist/stage', 'id' => $candi->id]) }}', '{{ get_phrase('Onboarding Stage') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Stage') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-refresh"></i>
                                        </a>

                                        <a href="#"
                                            onclick="confirmModal('{{ route('admin.candidate.delete', $candi->id) }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center text-muted">
                                        {{ get_phrase('No shortlisted candidates found') }}
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
            const searchInput = document.getElementById("shortlistSearch");
            const tableBody = document.getElementById("shortlistTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const name = row.querySelector(".sl-name")?.innerText.toLowerCase() || "";
                    const email = row.querySelector(".sl-email")?.innerText.toLowerCase() || "";
                    const phone = row.querySelector(".sl-phone")?.innerText.toLowerCase() || "";
                    const address = row.querySelector(".sl-address")?.innerText.toLowerCase() || "";
                    const source = row.querySelector(".sl-source")?.innerText.toLowerCase() || "";
                    const country = row.querySelector(".sl-country")?.innerText.toLowerCase() || "";
                    const state = row.querySelector(".sl-state")?.innerText.toLowerCase() || "";
                    const dob = row.querySelector(".sl-dob")?.innerText.toLowerCase() || "";
                    const recruitment = row.querySelector(".sl-recruitment")?.innerText
                        .toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        email.includes(value) ||
                        phone.includes(value) ||
                        address.includes(value) ||
                        source.includes(value) ||
                        country.includes(value) ||
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

                let noResultRow = document.getElementById("shortlistNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "shortlistNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="12" class="text-center text-muted">
                        No matching shortlisted candidates found
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
