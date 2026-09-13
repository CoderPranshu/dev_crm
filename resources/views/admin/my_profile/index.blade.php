@extends('index')
@push('title', get_phrase('My Profile'))
@push('meta')
@endpush

@push('css')
<style>
    /* ============================================================
       CODE SPARROW · EMPLOYEE PROFILE WORKSPACE
       Design tokens
       ============================================================ */
    :root{
        --cs-primary: #0F8EA3;
        --cs-primary-rgb: 15, 142, 163;
        --cs-secondary: #16B6C8;
        --cs-dark: #1F2937;
        --cs-bg: #F8FAFC;
        --cs-surface: #FFFFFF;
        --cs-border: #E5E7EB;
        --cs-muted: #64748B;
        --cs-success: #15803D;
        --cs-success-bg: #ECFDF3;
        --cs-warning: #B45309;
        --cs-warning-bg: #FFFBEB;
        --cs-danger: #B91C1C;
        --cs-danger-bg: #FEF2F2;
        --cs-radius-sm: 10px;
        --cs-radius: 14px;
        --cs-radius-lg: 18px;
        --cs-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.04);
        --cs-shadow: 0 4px 16px -4px rgba(15, 23, 42, 0.08);
        --cs-shadow-lg: 0 16px 40px -12px rgba(15, 23, 42, 0.16);
        --cs-transition: 180ms cubic-bezier(.4,0,.2,1);
    }

    .cs-workspace{
        color: var(--cs-dark);
        font-feature-settings: "cv11", "ss01";
        -webkit-font-smoothing: antialiased;
    }

    /* ---------------- Hero ---------------- */
    .cs-hero{
        position: relative;
        overflow: hidden;
        background: var(--cs-surface);
        border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius-lg);
        padding: 36px 36px 28px;
        margin-bottom: 20px;
        isolation: isolate;
    }
    .cs-hero::before{
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(520px 220px at 88% -10%, rgba(var(--cs-primary-rgb), 0.10), transparent 70%),
            radial-gradient(360px 180px at 100% 100%, rgba(22, 182, 200, 0.08), transparent 70%);
        pointer-events: none;
        z-index: -1;
    }
    .cs-hero::after{
        /* subtle flight-path arc, referencing the sparrow's trajectory */
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 260px;
        height: 260px;
        border: 1px solid rgba(var(--cs-primary-rgb), 0.14);
        border-radius: 50%;
        pointer-events: none;
        z-index: -1;
    }
    .cs-hero-top{
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }
    .cs-hero-identity{
        display: flex;
        align-items: center;
        gap: 20px;
        min-width: 0;
    }
    .cs-avatar-wrap{
        position: relative;
        flex-shrink: 0;
        width: 88px;
        height: 88px;
    }
    .cs-avatar{
        width: 88px;
        height: 88px;
        border-radius: 22px;
        object-fit: cover;
        border: 1px solid var(--cs-border);
        box-shadow: var(--cs-shadow);
        transition: transform var(--cs-transition);
        display: block;
    }
    .cs-avatar-wrap:hover .cs-avatar{
        transform: scale(1.03);
    }
    .cs-avatar-edit{
        position: absolute;
        inset: 0;
        border-radius: 22px;
        background: rgba(15, 23, 42, 0.55);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .02em;
        opacity: 0;
        cursor: pointer;
        transition: opacity var(--cs-transition);
        border: none;
        padding: 0;
        font-family: inherit;
    }
    .cs-avatar-wrap:hover .cs-avatar-edit{ opacity: 1; }
    .cs-avatar-ring{
        position: absolute;
        top: -4px; left: -4px; right: -4px; bottom: -4px;
        border-radius: 26px;
        border: 1.5px solid rgba(var(--cs-primary-rgb), 0.25);
        pointer-events: none;
    }

    .cs-identity-text{ min-width: 0; }
    .cs-name{
        font-size: 26px;
        font-weight: 650;
        letter-spacing: -0.01em;
        color: var(--cs-dark);
        margin: 0 0 2px;
        line-height: 1.2;
    }
    .cs-designation{
        font-size: 14.5px;
        color: var(--cs-muted);
        margin: 0 0 10px;
    }
    .cs-badges{
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .cs-pill{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .01em;
        background: rgba(var(--cs-primary-rgb), 0.08);
        color: var(--cs-primary);
        border: 1px solid rgba(var(--cs-primary-rgb), 0.16);
    }
    .cs-pill-muted{
        background: #F1F5F9;
        color: var(--cs-muted);
        border-color: var(--cs-border);
    }
    .cs-dot{
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--cs-secondary);
        flex-shrink: 0;
    }

    .cs-hero-actions{
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .cs-btn{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: var(--cs-radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        border: 1px solid var(--cs-border);
        background: var(--cs-surface);
        color: var(--cs-dark);
        cursor: pointer;
        transition: all var(--cs-transition);
        white-space: nowrap;
    }
    .cs-btn:hover{
        border-color: rgba(var(--cs-primary-rgb), 0.35);
        transform: translateY(-1px);
        box-shadow: var(--cs-shadow-sm);
    }
    .cs-btn-primary{
        background: linear-gradient(180deg, var(--cs-secondary), var(--cs-primary));
        border-color: transparent;
        color: #fff;
        box-shadow: 0 6px 16px -6px rgba(var(--cs-primary-rgb), 0.55);
    }
    .cs-btn-primary:hover{
        box-shadow: 0 10px 22px -8px rgba(var(--cs-primary-rgb), 0.6);
        transform: translateY(-1px);
    }
    .cs-btn-primary:disabled{ opacity: .6; cursor: not-allowed; transform: none; }
    .cs-btn i{ font-size: 14px; transition: transform var(--cs-transition); }
    .cs-btn:hover i.bi-arrow-right{ transform: translateX(2px); }

    .cs-hero-meta{
        display: grid;
        grid-template-columns: repeat(4, minmax(0,1fr));
        gap: 0;
        margin-top: 26px;
        padding-top: 22px;
        border-top: 1px solid var(--cs-border);
    }
    .cs-meta-item{
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding-right: 16px;
    }
    .cs-meta-item + .cs-meta-item{
        border-left: 1px solid var(--cs-border);
        padding-left: 16px;
    }
    .cs-meta-icon{
        width: 30px; height: 30px;
        border-radius: 9px;
        background: #F1F5F9;
        color: var(--cs-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .cs-meta-label{
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--cs-muted);
        margin: 0 0 2px;
        font-weight: 600;
    }
    .cs-meta-value{
        font-size: 13.5px;
        font-weight: 550;
        color: var(--cs-dark);
        margin: 0;
        word-break: break-word;
    }
    .cs-meta-empty{ color: #94A3B8; font-weight: 450; font-style: normal; }

    /* ---------------- Profile completion ---------------- */
    .cs-completion{
        background: var(--cs-surface);
        border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius);
        padding: 18px 22px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .cs-completion-ring{
        position: relative;
        width: 52px; height: 52px;
        flex-shrink: 0;
    }
    .cs-completion-ring svg{ transform: rotate(-90deg); }
    .cs-completion-ring-track{ stroke: #EEF2F6; }
    .cs-completion-ring-value{
        stroke: var(--cs-primary);
        stroke-linecap: round;
        transition: stroke-dashoffset 900ms cubic-bezier(.4,0,.2,1);
    }
    .cs-completion-pct{
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 12.5px; font-weight: 700; color: var(--cs-dark);
    }
    .cs-completion-text{ flex: 1 1 240px; min-width: 200px; }
    .cs-completion-text h5{
        font-size: 14.5px; font-weight: 650; margin: 0 0 2px; color: var(--cs-dark);
    }
    .cs-completion-text p{
        font-size: 12.5px; color: var(--cs-muted); margin: 0;
    }
    .cs-completion-missing{
        display: flex; gap: 6px; flex-wrap: wrap;
    }
    .cs-chip{
        font-size: 12px;
        font-weight: 550;
        padding: 5px 10px;
        border-radius: 8px;
        background: var(--cs-warning-bg);
        color: var(--cs-warning);
        border: 1px solid rgba(180, 83, 9, 0.14);
        cursor: pointer;
        transition: all var(--cs-transition);
        text-decoration: none;
    }
    .cs-chip:hover{ transform: translateY(-1px); box-shadow: var(--cs-shadow-sm); color: var(--cs-warning); }
    .cs-completion-complete{
        font-size: 12px;
        font-weight: 600;
        color: var(--cs-success);
        background: var(--cs-success-bg);
        border: 1px solid rgba(21,128,61,0.14);
        padding: 5px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* ---------------- Snapshot cards ---------------- */
    .cs-snapshot{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }
    .cs-stat-card{
        background: var(--cs-surface);
        border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius);
        padding: 18px 18px 16px;
        transition: transform var(--cs-transition), box-shadow var(--cs-transition), border-color var(--cs-transition);
    }
    .cs-stat-card:hover{
        transform: translateY(-2px);
        box-shadow: var(--cs-shadow);
        border-color: rgba(var(--cs-primary-rgb), 0.2);
    }
    .cs-stat-icon{
        width: 34px; height: 34px;
        border-radius: 10px;
        background: rgba(var(--cs-primary-rgb), 0.08);
        color: var(--cs-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        margin-bottom: 12px;
    }
    .cs-stat-value{
        font-size: 15px;
        font-weight: 650;
        color: var(--cs-dark);
        margin: 0 0 2px;
        line-height: 1.3;
    }
    .cs-stat-value.is-empty{ color: #94A3B8; font-weight: 500; font-size: 13.5px; }
    .cs-stat-label{
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--cs-muted);
        font-weight: 600;
        margin: 0;
    }

    /* ---------------- Workspace nav ---------------- */
    .cs-tabbar{
        display: flex;
        align-items: center;
        gap: 4px;
        background: var(--cs-surface);
        border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius);
        padding: 6px;
        margin-bottom: 20px;
        overflow-x: auto;
        scrollbar-width: none;
        position: sticky;
        top: 8px;
        z-index: 5;
    }
    .cs-tabbar::-webkit-scrollbar{ display: none; }
    .cs-tab{
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 15px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: var(--cs-muted);
        font-size: 13.5px;
        font-weight: 560;
        white-space: nowrap;
        cursor: pointer;
        transition: background var(--cs-transition), color var(--cs-transition);
        flex-shrink: 0;
    }
    .cs-tab i{ font-size: 15px; }
    .cs-tab:hover{
        background: #F1F5F9;
        color: var(--cs-dark);
    }
    .cs-tab.is-active{
        background: linear-gradient(180deg, var(--cs-secondary), var(--cs-primary));
        color: #fff;
        box-shadow: 0 4px 12px -4px rgba(var(--cs-primary-rgb), 0.5);
    }
    .cs-tab.is-active:hover{ background: linear-gradient(180deg, var(--cs-secondary), var(--cs-primary)); }

    /* ---------------- Tab content shell ---------------- */
    .cs-panel{
        background: transparent;
    }
    .cs-panel-fade{
        animation: csFadeIn 260ms ease both;
    }
    @keyframes csFadeIn{
        from{ opacity: 0; transform: translateY(4px); }
        to{ opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991px){
        .cs-hero{ padding: 26px 20px 22px; }
        .cs-hero-meta{ grid-template-columns: repeat(2, minmax(0,1fr)); row-gap: 16px; }
        .cs-meta-item:nth-child(2n){ border-left: none; padding-left: 0; }
        .cs-meta-item:nth-child(n+3){ border-top: 1px solid var(--cs-border); padding-top: 14px; }
    }
    @media (max-width: 575px){
        .cs-hero-top{ flex-direction: column; }
        .cs-hero-actions{ width: 100%; }
        .cs-hero-actions .cs-btn{ flex: 1; justify-content: center; }
        .cs-hero-meta{ grid-template-columns: 1fr 1fr; }
    }

    @media (prefers-reduced-motion: reduce){
        .cs-avatar, .cs-btn, .cs-stat-card, .cs-tab, .cs-completion-ring-value, .cs-panel-fade{
            transition: none !important;
            animation: none !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('My Profile') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('My Profile') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    @php
        // --- Real-data profile completion calculation (no fabricated fields) ---
        $cs_fields = [
            'phone'        => ['label' => get_phrase('Phone'), 'value' => $user->phone],
            'present_address' => ['label' => get_phrase('Address'), 'value' => $user->present_address],
            'birthday'     => ['label' => get_phrase('Birthday'), 'value' => $user->birthday],
            'bio'          => ['label' => get_phrase('Bio'), 'value' => $user->bio],
            'photo'        => ['label' => get_phrase('Photo'), 'value' => $user->photo],
            'gender'       => ['label' => get_phrase('Gender'), 'value' => $user->gender],
            'blood_group'  => ['label' => get_phrase('Blood group'), 'value' => $user->blood_group],
        ];
        $cs_filled = 2; // name + email always required/present
        $cs_total  = count($cs_fields) + 2;
        $cs_missing = [];
        foreach ($cs_fields as $cs_key => $cs_field) {
            if (!empty($cs_field['value'])) {
                $cs_filled++;
            } else {
                $cs_missing[$cs_key] = $cs_field['label'];
            }
        }
        $cs_field_anchors = [
            'phone'            => 'eInputPhone',
            'present_address'  => 'eInputAddress',
            'birthday'         => 'eInputDate',
            'bio'              => 'eInputTextarea',
            'photo'            => 'photo',
            'gender'           => 'eGenderList',
            'blood_group'      => 'eSectionList',
        ];
        $cs_percent = (int) round(($cs_filled / $cs_total) * 100);
        $cs_ring_circumference = 2 * 3.14159 * 22;
        $cs_ring_offset = $cs_ring_circumference - ($cs_percent / 100) * $cs_ring_circumference;
    @endphp

    <div class="cs-workspace">

        <!-- ================= HERO ================= -->
        <div class="cs-hero">
            <div class="cs-hero-top">
                <div class="cs-hero-identity">
                    <div class="cs-avatar-wrap">
                        <div class="cs-avatar-ring"></div>
                        <img class="cs-avatar" src="{{ get_image('uploads/user-image/' . $user->photo) }}" alt="{{ $user->name }}">
                        @if (auth()->id() === $user->id)
                            <button type="button" class="cs-avatar-edit cs-photo-trigger" title="{{ get_phrase('Photo') }}"
                                data-info-url="{{ route('admin.my.profile', ['info']) }}"
                                data-is-info-tab="{{ $tab == 'info' ? '1' : '0' }}">
                                <i class="bi bi-camera"></i> {{ get_phrase('Change') }}
                            </button>
                        @endif
                    </div>
                    <div class="cs-identity-text">
                        <h4 class="cs-name">{{ $user->name }}</h4>
                        @if ($user->designation)
                            <p class="cs-designation">{{ $user->designation }}</p>
                        @endif
                        <div class="cs-badges">
                            <span class="cs-pill"><span class="cs-dot"></span>{{ ucfirst($user->role) }}</span>
                            @if ($user->created_at)
                                <span class="cs-pill cs-pill-muted">
                                    <i class="bi bi-calendar3"></i> {{ get_phrase('Joined') }} {{ $user->created_at->format('M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if (auth()->id() === $user->id)
                    <div class="cs-hero-actions">
                        <button type="button" class="cs-btn" id="csUpdatePhotoBtn"
                            data-info-url="{{ route('admin.my.profile', ['info']) }}"
                            data-is-info-tab="{{ $tab == 'info' ? '1' : '0' }}">
                            <i class="bi bi-camera"></i> {{ get_phrase('Update photo') }}
                        </button>
                        <button type="button" class="cs-btn cs-btn-primary" id="csEditProfileBtn"
                            data-info-url="{{ route('admin.my.profile', ['info']) }}"
                            data-is-info-tab="{{ $tab == 'info' ? '1' : '0' }}">
                            <i class="bi bi-pencil"></i> {{ get_phrase('Edit Profile') }}
                        </button>
                    </div>
                @endif
            </div>

            <div class="cs-hero-meta">
                <div class="cs-meta-item">
                    <div class="cs-meta-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <p class="cs-meta-label">{{ get_phrase('Email') }}</p>
                        <p class="cs-meta-value">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="cs-meta-item">
                    <div class="cs-meta-icon"><i class="bi bi-telephone"></i></div>
                    <div>
                        <p class="cs-meta-label">{{ get_phrase('Phone') }}</p>
                        <p class="cs-meta-value @if(!$user->phone) cs-meta-empty @endif">
                            {{ $user->phone ?: get_phrase('Not added yet') }}
                        </p>
                    </div>
                </div>
                <div class="cs-meta-item">
                    <div class="cs-meta-icon"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <p class="cs-meta-label">{{ get_phrase('Role') }}</p>
                        <p class="cs-meta-value">{{ ucfirst($user->role) }}</p>
                    </div>
                </div>
                <div class="cs-meta-item">
                    <div class="cs-meta-icon"><i class="bi bi-geo-alt"></i></div>
                    <div>
                        <p class="cs-meta-label">{{ get_phrase('Location') }}</p>
                        <p class="cs-meta-value @if(!$user->present_address) cs-meta-empty @endif">
                            {{ $user->present_address ?: get_phrase('Not added yet') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= PROFILE COMPLETION ================= -->
        @if (auth()->id() === $user->id && $cs_percent < 100)
            <div class="cs-completion">
                <div class="cs-completion-ring">
                    <svg width="52" height="52" viewBox="0 0 52 52">
                        <circle class="cs-completion-ring-track" cx="26" cy="26" r="22" fill="none" stroke-width="5"></circle>
                        <circle class="cs-completion-ring-value" cx="26" cy="26" r="22" fill="none" stroke-width="5"
                            stroke-dasharray="{{ $cs_ring_circumference }}"
                            stroke-dashoffset="{{ $cs_ring_offset }}"></circle>
                    </svg>
                    <span class="cs-completion-pct">{{ $cs_percent }}%</span>
                </div>
                <div class="cs-completion-text">
                    <h5>{{ get_phrase('Complete your profile') }}</h5>
                    <p>{{ get_phrase('A complete profile helps your team recognize and reach you faster.') }}</p>
                </div>
                <div class="cs-completion-missing">
                    @foreach ($cs_missing as $cs_key => $cs_label)
                        <a href="{{ route('admin.my.profile', ['info']) }}#{{ $cs_field_anchors[$cs_key] ?? '' }}" class="cs-chip">+ {{ $cs_label }}</a>
                    @endforeach
                </div>
            </div>
        @elseif (auth()->id() === $user->id)
            <div class="cs-completion">
                <span class="cs-completion-complete"><i class="bi bi-check-circle-fill"></i> {{ get_phrase('Profile complete') }}</span>
            </div>
        @endif

        <!-- ================= SNAPSHOT ================= -->
        <div class="cs-snapshot">
            <div class="cs-stat-card">
                <div class="cs-stat-icon"><i class="bi bi-shield-check"></i></div>
                <p class="cs-stat-value">{{ ucfirst($user->role) }}</p>
                <p class="cs-stat-label">{{ get_phrase('Role') }}</p>
            </div>
            <div class="cs-stat-card">
                <div class="cs-stat-icon"><i class="bi bi-droplet"></i></div>
                @if ($user->blood_group)
                    <p class="cs-stat-value">{{ $user->blood_group }}</p>
                @else
                    <p class="cs-stat-value is-empty">{{ get_phrase('Not added yet') }}</p>
                @endif
                <p class="cs-stat-label">{{ get_phrase('Blood group') }}</p>
            </div>
            <div class="cs-stat-card">
                <div class="cs-stat-icon"><i class="bi bi-gender-ambiguous"></i></div>
                @if ($user->gender)
                    <p class="cs-stat-value">{{ ucfirst($user->gender) }}</p>
                @else
                    <p class="cs-stat-value is-empty">{{ get_phrase('Not added yet') }}</p>
                @endif
                <p class="cs-stat-label">{{ get_phrase('Gender') }}</p>
            </div>
            <div class="cs-stat-card">
                <div class="cs-stat-icon"><i class="bi bi-calendar-heart"></i></div>
                @if ($user->birthday)
                    <p class="cs-stat-value">{{ date('M d, Y', strtotime($user->birthday)) }}</p>
                @else
                    <p class="cs-stat-value is-empty">{{ get_phrase('Not added yet') }}</p>
                @endif
                <p class="cs-stat-label">{{ get_phrase('Birthday') }}</p>
            </div>
        </div>

        <!-- ================= WORKSPACE NAV ================= -->
        <div class="cs-tabbar" role="tablist" aria-label="{{ get_phrase('My Profile') }}">
            <button type="button" role="tab" aria-selected="{{ $tab == 'info' ? 'true' : 'false' }}"
                onclick="redirectTo('{{ route('admin.my.profile', ['info']) }}');"
                class="cs-tab @if ($tab == 'info') is-active @endif">
                <i class="bi bi-person"></i> {{ get_phrase('Basic Info') }}
            </button>

            @if (!$user->hasAnyRole(['End Customer', 'Vendor']))
                <button type="button" role="tab" aria-selected="{{ $tab == 'task' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['task']) }}');"
                    class="cs-tab @if ($tab == 'task') is-active @endif">
                    <i class="bi bi-list-check"></i> {{ get_phrase('Task') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'attendance' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['attendance']) }}');"
                    class="cs-tab @if ($tab == 'attendance') is-active @endif">
                    <i class="bi bi-calendar-check"></i> {{ get_phrase('Attendance') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'timesheet' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['timesheet']) }}');"
                    class="cs-tab @if ($tab == 'timesheet') is-active @endif">
                    <i class="bi bi-clock-history"></i> {{ get_phrase('Timesheet') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'payslip' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['payslip']) }}');"
                    class="cs-tab @if ($tab == 'payslip') is-active @endif">
                    <i class="bi bi-receipt"></i> {{ get_phrase('Payslip') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'assessment' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['assessment']) }}');"
                    class="cs-tab @if ($tab == 'assessment') is-active @endif">
                    <i class="bi bi-clipboard-data"></i> {{ get_phrase('Assessment') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'performance' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['performance']) }}');"
                    class="cs-tab @if ($tab == 'performance') is-active @endif">
                    <i class="bi bi-graph-up-arrow"></i> {{ get_phrase('Performance') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'leave' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['leave']) }}');"
                    class="cs-tab @if ($tab == 'leave') is-active @endif">
                    <i class="bi bi-calendar-week"></i> {{ get_phrase('Leave') }}
                </button>

                <button type="button" role="tab" aria-selected="{{ $tab == 'inventory' ? 'true' : 'false' }}"
                    onclick="redirectTo('{{ route('admin.my.profile', ['inventory']) }}');"
                    class="cs-tab @if ($tab == 'inventory') is-active @endif">
                    <i class="bi bi-box-seam"></i> {{ get_phrase('Inventory') }}
                </button>
            @endif
        </div>

        <!-- ================= TAB CONTENT ================= -->
        <div class="cs-panel cs-panel-fade" role="tabpanel">
            @include('admin.my_profile.profile_' . $tab)
        </div>

    </div>
@endsection

@push('js')
<script>
    // Hero shortcuts reuse the existing Basic Info form fields — no backend change.
    // If the person isn't on the Basic Info tab yet, we navigate them there first.
    document.addEventListener('click', function (e) {
        var photoTrigger = e.target.closest('.cs-photo-trigger, #csUpdatePhotoBtn');
        if (photoTrigger) {
            if (photoTrigger.dataset.isInfoTab === '1') {
                document.getElementById('photo')?.click();
            } else if (typeof redirectTo === 'function') {
                redirectTo(photoTrigger.dataset.infoUrl);
            } else {
                window.location.href = photoTrigger.dataset.infoUrl;
            }
            return;
        }

        var editTrigger = e.target.closest('#csEditProfileBtn');
        if (editTrigger) {
            if (editTrigger.dataset.isInfoTab === '1') {
                var target = document.getElementById('eInputName');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    target.focus({ preventScroll: true });
                }
            } else if (typeof redirectTo === 'function') {
                redirectTo(editTrigger.dataset.infoUrl);
            } else {
                window.location.href = editTrigger.dataset.infoUrl;
            }
        }
    });
</script>
@endpush
