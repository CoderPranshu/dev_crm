@php
    $branch = DB::table('branches')->get();
$roles = \Spatie\Permission\Models\Role::where('name', '!=', 'Admin')
    ->pluck('name', 'name')
    ->all();

    // dd($roles);
@endphp

<form action="{{ route('admin.staff.store') }}" method="post" enctype="multipart/form-data">
    @Csrf
    <div class="fpb-7">
        <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
        <input type="text" name="name" class="form-control eForm-control" id="name" required>
    </div>
    <div class="fpb-7">
        <label for="branch_id" class="eForm-label">{{ get_phrase('Branch') }}</label>
        <select class="form-select eForm-select select2" id="branch_id" name="branch_id">
            <option value="" disabled selected>{{ get_phrase('Select a branch') }}</option>
            @foreach ($branch as $row)
                <option value="{{ $row->id }}">{{ $row->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="fpb-7">
        <label for="department_id" class="eForm-label">{{ get_phrase('Department') }}</label>
        <select name="department" id="department_id" class="form-select eForm-select select2">
            <option value="" disabled selected>--Select Department--</option>
        </select>
    </div>

    <div class="fpb-7">
        <label for="designation_id" class="eForm-label">{{ get_phrase('Designation') }}</label>
        <select name="designation_id" id="designation_id" class="form-select eForm-select select2">
            <option value="" disabled selected>--Select Designation--</option>
        </select>
    </div>

    <div class="fpb-7">
        <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
        <input type="email" name="email" class="form-control eForm-control" id="email" required>
    </div>

    <div class="fpb-7">
        <label for="password" class="eForm-label">{{ get_phrase('Password') }}</label>
        <input type="text" name="password" class="form-control eForm-control" id="password" required>
    </div>

    <div class="fpb-7">
        <label for="role" class="eForm-label">{{ get_phrase('User role') }}</label>
        <select name="roles" class="form-select eForm-select" required>
            @foreach($roles as $key => $role)
                <option value="{{ $key }}">{{ $role }}</option>
            @endforeach
        </select>
    </div>

    <div class="fpb-7">
        <label for="" class="eForm-label">{{ get_phrase('Paycode') }}</label>
        <input type="text" class="form-control eForm-control" required name="paycode">
    </div>

    <div class="fpb-7">
        <label for="" class="eForm-label">{{ get_phrase('Is Manager') }}</label>
        <select name="is_manager" class="form-control eForm-control" id="">
            <option value="0">{{ get_phrase('No') }}</option>
            <option value="1">{{ get_phrase('Yes') }}</option>
        </select>
    </div>

    <div class="fpb-7">
        <label for="photo" class="eForm-label">{{ get_phrase('Photo') }}</label>
        <input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
    </div>

    <button type="submit" class="btn-form mt-2 mb-3">{{ get_phrase('Apply') }}</button>
</form>

@include('init')
