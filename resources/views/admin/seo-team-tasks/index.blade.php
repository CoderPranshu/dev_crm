@extends('index')

@push('title', get_phrase('SEO Team Tasks'))

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">

        <div class="d-flex flex-column">
            <h4>{{ get_phrase('SEO Team Tasks') }}</h4>

            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li>
                    SEO Team Tasks
                </li>
            </ul>
        </div>

        <div>
            <a href="{{ route('admin.seo-team-tasks.create') }}"
               class="export_btn">
                <i class="bi bi-plus"></i>
                <span>Add Team Task</span>
            </a>
        </div>

    </div>
</div>


<div class="row">

<div class="col-md-12">

<div class="eSection-wrap">

<div class="d-flex justify-content-between align-items-center">

<p class="column-title mb-2">
SEO Team Tasks
</p>

<div class="mb-3">

<input type="text"
id="searchTask"
class="form-control eForm-control"
placeholder="Search Client / Team / Plan">

</div>

</div>

<div class="table-responsive">

<table class="table eTable">

<thead>

<tr>

<th>#</th>

<th>Client</th>

<th>SEO Plan</th>

<th>Team</th>

<th>Week Days</th>

<th>Status</th>

<th width="120">
Action
</th>

</tr>

</thead>

<tbody id="taskBody">

@foreach($tasks as $task)

<tr>

<td>{{ $loop->iteration }}</td>

<td class="client">

{{ $task->seoPlanClient->company->name ?? '-' }}

</td>

<td class="plan">

{{ $task->seoPlanClient->seoPlan->name ?? '-' }}

</td>

<td class="team">

{{ $task->team_name }}

</td>

<td class="days">

{{-- @foreach(json_decode($task->week_days,true) as $day)

<span class="badge bg-primary">

{{ ucfirst($day) }}

</span>

@endforeach --}}

</td>

<td>

@if($task->status=="Pending")

<span class="badge bg-warning">

Pending

</span>

@elseif($task->status=="In Progress")

<span class="badge bg-info">

In Progress

</span>

@else

<span class="badge bg-success">

Completed

</span>

@endif

</td>

<td>

<a href="{{ route('admin.seo-team-tasks.show',$task->id) }}"
class="btn btn-sm">

<i class="fi-rr-eye"></i>

</a>

<a href="{{ route('admin.seo-team-tasks.edit',$task->id) }}"
class="btn btn-sm">

<i class="fi-rr-pencil"></i>

</a>

<form
action="{{ route('admin.seo-team-tasks.destroy',$task->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button
class="btn btn-sm text-danger"
onclick="return confirm('Delete?')">

<i class="fi-rr-trash"></i>

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

@endsection


@push('js')

<script>

document.getElementById('searchTask').addEventListener('keyup',function(){

let value=this.value.toLowerCase();

document.querySelectorAll('#taskBody tr').forEach(function(row){

let client=row.querySelector('.client').innerText.toLowerCase();

let plan=row.querySelector('.plan').innerText.toLowerCase();

let team=row.querySelector('.team').innerText.toLowerCase();

let days=row.querySelector('.days').innerText.toLowerCase();

if(client.includes(value)
||plan.includes(value)
||team.includes(value)
||days.includes(value))

row.style.display='';

else

row.style.display='none';

});

});

</script>

@endpush