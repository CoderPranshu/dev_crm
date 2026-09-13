@extends('index')
@push('title', get_phrase('Stock Movement'))
@push('meta')
@endpush
@push('css')
    <style>
        .detail_label {
            color: rgb(160, 160, 160);
            font-size: 13px;
            font-weight: 500;
        }

        .mainSection-title h4 {
            margin-bottom: 0px;
        }
    </style>
@endpush

@section('content')
    <div class="container card p-3 border-0">

        <div class="mainSection-title">
            <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                <div class="d-flex flex-column">
                    <h4>{{ get_phrase('Stock Movement') }}</h4>
                    <ul class="d-flex align-items-center eBreadcrumb-2">
                        <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.stockmovement.index') }}">{{ get_phrase('Stock Movement') }}</a></li>
                        <li><a href="#">{{ get_phrase('Stock Movement Details') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>



        <!-- Page Title -->
        <div class="eForm-control mb-3 d-flex justify-content-between">
            <p class="eForm-label">Stock Movement Details</p>
            <button class="btn btn-primary round-3 btn-sm">{{ Str::ucfirst($stockmovement->movement_type) }}</button>

        </div>

        <!-- Movement Summary Card -->
        <div class="card mb-4">
            <div class="card-header mainSection-title" style="background-color: #f5f5ff;">
                <h4>{{ get_phrase('Movement Summary') }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 mainSection-title">
                        <label class="eForm-label">
                            Name
                        </label>
                        <p class="detail_label">{{ $stockmovement->product->name }}</p>
                    </div>
                    <div class="col-md-4 mainSection-title">

                        <label class="eForm-label">
                            Movement type
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->movement_type }}</span>

                    </div>
                    <div class="col-md-4 mainSection-title">

                        <label class="eForm-label">
                            Date & Time
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->created_at }}</span>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mainSection-title">

                        <label class="eForm-label">
                            SKU
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->product->sku }}</span>

                    </div>
                    <div class="col-md-4 mainSection-title mb-3">
                        <label class="eForm-label">
                            Unit
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->product->unit }}</span>
                    </div>
                    <div class="col-md-4 mainSection-title">

                        <label class="eForm-label">
                            Quantity
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->quantity }}</span>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mainSection-title">
                        <label class="eForm-label">
                            Quantity Before
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->quantity_before }}</span>
                    </div>
                    <div class="col-md-4 mainSection-title">

                        <label class="eForm-label">
                            Quantity After
                        </label><br>
                        <span class="detail_label">{{ $stockmovement->quantity_after }}</span>

                    </div>
                    <div class="col-md-4 mainSection-title">

                        <label class="eForm-label">
                            Refrence id
                        </label><br>
                        <span class="detail_label">PO #12345 (Purchase Order)</span>

                    </div>
                </div>

            </div>
        </div>

        <!-- Movement Summary Card -->
        <div class="row">
            <div class="col-12">

                <div class="card mb-4">
                    <div class="card-header mainSection-title" style="background-color: #f5f5ff;">
                        <h4>{{ get_phrase('Werehouse details') }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4 mainSection-title">
                                <label class="eForm-label">
                                    Name
                                </label><br>
                                <span class="detail_label">{{ $stockmovement->warehouse->name ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-4 mainSection-title">
                                <label class="eForm-label">
                                    Address
                                </label><br>
                                <span class="detail_label">{{ $stockmovement->warehouse->address ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-4 mainSection-title">
                                <label class="eForm-label">
                                    Pin code
                                </label><br>
                                <span class="detail_label">{{ $stockmovement->warehouse->code ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Card -->
        <div class="card mb-4">
            <div class="card-header mainSection-title" style="background-color: #f5f5ff;">
                <h4>{{ get_phrase('Notes') }}</h4>

            </div>
            <div class="card-body">
                <span class="detail_label">{{ $stockmovement->note }} </span>
            </div>
        </div>


    </div>
@endsection
