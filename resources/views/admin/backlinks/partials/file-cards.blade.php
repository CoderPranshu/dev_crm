{{-- Include above your existing backlinks table. Controller must pass $uploads. --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Uploaded Files</h5>
    <a href="{{ route('admin.backlinks.upload') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-plus me-1"></i>Upload CSV / Excel</a>
</div>
<div class="row g-3 mb-4">
    @forelse($uploads as $upload)
        <div class="col-md-6 col-xl-4"><div class="card border-0 shadow-sm h-100"><div class="card-body p-4">
            <div class="d-flex gap-3 mb-3 align-items-start">
                <span class="bg-success bg-opacity-10 text-success rounded p-3"><i class="fa-solid {{ $upload->extension === 'csv' ? 'fa-file-csv' : 'fa-file-excel' }} fa-lg"></i></span>
                <div class="flex-grow-1" style="min-width:0">
                    <h6 class="mb-1 text-break">{{ $upload->original_name }}</h6>
                    <small class="text-muted">{{ strtoupper($upload->extension) }} · {{ number_format($upload->size / 1024, 1) }} KB</small>
                </div>
            </div>
            <div class="small text-muted mb-2">Category: {{ $upload->category->name ?? '—' }}</div>
            <div class="small text-muted mb-3">{{ $upload->created_at->format('d M Y, h:i A') }}</div>
            @if($upload->status === 'completed')
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-success">{{ $upload->imported }} imported</span>
                    <span class="badge bg-secondary">{{ $upload->skipped }} duplicates</span>
                    <span class="badge bg-warning text-dark">{{ $upload->invalid }} invalid</span>
                </div>
            @else
                <div class="mb-3"><span class="badge bg-warning text-dark">Awaiting column mapping</span></div>
            @endif
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.backlinks.files.open', $upload) }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye me-1"></i>Open</a>
                <a href="{{ route('admin.backlinks.files.download', $upload) }}" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-download me-1"></i>Download</a>
                @if($upload->status !== 'completed')<a href="{{ route('admin.backlinks.map', $upload) }}" class="btn btn-success btn-sm">Map & Import</a>@endif
            </div>
        </div></div></div>
    @empty
        <div class="col-12"><div class="card border-0 shadow-sm"><div class="card-body text-center text-muted py-4">No uploaded files yet.</div></div></div>
    @endforelse
</div>
{{ $uploads->appends(request()->except('files_page'))->links() }}
