@extends('index')
@push('title', get_phrase('Holidays'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Holidays') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Holidays') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/holidays/add']) }}', '{{ get_phrase('Add new holiday') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new holiday') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Holidays') }}</p>
                    <div class="mb-3">
                        <input type="text" id="holidaySearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search title / date / description...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Days') }}</th>
                                <th class="">{{ get_phrase('Description') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="holidayTableBody">
                            @forelse ($holidays as $holiday)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="h-title">{{ $holiday->title }}</td>
                                    <td class="h-date">{{ $holiday->date }} Days</td>
                                    <td class="h-desc">{{ $holiday->description }}</td>
                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/holidays/edit', 'id' => $holiday->id]) }}', '{{ get_phrase('Edit Holiday') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#"
                                            onclick="confirmModal('{{ route('admin.holidays.delete', $holiday->id) }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        {{ get_phrase('No holidays found') }}
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

@push('css')
    <style>
        td p {
            font-size: 12px !important;
            font-weight: 400 !important;
        }
    </style>
@endpush


@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("holidaySearch");
            const tableBody = document.getElementById("holidayTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".h-title")?.innerText.toLowerCase() || "";
                    const date = row.querySelector(".h-date")?.innerText.toLowerCase() || "";
                    const desc = row.querySelector(".h-desc")?.innerText.toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        date.includes(value) ||
                        desc.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("holidayNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "holidayNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="5" class="text-center text-muted">
                        No matching holidays found
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
