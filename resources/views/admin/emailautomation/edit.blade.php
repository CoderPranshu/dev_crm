@extends('index')
@push('title', get_phrase('Email Automation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Email Automation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.emailautomation.index') }}">{{ get_phrase('Email Automation') }}</a></li>
                    <li><a href="#">{{ get_phrase('Edit Email Automation') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="{{ route('admin.emailautomation.add') }}" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new email automation') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Email Template') }}</p>
                <form action="{{ route('admin.emailautomation.update', $campaign->id) }}" method="POST">
                    @Csrf

                    {{-- Campaign Name --}}
                    <div class="form-group">
                        <label class="eForm-label">Campaign Name</label>
                        <input type="text" name="name" class="form-control eForm-control"
                            value="{{ $campaign->name }}" required>
                    </div>

                    {{-- Template --}}
                    <div class="form-group">
                        <label class="eForm-label">Select Email Template</label>
                        <select name="template_id" class="form-control eForm-control" required>
                            <option value="">Select Template</option>
                            @foreach ($templates as $temp)
                                <option value="{{ $temp->id }}" @if ($campaign->template_id == $temp->id) selected @endif>
                                    {{ $temp->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                                        @php
                        $branches = App\Models\Branch::get();
                    @endphp
                    <div class="col-md-12 mt-2">
                        <label class="eForm-label">Branches</label>
                        @if(auth()->user()->hasRole('Admin'))
                            <select name="branch_id" class="form-control eForm-control" required>
                                <option value="">{{ get_phrase('Select Branch') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $campaign->branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->title }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                            <p class="eForm-control">{{ auth()->user()->branch->title }}</p>
                        @endif
                    </div>

                    {{-- Subject --}}
                    <div class="form-group">
                        <label class="eForm-label">Email Subject</label>
                        <input type="text" name="subject" class="form-control eForm-control"
                            value="{{ $campaign->subject }}" required>
                    </div>

                    {{-- Subscribers --}}
                    <div class="form-group">
                        <label class="eForm-label">Select Subscribers</label>
                        <select name="subscribers[]" class="form-control eForm-control" multiple required>
                            @foreach ($subscribers as $sub)
                                <option value="{{ $sub->id }}" @if (in_array($sub->id, $selectedSubscribers)) selected @endif>
                                    {{ $sub->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Schedule --}}
                    <div class="form-group">
                        <label class="eForm-label">Schedule Time (Optional)</label>
                        <input type="datetime-local" name="schedule_time" class="form-control eForm-control"
                            value="{{ $campaign->schedule_time ? date('Y-m-d\TH:i', strtotime($campaign->schedule_time)) : '' }}">
                    </div>

                    <button class="btn btn-primary eForm-label mt-3">Update Campaign</button>
                </form>
            </div>
        </div>
    </div>
@endsection
