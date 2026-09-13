@extends('index')
@push('title', get_phrase('Lead History'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Lead History') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.leads.callagain') }}">{{ get_phrase('Call Again Lead') }}</a></li>
                    <li><a href="#">{{ get_phrase('Lead History') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Note</th>
                                <th>Next Date</th>
                                <th>Created By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notes as $key => $note)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $note->description }}</td>
                                    <td>{{ $note->call_date ? \Carbon\Carbon::parse($note->call_date)->format('d M Y, h:i A') : 'N/A' }}</td>
                                    <td>{{ $note->user->name ?? 'N/A' }}</td>
                                    <td>{{ $note->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No call history found
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
