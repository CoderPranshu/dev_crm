@extends('index')
@push('title', get_phrase('Attendence'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Attendence') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Attendence') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <form method="GET" class="row mb-3">
        <div class="col-md-4">
            <label class="eForm-label">Branch</label>
            <select name="branch_id" class="eForm-control form-control">
                <option value="">All Branches</option>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}" @selected($branchId == $b->id)>
                        {{ $b->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="eForm-label">From</label>
            <input type="date" name="from_date" value="{{ str_replace('/', '-', $fromDate) }}"
                class="eForm-control form-control">
        </div>

        <div class="col-md-3">
            <label class="eForm-label">To</label>
            <input type="date" name="to_date" value="{{ str_replace('/', '-', $toDate) }}"
                class="eForm-control form-control">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>


    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="column-title mb-2">{{ get_phrase('Attendance') }}</p>
                    <a href="{{ route('admin.attendance.export') }}" class="btn btn-sm btn-success mb-3">
                        Export Excel
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Card No</th>
                                <th>PayCode</th>
                                <th>Punch In</th>
                                <th>Punch Out</th>
                                <th>Created Date</th>
                                <th>System IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($processedRows as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row['BRANCH_NAME'] }}</td>
                                    <td>{{ $row['CARDNO'] ?? '-' }}</td>
                                    <td>{{ $row['PAYCODE'] ?? '-' }}</td>
                                    <td class="text-success fw-bold">
                                        {{ $row['PUNCH_IN'] }}
                                    </td>

                                    <td class="text-danger fw-bold">
                                        {{ $row['PUNCH_OUT'] }}
                                    </td>

                                    <td>{{ $row['DATE'] ?? '-' }}</td>
                                    <td>{{ $row['SYSTEMIP'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">
                                        No attendance data found
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
