
<form action="{{ route('admin.branch.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Branch name')}}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title" />
        </div>
        
        
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Register Company name')}}</label>
            <input type="text" name="company_name" class="form-control eForm-control" id="title" />
        </div>
        
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Contact Person')}}</label>
            <input type="text" name="contact_person" class="form-control eForm-control" id="title" />
        </div>
        
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Phone Number')}}</label>
            <input type="tel" name="phone_no" class="form-control eForm-control" id="title" />
        </div>
        
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('GST Number')}}</label>
            <input type="text" name="gstin" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12">
            <label for="machine" class="eForm-label">{{ get_phrase('Machine Serial') }}</label>
            <input type="text" name="machine_serial_no" class="form-control eForm-control" id="machine">
        </div>
        
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Address')}}</label>
            <textarea class="form-control eForm-control" name="address" row="2"></textarea>
        </div>
        
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('State Code')}}</label>
            <input type="text" name="state_code" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="description" class="eForm-label">{{get_phrase('Terms & Condition')}}<small class="text-muted">({{get_phrase('Optional')}})</small></label>
            <textarea name="terms_condition" class="form-control eForm-control" rows="2"></textarea>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>
