@php
    $categories = DB::table('categories')->get();
    $branches = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.product.store') }}" method="POST">
    @csrf

    <div class="row">

        <!-- Name -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control eForm-control" required>
        </div>

        <!-- SKU -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">SKU <span class="text-danger">*</span></label>
            <input type="text" name="sku" class="form-control eForm-control" required>
        </div>

        <!-- Category -->
        <div class="col-md-12 mb-3">
            <label for="recruitment" class="eForm-label">{{ get_phrase('Category') }}</label>
            <select name="category_id" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Unit -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Unit</label>
            <input type="text" name="unit" value="pcs" class="form-control eForm-control">
        </div>

        <!-- Cost Price -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Cost Price</label>
            <input type="number" step="1" name="cost_price" value="0" class="form-control eForm-control">
        </div>

        <!-- Sale Price -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Sale Price</label>
            <input type="number" step="1" name="sale_price" value="0" class="form-control eForm-control">
        </div>

        <!-- Opening Stock -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Opening Stock</label>
            <input type="number" step="1" name="opening_stock" value="0" class="form-control eForm-control">
        </div>

        <!-- Min Stock -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Minimum Stock Alert</label>
            <input type="number" step="1" name="min_stock" value="0" class="form-control eForm-control">
        </div>

        <!-- Is Stock Item -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Is Stock Item?</label>
            <select name="is_stock_item" class="form-control eForm-control">
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="" class="eForm-label">{{ get_phrase('Branch') }}</label>
            @if (auth()->user()->hasRole('Admin'))
                <select name="branch_id" class="form-control eForm-control" id="">
                    @foreach ($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->title }}</option>
                    @endforeach
                </select>
            @else
                <input type="text" class="form-control eForm-control" value="{{ auth()->user()->branch->title }}" readonly>
            @endif
        </div>


        <!-- Meta (JSON) -->
        {{-- <div class="col-md-12 mb-3">
            <label class="eForm-label">Meta (JSON)</label>
            <textarea name="meta" class="form-control eForm-control" rows="3"
                placeholder='{"color": "red", "size": "XL"}'></textarea>
        </div> --}}

        <div class="col-md-12 mt-3">
            <button class="btn-form btn-primary">{{ get_phrase('Add') }}</button>
        </div>

    </div>
</form>


