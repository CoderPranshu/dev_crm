@extends('index')

@push('title', get_phrase('Subscriptions'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')
 
<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h4>
                {{ get_phrase('Subscriptions') }}
            </h4>

        </div>

        <div>

            <a href="{{ route('admin.subscriptions.create') }}"
               class="btn btn-primary">

                <i class="fi-rr-plus"></i>

                Add Subscription

            </a>

        </div>

    </div>

</div>

<div class="eSection-wrap">

    <div class="table-responsive">

        <table class="table eTable">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Client</th>

                    {{-- <th>Company</th> --}}

                    <th>Total</th>

                    <th>Paid</th>

                    <th>Due</th>

                    <th>Purchase Date</th>

                    <th>Expiry Date</th>

                    <th>Days Left</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($subscriptions as $subscription)

                    @php

                        $today =
                        \Carbon\Carbon::today();

                        $expiry =
                        \Carbon\Carbon::parse(
                            $subscription->expiry_date
                        );

                        $daysLeft =
                        $today->diffInDays(
                            $expiry,
                            false
                        );

                    @endphp

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $subscription->client_name }}

                        </td>

                        {{-- <td>

                            {{ $subscription->company_name }}

                        </td> --}}

                        <td>

                            ₹{{ number_format(
                                $subscription->total_amount,
                                2
                            ) }}

                        </td>
                        <td>
                            ₹{{ number_format(
                                $subscription->paid_amount,
                                2
                            ) }}
                        </td>
                        <td>
                            @if(
                                $subscription->due_amount > 0
                            )
                                <span class="text-danger">
                                    ₹{{ number_format(
                                        $subscription->due_amount,
                                        2
                                    ) }}
                                </span>
                            @else
                                <span class="text-success">
                                    Paid
                                </span>
                            @endif
                        </td>

                        <td>

                            {{ date(
                                'd M Y',
                                strtotime(
                                    $subscription->purchase_date
                                )
                            ) }}

                        </td>

                        <td>

                            {{ date(
                                'd M Y',
                                strtotime(
                                    $subscription->expiry_date
                                )
                            ) }}

                        </td>

                        <td>

                            @if($daysLeft < 0)

                                <span class="text-danger">

                                    Expired

                                </span>

                            @else

                                {{ $daysLeft }} Days

                            @endif

                        </td>

                        <td>

                            @if($daysLeft < 0)

                                <span class="badge bg-danger">

                                    Expired

                                </span>

                            @elseif(
                                $daysLeft <=
                                $subscription->renew_before_days
                            )

                                <span class="badge bg-warning">

                                    Renewal Due

                                </span>

                            @else

                                <span class="badge bg-success">

                                    Active

                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="dropdown">

                                <button
                                    class="btn btn-secondary btn-sm dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">

                                    Action

                                </button>

                                <ul class="dropdown-menu">

                                    <li>

                                        <a class="dropdown-item"
                                           href="{{ route('admin.subscriptions.show',$subscription->id) }}">

                                            View

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item"
                                           href="{{ route('admin.subscriptions.edit',$subscription->id) }}">

                                            Edit

                                        </a>

                                    </li>

                                    @if(
                                        $daysLeft <=
                                        $subscription->renew_before_days
                                    )

                                    <li>

                                        <a class="dropdown-item"
                                           href="{{ route('admin.renewals.create',['subscription_id'=>$subscription->id]) }}">

                                            Renew

                                        </a>

                                    </li>

                                    @endif

                                    @if(
                                        $subscription->due_amount > 0
                                    )

                                    <li>

                                        <a class="dropdown-item"
                                           href="{{ route('admin.subscription-payments.create',['subscription_id'=>$subscription->id]) }}">

                                            Pay Now

                                        </a>

                                    </li>

                                    @endif

                                    <li>

                                        {{-- <a class="dropdown-item text-danger"
                                           href="#"
                                           onclick="confirmModal('{{ route('admin.subscriptions.destroy', $subscription->id) }}');">

                                            Delete

                                        </a> --}}

                                        <form action="{{ route('admin.subscriptions.destroy',$subscription->id) }}"
                                            method="POST"
                                            style="display:inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure?')">

                                                Delete

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>

                        <td colspan="11"
                            class="text-center">

                            No Subscription Found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('js')
<script>

</script>
@endpush