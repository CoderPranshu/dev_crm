@extends('index') {{-- adjust to your actual admin layout name --}}

@section('title', $module->module_name . ' - Module Workspace')

@push('css')
<style>
    :root {
        --mw-primary: #6a5cf0;
        --mw-primary-dark: #4c3fd6;
        --mw-border: #e9e8f5;
        --mw-bg-soft: #f8f8fd;
        --mw-text-muted: #8a8aa3;
        --mw-success: #17c964;
        --mw-warning: #f5a524;
        --mw-danger: #f31260;
        --mw-info: #3b82f6;
        --mw-dark: #2b2b3d;
    }

    .mw-hero {
        background: linear-gradient(120deg, var(--mw-primary) 0%, #8f7ffb 60%, #a78bfa 100%);
        border-radius: 1rem;
        padding: 1.6rem 2rem;
        color: #fff;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px -12px rgba(106, 92, 240, 0.55);
        border-left-width: 6px;
        border-left-style: solid;
    }
    .mw-hero-back { color: #fff; opacity: 0.85; font-size: 0.8rem; text-decoration: none; }
    .mw-hero-back:hover { opacity: 1; color: #fff; }
    .mw-hero-name { font-weight: 800; font-size: 1.5rem; margin: 0.3rem 0 0.5rem; }
    .mw-hero-project { font-size: 0.85rem; opacity: 0.9; }
    .mw-hero .progress { height: 8px; border-radius: 999px; background: rgba(255,255,255,0.28); margin-top: 0.75rem; }
    .mw-hero .progress-bar { background: #fff; }

    .mw-card { background: #fff; border: 1px solid var(--mw-border); border-radius: 1rem; margin-bottom: 1.5rem; box-shadow: 0 4px 14px -8px rgba(43, 43, 61, 0.08); }
    .mw-card-head { padding: 1rem 1.25rem; border-bottom: 1px solid var(--mw-border); font-weight: 700; font-size: 0.92rem; display: flex; align-items: center; gap: 0.5rem; }
    .mw-card-head i { color: var(--mw-primary); }
    .mw-card-body { padding: 1.15rem 1.25rem; }

    .badge-soft { border-radius: 999px; font-weight: 700; font-size: 0.7rem; padding: 0.34rem 0.7rem; }
    .badge-priority-critical { background: #7f1d1d; color: #fff; }
    .badge-priority-high { background: #fde3e9; color: var(--mw-danger); }
    .badge-priority-medium { background: #fff1e0; color: #d9822b; }
    .badge-priority-low { background: #e5faed; color: var(--mw-success); }
    .badge-status-pending { background: #eef0f6; color: #6b6b83; }
    .badge-status-in-progress { background: #e6f0ff; color: var(--mw-info); }
    .badge-status-completed { background: #e5faed; color: var(--mw-success); }
    .badge-status-on-hold { background: #2b2b3d; color: #fff; }
    .badge-status-cancelled { background: #fde3e9; color: var(--mw-danger); }
    .badge-status-testing { background: #f3e8ff; color: #8b5cf6; }
    .badge-status-planning { background: #e0f2fe; color: #0284c7; }
    .badge-status-generic { background: #eef0f6; color: #6b6b83; }

    .info-row { display: flex; justify-content: space-between; padding: 0.55rem 0; border-bottom: 1px solid var(--mw-border); font-size: 0.87rem; }
    .info-row:last-child { border-bottom: none; }
    .info-row span.info-label { color: var(--mw-text-muted); font-weight: 600; }
    .info-row span.info-value { color: var(--mw-dark); text-align: right; max-width: 60%; }

    .mw-tag { background: var(--mw-bg-soft); color: #52526b; border-radius: 999px; font-size: 0.72rem; padding: 0.2rem 0.6rem; }

    .sub-module-card { background: var(--mw-bg-soft); border: 1px solid var(--mw-border); border-radius: 0.7rem; padding: 0.8rem 0.9rem; margin-bottom: 0.6rem; }
    .sub-module-card:last-child { margin-bottom: 0; }
    .sub-module-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .sub-module-name { font-weight: 700; font-size: 0.87rem; }
    .sub-module-meta { display: flex; flex-wrap: wrap; gap: 0.9rem; font-size: 0.78rem; color: var(--mw-text-muted); }
    .sub-module-card .progress { height: 6px; border-radius: 999px; background: #ececf7; margin-top: 0.5rem; }

    .file-row { display: flex; align-items: center; gap: 0.85rem; padding: 0.7rem 0; border-bottom: 1px solid var(--mw-border); }
    .file-row:last-child { border-bottom: none; }
    .file-icon { width: 40px; height: 40px; border-radius: 0.6rem; background: var(--mw-bg-soft); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: var(--mw-primary); flex-shrink: 0; }
    .file-name { font-weight: 700; font-size: 0.87rem; color: var(--mw-dark); }
    .file-meta { font-size: 0.75rem; color: var(--mw-text-muted); }

    .timeline-list { list-style: none; margin: 0; padding: 0; }
    .timeline-list li { position: relative; padding-left: 2.3rem; padding-bottom: 1.1rem; }
    .timeline-list li:last-child { padding-bottom: 0; }
    .timeline-icon { position: absolute; left: 0; top: 0; width: 30px; height: 30px; border-radius: 50%; background: #eeecfe; color: var(--mw-primary); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
    .timeline-list li::after { content: ''; position: absolute; left: 14px; top: 30px; bottom: 0; width: 1px; background: var(--mw-border); }
    .timeline-list li:last-child::after { display: none; }
    .timeline-title { font-weight: 700; font-size: 0.85rem; display: block; }
    .timeline-desc { font-size: 0.8rem; color: var(--mw-text-muted); }
    .timeline-time { font-size: 0.72rem; color: var(--mw-text-muted); }

    .comment-row { display: flex; gap: 0.7rem; padding: 0.7rem 0; border-bottom: 1px solid var(--mw-border); }
    .comment-row:last-child { border-bottom: none; }
    .comment-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--mw-primary-dark); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; }
    .comment-author { font-weight: 700; font-size: 0.83rem; }
    .comment-time { font-size: 0.72rem; color: var(--mw-text-muted); }
    .comment-body { font-size: 0.85rem; color: #52526b; margin-top: 0.15rem; }

    .mw-empty { text-align: center; padding: 2rem 1rem; color: var(--mw-text-muted); }
    .mw-empty i { font-size: 2rem; color: var(--mw-primary); opacity: 0.35; margin-bottom: 0.6rem; display: block; }

    .mw-progress-slider-row { display: flex; align-items: center; gap: 0.75rem; }
    .mw-progress-slider-row .form-range { flex: 1; }
    .mw-progress-value { font-weight: 700; color: var(--mw-primary); min-width: 42px; text-align: right; }

    @media (max-width: 767.98px) {
        .mw-hero { padding: 1.4rem; }
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

    $statusBadgeClass = fn ($status) => match ($status) {
        'In Progress' => 'badge-status-in-progress',
        'Completed' => 'badge-status-completed',
        'On Hold' => 'badge-status-on-hold',
        'Cancelled' => 'badge-status-cancelled',
        'Testing' => 'badge-status-testing',
        'Planning' => 'badge-status-planning',
        'Pending' => 'badge-status-pending',
        default => 'badge-status-generic',
    };

    $progressBarClass = fn ($value) => match (true) {
        $value <= 25 => 'bg-danger',
        $value <= 50 => 'bg-warning',
        $value <= 75 => 'bg-primary',
        default => 'bg-success',
    };

    $statusOptionList = ['Pending', 'Planning', 'In Progress', 'Testing', 'Completed', 'On Hold', 'Cancelled'];
    if (!in_array($module->status, $statusOptionList)) {
        $statusOptionList[] = $module->status;
    }    
@endphp

<div class="container-fluid">
    {{-- ======================= HERO ======================= --}}
    <div class="mw-hero" data-module-color="{{ $module->color ?: '#6a5cf0' }}">
        <a href="{{ route('admin.modules.index') }}" class="mw-hero-back">
            <i class="bi bi-arrow-left"></i> Back to My Modules
        </a>
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <div class="mw-hero-name">{{ $module->module_name }}</div>
                <div class="mw-hero-project">
                    <i class="bi bi-folder2"></i> {{ $project->project_name ?? '—' }}
                    @if ($module->department)
                        &middot; <i class="bi bi-building"></i> {{ $module->department->title }}
                    @endif
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <span class="badge-soft {{ $priorityBadgeClass($module->priority) }}">{{ $module->priority }}</span>
                    <span class="badge-soft {{ $statusBadgeClass($module->status) }}">{{ $module->status }}</span>
                </div>
            </div>
            <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-outline-light">
                <i class="bi bi-box-arrow-up-right"></i> Open Project Workspace
            </a>
        </div>

        <div style="max-width: 420px;">
            <div class="d-flex justify-content-between" style="font-size:0.78rem;">
                <span>Progress</span>
                <span>{{ $module->progress }}%</span>
            </div>
            <div class="progress">
                <div class="progress-bar" data-progress-width="{{ $module->progress }}"></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- ======================= LEFT / MAIN COLUMN ======================= --}}
        <div class="col-lg-8">

            {{-- ---------------- Module Details ---------------- --}}
            <div class="mw-card">
                <div class="mw-card-head"><i class="bi bi-info-circle"></i> Module Details</div>
                <div class="mw-card-body">
                    <div class="info-row"><span class="info-label">Module Type</span><span class="info-value">{{ $module->module_type ?: '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Department</span><span class="info-value">{{ $module->department->title ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Estimated Hours</span><span class="info-value">{{ rtrim(rtrim(number_format($module->estimated_hours, 1), '0'), '.') ?: 0 }}h</span></div>
                    <div class="info-row"><span class="info-label">Actual Hours</span><span class="info-value">{{ rtrim(rtrim(number_format($module->actual_hours, 1), '0'), '.') ?: 0 }}h</span></div>
                    <div class="info-row"><span class="info-label">Start Date</span><span class="info-value">{{ $module->start_date ? \Illuminate\Support\Carbon::parse($module->start_date)->format('d M Y') : '—' }}</span></div>
                    <div class="info-row">
                        <span class="info-label">Deadline</span>
                        <span class="info-value">
                            {{ $module->deadline ? \Illuminate\Support\Carbon::parse($module->deadline)->format('d M Y') : '—' }}
                            @if ($remainingDays !== null)
                                @if ($remainingDays < 0)
                                    <span class="text-danger">({{ abs($remainingDays) }} days overdue)</span>
                                @elseif ($remainingDays === 0)
                                    <span class="text-warning">(Due today)</span>
                                @else
                                    <span class="text-muted">({{ $remainingDays }} days left)</span>
                                @endif
                            @endif
                        </span>
                    </div>
                    @if ($module->description)
                        <div class="mt-3">
                            <span class="info-label d-block mb-1">Description</span>
                            <p class="mb-0" style="font-size:0.87rem; color:#52526b;">{{ $module->description }}</p>
                        </div>
                    @endif
                    @if (!empty($module->tags))
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @foreach ($module->tags as $tag)
                                <span class="mw-tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- ---------------- Project Details ---------------- --}}
            <div class="mw-card">
                <div class="mw-card-head"><i class="bi bi-briefcase"></i> Project Details</div>
                <div class="mw-card-body">
                    <div class="info-row"><span class="info-label">Project Name</span><span class="info-value">{{ $project->project_name ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Client</span><span class="info-value">{{ $project->client_name ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Department</span><span class="info-value">{{ $project->department->title ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Lead Developer</span><span class="info-value">{{ $project->assignedTo->name ?? 'Unassigned' }}</span></div>
                    <div class="info-row"><span class="info-label">Project Deadline</span><span class="info-value">{{ $project->deadline ? \Illuminate\Support\Carbon::parse($project->deadline)->format('d M Y') : '—' }}</span></div>
                </div>
            </div>

            {{-- ---------------- Progress & Status Update ---------------- --}}
            <div class="mw-card">
                <div class="mw-card-head"><i class="bi bi-graph-up-arrow"></i> Update Progress &amp; Status</div>
                <div class="mw-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.83rem;">Progress</label>
                        <div class="mw-progress-slider-row">
                            <input type="range" class="form-range" min="0" max="100" value="{{ $module->progress }}" id="progressSlider">
                            <span class="mw-progress-value" id="progressValue">{{ $module->progress }}%</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.83rem;">Status</label>
                        <select class="form-select" id="statusSelect">
                            @foreach ($statusOptionList as $statusOption)
                                <option value="{{ $statusOption }}" @selected($module->status === $statusOption)>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" id="saveProgressBtn">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                    <p class="text-muted mt-2 mb-0" style="font-size:0.78rem;">
                        <i class="bi bi-info-circle"></i> This form isn't connected to a backend endpoint yet — see the note below the code.
                    </p>
                </div>
            </div>

            {{-- ---------------- Sub Modules ---------------- --}}
            {{-- <div class="mw-card">
                <div class="mw-card-head">
                    <span><i class="bi bi-diagram-2"></i> Sub Modules</span>
                    <span class="text-muted fw-normal ms-auto" style="font-size:0.78rem;">{{ $completedSubModules }}/{{ $totalSubModules }} completed</span>
                </div>
                <div class="mw-card-body">
                    @forelse ($module->subModules as $subModule)
                        <div class="sub-module-card">
                            <div class="sub-module-top">
                                <span class="sub-module-name">{{ $subModule->sub_module_name }}</span>
                                <span class="badge-soft {{ $statusBadgeClass($subModule->status) }}">{{ $subModule->status }}</span>
                            </div>
                            <div class="sub-module-meta">
                                <span><i class="bi bi-person"></i> {{ $subModule->assignedUser->name ?? 'Unassigned' }}</span>
                                <span class="badge-soft {{ $priorityBadgeClass($subModule->priority) }}">{{ $subModule->priority }}</span>
                                <span><i class="bi bi-clock"></i> {{ rtrim(rtrim(number_format($subModule->estimated_hours, 1), '0'), '.') ?: 0 }}h est.</span>
                                <span><i class="bi bi-clock-history"></i> {{ rtrim(rtrim(number_format($subModule->actual_hours, 1), '0'), '.') ?: 0 }}h actual</span>
                                <span><i class="bi bi-calendar-check"></i> {{ $subModule->deadline ? \Illuminate\Support\Carbon::parse($subModule->deadline)->format('d M Y') : '—' }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar {{ $progressBarClass($subModule->progress) }}" data-progress-width="{{ $subModule->progress }}"></div>
                            </div>
                        </div>
                    @empty
                        <div class="mw-empty">
                            <i class="bi bi-diagram-2"></i>
                            No sub modules under this module yet.
                        </div>
                    @endforelse
                </div>
            </div> --}}

            <div class="mw-card">

<div class="mw-card-head">

    <span>
        <i class="bi bi-diagram-2"></i>
        Sub Modules
    </span>

    <span class="ms-auto">

        {{-- <a href="{{ route('admin.submodules.create',$module->id) }}" --}}
           class="btn btn-primary btn-sm">

            <i class="bi bi-plus"></i>

            Add

        </a>

    </span>

</div>

<div class="mw-card-body">

@forelse($module->subModules as $sub)

<div class="sub-module-card">

<div class="d-flex justify-content-between">

<div>

<h6 class="mb-1">

{{ $sub->sub_module_name }}

</h6>

<small>

Assigned :

{{ optional($sub->assignedTo)->name ?? 'N/A' }}

</small>

</div>

<div>

<span class="badge bg-info">

{{ $sub->priority }}

</span>

</div>

</div>

<div class="mt-3 row">

<div class="col-md-4">

{{-- <form method="POST" action="{{ route('admin.submodules.status',$sub->id) }}">

@csrf

@method('PATCH') --}}

<select

name="status"

class="form-select form-select-sm"

onchange="this.form.submit()">

<option

{{ $sub->status=='Pending'?'selected':'' }}>

Pending

</option>

<option

{{ $sub->status=='Planning'?'selected':'' }}>

Planning

</option>

<option

{{ $sub->status=='In Progress'?'selected':'' }}>

In Progress

</option>

<option

{{ $sub->status=='Testing'?'selected':'' }}>

Testing

</option>

<option

{{ $sub->status=='Completed'?'selected':'' }}>

Completed

</option>

<option

{{ $sub->status=='On Hold'?'selected':'' }}>

On Hold

</option>

</select>

</form>

</div>

<div class="col-md-8 text-end">

<a

{{-- href="{{ route('admin.submodules.edit',$sub->id) }}" --}}

class="btn btn-warning btn-sm">

Edit

</a>

<form

{{-- action="{{ route('admin.submodules.destroy',$sub->id) }}" --}}

{{-- method="POST" --}}

class="d-inline">

{{-- @csrf --}}

{{-- @method('DELETE') --}}

<button

class="btn btn-danger btn-sm"

onclick="return confirm('Delete?')">

Delete

</button>

</form>

</div>

</div>

</div>

@empty

<div class="alert alert-info">

No Submodules Found

</div>

@endforelse

</div>

</div>

            {{-- ---------------- Attachments ---------------- --}}
            <div class="mw-card">
                <div class="mw-card-head">
                    <span><i class="bi bi-paperclip"></i> Attachments</span>
                    <span class="text-muted fw-normal ms-auto" style="font-size:0.78rem;">{{ $moduleAttachments->count() }} files</span>
                </div>
                <div class="mw-card-body">
                    @forelse ($moduleAttachments as $attachment)
                        <div class="file-row">
                            <span class="file-icon"><i class="bi bi-file-earmark-fill"></i></span>
                            <div class="flex-grow-1">
                                <div class="file-name">{{ $attachment->original_name ?? $attachment->file_name ?? 'File' }}</div>
                                <div class="file-meta">Uploaded by {{ $attachment->uploadedBy->name ?? 'Unknown' }}</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" disabled title="Wire this up once attachments are stored">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
                    @empty
                        <div class="mw-empty">
                            <i class="bi bi-paperclip"></i>
                            No attachments yet.
                        </div>
                    @endforelse

                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="uploadFileBtn">
                        <i class="bi bi-upload"></i> Upload File
                    </button>
                </div>
            </div>

            {{-- ---------------- Comments ---------------- --}}
            <div class="mw-card">
                <div class="mw-card-head"><i class="bi bi-chat-left-text"></i> Comments</div>
                <div class="mw-card-body">
                    @forelse ($moduleComments as $comment)
                        <div class="comment-row">
                            <span class="comment-avatar">{{ strtoupper(substr($comment->author->name ?? 'U', 0, 1)) }}</span>
                            <div>
                                <span class="comment-author">{{ $comment->author->name ?? 'Unknown' }}</span>
                                <span class="comment-time">&middot; {{ $comment->created_at?->diffForHumans() }}</span>
                                <div class="comment-body">{{ $comment->body }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="mw-empty">
                            <i class="bi bi-chat-left-text"></i>
                            No comments yet. Be the first to leave one.
                        </div>
                    @endforelse

                    <div class="mt-3">
                        <textarea class="form-control mb-2" id="commentBox" rows="2" placeholder="Write a comment..."></textarea>
                        <button type="button" class="btn btn-primary btn-sm" id="postCommentBtn">
                            <i class="bi bi-send"></i> Post Comment
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- ======================= RIGHT SIDEBAR ======================= --}}
        <div class="col-lg-4">

            <div class="mw-card">
                <div class="mw-card-head"><i class="bi bi-bar-chart"></i> Module Breakdown</div>
                <div class="mw-card-body">
                    <div class="info-row"><span class="info-label">Total Sub Modules</span><span class="info-value">{{ $totalSubModules }}</span></div>
                    <div class="info-row"><span class="info-label">Completed Sub Modules</span><span class="info-value">{{ $completedSubModules }}</span></div>
                    <div class="info-row"><span class="info-label">Pending Sub Modules</span><span class="info-value">{{ $pendingSubModules }}</span></div>
                </div>
            </div>

            <div class="mw-card">
                <div class="mw-card-head"><i class="bi bi-activity"></i> Activity Timeline</div>
                <div class="mw-card-body">
                    <ul class="timeline-list">
                        @forelse ($activityFeed as $activity)
                            <li>
                                <span class="timeline-icon"><i class="bi {{ $activity['icon'] }}"></i></span>
                                <span class="timeline-title">{{ $activity['label'] }}</span>
                                <span class="timeline-desc d-block">{{ $activity['description'] }}</span>
                                <span class="timeline-time">{{ $activity['at']->diffForHumans() }}</span>
                            </li>
                        @empty
                            <p class="text-muted mb-0" style="font-size:0.85rem;">No activity recorded yet.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // Apply dynamic progress-bar widths and the hero's color accent without
    // writing inline style="" in the Blade markup.
    document.querySelectorAll('[data-progress-width]').forEach(function (bar) {
        const value = parseInt(bar.dataset.progressWidth, 10) || 0;
        bar.style.width = value + '%';
    });
    document.querySelectorAll('[data-module-color]').forEach(function (hero) {
        hero.style.borderLeftColor = hero.dataset.moduleColor;
    });

    // Live progress slider label
    const slider = document.getElementById('progressSlider');
    const sliderValue = document.getElementById('progressValue');
    if (slider) {
        slider.addEventListener('input', function () {
            sliderValue.textContent = slider.value + '%';
        });
    }

    // Placeholder actions — none of these are wired to a backend endpoint yet.
    const saveBtn = document.getElementById('saveProgressBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            alert('Connect this button to a progress/status update endpoint (e.g. PATCH /developer/modules/' + '{{ $module->id }}' + ').');
        });
    }

    const uploadBtn = document.getElementById('uploadFileBtn');
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function () {
            alert('Connect this button to a module attachment upload endpoint.');
        });
    }

    const postCommentBtn = document.getElementById('postCommentBtn');
    if (postCommentBtn) {
        postCommentBtn.addEventListener('click', function () {
            const box = document.getElementById('commentBox');
            if (!box.value.trim()) return;
            alert('Connect this button to a comment-posting endpoint.');
        });
    }
});
</script>
@endpush