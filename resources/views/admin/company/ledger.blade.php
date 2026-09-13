@extends('index')
@push('title', get_phrase('Ledger'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Ledger') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.company.index') }}">{{ get_phrase('Company') }}</a></li>
                    <li><a href="#">{{ get_phrase('Ledger') }}</a></li>
                </ul>
            </div>
            @can('organization-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/add']) }}', '{{ get_phrase('Add new company') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new company') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Ledger') }}</p>
                <div class="table-responsive">
                    <div class="mt-3">
                        <form method="GET" action="{{ route('admin.ledger.show', $id) }}" class="row mb-3">

                            <div class="col-md-3">
                                <label class="eForm-label">From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                    class="eForm-control form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="eForm-label">To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                    class="eForm-control form-control">
                            </div>

                            <div class="col-md-1 align-self-end">
                                <button class="btn btn-primary">Filter</button>
                            </div>

                            <div class="col-md-1 align-self-end">
                                <a href="{{ route('admin.ledger.show', $id) }}" class="btn btn-secondary">Reset</a>
                            </div>

                        </form>
                        <h5 class="eForm-label">
                            Total Balance:
                            @if ($totalBalance > 0)
                                <span class="text-success fw-bold">₹{{ $totalBalance }} Receivable</span>
                            @elseif($totalBalance < 0)
                                <span class="text-danger fw-bold">₹{{ $totalBalance }} Payable</span>
                            @else
                                <span class="text-secondary fw-bold">₹{{ $totalBalance }}</span>
                            @endif
                        </h5>
                    </div>


                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ledger as $row)
                                <tr>
                                    <td>{{ $row['date'] }}</td>
                                    <td>{{ $row['type'] }}</td>
                                    <td>{{ $row['ref'] }}</td>
                                    <td>{{ $row['debit'] }}</td>
                                    <td>{{ $row['credit'] }}</td>
                                    <td
                                        class=" @if ($row['balance'] < 0) text-danger fw-bold @elseif($row['balance'] > 0) text-success fw-bold @endif">
                                        {{ $row['balance'] }}
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
