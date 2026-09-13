@php
    $warehouses = DB::table('warehouses')->get();
    $products = DB::table('products')->get();
@endphp

<form action="{{ route('admin.stockmovement.store') }}" method="POST">
    @Csrf

    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Product <span class="text-danger">*</span></label>
            <select name="product_id" class="form-select form-control eForm-control" required>
                <option value="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Warehouse</label>
            <select name="warehouse_id" class="form-select form-control eForm-control">
                <option value="">Select Warehouse</option>
                @foreach ($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Movement Type <span class="text-danger">*</span></label>
            <select name="movement_type" class="form-control form-select eForm-control" required>
                <option value="">Select Type</option>
                <option value="purchase">Purchase</option>
                <option value="sale">Sale</option>
                <option value="transfer_out">Transfer Out</option>
                <option value="transfer_in">Transfer In</option>
                <option value="adjustment">Adjustment</option>
                <option value="manufacturing_consumption">Manufacturing Consumption</option>
                <option value="manufacturing_production">Manufacturing Production</option>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Quantity <span class="text-danger">*</span></label>
            <input type="number" step="0.0001" class="form-control eForm-control" name="quantity" required>
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Quantity Before</label>
            <input type="number" step="0.0001" class="eForm-control form-control" name="quantity_before" value="0">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Quantity After</label>
            <input type="number" step="0.0001" class="eForm-control form-control" name="quantity_after" value="0">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Reference Type</label>
            <input type="text" class="eForm-control form-control"
                name="reference_type"
                placeholder="Example: PurchaseOrder, SalesOrder, Transfer">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Reference ID</label>
            <input type="number" class="eForm-control form-control" name="reference_id">
        </div>

        <div class="col-md-12 mb-3">
            <label class="eForm-label">Note</label>
            <textarea name="note" class="eForm-control form-control" rows="3"></textarea>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn-form btn-primary">Save Movement</button>
        </div>
    </div>
</form>
