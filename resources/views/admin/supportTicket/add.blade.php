@php
    $user = Auth::user();
    $departments = DB::table('support_departments')->get();
@endphp

<form action="{{ route('admin.support.store') }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="" class="eForm-label">Name</label>
            <input type="text" name="name" class="form-control eForm-control" value="{{ $user->name }}" readonly>
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">Email</label>
            <input type="text" class="form-control eForm-control" value="{{ $user->email }}" name="email" readonly>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">Department</label>
            <select name="department" class="eForm-control form-control select2 form-select" name="department_is" id="">
                <option value="">--Select Department---</option>
                @foreach ($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Message') }}</label>
            <textarea name="message" id="" cols="30" rows="6" class="form-control eForm-control"></textarea>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Attach File') }}</label>
            <input type="file" class="form-control eForm-control" name="file">
        </div>

        <div class="col-md-12 mt-3">
            <button class="btn-form btn w-100" type="submit">{{ get_phrase('Submit') }}</button>
        </div>
    </div>
</form>
