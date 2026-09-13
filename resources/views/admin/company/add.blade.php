<form action="{{ route('admin.company.store') }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{get_phrase('Company Name')}}</label>
            <input type="text" name="name" class="form-control eForm-control" id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Contact Person') }}</label>
            <input type="text" name="contact_person" class="form-control eForm-control" id="contactPerson">
        </div>

        <div class="col-md-12 mt-3">
            <label for="phone" class="eForm-label">{{ get_phrase('Contact No') }}</label>
            <input type="text" name="phone" class="form-control eForm-control" id="phone">
        </div>

        <div class="col-md-12 mt-3">
            <label for="gst" class="eForm-label">{{ get_phrase('GST no. (Optional)') }}</label>
            <input type="text" name="gst_no" class="form-control eForm-control" id="gst">
        </div>

        <div class="col-md-12 mt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" class="form-control eForm-control" id="email" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="password" class="eForm-label">{{ get_phrase('Password') }}</label>
            <input type="password" class="form-control eForm-control" name="password" id="password">
        </div>

        <div class="col-md-12 mt-3">
            <label for="password_confirmation" class="eForm-label">{{ get_phrase('Confirm Password') }}</label>
            <input type="password" class="form-control eForm-control" name="password_confirmation" id="password_confirmation">
        </div>

        <div class="col-md-12 mt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <input type="text" name="address" class="form-control eForm-control" id="address">
        </div>

        <div class="col-md-12 mt-3">
            <input type="checkbox" id="same_as_bill" class="" name="ship_to" aria-label="Text input with checkbox" value="1"> <span class="eForm-label">Ship to same as bill to</span>
        </div>

        <div class="col-md-12 mt-3" id="ship_to_div">
            <label for="ship_to" class="eForm-label">{{ get_phrase('Ship Address') }}</label>
            <input type="text" name="shipping" class="form-control eForm-control" id="ship_to">
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>


<script>
document.getElementById('same_as_bill').addEventListener('change', function() {
    let shipDiv = document.getElementById('ship_to_div');

    if(this.checked){
        shipDiv.style.display = 'none';
    }else{
        shipDiv.style.display = 'block';
    }
});
</script>
