@extends('index')

@push('title', get_phrase('Subscription Categories'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>Subscription Categories</h4>

        <a href="{{ route('admin.subscription-categories.create') }}"
            class="btn btn-primary">
            Add Category
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($categories as $key => $category)

                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>{{ $category->name }}</td>

                    <td>
                        @if($category->status)
                            Active
                        @else
                            Inactive
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('admin.subscription-categories.edit',$category->id) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.subscription-categories.destroy',$category->id) }}"
                            method="POST"
                            style="display:inline-block">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete?')"
                                class="btn btn-sm btn-danger">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4">
                        No Data Found
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

@endsection

@push('js')
<script>

</script>
@endpush