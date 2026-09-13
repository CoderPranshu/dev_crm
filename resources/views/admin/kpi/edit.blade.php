@php
    $department = DB::table('departments')->get();
    $kpi = DB::table('kpis')->where('id', $id)->first();
    $branches = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.kpi.update', $kpi->id) }}" method="POST">
    @Csrf

    <div class="row">

        <div class="col-md-12">
            <label class="eForm-label">{{ get_phrase('Title') }}</label>
            <input type="text" class="form-control eForm-control" name="title" value="{{ $kpi->title }}" required>
        </div>

        <div class="col-md-12 mt-2">
            <label class="eForm-label">{{ get_phrase('Description') }}</label>
            <textarea name="description" class="form-control eForm-control" rows="3">{{ $kpi->description }}</textarea>
        </div>

        {{-- Branch --}}
        <div class="fpb-7">
            <label class="eForm-label">{{ get_phrase('Branch') }}</label>
            <select class="form-select eForm-select select2" id="branch_id" name="branch_id"
                data-selected="{{ $kpi->branch_id }}">
                <option value="">-- Select Branch --</option>
                @foreach ($branches as $row)
                    <option value="{{ $row->id }}" {{ $row->id == $kpi->branch_id ? 'selected' : '' }}>
                        {{ $row->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Department --}}
        <div class="fpb-7">
            <label class="eForm-label">{{ get_phrase('Department') }}</label>
            <select class="form-select eForm-select select2" id="department_id" name="department_id"
                data-selected="{{ $kpi->department_id }}">
                <option value="">-- Select Department --</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn-form w-100">
                {{ get_phrase('Update KRA') }}
            </button>
        </div>

    </div>
</form>

@include('jseditkra')
