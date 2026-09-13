@extends('index')

@push('title', get_phrase('Edit Category'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            Edit Category
        </div>

        <div class="card-body">

            <form
                action="{{ route('subscription-categories.update',$category->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Name</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ $category->name }}"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label>Status</label>

                    <select
                        name="status"
                        class="form-control">

                        <option value="1"
                            {{ $category->status == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ $category->status == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <button
                    class="btn btn-primary">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@push('js')
<script>

</script>
@endpush