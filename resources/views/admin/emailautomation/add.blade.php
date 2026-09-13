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
                    <li><a href="#">{{ get_phrase('Add Email Automation') }}</a></li>
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
                <form action="{{ route('admin.emailautomation.store') }}" method="POST">
                    @csrf

                    {{-- Campaign Name --}}
                    <div class="form-group">
                        <label class="eForm-label">Campaign Name</label>
                        <input type="text" name="name" class="eForm-control form-control" required>
                    </div>

                    {{-- Template --}}
                    <div class="form-group mt-3">
                        <label class="eForm-label">Select Email Template</label>
                        <select name="template_id" id="template_id" class="form-control eForm-control" required>
                            <option value="">Select Template</option>
                            @foreach ($templates as $temp)
                                <option value="{{ $temp->id }}">{{ $temp->title }}</option>
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
                                    <option value="{{ $branch->id }}">{{ $branch->title }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                            <p class="eForm-control">{{ auth()->user()->branch->title }}</p>
                        @endif
                    </div>

                    {{-- Subject --}}
                    <div class="form-group mt-3">
                        <label class="eForm-label">Email Subject</label>
                        <input type="text" name="subject" class="eForm-control form-control" required
                            placeholder="Your Subject Here">
                    </div>

                    {{-- Subscribers --}}
                    <div class="form-group mt-3">
                        <label class="eForm-label">Select Subscribers</label>
                        <select name="subscribers[]" id="subscribers" class="form-control eForm-control eForm-select select2" multiple required>
                            @foreach ($subscribers as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->email }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted eForm-label">You can select multiple subscribers</small>
                    </div>

                    {{-- Schedule --}}
                    <div class="form-group mt-3">
                        <label class="eForm-label">Schedule Time (Optional)</label>
                        <input type="datetime-local" name="schedule_time" class="eForm-control form-control">
                        <small class="text-muted">Leave empty to send immediately</small>
                    </div>

                    <button class="btn btn-primary mt-3">Create Campaign</button>
                </form>
            </div>
        </div>
    </div>
    <script id="ajaxbranchfilter">
document.getElementById('branch_id')?.addEventListener('change', function () {
    let branchId = this.value;

    fetch(`/admin/emailautomation/get-data?branch_id=${branchId}`)
        .then(res => res.json())
        .then(data => {

            // Templates
            let templateSelect = document.getElementById('template_id');
            templateSelect.innerHTML = '<option value="">Select Template</option>';

            data.templates.forEach(t => {
                templateSelect.innerHTML += `<option value="${t.id}">${t.title}</option>`;
            });

            // Subscribers
            let subscriberSelect = document.getElementById('subscribers');
            subscriberSelect.innerHTML = '';

            data.subscribers.forEach(s => {
                subscriberSelect.innerHTML += `<option value="${s.id}">${s.email}</option>`;
            });
        });
});
</script>
@endsection
