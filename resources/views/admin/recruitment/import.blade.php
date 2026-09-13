<a href="{{ route('admin.recruitment.sample.csv') }}" class="export_btn_primary mb-3">
    Download Sample CSV
</a>

<form action="{{ route('admin.recruitment.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="">

        <div class="modal-body">
            <div class="mb-3">
                <label class="eForm-label">Choose CSV File</label>
                <input type="file" name="file" class="form-control eForm-control" accept=".csv" required>
            </div>

            <div class="alert alert-info eForm-label mb-0">
                <strong>CSV Columns:</strong><br>
                title, description, department, branch, position, start_date, end_date, manager_email
            </div>
        </div>

        <div class="">
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </div>
    </div>
</form>
