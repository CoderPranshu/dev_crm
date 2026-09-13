@php
    $categories = DB::table('lead_categories')->get();
    $lead = DB::table('leads')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.leads.update', $lead->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" value="{{ $lead->name }}" id="name" />
        </div>

        <div class="col-md-12 mt-2">
            <label for="phone" class="eForm-label">{{ get_phrase('Phone no') }}</label>
            <input type="text" name="phone" class="form-control eForm-control" value="{{ $lead->phone }}" id="phone" />
        </div>

        <div class="col-md-12 mt-2">
            <label for="email" class="eForm-label">{{ get_phrase('Email address') }}</label>
            <input type="email" name="email" class="form-control eForm-control" value="{{ $lead->email }}" id="email" />
        </div>

        <div class="col-md-12 mt-2">
            <label for="requirement" class="eForm-label">{{ get_phrase('Requirement') }}</label>
            <input type="text" name="requirement" class="form-control eForm-control" value="{{ $lead->requirement }}" id="requirement" />
        </div>

        <div class="col-md-12 mt-2">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <input type="text" name="address" class="form-control eForm-control" value="{{ $lead->address }}" id="address" />
        </div>

        <div class="col-md-12 mt-2">
            <div class="fpb-7">
                <label for="categories_id" class="eForm-label">{{ get_phrase('Branch') }}</label>
                <select class="form-select eForm-select select2" id="categories_id" name="categories_id">
                    <option value="" disabled selected>{{ get_phrase('Select a category') }}</option>
                    @foreach ($categories as $row)
                        <option value="{{ $row->id }}" {{ $row->id == $lead->categories_id ? 'selected' : '' }}>{{ $row->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-2">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>

@include('init')
