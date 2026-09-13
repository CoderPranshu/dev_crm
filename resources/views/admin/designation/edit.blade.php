@php
    $departments = DB::table('departments')->get();
    $desi = DB::table('designations')->get()->first();
@endphp

<form action="{{ route('admin.designation.update', $desi->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
            <input type="text" name="title" class="form-control eForm-control" value="{{ $desi->title }}" id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label class="eForm-label">{{ get_phrase('Department') }}</label>
            <select name="department_id" class="form-control eForm-control" id="">
                <option value="" selected disabled>Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" {{ $department->id == $desi->department_id ? 'selected' : '' }}>{{ $department->title }}</option>
                @endforeach
            </select>
        </div>



        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>
