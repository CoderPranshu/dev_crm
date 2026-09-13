@extends('index')

@push('title', 'Daily Update Task')

@push('css')

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
        }

        /* .dashboard-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            padding: 20px;
        }

        .task-card {
            border-left: 5px solid #0d6efd;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .task-time {
            color: #6c757d;
            font-size: 14px;
        }

        .fc-toolbar-title {
            font-size: 24px !important;
            font-weight: bold;
        }

        .today-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .add-btn {
            border-radius: 30px;
        }

        #calendar {
            min-height: 700px;
        } */

        .dashboard-card{
            background:#fff;
            border-radius:18px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
            padding:20px;
        }

        .task-card{
            border-left:5px solid #0d6efd;
            margin-bottom:15px;
            border-radius:10px;
        }

        .task-time{
            color:#6c757d;
            font-size: 12px;
        }

        .fc-toolbar-title{
            font-size:24px!important;
            font-weight:bold;
        }

        .today-title{
            font-size:20px;
            font-weight:600;
            margin-bottom:20px;
        }

        .add-btn{
            border-radius:30px;
        }

        .card-body .h6{
            font-size: 12px !important;
        }

        /*  */

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #ede9e9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* .fc .fc-button-primary{
            background-color: #fff !important;
            color: #fff !important;   
        } */

    </style>

@endpush

@section('content')
    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-lg-12">

                <div class="dashboard-card">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h3 style="font-size: 20px;">📅 Daily Update Task</h3>

                        <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#taskModal">

                            + Add Task

                        </button>

                    </div>

                    <div id="calendar"></div>

                </div>

            </div>

            <div class="col-lg-12 mt-3">

                <div class="dashboard-card">

                    <div class="today-title">

                        Today's Tasks

                    </div>

                    <div id="todayTaskList">

                        @forelse($tasks as $task)
                            <div class="card task-card">

                                <div class="card-body" style="padding: 0.5rem 1rem;">

                                    <h6 style="font-size: 12px;">

                                        {{ $task->title }}

                                    </h6>

                                    <div class="task-time">

                                        🕒 {{ date('h:i A', strtotime($task->task_time)) }}

                                    </div>

                                    <div class="mt-2">

                                        @if ($task->status == 'Pending')
                                            <span class="badge bg-warning" style="font-size: 10px;">

                                                Pending

                                            </span>
                                        @else
                                            <span class="badge bg-success">

                                                Completed

                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="alert alert-light">

                                No Task Found

                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Modal -->

    <div class="modal fade" id="taskModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <form id="taskForm">

                    @csrf

                    <div class="modal-header">

                        <h5>Add Task</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label>

                                Task Name

                            </label>

                            <input type="text" name="title" class="form-control" required>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <label>

                                    Date

                                </label>

                                <input type="date" name="task_date" class="form-control" required>

                            </div>

                            <div class="col-md-6">

                                <label>

                                    Time

                                </label>

                                <input type="time" name="task_time" class="form-control" required>

                            </div>

                        </div>

                        <div class="mt-3">

                            <label>

                                Priority

                            </label>

                            <select name="priority" class="form-select">

                                <option>

                                    Low

                                </option>

                                <option selected>

                                    Medium

                                </option>

                                <option>

                                    High

                                </option>

                            </select>

                        </div>

                        <div class="mt-3">

                            <label>

                                Description

                            </label>

                            <textarea name="description" rows="3" class="form-control"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Close

                        </button>

                        <button type="submit" class="btn btn-primary">

                            Save Task

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

@push('js')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {

            //     initialView: 'dayGridMonth',

            //     height: 700,

            //     headerToolbar: {

            //         left: 'prev,next today',

            //         center: 'title',

            //         right: 'dayGridMonth,timeGridWeek,timeGridDay'

            //     },

            //     dayMaxEvents: true,      // +more link show karega
            //     nowIndicator: true,
            //     editable: false,
            //     navLinks: true,

            //     events: @json($events),

            //     eventClick: function(info) {

            //         alert(info.event.title);

            //     }

            // });

            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {

                initialView: 'dayGridMonth',

                height: 700,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                dayMaxEvents: true,      // +more link show karega
                nowIndicator: true,
                editable: false,
                navLinks: true,

                events: @json($events)

            });

            calendar.render();

            // Open Modal on Date Click
            calendar.setOption('dateClick', function(info) {

                $('#taskModal').modal('show');

                $('input[name=task_date]').val(info.dateStr);

            });

            // Save Task
            $('#taskForm').on('submit', function(e) {

                // e.preventDefault();

                $.ajax({

                    // url: "{{ route('admin.daily-update-task.store') }}",

                    type: "POST",

                    data: $(this).serialize(),

                    success: function(res) {

                        $('#taskModal').modal('hide');

                        $('#taskForm')[0].reset();

                        // calendar.addEvent({

                        //     id: res.id,
                        //     title: res.title,
                        //     start: res.start,
                        //     color: res.color

                        // });

                        loadCalendarEvents();

                        loadTodayTask();

                        alert('Task Added Successfully');

                    },

                    error: function(xhr) {

                        alert('Validation Error');

                    }

                });

            });

            // Load Today's Tasks
            function loadTodayTask() {

                $.get("{{ route('admin.daily-update-task.today') }}", function(data) {

                    $('#todayTaskList').html(data);

                });

            }

            // Delete Event
            calendar.setOption('eventClick', function(info) {

                if (confirm("Delete this task?")) {

                    $.ajax({

                        url: "{{ url('admin/daily-update-task') }}/" + info.event.id,

                        type: "POST",

                        data: {
                            _method: 'DELETE',
                            _token: "{{ csrf_token() }}"
                        },

                        success: function() {

                            info.event.remove();

                            loadTodayTask();

                        }

                    });

                }

            });

            function loadCalendarEvents() {

                $.ajax({
                    url: "{{ route('admin.daily-update-task.events') }}",
                    type: "GET",
                    success: function(events) {

                        calendar.removeAllEvents();

                        calendar.addEventSource(events);

                    }
                });

            }

        });
    </script>

@endpush
