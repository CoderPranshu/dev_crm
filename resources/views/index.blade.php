<!DOCTYPE html>
<html lang="en">

<head>
    <title>@stack('title') | {{ get_settings('website_title') }}</title>

    <!-- all the meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ get_image(get_settings('favicon')) }}" />
    <meta content="{{ csrf_token() }}" name="csrf_token" />
    @stack('meta')
    <!-- End meta -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-5.1.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendors/bootstrap-icons-1.9.1/bootstrap-icons.css') }}">

    {{-- FlatIcons --}}
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" />
    <!-- Select2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />

    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/toastr/toastr.min.css') }}">

    @stack('css')
    @include('navcss')

    <!--Main Jquery-->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.7.1.min.js') }}"></script>
</head>

<body>
    {{-- @include(auth()->user()->role . '.navigation') --}}

    @include('admin.navigation')
    <section class="home-section">
        <div class="home-content">
            @include('header')

            <div class="main_content">

                @yield('content')

            </div>
        </div>
    </section>


    <!--Bootstrap bundle with popper-->
    <script src="{{ asset('assets/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <!-- Datepicker js -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
    <!-- Select2 js -->
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

    <!--Custom Script-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>


    @include('modal')
    @include('common_scripts')
    @include('init')
    @include('navscript')
    @stack('js')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let previousCount = 0;
            let soundUnlocked = false;

            const countEl = document.getElementById('notificationCount');
            const listEl = document.getElementById('notificationList');
            const soundEl = document.getElementById('notificationSound');
            const markAllReadBtn = document.getElementById('markAllReadBtn');

            document.addEventListener('click', function unlockSound() {
                if (soundEl && !soundUnlocked) {
                    soundEl.play().then(() => {
                        soundEl.pause();
                        soundEl.currentTime = 0;
                        soundUnlocked = true;
                    }).catch(() => {});
                }
                document.removeEventListener('click', unlockSound);
            });

            function renderNotifications(data) {
                if (data.count > 0) {
                    countEl.style.display = 'inline-block';
                    countEl.innerText = data.count;
                } else {
                    countEl.style.display = 'none';
                    countEl.innerText = 0;
                }

                if (!data.notifications || data.notifications.length === 0) {
                    listEl.innerHTML = `<div class="p-3 text-muted">No new notifications</div>`;
                    return;
                }

                let html = '';

                data.notifications.forEach(notification => {
                    html += `
                <a href="${notification.url ?? '#'}"
                   class="dropdown-item border-bottom p-3 notification-item"
                   data-id="${notification.id}">
                    <div class="fw-bold mb-1">${notification.title}</div>
                    <div class="small text-muted mb-1">${notification.message}</div>
                    <div class="small text-secondary">${notification.created_at}</div>
                </a>
            `;
                });

                listEl.innerHTML = html;

                document.querySelectorAll('.notification-item').forEach(item => {
                    item.addEventListener('click', function(e) {
                        const id = this.dataset.id;

                        fetch(`{{ url('/admin/notifications/read') }}/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                    });
                });
            }

            function showToast(title, message) {
                const toast = document.createElement('div');
                toast.style.position = 'fixed';
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '99999';
                toast.style.background = '#fff';
                toast.style.padding = '12px 16px';
                toast.style.minWidth = '280px';
                toast.style.borderRadius = '10px';
                toast.style.boxShadow = '0 4px 16px rgba(0,0,0,.12)';
                toast.style.borderLeft = '4px solid #0d6efd';

                toast.innerHTML = `
            <div style="font-weight:600; margin-bottom:4px;">${title}</div>
            <div style="font-size:13px; color:#666;">${message}</div>
        `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 4000);
            }

            function fetchNotifications(initial = false) {
                fetch(`{{ route('admin.notifications.unread') }}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        renderNotifications(data);

                        if (!initial && data.count > previousCount) {
                            if (soundEl && soundUnlocked) {
                                soundEl.currentTime = 0;
                                soundEl.play().catch(() => {});
                            }

                            if (data.notifications.length > 0) {
                                showToast(data.notifications[0].title, data.notifications[0].message);
                            }
                        }

                        previousCount = data.count;
                    })
                    .catch(error => {
                        console.error('Notification fetch error:', error);
                    });
            }

            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    fetch(`{{ route('admin.notifications.readAll') }}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(() => fetchNotifications());
                });
            }

            fetchNotifications(true);

            setInterval(() => {
                fetchNotifications();
            }, 10000); // every 10 seconds
        });
    </script>
</body>

</html>
