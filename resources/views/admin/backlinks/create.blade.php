@extends('index')

@push('title', get_phrase('Add Backlink'))

@section('content')

<form
    action="{{ route('admin.backlinks.store') }}"
    method="POST">

    @csrf

    <div class="mainSection-title">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h4>

                    Add Backlink

                </h4>

                <small class="text-muted">

                    Create New Backlink

                </small>

            </div>

            <div>

                <a
                    href="{{ route('admin.backlinks.index') }}"
                    class="btn btn-light border">

                    <i class="fa-solid fa-arrow-left me-2"></i>

                    Back

                </a>

            </div>

        </div>

    </div>

    <div class="eSection-wrap">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="row">

                    <div class="col-lg-6 mb-4">

                        <label class="form-label fw-semibold">

                            Category

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="backlink_category_id"
                            class="form-select @error('backlink_category_id') is-invalid @enderror"
                            required>

                            <option value="">

                                Select Category

                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('backlink_category_id')==$category->id?'selected':'' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('backlink_category_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="col-lg-6 mb-4">

                        <label class="form-label fw-semibold">

                            Website URL

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="url"
                            name="website_url"
                            class="form-control @error('website_url') is-invalid @enderror"
                            value="{{ old('website_url') }}"
                            placeholder="https://example.com"
                            required>

                        @error('website_url')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="col-lg-6 mb-4">

                        <label class="form-label fw-semibold">

                            Domain Authority (DA)

                        </label>

                        <input
                            type="number"
                            min="0"
                            max="100"
                            name="domain_authority"
                            value="{{ old('domain_authority') }}"
                            class="form-control">

                    </div>

                    <div class="col-lg-6 mb-4">

                        <label class="form-label fw-semibold">

                            Page Authority (PA)

                        </label>

                        <input
                            type="number"
                            min="0"
                            max="100"
                            name="page_authority"
                            value="{{ old('page_authority') }}"
                            class="form-control">

                    </div>

                                        <div class="col-lg-6 mb-4">

                        <!-- <label class="form-label fw-semibold">

                            Status

                        </label> -->

                        <select
                            name="status"
                            class="form-select d-none">

                            <option value="available" selected>

                                Available

                            </option>

                            <option value="assigned">

                                Assigned

                            </option>

                            <option value="completed">

                                Completed

                            </option>

                        </select>

                        <!-- <small class="text-muted">

                            Normally keep it as Available.

                        </small> -->

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('admin.backlinks.index') }}"
                        class="btn btn-light border">

                        <i class="fa-solid fa-xmark me-2"></i>

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Save Backlink

                    </button>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection