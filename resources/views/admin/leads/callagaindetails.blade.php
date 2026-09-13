@php
    $lead = \App\Models\Lead::find($id);
    $type = request('name');
@endphp

<form action="{{ route('admin.lead.notes') }}" method="post">
    @csrf
    <div class="row">
        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Message') }}</label>
                <textarea name="description" id="description" class="form-control eForm-control"
                    rows="3">{{ $lead->description }}</textarea>
            </div>
        </div>

        @if ($type == 'callagain')
                    <div class="col-md-12 pt-3">
            <div class="form-group">
                <label for="" class="eForm-label">{{ get_phrase('Next Date') }}</label>
                <input type="datetime-local" name="call_date" class="form-control eForm-control">
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn-form my-2 w-100">{{ get_phrase('Submit') }}</button>
            </div>
        </div>
    </div>
</form>



