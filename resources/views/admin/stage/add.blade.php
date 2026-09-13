
@php
    $recruitments = DB::table('recruitments')->get();
@endphp

<form action="{{ route('admin.stage.store') }}" method="post">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title" />
        </div>

        {{-- <div class="col-md-12 pt-3">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Select Recruitment') }}</label>
            <select name="recruitment_id" class="form-control form-select eForm-control">
                <option value="">{{ get_phrase('Select Recruitment') }}</option>
                @foreach($recruitments as $recruitment)
                    <option value="{{ $recruitment->id }}">{{ $recruitment->title }}</option>
                @endforeach
            </select>
            </div>
        </div> --}}

        <input type="hidden" name="recruitment_id" value="{{ request('recruitment_id') }}">


        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Add')}}</button>
        </div>
    </div>
</form>
