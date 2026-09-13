@extends('index')

@push('title', get_phrase('SEO Audit Overview'))

@push('css')
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Google Fonts (optional — Inter pairs well with the "premium SaaS" look) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


<style>
.cs-audit-overview .cs-section-title{
        font-size: 26px;
        font-weight: 700;
        color: #1F2937;
        letter-spacing: -.01em;
    }
    .cs-audit-overview .cs-section-subtitle{
        font-size: 14px;
        color: #64748B;
    }

    .cs-card{
        background: #FFFFFF;
        border: 1px solid #EEF2F6;
        border-radius: 22px;
        padding: 30px;
        box-shadow: 0 20px 60px rgba(15,23,42,.06);
    }

    /* ---- Audit Cards (On-Page / Off-Page / Technical) ---- */
    .cs-audit-card-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom: 22px;
    }
    .cs-icon-circle{
        width:44px;
        height:44px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:16px;
        flex-shrink:0;
    }
    .cs-icon-circle-primary{
        background: rgba(15,142,163,.10);
        color:#0F8EA3;
    }
    .cs-audit-card-title{
        font-size:16px;
        font-weight:700;
        color:#1F2937;
    }
    .cs-audit-card-desc{
        font-size:13px;
        color:#64748B;
    }

    .cs-audit-score-wrap{
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        text-align:center;
        padding: 10px 0 26px;
    }
    .cs-radial-chart{
        width:140px;
        height:140px;
    }
    .cs-audit-score-caption{
        display:flex;
        flex-direction:column;
        margin-top:6px;
    }
    .cs-audit-score-value{
        font-size:20px;
        font-weight:700;
        color:#1F2937;
    }
    .cs-audit-score-label{
        font-size:12px;
        color:#64748B;
    }

    .cs-checklist{
        list-style:none;
        margin:0;
        padding:0;
    }
    .cs-checklist-row{
        display:flex;
        align-items:center;
        gap:14px;
        padding: 12px 0;
        border-bottom: 1px solid #F1F4F8;
    }
    .cs-checklist-row-last{
        border-bottom:none;
        padding-bottom:0;
    }
    .cs-checklist-name{
        display:flex;
        align-items:center;
        gap:10px;
        font-size:13.5px;
        font-weight:600;
        color:#1F2937;
        flex: 0 0 42%;
    }
    .cs-status-icon{ font-size:14px; }
    .cs-status-green{ color:#22C55E; }
    .cs-status-teal{ color:#0F8EA3; }
    .cs-status-orange{ color:#F59E0B; }
    .cs-status-red{ color:#EF4444; }

    .cs-checklist-progress{ flex: 1 1 auto; }
    .cs-progress{
        height:12px;
        border-radius:999px;
        background:#F1F4F8;
        overflow:hidden;
    }
    .cs-progress-bar{
        height:100%;
        border-radius:999px;
        width:0%;
    }
    .cs-bar-green{ background:#22C55E; }
    .cs-bar-teal{ background:#0F8EA3; }
    .cs-bar-orange{ background:#F59E0B; }
    .cs-bar-red{ background:#EF4444; }

    .cs-checklist-percent{
        flex: 0 0 40px;
        text-align:right;
        font-size:13px;
        font-weight:700;
        color:#1F2937;
    }

    /* ---- Website Health Matrix ---- */
    .cs-health-matrix-header{ margin-bottom: 8px; }
    .cs-health-metric{
        border:1px solid #EEF2F6;
        border-radius:18px;
        padding:22px 18px;
        text-align:center;
        height:100%;
        position:relative;
    }
    .cs-health-metric-chart{
        width:84px;
        height:84px;
        margin:0 auto 14px;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .cs-health-metric-icon{
        font-size:13px;
        color:#0F8EA3;
        margin-bottom:6px;
    }
    .cs-health-metric-name{
        font-size:14px;
        font-weight:700;
        color:#1F2937;
        margin-bottom:8px;
    }
    .cs-health-metric-desc{
        font-size:12px;
        color:#64748B;
        margin: 8px 0 0;
    }

    .cs-badge{
        display:inline-block;
        font-size:11px;
        font-weight:700;
        padding:4px 12px;
        border-radius:999px;
        text-transform:capitalize;
    }
    .cs-badge-excellent{ background:rgba(34,197,94,.12); color:#22C55E; }
    .cs-badge-good{ background:rgba(15,142,163,.12); color:#0F8EA3; }
    .cs-badge-average{ background:rgba(245,158,11,.14); color:#F59E0B; }
    .cs-badge-poor{ background:rgba(239,68,68,.12); color:#EF4444; }
    .cs-badge-neutral{ background:#F1F4F8; color:#64748B; }

    /* ---- Recommendations Timeline ---- */
    .cs-priority-filter .cs-select{
        border-radius:12px;
        border:1px solid #EEF2F6;
        font-size:13px;
        padding: 8px 14px;
        color:#1F2937;
        min-width:160px;
    }

    .cs-timeline{
        margin-top: 12px;
        position:relative;
    }
    .cs-timeline-item{
        display:flex;
        gap:18px;
        padding: 20px 0;
        border-bottom:1px solid #F1F4F8;
    }
    .cs-timeline-item:last-child{
        border-bottom:none;
        padding-bottom:0;
    }
    .cs-timeline-marker{
        flex: 0 0 44px;
        height:44px;
        border-radius:50%;
        background: rgba(15,142,163,.10);
        color:#0F8EA3;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:16px;
    }
    .cs-timeline-content{ flex:1 1 auto; }
    .cs-timeline-top{
        display:flex;
        gap:8px;
        margin-bottom:8px;
    }
    .cs-timeline-title{
        font-size:15px;
        font-weight:700;
        color:#1F2937;
        margin-bottom:4px;
    }
    .cs-timeline-desc{
        font-size:13px;
        color:#64748B;
        margin-bottom:10px;
    }
    .cs-timeline-meta{
        display:flex;
        flex-wrap:wrap;
        gap:18px;
        font-size:12.5px;
        color:#64748B;
        font-weight:600;
    }
    .cs-timeline-meta i{ color:#0F8EA3; margin-right:4px; }

    .cs-badge-priority-critical{ background:rgba(239,68,68,.12); color:#EF4444; }
    .cs-badge-priority-high{ background:rgba(245,158,11,.14); color:#F59E0B; }
    .cs-badge-priority-medium{ background:rgba(15,142,163,.12); color:#0F8EA3; }
    .cs-badge-priority-low{ background:#F1F4F8; color:#64748B; }

    .cs-badge-status-completed{ background:rgba(34,197,94,.12); color:#22C55E; }
    .cs-badge-status-pending{ background:#F1F4F8; color:#64748B; }
    .cs-badge-status-in-progress{ background:rgba(15,142,163,.12); color:#0F8EA3; }

    /* ---- Responsive ---- */
    @media (max-width: 991.98px){
        .cs-card{ padding:24px; }
    }
    @media (max-width: 575.98px){
        .cs-checklist-row{ flex-wrap:wrap; }
        .cs-checklist-name{ flex: 0 0 100%; margin-bottom:6px; }
        .cs-checklist-percent{ text-align:left; }
    }
</style>
@endpush

@push('js')
{{-- ================= JS ================= --}}

<!-- Bootstrap 5.3 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ApexCharts (for onPageScoreChart, offPageScoreChart, technicalSeoChart, seoHealthGauge, keywordGrowthChart, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>

<!-- GSAP (for gsap-fade-up, gsap-slide-up, stagger-animation, chart-reveal, animate-progress) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<!-- CountUp.js (for countup-ready number counters) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ---------------------------------------------------------------
        // Shared radial score chart renderer
        // (On-Page / Off-Page / Technical SEO score rings)
        // ---------------------------------------------------------------
        function renderScoreRing(elementId, score, color) {
            var el = document.querySelector('#' + elementId);
            if (!el || typeof ApexCharts === 'undefined') return;

            var options = {
                chart: {
                    type: 'radialBar',
                    height: 140,
                    sparkline: { enabled: true }
                },
                series: [score],
                colors: [color],
                plotOptions: {
                    radialBar: {
                        hollow: { size: '68%' },
                        track: {
                            background: '#F1F4F8',
                            strokeWidth: '100%'
                        },
                        dataLabels: {
                            show: true,
                            name: { show: false },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                color: '#1F2937',
                                offsetY: 8,
                                formatter: function (val) { return val + '%'; }
                            }
                        }
                    }
                },
                stroke: { lineCap: 'round' }
            };

            new ApexCharts(el, options).render();
        }

        renderScoreRing('onPageScoreChart', {{ $onPageScore ?? 0 }}, '#0F8EA3');
        renderScoreRing('offPageScoreChart', {{ $offPageScore ?? 0 }}, '#0F8EA3');
        renderScoreRing('technicalSeoChart', {{ $technicalSeoScore ?? 0 }}, '#0F8EA3');

        // ---------------------------------------------------------------
        // Website Health Matrix — mini circular progress per metric
        // ---------------------------------------------------------------
        @foreach (($healthMetrics ?? []) as $index => $metric)
            renderScoreRing('healthMetricChart{{ $index }}', {{ (int) $metric['value'] }}, '#0F8EA3');
        @endforeach

    });
</script>
@endpush

@section('content')

{{-- ==================================================================
     SECTION: SEO Audit Overview
     Chunk 3 — On-Page / Off-Page / Technical SEO, Website Health Matrix,
     SEO Recommendations. Pure frontend. No JS. No ApexCharts config.
     Backend variables (if already defined by the controller) are used
     as-is below; nothing here is hardcoded in place of a real variable.
     ================================================================== --}}

<section class="cs-audit-overview" style="margin-top:48px; margin-bottom:30px;">

    {{-- ---------- Section Heading ---------- --}}
    <div class="d-flex flex-column mb-4 gsap-fade-up">
        <h2 class="cs-section-title mb-1">SEO Audit Overview</h2>
        <p class="cs-section-subtitle mb-0">
            Monitor every important SEO optimization area with live audit progress and actionable insights.
        </p>
    </div>

    {{-- ==================================================================
         ROW 1 — On-Page / Off-Page / Technical SEO (3 equal-height cards)
         ================================================================== --}}
    <div class="row g-4 align-items-stretch">

        {{-- ---------------- CARD 1: On-Page SEO ---------------- --}}
        <div class="col-12 col-md-6 col-xl-4 d-flex">
            <div class="cs-card cs-audit-card w-100 gsap-fade-up">

                <div class="cs-audit-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <span class="cs-icon-circle cs-icon-circle-primary">
                            <i class="fa-solid fa-file-lines"></i>
                        </span>
                        <div>
                            <h5 class="cs-audit-card-title mb-0">On-Page SEO</h5>
                            <p class="cs-audit-card-desc mb-0">Content &amp; structural optimization signals</p>
                        </div>
                    </div>
                </div>

                <div class="cs-audit-score-wrap chart-reveal">
                    <div id="onPageScoreChart" class="cs-radial-chart"></div>
                    <div class="cs-audit-score-caption">
                        <span class="cs-audit-score-value">{{ $onPageScore ?? '' }}</span>
                        <span class="cs-audit-score-label">Overall Score</span>
                    </div>
                </div>

                <ul class="cs-checklist stagger-animation">

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Title Tags</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $titleTagsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $titleTagsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-teal"></i>
                            <span>Meta Description</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-teal animate-progress" style="width: {{ $metaDescriptionScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $metaDescriptionScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Heading Structure</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $headingStructureScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $headingStructureScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-triangle-exclamation cs-status-icon cs-status-orange"></i>
                            <span>Image ALT Tags</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-orange animate-progress" style="width: {{ $imageAltTagsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $imageAltTagsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-teal"></i>
                            <span>Internal Linking</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-teal animate-progress" style="width: {{ $internalLinkingScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $internalLinkingScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-xmark cs-status-icon cs-status-red"></i>
                            <span>Keyword Density</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-red animate-progress" style="width: {{ $keywordDensityScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $keywordDensityScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>URL Structure</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $urlStructureScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $urlStructureScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row cs-checklist-row-last">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-triangle-exclamation cs-status-icon cs-status-orange"></i>
                            <span>Canonical URL</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-orange animate-progress" style="width: {{ $canonicalUrlScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $canonicalUrlScore ?? 0 }}%</span>
                    </li>

                </ul>
            </div>
        </div>

        {{-- ---------------- CARD 2: Off-Page SEO ---------------- --}}
        <div class="col-12 col-md-6 col-xl-4 d-flex">
            <div class="cs-card cs-audit-card w-100 gsap-fade-up">

                <div class="cs-audit-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <span class="cs-icon-circle cs-icon-circle-primary">
                            <i class="fa-solid fa-diagram-project"></i>
                        </span>
                        <div>
                            <h5 class="cs-audit-card-title mb-0">Off-Page SEO</h5>
                            <p class="cs-audit-card-desc mb-0">Authority &amp; external trust signals</p>
                        </div>
                    </div>
                </div>

                <div class="cs-audit-score-wrap chart-reveal">
                    <div id="offPageScoreChart" class="cs-radial-chart"></div>
                    <div class="cs-audit-score-caption">
                        <span class="cs-audit-score-value">{{ $offPageScore ?? '' }}</span>
                        <span class="cs-audit-score-label">Overall Score</span>
                    </div>
                </div>

                <ul class="cs-checklist stagger-animation">

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Backlinks Created</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $backlinksCreatedScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $backlinksCreatedScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-teal"></i>
                            <span>High Authority Links</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-teal animate-progress" style="width: {{ $highAuthorityLinksScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $highAuthorityLinksScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-triangle-exclamation cs-status-icon cs-status-orange"></i>
                            <span>Guest Posts</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-orange animate-progress" style="width: {{ $guestPostsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $guestPostsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Business Listings</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $businessListingsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $businessListingsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-teal"></i>
                            <span>Social Signals</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-teal animate-progress" style="width: {{ $socialSignalsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $socialSignalsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-triangle-exclamation cs-status-icon cs-status-orange"></i>
                            <span>Anchor Diversity</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-orange animate-progress" style="width: {{ $anchorDiversityScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $anchorDiversityScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Citation Building</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $citationBuildingScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $citationBuildingScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row cs-checklist-row-last">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-xmark cs-status-icon cs-status-red"></i>
                            <span>Toxic Links</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-red animate-progress" style="width: {{ $toxicLinksScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $toxicLinksScore ?? 0 }}%</span>
                    </li>

                </ul>
            </div>
        </div>

        {{-- ---------------- CARD 3: Technical SEO ---------------- --}}
        <div class="col-12 col-md-6 col-xl-4 d-flex mx-auto">
            <div class="cs-card cs-audit-card w-100 gsap-fade-up">

                <div class="cs-audit-card-header">
                    <div class="d-flex align-items-center gap-3">
                        <span class="cs-icon-circle cs-icon-circle-primary">
                            <i class="fa-solid fa-gauge-high"></i>
                        </span>
                        <div>
                            <h5 class="cs-audit-card-title mb-0">Technical SEO</h5>
                            <p class="cs-audit-card-desc mb-0">Site health &amp; crawl infrastructure</p>
                        </div>
                    </div>
                </div>

                <div class="cs-audit-score-wrap chart-reveal">
                    <div id="technicalSeoChart" class="cs-radial-chart"></div>
                    <div class="cs-audit-score-caption">
                        <span class="cs-audit-score-value">{{ $technicalSeoScore ?? '' }}</span>
                        <span class="cs-audit-score-label">Overall Score</span>
                    </div>
                </div>

                <ul class="cs-checklist stagger-animation">

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Page Speed</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $pageSpeedScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $pageSpeedScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Mobile Friendly</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $mobileFriendlyScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $mobileFriendlyScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-triangle-exclamation cs-status-icon cs-status-orange"></i>
                            <span>Core Web Vitals</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-orange animate-progress" style="width: {{ $coreWebVitalsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $coreWebVitalsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-teal"></i>
                            <span>Structured Data</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-teal animate-progress" style="width: {{ $structuredDataScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $structuredDataScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>Sitemap</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $sitemapScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $sitemapScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-teal"></i>
                            <span>Robots.txt</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-teal animate-progress" style="width: {{ $robotsTxtScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $robotsTxtScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-check cs-status-icon cs-status-green"></i>
                            <span>HTTPS</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-green animate-progress" style="width: {{ $httpsScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $httpsScore ?? 0 }}%</span>
                    </li>

                    <li class="cs-checklist-row cs-checklist-row-last">
                        <div class="cs-checklist-name">
                            <i class="fa-solid fa-circle-xmark cs-status-icon cs-status-red"></i>
                            <span>Broken Links</span>
                        </div>
                        <div class="cs-checklist-progress">
                            <div class="cs-progress">
                                <div class="cs-progress-bar cs-bar-red animate-progress" style="width: {{ $brokenLinksScore ?? 0 }}%"></div>
                            </div>
                        </div>
                        <span class="cs-checklist-percent">{{ $brokenLinksScore ?? 0 }}%</span>
                    </li>

                </ul>
            </div>
        </div>

    </div>

    {{-- ==================================================================
         ROW 2 — Website Health Matrix (Full Width)
         ================================================================== --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="cs-card cs-health-matrix gsap-fade-up" style="min-height:420px;">

                <div class="cs-audit-card-header cs-health-matrix-header">
                    <div>
                        <h5 class="cs-audit-card-title mb-1">Website Health Overview</h5>
                        <p class="cs-audit-card-desc mb-0">Visual summary of every SEO area.</p>
                    </div>
                </div>

                <div class="row g-4 mt-1 stagger-animation">

                    @php
                        $healthMetrics = $healthMetrics ?? [
                            ['name' => 'Performance Score', 'icon' => 'fa-bolt',            'value' => $performanceScore ?? 0,   'status' => $performanceStatus ?? '',   'desc' => 'Core loading & rendering speed'],
                            ['name' => 'Accessibility',      'icon' => 'fa-universal-access','value' => $accessibilityScore ?? 0, 'status' => $accessibilityStatus ?? '', 'desc' => 'Usability for all visitors'],
                            ['name' => 'SEO Score',          'icon' => 'fa-magnifying-glass','value' => $seoHealthScore ?? 0,     'status' => $seoHealthStatus ?? '',     'desc' => 'Overall search readiness'],
                            ['name' => 'Best Practices',     'icon' => 'fa-award',           'value' => $bestPracticesScore ?? 0, 'status' => $bestPracticesStatus ?? '', 'desc' => 'Modern web standards followed'],
                            ['name' => 'Security',           'icon' => 'fa-shield-halved',    'value' => $securityScore ?? 0,      'status' => $securityStatus ?? '',      'desc' => 'Protection against vulnerabilities'],
                            ['name' => 'Indexability',       'icon' => 'fa-list-check',       'value' => $indexabilityScore ?? 0,  'status' => $indexabilityStatus ?? '',  'desc' => 'Pages eligible for indexing'],
                            ['name' => 'Crawlability',       'icon' => 'fa-spider',            'value' => $crawlabilityScore ?? 0,  'status' => $crawlabilityStatus ?? '',  'desc' => 'Ease of discovery by search bots'],
                            ['name' => 'Page Experience',    'icon' => 'fa-mobile-screen',     'value' => $pageExperienceScore ?? 0,'status' => $pageExperienceStatus ?? '','desc' => 'Overall on-site user experience'],
                        ];
                    @endphp

                    @foreach ($healthMetrics as $metric)
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="cs-health-metric">
                                <div class="cs-health-metric-chart chart-reveal" id="healthMetricChart{{ $loop->index }}"></div>
                                <div class="cs-health-metric-icon">
                                    <i class="fa-solid {{ $metric['icon'] }}"></i>
                                </div>
                                <h6 class="cs-health-metric-name">{{ $metric['name'] }}</h6>
                                <span class="cs-badge cs-badge-{{ \Illuminate\Support\Str::slug($metric['status'] ?: 'neutral') }}">
                                    {{ $metric['status'] }}
                                </span>
                                <p class="cs-health-metric-desc">{{ $metric['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    {{-- ==================================================================
         ROW 3 — SEO Recommendations (Full Width)
         ================================================================== --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="cs-card cs-recommendations gsap-fade-up">

                <div class="cs-audit-card-header">
                    <div>
                        <h5 class="cs-audit-card-title mb-1">Recommendations</h5>
                        <p class="cs-audit-card-desc mb-0">Prioritized actions to improve your SEO performance.</p>
                    </div>

                    <div class="cs-priority-filter">
                        <select class="form-select cs-select" aria-label="Filter recommendations by priority">
                            <option selected>All Priorities</option>
                            <option>Critical</option>
                            <option>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                    </div>
                </div>

                <div class="cs-timeline stagger-animation">

                    @forelse (($recommendations ?? []) as $recommendation)
                        <div class="cs-timeline-item">
                            <div class="cs-timeline-marker">
                                <i class="fa-solid {{ $recommendation['icon'] ?? 'fa-lightbulb' }}"></i>
                            </div>
                            <div class="cs-timeline-content">
                                <div class="cs-timeline-top">
                                    <span class="cs-badge cs-badge-priority-{{ \Illuminate\Support\Str::slug($recommendation['priority']) }}">
                                        {{ $recommendation['priority'] }}
                                    </span>
                                    <span class="cs-badge cs-badge-status-{{ \Illuminate\Support\Str::slug($recommendation['status']) }}">
                                        {{ $recommendation['status'] }}
                                    </span>
                                </div>
                                <h6 class="cs-timeline-title">{{ $recommendation['title'] }}</h6>
                                <p class="cs-timeline-desc">{{ $recommendation['description'] }}</p>
                                <div class="cs-timeline-meta">
                                    <span><i class="fa-solid fa-chart-line"></i> Impact: {{ $recommendation['impact'] }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ $recommendation['time'] }}</span>
                                    <span><i class="fa-solid fa-tag"></i> {{ $recommendation['category'] }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Intentionally left for backend-driven recommendation data --}}
                    @endforelse

                </div>
            </div>
        </div>
    </div>

</section>

@endsection