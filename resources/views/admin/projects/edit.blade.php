@extends('index')

@push('css')
<style>
    /* ===============================
   Project Edit Page
==================================*/

body{
    background:#f5f7fb;
}

/* Card */
.project-edit-card{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 35px rgba(0,0,0,.06);
    overflow:hidden;
}

.project-edit-header{
    background:#fff;
    border-bottom:1px solid #ececec;
    padding:22px 30px;
}

.project-edit-header h4{
    font-weight:700;
    margin:0;
    color:#1f2937;
}

.project-edit-body{
    padding:35px;
}

/* Labels */

.form-label{
    font-weight:600;
    color:#374151;
    margin-bottom:8px;
    font-size:14px;
}

/* Inputs */

.form-control,
.form-select{
    border:1px solid #d8dee9;
    border-radius:12px;
    height:48px;
    box-shadow:none;
    transition:.3s;
    font-size:14px;
}

textarea.form-control{
    min-height:130px;
    resize:none;
}

.form-control:focus,
.form-select:focus{
    border-color:#4f8cff;
    box-shadow:0 0 0 .18rem rgba(79,140,255,.15);
}

/* Readonly */

.form-control[readonly]{
    background:#f8fafc;
    color:#6b7280;
}

/* Badge */

.project-info{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:25px;
}

.project-info span{
    background:#eef5ff;
    color:#2f6fed;
    padding:7px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

/* Divider */

.section-title{
    font-size:17px;
    font-weight:700;
    color:#111827;
    margin-bottom:20px;
    padding-bottom:10px;
    border-bottom:1px solid #ececec;
}

/* Buttons */

.btn-save{
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:12px;
    padding:11px 28px;
    font-weight:600;
    transition:.3s;
}

.btn-save:hover{
    background:#1d4ed8;
    color:#fff;
    transform:translateY(-2px);
}

.btn-cancel{
    background:#fff;
    color:#374151;
    border:1px solid #d1d5db;
    border-radius:12px;
    padding:11px 28px;
    font-weight:600;
    transition:.3s;
}

.btn-cancel:hover{
    background:#f3f4f6;
    color:#111827;
}

/* Footer */

.project-edit-footer{
    padding:20px 35px;
    border-top:1px solid #ececec;
    background:#fff;
}

/* Validation */

.invalid-feedback{
    font-size:13px;
}

/* Required */

.required{
    color:#ef4444;
    margin-left:3px;
}

/* Responsive */

@media(max-width:768px){

    .project-edit-body{
        padding:20px;
    }

    .project-edit-footer{
        padding:20px;
    }

    .btn-save,
    .btn-cancel{
        width:100%;
        margin-bottom:10px;
    }

}
</style>
@endpush

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i>
                Edit Project
            </h4>
        </div>
        <form action="{{ route('admin.projects.update',$project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="row">

                    {{-- Project Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Project Name</label>
                        <input type="text"
                               name="project_name"
                               class="form-control"
                               value="{{ old('project_name',$project->project_name) }}"
                               required>
                    </div>

                    {{-- Lead Developer --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Developer</label>

                        <select name="assigned_to" class="form-select">

                            @foreach($developers as $developer)

                                <option
                                    value="{{ $developer->id }}"
                                    {{ old('assigned_to',$project->assigned_to)==$developer->id ? 'selected':'' }}>

                                    {{ $developer->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Date</label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}">
                    </div>

                    {{-- Deadline --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Deadline</label>

                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="{{ old('deadline', optional($project->deadline)->format('Y-m-d')) }}">
                    </div>

                    {{-- Priority --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Priority</label>

                        <select name="priority" class="form-select">

                            @foreach(['Low','Medium','High','Critical'] as $priority)

                                <option
                                    value="{{ $priority }}"
                                    {{ old('priority',$project->priority)==$priority ? 'selected':'' }}>

                                    {{ $priority }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            @foreach(['Pending','In Progress','Completed','On Hold','Cancelled'] as $status)

                                <option
                                    value="{{ $status }}"
                                    {{ old('status',$project->status)==$status ? 'selected':'' }}>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Description --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">Project Description</label>

                        <textarea
                            name="project_description"
                            rows="5"
                            class="form-control">{{ old('project_description',$project->project_description) }}</textarea>

                    </div>

                    {{-- Remarks --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">Remarks</label>

                        <textarea
                            name="remarks"
                            rows="4"
                            class="form-control">{{ old('remarks',$project->remarks) }}</textarea>

                    </div>

                </div>

            </div>

            <div class="card-footer text-end">

                <a href="{{ route('admin.projects.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="bi bi-check-circle"></i>

                    Update Project

                </button>

            </div>

        </form>

    </div>

</div>

@endsection