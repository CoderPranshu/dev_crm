@extends('index')

@push('title', get_phrase('Add SEO Service'))

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h4>{{ get_phrase('Add SEO Service') }}</h4>

        </div>

        <div>

            <a href="{{ route('admin.seo-services.index') }}" class="btn btn-secondary">

                <i class="fi-rr-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

</div>

<div class="eSection-wrap">

    <form action="{{ route('admin.seo-services.store') }}" method="POST">

        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Service Name <span class="text-danger">*</span>

                </label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Enter Service Name">

                @error('name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Status <span class="text-danger">*</span>

                </label>

                <select name="status"
                        class="form-select @error('status') is-invalid @enderror">

                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

                @error('status')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-12 mb-3">

                <label class="form-label">

                    Description

                </label>

                <textarea name="description"
                          rows="5"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Enter Description">{{ old('description') }}</textarea>

                @error('description')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

        </div>

        <div class="mt-3">

            <button type="submit" class="btn btn-primary">

                <i class="fi-rr-disk"></i>

                Save

            </button>

            <a href="{{ route('admin.seo-services.index') }}"
               class="btn btn-light">

                Cancel

            </a>

        </div>

    </form>

</div>

@endsection