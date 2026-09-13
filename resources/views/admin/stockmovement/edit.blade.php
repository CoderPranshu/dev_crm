@php
    $warehouses = DB::table('warehouses')->get();
    $products = DB::table('products')->get();
    $stock = DB::table('stock_movements')->where('id',$id)->first();
@endphp

<form action="{{ route('admin.stockmovement.update', $stock->id) }}" method="POST">
    @Csrf

    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Product <span class="text-danger">*</span></label>
            <select name="product_id" class="form-select form-control eForm-control" required>
                <option value="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $stock->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Warehouse</label>
            <select name="warehouse_id" class="form-select form-control eForm-control">
                <option value="">Select Warehouse</option>
                @foreach ($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $stock->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Movement Type <span class="text-danger">*</span></label>
            <select name="movement_type" class="form-control form-select eForm-control" required>
                <option value="">Select Type</option>
                <option value="purchase" {{ $stock->movement_type == 'purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="sale" {{ $stock->movement_type == 'sale' ? 'selected' : '' }}>Sale</option>
                <option value="transfer_out" {{ $stock->movement_type == 'transfer_out' ? 'selected' : '' }}>Transfer Out</option>
                <option value="transfer_in" {{ $stock->movement_type == 'transfer_in' ? 'selected' : '' }}>Transfer In</option>
                <option value="adjustment" {{ $stock->movement_type == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                <option value="manufacturing_consumption" {{ $stock->movement_type == 'manufacturing_consumption' ? 'selected' : '' }}>Manufacturing Consumption</option>
                <option value="manufacturing_production" {{ $stock->movement_type == 'manufacturing_production' ? 'selected' : '' }}>Manufacturing Production</option>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Quantity <span class="text-danger">*</span></label>
            <input type="number" step="0.0001" class="form-control eForm-control" name="quantity" value="{{ $stock->quantity }}" required>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Quantity Before</label>
            <input type="number" step="0.0001" class="form-control eForm-control" name="quantity_before" value="{{ $stock->quantity_before }}">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Quantity After</label>
            <input type="number" step="0.0001" class="form-control eForm-control" name="quantity_after" value="{{ $stock->quantity_after }}">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Reference Type</label>
            <input type="text" class="form-control eForm-control"
                name="reference_type"
                placeholder="Example: PurchaseOrder, SalesOrder, Transfer" value="{{ $stock->reference_type }}">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Reference ID</label>
            <input type="number" class="form-control eForm-control" name="reference_id" value="{{ $stock->reference_id }}">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Note</label>
            <textarea name="note" class="form-control eForm-control" rows="3">{{ $stock->note }}</textarea>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn-form btn-primary">Update</button>
        </div>
    </div>
</form>
