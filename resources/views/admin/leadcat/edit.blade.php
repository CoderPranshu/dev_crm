
@php
    $cat = DB::table('lead_categories')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.leadcategory.update', $cat->id) }}" method="post">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="title" class="form-control eForm-control" value="{{ $cat->title }}" id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>
