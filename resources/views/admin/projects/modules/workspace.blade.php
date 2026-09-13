@extends('index')

@section('title','My Modules')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-1">
                My Modules
            </h3>

            <p class="text-muted mb-0">
                View all assigned, accepted, rejected and reassign requests.
            </p>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <ul class="nav nav-tabs mb-4" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#assigned" type="button">
                        Assigned
                        <span class="badge bg-primary ms-1">{{ $assigned->count() }}</span>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#accepted" type="button">
                        Accepted
                        <span class="badge bg-success ms-1">{{ $accepted->count() }}</span>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                        Rejected
                        <span class="badge bg-danger ms-1">{{ $rejected->count() }}</span>
                    </button>
                </li>

                @if(auth()->user()->hasRole('Admin') || auth()->id() == $leadDeveloperId)

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reassign" type="button">
                        Reassign Requests
                        <span class="badge bg-warning text-dark ms-1">{{ $reassignRequests->count() }}</span>
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#allmodules" type="button">
                        All Modules
                        <span class="badge bg-secondary ms-1">{{ $allModules->count() }}</span>
                    </button>
                </li>

                @endif

            </ul>

            <div class="tab-content">

                {{-- ========================= --}}
                {{-- Assigned Modules --}}
                {{-- ========================= --}}
                <div class="tab-pane fade show active" id="assigned">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Module</th>
                                    <th>Assigned By</th>
                                    <th>Assigned Date</th>
                                    <th>Status</th>
                                    <th width="220">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($assigned as $assignment)

                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $assignment->module->project->project_name ?? '-' }}</td>

                                        <td>
                                            <strong>{{ $assignment->module->module_name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $assignment->module->department->title ?? '' }}
                                            </small>
                                        </td>

                                        <td>{{ $assignment->assignedBy->name ?? '-' }}</td>

                                        <td>{{ optional($assignment->assigned_at)->format('d M Y h:i A') }}</td>

                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>

                                        <td>

                                            <div class="d-flex gap-2">

                                                {{-- Accept --}}
                                                <form action="{{ route('admin.modules.requests.accept',$assignment->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm">Accept</button>
                                                </form>

                                                {{-- Reject --}}
                                                <button
                                                    class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $assignment->id }}">
                                                    Reject
                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                    {{-- Reject Modal --}}
                                    <div class="modal fade" id="rejectModal{{ $assignment->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('admin.modules.requests.reject',$assignment->id) }}" method="POST">
                                                    @csrf

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Module</h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Reject Reason</label>
                                                            <textarea class="form-control" name="reason" rows="4" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                                        <button class="btn btn-danger">Reject Module</button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center">No Assigned Modules</td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- ========================================= --}}
                {{-- Accepted Tab --}}
                {{-- ========================================= --}}
                <div class="tab-pane fade" id="accepted">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Module</th>
                                    <th>Accepted Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                            @forelse($accepted as $assignment)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $assignment->module->project->project_name ?? '-' }}</td>

                                    <td>
                                        <strong>{{ $assignment->module->module_name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $assignment->module->department->title ?? '' }}
                                        </small>
                                    </td>

                                    <td>{{ optional($assignment->accepted_at)->format('d M Y h:i A') }}</td>

                                    <td>
                                        <span class="badge bg-success">Accepted</span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center">No Accepted Modules</td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- ========================================= --}}
                {{-- Rejected Tab (history — every rejection by this developer) --}}
                {{-- ========================================= --}}
                <div class="tab-pane fade" id="rejected">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Module</th>
                                    <th>Rejected Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                            @forelse($rejected as $assignment)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $assignment->module->project->project_name ?? '-' }}</td>

                                    <td>
                                        <strong>{{ $assignment->module->module_name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $assignment->module->department->title ?? '' }}
                                        </small>
                                    </td>

                                    <td>{{ optional($assignment->rejected_at)->format('d M Y h:i A') }}</td>

                                    <td>{{ $assignment->reason }}</td>

                                    <td>
                                        @if($assignment->is_current)
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Rejected (Reassigned)</span>
                                        @endif
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center">No Rejected Modules</td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- ========================================= --}}
                {{-- Reassign Requests Tab --}}
                {{-- $reassignRequests = ProjectModuleAssignment rows, rejected + is_current=true --}}
                {{-- ========================================= --}}
                @if(auth()->user()->hasRole('Admin') || auth()->id() == $leadDeveloperId)

                <div class="tab-pane fade" id="reassign">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Module</th>
                                    <th>Rejected By</th>
                                    <th>Rejected Date</th>
                                    <th>Reason</th>
                                    <th width="260">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                            @forelse($reassignRequests as $assignment)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $assignment->module->project->project_name ?? '-' }}</td>

                                    <td>
                                        <strong>{{ $assignment->module->module_name }}</strong>
                                    </td>

                                    <td>{{ $assignment->assignedTo->name ?? '-' }}</td>

                                    <td>{{ optional($assignment->rejected_at)->format('d M Y h:i A') }}</td>

                                    <td>{{ $assignment->reason }}</td>

                                    <td>

                                        <form action="{{ route('developer.modules.reassign',$assignment->id) }}" method="POST">
                                            @csrf

                                            <div class="row g-2">

                                                <div class="col-8">
                                                    <select class="form-select form-select-sm" name="assigned_to" required>
                                                        <option value="">Select Developer</option>
                                                        @foreach($developers as $developer)
                                                            <option value="{{ $developer->id }}">
                                                                {{ $developer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-4">
                                                    <button class="btn btn-primary btn-sm w-100">Reassign</button>
                                                </div>

                                            </div>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center">No Reassign Requests</td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                @endif

                {{-- ========================================= --}}
                {{-- All Modules Tab (Admin / Lead) --}}
                {{-- $allModules = ProjectModule rows with ->currentAssignment loaded --}}
                {{-- Shows every module in scope, regardless of assignee --}}
                {{-- ========================================= --}}
                @if(auth()->user()->hasRole('Admin') || auth()->id() == $leadDeveloperId)

                <div class="tab-pane fade" id="allmodules">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Module</th>
                                    <th>Department</th>
                                    <th>Current Assignee</th>
                                    <th>Assigned Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                            @forelse($allModules as $module)

                                @php
                                    $status = $module->currentAssignment->status ?? 'unassigned';
                                @endphp

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $module->project->project_name ?? '-' }}</td>

                                    <td>
                                        <strong>{{ $module->module_name }}</strong>
                                    </td>

                                    <td>{{ $module->department->title ?? '-' }}</td>

                                    <td>{{ $module->currentAssignment->assignedTo->name ?? 'Unassigned' }}</td>

                                    <td>
                                        {{ optional($module->currentAssignment?->assigned_at)->format('d M Y h:i A') ?? '-' }}
                                    </td>

                                    <td>

                                        @switch($status)

                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break

                                            @case('accepted')
                                                <span class="badge bg-success">Accepted</span>
                                                @break

                                            @case('rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                                @break

                                            @default
                                                <span class="badge bg-secondary">Unassigned</span>

                                        @endswitch

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center">No Modules Found</td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                @endif

            </div> {{-- tab-content --}}

        </div>

    </div>

</div>

@endsection