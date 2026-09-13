

<form action="{{ route('admin.warehouse.store') }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" id="name" />
        </div>


        <div class="col-md-12 mt-3">
            <label for="code" class="eForm-label">{{ get_phrase('Code') }}</label>
            <input type="text" name="code" class="form-control eForm-control" id="code" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <textarea name="address" class="form-control eForm-control" id="address" cols="30" rows="4"></textarea>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
