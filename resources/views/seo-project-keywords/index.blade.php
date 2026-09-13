{{--
    SEO Project Keywords module
    Route: seo-project-keywords.index / seo-project-keywords.save
    NOTE: adjust @extends() / @section() names below to match your existing
    admin layout conventions if they differ. Assumes the parent layout has
    a @stack('css') in <head> and @stack('js') before </body>.
--}}
@extends('index')

@section('title', 'SEO Project Keywords')

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<style>
    .skw {
        --skw-ink: #12172B;
        --skw-ink-soft: #5B6480;
        --skw-canvas: #F3F5FA;
        --skw-surface: #FFFFFF;
        --skw-border: #E3E7F0;
        --skw-primary: #26315F;
        --skw-primary-dark: #1A2247;
        --skw-primary-soft: #EEF1FA;
        --skw-accent: #0EA5A4;
        --skw-accent-soft: #E1F6F5;
        --skw-danger: #D65C4A;
        --skw-danger-soft: #FBEAE7;
        --skw-radius-lg: 16px;
        --skw-radius-md: 10px;
        --skw-radius-sm: 6px;
        --skw-shadow: 0 1px 2px rgba(18,23,43,.05), 0 10px 28px -14px rgba(18,23,43,.16);
        --skw-shadow-sm: 0 1px 2px rgba(18,23,43,.06);

        background: var(--skw-canvas);
        color: var(--skw-ink);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        min-height: 100%;
        padding: 40px 0 120px;
    }

    .skw *, .skw *::before, .skw *::after { box-sizing: border-box; }

    .skw .skw-shell { max-width: 1180px; margin: 0 auto; padding: 0 24px; }

    /* ---------- Header ---------- */
    .skw-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; gap: 16px; flex-wrap: wrap; }
    .skw-eyebrow {
        font-family: 'Sora', sans-serif; font-size: 11.5px; font-weight: 600; letter-spacing: .14em;
        text-transform: uppercase; color: var(--skw-accent); margin: 0 0 6px;
    }
    .skw-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 700; color: var(--skw-ink); margin: 0; letter-spacing: -.01em; }
    .skw-back {
        display: inline-flex; align-items: center; gap: 7px; font-family: 'Sora', sans-serif; font-weight: 600; font-size: 13.5px;
        color: var(--skw-primary); background: var(--skw-surface); border: 1px solid var(--skw-border);
        padding: 9px 16px 9px 12px; border-radius: 999px; text-decoration: none; box-shadow: var(--skw-shadow-sm);
        transition: border-color .15s ease, transform .15s ease, color .15s ease;
    }
    .skw-back:hover { color: var(--skw-primary-dark); border-color: #C9D0E4; transform: translateX(-2px); text-decoration: none; }
    .skw-back svg { width: 15px; height: 15px; }

    /* ---------- Alerts ---------- */
    .skw-alert {
        border: 1px solid transparent; border-radius: var(--skw-radius-md); padding: 13px 16px; margin-bottom: 20px;
        font-size: 14px; font-weight: 500; display: flex; align-items: flex-start; gap: 10px;
    }
    .skw-alert--success { background: var(--skw-accent-soft); border-color: #BEE9E7; color: #0B6E6D; }
    .skw-alert--danger { background: var(--skw-danger-soft); border-color: #F2CCC4; color: #9E3B2B; }
    .skw-alert ul { margin: 0; padding-left: 18px; }

    /* ---------- Card ---------- */
    .skw-card {
        background: var(--skw-surface); border: 1px solid var(--skw-border); border-radius: var(--skw-radius-lg);
        box-shadow: var(--skw-shadow); margin-bottom: 24px; overflow: hidden;
    }
    .skw-card-head {
        display: flex; justify-content: space-between; align-items: center; padding: 18px 22px;
        border-bottom: 1px solid var(--skw-border); background: linear-gradient(180deg, #FBFCFE, #FFFFFF);
    }
    .skw-card-title-wrap { display: flex; align-items: center; gap: 10px; }
    .skw-card-icon {
        width: 34px; height: 34px; border-radius: 10px; background: var(--skw-primary-soft);
        display: flex; align-items: center; justify-content: center; color: var(--skw-primary); flex-shrink: 0;
    }
    .skw-card-icon svg { width: 17px; height: 17px; }
    .skw-card-title { font-family: 'Sora', sans-serif; font-weight: 600; font-size: 15.5px; color: var(--skw-ink); }
    .skw-count {
        font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 500; color: var(--skw-ink-soft);
        background: var(--skw-canvas); border: 1px solid var(--skw-border); border-radius: 999px; padding: 1px 8px; margin-left: 4px;
    }
    .skw-add-btn {
        display: inline-flex; align-items: center; gap: 6px; font-family: 'Sora', sans-serif; font-weight: 600; font-size: 13px;
        color: var(--skw-surface); background: var(--skw-primary); border: none; border-radius: 999px; padding: 8px 15px 8px 12px;
        cursor: pointer; transition: background .15s ease, transform .1s ease;
    }
    .skw-add-btn:hover { background: var(--skw-primary-dark); }
    .skw-add-btn:active { transform: scale(.97); }
    .skw-add-btn svg { width: 14px; height: 14px; }

    .skw-card-body { padding: 4px 0 6px; }

    /* ---------- Table ---------- */
    .skw-table-wrap { overflow-x: auto; }
    .skw-table { width: 100%; border-collapse: collapse; min-width: 640px; }
    .skw-table thead th {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .07em; text-transform: uppercase;
        color: var(--skw-ink-soft); text-align: left; padding: 12px 14px; border-bottom: 1px solid var(--skw-border);
        white-space: nowrap; background: var(--skw-surface); position: sticky; top: 0;
    }
    .skw-table th.skw-col-narrow, .skw-table td.skw-col-narrow { text-align: center; }
    .skw-table tbody tr { border-bottom: 1px solid var(--skw-border); transition: background .12s ease; }
    .skw-table tbody tr:last-child { border-bottom: none; }
    .skw-table tbody tr:hover { background: #FAFBFD; }
    .skw-table tbody tr.skw-row-exit { opacity: 0; transform: translateX(6px); transition: opacity .18s ease, transform .18s ease; }
    .skw-table td { padding: 7px 14px; vertical-align: middle; }

    /* Inline "invisible until touched" inputs — spreadsheet-grade editing feel */
    .skw-input {
        width: 100%; min-width: 90px; border: 1px solid transparent; background: transparent; border-radius: var(--skw-radius-sm);
        padding: 7px 8px; font-family: 'Inter', sans-serif; font-size: 13.5px; color: var(--skw-ink); transition: all .12s ease;
    }
    .skw-input:hover { background: var(--skw-canvas); }
    .skw-input:focus {
        outline: none; background: var(--skw-surface); border-color: var(--skw-primary);
        box-shadow: 0 0 0 3px rgba(38,49,95,.10);
    }
    .skw-input--num { font-family: 'JetBrains Mono', monospace; font-size: 12.5px; }
    .skw-input--keyword { font-weight: 500; min-width: 160px; }

    .skw-rank-cell { display: flex; align-items: center; gap: 6px; }
    .skw-rank-cell .skw-input { width: 64px; min-width: 64px; text-align: right; }

    /* Signature element: live rank-delta chips vs. starting rank */
    .skw-delta {
        font-family: 'JetBrains Mono', monospace; font-size: 10.5px; font-weight: 500; line-height: 1;
        padding: 3px 6px; border-radius: 999px; white-space: nowrap; min-width: 30px; text-align: center;
        background: var(--skw-canvas); color: var(--skw-ink-soft); border: 1px solid var(--skw-border);
    }
    .skw-delta[data-state="up"] { background: var(--skw-accent-soft); color: #0B6E6D; border-color: #BEE9E7; }
    .skw-delta[data-state="down"] { background: var(--skw-danger-soft); color: #9E3B2B; border-color: #F2CCC4; }

    /* Delete button */
    .skw-del-btn {
        width: 30px; height: 30px; border-radius: var(--skw-radius-sm); border: 1px solid var(--skw-border);
        background: var(--skw-surface); color: var(--skw-ink-soft); display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .13s ease;
    }
    .skw-del-btn:hover { background: var(--skw-danger); border-color: var(--skw-danger); color: #fff; }
    .skw-del-btn svg { width: 14px; height: 14px; }

    /* ---------- Empty state ---------- */
    .skw-empty { text-align: center; padding: 34px 20px 30px; color: var(--skw-ink-soft); }
    .skw-empty svg { width: 30px; height: 30px; margin-bottom: 8px; opacity: .5; }
    .skw-empty p { margin: 0; font-size: 13.5px; }

    /* ---------- Sticky save bar ---------- */
    .skw-savebar {
        position: fixed; left: 0; right: 0; bottom: 0; z-index: 20; background: rgba(255,255,255,.9);
        backdrop-filter: blur(10px); border-top: 1px solid var(--skw-border); box-shadow: 0 -8px 24px -18px rgba(18,23,43,.25);
    }
    .skw-savebar-inner {
        max-width: 1180px; margin: 0 auto; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; gap: 14px;
    }
    .skw-dirty-note {
        font-size: 13px; color: var(--skw-ink-soft); display: flex; align-items: center; gap: 7px; opacity: 0; transition: opacity .2s ease;
    }
    .skw-dirty-note.is-visible { opacity: 1; }
    .skw-dirty-dot { width: 7px; height: 7px; border-radius: 50%; background: #E0A63E; flex-shrink: 0; }
    .skw-save-btn {
        font-family: 'Sora', sans-serif; font-weight: 700; font-size: 14px; color: #fff; background: var(--skw-primary);
        border: none; border-radius: 999px; padding: 12px 26px; cursor: pointer; box-shadow: var(--skw-shadow);
        transition: background .15s ease, transform .1s ease;
    }
    .skw-save-btn:hover { background: var(--skw-primary-dark); }
    .skw-save-btn:active { transform: scale(.98); }

    @media (max-width: 640px) {
        .skw { padding: 24px 0 130px; }
        .skw-title { font-size: 21px; }
        .skw-savebar-inner { flex-direction: column; align-items: stretch; }
        .skw-save-btn { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="skw">
<div class="skw-shell">

    <div class="skw-header">
        <div>
            <p class="skw-eyebrow">SEO Performance</p>
            <h1 class="skw-title">Project Keywords</h1>
        </div>
        <a href="{{ url()->previous() }}" class="skw-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            Back to SEO Project
        </a>
    </div>

    @if (session('success'))
        <div class="skw-alert skw-alert--success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="skw-alert skw-alert--danger">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="13"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="seoProjectKeywordsForm"
          action="{{ route('seo-project-keywords.save', $seoPlanClient->id) }}"
          method="POST">
        @csrf

        <div id="deletedKeywordsContainer"></div>
        <div id="deletedAreasContainer"></div>
        <div id="deletedStatesContainer"></div>

        {{-- ============ Section 1: Keywords ============ --}}
        <div class="skw-card">
            <div class="skw-card-head">
                <div class="skw-card-title-wrap">
                    <span class="skw-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <span class="skw-card-title">Keywords</span>
                    <span class="skw-count">{{ count($keywords) }}</span>
                </div>
                <button type="button" class="skw-add-btn" id="addKeywordRow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Keyword
                </button>
            </div>
            <div class="skw-card-body">
                <div class="skw-table-wrap">
                    <table class="skw-table" id="keywordsTable">
                        <thead>
                            <tr>
                                <th style="min-width:190px">Keyword</th>
                                <th style="min-width:120px">Search Volume</th>
                                <th style="min-width:110px">Starting Rank</th>
                                @foreach ($months as $m)
                                    <th style="min-width:100px">Month {{ $m }}</th>
                                @endforeach
                                <th class="skw-col-narrow" style="width:56px">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keywords as $keyword)
                                <tr data-row-id="{{ $keyword->id }}">
                                    <td>
                                        <input type="hidden" name="keywords[{{ $keyword->id }}][id]" value="{{ $keyword->id }}">
                                        <input type="text" class="skw-input skw-input--keyword"
                                               name="keywords[{{ $keyword->id }}][keyword]"
                                               value="{{ $keyword->keyword }}" required>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="skw-input skw-input--num"
                                               name="keywords[{{ $keyword->id }}][search_volume]"
                                               value="{{ $keyword->search_volume }}">
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="skw-input skw-input--num skw-starting-rank"
                                               name="keywords[{{ $keyword->id }}][starting_rank]"
                                               value="{{ $keyword->starting_rank }}">
                                    </td>
                                    @foreach ($months as $m)
                                        <td>
                                            <div class="skw-rank-cell">
                                                <input type="number" min="0" class="skw-input skw-input--num skw-month-rank"
                                                       name="keywords[{{ $keyword->id }}][rankings][{{ $m }}]"
                                                       value="{{ $keyword->rankingsByMonth[$m] ?? '' }}">
                                                <span class="skw-delta" data-delta>&mdash;</span>
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="skw-col-narrow">
                                        <button type="button" class="skw-del-btn remove-row"
                                                data-section="keyword" data-id="{{ $keyword->id }}" aria-label="Remove keyword">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (count($keywords) === 0)
                    <div class="skw-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <p>No keywords yet — add one to start tracking rankings.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============ Section 2: Areas We Serve ============ --}}
        <div class="skw-card">
            <div class="skw-card-head">
                <div class="skw-card-title-wrap">
                    <span class="skw-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <span class="skw-card-title">Areas We Serve</span>
                    <span class="skw-count">{{ count($areas) }}</span>
                </div>
                <button type="button" class="skw-add-btn" id="addAreaRow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Area
                </button>
            </div>
            <div class="skw-card-body">
                <div class="skw-table-wrap">
                    <table class="skw-table" id="areasTable">
                        <thead>
                            <tr>
                                <th>Area Name</th>
                                <th class="skw-col-narrow" style="width:56px">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($areas as $area)
                                <tr data-row-id="{{ $area->id }}">
                                    <td>
                                        <input type="hidden" name="areas[{{ $area->id }}][id]" value="{{ $area->id }}">
                                        <input type="text" class="skw-input skw-input--keyword"
                                               name="areas[{{ $area->id }}][name]"
                                               value="{{ $area->name }}" required>
                                    </td>
                                    <td class="skw-col-narrow">
                                        <button type="button" class="skw-del-btn remove-row"
                                                data-section="area" data-id="{{ $area->id }}" aria-label="Remove area">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (count($areas) === 0)
                    <div class="skw-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <p>No service areas added yet.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============ Section 3: States ============ --}}
        <div class="skw-card">
            <div class="skw-card-head">
                <div class="skw-card-title-wrap">
                    <span class="skw-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l7 3 7-3 4 2v13l-4-2-7 3-7-3-4 2V5z"/><line x1="10" y1="6" x2="10" y2="19"/><line x1="17" y1="3" x2="17" y2="16"/></svg>
                    </span>
                    <span class="skw-card-title">States</span>
                    <span class="skw-count">{{ count($states) }}</span>
                </div>
                <button type="button" class="skw-add-btn" id="addStateRow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add State
                </button>
            </div>
            <div class="skw-card-body">
                <div class="skw-table-wrap">
                    <table class="skw-table" id="statesTable">
                        <thead>
                            <tr>
                                <th style="min-width:190px">State</th>
                                @foreach ($months as $m)
                                    <th style="min-width:100px">Month {{ $m }}</th>
                                @endforeach
                                <th class="skw-col-narrow" style="width:56px">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($states as $state)
                                <tr data-row-id="{{ $state->id }}">
                                    <td>
                                        <input type="hidden" name="states[{{ $state->id }}][id]" value="{{ $state->id }}">
                                        <input type="text" class="skw-input skw-input--keyword"
                                               name="states[{{ $state->id }}][name]"
                                               value="{{ $state->name }}" required>
                                    </td>
                                    @foreach ($months as $m)
                                        <td>
                                            <input type="number" min="0" class="skw-input skw-input--num"
                                                   name="states[{{ $state->id }}][rankings][{{ $m }}]"
                                                   value="{{ $state->rankingsByMonth[$m] ?? '' }}">
                                        </td>
                                    @endforeach
                                    <td class="skw-col-narrow">
                                        <button type="button" class="skw-del-btn remove-row"
                                                data-section="state" data-id="{{ $state->id }}" aria-label="Remove state">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (count($states) === 0)
                    <div class="skw-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 3l7 3 7-3 4 2v13l-4-2-7 3-7-3-4 2V5z"/></svg>
                        <p>No states added yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="skw-savebar">
            <div class="skw-savebar-inner">
                <span class="skw-dirty-note" id="dirtyNote">
                    <span class="skw-dirty-dot"></span> You have unsaved changes
                </span>
                <button type="submit" class="skw-save-btn">Save All</button>
            </div>
        </div>
    </form>

</div>
</div>

{{-- Templates used by jQuery to build new rows. Kept out of the tables so they never submit. --}}
<template id="keywordRowTemplate">
    <tr data-row-id="">
        <td>
            <input type="hidden" name="keywords[__INDEX__][id]" value="">
            <input type="text" class="skw-input skw-input--keyword" name="keywords[__INDEX__][keyword]" required>
        </td>
        <td><input type="number" min="0" class="skw-input skw-input--num" name="keywords[__INDEX__][search_volume]"></td>
        <td><input type="number" min="0" class="skw-input skw-input--num skw-starting-rank" name="keywords[__INDEX__][starting_rank]"></td>
        @foreach ($months as $m)
            <td>
                <div class="skw-rank-cell">
                    <input type="number" min="0" class="skw-input skw-input--num skw-month-rank" name="keywords[__INDEX__][rankings][{{ $m }}]">
                    <span class="skw-delta" data-delta>&mdash;</span>
                </div>
            </td>
        @endforeach
        <td class="skw-col-narrow">
            <button type="button" class="skw-del-btn remove-row" data-section="keyword" data-id="" aria-label="Remove keyword">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </td>
    </tr>
</template>

<template id="areaRowTemplate">
    <tr data-row-id="">
        <td>
            <input type="hidden" name="areas[__INDEX__][id]" value="">
            <input type="text" class="skw-input skw-input--keyword" name="areas[__INDEX__][name]" required>
        </td>
        <td class="skw-col-narrow">
            <button type="button" class="skw-del-btn remove-row" data-section="area" data-id="" aria-label="Remove area">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </td>
    </tr>
</template>

<template id="stateRowTemplate">
    <tr data-row-id="">
        <td>
            <input type="hidden" name="states[__INDEX__][id]" value="">
            <input type="text" class="skw-input skw-input--keyword" name="states[__INDEX__][name]" required>
        </td>
        @foreach ($months as $m)
            <td><input type="number" min="0" class="skw-input skw-input--num" name="states[__INDEX__][rankings][{{ $m }}]"></td>
        @endforeach
        <td class="skw-col-narrow">
            <button type="button" class="skw-del-btn remove-row" data-section="state" data-id="" aria-label="Remove state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </td>
    </tr>
</template>
@endsection

@push('js')
<script>
(function ($) {
    'use strict';

    var newCounter = 0;
    var form = document.getElementById('seoProjectKeywordsForm');
    var dirtyNote = document.getElementById('dirtyNote');

    function nextIndex() {
        newCounter += 1;
        return 'new' + newCounter;
    }

    function markDirty() {
        if (dirtyNote) dirtyNote.classList.add('is-visible');
    }

    function appendRow(templateId, tbodySelector) {
        var index = nextIndex();
        var html = $(templateId).html().split('__INDEX__').join(index);
        $(tbodySelector).append(html);
        markDirty();
    }

    $('#addKeywordRow').on('click', function () {
        appendRow('#keywordRowTemplate', '#keywordsTable tbody');
    });

    $('#addAreaRow').on('click', function () {
        appendRow('#areaRowTemplate', '#areasTable tbody');
    });

    $('#addStateRow').on('click', function () {
        appendRow('#stateRowTemplate', '#statesTable tbody');
    });

    // Delegate remove-row clicks (covers both existing and dynamically added rows)
    $(document).on('click', '.remove-row', function () {
        var $btn = $(this);
        var section = $btn.data('section');
        var id = $btn.data('id');
        var $row = $btn.closest('tr');

        if (!window.confirm('Remove this row? This cannot be undone once you save.')) {
            return;
        }

        if (id) {
            var containerMap = {
                keyword: '#deletedKeywordsContainer',
                area: '#deletedAreasContainer',
                state: '#deletedStatesContainer'
            };
            var fieldMap = {
                keyword: 'deleted_keywords[]',
                area: 'deleted_areas[]',
                state: 'deleted_states[]'
            };

            $(containerMap[section]).append(
                $('<input>', { type: 'hidden', name: fieldMap[section], value: id })
            );
        }

        markDirty();
        $row.addClass('skw-row-exit');
        setTimeout(function () { $row.remove(); }, 180);
    });

    // Signature interaction: live rank-delta chips vs. starting rank.
    // Lower rank number = better position, so an improvement is starting_rank - current_rank > 0.
    function refreshRowDeltas($row) {
        var startVal = parseFloat($row.find('.skw-starting-rank').val());
        $row.find('.skw-month-rank').each(function () {
            var $input = $(this);
            var $chip = $input.closest('.skw-rank-cell').find('[data-delta]');
            var current = parseFloat($input.val());

            if (isNaN(startVal) || isNaN(current)) {
                $chip.attr('data-state', '').text('\u2014');
                return;
            }

            var delta = startVal - current;
            if (delta > 0) {
                $chip.attr('data-state', 'up').text('\u25B2' + delta);
            } else if (delta < 0) {
                $chip.attr('data-state', 'down').text('\u25BC' + Math.abs(delta));
            } else {
                $chip.attr('data-state', '').text('\u2014');
            }
        });
    }

    $(document).on('input', '#keywordsTable .skw-starting-rank, #keywordsTable .skw-month-rank', function () {
        refreshRowDeltas($(this).closest('tr'));
    });

    // Initialize delta chips for rows already on the page
    $('#keywordsTable tbody tr').each(function () { refreshRowDeltas($(this)); });

    // Unsaved-changes indicator
    if (form) {
        form.addEventListener('input', markDirty);
        form.addEventListener('submit', function () {
            if (dirtyNote) dirtyNote.classList.remove('is-visible');
        });
    }

})(jQuery);
</script>
@endpush