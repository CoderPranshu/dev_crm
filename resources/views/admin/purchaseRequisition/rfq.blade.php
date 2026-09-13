@php
    $pr = DB::table('purchase_requisitions')->where('id', $id)->first();
    $vendors = App\Models\Vendor::get();

@endphp
<form action="{{ route('admin.rfq.store') }}" method="POST">
    @csrf

    <input type="hidden" name="pr_id" value="{{ $pr->id }}">

    <input type="hidden" name="branch_id" value="{{ $pr->branch_id }}">

    <div class="mb-3">
        <label class="eForm-label">Last Date</label>
        <input type="date" name="last_date" class="form-control eForm-control" required>
    </div>

    <div class="mb-3">
        <label class="eForm-label">Select Vendors</label>
        <select name="vendors[]" class="form-control eForm-select select2" multiple="multiple" required>
            @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}">
                    {{ $vendor->user->name ?? 'No Name' }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn-form w-100">Create RFQ</button>
</form>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Vendors",
            allowClear: true,
            width: '100%'
        });
    });
</script>
