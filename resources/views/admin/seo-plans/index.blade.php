@extends('index')

@push('title', get_phrase('SEO Plans'))

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <div>

            <h4>{{ get_phrase('SEO Plans') }}</h4>

        </div>

        <div>

        
           @can('seo-plan-create')

           <a href="{{ route('admin.seo-plans.create') }}" class="btn btn-primary">

                <i class="fi-rr-plus"></i>

                Add SEO Plan

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
                    <th>SEO Service</th>
                    <th>Plan Name</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Created</th>
                   

                    @can('seo-plan-edit')

                    <th>Edit</th>

                    @endcan

                    @can('seo-plan-delete')

                    <th>Delete</th>

                    @endcan

                </tr>

            </thead>

            <tbody>

                @forelse($seoPlans as $plan)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $plan->service->name ?? '-' }}

                        </td>

                        <td>

                            {{ $plan->name }}

                        </td>

                        <td>

                            {{ $plan->duration }} Month{{ $plan->duration > 1 ? 's' : '' }}

                        </td>

                        <td>

                            @if($plan->status)

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

                            {{ $plan->created_at->format('d M Y') }}

                        </td>

                        @can('seo-plan-edit')
                            <td>
                                <a class="dropdown-item"
                                                href="{{ route('admin.seo-plans.edit', $plan->id) }}">

                                                    

                                                    <i class="fi-rr-pencil"></i>

                                </a>
                            </td>
                        @endcan

                       

                        @can('seo-plan-edit')
                            <td>

                                <form action="{{ route('admin.seo-plans.destroy', $plan->id) }}"
                                                    method="POST"
                                                    style="display:inline;">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="dropdown-item text-danger"
                                                            onclick="return confirm('Are you sure you want to delete this SEO Plan?')">

                                                        <i class="fi-rr-trash-xmark"></i>

                                                    </button>

                                </form>
                                
                            </td>
                        @endcan

                      

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            No SEO Plans Found

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