<form action="{{ route('admin.vendor.return.request.auto', [$id, $vendorid]) }}" method="POST">
    @csrf
    <input type="hidden" value="{{ $replacedqty }}" name="replaceqty">
    <div class="form-group">
        <label for="" class="eForm-label">Note</label>
        <textarea name="note" id="" cols="30" rows="4" class="form-control eForm-control"></textarea>
    </div>

    <div class="form-group">
        <button class="btn-form mt-2 w-100" type="submit">Submit</button>
    </div>
</form>
