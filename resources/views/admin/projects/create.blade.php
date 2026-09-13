@extends('index')

@push('title', get_phrase('Create Project'))

@push('css')
    <style>
        h5 {
            font-size: 15px;
        }

        .text-muted {
            font-size: 12px !important;
        }

        #previewClient {
            font-size: 12px !important;
        }

        #previewDeveloper {
            font-size: 12px !important;
        }

        #previewDepartment{
            font-size: 12px !important;
        }

        #previewStart {
            font-size: 12px !important;
        }

        #previewDeadline{
            font-size: 12px !important;           
        }
        
    </style>
@endpush

@section('content')
    <div class="mainSection-title">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h4>Create Project</h4>

                <small class="text-muted">
                    Create and assign a new project
                </small>

            </div>

            <div>

                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">

                    <i class="fi-rr-arrow-left"></i>

                    Back

                </a>

            </div>

        </div>

    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif



    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="row">

            {{-- LEFT SIDE --}}

            <div class="col-lg-8">

                <div class="eSection-wrap mb-4 pb-4">

                    <div class="mb-4">

                        <h5 class="fw-bold">

                            Client Information

                        </h5>

                        <small class="text-muted">

                            Enter client details

                        </small>

                    </div>

                    <div class="row">

                        {{-- Project Source --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Project Source

                            </label>

                            <select class="form-select eForm-control eForm-control" name="source" id="source">

                                <option value="manual">Manual Project</option>

                                <option value="lead">Lead Project</option>

                            </select>

                        </div>

                        {{-- Lead Dropdown --}}

                        <div class="col-md-6 mb-3" id="lead_section" style="display:none;">

                            <label class="form-label eForm-label">

                                Lead

                            </label>

                            <select name="lead_id" id="lead_id" class="form-select eForm-control eForm-control">

                                <option value="">Select Lead</option>

                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->id }}">

                                        {{ $lead->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>
                        {{-- Client Name --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Client Name

                            </label>

                            <input type="text" class="form-control eForm-control" id="client_name" name="client_name">

                        </div>

                        {{-- Company --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Company Name

                            </label>

                            <input type="text" class="form-control eForm-control" id="company_name" name="company_name">

                        </div>

                        {{-- Phone --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Phone

                            </label>

                            <input type="text" class="form-control eForm-control" name="phone" id="phone">

                        </div>

                        {{-- Alt Phone --}}



                        {{-- Email --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Email

                            </label>

                            <input type="email" class="form-control eForm-control" id="email" name="email">

                        </div>

                        {{-- Address --}}

                        <div class="col-md-12 mb-3">

                            <label class="form-label eForm-label">

                                Address

                            </label>

                            <textarea class="form-control eForm-control" rows="3" name="address" id="address"></textarea>

                        </div>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- Project Information --}}
                {{-- ===================================== --}}

                <div class="eSection-wrap mb-4 pb-4">

                    <div class="mb-4">

                        <h5 class="fw-bold">
                            Project Information
                        </h5>

                        <small class="text-muted">
                            Project details and assignment
                        </small>

                    </div>

                    <div class="row">

                        {{-- Project Name --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Project Name
                                <span class="text-danger">*</span>

                            </label>

                            <input type="text" class="form-control eForm-control" id="project_name" name="project_name">

                        </div>

                        {{-- Department --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Department

                            </label>


                            <select class="form-select eForm-control" id="department_id" name="department_id">

                                <option value="">Select Department</option>

                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">

                                        {{ $department->title }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Assign Lead --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label eForm-label">

                                Assign Lead Developer

                            </label>

                            <select class="form-select eForm-control" id="assigned_to" name="assigned_to">

                                <option value="">Select Lead Developer</option>

                            </select>

                        </div>

                        {{-- Priority --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label eForm-label">

                                Priority

                            </label>

                            <select class="form-select eForm-control" id="priority" name="priority">

                                <option value="Low">
                                    Low
                                </option>

                                <option value="Medium" selected>
                                    Medium
                                </option>

                                <option value="High">
                                    High
                                </option>

                                <option value="Critical">
                                    Critical
                                </option>

                            </select>

                        </div>

                        {{-- Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label eForm-label">

                                Status

                            </label>

                            <select class="form-select eForm-control" id="status" name="status">

                                <option value="Pending">
                                    Pending
                                </option>

                                <option value="In Progress">
                                    In Progress
                                </option>

                                <option value="On Hold">
                                    On Hold
                                </option>

                                <option value="Completed">
                                    Completed
                                </option>

                                <option value="Cancelled">
                                    Cancelled
                                </option>

                            </select>

                        </div>

                        {{-- Start Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label eForm-label">

                                Start Date

                            </label>

                            <input type="date" class="form-control eForm-control" id="start_date" name="start_date">

                        </div>

                        {{-- Deadline --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label eForm-label">

                                Deadline

                            </label>

                            <input type="date" class="form-control eForm-control" id="deadline" name="deadline">

                        </div>


                        {{-- Project Description --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label eForm-label">

                                Project Description

                            </label>

                            <textarea class="form-control eForm-control" rows="5" id="project_description" name="project_description"
                                placeholder="Write project requirements..."></textarea>

                        </div>

                        {{-- Internal Remarks --}}
                        <div class="col-md-12">

                            <label class="form-label eForm-label">

                                Internal Remarks

                            </label>

                            <textarea class="form-control eForm-control" rows="3" name="remarks"></textarea>

                        </div>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- Attachments --}}
                {{-- ===================================== --}}

                <div class="eSection-wrap mb-4 pb-3">

                    <div class="mb-4">

                        <h5 class="fw-bold">

                            Project Attachments

                        </h5>

                        <small class="text-muted">

                            Upload Requirement Documents, Images, ZIP Files etc.

                        </small>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <label class="form-label eForm-label">

                                Attach Files

                            </label>

                            <input type="file" class="form-control eForm-control" id="attachments" name="attachments[]" multiple>

                            <small class="text-muted">

                                Supported:
                                PDF, DOC, DOCX, XLS, XLSX,
                                PNG, JPG, JPEG,
                                ZIP, RAR, SQL

                            </small>

                        </div>

                    </div>

                    <div id="attachmentPreview" class="mt-3"></div>

                </div>

            </div>

            {{-- ===================================== --}}
            {{-- RIGHT SIDE --}}
            {{-- ===================================== --}}

            <div class="col-lg-4">

                <div style="position: sticky; top: 30px;">

                    {{-- Preview Card --}}

                    {{-- <div class="eSection-wrap mb-4">

                    <h5 class="fw-bold mb-3">

                        Live Preview

                    </h5>

                    <div class="text-center mb-4">

                        <div
                            style="
                            width:70px;
                            height:70px;
                            border-radius:50%;
                            background:#4361ee;
                            color:#fff;
                            font-size:30px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            margin:auto;">

                            <i class="fi-rr-folder"></i>

                        </div>

                    </div>

                    <table class="table table-borderless">

                        <tr>

                            <th width="40%">

                                Client

                            </th>

                            <td id="previewClient">

                                -

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Company

                            </th>

                            <td id="previewCompany">

                                -

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Project

                            </th>

                            <td id="previewProject">

                                -

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Department

                            </th>

                            <td id="previewDepartment">

                                -

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Lead Developer

                            </th>

                            <td id="previewDeveloper">

                                -

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Priority

                            </th>

                            <td>

                                <span
                                    class="badge bg-warning"
                                    id="previewPriority">

                                    Medium

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Status

                            </th>

                            <td>

                                <span
                                    class="badge bg-secondary"
                                    id="previewStatus">

                                    Pending

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Start Date

                            </th>

                            <td id="previewStart">

                                -

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Deadline

                            </th>

                            <td id="previewDeadline">

                                -

                            </td>

                        </tr>

                    </table>

                </div> --}}

                    {{-- ========================= --}}
                    {{-- Live Project Preview --}}
                    {{-- ========================= --}}

                    <div class="eSection-wrap pb-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>

                                <h5 class="mb-1 fw-bold">
                                    Live Preview
                                </h5>

                                <small class="text-muted">
                                    Project summary before save
                                </small>

                            </div>

                            <span class="badge bg-success">
                                Draft
                            </span>

                        </div>

                        {{-- Project Icon --}}

                        <div class="text-center mb-4">

                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                style="width:80px;height:80px;">

                                <i class="fi-rr-folder text-white" style="font-size:32px;"></i>

                            </div>

                            <h5 class="mt-3 mb-1 fw-bold" id="previewProject">

                                New Project

                            </h5>

                            <small class="text-muted">

                                <span id="previewCompany">Company Name</span>

                            </small>

                        </div>

                        {{-- Information --}}

                        <div class="border rounded p-3 mb-3">

                            <div class="d-flex justify-content-between mb-1">

                                <span class="text-muted">

                                    Client

                                </span>

                                <strong id="previewClient">

                                    -

                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-1">

                                <span class="text-muted">

                                    Department

                                </span>

                                <strong id="previewDepartment">

                                    -

                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-1">

                                <span class="text-muted">

                                    Lead Developer

                                </span>

                                <strong id="previewDeveloper">

                                    -

                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-1">

                                <span class="text-muted">

                                    Start Date

                                </span>

                                <strong id="previewStart">

                                    -

                                </strong>

                            </div>

                            <div class="d-flex justify-content-between">

                                <span class="text-muted">

                                    Deadline

                                </span>

                                <strong id="previewDeadline">

                                    -

                                </strong>

                            </div>

                        </div>

                        {{-- Status --}}

                        <div class="row g-2 mb-3">

                            <div class="col-6">

                                <div class="border rounded text-center p-3">

                                    <small class="text-muted d-block mb-2">

                                        Priority

                                    </small>

                                    <span class="badge bg-warning" id="previewPriority">

                                        Medium

                                    </span>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="border rounded text-center p-3">

                                    <small class="text-muted d-block mb-2">

                                        Status

                                    </small>

                                    <span class="badge bg-secondary" id="previewStatus">

                                        Pending

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Progress --}}

                        <div class="mb-3">

                            <div class="d-flex justify-content-between mb-2">

                                <small>

                                    Initial Progress

                                </small>

                                <small>

                                    0%

                                </small>


                            </div>

                            <div class="progress" style="height:8px;">

                                <div class="progress-bar bg-success" style="width:0%"></div>


                            </div>

                            <small class="text-muted">
                                Progress will start after modules are created.
                            </small>

                        </div>

                        {{-- Timeline --}}

                        <div class="border rounded p-3">

                            <h6 class="fw-bold mb-3">

                                Timeline

                            </h6>

                            <div class="d-flex justify-content-between">

                                <div class="text-center">

                                    <i class="fi-rr-play text-success"></i>

                                    <br>

                                    <small>Start</small>

                                </div>

                                <div class="flex-grow-1 border-top mt-2 mx-2"></div>

                                <div class="text-center">

                                    <i class="fi-rr-flag text-danger"></i>

                                    <br>

                                    <small>Deadline</small>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Progress Card --}}

                    {{-- <div class="eSection-wrap mb-4">

                    <h5 class="fw-bold">

                        Initial Progress

                    </h5>

                    <div class="progress mt-3">

                        <div
                            class="progress-bar bg-success"
                            style="width:0%">

                            0%

                        </div>

                    </div>

                    <small class="text-muted">

                        Progress will start after modules are created.

                    </small>

                </div> --}}

                    {{-- Summary Card --}}

                    <div class="eSection-wrap">

                        <h5 class="fw-bold mb-3">

                            Summary

                        </h5>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item d-flex justify-content-between">

                                Attachments

                                <span id="attachmentCount">

                                    0

                                </span>

                            </li>

                            <li class="list-group-item d-flex justify-content-between">

                                Modules

                                <span>

                                    0

                                </span>

                            </li>

                            <li class="list-group-item d-flex justify-content-between">

                                Sub Modules

                                <span>

                                    0

                                </span>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        {{-- =============================== --}}
        {{-- Action Buttons --}}
        {{-- =============================== --}}

        <div class="mt-4">

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('admin.projects.index') }}" class="btn btn-light">

                    Cancel

                </a>

                <button type="reset" class="btn btn-warning">

                    Reset

                </button>

                <button type="submit" class="btn btn-primary">

                    <i class="fi-rr-disk"></i>

                    Save Project

                </button>

            </div>

        </div>

        </div>

    </form>
@endsection

@push('js')

    <script>
        // ==========================
        // Live Preview
        // ==========================

        function updatePreview(inputId, previewId) {

            let value = document.getElementById(inputId).value;

            document.getElementById(previewId).innerHTML = value !== '' ? value : '-';

        }

        document.getElementById('client_name').addEventListener('keyup', function() {

            updatePreview('client_name', 'previewClient');

        });

        document.getElementById('company_name').addEventListener('keyup', function() {

            updatePreview('company_name', 'previewCompany');

        });

        document.getElementById('project_name').addEventListener('keyup', function() {

            updatePreview('project_name', 'previewProject');

        });

        document.getElementById('start_date').addEventListener('change', function() {

            updatePreview('start_date', 'previewStart');

        });

        document.getElementById('deadline').addEventListener('change', function() {

            updatePreview('deadline', 'previewDeadline');

        });


        // ==========================
        // Department Preview
        // ==========================

        document.getElementById('department_id').addEventListener('change', function() {

            let text = this.options[this.selectedIndex].text;

            document.getElementById('previewDepartment').innerHTML = text;

        });


        // ==========================
        // Developer Preview
        // ==========================

        document.getElementById('assigned_to').addEventListener('change', function() {

            let text = this.options[this.selectedIndex].text;

            document.getElementById('previewDeveloper').innerHTML = text;

        });


        // ==========================
        // Priority Badge
        // ==========================

        document.getElementById('priority').addEventListener('change', function() {

            let badge = document.getElementById('previewPriority');

            badge.innerHTML = this.value;

            badge.className = 'badge';

            if (this.value == 'Low') {

                badge.classList.add('bg-success');

            } else if (this.value == 'Medium') {

                badge.classList.add('bg-warning');

            } else if (this.value == 'High') {

                badge.classList.add('bg-danger');

            } else {

                badge.classList.add('bg-dark');

            }

        });


        // ==========================
        // Status Badge
        // ==========================

        document.getElementById('status').addEventListener('change', function() {

            let badge = document.getElementById('previewStatus');

            badge.innerHTML = this.value;

        });


        // ==========================
        // Attachment Preview
        // ==========================

        document.getElementById('attachments').addEventListener('change', function() {

            let preview = document.getElementById('attachmentPreview');

            let count = document.getElementById('attachmentCount');

            preview.innerHTML = '';

            count.innerHTML = this.files.length;

            Array.from(this.files).forEach(function(file) {

                preview.innerHTML += `

                <div class="border rounded p-2 mb-2 d-flex justify-content-between">

                    <div>

                        <i class="fi-rr-file me-2 text-primary"></i>

                        ${file.name}

                    </div>

                    <small>

                        ${(file.size/1024).toFixed(2)} KB

                    </small>

                </div>

            `;

            });

        });



        $('#lead_id').change(function() {

            let id = $(this).val();

            if (id == '') return;

            $.get('/admin/projects/get-lead/' + id, function(data) {

                $('#client_name').val(data.name);

                $('#company_name').val(data.company_name);

                $('#office_name').val(data.office_name);

                $('#phone').val(data.phone);

                $('#alternate_phone').val(data.alternate_phone);

                $('#email').val(data.email);

                $('#alternate_email').val(data.alternate_email);

                $('#website').val(data.website);

                $('#gst_number').val(data.gst_number);

                $('#address').val(data.address);

                $('#country').val(data.country);

                $('#state').val(data.state);

                $('#city').val(data.city);

                $('#zip_code').val(data.zip_code);

            });

        });

        $(document).ready(function() {

            $('#source').on('change', function() {

                if ($(this).val() == 'lead') {

                    $('#lead_section').slideDown();

                } else {

                    $('#lead_section').slideUp();

                    $('#lead_id').val('');

                    // Manual mode me fields bhi clear kar do
                    $('#client_name').val('');
                    $('#company_name').val('');
                    $('#office_name').val('');
                    $('#phone').val('');
                    $('#alternate_phone').val('');
                    $('#email').val('');
                    $('#alternate_email').val('');
                    $('#website').val('');
                    $('#gst_number').val('');
                    $('#address').val('');
                    $('#country').val('');
                    $('#state').val('');
                    $('#city').val('');
                    $('#zip_code').val('');

                }

            });

        });

        $('#department_id').change(function() {

            let departmentId = $(this).val();

            $('#assigned_to').html('<option>Loading...</option>');

            if (departmentId == '') {

                $('#assigned_to').html('<option>Select Lead Developer</option>');

                return;

            }

            $.ajax({

                url: '/admin/projects/get-developers/' + departmentId,

                type: 'GET',

                success: function(response) {

                    let option = '<option value="">Select Lead Developer</option>';

                    $.each(response, function(index, developer) {

                        option += '<option value="' + developer.id + '">' + developer.name +
                            '</option>';

                    });

                    $('#assigned_to').html(option);

                }

            });

        });
    </script>

@endpush
