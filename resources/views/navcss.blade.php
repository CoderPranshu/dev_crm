<style>
/* ============================================================
   CODE SPARROW ERP — PREMIUM ADMIN SIDEBAR
   STEP 1
   ============================================================ */

:root {
    --cs-sidebar-width: 258px;
    --cs-sidebar-bg: #ffffff;
    --cs-sidebar-border: #e8ebef;

    --cs-text: #16181d;
    --cs-muted: #7b8190;

    --cs-accent: #147d82;
    --cs-accent-soft: #edf7f6;

    --cs-active-bg: #171914;
    --cs-active-text: #ffffff;

    --cs-hover-bg: #f5f7f7;

    --cs-radius-sm: 8px;
    --cs-radius-md: 10px;
    --cs-radius-lg: 14px;

    --cs-transition: 180ms ease;
}


/* ============================================================
   GLOBAL
   ============================================================ */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body {
    background: #f6f7f9;
    overflow-x: hidden;
}


/* ============================================================
   OLD MAIN SIDEBAR
   Keep hidden if old two-sidebar markup exists
   ============================================================ */

.main-sidebar {
    display: none !important;
}


/* ============================================================
   MAIN NAVIGATION SIDEBAR
   ============================================================ */

.sidebar,
.sub-sidebar {
    position: fixed !important;

    top: 0;
    left: 0;

    width: var(--cs-sidebar-width) !important;
    height: 100vh !important;

    background: var(--cs-sidebar-bg) !important;

    border-right: 1px solid var(--cs-sidebar-border);

    z-index: 1000;

    display: flex;
    flex-direction: column;

    padding: 0 !important;

    box-shadow: none;

    transform: translateX(0);

    transition:
        width var(--cs-transition),
        transform var(--cs-transition);
}


/* ============================================================
   SIDEBAR LOGO AREA
   ============================================================ */

.sidebar .logo-details,
.sub-sidebar .logo-details {
    position: relative;

    min-height: 86px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 16px 22px;

    margin: 0 !important;

    border-bottom: 1px solid #f0f1f3;
}


.sidebar .logo-details img,
.sub-sidebar .logo-details img {
    display: block;

    max-width: 175px;
    max-height: 52px;

    width: auto;
    height: auto;

    object-fit: contain;
}


/* ============================================================
   SIDEBAR CLOSE ICON
   Desktop hidden
   ============================================================ */

.sidebar .closeIcon,
.sub-sidebar .close-btn {
    display: none;
}


/* ============================================================
   NAVIGATION SCROLL AREA
   ============================================================ */

.sidebar .nav-links,
.sub-sidebar .nav-links {
    flex: 1;

    margin: 0 !important;
    padding: 14px 12px 24px !important;

    list-style: none;

    overflow-x: hidden;
    overflow-y: auto;

    scrollbar-width: thin;
    scrollbar-color: #d8dce1 transparent;
}


.sidebar .nav-links::-webkit-scrollbar,
.sub-sidebar .nav-links::-webkit-scrollbar {
    width: 4px;
}


.sidebar .nav-links::-webkit-scrollbar-track,
.sub-sidebar .nav-links::-webkit-scrollbar-track {
    background: transparent;
}


.sidebar .nav-links::-webkit-scrollbar-thumb,
.sub-sidebar .nav-links::-webkit-scrollbar-thumb {
    background: #d8dce1;
    border-radius: 20px;
}


/* ============================================================
   TOP LEVEL LI
   ============================================================ */

.sidebar .nav-links > li,
.sub-sidebar .nav-links > li {
    position: relative;

    margin: 2px 0 !important;

    padding: 0;

    border-radius: var(--cs-radius-md);

    list-style: none;
}


/* ============================================================
   TOP LEVEL LINKS
   ============================================================ */

.sidebar .nav-links > li > a,
.sidebar .nav-links > li > .icon-link,
.sidebar .nav-links > li > .iocn-link,
.sub-sidebar .nav-links > li > a {
    min-height: 44px;

    width: 100%;

    display: flex;
    align-items: center;

    padding: 8px 11px !important;

    border: 0 !important;
    border-radius: var(--cs-radius-md);

    background: transparent;

    color: var(--cs-muted) !important;

    text-decoration: none;

    transition:
        background var(--cs-transition),
        color var(--cs-transition),
        transform var(--cs-transition);
}


/* ============================================================
   LINKS INSIDE ICON-LINK
   ============================================================ */

.sidebar .nav-links .icon-link > a,
.sidebar .nav-links .iocn-link > a {
    display: flex;
    align-items: center;

    flex: 1;

    min-width: 0;

    color: inherit !important;

    text-decoration: none;
}


/* ============================================================
   MENU ICONS
   ============================================================ */

.sidebar .nav-links i,
.sidebar .nav-links .sidebar_icon,
.sidebar .nav-links .icon-link i,
.sidebar .nav-links .iocn-link i {
    flex: 0 0 34px;

    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    margin: 0 8px 0 0 !important;

    color: #818793;

    font-size: 17px !important;
    line-height: 1;

    border-radius: 8px;

    transition:
        color var(--cs-transition),
        background var(--cs-transition);
}


/* ============================================================
   SVG ICON FIX
   Existing sidebar contains large SVGs
   ============================================================ */

.sidebar .nav-links svg,
.sub-sidebar .nav-links svg {
    width: 18px !important;
    height: 18px !important;

    max-width: 18px !important;
    max-height: 18px !important;

    flex-shrink: 0;

    transition:
        fill var(--cs-transition),
        stroke var(--cs-transition);
}


/* ============================================================
   LINK LABEL
   ============================================================ */

.sidebar .nav-links .link_name,
.sub-sidebar .nav-links .link_name {
    min-width: 0;

    color: inherit !important;

    font-size: 13px !important;
    font-weight: 500 !important;

    line-height: 1.35;

    letter-spacing: -0.01em;

    white-space: normal;

    transition: color var(--cs-transition);
}


/* ============================================================
   HOVER
   ============================================================ */

.sidebar .nav-links > li:hover > a,
.sidebar .nav-links > li:hover > .icon-link,
.sidebar .nav-links > li:hover > .iocn-link,
.sub-sidebar .nav-links > li:hover > a {
    background: var(--cs-hover-bg) !important;

    color: var(--cs-text) !important;
}


.sidebar .nav-links > li:hover i,
.sidebar .nav-links > li:hover .sidebar_icon {
    color: var(--cs-text) !important;
}


/*
   IMPORTANT:
   Old CSS was forcing SVG path fill + stroke to black.
   We keep this more controlled.
*/

.sidebar .nav-links > li:hover svg {
    opacity: 1;
}


/* ============================================================
   ACTIVE MENU
   Supports common existing active classes
   ============================================================ */

.sidebar .nav-links > li.active > a,
.sidebar .nav-links > li.active > .icon-link,
.sidebar .nav-links > li.active > .iocn-link,

.sidebar .nav-links > li > a.active,

.sidebar .nav-links > li.menu-active > a,
.sidebar .nav-links > li.menu-active > .icon-link,

.sub-sidebar .nav-links > li.active > a {
    background: var(--cs-active-bg) !important;

    color: var(--cs-active-text) !important;

    box-shadow:
        0 1px 2px rgba(0, 0, 0, .08),
        0 5px 14px rgba(15, 23, 42, .08);
}


.sidebar .nav-links > li.active > a i,
.sidebar .nav-links > li.active > .icon-link i,
.sidebar .nav-links > li.active > .iocn-link i,
.sidebar .nav-links > li > a.active i {
    color: #ffffff !important;
}


.sidebar .nav-links > li.active .link_name,
.sidebar .nav-links > li > a.active .link_name {
    color: #ffffff !important;
}


/* ============================================================
   DROPDOWN ARROW
   ============================================================ */

.sidebar .nav-links .arrow,
.sidebar .nav-links .dropdownToggle {
    margin-left: auto !important;

    width: 26px;
    height: 26px;

    flex: 0 0 26px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    color: #9aa0aa;

    font-size: 11px !important;

    border-radius: 6px;

    cursor: pointer;

    transition:
        transform var(--cs-transition),
        background var(--cs-transition),
        color var(--cs-transition);
}


.sidebar .nav-links .arrow:hover,
.sidebar .nav-links .dropdownToggle:hover {
    background: #eceeef;

    color: var(--cs-text);
}


.sidebar .nav-links li.showMenu .arrow {
    transform: rotate(180deg);
}


/* ============================================================
   SUB MENU
   ============================================================ */

.sidebar .nav-links li .sub-menu {
    display: none;

    position: static !important;

    width: auto !important;

    margin: 3px 0 7px !important;

    padding: 4px 0 4px 43px !important;

    background: transparent !important;

    border: 0 !important;

    border-radius: 0 !important;

    box-shadow: none !important;
}


.sidebar .nav-links li.showMenu .sub-menu {
    display: block;
}


.sidebar .nav-links li .sub-menu li {
    margin: 1px 0 !important;

    list-style: none;
}


.sidebar .nav-links li .sub-menu a {
    position: relative;

    display: flex;
    align-items: center;

    min-height: 34px;

    padding: 7px 10px !important;

    color: #7a808c !important;

    background: transparent !important;

    border-radius: 7px;

    font-size: 12px !important;
    font-weight: 500;

    text-decoration: none;

    opacity: 1 !important;

    transition:
        background var(--cs-transition),
        color var(--cs-transition);
}


.sidebar .nav-links li .sub-menu a::before {
    content: "";

    width: 5px;
    height: 5px;

    margin-right: 9px;

    border-radius: 50%;

    background: #c4c8ce;

    flex-shrink: 0;
}


.sidebar .nav-links li .sub-menu a:hover {
    color: var(--cs-text) !important;

    background: #f5f6f7 !important;
}


.sidebar .nav-links li .sub-menu a:hover::before {
    background: var(--cs-accent);
}


/* ============================================================
   CATEGORY / SECTION HEADINGS
   Example HRMS, ACCOUNTING, CRM
   ============================================================ */

.sidebar .nav-links .menu-title,
.sidebar .nav-links .nav-title,
.sidebar .nav-links .sidebar-title,
.sidebar .nav-links .sidebar_heading,
.sidebar .nav-links .sidebar-heading {
    display: block;

    padding: 16px 11px 6px;

    color: var(--cs-accent) !important;

    font-size: 11px !important;
    font-weight: 700 !important;

    line-height: 1;

    letter-spacing: .08em;

    text-transform: uppercase;
}


/* ============================================================
   HOME SECTION
   ============================================================ */

.home-section {
    position: relative !important;

    left: var(--cs-sidebar-width) !important;

    width: calc(100% - var(--cs-sidebar-width)) !important;

    min-height: 100vh;

    background: #f6f7f9 !important;

    transition:
        left var(--cs-transition),
        width var(--cs-transition) !important;
}


.home-section .home-content {
    min-height: 100vh;
}


/* ============================================================
   MAIN CONTENT
   ============================================================ */

.home-section .main_content {
    background: #f6f7f9;
}


/* ============================================================
   OVERLAY
   Desktop hidden
   ============================================================ */

.overlay {
    position: fixed;

    inset: 0;

    display: none;

    background: rgba(15, 23, 42, .42);

    backdrop-filter: blur(2px);

    z-index: 990;
}


.overlay.active {
    display: block;
}


/* ============================================================
   DESKTOP SIDEBAR COLLAPSE
   Existing .close class compatibility
   ============================================================ */

@media (min-width: 769px) {

    /*
     * STEP 1:
     * We intentionally keep desktop sidebar expanded.
     *
     * Proper premium compact/collapse behavior will be handled
     * in Step 3 together with navscript.
     */

    .sidebar {
        width: var(--cs-sidebar-width) !important;
    }

}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 768px) {

    :root {
        --cs-sidebar-width: 280px;
    }


    .sidebar,
    .sub-sidebar {
        width: 280px !important;

        transform: translateX(-100%);

        box-shadow:
            12px 0 35px rgba(15, 23, 42, .14);
    }


    /*
     * Existing project commonly adds/removes .close.
     * Keep compatibility.
     */

    .sidebar:not(.close),
    .sub-sidebar.active {
        transform: translateX(0);
    }


    .sidebar.close {
        transform: translateX(-100%);
    }


    .sidebar .closeIcon,
    .sub-sidebar .close-btn {
        position: absolute;

        top: 22px;
        right: 15px;

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #626873;

        background: #f4f5f6;

        border: 1px solid #e7e9ec;
        border-radius: 9px;

        cursor: pointer;

        z-index: 20;
    }


    .sidebar .logo-details,
    .sub-sidebar .logo-details {
        min-height: 78px;

        justify-content: flex-start;

        padding: 14px 55px 14px 18px;
    }


    .sidebar .logo-details img,
    .sub-sidebar .logo-details img {
        max-width: 160px;
        max-height: 46px;
    }


    .sidebar .nav-links,
    .sub-sidebar .nav-links {
        padding:
            10px 10px
            calc(24px + env(safe-area-inset-bottom))
            !important;
    }


    .sidebar .nav-links > li > a,
    .sidebar .nav-links > li > .icon-link,
    .sidebar .nav-links > li > .iocn-link {
        min-height: 46px;

        padding: 8px 10px !important;
    }


    .sidebar .nav-links .link_name {
        font-size: 13px !important;
    }


    .home-section {
        left: 0 !important;

        width: 100% !important;
    }


    .overlay.active {
        display: block;
    }

}


/* ============================================================
   SMALL MOBILE
   ============================================================ */

@media (max-width: 480px) {

    .sidebar,
    .sub-sidebar {
        width: min(86vw, 290px) !important;
    }

}


/* ============================================================
   FOCUS / ACCESSIBILITY
   ============================================================ */

.sidebar a:focus-visible,
.sidebar button:focus-visible {
    outline: 2px solid rgba(20, 125, 130, .35);
    outline-offset: 2px;
}


/* ============================================================
   REMOVE OLD BLACK HOVER OVERRIDES
   ============================================================ */

.sidebar .nav-links > li.showMenu .iocn-link a .link_name:hover,
.sidebar .nav-links > li a:hover .link_name {
    color: inherit !important;
}


.sidebar .nav-links > li:hover .icon-link,
.sidebar .nav-links > li:hover .sidebar_icon {
    color: inherit;
}


/*
 * Do NOT force every SVG path to fill:black.
 * Some existing icons may be stroke-based.
 */

.sidebar .nav-links > li:hover .icon-link svg,
.sidebar .nav-links > li:hover .sidebar_icon svg,
.sidebar .nav-links > li a:hover .icon-link svg,
.sidebar .nav-links > li a:hover .sidebar_icon svg {
    width: 18px !important;
    height: 18px !important;
}



/*  */

/* ============================================================
   STEP 1 HOTFIX — CURRENT SIDEBAR MARKUP
   ============================================================ */

/* Remove old blue active/left indicator */
.sidebar .nav-links > li::before,
.sidebar .nav-links > li > a::before,
.sidebar .nav-links > li > .icon-link::before,
.sidebar .nav-links > li > .iocn-link::before {
    display: none !important;
    content: none !important;
    border: 0 !important;
}


/* ------------------------------------------------------------
   Main menu rows
   ------------------------------------------------------------ */

.sidebar .nav-links > li {
    position: relative !important;
    height: auto !important;
    min-height: 44px !important;

    margin: 2px 0 !important;

    overflow: visible !important;
}


/* Main clickable row */
.sidebar .nav-links > li > a,
.sidebar .nav-links > li > .icon-link,
.sidebar .nav-links > li > .iocn-link {
    position: relative !important;

    width: 100% !important;
    min-height: 44px !important;
    height: auto !important;

    display: flex !important;
    align-items: center !important;

    padding: 7px 10px !important;

    border-radius: 9px !important;

    border-left: 0 !important;
}


/* ------------------------------------------------------------
   Fix icon sizing/alignment
   ------------------------------------------------------------ */

.sidebar .nav-links > li > a > i,
.sidebar .nav-links > li > .icon-link > i,
.sidebar .nav-links > li > .iocn-link > i,
.sidebar .nav-links .sidebar_icon {
    width: 34px !important;
    min-width: 34px !important;
    height: 34px !important;

    margin: 0 8px 0 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    line-height: 1 !important;

    position: static !important;
}


/* SVG must not inherit old huge dimensions */
.sidebar .nav-links > li svg {
    width: 18px !important;
    height: 18px !important;

    min-width: 18px !important;
    max-width: 18px !important;

    min-height: 18px !important;
    max-height: 18px !important;
}


/* ------------------------------------------------------------
   Main label
   ------------------------------------------------------------ */

.sidebar .nav-links .link_name {
    position: static !important;

    display: block !important;

    flex: 1 1 auto !important;

    width: auto !important;
    min-width: 0 !important;

    margin: 0 !important;
    padding: 0 !important;

    font-size: 13px !important;
    line-height: 18px !important;

    white-space: normal !important;

    transform: none !important;
}


/* ------------------------------------------------------------
   Dropdown parent
   ------------------------------------------------------------ */

.sidebar .nav-links > li > .icon-link,
.sidebar .nav-links > li > .iocn-link {
    display: flex !important;
    align-items: center !important;
}


/* ------------------------------------------------------------
   Dropdown arrow
   ------------------------------------------------------------ */

.sidebar .nav-links .arrow,
.sidebar .nav-links .dropdownToggle {
    position: static !important;

    margin-left: auto !important;
    margin-right: 0 !important;

    width: 28px !important;
    min-width: 28px !important;
    height: 28px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    transform: none;
}


.sidebar .nav-links li.showMenu .arrow,
.sidebar .nav-links li.showMenu .dropdownToggle {
    transform: rotate(180deg);
}


/* ============================================================
   CRITICAL SUBMENU FIX
   ============================================================ */

.sidebar .nav-links li .sub-menu {
    position: static !important;

    top: auto !important;
    left: auto !important;

    width: 100% !important;
    height: auto !important;

    margin: 2px 0 6px !important;
    padding: 2px 0 2px 42px !important;

    background: transparent !important;

    border: 0 !important;
    border-radius: 0 !important;

    box-shadow: none !important;

    opacity: 1 !important;

    transform: none !important;

    overflow: visible !important;
}


/* Closed submenu */
.sidebar .nav-links li:not(.showMenu) > .sub-menu {
    display: none !important;
}


/* Open submenu */
.sidebar .nav-links li.showMenu > .sub-menu {
    display: block !important;
}


/* Submenu items */
.sidebar .nav-links li .sub-menu li {
    position: relative !important;

    width: 100% !important;
    height: auto !important;
    min-height: 34px !important;

    margin: 1px 0 !important;
    padding: 0 !important;
}


/* Submenu links */
.sidebar .nav-links li .sub-menu li a {
    position: relative !important;

    width: 100% !important;
    min-height: 34px !important;
    height: auto !important;

    display: flex !important;
    align-items: center !important;

    padding: 7px 9px !important;

    color: #737986 !important;

    background: transparent !important;

    border-radius: 7px !important;

    font-size: 12px !important;
    font-weight: 500 !important;
    line-height: 18px !important;

    white-space: normal !important;

    opacity: 1 !important;

    transform: none !important;
}


.sidebar .nav-links li .sub-menu li a:hover {
    background: #f4f6f6 !important;
    color: #171914 !important;
}


/* Remove old floating submenu title */
.sidebar .nav-links li .sub-menu .link_name {
    display: none !important;
}


/* ------------------------------------------------------------
   Remove legacy active blue borders
   ------------------------------------------------------------ */

.sidebar .nav-links li,
.sidebar .nav-links li a,
.sidebar .nav-links li .icon-link,
.sidebar .nav-links li .iocn-link {
    border-left: 0 !important;
}


/* ------------------------------------------------------------
   Premium hover
   ------------------------------------------------------------ */

.sidebar .nav-links > li > a:hover,
.sidebar .nav-links > li > .icon-link:hover,
.sidebar .nav-links > li > .iocn-link:hover {
    background: #f5f7f7 !important;
    color: #171914 !important;
}


/* ------------------------------------------------------------
   Sidebar category headings
   ------------------------------------------------------------ */

.sidebar .nav-links .menu-title,
.sidebar .nav-links .nav-title,
.sidebar .nav-links .sidebar-title,
.sidebar .nav-links .sidebar_heading,
.sidebar .nav-links .sidebar-heading {
    min-height: auto !important;

    padding: 17px 10px 7px !important;

    color: #147d82 !important;

    font-size: 11px !important;
    font-weight: 700 !important;

    letter-spacing: .07em;

    text-transform: uppercase;
}


/* ------------------------------------------------------------
   Better sidebar spacing
   ------------------------------------------------------------ */

.sidebar .nav-links {
    padding: 14px 12px 28px !important;
}


/* ------------------------------------------------------------
   Logo separation
   ------------------------------------------------------------ */

.sidebar .logo-details {
    border-bottom: 1px solid #edf0f2 !important;

    background: #ffffff !important;
}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 768px) {

    .sidebar .nav-links li .sub-menu {
        padding-left: 40px !important;
    }

    .sidebar .nav-links > li {
        min-height: 46px !important;
    }

}

/*  */

/* ============================================================
   STEP 2 — PREMIUM SIDEBAR FINAL STRUCTURE FIX
   ============================================================ */


/* ------------------------------------------------------------
   IMPORTANT:
   dropdownToggle class LI par hai, arrow par nahi
   ------------------------------------------------------------ */

.sidebar .nav-links > li.dropdownToggle {
    display: block !important;

    width: 100% !important;
    height: auto !important;
    min-height: 44px !important;

    margin: 2px 0 !important;

    padding: 0 !important;

    position: relative !important;

    transform: none !important;

    overflow: visible !important;
}


/* Parent dropdown row */
.sidebar .nav-links > li.dropdownToggle > .iocn-link {
    width: 100% !important;

    min-height: 44px !important;

    display: flex !important;
    align-items: center !important;

    padding: 7px 10px !important;

    border-radius: 10px !important;

    background: transparent !important;

    transition:
        background .18s ease,
        color .18s ease;
}


/* Dropdown link */
.sidebar .nav-links > li.dropdownToggle > .iocn-link > a {
    flex: 1 1 auto !important;

    min-width: 0 !important;

    display: flex !important;
    align-items: center !important;

    padding: 0 !important;

    background: transparent !important;

    color: #747b89 !important;

    text-decoration: none !important;
}


/* ------------------------------------------------------------
   Actual arrow
   ------------------------------------------------------------ */

.sidebar .nav-links > li.dropdownToggle > .iocn-link > .arrow {
    position: static !important;

    width: 28px !important;
    min-width: 28px !important;
    height: 28px !important;

    margin-left: auto !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    background: transparent !important;

    border-radius: 7px !important;

    transform: rotate(0deg) !important;

    transition:
        transform .18s ease,
        background .18s ease;
}


.sidebar .nav-links > li.dropdownToggle.showMenu
> .iocn-link
> .arrow {
    transform: rotate(90deg) !important;
}


.sidebar .nav-links > li.dropdownToggle
> .iocn-link
> .arrow svg {
    width: 8px !important;
    height: 12px !important;

    min-width: 8px !important;
    max-width: 8px !important;

    min-height: 12px !important;
    max-height: 12px !important;
}


/* Original SVG uses white fill */
.sidebar .nav-links
.dropdownToggle
> .iocn-link
> .arrow
svg path {
    fill: #9298a3 !important;
}


.sidebar .nav-links
.dropdownToggle
> .iocn-link:hover
> .arrow {
    background: #ecefed !important;
}


/* ------------------------------------------------------------
   Dropdown hover
   ------------------------------------------------------------ */

.sidebar .nav-links
> li.dropdownToggle
> .iocn-link:hover {
    background: #f5f7f6 !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .iocn-link:hover
> a {
    color: #171914 !important;
}


/* ============================================================
   SUBMENU
   ============================================================ */

.sidebar .nav-links
> li.dropdownToggle
> .sub-menu {
    position: static !important;

    display: none !important;

    width: 100% !important;
    height: auto !important;

    margin: 2px 0 7px !important;

    padding: 3px 0 3px 43px !important;

    background: transparent !important;

    border: 0 !important;

    box-shadow: none !important;

    opacity: 1 !important;

    transform: none !important;
}


.sidebar .nav-links
> li.dropdownToggle.showMenu
> .sub-menu {
    display: block !important;
}


/* Hide duplicate submenu heading */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li:first-child
> a.link_name {
    display: none !important;
}


/* Submenu item */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li {
    width: 100% !important;

    min-height: 32px !important;

    margin: 1px 0 !important;
}


/* Submenu link */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a {
    min-height: 32px !important;

    display: flex !important;
    align-items: center !important;

    padding: 6px 10px !important;

    border-radius: 7px !important;

    color: #818793 !important;

    font-size: 12px !important;
    font-weight: 500 !important;

    background: transparent !important;

    text-decoration: none !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a:hover {
    background: #f4f6f5 !important;

    color: #171914 !important;
}


/* Active submenu */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a.active {
    color: #0f766e !important;

    background: #edf7f5 !important;

    font-weight: 600 !important;
}


/* ============================================================
   ICON
   ============================================================ */

.sidebar .nav-links .sidebar_icon {
    width: 32px !important;
    min-width: 32px !important;
    height: 32px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    margin-right: 9px !important;

    color: #858b97 !important;
}


.sidebar .nav-links .sidebar_icon svg {
    width: 17px !important;
    height: 17px !important;

    min-width: 17px !important;
    max-width: 17px !important;

    min-height: 17px !important;
    max-height: 17px !important;
}


/* ============================================================
   NORMAL MENU
   ============================================================ */

.sidebar .nav-links
> li:not(.dropdownToggle)
> .iocn-link {
    width: 100% !important;

    min-height: 44px !important;

    display: flex !important;
    align-items: center !important;

    padding: 7px 10px !important;

    border-radius: 10px !important;
}


.sidebar .nav-links
> li:not(.dropdownToggle)
> .iocn-link
> a {
    display: flex !important;
    align-items: center !important;

    width: 100% !important;

    padding: 0 !important;

    color: #747b89 !important;

    background: transparent !important;
}


/* ============================================================
   ACTIVE PREMIUM BLACK PILL
   Your current route uses showMenu
   ============================================================ */

.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link {
    background: #171914 !important;
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link
> a {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.link_name {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon {
    color: #ffffff !important;
}


/* SVG active */
.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon svg,
.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon svg path {
    fill: #ffffff !important;
    stroke: #ffffff !important;
}


/* Dropdown active parent */
.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link,
.sidebar .nav-links
> li.dropdownToggle.showMenu.active
> .iocn-link {
    background: #171914 !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link
> a,
.sidebar .nav-links
> li.dropdownToggle.showMenu.active
> .iocn-link
> a {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
.link_name {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
.sidebar_icon {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link
> .arrow
svg path {
    fill: #ffffff !important;
}


/* ============================================================
   TYPOGRAPHY
   ============================================================ */

.sidebar .nav-links .link_name {
    font-size: 13px !important;

    font-weight: 500 !important;

    line-height: 18px !important;

    letter-spacing: -.01em !important;

    color: inherit !important;
}


/* ============================================================
   SECTION TITLES
   Actual navigation currently uses H6
   ============================================================ */

.sidebar .nav-links > h6 {
    padding: 17px 10px 7px !important;

    margin: 0 !important;

    color: #147d82 !important;

    font-size: 11px !important;

    font-weight: 700 !important;

    line-height: 14px !important;

    letter-spacing: .075em !important;

    text-transform: uppercase !important;
}


/* Inline padding from Blade override */
.sidebar .nav-links > h6[style] {
    padding-left: 10px !important;
}


/* ============================================================
   MAIN SPACING
   ============================================================ */

.sidebar .nav-links {
    padding: 13px 12px 30px !important;
}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 767.98px) {

    .sidebar .nav-links
    > li.dropdownToggle
    > .sub-menu {
        padding-left: 41px !important;
    }

}

/*  */


/* ============================================================
   STEP 3 — SIDEBAR SEARCH + PREMIUM POLISH
   ============================================================ */

.cs-sidebar-search {
    position: relative;

    margin: 10px 12px 8px;

    display: flex;
    align-items: center;
}

.cs-sidebar-search i {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    color: #969ca7;

    font-size: 13px;

    pointer-events: none;
}

.cs-sidebar-search input {
    width: 100%;

    height: 38px;

    padding: 0 12px 0 34px;

    border: 1px solid #e7e9ec;
    border-radius: 9px;

    background: #f8f9fa;

    color: #171914;

    font-size: 12px;
    font-weight: 500;

    outline: none;

    transition:
        border-color .18s ease,
        background .18s ease,
        box-shadow .18s ease;
}

.cs-sidebar-search input::placeholder {
    color: #a1a6af;
}

.cs-sidebar-search input:focus {
    background: #ffffff;

    border-color: #b8c8c7;

    box-shadow:
        0 0 0 3px rgba(20, 125, 130, .08);
}


/* Slightly tighter professional density */
.sidebar .nav-links > li {
    margin: 1px 0 !important;
}

.sidebar .nav-links > li > .iocn-link,
.sidebar .nav-links > li > .icon-link,
.sidebar .nav-links > li > a {
    min-height: 42px !important;
}

.sidebar .nav-links .sidebar_icon {
    width: 30px !important;
    min-width: 30px !important;
    height: 30px !important;

    margin-right: 8px !important;
}

.sidebar .nav-links .sidebar_icon svg {
    width: 16px !important;
    height: 16px !important;

    min-width: 16px !important;
    min-height: 16px !important;

    max-width: 16px !important;
    max-height: 16px !important;
}

.sidebar .nav-links .link_name {
    font-size: 12.5px !important;
}


/* Improve active item slightly */
.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link {
    background: #171914 !important;

    box-shadow:
        0 1px 2px rgba(0, 0, 0, .08),
        0 5px 14px rgba(15, 23, 42, .08);
}


/* Section headings */
.sidebar .nav-links > h6 {
    padding-top: 15px !important;
    padding-bottom: 6px !important;

    color: #137c83 !important;

    font-size: 10.5px !important;
}


/* Better scrollbar */
.sidebar .nav-links::-webkit-scrollbar {
    width: 4px;
}

.sidebar .nav-links::-webkit-scrollbar-thumb {
    background: #d6dadd;

    border-radius: 20px;
}


/* Search hidden on very small mobile only if needed */
@media (max-width: 360px) {
    .cs-sidebar-search {
        margin-left: 10px;
        margin-right: 10px;
    }
}



/*  */

/* ============================================================
   STEP 3 FIX — LOGO + SEARCH
   ============================================================ */

.sidebar .logo-details {
    width: 100% !important;
    height: 92px !important;
    min-height: 92px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    padding: 15px 22px !important;

    overflow: hidden !important;

    border-bottom: 0 !important;
}

.sidebar .logo-details img {
    display: block !important;

    width: auto !important;
    height: auto !important;

    max-width: 185px !important;
    max-height: 58px !important;

    object-fit: contain !important;

    margin: 0 auto !important;
}


/* Search gets its own row */
.cs-sidebar-search {
    position: relative !important;

    width: auto !important;

    display: flex !important;
    align-items: center !important;

    margin: 0 14px 10px !important;

    padding: 0 !important;
}

.cs-sidebar-search input {
    display: block !important;

    width: 100% !important;
    height: 38px !important;

    padding: 0 12px 0 36px !important;

    background: #f7f8f8 !important;

    border: 1px solid #e6e9eb !important;
    border-radius: 9px !important;

    color: #1d2127 !important;

    font-size: 12px !important;

    outline: none !important;
}

.cs-sidebar-search i {
    position: absolute !important;

    left: 13px !important;
    top: 50% !important;

    transform: translateY(-50%) !important;

    margin: 0 !important;

    width: auto !important;
    height: auto !important;

    color: #949aa4 !important;

    font-size: 13px !important;

    z-index: 2;
}


/* Navigation starts cleanly below search */
.sidebar .nav-links {
    padding-top: 4px !important;
}
/*  */




/* ============================================================
   STEP 4B — PREMIUM TOPBAR
   ============================================================ */

.cs-topbar {
    position: sticky;
    top: 0;
    z-index: 950;

    min-height: 72px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 16px;

    padding: 0 22px;

    background: rgba(255,255,255,.96);

    border-bottom: 1px solid #eceef1;

    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);

    box-shadow:
        0 1px 2px rgba(15, 23, 42, .02);

    font-family: inherit;
}


/* ============================================================
   LEFT
   ============================================================ */

.cs-topbar-left {
    min-width: 220px;

    display: flex;
    align-items: center;

    gap: 12px;
}


.cs-sidebar-trigger {
    width: 38px;
    height: 38px;

    flex: 0 0 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 1px solid transparent;
    border-radius: 9px;

    background: transparent;

    color: #626976;

    cursor: pointer;

    transition:
        background .18s ease,
        border-color .18s ease,
        color .18s ease;
}


.cs-sidebar-trigger:hover {
    background: #f5f7f8;

    border-color: #e8eaed;

    color: #171914;
}


.cs-sidebar-trigger .menuList {
    display: flex;
    align-items: center;
    justify-content: center;
}


.cs-sidebar-trigger i {
    font-size: 21px;
    line-height: 1;
}


.cs-topbar-brand {
    display: flex;
    flex-direction: column;

    min-width: 0;
}


.cs-topbar-title {
    color: #171914;

    font-size: 15px;
    font-weight: 700;

    line-height: 1.2;

    white-space: nowrap;
}


.cs-topbar-subtitle {
    margin-top: 2px;

    color: #9aa0aa;

    font-size: 10.5px;
    font-weight: 500;

    line-height: 1.2;

    white-space: nowrap;
}


/* ============================================================
   CENTER
   ============================================================ */

.cs-topbar-center {
    flex: 1 1 auto;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    min-width: 0;

    overflow-x: auto;
    overflow-y: hidden;

    scrollbar-width: none;
}


.cs-topbar-center::-webkit-scrollbar {
    display: none;
}


/* ============================================================
   FINANCE CARDS
   ============================================================ */

.cs-finance-card {
    height: 42px;

    display: inline-flex;
    align-items: center;

    gap: 8px;

    flex: 0 0 auto;

    padding: 5px 11px 5px 6px;

    background: #ffffff;

    border: 1px solid #e8ebee;
    border-radius: 12px;

    box-shadow:
        0 1px 2px rgba(15, 23, 42, .03);

    transition:
        border-color .18s ease,
        box-shadow .18s ease,
        transform .18s ease;
}


.cs-finance-card:hover {
    border-color: #dfe3e7;

    box-shadow:
        0 4px 14px rgba(15, 23, 42, .06);

    transform: translateY(-1px);
}


.cs-finance-icon {
    width: 30px;
    height: 30px;

    flex: 0 0 30px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    font-size: 12px;
}


.cs-finance-green {
    background: #e9f8f0;

    color: #22a268;
}


.cs-finance-red {
    background: #fff0f2;

    color: #ee3f68;
}


.cs-finance-content {
    display: flex;
    flex-direction: column;

    line-height: 1.05;
}


.cs-finance-label {
    color: #9097a2;

    font-size: 10px;
    font-weight: 500;

    margin-bottom: 2px;
}


.cs-finance-value {
    color: #171914;

    font-size: 12px;
    font-weight: 700;

    white-space: nowrap;
}


/* ============================================================
   TOPBAR ACTIONS
   ============================================================ */

.cs-topbar-action {
    min-height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 6px;

    flex: 0 0 auto;

    padding: 0 13px;

    border: 1px solid #dde2e6;
    border-radius: 10px;

    background: #ffffff;

    color: #2e3742;

    font-size: 12px;
    font-weight: 600;

    text-decoration: none;

    transition:
        background .18s ease,
        color .18s ease,
        border-color .18s ease,
        box-shadow .18s ease,
        transform .18s ease;
}


.cs-topbar-action:hover {
    background: #f6f8f9;

    border-color: #cfd5da;

    color: #171914;

    box-shadow:
        0 3px 10px rgba(15, 23, 42, .05);

    transform: translateY(-1px);
}


.cs-topbar-action i {
    font-size: 12px;
}


.cs-topbar-action-primary {
    background: #147d82;

    border-color: #147d82;

    color: #ffffff;
}


.cs-topbar-action-primary:hover {
    background: #0f6d72;

    border-color: #0f6d72;

    color: #ffffff;
}


/* ============================================================
   RIGHT
   ============================================================ */

.cs-topbar-right {
    min-width: max-content;

    display: flex;
    align-items: center;

    gap: 8px;
}


/* ============================================================
   NOTIFICATION
   ============================================================ */

.cs-notification-btn {
    position: relative;

    width: 40px;
    height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 1px solid transparent;
    border-radius: 10px;

    background: transparent;

    color: #666d78;

    cursor: pointer;

    transition:
        background .18s ease,
        border-color .18s ease,
        color .18s ease;
}


.cs-notification-btn:hover {
    background: #f5f7f8;

    border-color: #e8eaed;

    color: #171914;
}


.cs-notification-btn i {
    font-size: 17px;
}


.cs-notification-count {
    position: absolute;

    top: -3px;
    right: -3px;

    min-width: 18px;
    height: 18px;

    padding: 0 5px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 2px solid #ffffff;
    border-radius: 999px;

    background: #ef476f;

    color: #ffffff;

    font-size: 9px;
    font-weight: 700;

    line-height: 1;
}


/* ============================================================
   NOTIFICATION DROPDOWN
   ============================================================ */

.cs-notification-dropdown {
    width: 360px;

    padding: 0 !important;

    overflow: hidden;

    border: 1px solid #e5e8eb !important;
    border-radius: 14px !important;

    background: #ffffff;

    box-shadow:
        0 14px 40px rgba(15, 23, 42, .13) !important;
}


.cs-notification-header {
    min-height: 64px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 12px;

    padding: 13px 15px;

    border-bottom: 1px solid #eef0f2;
}


.cs-notification-header > div {
    display: flex;
    flex-direction: column;
}


.cs-notification-header strong {
    color: #171914;

    font-size: 13px;
    font-weight: 700;
}


.cs-notification-header small {
    color: #999fa8;

    font-size: 10.5px;

    margin-top: 1px;
}


.cs-mark-read {
    padding: 6px 8px;

    border: 0;
    border-radius: 7px;

    background: #f2f6f6;

    color: #147d82;

    font-size: 10.5px;
    font-weight: 600;

    cursor: pointer;
}


.cs-mark-read:hover {
    background: #e8f2f1;
}


.cs-notification-list {
    max-height: 390px;

    overflow-y: auto;
}


/* Existing JS injects .notification-item */
.cs-notification-list .notification-item {
    display: block;

    padding: 12px 14px !important;

    background: #ffffff;

    color: #2c333c;

    text-decoration: none;

    border-bottom: 1px solid #f0f1f3 !important;

    transition: background .15s ease;
}


.cs-notification-list .notification-item:hover {
    background: #f8fafa;
}


.cs-notification-list .notification-item:last-child {
    border-bottom: 0 !important;
}


/* ============================================================
   DIVIDER
   ============================================================ */

.cs-topbar-divider {
    width: 1px;
    height: 26px;

    margin: 0 3px;

    background: #e7e9ec;
}


/* ============================================================
   USER
   ============================================================ */

.cs-user-trigger {
    min-height: 46px;

    display: flex;
    align-items: center;

    gap: 9px;

    padding: 4px 7px 4px 5px;

    border: 1px solid transparent;
    border-radius: 11px;

    background: transparent;

    color: #171914;

    cursor: pointer;

    transition:
        background .18s ease,
        border-color .18s ease;
}


.cs-user-trigger:hover,
.cs-user-trigger[aria-expanded="true"] {
    background: #f6f8f8;

    border-color: #e7e9ec;
}


.cs-user-avatar {
    position: relative;

    width: 36px;
    height: 36px;

    flex: 0 0 36px;
}


.cs-user-avatar img {
    width: 36px;
    height: 36px;

    display: block;

    object-fit: cover;

    border-radius: 10px;

    background: #eef0f2;
}


.cs-online-dot {
    position: absolute;

    right: -2px;
    bottom: -2px;

    width: 10px;
    height: 10px;

    border: 2px solid #ffffff;
    border-radius: 50%;

    background: #30b77a;
}


.cs-user-info {
    min-width: 0;

    display: flex;
    flex-direction: column;

    text-align: left;
}


.cs-user-name {
    max-width: 130px;

    overflow: hidden;

    color: #171914;

    font-size: 12px;
    font-weight: 700;

    line-height: 1.2;

    white-space: nowrap;
    text-overflow: ellipsis;
}


.cs-user-role {
    margin-top: 2px;

    color: #9299a4;

    font-size: 10px;
    font-weight: 500;

    line-height: 1.1;

    text-transform: capitalize;
}


.cs-user-arrow {
    margin-left: 2px;

    color: #9aa0a9;

    font-size: 10px;

    transition: transform .18s ease;
}


.cs-user-trigger[aria-expanded="true"]
.cs-user-arrow {
    transform: rotate(180deg);
}


/* ============================================================
   PROFILE DROPDOWN
   ============================================================ */

.cs-profile-menu {
    width: 245px;

    padding: 8px !important;

    border: 1px solid #e5e8eb !important;
    border-radius: 14px !important;

    background: #ffffff;

    box-shadow:
        0 14px 40px rgba(15, 23, 42, .13) !important;
}


.cs-profile-header {
    display: flex;
    align-items: center;

    gap: 10px;

    padding: 8px 8px 10px;
}


.cs-profile-avatar {
    width: 40px;
    height: 40px;

    flex: 0 0 40px;
}


.cs-profile-avatar img {
    width: 40px;
    height: 40px;

    object-fit: cover;

    border-radius: 10px;
}


.cs-profile-header > div:last-child {
    min-width: 0;

    display: flex;
    flex-direction: column;
}


.cs-profile-header strong {
    max-width: 155px;

    overflow: hidden;

    color: #171914;

    font-size: 12.5px;
    font-weight: 700;

    white-space: nowrap;
    text-overflow: ellipsis;
}


.cs-profile-header span {
    margin-top: 2px;

    color: #9298a2;

    font-size: 10.5px;

    text-transform: capitalize;
}


.cs-profile-menu .dropdown-divider {
    margin: 5px 0;

    border-color: #eef0f2;
}


.cs-profile-item {
    min-height: 38px;

    display: flex !important;
    align-items: center;

    gap: 9px;

    padding: 7px 8px !important;

    border-radius: 8px;

    color: #505761 !important;

    font-size: 11.5px;
    font-weight: 500;

    transition:
        background .15s ease,
        color .15s ease;
}


.cs-profile-item:hover {
    background: #f5f7f8 !important;

    color: #171914 !important;
}


.cs-profile-item-icon {
    width: 28px;
    height: 28px;

    flex: 0 0 28px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #f1f4f4;

    color: #147d82;
}


.cs-profile-item-icon i {
    font-size: 12px;
}


.cs-logout-item {
    color: #b63a46 !important;
}


.cs-logout-item .cs-profile-item-icon {
    background: #fff1f2;

    color: #cf4452;
}


/* ============================================================
   REMOVE LEGACY HEADER STYLING
   ============================================================ */

.home-header {
    display: none !important;
}


.cs-topbar .btn-secondary,
.cs-topbar .dropdown-toggle {
    box-shadow: none !important;
}


/* ============================================================
   TABLET
   ============================================================ */

@media (max-width: 1180px) {

    .cs-topbar {
        padding: 0 16px;
    }


    .cs-topbar-left {
        min-width: auto;
    }


    .cs-topbar-subtitle {
        display: none;
    }


    .cs-user-name {
        max-width: 90px;
    }


    .cs-finance-card {
        padding-right: 8px;
    }

}


/* ============================================================
   MOBILE / SMALL TABLET
   ============================================================ */

@media (max-width: 900px) {

    .cs-topbar {
        min-height: 64px;

        padding: 0 12px;

        gap: 8px;
    }


    .cs-topbar-center {
        justify-content: flex-start;

        order: 3;

        position: absolute;

        top: 64px;
        left: 0;
        right: 0;

        padding: 7px 12px;

        background: #ffffff;

        border-bottom: 1px solid #eceef1;

        box-shadow:
            0 3px 10px rgba(15,23,42,.03);
    }


    .home-section .main_content {
        padding-top: 56px;
    }


    .cs-topbar-title {
        font-size: 13px;
    }


    .cs-user-info {
        display: none;
    }


    .cs-user-arrow {
        display: none;
    }


    .cs-user-trigger {
        padding: 4px;
    }

}


/* ============================================================
   SMALL MOBILE
   ============================================================ */

@media (max-width: 576px) {

    .cs-topbar {
        padding: 0 8px;
    }


    .cs-topbar-brand {
        max-width: 125px;
    }


    .cs-topbar-title {
        overflow: hidden;

        white-space: nowrap;
        text-overflow: ellipsis;
    }


    .cs-topbar-action {
        min-height: 34px;

        padding: 0 10px;

        font-size: 11px;
    }


    .cs-topbar-action i {
        display: none;
    }


    .cs-finance-card {
        height: 38px;
    }


    .cs-finance-icon {
        width: 27px;
        height: 27px;

        flex-basis: 27px;
    }


    .cs-finance-label {
        font-size: 9px;
    }


    .cs-finance-value {
        font-size: 10.5px;
    }


    .cs-notification-dropdown {
        width: min(340px, calc(100vw - 20px));
    }


    .cs-profile-menu {
        width: min(245px, calc(100vw - 20px));
    }

}

/* ============================================================
   STEP 4C — TOPBAR FINAL POLISH
   ============================================================ */

.cs-topbar {
    min-height: 68px;
    padding-left: 18px;
    padding-right: 18px;
}

.cs-topbar-left {
    gap: 10px;
}

.cs-topbar-title {
    font-size: 14.5px;
    font-weight: 700;
}

.cs-topbar-subtitle {
    font-size: 10px;
    color: #a0a6af;
}

/* finance cards */
.cs-finance-card {
    height: 40px;
    border-color: #edf0f2;
    box-shadow: none;
}

.cs-finance-card:hover {
    border-color: #dfe4e7;
    box-shadow: 0 3px 10px rgba(15,23,42,.05);
}

/* action buttons */
.cs-topbar-action {
    min-height: 36px;
    padding: 0 12px;
    border-radius: 9px;
}

/* right area */
.cs-topbar-right {
    gap: 6px;
}

/* notification */
.cs-notification-btn {
    width: 38px;
    height: 38px;
}

/* user */
.cs-user-trigger {
    min-height: 42px;
    padding: 3px 6px 3px 4px;
}

.cs-user-avatar,
.cs-user-avatar img {
    width: 34px;
    height: 34px;
}

.cs-user-avatar {
    flex-basis: 34px;
}

.cs-user-name {
    font-size: 11.5px;
}

.cs-user-role {
    font-size: 9.5px;
}

/* content spacing */
.home-section .main_content {
    padding-top: 18px !important;
}

/* desktop alignment */
@media (min-width: 1200px) {
    .cs-topbar-center {
        gap: 7px;
    }
}

/*  */





/* ============================================================
   STEP 3 — REFERENCE STYLE SIDEBAR POLISH
   ============================================================ */

:root {
    --cs-sidebar-width: 268px;
}


/* Sidebar width */
.sidebar,
.sub-sidebar {
    width: var(--cs-sidebar-width) !important;
}


/* Main page alignment */
.home-section {
    left: var(--cs-sidebar-width) !important;
    width: calc(100% - var(--cs-sidebar-width)) !important;
}


/* Logo area */
.sidebar .logo-details {
    height: 86px !important;
    min-height: 86px !important;

    padding: 14px 18px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}


.sidebar .logo-details img {
    max-width: 185px !important;
    max-height: 56px !important;
}


/* Search */
.cs-sidebar-search {
    margin: 0 14px 12px !important;
}


.cs-sidebar-search input {
    height: 38px !important;

    background: #f7f8f9 !important;

    border: 1px solid #e7eaee !important;
    border-radius: 9px !important;

    font-size: 12px !important;
}


/* Scroll menu area */
.sidebar .nav-links {
    padding: 4px 12px 18px !important;

    scrollbar-width: thin;
}


/* Section headings */
.sidebar .nav-links > h6 {
    margin: 0 !important;

    padding: 17px 10px 7px !important;

    color: #7d838e !important;

    font-size: 9.5px !important;
    font-weight: 700 !important;

    line-height: 1.2 !important;

    letter-spacing: .12em !important;

    text-transform: uppercase !important;
}


/* Override inline heading padding */
.sidebar .nav-links > h6[style] {
    padding-left: 10px !important;
}


/* Menu item */
.sidebar .nav-links > li {
    margin: 1px 0 !important;

    border-radius: 10px !important;
}


/* Main menu row */
.sidebar .nav-links > li > .iocn-link {
    min-height: 42px !important;

    padding: 5px 8px !important;

    display: flex !important;
    align-items: center !important;

    border-radius: 10px !important;

    transition:
        background .16s ease,
        color .16s ease,
        box-shadow .16s ease;
}


/* Actual link */
.sidebar .nav-links > li > .iocn-link > a {
    display: flex !important;
    align-items: center !important;

    flex: 1 !important;
    min-width: 0 !important;

    padding: 0 !important;

    color: #707784 !important;

    text-decoration: none !important;
}


/* Icon holder */
.sidebar .sidebar_icon {
    width: 30px !important;
    min-width: 30px !important;
    height: 30px !important;

    margin-right: 8px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    color: #7d8490 !important;
}


/* SVG */
.sidebar .sidebar_icon svg {
    width: 16px !important;
    height: 16px !important;

    min-width: 16px !important;
    max-width: 16px !important;

    min-height: 16px !important;
    max-height: 16px !important;
}


/* Menu label */
.sidebar .link_name {
    color: inherit !important;

    font-size: 12.5px !important;
    font-weight: 500 !important;

    line-height: 18px !important;

    white-space: nowrap !important;

    overflow: hidden !important;
    text-overflow: ellipsis !important;
}


/* Hover */
.sidebar .nav-links > li > .iocn-link:hover {
    background: #f5f6f7 !important;
}


.sidebar .nav-links > li > .iocn-link:hover > a {
    color: #171914 !important;
}


/* ============================================================
   ACTIVE ITEM — BLACK PILL
   ============================================================ */

.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link {
    background: #171914 !important;

    box-shadow:
        0 1px 2px rgba(0, 0, 0, .05),
        0 5px 14px rgba(15, 23, 42, .07);
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link
> a {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon {
    color: #ffffff !important;
}


/* Existing filled SVG support */
.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon svg,
.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon svg path {
    fill: #ffffff !important;
}


/* ============================================================
   DROPDOWN PARENT
   ============================================================ */

.sidebar .nav-links
> li.dropdownToggle
> .iocn-link {
    min-height: 42px !important;

    padding: 5px 8px !important;

    border-radius: 10px !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .iocn-link
> a {
    color: #707784 !important;
}


/* Arrow */
.sidebar .nav-links
> li.dropdownToggle
> .iocn-link
> .arrow {
    width: 26px !important;
    min-width: 26px !important;
    height: 26px !important;

    margin-left: auto !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 7px !important;

    transition:
        background .16s ease,
        transform .16s ease;
}


.sidebar .nav-links
> li.dropdownToggle
> .iocn-link
> .arrow:hover {
    background: #edf0f1 !important;
}


/* Arrow color */
.sidebar .nav-links
> li.dropdownToggle
> .iocn-link
> .arrow
svg path {
    fill: #8e949d !important;
}


/* Open dropdown */
.sidebar .nav-links
> li.dropdownToggle.showMenu
> .iocn-link
> .arrow {
    transform: rotate(90deg) !important;
}


/* Active dropdown parent */
.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link {
    background: #171914 !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link
> a {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link
> .arrow
svg path {
    fill: #ffffff !important;
}


/* ============================================================
   SUB MENU
   ============================================================ */

.sidebar .nav-links
> li.dropdownToggle
> .sub-menu {
    position: static !important;

    display: none !important;

    margin: 2px 0 6px !important;

    padding: 2px 0 2px 39px !important;

    background: transparent !important;

    border: none !important;

    box-shadow: none !important;
}


.sidebar .nav-links
> li.dropdownToggle.showMenu
> .sub-menu {
    display: block !important;
}


/* Hide duplicate submenu title */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li:first-child
> a.link_name {
    display: none !important;
}


/* Submenu link */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a {
    min-height: 30px !important;

    padding: 5px 9px !important;

    display: flex !important;
    align-items: center !important;

    border-radius: 7px !important;

    background: transparent !important;

    color: #8b919c !important;

    font-size: 11.5px !important;
    font-weight: 500 !important;

    text-decoration: none !important;
}


/* Hover */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a:hover {
    background: #f5f6f7 !important;

    color: #171914 !important;
}


/* Active submenu */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a.active {
    background: #eef6f5 !important;

    color: #137d82 !important;

    font-weight: 600 !important;
}


/* ============================================================
   BOTTOM AREA
   ============================================================ */

.cs-sidebar-bottom {
    padding: 8px 12px 12px !important;

    background: #ffffff !important;

    border-top: 1px solid #eef0f2 !important;
}


.cs-sidebar-settings {
    min-height: 38px !important;

    padding: 7px 10px !important;

    font-size: 12px !important;

    border-radius: 9px !important;
}


.cs-sidebar-user {
    min-height: 54px !important;

    padding: 7px 9px !important;

    border-radius: 12px !important;

    background: #f8f9fa !important;

    border: 1px solid #e7e9ed !important;
}


.cs-sidebar-user-avatar {
    width: 34px !important;
    height: 34px !important;

    flex-basis: 34px !important;
}


.cs-sidebar-user-info strong {
    font-size: 12px !important;
}


.cs-sidebar-user-info span {
    font-size: 10px !important;
}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 767.98px) {

    .sidebar,
    .sub-sidebar {
        width: 280px !important;
        max-width: 84vw !important;
    }


    .home-section {
        left: 0 !important;
        width: 100% !important;
    }

}


/*  */

/* ============================================================
   STEP 4 — BOND CRM STYLE WORKSPACE HEADER
   ============================================================ */

.cs-workspace-header {
    position: sticky;
    top: 10px;

    z-index: 900;

    min-height: 58px;

    margin:
        10px
        18px
        0;

    padding:
        8px
        12px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 18px;

    background:
        rgba(255, 255, 255, .96);

    border:
        1px solid #edf0f2;

    border-radius: 16px;

    box-shadow:
        0 3px 16px rgba(15, 23, 42, .035);

    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}



/* ============================================================
   LEFT
   ============================================================ */

.cs-workspace-left {
    display: flex;
    align-items: center;

    gap: 11px;

    min-width: 0;
}


/* Hamburger */
.cs-workspace-menu {
    width: 36px;
    height: 36px;

    flex: 0 0 36px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0;
    border-radius: 9px;

    background: transparent;

    color: #737a86;

    cursor: pointer;

    transition:
        background .16s ease,
        color .16s ease;
}


.cs-workspace-menu:hover {
    background: #f5f6f7;

    color: #171914;
}


.cs-workspace-menu i {
    font-size: 19px;
}



/* Breadcrumb */
.cs-workspace-breadcrumb {
    display: flex;
    align-items: center;

    gap: 8px;

    min-width: 0;

    font-size: 12px;
}


.cs-workspace-root {
    color: #9ba1aa;

    font-weight: 500;
}


.cs-workspace-breadcrumb i {
    color: #b6bbc2;

    font-size: 9px;
}


.cs-workspace-breadcrumb strong {
    color: #171914;

    font-weight: 650;

    white-space: nowrap;
}



/* ============================================================
   RIGHT
   ============================================================ */

.cs-workspace-right {
    display: flex;
    align-items: center;

    gap: 9px;

    flex-shrink: 0;
}



/* ============================================================
   PERIOD SWITCHER
   ============================================================ */

.cs-period-switcher {
    display: inline-flex;
    align-items: center;

    padding: 3px;

    border:
        1px solid #eceef1;

    border-radius: 999px;

    background: #fafafa;
}


.cs-period-btn {
    height: 31px;

    padding:
        0
        12px;

    border: 0;
    border-radius: 999px;

    background: transparent;

    color: #777e89;

    font-size: 11px;
    font-weight: 600;

    cursor: pointer;

    transition:
        background .16s ease,
        color .16s ease,
        box-shadow .16s ease;
}


.cs-period-btn:hover {
    color: #171914;
}


.cs-period-btn.active {
    background: #171914;

    color: #ffffff;

    box-shadow:
        0 3px 9px rgba(15, 23, 42, .15);
}



/* ============================================================
   NOTIFICATION
   ============================================================ */

.cs-header-icon-btn {
    position: relative;

    width: 36px;
    height: 36px;

    flex: 0 0 36px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0;
    border-radius: 9px;

    background: transparent;

    color: #676e78;

    cursor: pointer;

    transition:
        background .16s ease,
        color .16s ease;
}


.cs-header-icon-btn:hover {
    background: #f4f6f7;

    color: #171914;
}


.cs-header-icon-btn i {
    font-size: 16px;
}



/* Badge */
.cs-header-notification-count {
    position: absolute;

    top: -4px;
    right: -4px;

    min-width: 18px;
    height: 18px;

    padding:
        0
        5px;

    display: flex;
    align-items: center;
    justify-content: center;

    border:
        2px solid #ffffff;

    border-radius: 999px;

    background: #ee4166;

    color: #ffffff;

    font-size: 9px;
    font-weight: 700;
}



/* ============================================================
   DIVIDER
   ============================================================ */

.cs-header-divider {
    width: 1px;
    height: 24px;

    background: #eceef0;

    margin:
        0
        1px;
}



/* ============================================================
   CREATE
   ============================================================ */

.cs-create-btn {
    height: 36px;

    padding:
        0
        15px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    border: 0;
    border-radius: 10px;

    background: #171914;

    color: #ffffff;

    font-size: 11.5px;
    font-weight: 600;

    cursor: pointer;

    box-shadow:
        0 3px 8px rgba(15, 23, 42, .11);

    transition:
        background .16s ease,
        transform .16s ease,
        box-shadow .16s ease;
}


.cs-create-btn:hover {
    background: #242620;

    transform: translateY(-1px);

    box-shadow:
        0 5px 12px rgba(15, 23, 42, .14);
}


.cs-create-btn i {
    font-size: 12px;
}



/* ============================================================
   USER AVATAR
   ============================================================ */

.cs-header-user {
    min-width: 43px;
    height: 38px;

    padding:
        2px
        5px;

    display: flex;
    align-items: center;

    gap: 5px;

    border: 0;
    border-radius: 10px;

    background: transparent;

    cursor: pointer;

    transition:
        background .16s ease;
}


.cs-header-user:hover,
.cs-header-user[aria-expanded="true"] {
    background: #f5f6f7;
}


.cs-header-avatar {
    position: relative;

    width: 32px;
    height: 32px;

    flex: 0 0 32px;
}


.cs-header-avatar img {
    width: 32px;
    height: 32px;

    display: block;

    object-fit: cover;

    border-radius: 50%;

    background: #eef0f2;
}


.cs-header-online {
    position: absolute;

    right: -1px;
    bottom: -1px;

    width: 9px;
    height: 9px;

    border:
        2px solid #ffffff;

    border-radius: 50%;

    background: #22c77a;
}


.cs-header-user-arrow {
    color: #a3a8b0;

    font-size: 9px;

    transition:
        transform .16s ease;
}


.cs-header-user[aria-expanded="true"]
.cs-header-user-arrow {
    transform: rotate(180deg);
}



/* ============================================================
   NOTIFICATION DROPDOWN
   ============================================================ */

.cs-header-notification-dropdown {
    width: 350px;

    padding: 0 !important;

    overflow: hidden;

    border:
        1px solid #e5e8eb !important;

    border-radius:
        14px !important;

    box-shadow:
        0 14px 40px
        rgba(15, 23, 42, .12) !important;
}


.cs-header-notification-top {
    min-height: 60px;

    padding:
        12px
        14px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    border-bottom:
        1px solid #eef0f2;
}


.cs-header-notification-top > div {
    display: flex;
    flex-direction: column;
}


.cs-header-notification-top strong {
    color: #171914;

    font-size: 12.5px;
}


.cs-header-notification-top small {
    margin-top: 2px;

    color: #9aa0a9;

    font-size: 10px;
}


.cs-header-mark-read {
    padding:
        6px
        8px;

    border: 0;
    border-radius: 7px;

    background: #f0f5f4;

    color: #147d82;

    font-size: 10px;
    font-weight: 600;
}


.cs-header-notification-list {
    max-height: 380px;

    overflow-y: auto;
}


.cs-header-notification-list
.notification-item {
    padding:
        11px
        13px !important;

    border-bottom:
        1px solid #f0f1f3 !important;

    background: #ffffff;

    transition:
        background .15s ease;
}


.cs-header-notification-list
.notification-item:hover {
    background: #f8f9fa;
}



/* ============================================================
   USER DROPDOWN
   ============================================================ */

.cs-header-profile-menu {
    width: 235px;

    padding: 8px !important;

    border:
        1px solid #e5e8eb !important;

    border-radius:
        14px !important;

    box-shadow:
        0 14px 40px
        rgba(15, 23, 42, .12) !important;
}


.cs-header-profile-info {
    padding:
        7px
        7px
        9px;

    display: flex;
    align-items: center;

    gap: 9px;
}


.cs-header-profile-avatar {
    width: 38px;
    height: 38px;

    flex: 0 0 38px;
}


.cs-header-profile-avatar img {
    width: 38px;
    height: 38px;

    object-fit: cover;

    border-radius: 10px;
}


.cs-header-profile-info > div:last-child {
    display: flex;
    flex-direction: column;

    min-width: 0;
}


.cs-header-profile-info strong {
    max-width: 150px;

    overflow: hidden;

    color: #171914;

    font-size: 12px;
    font-weight: 700;

    white-space: nowrap;
    text-overflow: ellipsis;
}


.cs-header-profile-info span {
    margin-top: 2px;

    color: #949aa4;

    font-size: 10px;

    text-transform: capitalize;
}


.cs-header-profile-link {
    min-height: 37px;

    padding:
        7px
        8px !important;

    display: flex !important;
    align-items: center;

    gap: 9px;

    border-radius: 8px;

    color: #525a65 !important;

    font-size: 11.5px;
}


.cs-header-profile-link:hover {
    background: #f5f6f7 !important;

    color: #171914 !important;
}


.cs-header-profile-link i {
    width: 18px;

    color: #737b87;

    text-align: center;
}


.cs-header-logout {
    color: #bb3e49 !important;
}



/* ============================================================
   MAIN CONTENT GAP
   ============================================================ */

.home-section .main_content {
    padding-top: 18px !important;
}



/* ============================================================
   TABLET
   ============================================================ */

@media (max-width: 992px) {

    .cs-workspace-header {
        margin:
            8px
            10px
            0;

        padding:
            7px
            9px;
    }


    .cs-workspace-root {
        display: none;
    }


    .cs-workspace-breadcrumb
    .bi-chevron-right {
        display: none;
    }


    .cs-period-switcher {
        display: none;
    }

}



/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 576px) {

    .cs-workspace-header {
        top: 5px;

        min-height: 54px;

        margin:
            5px
            7px
            0;

        border-radius: 13px;
    }


    .cs-workspace-breadcrumb strong {
        max-width: 120px;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    .cs-header-divider {
        display: none;
    }


    .cs-create-btn {
        width: 36px;

        padding: 0;
    }


    .cs-create-btn span {
        display: none;
    }


    .cs-header-notification-dropdown {
        width:
            min(
                340px,
                calc(100vw - 16px)
            );
    }


    .cs-header-profile-menu {
        width:
            min(
                235px,
                calc(100vw - 16px)
            );
    }

}

/*  */








/* ============================================================
   FINAL PREMIUM SIDEBAR SHELL
   ============================================================ */

:root {
    --cs-sidebar-width: 275px;
}


/* Sidebar outer shell */
.sidebar,
.sub-sidebar {
    width: var(--cs-sidebar-width) !important;

    top: 10px !important;
    left: 10px !important;

    height: calc(100vh - 20px) !important;

    background: #ffffff !important;

    border: 1px solid #edf0f2 !important;
    border-radius: 18px !important;

    box-shadow:
        0 8px 28px rgba(15, 23, 42, .05) !important;

    overflow: hidden !important;
}


/* Main content should start after rounded sidebar */
.home-section {
    left: calc(var(--cs-sidebar-width) + 20px) !important;

    width:
        calc(
            100% -
            var(--cs-sidebar-width) -
            20px
        ) !important;

    background: #f5f7f9 !important;
}


/* ============================================================
   LOGO
   ============================================================ */

.sidebar .logo-details {
    min-height: 88px !important;

    padding: 16px 18px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    background: #ffffff !important;

    border-bottom: 0 !important;
}


.sidebar .logo-details img {
    max-width: 185px !important;
    max-height: 56px !important;

    width: auto !important;
    height: auto !important;

    object-fit: contain !important;
}


/* ============================================================
   SEARCH
   ============================================================ */

.cs-sidebar-search {
    margin: 0 14px 12px !important;
}


.cs-sidebar-search input {
    height: 40px !important;

    padding-left: 36px !important;

    background: #f7f8f9 !important;

    border: 1px solid #e6e9ec !important;
    border-radius: 10px !important;

    font-size: 12px !important;
}


.cs-sidebar-search i {
    left: 13px !important;

    color: #9299a4 !important;

    font-size: 13px !important;
}


/* ============================================================
   NAV AREA
   ============================================================ */

.sidebar .nav-links {
    flex: 1 1 auto !important;

    min-height: 0 !important;

    padding: 2px 12px 18px !important;

    overflow-y: auto !important;
    overflow-x: hidden !important;

    scrollbar-width: thin;
}


/* scrollbar */
.sidebar .nav-links::-webkit-scrollbar {
    width: 4px;
}

.sidebar .nav-links::-webkit-scrollbar-thumb {
    background: #d9dde2;
    border-radius: 20px;
}


/* ============================================================
   SECTION TITLES
   ============================================================ */

.sidebar .nav-links > h6 {
    margin: 0 !important;

    padding: 18px 10px 7px !important;

    color: #7e8590 !important;

    font-size: 9.5px !important;
    font-weight: 700 !important;

    letter-spacing: .12em !important;

    text-transform: uppercase !important;
}


/* ============================================================
   MENU ROWS
   ============================================================ */

.sidebar .nav-links > li {
    margin: 2px 0 !important;

    border-radius: 10px !important;
}


.sidebar .nav-links > li > .iocn-link {
    min-height: 43px !important;

    padding: 6px 8px !important;

    display: flex !important;
    align-items: center !important;

    border-radius: 10px !important;

    transition:
        background .16s ease,
        color .16s ease;
}


.sidebar .nav-links > li > .iocn-link > a {
    display: flex !important;
    align-items: center !important;

    flex: 1 !important;

    min-width: 0 !important;

    padding: 0 !important;

    color: #737a86 !important;

    text-decoration: none !important;
}


/* icon */
.sidebar .sidebar_icon {
    width: 30px !important;
    min-width: 30px !important;
    height: 30px !important;

    margin-right: 8px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    color: #7c838f !important;
}


.sidebar .sidebar_icon svg {
    width: 16px !important;
    height: 16px !important;

    min-width: 16px !important;
    max-width: 16px !important;

    min-height: 16px !important;
    max-height: 16px !important;
}


/* text */
.sidebar .link_name {
    color: inherit !important;

    font-size: 12.5px !important;
    font-weight: 500 !important;

    line-height: 18px !important;

    white-space: nowrap !important;

    overflow: hidden !important;
    text-overflow: ellipsis !important;
}


/* hover */
.sidebar .nav-links > li > .iocn-link:hover {
    background: #f5f6f7 !important;
}

.sidebar .nav-links > li > .iocn-link:hover > a {
    color: #171914 !important;
}


/* ============================================================
   ACTIVE ITEM
   ============================================================ */

.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link {
    background: #171914 !important;

    box-shadow:
        0 4px 12px rgba(15, 23, 42, .08);
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link > a {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon {
    color: #ffffff !important;
}


.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon svg,
.sidebar .nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon svg path {
    fill: #ffffff !important;
}


/* ============================================================
   DROPDOWN
   ============================================================ */

.sidebar .nav-links
> li.dropdownToggle
> .iocn-link {
    border-radius: 10px !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .iocn-link
> .arrow {
    width: 26px !important;
    height: 26px !important;

    margin-left: auto !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 7px !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .iocn-link
> .arrow
svg path {
    fill: #9096a0 !important;
}


.sidebar .nav-links
> li.dropdownToggle.showMenu
> .iocn-link
> .arrow {
    transform: rotate(90deg) !important;
}


/* active dropdown */
.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link {
    background: #171914 !important;
}


.sidebar .nav-links
> li.dropdownToggle.active
> .iocn-link > a {
    color: #ffffff !important;
}


/* ============================================================
   SUB MENU
   ============================================================ */

.sidebar .nav-links
> li.dropdownToggle
> .sub-menu {
    position: static !important;

    display: none !important;

    margin: 2px 0 6px !important;

    padding: 2px 0 2px 39px !important;

    background: transparent !important;

    border: 0 !important;
    box-shadow: none !important;
}


.sidebar .nav-links
> li.dropdownToggle.showMenu
> .sub-menu {
    display: block !important;
}


/* duplicate title hide */
.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li:first-child
> a.link_name {
    display: none !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a {
    min-height: 30px !important;

    padding: 5px 9px !important;

    display: flex !important;
    align-items: center !important;

    border-radius: 7px !important;

    color: #8a909b !important;

    font-size: 11.5px !important;
    font-weight: 500 !important;

    text-decoration: none !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a:hover {
    background: #f5f6f7 !important;

    color: #171914 !important;
}


.sidebar .nav-links
> li.dropdownToggle
> .sub-menu
> li
> a.active {
    background: #eef6f5 !important;

    color: #137d82 !important;

    font-weight: 600 !important;
}


/* ============================================================
   BOTTOM SECTION
   ============================================================ */

.cs-sidebar-bottom {
    flex: 0 0 auto !important;

    padding: 10px 12px 12px !important;

    background: #ffffff !important;

    border-top: 1px solid #edf0f2 !important;
}


/* Settings */
.cs-sidebar-settings {
    min-height: 38px !important;

    padding: 7px 10px !important;

    display: flex !important;
    align-items: center !important;

    gap: 10px !important;

    border-radius: 9px !important;

    color: #69717c !important;

    font-size: 12px !important;
    font-weight: 500 !important;

    text-decoration: none !important;
}


.cs-sidebar-settings:hover {
    background: #f5f6f7 !important;

    color: #171914 !important;
}


/* User card */
.cs-sidebar-user {
    min-height: 55px !important;

    margin-top: 7px !important;

    padding: 7px 9px !important;

    display: flex !important;
    align-items: center !important;

    gap: 9px !important;

    background: #f8f9fa !important;

    border: 1px solid #e7eaed !important;
    border-radius: 13px !important;
}


.cs-sidebar-user-avatar {
    width: 34px !important;
    height: 34px !important;

    flex: 0 0 34px !important;

    border-radius: 50% !important;

    overflow: hidden !important;
}


.cs-sidebar-user-avatar img {
    width: 100% !important;
    height: 100% !important;

    object-fit: cover !important;
}


.cs-sidebar-user-info {
    flex: 1 !important;

    min-width: 0 !important;
}


.cs-sidebar-user-info strong {
    display: block !important;

    color: #171914 !important;

    font-size: 12px !important;
    font-weight: 600 !important;

    white-space: nowrap !important;

    overflow: hidden !important;
    text-overflow: ellipsis !important;
}


.cs-sidebar-user-info span {
    display: block !important;

    margin-top: 2px !important;

    color: #9299a4 !important;

    font-size: 10px !important;

    white-space: nowrap !important;

    overflow: hidden !important;
    text-overflow: ellipsis !important;
}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 767.98px) {

    .sidebar,
    .sub-sidebar {
        top: 0 !important;
        left: 0 !important;

        width: 280px !important;
        max-width: 84vw !important;

        height: 100vh !important;

        border-radius: 0 16px 16px 0 !important;
    }


    .home-section {
        left: 0 !important;

        width: 100% !important;
    }

}

/*  */







/* ============================================================
   STEP 4B
   PREMIUM HEADER — ORIGINAL ERP CONTENT
   ============================================================ */

.cs-premium-header {
    position: sticky;
    top: 10px;
    z-index: 950;

    min-height: 64px;

    margin: 10px 16px 0;
    padding: 8px 12px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 14px;

    background: rgba(255, 255, 255, .97);

    border: 1px solid #e9ecef;
    border-radius: 16px;

    box-shadow:
        0 4px 18px rgba(15, 23, 42, .045);

    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}


/* ============================================================
   LEFT
   ============================================================ */

.cs-premium-header-left {
    display: flex;
    align-items: center;

    gap: 10px;

    flex: 0 0 auto;
    min-width: 185px;
}


.cs-premium-menu-btn {
    width: 38px;
    height: 38px;

    flex: 0 0 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0;
    border-radius: 10px;

    background: transparent;

    color: #69717d;

    cursor: pointer;

    transition:
        background .18s ease,
        color .18s ease;
}


.cs-premium-menu-btn:hover {
    background: #f3f5f6;
    color: #151713;
}


.cs-premium-menu-btn .menuList {
    display: flex;
    align-items: center;
    justify-content: center;
}


.cs-premium-menu-btn i {
    font-size: 21px;
    line-height: 1;
}


.cs-premium-brand-info {
    display: flex;
    flex-direction: column;

    min-width: 0;
}


.cs-premium-brand-title {
    max-width: 150px;

    color: #181a17;

    font-size: 13px;
    font-weight: 700;

    line-height: 1.2;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


.cs-premium-brand-subtitle {
    margin-top: 3px;

    color: #9aa0a9;

    font-size: 9.5px;
    font-weight: 500;

    line-height: 1.1;
}


/* ============================================================
   CENTER
   ============================================================ */

.cs-premium-header-center {
    flex: 1 1 auto;

    min-width: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    overflow-x: auto;
    overflow-y: hidden;

    scrollbar-width: none;
}


.cs-premium-header-center::-webkit-scrollbar {
    display: none;
}


/* ============================================================
   RECEIVABLE / PAYABLE
   ============================================================ */

.cs-premium-finance-card {
    height: 40px;

    flex: 0 0 auto;

    display: flex;
    align-items: center;

    gap: 8px;

    padding: 5px 10px 5px 5px;

    background: #fff;

    border: 1px solid #e8ebee;
    border-radius: 11px;

    transition:
        border-color .18s ease,
        box-shadow .18s ease,
        transform .18s ease;
}


.cs-premium-finance-card:hover {
    border-color: #dce1e5;

    box-shadow:
        0 4px 12px rgba(15, 23, 42, .05);

    transform: translateY(-1px);
}


.cs-premium-finance-icon {
    width: 30px;
    height: 30px;

    flex: 0 0 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    font-size: 12px;
}


.cs-premium-green {
    background: #eaf8f0;
    color: #269c68;
}


.cs-premium-red {
    background: #fff0f2;
    color: #e94b67;
}


.cs-premium-finance-info {
    display: flex;
    flex-direction: column;

    line-height: 1.1;
}


.cs-premium-finance-info span {
    margin-bottom: 2px;

    color: #949ba5;

    font-size: 9.5px;
    font-weight: 500;
}


.cs-premium-finance-info strong {
    color: #181a17;

    font-size: 11.5px;
    font-weight: 700;

    white-space: nowrap;
}


/* ============================================================
   PROFORMA / PURCHASE / SUSPENSE
   ============================================================ */

.cs-premium-header-action {
    height: 38px;

    flex: 0 0 auto;

    padding: 0 12px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    background: #fff;

    border: 1px solid #e2e5e8;
    border-radius: 10px;

    color: #3f4650;

    font-size: 11.5px;
    font-weight: 600;

    text-decoration: none !important;

    transition:
        background .18s ease,
        border-color .18s ease,
        color .18s ease,
        transform .18s ease,
        box-shadow .18s ease;
}


.cs-premium-header-action:hover {
    background: #f7f8f9;

    border-color: #d4d9dd;

    color: #181a17;

    transform: translateY(-1px);

    box-shadow:
        0 4px 10px rgba(15, 23, 42, .045);
}


.cs-premium-action-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}


.cs-premium-action-icon i {
    font-size: 12px;
}


/* Suspense highlighted */
.cs-premium-header-primary {
    background: #171914 !important;
    border-color: #171914 !important;

    color: #fff !important;

    box-shadow:
        0 3px 8px rgba(15, 23, 42, .10);
}


.cs-premium-header-primary:hover {
    background: #282a25 !important;
    border-color: #282a25 !important;

    color: #fff !important;
}


/* ============================================================
   RIGHT
   ============================================================ */

.cs-premium-header-right {
    display: flex;
    align-items: center;

    gap: 7px;

    flex: 0 0 auto;
}


/* ============================================================
   NOTIFICATION
   ============================================================ */

.cs-premium-notification-btn {
    position: relative;

    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;

    border: 0;
    border-radius: 10px;

    background: transparent;

    color: #68707b;

    cursor: pointer;

    transition:
        background .18s ease,
        color .18s ease;
}


.cs-premium-notification-btn:hover,
.cs-premium-notification-btn[aria-expanded="true"] {
    background: #f3f5f6;

    color: #181a17;
}


.cs-premium-notification-btn i {
    font-size: 16px;
}


.cs-premium-notification-count {
    position: absolute;

    top: -4px;
    right: -4px;

    min-width: 18px;
    height: 18px;

    padding: 0 5px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 2px solid #fff;
    border-radius: 999px;

    background: #e94a65;

    color: #fff;

    font-size: 9px;
    font-weight: 700;

    line-height: 1;
}


/* ============================================================
   DIVIDER
   ============================================================ */

.cs-premium-header-divider {
    width: 1px;
    height: 25px;

    margin: 0 2px;

    background: #e6e9ec;
}


/* ============================================================
   USER
   ============================================================ */

.cs-premium-user-trigger {
    min-height: 42px;

    display: flex;
    align-items: center;

    gap: 8px;

    padding: 3px 7px 3px 4px;

    border: 1px solid transparent;
    border-radius: 11px;

    background: transparent;

    color: #181a17;

    cursor: pointer;

    transition:
        background .18s ease,
        border-color .18s ease;
}


.cs-premium-user-trigger:hover,
.cs-premium-user-trigger[aria-expanded="true"] {
    background: #f5f6f7;

    border-color: #e8ebed;
}


.cs-premium-user-avatar {
    position: relative;

    width: 34px;
    height: 34px;

    flex: 0 0 34px;
}


.cs-premium-user-avatar img {
    width: 34px;
    height: 34px;

    display: block;

    object-fit: cover;

    border-radius: 50%;

    background: #edf0f2;
}


.cs-premium-online-dot {
    position: absolute;

    right: -1px;
    bottom: -1px;

    width: 10px;
    height: 10px;

    border: 2px solid #fff;
    border-radius: 50%;

    background: #2bb673;
}


.cs-premium-user-info {
    min-width: 0;

    display: flex;
    flex-direction: column;

    text-align: left;
}


.cs-premium-user-name {
    max-width: 115px;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    color: #181a17;

    font-size: 11.5px;
    font-weight: 700;

    line-height: 1.2;
}


.cs-premium-user-role {
    margin-top: 2px;

    color: #979da6;

    font-size: 9.5px;
    font-weight: 500;

    line-height: 1.1;

    text-transform: capitalize;
}


.cs-premium-user-arrow {
    color: #9ba1aa;

    font-size: 9px;

    transition: transform .18s ease;
}


.cs-premium-user-trigger[aria-expanded="true"]
.cs-premium-user-arrow {
    transform: rotate(180deg);
}


/* ============================================================
   NOTIFICATION DROPDOWN
   ============================================================ */

.cs-premium-notification-dropdown {
    width: 350px;

    padding: 0 !important;

    overflow: hidden;

    background: #fff;

    border: 1px solid #e5e8eb !important;
    border-radius: 14px !important;

    box-shadow:
        0 16px 42px rgba(15, 23, 42, .13) !important;
}


.cs-premium-notification-header {
    min-height: 62px;

    padding: 12px 14px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 12px;

    border-bottom: 1px solid #eef0f2;
}


.cs-premium-notification-header > div {
    display: flex;
    flex-direction: column;
}


.cs-premium-notification-header strong {
    color: #181a17;

    font-size: 12.5px;
    font-weight: 700;
}


.cs-premium-notification-header small {
    margin-top: 2px;

    color: #999fa8;

    font-size: 10px;
}


.cs-premium-mark-read {
    padding: 6px 8px;

    border: 0;
    border-radius: 7px;

    background: #f1f5f4;

    color: #147d82;

    font-size: 10px;
    font-weight: 600;

    cursor: pointer;
}


.cs-premium-mark-read:hover {
    background: #e8f1f0;
}


.cs-premium-notification-list {
    max-height: 380px;

    overflow-y: auto;
}


/* Existing notification JS */
.cs-premium-notification-list .notification-item {
    display: block;

    padding: 12px 14px !important;

    background: #fff;

    border-bottom: 1px solid #f0f1f3 !important;

    color: #333a43;

    text-decoration: none;

    transition: background .15s ease;
}


.cs-premium-notification-list .notification-item:hover {
    background: #f8f9fa;
}


/* ============================================================
   PROFILE DROPDOWN
   ============================================================ */

.cs-premium-profile-menu {
    width: 245px;

    padding: 8px !important;

    background: #fff;

    border: 1px solid #e5e8eb !important;
    border-radius: 14px !important;

    box-shadow:
        0 16px 42px rgba(15, 23, 42, .13) !important;
}


.cs-premium-profile-header {
    display: flex;
    align-items: center;

    gap: 10px;

    padding: 8px 7px 10px;
}


.cs-premium-profile-avatar {
    width: 40px;
    height: 40px;

    flex: 0 0 40px;
}


.cs-premium-profile-avatar img {
    width: 40px;
    height: 40px;

    object-fit: cover;

    border-radius: 10px;
}


.cs-premium-profile-user {
    min-width: 0;

    display: flex;
    flex-direction: column;
}


.cs-premium-profile-user strong {
    max-width: 160px;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    color: #181a17;

    font-size: 12px;
    font-weight: 700;
}


.cs-premium-profile-user span {
    margin-top: 2px;

    color: #969ca5;

    font-size: 10px;

    text-transform: capitalize;
}


.cs-premium-profile-menu .dropdown-divider {
    margin: 5px 0;

    border-color: #edf0f2;
}


.cs-premium-profile-item {
    min-height: 38px;

    padding: 7px 8px !important;

    display: flex !important;
    align-items: center;

    gap: 9px;

    border-radius: 8px;

    color: #515963 !important;

    font-size: 11.5px;
    font-weight: 500;

    transition:
        background .15s ease,
        color .15s ease;
}


.cs-premium-profile-item:hover {
    background: #f5f6f7 !important;

    color: #181a17 !important;
}


.cs-premium-profile-item-icon {
    width: 28px;
    height: 28px;

    flex: 0 0 28px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #f1f4f4;

    color: #147d82;
}


.cs-premium-profile-item-icon i {
    font-size: 12px;
}


.cs-premium-logout {
    color: #bd3f4c !important;
}


.cs-premium-logout
.cs-premium-profile-item-icon {
    background: #fff1f2;

    color: #cf4452;
}


/* ============================================================
   CONTENT ALIGNMENT
   ============================================================ */

.home-section .main_content {
    padding-top: 18px !important;
}


/* ============================================================
   TABLET
   ============================================================ */

@media (max-width: 1180px) {

    .cs-premium-header {
        margin-left: 12px;
        margin-right: 12px;

        gap: 8px;
    }


    .cs-premium-header-left {
        min-width: auto;
    }


    .cs-premium-brand-subtitle {
        display: none;
    }


    .cs-premium-brand-title {
        max-width: 110px;
    }


    .cs-premium-user-name {
        max-width: 75px;
    }


    .cs-premium-header-action {
        padding: 0 9px;
    }

}


/* ============================================================
   SMALL TABLET
   ============================================================ */

@media (max-width: 950px) {

    .cs-premium-header {
        min-height: 60px;

        padding: 7px 9px;
    }


    .cs-premium-header-center {
        justify-content: flex-start;
    }


    .cs-premium-user-info {
        display: none;
    }


    .cs-premium-user-arrow {
        display: none;
    }


    .cs-premium-user-trigger {
        padding: 3px;
    }

}


/* ============================================================
   MOBILE
   ============================================================ */

@media (max-width: 767.98px) {

    .cs-premium-header {
        top: 6px;

        min-height: 56px;

        margin:
            6px
            7px
            0;

        padding:
            7px
            8px;

        border-radius: 13px;
    }


    .cs-premium-brand-info {
        display: none;
    }


    .cs-premium-header-left {
        min-width: auto;
    }


    /*
     * ERP actions become horizontal scroll row.
     */
    .cs-premium-header-center {
        position: absolute;

        top: 62px;
        left: 0;
        right: 0;

        justify-content: flex-start;

        padding:
            7px
            8px;

        background: #fff;

        border:
            1px solid #edf0f2;

        border-radius: 12px;

        box-shadow:
            0 4px 14px rgba(15, 23, 42, .04);
    }


    .home-section .main_content {
        padding-top: 70px !important;
    }


    .cs-premium-header-right {
        margin-left: auto;
    }

}


/* ============================================================
   SMALL MOBILE
   ============================================================ */

@media (max-width: 480px) {

    .cs-premium-finance-card {
        height: 37px;
    }


    .cs-premium-finance-icon {
        width: 27px;
        height: 27px;

        flex-basis: 27px;
    }


    .cs-premium-finance-info span {
        font-size: 8.5px;
    }


    .cs-premium-finance-info strong {
        font-size: 10.5px;
    }


    .cs-premium-header-action {
        height: 36px;

        padding: 0 9px;

        font-size: 10.5px;
    }


    .cs-premium-notification-dropdown {
        width:
            min(
                340px,
                calc(100vw - 16px)
            );
    }


    .cs-premium-profile-menu {
        width:
            min(
                245px,
                calc(100vw - 16px)
            );
    }

}

/*  */

/* ============================================================
   SIDEBAR COLLAPSE FIX
   OPEN = 275px
   CLOSED = 82px
   ============================================================ */

:root {
    --cs-sidebar-open: 275px;
    --cs-sidebar-close: 82px;
}


/* ================= OPEN ================= */

.sidebar {
    width: var(--cs-sidebar-open) !important;

    transition:
        width .25s ease,
        transform .25s ease !important;
}


.home-section {
    left: calc(var(--cs-sidebar-open) + 20px) !important;

    width:
        calc(
            100% -
            var(--cs-sidebar-open) -
            20px
        ) !important;

    transition:
        left .25s ease,
        width .25s ease !important;
}


/* ============================================================
   COLLAPSED SIDEBAR
   Existing project uses .close
   ============================================================ */

.sidebar.close {
    width: var(--cs-sidebar-close) !important;
}


/* Main content expands */
.sidebar.close ~ .home-section {
    left: calc(var(--cs-sidebar-close) + 20px) !important;

    width:
        calc(
            100% -
            var(--cs-sidebar-close) -
            20px
        ) !important;
}


/* ============================================================
   COLLAPSED LOGO
   ============================================================ */

.sidebar.close .logo-details {
    min-height: 76px !important;

    padding: 12px 8px !important;
}


.sidebar.close .logo-details img {
    max-width: 50px !important;
    max-height: 45px !important;

    object-fit: contain !important;
}


/* ============================================================
   COLLAPSED SEARCH
   ============================================================ */

.sidebar.close .cs-sidebar-search {
    width: 46px !important;
    height: 42px !important;

    margin:
        0
        auto
        12px !important;

    position: relative !important;
}


.sidebar.close .cs-sidebar-search input {
    width: 46px !important;
    height: 42px !important;

    padding: 0 !important;

    color: transparent !important;

    cursor: pointer !important;
}


.sidebar.close .cs-sidebar-search input::placeholder {
    color: transparent !important;
}


.sidebar.close .cs-sidebar-search i {
    position: absolute !important;

    left: 50% !important;
    top: 50% !important;

    transform: translate(-50%, -50%) !important;

    margin: 0 !important;

    pointer-events: none;
}


/* ============================================================
   COLLAPSED NAV
   ============================================================ */

.sidebar.close .nav-links {
    padding:
        4px
        10px
        16px !important;
}


/* Section headings hidden */
.sidebar.close .nav-links > h6 {
    display: none !important;
}


/* IMPORTANT:
   remove old huge spacing in collapsed mode
*/
.sidebar.close .nav-links > li {
    width: 48px !important;

    min-height: 46px !important;

    margin:
        3px
        auto !important;

    padding: 0 !important;

    border-radius: 11px !important;
}


.sidebar.close
.nav-links
> li
> .iocn-link {
    width: 48px !important;
    height: 46px !important;
    min-height: 46px !important;

    padding: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 11px !important;
}


/* Link only icon */
.sidebar.close
.nav-links
> li
> .iocn-link
> a {
    width: 48px !important;
    height: 46px !important;

    flex: 0 0 48px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    padding: 0 !important;

    overflow: hidden !important;
}


/* Icon perfectly centered */
.sidebar.close .sidebar_icon {
    width: 32px !important;
    min-width: 32px !important;
    height: 32px !important;

    margin: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}


.sidebar.close .sidebar_icon svg {
    width: 17px !important;
    height: 17px !important;
}


/* Text hidden */
.sidebar.close .link_name {
    display: none !important;
}


/* Dropdown arrow hidden */
.sidebar.close
.nav-links
> li
> .iocn-link
> .arrow {
    display: none !important;
}


/* Submenus completely hidden */
.sidebar.close .sub-menu {
    display: none !important;
}


/* Active item remains black square/pill */
.sidebar.close
.nav-links
> li.showMenu:not(.dropdownToggle)
> .iocn-link {
    background: #171914 !important;
}


.sidebar.close
.nav-links
> li.showMenu:not(.dropdownToggle)
.sidebar_icon {
    color: #fff !important;
}


/* ============================================================
   COLLAPSED BOTTOM
   ============================================================ */

.sidebar.close .cs-sidebar-bottom {
    padding:
        9px
        10px
        12px !important;
}


/* Settings icon only */
.sidebar.close .cs-sidebar-settings {
    width: 48px !important;
    height: 44px !important;

    margin: auto !important;

    padding: 0 !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}


.sidebar.close .cs-sidebar-settings span {
    display: none !important;
}


/* User card */
.sidebar.close .cs-sidebar-user {
    width: 48px !important;
    height: 48px !important;
    min-height: 48px !important;

    margin:
        7px
        auto
        0 !important;

    padding: 6px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 12px !important;
}


.sidebar.close .cs-sidebar-user-avatar {
    width: 34px !important;
    height: 34px !important;

    flex: 0 0 34px !important;
}


.sidebar.close .cs-sidebar-user-info,
.sidebar.close .cs-sidebar-user-more {
    display: none !important;
}


/* ============================================================
   MOBILE
   Mobile me compact 82px sidebar nahi chahiye.
   Full sidebar slide-in/out hoga.
   ============================================================ */

@media (max-width: 767.98px) {

    .sidebar {
        top: 0 !important;
        left: 0 !important;

        width: 280px !important;
        max-width: 84vw !important;

        height: 100vh !important;

        border-radius:
            0
            16px
            16px
            0 !important;
    }


    .home-section,
    .sidebar.close ~ .home-section {
        left: 0 !important;

        width: 100% !important;
    }

}





/*  */

/* ============================================================
   MOBILE SIDEBAR
   DEFAULT CLOSED
   ============================================================ */

@media (max-width: 767.98px) {

    /*
     * Sidebar full size rahega,
     * lekin default screen ke bahar.
     */
    .sidebar {
        position: fixed !important;

        top: 0 !important;
        left: 0 !important;

        width: 280px !important;
        max-width: 84vw !important;

        height: 100vh !important;

        transform: translateX(-105%) !important;

        transition:
            transform .25s ease !important;

        z-index: 2000 !important;

        border-radius:
            0
            18px
            18px
            0 !important;

        box-shadow:
            10px
            0
            35px
            rgba(15, 23, 42, .12) !important;
    }


    /*
     * OPEN only after hamburger click
     */
    .sidebar.mobile-open {
        transform: translateX(0) !important;
    }


    /*
     * Desktop .close class ko mobile par
     * 82px sidebar nahi banana.
     */
    .sidebar.close {
        width: 280px !important;
        max-width: 84vw !important;

        transform: translateX(-105%) !important;
    }


    .sidebar.close.mobile-open {
        transform: translateX(0) !important;
    }


    /*
     * Content always full width on mobile
     */
    .home-section,
    .sidebar.close ~ .home-section {
        left: 0 !important;

        width: 100% !important;

        margin-left: 0 !important;
    }


    /*
     * Mobile open hone par sidebar content
     * full visible hona chahiye
     */
    .sidebar.mobile-open .link_name {
        display: inline-block !important;
    }


    .sidebar.mobile-open .nav-links > h6 {
        display: block !important;
    }


    .sidebar.mobile-open .cs-sidebar-user-info,
    .sidebar.mobile-open .cs-sidebar-user-more {
        display: block !important;
    }


    .sidebar.mobile-open .cs-sidebar-settings span {
        display: inline-block !important;
    }


    /*
     * Prevent page horizontal movement
     */
    html,
    body {
        overflow-x: hidden;
    }

}





</style>



