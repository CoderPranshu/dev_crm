@extends('index')

@push('title', get_phrase('Special Days Calendar'))

@section('content')

@php
    $today = now('Asia/Kolkata')->startOfDay();

    $categoryColors = [
        'festival'      => '#1498a8',
        'national'      => '#252525',
        'international' => '#087f8c',
        'health'        => '#e05252',
        'environment'   => '#29966f',
        'education'     => '#167f9c',
        'awareness'     => '#d05f88',
        'professional'  => '#3d4648',
        'general'       => '#687174',
    ];
@endphp

<style>
    .special-days-page {
        --sd-primary: #1498a8;
        --sd-primary-dark: #087f8c;
        --sd-dark: #252525;
        --sd-charcoal: #343434;
        --sd-muted: #687174;
        --sd-border: #dfecee;
        --sd-light: #eef9fa;
        --sd-bg: #f5f9fa;
    }

    .special-days-page .page-heading {
        margin-bottom: 24px;
    }

    .special-days-page .page-heading h4 {
        color: var(--sd-dark);
        font-weight: 700;
        margin-bottom: 5px;
    }

    .special-days-page .page-heading p {
        color: var(--sd-muted);
        margin: 0;
    }

    .today-card {
        position: relative;
        overflow: hidden;
        min-height: 220px;
        padding: 28px;
        border: 0;
        border-radius: 22px;
        color: #fff;
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, .18), transparent 34%),
            linear-gradient(135deg, #202020 0%, #343434 46%, #1498a8 100%);
        box-shadow: 0 18px 45px rgba(20, 152, 168, .20);
    }

    .today-card::before {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        top: -85px;
        right: 100px;
        border-radius: 50%;
        background: rgba(20, 152, 168, .22);
    }

    .today-card::after {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        right: -85px;
        bottom: -115px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
    }

    .today-label {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        padding: 7px 13px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 30px;
        background: rgba(20, 152, 168, .28);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .6px;
        text-transform: uppercase;
    }

    .today-card h2 {
        position: relative;
        z-index: 2;
        max-width: 750px;
        margin-bottom: 10px;
        color: #fff;
        font-size: 31px;
        font-weight: 700;
    }

    .today-date,
    .today-card .today-description {
        position: relative;
        z-index: 2;
        color: rgba(255, 255, 255, .82);
    }

    .today-date {
        font-size: 15px;
    }

    .occasion-tags {
        position: relative;
        z-index: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }

    .occasion-tag {
        display: inline-flex;
        padding: 7px 11px;
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 10px;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
    }

    .empty-today {
        position: relative;
        z-index: 2;
        max-width: 600px;
    }

    .empty-today h2 {
        font-size: 27px;
    }

    .next-highlight {
        height: 100%;
        padding: 24px;
        border: 1px solid var(--sd-border);
        border-top: 4px solid var(--sd-primary);
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 12px 35px rgba(20, 152, 168, .08);
    }

    .next-highlight .small-label {
        color: var(--sd-primary);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .7px;
        text-transform: uppercase;
    }

    .next-highlight .countdown {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 64px;
        height: 64px;
        padding: 0 12px;
        margin: 20px 0;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(135deg, #087f8c, #17a4b4);
        box-shadow: 0 10px 20px rgba(20, 152, 168, .22);
        font-size: 24px;
        font-weight: 800;
    }

    .next-highlight h5 {
        color: var(--sd-dark);
        font-weight: 700;
    }

    .section-card {
        overflow: hidden;
        margin-top: 24px;
        border: 1px solid var(--sd-border);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(32, 32, 32, .05);
    }

    .section-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--sd-border);
        background: linear-gradient(90deg, #fff 0%, #f1fafb 100%);
    }

    .section-card-header h5 {
        margin: 0;
        color: var(--sd-dark);
        font-weight: 700;
    }

    .section-card-header span {
        color: var(--sd-muted);
        font-size: 13px;
    }

    .upcoming-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(215px, 1fr));
        gap: 15px;
        padding: 20px;
    }

    .occasion-card {
        position: relative;
        padding: 18px;
        border: 1px solid var(--sd-border);
        border-radius: 16px;
        background: #fff;
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    .occasion-card:hover {
        transform: translateY(-3px);
        border-color: var(--sd-primary);
        box-shadow: 0 12px 30px rgba(20, 152, 168, .12);
    }

    .occasion-card .category-line {
        width: 38px;
        height: 4px;
        margin-bottom: 16px;
        border-radius: 20px;
    }

    .occasion-card h6 {
        min-height: 42px;
        margin-bottom: 7px;
        color: var(--sd-dark);
        font-weight: 700;
        line-height: 1.4;
    }

    .occasion-date {
        color: var(--sd-muted);
        font-size: 13px;
    }

    .days-left,
    .major-badge {
        display: inline-block;
        padding: 5px 9px;
        margin-top: 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .days-left {
        color: var(--sd-primary-dark);
        background: #e5f7f9;
    }

    .major-badge {
        color: #b42318;
        background: #fee4e2;
    }

    .special-days-table {
        margin: 0;
    }

    .special-days-table th {
        padding: 14px 20px;
        border-bottom: 1px solid var(--sd-border);
        color: #475254;
        background: #f1f8f9;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .special-days-table td {
        padding: 15px 20px;
        border-color: var(--sd-border);
        vertical-align: middle;
    }

    .special-days-table tbody tr:hover {
        background: #f4fbfc;
    }

    .date-box {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 150px;
    }

    .date-number {
        display: flex;
        flex: 0 0 45px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 48px;
        border-radius: 12px;
        color: var(--sd-primary-dark);
        background: #e5f7f9;
        font-size: 17px;
        font-weight: 800;
        line-height: 1;
    }

    .date-number small {
        margin-top: 4px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        color: var(--sd-charcoal);
        background: #eef4f5;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .category-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    #days-filter {
        min-width: 155px;
        color: var(--sd-dark);
        border-color: #cce4e7;
        border-radius: 10px;
        background-color: #fff;
        font-weight: 600;
    }

    #days-filter:focus {
        border-color: var(--sd-primary);
        box-shadow: 0 0 0 .2rem rgba(20, 152, 168, .15);
    }

    .no-events {
        padding: 35px 20px;
        color: var(--sd-muted);
        text-align: center;
    }

    @media (max-width: 767.98px) {
        .today-card {
            min-height: auto;
            padding: 23px;
        }

        .today-card h2 {
            font-size: 24px;
        }

        .section-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .section-card-header form,
        #days-filter {
            width: 100%;
        }

        .upcoming-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="special-days-page">
    <div class="page-heading">
        <h4>Festival &amp; Special Day Reminder</h4>
        <p>Today’s occasion and upcoming creative opportunities.</p>
    </div>

    <div class="row g-4">
        <div class="col-xl-8 col-lg-7">
            <div class="today-card">
                <div class="today-label">Today’s Occasion</div>

                @if($todayDays->isNotEmpty())
                    <h2>{{ $todayDays->pluck('title')->join(' • ') }}</h2>

                    <div class="today-date">
                        {{ $today->format('l, d F Y') }}
                    </div>

                    <div class="occasion-tags">
                        @foreach($todayDays as $day)
                            <span class="occasion-tag">
                                {{ \Illuminate\Support\Str::headline($day->category) }}
                            </span>

                            @if($day->is_major)
                                <span class="occasion-tag">Important Creative</span>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="empty-today">
                        <h2>No major occasion today</h2>

                        <div class="today-date">
                            {{ $today->format('l, d F Y') }}
                        </div>

                        <p class="today-description mt-3 mb-0">
                            Check the upcoming section to prepare creatives in advance.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="next-highlight">
                <div class="small-label">Next Occasion</div>

                @if($nextOccasion)
                    @php
                        $nextDaysCount = $today->diffInDays($nextOccasion->occasion_date);
                    @endphp

                    <div class="countdown">{{ $nextDaysCount }}</div>
                    <h5>{{ $nextOccasion->title }}</h5>

                    <p class="text-muted mb-1">
                        {{ $nextOccasion->occasion_date->format('l, d F Y') }}
                    </p>

                    <small class="text-muted">
                        {{ $nextDaysCount === 1 ? 'Tomorrow' : $nextDaysCount.' days remaining' }}
                    </small>
                @else
                    <div class="py-4">
                        <h5>No upcoming occasion</h5>
                        <p class="text-muted mb-0">
                            No special day found in the next 365 days.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-card-header">
            <div>
                <h5>Upcoming 7 Days</h5>
                <span>Prepare upcoming creatives in advance</span>
            </div>
        </div>

        @if($nextSevenDays->isNotEmpty())
            <div class="upcoming-grid">
                @foreach($nextSevenDays as $day)
                    @php
                        $daysRemaining = $today->diffInDays($day->occasion_date);
                        $categoryColor = $categoryColors[$day->category] ?? '#687174';
                    @endphp

                    <div class="occasion-card">
                        <div class="category-line" style="background: {{ $categoryColor }};"></div>
                        <h6>{{ $day->title }}</h6>

                        <div class="occasion-date">
                            {{ $day->occasion_date->format('D, d M Y') }}
                        </div>

                        <span class="days-left">
                            {{ $daysRemaining === 1 ? 'Tomorrow' : $daysRemaining.' days left' }}
                        </span>

                        @if($day->is_major)
                            <br>
                            <span class="major-badge">Important</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">
                No occasion is scheduled in the next 7 days.
            </div>
        @endif
    </div>

    <div class="section-card">
        <div class="section-card-header">
            <div>
                <h5>Upcoming {{ $filterDays }} Days</h5>
                <span>{{ $filteredUpcomingDays->count() }} occasions found</span>
            </div>

            <form
                method="GET"
                action="{{ route('admin.special-days.index') }}"
                class="d-flex align-items-center gap-2"
            >
                <label for="days-filter" class="text-muted small mb-0">
                    Show:
                </label>

                <select
                    name="days"
                    id="days-filter"
                    class="form-select form-select-sm"
                    onchange="this.form.submit()"
                >
                    @foreach($allowedDays as $days)
                        <option
                            value="{{ $days }}"
                            {{ $filterDays === $days ? 'selected' : '' }}
                        >
                            Next {{ $days }} Days
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($filteredUpcomingDays->isNotEmpty())
            <div class="table-responsive">
                <table class="table special-days-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Occasion</th>
                            <th>Category</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($filteredUpcomingDays as $day)
                            @php
                                $daysRemaining = $today->diffInDays($day->occasion_date);
                                $categoryColor = $categoryColors[$day->category] ?? '#687174';
                            @endphp

                            <tr>
                                <td>
                                    <div class="date-box">
                                        <div class="date-number">
                                            {{ $day->occasion_date->format('d') }}
                                            <small>{{ $day->occasion_date->format('M') }}</small>
                                        </div>

                                        <div>
                                            <span class="text-muted d-block">
                                                {{ $day->occasion_date->format('l') }}
                                            </span>
                                            <small class="text-muted">
                                                {{ $day->occasion_date->format('Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <strong>{{ $day->title }}</strong>

                                    @if($day->is_major)
                                        <span class="major-badge ms-2">Important</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="category-badge">
                                        <span
                                            class="category-dot"
                                            style="background: {{ $categoryColor }};"
                                        ></span>
                                        {{ \Illuminate\Support\Str::headline($day->category) }}
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        {{ $daysRemaining === 1 ? 'Tomorrow' : $daysRemaining.' days' }}
                                    </strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-events">
                No occasion found in the next {{ $filterDays }} days.
            </div>
        @endif
    </div>
</div>

@endsection









