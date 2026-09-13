@php
    $boms = DB::table('boms')->get();
    $branches = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.productionorder.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="bom_id" class="eForm-label">Select BOM</label>
        <select name="bom_id" id="bom_id" class="eForm-label form-control" required>
            <option value="">-- Select BOM --</option>
            @foreach ($boms as $bom)
                <option value="{{ $bom->id }}">
                    {{ $bom->name ?? $bom->bom_no }}
                </option>
            @endforeach
        </select>
        @error('bom_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="eForm-label">Finished Product</label>
        <input type="text" id="finished_product_name" class="eForm-label form-control" placeholder="Select BOM first" readonly>
        <input type="hidden" name="finished_product_id" id="finished_product_id">
        @error('finished_product_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="eForm-label">Production Quantity</label>
        <input type="number" step="0.0001" name="quantity" class="eForm-label form-control" required>
        @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn-form btn-primary w-100">Create Production Order</button>
</form>

@include('productionorder')
