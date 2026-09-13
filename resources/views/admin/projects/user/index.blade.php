@extends('index')

@section('content')

<div class="container-fluid">

    <div class="row">

        @forelse($projects as $project)

        @php

            $progress = (int) round($project->modules->avg('progress') ?? 0);

        @endphp

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h5>

                        {{ $project->project_name }}

                    </h5>

                    <p>

                        {{ $project->client_name }}

                    </p>

                    <p>

                        {{ $project->status }}

                    </p>

                    <div class="progress mb-3">

                        <div class="progress-bar"

                             style="width:{{ $progress }}%">

                            {{ $progress }}%

                        </div>

                    </div>

                    <p>

                        Deadline :

                        {{ optional($project->deadline)->format('d M Y') }}

                    </p>

                    <a

                    href="{{ route('user.projects.show',$project->id) }}"

                    class="btn btn-primary btn-sm">

                        View Project

                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info">

                No Projects Found.

            </div>

        </div>

        @endforelse

    </div>

    {{ $projects->links() }}

</div>

@endsection