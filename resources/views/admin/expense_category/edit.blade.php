@php
    $category = App\Models\ExpenseCategory::where('id', $id)->first();
@endphp

<form action="{{ route('admin.exp.category.update', $category->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" value="{{$category->name}}" name="name" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>
