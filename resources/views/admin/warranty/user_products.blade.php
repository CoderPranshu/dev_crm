@extends('index')
@push('title', get_phrase('Warranty'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Warranty') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.warranty.index') }}">{{ get_phrase('Sold Products') }}</a></li>
                    <li><a href="#">{{ get_phrase('Warranty') }}</a></li>
                </ul>
            </div>
            @can('tax-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/warranty/add']) }}', '{{ get_phrase('Add warranty tax') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new warranty') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Warranty') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Vendor</th>
                                <th>Warranty No</th>
                                <th>Phone</th>
                                <th>Purchase Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($warranties as $w)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $w->product->name ?? 'N/A' }}</td>

                                    <td>{{ $w->vendor->name ?? 'N/A' }}</td>

                                    <td>{{ $w->warranty_no }}</td>

                                    <td>{{ $w->phone_no }}</td>

                                    <td>{{ $w->created_at->format('d M Y') }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
