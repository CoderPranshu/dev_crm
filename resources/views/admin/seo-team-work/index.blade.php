@extends('index')

@push('title', get_phrase('SEO Team Daily Work'))

@push('css')
    <style>
        /* ==========================
       SEO Team Work Cards
    ========================== */

        #taskCards .card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            transition: .25s ease;
            box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
            background: #fff;
        }

        #taskCards .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
        }

        /* Header */

        #taskCards .card-header {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border-bottom: 1px solid #ececec;
            padding: 14px 18px;
        }

        #taskCards .card-header h5 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
            color: #222;
        }

        #taskCards .card-header small {
            color: #7b8794;
            font-size: 13px;
        }

        /* Body */

        #taskCards .card-body {
            padding: 16px 18px;
        }

        /* Information */

        #taskCards strong {
            color: #555;
            font-size: 13px;
            font-weight: 600;
        }

        #taskCards .card-body .row {
            margin-bottom: 10px !important;
        }

        #taskCards .card-body .col-6 {
            font-size: 14px;
            color: #2c3e50;
        }

        #taskCards .card-body .col-3 {
            font-size: 12px;
            color: #2c3e50;
        }


        /* Task Heading */

        #taskCards .card-body>strong {
            display: block;
            margin: 8px 0 10px;
            font-size: 15px;
            color: #222;
        }

        /* Task List */

        #taskCards .list-group {
            margin-top: 8px;
        }

        #taskCards .list-group-item {
            border: none;
            border-radius: 8px;
            background: #f8f9fb;
            margin-bottom: 8px;
            padding: 10px 14px;
            font-size: 14px;
            transition: .2s;
        }

        #taskCards .list-group-item:hover {
            background: #eef5ff;
        }

        .list-group {
            height: 90px;
            overflow: auto;
        }

        /* Footer */

        #taskCards .card-footer {
            background: #fff;
            border-top: 1px solid #eee;
            padding: 12px 18px;
        }

        /* Button */

        #taskCards .btn-primary {
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 18px;
        }

        /* Badges */

        #taskCards .badge {
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Pending */

        .bg-warning {
            background: #fff5d8 !important;
            color: #b97700 !important;
        }

        /* Completed */

        .bg-success {
            background: #d9f8e6 !important;
            color: #15803d !important;
        }

        /* Reduce overall card height */

        #taskCards .card-body {
            min-height: 220px;
        }

        /* Mobile */

        @media(max-width:768px) {

            #taskCards .card-body {
                min-height: auto;
            }

        }

        #taskCards .card {
            height: auto !important;
        }

        #taskCards .card-body {
            min-height: 0 !important;
        }


        /* Card */
        #taskCards .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .08);
            transition: .2s;
        }

        #taskCards .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(0, 0, 0, .12);
        }

        /* Header */
        #taskCards .card-header {
            padding: 10px 15px;
        }

        #taskCards .card-header h5 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        #taskCards .card-header small {
            font-size: 12px;
        }

        /* Body */
        #taskCards .card-body {
            padding: 12px 15px;
            min-height: auto !important;
            /* Height remove */
        }

        /* Information */
        #taskCards .card-body .row {
            margin-bottom: 6px !important;
        }

        #taskCards .card-body .col-6 {
            font-size: 13px;
        }

        #taskCards strong {
            font-size: 12px;
        }

        /* Task List */
        #taskCards .list-group {
            margin-top: 6px;
        }

        #taskCards .list-group-item {
            padding: 7px 10px;
            margin-bottom: 5px;
            font-size: 13px;
            border-radius: 6px;
        }

        /* Footer */
        #taskCards .card-footer {
            padding: 10px 15px;
        }

        /* Button */
        #taskCards .btn {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 6px;
        }
    </style>
@endpush


@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center">
            <h4>SEO Team Daily Work</h4>

            <div class="col-md-3">
                <input type="text" class="form-control" id="search" placeholder="Search Client...">
            </div>
        </div>
    </div>

    <div class="row" id="taskCards">

        @forelse($teamTasks as $teamTask)
            <div class="col-lg-12 mb-4 search-item">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-header bg-white">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h5 class="mb-1">
                                    {{ $teamTask->company->name }}
                                </h5>

                                <small class="text-muted">
                                    {{ $teamTask->seoPlan->name }}
                                </small>

                            </div>

                            <div class="d-flex gap-3">

                            

                            <div>

                                @if ($teamTask->status == 'active')
                                    <span class="badge bg-success">
                                        Active1
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif

                            </div>
                           

                          

                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('seo-project-keywords.index', $teamTask->id) }}"
                                    class="btn btn-info btn-sm border border-3 border-info text-white">
                                    <i class="fa-solid fa-share-nodes me-1"></i>
                                    Keywords
                                </a>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.on-page-seo.index', $teamTask->id) }}"
                                    class="btn btn-primary btn-sm border border-3 border-info">
                                    <i class="fa-solid fa-share-nodes me-1"></i>
                                    On Page SEO
                                </a>
                            </div>

                            {{-- <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.backlink-assignment.index', $teamTask->id) }}"
                                    class="btn btn-success btn-sm border border-3 border-info">
                                    <i class="fa-solid fa-share-nodes me-1"></i>
                                    Backlink Manager
                                </a>
                            </div> --}}

                            <a
                                href="{{ route('admin.seo-client-backlinks.index', $teamTask->id) }}"
                                class="btn btn-success">
                                Backlink Manager
                            </a>


                          <div class="d-flex align-items-center gap-2">

                                @php
                                    $hasDistribution = \App\Models\SeoTaskDistribution::where(
                                        'seo_plan_client_id',
                                        $teamTask->id
                                    )->exists();
                                @endphp

                                @if($hasDistribution)

                                    <a href="{{ route('admin.seo.task.distribution', $teamTask->id) }}"
                                    class="btn btn-warning btn-sm p-2">

                                        <i class="fa-solid fa-pen-to-square me-1"></i>

                                        Edit Distribution

                                    </a>

                                @else

                                    <a href="{{ route('admin.seo.task.distribution', $teamTask->id) }}"
                                    class="btn btn-primary btn-sm p-2">

                                        <i class="fa-solid fa-share-nodes me-1"></i>

                                        Assign Tasks

                                    </a>

                                @endif

                            </div>

                            <!--  -->

                          </div>

                          </div>

                    </div>

                    <div class="card-body">

                        <div class="row text-center mb-3">

                            <div class="col-3">

                                <strong>Team</strong><br>

                                {{ $teamTask->team->name ?? '-' }}

                            </div>

                            <div class="col-3">

                                <strong>Duration</strong><br>

                                {{ $teamTask->seoPlan->duration }} Month

                            </div>

                            <div class="col-3">

                                <strong>Start</strong><br>

                                {{ \Carbon\Carbon::parse($teamTask->start_date)->format('d M Y') }}

                            </div>

                            <div class="col-3">

                                <strong>End</strong><br>

                                {{ \Carbon\Carbon::parse($teamTask->end_date)->format('d M Y') }}

                            </div>

                        </div>

                        <hr>

                        <strong>Today's Tasks</strong>

                        <ul class="list-group mt-2">

                            @forelse($teamTask->todayTasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">

                                    <span>{{ $task->task_title }}</span>

                                    <span class="badge bg-primary">
                                        {{ ucfirst($task->day) }}
                                    </span>

                                </li>

                            @empty

                                <li class="list-group-item text-center text-muted">

                                    No Task Today

                                </li>
                            @endforelse

                        </ul>

                    </div>

                    <div class="card-footer bg-white text-end">

                        @if ($teamTask->todayTasks->count())
                            <a href="{{ route('admin.seo-team-work.show', $teamTask->id) }}" class="btn btn-primary">

                                Start Work

                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>

                                No Task

                            </button>
                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning text-center">

                    No Active SEO Work Found

                </div>

            </div>
        @endforelse

    </div>

@endsection

@push('js')

    <script>
        $('#search').on('keyup', function() {

            let value = $(this).val().toLowerCase();

            $('.search-item').filter(function() {

                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

            });

        });
    </script>

@endpush
