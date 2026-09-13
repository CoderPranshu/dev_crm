@php
    $categories = DB::table('categories')->where('parent_id', null)->get();
@endphp

<form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="form-control eForm-control" id="description" rows="4"></textarea>
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">{{ get_phrase('Parent Category') }}</label>
            <select name="parent_id" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select parent category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>

