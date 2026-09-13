@extends('index')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card eCard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Notification Setting</h5>
                <a href="{{ route('admin.notification-settings.index') }}" class="btn btn-secondary">Back</a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.notification-settings.update', $setting->id) }}" method="POST">
                    @csrf
                    @include('admin.notification_settings._form')
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
