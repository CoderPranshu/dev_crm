@php
    $sub = DB::table('subscribers')->first();
@endphp

<form action="{{ route('admin.subscriber.update', $sub->id) }}" method="post" enctype="multipart/form-data">
    @Csrf

    <div class="row">
        <div class="col-md-12">
            <label for="title" class="eForm-label">{{ get_phrase('Name') }}</label>
            <input type="text" name="name" value="{{ $sub->name }}" class="form-control eForm-control"
                id="title" />
        </div>

        <div class="col-md-12 pt-3">
            <label for="days" class="eForm-label">{{ get_phrase('Email') }}</label>
            <input type="email" name="email" value="{{ $sub->email }}" class="form-control eForm-control"
                id="days">
        </div>

        @php
            $branches = App\Models\Branch::get();
        @endphp
        <div class="col-md-12 mt-2">
            <label class="eForm-label">Branches</label>
            @if (auth()->user()->hasRole('Admin'))
                <select name="branch_id" class="form-control eForm-control" required>
                    <option value="">{{ get_phrase('Select Branch') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $sub->branch_id == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                <p class="eForm-control">{{ auth()->user()->branch->title }}</p>
            @endif
        </div>

        <div class="col-md-12 mt-3">
            <label for="recruitment" class="eForm-label">Status</label>
            <select name="status" class="form-control eForm-control" id="recruitmentSelect">
                <option selected disabled>Select status</option>
                <option value="active" @if ($sub->status == 'active') selected @endif>Status</option>
                <option value="inactive" @if ($sub->status == 'inactive') selected @endif>Inactive</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form my-2 w-100">{{ get_phrase('Update') }}</button>
        </div>
    </div>
</form>

@include('candidatejs')
