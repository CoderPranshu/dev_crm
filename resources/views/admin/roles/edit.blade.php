@extends('index')
@push('title', get_phrase('Role Edit'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Role Edit') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.role.index') }}">{{ get_phrase('Roles') }}</a></li>
                    <li><a href="#">{{ get_phrase('Edit Role') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap py-3">
                <p class="column-title mb-2">{{ get_phrase('Roles') }}</p>
                    @php
                        $role = \Spatie\Permission\Models\Role::where('id', $id)->first();
                    
                        // Sort permissions alphabetically by name
                        $permission = \Spatie\Permission\Models\Permission::orderBy('name', 'asc')->get();
                    
                        $rolePermissions = DB::table('role_has_permissions')
                            ->where('role_has_permissions.role_id', $id)
                            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                            ->all();
                    @endphp
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @csrf
                    {{-- @method('PATCH') --}}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="eForm-label">{{ get_phrase('Name') }}</label>
                                <input type="text" name="name" value="{{ $role->name }}" placeholder="Name"
                                    class="eForm-control form-control">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 pt-3">
                            <div class="form-group">
                                <label class="eForm-label">{{ get_phrase('Permission') }}</label><br>

                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="col-md-4">
                                            <label class="eForm-label" style="text-transform: capitalize">
                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                    class="name"
                                                    {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                {{ str_replace('-', ' ', $value->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn-form w-100 btn-primary">{{ get_phrase('Submit') }}</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
@stop
