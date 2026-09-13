@extends('index')
@push('title', get_phrase('Warehouse'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Warehouse') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Warehouse') }}</a></li>
                </ul>
            </div>
            @can('warehouse-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/warehouses/add']) }}', '{{ get_phrase('Add new Warehouse') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Warehouse') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Warehouse') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="">{{ get_phrase('Code') }}</th>
                                <th class="">{{ get_phrase('Address') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouses as $cat)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $cat->name }}
                                    </td>
                                    <td>
                                        {{ $cat->code }}
                                    </td>
                                    <td>
                                        {{ $cat->address }}
                                    </td>
                                    <td class="text-center">
                                        @can('warehouse-update')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/warehouses/edit', 'id' => $cat->id]) }}', '{{ get_phrase('Edit vendor') }}')"
                                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-pencil"></i>
                                            </a>
                                        @endcan

                                        @can('warehouse-delete')
                                            <a href="#"
                                                onclick="confirmModal('{{ route('admin.warehouse.delete', $cat->id) }}')"
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
