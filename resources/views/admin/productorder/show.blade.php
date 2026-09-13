@extends('index')
@push('title', get_phrase('Production Orders'))
@push('meta')
@endpush
@push('css')

    <style>
        .detail {
            font-size: 13px;
            font-weight: 500;
            color: rgb(156, 155, 155);
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="container">
            <div class="card p-3 shadow-sm border-0">
                <div class="mainSection-title mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                        <div class="d-flex flex-column">
                            <h4>{{ get_phrase('Production Orders Detail') }}</h4>
                            <ul class="d-flex align-items-center eBreadcrumb-2">
                                <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                                <li><a href="{{ route('admin.productionorder.index') }}">{{ get_phrase('Production Orders') }}</a></li>
                                <li><a href="#">{{ get_phrase('Detail page') }}</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-header d-flex justify-content-between align-items-center mainSection-title"
                        style="background-color: #f5f5ff;">
                        <h4 class="mb-0">{{ get_phrase('Production Order') }}</h4>
                        <span class="badge bg-warning text-dark text-uppercase">{{ $productionOrder->status }}</span>
                    </div>

                    <div class="card-body mainSection-title">

                        <!-- Finished Product Info -->
                        <h4 class="mb-3" style="border-bottom: 1px solid black;">{{ get_phrase('Finished Product') }}</h4>
                        <div class="row mb-3">
                            <div class="col-4">

                                <div class="">
                                    <label for="" class="eForm-label">
                                        Product Name
                                    </label><br>
                                    <span class="detail">
                                        {{ $productionOrder->finishedProduct->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="">
                                    <label for="" class="eForm-label">
                                        SKU
                                    </label><br>
                                    <span class="detail">
                                        {{ $productionOrder->finishedProduct->sku }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="">
                                    <label for="" class="eForm-label">
                                        Quantity
                                    </label><br>
                                    <span class="detail">
                                        {{ number_format($productionOrder->quantity, 2) }}
                                    </span>
                                </div>

                            </div>

                        </div>

                        <!-- BOM Details -->
                        <h4 class="mb-3" style="border-bottom: 1px solid black;">
                            {{ get_phrase('Bill of Materials (BOM)') }}
                        </h4>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="">
                                    <label for="" class="eForm-label">
                                        BOM Version
                                    </label><br>
                                    <span class="detail">
                                        {{ $productionOrder->bom->version }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="">
                                    <label for="" class="eForm-label">
                                        Notes
                                    </label><br>
                                    <span class="detail">
                                        {{ $productionOrder->bom->notes }}
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <!-- BOM Items -->
                            <h4 class="mb-3" style="border-bottom: 1px solid black;">{{ get_phrase('BOM Items') }}</h4>
                            <table class="table eTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Raw Product ID</th>
                                        <th>Quantity per Unit</th>
                                        <th>Wastage %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productionOrder->bom->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->raw_product_id }}</td>
                                            <td>{{ number_format($item->quantity, 2) }}</td>
                                            <td>{{ $item->wastage_percent }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="mb-3">
                            @php
                                $meta = json_decode($productionOrder->meta, true);
                            @endphp

                            @if ($meta)
                                <h4 class="mb-3" style="border-bottom: 1px solid black;">
                                    {{ get_phrase('Planned Materials') }}</h4>

                                <table class="table eTable">
                                    <thead>
                                        <tr>
                                            <th>Sr. no.</th>
                                            <th>Raw Product ID</th>
                                            <th>Qty per Unit</th>
                                            <th>Wastage %</th>
                                            <th>Total Required</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meta['planned_materials'] ?? [] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['raw_product_id'] }}</td>
                                                <td>{{ number_format($item['qty_per_unit'], 2) }}</td>
                                                <td>{{ $item['wastage_percent'] }}</td>
                                                <td>{{ $item['total_required'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p></p>

                            @endif


                        </div>

                        <!-- Metadata -->
                        <h4 class="mb-3" style="border-bottom: 1px solid black;">{{ get_phrase('Other Information') }}
                        </h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="25%" class="eForm-label">Created At</th>
                                <td class="detail">{{ $productionOrder->created_at }}</td>
                            </tr>
                            <tr>
                                <th class="eForm-label">Updated At</th>
                                <td class="detail">{{ $productionOrder->updated_at }}</td>
                            </tr>

                        </table>

                    </div>

                </div>
            </div>



        </div>
    </div>

@stop
