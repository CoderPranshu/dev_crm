@extends('index')
@push('title', get_phrase('Roles'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Roles') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Roles') }}</a></li>
                </ul>
            </div>
            @can('role-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.role.create') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new role') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between">
                    <p class="column-title mb-2">{{ get_phrase('Roles') }}</p>

                <div class="mb-3">
                    <input type="text" id="roleSearch" class="form-control eForm-control" placeholder="Search role...">
                </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="roleTableBody">
                            @foreach ($roles as $r)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="role-name">
                                        {{ $r->name }}
                                    </td>
                                    <td class="text-center">
                                        @can('role-edit')
                                            <a href="{{ route('admin.role.edit', $r->id) }}" class="btn btn p-0 px-1"
                                                title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('role-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.roles.delete', $r->id) }}')"
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

            const searchInput = document.getElementById("roleSearch");
            const rows = document.querySelectorAll("#roleTableBody tr");

            searchInput.addEventListener("keyup", function() {

                let value = this.value.toLowerCase();

                rows.forEach(row => {
                    let roleName = row.querySelector(".role-name").innerText.toLowerCase();

                    if (roleName.includes(value)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });

            });

        });
    </script>
@endpush
