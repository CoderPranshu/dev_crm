@php
    $productionOrders = DB::table('production_orders')->get();
    $products = DB::table('products')->get();
    $warehouses = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.productionconsumption.store') }}" method="POST">
    @Csrf

    <div class="mb-3">
        <label class="eForm-label">Production Order</label>
        <select name="production_order_id" class="eForm-control form-control" required>
            <option value="">Select Order</option>
            @foreach ($productionOrders as $order)
                <option value="{{ $order->id }}">
                    #{{ $order->production_no }} — {{ $order->reference ?? 'Order' }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="eForm-label">Warehouse (Optional)</label>
        <select name="branch_id" class="eForm-control form-control">
            <option value="">--None--</option>
            @foreach ($warehouses as $wh)
                <option value="{{ $wh->id }}">{{ $wh->title }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn-form btn-warning w-100">Start Production (Auto Consume)</button>
</form>

