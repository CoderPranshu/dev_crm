@extends('index')
@push('title', 'SEO Plan Clients')

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>SEO Plan Clients</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li>SEO Plan Clients</li>
            </ul>
        </div>

        @can('seo-assign-client-create')
            <div class="export-btn-area">
                <a href="{{ route('admin.seo-plan-clients.create') }}" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span>Add Client</span>
                </a>
            </div>
        @endcan

        
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">

            <table class="table eTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Assign Team</th>
                        <th>SEO Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    
                        @can('seo-assign-client-delete')
                           <th>Action</th>
                        @endcan
                    </tr>
                </thead>

                <tbody>
                    @foreach($assignments as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->company->name ?? '-' }}</td>
                         <td>{{ $item->team->name ?? '-' }}</td>
                        <td>{{ $item->seoPlan->name ?? '-' }}</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>
                        <td>
                            <span class="badge bg-success">{{ $item->status }}</span>
                        </td>

                        @can('seo-assign-client-delete')
                            <td>
                                <form action="{{ route('admin.seo-plan-clients.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        @endcan
                        
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection