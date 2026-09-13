@php
    $candi = DB::table('candidates')->where('id', $id)->first();
    $recruitment = DB::table('recruitments')->get();
@endphp

<form action="{{ route('admin.candidate.update',$candi->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="name" class="eForm-label">{{get_phrase('Name')}}</label>
            <input type="text" name="name" class="form-control eForm-control" value="{{ $candi->name }}" id="name" />
        </div>

        <div class="col-md-12 mt-3">
            <label for="email" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" class="form-control eForm-control" id="email"  value="{{ $candi->email }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="phone" class="eForm-label">{{ get_phrase('Phone') }}</label>
            <input type="tel" name="phone" class="form-control eForm-control" id="phone" value="{{ $candi->phone }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="address" class="eForm-label">{{ get_phrase('Address') }}</label>
            <input type="text" class="form-control eForm-control" name="address" id="address" value="{{ $candi->address }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="source" class="eForm-label">{{ get_phrase('Source') }}</label>
            <input type="text" class="form-control eForm-control" name="source" id="source" value="{{ $candi->source }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="country" class="eForm-label">{{ get_phrase('Country') }}</label>
            <input type="text" class="form-control eForm-control" name="country" id="country" value="{{ $candi->country }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="state" class="eForm-label">{{ get_phrase('State') }}</label>
            <input type="text" class="form-control eForm-control" name="state" id="state" value="{{ $candi->state }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="resume" class="eForm-label">{{ get_phrase('Resume') }}</label>
            <input type="file" class="form-control eForm-control" name="resume" id="resume"/>
            <a target="_blank" class="eForm-label text-info" href="{{ asset('uploads/resume/'.$candi->resume) }}">Download Resume</a>
        </div>

        <div class="col-md-12 mt-3">
            <label for="dob" class="eForm-label"> Date Of Birth</label>
            <input type="date" class="form-control eForm-control" name="dob" id="dob" value="{{ $candi->dob }}"/>
        </div>

        <div class="col-md-12 mt-3">
            <label for="" class="eForm-label">Document</label>
            <input type="file" class="form-control eForm-control" name="document" value="">
            @if($candi->document)
                <a target="_blank" class="eForm-label text-info" href="{{ asset('uploads/document/'.$candi->document) }}">Download Document</a>
            @endif
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Recruitment</label>
            <select name="recruitment_id" class="form-control eForm-control" id="">
                <option value="" selected disabled>Select Recruitment</option>
                @foreach ($recruitment as $rec)
                    <option value="{{ $rec->id }}" {{ $rec->id == $candi->recruitment_id ? 'selected' : '' }}>{{ $rec->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>
