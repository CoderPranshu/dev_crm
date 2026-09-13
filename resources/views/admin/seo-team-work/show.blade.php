@extends('index')

@push('title', get_phrase('SEO Team Work'))

@section('content')

@php
    use Carbon\Carbon;

    $now = Carbon::now();

    if ($now->lt($currentWeekStart)) {
        $planStatus = 'Upcoming';
    } elseif ($now->gt($planEnd)) {
        $planStatus = 'Completed';
    } else {
        $planStatus = 'Active';
    }

    $statusMeta = [
        'completed' => ['label' => 'Completed',    'badge' => 'sw-badge-success', 'card' => 'completed'],
        'available' => ['label' => 'Available',    'badge' => 'sw-badge-today',   'card' => 'today'],
        'upcoming'  => ['label' => 'Upcoming',      'badge' => 'sw-badge-locked',  'card' => 'locked'],
        'overdue'   => ['label' => 'Window Closed', 'badge' => 'sw-badge-missed',  'card' => 'missed'],
    ];
@endphp

<div class="sw-page">

    <form id="taskForm"
          action="{{ route('admin.seo-team-work.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <input type="hidden"
               name="seo_plan_client_id"
               value="{{ $planClient->id }}">

        <input type="hidden" name="distribution_id" id="distribution_id">

        {{-- ===========================================
            Hero Header
        =========================================== --}}
        <div class="sw-hero fade-up">
            <div class="sw-hero-left">
                <a href="{{ route('admin.seo-team-work.index') }}" class="sw-back-link">
                    <i class="fi-rr-arrow-left"></i> Back
                </a>

                <h1 class="sw-hero-title">SEO Team Work</h1>
                <p class="sw-hero-sub">Monday – Saturday weekly task execution &amp; tracking workspace.</p>

                <div class="sw-hero-meta">
                    <div>
                        <small>Client</small>
                        <span>{{ $planClient->company->name }}</span>
                    </div>
                    <div>
                        <small>Package</small>
                        <span>{{ $planClient->seoPlan->name }}</span>
                    </div>
                    <div>
                        <small>Plan</small>
                        <span>{{ $planStart->format('d M Y') }} → {{ $planEnd->format('d M Y') }}</span>
                    </div>
                    <div>
                        <small>Current Week</small>
                        <span>{{ $currentWeekStart->format('d M') }} - {{ $currentWeekEnd->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="sw-hero-right">
                <div class="sw-ring-wrap">
                    <svg class="sw-ring" viewBox="0 0 160 160">
                        <circle class="sw-ring-bg" cx="80" cy="80" r="70"></circle>
                        <circle class="sw-ring-fill" cx="80" cy="80" r="70" data-percent="{{ $currentWeekProgress }}"></circle>
                    </svg>
                    <div class="sw-ring-label">
                        <span class="sw-ring-value" data-counter="{{ $currentWeekProgress }}">0</span><span class="sw-ring-percent">%</span>
                        <small>This Week</small>
                    </div>
                </div>

                <div class="sw-hero-stats">
                    <div>
                        <span data-counter="{{ $currentWeekTotal }}">0</span>
                        <small>This Week's Tasks</small>
                    </div>
                    <div>
                        <span data-counter="{{ $currentWeekCompleted }}">0</span>
                        <small>Completed</small>
                    </div>
                    <div>
                        <span data-counter="{{ $currentWeekPending }}">0</span>
                        <small>Pending</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===========================================
            Client Overview Card
        =========================================== --}}
        <div class="sw-card sw-client-card fade-up">
            <div class="sw-client-left">
                @if(!empty($planClient->company->logo))
                    <img src="{{ asset($planClient->company->logo) }}" class="sw-client-logo" alt="{{ $planClient->company->name }}">
                @else
                    <div class="sw-client-logo-fallback">
                        {{ strtoupper(substr($planClient->company->name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <h3 class="sw-client-name">{{ $planClient->company->name }}</h3>
                    <span class="sw-client-badge">
                        <i class="fi-rr-shield-check"></i> {{ $planClient->seoPlan->name }}
                    </span>
                </div>
            </div>

            <div class="sw-client-right">
                <div class="sw-client-stat">
                    <small>Plan Duration</small>
                    <span>{{ $planClient->seoPlan->duration }} Month</span>
                </div>
                <div class="sw-client-stat">
                    <small>Status</small>
                    <span class="sw-plan-status sw-plan-status-{{ strtolower($planStatus) }}">{{ $planStatus }}</span>
                </div>
            </div>
        </div>

        {{-- ===========================================
            Completion Window Notice
        =========================================== --}}
        <div class="sw-window-notice fade-up">
            <i class="fi-rr-calendar"></i>
            <div>
                <strong>Monday – Saturday Completion Window</strong>
                <p>Any task scheduled this week can be completed on any day within the window, until Saturday.
                   <span class="sw-window-dates">{{ $currentWeekStart->format('d M Y') }} → {{ $currentWeekEnd->format('d M Y') }}</span>
                </p>
            </div>
        </div>

        {{-- ===========================================
            Tabs
        =========================================== --}}
        <ul class="nav sw-tabs fade-up" id="swTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="today-tab" data-bs-toggle="tab"
                        data-bs-target="#todayTasksPane" type="button" role="tab">
                    <i class="fi-rr-calendar"></i> Today Tasks
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="all-tab" data-bs-toggle="tab"
                        data-bs-target="#allTasksPane" type="button" role="tab">
                    <i class="fi-rr-list"></i> All Tasks
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- =======================================================
                TAB 1: TODAY TASKS (current week window)
            ======================================================== --}}
            <div class="tab-pane fade show active" id="todayTasksPane" role="tabpanel">

                <div class="sw-stats-grid fade-up">
                    <div class="sw-stat-card sw-border-teal">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-teal"><i class="fi-rr-list"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $currentWeekTotal }}">0</h2>
                        <small>Total This Week</small>
                    </div>

                    <div class="sw-stat-card sw-border-success">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-success"><i class="fi-rr-check"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $currentWeekCompleted }}">0</h2>
                        <small>Completed</small>
                    </div>

                    <div class="sw-stat-card sw-border-warning">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-warning"><i class="fi-rr-hourglass-end"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $currentWeekPending }}">0</h2>
                        <small>Pending / Available</small>
                    </div>

                    <div class="sw-stat-card sw-border-dark">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-dark"><i class="fi-rr-stats"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $currentWeekProgress }}">0</h2>
                        <small>Progress %</small>
                        <div class="sw-progress-track">
                            <div class="sw-progress-bar" style="width: {{ $currentWeekProgress }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="sw-search-bar fade-up">
                    <i class="fi-rr-search"></i>
                    <input type="text" id="taskSearchToday" placeholder="Search this week's tasks...">
                </div>

                @foreach($currentWeekDays as $dayBlock)

                    <div class="sw-day-section fade-up today-scope">

                        <div class="sw-day-header {{ $dayBlock['is_today'] ? 'sw-day-header-today' : '' }}">
                            <div class="sw-day-header-left">
                                <span class="sw-day-name">{{ $dayBlock['day_name'] }}</span>
                                <span class="sw-day-date">{{ $dayBlock['date']->format('d M Y') }}</span>
                                @if($dayBlock['is_today'])
                                    <span class="sw-badge sw-badge-today"><i class="fi-rr-time-fast"></i> Today</span>
                                @endif
                            </div>
                            <div class="sw-day-header-right">
                                <span class="sw-day-count">{{ $dayBlock['task_count'] }} {{ Str::plural('Task', $dayBlock['task_count']) }}</span>
                            </div>
                        </div>

                        <div class="sw-task-list">

                            @forelse($dayBlock['tasks'] as $row)
                                @include('admin.seo-team-work.partials.task-card', ['row' => $row, 'statusMeta' => $statusMeta])
                            @empty
                                <div class="sw-empty-state sw-empty-state-day">
                                    <i class="fi-rr-inbox"></i>
                                    <small>No task scheduled for {{ $dayBlock['day_name'] }}.</small>
                                </div>
                            @endforelse

                        </div>

                    </div>

                @endforeach

            </div>

            {{-- =======================================================
                TAB 2: ALL TASKS (whole plan, grouped by week)
            ======================================================== --}}
            <div class="tab-pane fade" id="allTasksPane" role="tabpanel">

                <div class="sw-stats-grid fade-up">
                    <div class="sw-stat-card sw-border-teal">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-teal"><i class="fi-rr-list"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $planTotal }}">0</h2>
                        <small>Total Plan Tasks</small>
                    </div>

                    <div class="sw-stat-card sw-border-success">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-success"><i class="fi-rr-check"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $planCompleted }}">0</h2>
                        <small>Completed</small>
                    </div>

                    <div class="sw-stat-card sw-border-warning">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-warning"><i class="fi-rr-hourglass-end"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $planPending }}">0</h2>
                        <small>Pending</small>
                    </div>

                    <div class="sw-stat-card sw-border-dark">
                        <div class="sw-stat-top">
                            <div class="sw-stat-icon sw-icon-dark"><i class="fi-rr-stats"></i></div>
                        </div>
                        <h2 class="sw-stat-value" data-counter="{{ $planProgress }}">0</h2>
                        <small>Progress %</small>
                        <div class="sw-progress-track">
                            <div class="sw-progress-bar" style="width: {{ $planProgress }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="sw-search-bar fade-up">
                    <i class="fi-rr-search"></i>
                    <input type="text" id="taskSearchAll" placeholder="Search across the whole plan...">
                </div>

                @forelse($planWeeks as $week)

                    <div class="sw-week-block fade-up">

                        <div class="sw-week-header">
                            <div>
                                <strong>Week {{ $week['week_number'] }}</strong>
                                <span class="sw-week-range">{{ $week['week_start']->format('d M Y') }} - {{ $week['week_end']->format('d M Y') }}</span>
                            </div>
                            <div class="sw-week-progress">
                                <span>{{ $week['completed'] }}/{{ $week['total'] }} completed</span>
                            </div>
                        </div>

                        @foreach($week['days'] as $dayBlock)

                            <div class="sw-day-section all-scope">

                                <div class="sw-day-header {{ $dayBlock['is_today'] ? 'sw-day-header-today' : '' }}">
                                    <div class="sw-day-header-left">
                                        <span class="sw-day-name">{{ $dayBlock['day_name'] }}</span>
                                        <span class="sw-day-date">{{ $dayBlock['date']->format('d M Y') }}</span>
                                        @if($dayBlock['is_today'])
                                            <span class="sw-badge sw-badge-today"><i class="fi-rr-time-fast"></i> Today</span>
                                        @endif
                                    </div>
                                    <div class="sw-day-header-right">
                                        <span class="sw-day-count">{{ $dayBlock['task_count'] }} {{ Str::plural('Task', $dayBlock['task_count']) }}</span>
                                    </div>
                                </div>

                                <div class="sw-task-list">

                                    @forelse($dayBlock['tasks'] as $row)
                                        @include('admin.seo-team-work.partials.task-card', ['row' => $row, 'statusMeta' => $statusMeta])
                                    @empty
                                        <div class="sw-empty-state sw-empty-state-day">
                                            <i class="fi-rr-inbox"></i>
                                            <small>No task scheduled for {{ $dayBlock['day_name'] }}.</small>
                                        </div>
                                    @endforelse

                                </div>

                            </div>

                        @endforeach

                    </div>

                @empty

                    <div class="sw-empty-state">
                        <i class="fi-rr-inbox"></i>
                        <div class="sw-empty-title">No Task Found</div>
                        <small>There is no SEO task scheduled in this plan.</small>
                    </div>

                @endforelse

            </div>

        </div>

        {{-- Complete Task Modal --}}

        <div class="modal fade"
             id="taskModal"
             tabindex="-1"
             aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content sw-modal-content">

                    <div class="modal-header sw-modal-header">
                        <div class="sw-modal-header-left">
                            <div class="sw-modal-icon"><i class="fi-rr-check"></i></div>
                            <div>
                                <h5 class="modal-title">Complete SEO Task</h5>
                                <small>Log today's progress for this task</small>
                            </div>
                        </div>
                        <button type="button"
                                class="btn-close sw-modal-close"
                                data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body sw-modal-body">

                        <div class="sw-selected-task">
                            <small>Selected Task</small>
                            <span id="selectedTaskName">-</span>
                        </div>

                        <div class="mb-4">
                            <label class="sw-form-label">Attachment</label>

                            <div class="sw-dropzone" id="swDropzone">
                                <input type="file"
                                       name="attachment"
                                       id="swAttachmentInput"
                                       class="sw-file-input"
                                       accept="image/*">

                                <div class="sw-dropzone-inner" id="swDropzoneInner">
                                    <div class="sw-dropzone-icon"><i class="fi-rr-cloud-upload-alt"></i></div>
                                    <div class="sw-dropzone-text">
                                        <strong>Drag &amp; drop</strong> your screenshot here
                                        <br>
                                        <span>or <span class="sw-browse-link">browse files</span></span>
                                    </div>
                                    <small class="text-muted">PNG, JPG or WEBP — up to 2MB</small>
                                </div>

                                <img id="swAttachmentPreview" class="sw-attachment-preview d-none" alt="Preview">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="sw-form-label">Website Link</label>
                            <div class="sw-input-icon">
                                <i class="fi-rr-link"></i>
                                <input type="url"
                                       name="link"
                                       class="sw-input"
                                       placeholder="https://example.com">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="sw-form-label">Remarks</label>
                            <textarea
                                name="remarks"
                                class="sw-textarea"
                                rows="4"
                                placeholder="Write remarks here..."></textarea>
                        </div>

                    </div>

                    <div class="modal-footer sw-modal-footer">
                        <button type="button"
                                class="sw-btn sw-btn-ghost"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                class="sw-btn sw-btn-primary">
                            <span class="btn-label"><i class="fi-rr-disk"></i> Save Task</span>
                            <span class="btn-loading d-none"><i class="fi-rr-spinner"></i> Saving...</span>
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

<style>
:root{
    --sw-accent:#00A8C6;
    --sw-secondary:#0F172A;
    --sw-success:#16A34A;
    --sw-warning:#F59E0B;
    --sw-danger:#EF4444;
    --sw-border:#E5E7EB;
    --sw-bg:#F8FAFC;
    --sw-radius:20px;
    --sw-shadow:0 10px 30px rgba(15,23,42,.06);
}

.sw-page{
    font-family:'Inter','Plus Jakarta Sans','Segoe UI',sans-serif;
    color:var(--sw-secondary);
    background:var(--sw-bg);
    border-radius:24px;
}

/* ---------- Hero ---------- */
.sw-hero{
    background:linear-gradient(135deg, #0F172A 0%, #0B3A45 55%, #00A8C6 130%);
    border-radius:28px;
    padding:36px 40px;
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:32px;
    flex-wrap:wrap;
    margin-bottom:24px;
    position:relative;
    overflow:hidden;
}
.sw-hero::before{
    content:'';
    position:absolute; inset:0;
    background:radial-gradient(circle at 85% 20%, rgba(255,255,255,.12), transparent 45%);
    pointer-events:none;
}
.sw-back-link{
    display:inline-flex; align-items:center; gap:8px;
    color:rgba(255,255,255,.8); font-size:13.5px; font-weight:600;
    background:rgba(255,255,255,.1); backdrop-filter:blur(6px);
    padding:8px 16px; border-radius:999px; margin-bottom:18px;
    transition:all .2s ease;
}
.sw-back-link:hover{ color:#fff; background:rgba(255,255,255,.18); }
.sw-hero-title{ font-size:32px; font-weight:700; margin:0 0 4px; letter-spacing:-.02em; }
.sw-hero-sub{ font-size:15px; color:rgba(255,255,255,.7); margin:0 0 22px; font-weight:500; }
.sw-hero-meta{ display:flex; gap:28px; flex-wrap:wrap; }
.sw-hero-meta div{ display:flex; flex-direction:column; gap:4px; }
.sw-hero-meta small{ font-size:12px; color:rgba(255,255,255,.55); font-weight:400; text-transform:uppercase; letter-spacing:.04em; }
.sw-hero-meta span{ font-size:14.5px; font-weight:600; }

.sw-hero-right{ display:flex; align-items:center; gap:32px; position:relative; z-index:1; flex-wrap:wrap; }
.sw-ring-wrap{ position:relative; width:150px; height:150px; flex-shrink:0; }
.sw-ring{ width:150px; height:150px; transform:rotate(-90deg); }
.sw-ring-bg{ fill:none; stroke:rgba(255,255,255,.15); stroke-width:12; }
.sw-ring-fill{
    fill:none; stroke:#fff; stroke-width:12; stroke-linecap:round;
    stroke-dasharray:439.8; stroke-dashoffset:439.8;
    transition:stroke-dashoffset 1.2s cubic-bezier(.4,0,.2,1);
}
.sw-ring-label{
    position:absolute; inset:0; display:flex; flex-direction:column;
    align-items:center; justify-content:center; text-align:center;
}
.sw-ring-value{ font-size:30px; font-weight:700; line-height:1; }
.sw-ring-percent{ font-size:18px; font-weight:700; }
.sw-ring-label small{ display:block; margin-top:4px; color:rgba(255,255,255,.65); font-size:12px; }

.sw-hero-stats{ display:flex; flex-direction:column; gap:16px; }
.sw-hero-stats div{
    background:rgba(255,255,255,.1); backdrop-filter:blur(6px);
    border:1px solid rgba(255,255,255,.14);
    border-radius:16px; padding:12px 22px; min-width:150px;
}
.sw-hero-stats span{ display:block; font-size:22px; font-weight:700; }
.sw-hero-stats small{ color:rgba(255,255,255,.65); font-size:12px; }

/* ---------- Card base ---------- */
.sw-card{
    background:#fff; border:1px solid var(--sw-border); border-radius:var(--sw-radius);
    box-shadow:var(--sw-shadow); padding:26px; margin-bottom:24px;
}

/* ---------- Client card ---------- */
.sw-client-card{ display:flex; justify-content:space-between; align-items:center; gap:24px; flex-wrap:wrap; }
.sw-client-left{ display:flex; align-items:center; gap:18px; }
.sw-client-logo{ width:64px; height:64px; border-radius:16px; object-fit:cover; border:1px solid var(--sw-border); }
.sw-client-logo-fallback{
    width:64px; height:64px; border-radius:16px; color:#fff; font-weight:700; font-size:24px;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg, var(--sw-accent), var(--sw-secondary));
}
.sw-client-name{ font-size:18px; font-weight:700; margin:0 0 6px; }
.sw-client-badge{
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(0,168,198,.08); color:var(--sw-accent);
    font-size:12.5px; font-weight:600; padding:6px 14px; border-radius:999px;
}
.sw-client-right{ display:flex; gap:34px; flex-wrap:wrap; }
.sw-client-stat{ display:flex; flex-direction:column; gap:4px; }
.sw-client-stat small{ font-size:12px; color:#9CA3AF; text-transform:uppercase; letter-spacing:.03em; }
.sw-client-stat span{ font-weight:600; font-size:14.5px; }
.sw-plan-status{ padding:5px 12px; border-radius:999px; font-size:12.5px; font-weight:600; width:fit-content; }
.sw-plan-status-active{ background:rgba(22,163,74,.1); color:var(--sw-success); }
.sw-plan-status-upcoming{ background:rgba(0,168,198,.1); color:var(--sw-accent); }
.sw-plan-status-completed{ background:#F3F4F6; color:#6B7280; }

/* ---------- Window notice ---------- */
.sw-window-notice{
    display:flex; align-items:flex-start; gap:14px;
    background:rgba(0,168,198,.06); border:1px solid rgba(0,168,198,.2);
    border-radius:var(--sw-radius); padding:18px 22px; margin-bottom:22px;
}
.sw-window-notice i{ font-size:18px; color:var(--sw-accent); margin-top:2px; }
.sw-window-notice strong{ font-size:14.5px; }
.sw-window-notice p{ margin:4px 0 0; font-size:13px; color:#4B5563; }
.sw-window-dates{ font-weight:600; color:var(--sw-secondary); }

/* ---------- Tabs ---------- */
.sw-tabs{ border:none; gap:10px; margin-bottom:20px; }
.sw-tabs .nav-link{
    border:1px solid var(--sw-border); border-radius:999px; color:#6B7280;
    font-weight:600; font-size:14px; padding:10px 22px; background:#fff;
    display:flex; align-items:center; gap:8px; transition:all .2s ease;
}
.sw-tabs .nav-link.active{
    background:linear-gradient(135deg, var(--sw-accent), #0EC8DE); color:#fff; border-color:transparent;
    box-shadow:0 8px 20px rgba(0,168,198,.25);
}

/* ---------- Stats grid ---------- */
.sw-stats-grid{ display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; margin-bottom:24px; }
.sw-stat-card{
    background:#fff; border:1px solid var(--sw-border); border-top:3px solid transparent;
    border-radius:var(--sw-radius); box-shadow:var(--sw-shadow); padding:22px;
    transition:transform .25s ease, box-shadow .25s ease;
}
.sw-stat-card:hover{ transform:translateY(-4px); box-shadow:0 18px 36px rgba(15,23,42,.1); }
.sw-border-teal{ border-top-color:var(--sw-accent); }
.sw-border-success{ border-top-color:var(--sw-success); }
.sw-border-warning{ border-top-color:var(--sw-warning); }
.sw-border-dark{ border-top-color:var(--sw-secondary); }
.sw-stat-top{ margin-bottom:14px; }
.sw-stat-icon{
    width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:16px;
}
.sw-icon-teal{ background:rgba(0,168,198,.1); color:var(--sw-accent); }
.sw-icon-success{ background:rgba(22,163,74,.1); color:var(--sw-success); }
.sw-icon-warning{ background:rgba(245,158,11,.12); color:var(--sw-warning); }
.sw-icon-dark{ background:rgba(15,23,42,.06); color:var(--sw-secondary); }
.sw-stat-value{ font-size:28px; font-weight:700; margin:0 0 2px; }
.sw-stat-card small{ color:#9CA3AF; font-size:13px; font-weight:500; }

.sw-progress-track{ margin-top:12px; height:6px; border-radius:999px; background:#F1F5F9; overflow:hidden; }
.sw-progress-bar{ height:100%; border-radius:999px; background:linear-gradient(90deg, var(--sw-accent), #0EC8DE); transition:width 1s ease; }

/* ---------- Search ---------- */
.sw-search-bar{
    position:sticky; top:14px; z-index:20;
    display:flex; align-items:center; gap:12px;
    background:#fff; border:1px solid var(--sw-border);
    border-radius:999px; box-shadow:var(--sw-shadow);
    padding:14px 22px; margin-bottom:22px; max-width:480px;
}
.sw-search-bar i{ color:#9CA3AF; }
.sw-search-bar input{ border:none; outline:none; flex:1; font-size:14.5px; background:transparent; }

/* ---------- Week block (All Tasks tab) ---------- */
.sw-week-block{ margin-bottom:28px; }
.sw-week-header{
    display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;
    background:var(--sw-secondary); color:#fff; padding:14px 22px;
    border-radius:16px 16px 0 0; margin-bottom:0;
}
.sw-week-range{ font-size:12.5px; color:rgba(255,255,255,.7); margin-left:10px; }
.sw-week-progress span{ font-size:12.5px; font-weight:600; background:rgba(255,255,255,.12); padding:5px 14px; border-radius:999px; }

/* ---------- Day sections ---------- */
.sw-day-section{
    background:#fff; border:1px solid var(--sw-border); border-radius:var(--sw-radius);
    box-shadow:var(--sw-shadow); margin-bottom:14px; overflow:hidden;
}
.all-scope{ border-radius:0; }
.sw-week-block .sw-day-section:last-child{ border-radius:0 0 var(--sw-radius) var(--sw-radius); }
.sw-day-header{
    display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;
    padding:18px 24px; background:var(--sw-bg); border-bottom:1px solid var(--sw-border);
}
.sw-day-header-today{ background:rgba(0,168,198,.06); }
.sw-day-header-left{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.sw-day-name{ font-size:16px; font-weight:700; }
.sw-day-date{ font-size:13px; color:#6B7280; font-weight:500; }
.sw-day-count{ font-size:12.5px; color:#6B7280; font-weight:600; background:#fff; border:1px solid var(--sw-border); padding:5px 12px; border-radius:999px; }

/* ---------- Task list ---------- */
.sw-task-list{ display:flex; flex-direction:column; gap:14px; padding:18px 24px; }
.sw-task-card{
    background:#fff; border:1px solid var(--sw-border); border-left:4px solid var(--sw-border);
    border-radius:18px; box-shadow:var(--sw-shadow);
    padding:20px 24px; display:flex; align-items:flex-start; gap:20px;
    transition:transform .2s ease, box-shadow .2s ease;
}
.sw-task-card:hover{ transform:translateY(-3px); box-shadow:0 14px 30px rgba(15,23,42,.1); }

.sw-status-completed{ border-left-color:var(--sw-success); }
.sw-status-today{ border-left-color:var(--sw-accent); box-shadow:0 0 0 3px rgba(0,168,198,.12), var(--sw-shadow); animation:sw-pulse 2.4s infinite; }
.sw-status-locked{ border-left-color:#D1D5DB; opacity:.7; }
.sw-status-missed{ border-left-color:var(--sw-danger); }

@keyframes sw-pulse{
    0%{ box-shadow:0 0 0 0 rgba(0,168,198,.25), var(--sw-shadow); }
    70%{ box-shadow:0 0 0 8px rgba(0,168,198,0), var(--sw-shadow); }
    100%{ box-shadow:0 0 0 0 rgba(0,168,198,0), var(--sw-shadow); }
}

.sw-task-check-col{ display:flex; flex-direction:column; align-items:center; gap:8px; flex-shrink:0; padding-top:2px; }
.sw-view-link{ font-size:11.5px; font-weight:600; color:var(--sw-accent); display:flex; align-items:center; gap:4px; }

/* Custom checkbox */
.sw-checkbox{ position:relative; display:inline-flex; cursor:pointer; }
.sw-checkbox input{ position:absolute; opacity:0; width:30px; height:30px; margin:0; cursor:pointer; }
.sw-checkbox-box{
    width:30px; height:30px; border-radius:10px; border:2px solid var(--sw-border);
    display:flex; align-items:center; justify-content:center; color:#fff; font-size:13px;
    background:#fff; transition:all .2s ease;
}
.sw-checkbox-today .sw-checkbox-box{ border-color:var(--sw-accent); }
.sw-checkbox-today input:hover ~ .sw-checkbox-box{ background:rgba(0,168,198,.08); transform:scale(1.05); }
.sw-checkbox-checked .sw-checkbox-box{ background:var(--sw-success); border-color:var(--sw-success); }
.sw-checkbox-disabled .sw-checkbox-box{ background:#F3F4F6; border-color:#E5E7EB; color:#9CA3AF; cursor:not-allowed; }
.sw-checkbox-disabled input{ cursor:not-allowed; }

.sw-task-main{ flex:1; min-width:0; }
.sw-task-title-row{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:8px; }
.sw-task-title{ font-size:15px; font-weight:600; }
.sw-task-meta{ display:flex; gap:18px; flex-wrap:wrap; margin-bottom:6px; }
.sw-task-meta span{ font-size:12.5px; color:#6B7280; display:inline-flex; align-items:center; gap:6px; }
.sw-task-remarks{ font-size:13px; color:#6B7280; margin:6px 0 0; }
.sw-task-link{ font-size:12.5px; color:var(--sw-accent); display:inline-flex; align-items:center; gap:6px; margin-top:6px; word-break:break-all; }

/* Badges */
.sw-badge{ font-size:11.5px; font-weight:600; padding:5px 12px; border-radius:999px; display:inline-flex; align-items:center; gap:6px; }
.sw-badge-success{ background:rgba(22,163,74,.1); color:var(--sw-success); }
.sw-badge-today{ background:rgba(0,168,198,.1); color:var(--sw-accent); }
.sw-badge-locked{ background:#F3F4F6; color:#9CA3AF; }
.sw-badge-missed{ background:rgba(239,68,68,.08); color:var(--sw-danger); }

/* Empty state */
.sw-empty-state{ text-align:center; padding:60px 10px; color:#9CA3AF; background:#fff; border:1px dashed var(--sw-border); border-radius:var(--sw-radius); }
.sw-empty-state i{ font-size:32px; margin-bottom:10px; display:block; color:#D1D5DB; }
.sw-empty-state-day{ padding:24px 10px; border:none; background:transparent; }
.sw-empty-title{ font-weight:600; color:var(--sw-secondary); }

/* ---------- Buttons ---------- */
.sw-btn{
    border:none; border-radius:12px; font-weight:600; font-size:14px;
    padding:12px 24px; display:inline-flex; align-items:center; gap:8px;
    cursor:pointer; transition:all .2s ease; position:relative; overflow:hidden;
}
.sw-btn-primary{
    background:linear-gradient(135deg, var(--sw-accent), #0EC8DE); color:#fff;
    box-shadow:0 8px 20px rgba(0,168,198,.25);
}
.sw-btn-primary:hover{ transform:translateY(-2px); box-shadow:0 12px 26px rgba(0,168,198,.35); color:#fff; }
.sw-btn-ghost{ background:#F3F4F6; color:var(--sw-secondary); }
.sw-btn-ghost:hover{ background:#E5E7EB; }
.sw-ripple{ position:absolute; border-radius:50%; background:rgba(255,255,255,.5); transform:scale(0); animation:sw-ripple .6s ease-out; pointer-events:none; }
@keyframes sw-ripple{ to{ transform:scale(3); opacity:0; } }

/* ---------- Modal ---------- */
.sw-modal-content{ border:none; border-radius:24px; overflow:hidden; box-shadow:0 30px 70px rgba(15,23,42,.25); }
.sw-modal-header{
    background:linear-gradient(135deg, var(--sw-secondary), #0B3A45 60%, var(--sw-accent));
    color:#fff; border:none; padding:24px 28px;
}
.sw-modal-header-left{ display:flex; align-items:center; gap:14px; }
.sw-modal-icon{
    width:44px; height:44px; border-radius:14px; background:rgba(255,255,255,.15);
    display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;
}
.sw-modal-header .modal-title{ font-size:17px; font-weight:700; margin:0; color:#fff; }
.sw-modal-header small{ color:rgba(255,255,255,.7); font-size:12.5px; }
.sw-modal-close{ filter:invert(1) brightness(2); opacity:.85; }
.sw-modal-body{ padding:28px; }
.sw-form-label{ font-weight:600; font-size:13.5px; margin-bottom:8px; display:block; }

.sw-selected-task{
    background:rgba(0,168,198,.06); border:1px solid rgba(0,168,198,.2);
    border-radius:14px; padding:14px 18px; margin-bottom:22px;
}
.sw-selected-task small{ display:block; color:var(--sw-accent); font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; margin-bottom:4px; }
.sw-selected-task span{ font-weight:600; font-size:14.5px; }

.sw-input, .sw-textarea{
    width:100%; border:1px solid var(--sw-border); border-radius:12px;
    padding:12px 16px; font-size:14.5px; transition:border-color .2s, box-shadow .2s;
}
.sw-input:focus, .sw-textarea:focus{ outline:none; border-color:var(--sw-accent); box-shadow:0 0 0 4px rgba(0,168,198,.12); }
.sw-input-icon{ position:relative; }
.sw-input-icon i{ position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#9CA3AF; }
.sw-input-icon .sw-input{ padding-left:42px; }
.sw-textarea{ resize:vertical; }

.sw-dropzone{
    position:relative; border:2px dashed var(--sw-border); border-radius:16px;
    padding:30px 20px; text-align:center; background:var(--sw-bg);
    transition:border-color .2s, background .2s;
}
.sw-dropzone.sw-dragover{ border-color:var(--sw-accent); background:rgba(0,168,198,.06); }
.sw-file-input{ position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.sw-dropzone-icon{ font-size:26px; color:var(--sw-accent); margin-bottom:10px; }
.sw-dropzone-text{ font-size:13.5px; color:#4B5563; margin-bottom:6px; }
.sw-browse-link{ color:var(--sw-accent); font-weight:600; }
.sw-attachment-preview{ max-height:160px; border-radius:12px; margin-top:14px; max-width:100%; }

.sw-modal-footer{ border:none; padding:20px 28px 28px; gap:10px; }

/* ---------- Fade-up ---------- */
.fade-up{ opacity:1; }

/* ---------- Responsive ---------- */
@media (max-width: 992px){
    .sw-stats-grid{ grid-template-columns:repeat(2, 1fr); }
    .sw-hero{ flex-direction:column; align-items:flex-start; }
    .sw-hero-right{ width:100%; justify-content:space-between; }
}
@media (max-width: 576px){
    .sw-page{ padding:16px; }
    .sw-stats-grid{ grid-template-columns:1fr; }
    .sw-hero{ padding:26px; }
    .sw-hero-title{ font-size:24px; }
    .sw-task-card{ flex-direction:column; }
    .sw-search-bar{ max-width:100%; }
    .sw-task-list{ padding:16px; }
}
</style>

@endsection

@push('js')

<script>

$(document).ready(function () {

    $(document).on("click", ".task-check", function (e) {

        e.preventDefault();

        let distributionId = $(this).data("distribution");

        let taskName = $(this).data("title");

        $("#distribution_id").val(distributionId);

        $("#selectedTaskName").text(taskName);

        let modal = new bootstrap.Modal(
            document.getElementById("taskModal")
        );

        modal.show();

    });

    $("#taskModal").on("hidden.bs.modal", function () {

        $(this).find("input[type='file']").val("");
        $(this).find("input[name='link']").val("");
        $(this).find("textarea[name='remarks']").val("");

        $("#distribution_id").val("");

        $("#selectedTaskName").text("-");

    });

});

</script>

@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Entrance animation
    |--------------------------------------------------------------------------
    */
    if (window.gsap) {
        gsap.from('.fade-up', {
            y: 18,
            opacity: 0,
            duration: 0.55,
            stagger: 0.08,
            ease: 'power2.out'
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Animated counters
    |--------------------------------------------------------------------------
    */
    function animateValue(el, end) {
        if (!el) return;
        var start = 0;
        var duration = 800;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            el.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.innerHTML = end;
            }
        }
        window.requestAnimationFrame(step);
    }

    document.querySelectorAll('[data-counter]').forEach(function (el) {
        animateValue(el, parseInt(el.getAttribute('data-counter'), 10) || 0);
    });

    /*
    |--------------------------------------------------------------------------
    | Progress ring
    |--------------------------------------------------------------------------
    */
    var ring = document.querySelector('.sw-ring-fill');
    if (ring) {
        var percent = parseFloat(ring.getAttribute('data-percent')) || 0;
        var circumference = 2 * Math.PI * 70;
        var offset = circumference - (percent / 100) * circumference;
        setTimeout(function () {
            ring.style.strokeDashoffset = offset;
        }, 150);
    }

    /*
    |--------------------------------------------------------------------------
    | Search filter — Today tab
    |--------------------------------------------------------------------------
    */
    var searchToday = document.getElementById('taskSearchToday');
    if (searchToday) {
        searchToday.addEventListener('keyup', function () {
            var value = this.value.toLowerCase();
            document.querySelectorAll('#todayTasksPane .task-card2').forEach(function (card) {
                card.style.display = card.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
            document.querySelectorAll('#todayTasksPane .sw-day-section').forEach(function (section) {
                var visible = section.querySelectorAll('.task-card2:not([style*="display: none"])');
                section.style.display = (value === '' || visible.length > 0) ? '' : 'none';
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Search filter — All Tasks tab
    |--------------------------------------------------------------------------
    */
    var searchAll = document.getElementById('taskSearchAll');
    if (searchAll) {
        searchAll.addEventListener('keyup', function () {
            var value = this.value.toLowerCase();
            document.querySelectorAll('#allTasksPane .task-card2').forEach(function (card) {
                card.style.display = card.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
            document.querySelectorAll('#allTasksPane .sw-day-section').forEach(function (section) {
                var visible = section.querySelectorAll('.task-card2:not([style*="display: none"])');
                section.style.display = (value === '' || visible.length > 0) ? '' : 'none';
            });
            document.querySelectorAll('#allTasksPane .sw-week-block').forEach(function (week) {
                var visibleDays = week.querySelectorAll('.sw-day-section:not([style*="display: none"])');
                week.style.display = (value === '' || visibleDays.length > 0) ? '' : 'none';
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Drag & drop attachment preview
    |--------------------------------------------------------------------------
    */
    var dropzone = document.getElementById('swDropzone');
    var fileInput = document.getElementById('swAttachmentInput');
    var preview = document.getElementById('swAttachmentPreview');
    var dropzoneInner = document.getElementById('swDropzoneInner');

    function showPreview(file) {
        if (!file || !file.type || file.type.indexOf('image') === -1) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            dropzoneInner.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }

    function resetDropzone() {
        preview.src = '';
        preview.classList.add('d-none');
        dropzoneInner.classList.remove('d-none');
        dropzone.classList.remove('sw-dragover');
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                showPreview(this.files[0]);
            }
        });
    }

    if (dropzone) {
        ['dragenter', 'dragover'].forEach(function (evt) {
            dropzone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('sw-dragover');
            });
        });

        ['dragleave', 'drop'].forEach(function (evt) {
            dropzone.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('sw-dragover');
            });
        });

        dropzone.addEventListener('drop', function (e) {
            var files = e.dataTransfer.files;
            if (files && files.length && fileInput) {
                fileInput.files = files;
                showPreview(files[0]);
            }
        });
    }

    $('#taskModal').on('hidden.bs.modal', function () {
        resetDropzone();
    });

    /*
    |--------------------------------------------------------------------------
    | Button ripple
    |--------------------------------------------------------------------------
    */
    document.querySelectorAll('.sw-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var rect = btn.getBoundingClientRect();
            var ripple = document.createElement('span');
            var size = Math.max(rect.width, rect.height);
            ripple.className = 'sw-ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            btn.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 600);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Save button loading state
    |--------------------------------------------------------------------------
    */
    var form = document.getElementById('taskForm');
    if (form) {
        form.addEventListener('submit', function () {
            var saveBtn = document.querySelector('.sw-btn-primary');
            if (saveBtn) {
                saveBtn.querySelector('.btn-label').classList.add('d-none');
                saveBtn.querySelector('.btn-loading').classList.remove('d-none');
            }
        });
    }

});
</script>
@endpush
