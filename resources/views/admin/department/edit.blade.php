@php
    $branches = DB::table('branches')->get();
    $depart = DB::table('departments')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.department.update', $depart->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
            <input type="text" name="title" value="{{ $depart->title }}" class="form-control eForm-control" id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Branch') }}</label>
            <select name="branch" class="form-control eForm-control" id="">
                <option value="" selected disabled>Select Branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $branch->id == $depart->branch ? 'selected' : '' }}>{{ $branch->title }}</option>
                @endforeach
            </select>
        </div>



        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>
