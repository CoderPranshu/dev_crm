@php
    $kraCompleted = $kra->users()->where('users.id', $user->id)->first()->pivot->complete ?? 0;
@endphp



<li class="position-relative mx-2 {{ $kraCompleted == 1 ? 'completed' : '' }}" id="kra-list{{ $kra->id }}">

    {{-- Sorting --}}
    <input class="sorting_values" type="hidden" value="{{ $kra->id }}">

    <div class="position-relative">
        <a href="#" class="sorting-btn">
            <i class="fi-rr-grip-dots-vertical"></i>
        </a>
    </div>

    {{-- Completion --}}
    <div class="task-checkbox-content">
        <input onchange="actionTo('{{ route('admin.kra.completion', ['id' => $kra->id, 'user' => $user->id]) }}')" class="task-checkbox"
            type="checkbox" title="{{ get_phrase('Mark As Completed') }}"
            {{ $kraCompleted == 1 ? 'checked disabled' : '' }}>

    </div>

    {{-- Description --}}
    <div class="task-area-content w-100">
        <form action="{{ route('admin.kra.update', $kra->id) }}" method="POST" class="ajaxForm task-from">
            @csrf

            <textarea name="description" class="task-description form-control border-0" rows="1"
                onkeyup="setTimeoutAwait(this); taskExpandToggler('{{ $kra->id }}', true)">{{ $kra->description }}</textarea>
        </form>
    </div>

    {{-- Actions --}}
    <div class="archive-section">

        {{-- Expand --}}
        <button class="btn px-1 py-0" onclick="taskExpandToggler('{{ $kra->id }}')"
            title="{{ get_phrase('Expand') }}">
            <i class="fi-bs-arrows-alt-v"></i>
        </button>

        {{-- Archive / Restore --}}
        @if ($kra->status == 'running')
            <button onclick="actionTo('{{ route('admin.kra.status', ['id' => $kra->id, 'user' => $user->id]) }}')" type="button"
                class="btn p-0" title="{{ get_phrase('Mark as Archive') }}">
                <i class="fi-rr-archive"></i>
            </button>
        @else
            <button onclick="actionTo('{{ route('admin.kra.status', ['id' => $kra->id, 'user' => $user->id]) }}')" type="button"
                class="btn px-1 py-0" title="{{ get_phrase('Restore') }}">
                <i class="fi fi-rr-refresh"></i>
            </button>
        @endif

        {{-- Delete --}}
        <button class="btn px-1 py-0" onclick="actionTo('{{ route('admin.kra.delete', ['id' => $kra->id]) }}')"
            title="{{ get_phrase('Delete') }}">
            <i class="fi fi-rr-trash"></i>
        </button>

    </div>
</li>

@include('taskinit')
