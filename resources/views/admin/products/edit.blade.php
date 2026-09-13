@php
    $categories = DB::table('categories')->get();
    $product = DB::table('products')->where('id', $id)->first();
    $branches = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.products.update', $product->id) }}" method="POST">
    @Csrf

    <div class="row">

        <!-- Name -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control eForm-control" value="{{ $product->name }}" required>
        </div>

        <!-- SKU -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">SKU <span class="text-danger">*</span></label>
            <input type="text" name="sku" class="form-control eForm-control" value="{{ $product->sku }}" required>
        </div>

        <!-- Category -->
        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">{{ get_phrase('Category') }}</label>
            <select name="category_id" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Unit -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Unit</label>
            <input type="text" name="unit" value="{{ $product->unit }}" class="form-control eForm-control">
        </div>

        <!-- Cost Price -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Cost Price</label>
            <input type="number" step="1" name="cost_price" value="{{ $product->cost_price }}" class="form-control eForm-control">
        </div>

        <!-- Sale Price -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Sale Price</label>
            <input type="number" step="1" name="sale_price" value="{{ $product->sale_price }}" class="form-control eForm-control">
        </div>

        <!-- Opening Stock -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Opening Stock</label>
            <input type="number" step="1" name="opening_stock" value="{{ $product->opening_stock }}" class="form-control eForm-control">
        </div>

        <!-- Min Stock -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Minimum Stock Alert</label>
            <input type="number" step="1" name="min_stock" value="{{ $product->min_stock }}" class="form-control eForm-control">
        </div>

        <!-- Is Stock Item -->
        <div class="col-md-12 mb-3">
            <label class="eForm-label">Is Stock Item?</label>
            <select name="is_stock_item" class="form-control eForm-control">
                <option value="1" {{ $product->is_stock_item ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$product->is_stock_item ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="col-md-12 mb-3">
            <label for="">{{ get_phrase('Branch')}}</label>
            <select name="branch_id" class="form-control eForm-label" id="">
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}" {{ $product->branch_id == $b->id ? 'selected' : '' }}>{{ $b->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button class="btn-form btn-primary">{{ get_phrase('Update') }}</button>
        </div>

    </div>
</form>
