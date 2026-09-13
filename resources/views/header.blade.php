@php
    use App\Models\Proforma;
    use App\Models\ProformaPayment;
    use App\Models\VendorPayment;
    use App\Models\PurchaseBill;
    use Carbon\Carbon;

    /*
    |--------------------------------------------------------------------------
    | HEADER FINANCE DATA
    |--------------------------------------------------------------------------
    */

    $totalProformaAmount = Proforma::sum('total');
    $totalReceivedAmount = ProformaPayment::sum('amount');

    $headerReceivable = max(
        0,
        $totalProformaAmount - $totalReceivedAmount
    );

    $headPayable = VendorPayment::sum('amount');
    $venborpay = PurchaseBill::sum('total_amount');

    $headerPayable = max(
        0,
        $venborpay - $headPayable
    );

    $todayReceived = ProformaPayment::whereDate(
        'payment_date',
        Carbon::today()
    )->sum('amount');

    $todayPaid = VendorPayment::whereDate(
        'payment_date',
        Carbon::today()
    )->sum('amount');
@endphp


{{-- ============================================================
    PREMIUM ERP HEADER
============================================================ --}}

<header class="cs-premium-header">

    {{-- ========================================================
        LEFT SIDE
    ========================================================= --}}
    <div class="cs-premium-header-left">

        {{-- SIDEBAR TOGGLE --}}
        <button
            type="button"
            class="cs-premium-menu-btn sidebar_menu_icon"
            aria-label="Toggle sidebar"
        >
            <span class="menuList">
                <i class="bi bi-list"></i>
            </span>
        </button>


        {{-- ERP / WORKSPACE --}}
        <div class="cs-premium-brand-info">

            <span class="cs-premium-brand-title">
                {{ get_settings('website_title') }}
            </span>

            <span class="cs-premium-brand-subtitle">
                Admin Workspace
            </span>

        </div>

    </div>



    {{-- ========================================================
        CENTER
        SAME ORIGINAL ERP CONTENT
    ========================================================= --}}
    <div class="cs-premium-header-center">


        {{-- ====================================================
            RECEIVABLE + PAYABLE
        ===================================================== --}}
        @if (auth()->user()->hasRole(['Admin', 'Accounts']))

            {{-- RECEIVABLE --}}
            <div class="cs-premium-finance-card">

                <div class="cs-premium-finance-icon cs-premium-green">

                    <i class="fi fi-rr-money"></i>

                </div>


                <div class="cs-premium-finance-info">

                    <span>
                        Receivable
                    </span>

                    <strong>
                        ₹{{ number_format($headerReceivable, 2) }}
                    </strong>

                </div>

            </div>


            {{-- PAYABLE --}}
            <div class="cs-premium-finance-card">

                <div class="cs-premium-finance-icon cs-premium-red">

                    <i class="fi fi-rr-credit-card"></i>

                </div>


                <div class="cs-premium-finance-info">

                    <span>
                        Payable
                    </span>

                    <strong>
                        ₹{{ number_format($headerPayable, 2) }}
                    </strong>

                </div>

            </div>

        @endif



        {{-- ====================================================
            PROFORMA
        ===================================================== --}}
        @can('performa-list')

            <a
                href="{{ route('admin.proforma.index') }}"
                class="cs-premium-header-action"
            >

                <span class="cs-premium-action-icon">
                    <i class="fi fi-rr-document"></i>
                </span>

                <span>
                    Proforma
                </span>

            </a>

        @endcan



        {{-- ====================================================
            PURCHASE
        ===================================================== --}}
        @can('purchase-requisition-list')

            <a
                href="{{ route('admin.purchase.index') }}"
                class="cs-premium-header-action"
            >

                <span class="cs-premium-action-icon">
                    <i class="fi fi-rr-shopping-cart"></i>
                </span>

                <span>
                    Purchase
                </span>

            </a>

        @endcan



        {{-- ====================================================
            SUSPENSE
        ===================================================== --}}
        @if (auth()->user()->hasRole(['Admin', 'Account']))

            <a
                href="{{ route('admin.suspense.index') }}"
                class="cs-premium-header-action cs-premium-header-primary"
            >

                <span class="cs-premium-action-icon">
                    <i class="fi fi-rr-wallet"></i>
                </span>

                <span>
                    Suspense
                </span>

            </a>

        @endif

    </div>



    {{-- ========================================================
        RIGHT SIDE
    ========================================================= --}}
    <div class="cs-premium-header-right">


        {{-- ====================================================
            NOTIFICATION
        ===================================================== --}}
        <div class="dropdown">

            <button
                type="button"
                class="cs-premium-notification-btn"
                id="notificationBell"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                aria-label="Notifications"
            >

                <i class="fi fi-rr-bell"></i>


                <span
                    id="notificationCount"
                    class="cs-premium-notification-count"
                    style="display:none;"
                >
                    0
                </span>

            </button>



            {{-- NOTIFICATION DROPDOWN --}}
            <div
                class="dropdown-menu dropdown-menu-end cs-premium-notification-dropdown"
            >

                <div class="cs-premium-notification-header">

                    <div>

                        <strong>
                            Notifications
                        </strong>

                        <small>
                            Recent activity
                        </small>

                    </div>


                    <button
                        type="button"
                        id="markAllReadBtn"
                        class="cs-premium-mark-read"
                    >
                        Mark all read
                    </button>

                </div>


                <div
                    id="notificationList"
                    class="cs-premium-notification-list"
                >

                    <div class="p-3 text-muted">
                        No new notifications
                    </div>

                </div>

            </div>

        </div>



        {{-- NOTIFICATION SOUND --}}
        <audio
            id="notificationSound"
            preload="auto"
        >

            <source
                src="{{ asset('notification.mp3') }}"
                type="audio/mpeg"
            >

        </audio>



        {{-- ====================================================
            DIVIDER
        ===================================================== --}}
        <span class="cs-premium-header-divider"></span>



        {{-- ====================================================
            USER PROFILE
        ===================================================== --}}
        <div class="dropdown cs-premium-user-dropdown">

            <button
                type="button"
                class="cs-premium-user-trigger"
                id="defaultDropdown"
                data-bs-toggle="dropdown"
                data-bs-auto-close="true"
                aria-expanded="false"
            >


                {{-- AVATAR --}}
                <div class="cs-premium-user-avatar">

                    {{-- <img src="{{ get_image('uploads/user-image/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}"> --}}

                    <img src="https://cdn.vectorstock.com/i/500p/22/63/a-simple-black-silhouette-of-man-in-suit-vector-55942263.jpg" alt="{{ auth()->user()->name }}">

                    <span class="cs-premium-online-dot"></span>

                </div>



                {{-- USER INFO --}}
                <div class="cs-premium-user-info">

                    <span class="cs-premium-user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="cs-premium-user-role">
                        {{ auth()->user()->role }}
                    </span>

                </div>



                {{-- ARROW --}}
                <i class="bi bi-chevron-down cs-premium-user-arrow"></i>

            </button>



            {{-- =================================================
                PROFILE DROPDOWN
            ================================================== --}}
            <ul
                class="dropdown-menu dropdown-menu-end cs-premium-profile-menu"
                aria-labelledby="defaultDropdown"
            >


                {{-- PROFILE HEADER --}}
                <li class="cs-premium-profile-header">

                    <div class="cs-premium-profile-avatar">

                        <img
                            src="{{ get_image(
                                'uploads/user-image/' .
                                auth()->user()->photo
                            ) }}"
                            alt="{{ auth()->user()->name }}"
                        >

                    </div>


                    <div class="cs-premium-profile-user">

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            {{ auth()->user()->role }}
                        </span>

                    </div>

                </li>



                <li>
                    <hr class="dropdown-divider">
                </li>



                {{-- MY PROFILE --}}
                <li>

                    <a
                        class="dropdown-item cs-premium-profile-item"
                        href="{{ route('admin.my.profile') }}"
                    >

                        <span class="cs-premium-profile-item-icon">
                            <i class="fi fi-rr-user"></i>
                        </span>

                        <span>
                            {{ get_phrase('My Profile') }}
                        </span>

                    </a>

                </li>



                {{-- CHANGE PASSWORD --}}
                <li>

                    <a
                        class="dropdown-item cs-premium-profile-item"
                        href="{{ route('admin.change.password') }}"
                    >

                        <span class="cs-premium-profile-item-icon">
                            <i class="fi fi-br-key-skeleton-left-right"></i>
                        </span>

                        <span>
                            {{ get_phrase('Change password') }}
                        </span>

                    </a>

                </li>



                {{-- SYSTEM SETTINGS --}}
                @if (auth()->user()->role == 'admin')

                    <li>

                        <a
                            class="dropdown-item cs-premium-profile-item"
                            href="{{ route('admin.system.settings') }}"
                        >

                            <span class="cs-premium-profile-item-icon">
                                <i class="fi fi-rr-settings"></i>
                            </span>

                            <span>
                                {{ get_phrase('System Settings') }}
                            </span>

                        </a>

                    </li>

                @endif



                <li>
                    <hr class="dropdown-divider">
                </li>



                {{-- LOGOUT --}}
                <li>

                    <a
                        class="dropdown-item cs-premium-profile-item cs-premium-logout"
                        href="{{ route('logout') }}"
                    >

                        <span class="cs-premium-profile-item-icon">
                            <i class="fi fi-rr-sign-out-alt"></i>
                        </span>

                        <span>
                            {{ get_phrase('Log out') }}
                        </span>

                    </a>

                </li>

            </ul>

        </div>

    </div>

</header>
