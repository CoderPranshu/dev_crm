@extends('index')
@push('title', get_phrase('Replaced Inventory History'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Replaced Inventory History') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a
                            href="{{ route('admin.company.products', ['vendor_id' => $id]) }}">{{ get_phrase('Vendor Inventory') }}</a>
                    </li>
                    <li><a href="#">{{ get_phrase('Replaced Inventory History') }}</a></li>
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
                                <th class="">#</th>
                                <th>{{ get_phrase('Vendor') }}</th>
                                <th>{{ get_phrase('Product') }}</th>
                                <th>{{ get_phrase('Qty') }}</th>
                                <th>{{ get_phrase('Reason') }}</th>
                                <th>{{ get_phrase('Status') }}</th>
                                <th>{{ get_phrase('Pickup Date') }}</th>
                                <th>{{ get_phrase('Created By') }}</th>
                                <th>{{ get_phrase('Note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($return as $r)
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
                                </tr>
                            @empty
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
