@extends('index')

@push('title', get_phrase('Add Plan'))

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form
                action="{{ route('admin.subscription-plans.store') }}"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label>Service Type</label>

                    <select
                        name="service_type_id"
                        class="form-control">

                        <option value="">
                            Select Service Type
                        </option>

                        @foreach($serviceTypes as $service)

                        <option value="{{ $service->id }}">
                            {{ $service->name }}
                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Plan Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label>Price</label>

                    <input
                        type="number"
                        name="price"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label>Duration (Months)</label>

                    <input
                        type="number"
                        name="duration_months"
                        value="12"
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

                <button class="btn btn-primary">
                    Save
                </button>

            </form>

        </div>

    </div>

</div>

@endsection