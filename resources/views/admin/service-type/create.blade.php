@extends('index')

@push('title', get_phrase('Add Service Type'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="mainSection-title">
    <h4>{{ get_phrase('Add Service Type') }}</h4>
</div>

<div class="eSection-wrap">

    <form action="{{ route('admin.service-types.store') }}"
          method="POST">

        @csrf

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="eForm-label">
                    Category
                </label>

                <select name="subscription_category_id"
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

            <div class="col-md-6 mb-3">

                <label class="eForm-label">
                    Service Type Name
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="eForm-label">
                    Price
                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="eForm-label">
                    Status
                </label>

                <select name="status"
                        class="form-select">

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <button type="submit"
                class="btn btn-primary">

            Save Service Type

        </button>

        <a href="{{ route('admin.service-types.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </form>

</div>

@endsection

@push('js')
<script>
</script>
@endpush