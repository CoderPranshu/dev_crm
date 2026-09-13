@extends('index')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card eCard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Notification Settings</h5>
                    <small class="text-muted">Manage who receives notification, mail, and SMS by event type.</small>
                </div>
                <a href="{{ route('admin.notification-settings.create') }}" class="btn btn-primary">
                    <i class="fi-rr-plus"></i> Add Setting
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.notification-settings.index') }}" method="GET" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Notification Type</label>
                        <select name="notification_type" class="form-control eForm-control">
                            <option value="">All</option>
                            @foreach ($notificationTypes as $key => $value)
                                <option value="{{ $key }}" {{ request('notification_type') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control eForm-control">
                            <option value="">All</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success me-2">Filter</button>
                        <a href="{{ route('admin.notification-settings.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Notification Type</th>
                                <th>User</th>
                                <th>Role</th>
                                <th class="text-center">System</th>
                                <th class="text-center">Mail</th>
                                {{-- <th class="text-center">SMS</th> --}}
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($settings as $setting)
                                <tr>
                                    <td>{{ $loop->iteration + ($settings->firstItem() - 1) }}</td>
                                    <td>
                                        <span class="fw-semibold">
                                            {{ $notificationTypes[$setting->notification_type] ?? ucwords(str_replace('_', ' ', $setting->notification_type)) }}
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $setting->notification_type }}</small>
                                    </td>
                                    <td>{{ $setting->user->name ?? '—' }}</td>
                                    <td>{{ $setting->role->name ?? '—' }}</td>
                                    <td class="text-center">
                                        @if ($setting->system_enabled)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($setting->mail_enabled)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">
                                        @if ($setting->sms_enabled)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td> --}}
                                    <td class="text-center">
                                        @if ($setting->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.notification-settings.edit', $setting->id) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="javascript:void(0);"
                                           onclick="confirmModal('{{ route('admin.notification-settings.delete', $setting->id) }}', 'Are you sure you want to delete this notification setting?');"
                                           class="btn btn-sm btn-danger">
                                            <i class="fi-rr-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No notification settings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $settings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
