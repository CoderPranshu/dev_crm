@php
    $vendor = DB::table('vendors')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.vendor.rating',$vendor->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="" class="eForm-label">{{ get_phrase('Rating') }}</label>
            <select name="rating" class="eForm-control form-control" id="">
                <option value="">--Select rating--</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Note') }}</label>
            <textarea name="note" class="form-control eForm-control" id="" cols="30" rows="3"></textarea>
        </div>

        <div class="col-md-12">
            <button class="btn-form btn-primary w-100 mt-2" type="submit">{{ get_phrase('Submit') }}</button>
        </div>
    </div>
</form>
