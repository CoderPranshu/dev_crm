@extends('index')

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="">
                <h4>Warranty Full History</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2 pb-3">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.WarrantyClaim.index') }}">{{ get_phrase('Warranty Claim') }}</a></li>
                    <li><a href="#">{{ get_phrase('Warranty') }}</a></li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0">
                            <div class="card-body">
                                <span>Warranty No: {{ $currentClaim->warranty_no }}</span> <br>
                                <span>Vendor: {{ $currentClaim->vendor->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="eSection-wrap mb-4">
        <p class="column-title mb-3">All Claims for this Warranty</p>

        <div class="table-responsive">
            <table class="table eTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Claim ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>File</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($claims as $claim)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $claim->id }}</td>
                            <td>{{ $claim->user->name ?? 'N/A' }}</td>
                            <td>{{ $claim->product->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($claim->status) }}</td>
                            <td>{{ $claim->description }}</td>
                            <td>
                                @if ($claim->file)
                                    <a href="{{ asset($claim->file) }}" target="_blank" class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $claim->created_at->format('d M Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No claims found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="eSection-wrap">
        <p class="column-title mb-3">Complete Warranty Timeline</p>

        <div class="table-responsive">
            <table class="table eTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Claim ID</th>
                        <th>Action</th>
                        <th>Old Status</th>
                        <th>New Status</th>
                        <th>Note</th>
                        <th>Changed By</th>
                        <th>Assigned To</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allHistories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->date ? \Carbon\Carbon::parse($history->date)->format('d M Y h:i A') : 'N/A' }}
                            </td>
                            <td>{{ $history->claim_id }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $history->action)) }}</td>
                            <td>{{ $history->old_status ?? 'N/A' }}</td>
                            <td>{{ $history->new_status ?? 'N/A' }}</td>
                            <td>{{ $history->note ?? 'N/A' }}</td>
                            <td>{{ $history->changedBy->name ?? 'System' }}</td>
                            <td>{{ $history->assignedTo->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No history found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
