@extends('index')
@push('title', get_phrase('Entries'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="container-fluid">

    {{-- <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-0">Suspense Entry Management</h3>
            <p class="text-muted">View received, paid, and add suspense entry from one page.</p>
        </div>
    </div> --}}

        <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Suspense Entry Management') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Suspense Entry Management') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    {{-- Summary cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="eForm-label">Total Received</h6>
                    <h3 class="fs-6 text-success">₹ {{ number_format($totalReceived, 2) }}</h3>
                    <small>From recived payment</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="eForm-label">Total Paid</h6>
                    <h3 class="fs-6 text-danger">₹ {{ number_format($totalPaid, 2) }}</h3>
                    <small>From paid</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="eForm-label">Suspense Received</h6>
                    <h3 class="fs-6 text-primary">₹ {{ number_format($totalSuspenseReceived, 2) }}</h3>
                    <small>Manual suspense entries</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="eForm-label">Suspense Paid</h6>
                    <h3 class="fs-6 text-warning">₹ {{ number_format($totalSuspensePaid, 2) }}</h3>
                    <small>Manual suspense entries</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Final summary --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-start border-success border-1 shadow-sm">
                <div class="card-body">
                    <h6 class="eForm-label">Grand Received</h6>
                    <h4 class="fs-6 text-success">₹ {{ number_format($grandReceived, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-start border-danger border-1 shadow-sm">
                <div class="card-body">
                    <h6 class="eForm-label">Grand Paid</h6>
                    <h4 class="fs-6 text-danger">₹ {{ number_format($grandPaid, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-start border-primary border-1 shadow-sm">
                <div class="card-body">
                    <h6 class="eForm-label">Difference</h6>
                    <h4 class="fs-6 {{ $difference >= 0 ? 'text-success' : 'text-danger' }}">
                        ₹ {{ number_format($difference, 2) }}
                    </h4>
                    <small>{{ $difference >= 0 ? 'More Received' : 'More Paid' }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Left side: suspense form --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 eForm-label text-white">Add Suspense Entry</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.suspense.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="eForm-label">Entry Date</label>
                            <input type="date" name="entry_date" class="eForm-control form-control" value="{{ old('entry_date', date('Y-m-d')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="eForm-label">Type</label>
                            <select name="type" class="form-select eForm-control form-control " required>
                                <option value="">Select Type</option>
                                <option value="received" {{ old('type') == 'received' ? 'selected' : '' }}>Received</option>
                                <option value="paid" {{ old('type') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="eForm-label">Amount</label>
                            <input type="number" step="0.01" name="amount" class="eForm-control form-control" value="{{ old('amount') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="eForm-label">Reference No</label>
                            <input type="text" name="reference_no" class="eForm-control form-control" value="{{ old('reference_no') }}">
                        </div>

                        <div class="mb-3">
                            <label class="eForm-label">Description</label>
                            <textarea name="description" class="eForm-control form-control" rows="4">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Suspense Entry</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right side: all tables --}}
        <div class="col-md-8">
            {{-- Received --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 eForm-label text-white">Received Payments</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receivedPayments as $key => $payment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $payment->id }}</td>
                                    <td class="text-success ">₹ {{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No received payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paid --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0 eForm-label text-white">Paid Payments</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paidPayments as $key => $payment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $payment->id }}</td>
                                    <td class="text-danger">₹ {{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No paid payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Suspense entries --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning">
                    <h5 class="mb-0 eForm-label">Suspense Entries</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suspenseEntries as $key => $entry)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($entry->entry_date)->format('d M Y') }}</td>
                                    <td>
                                        @if($entry->type == 'received')
                                            <span class="badge bg-success">Received</span>
                                        @else
                                            <span class="badge bg-danger">Paid</span>
                                        @endif
                                    </td>
                                    <td>{{ $entry->reference_no ?? 'N/A' }}</td>
                                    <td>₹ {{ number_format($entry->amount, 2) }}</td>
                                    <td>{{ $entry->description ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No suspense entries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
