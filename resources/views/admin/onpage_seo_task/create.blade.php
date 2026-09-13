@extends('index')

@push('title', get_phrase('Create On Page SEO Task'))

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-6">

            <h3 class="fw-bold mb-1">
                Create On Page SEO Task
            </h3>

            <p class="text-muted mb-0">
                Add a new master task for On Page SEO.
            </p>

        </div>

        <div class="col-md-6 text-end">

            <a href="{{ route('admin.onpage-seo-task.index') }}"
               class="btn btn-light border">

                <i class="fa fa-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    <form
        action="{{ route('admin.onpage-seo-task.store') }}"
        method="POST">

        @csrf

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="row">

                    {{-- Category --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">

                            Category

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="on_page_seo_category_id"
                            class="form-select @error('on_page_seo_category_id') is-invalid @enderror"
                            required>

                            <option value="">

                                Select Category

                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('on_page_seo_category_id')==$category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('on_page_seo_category_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- Task Name --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">

                            Task Name

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="task_name"
                            class="form-control @error('task_name') is-invalid @enderror"
                            value="{{ old('task_name') }}"
                            placeholder="Example : SEO Title"
                            required>

                        @error('task_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    {{-- Input Type --}}
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-semibold">

                            Input Type

                        </label>

                        <select
                            name="input_type"
                            id="input_type"
                            class="form-select">

                            <option value="text">Text</option>

                            <option value="textarea">Textarea</option>

                            <option value="number">Number</option>

                            <option value="url">URL</option>

                            <option value="email">Email</option>

                            <option value="date">Date</option>

                            <option value="file">File</option>

                            <option value="checkbox">Checkbox</option>

                            <option value="select">Select Dropdown</option>

                        </select>

                    </div>

                    {{-- Sort --}}
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-semibold">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order',0) }}">

                    </div>

                    {{-- Status --}}
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-semibold">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="active">

                                Active

                            </option>

                            <option value="inactive">

                                Inactive

                            </option>

                        </select>

                    </div>

                    {{-- Placeholder --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">

                            Placeholder

                        </label>

                        <input
                            type="text"
                            name="placeholder"
                            class="form-control"
                            placeholder="Example : Enter SEO Title">

                    </div>

                    {{-- Select Options --}}
                    <div
                        class="col-md-12 mb-4"
                        id="optionArea"
                        style="display:none;">

                        <label class="form-label fw-semibold">

                            Dropdown Options

                        </label>

                        <textarea
                            name="options"
                            rows="4"
                            class="form-control"
                            placeholder="One option per line

Yes
No
Pending"></textarea>

                        <small class="text-muted">

                            One option per line.

                        </small>

                    </div>

                    {{-- Required --}}
                    <div class="col-md-12 mb-4">

                        <div class="form-check">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="required"
                                name="is_required"
                                value="1">

                            <label
                                class="form-check-label"
                                for="required">

                                Required Field

                            </label>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <button
                    type="reset"
                    class="btn btn-light border">

                    <i class="fa fa-refresh me-2"></i>

                    Reset

                </button>

                <button
                    class="btn btn-primary">

                    <i class="fa fa-save me-2"></i>

                    Save Task

                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('js')

<script>

$(function(){

    $("#input_type").change(function(){

        if($(this).val()=="select"){

            $("#optionArea").slideDown();

        }else{

            $("#optionArea").slideUp();

        }

    });

});

</script>

@endpush