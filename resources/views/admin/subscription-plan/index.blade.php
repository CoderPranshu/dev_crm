@extends('index')

@push('title', get_phrase('Subscription Plans'))

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>Subscription Plans</h4>

        <a href="{{ route('admin.subscription-plans.create') }}"
            class="btn btn-primary">
            Add Plan
        </a>
    </div>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>#</th>
                <th>Service Type</th>
                <th>Plan Name</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($plans as $key => $plan)

            <tr>

                <td>{{ $key+1 }}</td>

                <td>
                    {{ $plan->serviceType->name ?? '' }}
                </td>

                <td>
                    {{ $plan->name }}
                </td>

                <td>
                    ₹{{ $plan->price }}
                </td>

                <td>
                    {{ $plan->duration_months }} Months
                </td>

                <td>
                    {{ $plan->status ? 'Active' : 'Inactive' }}
                </td>

                <td>

                    <a href="{{ route('admin.subscription-plans.edit',$plan->id) }}"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection