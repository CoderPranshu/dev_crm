@extends('index')

@push('title', get_phrase('On Page SEO Tasks'))

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>
    .bce-page {
        --bce-primary: #0F8EA3;
        --bce-primary-light: #16B6C8;
        --bce-bg: #F8FAFC;
        --bce-card: #FFFFFF;
        --bce-border: #E8EDF3;
        --bce-text: #1F2937;
        --bce-text-soft: #6B7280;
        --bce-success: #22C55E;
        --bce-success-soft: #E9FBF0;
        --bce-danger: #EF4444;
        --bce-danger-soft: #FDECEC;
        --bce-warning: #F59E0B;
        --bce-radius-lg: 18px;
        --bce-radius-md: 12px;
        --bce-radius-sm: 8px;
        --bce-shadow-sm: 0 1px 2px rgba(15,23,42,.04);
        --bce-shadow-md: 0 6px 20px -8px rgba(15,23,42,.10);
        --bce-shadow-lg: 0 16px 40px -16px rgba(15,23,42,.16);

        /* background: var(--bce-bg); */
        color: var(--bce-text);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Inter, Roboto, Helvetica, Arial, sans-serif;
        /* padding: 28px clamp(16px, 3vw, 36px) 60px; */
        min-height: 100%;
    }

    .bce-page *, .bce-page *::before, .bce-page *::after { box-sizing: border-box; }

    .bce-page ::-webkit-scrollbar { width: 8px; height: 8px; }
    .bce-page ::-webkit-scrollbar-track { background: transparent; }
    .bce-page ::-webkit-scrollbar-thumb { background: #D7DEE8; border-radius: 999px; }
    .bce-page ::-webkit-scrollbar-thumb:hover { background: #C2CBDA; }

    @media (prefers-reduced-motion: reduce) {
        .bce-page * { animation: none !important; transition: none !important; }
    }

    /* ---------- Breadcrumb ---------- */
    .bce-crumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--bce-text-soft); margin-bottom: 14px; }
    .bce-crumb .bce-crumb-current { color: var(--bce-text); font-weight: 600; }
    .bce-crumb i { font-size: 10px; opacity: .6; }

    /* ---------- Header ---------- */
    .bce-header {
        display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; flex-wrap: wrap;
        padding: 10px 0 24px;
    }
    .bce-title { font-size: 26px; font-weight: 700; letter-spacing: -.02em; color: var(--bce-text); margin: 0 0 6px; }
    .bce-subtitle { font-size: 14.5px; color: var(--bce-text-soft); margin: 0; max-width: 520px; }

    .bce-btn-gradient {
        display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px; color: #fff;
        background: linear-gradient(135deg, var(--bce-primary), var(--bce-primary-light));
        border: none; border-radius: 999px; padding: 11px 20px; box-shadow: 0 10px 24px -10px rgba(15,142,163,.55);
        transition: transform .16s ease, box-shadow .16s ease, filter .16s ease; text-decoration: none;
    }
    .bce-btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 16px 30px -12px rgba(15,142,163,.6); filter: brightness(1.04); color: #fff; }
    .bce-btn-gradient:active { transform: translateY(0); }

    /* ---------- Search toolbar ---------- */
    .bce-toolbar {
        background: var(--bce-card); border: 1px solid var(--bce-border); border-radius: var(--bce-radius-lg);
        box-shadow: var(--bce-shadow-sm); padding: 16px 18px; margin-bottom: 22px;
    }
    .bce-toolbar-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .bce-search-field { position: relative; flex: 1 1 280px; }
    .bce-search-field i {
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--bce-text-soft); font-size: 14px;
    }
    .bce-search-field input {
        width: 100%; border: 1px solid var(--bce-border); background: var(--bce-bg); border-radius: 999px;
        padding: 11px 16px 11px 40px; font-size: 14px; color: var(--bce-text); transition: all .15s ease;
    }
    .bce-search-field input:focus {
        outline: none; background: #fff; border-color: var(--bce-primary);
        box-shadow: 0 0 0 4px rgba(15,142,163,.12);
    }

    .bce-select-field { flex: 0 1 220px; min-width: 170px; }
    .bce-select-field select {
        width: 100%; border: 1px solid var(--bce-border); background: var(--bce-bg); border-radius: 999px;
        padding: 11px 34px 11px 16px; font-size: 13.5px; color: var(--bce-text); transition: all .15s ease;
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8' fill='none'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%236B7280' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
    }
    .bce-select-field select:focus {
        outline: none; background-color: #fff; border-color: var(--bce-primary);
        box-shadow: 0 0 0 4px rgba(15,142,163,.12);
    }

    .bce-btn-search {
        border: none; border-radius: 999px; padding: 11px 22px; font-weight: 600; font-size: 14px; color: #fff;
        background: var(--bce-primary); transition: background .15s ease, transform .1s ease;
    }
    .bce-btn-search:hover { background: #0C7688; color: #fff; }
    .bce-btn-search:active { transform: scale(.97); }
    .bce-btn-reset {
        border: 1px solid var(--bce-border); border-radius: 999px; padding: 11px 18px; font-weight: 600; font-size: 14px;
        color: var(--bce-text-soft); background: #fff; transition: all .15s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    }
    .bce-btn-reset:hover { background: var(--bce-bg); color: var(--bce-text); border-color: #D7DEE8; }

    .bce-result-counter { font-size: 13px; color: var(--bce-text-soft); margin-top: 12px; padding-top: 12px; border-top: 1px dashed var(--bce-border); }
    .bce-result-counter strong { color: var(--bce-text); font-weight: 600; }

    /* ---------- Table ---------- */
    .bce-table-card {
        background: var(--bce-card); border: 1px solid var(--bce-border); border-radius: var(--bce-radius-lg);
        box-shadow: var(--bce-shadow-sm); overflow: hidden; opacity: 0; animation: bceFadeUp .5s ease forwards;
    }
    @keyframes bceFadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .bce-table-wrap { overflow-x: auto; max-height: 640px; }
    .bce-table { width: 100%; border-collapse: collapse; min-width: 1020px; }
    .bce-table thead th {
        position: sticky; top: 0; z-index: 2; background: #FBFCFE; text-align: left; font-size: 11.5px; font-weight: 600;
        letter-spacing: .06em; text-transform: uppercase; color: var(--bce-text-soft);
        padding: 14px 18px; border-bottom: 1px solid var(--bce-border); white-space: nowrap;
    }
    .bce-table thead th.text-center { text-align: center; }
    .bce-table tbody td { padding: 15px 18px; border-bottom: 1px solid var(--bce-border); vertical-align: middle; font-size: 14px; color: var(--bce-text); }
    .bce-table tbody tr:last-child td { border-bottom: none; }
    .bce-table tbody tr { transition: background .12s ease; }
    .bce-table tbody tr:nth-child(even) { background: #FAFBFD; }
    .bce-table tbody tr:hover { background: #F1F8FA; }
    .bce-row-num { color: var(--bce-text-soft); font-variant-numeric: tabular-nums; font-size: 13px; }

    .bce-cat-badge {
        display: inline-block; font-size: 12px; font-weight: 600; color: var(--bce-primary);
        background: color-mix(in srgb, var(--bce-primary) 10%, white); border-radius: 999px; padding: 4px 11px; white-space: nowrap;
    }

    .bce-task-cell { display: flex; align-items: center; gap: 10px; }
    .bce-task-icon {
        width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
        background: var(--bce-bg); color: var(--bce-text-soft); font-size: 13px; border: 1px solid var(--bce-border);
    }
    .bce-task-name { font-weight: 600; color: var(--bce-text); font-size: 14px; }

    .bce-type-badge {
        display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .03em; color: var(--bce-text-soft);
        background: var(--bce-bg); border: 1px solid var(--bce-border); border-radius: 999px; padding: 4px 10px; white-space: nowrap;
    }

    .bce-placeholder-col { color: var(--bce-text-soft); font-size: 13.5px; max-width: 220px; }
    .bce-muted-dash { color: #C7CEDA; }

    .bce-sort-chip {
        display: inline-flex; align-items: center; justify-content: center; min-width: 30px; font-size: 12.5px; font-weight: 700;
        background: var(--bce-bg); border: 1px solid var(--bce-border); border-radius: var(--bce-radius-sm); padding: 4px 8px;
        font-variant-numeric: tabular-nums; color: var(--bce-text-soft);
    }

    /* Pills (Required / Status) */
    .bce-pill {
        display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; border-radius: 999px;
        padding: 5px 12px 5px 10px; white-space: nowrap;
    }
    .bce-pill .bce-dot { width: 7px; height: 7px; border-radius: 50%; }
    .bce-pill--yes { background: var(--bce-success-soft); color: #16803D; }
    .bce-pill--yes .bce-dot { background: var(--bce-success); }
    .bce-pill--no { background: #F1F3F6; color: #6B7280; }
    .bce-pill--no .bce-dot { background: #9CA3AF; }
    .bce-pill--active { background: var(--bce-success-soft); color: #16803D; }
    .bce-pill--active .bce-dot { background: var(--bce-success); }
    .bce-pill--inactive { background: var(--bce-danger-soft); color: #B3261E; }
    .bce-pill--inactive .bce-dot { background: var(--bce-danger); }

    /* Row actions */
    .bce-row-actions { display: inline-flex; align-items: center; gap: 8px; justify-content: center; }
    .bce-icon-btn {
        width: 34px; height: 34px; border-radius: var(--bce-radius-sm); border: 1px solid var(--bce-border); background: #fff;
        display: inline-flex; align-items: center; justify-content: center; transition: all .14s ease; box-shadow: var(--bce-shadow-sm);
        text-decoration: none; cursor: pointer; font-size: 13px;
    }
    .bce-icon-btn--edit { color: var(--bce-warning); }
    .bce-icon-btn--edit:hover { background: #FEF6E7; border-color: #F3D68A; color: #92620A; }
    .bce-icon-btn--delete { color: var(--bce-danger); }
    .bce-icon-btn--delete:hover { background: var(--bce-danger-soft); border-color: #F2B9B3; color: #B3261E; }

    /* ---------- Empty state ---------- */
    .bce-empty { text-align: center; padding: 64px 20px; }
    .bce-empty .bce-empty-icon {
        width: 76px; height: 76px; border-radius: 22px; background: var(--bce-bg); color: #B9C1CE;
        display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 18px;
    }
    .bce-empty h5 { font-size: 18px; font-weight: 700; color: var(--bce-text); margin-bottom: 6px; }
    .bce-empty p { font-size: 14px; color: var(--bce-text-soft); margin-bottom: 0; }

    /* ---------- Pagination ---------- */
    .bce-pagination-wrap { display: flex; justify-content: flex-end; margin-top: 20px; }
    .bce-pagination-wrap .pagination { gap: 6px; margin: 0; }
    .bce-pagination-wrap .page-item .page-link {
        border: 1px solid var(--bce-border); border-radius: 999px !important; color: var(--bce-text-soft);
        font-size: 13.5px; font-weight: 600; padding: 8px 14px; min-width: 38px; text-align: center; box-shadow: none;
        transition: all .14s ease;
    }
    .bce-pagination-wrap .page-item .page-link:hover { background: var(--bce-bg); color: var(--bce-text); }
    .bce-pagination-wrap .page-item.active .page-link {
        background: var(--bce-primary); border-color: var(--bce-primary); color: #fff;
    }
    .bce-pagination-wrap .page-item.disabled .page-link { opacity: .45; }

    @media (max-width: 640px) {
        .bce-page { padding: 18px 14px 50px; }
        .bce-title { font-size: 21px; }
        .bce-header { flex-direction: column; }
        .bce-btn-gradient { width: 100%; justify-content: center; }
        .bce-pagination-wrap { justify-content: center; }
    }
</style>
@endpush

@section('content')

@php
    $bceTypeIcons = [
        'text' => 'fa-font',
        'textarea' => 'fa-align-left',
        'select' => 'fa-caret-down',
        'checkbox' => 'fa-square-check',
        'radio' => 'fa-circle-dot',
        'number' => 'fa-hashtag',
        'file' => 'fa-paperclip',
        'date' => 'fa-calendar-days',
    ];
@endphp

<div class="bce-page">

    <nav class="bce-crumb" aria-label="breadcrumb">
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right"></i>
        <span>SEO</span>
        <i class="fa-solid fa-chevron-right"></i>
        <span class="bce-crumb-current">On Page SEO Tasks</span>
    </nav>

    <div class="bce-header">
        <div>
            <h1 class="bce-title">On Page SEO Tasks</h1>
            <p class="bce-subtitle">Manage Master On Page SEO Tasks.</p>
        </div>
        <a href="{{ route('admin.onpage-seo-task.create') }}" class="bce-btn-gradient">
            <i class="fa fa-plus"></i>
            Add Task
        </a>
    </div>

    {{-- ============ Search Toolbar ============ --}}
    <div class="bce-toolbar">
        <form method="GET">
            <div class="bce-toolbar-row">
                <div class="bce-search-field">
                    <i class="fa fa-search"></i>
                    <input type="text"
                        name="search"
                        placeholder="Search Task..."
                        value="{{ request('search') }}">
                </div>

                <div class="bce-select-field">
                    <select name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category')==$category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bce-btn-search">
                    Search
                </button>

                <a href="{{ url()->current() }}" class="bce-btn-reset">
                    <i class="fa fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>

        <div class="bce-result-counter">
            @if($tasks->total() > 0)
                Showing <strong>{{ $tasks->firstItem() }}–{{ $tasks->lastItem() }}</strong>
                of <strong>{{ $tasks->total() }}</strong> tasks
                @if(request('search'))
                    for &ldquo;<strong>{{ request('search') }}</strong>&rdquo;
                @endif
            @else
                No tasks match your current filters
            @endif
        </div>
    </div>

    {{-- ============ Table ============ --}}
    <div class="bce-table-card">
        <div class="bce-table-wrap">
            <table class="bce-table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Category</th>
                        <th>Task</th>
                        <th style="width:130px">Input Type</th>
                        <th>Placeholder</th>
                        <th style="width:100px">Required</th>
                        <th style="width:80px">Sort</th>
                        <th style="width:110px">Status</th>
                        <th style="width:120px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $key=>$task)
                        @php
                            $bceTypeIcon = $bceTypeIcons[strtolower($task->input_type)] ?? 'fa-i-cursor';
                        @endphp
                        <tr>
                            <td class="bce-row-num">{{ $tasks->firstItem()+$key }}</td>

                            <td>
                                <span class="bce-cat-badge">{{ $task->category->name }}</span>
                            </td>

                            <td>
                                <div class="bce-task-cell">
                                    <span class="bce-task-icon"><i class="fa fa-list-check"></i></span>
                                    <span class="bce-task-name">{{ $task->task_name }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="bce-type-badge">
                                    <i class="fa {{ $bceTypeIcon }} me-1"></i>
                                    {{ strtoupper($task->input_type) }}
                                </span>
                            </td>

                            <td class="bce-placeholder-col">
                                @if($task->placeholder)
                                    {{ $task->placeholder }}
                                @else
                                    <span class="bce-muted-dash">&mdash;</span>
                                @endif
                            </td>

                            <td>
                                @if($task->is_required)
                                    <span class="bce-pill bce-pill--yes"><span class="bce-dot"></span> Yes</span>
                                @else
                                    <span class="bce-pill bce-pill--no"><span class="bce-dot"></span> No</span>
                                @endif
                            </td>

                            <td>
                                <span class="bce-sort-chip">{{ $task->sort_order }}</span>
                            </td>

                            <td>
                                @if($task->status=='active')
                                    <span class="bce-pill bce-pill--active"><span class="bce-dot"></span> Active</span>
                                @else
                                    <span class="bce-pill bce-pill--inactive"><span class="bce-dot"></span> Inactive</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="bce-row-actions">
                                    <a href="{{ route('admin.onpage-seo-task.edit',$task->id) }}"
                                       class="bce-icon-btn bce-icon-btn--edit" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.onpage-seo-task.destroy',$task->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Delete Task?')"
                                            class="bce-icon-btn bce-icon-btn--delete" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="bce-empty">
                                    <span class="bce-empty-icon"><i class="fa fa-folder-open"></i></span>
                                    <h5>No Tasks Found</h5>
                                    <p>Click "Add Task" to create your first SEO Task.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bce-pagination-wrap">
        {{ $tasks->links() }}
    </div>

</div>

@endsection