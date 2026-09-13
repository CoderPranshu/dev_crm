@extends('index')
@push('title', get_phrase('Sold Products'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Sold Products') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Sold Products') }}</a></li>
                </ul>
            </div>
            @can('sold-product-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/warranty/add']) }}', '{{ get_phrase('Add Sold Products') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add Sold Products') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Sold Products') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Name') }}</th>
                                <th>{{ get_phrase('Vendor') }}</th>
                                <th>{{ get_phrase('Email') }}</th>
                                <th>{{ get_phrase('Phone') }}</th>
                                <th>{{ get_phrase('Product') }}</th>
                                <th>{{ get_phrase('Warranty No') }}</th>
                                <th>{{ get_phrase('Purchase Date') }}</th>
                                <th>{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($warranties as $w)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $w->user->name ?? 'N/A' }}</td>

                                    <td>{{ $w->vendor->name ?? 'N/A' }}</td>

                                    <td>{{ $w->user->email ?? 'N/A' }}</td>

                                    <td>{{ $w->phone_no ?? 'N/A' }}</td>

                                    <td>{{ $w->product->name ?? 'N/A' }}</td>

                                    <td>{{ $w->warranty_no ?? 'N/A' }}</td>

                                    <td>{{ $w->created_at->format('d, M-Y, H:i:s') }}</td>

                                    <td>
                                        <a href="{{ route('admin.warranty.user.products', $w->user_id) }}"
                                            class="export_btn btn-sm">
                                            <i class="fi-rr-eye"></i>&nbsp;
                                        </a>
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
