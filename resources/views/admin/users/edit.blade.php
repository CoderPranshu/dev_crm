@php
    $user = \App\Models\User::find($id);
    $roles = \Spatie\Permission\Models\Role::pluck('name', 'name')->all();
    $userRole = $user->roles->pluck('name', 'name')->all();
@endphp

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <label for="" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" class="eForm-control form-control" name="name" value="{{ $user->name }}" readonly>
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="text" class="eForm-control form-control" name="email" value="{{ $user->email }}" readonly>
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Assign Role') }}</label>
            <select name="roles[]" class="eForm-control form-control select2" multiple>
            @foreach ($roles as $role)
                <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>
                {{ $role }}</option>
            @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <button class="btn-form btn-primary w-100 mt-3" type="submit">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "{{ get_phrase('Select Role') }}"
                });
            });
        </script>


<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #00a3ff;
    border: 1px solid #00a3ff;
    border-radius: 4px;
    box-sizing: border-box;
    display: inline-block;
    margin-left: 5px;
    margin-top: 5px;
    padding: 0;
    padding-left: 20px;
    position: relative;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: bottom;
    white-space: nowrap;
    color: white;
    font-size: 12px;
}
</style>
