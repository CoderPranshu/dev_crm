@extends('index')
@push('title', get_phrase('Service Types'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Service Types') }}</h4>

                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            {{ get_phrase('Dashboard') }}
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            {{ get_phrase('Service Types') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="export-btn-area">
                {{-- <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/service_type']) }}','{{ get_phrase('Add Service Type') }}')"
                    class="export_btn">

                    <i class="bi bi-plus"></i>

                    <span class="d-none d-sm-inline-block">
                        {{ get_phrase('Add Service Type') }}
                    </span>

                </a> --}}

                <a href="{{ route('admin.service-types.create') }}"
                   class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span>{{ get_phrase('Add Service Type') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="eSection-wrap">

                <div class="d-flex justify-content-between align-items-center">

                    <p class="column-title mb-2">
                        {{ get_phrase('Service Types') }}
                    </p>

                    <div class="mb-3">

                        <input type="text"
                            id="serviceTypeSearch"
                            class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search service type...') }}">

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table eTable">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>
                                    {{ get_phrase('Category') }}
                                </th>

                                <th>
                                    {{ get_phrase('Service Type') }}
                                </th>

                                <th>
                                    {{ get_phrase('Price') }}
                                </th>

                                <th>
                                    {{ get_phrase('Status') }}
                                </th>

                                <th class="text-center">
                                    {{ get_phrase('Action') }}
                                </th>

                            </tr>

                        </thead>

                        <tbody id="serviceTypeTableBody">

                            @forelse ($serviceTypes as $serviceType)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="st-category">
                                        {{ $serviceType->category->name ?? '-' }}
                                    </td>

                                    <td class="st-name">
                                        {{ $serviceType->name }}
                                    </td>

                                    <td class="st-price">
                                        ₹{{ number_format($serviceType->price, 2) }}
                                    </td>

                                    <td class="st-status">

                                        @if ($serviceType->status == 1)

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        {{-- <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/service_type/edit', 'id' => $serviceType->id]) }}','{{ get_phrase('Edit Service Type') }}')"
                                            class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Edit') }}"
                                            data-bs-toggle="tooltip">

                                            <i class="fi-rr-pencil"></i>

                                        </a> --}}

                                         {{-- <a href="{{ route('admin.service-types.edit') }}"
                                            class="btn btn p-0 px-1"  title="{{ get_phrase('Edit') }}">
                                               <i class="fi-rr-pencil"></i>
                                               
                                            </a> --}}

                                        <a href="{{ route('admin.service-types.edit', $serviceType->id) }}"
   class="btn btn p-0 px-1"
   title="{{ get_phrase('Edit') }}"
   data-bs-toggle="tooltip">

    <i class="fi-rr-pencil"></i>

</a>    

                                        <a href="#"
                                            onclick="confirmModal('{{ route('admin.service-types.destroy', $serviceType->id) }}')"
                                            class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Delete') }}"
                                            data-bs-toggle="tooltip">

                                            <i class="fi-rr-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center text-muted">

                                        {{ get_phrase('No service type found') }}

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
<script>

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById(
            "serviceTypeSearch"
        );

    const tableBody =
        document.getElementById(
            "serviceTypeTableBody"
        );

    searchInput.addEventListener(
        "keyup",
        function () {

            let value =
                this.value
                .toLowerCase();

            let rows =
                tableBody
                .querySelectorAll("tr");

            let visibleCount = 0;

            rows.forEach(row => {

                if (
                    row.querySelector(
                        "td[colspan]"
                    )
                ) {
                    return;
                }

                let category =
                    row.querySelector(
                        ".st-category"
                    )?.innerText
                    .toLowerCase() || '';

                let name =
                    row.querySelector(
                        ".st-name"
                    )?.innerText
                    .toLowerCase() || '';

                let price =
                    row.querySelector(
                        ".st-price"
                    )?.innerText
                    .toLowerCase() || '';

                let status =
                    row.querySelector(
                        ".st-status"
                    )?.innerText
                    .toLowerCase() || '';

                let match =
                    category.includes(value) ||
                    name.includes(value) ||
                    price.includes(value) ||
                    status.includes(value);

                if (match) {

                    row.style.display = '';

                    visibleCount++;

                } else {

                    row.style.display = 'none';

                }

            });

        }
    );

});

</script>
@endpush