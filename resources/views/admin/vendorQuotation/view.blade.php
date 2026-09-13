@extends('index')
@push('title', get_phrase('Quotation Detail'))
@section('content')

<div class="container">

    <h3 class="eForm-label">Quotation Detail</h3>

    <div class="card mb-3 p-3">
        <p class="eForm-label"><strong>Quotation No:</strong> {{ $quotation->quotation_number }}</p>
        <p class="eForm-label"><strong>Vendor:</strong> {{ $quotation->vendor->name }}</p>
        <p class="eForm-label"><strong>Status:</strong> {{ $quotation->status }}</p>
        <p class="eForm-label"><strong>Total Amount:</strong> ₹{{ $quotation->total_amount }}</p>
        <p class="eForm-label"><strong>Note:</strong> {{ $quotation->note }}</p>
    </div>

    <h5 class="eForm-label">Items</h5>

<div class="card">
    <div class="card-body">
            <table class="table table-bordered">
        <thead>
            <tr class="eForm-label">
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Delivery Days</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
            <tr class="eForm-label">
                <td>
                    {{ $item->product->name ?? $item->product_id }}
                </td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ $item->price }}</td>
                <td>{{ $item->delivery_days }} Days</td>
                <td>₹{{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <strong class="eForm-label">Grand Total: ₹{{ $quotation->total_amount }}</strong>
    </div>

    {{-- OPTIONAL ACTIONS (next phase use) --}}
    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

        {{-- Future buttons --}}
        {{-- <a href="#" class="btn btn-success">Approve</a>
        <a href="#" class="btn btn-danger">Reject</a> --}}
    </div>
    </div>
</div>

</div>

@endsection
