@php
    $vendors = \App\Models\Vendor::get();
@endphp

<form action="{{ route('admin.vendorterm.store') }}" method="POST" enctype="multipart/form-data">
    @Csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Title') }}</label>
                <input type="text" class="eForm-control form-control" name="title">
            </div>
        </div>

        <div class="col-md-12 pt-3">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Description') }}</label>
                <textarea name="description" class="eForm-control form-control" id="" cols="30" rows="3"></textarea>
            </div>
        </div>

        <div class="col-md-12 pt-3">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Document') }}</label>
                <input type="file" class="eForm-control form-control" name="doc">
            </div>
        </div>

        <div class="col-md-12 pt-3">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Vendor') }}</label>
                <select name="vendor_id" id="" class="eForm-control form-control eForm-select">
                    <option value="" disabled selected>{{ get_phrase('--Select the vendor--') }}</option>
                    @foreach ($vendors as $v)
                        <option value="{{ $v->id }}">{{ $v->user->name ?? '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12 pt-3">
            <div class="form-group">
                <button class="btn-form w-100">{{ get_phrase('Submit') }}</button>
            </div>
        </div>
    </div>
</form>
