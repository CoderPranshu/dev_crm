@php
    $vendors = App\Models\Vendor::get();
    $p = DB::table('purchase_requisitions')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.purchase.order', $p->id) }}" method="POST">
    @Csrf

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="" class="eForm-label">{{ get_phrase('Vendors') }}</label>
            <select class="eForm-control form-control" name="vendor_id" id="">
                <option value="">--Select Vendor--</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button class="btn-form btn-sm btn-primary w-100">Save Proforma</button>
</form>


