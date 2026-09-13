@php
    $products = \App\Models\Product::where('category_id', '1')->get();
@endphp

<form action="{{ route('admin.advance.service.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="material" class="eForm-label">Components Required</label>
                <select name="components[]" class="form-select eForm-select select2" id="" multiple>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Description') }}</label>
                <textarea name="description" class="eForm-control" id="" cols="30" rows="4"></textarea>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <button class="btn-form w-100" type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>


@include('init')
