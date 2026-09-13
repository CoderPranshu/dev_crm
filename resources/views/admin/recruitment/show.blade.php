@extends('index')
@push('title', get_phrase('Recruitment'))
@push('meta')
@endpush
@push('css')
    <style>


        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        .list-group-item {
            border: none;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 2rem;
            }
        }

        .heading2{
            color: #828286;
            font-size: 12px;
        }

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="container">

                <div class="mainSection-title mb-3" style="border-bottom: 1px solid #e4e4e9;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                        <div class="d-flex flex-column">
                            <h4>{{ get_phrase('Recruitment') }}</h4>
                            <ul class="d-flex align-items-center eBreadcrumb-2">
                                <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                                <li><a href="{{ route('admin.recruitment.index') }}">{{ get_phrase('Recruitment') }}</a></li>
                                <li><a href="#">{{ get_phrase('View') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Page Header -->
                <div class="eForm-control" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    {{ $rec->title }}
                    <button class="btn btn-primary btn-sm" style="border-radius: 12px;">{{ $rec->status }}</button>
                </div>

                <div class="card mb-3">
                    <h5 class="card-header eForm-label">Job Details</h5>
                    <div class="card-body">
                         <ul style="list-style: none;">
                            <li class="list-group-item"><strong class="eForm-label">Position: &nbsp;</strong><span class="heading2">{{ $rec->title }}</span> </li>
                            <li class="list-group-item"><strong class="eForm-label">Department: &nbsp;</strong> <span class="heading2">{{ $rec->department->title }}</span> </li>
                            <li class="list-group-item"><strong class="eForm-label">Location: &nbsp;</strong> <span class="heading2">{{ $rec->branch->title }}</span> </li>
                            <li class="list-group-item"><strong class="eForm-label">Hiring Manager: &nbsp;</strong> <span class="heading2">{{ $rec->manager->name }}</span> </li>
                            <li class="list-group-item"><strong class="eForm-label">Application Period: &nbsp;</strong> <span class="heading2"> {{ \Carbon\Carbon::parse($rec->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($rec->end_date)->format('d M Y')  }} </span></li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-3">
                    <h5 class="card-header eForm-label">Job Description</h5>
                    <div class="card-body">
                        <div class="description">
                             <p class="heading2">{{ $rec->description }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p><span class="eForm-label">Posted on: &nbsp; </span> <span class="heading2">{{ \Carbon\Carbon::parse($rec->start_date)->format('d M Y') }}</span></p>
                    <p> <span class="eForm-label">Last Updated: &nbsp; </span> <span class="heading2"> {{ \Carbon\Carbon::parse($rec->end_date)->format('d M Y') }}</span></p>
                </div>

            </div>
        </div>
    </div>

@stop
