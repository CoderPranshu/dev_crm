@extends('index')
@push('title', get_phrase('Vendor return request'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Vendor Return Request') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Vendor Return Request') }}</a></li>
                </ul>
            </div>
            @can('warranty-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendorreturn/add']) }}', '{{ get_phrase('Claim Warranty') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new request') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Product Return List Requested By Vendor') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Vendor') }}</th>
                                <th>{{ get_phrase('Product') }}</th>
                                <th>{{ get_phrase('Qty') }}</th>
                                <th>{{ get_phrase('Reason') }}</th>
                                <th>{{ get_phrase('Status') }}</th>
                                <th>{{ get_phrase('Pickup Date') }}</th>
                                <th>{{ get_phrase('Created By') }}</th>
                                <th>{{ get_phrase('Note') }}</th>
                                <th>{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($returnrequests as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->vendor->name ?? 'N/A' }}</td>
                                    <td>{{ $r->product->name }}</td>
                                    <td>{{ $r->quantity }}</td>
                                    <td>{{ $r->reason }}</td>
                                    <td>
                                        @if ($r->status == 'pending')
                                            <span class="badge bg-warning">{{ $r->status }}</span>
                                        @elseif ($r->status == 'approved')
                                            <span class="badge bg-info">{{ $r->status }}</span>
                                        @elseif ($r->status == 'collected')
                                            <span class="badge bg-primary">{{ $r->status }}</span>
                                        @elseif ($r->status == 'replaced')
                                            <span class="badge bg-success">{{ $r->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $r->pickup_date ?? 'N/A' }}</td>
                                    <td>{{ $r->user->name }}</td>
                                    <td>
                                        @php
                                            $fullText = $r->note ?? 'N/A';
                                            $limit = 20; // characters limit
                                        @endphp

                                        @if (strlen($fullText) > $limit)
                                            <span class="short-text">
                                                {{ substr($fullText, 0, $limit) }}...
                                            </span>

                                            <span class="full-text d-none">
                                                {{ $fullText }}
                                            </span>

                                            <a href="javascript:void(0);" class="toggle-text text-primary">Read More</a>
                                        @else
                                            {{ $fullText }}
                                        @endif
                                    </td>
                                    <td>
                                        @can('vendor-return-edit')
                                            <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/vendorreturn/status', 'id' => $r->id]) }}', '{{ get_phrase('Status update') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Status Update') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-refresh"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        No return request found
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
        $(document).on('click', '.toggle-text', function() {
            let parent = $(this).closest('td');

            parent.find('.short-text').toggleClass('d-none');
            parent.find('.full-text').toggleClass('d-none');

            if ($(this).text() === 'Read More') {
                $(this).text('Show Less');
            } else {
                $(this).text('Read More');
            }
        });
    </script>
@endpush
