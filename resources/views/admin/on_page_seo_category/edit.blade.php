@extends('index')

@push('title', get_phrase('Edit On Page SEO Category'))

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-6">

            <h3 class="fw-bold mb-1">
                Edit On Page SEO Category
            </h3>

            <p class="text-muted mb-0">
                Update existing category information.
            </p>

        </div>

        <div class="col-md-6 text-end">

            <a href="{{ route('admin.on-page-seo-category.index') }}"
               class="btn btn-light border">

                <i class="fa fa-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    <form action="{{ route('admin.on-page-seo-category.update',$category->id) }}"
          method="POST">

        @csrf

        @method('PUT')

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">

                            Category Name

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name',$category->name) }}"
                            required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order',$category->sort_order) }}">

                    </div>

                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="active"
                                {{ $category->status=='active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ $category->status=='inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                    <div class="col-md-12">

                        <label class="form-label fw-semibold">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="form-control">{{ old('description',$category->description) }}</textarea>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <button class="btn btn-primary">

                    <i class="fa fa-save me-2"></i>

                    Update Category

                </button>

            </div>

        </div>

    </form>

</div>

@endsection