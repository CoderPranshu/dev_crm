@php
    $categories = DB::table('lead_categories')->get();
    // $deal = DB::table('deals')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.deals.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control"  id="name" />
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Close date') }}</label>
            <input type="date" name="close_date" class="form-control eForm-control">
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Remark') }}</label>
            <input type="text" class="form-control eForm-control" name="remarks">
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Requirement') }}</label>
            <input type="text" class="form-control eForm-control" name="requirement">
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" id="" cols="30" rows="5" class="form-control eForm-control"></textarea>
        </div>

        <div class="col-md-12 mt-2">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add new') }}</button>
        </div>
    </div>
</form>

@include('init')
