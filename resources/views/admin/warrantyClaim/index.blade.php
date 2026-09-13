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
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Warranty') }}</a></li>
                </ul>
            </div>
            @can('warranty-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/warrantyClaim/add']) }}', '{{ get_phrase('Claim Warranty') }}')"
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
                                <th>{{ get_phrase('Customer') }}</th>
                                {{-- <th>{{ get_phrase('Vendor') }}</th> --}}
                                {{-- <th>{{ get_phrase('Email') }}</th> --}}
                                <th>{{ get_phrase('Product') }}</th>
                                <th>{{ get_phrase('Warranty No') }}</th>
                                <th>{{ get_phrase('Description') }}</th>
                                <th>{{ get_phrase('File') }}</th>
                                <th>{{ get_phrase('Service Status') }}</th>
                                <th>{{ get_phrase('Status') }}</th>
                                <th>{{ get_phrase('Assign Vendor') }}</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($claims as $claim)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $claim->user->name ?? 'N/A' }}</td>

                                    {{-- <td>{{ $claim->vendor->name ?? 'N/A' }}</td> --}}

                                    {{-- <td>{{ $claim->user->email ?? 'N/A' }}</td> --}}

                                    <td>{{ $claim->product->name ?? 'N/A' }}</td>

                                    <td>{{ $claim->warranty_no }}</td>

                                    <td>{{ $claim->description }}</td>

                                    <td>
                                        @if ($claim->file)
                                            <a href="{{ asset($claim->file) }}" target="_blank" class="badge bg-primary">
                                                View
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @php
                                        $user = auth()->user();

                                       $role =  $user->load('roles');

                                    //    dd($role);
                                         // Load roles relationship to avoid N+1 query issue
                                    @endphp
                                     @if ($user->hasRole('Admin') || ($user->hasRole('Sales') || $claim->assign_to == $user->id))

                                    <td>
                                        <form action="{{ route('admin.service.status', $claim->id) }}" method="POST">
                                            @csrf
                                            <select name="service_status"
                                                class="form-control eForm-control form-select servicestatusSelect"
                                                style="width: 125px; padding: 5px 10px;">
                                                <option value="">Service status</option>
                                                <option value="repair"
                                                    {{ $claim->service_status == 'repair' ? 'selected' : '' }}>Repair
                                                </option>
                                                <option value="replaced"
                                                    {{ $claim->service_status == 'replaced' ? 'selected' : '' }}>Replaced
                                                </option>
                                            </select>
                                        </form>
                                    </td>


                                        <td>

                                            <form action="{{ route('admin.warranty.claim.status.update', $claim->id) }}"
                                                method="POST">
                                                @csrf

                                                <select name="status"
                                                    class="form-select eForm-control form-control form-select-sm statusSelect"
                                                    style="width:108px; padding: 5px 10px">

                                                    <option value="pending"
                                                        {{ $claim->status == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>

                                                    <option value="approved"
                                                        {{ $claim->status == 'approved' ? 'selected' : '' }}>
                                                        Approved
                                                    </option>

                                                    <option value="rejected"
                                                        {{ $claim->status == 'rejected' ? 'selected' : '' }}>
                                                        Rejected
                                                    </option>

                                                </select>

                                            </form>

                                        </td>
                                    @else
                                        <td>

                                            @if ($claim->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($claim->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($claim->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif

                                        </td>
                                    @endif
                                    <td>
                                        @if (auth()->user()->hasRole('Admin') || ($user->hasRole('Sales')))
                                            <form action="{{ route('admin.warranty.claim.assign.vendor', $claim->id) }}"
                                                method="POST">
                                                @csrf

                                                <select name="assign_to"
                                                    class="form-select form-control eForm-control form-select-sm"
                                                    onchange="this.form.submit()" style="width: 135px; padding:5px 10px;">
                                                    <option value="">Select Vendor</option>

                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            {{ $claim->assign_to == $vendor->id ? 'selected' : '' }}>
                                                            {{ $vendor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @else
                                            {{ $claim->assignedVendor->name ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.warranty.claim.show', $claim->id) }}"
                                            class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        {{ get_phrase('No warranty claims found') }}
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
        document.querySelectorAll('.statusSelect').forEach(function(select) {
            let initialValue = select.value;

            select.addEventListener('change', function() {
                if (this.value !== initialValue) {
                    this.form.submit();
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll('.servicestatusSelect').forEach(function(select) {
            let initialValue = select.value;

            select.addEventListener('change', function() {
                if (this.value !== initialValue) {
                    this.form.submit();
                }
            });
        });
    </script>
@endpush
