@php
    $branches = DB::table('branches')->get();
    $roles = DB::table('roles')->where('name', '!=', 'Admin')->get();
@endphp


<form action="{{ route('admin.staff.profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="fpb-7">
        <label for="eInputName" class="eForm-label">{{ get_phrase('Name') }}</label>
        <input value="{{ $user->name }}" name="name" type="text" class="form-control eForm-control" id="eInputName"
            placeholder="Enter your name" aria-label="Enter your name" required />
    </div>

    {{-- <div class="fpb-7">
        <label for="branch_id" class="eForm-label">{{get_phrase('Branch')}}</label>
        <select class="form-select eForm-select select2" id="branch_id" name="branch_id">
            @php $branches = DB::table('branches')->get(); @endphp

            <option value="">{{get_phrase('Select a branch')}}</option>
            @foreach ($branches as $branch)
                <option value="{{ $user->branch_id }}" @if ($branch->id == $user->branch_id) selected @endif>{{ $branch->title }}</option>
            @endforeach
        </select>
    </div> --}}

    @php
        $branches = DB::table('branches')->get();
    @endphp

    <div class="row">
        <div class="col-md-4">
            <div class="fpb-7">
                <label for="branch_id" class="eForm-label">{{ get_phrase('Branch') }}</label>
                <select class="form-select eForm-select select2" id="branch_id" name="branch_id">
                    <option value="" disabled selected>{{ get_phrase('Select a branch') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $branch->id == $user->branch_id ? 'selected' : '' }}>
                            {{ $branch->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="fpb-7">
                <label for="department_id" class="eForm-label">{{ get_phrase('Department') }}</label>
                <select name="department_id" id="department_id" class="form-select eForm-select select2">
                    <option value="" disabled>--Select Department--</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="fpb-7">
                <label for="designation_id" class="eForm-label">{{ get_phrase('Designation') }}</label>
                <select name="designation_id" id="designation_id" class="form-select eForm-select select2">
                    <option value="" disabled>--Select Designation--</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Store current user selections --}}
    <input type="hidden" id="selected_department" value="{{ $user->department }}">
    <input type="hidden" id="selected_designation" value="{{ $user->designation }}">


    <div class="fpb-7">
        <label for="eInputEmail" class="eForm-label">{{ get_phrase('Email') }}</label>
        <input value="{{ $user->email }}" name="email" type="email" class="form-control eForm-control"
            id="eInputEmail" placeholder="Enter your email address" aria-label="Enter your email address" required />
    </div>

    <div class="fpb-7">
        <label for="eClassList" class="eForm-label">{{ get_phrase('Role') }}</label>
        <select name="role" class="form-select eForm-select select2" required>
            {{-- <option value="staff" @if ($user->role == 'staff') selected @endif>{{ get_phrase('Staff') }}</option> --}}
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="fpb-7">
        <label for="eSectionList" class="eForm-label">{{ get_phrase('Blood group') }}</label>
        <select name="blood_group" class="form-select eForm-select select2" data-placeholder="Selecte a blood group">
            <option value="">{{ get_phrase('Select a blood group') }}</option>
            <option value="A+" @if ($user->blood_group == 'A+') selected @endif>{{ get_phrase('A Positive') }}
                (A+)</option>
            <option value="A-" @if ($user->blood_group == 'A-') selected @endif>{{ get_phrase('A Negative') }}
                (A-)</option>
            <option value="B+" @if ($user->blood_group == 'B+') selected @endif>{{ get_phrase('B Positive') }}
                (B+)</option>
            <option value="B-" @if ($user->blood_group == 'B-') selected @endif>{{ get_phrase('B Negative') }}
                (B-)</option>
            <option value="O+" @if ($user->blood_group == 'O+') selected @endif>{{ get_phrase('O Positive') }}
                (O+)</option>
            <option value="O-" @if ($user->blood_group == 'O-') selected @endif>{{ get_phrase('O Negative') }}
                (O-)</option>
            <option value="AB+" @if ($user->blood_group == 'AB+') selected @endif>{{ get_phrase('AB Positive') }}
                (AB+)</option>
            <option value="AB-" @if ($user->blood_group == 'AB-') selected @endif>{{ get_phrase('AB Negative') }}
                (AB-)</option>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eBrithDay" class="eForm-label">{{ get_phrase('Birthday') }}</label>
                <input type="text" class="form-control eForm-control date-range-picket" id="eInputDate"
                    name="birthday" value="{{ date('m/d/Y', strtotime($user->birthday)) }}" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="fpb-7">
            <label for="" class="eForm-label">{{ get_phrase('Joining Date') }}</label>
            <input type="date" class="form-control eForm-control date-range-picked" name="join_date"
                value="{{ date('Y-m-d', strtotime($user->join_date)) }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="" class="eForm-label">{{ get_phrase('Reporting Manager') }}</label>
                <input type="text" class="form-control eForm-control" name="manager" value="{{ $user->manager }}"
                    placeholder="Enter the reporting manger">
            </div>
        </div>

        <div class="col-md-6">
            <div class="fpb-7">
                <label for="eGenderList" class="eForm-label">{{ get_phrase('Gender') }}</label>
                <select name="gender" class="form-select eForm-select select2" required>
                    <option value="male" @if ($user->gender == 'Male') selected @endif>{{ get_phrase('Male') }}
                    </option>
                    <option value="female" @if ($user->gender == 'Female') selected @endif>
                        {{ get_phrase('Female') }}
                    </option>
                    <option value="other" @if ($user->gender == 'Other') selected @endif>
                        {{ get_phrase('Other') }}
                    </option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="" class="eForm-label">{{ get_phrase('Employe type') }}</label>
                <select name="employ_type" class="form-select eForm-select select2" id="">
                    <option value="full_time" @if ($user->employ_type == 'full_time') selected @endif>
                        {{ get_phrase('Full Time') }}</option>
                    <option value="part_time" @if ($user->employ_type == 'part_time') selected @endif>
                        {{ get_phrase('Part Time') }}</option>
                    <option value="contract" @if ($user->employ_type == 'contract') selected @endif>
                        {{ get_phrase('Contract') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="fpb-7">
                <label for="" class="eForm-label">{{ get_phrase('Shift Timing') }}</label>
                <input type="text" class="form-control eForm-control" placeholder="10AM - 6PM"
                    value="{{ $user->shift }}" name="shift">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Status') }}</label>
                <select name="status" class="form-control eForm-select select2" id="">
                    <option value="active" @if ($user->status == 'active') selected @endif>
                        {{ get_phrase('Active') }}</option>
                    <option value="inactive" @if ($user->status == 'inactive') selected @endif>
                        {{ get_phrase('Inactive') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">Salary(Monthly)</label>
                <input type="text" class="form-control eForm-control" name="salary" value="{{ $user->salary }}"
                    placeholder="Enter monthly salary">
            </div>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">PAN Number</label>
                <input type="text" class="form-control eForm-control" name="pan_no"
                    value="{{ $user->pan_no }}" placeholder="Enter PAN Number">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">Aadhar Number</label>
                <input type="text" class="form-control eForm-control" name="aadhar" value="{{ $user->aadhar }}"
                    placeholder="Enter Aadhar Number">
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">Bank Account Number</label>
                <input type="text" class="form-control eForm-control" name="bank_account_n"
                    value="{{ $user->bank_account_no }}" placeholder="Enter Bank Account Number">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">IFSC Code</label>
                <input type="text" class="form-control eForm-control" name="ifsc_code"
                    value="{{ $user->ifsc_code }}" placeholder="Enter IFSC Code">
            </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">Emergency Contact Name</label>
                <input type="text" class="form-control eForm-control" name="emg_contact_name"
                    value="{{ $user->emg_contact_name }}" placeholder="Enter emergency contact name">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="eForm-label">Emergency Contact Number</label>
                <input type="text" class="form-control eForm-control" name="emg_contact_number"
                    value="{{ $user->emg_contact_number }}" placeholder="Enter emergency contact number">
            </div>
        </div>
    </div>


    <div class="row pt-3">
        <div class="col-md-4">
            <div class="fpb-7">
                <label for="eInputPhone" class="eForm-label">{{ get_phrase('Phone Number') }}</label>
                <input value="{{ $user->phone }}" name="phone" type="text" class="form-control eForm-control"
                    id="eInputPhone" placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="fpb-7">
                <label for="alternative_phone"
                    class="eForm-label">{{ get_phrase('Alternative phone number') }}</label>
                <input value="{{ $user->alternative_phone }}" name="alternative_phone" type="text"
                    class="form-control eForm-control" id="alternative_phone" placeholder="01XXXXXXXXX"
                    aria-label="01XXXXXXXXX" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="fpb-7">
                <label for="rel_of_alternative_phone"
                    class="eForm-label">{{ get_phrase('Relationship of Contact person') }}</label>
                <input value="{{ $user->rel_of_alternative_phone }}" name="rel_of_alternative_phone" type="text"
                    class="form-control eForm-control" id="alternative_phone" placeholder="01XXXXXXXXX"
                    aria-label="01XXXXXXXXX" />
            </div>
        </div>
    </div>

    <div class="fpb-7">
        <label for="eInputAddress" class="eForm-label">{{ get_phrase('Present Address') }}</label>
        <input value="{{ $user->present_address }}" name="present_address" type="text"
            class="form-control eForm-control" id="eInputAddress" placeholder="Enter your present address"
            aria-label="Enter your present address" />
    </div>
    <div class="fpb-7">
        <label for="eInputAddress2" class="eForm-label">{{ get_phrase('Permanent Address') }}</label>
        <input value="{{ $user->permanent_address }}" name="permanent_address" type="text"
            class="form-control eForm-control" id="eInputAddress2" placeholder="Enter your permanent address"
            aria-label="Enter your permanent address" />
    </div>
    <div class="fpb-7">
        <label for="eInputTextarea" class="eForm-label">{{ get_phrase('Bio') }}</label>
        <textarea name="bio" class="form-control eForm-control" id="eInputTextarea">{{ $user->bio }}</textarea>
    </div>
    <div class="fpb-7">
        <label for="photo" class="eForm-label">{{ get_phrase('Photo') }}</label>
        <input type="file" name="photo" class="form-control eForm-control-file" id="photo"
            accept="image/*">
    </div>

    <div class="fpb-7 mt-4">
        <button type="submit" class="eBtn btn-primary">{{ get_phrase('Save Changes') }}</button>
    </div>
</form>

@include('initedit')
