@php
    $categories = DB::table('lead_categories')->get();
    $users = DB::table('users')->where('role', '!=', 'admin')->where('department', '3')->get();
    $lead = DB::table('leads')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.leads.change_status', $lead->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <div class="fpb-7">
                <label class="eForm-label">{{ get_phrase('Status') }}</label>
                <select name="status" class="form-select eForm-select select2" id="">
                    <option value="">--Select Status--</option>
                    <option value="accept" {{ $lead->status == 'accept' ? 'selected' : '' }}>{{ get_phrase('Accept') }}</option>
                    <option value="reject" {{ $lead->status == 'reject' ? 'selected' : '' }}>{{ get_phrase('Reject') }}</option>
                    <option value="call" {{ $lead->status == 'call' ? 'selected' : '' }}>{{ get_phrase('Call Again') }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-2 d-none" id="call_schedule_box">
            <label class="eForm-label">{{ get_phrase('Call Schedule Date & Time') }}</label>
            <input type="datetime-local" name="call_schedule" class="form-control eForm-control">
        </div>

        <div class="col-md-12 mt-2">
            <div class="fpb-7">
                <label for="" class="eForm-label">{{ get_phrase('Assign to') }}</label>
                <select name="user_id" class="form-select eForm-select select2" id="">
                    <option value="" selected>--Select User--</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $lead->user_id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-2">
            <label for="" class="eForm-label">{{ get_phrase('Remarks') }}</label>
            <textarea name="remarks" class="form-control eForm-control" id="" cols="30" rows="4">{{ $lead->remarks }}</textarea>
        </div>

        <div class="col-md-12 mt-2">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add') }}</button>
        </div>
    </div>
</form>
@include('init')
