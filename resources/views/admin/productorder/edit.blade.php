@php
    $boms = DB::table('boms')->get();
    $products = DB::table('products')->get();
    $productionOrder = DB::table('production_orders')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.productionorder.update', $productionOrder->id) }}" method="POST">
    @Csrf

    <!-- BOM -->
    <div class="mb-3">
        <label class="eForm-label">Select BOM</label>
        <select name="bom_id" id="bom_id" class="eForm-control form-control"
            {{ $productionOrder->status != 'pending' ? 'disabled' : '' }}>
            <option value="">-- Select BOM --</option>
            @foreach ($boms as $bom)
                <option value="{{ $bom->id }}" {{ $productionOrder->bom_id == $bom->id ? 'selected' : '' }}>
                    {{ $bom->name ?? 'BOM #' . $bom->id }}
                </option>
            @endforeach
        </select>
        @error('bom_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label class="eForm-label">Finished Product</label>
        <input type="text" id="finished_product_name" class="eForm-control form-control"
            value="{{ $productionOrder->finishedProduct->name ?? '' }}" readonly>
        <input type="hidden" name="finished_product_id" id="finished_product_id"
            value="{{ $productionOrder->finished_product_id }}">
    </div>

    <div class="mb-3">
        <label class="eForm-label">Production Quantity</label>
        <input type="number" step="0.0001" name="quantity" class="eForm-control form-control"
            value="{{ $productionOrder->quantity }}" {{ $productionOrder->status != 'pending' ? 'readonly' : '' }}>
        @error('quantity')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    @if ($productionOrder->status == 'pending')
        <button type="submit" class="btn-form btn-primary w-100">Update Production Order</button>
    @else
        <div class="alert alert-warning text-center">
            This production order cannot be edited because it is
            <strong>{{ strtoupper($productionOrder->status) }}</strong>.
        </div>
    @endif
</form>

