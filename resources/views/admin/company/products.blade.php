@extends('index')
@push('title', get_phrase('Inventory'))
@push('meta')
@endpush
@push('css')
    <style>
        .icon-btn {
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            cursor: pointer;
        }

        .icon-btn i {
            font-size: 18px;
            /* adjust size if needed */
        }
    </style>
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Inventory') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Inventory') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">

                @php
                    $vendors = \App\Models\Company::get();
                    $selectedVendor = request()->vendor_id;

                    $selectedVendorData = \App\Models\Company::where('id', $selectedVendor)->first();
                @endphp

                <!-- Vendor Filter -->
                <form method="GET" class="mb-3">
                    <select name="vendor_id" class="form-select form-control eForm-control" onchange="this.form.submit()"
                        style="width:200px;">
                        <option value="">Select Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $selectedVendor == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <p class="column-title mb-2">{{ get_phrase('Inventory item types') }}</p>

                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ get_phrase('Type') }}</th>
                                <th>{{ get_phrase('Total Qty') }}</th>
                                <th>{{ get_phrase('Sold Qty') }}</th>
                                <th>{{ get_phrase('Replaced Qty') }}</th>
                                <th>{{ get_phrase('Available Qty') }}</th>
                                <th class="text-start">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach (App\Models\Product::where('category_id', '3')->get() as $key => $inventory)
                                @php
                                    $total = 0;

                                    // dd($selectedVendor);

                                    if ($selectedVendor) {
                                        $total = DB::table('invoice_items')
                                            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                                            ->where('invoices.customer_id', $selectedVendor)
                                            ->where('invoice_items.product_id', $inventory->id)
                                            ->sum('invoice_items.quantity');
                                    }

                                    $tt = 0;

                                    if ($selectedVendorData) {
                                        $tt = \App\Models\Warranty::where('vendor_id', $selectedVendorData->user_id)
                                            ->where('product_id', $inventory->id)
                                            ->count();
                                    }

                                    $finalQty = $total - $tt;

                                    $replacedqty = 0;

                                    if ($selectedVendorData) {
                                        $replacedqty = \App\Models\WarrantyClaim::where(
                                            'assign_to',
                                            $selectedVendorData->user_id,
                                        )
                                            ->where('product_id', $inventory->id)
                                            ->where('service_status', 'replaced')
                                            ->count();
                                    }

                                    // dd($replacedqty);

                                    // dd($selectedVendorData->user_id);

                                    // $soldQty = 0;

                                    if ($selectedVendorData) {
                                        $soldQty = \App\Models\Warranty::where(
                                            'vendor_id',
                                            $selectedVendorData->user_id,
                                        )
                                            ->where('product_id', $inventory->id)
                                            ->count();
                                    }

                                    $replacedqtyret = 0;
                                    if ($selectedVendorData) {
                                        $replacedqtyret = \App\Models\VendorReturn::where(
                                            'vendor_id',
                                            $selectedVendorData->user_id,
                                        )
                                            ->where('product_id', $inventory->id)
                                            ->where('status', '!=', 'rejected')
                                            ->sum('quantity');
                                    }

                                    $replacedItem = max(0, $replacedqty - $replacedqtyret);

                                    // dd($replacedqtyret);

                                @endphp


                                <tr>
                                    <td>{{ ++$key }}</td>

                                    <td>{{ $inventory->name }}</td>

                                    <td>
                                        {{ $finalQty ?? 0 }} @if ($finalQty > 1)
                                            {{ Str::plural($inventory->name) }}
                                        @else
                                            {{ $inventory->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $soldQty ?? 0 }} @if ($soldQty > 1)
                                            {{ Str::plural($inventory->name) }}
                                        @else
                                            {{ $inventory->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $replacedItem }} @if ($replacedItem > 1)
                                            {{ Str::plural($inventory->name) }}
                                        @else
                                            {{ $inventory->name }}
                                        @endif
                                    </td>

                                    <td>
                                        {{ $finalQty - $replacedItem - $soldQty }} @if ($total > 1)
                                            {{ Str::plural($inventory->name) }} Left
                                        @else
                                            {{ $inventory->name }} Left
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex">
                                            <a href="{{ route('admin.replaced.products', [$inventory->id, $selectedVendorData]) }}"
                                                class="btn p-0 px-1" title="Replacement Details">
                                                <i class="fi-rr-list-check"></i>
                                            </a>

                                            {{-- <form
                                                action="{{ route('admin.vendor.return.request.auto', [$inventory->id, $selectedVendorData]) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $replacedItem }}" name="replaceqty">
                                                <button type="submit" class="icon-btn ms-3">
                                                    <i class="fi-rr-exchange"></i>
                                                </button>
                                            </form> --}}

                                            @if ($replacedItem > 0)
                                                <a href="#"
                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/returnreq', 'id' => $inventory->id, 'vendorid' => $selectedVendorData, 'replacedqty' => $replacedItem]) }}', '{{ get_phrase('Create the replacement request') }}')"
                                                    class="btn btn p-0 px-1"
                                                    title="{{ get_phrase('Replacement Request') }}"
                                                    data-bs-toggle="tooltip">
                                                    <i class="fi-rr-exchange"></i>
                                                </a>
                                            @else
                                                <span data-bs-toggle="tooltip"
                                                    title="Can't make request, replacement is less than 1">

                                                    <a href="javascript:void(0);" class="btn p-0 px-1 disabled"
                                                        style="opacity: 0.5; pointer-events: none;">
                                                        <i class="fi-rr-exchange"></i>
                                                    </a>

                                                </span>
                                            @endif

                                            <a href="{{ route('admin.vendor.return.history.show', $selectedVendorData) }}"
                                                class="btn p-0 px-1" title="Show the replacement history"
                                                data-bs-toggle="tooltip">
                                                <i class="fi-rr-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if (App\Models\Inventory::count() == 0)
                                <tr>
                                    <td colspan="4" class="text-center">No data found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
