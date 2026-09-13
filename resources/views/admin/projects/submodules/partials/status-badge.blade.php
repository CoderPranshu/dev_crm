{{--
    Usage: @include('admin.projects.submodules.partials.status-badge', ['status' => $submodule->status])

    Centralizes the status -> badge color mapping so every screen that
    shows a submodule status (index, my-tasks, workspace, review history)
    looks identical and only needs updating in one place.
--}}
@php
    $badgeMap = [
        'Pending' => 'bg-secondary',
        'Planning' => 'bg-info text-dark',
        'In Progress' => 'bg-primary',
        'Testing' => 'bg-warning text-dark',
        'Ready For Review' => 'bg-purple text-white',
        'Changes Requested' => 'bg-danger',
        'Approved' => 'bg-success',
        'Completed' => 'bg-success',
        'On Hold' => 'bg-dark',
        'Cancelled' => 'bg-danger',
    ];

    $badgeClass = $badgeMap[$status] ?? 'bg-secondary';
@endphp

<span class="badge {{ $badgeClass }}" @if($status === 'Ready For Review') style="background:#8b5cf6;" @endif>
    @if($status === 'Approved')
        <i class="bi bi-lock-fill me-1"></i>
    @endif
    {{ $status }}
</span>
