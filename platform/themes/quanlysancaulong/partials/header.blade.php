<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    <script>
        tailwind = {
            config: {
                corePlugins: { preflight: false }, theme: {
                    extend: {
                        colors: {
                            background: '#ffffff',
                            foreground: '#0f172a',
                            muted: '#f1f5f9',
                            'muted-foreground': '#64748b',
                            border: '#e2e8f0',
                            primary: '#059669',
                            'primary-dark': '#047857',
                            secondary: '#10b981',
                            accent: '#14b8a6',
                        }
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    {!! Theme::header() !!}

    <style>
        :root {
            --primary-font: 'Inter', sans-serif !important;
            --primary-color: #059669;
            --primary-dark: #047857;
            --primary-light: #10b981;
            --bg-light: #f0fdfa;
        }

        * {
            font-family: 'Inter', sans-serif !important;
        }

        body {
            font-family: 'Inter', sans-serif !important;
        }

        /* ===== MODERN HEADER STYLES ===== */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .site-header.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            background: rgba(255, 255, 255, 0.98);
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            gap: 32px;
        }

        /* Logo */
        .logo-wrapper .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .logo-wrapper .navbar-brand:hover {
            transform: scale(1.02);
        }

        .logo-wrapper img {
            height: 45px;
            width: auto;
        }

        /* Navigation */
        .nav-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-nav .nav-item {
            position: relative;
        }

        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            color: #1f2937 !important;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
            position: relative;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #059669;
            border-radius: 2px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover {
            color: #059669 !important;
            background: #f0fdfa;
        }

        .navbar-nav .nav-link:hover::after {
            width: calc(100% - 32px);
        }

        .navbar-nav .nav-item.active .nav-link {
            color: #059669 !important;
            background: #ecfdf5;
        }

        .navbar-nav .nav-item.active .nav-link::after {
            width: calc(100% - 32px);
        }

        /* Dropdown */
        .dropdown-menu {
            min-width: 200px;
            padding: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            animation: fadeInDown 0.2s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .dropdown-item:hover {
            background: #f0fdfa;
            color: #059669;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Phone Button */
        .header-phone-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #059669;
            color: white !important;
            padding: 10px 18px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);
        }

        .header-phone-btn:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
        }

        .header-phone-btn:active {
            transform: translateY(0);
        }

        .header-phone-btn i {
            font-size: 18px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Action Icon Buttons */
        .header-action-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            color: #374151 !important;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .header-action-icon:hover {
            background: #f0fdfa;
            border-color: #a7f3d0;
            color: #059669 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
        }

        .header-action-icon i {
            font-size: 20px;
        }

        /* Register Button */
        .header-register-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #059669;
            color: white !important;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.25);
        }

        .header-register-btn:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
        }

        /* User Menu Dropdown */
        .user-menu-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px 6px 12px;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .user-menu-trigger:hover {
            background: #f0fdfa;
            border-color: #a7f3d0;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #374151;
            max-width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* User Dropdown */
        .user-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 260px;
            padding: 8px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            background: white;
            z-index: 1050;
            margin-top: 8px;
        }

        .user-dropdown.show {
            display: block;
            animation: fadeInDown 0.2s ease;
        }

        .user-dropdown-header {
            background: #f0fdfa;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 8px;
        }

        .user-dropdown-name {
            font-weight: 700;
            color: #059669;
            font-size: 15px;
        }

        .user-dropdown-email {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 500;
            color: #374151 !important;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.15s ease;
        }

        .user-dropdown-item:hover {
            background: #f0fdfa;
            color: #059669 !important;
        }

        .user-dropdown-item.logout {
            color: #dc2626 !important;
        }

        .user-dropdown-item.logout:hover {
            background: #fef2f2;
            color: #dc2626 !important;
        }

        .user-dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 6px 0;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .header-wrapper {
                flex-wrap: wrap;
            }

            .nav-wrapper {
                order: 3;
                width: 100%;
                justify-content: flex-start;
            }

            .navbar-collapse {
                display: none !important;
            }

            .navbar-collapse.show {
                display: block !important;
                width: 100%;
                padding-top: 16px;
            }

            .navbar-nav {
                flex-direction: column;
                align-items: stretch;
                gap: 4px;
            }

            .navbar-nav .nav-link::after {
                display: none;
            }
        }

        /* Desktop - Always show navbar */
        @media (min-width: 992px) {

            .navbar-collapse,
            .collapse.navbar-collapse,
            #navbarNav {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .navbar-toggler {
                display: none !important;
            }

            .navbar-nav {
                display: flex !important;
                flex-direction: row !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .nav-link {
                display: flex !important;
                visibility: visible !important;
            }
        }
    </style>
</head>

<body {!! Theme::bodyAttributes() !!}>
    {!! apply_filters(THEME_FRONT_BODY, null) !!}

    <header class="site-header">
        <div class="container">
            <div class="header-wrapper">
                <!-- Logo -->
                <div class="logo-wrapper">
                    <a class="navbar-brand" href="{{ BaseHelper::getHomepageUrl() }}">
                        @if($logo = Theme::getLogo())
                            {{ Theme::getLogoImage(maxHeight: 45) }}
                        @else
                            <span style="font-weight: 800; font-size: 20px; color: #059669;">
                                {{ theme_option('site_title', 'BadmintonPro') }}
                            </span>
                        @endif
                    </a>
                </div>

                @php
                    $mainMenu = \Botble\Menu\Models\Menu::where('slug', 'main-menu')
                        ->with(['menuNodes', 'menuNodes.child'])
                        ->first();
                    $specialItems = [];
                    $normalItems = [];

                    if ($mainMenu) {
                        foreach ($mainMenu->menuNodes->sortBy('position') as $item) {
                            $label = \Illuminate\Support\Str::ascii(mb_strtolower(trim($item->title ?: $item->name ?: '')));
                            if (in_array($label, ['phone', 'tra cuu'], true)) {
                                $specialItems[] = $item;
                            } else {
                                $normalItems[] = $item;
                            }
                        }
                    }
                @endphp

                <!-- Navigation -->
                <nav class="nav-wrapper navbar navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">

                        <!-- Main Menu Items -->
                        <ul class="navbar-nav">
                            @foreach($normalItems as $item)
                                @php
                                    $hasChildren = $item->has_child;
                                    $active = $item->url && (url($item->url) == url()->current() || (url()->current() == url('/') && $item->url == '/'));
                                    $activeClass = $active ? 'active' : '';
                                    $hasChildrenClass = $hasChildren ? 'dropdown' : '';
                                    $linkClass = $hasChildren ? 'dropdown-toggle' : '';
                                    $linkAttributes = $hasChildren ? 'role="button" data-bs-toggle="dropdown" aria-expanded="false"' : '';
                                @endphp
                                <li class="nav-item {{ $activeClass }} {{ $hasChildrenClass }} {{ $item->css_class }}">
                                    <a class="nav-link {{ $linkClass }}" href="{{ $item->url }}"
                                        target="{{ $item->target }}" {!! $linkAttributes !!}>
                                        @if($item->icon_font)
                                            <i class="{{ trim($item->icon_font) }}"></i>
                                        @endif
                                        {{ $item->title ?: ($item->name ?? '') }}
                                    </a>
                                    @if($hasChildren)
                                        <ul class="dropdown-menu">
                                            @foreach($item->child as $child)
                                                <li>
                                                    <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                                        @if($child->icon_font)
                                                            <i class="{{ trim($child->icon_font) }}"></i>
                                                        @endif
                                                        {{ $child->title ?: ($child->name ?? '') }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>

                <!-- Header Actions -->
                <div class="header-actions">
                    @foreach($specialItems as $item)
                        @php
                            $label = \Illuminate\Support\Str::ascii(mb_strtolower(trim($item->title ?: $item->name ?: '')));
                            $isPhone = $label === 'phone';
                            $isTraCuu = $label === 'tra cuu';
                        @endphp

                        @if($isPhone)
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="header-phone-btn">
                                <i class="ti ti-phone"></i>
                                <span>{{ theme_option('phone', '0886 264 644') }}</span>
                            </a>
                        @elseif($isTraCuu)
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="header-action-icon" title="Tra cứu">
                                <i class="ti ti-search"></i>
                            </a>
                        @endif
                    @endforeach

                    <!-- Auth Links -->
                    @auth('member')
                        <!-- Logged In: User Menu -->
                        <div class="dropdown">
                            <a href="#" class="user-menu-trigger dropdown-toggle" id="userMenuDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(auth('member')->user()->name, 0, 1)) }}
                                </div>
                                <span
                                    class="user-name d-none d-md-block">{{ auth('member')->user()->first_name ?: auth('member')->user()->name }}</span>
                                <i class="ti ti-chevron-down" style="font-size: 14px; color: #6b7280;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dropdown" aria-labelledby="userMenuDropdown">
                                <li class="user-dropdown-header">
                                    <div class="user-dropdown-name">{{ auth('member')->user()->name }}</div>
                                    <div class="user-dropdown-email">{{ auth('member')->user()->email }}</div>
                                </li>
                                <li>
                                    <a class="user-dropdown-item" href="{{ route('public.member.dashboard') }}">
                                        <i class="ti ti-layout-dashboard"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <div class="user-dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="user-dropdown-item" href="{{ route('public.booking') }}">
                                        <i class="ti ti-calendar-plus"></i>
                                        Đặt sân ngay
                                    </a>
                                </li>
                                <li>
                                    <a class="user-dropdown-item" href="{{ route('public.member.dashboard') }}#bookings">
                                        <i class="ti ti-history"></i>
                                        Lịch sử đặt sân
                                    </a>
                                </li>
                                <li>
                                    <a class="user-dropdown-item" href="{{ url('/goi-thanh-vien') }}">
                                        <i class="ti ti-award"></i>
                                        Gói thành viên
                                    </a>
                                </li>
                                <li>
                                    <a class="user-dropdown-item" href="{{ url('/tra-cuu') }}">
                                        <i class="ti ti-search"></i>
                                        Tra cứu booking
                                    </a>
                                </li>
                                <li>
                                    <div class="user-dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="user-dropdown-item" href="{{ route('public.member.settings') }}">
                                        <i class="ti ti-settings"></i>
                                        Cài đặt tài khoản
                                    </a>
                                </li>
                                <li>
                                    <div class="user-dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="user-dropdown-item logout" href="{{ route('public.member.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ti ti-logout"></i>
                                        Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('public.member.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Not Logged In -->
                        @if(!request()->routeIs('public.member.login'))
                            <a href="{{ route('public.member.login') }}" class="header-action-icon" title="Đăng nhập">
                                <i class="ti ti-login"></i>
                            </a>
                        @endif
                        @if(!request()->routeIs('public.member.register'))
                            <a href="{{ route('public.member.register') }}" class="header-register-btn">
                                <i class="ti ti-user-plus"></i>
                                Đăng ký
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <script>
        // Sticky header effect on scroll
        window.addEventListener('scroll', function () {
            const header = document.querySelector('.site-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // User dropdown toggle (fallback if Bootstrap JS not working)
        document.addEventListener('DOMContentLoaded', function () {
            const userMenuTrigger = document.getElementById('userMenuDropdown');
            const userDropdown = document.querySelector('.user-dropdown');

            if (userMenuTrigger && userDropdown) {
                userMenuTrigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    userDropdown.classList.toggle('show');
                    userMenuTrigger.setAttribute('aria-expanded', userDropdown.classList.contains('show'));
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function (e) {
                    if (!userMenuTrigger.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.remove('show');
                        userMenuTrigger.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>