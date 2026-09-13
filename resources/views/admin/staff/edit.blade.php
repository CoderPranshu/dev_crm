@php
    $branches = DB::table('branches')->get();
    $user_details = \App\Models\User::find($user_id);
    $roles = \Spatie\Permission\Models\Role::pluck('name', 'name')->all();
    $userRole = $user_details->roles->pluck('name', 'name')->all();
@endphp

@if (!$user_details)
    <div class="alert alert-danger">{{ get_phrase('User not found') }}</div>
@else
<form action="{{ route('admin.staff.update', $user_id) }}" method="post" enctype="multipart/form-data">
    @csrf

    {{-- NAME --}}
    <div class="fpb-7">
        <label class="eForm-label">Name</label>
        <input type="text" name="name" class="form-control eForm-control"
            value="{{ $user_details->name }}" required>
    </div>

    {{-- BRANCH --}}
    <div class="fpb-7">
        <label class="eForm-label">Branch</label>
        <select class="form-select eForm-select select2" id="branch_id" name="branch_id" required>
            <option value="">Select Branch</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ $user_details->branch_id == $branch->id ? 'selected' : '' }}>
                    {{ $branch->title }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- DEPARTMENT --}}
    <div class="fpb-7">
        <label class="eForm-label">Department</label>
        <select name="department_id" id="department_id" class="form-select eForm-select select2">
            <option value="">--Select Department--</option>
        </select>
    </div>

    {{-- DESIGNATION --}}
    <div class="fpb-7">
        <label class="eForm-label">Designation</label>
        <select name="designation_id" id="designation_id" class="form-select eForm-select select2">
            <option value="">--Select Designation--</option>
        </select>
    </div>

    {{-- EMAIL --}}
    <div class="fpb-7">
        <label class="eForm-label">Email</label>
        <input type="email" name="email" class="form-control eForm-control"
            value="{{ $user_details->email }}" required>
    </div>

    {{-- ROLE --}}
    <div class="fpb-7">
        <label class="eForm-label">User role</label>
        <select name="roles" class="form-select eForm-select" required>
            <option value="">---Select Role---</option>
            @foreach ($roles as $key => $role)
                <option value="{{ $key }}"
                    {{ in_array($key, (array) $userRole) ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- PAYCODE --}}
    <div class="fpb-7">
        <label class="eForm-label">Paycode</label>
        <input type="text" name="paycode" class="form-control eForm-control"
            value="{{ $user_details->paycode }}">
    </div>

    {{-- PHOTO --}}
    <div class="fpb-7">
        <label class="eForm-label">Photo</label>

        <input type="file" name="photo" class="form-control eForm-control-file" accept="image/*">

        <input type="hidden" name="remove_photo" id="remove_photo" value="0">

        @if ($user_details->photo)
            <div class="mt-2 d-flex align-items-center gap-2" id="photo-preview-wrapper">
                <img src="{{ asset('uploads/user-image/' . $user_details->photo) }}"
                    width="80" class="rounded border">

                <button type="button" class="btn btn-sm btn-danger"
                    onclick="removeUserPhoto()">Remove</button>
            </div>
        @endif
    </div>

    <button type="submit" class="btn-form mt-2 mb-3">Update</button>
</form>
@endif

@include('init')
