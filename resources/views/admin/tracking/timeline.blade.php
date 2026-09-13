@extends('index')
@push('title', get_phrase('Tracking Timeline'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Tax') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Tracking Timeline') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Tax') }}</p>

                @foreach ($events as $event)
                    <div class="timeline-item">
                        <div class="timeline-icon"></div>
                        <div class="timeline-content">
                            <h4>{{ $event->title }}</h4>
                            <small>{{ $event->event_time->format('d M Y, h:i A') }}</small>
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .timeline {
            position: relative;
            margin: 20px 0;
            padding: 0;
        }

        .timeline:before {
            content: '';
            position: absolute;
            left: 20px;
            width: 3px;
            height: 100%;
            background: #007bff;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 50px;
        }

        .timeline-icon {
            width: 15px;
            height: 15px;
            background: #007bff;
            border-radius: 50%;
            position: absolute;
            left: 13px;
            top: 5px;
        }

        .timeline-content {
            background: #fff;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
    </style>
@endpush
