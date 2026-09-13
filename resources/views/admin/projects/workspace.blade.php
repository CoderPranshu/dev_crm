@extends('index')

@push('title', get_phrase('Project Details'))

@push('css')
    <style>
        .project-card{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.3s;
    overflow:hidden;
    background:#fff;
}

.project-card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 40px rgba(67,97,238,.15);
}

.project-header{
    padding:20px 25px;
    background:linear-gradient(135deg,#4361ee,#5b7cff);
    color:#fff;
}

.project-header h4{
    margin:0;
    font-weight:700;
}

.project-body{
    padding:25px;
}

.info-box{
    border:1px solid #edf1f7;
    border-radius:14px;
    padding:18px;
    transition:.3s;
    height:100%;
}

.info-box:hover{
    border-color:#4361ee;
    box-shadow:0 8px 20px rgba(67,97,238,.08);
}

.info-title{
    font-size:13px;
    color:#8d97ad;
    margin-bottom:8px;
}

.info-value{
    font-size:16px;
    font-weight:600;
    color:#222;
}

.summary-card{
    border-radius:18px;
    padding:25px;
    background:#fff;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.summary-icon{
    width:80px;
    height:80px;
    border-radius:50%;
    background:#4361ee;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    margin:auto;
}

.progress{
    height:10px;
    border-radius:50px;
    background:#edf1f7;
}

.progress-bar{
    border-radius:50px;
}

.file-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px;
    border:1px solid #edf1f7;
    border-radius:14px;
    margin-bottom:15px;
    transition:.3s;
}

.file-item:hover{
    background:#f8faff;
    border-color:#4361ee;
}

.file-icon{
    width:50px;
    height:50px;
    border-radius:12px;
    background:#eef3ff;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#4361ee;
    font-size:22px;
}

.timeline-item{
    display:flex;
    margin-bottom:25px;
}

.timeline-icon{
    width:42px;
    height:42px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    margin-right:15px;
}

.timeline-success{
    background:#22c55e;
}

.timeline-primary{
    background:#4361ee;
}

.timeline-warning{
    background:#f59e0b;
}

.quick-btn{
    width:100%;
    border-radius:12px;
    padding:12px;
    margin-bottom:12px;
    font-weight:600;
}

.stat-box{
    border:1px solid #edf1f7;
    border-radius:15px;
    padding:20px;
    text-align:center;
    transition:.3s;
}

.stat-box:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.stat-box h3{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.stat-box small{
    color:#8d97ad;
}

.priority-low{
    background:#22c55e;
    color:#fff;
}

.priority-medium{
    background:#0ea5e9;
    color:#fff;
}

.priority-high{
    background:#f59e0b;
    color:#fff;
}

.priority-critical{
    background:#ef4444;
    color:#fff;
}

.status-pending{
    background:#f59e0b;
    color:#fff;
}

.status-progress{
    background:#4361ee;
    color:#fff;
}

.status-completed{
    background:#22c55e;
    color:#fff;
}

.status-hold{
    background:#6b7280;
    color:#fff;
}

.status-cancelled{
    background:#ef4444;
    color:#fff;
}

.sticky-sidebar{
    position:sticky;
    top:20px;
}

@media(max-width:991px){

    .sticky-sidebar{
        position:relative;
        top:0;
    }

    .summary-card{
        margin-top:20px;
    }

}

@media(max-width:767px){

    .project-header{
        text-align:center;
    }

    .file-item{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .timeline-item{
        align-items:flex-start;
    }

}
    </style>
@endpush

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h4>{{ $project->project_name }}</h4>

            <small class="text-muted">
                Project Details
            </small>

        </div>

        <div>

            <a href="{{ route('admin.projects.index') }}"
               class="btn btn-light">

                <i class="fi-rr-arrow-left"></i>

                Back

            </a>

            <a href="{{ route('admin.projects.edit',$project->id) }}"
               class="btn btn-primary">

                <i class="fi-rr-edit"></i>

                Edit

            </a>

        </div>

    </div>

</div>

<div class="row">

    {{-- Left Section --}}

    <div class="col-lg-8">

        {{-- Project Overview --}}

        <div class="eSection-wrap mb-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">

                        {{ $project->project_name }}

                    </h5>

                    <small class="text-muted">

                        Created {{ $project->created_at->diffForHumans() }}

                    </small>

                </div>

                <div>

                    @if($project->status=="Pending")

                        <span class="badge bg-warning">

                            Pending

                        </span>

                    @elseif($project->status=="In Progress")

                        <span class="badge bg-primary">

                            In Progress

                        </span>

                    @elseif($project->status=="Completed")

                        <span class="badge bg-success">

                            Completed

                        </span>

                    @elseif($project->status=="On Hold")

                        <span class="badge bg-secondary">

                            On Hold

                        </span>

                    @else

                        <span class="badge bg-danger">

                            Cancelled

                        </span>

                    @endif

                </div>

            </div>

            <div class="row text-center">

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h6 class="text-muted mb-2">

                            Priority

                        </h6>

                        @if($project->priority=="Critical")

                            <span class="badge bg-danger">

                                Critical

                            </span>

                        @elseif($project->priority=="High")

                            <span class="badge bg-warning">

                                High

                            </span>

                        @elseif($project->priority=="Medium")

                            <span class="badge bg-info">

                                Medium

                            </span>

                        @else

                            <span class="badge bg-success">

                                Low

                            </span>

                        @endif

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h6 class="text-muted mb-2">

                            Department

                        </h6>

                        <strong>

                            {{ $project->department->name ?? '-' }}

                        </strong>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h6 class="text-muted mb-2">

                            Start Date

                        </h6>

                        <strong>

                            {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}

                        </strong>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h6 class="text-muted mb-2">

                            Deadline

                        </h6>

                        <strong>

                            {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}

                        </strong>

                    </div>

                </div>

            </div>

            <hr>

            <h6 class="fw-bold mb-3">

                Project Progress

            </h6>

            <div class="progress mb-2" style="height:12px;">

                <div class="progress-bar bg-success"
                     style="width:0%;">

                </div>

            </div>

            <small class="text-muted">

                Progress will calculate automatically after modules are completed.

            </small>

        </div>

                {{-- Client Information Card (Part 2 se start hoga) --}}

    </div>





    {{-- Right Sidebar --}}

    <div class="col-lg-4">

        <div class="eSection-wrap mb-4">

            <h5 class="fw-bold mb-4">

                Project Summary

            </h5>

            <div class="text-center mb-4">

                <div style="width:80px;height:80px;background:#4361ee;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:34px;margin:auto;">

                    <i class="fi-rr-folder"></i>

                </div>

            </div>

            <table class="table table-borderless">

                <tr>

                    <th width="45%">

                        Project ID

                    </th>

                    <td>

                        #{{ $project->id }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Developer

                    </th>

                    <td>

                        {{ $project->assignedTo->name ?? '-' }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Created By

                    </th>

                    <td>

                        {{ $project->createdBy->name ?? '-' }}

                    </td>

                </tr>

                <tr>

                    <th>

                        Created

                    </th>

                    <td>

                        {{ $project->created_at->format('d M Y') }}

                    </td>

                </tr>

            </table>

        </div>

                {{-- Progress Card --}}

        <div class="eSection-wrap mb-4">

            <h5 class="fw-bold mb-3">

                Project Progress

            </h5>

            <div class="text-center">

                <h1 class="fw-bold text-success mb-2">

                    0%

                </h1>

                <div class="progress mb-3" style="height:10px;">

                    <div class="progress-bar bg-success"
                         style="width:0%;">

                    </div>

                </div>

                <small class="text-muted">

                    Progress will update automatically
                    after completing modules.

                </small>

            </div>

        </div>





        {{-- Statistics Card --}}

        <div class="eSection-wrap mb-4">

            <h5 class="fw-bold mb-4">

                Statistics

            </h5>

            <div class="row text-center">

                <div class="col-6 mb-3">

                    <div class="border rounded p-3">

                        <h3 class="mb-1">

                            0

                        </h3>

                        <small class="text-muted">

                            Modules

                        </small>

                    </div>

                </div>

                <div class="col-6 mb-3">

                    <div class="border rounded p-3">

                        <h3 class="mb-1">

                            0

                        </h3>

                        <small class="text-muted">

                            Sub Modules

                        </small>

                    </div>

                </div>

                <div class="col-6">

                    <div class="border rounded p-3">

                        <h3 class="text-success mb-1">

                            0

                        </h3>

                        <small class="text-muted">

                            Completed

                        </small>

                    </div>

                </div>

                <div class="col-6">

                    <div class="border rounded p-3">

                        <h3 class="text-warning mb-1">

                            0

                        </h3>

                        <small class="text-muted">

                            Pending

                        </small>

                    </div>

                </div>

            </div>

        </div>

        {{-- Project Attachments --}}

<div class="eSection-wrap mb-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h5 class="fw-bold mb-0">

            Project Attachments

        </h5>

        <span class="badge bg-primary">

            {{ $project->attachments->count() }} Files

        </span>

    </div>

    @forelse($project->attachments as $attachment)

        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-3">

            <div class="d-flex align-items-center">

                <div style="width:50px;height:50px;border-radius:12px;background:#eef3ff;color:#4361ee;display:flex;align-items:center;justify-content:center;font-size:22px;">

                    <i class="fi-rr-file"></i>

                </div>

                <div class="ms-3">

                    <div class="fw-bold">

                        {{ $attachment->original_name }}

                    </div>

                    <small class="text-muted">

                        {{ strtoupper($attachment->extension) }}

                        •

                        {{ number_format($attachment->file_size/1024,2) }} KB

                    </small>

                </div>

            </div>

            <div>
                <a href="{{ asset($attachment->file_path) }}"
                   target="_blank"
                   class="btn btn-light btn-sm">

                    <i class="fi-rr-eye"></i>

                </a>

                <a href="{{ asset($attachment->file_path) }}"
                   download
                   class="btn btn-primary btn-sm">

                    <i class="fi-rr-download"></i>

                </a>

            </div>

        </div>

    @empty

        <div class="text-center py-5">

            <i class="fi-rr-folder-open text-muted"
               style="font-size:50px;"></i>

            <p class="text-muted mt-3">

                No Attachments Uploaded

            </p>

        </div>

    @endforelse

</div>

{{-- Quick Actions --}}

<div class="eSection-wrap mb-4">

    <h5 class="fw-bold mb-4">

        Quick Actions

    </h5>

    <div class="d-grid gap-2">

        <a href="{{ route('admin.projects.edit',$project->id) }}"
           class="btn btn-primary">

            <i class="fi-rr-edit me-2"></i>

            Edit Project

        </a>

        <a href="#"
           class="btn btn-success">

            <i class="fi-rr-plus me-2"></i>

            Add Module

        </a>

        <a href="#"
           class="btn btn-warning">

            <i class="fi-rr-upload me-2"></i>

            Upload File

        </a>

        <a href="#"
           class="btn btn-info text-white">

            <i class="fi-rr-user me-2"></i>

            Change Developer

        </a>

    </div>

</div>

{{-- Recent Activity --}}

<div class="eSection-wrap">

    <h5 class="fw-bold mb-4">

        Recent Activity

    </h5>

    <div class="timeline">

        <div class="d-flex mb-4">
            <div>
                <span class="badge bg-success rounded-circle p-2">
                    <i class="fi-rr-check"></i>
                </span>
            </div>
            <div class="ms-3">
                <div class="fw-bold">
                    Project Created
                </div>
                <small class="text-muted">
                    {{ $project->created_at->diffForHumans() }}
                </small>
            </div>
        </div>

        <div class="d-flex mb-4">
            <div>
                <span class="badge bg-primary rounded-circle p-2">
                    <i class="fi-rr-user"></i>
                </span>
            </div>

            <div class="ms-3">
                <div class="fw-bold">
                    Assigned To\
                    {{ $project->assignedTo->name ?? '-' }}
                </div>
                <small class="text-muted">
                    Developer Assigned
                </small>
            </div>

        </div>

        <div class="d-flex">

            <div>

                <span class="badge bg-warning rounded-circle p-2">

                    <i class="fi-rr-clock"></i>

                </span>

            </div>

            <div class="ms-3">

                <div class="fw-bold">

                    Status

                    {{ $project->status }}
                </div>
                <small class="text-muted">
                    Current Project Status
                </small>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection