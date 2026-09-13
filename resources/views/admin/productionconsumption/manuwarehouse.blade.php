@php
    $sales = App\Models\SalesOrder::find($id);
    $branches = App\Models\Branch::get();
@endphp

<form action="{{ route('admin.product.manufacture', $sales->id) }}" method="POST">
    @csrf

    <div class="form-group">
        <label class="eForm-label">Branch</label>
        @if (auth()->user()->hasRole('Admin'))
<select name="branch" class="eForm-control eForm-select form-control">
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->title }}</option>
            @endforeach
        </select>
        @else
         <input type="text" class="form-control eForm-control" value="{{ auth()->user()->branch->title }}" readonly >
        @endif
    </div>

    <div class="form-group pt-3">
        <button class="btn btn-form w-100" type="submit">Submit</button>
    </div>
</form>
