
@php
    $recruitments = DB::table('recruitments')->get();
@endphp

<style>
    .ck-editor__editable,
    .ck-editor__editable_inline {
        min-height: 300px !important;   /* Set your height */
    }
</style>


<form action="{{ route('admin.onboarding.store') }}" method="post">
    @csrf

    <div class="row">

        {{-- Title --}}
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Title') }}</label>
            <input type="text" name="title" class="form-control eForm-control" id="title" required />
        </div>

        {{-- Description --}}
        <div class="col-md-12 mt-3">
            <label for="description" class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="form-control eForm-control" id="description" rows="3"></textarea>
        </div>

        {{-- Email Template --}}
        <div class="col-md-12 mt-3">
            <label for="email_template" class="eForm-label">{{ get_phrase('Email Template') }}</label>
            <textarea name="email_template" id="email_template" class="form-control eForm-control" rows="6"></textarea>
        </div>

        {{-- Submit --}}
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">
                {{ get_phrase('Add') }}
            </button>
        </div>
    </div>
</form>

@include('candidatejs')

