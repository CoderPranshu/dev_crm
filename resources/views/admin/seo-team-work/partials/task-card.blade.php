@php
    $meta = $statusMeta[$row['status_label']] ?? $statusMeta['upcoming'];
@endphp

<div class="sw-task-card sw-status-{{ $meta['card'] }} task-card2">

    <div class="sw-task-check-col">
        @if($row['status_label'] === 'completed')

            <label class="sw-checkbox sw-checkbox-checked">
                <input type="checkbox" checked disabled>
                <span class="sw-checkbox-box"><i class="fi-rr-check"></i></span>
            </label>

            @if(!empty($row['attachment']))
                <a href="{{ asset('storage/'.$row['attachment']) }}"
                   target="_blank"
                   class="sw-view-link">
                    <i class="fi-rr-picture"></i> View
                </a>
            @endif

        @elseif($row['status_label'] === 'available')

            <label class="sw-checkbox sw-checkbox-today">
                <input type="checkbox"
                       class="task-check"
                       data-distribution="{{ $row['distribution_id'] }}"
                       data-title="{{ $row['task_title'] }}">
                <span class="sw-checkbox-box"></span>
            </label>

        @else

            <label class="sw-checkbox sw-checkbox-disabled">
                <input type="checkbox" disabled>
                <span class="sw-checkbox-box">
                    @if($row['status_label'] === 'upcoming')
                        <i class="fi-rr-lock"></i>
                    @endif
                </span>
            </label>

        @endif
    </div>

    <div class="sw-task-main">
        <div class="sw-task-title-row">
            <strong class="sw-task-title">{{ $row['task_title'] }}</strong>
            <span class="sw-badge {{ $meta['badge'] }}"><i class="fi-rr-check-circle"></i> {{ $meta['label'] }}</span>
        </div>

        <div class="sw-task-meta">
            <span><i class="fi-rr-calendar"></i> {{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}</span>
            <span><i class="fi-rr-list"></i> {{ $row['day'] }}</span>
            @if(!empty($row['assigned_user']))
                <span><i class="fi-rr-user"></i> {{ $row['assigned_user'] }}</span>
            @endif
        </div>

        @if(!empty($row['remarks']))
            <p class="sw-task-remarks">{{ $row['remarks'] }}</p>
        @endif

        @if(!empty($row['link']))
            <a href="{{ $row['link'] }}" target="_blank" class="sw-task-link">
                <i class="fi-rr-link"></i> {{ $row['link'] }}
            </a>
        @endif
    </div>

</div>
