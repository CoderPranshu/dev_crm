@php
    $candidate = DB::table('candidates')->where('id', $id)->first();
    $stages = DB::table('on_boardings')->get();
@endphp
<form action="{{ route('admin.onboardingstage.update', $candidate->id) }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Onboarding Stage</label>
            <select name="onboarding" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select Stage</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}">{{ $stage->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>
