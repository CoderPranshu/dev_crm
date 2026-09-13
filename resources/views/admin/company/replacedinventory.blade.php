@extends('index')
@push('title', get_phrase('Replaced Inventory'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Replaced Inventory') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.company.products', ['vendor_id' => $vendorid]) }}">{{ get_phrase('Vendor Inventory') }}</a></li>
                    <li><a href="#">{{ get_phrase('Replaced Inventory') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Inventory Replace by vendor') }}</p>
                    {{-- <div class="mb-3">
                        <input type="text" id="companySearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search company / contact / phone / email / GST / rating...') }}">
                    </div> --}}
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Replace Date</th>
                                <th>Replaced Customer</th>
                            </tr>
                        </thead>
                        <tbody id="companyTableBody">
                            @forelse ($repaired as $repair)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $repair->product->name }}</td>
                                    <td>{{ $repair->updated_at }}</td>
                                    <td>{{ $repair->user->name }}, <small>Qty: {{ get_phrase('1 Charger') }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No replacement found
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
