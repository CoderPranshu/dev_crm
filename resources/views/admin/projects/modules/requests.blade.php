@extends('index') {{-- adjust to your actual admin layout name --}}

@section('title', 'Module Requests')

@push('css')
<style>
    :root {
        --mr-primary: #6a5cf0;
        --mr-primary-dark: #4c3fd6;
        --mr-border: #e9e8f5;
        --mr-bg-soft: #f8f8fd;
        --mr-text-muted: #8a8aa3;
        --mr-success: #17c964;
        --mr-warning: #f5a524;
        --mr-danger: #f31260;
        --mr-info: #3b82f6;
        --mr-dark: #2b2b3d;
    }

    .mr-header {
        background: linear-gradient(120deg, var(--mr-primary) 0%, #8f7ffb 60%, #a78bfa 100%);
        border-radius: 1rem;
        padding: 1.6rem 2rem;
        color: #fff;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px -12px rgba(106, 92, 240, 0.55);
    }
    .mr-header h3 { font-weight: 800; margin-bottom: 0.2rem; }
    .mr-header p { opacity: 0.9; margin-bottom: 0; font-size: 0.88rem; }

    .mr-stat {
        background: #fff;
        border: 1px solid var(--mr-border);
        border-radius: 0.9rem;
        padding: 1rem 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 4px 14px -8px rgba(43, 43, 61, 0.08);
        height: 100%;
    }
    .mr-stat-icon {
        width: 42px; height: 42px; border-radius: 0.7rem; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.05rem;
    }
    .mr-stat-num { font-weight: 800; font-size: 1.2rem; line-height: 1; display: block; color: var(--mr-dark); }
    .mr-stat-label { font-size: 0.72rem; color: var(--mr-text-muted); font-weight: 600; }

    .mr-filter-bar {
        background: #fff;
        border: 1px solid var(--mr-border);
        border-radius: 1rem;
        padding: 1.1rem 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 14px -8px rgba(43, 43, 61, 0.08);
    }
    .mr-filter-bar label { font-size: 0.78rem; font-weight: 700; color: #52526b; margin-bottom: 0.3rem; }
    .mr-filter-bar .form-control, .mr-filter-bar .form-select { border-radius: 0.6rem; font-size: 0.87rem; }

    /* Request row — deliberately NOT a Bootstrap .card, just a styled panel */
    .mr-request-row {
        background: #fff;
        border: 1px solid var(--mr-border);
        border-left-width: 5px;
        border-left-style: solid;
        border-left-color: var(--mr-primary);
        border-radius: 0.9rem;
        padding: 1.2rem 1.3rem;
        margin-bottom: 1.1rem;
        box-shadow: 0 6px 18px -10px rgba(43, 43, 61, 0.12);
        transition: box-shadow .15s ease, transform .15s ease;
    }
    .mr-request-row:hover { box-shadow: 0 12px 26px -10px rgba(43, 43, 61, 0.2); transform: translateY(-2px); }

    .mr-request-top { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 0.75rem; margin-bottom: 0.6rem; }
    .mr-module-name { font-weight: 700; font-size: 1rem; color: var(--mr-dark); margin-bottom: 0.1rem; }
    .mr-project-line { font-size: 0.82rem; color: var(--mr-text-muted); }
    .mr-project-line i { margin-right: 0.25rem; }

    .badge-soft { border-radius: 999px; font-weight: 700; font-size: 0.7rem; padding: 0.34rem 0.7rem; }
    .badge-priority-critical { background: #7f1d1d; color: #fff; }
    .badge-priority-high { background: #fde3e9; color: var(--mr-danger); }
    .badge-priority-medium { background: #fff1e0; color: #d9822b; }
    .badge-priority-low { background: #e5faed; color: var(--mr-success); }
    .badge-status-pending { background: #fff1e0; color: #d9822b; }
    .badge-status-accepted { background: #e5faed; color: var(--mr-success); }
    .badge-status-rejected { background: #fde3e9; color: var(--mr-danger); }

    .mr-meta-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; margin: 0.85rem 0; }
    .mr-meta-item { background: var(--mr-bg-soft); border-radius: 0.6rem; padding: 0.5rem 0.6rem; }
    .mr-meta-item strong { display: block; font-size: 0.85rem; color: var(--mr-dark); }
    .mr-meta-item span { font-size: 0.63rem; color: var(--mr-text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em; }

    .mr-description { font-size: 0.85rem; color: #52526b; margin-bottom: 0.9rem; }

    .mr-actions { display: flex; justify-content: flex-end; gap: 0.5rem; border-top: 1px solid var(--mr-border); padding-top: 0.85rem; }
    .mr-actions .btn { border-radius: 0.5rem; font-weight: 600; font-size: 0.83rem; }
    .btn-accept { background: var(--mr-success); border-color: var(--mr-success); color: #fff; }
    .btn-accept:hover { background: #14b358; border-color: #14b358; color: #fff; }
    .btn-reject { background: #fff; border-color: var(--mr-danger); color: var(--mr-danger); }
    .btn-reject:hover { background: var(--mr-danger); border-color: var(--mr-danger); color: #fff; }

    .mr-empty-state {
        text-align: center;
        padding: 4rem 1.5rem;
        background: #fff;
        border: 2px dashed var(--mr-border);
        border-radius: 1rem;
    }
    .mr-empty-state i { font-size: 3.5rem; color: var(--mr-primary); opacity: 0.35; margin-bottom: 1rem; display: block; }
    .mr-empty-state h5 { font-weight: 700; color: var(--mr-dark); }
    .mr-empty-state p { color: var(--mr-text-muted); }

    @media (max-width: 767.98px) {
        .mr-header { padding: 1.4rem; }
        .mr-meta-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
@php
    $priorityBadgeClass = fn ($priority) => match ($priority) {
        'Critical' => 'badge-priority-critical',
        'High' => 'badge-priority-high',
        'Medium' => 'badge-priority-medium',
        default => 'badge-priority-low',
    };
@endphp

<div class="container-fluid">

    {{-- ======================= HEADER ======================= --}}
    <div class="mr-header">
        <h3><i class="bi bi-inbox me-2"></i>Module Requests</h3>
        <p>Modules waiting for your response before they land on your workload.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ======================= SUMMARY STATS ======================= --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-4">
            <div class="mr-stat">
                <span class="mr-stat-icon" style="background:var(--mr-warning);"><i class="bi bi-hourglass-split"></i></span>
                <span><span class="mr-stat-num">{{ $pendingRequestsCount }}</span><span class="mr-stat-label">Pending Requests</span></span>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="mr-stat">
                <span class="mr-stat-icon" style="background:var(--mr-success);"><i class="bi bi-check-circle"></i></span>
                <span><span class="mr-stat-num">{{ $acceptedTodayCount }}</span><span class="mr-stat-label">Accepted Today</span></span>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="mr-stat">
                <span class="mr-stat-icon" style="background:var(--mr-danger);"><i class="bi bi-x-circle"></i></span>
                <span><span class="mr-stat-num">{{ $rejectedTodayCount }}</span><span class="mr-stat-label">Rejected Today</span></span>
            </div>
        </div>
    </div>

    {{-- ======================= FILTERS ======================= --}}
    <div class="mr-filter-bar">
        <form action="{{ route('admin.modules.requests') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5 col-lg-4">
                    <label>Search Module</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by module name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 col-lg-3">
                    <label>Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All Priority</option>
                        @foreach (['Low', 'Medium', 'High', 'Critical'] as $priorityOption)
                            <option value="{{ $priorityOption }}" @selected(request('priority') === $priorityOption)>{{ $priorityOption }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label>Department</label>
                    <select name="department_id" class="form-select">
                        <option value="">All Departments</option>
                        @foreach ($departmentOptions as $department)
                            <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.modules.requests') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- ======================= REQUEST LIST ======================= --}}
    @if ($requests->isEmpty())
        <div class="mr-empty-state">
            <i class="bi bi-inbox"></i>
            <h5>No Pending Module Requests</h5>
            <p>
                @if (request()->hasAny(['search', 'priority', 'department_id']))
                    No pending requests match these filters.
                @else
                    You're all caught up — nothing is waiting for your response right now.
                @endif
            </p>
            @if (request()->hasAny(['search', 'priority', 'department_id']))
                <a href="{{ route('admin.modules.requests') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-counterclockwise"></i> Clear Filters
                </a>
            @endif
        </div>
    @else
        @foreach ($requests as $assignment)
            @php $module = $assignment->module; @endphp
            <div class="mr-request-row">
                <div class="mr-request-top">
                    <div>
                        <div class="mr-module-name">{{ $module->module_name }}</div>
                        <div class="mr-project-line">
                            <i class="bi bi-folder2"></i>{{ $module->project->project_name ?? '—' }}
                            @if ($module->module_type)
                                &middot; {{ $module->module_type }}
                            @endif
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2 align-items-start">
                        <span class="badge-soft {{ $priorityBadgeClass($module->priority) }}">{{ $module->priority }}</span>
                        <span class="badge-soft badge-status-pending">Pending</span>
                    </div>
                </div>

                @if ($module->description)
                    <div class="mr-description">{{ Str::limit($module->description, 180) }}</div>
                @endif

                <div class="mr-meta-grid">
                    <div class="mr-meta-item">
                        <strong>{{ $module->department->title ?? '—' }}</strong>
                        <span>Department</span>
                    </div>
                    <div class="mr-meta-item">
                        <strong>{{ $assignment->assignedBy->name ?? '—' }}</strong>
                        <span>Assigned By</span>
                    </div>
                    <div class="mr-meta-item">
                        <strong>{{ $assignment->assigned_at ? \Illuminate\Support\Carbon::parse($assignment->assigned_at)->format('d M Y') : '—' }}</strong>
                        <span>Assigned Date</span>
                    </div>
                    <div class="mr-meta-item">
                        <strong>{{ $module->deadline ? \Illuminate\Support\Carbon::parse($module->deadline)->format('d M Y') : '—' }}</strong>
                        <span>Deadline</span>
                    </div>
                </div>

                <div class="mr-actions">
                    <form action="{{ route('admin.modules.requests.accept', $assignment->id) }}" method="POST" onsubmit="return confirm('Accept this module assignment?');">
                        @csrf
                        <button type="submit" class="btn btn-accept">
                            <i class="bi bi-check-lg"></i> Accept
                        </button>
                    </form>

                     <form action="{{ route('admin.modules.requests.reject', $assignment->id) }}" method="POST" onsubmit="return confirm('Accept this module assignment?');">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-check-lg"></i> Rejected
                        </button>
                    </form>
                    <!-- <button type="button" class="btn btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal"
                            data-reject-action="{{ route('admin.modules.requests.reject', $assignment->id) }}"
                            data-module-name="{{ $module->module_name }}">
                        <i class="bi bi-x-lg"></i> Reject
                    </button> -->
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-2">
            {{ $requests->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

{{-- ======================= REJECT MODAL ======================= --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 1rem; border: none;">
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Reject Module Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3" style="font-size:0.87rem;">
                        You're rejecting <strong id="rejectModuleName"></strong>. You can optionally let the lead developer know why.
                    </p>
                    <label class="form-label fw-semibold" style="font-size:0.83rem;">Reason for Rejection</label>
                    <textarea name="remarks" class="form-control" rows="3" maxlength="1000" placeholder="Optional..."></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-reject">
                        <i class="bi bi-x-lg"></i> Submit Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');
    const rejectModuleName = document.getElementById('rejectModuleName');

    rejectModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        rejectForm.setAttribute('action', button.dataset.rejectAction);
        rejectModuleName.textContent = button.dataset.moduleName;
    });
});
</script>
@endpush