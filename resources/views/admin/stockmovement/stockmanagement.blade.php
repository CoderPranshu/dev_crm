@extends('index')
@push('title', get_phrase('Stock Check'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Stock Check') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Stock Check') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Stock Check') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Product') }}</th>
                                <th class="">{{ get_phrase('Warehouse') }}</th>

                                <th class="">{{ get_phrase('Stock Left') }}</th>
                                <th class="">{{ get_phrase('Minimum Stock') }}</th>

                                <th class="text-center">{{ get_phrase('Record Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $key => $stock)
                                @php
                                    $isLow = $stock->product && $stock->quantity_after <= $stock->product->min_stock;
                                @endphp

                                <tr class="{{ $isLow ? 'table-danger' : '' }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $stock->product->name ?? 'N/A' }}
                                        @if ($isLow)
                                            <span class="badge bg-danger ms-2">LOW STOCK</span>
                                        @endif
                                    </td>
                                    <td>{{ $stock->warehouse->name ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ $stock->quantity_after }}</strong>
                                    </td>
                                    <td>{{ $stock->product->min_stock ?? 0 }}</td>
                                    <td>
                                        @if ($isLow)
                                            <span class="text-danger fw-bold">Reorder Required</span>
                                        @else
                                            <span class="text-success fw-bold">Safe</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
