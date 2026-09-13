@php
    $vendors = DB::table('vendors')->get();
@endphp

<form action="{{ route('admin.vendor.contract.store') }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Title') }}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">{{ get_phrase('Vendor') }}</label>
            <select name="vendor_id" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select vendor</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->company }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="document" class="eForm-label">{{ get_phrase('Document') }}</label>
            <input type="file" name="doc" class="form-control eForm-control" id="document" />
        </div>

        {{-- <div class="col-md-12 mt-3">
            <label for="amount" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="form-control eForm-control" id="" cols="30" rows="4"></textarea>
        </div> --}}

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">Start Date</label>
            <input type="date" class="form-control eForm-control" value="{{ now()->format('Y-m-d') }}" name="start_date">
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">End Date</label>
            <input type="date" class="form-control eForm-control" name="end_date" value="{{ now()->addYear()->format('Y-m-d') }}">
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">Status</label>
            <select name="status" class="form-control eForm-control" id="">
                <option value="draft">Draft</option>
                <option value="active">Active</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
