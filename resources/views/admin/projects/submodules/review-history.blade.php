@extends('index')

@push('title', 'Review History')

@push('css')
<style>
.review-card{
    border:none;
    border-radius:12px;
    box-shadow:0 4px 18px rgba(0,0,0,.06);
}

.review-timeline{
    list-style:none;
    padding-left:0;
    margin:0;
    position:relative;
}

.review-timeline::before{
    content:"";
    position:absolute;
    left:18px;
    top:4px;
    bottom:4px;
    width:2px;
    background:#eef1ff;
}

.review-item{
    position:relative;
    padding-left:3rem;
    padding-bottom:1.5rem;
}

.review-item:last-child{
    padding-bottom:0;
}

.review-dot{
    position:absolute;
    left:10px;
    top:0;
    width:18px;
    height:18px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:.65rem;
    color:#fff;
}

.review-dot.approved{ background:#17c964; }
.review-dot.changes{ background:#f31260; }

.review-round-label{
    font-size:.7rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.03em;
    color:#8a8aa3;
}

.review-remark-box{
    background:#f8f8fd;
    border-radius:.6rem;
    padding:.7rem .9rem;
    margin-top:.4rem;
    font-size:.88rem;
    color:#374151;
}
</style>
@endpush

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-clock-history text-primary"></i>
                Review History
            </h3>
            <small class="text-muted">
                Module : <strong>{{ $submodule->module->module_name ?? 'N/A' }}</strong>
                &nbsp;|&nbsp;
                Sub Module : <strong>{{ $submodule->sub_module_name }}</strong>
            </small>
        </div>

        <a href="{{ route('submodules.submodules.index', $submodule->project_module_id) }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Current status --}}
    <div class="card review-card mb-4">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="text-muted small mb-1">Current Status</div>
                @include('admin.projects.submodules.partials.status-badge', ['status' => $submodule->status])
            </div>

            @if($submodule->last_reviewed_at)
                <div class="text-end">
                    <div class="text-muted small">Last reviewed</div>
                    <div class="fw-semibold">
                        {{ $submodule->lastReviewer->name ?? 'Unknown' }}
                        &middot;
                        {{ $submodule->last_reviewed_at->diffForHumans() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Timeline --}}
    <div class="card review-card">
        <div class="card-header bg-white border-0 pt-3">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-list-check me-2 text-primary"></i>
                All Reviews ({{ $reviews->count() }})
            </h6>
        </div>

        <div class="card-body">
            @forelse($reviews as $review)
                <ul class="review-timeline">
                    <li class="review-item">
                        <span class="review-dot {{ $review->decision === 'Approved' ? 'approved' : 'changes' }}">
                            <i class="bi {{ $review->decision === 'Approved' ? 'bi-check-lg' : 'bi-x-lg' }}"></i>
                        </span>

                        <div class="review-round-label">Review #{{ $review->review_round }}</div>

                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge {{ $review->decision === 'Approved' ? 'bg-success' : 'bg-danger' }}">
                                {{ $review->decision }}
                            </span>
                            <span class="text-muted small">
                                by {{ $review->reviewer->name ?? 'Unknown' }}
                                &middot;
                                {{ $review->created_at->format('d M Y, h:i A') }}
                            </span>
                        </div>

                        @if($review->remarks)
                            <div class="review-remark-box">
                                {{ $review->remarks }}
                            </div>
                        @endif
                    </li>
                </ul>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    No reviews yet. This sub module hasn't been reviewed.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
