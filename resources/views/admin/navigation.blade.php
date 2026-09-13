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
        <i class="fi-rr-search"></i>

        <input
            type="text"
            id="sidebarMenuSearch"
            placeholder="{{ get_phrase('Search menu') }}"
            autocomplete="off"
        >
    </div>

    <div class="closeIcon">
        <span><i class="bi bi-x-circle"></i></span>
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
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                            width="48" height="48" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="M64.671 146.502C27.711 188.049 3.457 241.62 0 300.62h60.76c3.259-42.488 20.112-81.161 46.32-111.709l-42.409-42.409zM249.305 332.188c-5.113 2.581-8.305 7.726-8.305 13.432.015 12.598 17.783 19.438 26.191 9.99l52.427-58.608-70.313 35.186zM85.882 125.291l42.409 42.409c30.548-26.208 70.221-43.061 112.709-46.32v-60c-59 3.456-113.57 26.951-155.118 63.911zM271 61.38v60c42.488 3.259 82.161 20.112 112.709 46.32l42.409-42.409C384.57 88.331 330 64.836 271 61.38zM447.329 146.502l-42.409 42.409c26.208 30.547 43.061 69.221 46.32 111.709H512c-3.457-59-27.711-112.571-64.671-154.118z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M450.731 330.62c-1.307 17.011-4.142 33.83-9.835 49.98a15.007 15.007 0 0 1-19.131 9.17c-7.822-2.754-11.924-11.323-9.17-19.131a165.1 165.1 0 0 0 9.404-55.02c0-45.487-18.501-86.733-48.375-116.611a.027.027 0 0 0-.007-.004l-.007-.011C343.733 169.12 301.487 150.62 256 150.62s-87.733 18.501-117.611 48.375l-.004.007-.011.007C108.501 228.886 90 270.133 90 315.62a165.1 165.1 0 0 0 9.404 55.02c2.754 7.808-1.348 16.377-9.17 19.131-7.749 2.739-16.362-1.362-19.131-9.17-5.693-16.15-8.527-32.968-9.835-49.98H0c2.146 36.632 11.7 67.637 25.107 95.464 7.178 14.897 22.939 24.536 40.151 24.536h381.468c17.227 0 32.988-9.639 40.181-24.551 13.239-27.556 23.031-60.256 25.093-95.449h-61.269zm-55.333-72.217L289.545 375.62c-27.25 30.48-78.545 11.411-78.545-30 0-17.124 9.525-32.536 24.838-40.23.02-.009.029-.029.049-.038l141.625-70.371c.049-.024.101-.016.15-.04 14.508-7.072 28.789 10.752 17.736 23.462z"
                                    fill="#000000" data-original="#000000" class=""></path>
                            </g>
                        </svg>
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
                            <svg id="fi_50044" style="enable-background:new 0 0 612 612;" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                y="0px" width="48" height="48" viewBox="0 0 612 612" xml:space="preserve">
                                <g>
                                    <path
                                        d="M257.254,316.536c84.086,0,152.252-68.166,152.252-152.252S341.341,12.031,257.254,12.031
                                                                                          c-84.087,0-152.253,68.166-152.253,152.252S173.167,316.536,257.254,316.536z M330.946,224.34
                                                                                          c-6.927,22.9-36.596,40.115-72.154,40.115c-35.559,0-65.228-17.215-72.153-40.115H330.946z M608.234,481.521L468.934,597.613
                                                                                          c-4.052,3.377-10.418,3.088-14.147-0.642l-69.355-69.364c-4.083-4.084-4.083-10.766,0.001-14.85l14.847-14.847
                                                                                          c4.083-4.083,10.766-4.084,14.849-0.001l49.024,49.016L581.35,449.26c4.437-3.696,11.091-3.092,14.788,1.345l13.441,16.127
                                                                                          C613.275,471.168,612.671,477.823,608.234,481.521z M369.096,543.941l26.415,26.419c-36.051,5.076-81.493,8.68-138.256,8.68
                                                                                          c-146.803,0-218.644-23.987-244.982-35.706C5.477,540.31,0,531.665,0,524.227v-50.188c0-75.205,57.26-137.596,130.325-145.953
                                                                                          c2.22-0.254,5.513,0.696,7.322,2.007c33.688,24.389,74.932,38.944,119.607,38.944s85.919-14.556,119.607-38.944
                                                                                          c1.81-1.311,5.102-2.261,7.322-2.007c73.065,8.356,130.326,70.747,130.326,145.953v0.849l-48.942,40.782l-34.105-34.094
                                                                                          c-6.348-6.348-14.787-9.845-23.759-9.845s-17.411,3.497-23.759,9.845l-14.848,14.848
                                                                                          C355.99,509.528,355.99,530.837,369.096,543.941z">
                                    </path>
                                </g>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor"
                                class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                            </svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Recruitment') }}</span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                            <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                                d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                                fill="#fff" opacity="1" />
                        </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-file-person" viewBox="0 0 16 16">
                                <path
                                    d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Onboarding') }}</span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                            <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                                d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                                fill="#fff" opacity="1" />
                        </svg>
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
                            <svg width="48" height="48" version="1.1" id="fi_198141"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                y="0px" viewBox="-100 0 550 512" style="enable-background:new 0 0 512 512;"
                                xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M501.084,295.982h-17.462c0-8.398,0-13.914,0-22.126c0-5.57-4.515-10.086-10.086-10.086h-5.964
                                                c0.709-8.717-4.914-16.938-13.672-19.189c-6.96-1.789-50.851-13.07-57.62-14.81l18.561-48.611
                                                c5.374-14.076-1.673-29.852-15.761-35.231l-42.49-16.44c-8.143-3.151-16.891-3.956-25.479-2.38
                                                c-33.716,6.185-89.129,16.352-95.531,17.522c-4.233,0.774-8.056,3.014-10.802,6.327l-37.719,45.523V59.369
                                                c0-5.358-3.535-10.072-8.678-11.573l-81.14-23.68h210.377v89.025l24.112-3.15V12.06c0-6.658-5.398-12.056-12.056-12.056
                                                c-1.709,0-306.832-0.027-307.764,0.05C5.526,0.58,0.841,5.946,0.841,12.06c0,2.958-0.057,440.79,0.104,442.075
                                                c0.613,4.872,4.095,8.755,8.575,10.064l162.107,47.309c7.723,2.257,15.433-3.561,15.433-11.573V250.25
                                                c2.794-1.093,5.367-2.864,7.416-5.339l54.243-65.467c6.603-1.207,53.019-9.697,60.479-11.061l-40.764,106.762
                                                c0,0,1.453-3.672-25.712,89.318l-31.614,60.093v56.934h0.001c9.305,2.27,19.27-1.977,23.908-10.795l46.438-88.273
                                                c0.663-1.259,1.197-2.582,1.597-3.948l25.689-87.938c1.868,0.713,0.948,0.362,5.789,2.21c6.469,10.16,38.31,60.168,44.751,70.286
                                                l-32.169,90.604c-3.94,11.096,1.861,23.286,12.958,27.226c11.036,3.919,23.279-1.841,27.226-12.958l35.651-100.411
                                                c2.143-6.038,1.503-12.917-2.107-18.585l-31.286-49.137c4.559-11.941,9.003-23.58,13.584-35.578
                                                c17.371,4.465,28.807,7.405,28.807,7.405l-0.263,24.386H394.22c-2.269,0-4.355,0.759-6.039,2.022l26.713,41.955
                                                c6.327,9.937,7.695,22.004,3.754,33.106l-4.437,12.498h86.875c5.569,0,10.083-4.515,10.083-10.083v-69.414
                                                C511.169,300.497,506.654,295.982,501.084,295.982z M152.698,316.97c0,6.658-5.398,12.056-12.056,12.056
                                                c-6.658,0-12.056-5.398-12.056-12.056v-69.596c0-6.658,5.398-12.056,12.056-12.056c6.658,0,12.056,5.398,12.056,12.056V316.97z
                                                 M463.453,295.982h-0.001h-31.599v-12.041h31.6V295.982z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M315.805,325.767l-8.188,28.028v86.777h-37.929l-12.685,24.113h52.405c-0.579-5.552,0.081-11.207,2.005-16.624
                                                l20.318-57.222v-40.06L315.805,325.767z">
                                        </path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path
                                            d="M416.914,50.634c-20.845-7.959-44.195,2.487-52.154,23.332c-8.029,21.025,2.701,44.277,23.332,52.154
                                                c20.656,7.888,44.136-2.332,52.154-23.332C448.204,81.943,437.759,58.593,416.914,50.634z">
                                        </path>
                                    </g>
                            </svg>
                        </div>
                        <span class="link_name">{{ get_phrase('Leave Management') }}</span>
                    </a>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4.743" height="7.773" viewBox="0 0 4.743 7.773">
                            <path id="navigate_before_FILL0_wght600_GRAD0_opsz24"
                                d="M1.466.247,4.5,3.277a.793.793,0,0,1,.189.288.92.92,0,0,1,0,.643A.793.793,0,0,1,4.5,4.5l-3.03,3.03a.828.828,0,0,1-.609.247.828.828,0,0,1-.609-.247.875.875,0,0,1,0-1.219L2.668,3.886.247,1.466A.828.828,0,0,1,0,.856.828.828,0,0,1,.247.247.828.828,0,0,1,.856,0,.828.828,0,0,1,1.466.247Z"
                                fill="#fff" opacity="1" />
                        </svg>
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
                            <svg id="fi_6462992" height="48" viewBox="0 0 32 32" width="48"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="team">
                                    <path
                                        d="m6 17c-2.2055664 0-4-1.7939453-4-4s1.7944336-4 4-4 4 1.7939453 4 4-1.7944336 4-4 4zm1.7700195.6699219c-1.1401367.4404297-2.3999023.4404297-3.5400391 0-.2900391-.1103516-.6201172-.0703125-.8798828.0898438-1.4702148.930664-2.3500976 2.5097656-2.3500976 4.2402343v4c0 .5498047.4501953 1 1 1h5v-5c0-1.5498047.4101563-3.0595703 1.1499023-4.3798828-.1298828-.0205078-.2597656 0-.3798828.0498047zm18.2299805-.6699219c2.2055664 0 4-1.7939453 4-4s-1.7944336-4-4-4-4 1.7939453-4 4 1.7944336 4 4 4zm2.6499023.7597656c-.2597656-.1601563-.5898438-.2001953-.8798828-.0898438-1.1401367.4404297-2.3999023.4404297-3.5400391 0-.1201172-.0498047-.25-.0703125-.3798828-.0498047.7397462 1.3203126 1.1499024 2.8300782 1.1499024 4.3798829v5h5c.5498047 0 1-.4501953 1-1v-4c0-1.7304687-.8798828-3.3095703-2.3500977-4.2402344zm-12.6499023-2.7597656c-2.7568359 0-5-2.2431641-5-5s2.2431641-5 5-5 5 2.2431641 5 5-2.2431641 5-5 5zm7 7c0-2.2304688-1.0698242-4.3300781-2.8701172-5.6396484-.2998047-.2207031-.699707-.25-1.0297852-.0908203-.6699218.3408203-1.3798828.5507812-2.1000976.6503906v5.0800781c0 .5498047-.4501953 1-1 1s-1-.4501953-1-1v-5.0800781c-.7202148-.0996094-1.4301758-.3095703-2.1000977-.6503906-.3300781-.1591797-.7299805-.1298828-1.0297852.0908203-1.8002929 1.3095703-2.8701171 3.4091797-2.8701171 5.6396484v5h14z">
                                    </path>
                                </g>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                <path
                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                <path
                                    d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.7 11.7 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.245.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 7.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z" />
                            </svg>
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
                            <svg height="48" width="48" version="1.1" id="fi_726182"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                xml:space="preserve">
                                <g>
                                    <g>
                                        <polygon points="320,0 320,128 448,128 		"></polygon>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M320,160c-17.632,0-32-14.368-32-32V0H96C78.368,0,64,14.368,64,32v448c0,17.664,14.368,32,32,32h320
                                                c17.664,0,32-14.336,32-32V160H320z M176,97.984V80c0-8.832,7.168-16,16-16c8.832,0,16,7.168,16,16v18.016
                                                c10.016,2.272,19.36,6.496,27.072,12.768c6.88,5.568,7.904,15.648,2.304,22.496c-5.6,6.88-15.68,7.872-22.496,2.304
                                                C208.832,130.688,200.704,128,192,128c-17.344,0-32,10.976-32,24s14.656,24,32,24c35.296,0,64,25.12,64,56
                                                c0,26.016-20.48,47.744-48,54.016V304c0,8.832-7.168,16-16,16c-8.832,0-16-7.168-16-16v-18.016
                                                c-10.016-2.272-19.36-6.496-27.072-12.768c-6.88-5.6-7.904-15.68-2.304-22.528c5.6-6.912,15.648-7.872,22.496-2.304
                                                C175.168,253.312,183.296,256,192,256c17.344,0,32-10.976,32-24s-14.656-24-32-24c-35.296,0-64-25.12-64-56
                                                C128,125.984,148.48,104.256,176,97.984z M368,448H144c-8.832,0-16-7.168-16-16c0-8.832,7.168-16,16-16h224
                                                c8.832,0,16,7.168,16,16C384,440.832,376.832,448,368,448z M368,384H144c-8.832,0-16-7.168-16-16c0-8.832,7.168-16,16-16h224
                                                c8.832,0,16,7.168,16,16C384,376.832,376.832,384,368,384z M368,320h-64c-8.832,0-16-7.168-16-16c0-8.832,7.168-16,16-16h64
                                                c8.832,0,16,7.168,16,16C384,312.832,376.832,320,368,320z M368,256h-64c-8.832,0-16-7.168-16-16c0-8.832,7.168-16,16-16h64
                                                c8.832,0,16,7.136,16,16C384,248.832,376.832,256,368,256z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
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

                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                            width="48" height="48" x="0" y="0" viewBox="0 0 60 60"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path
                                    d="M31 8.259a2.077 2.077 0 0 1 1.086 1.654l.215 2.254a17.909 17.909 0 0 1 9.692 4.426l4.222-4.223A23.985 23.985 0 0 0 31 6.048ZM27.7 12.167l.215-2.267A2.07 2.07 0 0 1 29 8.259V6.048a23.989 23.989 0 0 0-15.216 6.322l4.223 4.223a17.909 17.909 0 0 1 9.693-4.426ZM6.086 27.935a.953.953 0 0 0 .255.734A1.016 1.016 0 0 0 7.09 29h4.02a1.019 1.019 0 0 0 1-.936A17.9 17.9 0 0 1 16.588 18l-4.215-4.215a23.807 23.807 0 0 0-6.287 14.15ZM37.979 45.916l-4.264-.645a1 1 0 0 1-.754-.56l-1.906-4.017a1.149 1.149 0 0 0-2.11 0l-1.906 4.017a1 1 0 0 1-.754.56l-4.264.644a1.187 1.187 0 0 0-.949.831 1.3 1.3 0 0 0 .3 1.351l3.085 3.127a.994.994 0 0 1 .274.865l-.726 4.411a1.277 1.277 0 0 0 .516 1.281 1.092 1.092 0 0 0 1.186.071l3.814-2.084a.994.994 0 0 1 .958 0l3.814 2.085a1.1 1.1 0 0 0 1.186-.072 1.277 1.277 0 0 0 .516-1.281l-.728-4.415a.994.994 0 0 1 .274-.865l3.085-3.12a1.3 1.3 0 0 0 .3-1.351 1.185 1.185 0 0 0-.947-.833ZM57.447 49.435l-3.2-.485a1 1 0 0 1-.754-.559l-1.43-3.013a.611.611 0 0 0-1.13 0l-1.43 3.013a1 1 0 0 1-.754.559l-3.2.484a.646.646 0 0 0-.513.454.742.742 0 0 0 .167.759l2.313 2.345a1 1 0 0 1 .275.865l-.546 3.312a.716.716 0 0 0 .284.716.568.568 0 0 0 .627.038l2.86-1.563a.994.994 0 0 1 .958 0l2.86 1.564a.569.569 0 0 0 .627-.039.716.716 0 0 0 .284-.716l-.545-3.312a1 1 0 0 1 .275-.865l2.313-2.345a.742.742 0 0 0 .167-.759.644.644 0 0 0-.508-.453ZM48.89 29h4.02a1.016 1.016 0 0 0 .749-.331.953.953 0 0 0 .255-.733 23.807 23.807 0 0 0-6.287-14.149L43.412 18A17.9 17.9 0 0 1 47.9 28.064a1.019 1.019 0 0 0 .99.936Z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M30 2A28.032 28.032 0 0 0 2 30a2.986 2.986 0 0 0 3 3h21.026a4.914 4.914 0 0 1 .29-6.352L27.5 14.206a15.967 15.967 0 0 0-13.41 14.069A3.015 3.015 0 0 1 11.11 31H7.09a3.022 3.022 0 0 1-2.223-.979 2.966 2.966 0 0 1-.773-2.257 26 26 0 0 1 51.812 0 2.965 2.965 0 0 1-.773 2.256 3.022 3.022 0 0 1-2.223.98h-4.02a3.015 3.015 0 0 1-2.984-2.725A15.967 15.967 0 0 0 32.5 14.206l1.188 12.442A4.914 4.914 0 0 1 33.974 33H55a2.967 2.967 0 0 0 3-2.906V30A28.032 28.032 0 0 0 30 2Z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="m29.906 10.087-1.45 15.182a4.566 4.566 0 0 1 3.088 0L30.1 10.1a.1.1 0 0 0-.194-.013Z"
                                    fill="#000000" data-original="#000000" class=""></path>
                                <circle cx="30" cy="30" r="3" fill="#000000" data-original="#000000"
                                    class=""></circle>
                                <path
                                    d="M4.25 57.169a.716.716 0 0 0 .284.716.568.568 0 0 0 .627.038l2.86-1.563a.994.994 0 0 1 .958 0l2.86 1.564a.569.569 0 0 0 .627-.039.716.716 0 0 0 .284-.716l-.55-3.312a1 1 0 0 1 .275-.865l2.313-2.345a.742.742 0 0 0 .167-.759.644.644 0 0 0-.512-.453l-3.2-.485a1 1 0 0 1-.754-.559l-1.43-3.013a.611.611 0 0 0-1.13 0l-1.43 3.013a1 1 0 0 1-.754.559l-3.2.484a.646.646 0 0 0-.513.454.742.742 0 0 0 .167.759l2.313 2.345a1 1 0 0 1 .275.865Z"
                                    fill="#fff" data-original="#fff" class=""></path>
                            </g>
                        </svg>
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
                        <svg id="fi_3031267" enable-background="new 0 0 507.926 507.926" height="48"
                            viewBox="0 0 507.926 507.926" width="48" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="m161.618 57.722h-138.523c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087h138.523c12.751 0 23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087zm-23.087 138.523h-92.349v-92.349h92.349z">
                                </path>
                                <path
                                    d="m484.839 126.983h-230.872c-12.751 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.336 23.087-23.087 0-12.75-10.337-23.087-23.087-23.087z">
                                </path>
                                <path
                                    d="m484.839 357.855h-230.872c-12.751 0-23.087 10.337-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.337 23.087-23.087s-10.337-23.087-23.087-23.087z">
                                </path>
                                <path
                                    d="m145.457 318.353-76.857 75.934-28.905-30.013c-8.868-9.168-23.489-9.411-32.657-.543-9.168 8.868-9.411 23.489-.543 32.657l45.112 46.89c4.302 4.389 10.177 6.882 16.323 6.926h.277c6.053-.019 11.857-2.415 16.161-6.672l93.411-92.349c9.664-8.317 10.756-22.895 2.439-32.559s-22.895-10.756-32.559-2.439c-.781.673-1.517 1.397-2.202 2.168z">
                                </path>
                            </g>
                        </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                width="48" height="48" x="0" y="0" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path
                                        d="M432 88a40.045 40.045 0 0 0-40 40c0 28.422 15.751 54.325 39.991 83.582C465.005 171.535 472 149 472 128a40.045 40.045 0 0 0-40-40Zm0 64a24 24 0 1 1 24-24 24.028 24.028 0 0 1-24 24ZM248 288a40 40 0 0 0-80 0c0 28.422 15.751 54.325 39.991 83.582C241.005 331.535 248 309 248 288Zm-64 0a24 24 0 1 1 24 24 24.028 24.028 0 0 1-24-24Z"
                                        fill="#000000" data-original="#000000" class=""></path>
                                    <circle cx="208" cy="288" r="8" fill="#000000" data-original="#000000"
                                        class=""></circle>
                                    <circle cx="432" cy="128" r="8" fill="#000000" data-original="#000000"
                                        class=""></circle>
                                    <path
                                        d="M303.715 357.622c-6.251-11.491-22.6-18.782-48.6-21.671q-1.6-.177-3.17-.343c-8.779 17.575-21.9 34.965-37.872 53.6a8 8 0 0 1-12.148 0c-12.918-15.072-23.969-29.332-32.37-43.534-2.6 4.194-3.757 10.53-1.711 20.759 2.615 13.087 15.468 25.111 30.351 39.035 20.657 19.326 43.889 41.066 49.227 74.352 2.851.111 5.708.182 8.577.182 6.433 0 12.82-.3 19.154-.848 2.859-16.537 9.853-51.063 21.691-74.731 10.42-20.839 12.667-36.148 6.871-46.801Z"
                                        fill="#000000" data-original="#000000" class=""></path>
                                    <path
                                        d="M319.277 279.633c-18.386-9.365-35.754-18.212-46.137-35.517-11.509-19.182-12.333-40.387-2.262-58.176C282.731 165.005 307.685 152 336 152c11.366 0 25.3-2.457 41.487-7.3A94.819 94.819 0 0 1 376 128a55.713 55.713 0 0 1 12.193-34.825Q379.868 86.728 371 81.147c-13.689 23.927-32.134 34.782-52.572 30.7-15.289-3.058-26.489 5.607-38.337 14.783-9.2 7.123-19.886 15.4-32.4 15.4-6.349 0-13.167-2.132-20.5-7.63a27.783 27.783 0 0 1-11.074-19.24c-2.59-19.26 11.3-45.06 26.511-66.75a213.036 213.036 0 0 0-74.887 18.4c.158 1.711.25 3.442.25 5.194a97.712 97.712 0 0 1-5.224 31.25c19.669 19.983 26.928 42.909 20.986 66.689-8.462 33.845-27.129 49-43.6 62.362C123.813 245.57 112 255.158 112 280c0 26.369-1.327 51.107-17.351 64.019-7.055 5.684-16.086 8.494-27.688 8.494q-3.949 0-8.309-.439a216.624 216.624 0 0 0 172.237 126.477c-5.657-25.862-24.919-43.9-43.624-61.4-16.193-15.149-31.488-29.458-35.11-47.581-3.446-17.232-.256-30.332 9.47-39.094C155.452 316.738 152 302.805 152 288a56 56 0 0 1 112 0 98.028 98.028 0 0 1-5.547 32.235c31.025 3.695 50.442 13.428 59.317 29.741 8.481 15.588 6.317 35.739-6.615 61.6-9.912 19.815-16.254 48.556-19.375 65.478a214.392 214.392 0 0 0 116.662-60.034c-10.944-16.284-19.109-37.578-24.287-63.452-9.105-45.528-37.455-59.968-64.878-73.935Z"
                                        fill="#000000" data-original="#000000" class=""></path>
                                    <path
                                        d="M438.074 229.206a8 8 0 0 1-12.148 0c-20.614-24.052-36.491-46.035-44.394-69.016C364.055 165.37 348.767 168 336 168c-22.562 0-42.18 9.9-51.2 25.823-7.257 12.817-6.526 27.754 2.058 42.061 8.019 13.365 22.691 20.839 39.679 29.492 27.926 14.224 62.68 31.925 73.306 85.055 4.428 22.13 11.094 40.406 19.844 54.522a216.348 216.348 0 0 0 42.285-206.159c-6.898 9.915-14.947 19.968-23.898 30.412Z"
                                        fill="#000000" data-original="#000000" class=""></path>
                                    <circle cx="112" cy="72" r="8" fill="#000000" data-original="#000000"
                                        class=""></circle>
                                    <path
                                        d="M231.983 113.027a12.015 12.015 0 0 0 4.817 8.573c11.532 8.648 18.6 3.912 33.5-7.622 12.837-9.943 28.809-22.312 51.272-17.824 16.127 3.223 27.869-9.469 35.582-23.014a215.81 215.81 0 0 0-94.495-25.026c-21.309 28.11-32.459 51.648-30.676 64.913ZM152 72a40 40 0 0 0-80 0c0 28.422 15.751 54.325 39.991 83.582C145.005 115.535 152 93 152 72Zm-64 0a24 24 0 1 1 24 24 24.028 24.028 0 0 1-24-24Z"
                                        fill="#000000" data-original="#000000" class=""></path>
                                    <path
                                        d="M84.61 331.56C94.1 323.918 96 306.166 96 280c0-32.463 17.325-46.524 34.08-60.122 15.237-12.366 30.992-25.153 38.159-53.818 4.092-16.377-.033-31.986-12.25-46.539-8.779 17.6-21.92 35.022-37.915 53.685a8 8 0 0 1-12.148 0 366.135 366.135 0 0 1-26.3-33.931A213.785 213.785 0 0 0 40 264a216.274 216.274 0 0 0 11.88 70.942c15.599 2.875 26.34 1.767 32.73-3.382Z"
                                        fill="#000000" data-original="#000000" class=""></path>
                                </g>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                <path
                                    d="M9.293 0H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6.707L9.293 0zM8 1.5L12.5 6H8V1.5zM4 4h8v1H4V4zm0 2h8v1H4V6zm0 2h8v1H4V8zm0 2h8v1H4v-1zm0 2h8v1H4v-1z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                <path
                                    d="M9.293 0H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6.707L9.293 0zM8 1.5L12.5 6H8V1.5zM4 4h8v1H4V4zm0 2h8v1H4V6zm0 2h8v1H4V8zm0 2h8v1H4v-1zm0 2h8v1H4v-1z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                <path
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                <path
                                    d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-cash-stack" viewBox="0 0 16 16">
                                <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                <path
                                    d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-cash-coin" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                <path
                                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                <path
                                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247m2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
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
            <!--                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"-->
            <!--                        class="bi bi-percent" viewBox="0 0 16 16">-->
            <!--                        <path-->
            <!--                            d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0M4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />-->
            <!--                    </svg>-->
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-people" viewBox="0 0 16 16">
                                <path
                                    d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72a.274.274 0 0 1-.022.005z" />
                                <path
                                    d="M11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm-5 2a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm-3 5c0-1.164.413-2.29 1.155-3.143a4.933 4.933 0 0 1 2.79-1.108A4.933 4.933 0 0 0 3 14z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5z" />
                                <path d="M9.5 3V1L14 5h-2.5A2 2 0 0 1 9.5 3z" />
                                <path
                                    d="M4.5 9h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1zm0 2h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-cash-coin" viewBox="0 0 16 16">
                                <path d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                                <path
                                    d="M11 8a.5.5 0 0 1 .5-.5h.5V7a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-.5V9a.5.5 0 0 1-1 0v-.5h-.5A.5.5 0 0 1 11 8z" />
                                <path
                                    d="M1 4.5a.5.5 0 0 1 .5-.5H11a.5.5 0 0 1 0 1H1.5a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5H8a.5.5 0 0 1 0 1H1.5a.5.5 0 0 1-.5-.5z" />
                            </svg>
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
        <!-- menu starts here -->
        @can('organization-list')
            <li class="nav-links-li @if ($current_route == 'admin.company.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.company.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-building-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Organization') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('lead-category-list')
            <li class="nav-links-li @if ($current_route == 'admin.leadcategory.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.leadcategory.index') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-file-earmark-check" viewBox="0 0 16 16">
                                <path
                                    d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z" />
                                <path
                                    d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Lead Category') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan
        @can('lead-list')
            <li class="nav-links-li @if ($current_route == 'admin.leads.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.leads.index') }}">
                        <div class="sidebar_icon">
                            <svg id="fi_3031267" enable-background="new 0 0 507.926 507.926" height="48"
                                viewBox="0 0 507.926 507.926" width="48" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="m161.618 57.722h-138.523c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087h138.523c12.751 0 23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087zm-23.087 138.523h-92.349v-92.349h92.349z">
                                    </path>
                                    <path
                                        d="m484.839 126.983h-230.872c-12.751 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.336 23.087-23.087 0-12.75-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m484.839 357.855h-230.872c-12.751 0-23.087 10.337-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.337 23.087-23.087s-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m145.457 318.353-76.857 75.934-28.905-30.013c-8.868-9.168-23.489-9.411-32.657-.543-9.168 8.868-9.411 23.489-.543 32.657l45.112 46.89c4.302 4.389 10.177 6.882 16.323 6.926h.277c6.053-.019 11.857-2.415 16.161-6.672l93.411-92.349c9.664-8.317 10.756-22.895 2.439-32.559s-22.895-10.756-32.559-2.439c-.781.673-1.517 1.397-2.202 2.168z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Leads') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        {{--  --}}

         @can('lead-list')
            <li class="nav-links-li @if ($current_route == 'admin.leads.actions.index') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.leads.actions.index') }}">
                        <div class="sidebar_icon">
                            <svg id="fi_3031267" enable-background="new 0 0 507.926 507.926" height="48"
                                viewBox="0 0 507.926 507.926" width="48" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="m161.618 57.722h-138.523c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087h138.523c12.751 0 23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087zm-23.087 138.523h-92.349v-92.349h92.349z">
                                    </path>
                                    <path
                                        d="m484.839 126.983h-230.872c-12.751 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.336 23.087-23.087 0-12.75-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m484.839 357.855h-230.872c-12.751 0-23.087 10.337-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.337 23.087-23.087s-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m145.457 318.353-76.857 75.934-28.905-30.013c-8.868-9.168-23.489-9.411-32.657-.543-9.168 8.868-9.411 23.489-.543 32.657l45.112 46.89c4.302 4.389 10.177 6.882 16.323 6.926h.277c6.053-.019 11.857-2.415 16.161-6.672l93.411-92.349c9.664-8.317 10.756-22.895 2.439-32.559s-22.895-10.756-32.559-2.439c-.781.673-1.517 1.397-2.202 2.168z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Leads Actions') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

         @can('leads-import-upload-history')
            <li class="nav-links-li @if ($current_route == 'admin.leads.import.history') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.leads.import.history') }}">
                        <div class="sidebar_icon">
                            <svg id="fi_3031267" enable-background="new 0 0 507.926 507.926" height="48"
                                viewBox="0 0 507.926 507.926" width="48" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="m161.618 57.722h-138.523c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087h138.523c12.751 0 23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087zm-23.087 138.523h-92.349v-92.349h92.349z">
                                    </path>
                                    <path
                                        d="m484.839 126.983h-230.872c-12.751 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.336 23.087-23.087 0-12.75-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m484.839 357.855h-230.872c-12.751 0-23.087 10.337-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.337 23.087-23.087s-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m145.457 318.353-76.857 75.934-28.905-30.013c-8.868-9.168-23.489-9.411-32.657-.543-9.168 8.868-9.411 23.489-.543 32.657l45.112 46.89c4.302 4.389 10.177 6.882 16.323 6.926h.277c6.053-.019 11.857-2.415 16.161-6.672l93.411-92.349c9.664-8.317 10.756-22.895 2.439-32.559s-22.895-10.756-32.559-2.439c-.781.673-1.517 1.397-2.202 2.168z">
                                    </path>
                                </g>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M0 0h1v15h15v1H0zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Rejected Leads') }}
                        </span>
                    </a>
                </div>
            </li>
        @endcan

        @can('lead-list')
            <li class="nav-links-li @if ($current_route == 'admin.leads.callagain') showMenu @endif">
                <div class="iocn-link">
                    <a class="w-100" href="{{ route('admin.leads.callagain') }}">
                        <div class="sidebar_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-telephone-forward" viewBox="0 0 16 16">
                                <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708" />
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Call again Leads') }}
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
                            <svg id="fi_3031267" enable-background="new 0 0 507.926 507.926" height="48"
                                viewBox="0 0 507.926 507.926" width="48" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="m161.618 57.722h-138.523c-12.751 0-23.087 10.336-23.087 23.087v138.523c0 12.751 10.336 23.087 23.087 23.087h138.523c12.751 0 23.087-10.336 23.087-23.087v-138.523c0-12.751-10.336-23.087-23.087-23.087zm-23.087 138.523h-92.349v-92.349h92.349z">
                                    </path>
                                    <path
                                        d="m484.839 126.983h-230.872c-12.751 0-23.087 10.336-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.336 23.087-23.087 0-12.75-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m484.839 357.855h-230.872c-12.751 0-23.087 10.337-23.087 23.087s10.336 23.087 23.087 23.087h230.872c12.751 0 23.087-10.337 23.087-23.087s-10.337-23.087-23.087-23.087z">
                                    </path>
                                    <path
                                        d="m145.457 318.353-76.857 75.934-28.905-30.013c-8.868-9.168-23.489-9.411-32.657-.543-9.168 8.868-9.411 23.489-.543 32.657l45.112 46.89c4.302 4.389 10.177 6.882 16.323 6.926h.277c6.053-.019 11.857-2.415 16.161-6.672l93.411-92.349c9.664-8.317 10.756-22.895 2.439-32.559s-22.895-10.756-32.559-2.439c-.781.673-1.517 1.397-2.202 2.168z">
                                    </path>
                                </g>
                            </svg>
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
                            <svg id="fi_50044" style="enable-background:new 0 0 612 612;" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                y="0px" width="48" height="48" viewBox="0 0 612 612" xml:space="preserve">
                                <g>
                                    <path
                                        d="M257.254,316.536c84.086,0,152.252-68.166,152.252-152.252S341.341,12.031,257.254,12.031
                                                                                                                                                                                          c-84.087,0-152.253,68.166-152.253,152.252S173.167,316.536,257.254,316.536z M330.946,224.34
                                                                                                                                                                                          c-6.927,22.9-36.596,40.115-72.154,40.115c-35.559,0-65.228-17.215-72.153-40.115H330.946z M608.234,481.521L468.934,597.613
                                                                                                                                                                                          c-4.052,3.377-10.418,3.088-14.147-0.642l-69.355-69.364c-4.083-4.084-4.083-10.766,0.001-14.85l14.847-14.847
                                                                                                                                                                                          c4.083-4.083,10.766-4.084,14.849-0.001l49.024,49.016L581.35,449.26c4.437-3.696,11.091-3.092,14.788,1.345l13.441,16.127
                                                                                                                                                                                          C613.275,471.168,612.671,477.823,608.234,481.521z M369.096,543.941l26.415,26.419c-36.051,5.076-81.493,8.68-138.256,8.68
                                                                                                                                                                                          c-146.803,0-218.644-23.987-244.982-35.706C5.477,540.31,0,531.665,0,524.227v-50.188c0-75.205,57.26-137.596,130.325-145.953
                                                                                                                                                                                          c2.22-0.254,5.513,0.696,7.322,2.007c33.688,24.389,74.932,38.944,119.607,38.944s85.919-14.556,119.607-38.944
                                                                                                                                                                                          c1.81-1.311,5.102-2.261,7.322-2.007c73.065,8.356,130.326,70.747,130.326,145.953v0.849l-48.942,40.782l-34.105-34.094
                                                                                                                                                                                          c-6.348-6.348-14.787-9.845-23.759-9.845s-17.411,3.497-23.759,9.845l-14.848,14.848
                                                                                                                                                                                          C355.99,509.528,355.99,530.837,369.096,543.941z">
                                    </path>
                                </g>
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-envelope-paper" viewBox="0 0 16 16">
                                <path
                                    d="M4 0a2 2 0 0 0-2 2v1.133l-.941.502A2 2 0 0 0 0 5.4V14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5.4a2 2 0 0 0-1.059-1.765L14 3.133V2a2 2 0 0 0-2-2zm10 4.267.47.25A1 1 0 0 1 15 5.4v.817l-1 .6zm-1 3.15-3.75 2.25L8 8.917l-1.25.75L3 7.417V2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1zm-11-.6-1-.6V5.4a1 1 0 0 1 .53-.882L2 4.267zm13 .566v5.734l-4.778-2.867zm-.035 6.88A1 1 0 0 1 14 15H2a1 1 0 0 1-.965-.738L8 10.083zM1 13.116V7.383l4.778 2.867L1 13.117Z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-people" viewBox="0 0 16 16">
                                <path
                                    d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-envelope-open" viewBox="0 0 16 16">
                                <path
                                    d="M8.47 1.318a1 1 0 0 0-.94 0l-6 3.2A1 1 0 0 0 1 5.4v.817l5.75 3.45L8 8.917l1.25.75L15 6.217V5.4a1 1 0 0 0-.53-.882zM15 7.383l-4.778 2.867L15 13.117zm-.035 6.88L8 10.082l-6.965 4.18A1 1 0 0 0 2 15h12a1 1 0 0 0 .965-.738ZM1 13.116l4.778-2.867L1 7.383v5.734ZM7.059.435a2 2 0 0 1 1.882 0l6 3.2A2 2 0 0 1 16 5.4V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5.4a2 2 0 0 1 1.059-1.765z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path
                                    d="M8.21.5a1 1 0 0 0-.42 0L1 2.89v8.22l6.79 2.39a1 1 0 0 0 .42 0l6.79-2.39V2.89L8.21.5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path
                                    d="M8.21.5a1 1 0 0 0-.42 0L1 2.89v8.22l6.79 2.39a1 1 0 0 0 .42 0l6.79-2.39V2.89L8.21.5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                <path
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 1 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-gear" viewBox="0 0 16 16">
                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-diagram-3" viewBox="0 0 16 16">
                                <path d="M6 2a2 2 0 1 1-2 2 2 2 0 0 1 2-2z" />
                                <path d="M10 2a2 2 0 1 1-2 2 2 2 0 0 1 2-2z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-box-arrow-in-down" viewBox="0 0 16 16">
                                <path d="M3.5 8a.5.5 0 0 1 .5-.5H7V1.5a.5.5 0 0 1 1 0V7.5h3a.5.5 0 0 1 .5.5l-4 4-4-4z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-fire" viewBox="0 0 16 16">
                                <path
                                    d="M8 0c.69 1.04 1.78 3.02 2.5 4.5S12 7 12 9c0 3.313-2.687 6-6 6S0 12.313 0 9c0-2 1.5-4.5 2.5-5.5C3.278 2.52 4.31 1.04 5 0" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 15a.5.5 0 0 1-.5-.5V14a5 5 0 0 1 2.5-4.33V6.33A5 5 0 0 1 2 2V1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V2a5 5 0 0 1-2.5 4.33v3.34A5 5 0 0 1 14 14v.5a.5.5 0 0 1-.5.5h-11z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M2 2v4h4l-1.5-1.5A5 5 0 1 1 3 8H1a7 7 0 1 0 2-4.9L2 2z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                <path
                                    d="M10.97 5.97a.75.75 0 0 0-1.08.02L7.477 9.417 6.384 8.323a.75.75 0 0 0-1.06 1.06l1.6 1.6a.75.75 0 0 0 1.08-.02l3-3a.75.75 0 0 0-.02-1.06z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-truck" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1h9a.5.5 0 0 1 .5.5V4h2.5a.5.5 0 0 1 .4.2l2 2.5a.5.5 0 0 1 .1.3V11a.5.5 0 0 1-.5.5H14a2 2 0 1 1-4 0H6a2 2 0 1 1-4 0H.5A.5.5 0 0 1 0 11V1.5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M2 2v4h4l-1.5-1.5A5 5 0 1 1 3 8H1a7 7 0 1 0 2-4.9L2 2z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt" viewBox="0 0 16 16">
                                <path
                                    d="M1 1.75A.75.75 0 0 1 1.75 1h12.5a.75.75 0 0 1 .75.75v12.5l-2-1-2 1-2-1-2 1-2-1-2 1-2-1V1.75z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-cart-check" viewBox="0 0 16 16">
                                <path d="M9 11.5 7.5 10 6 11.5l3 3 7-7-1.5-1.5-5.5 5.5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-box-arrow-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z" />
                                <path fill-rule="evenodd"
                                    d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-truck" viewBox="0 0 16 16">
                                <path d="M0 3h10v8H0zM10 6h3l3 3v2h-6z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-truck" viewBox="0 0 16 16">
                                <path d="M0 3h10v8H0zM10 6h3l3 3v2h-6z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                <path
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                <path
                                    d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-send" viewBox="0 0 16 16">
                                <path
                                    d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.425l5.939 2.06 2.06 5.939a.75.75 0 0 0 1.425-.124L15.964.686z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                <path
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5
                                                                                                                                                                                            <path
                                                                                                                                                                                                d="
                                    M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0
                                    0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0
                                    0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7
                                    1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217
                                    1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0
                                    0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12
                                    1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                <path
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                <path
                                    d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                <path
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                <path
                                    d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                <path
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                <path
                                    d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                <path
                                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708" />
                            </svg>

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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-shield-check" viewBox="0 0 16 16">
                                <path
                                    d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56" />
                                <path
                                    d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                            </svg>

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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-building-add" viewBox="0 0 16 16">
                                <path
                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0" />
                                <path
                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1z" />
                                <path
                                    d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-chat-dots" viewBox="0 0 16 16">
                                <path
                                    d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                <path
                                    d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-person-lock" viewBox="0 0 16 16">
                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path d="M2 14s-1 0-1-1 1-4 7-4c.97 0 1.87.1 2.68.28A2.5 2.5 0 0 0 10 11.5V14H2z" />
                                <path
                                    d="M13.5 8a1.5 1.5 0 0 1 1.5 1.5V11h-3V9.5A1.5 1.5 0 0 1 13.5 8zm-1 1.5V10h2v-.5a1 1 0 0 0-2 0z" />
                                <path d="M11 11h5v4h-5v-4z" />
                            </svg>

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
                        <svg width="48" height="48" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 460.8 460.8" style="enable-background:new 0 0 460.8 460.8;"
                            xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path d="M230.432,239.282c65.829,0,119.641-53.812,119.641-119.641C350.073,53.812,296.261,0,230.432,0
    S110.792,53.812,110.792,119.641S164.604,239.282,230.432,239.282z" />
                                        <path d="M435.755,334.89c-3.135-7.837-7.314-15.151-12.016-21.943c-24.033-35.527-61.126-59.037-102.922-64.784
    c-5.224-0.522-10.971,0.522-15.151,3.657c-21.943,16.196-48.065,24.555-75.233,24.555s-53.29-8.359-75.233-24.555
    c-4.18-3.135-9.927-4.702-15.151-3.657c-41.796,5.747-79.412,29.257-102.922,64.784c-4.702,6.792-8.882,14.629-12.016,21.943
    c-1.567,3.135-1.045,6.792,0.522,9.927c4.18,7.314,9.404,14.629,14.106,20.898c7.314,9.927,15.151,18.808,24.033,27.167
    c7.314,7.314,15.673,14.106,24.033,20.898c41.273,30.825,90.906,47.02,142.106,47.02s100.833-16.196,142.106-47.02
    c8.359-6.269,16.718-13.584,24.033-20.898c8.359-8.359,16.718-17.241,24.033-27.167c5.224-6.792,9.927-13.584,14.106-20.898
    C436.8,341.682,437.322,338.024,435.755,334.89z" />
                                    </g>
                                </g>
                            </g>
                        </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-tags-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2 2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l6.414 6.414a2 2 0 0 0 2.828 0l4.172-4.172a2 2 0 0 0 0-2.828L8.293 1.293A1 1 0 0 0 7.586 1H3a1 1 0 0 0-1 1z" />
                                <path d="M5.5 5A1.5 1.5 0 1 1 4 3.5 1.5 1.5 0 0 1 5.5 5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-tools" viewBox="0 0 16 16">
                                <path
                                    d="M1 0 0 1l4.5 4.5-1 1L0 3v2l3 3-2 2 5 5 2-2 3 3h2l-3.5-3.5 1-1L16 15V13l-3-3 2-2-5-5-2 2L5 1H3l3.5 3.5-1 1L1 0z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-credit-card-2-front-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3h16v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V7zm3 2a.5.5 0 0 0-.5.5v1A.5.5 0 0 0 3 11h2a.5.5 0 0 0 .5-.5v-1A.5.5 0 0 0 5 9H3z" />
                            </svg>
                        </div>
                        <span class="link_name">
                            {{ get_phrase('Subscriptions') }}
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-globe2" viewBox="0 0 16 16">
                                <path
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-2.4.43c.3.5.57 1.1.8 1.8h3.2c.23-.7.5-1.3.8-1.8A7 7 0 0 0 8 1zM5.3 4A13 13 0 0 0 5 8c0 1.4.1 2.7.3 4h5.4c.2-1.3.3-2.6.3-4s-.1-2.7-.3-4H5.3z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-clipboard-data" viewBox="0 0 16 16">
                                <path
                                    d="M10 1.5v1A.5.5 0 0 1 9.5 3h-3a.5.5 0 0 1-.5-.5v-1A1.5 1.5 0 0 1 7.5 0h1A1.5 1.5 0 0 1 10 1.5" />
                                <path
                                    d="M4 1.5H3A2 2 0 0 0 1 3.5v10A2.5 2.5 0 0 0 3.5 16h9a2.5 2.5 0 0 0 2.5-2.5v-10A2 2 0 0 0 13 1.5h-1v1A1.5 1.5 0 0 1 10.5 4h-5A1.5 1.5 0 0 1 4 2.5z" />
                                <path d="M4.5 12.5h1v-3h-1zm3 0h1v-5h-1zm3 0h1v-2h-1z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-people" viewBox="0 0 16 16">
                                <path d="M13 7a2 2 0 1 0-1.999-2A2 2 0 0 0 13 7z" />
                                <path d="M5 7a2 2 0 1 0-2-2 2 2 0 0 0 2 2z" />
                                <path
                                    d="M5 8c-2.33 0-4 1.17-4 2.5V12h8v-1.5C9 9.17 7.33 8 5 8zm8 0c-.29 0-.57.02-.84.06A3.7 3.7 0 0 1 15 10.5V12h1v-1.5C16 9.17 14.33 8 13 8z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-list-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2.5 12.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                <path fill-rule="evenodd"
                                    d="M1.5 4.5a.5.5 0 0 1 .707 0L3 5.293 4.293 4a.5.5 0 1 1 .707.707L3.354 6.354a.5.5 0 0 1-.708 0L1.5 5.207a.5.5 0 0 1 0-.707zm0 4a.5.5 0 0 1 .707 0L3 9.293 4.293 8a.5.5 0 1 1 .707.707L3.354 10.354a.5.5 0 0 1-.708 0L1.5 9.207a.5.5 0 0 1 0-.707z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                                <path
                                    d="M11 2a1 1 0 0 1 1 1v10h2v1H2v-1h2V7a1 1 0 0 1 1-1h1v7h2V4a1 1 0 0 1 1-1h1v10h1V3a1 1 0 0 1 1-1h1z" />
                                <path fill-rule="evenodd"
                                    d="M4.5 11.5a.5.5 0 0 1 .5-.5h1v1H5a.5.5 0 0 1-.5-.5zm3-3a.5.5 0 0 1 .5-.5h1v4H8a.5.5 0 0 1-.5-.5v-3zm3-4a.5.5 0 0 1 .5-.5h1v8h-1a.5.5 0 0 1-.5-.5v-7z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
                                <path
                                    d="M6.5 0a1.5 1.5 0 0 0-1.5 1.5V3H2A2 2 0 0 0 0 5v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3V1.5A1.5 1.5 0 0 0 9.5 0h-3ZM6 1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3H6V1.5ZM1 6h14v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6Z" />
                            </svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="48"
                                    height="48"
                                    fill="currentColor"
                                    class="bi bi-send"
                                    viewBox="0 0 16 16">
                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.5 6a.5.5 0 0 0 .058.949l5.481 1.826 1.826 5.481a.5.5 0 0 0 .949.058L15.964.686zM6.5 8.5 13.5 2 7 9l-.5 4.5L6.5 8.5z"/>
                                </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                <path
                                    d="M15.964.686a.5.5 0 0 0-.65-.65L.5 6a.5.5 0 0 0 .058.949l5.481 1.826 1.826 5.481a.5.5 0 0 0 .949.058L15.964.686zM6.5 8.5 13.5 2 7 9l-.5 4.5L6.5 8.5z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-layers" viewBox="0 0 16 16">
                                <path
                                    d="M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882zM8 2.566 14.151 5.5 8 8.434 1.849 5.5z" />
                                <path
                                    d="M.5 9.5a.5.5 0 0 1 .735-.441L8 12.434l6.765-3.375A.5.5 0 0 1 15.5 9.5v1a.5.5 0 0 1-.265.441l-7 3.5a.5.5 0 0 1-.47 0l-7-3.5A.5.5 0 0 1 .5 10.5z" />
                            </svg>
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

                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M5 3.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M2.146 3.146a.5.5 0 0 1 .708 0l.854.854 1.646-1.646a.5.5 0 1 1 .708.708L4.06 5.06a.5.5 0 0 1-.708 0L2.146 3.854a.5.5 0 0 1 0-.708zm0 4a.5.5 0 0 1 .708 0l.854.854 1.646-1.646a.5.5 0 1 1 .708.708L4.06 9.06a.5.5 0 0 1-.708 0L2.146 7.854a.5.5 0 0 1 0-.708zm0 4a.5.5 0 0 1 .708 0l.854.854 1.646-1.646a.5.5 0 1 1 .708.708l-1.999 1.999a.5.5 0 0 1-.708 0l-1.001-1.001a.5.5 0 0 1 0-.708z" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
                                <path
                                    d="M6.5 0a1.5 1.5 0 0 0-1.5 1.5V3H2A2 2 0 0 0 0 5v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3V1.5A1.5 1.5 0 0 0 9.5 0h-3ZM6 1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3H6V1.5ZM1 6h14v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6Z" />
                            </svg>
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
            <i class="fi-rr-settings"></i>
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
                <i class="bi bi-three-dots-vertical"></i>
            </div>

        </div>

    </div>

</div>

