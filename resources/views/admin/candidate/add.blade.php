@php
    $recruitment = DB::table('recruitments')->get();
        $branches = DB::table('branches')->get();

@endphp

<form action="{{ route('admin.candidate.store') }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" class="form-control eForm-control" id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" class="form-control eForm-control" id="email" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="phone" class="eForm-label">{{ get_phrase('Phone') }}</label>
            <input type="tel" name="phone" class="form-control eForm-control" id="phone" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <input type="text" class="form-control eForm-control" name="address" id="address" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="source" class="eForm-label">{{ get_phrase('Source') }}</label>
            <input type="text" class="form-control eForm-control" name="source" id="source" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="country" class="eForm-label">{{ get_phrase('Country') }}</label>
            <input type="text" class="form-control eForm-control" name="country" id="country" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="state" class="eForm-label">{{ get_phrase('State') }}</label>
            <input type="text" class="form-control eForm-control" name="state" id="state" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="resume" class="eForm-label">{{ get_phrase('Resume') }}</label>
            <input type="file" class="form-control eForm-control" name="resume" id="resume" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="dob" class="eForm-label"> Date Of Birth</label>
            <input type="date" class="form-control eForm-control" name="dob" id="dob" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Recruitment</label>
            <select name="recruitment_id" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select Recruitment</option>
                @foreach ($recruitment as $rec)
                    <option value="{{ $rec->id }}">{{ $rec->title }}</option>
                @endforeach
            </select>
        </div>
        @if (auth()->user()->hasRole('Admin'))
        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">{{ get_phrase('Branch') }}</label>
            
                <select name="branch_id" class="form-control eForm-control" id="">
                    @foreach ($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->title }}</option>
                    @endforeach
                </select>
        </div>
         @else
                <input type="hidden" class="form-control eForm-control" value="{{ auth()->user()->branch_id }}" readonly>
            @endif

        <div class="col-md-12 mt-3">
            <label for="stage" class="eForm-label">Stage</label>
            <select name="stage_id" class="form-control eForm-control" id="stageDropdown">
                {{-- <option selected disabled>Select Stage</option> --}}
            </select>


        </div>


        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Add') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
