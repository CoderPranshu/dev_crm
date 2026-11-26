{{-- resources/views/seo-project-keywords/index.blade.php --}}
@extends('index')

@section('title', 'SEO Project Keywords')

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

<style>
    .skw {
        --ink: #12172b;
        --muted: #5b6480;
        --canvas: #f3f5fa;
        --surface: #fff;
        --border: #e3e7f0;
        --primary: #26315f;
        --primary-dark: #1a2247;
        --primary-soft: #eef1fa;
        --accent: #0ea5a4;
        --accent-soft: #e1f6f5;
        --danger: #d65c4a;
        --danger-soft: #fbeae7;
        --shadow: 0 1px 2px rgba(18,23,43,.05), 0 12px 30px -18px rgba(18,23,43,.2);
        min-height: 100%; padding: 5px 0 120px; color: var(--ink); background: var(--canvas);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .skw *, .skw *::before, .skw *::after { box-sizing: border-box; }
    .skw-shell { width: 100%; max-width: 1500px; margin: 0 auto; }
    .skw-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
    .skw-eyebrow { margin: 0 0 5px; color: var(--accent); font: 600 11px/1.4 'Sora',sans-serif; letter-spacing: .14em; text-transform: uppercase; }
    .skw-title { margin: 0; color: var(--ink); font: 700 26px/1.25 'Sora',sans-serif; }
    .skw-back, .skw-add-btn { display: inline-flex; align-items: center; justify-content: center; gap: 7px; border-radius: 999px; font: 600 13px/1 'Sora',sans-serif; text-decoration: none; transition: .15s ease; }
    .skw-back { padding: 10px 16px; color: var(--primary); background: #fff; border: 1px solid var(--border); }
    .skw-back:hover { color: var(--primary-dark); border-color: #c9d0e4; transform: translateX(-2px); }
    .skw-back svg, .skw-add-btn svg { width: 15px; height: 15px; }
    .skw-alert { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 18px; padding: 13px 16px; border: 1px solid transparent; border-radius: 10px; font-size: 14px; font-weight: 500; }
    .skw-alert--success { color: #0b6e6d; background: var(--accent-soft); border-color: #bee9e7; }
    .skw-alert--danger { color: #9e3b2b; background: var(--danger-soft); border-color: #f2ccc4; }
    .skw-alert ul { margin: 0; padding-left: 18px; }
    .skw-card { margin-bottom: 24px; overflow: hidden; background: var(--surface); border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow); }
    .skw-card-head { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 18px 22px; background: linear-gradient(180deg,#fbfcfe,#fff); border-bottom: 1px solid var(--border); }
    .skw-card-title-wrap { display: flex; align-items: center; gap: 10px; }
    .skw-card-icon { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; flex: 0 0 36px; color: #1d5257; background: #acc7ca; border-radius: 10px; }
    .skw-card-icon svg { width: 18px; height: 18px; }
    .skw-card-title { color: var(--ink); font: 600 16px/1.3 'Sora',sans-serif; }
    .skw-count { padding: 3px 8px; color: var(--muted); background: var(--canvas); border: 1px solid var(--border); border-radius: 999px; font: 500 11px/1.4 'JetBrains Mono',monospace; }
    .skw-add-btn { min-height: 36px; padding: 9px 15px; color: #fff; background: #1d5257; border: 0; cursor: pointer; }
    .skw-add-btn:hover { color: #fff; background: var(--primary-dark); transform: translateY(-1px); }
    .skw-add-btn:active { transform: scale(.98); }
    .skw-add-btn--small { min-height: 32px; padding: 8px 13px; font-size: 12px; }
    .skw-table-wrap { width: 100%; overflow-x: auto; scrollbar-color: #aeb6ca #eef1f6; scrollbar-width: thin; }
    .skw-table-wrap::-webkit-scrollbar { height: 9px; }
    .skw-table-wrap::-webkit-scrollbar-track { background: #eef1f6; border-radius: 999px; }
    .skw-table-wrap::-webkit-scrollbar-thumb { background: #aeb6ca; border-radius: 999px; }
    .skw-table { width: 100%; min-width: 650px; border-collapse: separate; border-spacing: 0; }
    .skw-table thead th { padding: 13px 14px; color: var(--muted); background: #fafbfe; border-bottom: 1px solid var(--border); font: 600 11px/1.3 'Sora',sans-serif; letter-spacing: .07em; text-align: left; text-transform: uppercase; white-space: nowrap; }
    .skw-month-heading { display: flex; align-items: flex-start; flex-direction: column; gap: 4px; }
    .skw-month-heading small { color: var(--primary); font: 600 10px/1.2 'Inter',sans-serif; letter-spacing: 0; text-transform: none; }
    .skw-table tbody tr { transition: background .12s ease, opacity .18s ease, transform .18s ease; }
    .skw-table tbody tr:not(:last-child) td { border-bottom: 1px solid var(--border); }
    .skw-table tbody tr:hover td { background-color: #fafbfe; }
    .skw-table tbody tr.skw-row-exit { opacity: 0; transform: translateX(8px); }
    .skw-table td { padding: 8px 14px; background: #fff; vertical-align: middle; }
    .skw-col-narrow { width: 76px; min-width: 76px; text-align: center !important; }
    .skw-input { width: 100%; min-width: 90px; padding: 8px 9px; color: var(--ink); background: transparent; border: 1px solid transparent; border-radius: 7px; font: 500 13px/1.3 'Inter',sans-serif; transition: .12s ease; }
    .skw-input:hover { background: var(--canvas); }
    .skw-input:focus { outline: 0; background: #fff; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(38,49,95,.1); }
    .skw-input--num { font-family: 'JetBrains Mono',monospace; text-align: right; }
    .skw-input--keyword { min-width: 170px; font-weight: 600; }
    .skw-rank-cell { display: flex; align-items: center; gap: 6px; }
    .skw-rank-cell .skw-input { width: 66px; min-width: 66px; }
    .skw-delta { min-width: 31px; padding: 3px 5px; color: var(--muted); background: var(--canvas); border: 1px solid var(--border); border-radius: 999px; font: 500 10px/1 'JetBrains Mono',monospace; text-align: center; }
    .skw-delta[data-state="up"] { color: #0b6e6d; background: var(--accent-soft); border-color: #bee9e7; }
    .skw-delta[data-state="down"] { color: #9e3b2b; background: var(--danger-soft); border-color: #f2ccc4; }
    .skw-del-btn { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; padding: 0; color: var(--muted); background: #fff; border: 1px solid var(--border); border-radius: 9px; cursor: pointer; transition: .13s ease; }
    .skw-del-btn:hover { color: #fff; background: var(--danger); border-color: var(--danger); transform: translateY(-1px); }
    .skw-del-btn svg { width: 15px; height: 15px; }
    .skw-empty { padding: 32px 20px; color: var(--muted); text-align: center; }
    .skw-empty p { margin: 0; font-size: 13px; }

    /* State group cards */
    .skw-state-groups { display: grid; gap: 18px; padding: 18px; background: #f7f8fc; }
    .skw-state-group { min-width: 0; overflow: hidden; background: #fff; border: 1px solid #dfe4ef; border-radius: 14px; box-shadow: 0 8px 22px -20px rgba(18,23,43,.45); }
    .skw-state-group-head { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 15px 16px; background: linear-gradient(90deg,#f4f6fc 0%,#fff 72%); border-bottom: 1px solid var(--border); }
    .skw-state-group-name { display: flex; align-items: center; gap: 10px; min-width: 0; }
    .skw-state-group-mark { width: 9px; height: 32px; flex: 0 0 9px; background: linear-gradient(180deg,var(--primary),#6574b8); border-radius: 999px; }
    .skw-state-group-title { margin: 0; overflow: hidden; color: var(--ink); font: 700 15px/1.3 'Sora',sans-serif; text-overflow: ellipsis; white-space: nowrap; }
    .skw-state-group-meta { display: block; margin-top: 3px; color: var(--muted); font-size: 11px; }
    .skw-state-table { table-layout: auto; }
    .skw-state-table th:first-child, .skw-state-table td:first-child { position: sticky; left: 0; z-index: 2; width: 220px; min-width: 220px; box-shadow: 8px 0 14px -16px rgba(18,23,43,.8); }
    .skw-state-table th:last-child, .skw-state-table td:last-child { position: sticky; right: 0; z-index: 2; background: #fff; box-shadow: -8px 0 14px -16px rgba(18,23,43,.8); }
    .skw-state-table thead th:first-child, .skw-state-table thead th:last-child { z-index: 3; background: #f5f7fb; }
    .skw-state-table .skw-input--num { width: 76px; min-width: 76px; }

    .skw-savebar { position: fixed; right: 0; bottom: 0; left: 0; z-index: 20; background: rgba(255,255,255,.92); border-top: 1px solid var(--border); box-shadow: 0 -8px 24px -18px rgba(18,23,43,.25); backdrop-filter: blur(10px); }
    .skw-savebar-inner { display: flex; align-items: center; justify-content: space-between; gap: 14px; max-width: 1500px; margin: 0 auto; padding: 13px 24px; }
    .skw-dirty-note { display: flex; align-items: center; gap: 7px; color: var(--muted); font-size: 13px; opacity: 0; transition: opacity .2s ease; }
    .skw-dirty-note.is-visible { opacity: 1; }
    .skw-dirty-dot { width: 7px; height: 7px; background: #e0a63e; border-radius: 50%; }
    .skw-save-btn { min-width: 142px; padding: 12px 25px; color: #fff; background: #1d5257; border: 0; border-radius: 999px; box-shadow: var(--shadow); cursor: pointer; font: 700 14px/1 'Sora',sans-serif; transition: .15s ease; }
    .skw-save-btn:hover { background: var(--primary-dark); transform: translateY(-1px); }

    @media (max-width: 767px) {
        .skw { padding: 22px 0 130px; }
        .skw-shell { padding: 0 12px; }
        .skw-header, .skw-card-head, .skw-state-group-head { align-items: stretch; flex-direction: column; }
        .skw-title { font-size: 21px; }
        .skw-add-btn, .skw-back { width: 100%; }
        .skw-state-groups { padding: 10px; }
        .skw-state-table th:first-child, .skw-state-table td:first-child { width: 170px; min-width: 170px; }
        .skw-savebar-inner { align-items: stretch; flex-direction: column; padding: 10px 12px; }
        .skw-save-btn { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="skw">
    <div class="skw-shell">
        <div class="skw-header">
            <div><p class="skw-eyebrow">SEO Performance</p><h1 class="skw-title">Project Keywords</h1></div>
            <a href="{{ url()->previous() }}" class="skw-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 18l-6-6 6-6"/></svg>
                Back to SEO Project
            </a>
        </div>

        @if (session('success'))
            <div class="skw-alert skw-alert--success"><span>{{ session('success') }}</span></div>
        @endif
        @if ($errors->any())
            <div class="skw-alert skw-alert--danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form id="seoProjectKeywordsForm" action="{{ route('seo-project-keywords.save', $seoPlanClient->id) }}" method="POST">
            @csrf
            <div id="deletedKeywordsContainer"></div>
            <div id="deletedAreasContainer"></div>
            <div id="deletedStatesContainer"></div>

            {{-- Keywords --}}
            <div class="skw-card">
                <div class="skw-card-head">
                    <div class="skw-card-title-wrap">
                        <span class="skw-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                        <span class="skw-card-title">Keywords</span><span class="skw-count" id="keywordCount">{{ $keywords->count() }}</span>
                    </div>
                    <button type="button" class="skw-add-btn" id="addKeywordRow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Keyword</button>
                </div>
                <div class="skw-table-wrap">
                    <table class="skw-table" id="keywordsTable">
                        <thead><tr><th style="min-width:190px">Keyword</th><th style="min-width:120px">Search Volume</th><th style="min-width:110px">Starting Rank</th>@foreach ($months as $month)<th style="min-width:105px"><span class="skw-month-heading"><span>Month {{ $month }}</span><small>{{ $monthDates[$month]->format('d M Y') }}</small></span></th>@endforeach<th class="skw-col-narrow">Remove</th></tr></thead>
                        <tbody>
                            @foreach ($keywords as $keyword)
                                <tr data-row-id="{{ $keyword->id }}">
                                    <td><input type="hidden" name="keywords[{{ $keyword->id }}][id]" value="{{ $keyword->id }}"><input type="text" class="skw-input skw-input--keyword" name="keywords[{{ $keyword->id }}][keyword]" value="{{ $keyword->keyword }}" required></td>
                                    <td><input type="number" min="0" class="skw-input skw-input--num" name="keywords[{{ $keyword->id }}][search_volume]" value="{{ $keyword->search_volume }}"></td>
                                    <td><input type="number" min="0" class="skw-input skw-input--num skw-starting-rank" name="keywords[{{ $keyword->id }}][starting_rank]" value="{{ $keyword->starting_rank }}"></td>
                                    @foreach ($months as $month)
                                        <td><div class="skw-rank-cell"><input type="number" min="0" class="skw-input skw-input--num skw-month-rank" name="keywords[{{ $keyword->id }}][rankings][{{ $month }}]" value="{{ $keyword->rankingsByMonth[$month] ?? '' }}"><span class="skw-delta" data-delta>&mdash;</span></div></td>
                                    @endforeach
                                    <td class="skw-col-narrow"><button type="button" class="skw-del-btn remove-row" data-section="keyword" data-id="{{ $keyword->id }}" data-delete-url="{{ route('admin.seo-project-keywords.destroy', ['seoPlanClient' => $seoPlanClient->id, 'keyword' => $keyword->id]) }}" aria-label="Remove keyword"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($keywords->isEmpty())<div class="skw-empty" id="keywordsEmpty"><p>No keywords yet — add one to start tracking rankings.</p></div>@endif
            </div>

            {{-- Areas --}}
            <div class="skw-card">
                <div class="skw-card-head">
                    <div class="skw-card-title-wrap">
                        <span class="skw-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                        <span class="skw-card-title">Areas We Serve</span><span class="skw-count" id="areaCount">{{ $areas->count() }}</span>
                    </div>
                    <button type="button" class="skw-add-btn" id="addAreaRow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Area</button>
                </div>
                <div class="skw-table-wrap">
                    <table class="skw-table" id="areasTable">
                        <thead><tr><th>Area Name</th><th class="skw-col-narrow">Remove</th></tr></thead>
                        <tbody>
                            @foreach ($areas as $area)
                                <tr data-row-id="{{ $area->id }}">
                                    <td><input type="hidden" name="areas[{{ $area->id }}][id]" value="{{ $area->id }}"><input type="text" class="skw-input skw-input--keyword" name="areas[{{ $area->id }}][name]" value="{{ $area->name }}" required></td>
                                    <td class="skw-col-narrow"><button type="button" class="skw-del-btn remove-row" data-section="area" data-id="{{ $area->id }}" data-delete-url="{{ route('admin.seo-project-locations.destroy', ['seoPlanClient' => $seoPlanClient->id, 'location' => $area->id]) }}" aria-label="Remove area"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($areas->isEmpty())<div class="skw-empty" id="areasEmpty"><p>No service areas added yet.</p></div>@endif
            </div>

            {{-- State groups --}}
            <div class="skw-card">
                <div class="skw-card-head">
                    <div class="skw-card-title-wrap">
                        <span class="skw-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l7 3 7-3 4 2v13l-4-2-7 3-7-3-4 2V5z"/><line x1="10" y1="6" x2="10" y2="19"/><line x1="17" y1="3" x2="17" y2="16"/></svg></span>
                        <span class="skw-card-title">Stats Groups</span><span class="skw-count">{{ $stateGroups->count() }}</span>
                    </div>
                    <button type="button" class="skw-add-btn" id="addStateGroup" data-url="{{ route('admin.seo-project-state-groups.store', $seoPlanClient) }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add State Group</button>
                </div>

                @if ($stateGroups->isNotEmpty())
                    <div class="skw-state-groups">
                        @foreach ($stateGroups as $group)
                            <section class="skw-state-group" data-state-group>
                                <div class="skw-state-group-head">
                                    <div class="skw-state-group-name"><span class="skw-state-group-mark"></span><div><h3 class="skw-state-group-title">{{ $group->name }}</h3><span class="skw-state-group-meta"><span data-state-count>{{ $group->states->count() }}</span> <span data-state-word>{{ $group->states->count() === 1 ? 'state' : 'states' }}</span></span></div></div>
                                    <button type="button" class="skw-add-btn skw-add-btn--small add-state-to-group" data-group-name="{{ $group->name }}" data-url="{{ route('admin.seo-project-states.store', ['seoPlanClient' => $seoPlanClient->id, 'stateGroup' => $group->id]) }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add State</button>
                                </div>
                                <div class="skw-table-wrap">
                                    <table class="skw-table skw-state-table" style="min-width: {{ 320 + (count($months) * 110) }}px">
                                        <thead><tr><th>State</th>@foreach ($months as $month)<th style="min-width:110px"><span class="skw-month-heading"><span>Month {{ $month }}</span><small>{{ $monthDates[$month]->format('d M Y') }}</small></span></th>@endforeach<th class="skw-col-narrow">Remove</th></tr></thead>
                                        <tbody>
                                            @forelse ($group->states as $state)
                                                <tr data-row-id="{{ $state->id }}">
                                                    <td><input type="hidden" name="states[{{ $state->id }}][id]" value="{{ $state->id }}"><input type="hidden" name="states[{{ $state->id }}][state_group_id]" value="{{ $group->id }}"><input type="text" class="skw-input skw-input--keyword" name="states[{{ $state->id }}][name]" value="{{ $state->name }}" required></td>
                                                    @foreach ($months as $month)<td><input type="number" min="0" class="skw-input skw-input--num" name="states[{{ $state->id }}][rankings][{{ $month }}]" value="{{ $state->rankingsByMonth[$month] ?? '' }}"></td>@endforeach
                                                    <td class="skw-col-narrow"><button type="button" class="skw-del-btn remove-row" data-section="state" data-id="{{ $state->id }}" data-delete-url="{{ route('admin.seo-project-locations.destroy', ['seoPlanClient' => $seoPlanClient->id, 'location' => $state->id]) }}" aria-label="Remove state"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></td>
                                                </tr>
                                            @empty
                                                <tr class="skw-no-state-row"><td colspan="{{ count($months) + 2 }}"><div class="skw-empty"><p>No states in this group yet.</p></div></td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        @endforeach
                    </div>
                @else
                    <div class="skw-empty"><p>No state groups added yet.</p></div>
                @endif
            </div>

            <div class="skw-savebar"><div class="skw-savebar-inner"><span class="skw-dirty-note" id="dirtyNote"><span class="skw-dirty-dot"></span>You have unsaved changes</span><button type="submit" class="skw-save-btn" id="saveAllButton">Save All</button></div></div>
        </form>
    </div>
</div>

<template id="keywordRowTemplate">
    <tr data-row-id="">
        <td><input type="hidden" name="keywords[__INDEX__][id]" value=""><input type="text" class="skw-input skw-input--keyword" name="keywords[__INDEX__][keyword]" required></td>
        <td><input type="number" min="0" class="skw-input skw-input--num" name="keywords[__INDEX__][search_volume]"></td>
        <td><input type="number" min="0" class="skw-input skw-input--num skw-starting-rank" name="keywords[__INDEX__][starting_rank]"></td>
        @foreach ($months as $month)<td><div class="skw-rank-cell"><input type="number" min="0" class="skw-input skw-input--num skw-month-rank" name="keywords[__INDEX__][rankings][{{ $month }}]"><span class="skw-delta" data-delta>&mdash;</span></div></td>@endforeach
        <td class="skw-col-narrow"><button type="button" class="skw-del-btn remove-row" data-section="keyword" data-id="" aria-label="Remove keyword"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></td>
    </tr>
</template>

<template id="areaRowTemplate">
    <tr data-row-id="">
        <td><input type="hidden" name="areas[__INDEX__][id]" value=""><input type="text" class="skw-input skw-input--keyword" name="areas[__INDEX__][name]" required></td>
        <td class="skw-col-narrow"><button type="button" class="skw-del-btn remove-row" data-section="area" data-id="" aria-label="Remove area"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></td>
    </tr>
</template>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function ($) {
    'use strict';
    const form = document.getElementById('seoProjectKeywordsForm');
    const dirtyNote = document.getElementById('dirtyNote');
    let newCounter = 0;

    function nextIndex() { newCounter += 1; return 'new' + Date.now() + '_' + newCounter; }
    function markDirty() { if (dirtyNote) dirtyNote.classList.add('is-visible'); }
    function escapeHtml(value) { return $('<div>').text(value || '').html(); }
    function ajaxErrorMessage(xhr, fallback) {
        if (xhr.responseJSON && xhr.responseJSON.errors) {
            const errors = Object.values(xhr.responseJSON.errors).flat();
            return errors.length ? errors[0] : fallback;
        }
        return xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : fallback;
    }
    function toast(icon, title) {
        return Swal.fire({ toast: true, position: 'top-end', icon: icon, title: title, showConfirmButton: false, timer: 2400, timerProgressBar: true });
    }
    function appendRow(templateId, tbodySelector, countSelector, emptySelector) {
        const html = $(templateId).html().split('__INDEX__').join(nextIndex());
        $(tbodySelector).append(html);
        $(emptySelector).remove();
        if (countSelector) $(countSelector).text($(tbodySelector).children('tr').length);
        markDirty();
    }

    $('#addKeywordRow').on('click', function () {
        appendRow('#keywordRowTemplate', '#keywordsTable tbody', '#keywordCount', '#keywordsEmpty');
        $('#keywordsTable tbody tr:last .skw-input--keyword').trigger('focus');
    });
    $('#addAreaRow').on('click', function () {
        appendRow('#areaRowTemplate', '#areasTable tbody', '#areaCount', '#areasEmpty');
        $('#areasTable tbody tr:last .skw-input--keyword').trigger('focus');
    });

    $('#addStateGroup').on('click', async function () {
        const url = $(this).data('url');
        const result = await Swal.fire({
            title: 'Add State Group', text: 'Enter a clear name for this group.', input: 'text', inputPlaceholder: 'Example: Website Backlinks',
            showCancelButton: true, confirmButtonText: 'Create Group', cancelButtonText: 'Cancel', confirmButtonColor: '#26315f', cancelButtonColor: '#7b849e', reverseButtons: true,
            inputValidator: function (value) { if (!value || !value.trim()) return 'State group name is required.'; if (value.trim().length > 255) return 'Name cannot exceed 255 characters.'; }
        });
        if (!result.isConfirmed) return;
        Swal.fire({ title: 'Creating group...', allowOutsideClick: false, didOpen: function () { Swal.showLoading(); } });
        $.ajax({
            url: url, type: 'POST', data: { _token: '{{ csrf_token() }}', name: result.value.trim() },
            success: function (response) {
                Swal.fire({ icon: response.created ? 'success' : 'info', title: response.created ? 'Group Created' : 'Already Exists', text: response.message, confirmButtonColor: '#26315f' }).then(function () { window.location.reload(); });
            },
            error: function (xhr) { Swal.fire({ icon: 'error', title: 'Unable to create group', text: ajaxErrorMessage(xhr, 'Please try again.'), confirmButtonColor: '#26315f' }); }
        });
    });

    $(document).on('click', '.add-state-to-group', async function () {
        const url = $(this).data('url');
        const groupName = $(this).data('group-name');
        const result = await Swal.fire({
            title: 'Add State', html: 'Add a state inside <strong>' + escapeHtml(groupName) + '</strong>.', input: 'text', inputPlaceholder: 'Enter state name',
            showCancelButton: true, confirmButtonText: 'Add State', cancelButtonText: 'Cancel', confirmButtonColor: '#26315f', cancelButtonColor: '#7b849e', reverseButtons: true,
            inputValidator: function (value) { if (!value || !value.trim()) return 'State name is required.'; if (value.trim().length > 255) return 'Name cannot exceed 255 characters.'; }
        });
        if (!result.isConfirmed) return;
        Swal.fire({ title: 'Adding state...', allowOutsideClick: false, didOpen: function () { Swal.showLoading(); } });
        $.ajax({
            url: url, type: 'POST', data: { _token: '{{ csrf_token() }}', name: result.value.trim() },
            success: function (response) {
                Swal.fire({ icon: response.created ? 'success' : 'info', title: response.created ? 'State Added' : 'Already Exists', text: response.message, confirmButtonColor: '#26315f' }).then(function () { window.location.reload(); });
            },
            error: function (xhr) { Swal.fire({ icon: 'error', title: 'Unable to add state', text: ajaxErrorMessage(xhr, 'Please try again.'), confirmButtonColor: '#26315f' }); }
        });
    });

    $(document).on('click', '.remove-row', async function () {
        const button = $(this);
        const section = button.data('section');
        const id = button.data('id');
        const deleteUrl = button.data('delete-url');
        const row = button.closest('tr');
        const stateGroup = row.closest('[data-state-group]');
        const labels = { keyword: 'keyword', area: 'area', state: 'state' };
        const result = await Swal.fire({
            icon: 'warning', title: 'Remove this ' + (labels[section] || 'row') + '?',
            text: id ? 'This record will be permanently deleted now.' : 'This unsaved row will be removed.',
            showCancelButton: true, confirmButtonText: 'Yes, Delete', cancelButtonText: 'Cancel', confirmButtonColor: '#d65c4a', cancelButtonColor: '#7b849e', reverseButtons: true
        });
        if (!result.isConfirmed) return;

        function removeRowFromPage() {
            row.find(':input, button').prop('disabled', true);
            row.addClass('skw-row-exit');

            setTimeout(function () {
                row.remove();

                if (section === 'keyword') {
                    $('#keywordCount').text($('#keywordsTable tbody > tr').length);
                }

                if (section === 'area') {
                    $('#areaCount').text($('#areasTable tbody > tr').length);
                }

                if (section === 'state' && stateGroup.length) {
                    const count = stateGroup.find('tbody > tr').not('.skw-no-state-row').length;
                    stateGroup.find('[data-state-count]').text(count);
                    stateGroup.find('[data-state-word]').text(count === 1 ? 'state' : 'states');
                }
            }, 180);
        }

        if (!id) {
            removeRowFromPage();
            toast('success', 'Unsaved row removed.');
            return;
        }

        if (!deleteUrl) {
            Swal.fire({
                icon: 'error',
                title: 'Delete route missing',
                text: 'Please replace the Blade and routes files with the latest versions.',
                confirmButtonColor: '#26315f'
            });
            return;
        }

        button.prop('disabled', true);
        Swal.fire({
            title: 'Deleting...',
            text: 'Please wait while the record is removed.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function () { Swal.showLoading(); }
        });

        $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function (response) {
                removeRowFromPage();
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted',
                    text: response.message || 'Record deleted successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                button.prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Delete failed',
                    text: ajaxErrorMessage(xhr, 'The record could not be deleted. Please check the delete route.'),
                    confirmButtonColor: '#26315f'
                });
            }
        });
    });

    function refreshRowDeltas(row) {
        const startValue = parseFloat(row.find('.skw-starting-rank').val());
        row.find('.skw-month-rank').each(function () {
            const input = $(this), chip = input.closest('.skw-rank-cell').find('[data-delta]'), currentValue = parseFloat(input.val());
            if (isNaN(startValue) || isNaN(currentValue)) { chip.attr('data-state', '').text('\u2014'); return; }
            const delta = startValue - currentValue;
            if (delta > 0) chip.attr('data-state', 'up').text('\u25B2' + delta);
            else if (delta < 0) chip.attr('data-state', 'down').text('\u25BC' + Math.abs(delta));
            else chip.attr('data-state', '').text('\u2014');
        });
    }
    $(document).on('input', '#keywordsTable .skw-starting-rank, #keywordsTable .skw-month-rank', function () { refreshRowDeltas($(this).closest('tr')); });
    $('#keywordsTable tbody tr').each(function () { refreshRowDeltas($(this)); });

    if (form) {
        form.addEventListener('input', markDirty);
        form.addEventListener('submit', function () {
            if (dirtyNote) dirtyNote.classList.remove('is-visible');
            const button = document.getElementById('saveAllButton');
            if (button) { button.disabled = true; button.textContent = 'Saving...'; }
        });
    }
})(jQuery);
</script>
@endpush
