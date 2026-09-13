@php
    $warehouse = DB::table('warehouses')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.warehouse.update', $warehouse->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" id="name" value="{{ $warehouse->name }}" />
        </div>


        <div class="col-md-12 mt-3">
            <label for="code" class="eForm-label">{{ get_phrase('Code') }}</label>
            <input type="text" name="code" class="form-control eForm-control" id="code" value="{{ $warehouse->code }}" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <textarea name="address" class="form-control eForm-control" id="address" cols="30" rows="4">{{ $warehouse->address }}</textarea>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
