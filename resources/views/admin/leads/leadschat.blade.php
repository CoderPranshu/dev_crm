@php
    $lead = App\Models\Lead::findOrFail($id);

    $notes = App\Models\LeadNote::with('user')
        ->where('lead_id', $id)
        ->latest()
        ->get();
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <div class="row">
                @forelse ($notes as $key => $note)
                    <div class="col-12 mb-2">
                        <div class="card border-0 shadow-sm" style="border-left: 4px solid #4e73df;">
                            <div class="card-body py-2 px-3">

                                <div class="d-flex justify-content-between align-items-start">

                                    <!-- LEFT CONTENT -->
                                    <div class="w-100">

                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-primary me-2">#{{ $key + 1 }}</span>
                                            <small class="text-muted eForm-label">
                                                {{ $note->created_at->format('d M Y, h:i A') }}
                                            </small>
                                        </div>

                                        <div class="mb-1">
                                            <span class="eForm-label text-dark">Note:</span>
                                            <span class="ms-1 eForm-label">
                                                {{ $note->description }}
                                            </span>
                                        </div>

                                        <div class="d-flex flex-wrap gap-3">

                                            <div>
                                                <span class="eForm-label text-muted">Next:</span>
                                                <span class="ms-1 eForm-label">
                                                    {{ $note->call_date
                                                        ? \Carbon\Carbon::parse($note->call_date)->format('d M Y, h:i A')
                                                        : 'N/A' }}
                                                </span>
                                            </div>

                                            <div>
                                                <span class="eForm-label text-muted">By:</span>
                                                <span class="ms-1 fw-semibold eForm-label">
                                                    {{ $note->user->name ?? 'N/A' }}
                                                </span>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-3">
                        No call history found
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
