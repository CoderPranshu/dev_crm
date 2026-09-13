{{--
    Usage (Lead Developer / Admin only):
    @include('admin.projects.submodules.partials.review-actions', ['submodule' => $submodule])

    Renders nothing unless the submodule is currently "Ready For Review" —
    keeps callers simple, no @if wrapper needed at the call site.
--}}
@php
    $canReview = auth()->user()->hasRole('Admin')
        || ($submodule->module->project->assigned_to ?? null) == auth()->id();
@endphp

@if($canReview && $submodule->status === 'Ready For Review')

    <div class="d-flex gap-2">

        {{-- Approve --}}
        <form action="{{ route('admin.project-submodules.review.store', $submodule->id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="decision" value="Approved">
            <button type="submit" class="btn btn-sm btn-success"
                    onclick="return confirm('Approve this sub module? Once approved it will be locked.')">
                <i class="bi bi-check-lg"></i> Approve
            </button>
        </form>

        {{-- Request Changes — opens modal for mandatory remarks --}}
        <button type="button" class="btn btn-sm btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#changesModal-{{ $submodule->id }}">
            <i class="bi bi-x-lg"></i> Request Changes
        </button>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="changesModal-{{ $submodule->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:14px;">
                <form action="{{ route('admin.project-submodules.review.store', $submodule->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="decision" value="Changes Requested">

                    <div class="modal-header">
                        <h6 class="modal-title fw-bold">
                            Request Changes — {{ $submodule->sub_module_name }}
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label fw-bold">
                            What needs to change? <span class="text-danger">*</span>
                        </label>
                        <textarea name="remarks" rows="4" class="form-control" required
                                  placeholder="e.g. Notification badge alignment incorrect."></textarea>
                        <small class="text-muted">This remark is visible to the developer and saved permanently in the review history.</small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-lg"></i> Send Back for Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@elseif($submodule->status === 'Approved')
    <span class="text-success small fw-semibold">
        <i class="bi bi-lock-fill"></i> Approved &middot; Locked
    </span>
@elseif($submodule->status === 'Changes Requested')
    <span class="text-danger small fw-semibold">
        <i class="bi bi-arrow-repeat"></i> Waiting on developer
    </span>
@endif

<a href="{{ route('admin.project-submodules.review.history', $submodule->id) }}" class="d-inline-block mt-1 small">
    <i class="bi bi-clock-history"></i> View Review History
</a>
