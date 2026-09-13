
@php
    $type = DB::table('leave_types')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.type.update', $type->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" value="{{ $type->name }}" name="name" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Days') }}</label>
            <input type="number" name="days" value="{{ $type->days }}" class="form-control eForm-control" id="days">
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>
