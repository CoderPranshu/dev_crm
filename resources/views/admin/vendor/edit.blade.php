@php
    $taxs = \App\Models\Tax::all();
    $vendor = \App\Models\Vendor::findOrFail($id);
@endphp

<form action="{{ route('admin.vendor.update', $vendor->id) }}" method="post">
    @csrf

    <div class="row">

        <div class="col-md-12 pt-3">
            <label for="company" class="eForm-label">{{ get_phrase('Company') }}</label>
            <input type="text" name="company" class="form-control eForm-control" id="company"
                value="{{ $vendor->company }}" />
        </div>



        <div class="col-md-12 pt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" class="form-control eForm-control" id="email"
                value="{{ $vendor->user->email }}" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="phone" class="eForm-label">{{ get_phrase('Phone') }}</label>
            <input type="text" name="phone" class="form-control eForm-control" id="phone"
                value="{{ $vendor->phone }}" />
        </div>



        <div class="col-md-12 pt-3">
            <label for="website" class="eForm-label">{{ get_phrase('Website') }}</label>
            <input type="text" name="website" class="form-control eForm-control" id="website"
                value="{{ $vendor->website }}" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <textarea name="address" class="form-control eForm-control" id="address">{{ $vendor->address }}</textarea>
        </div>

        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" id="name"
                value="{{ $vendor->user->name }}" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="vendor_type" class="eForm-label">{{ get_phrase('Vendor Type') }}</label>
            <input type="text" name="vendor_type" class="form-control eForm-control" id="vendor_type"
                value="{{ $vendor->vendor_type }}" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="tax_id" class="eForm-label">{{ get_phrase('GST Number') }}</label>
            <input type="text" class="form-control eForm-control" name="tax_id" value="{{ $vendor->tax_id }}">
        </div>

        <div class="col-md-12 pt-3">
            <label for="notes" class="eForm-label">{{ get_phrase('Notes') }}</label>
            <textarea name="notes" class="form-control eForm-control" id="notes">{{ $vendor->notes }}</textarea>
        </div>

        <input type="hidden" name="role" value="Saler" id="">

        <div class="col-md-12 mt-3">
            <label for="status" class="eForm-label">{{ get_phrase('Status') }}</label>
            <select name="status" class="form-control eForm-control" id="status">
                <option selected disabled>{{ get_phrase('Select Status') }}</option>
                <option value="active" {{ $vendor->status == 'active' ? 'selected' : '' }}>{{ get_phrase('Active') }}
                </option>
                <option value="inactive" {{ $vendor->status == 'inactive' ? 'selected' : '' }}>
                    {{ get_phrase('Inactive') }}</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
