<header class="header--mobile">
    <div class="header__left">
        <button class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="header__center">
        <a class="ps-logo" href="{{ route('public.member.dashboard') }}">
            {!! Theme::getLogoImage(maxHeight: 40) !!}
        </a>
    </div>
    <div class="header__right">
        <a href="{{ route('public.member.logout') }}">
            <x-core::icon name="ti ti-logout" />
        </a>
    </div>
</header>

<aside class="ps-drawer--mobile">
    <div class="ps-drawer__header py-3">
        <h4 class="fs-3 mb-0">Menu</h4>
        <button class="ps-drawer__close">
            <x-core::icon name="ti ti-x" />
        </button>
    </div>
    <div class="ps-drawer__content">
        @include('plugins/member::themes.dashboard.layouts.menu')
    </div>
</aside>

<div class="ps-site-overlay"></div>

@push('header')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        /* ===== SIDEBAR DARK GREEN WITH WHITE TEXT ===== */
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        body {
            background: #f8f9fa !important;
        }

        /* DARK GREEN SIDEBAR */
        .ps-main__sidebar,
        aside.ps-main__sidebar,
        .ps-main .ps-main__sidebar {
            background: #1e5245 !important;
            background-color: #1e5245 !important;
            min-height: 100vh !important;
            width: 240px !important;
        }

        .ps-sidebar,
        .ps-main__sidebar .ps-sidebar {
            background: #1e5245 !important;
            background-color: #1e5245 !important;
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            padding: 20px 0 !important;
        }

        .ps-sidebar__top {
            padding: 0 20px 24px 20px !important;
            background: transparent !important;
            margin: 0 !important;
            border: none !important;
        }

        .ps-logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* LARGER LOGO ICON */
        .logo-icon {
            font-size: 36px !important;
            color: white !important;
        }

        /* LARGER WHITE TEXT FOR LOGO */
        .logo-text {
            font-size: 17px !important;
            color: white !important;
            line-height: 1.3;
            font-weight: 500 !important;
        }

        .logo-text strong {
            font-weight: 700 !important;
            display: block;
            font-size: 18px !important;
            color: white !important;
        }

        .logo-text span {
            font-weight: 400 !important;
            opacity: 1 !important;
            font-size: 16px !important;
            color: white !important;
        }

        .ps-block--user-wellcome,
        .ps-block--earning-count {
            display: none !important;
        }

        .ps-sidebar__content {
            flex: 1;
            padding: 0;
        }

        .menu {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
        }

        .menu li {
            margin: 0 !important;
        }

        /* LARGER WHITE TEXT FOR MENU ITEMS */
        .menu a {
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            padding: 14px 20px !important;
            color: white !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            font-size: 16px !important;
            transition: all 0.2s ease !important;
            border-left: 3px solid transparent !important;
            position: relative !important;
        }

        .menu a.active {
            background: transparent !important;
            color: white !important;
            font-weight: 600 !important;
            border-left-color: #ef4444 !important;
        }

        .menu a:hover:not(.active) {
            color: white !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }

        .menu a i,
        .menu a svg {
            font-size: 22px !important;
            width: 22px !important;
            opacity: 1 !important;
            color: white !important;
        }

        .ps-sidebar__footer {
            padding: 20px;
            display: none;
        }

        .ps-main__wrapper {
            background: #f8f9fa !important;
            padding: 0 !important;
            min-height: 100vh;
            margin-left: 0;
        }

        .ps-main__wrapper>header {
            display: none !important;
        }

        #app {
            padding: 0;
        }
    </style>
@endpush

<main class="ps-main">
    <div class="ps-main__sidebar" style="background: #1e5245 !important; background-color: #1e5245 !important;">
        <div class="ps-sidebar" style="background: #1e5245 !important; background-color: #1e5245 !important;">
            <div class="ps-sidebar__top">
                <div class="ps-logo-area">
                    <div class="logo-icon">
                        <i class="ti ti-ball-tennis" style="color: white !important; font-size: 36px !important;"></i>
                    </div>
                    <div class="logo-text">
                        <strong style="color: white !important;">Badminton</strong>
                        <span style="color: white !important;">court</span>
                    </div>
                </div>
            </div>
            <div class="ps-sidebar__content">
                <div class="ps-sidebar__center">
                    <ul class="menu">
                        <li>
                            <a href="{{ route('public.member.dashboard') }}"
                                class="{{ request()->routeIs('public.member.dashboard') ? 'active' : '' }}"
                                style="color: white !important;">
                                <i class="ti ti-home" style="color: white !important;"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/dat-san') }}" style="color: white !important;">
                                <i class="ti ti-calendar-event" style="color: white !important;"></i>
                                Đặt Sân
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/tra-cuu') }}" style="color: white !important;">
                                <i class="ti ti-history" style="color: white !important;"></i>
                                Lịch Sử
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.member.settings') }}"
                                class="{{ request()->routeIs('public.member.settings') ? 'active' : '' }}"
                                style="color: white !important;">
                                <i class="ti ti-settings" style="color: white !important;"></i>
                                Cài Đặt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="ps-main__wrapper" id="vendor-dashboard">
        <div id="app">
            @yield('content')
        </div>
    </div>
</main>