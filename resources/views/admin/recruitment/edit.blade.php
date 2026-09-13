@php
    $recruitment = DB::table('recruitments')->where('id', $id)->first();
    $managers = DB::table('users')
    ->where('branch_id', $recruitment->branch_id)
    ->where('is_manager', 1)
    ->get();
    $branches = DB::table('branches')->get();
    $departments = DB::table('departments')->get();
    $positions = DB::table('designations')->get();
@endphp

<form action="{{ route('admin.recruitment.update', $recruitment->id) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Title') }}</label>
            <input type="text" value="{{ $recruitment->title }}" name="title" class="form-control eForm-control"
                id="title" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="description" class="eForm-label">{{ get_phrase('Description') }}<small
                    class="text-muted">({{ get_phrase('Optional') }})</small></label>
            <textarea name="description" class="form-control eForm-control" rows="2">{{ $recruitment->description }}</textarea>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Start Date') }}</label>
            <input type="datetime-local" value="{{ $recruitment->start_date }}" name="start_date"
                class="form-control eForm-control">
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('End Date') }}</label>
            <input type="datetime-local" name="end_date" value="{{ $recruitment->end_date }}"
                class="form-control eForm-control">
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Branch') }}</label>
            <select name="branch_id" id="branch_id" class="form-control eForm-control">
                <option value="">{{ get_phrase('Select Branch') }}</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}"
                        {{ $branch->id == $recruitment->branch_id ? 'selected' : '' }}>{{ $branch->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Department') }}</label>
            <select name="department_id" class="form-control eForm-control">
                <option value="">{{ get_phrase('Select Department') }}</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}"
                        {{ $department->id == $recruitment->department_id ? 'selected' : '' }}>
                        {{ $department->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Position') }}</label>
            <select name="position" class="form-control eForm-control">
                <option value="">{{ get_phrase('Select Position') }}</option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}"
                        {{ $position->id == $recruitment->position ? 'selected' : '' }}>
                        {{ $position->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Manager') }}</label>
            <select name="manager_id" id="manager_id" class="form-control eForm-control">
                <option value="">{{ get_phrase('Select Manager') }}</option>
                @foreach ($managers as $manager)
                    <option value="{{ $manager->id }}" {{ $manager->id == $recruitment->manager_id ? 'selected' : '' }}>{{ $manager->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>


<script>
    $('#branch_id').on('change', function () {
        let branch_id = $(this).val();

        if (branch_id) {
            $.ajax({
                url: '/admin/get-managers/' + branch_id,
                type: 'GET',
                success: function (data) {
                    let managerDropdown = $('#manager_id');
                    managerDropdown.empty();
                    managerDropdown.append('<option value="">Select Manager</option>');

                    data.forEach(function (manager) {
                        managerDropdown.append(
                            `<option value="${manager.id}">${manager.name}</option>`
                        );
                    });
                }
            });
        } else {
            $('#manager_id').empty().append('<option value="">Select Manager</option>');
        }
    });
</script>
