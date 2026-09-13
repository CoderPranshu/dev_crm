@extends('index')

@section('title', $project->project_name)

@push('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


<style>
    .project-header-card{

background:#fff;

padding:30px;

border-radius:15px;

box-shadow:0 10px 25px rgba(0,0,0,.05);

}

.project-icon{

width:70px;

height:70px;

background:#0d6efd;

color:#fff;

border-radius:15px;

display:flex;

align-items:center;

justify-content:center;

font-size:28px;

}

.project-title{

font-weight:700;

margin-bottom:5px;

}

.project-client{

margin:0;

color:#6c757d;

}

.summary-card{

background:#fff;

border-radius:15px;

padding:20px;

display:flex;

align-items:center;

gap:18px;

box-shadow:0 8px 20px rgba(0,0,0,.05);

height:100%;

}

.summary-icon{

width:55px;

height:55px;

border-radius:12px;

display:flex;

align-items:center;

justify-content:center;

color:#fff;

font-size:22px;

}

/* ===============================
PROJECT INFORMATION
=============================== */

.info-box{

    background:#f8f9fa;

    border:1px solid #ececec;

    border-radius:10px;

    padding:18px;

    height:100%;

}

.info-box label{

    display:block;

    font-size:13px;

    color:#6c757d;

    margin-bottom:8px;

    font-weight:600;

}

.info-box p{

    margin:0;

    font-size:15px;

    font-weight:600;

    color:#212529;

}

.card-header h5{

    font-weight:700;

}

/* ===================================
MODULES
=================================== */

.module-item{

    background:#fff;

    border:1px solid #e9ecef;

    border-radius:12px;

    padding:20px;

    margin-bottom:20px;

    transition:.3s;

}

.module-item:last-child{

    margin-bottom:0;

}

.module-item:hover{

    border-color:#0d6efd;

    box-shadow:0 8px 20px rgba(13,110,253,.08);

}

.module-item h6{

    font-weight:600;

    margin-bottom:5px;

}

.module-item .progress{

    background:#edf2f7;

    border-radius:30px;

}

.module-item .progress-bar{

    border-radius:30px;

}

/* ===================================
ATTACHMENTS
=================================== */

.attachment-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:18px;

    border:1px solid #e9ecef;

    border-radius:12px;

    margin-bottom:15px;

    transition:.3s;

    background:#fff;

}

.attachment-item:last-child{

    margin-bottom:0;

}

.attachment-item:hover{

    border-color:#0d6efd;

    box-shadow:0 8px 20px rgba(13,110,253,.08);

}

.attachment-left{

    display:flex;

    align-items:center;

    gap:15px;

}

.attachment-icon{

    width:50px;

    height:50px;

    border-radius:12px;

    background:#f8f9fa;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

}

.attachment-item h6{

    margin:0;

    font-size:15px;

    font-weight:600;

}

.attachment-item small{

    color:#6c757d;

}

@media(max-width:768px){

    .attachment-item{

        flex-direction:column;

        align-items:flex-start;

        gap:15px;

    }

    .attachment-item .btn{

        width:100%;

    }

}
/* ===================================
CHAT CARD
=================================== */

.chat-circle{

    width:90px;

    height:90px;

    margin:auto;

    border-radius:50%;

    background:#0d6efd;

    color:#fff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:34px;

    box-shadow:0 12px 30px rgba(13,110,253,.25);

}

.card{

    border-radius:16px;

}

.progress{

    border-radius:30px;

}

.progress-bar{

    border-radius:30px;

}

.btn{

    border-radius:10px;

}

.badge{

    border-radius:20px;

    padding:8px 15px;

}

body{

    background:#f5f7fb;

}

@media(max-width:768px){

    .project-header-card{

        padding:20px;

    }

    .project-title{

        font-size:24px;

    }

    .summary-card{

        margin-bottom:15px;

    }

    .chat-circle{

        width:70px;

        height:70px;

        font-size:28px;

    }

}
</style>
@endpush

@section('content')

<div class="container-fluid py-4">

    <div class="row">

        <div class="col-12">

            <div class="project-header-card">

                <div class="row align-items-center">

                    <div class="col-lg-8">

                        <div class="d-flex align-items-center">

                            <div class="project-icon">

                                <i class="fa-solid fa-diagram-project"></i>

                            </div>

                            <div class="ms-3">

                                <h2 class="project-title2" style="font-size: 25px;">

                                    {{ $project->project_name }}

                                </h2>

                                <p class="project-client">

                                    <i class="fa-solid fa-user"></i>

                                    {{ $project->client_name }}

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                        @php

                            $statusClass = match($project->status){

                                'Completed' => 'success',

                                'In Progress' => 'primary',

                                'Pending' => 'warning',

                                'Cancelled' => 'danger',

                                default => 'secondary'

                            };

                        @endphp

                        <span class="badge bg-{{ $statusClass }} px-3 py-2">

                            {{ $project->status }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ============================= --}}
    {{-- SUMMARY CARDS --}}
    {{-- ============================= --}}

    <div class="row mt-4">

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="summary-card">

                <div class="summary-icon bg-primary">

                    <i class="fa-solid fa-bars-progress"></i>

                </div>

                <div>

                    <small>Overall Progress</small>

                    <h4>{{ $overallProgress }}%</h4>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="summary-card">

                <div class="summary-icon bg-success">

                    <i class="fa-solid fa-layer-group"></i>

                </div>

                <div>

                    <small>Total Modules</small>

                    <h4>{{ $project->modules->count() }}</h4>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="summary-card">

                <div class="summary-icon bg-warning">

                    <i class="fa-solid fa-paperclip"></i>

                </div>

                <div>

                    <small>Attachments</small>

                    <h4>{{ $project->attachments->count() }}</h4>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="summary-card">

                <div class="summary-icon bg-danger">

                    <i class="fa-solid fa-calendar-days"></i>

                </div>

                <div>

                    <small>Deadline</small>

                    <h6>

                        {{ $project->deadline
                            ? \Carbon\Carbon::parse($project->deadline)->format('d M Y')
                            : 'N/A' }}

                    </h6>

                </div>

            </div>

        </div>

    </div>

    {{-- ============================= --}}
    {{-- PROGRESS --}}
    {{-- ============================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">

                <strong>Project Progress</strong>

                <strong>{{ $overallProgress }}%</strong>

            </div>

            <div class="progress" style="height:12px;">

                <div class="progress-bar bg-primary"

                     style="width:{{ $overallProgress }}%">

                </div>

            </div>

        </div>

    </div>

        {{-- ========================================= --}}
    {{-- PROJECT INFORMATION --}}
    {{-- ========================================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="mb-0">

                <i class="fa-solid fa-circle-info text-primary me-2"></i>

                Project Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-lg-6">

                    <div class="info-box">

                        <label>Client Name</label>

                        <p>{{ $project->client_name }}</p>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="info-box">

                        <label>Lead Developer</label>

                        <p>

                            {{ $project->assignedTo->name ?? 'Not Assigned' }}

                        </p>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="info-box">

                        <label>Department</label>

                        <p>

                            {{ $project->department->title ?? 'N/A' }}

                        </p>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="info-box">

                        <label>Priority</label>

                        <p>

                            @php

                                $priorityColor = match($project->priority){

                                    'Critical' => 'danger',

                                    'High' => 'warning',

                                    'Medium' => 'info',

                                    default => 'secondary'

                                };

                            @endphp

                            <span class="badge bg-{{ $priorityColor }}">

                                {{ $project->priority }}

                            </span>

                        </p>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="info-box">

                        <label>Start Date</label>

                        <p>

                            {{ $project->start_date
                                ? \Carbon\Carbon::parse($project->start_date)->format('d M Y')
                                : 'N/A' }}

                        </p>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="info-box">

                        <label>Deadline</label>

                        <p>

                            {{ $project->deadline
                                ? \Carbon\Carbon::parse($project->deadline)->format('d M Y')
                                : 'N/A' }}

                        </p>

                    </div>

                </div>

                <div class="col-12">

                    <div class="info-box">

                        <label>Project Description</label>

                        <p class="mb-0">

                            {{ $project->project_description ?: 'No description available.' }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

        {{-- ========================================= --}}
    {{-- MODULES --}}
    {{-- ========================================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="mb-0">

                <i class="fa-solid fa-layer-group text-primary me-2"></i>

                Project Modules

            </h5>

        </div>

        <div class="card-body">

            @forelse($project->modules as $module)

                @php

                    $statusClass = match($module->status){

                        'Completed' => 'success',

                        'In Progress' => 'primary',

                        'Pending' => 'warning',

                        'On Hold' => 'secondary',

                        default => 'secondary'

                    };

                @endphp

                <div class="module-item">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <h6 class="mb-1">

                                {{ $module->module_name }}

                            </h6>

                            <small class="text-muted">

                                {{ $module->estimated_hours ?? 0 }} Hours Estimated

                            </small>

                        </div>

                        <span class="badge bg-{{ $statusClass }}">

                            {{ $module->status }}

                        </span>

                    </div>

                    <div class="progress mt-3" style="height:8px;">

                        <div class="progress-bar bg-primary"

                             style="width:{{ $module->progress }}%">

                        </div>

                    </div>

                    <div class="text-end mt-2">

                        <small class="text-muted">

                            {{ $module->progress }}% Completed

                        </small>

                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="fa-solid fa-layer-group fa-3x text-secondary mb-3"></i>

                    <h6>No Modules Available</h6>

                    <p class="text-muted mb-0">

                        Modules will appear here once development starts.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

        {{-- ========================================= --}}
    {{-- PROJECT ATTACHMENTS --}}
    {{-- ========================================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4">

            <h5 class="mb-0">

                <i class="fa-solid fa-paperclip text-primary me-2"></i>

                Project Attachments

            </h5>

        </div>

        <div class="card-body">

            @forelse($project->attachments as $file)

                @php

                    $extension = strtolower($file->extension);

                    if(in_array($extension,['jpg','jpeg','png','gif','webp'])){
                        $icon='fa-regular fa-image text-success';
                    }elseif(in_array($extension,['pdf'])){
                        $icon='fa-solid fa-file-pdf text-danger';
                    }elseif(in_array($extension,['doc','docx'])){
                        $icon='fa-solid fa-file-word text-primary';
                    }elseif(in_array($extension,['xls','xlsx','csv'])){
                        $icon='fa-solid fa-file-excel text-success';
                    }elseif(in_array($extension,['zip','rar'])){
                        $icon='fa-solid fa-file-zipper text-warning';
                    }else{
                        $icon='fa-solid fa-file text-secondary';
                    }

                @endphp

                <div class="attachment-item">

                    <div class="attachment-left">

                        <div class="attachment-icon">

                            <i class="{{ $icon }}"></i>

                        </div>

                        <div>

                            <h6>

                                {{ $file->original_name }}

                            </h6>

                            <small>

                                {{ strtoupper($file->extension) }}

                                •

                                {{ number_format($file->file_size / 1024,1) }} KB

                            </small>

                        </div>

                    </div>

                    <a href="{{ asset($file->file_path) }}"

                       download

                       class="btn btn-primary btn-sm">

                        <i class="fa-solid fa-download me-1"></i>

                        Download

                    </a>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="fa-solid fa-folder-open fa-3x text-secondary mb-3"></i>

                    <h6>No Attachments Found</h6>

                    <p class="text-muted mb-0">

                        No project files have been uploaded yet.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

        {{-- ========================================= --}}
    {{-- CHAT --}}
    {{-- ========================================= --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body text-center py-5">

            <div class="chat-circle">

                <i class="fa-solid fa-comments"></i>

            </div>

            <h4 class="mt-4">

                Need Help?

            </h4>

            <p class="text-muted mb-4">

                Chat directly with your Lead Developer regarding this project.

            </p>

            <a
              href="{{ route('admin.projects.chat', $project->id) }}"

              
               class="btn btn-primary px-4">

                <i class="fa-solid fa-paper-plane me-2"></i>

                Open Chat

            </a>

        </div>

    </div>

    {{-- ========================================= --}}
    {{-- BACK BUTTON --}}
    {{-- ========================================= --}}

    <div class="text-center mt-4">

        <a href="{{ route('user.projects.index') }}"
           class="btn btn-outline-secondary px-4">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Back to My Projects

        </a>

    </div>

</div>

@endsection

