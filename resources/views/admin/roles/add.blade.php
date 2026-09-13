@extends('index')
@push('title', get_phrase('Role Create'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Role Create') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Role Create') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap py-3">
                <p class="column-title mb-2">{{ get_phrase('Roles') }}</p>

                @php
                    $permission = \Spatie\Permission\Models\Permission::orderBy('name', 'asc')->get();
                @endphp

                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="eForm-label">{{ get_phrase('Name') }}</label>
                                <input type="text" name="name" placeholder="Name" class="eForm-label form-control">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="eForm-label">{{ get_phrase('Permission') }}</label><br>
                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <label class="eForm-label d-block" style="text-transform: capitalize">
                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                    class="name">
                                                {{ str_replace('-', ' ', $value->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 pt-3">
                            <button type="submit" class="btn-form  btn-primary">{{ get_phrase('Submit') }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
