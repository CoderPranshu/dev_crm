<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       BASIC ELEMENTS
    ========================================================== */
    const sidebar = document.querySelector('.sidebar');
    const toggleButtons = document.querySelectorAll('.sidebar_menu_icon');
  
    const closeButtons = document.querySelectorAll(
        '.closeIcon, .close-btn, .sidebar-close, .cs-sidebar-close'
    );


    const overlay = document.querySelector('.overlay');

    function isMobile() {
        return window.innerWidth <= 767.98;
    }


    /* =========================================================
       MOBILE SIDEBAR
       DEFAULT CLOSED ON EVERY PAGE / ROUTE LOAD
    ========================================================== */

    // if (sidebar && isMobile()) {

    //     sidebar.classList.remove('mobile-open');

    //     document.body.classList.remove('sidebar-mobile-open');

    //     if (overlay) {
    //         overlay.classList.remove('active');
    //     }
    // }

    if (sidebar && isMobile()) {
        sidebar.classList.remove('close');
        sidebar.classList.remove('mobile-open');

        document.body.classList.remove('sidebar-mobile-open');

        if (overlay) {
            overlay.classList.remove('active');
        }
    }



    /* =========================================================
       HEADER HAMBURGER
    ========================================================== */

    toggleButtons.forEach(function (button) {

        button.addEventListener('click', function (e) {

            /*
             * MOBILE
             */
            if (isMobile()) {

                e.preventDefault();
                e.stopPropagation();

                if (!sidebar) {
                    return;
                }

                const willOpen =
                    !sidebar.classList.contains('mobile-open');

                if (willOpen) {
                    // Mobile should NEVER use desktop collapsed state
                    sidebar.classList.remove('close');
                    sidebar.classList.add('mobile-open');
                } else {
                    sidebar.classList.remove('mobile-open');
                }


                document.body.classList.toggle(
                    'sidebar-mobile-open',
                    willOpen
                );

                if (overlay) {
                    overlay.classList.toggle(
                        'active',
                        willOpen
                    );
                }

                return;
            }


            /*
             * DESKTOP
             * Compact / Expanded sidebar
             */
            if (sidebar) {
                sidebar.classList.toggle('close');
            }

        });

    });


    /* =========================================================
       MOBILE CLOSE BUTTON
    ========================================================== */

    closeButtons.forEach(function (button) {

        button.addEventListener('click', function (e) {

            if (!isMobile()) {
                return;
            }

            e.preventDefault();

            closeMobileSidebar();

        });

    });


    /* =========================================================
       MOBILE CLOSE FUNCTION
    ========================================================== */

    function closeMobileSidebar() {

        if (!sidebar) {
            return;
        }

        sidebar.classList.remove('mobile-open');

        document.body.classList.remove(
            'sidebar-mobile-open'
        );

        if (overlay) {
            overlay.classList.remove('active');
        }
    }


    /* =========================================================
       OVERLAY CLICK
    ========================================================== */

    if (overlay) {

        overlay.addEventListener('click', function () {

            if (isMobile()) {
                closeMobileSidebar();
            }

        });

    }


    /* =========================================================
       CLICK OUTSIDE SIDEBAR
    ========================================================== */

    document.addEventListener('click', function (e) {

        if (!isMobile() || !sidebar) {
            return;
        }

        if (!sidebar.classList.contains('mobile-open')) {
            return;
        }


        const clickedInsideSidebar =
            sidebar.contains(e.target);

        const clickedToggle =
            e.target.closest('.sidebar_menu_icon');


        if (
            !clickedInsideSidebar &&
            !clickedToggle
        ) {
            closeMobileSidebar();
        }

    });


    /* =========================================================
       CLOSE SIDEBAR AFTER CLICKING A NORMAL MENU LINK
       MOBILE ONLY
    ========================================================== */

    if (sidebar) {

        const sidebarLinks =
            sidebar.querySelectorAll(
                '.nav-links a'
            );

        sidebarLinks.forEach(function (link) {

            link.addEventListener('click', function () {

                if (!isMobile()) {
                    return;
                }

                /*
                 * javascript:void links are dropdowns.
                 * Don't close those.
                 */
                const href =
                    this.getAttribute('href') || '';

                if (
                    href === '#' ||
                    href === 'javascript:void(0);' ||
                    href === 'javascript:void(0)'
                ) {
                    return;
                }

                closeMobileSidebar();

            });

        });

    }


    /* =========================================================
       RESIZE
    ========================================================== */

    window.addEventListener('resize', function () {

        if (!sidebar) {
            return;
        }


        /*
         * Entering mobile
         */
        if (isMobile()) {

            sidebar.classList.remove('close');

            closeMobileSidebar();

        } else {

            /*
             * Entering desktop
             */
            sidebar.classList.remove('mobile-open');

            document.body.classList.remove(
                'sidebar-mobile-open'
            );

            if (overlay) {
                overlay.classList.remove('active');
            }

        }

    });



    /* =========================================================
       SIDEBAR SEARCH
    ========================================================== */

    const searchInput =
        document.getElementById('sidebarMenuSearch');


    if (searchInput) {

        const menuItems =
            document.querySelectorAll(
                '.sidebar .nav-links > li'
            );

        const sectionTitles =
            document.querySelectorAll(
                '.sidebar .nav-links > h6'
            );


        searchInput.addEventListener(
            'input',
            function () {

                const keyword =
                    this.value
                        .trim()
                        .toLowerCase();


                /*
                 * EMPTY SEARCH
                 */
                if (!keyword) {

                    menuItems.forEach(
                        function (item) {
                            item.style.display = '';
                        }
                    );

                    sectionTitles.forEach(
                        function (title) {
                            title.style.display = '';
                        }
                    );

                    return;
                }


                /*
                 * Hide section headings
                 */
                sectionTitles.forEach(
                    function (title) {
                        title.style.display = 'none';
                    }
                );


                /*
                 * Filter menu
                 */
                menuItems.forEach(
                    function (item) {

                        const text =
                            item.textContent
                                .replace(/\s+/g, ' ')
                                .trim()
                                .toLowerCase();

                        const matches =
                            text.includes(keyword);


                        item.style.display =
                            matches
                                ? ''
                                : 'none';


                        /*
                         * Open matching dropdown
                         */
                        if (
                            matches &&
                            item.classList.contains(
                                'dropdownToggle'
                            )
                        ) {
                            item.classList.add(
                                'showMenu'
                            );
                        }

                    }
                );

            }
        );

    }



    /* =========================================================
       PERIOD BUTTONS
       Only works if these buttons exist
    ========================================================== */

    const periodButtons =
        document.querySelectorAll(
            '.cs-period-btn'
        );


    periodButtons.forEach(
        function (button) {

            button.addEventListener(
                'click',
                function () {

                    periodButtons.forEach(
                        function (item) {

                            item.classList.remove(
                                'active'
                            );

                        }
                    );


                    this.classList.add(
                        'active'
                    );

                }
            );

        }
    );

});

// 




</script>
