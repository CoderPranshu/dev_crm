@extends('index')

@push('title', get_phrase('SEO Services'))

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h4>{{ get_phrase('SEO Services') }}</h4>

        </div>

        <div>

           @can('seo-service-create')
                <a href="{{ route('admin.seo-services.create') }}" class="btn btn-primary">

                        <i class="fi-rr-plus"></i>

                        Add SEO Service

                </a>
           @endcan
        </div>

    </div>

</div>

<div class="eSection-wrap">

    <div class="table-responsive">

        <table class="table eTable">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Service Name</th>

                    <th>Description</th>

                    <th>Status</th>

                    <th>Created</th>

                    @can('seo-service-edit')

                      <th>Edit</th>

                    @endcan

                    @can('seo-service-delete')

                      <th>Delete</th>

                    @endcan

                </tr>

            </thead>

            <tbody>

                @forelse($seoServices as $service)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $service->name }}

                        </td>

                        <td>

                            {{ $service->description ?? '-' }}

                        </td>

                        <td>

                            @if($service->status)

                                <span class="badge bg-success">

                                    Active

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Inactive

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $service->created_at->format('d M Y') }}

                        </td>

                        @can('seo-service-edit')
                            <td>
                            
                                <a class="dropdown-item"
                                    href="{{ route('admin.seo-services.edit', $service->id) }}">

                                    

                                    <i class="fi-rr-pencil"></i>

                                </a>
                                
                            </td>
                        @endcan

                         @can('seo-service-delete')
                            <td>
                                <form action="{{ route('admin.seo-services.destroy', $service->id) }}"
                                            method="POST"
                                            style="display:inline;">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                            class="dropdown-item text-danger"
                                            onclick="return confirm('Are you sure you want to delete this SEO Service?')">

                                        

                                        <i class="fi-rr-trash-xmark"></i>

                                    </button>

                                </form>
                            </td>

                          @endcan
                          
                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No SEO Services Found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('js')

<script>

</script>

@endpush