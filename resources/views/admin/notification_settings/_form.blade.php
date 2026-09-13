<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Notification Type <span class="text-danger">*</span></label>
        <select name="notification_type" class="form-control eForm-control" required>
            <option value="">Select Notification Type</option>
            @foreach ($notificationTypes as $key => $value)
                <option value="{{ $key }}"
                    {{ old('notification_type', $setting->notification_type ?? '') == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        @error('notification_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">User</label>
        <select name="user_id" class="form-control eForm-control">
            <option value="">Select User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('user_id', $setting->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} {{ $user->email ? '- '.$user->email : '' }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Role</label>
        <select name="role_id" class="form-control eForm-control">
            <option value="">Select Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}"
                    {{ old('role_id', $setting->role_id ?? '') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                {{ old('is_active', $setting->is_active ?? 1) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border rounded-3 p-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="system_enabled" value="1"
                    {{ old('system_enabled', $setting->system_enabled ?? 1) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold">System Notification</label>
            </div>
            <small class="text-muted">Enable in-app notifications.</small>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border rounded-3 p-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="mail_enabled" value="1"
                    {{ old('mail_enabled', $setting->mail_enabled ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold">Mail Notification</label>
            </div>
            <small class="text-muted">Enable email notifications.</small>
        </div>
    </div>

    {{-- <div class="col-md-4 mb-3">
        <div class="card border rounded-3 p-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="sms_enabled" value="1"
                    {{ old('sms_enabled', $setting->sms_enabled ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold">SMS Notification</label>
            </div>
            <small class="text-muted">Enable SMS notifications.</small>
        </div>
    </div> --}}

    <div class="col-12">
        <div class="alert alert-info">
            Select at least one <strong>User</strong> or <strong>Role</strong>.
            You can also select both.
        </div>
    </div>
</div>
