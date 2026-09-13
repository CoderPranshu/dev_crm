<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ get_phrase('Login') }} | {{ get_settings('website_title') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0F172A">

    <link rel="shortcut icon" href="{{ get_image(get_settings('favicon')) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-5.1.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-icons-1.9.1/bootstrap-icons.css') }}">

    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

    <style>
        :root {
            --navy: #0F172A;
            --navy-2: #16213E;
            --navy-soft: #1E293B;
            --teal: #14B8A6;
            --teal-light: #2DD4BF;
            --blue: #3B82F6;
            --bg: #F8FAFC;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --text-faint: #94A3B8;

            --font-display: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;

            --shadow-sm: 0 1px 2px rgba(15, 23, 42, .05);
            --shadow-md: 0 8px 24px rgba(15, 23, 42, .08);
            --shadow-lg: 0 24px 60px rgba(15, 23, 42, .14);
            --shadow-xl: 0 40px 90px rgba(15, 23, 42, .22);

            --r-card: 24px;
            --r-input: 14px;
            --r-btn: 14px;
        }

        * { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text-dark);
            overflow: hidden;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }

        .cs-shell {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* ============ LEFT HERO (55%) ============ */
        .cs-hero {
            position: relative;
            flex: 0 0 55%;
            max-width: 55%;
            height: 100%;
            background:
                radial-gradient(120% 90% at 15% 8%, #17324a 0%, transparent 55%),
                radial-gradient(90% 70% at 90% 92%, rgba(20,184,166,.35) 0%, transparent 60%),
                linear-gradient(150deg, var(--navy) 0%, var(--navy-2) 55%, #0B1526 100%);
            overflow: hidden;
        }

        /* grid texture */
        .cs-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .05) 1px, transparent 1px);
            background-size: 42px 42px;
            -webkit-mask-image: radial-gradient(80% 70% at 40% 30%, #000 20%, transparent 80%);
            mask-image: radial-gradient(80% 70% at 40% 30%, #000 20%, transparent 80%);
            opacity: .6;
        }

        /* blobs */
        .cs-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: .55;
            will-change: transform;
        }
        .cs-blob-1 { width: 460px; height: 460px; top: -140px; left: -100px; background: radial-gradient(circle at 30% 30%, var(--teal), transparent 70%); }
        .cs-blob-2 { width: 380px; height: 380px; bottom: -120px; right: -80px; background: radial-gradient(circle at 60% 40%, var(--blue), transparent 70%); }
        .cs-blob-3 { width: 260px; height: 260px; bottom: 30%; left: 8%; background: radial-gradient(circle, var(--teal-light), transparent 72%); opacity: .35; }

        /* particles */
        .cs-particles { position: absolute; inset: 0; pointer-events: none; }
        .cs-particle {
            position: absolute;
            width: 3px; height: 3px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .5);
        }

        .cs-hero-inner {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 64px;
        }

        .cs-hero-topbar {
            position: absolute;
            top: 40px;
            left: 64px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 3;
        }
        .cs-badge-mark {
            width: 34px; height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--teal), var(--blue));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 16px rgba(20, 184, 166, .35);
        }
        .cs-badge-mark svg { width: 19px; height: 19px; }
        .cs-hero-brand { font-family: var(--font-display); font-weight: 700; color: #fff; font-size: 15px; letter-spacing: .2px; }
        .cs-hero-brand span { color: var(--teal-light); }

        /* glass welcome card */
        .cs-glass {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .14);
            -webkit-backdrop-filter: blur(18px);
            backdrop-filter: blur(18px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .25);
        }

        .cs-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--teal-light);
            padding: 7px 14px;
            border-radius: 100px;
            margin-bottom: 22px;
        }
        .cs-eyebrow .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--teal-light); box-shadow: 0 0 8px var(--teal-light); }

        .cs-hero-title {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 40px;
            line-height: 1.15;
            color: #fff;
            max-width: 480px;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }
        .cs-hero-sub {
            font-size: 15.5px;
            line-height: 1.65;
            color: rgba(255, 255, 255, .62);
            max-width: 440px;
            margin-bottom: 40px;
        }

        /* feature grid */
        .cs-feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            max-width: 520px;
            position: relative;
        }

        .cs-feature-card {
            padding: 20px;
            border-radius: 20px;
            cursor: default;
            transition: transform .35s cubic-bezier(.22, .9, .3, 1), background .35s, border-color .35s;
        }
        .cs-feature-card:hover {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .25);
        }
        .cs-feature-icon {
            width: 38px; height: 38px;
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(20, 184, 166, .25), rgba(59, 130, 246, .25));
            border: 1px solid rgba(255, 255, 255, .12);
            margin-bottom: 14px;
            font-size: 17px;
            color: var(--teal-light);
        }
        .cs-feature-title { font-family: var(--font-display); font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .cs-feature-desc { font-size: 12.5px; color: rgba(255, 255, 255, .5); line-height: 1.5; }

        /* flight path svg connecting the cards - brand signature */
        .cs-flightpath {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: visible;
        }
        .cs-flightpath path {
            fill: none;
            stroke: rgba(45, 212, 191, .35);
            stroke-width: 1.5;
            stroke-dasharray: 4 7;
        }

        /* sparrow signature mark that flies in */
        .cs-sparrow {
            position: absolute;
            width: 46px;
            z-index: 4;
            filter: drop-shadow(0 6px 14px rgba(20, 184, 166, .4));
            opacity: 0;
        }
        .cs-sparrow .wing { transform-origin: 60% 45%; animation: flap 2.6s ease-in-out infinite; }
        @keyframes flap {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(-14deg); }
        }

        /* trust stat row */
        .cs-stats {
            display: flex;
            gap: 34px;
            margin-top: 42px;
            padding-top: 26px;
            border-top: 1px solid rgba(255, 255, 255, .1);
            max-width: 520px;
        }
        .cs-stat-num { font-family: var(--font-display); font-weight: 800; font-size: 21px; color: #fff; }
        .cs-stat-label { font-size: 12px; color: rgba(255, 255, 255, .48); margin-top: 2px; }

        /* ============ RIGHT LOGIN PANEL (45%) ============ */
        .cs-right {
            flex: 1;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: var(--bg);
            padding: 32px;
            overflow-y: auto;
        }
        .cs-right::before {
            content: '';
            position: absolute;
            top: -180px; right: -180px;
            width: 420px; height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(20, 184, 166, .07), transparent 70%);
            pointer-events: none;
        }

        .cs-login-wrap { width: 100%; max-width: 420px; }

        .cs-login-card {
            background: var(--card);
            border-radius: var(--r-card);
            padding: 46px 42px 38px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border);
            position: relative;
        }

        /* animated gradient border ring */
        .cs-login-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: var(--r-card);
            padding: 1px;
            background: linear-gradient(120deg, var(--teal), var(--blue), var(--navy-soft), var(--teal));
            background-size: 300% 300%;
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity .4s;
            animation: borderflow 6s linear infinite;
            pointer-events: none;
        }
        .cs-login-card:hover::before { opacity: 1; }
        @keyframes borderflow { to { background-position: 300% 0; } }

        .cs-logo-row { text-align: center; margin-bottom: 26px; }
        .cs-logo-row img { height: 34px; width: auto; }

        .cs-welcome-title {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -0.01em;
            text-align: center;
            margin-bottom: 6px;
        }
        .cs-welcome-sub {
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 30px;
        }

        /* floating label inputs */
        .cs-field { position: relative; margin-bottom: 18px; }
        .cs-field .cs-input-icon {
            position: absolute;
            left: 16px; top: 50%; transform: translateY(-50%);
            color: var(--text-faint);
            font-size: 16px;
            transition: color .25s;
            z-index: 2;
        }
        .cs-field input {
            width: 100%;
            height: 54px;
            border: 1.5px solid var(--border);
            border-radius: var(--r-input);
            background: #fff;
            padding: 22px 16px 6px 44px;
            font-size: 14.5px;
            font-family: var(--font-body);
            color: var(--text-dark);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }
        .cs-field input::placeholder { color: transparent; }
        .cs-field label {
            position: absolute;
            left: 44px; top: 17px;
            font-size: 14px;
            color: var(--text-faint);
            pointer-events: none;
            transition: all .2s ease;
            background: transparent;
        }
        .cs-field input:focus,
        .cs-field input:not(:placeholder-shown) {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(20, 184, 166, .12);
        }
        .cs-field input:focus ~ label,
        .cs-field input:not(:placeholder-shown) ~ label {
            top: 8px;
            font-size: 11px;
            font-weight: 600;
            color: var(--teal);
            letter-spacing: .02em;
        }
        .cs-field input:focus ~ .cs-input-icon { color: var(--teal); }

        .cs-eye-toggle {
            position: absolute;
            right: 16px; top: 50%; transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-faint);
            font-size: 16px;
            z-index: 2;
        }
        .cs-eye-toggle:hover { color: var(--text-dark); }

        .cs-field-error {
            display: block;
            font-size: 12px;
            color: #EF4444;
            margin-top: 6px;
            margin-left: 4px;
        }

        .cs-row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }
        .cs-remember { display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: var(--text-muted); }
        .cs-remember input {
            width: 16px; height: 16px;
            accent-color: var(--teal);
            cursor: pointer;
        }
        .cs-forgot { font-size: 13.5px; color: var(--blue); text-decoration: none; font-weight: 500; }
        .cs-forgot:hover { text-decoration: underline; }

        .cs-btn-login {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: var(--r-btn);
            background: linear-gradient(135deg, var(--navy) 0%, #1e3a5f 55%, var(--teal) 150%);
            background-size: 180% 180%;
            background-position: 0% 50%;
            color: #fff;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 15px;
            letter-spacing: .01em;
            cursor: pointer;
            position: relative;
            box-shadow: 0 14px 30px -8px rgba(15, 23, 42, .5);
            transition: transform .25s ease, box-shadow .25s ease, background-position .5s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .cs-btn-login:hover { transform: translateY(-2px); box-shadow: 0 18px 36px -6px rgba(20, 184, 166, .45); background-position: 100% 50%; }
        .cs-btn-login:active { transform: translateY(0); }
        .cs-btn-login .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255, 255, 255, .35);
            border-top-color: #fff;
            border-radius: 50%;
            display: none;
            animation: spin .7s linear infinite;
        }
        .cs-btn-login.is-loading .btn-label { opacity: .6; }
        .cs-btn-login.is-loading .spinner { display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .cs-divider { display: flex; align-items: center; gap: 12px; margin: 26px 0 20px; }
        .cs-divider::before, .cs-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .cs-divider span { font-size: 12px; color: var(--text-faint); white-space: nowrap; }

        .cs-social-row { display: flex; gap: 12px; margin-bottom: 28px; }
        .cs-social-btn {
            flex: 1;
            height: 48px;
            border: 1.5px solid var(--border);
            border-radius: var(--r-input);
            background: #fff;
            display: flex; align-items: center; justify-content: center; gap: 9px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            transition: all .2s ease;
        }
        .cs-social-btn:hover { border-color: var(--teal); box-shadow: 0 6px 16px rgba(15, 23, 42, .08); transform: translateY(-1px); }
        .cs-social-btn svg { width: 17px; height: 17px; }

        .cs-help {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }
        .cs-help a { color: var(--teal); font-weight: 600; text-decoration: none; }
        .cs-help a:hover { text-decoration: underline; }

        .cs-footer {
            text-align: center;
            font-size: 12px;
            color: var(--text-faint);
            margin-top: 22px;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 991.98px) {
            body { overflow-y: auto; overflow-x: hidden; }
            .cs-shell { flex-direction: column; height: auto; min-height: 100vh; }
            .cs-hero { display: none; }
            .cs-right { flex: 1; height: auto; min-height: 100vh; padding: 40px 20px; }
        }
        @media (max-width: 480px) {
            .cs-login-card { padding: 34px 22px 28px; }
            .cs-social-row { flex-direction: column; }
        }
    </style>
</head>

<body>

    <div class="cs-shell">

        <!-- ============ LEFT HERO ============ -->
        <div class="cs-hero" id="csHero">
            <div class="cs-grid"></div>
            <div class="cs-blob cs-blob-1" data-depth="0.02"></div>
            <div class="cs-blob cs-blob-2" data-depth="0.035"></div>
            <div class="cs-blob cs-blob-3" data-depth="0.05"></div>
            <div class="cs-particles" id="csParticles"></div>

            <!-- signature flying sparrow -->
            <!-- <svg class="cs-sparrow" id="csSparrow" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M32 20c6-8 16-9 20-6-4 1-7 3-8 6 5 0 9 3 10 7-4-1-7 0-9 2 3 3 3 8 1 12-1-4-3-6-6-7 1 5-1 10-5 13 0-4-1-8-3-10-3 3-8 4-12 2 3-2 5-5 5-8-4 2-9 1-12-2 4 0 7-2 9-5-4 0-7-3-8-6 4 1 7 0 9-2-2-3-2-7 0-10 1 3 3 5 5 6 1-4 3-7 4-8Z" fill="url(#sparrowGrad)"/>
                <g class="wing">
                    <path d="M30 26c-7-2-14 1-17 6 5-1 10 0 13 3 1-4 2-7 4-9Z" fill="url(#sparrowGrad2)"/>
                </g>
                <defs>
                    <linearGradient id="sparrowGrad" x1="8" y1="10" x2="56" y2="54" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2DD4BF"/>
                        <stop offset="1" stop-color="#3B82F6"/>
                    </linearGradient>
                    <linearGradient id="sparrowGrad2" x1="13" y1="26" x2="30" y2="35" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#0F172A"/>
                        <stop offset="1" stop-color="#1E293B"/>
                    </linearGradient>
                </defs>
            </svg> -->

            <svg class="cs-sparrow" id="csSparrow" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">

    <!-- Main Sparrow Body + Head -->
    <path
        d="M12 39
           L29 27
           C31 20 36 17 41 18
           C46 18 49 21 50 25
           C54 25 57 27 59 29
           L50 31
           C50 39 46 45 39 47
           C31 50 22 47 17 43
           L12 39Z"
        fill="url(#sparrowGrad)"
    />

    <!-- Wing -->
    <g class="wing">
        <path
            d="M12 39
               L29 27
               C32 28 34 32 34 36
               C34 42 29 46 23 45
               C18 44 14 41 12 39Z"
            fill="url(#sparrowGrad2)"
        />
    </g>

    <!-- Eye -->
    <circle
        cx="41"
        cy="24"
        r="2"
        fill="white"
    />

    <defs>
        <linearGradient id="sparrowGrad" x1="8" y1="10" x2="56" y2="54" gradientUnits="userSpaceOnUse">
            <stop stop-color="#2DD4BF"/>
            <stop offset="1" stop-color="#3B82F6"/>
        </linearGradient>

        <linearGradient id="sparrowGrad2" x1="13" y1="26" x2="30" y2="35" gradientUnits="userSpaceOnUse">
            <stop stop-color="#0F172A"/>
            <stop offset="1" stop-color="#1E293B"/>
        </linearGradient>
    </defs>

</svg>


            <div class="cs-hero-topbar">
                <div class="cs-badge-mark">
                    <!-- <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 20c6-8 16-9 20-6-4 1-7 3-8 6 5 0 9 3 10 7-4-1-7 0-9 2 3 3 3 8 1 12-1-4-3-6-6-7 1 5-1 10-5 13 0-4-1-8-3-10-3 3-8 4-12 2 3-2 5-5 5-8-4 2-9 1-12-2 4 0 7-2 9-5-4 0-7-3-8-6 4 1 7 0 9-2-2-3-2-7 0-10 1 3 3 5 5 6 1-4 3-7 4-8Z" fill="#fff"/>
                    </svg> -->

                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
    <!-- Sparrow Body -->
    <path
        d="M10 40
           L27 28
           C29 21 34 17 40 18
           C46 18 49 22 50 27
           C54 27 57 28 59 30
           L50 32
           C49 39 45 44 39 46
           C32 48 24 46 18 42
           L10 40Z"
        fill="#fff"
    />

    <!-- Wing -->
    <path
        d="M11 40
           L28 28
           C32 29 34 33 34 36
           C34 42 29 45 24 45
           C19 44 14 42 11 40Z"
        fill="#fff"
    />

    <!-- Eye -->
    <circle
        cx="41"
        cy="24"
        r="2"
        fill="#0F172A"
    />
</svg>
                </div>
                <div class="cs-hero-brand" style="margin-top: 10px;">CODE<span>SPARROW</span></div>
            </div>

            <div class="cs-hero-inner">
                <div id="csHeroText">
                    <div class="cs-eyebrow cs-glass"><span class="dot"></span> Welcome to Code Sparrow ERP</div>
                    <h1 class="cs-hero-title">One workspace for Projects, CRM, HRM &amp; Finance.</h1>
                    <p class="cs-hero-sub">Manage projects, CRM, HRM, finance and team collaboration from a single, unified command center built for growing businesses.</p>
                </div>

                <div style="position: relative;">
                    <svg class="cs-flightpath" viewBox="0 0 520 210" id="csFlightpath">
                        <path d="M110 40 C 200 -10, 260 90, 400 45" />
                        <path d="M110 40 C 60 110, 150 150, 110 170" />
                        <path d="M400 45 C 460 100, 380 150, 400 170" />
                    </svg>

                    <div class="cs-feature-grid" id="csFeatures">
                        <div class="cs-feature-card cs-glass">
                            <div class="cs-feature-icon">
                                <!-- <i class="bi bi-rocket-takeoff"></i> -->

                                <i class="bi bi-file-earmark"></i>
                            </div>
                            <div class="cs-feature-title">Project Management</div>
                            <div class="cs-feature-desc">Plan, track and ship work on time.</div>
                        </div>
                        <div class="cs-feature-card cs-glass">
                            <div class="cs-feature-icon"><i class="bi bi-people"></i></div>
                            <div class="cs-feature-title">Team Collaboration</div>
                            <div class="cs-feature-desc">Keep every department in sync.</div>
                        </div>
                        <div class="cs-feature-card cs-glass">
                            <div class="cs-feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                            <div class="cs-feature-title">Business Analytics</div>
                            <div class="cs-feature-desc">Real-time insight into performance.</div>
                        </div>
                        <div class="cs-feature-card cs-glass">
                            <div class="cs-feature-icon"><i class="bi bi-shield-lock"></i></div>
                            <div class="cs-feature-title">Secure Cloud Access</div>
                            <div class="cs-feature-desc">Enterprise-grade data protection.</div>
                        </div>
                    </div>
                </div>

                <div class="cs-stats" id="csStats">
                    <div>
                        <div class="cs-stat-num" data-count="10000">0</div>
                        <div class="cs-stat-label">Businesses onboard</div>
                    </div>
                    <div>
                        <div class="cs-stat-num" data-count="99.9" data-decimal="1">0</div>
                        <div class="cs-stat-label">Uptime guaranteed</div>
                    </div>
                    <div>
                        <div class="cs-stat-num">24/7</div>
                        <div class="cs-stat-label">Support &amp; onboarding</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIGHT LOGIN ============ -->
        <div class="cs-right">
            <div class="cs-login-wrap" id="csLoginWrap">
                <div class="cs-login-card">

                    <div class="cs-logo-row" id="csLogoRow">
                        <img src="{{ get_image(get_settings('dark_logo')) }}" alt="{{ get_settings('website_title') }}">
                    </div>

                    <h2 class="cs-welcome-title">{{ get_phrase('Welcome Back') }}</h2>
                    <p class="cs-welcome-sub">{{ get_phrase('Login to continue managing your business.') }}</p>

                    <form action="{{ route('login') }}" method="post" id="csLoginForm">
                        @csrf

                        <div class="cs-field cs-anim-field">
                            <i class="bi bi-envelope cs-input-icon"></i>
                            <input type="email" name="email" id="email" placeholder=" " value="{{ old('email') }}">
                            <label for="email">{{ get_phrase('Email') }}</label>
                            @if ($errors->has('email'))
                                <small class="cs-field-error">{{ get_phrase($errors->first('email')) }}</small>
                            @endif
                        </div>

                        <div class="cs-field cs-anim-field">
                            <i class="bi bi-lock cs-input-icon"></i>
                            <input type="password" name="password" id="password" placeholder=" ">
                            <label for="password">{{ get_phrase('Password') }}</label>
                            <span class="cs-eye-toggle" id="csEyeToggle"><i class="bi bi-eye-slash"></i></span>
                            @if ($errors->has('password'))
                                <small class="cs-field-error">{{ get_phrase($errors->first('password')) }}</small>
                            @endif
                        </div>

                        <div class="cs-row-between cs-anim-field">
                            <label class="cs-remember">
                                <input type="checkbox" name="remember" id="remember_me">
                                {{ get_phrase('Remember me') }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="cs-forgot">{{ get_phrase('Forgot your password?') }}</a>
                            @endif
                        </div>

                        <button type="submit" class="cs-btn-login cs-anim-field" id="csLoginBtn">
                            <span class="btn-label">{{ get_phrase('Login') }}</span>
                            <span class="spinner"></span>
                        </button>
                    </form>


                    <div class="cs-help" class="mt-5" style="margin-top: 50px;">
                        {{ get_phrase('Need help?') }} <a href="#">{{ get_phrase('Contact Administrator') }}</a>
                    </div>
                </div>

                <div class="cs-footer">&copy; 2026 Code Sparrow ERP. {{ get_phrase('All rights reserved.') }}</div>
            </div>
        </div>

    </div>

    <!--Main Jquery-->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.7.1.min.js') }}"></script>
    <!--Bootstrap bundle with popper-->
    <script src="{{ asset('assets/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>

    <!--Custom Script-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        /* =========================================================
           ESSENTIAL UI — always runs, never depends on GSAP/CDN.
           If any animation library fails to load, the page still
           works and is fully visible/usable.
        ========================================================= */
        (function () {
            var pwd = document.getElementById('password');
            var eye = document.getElementById('csEyeToggle');
            if (eye && pwd) {
                eye.addEventListener('click', function () {
                    var icon = eye.querySelector('i');
                    if (pwd.type === 'password') {
                        pwd.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        pwd.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            }

            var form = document.getElementById('csLoginForm');
            var btn = document.getElementById('csLoginBtn');
            if (form && btn) {
                form.addEventListener('submit', function () {
                    btn.classList.add('is-loading');
                    btn.setAttribute('disabled', 'disabled');
                });
            }
        })();
    </script>

    <!-- GSAP (decorative only — page works fully without it) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <script>
        /* =========================================================
           DECORATIVE ANIMATIONS — guarded. If GSAP failed to load
           (CDN blocked, offline, ad-blocker) this block is skipped
           entirely and the CSS-default (fully visible) state stands.
        ========================================================= */
        if (typeof gsap !== 'undefined') {
            try {
                /* ---------- generate ambient particles ---------- */
                var pWrap = document.getElementById('csParticles');
                for (var i = 0; i < 26; i++) {
                    var p = document.createElement('div');
                    p.className = 'cs-particle';
                    p.style.left = Math.random() * 100 + '%';
                    p.style.top = Math.random() * 100 + '%';
                    p.style.opacity = (Math.random() * .5 + .15).toFixed(2);
                    pWrap.appendChild(p);
                    gsap.to(p, {
                        y: (Math.random() * 60 + 20) * (Math.random() > .5 ? 1 : -1),
                        x: (Math.random() * 40 + 10) * (Math.random() > .5 ? 1 : -1),
                        duration: Math.random() * 6 + 6,
                        repeat: -1,
                        yoyo: true,
                        ease: 'sine.inOut'
                    });
                }

                /* ---------- blob ambient float ---------- */
                gsap.utils.toArray('.cs-blob').forEach(function (blob, i) {
                    gsap.to(blob, {
                        x: 30 * (i % 2 === 0 ? 1 : -1),
                        y: 24,
                        duration: 8 + i * 2,
                        repeat: -1,
                        yoyo: true,
                        ease: 'sine.inOut'
                    });
                });

                /* ---------- animated flight-path dashes ---------- */
                document.querySelectorAll('.cs-flightpath path').forEach(function (path) {
                    gsap.to(path, { strokeDashoffset: -200, duration: 6, repeat: -1, ease: 'linear' });
                });

                /* ---------- count-up stats ---------- */
                document.querySelectorAll('.cs-stat-num[data-count]').forEach(function (el) {
                    var target = parseFloat(el.getAttribute('data-count'));
                    var decimals = parseInt(el.getAttribute('data-decimal') || '0', 10);
                    var obj = { val: 0 };
                    gsap.to(obj, {
                        val: target,
                        duration: 2,
                        delay: 1.4,
                        ease: 'power2.out',
                        onUpdate: function () {
                            el.textContent = decimals ? obj.val.toFixed(decimals) : Math.round(obj.val).toLocaleString() + '+';
                        }
                    });
                });

                /* ---------- master load timeline ---------- */
                var tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

                tl.from('.cs-hero-topbar', { opacity: 0, y: -16, duration: .7 })
                  .from('.cs-eyebrow', { opacity: 0, y: 14, duration: .6 }, '-=.3')
                  .from('.cs-hero-title', { opacity: 0, y: 22, duration: .7 }, '-=.35')
                  .from('.cs-hero-sub', { opacity: 0, y: 18, duration: .6 }, '-=.4')
                  .from('.cs-feature-card', { opacity: 0, y: 26, stagger: .12, duration: .6 }, '-=.25')
                  .from('.cs-stats', { opacity: 0, y: 16, duration: .6 }, '-=.2')
                  .fromTo('#csSparrow',
                        { x: -40, y: 160, opacity: 0, rotate: -8 },
                        { x: 330, y: 10, opacity: 1, rotate: 4, duration: 1.6, ease: 'power2.out' },
                        '-=1.4')
                  .to('#csSparrow', { y: '+=8', duration: 2.2, repeat: -1, yoyo: true, ease: 'sine.inOut' })
                  .from('.cs-login-wrap', { opacity: 0, x: 60, duration: .8 }, .3)
                  .from('.cs-logo-row', { opacity: 0, y: -10, duration: .5 }, '-=.5')
                  .from('.cs-anim-field', { opacity: 0, y: 16, stagger: .09, duration: .5 }, '-=.3');

                /* ---------- mouse parallax on hero ---------- */
                var hero = document.getElementById('csHero');
                if (hero) {
                    hero.addEventListener('mousemove', function (e) {
                        var rect = hero.getBoundingClientRect();
                        var relX = (e.clientX - rect.left) / rect.width - 0.5;
                        var relY = (e.clientY - rect.top) / rect.height - 0.5;

                        gsap.to('.cs-blob', {
                            x: function (i, target) { return relX * 40 * (parseFloat(target.dataset.depth || .03) * 100); },
                            y: function (i, target) { return relY * 40 * (parseFloat(target.dataset.depth || .03) * 100); },
                            duration: 1.2,
                            ease: 'power2.out',
                            overwrite: 'auto'
                        });

                        gsap.to('#csFeatures', {
                            x: relX * 14,
                            y: relY * 10,
                            duration: 1,
                            ease: 'power2.out',
                            overwrite: 'auto'
                        });

                        gsap.to('#csHeroText', {
                            x: relX * 8,
                            duration: 1,
                            ease: 'power2.out',
                            overwrite: 'auto'
                        });
                    });
                }

                /* ---------- input focus glow lift on card ---------- */
                document.querySelectorAll('.cs-field input').forEach(function (inp) {
                    inp.addEventListener('focus', function () {
                        gsap.to(inp.closest('.cs-field'), { y: -2, duration: .25, ease: 'power2.out' });
                    });
                    inp.addEventListener('blur', function () {
                        gsap.to(inp.closest('.cs-field'), { y: 0, duration: .25, ease: 'power2.out' });
                    });
                });
            } catch (err) {
                console.warn('Code Sparrow login: decorative animation skipped —', err);
            }
        }
    </script>

</body>

</html>