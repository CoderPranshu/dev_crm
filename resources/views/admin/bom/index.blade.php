@extends('index')
@push('title', get_phrase('BOM'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('BOM') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('BOM') }}</a></li>
                </ul>
            </div>
            @can('bom-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.bom.create') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new BOM') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('BOM') }}</p>
                    <div class="mb-3">
                        <input type="text" id="bomSearch" class="form-control eForm-control"
                            placeholder="Search product / version / notes...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th>Bom No</th>
                                <th class="">{{ get_phrase('Product') }}</th>
                                <th class="">{{ get_phrase('Version') }}</th>
                                <th class="">{{ get_phrase('Notes') }}</th>
                                <th class="">{{ get_phrase('Branch') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="bomTableBody">
                            @foreach ($boms as $bom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="bom-no">{{ $bom->bom_no }}</td>
                                    <td class="bom-product">{{ $bom->product->name }}</td>
                                    <td class="bom-version">{{ $bom->version }}</td>
                                    <td class="bom-notes">{{ $bom->notes }}</td>
                                    <td class="bom-branch">{{ $bom->branch->title }}</td>
                                    <td class="text-center">
                                        @can('bom-update')
                                            <a href="{{ route('admin.bom.edit', $bom->id) }}" class="btn btn p-0 px-1"
                                                title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('bom-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.bom.delete', $bom->id) }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan

                                        @can('bom-show')
                                            <a href="{{ route('admin.bom.show', $bom->id) }}" class="btn btn p-0 px-1"
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
            const searchInput = document.getElementById("bomSearch");
            const tableBody = document.getElementById("bomTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const product = row.querySelector(".bom-product")?.innerText.toLowerCase() ||
                        "";
                    const version = row.querySelector(".bom-version")?.innerText.toLowerCase() ||
                        "";
                    const notes = row.querySelector(".bom-notes")?.innerText.toLowerCase() || "";

                    const match =
                        product.includes(value) ||
                        version.includes(value) ||
                        notes.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("bomNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "bomNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="5" class="text-center text-muted">
                        No matching BOM found
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
