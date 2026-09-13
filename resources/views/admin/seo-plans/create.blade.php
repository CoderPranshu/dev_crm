@extends('index')

@push('title', get_phrase('Add SEO Plan'))

@push('css')

<style>
    /* ===========================================
   SEO PLAN TASK DESIGN
=========================================== */

.eSection-wrap{
    background:#fff;
    border-radius:12px;
    padding:25px;
    box-shadow:0 5px 18px rgba(0,0,0,.05);
}

/* Labels */

.form-label,
label{
    font-weight:600;
    color:#374151;
    margin-bottom:7px;
}

/* Inputs */

.form-control,
.form-select{

    height:46px;

    border-radius:10px;

    border:1px solid #dcdfe5;

    transition:.3s;

    box-shadow:none;

}

textarea.form-control{

    height:auto;

}

.form-control:focus,
.form-select:focus{

    border-color:#0d6efd;

    box-shadow:0 0 0 .15rem rgba(13,110,253,.15);

}

/* Accordion */

.accordion-item{

    border:none;

    border-radius:12px !important;

    overflow:hidden;

    margin-bottom:20px;

    box-shadow:0 3px 12px rgba(0,0,0,.06);

}

.accordion-button{

    background:#f8fafc;

    font-size:16px;

    font-weight:700;

    color:#1f2937;

    padding:18px;

    box-shadow:none !important;

}

.accordion-button:not(.collapsed){

    background:#0d6efd;

    color:#fff;

}

.accordion-button::after{

    filter:brightness(0);

}

.accordion-button:not(.collapsed)::after{

    filter:brightness(100);

}

.accordion-body{

    background:#fff;

    padding:20px;

}

/* Table */

.table{

    margin-bottom:15px;

}

.table thead{

    background:#f4f6f9;

}

.table thead th{

    border:none;

    font-weight:600;

    color:#555;

    padding:14px;

}

.table tbody td{

    vertical-align:middle;

    padding:12px;

}

/* Task input */

.table input{

    height:42px;

    border-radius:8px;

}

/* Repeat Type select inside table */

.table select{

    height:42px;

    border-radius:8px;

}

/* Buttons */

.addTask{

    border-radius:8px;

    padding:8px 18px;

    font-weight:600;

}

.removeRow{

    width:38px;

    height:38px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

    padding:0;

}

/* Save Button */

.btn-primary{

    border-radius:8px;

    padding:10px 24px;

    font-weight:600;

}

.btn-light{

    border-radius:8px;

    padding:10px 24px;

}

/* Hover */

.table tbody tr{

    transition:.25s;

}

.table tbody tr:hover{

    background:#f8fbff;

}

/* Responsive */

@media(max-width:768px){

    .accordion-button{

        font-size:15px;

    }

    .table{

        min-width:750px;

    }

}
</style>
@endpush

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center">

        <h4>{{ get_phrase('Add SEO Plan') }}</h4>

        <a href="{{ route('admin.seo-plans.index') }}" class="btn btn-secondary">

            <i class="fi-rr-arrow-left"></i>

            Back

        </a>

    </div>

</div>

<div class="eSection-wrap">

<form action="{{ route('admin.seo-plans.store') }}" method="POST">

@csrf

<div class="row">

    <div class="col-md-4 mb-3">

        <label>SEO Service <span class="text-danger">*</span></label>

        <select name="seo_service_id" class="form-select" required>

            <option value="">Select SEO Service</option>

            @foreach($seoServices as $service)

                <option value="{{ $service->id }}">

                    {{ $service->name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-4 mb-3">

        <label>Plan Name</label>

        <input type="text"
               class="form-control"
               name="name"
               required>

    </div>

    <div class="col-md-2 mb-3">

        <label>Duration</label>

        <input type="number"
               class="form-control"
               name="duration"
               value="3">

    </div>

    <div class="col-md-2 mb-3">

        <label>Status</label>

        <select name="status" class="form-select">

            <option value="1">

                Active

            </option>

            <option value="0">

                Inactive

            </option>

        </select>

    </div>

</div>

<hr>

<div class="accordion" id="taskAccordion">

<!-- ================= MONDAY ================= -->

<div class="accordion-item mb-3">

    <h2 class="accordion-header">

        <button class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#monday">

            Monday Tasks

        </button>

    </h2>

    <div id="monday"
         class="accordion-collapse collapse show">

        <div class="accordion-body">

            <table class="table table-bordered"
                   id="mondayTable">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th width="160">Repeat Type</th>

                        <th width="80">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <input type="text"
                                   name="tasks[monday][]"
                                   class="form-control"
                                   placeholder="Task">

                        </td>

                        <td>

                            <select name="repeat_type[monday][]" class="form-select">

                                <option value="weekly" selected>Weekly</option>

                                <option value="monthly">Monthly</option>

                                <option value="first_time">First Time</option>

                            </select>

                        </td>

                        <td>

                            <button type="button"
                                    class="btn btn-danger removeRow">

                                ×

                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

            <button type="button"
                    class="btn btn-success btn-sm addTask"
                    data-target="mondayTable">

                + Add Task

            </button>

        </div>

    </div>

</div>

<!-- ================= TUESDAY ================= -->

<div class="accordion-item mb-3">

    <h2 class="accordion-header">

        <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#tuesday">

            Tuesday Tasks

        </button>

    </h2>

    <div id="tuesday"
         class="accordion-collapse collapse">

        <div class="accordion-body">

            <table class="table table-bordered"
                   id="tuesdayTable">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th width="160">Repeat Type</th>

                        <th width="80">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <input type="text"
                                   name="tasks[tuesday][]"
                                   class="form-control"
                                   placeholder="Task">

                        </td>

                        <td>

                            <select name="repeat_type[tuesday][]" class="form-select">

                                <option value="weekly" selected>Weekly</option>

                                <option value="monthly">Monthly</option>

                                <option value="first_time">First Time</option>

                            </select>

                        </td>

                        <td>

                            <button type="button"
                                    class="btn btn-danger removeRow">

                                ×

                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

            <button type="button"
                    class="btn btn-success btn-sm addTask"
                    data-target="tuesdayTable">

                + Add Task

            </button>

        </div>

    </div>

</div>


<!-- ================= WEDNESDAY ================= -->

<div class="accordion-item mb-3">

    <h2 class="accordion-header">

        <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#wednesday">

            Wednesday Tasks

        </button>

    </h2>

    <div id="wednesday"
         class="accordion-collapse collapse">

        <div class="accordion-body">

            <table class="table table-bordered"
                   id="wednesdayTable">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th width="160">Repeat Type</th>

                        <th width="80">Action</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <input type="text"
                                   name="tasks[wednesday][]"
                                   class="form-control"
                                   placeholder="Task">

                        </td>

                        <td>

                            <select name="repeat_type[wednesday][]" class="form-select">

                                <option value="weekly" selected>Weekly</option>

                                <option value="monthly">Monthly</option>

                                <option value="first_time">First Time</option>

                            </select>

                        </td>

                        <td>

                            <button type="button"
                                    class="btn btn-danger removeRow">

                                ×

                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

            <button type="button"
                    class="btn btn-success btn-sm addTask"
                    data-target="wednesdayTable">

                + Add Task

            </button>

        </div>

    </div>

</div>

<!-- ================= THURSDAY ================= -->

<div class="accordion-item mb-3">

    <h2 class="accordion-header">

        <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#thursday">

            Thursday Tasks

        </button>

    </h2>

    <div id="thursday"
         class="accordion-collapse collapse">

        <div class="accordion-body">

            <table class="table table-bordered"
                   id="thursdayTable">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th width="160">Repeat Type</th>

                        <th width="80">Action</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <input type="text"
                                   name="tasks[thursday][]"
                                   class="form-control"
                                   placeholder="Task">

                        </td>

                        <td>

                            <select name="repeat_type[thursday][]" class="form-select">

                                <option value="weekly" selected>Weekly</option>

                                <option value="monthly">Monthly</option>

                                <option value="first_time">First Time</option>

                            </select>

                        </td>

                        <td>

                            <button type="button"
                                    class="btn btn-danger removeRow">

                                ×

                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

            <button type="button"
                    class="btn btn-success btn-sm addTask"
                    data-target="thursdayTable">

                + Add Task

            </button>

        </div>

    </div>

</div>

<!-- ================= FRIDAY ================= -->

<div class="accordion-item mb-3">

    <h2 class="accordion-header">

        <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#friday">

            Friday Tasks

        </button>

    </h2>

    <div id="friday"
         class="accordion-collapse collapse">

        <div class="accordion-body">

            <table class="table table-bordered"
                   id="fridayTable">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th width="160">Repeat Type</th>

                        <th width="80">Action</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <input type="text"
                                   name="tasks[friday][]"
                                   class="form-control"
                                   placeholder="Task">

                        </td>

                        <td>

                            <select name="repeat_type[friday][]" class="form-select">

                                <option value="weekly" selected>Weekly</option>

                                <option value="monthly">Monthly</option>

                                <option value="first_time">First Time</option>

                            </select>

                        </td>

                        <td>

                            <button type="button"
                                    class="btn btn-danger removeRow">

                                ×

                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

            <button type="button"
                    class="btn btn-success btn-sm addTask"
                    data-target="fridayTable">

                + Add Task

            </button>

        </div>

    </div>

</div>

<!-- ================= SATURDAY ================= -->

<div class="accordion-item mb-3">

    <h2 class="accordion-header">

        <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#saturday">

            Saturday Tasks

        </button>

    </h2>

    <div id="saturday"
         class="accordion-collapse collapse">

        <div class="accordion-body">

            <table class="table table-bordered"
                   id="saturdayTable">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th width="160">Repeat Type</th>

                        <th width="80">Action</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <input type="text"
                                   name="tasks[saturday][]"
                                   class="form-control"
                                   placeholder="Task">

                        </td>

                        <td>

                            <select name="repeat_type[saturday][]" class="form-select">

                                <option value="weekly" selected>Weekly</option>

                                <option value="monthly">Monthly</option>

                                <option value="first_time">First Time</option>

                            </select>

                        </td>

                        <td>

                            <button type="button"
                                    class="btn btn-danger removeRow">

                                ×

                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

            <button type="button"
                    class="btn btn-success btn-sm addTask"
                    data-target="saturdayTable">

                + Add Task

            </button>

        </div>

    </div>

</div>

</div>

<div class="mt-4">

    <button type="submit"
            class="btn btn-primary">

        <i class="fi-rr-disk"></i>

        Save SEO Plan

    </button>

    <a href="{{ route('admin.seo-plans.index') }}"
       class="btn btn-light">

        Cancel

    </a>

</div>

</form>

</div>

@endsection

@push('js')

<script>

document.addEventListener('DOMContentLoaded', function () {

    // Add Task
    document.querySelectorAll('.addTask').forEach(function(button){

        button.addEventListener('click', function(){

            let tableId = this.dataset.target;

            let tbody = document.querySelector('#' + tableId + ' tbody');

            let firstRow = tbody.querySelector('tr');

            let newRow = firstRow.cloneNode(true);

            newRow.querySelector('input').value = '';

            let repeatSelect = newRow.querySelector('select[name^="repeat_type"]');

            if (repeatSelect) {

                repeatSelect.value = 'weekly';

            }

            tbody.appendChild(newRow);

        });

    });

    // Remove Task
    document.addEventListener('click', function(e){

        if(e.target.classList.contains('removeRow')){

            let tbody = e.target.closest('tbody');

            if(tbody.querySelectorAll('tr').length == 1){

                alert('At least one task is required.');

                return;

            }

            e.target.closest('tr').remove();

        }

    });

});

</script>

@endpush