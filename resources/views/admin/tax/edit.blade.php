@php
    $tax = DB::table('taxes')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.tax.update', $tax->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" value="{{ $tax->name }}" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Rate') }}</label>
            <input type="number" name="rate" value="{{ $tax->rate }}" class="form-control eForm-control" id="days">
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Type</label>
            <select name="type" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select type</option>
                <option value="percentage" {{ $tax->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                <option value="fixed" {{ $tax->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Status</label>
            <select name="status" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select status</option>
                <option value="active" {{ $tax->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $tax->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
