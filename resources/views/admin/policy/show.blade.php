@extends('index')
@push('title', get_phrase('Recruitment'))
@push('meta')
@endpush
@push('css')
    <style>
        .main_content {
            padding: 0px;
        }

        p {
            font-size: 13px;
            /* color: rgb(170, 170, 170); */
            color: #8a7c8b;
            text-align: justify;
            font-weight: 400;

        }

        .description h4 {

            font-size: 15px;
            color: rgb(141, 137, 137);
        }

        .eForm-label {
            margin: 0px;
        }
    </style>
@endpush

@section('content')
    <div class=""></div>
    <main class="container">

        <div class="row card border-0 p-3 m-3">

            <div class="col-lg-12 mb-4">
                <div class="mainSection-title mb-3" style="border-bottom: 1px solid #e4e4e9;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                        <div class="d-flex flex-column">
                            <h4>{{ get_phrase('Policy') }}</h4>
                            <ul class="d-flex align-items-center eBreadcrumb-2">
                                <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                                <li><a href="{{ route('admin.policy.index') }}">{{ get_phrase('Policy') }}</a></li>
                                <li><a href="#">{{ get_phrase('View') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between eForm-control mb-3">

                    <h4 class="eForm-label">{{ $policy->title }}</h4>
                    <p>Date :{{ \Carbon\Carbon::parse($policy->date)->format('d M Y') }}</p>
                </div>


                <div class="card">
                    <div class="card-header eForm-label">
                        Description
                    </div>
                    <div class="card-body description">
                        <p>{!! $policy->description !!}</p>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header eForm-label">
                        Document
                    </div>
                    <div class="card-body">
                        <iframe src="{{ asset('uploads/document/' . $policy->document) }}" width="100%" height="1000px">
                            This browser does not support PDFs.
                            <a href="{{ asset('uploads/document/' . $policy->document) }}">Download PDF</a>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@stop
