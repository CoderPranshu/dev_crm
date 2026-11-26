@php $current_route = Route::currentRouteName(); @endphp
@php
    // determine which main tab should be active based on current route
    $main_active = 'dashboard-sidebar';

    $role = auth()->user()->getRoleNames()->first();

@endphp

<style>

    /*  */

    /* =========================================
   CODE SPARROW - FIXED SIDEBAR LAYOUT
========================================= */

.sidebar {
    display: flex !important;
    flex-direction: column !important;
    height: 100vh !important;
    background: #ffffff !important;
    border-right: 1px solid #edf0f3 !important;
}

/* Main menu only scrolls */
.sidebar .nav-links {
    flex: 1 1 auto !important;
    min-height: 0 !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;

    margin-bottom: 0 !important;
    padding-bottom: 20px !important;
}

/* Bottom fixed section */
.cs-sidebar-bottom {
    flex: 0 0 auto;
    padding: 10px 14px 14px;
    background: #ffffff;
    border-top: 1px solid #edf0f3;
}

/* Settings */
.cs-sidebar-settings {
    min-height: 42px;
    padding: 8px 12px;

    display: flex;
    align-items: center;
    gap: 12px;

    color: #6b7280;
    text-decoration: none;

    border-radius: 10px;

    font-size: 14px;
    font-weight: 500;

    transition: 0.2s ease;
}

.cs-sidebar-settings:hover {
    background: #f6f7f8;
    color: #111827;
}

.cs-sidebar-settings i {
    width: 20px;
    text-align: center;
    font-size: 16px;
}

/* User card */
.cs-sidebar-user {
    margin-top: 7px;

    min-height: 58px;
    padding: 8px 10px;

    display: flex;
    align-items: center;
    gap: 10px;

    border: 1px solid #e7e9ed;
    border-radius: 14px;

    background: #f8f9fa;
}

/* Avatar */
.cs-sidebar-user-avatar {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;

    border-radius: 50%;
    overflow: hidden;

    background: #e5e7eb;
}

.cs-sidebar-user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cs-user-placeholder {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #e8ecef;
    color: #374151;

    font-size: 14px;
    font-weight: 700;
}

/* User text */
.cs-sidebar-user-info {
    flex: 1;
    min-width: 0;

    display: flex;
    flex-direction: column;
}

.cs-sidebar-user-info strong {
    color: #111827;

    font-size: 13px;
    font-weight: 600;

    line-height: 1.3;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cs-sidebar-user-info span {
    margin-top: 2px;

    color: #8a919e;

    font-size: 11px;
    line-height: 1.2;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Three dots */
.cs-sidebar-user-more {
    flex: 0 0 auto;

    color: #8a919e;
    font-size: 16px;

    display: flex;
    align-items: center;
    justify-content: center;
}

/* Mobile */
@media (max-width: 767.98px) {

    .cs-sidebar-bottom {
        padding-bottom: max(14px, env(safe-area-inset-bottom));
    }

    .sidebar .nav-links {
        height: auto !important;
        flex: 1 1 auto !important;
    }
}


    /*  */
    .main-icon.no-action {
        pointer-events: none !important;
    }

        /* =========================================
    MOBILE SIDEBAR - FINAL RESPONSIVE FIX
    ========================================= */

    @media (max-width: 767.98px) {

        /* Sidebar */
        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;

            width: 280px !important;
            max-width: 82vw !important;

            height: 100vh !important;
            height: 100dvh !important;

            z-index: 9999 !important;

            overflow: hidden !important;

            transition: transform 0.3s ease,
                width 0.3s ease !important;
        }


        /* Logo area */
        .sidebar .logo-details {
            height: 90px !important;
            margin-top: 0 !important;

            padding: 15px !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .sidebar .logo-lg {
            width: 145px !important;
            max-width: 75% !important;
            height: auto !important;
        }


        /* Close button */
        .sidebar .closeIcon {
            position: absolute !important;

            top: 18px !important;
            right: 12px !important;

            z-index: 10000 !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            width: 32px !important;
            height: 32px !important;
        }

        .sidebar .closeIcon span {
            cursor: pointer !important;
            font-size: 20px !important;
        }


        /* Sidebar menu */
        .sidebar .nav-links {
            width: 100% !important;

            height: calc(100vh - 90px) !important;
            height: calc(100dvh - 90px) !important;

            overflow-x: hidden !important;
            overflow-y: auto !important;

            padding: 5px 10px 30px !important;

            margin: 0 !important;
        }


        /* Section headings */
        .sidebar .nav-links h6 {
            padding-left: 18px !important;
            margin-top: 10px !important;
            margin-bottom: 5px !important;

            font-size: 12px !important;
        }


        /* Menu item */
        .sidebar .nav-links-li {
            width: 100% !important;
            margin: 0 !important;
        }


        .sidebar .iocn-link {
            width: 100% !important;
        }


        .sidebar .iocn-link>a {
            width: 100% !important;

            min-height: 54px !important;

            padding: 5px 8px !important;

            display: flex !important;
            align-items: center !important;

            box-sizing: border-box !important;
        }


        /* Icon */
        .sidebar .sidebar_icon {
            width: 48px !important;
            min-width: 48px !important;
            height: 48px !important;

            flex-shrink: 0 !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .sidebar .sidebar_icon svg {
            width: 32px !important;
            height: 32px !important;

            max-width: 32px !important;
            max-height: 32px !important;
        }


        /* Text */
        .sidebar .link_name {
            display: block !important;

            font-size: 14px !important;
            line-height: 1.3 !important;

            white-space: normal !important;

            overflow: hidden !important;
            text-overflow: ellipsis !important;

            flex: 1 !important;

            min-width: 0 !important;
        }


        /* Sub menu */
        .sidebar .sub-menu {
            width: 100% !important;
            padding-left: 48px !important;

            box-sizing: border-box !important;
        }

        .sidebar .sub-menu li a {
            font-size: 13px !important;

            padding: 8px 10px !important;

            white-space: normal !important;

            line-height: 1.4 !important;
        }


        /* Prevent horizontal overflow */
        html,
        body {
            max-width: 100% !important;
            overflow-x: hidden !important;
        }
    }


    /* =========================================
        SMALL MOBILE
        ========================================= */

    @media (max-width: 480px) {

        .sidebar {
            width: 260px !important;
            max-width: 84vw !important;
        }

        .sidebar .logo-details {
            height: 80px !important;
        }

        .sidebar .logo-lg {
            width: 135px !important;
        }

        .sidebar .nav-links {
            height: calc(100vh - 80px) !important;
            height: calc(100dvh - 80px) !important;
        }

        .sidebar .sidebar_icon {
            width: 44px !important;
            min-width: 44px !important;
            height: 44px !important;
        }

        .sidebar .sidebar_icon svg {
            width: 29px !important;
            height: 29px !important;
        }

        .sidebar .link_name {
            font-size: 13px !important;
        }
    }


        /* =========================================
    VERY SMALL MOBILE
    ========================================= */

    @media (max-width: 360px) {

        .sidebar {
            width: 245px !important;
            max-width: 86vw !important;
        }

        .sidebar .logo-lg {
            width: 125px !important;
        }

        .sidebar .link_name {
            font-size: 12px !important;
        }
    }

        /* =========================================
    MOBILE SIDEBAR
    ========================================= */

    @media (max-width: 767.98px) {

        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 280px !important;
            max-width: 82vw !important;
            height: 100vh !important;
            height: 100dvh !important;
            z-index: 9999 !important;

            transition: transform 0.3s ease !important;
        }


        /* SIDEBAR OPEN */
        /* .sidebar:not(.close) {
            transform: translateX(0) !important;
        } */


        /* SIDEBAR CLOSED */
        /* .sidebar.close {
            width: 280px !important;
            max-width: 82vw !important;

            transform: translateX(-100%) !important;
        } */


        /* MAIN PAGE */
        body {
            overflow-x: hidden !important;
        }
    }

   




@media (max-width: 767.98px) {

    /* =====================================================
       MOBILE SIDEBAR - TRUE DEFAULT CLOSED
       Applies BEFORE JavaScript runs
    ====================================================== */

    #dashboard-sidebar {
        transform: translateX(-105%) !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* Explicit open state only */
    #dashboard-sidebar.mobile-open {
        transform: translateX(0) !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    /* Keep full sidebar layout when opened */
    #dashboard-sidebar.mobile-open .link_name {
        display: block !important;
    }

    #dashboard-sidebar.mobile-open .nav-links > h6 {
        display: block !important;
    }

    #dashboard-sidebar.mobile-open .cs-sidebar-user-info,
    #dashboard-sidebar.mobile-open .cs-sidebar-user-more {
        display: flex !important;
    }

    #dashboard-sidebar.mobile-open .cs-sidebar-settings span {
        display: inline !important;
    }

    .home-section {
        left: 0 !important;
        width: 100% !important;
        margin-left: 0 !important;
    }
}

/* ============================================================
   DESKTOP SIDEBAR
   .close = compact sidebar
============================================================ */

@media (min-width: 768px) {

    #dashboard-sidebar {
        transform: none !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    #dashboard-sidebar.sidebar {
        width: 275px !important;
        max-width: none !important;
        transition: width .25s ease !important;
    }

    #dashboard-sidebar.sidebar.close {
        width: 82px !important;
    }


    /* MAIN CONTENT - EXPANDED */
    #dashboard-sidebar ~ .home-section {
        left: 295px !important;
        width: calc(100% - 295px) !important;

        transition:
            left .25s ease,
            width .25s ease !important;
    }


    /* MAIN CONTENT - COLLAPSED */
    #dashboard-sidebar.close ~ .home-section {
        left: 102px !important;
        width: calc(100% - 102px) !important;
    }


    /* Hide text in collapsed desktop sidebar */
    #dashboard-sidebar.close .link_name,
    #dashboard-sidebar.close .nav-links > h6,
    #dashboard-sidebar.close .arrow,
    #dashboard-sidebar.close .sub-menu,
    #dashboard-sidebar.close .cs-sidebar-user-info,
    #dashboard-sidebar.close .cs-sidebar-user-more,
    #dashboard-sidebar.close .cs-sidebar-settings span {
        display: none !important;
    }

}



/*  */

@media (max-width: 767.98px) {

    #dashboard-sidebar.mobile-open {
        width: 280px !important;
        max-width: 82vw !important;
    }

    #dashboard-sidebar.mobile-open .cs-sidebar-search {
        width: auto !important;
    }

    #dashboard-sidebar.mobile-open .cs-sidebar-search input {
        display: block !important;
    }

    #dashboard-sidebar.mobile-open .link_name {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    #dashboard-sidebar.mobile-open .arrow {
        display: flex !important;
    }

    #dashboard-sidebar.mobile-open .cs-sidebar-user-info {
        display: flex !important;
    }

    #dashboard-sidebar.mobile-open .cs-sidebar-user-more {
        display: flex !important;
    }
}









/* Consistent inline SVG icons; scoped to this sidebar. */
#dashboard-sidebar .cs-modern-icon {
    display: inline-block;
    width: 28px !important;
    height: 28px !important;
    min-width: 28px;
    max-width: 28px !important;
    max-height: 28px !important;
    flex-shrink: 0;
    vertical-align: middle;
    fill: none !important;
    stroke: currentColor !important;
    stroke-width: 1.7;
    stroke-linecap: round;
    stroke-linejoin: round;
}
#dashboard-sidebar .cs-modern-icon * {
    fill: none !important;
    stroke: currentColor !important;
}
#dashboard-sidebar .cs-utility-icon {
    width: 20px !important;
    height: 20px !important;
    min-width: 20px;
    max-width: 20px !important;
    max-height: 20px !important;
}
#dashboard-sidebar .arrow .cs-modern-icon {
    width: 16px !important;
    height: 16px !important;
    min-width: 16px;
}
#dashboard-sidebar .closeIcon span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebarMenu = document.querySelector('.sidebar .nav-links');

    if (!sidebarMenu) return;

    // Save sidebar scroll position
    sidebarMenu.addEventListener('scroll', function () {
        localStorage.setItem(
            'sidebarScroll',
            sidebarMenu.scrollTop
        );
    });

    // Restore sidebar scroll position
    window.addEventListener('load', function () {

        setTimeout(function () {

            const savedScroll =
                localStorage.getItem('sidebarScroll');

            if (savedScroll !== null) {
                sidebarMenu.scrollTop =
                    parseInt(savedScroll, 10);
            }

        }, 500);

    });

});
</script>




<div
    class="sidebar sub-sidebar {{ $main_active === 'dashboard-sidebar' ? 'active' : '' }}"
    id="dashboard-sidebar">
    <div class="logo-details mt-4">
        <div class="img_wrapper">
            <!-- <img class="logo-lg" src="{{ get_image(get_settings('light_logo')) }}" width="175px" /> -->
            <!-- <img class="logo-sm ms-auto me-auto" src="{{ get_image(get_settings('favicon')) }}" width="40px" /> -->


            <img class="logo-lg" src="{{ asset('uploads/code-sparrow-logo.png') }}" width="175">

        </div>

        <!-- code-sparrow-logo.png -->
    </div>

    <div class="cs-sidebar-search">
        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="10.5" cy="10.5" r="6.5" /><path d="m16 16 5 5" /></svg>

        <input
            type="text"
            id="sidebarMenuSearch"
            placeholder="{{ get_phrase('Search menu') }}"
            autocomplete="off"
        >
    </div>

    <div class="closeIcon">
        <span><svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9" /><path d="m9 9 6 6 M15 9l-6 6" /></svg></span>
    </div>

    <ul class="nav-links">
        @canany(['recuritment-list', 'candidate-list', 'stage-list', 'designation-list', 'department-list',
            'holiday-list', 'leave-type-list', 'employees-list', 'branch-list', 'kra-list', 'kpi-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">HRMS</h6>
        @endcanany
        <!-- menu starts here -->
        <li class="nav-links-li @if ($current_route == 'admin.dashboard') showMenu @endif">
            <div class="iocn-link">
                <a class="w-100" href="{{ route('admin.dashboard') }}">
                    <div class="sidebar_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 3v18h18 M7 17v-5 M12 17V8 M17 17V5" /></svg>
                    </div>
                    <span class="link_name">
                        {{ get_phrase('Statistics') }}
                    </span>
                </a>
            </div>
        </li>

        @can('attendence')
            <li class="nav-links-li @if ($current_route == 'admin.atten.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.atten.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="16" rx="3" /><path d="M7 3v4 M17 3v4 M3 10h18" /><path d="m8 13 3 3 5-6" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Attendance') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @canany(['recuritment-list', 'candidate-list', 'stage-list', 'designation-list', 'department-list'])
            <li class="nav-links-li dropdownToggle @if (
                $current_route == 'admin.recruitment.index' ||
                    $current_route == 'admin.candidate.index' ||
                    $current_route == 'admin.stage.index' ||
                    $current_route == 'admin.shortlist.index' ||
                    $current_route == 'admin.performance.criteria' ||
                    $current_route == 'admin.designation.index' ||
                    $current_route == 'admin.department.index') active showMenu @endif">
                <div class="iocn-link">
                    <a href="#">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="M16 5a3 3 0 0 1 0 6 M18 15a5 5 0 0 1 3 4v2" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Recruitment') }}</span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m9 5 7 7-7 7" /></svg>
                    </span>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="{{ route('admin.recruitment.index') }}">{{ get_phrase('Jobs') }}</a>
                    </li>
                    @can('recuritment-list')
                        <li><a class="@if ($current_route == 'admin.recruitment.index') active @endif"
                                href="{{ route('admin.recruitment.index') }}">{{ get_phrase('Jobs') }}</a></li>
                    @endcan
                    @can('candidate-list')
                        <li><a class="@if ($current_route == 'admin.candidate.index') active @endif"
                                href="{{ route('admin.candidate.index') }}">{{ get_phrase('Candidates') }}</a></li>
                    @endcan
                    @can('stage-list')
                        <li><a class="@if ($current_route == 'admin.stage.index') active @endif"
                                href="{{ route('admin.stage.index') }}">{{ get_phrase('Selection Process') }}</a>
                        </li>
                    @endcan
                    <li><a class="@if ($current_route == 'admin.shortlist.index') active @endif"
                            href="{{ route('admin.shortlist.index') }}">{{ get_phrase('Shortlisted Candidates') }}</a>
                    </li>
                    @can('designation-list')
                        <li><a class="@if ($current_route == 'admin.designation.index') active @endif"
                                href="{{ route('admin.designation.index') }}">{{ get_phrase('Designation') }}</a></li>
                    @endcan
                    @can('department-list')
                        <li><a class="@if ($current_route == 'admin.department.index') active @endif"
                                href="{{ route('admin.department.index') }}">{{ get_phrase('Department') }}</a></li>
                    @endcan

                </ul>
            </li>
        @endcan

        @canany(['candidate-list'])
            <li class="nav-links-li dropdownToggle @if (
                $current_route == 'admin.onboarding.index' ||
                    $current_route == 'admin.selected.candi' ||
                    $current_route == 'admin.rejected.candidate') active showMenu @endif">
                <div class="iocn-link">
                    <a href="#">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="M17 8v6 M14 11h6" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Onboarding') }}</span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m9 5 7 7-7 7" /></svg>
                    </span>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name"
                            href="{{ route('admin.onboarding.index') }}">{{ get_phrase('Onboarding') }}</a>
                    </li>
                    <li><a class="@if ($current_route == 'admin.onboarding.index') active @endif"
                            href="{{ route('admin.onboarding.index') }}">{{ get_phrase('Selection Process') }}</a></li>
                    @can('candidate-list')
                        <li><a class="@if ($current_route == 'admin.selected.candi') active @endif"
                                href="{{ route('admin.selected.candi') }}">{{ get_phrase('Selected Candidates') }}</a></li>
                    @endcan

                    @can('candidate-list')
                        <li><a class="@if ($current_route == 'admin.rejected.candidate') active @endif"
                                href="{{ route('admin.rejected.candidate') }}">{{ get_phrase('Rejected Candidates') }}</a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcanany

        @canany(['holiday-list', 'leave-type-list'])
            <li class="nav-links-li dropdownToggle @if (
                $current_route == 'admin.leave.report' ||
                    $current_route == 'admin.holiday.index' ||
                    $current_route == 'admin.type.index') active showMenu @endif">
                <div class="iocn-link">
                    <a href="#">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="16" rx="3" /><path d="M7 3v4 M17 3v4 M3 10h18" /><path d="M8 15h8" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Leave Management') }}</span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m9 5 7 7-7 7" /></svg>
                    </span>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name"
                            href="{{ route('admin.leave.report') }}">{{ get_phrase('Leave Report') }}</a>
                    </li>
                    <li><a class="@if ($current_route == 'admin.leave.report') active @endif"
                            href="{{ route('admin.leave.report') }}">{{ get_phrase('Leave Report') }}</a> </li>
                    @can('holiday-list')
                        <li><a class="@if ($current_route == 'admin.holiday.index') active @endif"
                                href="{{ route('admin.holiday.index') }}">{{ get_phrase('Holiday') }}</a> </li>
                    @endcan
                    @can('leave-type-list')
                        <li><a class="@if ($current_route == 'admin.type.index') active @endif"
                                href="{{ route('admin.type.index') }}">{{ get_phrase('Leave Type') }}</a> </li>
                    @endcan

                </ul>
            </li>
        @endcanany

        @can('employees-list')
            <li class="nav-links-li @if ($current_route == 'admin.staffs' || $current_route == 'admin.staff.profile') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.staffs') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="M16 5a3 3 0 0 1 0 6 M18 15a5 5 0 0 1 3 4v2" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Employees') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan


        @can('policy-list')
            <li class="nav-links-li @if ($current_route == 'admin.policy.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.policy.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z" /><path d="m8 13 3 3 5-6" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Policy') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('salary-list')
            <li class="nav-links-li @if ($current_route == 'admin.payslip') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.payslip') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 11h7 M8 13h7 M9 11c5 0 5 5 0 5l5 3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Salary') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan
        {{--
        <li class="nav-links-li @if ($current_route == 'admin.performance') showMenu @endif">
            <div class="iocn-link">
                <a class="w-100" href="{{ route('admin.performance') }}">
                    <div class="sidebar_icon">

                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 17l6-6 4 3 8-10 M15 4h6v6 M3 21h18" /></svg>
                    </div>
                    <span class="link_name">
                        {{ get_phrase('Performance') }}
                    </span>
                </a>
            </div>
        </li>



        <li class="nav-links-li @if ($current_route == 'admin.tasks') showMenu @endif">
            <div class="iocn-link">
                <a class="w-100" href="{{ route('admin.tasks', ['running']) }}">
                    <div class="sidebar_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4" y="4" width="16" height="17" rx="3" /><rect x="9" y="2" width="6" height="4" rx="1.5" /><path d="m7 11 1 1 2-2 M13 11h4 m-10 5 1 1 2-2 M13 16h4" /></svg>
                    </div>
                    <span class="link_name">
                        {{ get_phrase('Task Manager') }}
                    </span>
                </a>
            </div>
        </li>
 --}}

        @can('branch-list')
            <li class="nav-links-li @if ($current_route == 'admin.branch') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.branch') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 8v5 M5 17v-4h14v4" /><rect x="9" y="2" width="6" height="6" rx="1.5" /><rect x="2" y="17" width="6" height="5" rx="1.5" /><rect x="16" y="17" width="6" height="5" rx="1.5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Branch') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('kra-list')
            <li class="nav-links-li @if ($current_route == 'admin.kra.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.kra.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9" /><circle cx="12" cy="12" r="5" /><circle cx="12" cy="12" r="1" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Kra') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('kpi-list')
            <li class="nav-links-li @if ($current_route == 'admin.kpi.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.kpi.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 3v18h18 M7 17v-5 M12 17V8 M17 17V5" /><circle cx="18" cy="6" r="3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Kpi') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan





        <!-- menu starts here -->

        @canany(['invoice-list', 'purchase-bill-list', 'tax-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Accounting</h6>
        @endcanany



        @can('invoice-list')
            <li class="nav-links-li @if ($current_route == 'admin.invoice.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.invoice.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 12h8 M8 16h5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Invoice') }}
                        </span>
                    </a>
                </div>
            </li>

            <li class="nav-links-li @if ($current_route == 'admin.receivable.show') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.receivable.show') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="15" rx="3" /><path d="M12 10v7 m-3-3 3 3 3-3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Receivable') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('payable-list')
            <li class="nav-links-li">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.payables.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="15" rx="3" /><path d="M12 17V9 m-3 3 3-3 3 3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Payable') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        {{-- @can('suspense-entry-list')
            <li class="nav-links-li @if ($current_route == 'admin.suspense.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.suspense.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M10 12a2 2 0 1 1 3 1.7L12 15 M12 18h.01" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Suspense Entry') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan --}}



        <!--@can('tax-list')
    -->
            <!--    <li class="nav-links-li @if ($current_route == 'admin.tax.index') showMenu @endif">-->
            <!--        <div class="iocn-link">-->
            <!--            <a class="w-100" href="{{ route('admin.tax.index') }}">-->
            <!--                <div class="sidebar_icon">-->
            <!--                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 12h8 M8 16h8 M8 8h2" /></svg>-->
            <!--                </div>-->
            <!--                <span class="link_name">-->
            <!--                    {{ get_phrase('Billing Details') }}-->
            <!--                </span>-->
            <!--            </a>-->
            <!--        </div>-->
            <!--    </li>-->
            <!--
@endcan-->

        @canany(['vendor-list', 'vendor-contract-list', 'payment-terms-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Supplier & Vendor</h6>
        @endcanany
        <!-- Vendors -->
        @can('vendor-list')
            <li class="nav-links-li">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="7" width="18" height="14" rx="3" /><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2 M3 12a20 20 0 0 0 18 0 M12 12v3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Vendors') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- Vendors Contract -->
        @can('vendor-contract-list')
            <li class="nav-links-li">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.contract') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="m8 17 2-3 3 2 3-3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Vendors Contract') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- Vendor Terms Payment -->
        @can('payment-terms-list')
            <li class="nav-links-li">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendorterm.payment') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="16" rx="3" /><path d="M7 3v4 M17 3v4 M3 10h18" /><path d="M8 11h7 M8 13h7 M9 11c5 0 5 5 0 5l5 3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Vendor Terms Payment') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan


        @canany(['lead-category-list', 'lead-list', 'deals-list', 'email-template-list', 'subscriber-list',
            'email-automation-list', 'organization-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">CRM</h6>
        @endcanany

        {{--  --}}

       @can('organization-list')
            <li class="nav-links-li @if ($current_route == 'admin.quotation.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.quotation.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 11h7 M8 13h7 M9 11c5 0 5 5 0 5l5 3" /></svg>
                        </div>

                        <span class="link_name">
                            {{ get_phrase('Quotation') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan



        {{--  --}}
        
       
        
        
       
        
      
       {{-- Proposal Categories --}}
@can('organization-list')
    <li class="nav-links-li @if ($current_route == 'admin.quotation-categories.index') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.quotation-categories.index') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="3" width="7" height="7" rx="2" /><rect x="14" y="3" width="7" height="7" rx="2" /><rect x="3" y="14" width="7" height="7" rx="2" /><rect x="14" y="14" width="7" height="7" rx="2" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Proposal Categories') }}
                </span>
            </a>
        </div>
    </li>
@endcan

{{-- Detailed Proposal --}}
@can('organization-list')
    <li class="nav-links-li @if ($current_route == 'admin.detailed-quotations.index') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.detailed-quotations.index') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 12h8 M8 16h3 m3 2 2 2 4-5" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Detailed Proposal') }}
                </span>
            </a>
        </div>
    </li>
@endcan

{{-- Organization --}}
@can('organization-list')
    <li class="nav-links-li @if ($current_route == 'admin.company.index') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.company.index') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="5" y="3" width="14" height="18" rx="2" /><path d="M9 21v-5h6v5 M9 7h1 M14 7h1 M9 11h1 M14 11h1" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Organization') }}
                </span>
            </a>
        </div>
    </li>
@endcan

{{-- Lead Category --}}
@can('lead-category-list')
    <li class="nav-links-li @if ($current_route == 'admin.leadcategory.index') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.leadcategory.index') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 3h8l10 10-8 8L3 11V3Z" /><circle cx="7.5" cy="7.5" r="1" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Lead Category') }}
                </span>
            </a>
        </div>
    </li>
@endcan
        {{--  --}}
        {{-- Leads --}}
@can('lead-list')
    <li class="nav-links-li @if ($current_route == 'admin.leads.index') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.leads.index') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="3" width="18" height="18" rx="3" /><circle cx="9" cy="9" r="2.5" /><path d="M5.5 18a3.5 3.5 0 0 1 7 0 M16 8h2 M16 12h2 M16 16h2" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Leads') }}
                </span>
            </a>
        </div>
    </li>
@endcan

{{-- Leads Actions --}}
@can('lead-list')
    <li class="nav-links-li @if ($current_route == 'admin.leads.actions.index') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.leads.actions.index') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4" y="4" width="16" height="17" rx="3" /><rect x="9" y="2" width="6" height="4" rx="1.5" /><path d="m7 11 1 1 2-2 M13 11h4 m-10 5 1 1 2-2 M13 16h4" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Leads Actions') }}
                </span>
            </a>
        </div>
    </li>
@endcan

{{-- Leads Import and Upload History --}}
@can('leads-import-upload-history')
    <li class="nav-links-li @if ($current_route == 'admin.leads.import.history') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.leads.import.history') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M12 17V9 m-3 3 3-3 3 3" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Leads Import-Uploads History') }}
                </span>
            </a>
        </div>
    </li>
@endcan




        {{--  --}}

        @can('lead-list')
            <li class="nav-links-li @if ($current_route == 'admin.lead.rejected') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.lead.rejected') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="m16 15 5 5 M21 15l-5 5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Rejected Leads') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        {{-- Today Follow up --}}
@can('lead-list')
    <li class="nav-links-li @if ($current_route == 'admin.leads.callagain') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.leads.callagain') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M8 3H5a2 2 0 0 0-2 2c0 8.84 7.16 16 16 16a2 2 0 0 0 2-2v-3l-5-2-2 2a13 13 0 0 1-6-6l2-2-2-5Z" /><circle cx="17" cy="7" r="5" /><path d="M17 4.5V7l1.5 1" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Today Follow up') }}
                </span>
            </a>
        </div>
    </li>
@endcan

{{-- Today Meetings --}}
@can('lead-list')
    <li class="nav-links-li @if ($current_route == 'admin.leads.today_meetings') showMenu @endif">
        <div class="iocn-link">
            <a class="w-100" href="{{ route('admin.leads.today_meetings') }}">
                <div class="sidebar_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="16" rx="3" /><path d="M7 3v4 M17 3v4 M3 10h18" /><circle cx="9" cy="14" r="1.5" /><circle cx="15" cy="14" r="1.5" /><path d="M6 19a3 3 0 0 1 6 0 M12 19a3 3 0 0 1 6 0" /></svg>
                </div>

                <span class="link_name">
                    {{ get_phrase('Today Meetings') }}
                </span>
            </a>
        </div>
    </li>
@endcan



        
        


        @can('lead-list')
            <li class="nav-links-li @if ($current_route == 'admin.salespipeline') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.salespipeline') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 3h18l-7 8v7l-4 3V11L3 3Z" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Sales Pipeline') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- menu starts here -->
        @can('deals-list')
            <li class="nav-links-li @if ($current_route == 'admin.deals.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.deals.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="7" width="18" height="14" rx="3" /><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2 M3 12a20 20 0 0 0 18 0 M12 12v3" /><path d="m8 13 3 3 5-6" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Deals') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('email-template-list')
            <li class="nav-links-li @if ($current_route == 'admin.emailtemplate.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.emailtemplate.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="3" /><path d="m3 6 9 7 9-7" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Email Template') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('subscriber-list')
            <li class="nav-links-li @if ($current_route == 'admin.subscriber.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.subscriber.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="m16 16 2 2 4-5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Subscriber') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('email-automation-list')
            <li class="nav-links-li @if ($current_route == 'admin.emailautomation.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.emailautomation.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="3" /><path d="m3 6 9 7 9-7" /><path d="m13 8-3 5h4l-3 4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Email Automation') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @canany(['product-list', 'stockmovement-list', 'production-order-list', 'bom-list', 'grn-list',
            'production-consumption-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Stock Management</h6>
        @endcanany

        <!-- Inventory -->
        @can('product-list')
            <li class="nav-links-li @if ($current_route == 'admin.product.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.product.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Inventory') }}</span>
                    </a>
                </div>
            </li>
            {{--
            <li class="nav-links-li @if ($current_route == 'admin.warehouse.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.warehouse.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 21V9l9-6 9 6v12 M3 10h18 M8 21v-7h8v7 M8 17h8" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Warehouse') }}</span>
                    </a>
                </div>
            </li> --}}
        @endcan

        <!-- Stock Movement -->
        {{-- @can('stockmovement-list')
            <li class="nav-links-li @if ($current_route == 'admin.stockmovement.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.stockmovement.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="M2 3h5 m-2-2 2 2-2 2 M17 21h5 m-2-2 2 2-2 2" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Stock Movement') }}</span>
                    </a>
                </div>
            </li>
        @endcan --}}

        <!-- Production Orders -->
        @can('production-order-list')
            <li class="nav-links-li @if ($current_route == 'admin.productionorder.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.productionorder.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4" y="4" width="16" height="17" rx="3" /><rect x="9" y="2" width="6" height="4" rx="1.5" /><path d="m7 11 1 1 2-2 M13 11h4 m-10 5 1 1 2-2 M13 16h4" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Production Orders') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- BOM -->
        @can('bom-list')
            <li class="nav-links-li @if ($current_route == 'admin.bom.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.bom.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 10 5-10 5L2 8l10-5Z M2 12l10 5 10-5 M2 16l10 5 10-5" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Bom') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- GRN -->
        @can('grn-list')
            <li class="nav-links-li @if ($current_route == 'admin.grn.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.grn.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="m8 13 3 3 5-6" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('GRN') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- Production Consumption -->
        @can('production-consumption-list')
            <li class="nav-links-li @if ($current_route == 'admin.productionconsumption.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.productionconsumption.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 21V10l6 3V9l6 4V5h4l2 16H3Z M7 17h1 M12 17h1 M17 17h1" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Production Consumption') }}</span>
                    </a>
                </div>
            </li>
        @endcan


        @canany(['vendor-return-list', 'vendor-return-create', 'vendor-return-edit', 'vendor-return-delete'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Wastage requests</h6>
        @endcanany

        @can('vendor-return-list')
            <li class="nav-links-li @if ($current_route == 'admin.vendor.return.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.return.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="M2 3h6 M2 3v5 M2 3l5 5" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Requested') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        @can('vendor-return-list')
            <li class="nav-links-li @if ($current_route == 'admin.vendor.return.rejected') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.return.rejected') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="m9 11 6 6 M15 11l-6 6" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Rejected') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        @can('vendor-return-list')
            <li class="nav-links-li @if ($current_route == 'admin.vendor.return.approved') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.return.approved') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="m8 13 3 3 5-6" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Approved') }}</span>
                    </a>
                </div>
            </li>
        @endcan


        @can('vendor-return-list')
            <li class="nav-links-li @if ($current_route == 'admin.vendor.return.collected') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.return.collected') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="M12 10v7 m-3-3 3 3 3-3" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Collected') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        @can('vendor-return-list')
            <li class="nav-links-li @if ($current_route == 'admin.vendor.return.replaced') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.vendor.return.replaced') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M4 8a8 8 0 0 1 14-3l3 3 M21 3v5h-5 M20 16a8 8 0 0 1-14 3l-3-3 M3 21v-5h5" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Replaced') }}</span>
                    </a>
                </div>
            </li>
        @endcan


        @canany(['performa-list', 'sales-order-list', 'manufacturing', 'packing-list', 'delivery-list',
            'dispatch-invoice-list', 'dispatch-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Order Pipeline</h6>
        @endcanany
        <!-- Proforma -->

        @can('performa-list')
            <li class="nav-links-li @if ($current_route == 'admin.proforma.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.proforma.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 12h5 M8 16h8" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Performa') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        @can('sales-order-list')
            <li class="nav-links-li @if ($current_route == 'admin.salesorders.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.salesorders.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="7" width="18" height="14" rx="3" /><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2 M3 12a20 20 0 0 0 18 0 M12 12v3" /><path d="M8 17h8" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Production Order') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- Production Manufacturing -->
        @can('manufacturing')
            <li class="nav-links-li @if ($current_route == 'admin.product.manufacturing') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.product.manufacturing') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 21V10l6 3V9l6 4V5h4l2 16H3Z M7 17h1 M12 17h1 M17 17h1" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Manufacturing') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        <!-- Delivery -->
        @can('packing-list')
            <li class="nav-links-li @if ($current_route == 'admin.packing.ready') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.packing.ready') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="M8 16l3 2" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Packing') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        @can('delivery-list')
            <li class="nav-links-li @if ($current_route == 'admin.delivery.ready') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.delivery.ready') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M12 12v6 M9 15h6" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Generate Invoice') }}</span>
                    </a>
                </div>
            </li>
        @endcan

        @can('disptach-invoice-list')
            <li class="nav-links-li @if ($current_route == 'admin.dispatch.invoice.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.dispatch.invoice.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 5h11v12H3V5Z M14 10h4l3 4v3h-7 M3 17H2" /><circle cx="6" cy="18" r="2" /><circle cx="18" cy="18" r="2" /><path d="M6 9h4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Dispatch ready') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan
        <!-- Dispatch -->
        @can('dispatch-list')
            <li class="nav-links-li @if ($current_route == 'admin.dispatch.list') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.dispatch.list') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 5h11v12H3V5Z M14 10h4l3 4v3h-7 M3 17H2" /><circle cx="6" cy="18" r="2" /><circle cx="18" cy="18" r="2" /><path d="M2 8h5 M1 12h4" /></svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Dispatched') }}</span>
                    </a>
                </div>
            </li>
        @endcan



        @canany(['purchase-requisition-list', 'purchase-order=list', 'purchase-bill-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Procurement</h6>
        @endcanany

        @can('purchase-requisition-list')
            <li class="nav-links-li @if ($current_route == 'admin.purchase') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.purchase.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4" y="4" width="16" height="17" rx="3" /><rect x="9" y="2" width="6" height="4" rx="1.5" /><path d="m7 11 1 1 2-2 M13 11h4 m-10 5 1 1 2-2 M13 16h4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Purchase Requisition') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('purchase-order-list')
            <li class="nav-links-li @if ($current_route == 'admin.rfq.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.rfq.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M10 12a2 2 0 1 1 3 1.7L12 15 M12 18h.01" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('RFQ(Request Quotation)') }}
                        </span>
                    </a>
                </div>
            </li>

            <li class="nav-links-li @if ($current_route == 'admin.purchaseorder') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.purchaseorder.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 3h2l3 12h11l3-8H6 M9 18h.01 M18 18h.01" /><circle cx="9" cy="20" r="1" /><circle cx="18" cy="20" r="1" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Purchase Order') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan



        @can('purchase-bill-list')
            <li class="nav-links-li @if ($current_route == 'admin.purchase.bills') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.purchase.bills') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M8 11h7 M8 13h7 M9 11c5 0 5 5 0 5l5 3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Purchase Bills') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan





        @canany(['sold-product-list', 'warranty-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Warranty</h6>
        @endcanany
        @can('sold-product-list')
            <li class="nav-links-li @if ($current_route == 'admin.warranty.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.warranty.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5" /><path d="M10 16h4" /></svg>

                        </div>
                        <span class="link_name">
                            {{ get_phrase('Product Purchase') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('warranty-list')
            <li class="nav-links-li @if ($current_route == 'admin.WarrantyClaim.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.WarrantyClaim.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z" /><path d="M12 8v5 M12 16h.01" /></svg>

                        </div>
                        <span class="link_name">
                            {{ get_phrase('Warranty Claim') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @if (auth()->user()->hasRole('Admin'))
            <li class="nav-links-li @if ($current_route == 'admin.notification-settings.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.notification-settings.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9 M10 21h4" /><circle cx="18" cy="5" r="3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Notification Setting') }}
                        </span>
                    </a>
                </div>
            </li>
        @endif

        @can('support-department-list')
            <li class="nav-links-li @if ($current_route == 'admin.support.department.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.support.department.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="M16 5a3 3 0 0 1 0 6 M18 15a5 5 0 0 1 3 4v2" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Support Department') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('support-tickets')
            <li class="nav-links-li @if ($current_route == 'admin.support.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.support.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M4 14v-3a8 8 0 0 1 16 0v7a3 3 0 0 1-3 3h-3" /><rect x="2" y="11" width="4" height="7" rx="2" /><rect x="18" y="11" width="4" height="7" rx="2" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Support') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('role-list')
            <li class="nav-links-li @if ($current_route == 'admin.role.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.role.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z" /><circle cx="12" cy="10" r="2" /><path d="M8 17a4 4 0 0 1 8 0" /></svg>

                        </div>
                        <span class="link_name">
                            {{ get_phrase('Roles') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        <li class="nav-links-li @if ($current_route == 'admin.my.profile') showMenu @endif">
            <div class="iocn-link">
                <a class="w-100" href="{{ route('admin.my.profile') }}">
                    <div class="sidebar_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="3" width="18" height="18" rx="3" /><circle cx="12" cy="9" r="3" /><path d="M6 21v-2a6 6 0 0 1 12 0v2" /></svg>
                    </div>
                    <span class="link_name">
                        {{ get_phrase('My Profile') }}
                    </span>
                </a>
            </div>
        </li>


        @canany('support-department-list')
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Subscription</h6>
        @endcanany

        @can('support-department-list')
            <li class="nav-links-li @if ($current_route == 'admin.subscription-categories.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.subscription-categories.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="3" width="7" height="7" rx="2" /><rect x="14" y="3" width="7" height="7" rx="2" /><rect x="3" y="14" width="7" height="7" rx="2" /><rect x="14" y="14" width="7" height="7" rx="2" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Subscription Categories') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('support-department-list')
            <li class="nav-links-li @if ($current_route == 'admin.service-types.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.service-types.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m10 3-.7 2.4-2 .9L5 5.6 3 9l1.8 1.7v2.6L3 15l2 3.4 2.3-.7 2 .9L10 21h4l.7-2.4 2-.9 2.3.7 2-3.4-1.8-1.7v-2.6L21 9l-2-3.4-2.3.7-2-.9L14 3h-4Z" /><circle cx="12" cy="12" r="3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Service types') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('support-department-list')
            <li class="nav-links-li @if ($current_route == 'admin.support.desubscriptionspartment.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.subscriptions.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="3" /><path d="M3 10h18 M7 15h4 M17 14v3 M15.5 15.5h3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Subscriptions') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @canany(['seo-team-task-list', 'seo-service-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Social Media</h6>
        @endcanany

        @can('seo-service-list')
            <li class="nav-links-li @if ($current_route == 'admin.special-days.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.special-days.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="16" rx="3" /><path d="M7 3v4 M17 3v4 M3 10h18" /><circle cx="12" cy="15" r="2" /><path d="M8 19h8" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Social Media Calender') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan


        {{-- seo --}}

        @canany(['seo-team-task-list', 'seo-service-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Seo Manager</h6>
        @endcanany

        @can('seo-service-list')
            <li class="nav-links-li @if ($current_route == 'admin.seo-services.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.seo-services.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="10.5" cy="10.5" r="6.5" /><path d="m16 16 5 5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Seo services') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('seo-plan-list')
            <li class="nav-links-li @if ($current_route == 'admin.seo-plans.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.seo-plans.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4" y="4" width="16" height="17" rx="3" /><rect x="9" y="2" width="6" height="4" rx="1.5" /><path d="m7 11 1 1 2-2 M13 11h4 m-10 5 1 1 2-2 M13 16h4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Seo plans') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('seo-assign-client-list')
            <li class="nav-links-li @if ($current_route == 'admin.seo-plan-clients.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.seo-plan-clients.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="M16 5a3 3 0 0 1 0 6 M18 15a5 5 0 0 1 3 4v2" /><path d="M17 12v4 M15 14h4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Seo Assign clients') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('seo-team-task-list')
            <li class="nav-links-li @if ($current_route == 'admin.seo-team-work.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.seo-team-work.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="8" r="3" /><path d="M3 21v-2a6 6 0 0 1 12 0v2" /><path d="M16 5a3 3 0 0 1 0 6 M18 15a5 5 0 0 1 3 4v2" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Seo team work') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        {{-- end seo --}}

        @canany(['backlink-categories-list', 'backlink-categories-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Backlink Manager</h6>
        @endcanany

        @can('backlink-categories-list')
            <li class="nav-links-li @if ($current_route == 'admin.backlink-categories.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.backlink-categories.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M3 3h8l10 10-8 8L3 11V3Z" /><circle cx="7.5" cy="7.5" r="1" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Backlink Categories') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('backlink-list')
            <li class="nav-links-li @if ($current_route == 'admin.backlinks.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.backlinks.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m10 13 4-4 M8 15l-1 1a3.5 3.5 0 0 1-5-5l4-4a3.5 3.5 0 0 1 5 0 M13 17a3.5 3.5 0 0 0 5 0l4-4a3.5 3.5 0 0 0-5-5l-1 1" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Backlink') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('backlink-bulk-upload')
            <li class="nav-links-li @if ($current_route == 'admin.backlinks.upload') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.backlinks.upload') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M4 16v4h16v-4 M12 16V3 M7 8l5-5 5 5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Backlink Bulk Upload') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan



        <!-- seo report -->


        <!--  -->

        @canany(['on-page-categories-list', 'on-page-categories-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">On Page Seo</h6>
        @endcanany

        @can('on-page-categories-list')
            <li class="nav-links-li @if ($current_route == 'admin.on-page-seo-category.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.on-page-seo-category.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="3" width="7" height="7" rx="2" /><rect x="14" y="3" width="7" height="7" rx="2" /><rect x="3" y="14" width="7" height="7" rx="2" /><rect x="14" y="14" width="7" height="7" rx="2" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('On Page Categories') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('on-page-seo-tasks-list')
            <li class="nav-links-li @if ($current_route == 'admin.onpage-seo-task.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.onpage-seo-task.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="m8 13 3 3 5-6" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('On Page Seo Task') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        <!--  -->
        @canany(['seo-reports'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Seo Reports</h6>
        @endcanany

        @can('seo-reports')
            <li class="nav-links-li @if ($current_route == 'admin.seo-report.index.dashboard') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.seo-report.index.dashboard') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="3" width="18" height="18" rx="3" /><path d="M3 8h18 M8 8v13 M11 17l3-4 3 2 2-4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Seo Report Dashboard') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('seo-reports')
            <li class="nav-links-li @if ($current_route == 'admin.seo-report.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.seo-report.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z M14 3v6h6" /><path d="M12 10v7 m-3-3 3 3 3-3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Seo Report Generate PDF') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan



        <!-- end seo report -->



        @canany(['project-list'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">Project Assign</h6>
        @endcanany

        @can('project-list')
            <li class="nav-links-li @if ($current_route == 'admin.projects.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.projects.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="7" width="18" height="14" rx="3" /><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2 M3 12a20 20 0 0 0 18 0 M12 12v3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Project') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan



        <!-- @can('module-requested')
    <li class="nav-links-li @if ($current_route == 'admin.modules.requests') showMenu @endif">
                    <div class="iocn-link">
                        <a class="w-100" href="{{ route('admin.modules.requests') }}">
                            <div class="sidebar_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m3 3 19 9-19 9 4-9-4-9Z M7 12h15" /></svg>
                            </div>
                            <span class="link_name">
                                {{ get_phrase('My Requests') }}
                            </span>
                        </a>
                    </div>
                </li>
@endcan -->

        @can('module-requested')
            <li class="nav-links-li @if ($current_route == 'developer.all.modules.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('developer.all.modules.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m3 3 19 9-19 9 4-9-4-9Z M7 12h15" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('My Requests') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan


        @can('module-view')
            <li class="nav-links-li @if ($current_route == 'admin.modules.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.modules.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m12 3 10 5-10 5L2 8l10-5Z M2 12l10 5 10-5 M2 16l10 5 10-5" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('My Modules') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan


        @can('module-requested')
            <li class="nav-links-li @if ($current_route == 'admin.submodules.all') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.submodules.all') }}">
                        <div class="sidebar_icon">

                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4" y="4" width="16" height="17" rx="3" /><rect x="9" y="2" width="6" height="4" rx="1.5" /><path d="m7 11 1 1 2-2 M13 11h4 m-10 5 1 1 2-2 M13 16h4" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Tasks') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan


        <!-- User projects -->

        @canany(['project-my-project'])
            <h6 style="padding-left: 38px; font-weight:600" class="pt-3 text-info2">My Projects</h6>
        @endcanany

        @can('project-my-project')
            <li class="nav-links-li @if ($current_route == 'user.projects.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('user.projects.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="7" width="18" height="14" rx="3" /><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2 M3 12a20 20 0 0 0 18 0 M12 12v3" /></svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Projects') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan





      </ul>

    {{-- =========================================
        SIDEBAR BOTTOM FIXED AREA
    ========================================== --}}
    <div class="cs-sidebar-bottom">

        {{-- Settings --}}
        <a href="#"
           class="cs-sidebar-settings"
           onclick="return false;">
            <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m10 3-.7 2.4-2 .9L5 5.6 3 9l1.8 1.7v2.6L3 15l2 3.4 2.3-.7 2 .9L10 21h4l.7-2.4 2-.9 2.3.7 2-3.4-1.8-1.7v-2.6L21 9l-2-3.4-2.3.7-2-.9L14 3h-4Z" /><circle cx="12" cy="12" r="3" /></svg>
            <span>{{ get_phrase('Settings') }}</span>
        </a>

        {{-- Logged In User --}}
        <div class="cs-sidebar-user">

            <div class="cs-sidebar-user-avatar">
                @if(auth()->user()->photo ?? false)
                    <img src="https://cdn.vectorstock.com/i/500p/22/63/a-simple-black-silhouette-of-man-in-suit-vector-55942263.jpg"
                         alt="{{ auth()->user()->name }}">
                @else
                    <div class="cs-user-placeholder">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="cs-sidebar-user-info">
                <strong>
                    {{ auth()->user()->name ?? 'User' }}
                </strong>

                <span>
                    {{ ucfirst($role ?? 'User') }}
                </span>
            </div>

            <div class="cs-sidebar-user-more">
                <svg xmlns="http://www.w3.org/2000/svg" class="cs-modern-icon cs-utility-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="5" r="1" /><circle cx="12" cy="12" r="1" /><circle cx="12" cy="19" r="1" /></svg>
            </div>

        </div>

    </div>

</div>


