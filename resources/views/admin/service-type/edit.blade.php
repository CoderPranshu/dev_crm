@extends('index')

@push('title', get_phrase('Edit Service Type'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">

        <div class="d-flex flex-column">

            <h4>
                {{ get_phrase('Edit Service Type') }}
            </h4>

            <ul class="d-flex align-items-center eBreadcrumb-2">

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        {{ get_phrase('Dashboard') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.service-types.index') }}">
                        {{ get_phrase('Service Types') }}
                    </a>
                </li>

                <li>
                    <a href="#">
                        {{ get_phrase('Edit') }}
                    </a>
                </li>

            </ul>

        </div>

    </div>
</div>

<div class="eSection-wrap">

    <form action="{{ route('admin.service-types.update', $serviceType->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="eForm-label">

                    {{ get_phrase('Category') }}

                    <span class="text-danger">*</span>

                </label>

                <select name="subscription_category_id"
                        class="form-select eForm-control"
                        required>

                    <option value="">
                        {{ get_phrase('Select Category') }}
                    </option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            {{ $serviceType->subscription_category_id == $category->id ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="eForm-label">

                    {{ get_phrase('Service Type Name') }}

                    <span class="text-danger">*</span>

                </label>

                <input type="text"
                       name="name"
                       class="form-control eForm-control"
                       value="{{ $serviceType->name }}"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="eForm-label">

                    {{ get_phrase('Price') }}

                    <span class="text-danger">*</span>

                </label>

                <input type="number"
                       step="0.01"
                       min="0"
                       name="price"
                       class="form-control eForm-control"
                       value="{{ $serviceType->price }}"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="eForm-label">

                    {{ get_phrase('Status') }}

                </label>

                <select name="status"
                        class="form-select eForm-control">

                    <option value="1"
                        {{ $serviceType->status == 1 ? 'selected' : '' }}>

                        {{ get_phrase('Active') }}

                    </option>

                    <option value="0"
                        {{ $serviceType->status == 0 ? 'selected' : '' }}>

                        {{ get_phrase('Inactive') }}

                    </option>

                </select>

            </div>

        </div>

        <div class="mt-3">

            <button type="submit"
                    class="btn btn-primary">

                {{ get_phrase('Update Service Type') }}

            </button>

            <a href="{{ route('admin.service-types.index') }}"
               class="btn btn-secondary">

                {{ get_phrase('Back') }}

            </a>

        </div>

    </form>

</div>

@endsection

@push('js')
<script>

</script>
@endpush