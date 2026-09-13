@php
    $vendor = \App\Models\Company::with('user')->get();
    $products = \App\Models\Product::where('category_id', 3)->latest()->get();
@endphp

<form action="{{ route('admin.vendor.return.store') }}" method="POST">

    @csrf

    @if (auth()->user()->hasRole('Admin'))
        <div class="form-group">
            <label for="" class="eForm-label">{{ get_phrase('Vendor') }}</label>
            <select name="vendor_id" class="form-control eForm-control" id="">
                <option value="">--Select vendor--</option>
                @foreach ($vendor as $v)
                    <option value="{{ $v->user->id ?? null}}">{{ $v->name}}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="form-group">
        <label for="" class="eForm-label">{{ get_phrase('Product') }}</label>
        <select name="product_id" class="form-control eForm-control" id="">
            @foreach ($products as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-2">
        <label for="" class="eForm-label">Quantity</label>
        <input type="number" class="form-control eForm-control" value="{{ old('quantity') }}" name="quantity">
    </div>

    <div class="form-group mt-2">
        <label for="" class="eForm-label">Reason</label>
        <select name="reason" class="eForm-control form-control" id="">
            <option value="replaced">Replaced</option>
            <option value="damaged">Damaged</option>
            <option value="defective">Defective</option>
        </select>
    </div>

    <div class="form-group mt-2">
        <label for="" class="eForm-label">Note</label>
        <textarea name="note" class="eForm-control form-control" id="" cols="30" rows="3"></textarea>
    </div>

    <div class="form-group mt-2">
        <button class="btn-form my-3 w-100">Submit</button>
    </div>
</form>
