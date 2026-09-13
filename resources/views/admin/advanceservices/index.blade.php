@extends('index')
@push('title', get_phrase('Advance Services'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Advance Services') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Advance Services') }}</a></li>
                </ul>
            </div>
            @can('organization-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/advanceservices/add']) }}', '{{ get_phrase('Add new request') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Request Advance Service') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Advance Service') }}</p>

                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Vendor name') }}</th>
                                <th>{{ get_phrase('Components') }}</th>
                                <th>{{ get_phrase('Status') }}</th>
                                <th>{{ get_phrase('Description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->vendor->name }}</td>
                                    <td>
                                        @foreach ($s->products as $p)
                                            {{ $p->name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($s->status == 'pending')
                                            <span class="badge bg-warning">{{ $s->status }}</span>

                                            @if (auth()->user()->hasRole('Admin'))
                                                <button class="btn btn-sm btn-success ms-2 approve-btn"
                                                    data-id="{{ $s->id }}">
                                                    Approve
                                                </button>
                                            @endif
                                        @else
                                            <span class="badge bg-success">{{ $s->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $s->description }}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            No request found.
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
