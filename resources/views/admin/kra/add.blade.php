@php
    $department = DB::table('departments')->get();
    $branch = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.kra.store') }}" method="POST">
    @Csrf
    <div class="row">
        <div class="col-md-12">
            <label for="" class="eForm-label">{{ get_phrase('Title') }}</label>
            <input type="text" class="eForm-control form-control" name="title" required>
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="eForm-control form-control" id="" cols="30" rows="3"></textarea>
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
            <select name="department_id" id="department_id" class="form-select eForm-select select2">
                <option value="" disabled selected>--Select Department--</option>
            </select>
        </div>

        <div class="col-md-12">
            <div class="mt-3">
                <button class="btn-form my-2 w-100" type="submit">{{ get_phrase('Add kra') }}</button>
            </div>
        </div>
    </div>
</form>


@include('init')
