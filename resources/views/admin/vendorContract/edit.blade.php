@php
    $vendors = DB::table('vendors')->get();
    $vendorContract = DB::table('vendor_contracts')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.vendor.contract.update', $vendorContract->id) }}" method="post"
    enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Title') }}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title"
                value="{{ $vendorContract->title }}" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">{{ get_phrase('Vendor') }}</label>
            <select name="vendor_id" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select vendor</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}"
                        {{ $vendorContract->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->company }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="document" class="eForm-label">{{ get_phrase('Document') }}</label>
            <input type="file" name="doc" class="form-control eForm-control" id="document" />
            @if ($vendorContract->doc)
                <a class="eForm-label text-info" href="{{ asset('uploads/vendorcont/' . $vendorContract->doc) }}"
                    target="_blank">View current document</a>
            @endif
        </div>

        {{-- <div class="col-md-12 mt-3">
            <label for="amount" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="form-control eForm-control" id="" cols="30" rows="4">{{ $vendorContract->description }}</textarea>
        </div> --}}


        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">Start Date</label>
            <input type="date" class="form-control eForm-control" value="{{ $vendorContract->start_date }}"
                name="start_date">
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">End Date</label>
            <input type="date" class="form-control eForm-control" name="end_date"
                value="{{ $vendorContract->end_date }}">
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">Status</label>
            <select name="status" class="form-control eForm-control" id="">
                <option value="draft" {{ $vendorContract->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ $vendorContract->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="active" {{ $vendorContract->status == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="active" {{ $vendorContract->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
