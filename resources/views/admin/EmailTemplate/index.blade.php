@extends('index')
@push('title', get_phrase('Email Templates'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Email Templates') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Email Templates') }}</a></li>
                </ul>
            </div>
            @can('email-template-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.emailtemplate.add') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new email template') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Email Template') }}</p>
                    <div class="mb-3">
                        <input type="text" id="emailTemplateSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search title / subject...') }}">
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
                        <tbody id="emailTemplateTableBody">
                            @forelse ($emailtemplates as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="et-title">{{ $cat->title }}</td>
                                    <td class="et-subject">{{ $cat->subject }}</td>
                                    <td class="text-center">
                                        @can('email-template-update')
                                            <a href="{{ route('admin.emailtemplate.edit', $cat->id) }}"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('email-template-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.emailtemplate.delete', $cat->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        {{ get_phrase('No email templates found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("emailTemplateSearch");
            const tableBody = document.getElementById("emailTemplateTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const title = row.querySelector(".et-title")?.innerText.toLowerCase() || "";
                    const subject = row.querySelector(".et-subject")?.innerText.toLowerCase() || "";

                    const match =
                        title.includes(value) ||
                        subject.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("emailTemplateNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "emailTemplateNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="4" class="text-center text-muted">
                        No matching email templates found
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
