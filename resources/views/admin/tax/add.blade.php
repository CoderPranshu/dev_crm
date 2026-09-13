<form action="{{ route('admin.tax.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Rate') }}</label>
            <input type="number" name="rate" class="form-control eForm-control" id="days">
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Type</label>
            <select name="type" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select type</option>
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Status</label>
            <select name="status" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
