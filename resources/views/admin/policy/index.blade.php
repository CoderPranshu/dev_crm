@extends('index')
@push('title', get_phrase('Policy'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Policy') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Policy') }}</a></li>
                </ul>
            </div>
            @can('policy-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/policy/add']) }}', '{{ get_phrase('Add new policy') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new policy') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Policy') }}</p>
                    <div class="mb-3">
                        <input type="text" id="policySearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search title / days / document...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Days') }}</th>
                                <th class="">{{ get_phrase('Document') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="policyTableBody">
                            @forelse ($policies as $policy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="p-title">{{ $policy->title }}</td>

                                    <td class="p-days">{{ $policy->date }} Days</td>

                                    <td class="p-document">
                                        @if ($policy->document)
                                            <a href="{{ asset('uploads/document/' . $policy->document) }}" target="_blank">
                                                {{ get_phrase('View Document') }}
                                            </a>
                                        @else
                                            {{ get_phrase('No Document') }}
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @can('policy-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/policy/edit', 'id' => $policy->id]) }}', '{{ get_phrase('Edit Policy') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('policy-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.policy.delete', $policy->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan

                                        @can('policy-show')
                                            <a href="{{ route('admin.policy.show', $policy->id) }}" class="btn btn p-0 px-1"
                                                title="{{ get_phrase('View') }}" data-bs-toggle="tooltip">
                                                <i class="fi-rr-eye"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        {{ get_phrase('No policies found') }}
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
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("policySearch");
            const tableBody = document.getElementById("policyTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".p-title")?.innerText.toLowerCase() || "";
                    const days = row.querySelector(".p-days")?.innerText.toLowerCase() || "";
                    const document = row.querySelector(".p-document")?.innerText.toLowerCase() ||
                    "";

                    const match =
                        title.includes(value) ||
                        days.includes(value) ||
                        document.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("policyNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "policyNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="5" class="text-center text-muted">
                        No matching policies found
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
