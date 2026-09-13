@extends('index')

@push('title', 'My Tasks')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fas fa-puzzle-piece text-primary"></i>

                My Tasks

            </h3>

            <small class="text-muted">

                Project :
                <strong>{{ $module->project->project_name ?? 'N/A' }}</strong>

                &nbsp; |

                Module :
                <strong>{{ $module->module_name }}</strong>

            </small>

        </div>

        <div>

            <a href="{{ route('admin.modules.show',$module->id) }}"
               class="btn btn-light">

                <i class="fas fa-arrow-left"></i>

                Back

            </a>

            <!--<a href="{{ route('submodules.create',$module->id) }}"-->
            <!--   class="btn btn-primary">-->

            <!--    <i class="fas fa-plus-circle"></i>-->

            <!--    Add Sub Module-->

            <!--</a>-->

        </div>

    </div>


    <!-- Statistics -->

    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">

                        Total Sub Modules

                    </h6>

                    <h2 class="fw-bold">

                        {{ $module->subModules->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">

                        Completed

                    </h6>

                    <h2 class="text-success fw-bold">

                        {{ $module->subModules->where('status','Completed')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">

                        In Progress

                    </h6>

                    <h2 class="text-primary fw-bold">

                        {{ $module->subModules->where('status','In Progress')->count() }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">

                        Pending

                    </h6>

                    <h2 class="text-warning fw-bold">

                        {{ $module->subModules->where('status','Pending')->count() }}

                    </h2>

                </div>

            </div>

        </div>

    </div>


    <!-- Search Card -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-5">

                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="Search Sub Module...">

                </div>

                <div class="col-md-3">

                    <select
                        id="statusFilter"
                        class="form-select">

                        <option value="">All Status</option>

                        <option>Pending</option>

                        <option>Planning</option>

                        <option>In Progress</option>

                        <option>Testing</option>

                        <option>Completed</option>

                        <option>On Hold</option>

                        <option>Cancelled</option>

                    </select>

                </div>

                <div class="col-md-3">

                    <select
                        id="priorityFilter"
                        class="form-select">

                        <option value="">All Priority</option>

                        <option>Low</option>

                        <option>Medium</option>

                        <option>High</option>

                        <option>Critical</option>

                    </select>

                </div>

                <div class="col-md-1">

                    <button
                        class="btn btn-primary w-100">

                        <i class="fas fa-search"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- Table Card -->

    <div class="card shadow border-0">

        <div class="card-header bg-white" style="border-radius: 15px;">

            <h5 class="mb-0">

                <i class="fas fa-list"></i>

                My Tasks

            </h5>

        </div>

        <div class="card-body p-3">

            <div class="table-responsive">

                <table class="table table-hover eTable align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Sub Module</th>

                            <th>Developer</th>

                            <th>Status</th>

                            <th>Priority</th>

                            <th>Progress</th>

                            <th>Deadline</th>

                             <th width="160">Action</th> 

                        </tr>

                    </thead>

                    <tbody id="subModuleTable">

                    @forelse($submodules as $submodule)

<tr>

    <td>
        {{ $loop->iteration }}
    </td>

    <td>

        <div>

            <div class="fw-bold">

                {{ $submodule->sub_module_name }}

            </div>

            @if($submodule->description)

                <small class="text-muted">

                    {{ \Illuminate\Support\Str::limit($submodule->description,60) }}

                </small>

            @endif

        </div>

    </td>

    <td>

        @if($submodule->assignedTo)

            <span class="badge bg-info">

                {{ $submodule->assignedTo->name }}

            </span>

        @else

            <span class="badge bg-secondary">

                Not Assigned

            </span>

        @endif

    </td>

    <td>

        @switch($submodule->status)

            @case('Completed')

                <span class="badge bg-success">

                    Completed

                </span>

                @break

            @case('In Progress')

                <span class="badge bg-primary">

                    In Progress

                </span>

                @break

            @case('Testing')

                <span class="badge bg-info">

                    Testing

                </span>

                @break

            @case('On Hold')

                <span class="badge bg-warning text-dark">

                    On Hold

                </span>

                @break

            @case('Cancelled')

                <span class="badge bg-danger">

                    Cancelled

                </span>

                @break

            @default

                <span class="badge bg-secondary">

                    Pending

                </span>

        @endswitch

    </td>

    <td>

        @switch($submodule->priority)

            @case('Critical')

                <span class="badge bg-danger">

                    Critical

                </span>

                @break

            @case('High')

                <span class="badge bg-warning text-dark">

                    High

                </span>

                @break

            @case('Medium')

                <span class="badge bg-primary">

                    Medium

                </span>

                @break

            @default

                <span class="badge bg-success">

                    Low

                </span>

        @endswitch

    </td>

    <td style="width:180px;">

        <div class="progress" style="height:8px;">

            <div class="progress-bar

                @if($submodule->progress>=100)

                    bg-success

                @elseif($submodule->progress>=60)

                    bg-primary

                @elseif($submodule->progress>=30)

                    bg-warning

                @else

                    bg-danger

                @endif

            "

            role="progressbar"

            style="width: {{ $submodule->progress }}%;">

            </div>

        </div>

        <small class="fw-bold">

            {{ $submodule->progress }}%

        </small>

    </td>

    <td>

        @if($submodule->deadline)

            @php

                $days=\Carbon\Carbon::today()->diffInDays($submodule->deadline,false);

            @endphp

            @if($days<0)

                <span class="text-danger fw-bold">

                    Expired

                </span>

            @elseif($days<=2)

                <span class="text-danger fw-bold">

                    {{ $days }} Day Left

                </span>

            @elseif($days<=7)

                <span class="text-warning fw-bold">

                    {{ $days }} Days

                </span>

            @else

                <span class="text-success">

                    {{ \Carbon\Carbon::parse($submodule->deadline)->format('d M Y') }}

                </span>

            @endif

        @else

            -

        @endif

    </td>

    <td>
        <select class="form-select form-select-sm submodule-status"
            data-id="{{ $submodule->id }}">

        @foreach (['Pending', 'Planning', 'In Progress', 'Testing', 'Completed', 'On Hold', 'Cancelled'] as $status)
            <option value="{{ $status }}"
                @selected($submodule->status == $status)>
                {{ $status }}
            </option>
        @endforeach

    </select>
    </td>

    <!-- <td>

        <a href="{{ route('submodules.edit',[$module->id,$submodule->id]) }}"
           class="btn btn-sm btn-warning">

            <i class="fas fa-edit"></i>

        </a>

        <form
            action="{{ route('submodules.destroy',[$module->id,$submodule->id]) }}"
            method="POST"
            class="d-inline">

            @csrf
            @method('DELETE')

            <button
                onclick="return confirm('Delete this Sub Module?')"
                class="btn btn-sm btn-danger">

                <i class="fas fa-trash"></i>

            </button>

        </form>

    </td> -->

</tr>

@empty

<tr>

    <td colspan="8">

        <div class="text-center py-5">

            <img src="{{ asset('assets/images/empty.svg') }}"
                 width="170"
                 class="mb-3">

            <h5>

                No Sub Modules Found

            </h5>

            <p class="text-muted">

                Click "Add Sub Module" to create your first sub module.

            </p>

        </div>

    </td>

</tr>

@endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if(method_exists($submodules,'links'))

        <div class="card-footer bg-white">

            {{ $submodules->links() }}

        </div>

        @endif

    </div>

</div>

@endsection


@push('css')

<style>

.card{
    border-radius:14px;
}

.table th{
    white-space: nowrap;
    font-weight:600;
}

.table td{
    vertical-align: middle;
}

.progress{
    border-radius:30px;
}

.progress-bar{
    border-radius:30px;
}

.badge{
    font-size:12px;
    padding:6px 10px;
}

.btn-sm{
    border-radius:8px;
}

.table tbody tr:hover{

    background:#f8fbff;

    transition:.25s;

}

#searchInput{

    border-radius:10px;

}

.form-select{

    border-radius:10px;

}

.card-header{

    border-bottom:1px solid #ececec;

}

</style>

@endpush



@push('js')

<script>

document.addEventListener('DOMContentLoaded',function(){

    const search=document.getElementById('searchInput');

    const status=document.getElementById('statusFilter');

    const priority=document.getElementById('priorityFilter');

    function filterTable(){

        let keyword=search.value.toLowerCase();

        let statusValue=status.value.toLowerCase();

        let priorityValue=priority.value.toLowerCase();

        let rows=document.querySelectorAll('#subModuleTable tr');

        rows.forEach(function(row){

            let text=row.innerText.toLowerCase();

            let show=true;

            if(keyword && !text.includes(keyword)){
                show=false;
            }

            if(statusValue && !text.includes(statusValue)){
                show=false;
            }

            if(priorityValue && !text.includes(priorityValue)){
                show=false;
            }

            row.style.display=show ? '' : 'none';

        });

    }

    search.addEventListener('keyup',filterTable);

    status.addEventListener('change',filterTable);

    priority.addEventListener('change',filterTable);

});

// 

document.addEventListener('change', function (e) {

    if (!e.target.classList.contains('submodule-status')) return;

    let id = e.target.dataset.id;

    fetch('/admin/project-submodules/' + id + '/status', {

        method: 'PATCH',

        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },

        body: JSON.stringify({
            status: e.target.value
        })

    })
    .then(res => res.json())
    .then(res => {
        location.reload();
    });

});

</script>

@endpush