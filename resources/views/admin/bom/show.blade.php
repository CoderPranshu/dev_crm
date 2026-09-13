@extends('index')
@push('title', get_phrase('BOM'))
@push('meta')
@endpush
@push('css')
<style>
    .detail{
        font-size: 13px;
        font-weight: 500;
        color: rgb(158, 158, 158);
    }
</style>
@endpush

@section('content')




    <div class="container">

        <div class="card p-3 border-0 shadow-sm">
            <div class="mainSection-title mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                    <div class="d-flex flex-column">
                        <h4>{{ get_phrase('BOM Detail Page') }}</h4>
                        <ul class="d-flex align-items-center eBreadcrumb-2">
                            <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                            <li><a href="{{ route('admin.bom.index') }}">{{ get_phrase('BOM') }}</a></li>
                            <li><a href="#">{{ get_phrase('Detail page') }}</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="card border-0">
            <div class="card-header mainSection-title" style="background-color: #f5f5ff;">
                <h4 class="mb-0">{{ get_phrase('Bill of Materials') }}</h4>
            </div>

            <div class="card-body mainSection-title">

                <!-- Product Information -->
                <h4 class="mb-3" style="border-bottom: 1px solid black;">{{ get_phrase('Product Information') }}</h4>
                <div class="row mb-4 p-2">
                    <div class="col-md-4">
                        <label class="eForm-label">Product Name</label>
                        <p class="detail">{{ $bom->product->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="eForm-label">SKU</label>
                        <p class="detail">{{ $bom->product->sku }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="eForm-label">Unit</label>
                        <p class="detail">{{ $bom->product->unit }}</p>
                    </div>
                </div>

                <!-- BOM Details -->
                <h4 class="mb-3" style="border-bottom: 1px solid black;">{{ get_phrase('BOM Details') }}</h4>
                <div class="row mb-4 p-2">
                    <div class="col-md-4">
                        <label class="eForm-label">Version</label>
                        <p class="detail">{{ $bom->version }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="eForm-label">Status</label>
                        <p class="detail"><span class="badge bg-success">Active</span></p>
                    </div>
                    <div class="col-md-4">
                        <label class="eForm-label">Notes</label>
                        <p class="detail">{{ $bom->notes }}</p>
                    </div>
                </div>

                <!-- BOM Items Table -->
                <h4 class="mb-3" style="border-bottom: 1px solid black;">{{ get_phrase('Raw Materials') }}</h4>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Raw Product ID</th>
                                <th>Quantity</th>
                                <th>Wastage %</th>
                                {{-- <th>Notes</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bom->items as $item)
                                 <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name  }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->wastage_percent }}</td>
                                {{-- <td>{{ $item->notes }}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>


    @stop
