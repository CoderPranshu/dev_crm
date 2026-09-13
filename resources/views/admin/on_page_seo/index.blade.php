@extends('index')

@section('title', 'On Page SEO')

@section('content')

<div class="ops-page">

    {{-- ===========================================
        Breadcrumb
    =========================================== --}}
    <nav aria-label="breadcrumb" class="ops-breadcrumb fade-up">
        <a href="">Dashboard</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>SEO Project</span>
        <i class="fa-solid fa-chevron-right"></i>
        <span class="ops-breadcrumb-active">On Page SEO</span>
    </nav>

    {{-- ===========================================
        Success / Error Message
    =========================================== --}}
    @if(session('success'))
        <div class="ops-alert ops-alert-success fade-up">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ===========================================
        Project Header
    =========================================== --}}
    <div class="ops-card ops-project-card fade-up">

        <div class="ops-project-left">
            <div class="ops-project-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
            <div>
                <h3 class="ops-project-name">{{ $seoProject->company->company_name ?? 'N/A' }}</h3>
                <div class="ops-project-meta">
                    <span><i class="fa-solid fa-hashtag"></i> Project #{{ $seoProject->id }}</span>
                    <span><i class="fa-solid fa-layer-group"></i> {{ $seoProject->seoPlan->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        @php
            $totalTasks = $categories->sum(function($cat){
                return $cat->tasks->count();
            });

            $completedTasks = 0;

            foreach($categories as $category){
                foreach($category->tasks as $task){
                    if(
                        $task->projectTask &&
                        $task->projectTask->status == 'completed'
                    ){
                        $completedTasks++;
                    }
                }
            }

            $progress = $totalTasks
                ? round(($completedTasks/$totalTasks)*100)
                : 0;
        @endphp

        <div class="ops-project-right">
            <div class="ops-progress-head">
                <span>Overall Progress</span>
                <strong data-counter="{{ $progress }}">0</strong>%
            </div>
            <div class="ops-progress-track">
                <div class="ops-progress-fill" style="width: {{ $progress }}%;"></div>
            </div>
            <small class="ops-progress-sub">{{ $completedTasks }} / {{ $totalTasks }} tasks completed</small>
        </div>

    </div>

    {{-- ===========================================
        Category Tabs
    =========================================== --}}
    <div class="ops-card ops-tabs-card fade-up">

        <div class="ops-tabs-nav">
            @foreach($categories as $index => $category)
                <button
                    type="button"
                    class="ops-tab-btn {{ $index == 0 ? 'active' : '' }}"
                    data-tab-target="cat-pane-{{ $category->id }}"
                >
                    <i class="fa-solid fa-folder-open"></i>
                    <span>{{ $category->name }}</span>
                    <span class="ops-tab-count">{{ $category->tasks->count() }}</span>
                </button>
            @endforeach
        </div>

        {{-- ===========================================
            Category Panes
        =========================================== --}}
        @foreach($categories as $index => $category)

            <div class="ops-tab-pane {{ $index == 0 ? 'active' : '' }}" id="cat-pane-{{ $category->id }}">

                <div class="table-responsive ops-table-wrap">

                    <table class="ops-table">

                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Task</th>
                                <th width="170">Status</th>
                                <th>Remarks</th>
                                <th width="150">Completed At</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($category->tasks as $tIndex => $task)

                            @php
                                $projectTask = $task->projectTask;
                                $currentStatus = optional($projectTask)->status ?? 'pending';
                            @endphp

                            <tr class="ops-row ops-row-{{ $currentStatus }}">

                                <td class="text-center ops-index">{{ $tIndex + 1 }}</td>

                                <td>
                                    <div class="ops-task-name">{{ $task->task_name }}</div>
                                    @if($task->description)
                                        <small class="ops-task-desc">{{ $task->description }}</small>
                                    @endif
                                </td>

                                {{-- Single form: Status + Remarks + Save --}}
                                <td colspan="2">
                                    <form method="POST" action="{{ route('admin.on-page-seo.update') }}" class="ops-task-form">
                                        @csrf
                                        <input type="hidden" name="seo_plan_client_id" value="{{ $seoProject->id }}">
                                        <input type="hidden" name="on_page_seo_task_id" value="{{ $task->id }}">

                                        <div class="ops-form-row">

                                            <div class="ops-status-col">
                                                <select name="status" class="ops-select">
                                                    <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    <option value="completed" {{ $currentStatus == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>

                                            <div class="ops-remarks-col ops-remarks-wrap {{ $currentStatus != 'rejected' ? 'ops-hidden' : '' }}">
                                                <textarea
                                                    name="remarks"
                                                    class="ops-textarea"
                                                    rows="1"
                                                    placeholder="Write remarks...">{{ optional($projectTask)->remarks }}</textarea>
                                            </div>

                                            <div class="ops-save-col">
                                                <button type="submit" class="ops-save-btn">
                                                    <i class="fa-solid fa-floppy-disk"></i> Save
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </td>

                                {{-- Completed Date --}}
                                <td class="text-center ops-completed-cell">

                                    @if(optional($projectTask)->completed_at)
                                        {{ \Carbon\Carbon::parse($projectTask->completed_at)->format('d M Y') }}
                                        <br>
                                        <small>{{ \Carbon\Carbon::parse($projectTask->completed_at)->format('h:i A') }}</small>
                                    @else
                                        <span class="ops-pill ops-pill-neutral">--</span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="ops-empty-cell">
                                    <div class="ops-empty-state">
                                        <i class="fa-regular fa-folder-open"></i>
                                        <div>No Tasks Found</div>
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        @endforeach

    </div>

</div>

<style>
:root{
    --ops-accent:#00A8C6;
    --ops-dark:#0F172A;
    --ops-success:#16A34A;
    --ops-warning:#F59E0B;
    --ops-danger:#EF4444;
    --ops-border:#E5E7EB;
    --ops-bg:#F8FAFC;
    --ops-radius:20px;
    --ops-shadow:0 10px 30px rgba(15,23,42,.06);
}

.ops-page{
    font-family:'Inter','Segoe UI',sans-serif;
    color:var(--ops-dark);
    background:var(--ops-bg);
    padding:28px;
    border-radius:24px;
}

/* ---------- Alert ---------- */
.ops-alert{
    display:flex; align-items:center; gap:10px;
    padding:14px 18px; border-radius:14px; font-size:14px; font-weight:600;
    margin-bottom:20px;
}
.ops-alert-success{
    background:rgba(22,163,74,.08); color:var(--ops-success); border:1px solid rgba(22,163,74,.2);
}
.ops-alert i{ font-size:16px; }

/* ---------- Breadcrumb ---------- */
.ops-breadcrumb{
    display:flex; align-items:center; gap:10px; font-size:13.5px; color:#9CA3AF;
    margin-bottom:20px; flex-wrap:wrap;
}
.ops-breadcrumb a{ color:#6B7280; font-weight:500; }
.ops-breadcrumb a:hover{ color:var(--ops-accent); }
.ops-breadcrumb i{ font-size:9px; color:#D1D5DB; }
.ops-breadcrumb-active{ color:var(--ops-accent); font-weight:600; }

/* ---------- Card base ---------- */
.ops-card{
    background:#fff; border:1px solid var(--ops-border); border-radius:var(--ops-radius);
    box-shadow:var(--ops-shadow); margin-bottom:24px; overflow:hidden;
}

/* ---------- Project header ---------- */
.ops-project-card{ display:flex; justify-content:space-between; align-items:center; gap:24px; flex-wrap:wrap; padding:26px; }
.ops-project-left{ display:flex; align-items:center; gap:18px; }
.ops-project-icon{
    width:60px; height:60px; border-radius:16px; flex-shrink:0;
    background:rgba(0,168,198,.08); color:var(--ops-accent);
    display:flex; align-items:center; justify-content:center; font-size:22px;
}
.ops-project-name{ font-size:19px; font-weight:700; margin:0 0 6px; }
.ops-project-meta{ display:flex; gap:20px; flex-wrap:wrap; color:#6B7280; font-size:13px; }
.ops-project-meta span{ display:inline-flex; align-items:center; gap:6px; }
.ops-project-meta i{ color:var(--ops-accent); font-size:12px; }

.ops-project-right{ min-width:240px; }
.ops-progress-head{ display:flex; align-items:baseline; justify-content:space-between; margin-bottom:8px; font-size:13.5px; color:#6B7280; }
.ops-progress-head strong{ font-size:20px; color:var(--ops-dark); font-weight:700; }
.ops-progress-track{ height:10px; border-radius:999px; background:var(--ops-border); overflow:hidden; }
.ops-progress-fill{
    height:100%; border-radius:999px;
    background:linear-gradient(90deg, var(--ops-accent), #0EC8DE);
    transition:width 1.1s cubic-bezier(.4,0,.2,1);
}
.ops-progress-sub{ display:block; margin-top:8px; color:#9CA3AF; font-size:12.5px; }

/* ---------- Tabs ---------- */
.ops-tabs-card{ padding:0; }

.ops-tabs-nav{
    display:flex;
    gap:4px;
    padding:16px 16px 0;
    overflow-x:auto;
    border-bottom:1px solid var(--ops-border);
    scrollbar-width:thin;
}
.ops-tab-btn{
    display:inline-flex; align-items:center; gap:8px;
    background:transparent; border:none;
    color:#6B7280; font-size:13.5px; font-weight:600;
    padding:12px 18px; border-radius:12px 12px 0 0;
    cursor:pointer; white-space:nowrap;
    border-bottom:3px solid transparent;
    transition:color .2s ease, background .2s ease, border-color .2s ease;
}
.ops-tab-btn i{ color:#9CA3AF; font-size:13px; transition:color .2s ease; }
.ops-tab-btn:hover{ color:var(--ops-dark); background:var(--ops-bg); }
.ops-tab-btn.active{
    color:var(--ops-accent);
    background:rgba(0,168,198,.06);
    border-bottom-color:var(--ops-accent);
}
.ops-tab-btn.active i{ color:var(--ops-accent); }
.ops-tab-count{
    background:rgba(0,168,198,.1); color:var(--ops-accent);
    font-size:11px; font-weight:700;
    padding:2px 8px; border-radius:999px;
}
.ops-tab-btn:not(.active) .ops-tab-count{ background:#F3F4F6; color:#9CA3AF; }

.ops-tab-pane{ display:none; }
.ops-tab-pane.active{ display:block; }

/* ---------- Table ---------- */
.ops-table-wrap{ padding:6px; }
.ops-table{ width:100%; border-collapse:collapse; }
.ops-table thead th{
    color:#9CA3AF; font-size:11.5px; font-weight:600; text-transform:uppercase; letter-spacing:.04em;
    padding:14px 18px; text-align:left; border-bottom:1px solid var(--ops-border);
}
.ops-table tbody td{
    padding:14px 18px; border-bottom:1px solid var(--ops-border); vertical-align:top; font-size:14px;
}
.ops-table tbody tr:last-child td{ border-bottom:none; }
.ops-table tbody tr{ transition:background .2s ease; }
.ops-table tbody tr:hover{ background:var(--ops-bg); }

.ops-index{ color:#9CA3AF; font-weight:600; padding-top:16px !important; }
.ops-task-name{ font-weight:600; font-size:14px; }
.ops-task-desc{ color:#9CA3AF; font-size:12.5px; display:block; margin-top:2px; }

/* Row left accent by status */
.ops-row{ border-left:3px solid transparent; }
.ops-row-pending td:first-child{ box-shadow:inset 3px 0 0 #D1D5DB; }
.ops-row-working td:first-child{ box-shadow:inset 3px 0 0 var(--ops-warning); }
.ops-row-completed td:first-child{ box-shadow:inset 3px 0 0 var(--ops-success); }
.ops-row-rejected td:first-child{ box-shadow:inset 3px 0 0 var(--ops-danger); }
.ops-row-verified td:first-child{ box-shadow:inset 3px 0 0 var(--ops-accent); }

/* ---------- Merged Form Layout ---------- */
.ops-task-form{ margin:0; }
.ops-form-row{
    display:flex;
    align-items:flex-start;
    gap:12px;
    flex-wrap:wrap;
}

.ops-status-col{ flex:0 0 160px; }
.ops-remarks-col{ flex:1 1 220px; min-width:180px; }
.ops-save-col{ flex:0 0 auto; padding-top:1px; }

.ops-select{
    width:100%; height:42px; border-radius:11px; border:1px solid var(--ops-border);
    padding:0 12px; font-size:13.5px; background:#fff; cursor:pointer;
    transition:border-color .2s ease, box-shadow .2s ease;
}
.ops-select:focus{ outline:none; border-color:var(--ops-accent); box-shadow:0 0 0 4px rgba(0,168,198,.12); }

.ops-textarea{
    width:100%; min-height:42px; border-radius:11px; border:1px solid var(--ops-border);
    padding:10px 12px; font-size:13.5px; resize:vertical;
    transition:border-color .2s ease, box-shadow .2s ease;
}
.ops-textarea:focus{ outline:none; border-color:var(--ops-accent); box-shadow:0 0 0 4px rgba(0,168,198,.12); }

.ops-save-btn{
    display:inline-flex; align-items:center; gap:6px;
    background:var(--ops-accent); color:#fff; border:none;
    font-size:12.5px; font-weight:600; padding:12px 16px; border-radius:9px;
    height:42px;
    cursor:pointer; transition:background .2s ease;
}
.ops-save-btn:hover{ background:#00909e; }

/* ---------- Hidden helper ---------- */
.ops-hidden{ display:none; }

/* ---------- Pills ---------- */
.ops-pill{ display:inline-flex; align-items:center; font-size:11.5px; font-weight:600; padding:5px 12px; border-radius:999px; }
.ops-pill-neutral{ background:#F3F4F6; color:#9CA3AF; }

/* ---------- Empty state ---------- */
.ops-empty-cell{ padding:0 !important; border-bottom:none !important; }
.ops-empty-state{ text-align:center; padding:50px 10px; color:#9CA3AF; }
.ops-empty-state i{ font-size:28px; margin-bottom:8px; display:block; color:#D1D5DB; }

/* ---------- Fade-up ---------- */
.fade-up{ opacity:1; }

/* ---------- Responsive ---------- */
@media (max-width: 992px){
    .ops-project-card{ flex-direction:column; align-items:flex-start; }
    .ops-project-right{ width:100%; }
}
@media (max-width: 768px){
    .ops-status-col{ flex:1 1 100%; }
    .ops-remarks-col{ flex:1 1 100%; }
    .ops-save-col{ flex:1 1 100%; }
    .ops-save-btn{ width:100%; justify-content:center; }
}
@media (max-width: 576px){
    .ops-page{ padding:16px; }
    .ops-tabs-nav{ padding:12px 12px 0; }
    .ops-tab-btn{ padding:10px 14px; font-size:12.5px; }
}
</style>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
$(function () {

    /*
    |--------------------------------------------------------------------------
    | Entrance animation
    |--------------------------------------------------------------------------
    */
    if (window.gsap) {
        gsap.from('.fade-up', {
            y: 18,
            opacity: 0,
            duration: 0.5,
            stagger: 0.08,
            ease: 'power2.out'
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Animated progress counter (visual only)
    |--------------------------------------------------------------------------
    */
    $('[data-counter]').each(function () {
        let $el = $(this);
        let end = parseInt($el.attr('data-counter'), 10) || 0;
        let start = 0;
        let duration = 800;
        let startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            let progress = Math.min((timestamp - startTime) / duration, 1);
            $el.text(Math.floor(progress * (end - start) + start));
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                $el.text(end);
            }
        }
        window.requestAnimationFrame(step);
    });

    /*
    |--------------------------------------------------------------------------
    | Category Tabs
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.ops-tab-btn', function () {
        let target = $(this).data('tab-target');

        $('.ops-tab-btn').removeClass('active');
        $(this).addClass('active');

        $('.ops-tab-pane').removeClass('active');
        $('#' + target).addClass('active');
    });

    /*
    |--------------------------------------------------------------------------
    | Auto-expanding remarks textarea (visual only)
    |--------------------------------------------------------------------------
    */
    function autoExpand($ta) {
        $ta.css('height', 'auto');
        $ta.css('height', $ta[0].scrollHeight + 'px');
    }

    $('.ops-textarea').each(function () {
        autoExpand($(this));
    });

    $(document).on('input', '.ops-textarea', function () {
        autoExpand($(this));
    });

    /*
    |--------------------------------------------------------------------------
    | Show remarks field only when status = rejected
    |--------------------------------------------------------------------------
    */
    $(document).on('change', '.ops-select', function () {
        let val = $(this).val();
        let $remarksWrap = $(this).closest('.ops-form-row').find('.ops-remarks-wrap');

        if (val === 'rejected') {
            $remarksWrap.removeClass('ops-hidden');
            autoExpand($remarksWrap.find('.ops-textarea'));
        } else {
            $remarksWrap.addClass('ops-hidden');
        }
    });

});
</script>
@endpush