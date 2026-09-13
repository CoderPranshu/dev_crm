@extends('index')

@section('title', 'SEO Performance Report')

@section('content')

@php
    $companyName = optional($project->company)->company_name ?? 'Client';
    $website = optional($project->company)->website;
    $planTitle = optional($project->seoPlan)->title ?? 'SEO Plan';
    $initials = collect(explode(' ', trim($companyName)))
        ->filter()
        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
        ->take(2)
        ->implode('') ?: 'SR';

    $backlinkCompletedPct = $stats['backlinks'] > 0
        ? round(($stats['backlinks_completed'] / $stats['backlinks']) * 100)
        : 0;

    $onpageCompletedPct = $stats['onpage_total'] > 0
        ? round(($stats['onpage_completed'] / $stats['onpage_total']) * 100)
        : 0;

    $overallScore = (int) round((($backlinkCompletedPct + $onpageCompletedPct) / 2));

    $backlinkCancelled = $backlinks->where('status', 'cancelled')->count();
    $backlinkCompleted = $backlinks->where('status', 'completed')->count();
    $backlinkPending = $backlinks->whereNotIn('status', ['completed', 'cancelled'])->count();

    $daHigh = $backlinks->filter(fn($b) => (optional($b->backlink)->domain_authority ?? 0) >= 50)->count();
    $daMedium = $backlinks->filter(function ($b) {
        $da = optional($b->backlink)->domain_authority ?? 0;
        return $da >= 20 && $da < 50;
    })->count();
    $daLow = $backlinks->filter(function ($b) {
        $da = optional($b->backlink)->domain_authority;
        return $da !== null && $da < 20;
    })->count();

    $areaLocations = $project->locations->where('type', 'area')->values();
    $stateLocations = $project->locations->where('type', 'state')->values();

    $mapLocationsForChart = function ($locations) {
        return $locations->map(function ($loc) {
            $rankings = $loc->rankings->sortBy('month_no')->values()->map(function ($r) {
                return ['month_no' => $r->month_no, 'ranking' => $r->ranking];
            })->values()->all();

            return ['name' => $loc->name, 'rankings' => $rankings];
        })->values()->all();
    };

    $areaLocationsData = $mapLocationsForChart($areaLocations);
    $stateLocationsData = $mapLocationsForChart($stateLocations);

    $projectStart = optional($project->created_at)->format('M Y') ?? '—';
    $currentMonth = now()->format('M Y');
    $firstKeywordDate = optional(optional($keywords->sortBy('created_at')->first())->created_at)->format('M d, Y') ?? '—';
    $firstBacklinkDate = optional(optional($backlinks->sortBy('created_at')->first())->created_at)->format('M d, Y') ?? '—';
    $firstOnPageDate = optional(optional($onPages->sortBy('created_at')->first())->created_at)->format('M d, Y') ?? '—';

    $keywordsInTop10 = $keywords->filter(function ($keyword) {
        $current = optional($keyword->rankings->sortBy('month_no')->last())->ranking ?? $keyword->starting_rank ?? null;
        return $current !== null && $current <= 10;
    })->count();

    /* ---------------------------------------------------------------
       Real, backend-derived numbers for the hero: monthly visibility
       trend (same math the "Monthly Growth" chart already uses) so
       the hero's AI summary / delta / sparkline are never fabricated.
    ---------------------------------------------------------------- */
    $visibilityByMonth = collect();
    foreach ($keywords as $keyword) {
        foreach ($keyword->rankings as $r) {
            if ($r->month_no !== null && $r->ranking !== null) {
                $visibilityByMonth->push(['month' => $r->month_no, 'rank' => $r->ranking]);
            }
        }
    }
    $visibilityByMonth = $visibilityByMonth
        ->groupBy('month')
        ->map(fn($group) => max(0, round(100 - $group->avg('rank'))))
        ->sortKeys();

    $visibilitySeries = $visibilityByMonth->values()->all();
    $latestVisibility = $visibilityByMonth->last();
    $previousVisibility = $visibilityByMonth->count() > 1 ? $visibilityByMonth->slice(-2, 1)->first() : null;
    $visibilityDelta = ($latestVisibility !== null && $previousVisibility !== null)
        ? ($latestVisibility - $previousVisibility)
        : null;

    // Build an inline SVG polyline for the hero sparkline — no JS charting lib needed for this tiny element.
    $sparklinePoints = '';
    if (count($visibilitySeries) > 1) {
        $sMax = max($visibilitySeries);
        $sMin = min($visibilitySeries);
        $sRange = max($sMax - $sMin, 1);
        $sw = 220; $sh = 56; $n = count($visibilitySeries);
        $pts = [];
        foreach ($visibilitySeries as $i => $v) {
            $x = ($i / ($n - 1)) * $sw;
            $y = $sh - (($v - $sMin) / $sRange) * $sh;
            $pts[] = round($x, 1) . ',' . round($y, 1);
        }
        $sparklinePoints = implode(' ', $pts);
    }

    $heroSummary = 'SEO score is at ' . $overallScore . '%, with ' . $backlinkCompleted . ' backlink(s) live and '
        . $onpageCompletedPct . '% of on-page tasks complete' . ($keywordsInTop10 > 0 ? ', and ' . $keywordsInTop10 . ' keyword(s) ranking in the Top 10.' : '.');
@endphp

@php
    /* =====================================================================
       Additional real, backend-derived series for the ApexCharts rebuild.
       Nothing here is fabricated — everything is aggregated from the same
       $keywords / $backlinks / $onPages collections already passed in.
    ===================================================================== */

    // Average Domain Authority across backlinks that actually have a DA value
    $daValues = $backlinks->map(fn($b) => optional($b->backlink)->domain_authority)->filter(fn($v) => $v !== null);
    $averageDA = $daValues->count() ? round($daValues->avg()) : 0;

    // DA / status distribution used by the radial backlink chart (percent of total)
    $totalBacklinksForRadial = max($stats['backlinks'] ?? 0, 1);
    $daHighPct = round(($daHigh / $totalBacklinksForRadial) * 100);
    $daMediumPct = round(($daMedium / $totalBacklinksForRadial) * 100);
    $daLowPct = round(($daLow / $totalBacklinksForRadial) * 100);
    $backlinkPendingPct = round(($backlinkPending / $totalBacklinksForRadial) * 100);

    // Backlink growth — cumulative count by month, based on assigned_date (falls back to created_at)
    $backlinkGrowthRaw = $backlinks
        ->map(fn($b) => optional($b->assigned_date ?? $b->created_at)?->format('Y-m'))
        ->filter()
        ->countBy()
        ->sortKeys();
    $backlinkGrowthLabels = $backlinkGrowthRaw->keys()
        ->map(fn($k) => optional(\DateTime::createFromFormat('Y-m', $k))->format('M Y') ?: $k)
        ->values()->all();
    $backlinkGrowthCumulative = [];
    $cumB = 0;
    foreach ($backlinkGrowthRaw->values()->all() as $c) { $cumB += $c; $backlinkGrowthCumulative[] = $cumB; }

    // On-page task growth — cumulative count by month, based on created_at
    $onpageGrowthRaw = $onPages
        ->map(fn($p) => optional($p->created_at)?->format('Y-m'))
        ->filter()
        ->countBy()
        ->sortKeys();
    $onpageGrowthLabels = $onpageGrowthRaw->keys()
        ->map(fn($k) => optional(\DateTime::createFromFormat('Y-m', $k))->format('M Y') ?: $k)
        ->values()->all();
    $onpageGrowthCumulative = [];
    $cumO = 0;
    foreach ($onpageGrowthRaw->values()->all() as $c) { $cumO += $c; $onpageGrowthCumulative[] = $cumO; }

    // On-page weekly / today change, using created_at as the completion marker
    // (the previous design already displayed created_at as the task's "completed" date)
    $todayStart = now()->startOfDay();
    $weekAgoStart = now()->copy()->subDays(7)->startOfDay();
    $onpageCompletedToday = $onPages->filter(fn($p) => ($p->status ?? '') === 'completed' && optional($p->created_at)?->greaterThanOrEqualTo($todayStart))->count();
    $onpageCompletedThisWeek = $onPages->filter(fn($p) => ($p->status ?? '') === 'completed' && optional($p->created_at)?->greaterThanOrEqualTo($weekAgoStart))->count();

    // Keyword tier distribution per month — Top 3 / Top 10 / Top 50 / Top 100
    $tierByMonth = collect();
    foreach ($keywords as $keyword) {
        foreach ($keyword->rankings as $r) {
            if ($r->month_no === null || $r->ranking === null) continue;
            if (!$tierByMonth->has($r->month_no)) {
                $tierByMonth[$r->month_no] = ['top3' => 0, 'top10' => 0, 'top50' => 0, 'top100' => 0];
            }
            $bucket = $tierByMonth[$r->month_no];
            if ($r->ranking <= 3) $bucket['top3']++;
            if ($r->ranking <= 10) $bucket['top10']++;
            if ($r->ranking <= 50) $bucket['top50']++;
            if ($r->ranking <= 100) $bucket['top100']++;
            $tierByMonth[$r->month_no] = $bucket;
        }
    }
    $tierByMonth = $tierByMonth->sortKeys();
    $tierMonths = $tierByMonth->keys()->map(fn($m) => 'Month ' . $m)->values()->all();
    $tierTop3 = $tierByMonth->pluck('top3')->values()->all();
    $tierTop10 = $tierByMonth->pluck('top10')->values()->all();
    $tierTop50 = $tierByMonth->pluck('top50')->values()->all();
    $tierTop100 = $tierByMonth->pluck('top100')->values()->all();
@endphp

<div class="seo-report" data-theme="light">

    {{-- ============================= --}}
    {{-- UTILITY BAR (theme + export)  --}}
    {{-- ============================= --}}
    <div class="report-toolbar fade-up">
        <div class="toolbar-left">
            <span class="toolbar-eyebrow">Report</span>
            <span class="toolbar-divider">/</span>
            <span class="toolbar-page">{{ $currentMonth }} Overview</span>
        </div>
        <div class="toolbar-right">
            <button type="button" class="tb-btn" id="exportKeywordsBtn" title="Export keyword table as CSV">
                <i class="fa-solid fa-file-arrow-down"></i> Export Keywords
            </button>
            <button type="button" class="tb-btn" id="exportBacklinksBtn" title="Export backlink table as CSV">
                <i class="fa-solid fa-file-arrow-down"></i> Export Backlinks
            </button>
            <button type="button" class="tb-btn tb-btn-icon" id="themeToggleBtn" title="Toggle light / dark">
                <i class="fa-solid fa-moon"></i>
            </button>
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 1 — PREMIUM HERO --}}
    {{-- ============================= --}}
    <div class="hero-card fade-up">
        <div class="hero-noise"></div>
        <div class="hero-glow hero-glow-a"></div>
        <div class="hero-glow hero-glow-b"></div>

        <div class="hero-grid">
            <div class="hero-main">
                <span class="badge hero-badge">
                    <i class="fa-solid fa-chart-line"></i> SEO Performance Report
                </span>
                <h1 class="hero-title">{{ $companyName }}</h1>
                @if($website)
                    <p class="hero-subtitle">
                        <i class="fa-solid fa-globe"></i>
                        <a href="{{ $website }}" target="_blank" rel="noopener" class="hero-link">{{ $website }}</a>
                    </p>
                @endif

                <p class="hero-summary">
                    <i class="fa-solid fa-sparkles"></i> {{ $heroSummary }}
                </p>

                <div class="hero-meta">
                    <div class="hero-meta-item">
                        <small>Plan</small>
                        <strong>{{ $planTitle }}</strong>
                    </div>
                    <div class="hero-meta-item">
                        <small>Started</small>
                        <strong>{{ $projectStart }}</strong>
                    </div>
                    <div class="hero-meta-item">
                        <small>Report Month</small>
                        <strong>{{ $currentMonth }}</strong>
                    </div>
                    @if($visibilityDelta !== null)
                        <div class="hero-meta-item">
                            <small>Monthly Visibility Change</small>
                            <strong class="{{ $visibilityDelta >= 0 ? 'text-up' : 'text-down' }}">
                                <i class="fa-solid fa-arrow-{{ $visibilityDelta >= 0 ? 'up' : 'down' }}"></i>
                                {{ $visibilityDelta >= 0 ? '+' : '' }}{{ $visibilityDelta }} pts
                            </strong>
                        </div>
                    @endif
                </div>

                @if($sparklinePoints)
                    <div class="hero-sparkline">
                        <span class="hero-sparkline-label">Visibility trend</span>
                        <svg viewBox="0 0 220 56" preserveAspectRatio="none">
                            <polyline points="{{ $sparklinePoints }}" class="spark-line"></polyline>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="hero-score">
                <div class="gauge-ring gauge-ring-hero gauge-glow" data-pct="{{ $overallScore }}">
                    <svg viewBox="0 0 170 170">
                        <defs>
                            <linearGradient id="heroScoreGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#A78BFA" />
                                <stop offset="100%" stop-color="#60A5FA" />
                            </linearGradient>
                        </defs>
                        <circle class="ring-bg ring-bg-dark" cx="85" cy="85" r="72"></circle>
                        <circle class="ring-fg" style="stroke: white;" cx="85" cy="85" r="72"></circle>
                    </svg>
                    <div class="gauge-center">
                        <span class="gauge-value gauge-value-hero">{{ $overallScore }}%</span>
                        <span class="gauge-caption gauge-caption-hero">SEO Health</span>
                    </div>
                </div>
                <div class="hero-logo-chip">
                    <span>{{ $initials }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 2 — KPI CARDS --}}
    {{-- ============================= --}}
    <div class="kpi-grid">

        <div class="kpi-card fade-up">
            <div class="kpi-border"></div>
            <div class="kpi-icon kpi-icon-primary"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
            <div class="kpi-value" data-count="{{ $stats['keywords'] ?? 0 }}">0</div>
            <div class="kpi-label">Total Keywords</div>
            @if(count($visibilitySeries) > 1)
                <div class="kpi-spark" id="sparkKeywords" data-series="{{ json_encode($visibilitySeries) }}"></div>
            @endif
            <div class="kpi-trend"><i class="fa-solid fa-trophy"></i> {{ $keywordsInTop10 }} in Top 10</div>
        </div>

        <div class="kpi-card fade-up">
            <div class="kpi-border"></div>
            <div class="kpi-top">
                <div>
                    <div class="kpi-icon kpi-icon-purple"><i class="fa-solid fa-link"></i></div>
                    <div class="kpi-value" data-count="{{ $stats['backlinks'] ?? 0 }}">0</div>
                    <div class="kpi-label">Backlinks</div>
                </div>
                <div class="progress-ring" data-pct="{{ $backlinkCompletedPct }}">
                    <svg viewBox="0 0 60 60">
                        <circle class="ring-bg" cx="30" cy="30" r="26"></circle>
                        <circle class="ring-fg ring-purple" cx="30" cy="30" r="26"></circle>
                    </svg>
                    <span class="ring-label">{{ $backlinkCompletedPct }}%</span>
                </div>
            </div>
            @if(count($backlinkGrowthCumulative) > 1)
                <div class="kpi-spark" id="sparkBacklinks" data-series="{{ json_encode($backlinkGrowthCumulative) }}"></div>
            @endif
            <div class="kpi-trend"><i class="fa-solid fa-circle-check"></i> {{ $stats['backlinks_completed'] ?? 0 }} completed &middot; {{ $backlinkPending }} pending</div>
        </div>

        <div class="kpi-card fade-up">
            <div class="kpi-border"></div>
            <div class="kpi-top">
                <div>
                    <div class="kpi-icon kpi-icon-warning"><i class="fa-solid fa-list-check"></i></div>
                    <div class="kpi-value" data-count="{{ $stats['onpage_total'] ?? 0 }}">0</div>
                    <div class="kpi-label">On-Page Tasks</div>
                </div>
                <div class="progress-ring" data-pct="{{ $onpageCompletedPct }}">
                    <svg viewBox="0 0 60 60">
                        <circle class="ring-bg" cx="30" cy="30" r="26"></circle>
                        <circle class="ring-fg ring-warning" cx="30" cy="30" r="26"></circle>
                    </svg>
                    <span class="ring-label">{{ $onpageCompletedPct }}%</span>
                </div>
            </div>
            @if(count($onpageGrowthCumulative) > 1)
                <div class="kpi-spark" id="sparkOnpage" data-series="{{ json_encode($onpageGrowthCumulative) }}"></div>
            @endif
            <div class="kpi-trend"><i class="fa-solid fa-circle-check"></i> {{ $stats['onpage_completed'] ?? 0 }} completed</div>
        </div>

        <div class="kpi-card fade-up">
            <div class="kpi-border"></div>
            <div class="kpi-icon kpi-icon-danger"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="kpi-value" data-count="{{ $stats['areas'] ?? 0 }}">0</div>
            <div class="kpi-label">Area Rankings</div>
            <div class="kpi-trend"><i class="fa-solid fa-location-dot"></i> Local coverage</div>
        </div>

        <div class="kpi-card fade-up">
            <div class="kpi-border"></div>
            <div class="kpi-icon kpi-icon-primary"><i class="fa-solid fa-flag-usa"></i></div>
            <div class="kpi-value" data-count="{{ $stats['states'] ?? 0 }}">0</div>
            <div class="kpi-label">State Rankings</div>
            <div class="kpi-trend"><i class="fa-solid fa-location-dot"></i> Regional coverage</div>
        </div>

        <div class="kpi-card fade-up">
            <div class="kpi-border"></div>
            <div class="kpi-icon kpi-icon-success"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="kpi-value" data-count="{{ $averageDA }}">0</div>
            <div class="kpi-label">Average Domain Authority</div>
            <div class="kpi-trend"><i class="fa-solid fa-scale-balanced"></i> {{ $daHigh }} high &middot; {{ $daMedium }} med &middot; {{ $daLow }} low</div>
        </div>

    </div>
    <p class="kpi-footnote">
        <i class="fa-solid fa-circle-info"></i>
        Traffic, clicks/impressions, DR and Spam Score cards aren't shown because this project isn't currently wired to a
        Search Console / GA4 / backlink-API data source — happy to add them once those fields are available.
    </p>

    {{-- ============================= --}}
    {{-- SECTION 3 — KEYWORD RANKING PERFORMANCE --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-chart-line text-primary"></i> Keyword Ranking Distribution</h5>
                <p class="section-subtitle">Number of tracked keywords ranking within each tier, per month</p>
            </div>
        </div>
        <div class="panel-body">
            @if(count($tierMonths) > 1)
                <div class="chart-wrap" id="keywordTierChart"
                     data-months="{{ json_encode($tierMonths) }}"
                     data-top3="{{ json_encode($tierTop3) }}"
                     data-top10="{{ json_encode($tierTop10) }}"
                     data-top50="{{ json_encode($tierTop50) }}"
                     data-top100="{{ json_encode($tierTop100) }}"></div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                    <p>Not enough monthly ranking history yet to chart tier distribution.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 4 — KEYWORD PROGRESS TABLE --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-table-list text-primary"></i> Keyword Progress</h5>
            </div>
            @if($keywords->count())
                <div class="panel-tools">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="keywordSearch" placeholder="Search keywords…">
                    </div>
                </div>
            @endif
        </div>
        <div class="panel-body">
            @if($keywords->count())
                <div class="table-scroll">
                    <table class="table premium-table align-middle" id="keywordTable">
                        <thead>
                            <tr>
                                <th data-sort="text">Keyword <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="number">Search Volume <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="number">Starting Rank <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="number">Current Rank <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="number">Improvement <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="text">Status <i class="fa-solid fa-sort"></i></th>
                                <th style="min-width:140px">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($keywords as $keyword)
                            @php
                                $startRank = $keyword->starting_rank ?? null;
                                $currentRank = optional($keyword->rankings->sortBy('month_no')->last())->ranking ?? $startRank;
                                $improvement = ($startRank !== null && $currentRank !== null) ? ($startRank - $currentRank) : null;

                                if ($currentRank === null) {
                                    $badgeClass = 'badge-muted';
                                    $badgeLabel = 'No Data';
                                    $barClass = 'bar-muted';
                                    $barPct = 0;
                                } elseif ($currentRank <= 10) {
                                    $badgeClass = 'badge-success';
                                    $badgeLabel = 'Top 10';
                                    $barClass = 'bar-success';
                                    $barPct = 100;
                                } elseif ($currentRank <= 20) {
                                    $badgeClass = 'badge-primary';
                                    $badgeLabel = 'Top 20';
                                    $barClass = 'bar-primary';
                                    $barPct = 75;
                                } elseif ($currentRank <= 50) {
                                    $badgeClass = 'badge-warning';
                                    $badgeLabel = 'Top 50';
                                    $barClass = 'bar-warning';
                                    $barPct = 45;
                                } else {
                                    $badgeClass = 'badge-danger';
                                    $badgeLabel = 'Above 50';
                                    $barClass = 'bar-danger';
                                    $barPct = 20;
                                }
                            @endphp
                            <tr>
                                <td data-value="{{ $keyword->keyword ?? '' }}"><strong>{{ $keyword->keyword ?? '—' }}</strong></td>
                                <td data-value="{{ $keyword->search_volume ?? 0 }}">{{ $keyword->search_volume ? number_format($keyword->search_volume) : '—' }}</td>
                                <td data-value="{{ $startRank ?? 0 }}">{{ $startRank ?? '—' }}</td>
                                <td data-value="{{ $currentRank ?? 0 }}">{{ $currentRank ?? '—' }}</td>
                                <td data-value="{{ $improvement ?? 0 }}">
                                    @if($improvement === null)
                                        <span class="text-muted">—</span>
                                    @elseif($improvement > 0)
                                        <span class="text-up"><i class="fa-solid fa-arrow-up"></i> {{ $improvement }}</span>
                                    @elseif($improvement < 0)
                                        <span class="text-down"><i class="fa-solid fa-arrow-down"></i> {{ abs($improvement) }}</span>
                                    @else
                                        <span class="text-muted"><i class="fa-solid fa-minus"></i> 0</span>
                                    @endif
                                </td>
                                <td data-value="{{ $badgeLabel }}"><span class="badge status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>
                                <td>
                                    <div class="progress premium-progress">
                                        <div class="progress-bar {{ $barClass }}" style="--w: {{ $barPct }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-table-list"></i>
                    <p>No keywords found for this project.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 5 — AREA RANKING --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-map-location-dot text-success"></i> Area Ranking</h5>
                <p class="section-subtitle">Lower ranking position is better</p>
            </div>
            <div class="trend-chip" id="areaTrendChip" style="display:none;"></div>
        </div>
        <div class="panel-body chart-panel-body">
            @if($areaLocations->count())
                <div class="chart-wrap" id="areaRankChart" data-locations='@json($areaLocationsData)' data-colors='["#3B82F6","#8B5CF6","#06B6D4","#10B981","#F97316"]'></div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <p>No area-level ranking data available.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 6 — STATE RANKING --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-flag-usa text-primary"></i> State Ranking</h5>
                <p class="section-subtitle">Lower ranking position is better</p>
            </div>
            <div class="trend-chip" id="stateTrendChip" style="display:none;"></div>
        </div>
        <div class="panel-body chart-panel-body">
            @if($stateLocations->count())
                <div class="chart-wrap" id="stateRankChart" data-locations='@json($stateLocationsData)' data-colors='["#8B5CF6","#3B82F6","#06B6D4","#F97316","#10B981"]'></div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-flag-usa"></i>
                    <p>No state-level ranking data available.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 7 — BACKLINK ANALYTICS --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-link text-purple"></i> Backlink Analytics</h5>
                <p class="section-subtitle">Authority &amp; status distribution across all backlinks</p>
            </div>
        </div>
        <div class="panel-body">
            <div class="backlink-grid">
                <div class="radial-wrap">
                    <div class="chart-wrap chart-wrap-radial" id="backlinkRadialChart"
                         data-series="{{ json_encode([$daHighPct, $daMediumPct, $daLowPct, $backlinkPendingPct]) }}"></div>
                    <div class="radial-center">
                        <span class="radial-center-value" style="margin-top: px;">{{ $stats['backlinks'] ?? 0 }} </span>
                        <span class="radial-center-label" style="margin-top: 60px;">Total Backlinks</span>
                    </div>
                </div>
                <div class="mini-stat-grid">
                    <div class="mini-stat">
                        <span class="mini-stat-value">{{ $averageDA }}</span>
                        <span class="mini-stat-label">Average DA</span>
                    </div>
                    <div class="mini-stat">
                        <span class="mini-stat-value text-up">{{ $daHigh }}</span>
                        <span class="mini-stat-label">High DA (50+)</span>
                    </div>
                    <div class="mini-stat">
                        <span class="mini-stat-value text-warning">{{ $daMedium }}</span>
                        <span class="mini-stat-label">Medium DA (20-49)</span>
                    </div>
                    <div class="mini-stat">
                        <span class="mini-stat-value text-down">{{ $daLow }}</span>
                        <span class="mini-stat-label">Low DA (&lt;20)</span>
                    </div>
                    <div class="mini-stat">
                        <span class="mini-stat-value text-up">{{ $backlinkCompleted }}</span>
                        <span class="mini-stat-label">Completed</span>
                    </div>
                    <div class="mini-stat">
                        <span class="mini-stat-value text-warning">{{ $backlinkPending }}</span>
                        <span class="mini-stat-label">Pending</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 7B — BACKLINK GROWTH --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-arrow-trend-up text-primary"></i> Backlink Growth</h5>
                <p class="section-subtitle">Cumulative backlinks acquired over time, with rolling average</p>
            </div>
        </div>
        <div class="panel-body">
            @if(count($backlinkGrowthCumulative) > 1)
                <div class="chart-wrap" id="backlinkGrowthChart"
                     data-labels="{{ json_encode($backlinkGrowthLabels) }}"
                     data-series="{{ json_encode($backlinkGrowthCumulative) }}"></div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <p>Not enough dated backlink history yet to chart growth.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 8 — BACKLINK TABLE --}}
    {{-- ============================= --}}
    <!-- <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-list text-purple"></i> Backlink Details</h5>
            </div>
            @if($backlinks->count())
                <div class="panel-tools">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="backlinkSearch" placeholder="Search backlinks…">
                    </div>
                </div>
            @endif
        </div>
        <div class="panel-body">
            @if($backlinks->count())
                <div class="table-scroll">
                    <table class="table premium-table align-middle" id="backlinkTable">
                        <thead>
                            <tr>
                                <th data-sort="text">Website <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="text">Category <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="number">Domain Authority <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="text">Status <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="text">Assigned Date <i class="fa-solid fa-sort"></i></th>
                                <th data-sort="text">Completed Date <i class="fa-solid fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($backlinks as $backlink)
                            @php
                                $da = optional($backlink->backlink)->domain_authority;
                                $status = $backlink->status ?? 'pending';
                                $statusBadge = match($status) {
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-warning',
                                };
                                $assignedDate = optional($backlink->assigned_date ?? $backlink->created_at)?->format('M d, Y');
                                $completedDate = optional($backlink->completed_date ?? null)?->format('M d, Y');
                            @endphp
                            <tr>
                                <td data-value="{{ optional($backlink->backlink)->website_url ?? '' }}"><strong>{{ optional($backlink->backlink)->website_url ?? '—' }}</strong></td>
                                <td data-value="{{ optional(optional($backlink->backlink)->category)->name ?? '' }}">{{ optional(optional($backlink->backlink)->category)->name ?? '—' }}</td>
                                <td data-value="{{ $da ?? 0 }}">{{ $da !== null ? $da : '—' }}</td>
                                <td data-value="{{ $status }}"><span class="badge status-badge {{ $statusBadge }}">{{ ucfirst($status) }}</span></td>
                                <td data-value="{{ $assignedDate ?? '' }}">{{ $assignedDate ?? '—' }}</td>
                                <td data-value="{{ $completedDate ?? '' }}">{{ $completedDate ?? '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-link"></i>
                    <p>No backlink records found.</p>
                </div>
            @endif
        </div>
    </div> -->

    {{-- ============================= --}}
    {{-- SECTION 9 — PERFORMANCE OVERVIEW GAUGES --}}
    {{-- ============================= --}}
    <div class="gauge-grid">
        <div class="panel gauge-panel fade-up">
            <h5 class="section-title"><i class="fa-solid fa-gauge-high text-success"></i> On-Page Progress</h5>
            <div class="chart-wrap chart-wrap-gauge" id="onpageRadialGauge" data-pct="{{ $onpageCompletedPct }}" data-color="#10B981"></div>
            <div class="gauge-legend">
                <div><strong class="text-up">{{ $stats['onpage_completed'] ?? 0 }}</strong><small>Completed</small></div>
                <div><strong class="text-warning">{{ ($stats['onpage_total'] ?? 0) - ($stats['onpage_completed'] ?? 0) }}</strong><small>Pending</small></div>
                <div><strong>{{ $onpageCompletedToday }}</strong><small>Completed Today</small></div>
                <div><strong>{{ $onpageCompletedThisWeek }}</strong><small>Completed This Week</small></div>
            </div>
        </div>

        <div class="panel gauge-panel fade-up">
            <h5 class="section-title"><i class="fa-solid fa-link text-primary"></i> Backlink Progress</h5>
            <div class="chart-wrap chart-wrap-gauge" id="backlinkRadialGauge" data-pct="{{ $backlinkCompletedPct }}" data-color="#4F46E5"></div>
            <div class="gauge-legend">
                <div><strong class="text-up">{{ $backlinkCompleted }}</strong><small>Completed</small></div>
                <div><strong class="text-warning">{{ $backlinkPending }}</strong><small>Pending</small></div>
            </div>
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 10 — ON PAGE TASK LIST --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-list-check text-success"></i> On-Page Task List</h5>
            </div>
        </div>
        <div class="panel-body">
            @if($onPages->count())
                <div class="task-grid">
                    @foreach($onPages as $page)
                        @php
                            $status = $page->status ?? 'pending';
                            $taskCardClass = match($status) {
                                'completed' => 'task-card-success',
                                'running' => 'task-card-info',
                                default => 'task-card-warning',
                            };
                            $statusBadge = match($status) {
                                'completed' => 'badge-success',
                                'running' => 'badge-primary',
                                default => 'badge-warning',
                            };
                        @endphp
                        <div class="task-card {{ $taskCardClass }}">
                            <div class="task-card-top">
                                <span class="task-category">{{ optional($page->category)->name ?? 'General' }}</span>
                                <span class="badge status-badge {{ $statusBadge }}">{{ ucfirst($status) }}</span>
                            </div>
                            <p class="task-name">{{ optional($page->task)->task_name ?? '—' }}</p>
                            <div class="task-meta">
                                <span><i class="fa-regular fa-calendar-check"></i> {{ optional($page->created_at)?->format('M d, Y') ?? 'Not completed' }}</span>
                            </div>
                            @if(!empty($page->remarks))
                                <p class="task-remarks"><i class="fa-regular fa-comment-dots"></i> {{ $page->remarks }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-list-check"></i>
                    <p>No On Page SEO tasks found.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 11 — MONTHLY GROWTH --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-chart-area text-primary"></i> Monthly Growth</h5>
                <p class="section-subtitle">Visibility score derived from average keyword ranking each month</p>
            </div>
        </div>
        <div class="panel-body">
            @if(count($visibilitySeries) > 1)
                <div class="chart-wrap" id="monthlyGrowthChart" data-series="{{ json_encode($visibilitySeries) }}"></div>
            @else
                <div class="empty-state">
                    <i class="fa-solid fa-chart-area"></i>
                    <p>Not enough ranking history to chart growth yet.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 12 — OVERALL PERFORMANCE TIMELINE --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-timeline text-purple"></i> Overall Performance Timeline</h5>
            </div>
        </div>
        <div class="panel-body">
            <div class="premium-timeline">
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-primary"><i class="fa-solid fa-flag"></i></div>
                    <div class="timeline-content"><strong>Project Started</strong><span>{{ $projectStart }}</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-success"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <div class="timeline-content"><strong>Keywords Added</strong><span>{{ $firstKeywordDate }}</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-warning"><i class="fa-solid fa-list-check"></i></div>
                    <div class="timeline-content"><strong>On Page SEO Started</strong><span>{{ $firstOnPageDate }}</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-purple"><i class="fa-solid fa-link"></i></div>
                    <div class="timeline-content"><strong>Backlinks Started</strong><span>{{ $firstBacklinkDate }}</span></div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot timeline-dot-primary timeline-dot-current"><i class="fa-solid fa-calendar-day"></i></div>
                    <div class="timeline-content"><strong>Current Month</strong><span>{{ $currentMonth }}</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================= --}}
    {{-- SECTION 13 — AI INSIGHTS --}}
    {{-- ============================= --}}
    <div class="panel fade-up">
        <div class="panel-header">
            <div>
                <h5 class="section-title"><i class="fa-solid fa-lightbulb text-warning"></i> AI Insights &amp; Recommendations</h5>
                <p class="section-subtitle">Generated from this month's live account data</p>
            </div>
        </div>
        <div class="panel-body">
            <div class="insight-grid">
                @if($backlinkCompletedPct < 70)
                    <div class="insight-card insight-danger">
                        <div class="insight-icon"><i class="fa-solid fa-link"></i></div>
                        <div class="insight-body">
                            <div class="insight-top"><strong>Increase Backlink Velocity</strong><span class="severity-badge severity-high">High Priority</span></div>
                            <p>{{ $backlinkPending }} backlink(s) are still pending — prioritizing these will accelerate authority growth.</p>
                        </div>
                    </div>
                @endif
                @if($onpageCompletedPct < 70)
                    <div class="insight-card insight-warning">
                        <div class="insight-icon"><i class="fa-solid fa-list-check"></i></div>
                        <div class="insight-body">
                            <div class="insight-top"><strong>Continue On-Page Optimization</strong><span class="severity-badge severity-medium">Medium Priority</span></div>
                            <p>{{ ($stats['onpage_total'] ?? 0) - ($stats['onpage_completed'] ?? 0) }} on-page task(s) remain to fully optimize the site.</p>
                        </div>
                    </div>
                @endif
                <div class="insight-card insight-success">
                    <div class="insight-icon"><i class="fa-solid fa-heading"></i></div>
                    <div class="insight-body">
                        <div class="insight-top"><strong>Optimize Titles &amp; Meta</strong><span class="severity-badge severity-low">Suggestion</span></div>
                        <p>Refine title tags and meta descriptions for keywords still outside the Top 10.</p>
                    </div>
                </div>
                <div class="insight-card insight-purple">
                    <div class="insight-icon"><i class="fa-solid fa-gauge-high"></i></div>
                    <div class="insight-body">
                        <div class="insight-top"><strong>Improve Core Web Vitals</strong><span class="severity-badge severity-low">Suggestion</span></div>
                        <p>Faster load times and better stability support both rankings and conversions.</p>
                    </div>
                </div>
                <div class="insight-card insight-danger">
                    <div class="insight-icon"><i class="fa-solid fa-mouse-pointer"></i></div>
                    <div class="insight-body">
                        <div class="insight-top"><strong>Improve Click-Through Rate</strong><span class="severity-badge severity-medium">Medium Priority</span></div>
                        <p>Test more compelling titles and descriptions on pages with strong impressions but low clicks.</p>
                    </div>
                </div>
                <div class="insight-card insight-primary">
                    <div class="insight-icon"><i class="fa-solid fa-diagram-project"></i></div>
                    <div class="insight-body">
                        <div class="insight-top"><strong>Add Internal Links</strong><span class="severity-badge severity-low">Suggestion</span></div>
                        <p>Strengthen topical authority by linking related pages to top-performing content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
/* =========================================================
   DESIGN TOKENS
========================================================= */
.seo-report{
    --primary:#4F46E5;
    --primary-2:#2563EB;
    --success:#10B981;
    --warning:#F59E0B;
    --danger:#F43F5E;
    --purple:#8B5CF6;

    --bg:#F5F6FB;
    --card:#FFFFFF;
    --card-border:rgba(15,23,42,.06);
    --text-strong:#0F172A;
    --text-muted:#64748B;
    --text-faint:#94A3B8;
    --divider:#EEF1F6;
    --shadow-sm:0 1px 2px rgba(15,23,42,.04), 0 1px 1px rgba(15,23,42,.03);
    --shadow-md:0 12px 28px rgba(15,23,42,.08);
    --shadow-lg:0 24px 48px rgba(15,23,42,.14);

    font-family:'Inter',sans-serif;
    /* background:var(--bg); */
    color:var(--text-strong);
    padding:1.5rem 0;
    transition:background .35s ease,color .35s ease;
}

.seo-report[data-theme="dark"]{
    --bg:#0B1120;
    --card:#111A2C;
    --card-border:rgba(255,255,255,.06);
    --text-strong:#F1F5F9;
    --text-muted:#94A3B8;
    --text-faint:#64748B;
    --divider:rgba(255,255,255,.06);
    --shadow-sm:0 1px 2px rgba(0,0,0,.3);
    --shadow-md:0 12px 28px rgba(0,0,0,.45);
    --shadow-lg:0 24px 48px rgba(0,0,0,.55);
}

.seo-report h1,.seo-report h2,.seo-report h3,.seo-report h4,.seo-report h5{
    font-family:'Sora','Inter',sans-serif;
    font-weight:700;
}

.text-primary{color:var(--primary-2) !important;}
.text-purple{color:var(--purple) !important;}
.text-warning{color:var(--warning) !important;}
.text-up{color:var(--success) !important;}
.text-down{color:var(--danger) !important;}
.text-muted{color:var(--text-muted) !important;}

.section-title{font-weight:700;color:var(--text-strong);font-size:1.02rem;margin-bottom:.2rem;display:flex;align-items:center;gap:.5rem;}
.section-subtitle{font-size:.82rem;color:var(--text-muted);font-weight:500;margin:0;}

/* =========================================================
   TOOLBAR
========================================================= */
.report-toolbar{
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;
    margin-bottom:1.25rem;
}
.toolbar-left{display:flex;align-items:center;gap:.5rem;font-size:.85rem;color:var(--text-muted);font-weight:600;}
.toolbar-eyebrow{text-transform:uppercase;letter-spacing:.06em;font-size:.7rem;color:var(--text-faint);}
.toolbar-divider{color:var(--text-faint);}
.toolbar-page{color:var(--text-strong);}
.toolbar-right{display:flex;gap:.5rem;flex-wrap:wrap;}
.tb-btn{
    display:inline-flex;align-items:center;gap:.4rem;
    background:var(--card);border:1px solid var(--card-border);color:var(--text-strong);
    font-size:.8rem;font-weight:600;padding:.5rem .85rem;border-radius:.7rem;
    box-shadow:var(--shadow-sm);cursor:pointer;transition:transform .2s ease,box-shadow .2s ease,background .2s ease;
}
.tb-btn:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);}
.tb-btn-icon{width:2.35rem;justify-content:center;padding:.5rem;}

/* =========================================================
   HERO
========================================================= */
.hero-card{
    position:relative;overflow:hidden;border-radius:1.75rem;
    padding:2.25rem 2.5rem;margin-bottom:1.5rem;
    /* background:radial-gradient(120% 140% at 100% 0%,#3B3AC0 0%,#4338CA 32%,#1E1B4B 100%); */
    background: linear-gradient(135deg, #0F2C36 0%, #155B6C 60%, #1E8799 100%);
    box-shadow:var(--shadow-lg);
    isolation:isolate;
}
.hero-glow{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;}
.hero-glow-a{width:420px;height:420px; background: rgb(19 41 42 / 35%); top:-160px;right:-120px;animation:heroDrift 14s ease-in-out infinite;}
.hero-glow-b{width:320px;height:320px;background:rgba(96,165,250,.28);bottom:-140px;left:-80px;animation:heroDrift 18s ease-in-out infinite reverse;}
@keyframes heroDrift{0%,100%{transform:translate(0,0);}50%{transform:translate(30px,-20px);}}
.hero-noise{position:absolute;inset:0;opacity:.05;background-image:radial-gradient(rgba(255,255,255,.9) 1px,transparent 1px);background-size:14px 14px;pointer-events:none;}

.hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr auto;gap:2.5rem;align-items:center;}
.hero-badge{display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.14);color:#fff;font-weight:600;font-size:.75rem;padding:.4rem .8rem;border-radius:999px;border:1px solid rgba(255,255,255,.28);backdrop-filter:blur(6px);margin-bottom:.9rem;}
.hero-title{color:#fff;font-size:2.15rem;margin:0 0 .35rem;letter-spacing:-.01em;}
.hero-subtitle{color:rgba(255,255,255,.82);font-weight:500;margin:0 0 .9rem;font-size:.92rem;}
.hero-link{color:#fff;text-decoration:underline;text-decoration-color:rgba(255,255,255,.4);}
.hero-summary{color:rgba(255,255,255,.92);font-size:.92rem;font-weight:500;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:.9rem;padding:.7rem 1rem;display:flex;gap:.55rem;align-items:flex-start;max-width:36rem;margin-bottom:1.1rem;}
.hero-summary i{color:#C4B5FD;margin-top:.15rem;}

.hero-meta{display:flex;flex-wrap:wrap;gap:1.5rem;margin-bottom:1rem;}
.hero-meta-item small{display:block;color:rgba(255,255,255,.6);font-weight:600;text-transform:uppercase;font-size:.66rem;letter-spacing:.05em;}
.hero-meta-item strong{color:#fff;font-weight:700;font-size:.95rem;}

.hero-sparkline{display:flex;align-items:center;gap:.7rem;max-width:280px;}
.hero-sparkline-label{color:rgba(255,255,255,.6);font-size:.72rem;font-weight:600;white-space:nowrap;}
.hero-sparkline svg{width:100%;height:44px;}
.spark-line{fill:none;stroke:#C4B5FD;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;}

.hero-score{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;gap:.75rem;}
.hero-logo-chip{
    width:2.4rem;height:2.4rem;border-radius:50%;
    background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.3);
    display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.85rem;
    margin-top:-.6rem;
}

/* =========================================================
   GAUGES / RINGS
========================================================= */
.progress-ring{position:relative;width:60px;height:60px;flex-shrink:0;}
.progress-ring svg{width:60px;height:60px;transform:rotate(-90deg);}
.progress-ring .ring-bg{fill:none;stroke:var(--divider);stroke-width:6;}
.progress-ring .ring-fg{fill:none;stroke-width:6;stroke-linecap:round;stroke-dasharray:163;stroke-dashoffset:163;transition:stroke-dashoffset 1.2s cubic-bezier(.22,1,.36,1);}
.progress-ring .ring-success{stroke:var(--success);}
.progress-ring .ring-warning{stroke:var(--warning);}
.progress-ring .ring-primary{stroke:var(--primary-2);}
.progress-ring .ring-purple{stroke:var(--purple);}
.progress-ring .ring-label{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:700;color:var(--text-strong);}

.gauge-ring{position:relative;}
.gauge-ring-md{width:150px;height:150px;}
.gauge-ring-md svg{width:150px;height:150px;transform:rotate(-90deg);}
.gauge-ring-md .ring-bg{fill:none;stroke:var(--divider);stroke-width:9;}
.gauge-ring-md .ring-fg{fill:none;stroke-width:9;stroke-linecap:round;stroke-dasharray:327;stroke-dashoffset:327;transition:stroke-dashoffset 1.4s cubic-bezier(.22,1,.36,1);}

.gauge-ring-hero{width:170px;height:170px;}
.gauge-ring-hero svg{width:170px;height:170px;transform:rotate(-90deg);}
.gauge-ring-hero .ring-bg-dark{fill:none;stroke:rgba(255,255,255,.16);stroke-width:11;}
.gauge-ring-hero .ring-fg{fill:none;stroke-width:11;stroke-linecap:round;stroke-dasharray:452;stroke-dashoffset:452;transition:stroke-dashoffset 1.6s cubic-bezier(.22,1,.36,1);}
.gauge-glow .ring-fg{filter:drop-shadow(0 0 14px rgba(167,139,250,.65));}

.gauge-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;}
.gauge-value{font-size:1.85rem;font-weight:800;color:var(--text-strong);}
.gauge-value-hero{color:#fff;font-size:2.1rem;}
.gauge-caption{font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em;}
.gauge-caption-hero{color:rgba(255,255,255,.7);}

.gauge-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;margin-bottom:1.5rem;}
.gauge-panel{display:flex;flex-direction:column;align-items:center;text-align:center;gap:1rem;padding:1.75rem;}
.gauge-legend{display:flex;gap:2rem;}
.gauge-legend strong{display:block;font-size:1.2rem;font-weight:800;}
.gauge-legend small{color:var(--text-muted);font-size:.78rem;}

/* =========================================================
   KPI CARDS
========================================================= */
.kpi-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:1.1rem;margin-bottom:1.5rem;}
.kpi-card{
    position:relative;background:var(--card);border-radius:1.25rem;padding:1.35rem 1.4rem;
    border:1px solid var(--card-border);box-shadow:var(--shadow-sm);
    transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s ease;
    overflow:hidden;
}
.kpi-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg);}
.kpi-border{position:absolute;inset:0;border-radius:1.25rem;padding:1px;background:linear-gradient(135deg,rgba(79,70,229,.35),rgba(139,92,246,0),rgba(37,99,235,.25));opacity:0;transition:opacity .3s ease;pointer-events:none;-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;}
.kpi-card:hover .kpi-border{opacity:1;}
.kpi-top{display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;}
.kpi-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:.75rem;}
.kpi-icon-primary{background:rgba(37,99,235,.1);color:var(--primary-2);}
.kpi-icon-success{background:rgba(16,185,129,.1);color:var(--success);}
.kpi-icon-warning{background:rgba(245,158,11,.1);color:var(--warning);}
.kpi-icon-danger{background:rgba(244,63,94,.1);color:var(--danger);}
.kpi-icon-purple{background:rgba(139,92,246,.1);color:var(--purple);}
.kpi-value{font-size:1.85rem;font-weight:800;color:var(--text-strong);line-height:1.1;}
.kpi-label{color:var(--text-muted);font-weight:600;font-size:.82rem;margin-top:.15rem;}
.kpi-trend{color:var(--text-faint);font-size:.74rem;font-weight:600;margin-top:.65rem;}

/* =========================================================
   PANELS / TABLES
========================================================= */
.panel{background:var(--card);border:1px solid var(--card-border);border-radius:1.25rem;box-shadow:var(--shadow-sm);margin-bottom:1.5rem;}
.panel-header{display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:.75rem;padding:1.35rem 1.5rem 0;}
.panel-body{padding:1.35rem 1.5rem 1.5rem;}
.panel-tools{display:flex;align-items:center;}

.search-box{display:flex;align-items:center;gap:.5rem;background:var(--bg);border:1px solid var(--card-border);border-radius:.7rem;padding:.45rem .75rem;}
.search-box i{color:var(--text-faint);font-size:.8rem;}
.search-box input{border:none;background:transparent;outline:none;font-size:.83rem;color:var(--text-strong);width:180px;}

.table-scroll{max-height:460px;overflow:auto;border-radius:.9rem;border:1px solid var(--divider);}
.premium-table{margin:0;}
.premium-table thead th{
    position:sticky;top:0;z-index:2;background:var(--bg);border:none;color:var(--text-muted);
    font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;font-weight:700;
    padding:.85rem 1rem;cursor:pointer;user-select:none;white-space:nowrap;
}
.premium-table thead th i{font-size:.65rem;color:var(--text-faint);margin-left:.3rem;}
.premium-table tbody td{border-color:var(--divider);padding:.85rem 1rem;font-size:.87rem;color:var(--text-strong);}
.premium-table tbody tr{transition:background .2s ease;}
.premium-table tbody tr:hover{background:rgba(79,70,229,.04);}

.status-badge{font-weight:700;font-size:.7rem;padding:.38rem .7rem;border-radius:999px;}
.badge-success{background:rgba(16,185,129,.12);color:var(--success);}
.badge-primary{background:rgba(37,99,235,.12);color:var(--primary-2);}
.badge-warning{background:rgba(245,158,11,.12);color:#B45309;}
.badge-danger{background:rgba(244,63,94,.12);color:var(--danger);}
.badge-muted{background:var(--divider);color:var(--text-muted);}

.premium-progress{height:8px;border-radius:999px;background:var(--divider);overflow:hidden;}
.premium-progress .progress-bar{width:var(--w);border-radius:999px;transition:width 1s cubic-bezier(.22,1,.36,1);}
.bar-success{background:var(--success);}
.bar-primary{background:var(--primary-2);}
.bar-warning{background:var(--warning);}
.bar-danger{background:var(--danger);}
.bar-muted{background:var(--text-faint);}

/* Backlink analytics layout */
.backlink-grid{display:grid;grid-template-columns:minmax(220px,1fr) 2fr;gap:1.5rem;align-items:center;}
.mini-stat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;}
.mini-stat{background:var(--bg);border-radius:1rem;padding:1rem;text-align:center;}
.mini-stat-value{display:block;font-size:1.6rem;font-weight:800;color:var(--text-strong);}
.mini-stat-label{display:block;font-size:.75rem;font-weight:600;color:var(--text-muted);margin-top:.2rem;}

/* Task cards */
.task-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem;}
.task-card{border-radius:1rem;padding:1rem 1.1rem;border-left:4px solid var(--text-faint);background:var(--bg);transition:transform .25s ease,box-shadow .25s ease;}
.task-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);}
.task-card-success{border-left-color:var(--success);}
.task-card-warning{border-left-color:var(--warning);}
.task-card-info{border-left-color:var(--primary-2);}
.task-card-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.5rem;gap:.5rem;}
.task-category{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-muted);}
.task-name{font-weight:600;color:var(--text-strong);font-size:.9rem;margin:0 0 .5rem;}
.task-meta{font-size:.76rem;color:var(--text-muted);}
.task-remarks{font-size:.76rem;color:var(--text-faint);margin:.4rem 0 0;font-style:italic;}

/* Timeline */
.premium-timeline{position:relative;padding-left:2.75rem;}
.premium-timeline::before{content:'';position:absolute;left:1.1rem;top:.5rem;bottom:.5rem;width:2px;background:linear-gradient(180deg,var(--primary-2),var(--purple));}
.timeline-item{position:relative;padding-bottom:1.75rem;}
.timeline-item:last-child{padding-bottom:0;}
.timeline-dot{position:absolute;left:-2.75rem;top:0;width:2.2rem;height:2.2rem;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.85rem;box-shadow:0 0 0 4px var(--card);}
.timeline-dot-primary{background:var(--primary-2);}
.timeline-dot-success{background:var(--success);}
.timeline-dot-warning{background:var(--warning);}
.timeline-dot-purple{background:var(--purple);}
.timeline-dot-current{animation:pulseDot 2.4s ease-in-out infinite;}
@keyframes pulseDot{0%,100%{box-shadow:0 0 0 4px var(--card),0 0 0 6px rgba(79,70,229,.3);}50%{box-shadow:0 0 0 4px var(--card),0 0 0 10px rgba(79,70,229,.12);}}
.timeline-content strong{display:block;color:var(--text-strong);font-weight:700;font-size:.9rem;}
.timeline-content span{color:var(--text-muted);font-size:.8rem;}

/* AI Insights */
.insight-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem;}
.insight-card{display:flex;gap:.9rem;align-items:flex-start;background:var(--bg);border-radius:1rem;padding:1rem 1.1rem;border-left:4px solid transparent;}
.insight-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.95rem;}
.insight-top{display:flex;align-items:center;justify-content:space-between;gap:.5rem;margin-bottom:.15rem;}
.insight-top strong{color:var(--text-strong);font-size:.88rem;}
.insight-body p{color:var(--text-muted);font-size:.8rem;margin:0;}
.severity-badge{font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.03em;padding:.22rem .55rem;border-radius:999px;white-space:nowrap;}
.severity-high{background:rgba(244,63,94,.12);color:var(--danger);}
.severity-medium{background:rgba(245,158,11,.12);color:#B45309;}
.severity-low{background:rgba(16,185,129,.12);color:var(--success);}
.insight-danger{border-left-color:var(--danger);}
.insight-danger .insight-icon{background:rgba(244,63,94,.1);color:var(--danger);}
.insight-warning{border-left-color:var(--warning);}
.insight-warning .insight-icon{background:rgba(245,158,11,.1);color:var(--warning);}
.insight-success{border-left-color:var(--success);}
.insight-success .insight-icon{background:rgba(16,185,129,.1);color:var(--success);}
.insight-purple{border-left-color:var(--purple);}
.insight-purple .insight-icon{background:rgba(139,92,246,.1);color:var(--purple);}
.insight-primary{border-left-color:var(--primary-2);}
.insight-primary .insight-icon{background:rgba(37,99,235,.1);color:var(--primary-2);}

.chart-wrap{position:relative;height:340px;}
.chart-wrap-radial{height:260px;}
.chart-wrap-gauge{height:190px;}
.chart-panel-body{position:relative;}

.kpi-footnote{
    grid-column:1/-1;display:flex;align-items:center;gap:.5rem;
    color:var(--text-faint);font-size:.76rem;font-weight:500;
    background:var(--card);border:1px dashed var(--card-border);border-radius:.9rem;
    padding:.7rem 1rem;margin:-.5rem 0 1.5rem;
}
.kpi-footnote i{color:var(--text-muted);}

.kpi-spark{height:34px;margin:.4rem -.2rem 0;}

.trend-chip{
    display:inline-flex;align-items:center;gap:.35rem;
    background:rgba(16,185,129,.1);color:var(--success);
    font-weight:700;font-size:.78rem;padding:.4rem .75rem;border-radius:999px;
    white-space:nowrap;height:fit-content;
}
.trend-chip.is-down{background:rgba(244,63,94,.1);color:var(--danger);}

.radial-wrap{position:relative;display:flex;align-items:center;justify-content:center;}
.radial-center{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;pointer-events:none;}
.radial-center-value{display:block;font-size:1.7rem;font-weight:800;color:var(--text-strong);}
.radial-center-label{display:block;font-size:.7rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.04em;}

/* ApexCharts theme polish */
.apexcharts-tooltip{
    border-radius:.9rem !important;border:1px solid var(--card-border) !important;
    box-shadow:var(--shadow-md) !important;overflow:hidden;
}
.apexcharts-legend-text{color:var(--text-muted) !important;font-family:'Inter',sans-serif !important;font-size:.8rem !important;}
.apexcharts-menu{border-radius:.75rem !important;box-shadow:var(--shadow-md) !important;}

.empty-state{color:var(--text-faint);text-align:center;padding:3rem 1rem;}
.empty-state i{font-size:1.75rem;display:block;margin-bottom:.5rem;}

/* Fade up animation */
.fade-up{opacity:0;transform:translateY(18px);transition:opacity .6s cubic-bezier(.22,1,.36,1),transform .6s cubic-bezier(.22,1,.36,1);}
.fade-up.in-view{opacity:1;transform:translateY(0);}

@media(prefers-reduced-motion:reduce){
    .fade-up{opacity:1;transform:none;transition:none;}
    .hero-glow{animation:none;}
    .timeline-dot-current{animation:none;}
}

@media(max-width:1200px){
    .kpi-grid{grid-template-columns:repeat(3,1fr);}
}
@media(max-width:991px){
    .hero-grid{grid-template-columns:1fr;}
    .hero-score{align-items:flex-start;}
    .hero-title{font-size:1.7rem;}
    .kpi-grid{grid-template-columns:repeat(2,1fr);}
    .gauge-grid{grid-template-columns:1fr;}
    .backlink-grid{grid-template-columns:1fr;}
}
@media(max-width:576px){
    .kpi-grid{grid-template-columns:1fr;}
    .hero-card{padding:1.75rem;}
}
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const reportRoot = document.querySelector('.seo-report');

    /* ---------- Theme toggle (scoped to this component, persisted) ---------- */
    (function () {
        const btn = document.getElementById('themeToggleBtn');
        if (!btn || !reportRoot) return;
        const stored = localStorage.getItem('seoReportTheme');
        if (stored === 'dark') {
            reportRoot.setAttribute('data-theme', 'dark');
            btn.innerHTML = '<i class="fa-solid fa-sun"></i>';
        }
        btn.addEventListener('click', function () {
            const isDark = reportRoot.getAttribute('data-theme') === 'dark';
            reportRoot.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem('seoReportTheme', isDark ? 'light' : 'dark');
            btn.innerHTML = isDark ? '<i class="fa-solid fa-moon"></i>' : '<i class="fa-solid fa-sun"></i>';
        });
    })();

    /* ---------- Fade up on scroll ---------- */
    const fadeEls = document.querySelectorAll('.fade-up');
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    fadeEls.forEach(el => io.observe(el));

    /* ---------- Animated counters ---------- */
    document.querySelectorAll('.kpi-value[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'), 10) || 0;
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let current = 0;
                    const step = Math.max(1, Math.ceil(target / 40));
                    const timer = setInterval(() => {
                        current += step;
                        if (current >= target) { current = target; clearInterval(timer); }
                        el.textContent = current.toLocaleString();
                    }, 25);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        counterObserver.observe(el);
    });

    /* ---------- Progress rings & gauges ---------- */
    document.querySelectorAll('.progress-ring, .gauge-ring').forEach(ring => {
        const pct = parseFloat(ring.getAttribute('data-pct')) || 0;
        const fg = ring.querySelector('.ring-fg');
        if (!fg) return;
        const circumference = fg.getTotalLength ? fg.getTotalLength() : (2 * Math.PI * (fg.r ? fg.r.baseVal.value : 26));
        fg.style.strokeDasharray = circumference;
        fg.style.strokeDashoffset = circumference;
        const ringObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const offset = circumference - (pct / 100) * circumference;
                    requestAnimationFrame(() => { fg.style.strokeDashoffset = offset; });
                    ringObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        ringObserver.observe(ring);
    });

    /* ---------- Generic table search ---------- */
    function attachSearch(inputId, tableId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        if (!input || !table) return;
        input.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            table.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }
    attachSearch('keywordSearch', 'keywordTable');
    attachSearch('backlinkSearch', 'backlinkTable');

    /* ---------- Generic sortable table headers ---------- */
    function attachSort(tableId) {
        const table = document.getElementById(tableId);
        if (!table) return;
        const headers = table.querySelectorAll('thead th[data-sort]');
        headers.forEach((th, index) => {
            th.addEventListener('click', function () {
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const type = th.getAttribute('data-sort');
                const asc = th.getAttribute('data-order') !== 'asc';
                headers.forEach(h => h.removeAttribute('data-order'));
                th.setAttribute('data-order', asc ? 'asc' : 'desc');

                rows.sort((a, b) => {
                    const cellA = a.children[index].getAttribute('data-value') ?? a.children[index].textContent.trim();
                    const cellB = b.children[index].getAttribute('data-value') ?? b.children[index].textContent.trim();
                    if (type === 'number') {
                        return asc ? (parseFloat(cellA) - parseFloat(cellB)) : (parseFloat(cellB) - parseFloat(cellA));
                    }
                    return asc ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                });
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    }
    attachSort('keywordTable');
    attachSort('backlinkTable');

    /* ---------- CSV export ---------- */
    function exportTableToCsv(tableId, filename) {
        const table = document.getElementById(tableId);
        if (!table) return;
        const rows = Array.from(table.querySelectorAll('tr'));
        const csv = rows.map(row =>
            Array.from(row.querySelectorAll('th,td'))
                .map(cell => '"' + cell.textContent.trim().replace(/"/g, '""') + '"')
                .join(',')
        ).join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    const exportKeywordsBtn = document.getElementById('exportKeywordsBtn');
    if (exportKeywordsBtn) exportKeywordsBtn.addEventListener('click', () => exportTableToCsv('keywordTable', 'keyword-progress.csv'));
    const exportBacklinksBtn = document.getElementById('exportBacklinksBtn');
    if (exportBacklinksBtn) exportBacklinksBtn.addEventListener('click', () => exportTableToCsv('backlinkTable', 'backlink-details.csv'));

    /* ---------- Shared ApexCharts theme ---------- */
    const isDarkTheme = () => reportRoot && reportRoot.getAttribute('data-theme') === 'dark';
    const axisColor = () => isDarkTheme() ? '#94A3B8' : '#64748B';
    const gridColor = () => isDarkTheme() ? 'rgba(255,255,255,0.06)' : 'rgba(148,163,184,0.15)';
    const chartFont = "'Inter', sans-serif";
    const palette = ['#3B82F6', '#8B5CF6', '#06B6D4', '#10B981', '#F97316', '#F43F5E'];

    function paletteColor(index) {
        return palette[index % palette.length];
    }

    // Returns the boilerplate `chart` block shared by every chart (toolbar/export/animations/zoom).
    function chartShell(type, height, extra) {
        return Object.assign({
            type: type,
            height: height,
            fontFamily: chartFont,
            toolbar: {
                show: true,
                tools: { download: true, selection: false, zoom: true, zoomin: true, zoomout: true, pan: true, reset: true },
                export: {
                    csv: { filename: 'seo-report-chart' },
                    svg: { filename: 'seo-report-chart' },
                    png: { filename: 'seo-report-chart' }
                }
            },
            animations: { enabled: true, easing: 'easeinout', speed: 750, dynamicAnimation: { enabled: true, speed: 350 } },
            zoom: { enabled: true },
            background: 'transparent'
        }, extra || {});
    }
    const sharedGrid = { borderColor: gridColor(), strokeDashArray: 4, xaxis: { lines: { show: false } } };
    const sharedLegend = { fontFamily: chartFont, labels: { colors: axisColor() }, markers: { radius: 12 } };
    const sharedTooltip = { theme: isDarkTheme() ? 'dark' : 'light', style: { fontFamily: chartFont } };
    function axisLabelStyle() { return { style: { colors: axisColor(), fontSize: '11px' } }; }

    const renderedCharts = [];
    function track(chart) { if (chart) renderedCharts.push(chart); }

    /* ---------- KPI card sparklines (real monthly series only) ---------- */
    document.querySelectorAll('.kpi-spark[data-series]').forEach(el => {
        const series = JSON.parse(el.getAttribute('data-series') || '[]');
        if (series.length < 2) return;
        const rising = series[series.length - 1] >= series[0];
        const chart = new ApexCharts(el, {
            chart: { type: 'area', height: 34, sparkline: { enabled: true }, animations: { enabled: true, speed: 600 } },
            series: [{ data: series }],
            stroke: { curve: 'smooth', width: 2 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 100] } },
            colors: [rising ? '#10B981' : '#F43F5E'],
            tooltip: { enabled: false }
        });
        chart.render();
        track(chart);
    });

    /* ---------- Section 3: Keyword ranking tier distribution (Top3 / Top10 / Top50 / Top100) ---------- */
    (function () {
        const el = document.getElementById('keywordTierChart');
        if (!el) return;
        const months = JSON.parse(el.getAttribute('data-months') || '[]');
        const top3 = JSON.parse(el.getAttribute('data-top3') || '[]');
        const top10 = JSON.parse(el.getAttribute('data-top10') || '[]');
        const top50 = JSON.parse(el.getAttribute('data-top50') || '[]');
        const top100 = JSON.parse(el.getAttribute('data-top100') || '[]');

        const chart = new ApexCharts(el, {
            chart: chartShell('line', 340, { stacked: false }),
            series: [
                { name: 'Top 3', data: top3 },
                { name: 'Top 10', data: top10 },
                { name: 'Top 50', data: top50 },
                { name: 'Top 100', data: top100 }
            ],
            colors: ['#F43F5E', '#3B82F6', '#8B5CF6', '#06B6D4'],
            stroke: { curve: 'smooth', width: 3 },
            markers: { size: 4, strokeWidth: 0, hover: { size: 6 } },
            dataLabels: { enabled: false },
            grid: sharedGrid,
            legend: Object.assign({}, sharedLegend, { position: 'bottom' }),
            xaxis: Object.assign({ categories: months }, axisLabelStyle()),
            yaxis: Object.assign({ title: { text: 'Keywords', style: { color: axisColor() } }, min: 0 }, axisLabelStyle()),
            tooltip: sharedTooltip
        });
        chart.render();
        track(chart);
    })();

    /* ---------- Section 5 & 6: Area / State ranking — curved gradient area chart with annotations ---------- */
    function buildLocationChart(containerId, trendChipId) {
        const el = document.getElementById(containerId);
        if (!el) return;
        const locations = JSON.parse(el.getAttribute('data-locations') || '[]');
        const colors = JSON.parse(el.getAttribute('data-colors') || '[]');
        if (!locations.length) return;

        const labelsSet = new Set();
        locations.forEach(loc => loc.rankings.forEach(r => labelsSet.add('Month ' + r.month_no)));
        const months = Array.from(labelsSet);

        const series = locations.map(loc => ({ name: loc.name, data: loc.rankings.map(r => r.ranking) }));

        // Real best / worst / average markers computed from the actual ranking values
        const allRankings = locations.flatMap(loc => loc.rankings.map(r => r.ranking)).filter(v => v !== null && v !== undefined);
        const best = allRankings.length ? Math.min(...allRankings) : null;
        const worst = allRankings.length ? Math.max(...allRankings) : null;
        const avg = allRankings.length ? Math.round(allRankings.reduce((a, b) => a + b, 0) / allRankings.length) : null;

        // Trend indicator: average position in the first tracked month vs the latest
        const firstMonthAvgSet = locations.map(loc => loc.rankings[0]?.ranking).filter(v => v !== null && v !== undefined);
        const lastMonthAvgSet = locations.map(loc => loc.rankings[loc.rankings.length - 1]?.ranking).filter(v => v !== null && v !== undefined);
        const chip = document.getElementById(trendChipId);
        if (chip && firstMonthAvgSet.length && lastMonthAvgSet.length) {
            const firstAvg = firstMonthAvgSet.reduce((a, b) => a + b, 0) / firstMonthAvgSet.length;
            const lastAvg = lastMonthAvgSet.reduce((a, b) => a + b, 0) / lastMonthAvgSet.length;
            const improved = Math.round(firstAvg - lastAvg);
            chip.style.display = 'inline-flex';
            chip.classList.toggle('is-down', improved < 0);
            chip.innerHTML = '<i class="fa-solid fa-arrow-' + (improved >= 0 ? 'up' : 'down') + '"></i> '
                + Math.abs(improved) + ' position' + (Math.abs(improved) === 1 ? '' : 's') + (improved >= 0 ? ' improved' : ' dropped');
        }

        const annotations = { yaxis: [] };
        if (avg !== null) {
            annotations.yaxis.push({ y: avg, borderColor: '#94A3B8', strokeDashArray: 4, label: { text: 'Average: ' + avg, style: { background: '#94A3B8', color: '#fff', fontSize: '10px' } } });
        }
        if (best !== null) {
            annotations.yaxis.push({ y: best, borderColor: '#10B981', strokeDashArray: 0, label: { text: 'Best: ' + best, style: { background: '#10B981', color: '#fff', fontSize: '10px' }, position: 'left' } });
        }
        if (worst !== null && worst !== best) {
            annotations.yaxis.push({ y: worst, borderColor: '#F43F5E', strokeDashArray: 0, label: { text: 'Worst: ' + worst, style: { background: '#F43F5E', color: '#fff', fontSize: '10px' }, position: 'left' } });
        }

        const chart = new ApexCharts(el, {
            chart: chartShell('area', 340),
            series: series,
            colors: colors,
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0, stops: [0, 100] } },
            markers: { size: 4, strokeWidth: 0, hover: { size: 7 } },
            dataLabels: { enabled: false },
            grid: sharedGrid,
            legend: Object.assign({}, sharedLegend, { position: 'bottom' }),
            xaxis: Object.assign({ categories: months }, axisLabelStyle()),
            yaxis: Object.assign({ reversed: true, title: { text: 'Ranking Position', style: { color: axisColor() } } }, axisLabelStyle()),
            tooltip: sharedTooltip,
            annotations: annotations
        });
        chart.render();
        track(chart);
    }

    buildLocationChart('areaRankChart', 'areaTrendChip');
    buildLocationChart('stateRankChart', 'stateTrendChip');

    /* ---------- Section 7: Backlink radial analytics (High / Medium / Low DA / Pending) ---------- */
    (function () {
        const el = document.getElementById('backlinkRadialChart');
        if (!el) return;
        const series = JSON.parse(el.getAttribute('data-series') || '[]');
        const chart = new ApexCharts(el, {
            chart: chartShell('radialBar', 260),
            series: series,
            labels: ['High DA', 'Medium DA', 'Low DA', 'Pending'],
            colors: ['#10B981', '#3B82F6', '#F97316', '#8B5CF6'],
            plotOptions: {
                radialBar: {
                    hollow: { size: '38%' },
                    track: { background: gridColor() },
                    dataLabels: { show: false }
                }
            },
            stroke: { lineCap: 'round' },
            legend: Object.assign({}, sharedLegend, { show: true, position: 'bottom' }),
            tooltip: Object.assign({}, sharedTooltip, { y: { formatter: v => v + '%' } })
        });
        chart.render();
        track(chart);
    })();

    /* ---------- Section 7B: Backlink growth — glow area + moving average + target/forecast ---------- */
    (function () {
        const el = document.getElementById('backlinkGrowthChart');
        if (!el) return;
        const labels = JSON.parse(el.getAttribute('data-labels') || '[]');
        const series = JSON.parse(el.getAttribute('data-series') || '[]');
        if (series.length < 2) return;

        // 3-point moving average, computed from the real cumulative series
        const movingAverage = series.map((_, i) => {
            const slice = series.slice(Math.max(0, i - 2), i + 1);
            return Math.round((slice.reduce((a, b) => a + b, 0) / slice.length) * 10) / 10;
        });

        // Simple linear forecast for the next data point, derived from the last two real values
        const lastDelta = series[series.length - 1] - series[series.length - 2];
        const forecastLabels = labels.concat(['Forecast']);
        const forecastSeries = series.map(() => null);
        forecastSeries[series.length - 1] = series[series.length - 1];
        forecastSeries.push(series[series.length - 1] + Math.max(lastDelta, 0));

        const chart = new ApexCharts(el, {
            chart: chartShell('area', 340, { dropShadow: { enabled: true, top: 4, left: 0, blur: 6, opacity: 0.25, color: '#4F46E5' } }),
            series: [
                { name: 'Total Backlinks', data: series.concat([null]) },
                { name: 'Forecast', data: forecastSeries },
                { name: '3‑Month Avg', data: movingAverage.concat([null]) }
            ],
            colors: ['#4F46E5', '#06B6D4', '#94A3B8'],
            stroke: { curve: 'smooth', width: [3, 2, 2], dashArray: [0, 6, 4] },
            fill: {
                type: ['gradient', 'solid', 'solid'],
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 100] }
            },
            markers: {
                size: [4, 5, 0],
                strokeWidth: 0,
                hover: { size: 7 },
                discrete: [{ seriesIndex: 0, dataPointIndex: series.length - 1, size: 7, strokeWidth: 3, strokeColor: '#4F46E5', fillColor: '#fff' }]
            },
            dataLabels: { enabled: false },
            grid: sharedGrid,
            legend: Object.assign({}, sharedLegend, { position: 'bottom' }),
            xaxis: Object.assign({ categories: forecastLabels }, axisLabelStyle()),
            yaxis: Object.assign({ title: { text: 'Cumulative Backlinks', style: { color: axisColor() } }, min: 0 }, axisLabelStyle()),
            tooltip: sharedTooltip
        });
        chart.render();
        track(chart);
    })();

    /* ---------- Section 9: On-page / Backlink radial gauges ---------- */
    document.querySelectorAll('.chart-wrap-gauge[data-pct]').forEach(el => {
        const pct = parseFloat(el.getAttribute('data-pct')) || 0;
        const color = el.getAttribute('data-color') || '#4F46E5';
        const chart = new ApexCharts(el, {
            chart: chartShell('radialBar', 190),
            series: [pct],
            colors: [color],
            plotOptions: {
                radialBar: {
                    hollow: { size: '58%' },
                    track: { background: gridColor() },
                    dataLabels: {
                        name: { show: true, fontSize: '11px', color: axisColor(), offsetY: -6 },
                        value: { show: true, fontSize: '24px', fontWeight: 800, color: axisColor(), offsetY: 6, formatter: v => v + '%' }
                    }
                }
            },
            stroke: { lineCap: 'round' },
            labels: ['Complete']
        });
        chart.render();
        track(chart);
    });

    /* ---------- Section 11: Monthly growth (visibility score) — glow area chart ---------- */
    (function () {
        const el = document.getElementById('monthlyGrowthChart');
        if (!el) return;
        const series = JSON.parse(el.getAttribute('data-series') || '[]');
        if (series.length < 2) return;

        const chart = new ApexCharts(el, {
            chart: chartShell('area', 340, { dropShadow: { enabled: true, top: 4, left: 0, blur: 6, opacity: 0.25, color: '#4F46E5' } }),
            series: [{ name: 'Visibility Score', data: series }],
            colors: ['#4F46E5'],
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 100] } },
            markers: { size: 4, strokeWidth: 0, hover: { size: 7 } },
            dataLabels: { enabled: false },
            grid: sharedGrid,
            legend: Object.assign({}, sharedLegend, { show: false }),
            xaxis: axisLabelStyle(),
            yaxis: Object.assign({ min: 0, max: 100, title: { text: 'Visibility Score', style: { color: axisColor() } } }, axisLabelStyle()),
            tooltip: sharedTooltip
        });
        chart.render();
        track(chart);
    })();

});
</script>
@endpush
