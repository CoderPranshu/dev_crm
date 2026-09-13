@php
    $productionOrders = DB::table('production_orders')->get();
    $products = DB::table('products')->get();
    $warehouses = DB::table('branches')->get();
    $productionConsumption = DB::table('production_consumptions')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.productionconsumption.update', $productionConsumption->id) }}" method="POST">
    @Csrf
    <!-- Production Order -->
    <div class="mb-3">
        <label for="production_order_id" class="eForm-label">Production Order</label>
        <select name="production_order_id" id="production_order_id" class="eForm-control form-control" required>
            <option value="">Select Production Order</option>
            @foreach ($productionOrders as $order)
                <option value="{{ $order->id }}" {{ $productionConsumption->production_order_id == $order->id ? 'selected' : '' }}>
                    #{{ $order->production_no }} — {{ $order->reference ?? 'Order' }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Raw Product -->
    <div class="mb-3">
        <label for="raw_product_id" class="eForm-label">Raw Product</label>
        <select name="raw_product_id" id="raw_product_id" class="eForm-control form-control" required>
            <option value="">Select Raw Material</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ $productionConsumption->raw_product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Quantity Used -->
    <div class="mb-3">
        <label for="quantity_used" class="eForm-label">Quantity Used</label>
        <input type="number" step="0.0001" name="quantity_used" id="quantity_used" class="eForm-control form-control" required value="{{ $productionConsumption->quantity_used }}">
    </div>

    <!-- Warehouse (Optional) -->
    <div class="mb-3">
        <label for="warehouse_id" class="eForm-label">Warehouse (Optional)</label>
        <select name="warehouse_id" id="warehouse_id" class="eForm-control form-control">
            <option value="">Select Warehouse</option>
            @foreach ($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}" {{ $productionConsumption->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->title }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn-form w-100 btn-primary">{{ get_phrase('Update') }}</button>
</form>
