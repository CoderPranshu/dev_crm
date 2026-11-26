@extends('index')

@section('title', 'SEO Performance Report')

@section('content')

    @php
        $companyName = optional($project->company)->name ?? 'Client';
        $website = optional($project->company)->website;
        $planTitle = optional($project->seoPlan)->name ?? 'SEO Plan';
        $initials =
            collect(explode(' ', trim($companyName)))
                ->filter()
                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                ->take(2)
                ->implode('') ?:
            'SR';

        $backlinkCompletedPct =
            $stats['backlinks'] > 0 ? round(($stats['backlinks_completed'] / $stats['backlinks']) * 100) : 0;

        $onpageCompletedPct =
            $stats['onpage_total'] > 0 ? round(($stats['onpage_completed'] / $stats['onpage_total']) * 100) : 0;

        $overallScore = (int) round(($backlinkCompletedPct + $onpageCompletedPct) / 2);

        $backlinkCancelled = $backlinks->where('status', 'cancelled')->count();
        $backlinkCompleted = $backlinks->where('status', 'completed')->count();
        $backlinkPending = $backlinks->whereNotIn('status', ['completed', 'cancelled'])->count();

        $daHigh = $backlinks->filter(fn($b) => (optional($b->backlink)->domain_authority ?? 0) >= 50)->count();
        $daMedium = $backlinks
            ->filter(function ($b) {
                $da = optional($b->backlink)->domain_authority ?? 0;
                return $da >= 20 && $da < 50;
            })
            ->count();
        $daLow = $backlinks
            ->filter(function ($b) {
                $da = optional($b->backlink)->domain_authority;
                return $da !== null && $da < 20;
            })
            ->count();

        $areaLocations = $project->locations->where('type', 'area')->values();
        $stateLocations = $project->locations->where('type', 'state')->values();

        $projectStart = optional($project->created_at)->format('M Y') ?? '—';
        $currentMonth = now()->format('M Y');
        $firstKeywordDate =
            optional(optional($keywords->sortBy('created_at')->first())->created_at)->format('M d, Y') ?? '—';
        $firstBacklinkDate =
            optional(optional($backlinks->sortBy('created_at')->first())->created_at)->format('M d, Y') ?? '—';
        $firstOnPageDate =
            optional(optional($onPages->sortBy('created_at')->first())->created_at)->format('M d, Y') ?? '—';

        $keywordsInTop10 = $keywords
            ->filter(function ($keyword) {
                $current =
                    optional($keyword->rankings->sortBy('month_no')->last())->ranking ??
                    ($keyword->starting_rank ?? null);
                return $current !== null && $current <= 10;
            })
            ->count();

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
$visibilityDelta =
    $latestVisibility !== null && $previousVisibility !== null ? $latestVisibility - $previousVisibility : null;

// Build an inline SVG polyline for the hero sparkline — no JS charting lib needed for this tiny element.
$sparklinePoints = '';
if (count($visibilitySeries) > 1) {
    $sMax = max($visibilitySeries);
    $sMin = min($visibilitySeries);
    $sRange = max($sMax - $sMin, 1);
    $sw = 220;
    $sh = 56;
    $n = count($visibilitySeries);
    $pts = [];
    foreach ($visibilitySeries as $i => $v) {
        $x = ($i / ($n - 1)) * $sw;
        $y = $sh - (($v - $sMin) / $sRange) * $sh;
        $pts[] = round($x, 1) . ',' . round($y, 1);
    }
    $sparklinePoints = implode(' ', $pts);
}

$heroSummary =
    'SEO score is at ' .
    $overallScore .
    '%, with ' .
    $backlinkCompleted .
    ' backlink(s) live and ' .
    $onpageCompletedPct .
    '% of on-page tasks complete' .
    ($keywordsInTop10 > 0 ? ', and ' . $keywordsInTop10 . ' keyword(s) ranking in the Top 10.' : '.');
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
        $backlinkGrowthLabels = $backlinkGrowthRaw
            ->keys()
            ->map(fn($k) => optional(\DateTime::createFromFormat('Y-m', $k))->format('M Y') ?: $k)
            ->values()
            ->all();
        $backlinkGrowthCumulative = [];
        $cumB = 0;
        foreach ($backlinkGrowthRaw->values()->all() as $c) {
            $cumB += $c;
            $backlinkGrowthCumulative[] = $cumB;
        }

        // On-page task growth — cumulative count by month, based on created_at
        $onpageGrowthRaw = $onPages
            ->map(fn($p) => optional($p->created_at)?->format('Y-m'))
            ->filter()
            ->countBy()
            ->sortKeys();
        $onpageGrowthLabels = $onpageGrowthRaw
            ->keys()
            ->map(fn($k) => optional(\DateTime::createFromFormat('Y-m', $k))->format('M Y') ?: $k)
            ->values()
            ->all();
        $onpageGrowthCumulative = [];
        $cumO = 0;
        foreach ($onpageGrowthRaw->values()->all() as $c) {
            $cumO += $c;
            $onpageGrowthCumulative[] = $cumO;
        }

        // On-page weekly / today change, using created_at as the completion marker
        // (the previous design already displayed created_at as the task's "completed" date)
$todayStart = now()->startOfDay();
$weekAgoStart = now()->copy()->subDays(7)->startOfDay();
$onpageCompletedToday = $onPages
    ->filter(
        fn($p) => ($p->status ?? '') === 'completed' &&
            optional($p->created_at)?->greaterThanOrEqualTo($todayStart),
    )
    ->count();
$onpageCompletedThisWeek = $onPages
    ->filter(
        fn($p) => ($p->status ?? '') === 'completed' &&
            optional($p->created_at)?->greaterThanOrEqualTo($weekAgoStart),
    )
    ->count();

/*
 * Simple keyword-wise ranking chart.
 * Every keyword gets its own named line and every line uses the same
 * Month 0 to Month 12 axis. Missing ranking entries stay null so values
 * never move into the wrong month.
 */
$keywordChartMonthNumbers = collect(range(0, 12));
$keywordChartMonths = $keywordChartMonthNumbers->map(fn($month) => 'Month ' . $month)->all();

$keywordServiceStart =
    optional($planClient)->created_at ?? optional($keywords->sortBy('created_at')->first())->created_at;

$keywordChartDates = $keywordChartMonthNumbers
    ->map(function ($month) use ($keywordServiceStart) {
        return $keywordServiceStart
            ? $keywordServiceStart->copy()->addMonthsNoOverflow($month)->format('d M Y')
            : null;
    })
    ->all();

$usedKeywordChartNames = [];
$keywordChartSeries = $keywords
    ->map(function ($keyword) use ($keywordChartMonthNumbers, &$usedKeywordChartNames) {
        $rankingsByMonth = $keyword->rankings
            ->filter(fn($ranking) => $ranking->month_no !== null && $ranking->ranking !== null)
            ->sortBy('month_no')
            ->keyBy(fn($ranking) => (int) $ranking->month_no);

        $keywordName = trim((string) $keyword->keyword);
        if ($keywordName === '') {
            $keywordName = 'Keyword #' . $keyword->id;
        }

        $nameKey = mb_strtolower($keywordName);
        if (isset($usedKeywordChartNames[$nameKey])) {
            $keywordName .= ' (#' . $keyword->id . ')';
        }
        $usedKeywordChartNames[$nameKey] = true;

        $data = $keywordChartMonthNumbers
            ->map(function ($month) use ($rankingsByMonth) {
                $ranking = $rankingsByMonth->get($month);

                return $ranking && $ranking->ranking !== null ? (int) $ranking->ranking : null;
            })
            ->all();

        return [
            'name' => $keywordName,
            'data' => $data,
        ];
    })
    ->filter(fn($series) => collect($series['data'])->contains(fn($value) => $value !== null))
            ->values()
            ->all();
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
                <button type="button" class="tb-btn tb-btn-pdf" id="exportPdfBtn"
                    title="Download the full SEO report as PDF">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
                <span id="pdfExportStatus" class="visually-hidden" role="status" aria-live="polite"></span>
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
                    @if ($website)
                        <p class="hero-subtitle">
                            <i class="fa-solid fa-globe"></i>
                            <a href="{{ $website }}" target="_blank" rel="noopener"
                                class="hero-link">{{ $website }}</a>
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
                        @if ($visibilityDelta !== null)
                            <div class="hero-meta-item">
                                <small>Monthly Visibility Change</small>
                                <strong class="{{ $visibilityDelta >= 0 ? 'text-up' : 'text-down' }}">
                                    <i class="fa-solid fa-arrow-{{ $visibilityDelta >= 0 ? 'up' : 'down' }}"></i>
                                    {{ $visibilityDelta >= 0 ? '+' : '' }}{{ $visibilityDelta }} pts
                                </strong>
                            </div>
                        @endif
                    </div>

                    @if ($sparklinePoints)
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
                                <linearGradient id="heroScoreGradient" x1="0%" y1="0%" x2="100%"
                                    y2="100%">
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
                @if (count($visibilitySeries) > 1)
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
                @if (count($backlinkGrowthCumulative) > 1)
                    <div class="kpi-spark" id="sparkBacklinks"
                        data-series="{{ json_encode($backlinkGrowthCumulative) }}"></div>
                @endif
                <div class="kpi-trend"><i class="fa-solid fa-circle-check"></i> {{ $stats['backlinks_completed'] ?? 0 }}
                    completed &middot; {{ $backlinkPending }} pending</div>
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
                @if (count($onpageGrowthCumulative) > 1)
                    <div class="kpi-spark" id="sparkOnpage" data-series="{{ json_encode($onpageGrowthCumulative) }}">
                    </div>
                @endif
                <div class="kpi-trend"><i class="fa-solid fa-circle-check"></i> {{ $stats['onpage_completed'] ?? 0 }}
                    completed</div>
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
                <div class="kpi-value" data-count="{{ $stats['state_groups'] ?? 0 }}">0</div>
                <div class="kpi-label">Stats Groups</div>
                <div class="kpi-trend"><i class="fa-solid fa-chart-line"></i> {{ $stats['states'] ?? 0 }} tracked items
                </div>
            </div>

            <div class="kpi-card fade-up">
                <div class="kpi-border"></div>
                <div class="kpi-icon kpi-icon-success"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="kpi-value" data-count="{{ $averageDA }}">0</div>
                <div class="kpi-label">Average Domain Authority</div>
                <div class="kpi-trend"><i class="fa-solid fa-scale-balanced"></i> {{ $daHigh }} high &middot;
                    {{ $daMedium }} med &middot; {{ $daLow }} low</div>
            </div>

        </div>
        <p class="kpi-footnote">
            <i class="fa-solid fa-circle-info"></i>
            Traffic, clicks/impressions, DR and Spam Score cards aren't shown because this project isn't currently wired to
            a
            Search Console / GA4 / backlink-API data source — happy to add them once those fields are available.
        </p>

        {{-- ============================= --}}
        {{-- SECTION 3 — SIMPLE KEYWORD RANKING PROGRESS --}}
        {{-- ============================= --}}
        <div class="panel fade-up">
            <div class="panel-header">
                <div>
                    <h5 class="section-title"><i class="fa-solid fa-chart-line text-primary"></i> Keyword Ranking Progress
                    </h5>
                    <p class="section-subtitle">Each coloured line represents one keyword &middot; A smaller rank number
                        means a better Google position</p>
                </div>
                <div class="trend-chip">
                    <i class="fa-solid fa-trophy"></i> Lower rank is better
                </div>
            </div>
            <div class="panel-body">
                @if (count($keywordChartSeries))
                    <div class="chart-wrap" id="keywordRankingChart"
                        data-months="{{ json_encode($keywordChartMonths) }}"
                        data-dates="{{ json_encode($keywordChartDates) }}"
                        data-series="{{ json_encode($keywordChartSeries) }}"></div>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                        <p>No keyword ranking history is available yet.</p>
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
                @if ($keywords->count())
                    <div class="panel-tools">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="keywordSearch" placeholder="Search keywords…">
                        </div>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                @if ($keywords->count())
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
                                @foreach ($keywords as $keyword)
                                    @php
                                        $startRank = $keyword->starting_rank ?? null;
                                        $currentRank =
                                            optional($keyword->rankings->sortBy('month_no')->last())->ranking ??
                                            $startRank;
                                        $improvement =
                                            $startRank !== null && $currentRank !== null
                                                ? $startRank - $currentRank
                                                : null;

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
                                        <td data-value="{{ $keyword->keyword ?? '' }}">
                                            <strong>{{ $keyword->keyword ?? '—' }}</strong></td>
                                        <td data-value="{{ $keyword->search_volume ?? 0 }}">
                                            {{ $keyword->search_volume ? number_format($keyword->search_volume) : '—' }}
                                        </td>
                                        <td data-value="{{ $startRank ?? 0 }}">{{ $startRank ?? '—' }}</td>
                                        <td data-value="{{ $currentRank ?? 0 }}">{{ $currentRank ?? '—' }}</td>
                                        <td data-value="{{ $improvement ?? 0 }}">
                                            @if ($improvement === null)
                                                <span class="text-muted">—</span>
                                            @elseif($improvement > 0)
                                                <span class="text-up"><i class="fa-solid fa-arrow-up"></i>
                                                    {{ $improvement }}</span>
                                            @elseif($improvement < 0)
                                                <span class="text-down"><i class="fa-solid fa-arrow-down"></i>
                                                    {{ abs($improvement) }}</span>
                                            @else
                                                <span class="text-muted"><i class="fa-solid fa-minus"></i> 0</span>
                                            @endif
                                        </td>
                                        <td data-value="{{ $badgeLabel }}"><span
                                                class="badge status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                                        </td>
                                        <td>
                                            <div class="progress premium-progress">
                                                <div class="progress-bar {{ $barClass }}"
                                                    style="--w: {{ $barPct }}%"></div>
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
        <div class="row g-4 mb-3">
            <div class="col-12 col-lg-6 d-flex">
                <div class="panel fade-up">
                    <div class="panel-header">
                        <div>
                            <h5 class="section-title"><i class="fa-solid fa-map-location-dot text-success"></i> Area
                              Covered</h5>
                            <p class="section-subtitle">Lower ranking position is better</p>
                        </div>
                        <div class="trend-chip" id="areaTrendChip" style="display:none;"></div>
                    </div>
                    <div class="panel-body chart-panel-body">
                        @if (!empty($areaChartData['series']))
                            <div class="chart-wrap location-chart-wrap" id="areaRankChart"
                                data-chart="{{ json_encode($areaChartData) }}"></div>
                        @else
                            <div class="empty-state">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <p>No area-level ranking data available.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="panel fade-up">
                    <div class="panel-header">
                        <div>
                            <h5 class="section-title"><i class="fa-solid fa-timeline text-purple"></i> Overall Performance
                                Timeline</h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="premium-timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-primary"><i class="fa-solid fa-flag"></i></div>
                                <div class="timeline-content"><strong>Project
                                        Started</strong><span>{{ $projectStart }}</span></div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-success"><i
                                        class="fa-solid fa-magnifying-glass"></i></div>
                                <div class="timeline-content"><strong>Keywords
                                        Added</strong><span>{{ $firstKeywordDate }}</span></div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-warning"><i class="fa-solid fa-list-check"></i>
                                </div>
                                <div class="timeline-content"><strong>On Page SEO
                                        Started</strong><span>{{ $firstOnPageDate }}</span></div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-purple"><i class="fa-solid fa-link"></i></div>
                                <div class="timeline-content"><strong>Backlinks
                                        Started</strong><span>{{ $firstBacklinkDate }}</span></div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot timeline-dot-primary timeline-dot-current"><i
                                        class="fa-solid fa-calendar-day"></i></div>
                                <div class="timeline-content"><strong>Current
                                        Month</strong><span>{{ $currentMonth }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        {{-- ======================================== --}}
        {{-- SECTION 6 — ONE GRAPH PER STATE GROUP --}}
        {{-- ======================================== --}}
        @forelse($stateGroupCharts as $groupChart)
            <div class="panel fade-up">
                <div class="panel-header">
                    <div>
                        <h5 class="section-title">
                            <i class="fa-solid fa-chart-line text-primary"></i>
                            {{ $groupChart['name'] }}
                        </h5>
                        <p class="section-subtitle">
                            {{ $groupChart['state_count'] }} tracked
                            {{ $groupChart['state_count'] === 1 ? 'item' : 'items' }}
                            &middot; Monthly progress overview
                        </p>
                    </div>
                    <div class="trend-chip" id="stateGroupTrendChip{{ $groupChart['id'] }}" style="display:none;"></div>
                </div>

                <div class="panel-body chart-panel-body">
                    <div class="chart-wrap location-chart-wrap" id="stateGroupRankChart{{ $groupChart['id'] }}"
                        data-state-group-chart data-trend-chip="stateGroupTrendChip{{ $groupChart['id'] }}"
                        data-chart="{{ json_encode($groupChart['chart']) }}"></div>
                </div>
            </div>
        @empty
            <div class="panel fade-up">
                <div class="panel-body">
                    <div class="empty-state">
                        <i class="fa-solid fa-chart-line"></i>
                        <p>No Stats Group ranking data available.</p>
                    </div>
                </div>
            </div>
        @endforelse

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
                            data-series="{{ json_encode([$daHighPct, $daMediumPct, $daLowPct, $backlinkPendingPct]) }}">
                        </div>
                        <div class="radial-center">
                            <span class="radial-center-value" style="margin-top: px;">{{ $stats['backlinks'] ?? 0 }}
                            </span>
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
                @if (count($backlinkGrowthCumulative) > 1)
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
                @if ($backlinks->count())
    <div class="panel-tools">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="backlinkSearch" placeholder="Search backlinks…">
                        </div>
                    </div>
    @endif
            </div>
            <div class="panel-body">
                @if ($backlinks->count())
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
                            @foreach ($backlinks as $backlink)
    @php
        $da = optional($backlink->backlink)->domain_authority;
        $status = $backlink->status ?? 'pending';
        $statusBadge = match ($status) {
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
                <div class="chart-wrap chart-wrap-gauge" id="onpageRadialGauge" data-pct="{{ $onpageCompletedPct }}"
                    data-color="#10B981"></div>
                <div class="gauge-legend">
                    <div><strong class="text-up">{{ $stats['onpage_completed'] ?? 0 }}</strong><small>Completed</small>
                    </div>
                    <div><strong
                            class="text-warning">{{ ($stats['onpage_total'] ?? 0) - ($stats['onpage_completed'] ?? 0) }}</strong><small>Pending</small>
                    </div>
                    <div><strong>{{ $onpageCompletedToday }}</strong><small>Completed Today</small></div>
                    <div><strong>{{ $onpageCompletedThisWeek }}</strong><small>Completed This Week</small></div>
                </div>
            </div>

            <div class="panel gauge-panel fade-up">
                <h5 class="section-title"><i class="fa-solid fa-link text-primary"></i> Backlink Progress</h5>
                <div class="chart-wrap chart-wrap-gauge" id="backlinkRadialGauge" data-pct="{{ $backlinkCompletedPct }}"
                    data-color="#4F46E5"></div>
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
                @if ($onPages->count())
                    <div class="task-grid">
                        @foreach ($onPages as $page)
                            @php
                                $status = $page->status ?? 'pending';
                                $taskCardClass = match ($status) {
                                    'completed' => 'task-card-success',
                                    'running' => 'task-card-info',
                                    default => 'task-card-warning',
                                };
                                $statusBadge = match ($status) {
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
                                    <span><i class="fa-regular fa-calendar-check"></i>
                                        {{ optional($page->created_at)?->format('M d, Y') ?? 'Not completed' }}</span>
                                </div>
                                @if (!empty($page->remarks))
                                    <p class="task-remarks"><i class="fa-regular fa-comment-dots"></i>
                                        {{ $page->remarks }}</p>
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
                @if (count($visibilitySeries) > 1)
                    <div class="chart-wrap" id="monthlyGrowthChart" data-series="{{ json_encode($visibilitySeries) }}">
                    </div>
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


        {{-- ============================= --}}
        {{-- SECTION 13 — AI INSIGHTS --}}
        {{-- ============================= --}}
        {{-- <div class="panel fade-up">
            <div class="panel-header">
                <div>
                    <h5 class="section-title"><i class="fa-solid fa-lightbulb text-warning"></i> AI Insights &amp;
                        Recommendations</h5>
                    <p class="section-subtitle">Generated from this month's live account data</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="insight-grid">
                    @if ($backlinkCompletedPct < 70)
                        <div class="insight-card insight-danger">
                            <div class="insight-icon"><i class="fa-solid fa-link"></i></div>
                            <div class="insight-body">
                                <div class="insight-top"><strong>Increase Backlink Velocity</strong><span
                                        class="severity-badge severity-high">High Priority</span></div>
                                <p>{{ $backlinkPending }} backlink(s) are still pending — prioritizing these will
                                    accelerate authority growth.</p>
                            </div>
                        </div>
                    @endif
                    @if ($onpageCompletedPct < 70)
                        <div class="insight-card insight-warning">
                            <div class="insight-icon"><i class="fa-solid fa-list-check"></i></div>
                            <div class="insight-body">
                                <div class="insight-top"><strong>Continue On-Page Optimization</strong><span
                                        class="severity-badge severity-medium">Medium Priority</span></div>
                                <p>{{ ($stats['onpage_total'] ?? 0) - ($stats['onpage_completed'] ?? 0) }} on-page task(s)
                                    remain to fully optimize the site.</p>
                            </div>
                        </div>
                    @endif
                    <div class="insight-card insight-success">
                        <div class="insight-icon"><i class="fa-solid fa-heading"></i></div>
                        <div class="insight-body">
                            <div class="insight-top"><strong>Optimize Titles &amp; Meta</strong><span
                                    class="severity-badge severity-low">Suggestion</span></div>
                            <p>Refine title tags and meta descriptions for keywords still outside the Top 10.</p>
                        </div>
                    </div>
                    <div class="insight-card insight-purple">
                        <div class="insight-icon"><i class="fa-solid fa-gauge-high"></i></div>
                        <div class="insight-body">
                            <div class="insight-top"><strong>Improve Core Web Vitals</strong><span
                                    class="severity-badge severity-low">Suggestion</span></div>
                            <p>Faster load times and better stability support both rankings and conversions.</p>
                        </div>
                    </div>
                    <div class="insight-card insight-danger">
                        <div class="insight-icon"><i class="fa-solid fa-mouse-pointer"></i></div>
                        <div class="insight-body">
                            <div class="insight-top"><strong>Improve Click-Through Rate</strong><span
                                    class="severity-badge severity-medium">Medium Priority</span></div>
                            <p>Test more compelling titles and descriptions on pages with strong impressions but low clicks.
                            </p>
                        </div>
                    </div>
                    <div class="insight-card insight-primary">
                        <div class="insight-icon"><i class="fa-solid fa-diagram-project"></i></div>
                        <div class="insight-body">
                            <div class="insight-top"><strong>Add Internal Links</strong><span
                                    class="severity-badge severity-low">Suggestion</span></div>
                            <p>Strengthen topical authority by linking related pages to top-performing content.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

@endsection

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Equal height dashboard cards */
.row > .col-lg-6 {
    display: flex;
}

.row > .col-lg-6 > .panel {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.row > .col-lg-6 > .panel .panel-body {
    flex: 1;
}


        /* =========================================================
       DESIGN TOKENS
    ========================================================= */
        .seo-report {
            --primary: #4F46E5;
            --primary-2: #2563EB;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #F43F5E;
            --purple: #8B5CF6;

            --bg: #F5F6FB;
            --card: #FFFFFF;
            --card-border: rgba(15, 23, 42, .06);
            --text-strong: #0F172A;
            --text-muted: #64748B;
            --text-faint: #94A3B8;
            --divider: #EEF1F6;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, .04), 0 1px 1px rgba(15, 23, 42, .03);
            --shadow-md: 0 12px 28px rgba(15, 23, 42, .08);
            --shadow-lg: 0 24px 48px rgba(15, 23, 42, .14);

            font-family: 'Inter', sans-serif;
            /* background:var(--bg); */
            color: var(--text-strong);
            padding: 1.5rem 0;
            transition: background .35s ease, color .35s ease;
        }

        .seo-report[data-theme="dark"] {
            --bg: #0B1120;
            --card: #111A2C;
            --card-border: rgba(255, 255, 255, .06);
            --text-strong: #F1F5F9;
            --text-muted: #94A3B8;
            --text-faint: #64748B;
            --divider: rgba(255, 255, 255, .06);
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .3);
            --shadow-md: 0 12px 28px rgba(0, 0, 0, .45);
            --shadow-lg: 0 24px 48px rgba(0, 0, 0, .55);
        }

        .seo-report h1,
        .seo-report h2,
        .seo-report h3,
        .seo-report h4,
        .seo-report h5 {
            font-family: 'Sora', 'Inter', sans-serif;
            font-weight: 700;
        }

        .text-primary {
            color: var(--primary-2) !important;
        }

        .text-purple {
            color: var(--purple) !important;
        }

        .text-warning {
            color: var(--warning) !important;
        }

        .text-up {
            color: var(--success) !important;
        }

        .text-down {
            color: var(--danger) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .section-title {
            font-weight: 700;
            color: var(--text-strong);
            font-size: 1.02rem;
            margin-bottom: .2rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .section-subtitle {
            font-size: .82rem;
            color: var(--text-muted);
            font-weight: 500;
            margin: 0;
        }

        /* =========================================================
       TOOLBAR
    ========================================================= */
        .report-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
            margin-bottom: 1.25rem;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .toolbar-eyebrow {
            text-transform: uppercase;
            letter-spacing: .06em;
            font-size: .7rem;
            color: var(--text-faint);
        }

        .toolbar-divider {
            color: var(--text-faint);
        }

        .toolbar-page {
            color: var(--text-strong);
        }

        .toolbar-right {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .tb-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--card);
            border: 1px solid var(--card-border);
            color: var(--text-strong);
            font-size: .8rem;
            font-weight: 600;
            padding: .5rem .85rem;
            border-radius: .7rem;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .tb-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .tb-btn-icon {
            width: 2.35rem;
            justify-content: center;
            padding: .5rem;
        }

        /* =========================================================
       HERO
    ========================================================= */
        .hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 1.75rem;
            padding: 2.25rem 2.5rem;
            margin-bottom: 1.5rem;
            /* background:radial-gradient(120% 140% at 100% 0%,#3B3AC0 0%,#4338CA 32%,#1E1B4B 100%); */
            background: linear-gradient(135deg, #0F2C36 0%, #155B6C 60%, #1E8799 100%);
            box-shadow: var(--shadow-lg);
            isolation: isolate;
        }

        .hero-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
        }

        .hero-glow-a {
            width: 420px;
            height: 420px;
            background: rgb(19 41 42 / 35%);
            top: -160px;
            right: -120px;
            animation: heroDrift 14s ease-in-out infinite;
        }

        .hero-glow-b {
            width: 320px;
            height: 320px;
            background: rgba(96, 165, 250, .28);
            bottom: -140px;
            left: -80px;
            animation: heroDrift 18s ease-in-out infinite reverse;
        }

        @keyframes heroDrift {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(30px, -20px);
            }
        }

        .hero-noise {
            position: absolute;
            inset: 0;
            opacity: .05;
            background-image: radial-gradient(rgba(255, 255, 255, .9) 1px, transparent 1px);
            background-size: 14px 14px;
            pointer-events: none;
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2.5rem;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(255, 255, 255, .14);
            color: #fff;
            font-weight: 600;
            font-size: .75rem;
            padding: .4rem .8rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .28);
            backdrop-filter: blur(6px);
            margin-bottom: .9rem;
        }

        .hero-title {
            color: #fff;
            font-size: 2.15rem;
            margin: 0 0 .35rem;
            letter-spacing: -.01em;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, .82);
            font-weight: 500;
            margin: 0 0 .9rem;
            font-size: .92rem;
        }

        .hero-link {
            color: #fff;
            text-decoration: underline;
            text-decoration-color: rgba(255, 255, 255, .4);
        }

        .hero-summary {
            color: rgba(255, 255, 255, .92);
            font-size: .92rem;
            font-weight: 500;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: .9rem;
            padding: .7rem 1rem;
            display: flex;
            gap: .55rem;
            align-items: flex-start;
            max-width: 36rem;
            margin-bottom: 1.1rem;
        }

        .hero-summary i {
            color: #C4B5FD;
            margin-top: .15rem;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .hero-meta-item small {
            display: block;
            color: rgba(255, 255, 255, .6);
            font-weight: 600;
            text-transform: uppercase;
            font-size: .66rem;
            letter-spacing: .05em;
        }

        .hero-meta-item strong {
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
        }

        .hero-sparkline {
            display: flex;
            align-items: center;
            gap: .7rem;
            max-width: 280px;
        }

        .hero-sparkline-label {
            color: rgba(255, 255, 255, .6);
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .hero-sparkline svg {
            width: 100%;
            height: 44px;
        }

        .spark-line {
            fill: none;
            stroke: #C4B5FD;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .hero-score {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .75rem;
        }

        .hero-logo-chip {
            width: 2.4rem;
            height: 2.4rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: .85rem;
            margin-top: -.6rem;
        }

        /* =========================================================
       GAUGES / RINGS
    ========================================================= */
        .progress-ring {
            position: relative;
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }

        .progress-ring svg {
            width: 60px;
            height: 60px;
            transform: rotate(-90deg);
        }

        .progress-ring .ring-bg {
            fill: none;
            stroke: var(--divider);
            stroke-width: 6;
        }

        .progress-ring .ring-fg {
            fill: none;
            stroke-width: 6;
            stroke-linecap: round;
            stroke-dasharray: 163;
            stroke-dashoffset: 163;
            transition: stroke-dashoffset 1.2s cubic-bezier(.22, 1, .36, 1);
        }

        .progress-ring .ring-success {
            stroke: var(--success);
        }

        .progress-ring .ring-warning {
            stroke: var(--warning);
        }

        .progress-ring .ring-primary {
            stroke: var(--primary-2);
        }

        .progress-ring .ring-purple {
            stroke: var(--purple);
        }

        .progress-ring .ring-label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            font-weight: 700;
            color: var(--text-strong);
        }

        .gauge-ring {
            position: relative;
        }

        .gauge-ring-md {
            width: 150px;
            height: 150px;
        }

        .gauge-ring-md svg {
            width: 150px;
            height: 150px;
            transform: rotate(-90deg);
        }

        .gauge-ring-md .ring-bg {
            fill: none;
            stroke: var(--divider);
            stroke-width: 9;
        }

        .gauge-ring-md .ring-fg {
            fill: none;
            stroke-width: 9;
            stroke-linecap: round;
            stroke-dasharray: 327;
            stroke-dashoffset: 327;
            transition: stroke-dashoffset 1.4s cubic-bezier(.22, 1, .36, 1);
        }

        .gauge-ring-hero {
            width: 170px;
            height: 170px;
        }

        .gauge-ring-hero svg {
            width: 170px;
            height: 170px;
            transform: rotate(-90deg);
        }

        .gauge-ring-hero .ring-bg-dark {
            fill: none;
            stroke: rgba(255, 255, 255, .16);
            stroke-width: 11;
        }

        .gauge-ring-hero .ring-fg {
            fill: none;
            stroke-width: 11;
            stroke-linecap: round;
            stroke-dasharray: 452;
            stroke-dashoffset: 452;
            transition: stroke-dashoffset 1.6s cubic-bezier(.22, 1, .36, 1);
        }

        .gauge-glow .ring-fg {
            filter: drop-shadow(0 0 14px rgba(167, 139, 250, .65));
        }

        .gauge-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .gauge-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-strong);
        }

        .gauge-value-hero {
            color: #fff;
            font-size: 2.1rem;
        }

        .gauge-caption {
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .gauge-caption-hero {
            color: rgba(255, 255, 255, .7);
        }

        .gauge-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .gauge-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
            padding: 1.75rem;
        }

        .gauge-legend {
            display: flex;
            gap: 2rem;
        }

        .gauge-legend strong {
            display: block;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .gauge-legend small {
            color: var(--text-muted);
            font-size: .78rem;
        }

        /* =========================================================
       KPI CARDS
    ========================================================= */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .kpi-card {
            position: relative;
            background: var(--card);
            border-radius: 1.25rem;
            padding: 1.35rem 1.4rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-sm);
            transition: transform .3s cubic-bezier(.22, 1, .36, 1), box-shadow .3s ease;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .kpi-border {
            position: absolute;
            inset: 0;
            border-radius: 1.25rem;
            padding: 1px;
            background: linear-gradient(135deg, rgba(79, 70, 229, .35), rgba(139, 92, 246, 0), rgba(37, 99, 235, .25));
            opacity: 0;
            transition: opacity .3s ease;
            pointer-events: none;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .kpi-card:hover .kpi-border {
            opacity: 1;
        }

        .kpi-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .5rem;
        }

        .kpi-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: .75rem;
        }

        .kpi-icon-primary {
            background: rgba(37, 99, 235, .1);
            color: var(--primary-2);
        }

        .kpi-icon-success {
            background: rgba(16, 185, 129, .1);
            color: var(--success);
        }

        .kpi-icon-warning {
            background: rgba(245, 158, 11, .1);
            color: var(--warning);
        }

        .kpi-icon-danger {
            background: rgba(244, 63, 94, .1);
            color: var(--danger);
        }

        .kpi-icon-purple {
            background: rgba(139, 92, 246, .1);
            color: var(--purple);
        }

        .kpi-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-strong);
            line-height: 1.1;
        }

        .kpi-label {
            color: var(--text-muted);
            font-weight: 600;
            font-size: .82rem;
            margin-top: .15rem;
        }

        .kpi-trend {
            color: var(--text-faint);
            font-size: .74rem;
            font-weight: 600;
            margin-top: .65rem;
        }

        /* =========================================================
       PANELS / TABLES
    ========================================================= */
        .panel {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
            padding: 1.35rem 1.5rem 0;
        }

        .panel-body {
            padding: 1.35rem 1.5rem 1.5rem;
        }

        .panel-tools {
            display: flex;
            align-items: center;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: var(--bg);
            border: 1px solid var(--card-border);
            border-radius: .7rem;
            padding: .45rem .75rem;
        }

        .search-box i {
            color: var(--text-faint);
            font-size: .8rem;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: .83rem;
            color: var(--text-strong);
            width: 180px;
        }

        .table-scroll {
            max-height: 460px;
            overflow: auto;
            border-radius: .9rem;
            border: 1px solid var(--divider);
        }

        .premium-table {
            margin: 0;
        }

        .premium-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--bg);
            border: none;
            color: var(--text-muted);
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 700;
            padding: .85rem 1rem;
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
        }

        .premium-table thead th i {
            font-size: .65rem;
            color: var(--text-faint);
            margin-left: .3rem;
        }

        .premium-table tbody td {
            border-color: var(--divider);
            padding: .85rem 1rem;
            font-size: .87rem;
            color: var(--text-strong);
        }

        .premium-table tbody tr {
            transition: background .2s ease;
        }

        .premium-table tbody tr:hover {
            background: rgba(79, 70, 229, .04);
        }

        .status-badge {
            font-weight: 700;
            font-size: .7rem;
            padding: .38rem .7rem;
            border-radius: 999px;
        }

        .badge-success {
            background: rgba(16, 185, 129, .12);
            color: var(--success);
        }

        .badge-primary {
            background: rgba(37, 99, 235, .12);
            color: var(--primary-2);
        }

        .badge-warning {
            background: rgba(245, 158, 11, .12);
            color: #B45309;
        }

        .badge-danger {
            background: rgba(244, 63, 94, .12);
            color: var(--danger);
        }

        .badge-muted {
            background: var(--divider);
            color: var(--text-muted);
        }

        .premium-progress {
            height: 8px;
            border-radius: 999px;
            background: var(--divider);
            overflow: hidden;
        }

        .premium-progress .progress-bar {
            width: var(--w);
            border-radius: 999px;
            transition: width 1s cubic-bezier(.22, 1, .36, 1);
        }

        .bar-success {
            background: var(--success);
        }

        .bar-primary {
            background: var(--primary-2);
        }

        .bar-warning {
            background: var(--warning);
        }

        .bar-danger {
            background: var(--danger);
        }

        .bar-muted {
            background: var(--text-faint);
        }

        /* Backlink analytics layout */
        .backlink-grid {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) 2fr;
            gap: 1.5rem;
            align-items: center;
        }

        .mini-stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .mini-stat {
            background: var(--bg);
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
        }

        .mini-stat-value {
            display: block;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-strong);
        }

        .mini-stat-label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-top: .2rem;
        }

        /* Task cards */
        .task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }

        .task-card {
            border-radius: 1rem;
            padding: 1rem 1.1rem;
            border-left: 4px solid var(--text-faint);
            background: var(--bg);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .task-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .task-card-success {
            border-left-color: var(--success);
        }

        .task-card-warning {
            border-left-color: var(--warning);
        }

        .task-card-info {
            border-left-color: var(--primary-2);
        }

        .task-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: .5rem;
            gap: .5rem;
        }

        .task-category {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-muted);
        }

        .task-name {
            font-weight: 600;
            color: var(--text-strong);
            font-size: .9rem;
            margin: 0 0 .5rem;
        }

        .task-meta {
            font-size: .76rem;
            color: var(--text-muted);
        }

        .task-remarks {
            font-size: .76rem;
            color: var(--text-faint);
            margin: .4rem 0 0;
            font-style: italic;
        }

        /* Timeline */
        .premium-timeline {
            position: relative;
            padding-left: 2.75rem;
        }

        .premium-timeline::before {
            content: '';
            position: absolute;
            left: 1.1rem;
            top: .5rem;
            bottom: .5rem;
            width: 2px;
            background: linear-gradient(180deg, var(--primary-2), var(--purple));
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.75rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2.75rem;
            top: 0;
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .85rem;
            box-shadow: 0 0 0 4px var(--card);
        }

        .timeline-dot-primary {
            background: var(--primary-2);
        }

        .timeline-dot-success {
            background: var(--success);
        }

        .timeline-dot-warning {
            background: var(--warning);
        }

        .timeline-dot-purple {
            background: var(--purple);
        }

        .timeline-dot-current {
            animation: pulseDot 2.4s ease-in-out infinite;
        }

        @keyframes pulseDot {

            0%,
            100% {
                box-shadow: 0 0 0 4px var(--card), 0 0 0 6px rgba(79, 70, 229, .3);
            }

            50% {
                box-shadow: 0 0 0 4px var(--card), 0 0 0 10px rgba(79, 70, 229, .12);
            }
        }

        .timeline-content strong {
            display: block;
            color: var(--text-strong);
            font-weight: 700;
            font-size: .9rem;
        }

        .timeline-content span {
            color: var(--text-muted);
            font-size: .8rem;
        }

        /* AI Insights */
        .insight-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }

        .insight-card {
            display: flex;
            gap: .9rem;
            align-items: flex-start;
            background: var(--bg);
            border-radius: 1rem;
            padding: 1rem 1.1rem;
            border-left: 4px solid transparent;
        }

        .insight-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .95rem;
        }

        .insight-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            margin-bottom: .15rem;
        }

        .insight-top strong {
            color: var(--text-strong);
            font-size: .88rem;
        }

        .insight-body p {
            color: var(--text-muted);
            font-size: .8rem;
            margin: 0;
        }

        .severity-badge {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            padding: .22rem .55rem;
            border-radius: 999px;
            white-space: nowrap;
        }

        .severity-high {
            background: rgba(244, 63, 94, .12);
            color: var(--danger);
        }

        .severity-medium {
            background: rgba(245, 158, 11, .12);
            color: #B45309;
        }

        .severity-low {
            background: rgba(16, 185, 129, .12);
            color: var(--success);
        }

        .insight-danger {
            border-left-color: var(--danger);
        }

        .insight-danger .insight-icon {
            background: rgba(244, 63, 94, .1);
            color: var(--danger);
        }

        .insight-warning {
            border-left-color: var(--warning);
        }

        .insight-warning .insight-icon {
            background: rgba(245, 158, 11, .1);
            color: var(--warning);
        }

        .insight-success {
            border-left-color: var(--success);
        }

        .insight-success .insight-icon {
            background: rgba(16, 185, 129, .1);
            color: var(--success);
        }

        .insight-purple {
            border-left-color: var(--purple);
        }

        .insight-purple .insight-icon {
            background: rgba(139, 92, 246, .1);
            color: var(--purple);
        }

        .insight-primary {
            border-left-color: var(--primary-2);
        }

        .insight-primary .insight-icon {
            background: rgba(37, 99, 235, .1);
            color: var(--primary-2);
        }

        .chart-wrap {
            position: relative;
            height: 340px;
        }

        .chart-wrap-radial {
            height: 260px;
        }

        .chart-wrap-gauge {
            height: 190px;
        }

        .chart-panel-body {
            position: relative;
        }

        .kpi-footnote {
            grid-column: 1/-1;
            display: flex;
            align-items: center;
            gap: .5rem;
            color: var(--text-faint);
            font-size: .76rem;
            font-weight: 500;
            background: var(--card);
            border: 1px dashed var(--card-border);
            border-radius: .9rem;
            padding: .7rem 1rem;
            margin: -.5rem 0 1.5rem;
        }

        .kpi-footnote i {
            color: var(--text-muted);
        }

        .kpi-spark {
            height: 34px;
            margin: .4rem -.2rem 0;
        }

        .trend-chip {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: rgba(16, 185, 129, .1);
            color: var(--success);
            font-weight: 700;
            font-size: .78rem;
            padding: .4rem .75rem;
            border-radius: 999px;
            white-space: nowrap;
            height: fit-content;
        }

        .trend-chip.is-down {
            background: rgba(244, 63, 94, .1);
            color: var(--danger);
        }

        .radial-wrap {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .radial-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .radial-center-value {
            display: block;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text-strong);
        }

        .radial-center-label {
            display: block;
            font-size: .7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        /* ApexCharts theme polish */
        .apexcharts-tooltip {
            border-radius: .9rem !important;
            border: 1px solid var(--card-border) !important;
            box-shadow: var(--shadow-md) !important;
            overflow: hidden;
        }

        .apexcharts-legend-text {
            color: var(--text-muted) !important;
            font-family: 'Inter', sans-serif !important;
            font-size: .8rem !important;
        }

        .apexcharts-menu {
            border-radius: .75rem !important;
            box-shadow: var(--shadow-md) !important;
        }

        .empty-state {
            color: var(--text-faint);
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 1.75rem;
            display: block;
            margin-bottom: .5rem;
        }

        /* Fade up animation */
        .fade-up {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .6s cubic-bezier(.22, 1, .36, 1), transform .6s cubic-bezier(.22, 1, .36, 1);
        }

        .fade-up.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        @media(prefers-reduced-motion:reduce) {
            .fade-up {
                opacity: 1;
                transform: none;
                transition: none;
            }

            .hero-glow {
                animation: none;
            }

            .timeline-dot-current {
                animation: none;
            }
        }

        @media(max-width:1200px) {
            .kpi-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:991px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero-score {
                align-items: flex-start;
            }

            .hero-title {
                font-size: 1.7rem;
            }

            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .gauge-grid {
                grid-template-columns: 1fr;
            }

            .backlink-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:576px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .hero-card {
                padding: 1.75rem;
            }
        }

        /* PDF-only layout: expand tables and reveal sections not yet scrolled into view. */
        .tb-btn-pdf {
            background: #0e7490;
            color: #fff;
            border-color: #0e7490;
        }

        .tb-btn-pdf:hover {
            background: #155e75;
            color: #fff;
        }

        .tb-btn-pdf:disabled {
            opacity: .7;
            cursor: wait;
        }

        .pdf-report {
            width: 1280px !important;
            max-width: none !important;
            padding: 20px !important;
            box-sizing: border-box;
            background: var(--bg);
        }

        .pdf-report *,
        .pdf-report *::before,
        .pdf-report *::after {
            animation: none !important;
            transition: none !important;
        }

        .pdf-report .fade-up {
            opacity: 1 !important;
            transform: none !important;
        }

        .pdf-report .kpi-card,
        .pdf-report .task-card {
            transform: none !important;
        }

        .pdf-report .toolbar-right,
        .pdf-report .panel-tools,
        .pdf-report .apexcharts-toolbar,
        .pdf-report .apexcharts-tooltip,
        .pdf-report .apexcharts-xaxistooltip,
        .pdf-report .apexcharts-yaxistooltip,
        .pdf-report .apexcharts-menu {
            display: none !important;
        }

        .pdf-report .table-scroll {
            max-height: none !important;
            height: auto !important;
            overflow: visible !important;
        }

        .pdf-report .premium-table {
            width: 100% !important;
        }

        .pdf-report .premium-table thead th {
            position: static !important;
        }

        .pdf-report .kpi-grid {
            grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
        }

        .pdf-report .gauge-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .pdf-report .hero-grid {
            grid-template-columns: 1fr auto !important;
        }

        .pdf-report .hero-score {
            align-items: center !important;
        }

        .pdf-report .backlink-grid {
            grid-template-columns: minmax(220px, 1fr) 2fr !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const reportRoot = document.querySelector('.seo-report');

            /* ---------- Theme toggle (scoped to this component, persisted) ---------- */
            (function() {
                const btn = document.getElementById('themeToggleBtn');
                if (!btn || !reportRoot) return;
                const stored = localStorage.getItem('seoReportTheme');
                if (stored === 'dark') {
                    reportRoot.setAttribute('data-theme', 'dark');
                    btn.innerHTML = '<i class="fa-solid fa-sun"></i>';
                }
                btn.addEventListener('click', function() {
                    const isDark = reportRoot.getAttribute('data-theme') === 'dark';
                    reportRoot.setAttribute('data-theme', isDark ? 'light' : 'dark');
                    localStorage.setItem('seoReportTheme', isDark ? 'light' : 'dark');
                    btn.innerHTML = isDark ? '<i class="fa-solid fa-moon"></i>' :
                        '<i class="fa-solid fa-sun"></i>';
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
            }, {
                threshold: 0.1
            });
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
                                if (current >= target) {
                                    current = target;
                                    clearInterval(timer);
                                }
                                el.textContent = current.toLocaleString();
                            }, 25);
                            counterObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });
                counterObserver.observe(el);
            });

            /* ---------- Progress rings & gauges ---------- */
            document.querySelectorAll('.progress-ring, .gauge-ring').forEach(ring => {
                const pct = parseFloat(ring.getAttribute('data-pct')) || 0;
                const fg = ring.querySelector('.ring-fg');
                if (!fg) return;
                const circumference = fg.getTotalLength ? fg.getTotalLength() : (2 * Math.PI * (fg.r ? fg.r
                    .baseVal.value : 26));
                fg.style.strokeDasharray = circumference;
                fg.style.strokeDashoffset = circumference;
                const ringObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const offset = circumference - (pct / 100) * circumference;
                            requestAnimationFrame(() => {
                                fg.style.strokeDashoffset = offset;
                            });
                            ringObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });
                ringObserver.observe(ring);
            });

            /* ---------- Generic table search ---------- */
            function attachSearch(inputId, tableId) {
                const input = document.getElementById(inputId);
                const table = document.getElementById(tableId);
                if (!input || !table) return;
                input.addEventListener('input', function() {
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
                    th.addEventListener('click', function() {
                        const tbody = table.querySelector('tbody');
                        const rows = Array.from(tbody.querySelectorAll('tr'));
                        const type = th.getAttribute('data-sort');
                        const asc = th.getAttribute('data-order') !== 'asc';
                        headers.forEach(h => h.removeAttribute('data-order'));
                        th.setAttribute('data-order', asc ? 'asc' : 'desc');

                        rows.sort((a, b) => {
                            const cellA = a.children[index].getAttribute('data-value') ?? a
                                .children[index].textContent.trim();
                            const cellB = b.children[index].getAttribute('data-value') ?? b
                                .children[index].textContent.trim();
                            if (type === 'number') {
                                return asc ? (parseFloat(cellA) - parseFloat(cellB)) : (
                                    parseFloat(cellB) - parseFloat(cellA));
                            }
                            return asc ? cellA.localeCompare(cellB) : cellB.localeCompare(
                                cellA);
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
                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
            const exportKeywordsBtn = document.getElementById('exportKeywordsBtn');
            if (exportKeywordsBtn) exportKeywordsBtn.addEventListener('click', () => exportTableToCsv(
                'keywordTable', 'keyword-progress.csv'));
            const exportBacklinksBtn = document.getElementById('exportBacklinksBtn');
            if (exportBacklinksBtn) exportBacklinksBtn.addEventListener('click', () => exportTableToCsv(
                'backlinkTable', 'backlink-details.csv'));

            /* ---------- Download the entire report as a paginated PDF ---------- */
            const pdfButton = document.getElementById('exportPdfBtn');
            let pdfDependencies;

            function loadPdfScript(src, available) {
                if (available()) return Promise.resolve();
                return new Promise((resolve, reject) => {
                    const script = document.createElement('script');
                    const timeout = setTimeout(() => {
                        script.remove();
                        reject(new Error('PDF library loading timed out.'));
                    }, 30000);
                    script.src = src;
                    script.onload = () => {
                        clearTimeout(timeout);
                        available() ? resolve() : reject(new Error('PDF library is unavailable.'));
                    };
                    script.onerror = () => {
                        clearTimeout(timeout);
                        script.remove();
                        reject(new Error('Could not load the PDF library.'));
                    };
                    document.head.appendChild(script);
                });
            }

            // Embedded logo keeps the exported PDF self-contained and independent of image URLs.
            const pdfBrandLogo = 'data:image/png;base64,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';
            const pdfBrandDetails = {
                website: 'codesparrow.org',
                email: 'info@codesparrow.org',
                phone: '+91 8527373739',
                address: 'Office 407, Jaina Tower II, Janakpuri, New Delhi 110058'
            };

            if (pdfButton && reportRoot) pdfButton.addEventListener('click', async function() {
                if (pdfButton.disabled) return;
                const oldLabel = pdfButton.innerHTML;
                let staging;
                pdfButton.disabled = true;
                pdfButton.setAttribute('aria-busy', 'true');
                const status = document.getElementById('pdfExportStatus');
                const progress = message => {
                    pdfButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ' + message;
                    if (status) status.textContent = message;
                };
                try {
                    progress('Preparing PDF...');
                    if (!pdfDependencies) {
                        pdfDependencies = Promise.all([
                            loadPdfScript(
                                'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js',
                                () => typeof window.html2canvas === 'function'),
                            loadPdfScript(
                                'https://cdn.jsdelivr.net/npm/jspdf@4.2.1/dist/jspdf.umd.min.js',
                                () => !!window.jspdf?.jsPDF)
                        ]).catch(error => {
                            pdfDependencies = null;
                            throw error;
                        });
                    }
                    await pdfDependencies;
                    if (document.fonts) await document.fonts.ready;
                    await Promise.all(chartRenderPromises);
                    // Finish initial ApexCharts animations before freezing the charts.
                    await new Promise(resolve => setTimeout(resolve, 850));
                    const snapshots = await Promise.all(renderedCharts.map(async chart => ({
                        id: chart.el.id,
                        image: (await chart.dataURI({
                            scale: 2
                        })).imgURI,
                        height: chart.el.querySelector('svg')
                            ?.getBoundingClientRect().height
                    })));

                    const clone = reportRoot.cloneNode(true);
                    clone.classList.add('pdf-report');
                    // Keep the selected theme; only the temporary copy is expanded.
                    clone.querySelectorAll('.kpi-value[data-count]').forEach(el => {
                        el.textContent = (Number(el.dataset.count) || 0).toLocaleString();
                    });
                    clone.querySelectorAll('.progress-ring, .gauge-ring').forEach(ring => {
                        const fg = ring.querySelector('.ring-fg');
                        if (!fg) return;
                        const radius = Number(fg.getAttribute('r')) || 26;
                        const length = 2 * Math.PI * radius;
                        const pct = Math.min(100, Math.max(0, Number(ring.dataset.pct) || 0));
                        fg.style.strokeDasharray = String(length);
                        fg.style.strokeDashoffset = String(length * (1 - pct / 100));
                    });
                    clone.querySelectorAll('tbody tr').forEach(row => {
                        row.style.display = '';
                    });
                    for (const snapshot of snapshots) {
                        const host = Array.from(clone.querySelectorAll('[id]')).find(el => el.id ===
                            snapshot.id);
                        const svg = host?.querySelector('svg');
                        if (!svg || !snapshot.image) continue;
                        const image = document.createElement('img');
                        image.src = snapshot.image;
                        image.alt = 'Report chart';
                        image.style.cssText = 'display:block;width:100%;height:' + (snapshot.height ||
                            340) + 'px;object-fit:fill;';
                        svg.replaceWith(image);
                    }

                    staging = document.createElement('div');
                    staging.setAttribute('aria-hidden', 'true');
                    staging.inert = true;
                    // Off-screen DOM, visible to the renderer, without changing the live page.
                    staging.style.cssText =
                        'position:absolute;left:-20000px;top:0;width:1280px;pointer-events:none;';
                    staging.appendChild(clone);
                    document.body.appendChild(staging);
                    await Promise.all(Array.from(clone.querySelectorAll('img')).map(image => {
                        if (image.complete) return Promise.resolve();
                        return new Promise(resolve => {
                            image.onload = resolve;
                            image.onerror = resolve;
                        });
                    }));

                    const pdf = new window.jspdf.jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4',
                        compress: true
                    });
                    const margin = 10;
                    const pageWidthMm = pdf.internal.pageSize.getWidth();
                    const pageHeightMm = pdf.internal.pageSize.getHeight();
                    const pdfDarkTheme = clone.getAttribute('data-theme') === 'dark';
                    // A 3 mm white page edge looks like roughly 15 px in the PDF viewer.
                    const pageBorderMm = 3;
                    // Leave a dedicated band for branding on every A4 page.
                    const contentTopMm = 39.5;
                    const contentBottomMm = 22;
                    const widthMm = pageWidthMm - margin * 2;
                    const heightMm = pageHeightMm - contentTopMm - contentBottomMm;
                    const widthPx = Math.ceil(clone.getBoundingClientRect().width);
                    const pixelsPerMm = widthPx / widthMm;
                    const pagePixels = Math.floor(heightMm * pixelsPerMm);
                    const rootRect = clone.getBoundingClientRect();
                    const totalHeight = Math.ceil(clone.scrollHeight);
                    // Protect each normal-sized panel and each row of an oversized table.
                    const protectedBoxes = Array.from(clone.querySelectorAll(
                            ':scope > *, tbody tr, .task-card, .insight-card'))
                        .map(el => el.getBoundingClientRect())
                        .filter(rect => rect.height > 0 && rect.height < pagePixels)
                        .map(rect => ({
                            top: Math.floor(rect.top - rootRect.top),
                            bottom: Math.ceil(rect.bottom - rootRect.top)
                        }));
                    let top = 0;
                    let pageNumber = 0;
                    while (top < totalHeight) {
                        let bottom = Math.min(top + pagePixels, totalHeight);
                        // Move a page boundary backwards until it no longer cuts a card or row.
                        let changed = true;
                        while (changed) {
                            changed = false;
                            for (const box of protectedBoxes) {
                                if (box.top > top && box.top < bottom && box.bottom > bottom) {
                                    bottom = box.top;
                                    changed = true;
                                }
                            }
                        }
                        const heightPx = Math.max(1, bottom - top);
                        progress('Creating page ' + (pageNumber + 1) + '...');
                        // Render page-sized canvases to avoid the browser's full-page canvas limit.
                        const canvas = await window.html2canvas(clone, {
                            scale: 2,
                            useCORS: true,
                            logging: false,
                            backgroundColor: getComputedStyle(clone).getPropertyValue('--bg')
                                .trim() || '#ffffff',
                            x: 0,
                            y: top,
                            width: widthPx,
                            height: heightPx,
                            windowWidth: 1440,
                            windowHeight: 1000,
                            scrollX: 0,
                            scrollY: 0,
                            onclone: (doc, element) => {
                                // x/y are offsets relative to the rendered element's bounds.
                                element.parentElement.style.left = '0';
                            }
                        });
                        if (pageNumber > 0) pdf.addPage();
                        // Match the report's --bg across the entire page, including the header
                        // and the space around sliced content. Leave a white outer border.
                        pdf.setFillColor(...(pdfDarkTheme ? [11, 17, 32] : [245, 246, 251]));
                        pdf.rect(pageBorderMm, pageBorderMm,
                            pageWidthMm - pageBorderMm * 2,
                            pageHeightMm - pageBorderMm * 2, 'F');
                        pdf.addImage(canvas.toDataURL('image/jpeg', 0.95), 'JPEG', margin, contentTopMm,
                            widthMm, heightPx / pixelsPerMm);
                        canvas.width = 0;
                        canvas.height = 0;
                        pageNumber++;
                        top = bottom;
                    }
                    for (let page = 1; page <= pageNumber; page++) {
                        pdf.setPage(page);

                        // Approved layout: one large logo and one compact details block.
                        if (pdfDarkTheme) {
                            pdf.setFillColor(255, 255, 255);
                            pdf.roundedRect(8, 11, 49, 17, 1.5, 1.5, 'F');
                        }
                        pdf.addImage(pdfBrandLogo, 'PNG', margin, 13, 45.5, 12.79);
                        pdf.setDrawColor(20, 156, 175);
                        pdf.setLineWidth(0.65);
                        pdf.line(59, 7, 59, 31);
                        pdf.setFont('helvetica', 'bold');
                        pdf.setFontSize(13);
                        pdf.setTextColor(...(pdfDarkTheme ? [240, 247, 251] : [21, 55, 68]));
                        pdf.text('SEO PERFORMANCE REPORT', 65, 14);
                        pdf.setFontSize(6.5);
                        pdf.setTextColor(...(pdfDarkTheme ? [115, 211, 224] : [25, 140, 157]));
                        pdf.text('WEBSITE', 65, 22);
                        pdf.text('EMAIL', 106, 22);
                        pdf.text('PHONE', 159, 22);
                        pdf.setFont('helvetica', 'normal');
                        pdf.setFontSize(8.2);
                        pdf.setTextColor(...(pdfDarkTheme ? [228, 236, 243] : [37, 59, 71]));
                        pdf.text(pdfBrandDetails.website, 65, 27.5);
                        pdf.text(pdfBrandDetails.email, 106, 27.5);
                        pdf.text(pdfBrandDetails.phone, 159, 27.5);
                        pdf.setFontSize(7.4);
                        pdf.setTextColor(...(pdfDarkTheme ? [173, 190, 201] : [97, 116, 128]));
                        pdf.text(pdfBrandDetails.address, 65, 32.5);
                        pdf.setDrawColor(...(pdfDarkTheme ? [69, 86, 105] : [203, 220, 225]));
                        pdf.setLineWidth(0.3);
                        pdf.line(margin, 35.5, pageWidthMm - margin, 35.5);

                        // Brand footer, report label, and page count.
                        pdf.line(margin, pageHeightMm - 18, pageWidthMm - margin,
                            pageHeightMm - 18);
                        pdf.setFont('helvetica', 'normal');
                        pdf.setFontSize(8);
                        pdf.setTextColor(...(pdfDarkTheme ? [175, 190, 203] : [100, 116, 139]));
                        pdf.text('SEO Performance Report', margin, pageHeightMm - 10);
                        pdf.setFont('helvetica', 'bold');
                        pdf.setTextColor(...(pdfDarkTheme ? [112, 220, 230] : [24, 139, 154]));
                        pdf.text('Powered by Code Sparrow', pageWidthMm / 2,
                            pageHeightMm - 10, { align: 'center' });
                        pdf.setFont('helvetica', 'normal');
                        pdf.setTextColor(...(pdfDarkTheme ? [175, 190, 203] : [100, 116, 139]));
                        pdf.text(page + ' / ' + pageNumber, pageWidthMm - margin,
                            pageHeightMm - 10, { align: 'right' });
                    }
                    const company = reportRoot.querySelector('.hero-title')?.textContent.trim() ||
                        'Client';
                    const safeName = company.replace(/[^a-z0-9_-]+/gi, '-').replace(/^-+|-+$/g, '')
                        .slice(0, 80) || 'Client';
                    await pdf.save(safeName + '-SEO-Report-' + new Date().toISOString().slice(0, 10) +
                        '.pdf', {
                            returnPromise: true
                        });
                    if (status) status.textContent = 'PDF downloaded successfully.';
                } catch (error) {
                    console.error('SEO report PDF export failed:', error);
                    if (status) status.textContent = 'PDF download failed. Please try again.';
                    alert(
                        'PDF generate nahi ho saka. Internet connection aur PDF scripts ki loading check karke dobara try karein.');
                } finally {
                    staging?.remove();
                    pdfButton.innerHTML = oldLabel;
                    pdfButton.disabled = false;
                    pdfButton.removeAttribute('aria-busy');
                }
            });


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
                        tools: {
                            download: true,
                            selection: false,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true
                        },
                        export: {
                            csv: {
                                filename: 'seo-report-chart'
                            },
                            svg: {
                                filename: 'seo-report-chart'
                            },
                            png: {
                                filename: 'seo-report-chart'
                            }
                        }
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 750,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    zoom: {
                        enabled: true
                    },
                    background: 'transparent'
                }, extra || {});
            }
            const sharedGrid = {
                borderColor: gridColor(),
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: false
                    }
                }
            };
            const sharedLegend = {
                fontFamily: chartFont,
                labels: {
                    colors: axisColor()
                },
                markers: {
                    radius: 12
                }
            };
            const sharedTooltip = {
                theme: isDarkTheme() ? 'dark' : 'light',
                style: {
                    fontFamily: chartFont
                }
            };

            function axisLabelStyle() {
                return {
                    style: {
                        colors: axisColor(),
                        fontSize: '11px'
                    }
                };
            }

            const renderedCharts = [];
            const chartRenderPromises = [];

            function track(chart) {
                if (chart) renderedCharts.push(chart);
            }

            /* ---------- KPI card sparklines (real monthly series only) ---------- */
            document.querySelectorAll('.kpi-spark[data-series]').forEach(el => {
                const series = JSON.parse(el.getAttribute('data-series') || '[]');
                if (series.length < 2) return;
                const rising = series[series.length - 1] >= series[0];
                const chart = new ApexCharts(el, {
                    chart: {
                        type: 'area',
                        height: 34,
                        sparkline: {
                            enabled: true
                        },
                        animations: {
                            enabled: true,
                            speed: 600
                        }
                    },
                    series: [{
                        data: series
                    }],
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0,
                            stops: [0, 100]
                        }
                    },
                    colors: [rising ? '#10B981' : '#F43F5E'],
                    tooltip: {
                        enabled: false
                    }
                });
                chartRenderPromises.push(chart.render());
                track(chart);
            });

            /* ---------- Section 3: Simple keyword-wise ranking progress ---------- */
            (function() {
                const el = document.getElementById('keywordRankingChart');
                if (!el) return;
                const months = JSON.parse(el.getAttribute('data-months') || '[]');
                const dates = JSON.parse(el.getAttribute('data-dates') || '[]');
                const series = JSON.parse(el.getAttribute('data-series') || '[]');
                const colors = series.map((item, index) => {
                    const hue = Math.round((index * 137.508 + 215) % 360);
                    return 'hsl(' + hue + ', 72%, 50%)';
                });

                const allRanks = series
                    .flatMap(item => item.data)
                    .filter(value => value !== null && value !== undefined && value !== '');
                const worstRank = allRanks.length ? Math.max(...allRanks) : 100;
                const chartMax = Math.max(10, Math.ceil(worstRank / 10) * 10);

                const chart = new ApexCharts(el, {
                    chart: chartShell('line', 400, {
                        stacked: false
                    }),
                    series: series,
                    colors: colors,
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: 5,
                        strokeWidth: 2,
                        strokeColors: '#ffffff',
                        hover: {
                            size: 7
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    grid: sharedGrid,
                    legend: Object.assign({}, sharedLegend, {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        onItemClick: {
                            toggleDataSeries: true
                        },
                        onItemHover: {
                            highlightDataSeries: true
                        }
                    }),
                    xaxis: Object.assign({
                        categories: months,
                        title: {
                            text: 'SEO Service Month',
                            style: {
                                color: axisColor()
                            }
                        },
                        tooltip: {
                            enabled: false
                        }
                    }, axisLabelStyle()),
                    yaxis: Object.assign({
                        reversed: false,
                        min: 1,
                        max: chartMax,
                        forceNiceScale: true,
                        tickAmount: Math.min(10, chartMax - 1),
                        decimalsInFloat: 0,
                        title: {
                            text: 'Google Rank Number (Lower = Better)',
                            style: {
                                color: axisColor()
                            }
                        },
                        labels: {
                            formatter: value => Math.round(value),
                            style: {
                                colors: axisColor()
                            }
                        }
                    }, axisLabelStyle()),
                    tooltip: {
                        shared: false,
                        intersect: true,
                        theme: document.querySelector('.seo-report')?.getAttribute('data-theme') ===
                            'dark' ? 'dark' : 'light',
                        x: {
                            formatter: function(value, context) {
                                const index = context.dataPointIndex;
                                const date = dates[index] ? ' (' + dates[index] + ')' : '';
                                return months[index] + date;
                            }
                        },
                        y: {
                            formatter: value => value === null || value === undefined ? 'No data' :
                                'Rank ' + value,
                            title: {
                                formatter: seriesName => seriesName + ': '
                            }
                        }
                    },
                    noData: {
                        text: 'No keyword ranking data available',
                        align: 'center',
                        verticalAlign: 'middle'
                    }
                });
                chartRenderPromises.push(chart.render());
                track(chart);
            })();

            /* ---------- Section 5 & 6: Area ranking / State Group progress ---------- */
            function buildLocationChart(containerId, trendChipId) {
                const el = document.getElementById(containerId);
                if (!el) return;
                const isStateGroupChart = el.hasAttribute('data-state-group-chart');
                const chartData = JSON.parse(el.getAttribute('data-chart') || '{}');
                const months = Array.isArray(chartData.categories) ? chartData.categories : [];
                const series = Array.isArray(chartData.series) ? chartData.series : [];
                if (!months.length || !series.length) return;

                // Golden-angle hue spacing keeps every line visually distinct.
                const colors = series.map((item, index) => {
                    const hue = Math.round((index * 137.508 + (isStateGroupChart ? 28 : 0)) % 360);
                    return 'hsl(' + hue + ', 72%, 50%)';
                });

                // Real best / worst / average markers computed from the actual ranking values
                const allRankings = series
                    .flatMap(item => item.data)
                    .filter(value => value !== null && value !== undefined && value !== '');
                const best = allRankings.length ? Math.min(...allRankings) : null;
                const worst = allRankings.length ? Math.max(...allRankings) : null;
                const avg = allRankings.length ? Math.round(allRankings.reduce((a, b) => a + b, 0) / allRankings
                    .length) : null;

                // Compare each state's first and latest available values without shifting missing months.
                const firstMonthAvgSet = series
                    .map(item => item.data.find(value => value !== null && value !== undefined && value !== ''))
                    .filter(value => value !== undefined);
                const lastMonthAvgSet = series
                    .map(item => [...item.data].reverse().find(value => value !== null && value !== undefined &&
                        value !== ''))
                    .filter(value => value !== undefined);
                const chip = document.getElementById(trendChipId);
                if (chip && firstMonthAvgSet.length && lastMonthAvgSet.length) {
                    const firstAvg = firstMonthAvgSet.reduce((a, b) => a + b, 0) / firstMonthAvgSet.length;
                    const lastAvg = lastMonthAvgSet.reduce((a, b) => a + b, 0) / lastMonthAvgSet.length;
                    const difference = Math.round(lastAvg - firstAvg);
                    const improved = isStateGroupChart ? difference : -difference;
                    chip.style.display = 'inline-flex';
                    chip.classList.toggle('is-down', improved < 0);
                    if (isStateGroupChart) {
                        chip.innerHTML = '<i class="fa-solid fa-arrow-' + (difference >= 0 ? 'up' : 'down') +
                            '"></i> ' +
                            Math.abs(difference) + ' value ' + (difference >= 0 ? 'increased' : 'decreased');
                    } else {
                        chip.innerHTML = '<i class="fa-solid fa-arrow-' + (improved >= 0 ? 'up' : 'down') +
                            '"></i> ' +
                            Math.abs(improved) + ' position' + (Math.abs(improved) === 1 ? '' : 's') + (improved >=
                                0 ? ' improved' : ' dropped');
                    }
                }

                const annotations = {
                    yaxis: []
                };
                if (avg !== null) {
                    annotations.yaxis.push({
                        y: avg,
                        borderColor: '#94A3B8',
                        strokeDashArray: 4,
                        label: {
                            text: 'Average: ' + avg,
                            style: {
                                background: '#94A3B8',
                                color: '#fff',
                                fontSize: '10px'
                            }
                        }
                    });
                }
                if (best !== null) {
                    annotations.yaxis.push({
                        y: isStateGroupChart ? worst : best,
                        borderColor: '#10B981',
                        strokeDashArray: 0,
                        label: {
                            text: (isStateGroupChart ? 'Highest: ' + worst : 'Best: ' + best),
                            style: {
                                background: '#10B981',
                                color: '#fff',
                                fontSize: '10px'
                            },
                            position: 'left'
                        }
                    });
                }
                if (worst !== null && worst !== best) {
                    annotations.yaxis.push({
                        y: isStateGroupChart ? best : worst,
                        borderColor: '#F43F5E',
                        strokeDashArray: 0,
                        label: {
                            text: (isStateGroupChart ? 'Lowest: ' + best : 'Worst: ' + worst),
                            style: {
                                background: '#F43F5E',
                                color: '#fff',
                                fontSize: '10px'
                            },
                            position: 'left'
                        }
                    });
                }

                const legendRows = Math.ceil(series.length / 4);
                const chartHeight = Math.min(680, Math.max(360, 320 + Math.max(0, legendRows - 2) * 24));
                el.style.height = chartHeight + 'px';

                const chart = new ApexCharts(el, {
                    chart: chartShell('line', chartHeight),
                    series: series,
                    colors: colors,
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: series.length > 12 ? 2 : 4,
                        strokeWidth: 0,
                        hover: {
                            size: 7
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    grid: sharedGrid,
                    legend: Object.assign({}, sharedLegend, {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        itemMargin: {
                            horizontal: 10,
                            vertical: 6
                        },
                        onItemClick: {
                            toggleDataSeries: true
                        },
                        onItemHover: {
                            highlightDataSeries: true
                        }
                    }),
                    xaxis: Object.assign({
                        categories: months
                    }, axisLabelStyle()),
                    yaxis: Object.assign({
                        reversed: !isStateGroupChart,
                        min: isStateGroupChart ? 0 : 1,
                        forceNiceScale: true,
                        title: {
                            text: isStateGroupChart ? 'Monthly Value' : 'Ranking Position',
                            style: {
                                color: axisColor()
                            }
                        }
                    }, axisLabelStyle()),
                    tooltip: Object.assign({}, sharedTooltip, {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: value => value === null || value === undefined ?
                                'No data' :
                                (isStateGroupChart ? value : 'Rank ' + value)
                        }
                    }),
                    noData: {
                        text: isStateGroupChart ? 'No progress data available' :
                            'No ranking data available',
                        align: 'center',
                        verticalAlign: 'middle'
                    },
                    annotations: annotations
                });
                chartRenderPromises.push(chart.render());
                track(chart);
            }

            buildLocationChart('areaRankChart', 'areaTrendChip');

            document.querySelectorAll('[data-state-group-chart]').forEach(function(chartElement) {
                buildLocationChart(
                    chartElement.id,
                    chartElement.getAttribute('data-trend-chip')
                );
            });

            /* ---------- Section 7: Backlink radial analytics (High / Medium / Low DA / Pending) ---------- */
            (function() {
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
                            hollow: {
                                size: '38%'
                            },
                            track: {
                                background: gridColor()
                            },
                            dataLabels: {
                                show: false
                            }
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    legend: Object.assign({}, sharedLegend, {
                        show: true,
                        position: 'bottom'
                    }),
                    tooltip: Object.assign({}, sharedTooltip, {
                        y: {
                            formatter: v => v + '%'
                        }
                    })
                });
                chartRenderPromises.push(chart.render());
                track(chart);
            })();

            /* ---------- Section 7B: Backlink growth — glow area + moving average + target/forecast ---------- */
            (function() {
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
                    chart: chartShell('area', 340, {
                        dropShadow: {
                            enabled: true,
                            top: 4,
                            left: 0,
                            blur: 6,
                            opacity: 0.25,
                            color: '#4F46E5'
                        }
                    }),
                    series: [{
                            name: 'Total Backlinks',
                            data: series.concat([null])
                        },
                        {
                            name: 'Forecast',
                            data: forecastSeries
                        },
                        {
                            name: '3‑Month Avg',
                            data: movingAverage.concat([null])
                        }
                    ],
                    colors: ['#4F46E5', '#06B6D4', '#94A3B8'],
                    stroke: {
                        curve: 'smooth',
                        width: [3, 2, 2],
                        dashArray: [0, 6, 4]
                    },
                    fill: {
                        type: ['gradient', 'solid', 'solid'],
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0,
                            stops: [0, 100]
                        }
                    },
                    markers: {
                        size: [4, 5, 0],
                        strokeWidth: 0,
                        hover: {
                            size: 7
                        },
                        discrete: [{
                            seriesIndex: 0,
                            dataPointIndex: series.length - 1,
                            size: 7,
                            strokeWidth: 3,
                            strokeColor: '#4F46E5',
                            fillColor: '#fff'
                        }]
                    },
                    dataLabels: {
                        enabled: false
                    },
                    grid: sharedGrid,
                    legend: Object.assign({}, sharedLegend, {
                        position: 'bottom'
                    }),
                    xaxis: Object.assign({
                        categories: forecastLabels
                    }, axisLabelStyle()),
                    yaxis: Object.assign({
                        title: {
                            text: 'Cumulative Backlinks',
                            style: {
                                color: axisColor()
                            }
                        },
                        min: 0
                    }, axisLabelStyle()),
                    tooltip: sharedTooltip
                });
                chartRenderPromises.push(chart.render());
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
                            hollow: {
                                size: '58%'
                            },
                            track: {
                                background: gridColor()
                            },
                            dataLabels: {
                                name: {
                                    show: true,
                                    fontSize: '11px',
                                    color: axisColor(),
                                    offsetY: -6
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 800,
                                    color: axisColor(),
                                    offsetY: 6,
                                    formatter: v => v + '%'
                                }
                            }
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    labels: ['Complete']
                });
                chartRenderPromises.push(chart.render());
                track(chart);
            });

            /* ---------- Section 11: Monthly growth (visibility score) — glow area chart ---------- */
            (function() {
                const el = document.getElementById('monthlyGrowthChart');
                if (!el) return;
                const series = JSON.parse(el.getAttribute('data-series') || '[]');
                if (series.length < 2) return;

                const chart = new ApexCharts(el, {
                    chart: chartShell('area', 340, {
                        dropShadow: {
                            enabled: true,
                            top: 4,
                            left: 0,
                            blur: 6,
                            opacity: 0.25,
                            color: '#4F46E5'
                        }
                    }),
                    series: [{
                        name: 'Visibility Score',
                        data: series
                    }],
                    colors: ['#4F46E5'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0,
                            stops: [0, 100]
                        }
                    },
                    markers: {
                        size: 4,
                        strokeWidth: 0,
                        hover: {
                            size: 7
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    grid: sharedGrid,
                    legend: Object.assign({}, sharedLegend, {
                        show: false
                    }),
                    xaxis: axisLabelStyle(),
                    yaxis: Object.assign({
                        min: 0,
                        max: 100,
                        title: {
                            text: 'Visibility Score',
                            style: {
                                color: axisColor()
                            }
                        }
                    }, axisLabelStyle()),
                    tooltip: sharedTooltip
                });
                chartRenderPromises.push(chart.render());
                track(chart);
            })();

        });
    </script>
@endpush




