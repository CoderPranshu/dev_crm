@extends('index')

@push('title', get_phrase('Add Category'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            Add Category
        </div>

        <div class="card-body">

            <form
                action="{{ route('admin.subscription-categories.store') }}"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label>Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label>Status</label>

                    <select
                        name="status"
                        class="form-control">

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>

                </div>

                <button
                    class="btn btn-primary">

                    Save

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