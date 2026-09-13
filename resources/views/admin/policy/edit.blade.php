@php
    $policy = DB::table('policies')->where('id', $id)->first();
@endphp

<form action="{{ route('admin.policy.update', $policy->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
            <input type="text" name="title" class="form-control eForm-control" value="{{ $policy->title }}" id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Date') }}</label>
            <input type="date" name="date" class="form-control eForm-control" value="{{ $policy->date }}" id="days">
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="form-control eForm-control" id="description" rows="4">{{ $policy->description }}</textarea>
        </div>

        <div class="col-md-12 pt-3">
            <label for="document" class="eForm-label">{{ get_phrase('Document') }}</label>
            <input type="file" name="document" class="form-control eForm-control" id="document">
            @if ($policy->document != null)
                <a class="eForm-label text-info" href="{{ asset('uploads/document/' . $policy->document) }}" target="_blank">{{ get_phrase('View Document') }}</a>
            @endif
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{get_phrase('Update')}}</button>
        </div>
    </div>
</form>

@include('candidatejs')
