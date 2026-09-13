
{{-- @php
    $recruitments = DB::table('recruitments')->get();
@endphp --}}

<form action="{{ route('admin.type.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="name" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Days') }}</label>
            <input type="number" name="days" class="form-control eForm-control" id="days">
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>
