<a href="{{ route('admin.candidate.sample.csv') }}" class="export_btn_primary">
    Download Sample CSV
</a>

<form action="{{ route('admin.candidate.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="">

        <div class="modal-body">
            <div class="mb-3">
                <label class="eForm-label">Choose CSV File</label>
                <input type="file" name="file" class="form-control eForm-control" accept=".csv" required>
            </div>
        </div>

        <div class="">
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </div>
    </div>
</form>
