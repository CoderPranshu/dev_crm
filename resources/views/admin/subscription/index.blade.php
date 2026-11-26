@extends('index')

@push('title', get_phrase('Subscriptions'))

@push('css')
<style>
    .subscriptions-page .subscription-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .subscriptions-page .subscription-search {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .subscriptions-page .subscription-search input {
        width: min(360px, 100%);
    }

    .subscriptions-page .subscription-table {
        min-width: 1380px;
        margin-bottom: 0;
        vertical-align: middle;
    }

    .subscriptions-page .subscription-table th {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
        background: #f8fafc;
    }

    .subscriptions-page .subscription-table td,
    .subscriptions-page .subscription-table th {
        padding: 15px 12px;
    }

    .subscriptions-page .client-name {
        color: #17283c;
        font-weight: 700;
    }

    .subscriptions-page .muted-line {
        color: #64748b;
        font-size: 12px;
    }

    .subscriptions-page .domain-details summary {
        color: #08758b;
        cursor: pointer;
        font-weight: 700;
        width: fit-content;
    }

    .subscriptions-page .domain-details summary:hover {
        text-decoration: underline;
    }

    .subscriptions-page .domain-list {
        width: min(540px, 78vw);
        max-width: none;
        padding-top: 12px;
    }

    .subscriptions-page .domain-box {
        border: 1px solid #deebef;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 10px;
        background: #fbfdfe;
    }

    .subscriptions-page .domain-box:last-child {
        margin-bottom: 0;
    }

    .subscriptions-page .domain-title {
        font-size: 14px;
        font-weight: 700;
        color: #174454;
        overflow-wrap: anywhere;
    }

    .subscriptions-page .domain-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .subscriptions-page .domain-status-form {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .subscriptions-page .domain-status-form select { width: auto; min-width: 116px; }

    .subscriptions-page .service-list {
        width: 100%;
        font-size: 12px;
        margin-top: 10px;
        border-collapse: collapse;
    }

    .subscriptions-page .service-list th,
    .subscriptions-page .service-list td {
        padding: 7px 5px;
        border-bottom: 1px solid #e8eef2;
        text-align: left;
        vertical-align: top;
        white-space: normal;
    }

    .subscriptions-page .service-list th:last-child,
    .subscriptions-page .service-list td:last-child {
        text-align: right;
        white-space: nowrap;
    }

    .subscriptions-page .service-list tfoot td {
        border-bottom: 0;
        font-weight: 700;
    }

    .subscriptions-page .status-pill {
        display: inline-block;
        border-radius: 999px;
        padding: 5px 11px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .subscriptions-page .status-active { color: #047857; background: #e8f8f1; }
    .subscriptions-page .status-renewal { color: #9a6700; background: #fff4d8; }
    .subscriptions-page .status-expired { color: #be123c; background: #ffe8ed; }
    .subscriptions-page .status-other { color: #475569; background: #eef2f7; }

    .subscriptions-page .subscription-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .subscriptions-page .subscription-actions form {
        margin: 0;
    }

    @media (max-width: 767px) {
        .subscriptions-page .subscription-search,
        .subscriptions-page .subscription-search input {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="mainSection-title d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h4 class="mb-0">{{ get_phrase('Subscriptions') }}</h4>
    <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">+ Add Subscription</a>
</div>

<div class="eSection-wrap subscriptions-page">
    @php
        if ($subscriptions instanceof \Illuminate\Pagination\AbstractPaginator) {
            if (method_exists($subscriptions->getCollection(), 'loadMissing')) {
                $subscriptions->getCollection()->loadMissing(['items', 'company']);
            }
        } elseif (method_exists($subscriptions, 'loadMissing')) {
            $subscriptions->loadMissing(['items', 'company']);
        }

        $categoryNames = $categoryNames ?? \App\Models\SubscriptionCategory::pluck('name', 'id');
        $serviceNames = $serviceNames ?? \App\Models\ServiceType::pluck('name', 'id');
        $hasShowRoute = \Illuminate\Support\Facades\Route::has('admin.subscriptions.show');
        $hasEditRoute = \Illuminate\Support\Facades\Route::has('admin.subscriptions.edit');
        $hasDestroyRoute = \Illuminate\Support\Facades\Route::has('admin.subscriptions.destroy');
        $hasDomainStatusRoute = \Illuminate\Support\Facades\Route::has('admin.subscriptions.domains.status');
        $hasRenewRoute = \Illuminate\Support\Facades\Route::has('admin.renewals.create');
        $hasPaymentRoute = \Illuminate\Support\Facades\Route::has('admin.subscription-payments.create');
    @endphp

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive">
        <table class="table eTable table-hover subscription-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Client</th>
                    <th scope="col">Domains &amp; Services</th>
                    <th scope="col">Total</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Due</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Expiry Date</th>
                    <th scope="col">Days Left</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscriptions as $subscription)
                    @php
                        $domainGroups = $subscription->items->groupBy(
                            fn ($item) => trim((string) $item->domain_name)
                        );

                        $today = \Illuminate\Support\Carbon::today();
                        $expiry = $subscription->expiry_date
                            ? \Illuminate\Support\Carbon::parse($subscription->expiry_date)->startOfDay()
                            : null;
                        $storedStatus = strtolower((string) $subscription->status);
                        $daysLeft = $expiry ? (int) $today->diffInDays($expiry, false) : null;
                        $renewBeforeDays = max(0, (int) $subscription->renew_before_days);
                        $paidAmount = (float) $subscription->paid_amount;
                        $dueAmount = (float) $subscription->total_amount - $paidAmount;

                        if ($storedStatus !== 'active') {
                            $statusText = $storedStatus ? ucfirst(str_replace('_', ' ', $storedStatus)) : 'Unknown';
                            $statusClass = 'status-other';
                        } elseif ($expiry && $expiry->lt($today)) {
                            $statusText = 'Expired';
                            $statusClass = 'status-expired';
                        } elseif ($expiry && $today->gte($expiry->copy()->subDays(max(0, (int) $subscription->renew_before_days)))) {
                            $statusText = 'Renewal Due';
                            $statusClass = 'status-renewal';
                        } else {
                            $statusText = 'Active';
                            $statusClass = 'status-active';
                        }
                    @endphp
                    <tr>
                        <td>
                            {{ (method_exists($subscriptions, 'firstItem') ? ($subscriptions->firstItem() ?? 1) : 1) + $loop->index }}
                        </td>

                        <td>
                            <div class="client-name">{{ $subscription->client_name ?: '—' }}</div>
                            <div class="muted-line">{{ $subscription->company->name ?? $subscription->company_name ?? '—' }}</div>
                            @if ($subscription->mobile)
                                <div class="muted-line">{{ $subscription->mobile }}</div>
                            @endif
                        </td>

                        <td>
                            @if ($subscription->items->isNotEmpty())
                                <details class="domain-details">
                                    <summary>View {{ $domainGroups->count() }} domain(s)</summary>
                                    <div class="muted-line">{{ $subscription->items->count() }} service(s)</div>
                                    <div class="domain-list">
                                        @foreach ($domainGroups as $domainName => $domainItems)
                                            @php
                                                $domainIsActive = $domainItems->every(
                                                    fn ($item) => $item->domain_status === 'active'
                                                );
                                            @endphp
                                            <div class="domain-box">
                                                <div class="domain-heading">
                                                    <div class="domain-title">{{ $domainName ?: 'No domain assigned' }}</div>
                                                    <span class="status-pill {{ $domainIsActive ? 'status-active' : 'status-other' }}">
                                                        {{ $domainIsActive ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>

                                                @if ($domainName !== '' && $hasDomainStatusRoute && auth()->user()?->role === 'admin')
                                                    <form class="domain-status-form" method="POST"
                                                          action="{{ route('admin.subscriptions.domains.status', $subscription->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="domain_name" value="{{ $domainName }}">
                                                        <label class="visually-hidden" for="domain-status-{{ $subscription->id }}-{{ $loop->index }}">Domain status</label>
                                                        <select id="domain-status-{{ $subscription->id }}-{{ $loop->index }}"
                                                                class="form-select form-select-sm" name="status">
                                                            <option value="active" @selected($domainIsActive)>Active</option>
                                                            <option value="inactive" @selected(!$domainIsActive)>Inactive</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                                                    </form>
                                                @endif

                                                <table class="service-list">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Category</th>
                                                            <th scope="col">Service</th>
                                                            <th scope="col">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($domainItems as $item)
                                                            <tr>
                                                                <td>
                                                                    {{ $categoryNames[$item->subscription_category_id] ?? 'Category #'.$item->subscription_category_id }}
                                                                </td>
                                                                <td>
                                                                    {{ $serviceNames[$item->service_type_id] ?? 'Service #'.$item->service_type_id }}
                                                                </td>
                                                                <td>₹{{ number_format((float) $item->price, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2">Domain Total</td>
                                                            <td>₹{{ number_format((float) $domainItems->sum('price'), 2) }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            @else
                                <span class="muted-line">No services</span>
                            @endif
                        </td>

                        <td class="fw-semibold">₹{{ number_format((float) $subscription->total_amount, 2) }}</td>
                        <td>₹{{ number_format($paidAmount, 2) }}</td>
                        <td>
                            @if ($dueAmount > 0)
                                <span class="text-danger">₹{{ number_format($dueAmount, 2) }}</span>
                            @else
                                <span class="text-success">Paid</span>
                            @endif
                        </td>
                        <td>{{ $subscription->purchase_date ? \Illuminate\Support\Carbon::parse($subscription->purchase_date)->format('d M Y') : '—' }}</td>
                        <td>{{ $expiry ? $expiry->format('d M Y') : '—' }}</td>
                        <td>
                            @if ($daysLeft === null)
                                —
                            @elseif ($daysLeft < 0)
                                <span class="text-danger">Expired</span>
                            @else
                                {{ $daysLeft }} Days
                            @endif
                        </td>
                        <td><span class="status-pill {{ $statusClass }}">{{ $statusText }}</span></td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                <ul class="dropdown-menu">
                                    @if ($hasShowRoute)
                                        <li><a class="dropdown-item"
                                               href="{{ route('admin.subscriptions.show', $subscription->id) }}">View</a></li>
                                    @endif

                                    @if ($hasEditRoute)
                                        <li><a class="dropdown-item"
                                               href="{{ route('admin.subscriptions.edit', $subscription->id) }}">Edit</a></li>
                                    @endif

                                    @if ($hasRenewRoute && $daysLeft !== null && $daysLeft <= $renewBeforeDays)
                                        <li><a class="dropdown-item"
                                               href="{{ route('admin.renewals.create', ['subscription_id' => $subscription->id]) }}">Renew</a></li>
                                    @endif

                                    @if ($hasPaymentRoute && $dueAmount > 0)
                                        <li><a class="dropdown-item"
                                               href="{{ route('admin.subscription-payments.create', ['subscription_id' => $subscription->id]) }}">Pay Now</a></li>
                                    @endif

                                    @if ($hasDestroyRoute)
                                        <li>
                                            <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}"
                                                  method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-5">
                            <div class="client-name mb-1">No subscriptions found</div>
                            <div class="muted-line">Add a subscription to get started.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($subscriptions, 'links') && $subscriptions->hasPages())
        <div class="mt-4">{{ $subscriptions->links() }}</div>
    @endif
</div>
@endsection


