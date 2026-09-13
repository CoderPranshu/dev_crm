@extends('index')

@push('title', get_phrase('Create On Page SEO Category'))

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-6">

            <h3 class="fw-bold mb-1">
                Create On Page SEO Category
            </h3>

            <p class="text-muted mb-0">
                Create a new master category for On Page SEO.
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

    <form action="{{ route('admin.on-page-seo-category.store') }}"
          method="POST">

        @csrf

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row">

                    {{-- Category Name --}}
                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">

                            Category Name
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter Category Name"
                            value="{{ old('name') }}"
                            required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Sort Order --}}
                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order',0) }}">

                        @error('sort_order')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Status --}}
                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror">

                            <option value="active"
                                {{ old('status')=='active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status')=='inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Description --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Write category description...">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <button type="reset"
                        class="btn btn-light border">

                    <i class="fa fa-rotate-left me-2"></i>

                    Reset

                </button>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fa fa-save me-2"></i>

                    Save Category

                </button>

            </div>

        </div>

    </form>

</div>

@endsection