@extends('index')

@push('title', get_phrase('SEO Team Task Details'))

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>
            <h4>{{ get_phrase('SEO Team Task Details') }}</h4>

            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>

                <li>
                    <a href="{{ route('admin.seo-team-tasks.index') }}">
                        SEO Team Tasks
                    </a>
                </li>

                <li>Details</li>

            </ul>

        </div>

        <div>

            <a href="{{ route('admin.seo-team-tasks.index') }}"
               class="btn btn-secondary">

                <i class="fi-rr-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

</div>


<div class="eSection-wrap">

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold">

Client

</label>

<p>

{{ $task->seoPlanClient->company->name ?? '-' }}

</p>

</div>


<div class="col-md-6 mb-3">

<label class="fw-bold">

SEO Plan

</label>

<p>

{{ $task->seoPlanClient->seoPlan->name ?? '-' }}

</p>

</div>



<div class="col-md-6 mb-3">

<label class="fw-bold">

Team Name

</label>

<p>

{{ $task->team_name }}

</p>

</div>



<div class="col-md-6 mb-3">

<label class="fw-bold">

Status

</label>

<p>

@if($task->status=='Pending')

<span class="badge bg-warning">

Pending

</span>

@elseif($task->status=='In Progress')

<span class="badge bg-info">

In Progress

</span>

@else

<span class="badge bg-success">

Completed

</span>

@endif

</p>

</div>



<div class="col-md-12 mb-4">

<label class="fw-bold">

Assigned Week Days

</label>

<br>

{{-- @foreach(json_decode($task->week_days,true) as $day)

<span class="badge bg-primary me-2 mb-2">

{{ ucfirst($day) }}

</span>

@endforeach

</div> --}}



<div class="col-md-12">

<label class="fw-bold">

Notes

</label>

<div class="border rounded p-3">

{{ $task->notes ?? 'No Notes Available' }}

</div>

</div>

</div>

</div>

@endsection