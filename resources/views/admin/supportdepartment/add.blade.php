<form action="{{ route('admin.support.department.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="" class="eForm-label">Department Name</label>
            <input type="text" class="form-control eForm-control" name="name">
        </div>

        <div class="col-md-12 mt-3">
            <button class="btn-form btn w-100" type="submit">{{ get_phrase('Submit') }}</button>
        </div>
    </div>
</form>
