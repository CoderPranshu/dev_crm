@extends('index')

@push('title', get_phrase('Upload Backlink File'))

@section('content')

<div class="mainSection-title d-flex justify-content-between align-items-center">

    <div>

        <h4>Upload Backlink File</h4>

        <small class="text-muted">
            Upload a CSV or Excel file. No column mapping is required.
        </small>

    </div>

    <a href="{{ route('admin.backlinks.index') }}" class="btn btn-light border">
        <i class="fa-solid fa-arrow-left me-2"></i>Back
    </a>

</div>

<div class="eSection-wrap">

    @include('admin.backlinks.partials.alerts')

    <form
        action="{{ route('admin.backlinks.prepare') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <div class="mb-4">

                            <label for="category" class="form-label fw-semibold">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select
                                id="category"
                                name="backlink_category_id"
                                class="form-select @error('backlink_category_id') is-invalid @enderror"
                                required>

                                <option value="">Select Category</option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        @selected((string) old('backlink_category_id', $selectedCategoryId) === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('backlink_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div>

                            <label for="csv" class="form-label fw-semibold">
                                CSV / Excel File <span class="text-danger">*</span>
                            </label>

                            <input
                                id="csv"
                                type="file"
                                name="csv"
                                accept=".csv,.xlsx,.xls"
                                class="form-control @error('csv') is-invalid @enderror"
                                required>

                            @error('csv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2">
                                CSV, XLSX or XLS only. Maximum size: 50 MB.
                            </small>

                        </div>

                        <div class="alert alert-primary mt-4 mb-0">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            The original file will be stored securely and shown on the Backlinks index with Open and Download buttons.
                        </div>

                    </div>

                    <div class="card-footer bg-white p-3 text-end">

                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i>Upload File
                        </button>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h6>Instructions</h6>

                        <ul class="mb-0 ps-3">
                            <li>Select a category before uploading.</li>
                            <li>CSV, XLSX and XLS files are supported.</li>
                            <li>Maximum file size is 50 MB.</li>
                            <li>No column mapping will be shown.</li>
                            <li>No data will be inserted into the backlinks table.</li>
                            <li>The original file will appear on the index page.</li>
                            <li>You can open or download the file anytime.</li>
                            <li>Excel preview uses the first worksheet.</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection