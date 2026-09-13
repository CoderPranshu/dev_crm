@php
    $taxs = DB::table('taxes')->get();
@endphp

<form action="{{ route('admin.vendor.store') }}" method="post">
    @Csrf

    <div class="row">

        <div class="col-md-12 pt-3">
            <label for="company" class="eForm-label">{{ get_phrase('Company Name') }}</label>
            <input type="text" name="company" class="form-control eForm-control" id="company" />
        </div>



        <div class="col-md-12 pt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" class="form-control eForm-control" id="email" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="phone" class="eForm-label">{{ get_phrase('Phone') }}</label>
            <input type="text" name="phone" class="form-control eForm-control" id="phone" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="website" class="eForm-label">{{ get_phrase('Website') }}</label>
            <input type="text" name="website" class="form-control eForm-control" id="website" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <textarea name="address" class="form-control eForm-control" id="address"></textarea>
        </div>

        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Contact Person') }}</label>
            <input type="text" name="name" class="form-control eForm-control" id="name" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="vendor_type" class="eForm-label">{{ get_phrase('Vendor Type') }}</label>
            <input type="text" name="vendor_type" class="form-control eForm-control" id="vendor_type" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="tax_id" class="eForm-label">{{ get_phrase('GST No') }}</label>
            <input type="text" name="tax_id" class="form-control eForm-control" id="tax_id">
        </div>

        <div class="col-md-12 mt-3">
            <label for="status" class="eForm-label">{{ get_phrase('Status') }}</label>
            <select name="status" class="form-control eForm-control" id="status">
                <option selected disabled>{{ get_phrase('Select Status') }}</option>
                <option value="active">{{ get_phrase('Active') }}</option>
                <option value="inactive">{{ get_phrase('Inactive') }}</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
