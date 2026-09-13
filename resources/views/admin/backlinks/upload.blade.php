@extends('index')

@push('title', get_phrase('Upload Backlinks'))

@section('content')

<form
    action="{{ route('admin.backlinks.import') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h4>

                Upload Backlinks

            </h4>

            <small class="text-muted">

                Import Backlinks using CSV

            </small>

        </div>

        <a
            href="{{ route('admin.backlinks.index') }}"
            class="btn btn-light border">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Back

        </a>

    </div>

</div>

<div class="eSection-wrap">

<div class="row">

<div class="col-lg-8">

<div class="card border-0 shadow-sm">

<div class="card-body">

<div class="mb-4">

<label class="form-label fw-semibold">

Category

<span class="text-danger">*</span>

</label>

<select
name="backlink_category_id"
class="form-select"
required>

<option value="">

Select Category

</option>

@foreach($categories as $category)

<option value="{{ $category->id }}">

{{ $category->name }}

</option>

@endforeach

</select>

</div>

<div class="mb-4">

<label class="form-label fw-semibold">

CSV File

<span class="text-danger">*</span>

</label>

<input
type="file"
name="csv"
accept=".csv"
class="form-control"
required>

<small class="text-muted">

Only CSV files allowed.

</small>

</div>

<div class="alert alert-primary">

<h6>

CSV Format

</h6>

<pre class="mb-0">

website_url,domain_authority,page_authority

https://abc.com,55,42

https://xyz.com,60,50

</pre>

</div>

</div>

<div class="card-footer bg-white">

<div class="d-flex justify-content-end">

<button
class="btn btn-success">

<i class="fa-solid fa-file-arrow-up me-2"></i>

Upload CSV

</button>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card border-0 shadow-sm">

<div class="card-header">

Instructions

</div>

<div class="card-body">

<ul class="mb-0">

<li>Duplicate website automatically skipped.</li>

<li>Maximum 50MB CSV.</li>

<li>Only URL, DA and PA required.</li>

<li>Username & Password later filled by SEO Team.</li>

<li>Status automatically Available.</li>

</ul>

</div>

</div>

</div>

</div>

</div>

</form>

@endsection