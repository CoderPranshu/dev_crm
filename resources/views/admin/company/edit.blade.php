@php
    $company = DB::table('companies')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.company.update', $company->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Company Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" value="{{ $company->name }}"
                id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="contact" class="eForm-label">{{ get_phrase('Contact Person') }}</label>
            <input type="text" name="contact_person" class="form-control eForm-control"
                value="{{ $company->contact_person }}" id="contact">
        </div>

        <div class="col-md-12 mt-3">
            <label for="phone" class="eForm-label">{{ get_phrase('Phone') }}</label>
            <input type="text" name="phone" class="form-control eForm-control" value="{{ $company->phone }}"
                id="phone">
        </div>

        <div class="col-md-12 mt-3">
            <label for="gst" class="eForm-label">{{ get_phrase('GST no.') }}</label>
            <input type="text" name="gst_no" class="form-control eForm-control" value="{{ $company->gst_no }}"
                id="gst">
        </div>

        <div class="col-md-12 mt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" class="form-control eForm-control" value="{{ $company->email }}"
                id="email" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <input type="text" name="address" class="form-control eForm-control" value="{{ $company->address }}"
                id="address">
        </div>

        <div class="col-md-12 mt-3">
            <input type="checkbox" id="same_as_bill" name="ship_to" class="" value="1"
                {{ $company->ship_to == 1 ? 'checked' : '' }}> <span
                class="eForm-label">{{ get_phrase('Ship To') }}</span>
        </div>

        <div class="col-md-12 mt-3" id="ship_to_div">
            <label for="ship_to" class="eForm-label">{{ get_phrase('Shipping Address') }}</label>
            <input type="text" name="shipping" class="form-control eForm-control" value="{{ $company->shipping }}"
                id="ship_to">
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>


<script>
    document.getElementById('same_as_bill').addEventListener('change', function() {
        let shipDiv = document.getElementById('ship_to_div');

        if (this.checked) {
            shipDiv.style.display = 'none';
        } else {
            shipDiv.style.display = 'block';
        }
    });
</script>
