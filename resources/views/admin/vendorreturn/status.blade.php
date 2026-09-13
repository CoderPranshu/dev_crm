@php
    $vendorrequest = \App\Models\VendorReturn::where('id', $id)->firstOrFail();
@endphp

<form action="{{ route('admin.vendor.return.status.update',$vendorrequest->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="" class="eForm-label">{{ get_phrase('Status') }}</label>
        <select name="status" class="form-control eForm-control" id="">
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <div class="form-group">
        <button class="btn-form my-3 w-100">{{ get_phrase('Submit') }}</button>
    </div>
</form>
