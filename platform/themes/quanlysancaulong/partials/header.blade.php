<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

        <script>
            tailwind = { config: { corePlugins: { preflight: false }, theme: { extend: { colors: {
                background: '#ffffff',
                foreground: '#0f172a',
                muted: '#f1f5f9',
                'muted-foreground': '#64748b',
                border: '#e2e8f0',
                primary: '#065f46',
                secondary: '#059669',
                accent: '#14b8a6',
            } } } } };
        </script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>

        {!! Theme::header() !!}

        <style>
            :root {
                --primary-font: 'Baloo 2', sans-serif !important;
            }

            * {
                font-family: 'Baloo 2', sans-serif !important;
            }

            body {
                font-family: 'Baloo 2', sans-serif !important;
            }

            .site-header {
                position: sticky;
                top: 0;
                z-index: 1000;
                background: white;
                transition: all 0.3s ease;
                box-shadow: 0 2px 4px rgba(0,0,0,0);
            }

            .site-header.scrolled {
                box-shadow: 0 2px 12px rgba(0,0,0,0.1);
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
            }

            .site-header .navbar-nav,
            .site-header .navbar-collapse {
                opacity: 1 !important;
                visibility: visible !important;
            }

            .site-header .navbar-nav .nav-link {
                color: #065f46 !important;
            }

            @media (min-width: 992px) {
                .site-header .navbar-collapse {
                    display: flex !important;
                }
            }

            @media (max-width: 991.98px) {
                .site-header .navbar-collapse {
                    display: none;
                }

                .site-header .navbar-collapse.show {
                    display: block;
                }

                .site-header .navbar-nav {
                    flex-direction: column;
                    align-items: flex-start;
                    padding-top: 0.5rem;
                }
            }

            /* Header Actions Styling */
            .header-actions {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-left: 15px;
            }

            .header-phone-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: linear-gradient(90deg, #065f46 0%, #059669 100%);
                color: white !important;
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 14px;
                text-decoration: none;
                white-space: nowrap;
                transition: all 0.2s ease;
                border: none;
                cursor: pointer;
                height: 40px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .header-phone-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
                opacity: 0.95;
            }

            .header-phone-btn i {
                font-size: 16px;
                color: white !important;
                margin-right: 4px;
            }

            .header-action-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: white;
                border: 1px solid #e5e7eb;
                color: #065f46 !important;
                transition: all 0.2s ease;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }

            .header-action-icon:hover {
                background: #f3f4f6;
                color: #059669 !important;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                border-color: #d1d5db;
            }

            .header-action-icon i {
                font-size: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Specific icon adjustments */
            .ti-phone {
                transform: scaleX(-1); /* Flip phone icon */
            }

            .ti-file-search {
                font-size: 22px !important;
            }
        </style>
    </head>
    <body {!! Theme::bodyAttributes() !!}>
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <header class="site-header">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo-wrapper">
                        <a class="navbar-brand" href="{{ BaseHelper::getHomepageUrl() }}">
                            @if($logo = Theme::getLogo())
                                {{ Theme::getLogoImage(maxHeight: 50) }}
                            @else
                                {{ theme_option('site_title', 'Your Site') }}
                            @endif
                        </a>
                    </div>

                    <nav class="nav-wrapper navbar navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
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

                            <!-- Main Menu Items -->
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                                        <a class="nav-link {{ $linkClass }}"
                                           href="{{ $item->url }}"
                                           target="{{ $item->target }}"
                                           {!! $linkAttributes !!}>
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

                            <!-- Special Menu Items (Phone, Tra cứu) -->
                            <div class="d-flex align-items-center gap-3 header-actions">
                                @foreach($specialItems as $item)
                                    @php
                                        $label = \Illuminate\Support\Str::ascii(mb_strtolower(trim($item->title ?: $item->name ?: '')));
                                        $isPhone = $label === 'phone';
                                        $isTraCuu = $label === 'tra cuu';

                                        $linkClass = '';
                                        if ($isPhone) {
                                            $linkClass = 'header-phone-btn';
                                        } elseif ($isTraCuu) {
                                            $linkClass = 'header-action-icon';
                                        }
                                    @endphp

                                    <a href="{{ $item->url }}" target="{{ $item->target }}" class="{{ $linkClass }}">
                                        @if($item->icon_font)
                                            <i class="{{ trim($item->icon_font) }}"></i>
                                        @endif
                                        @if($isPhone)
                                            <span>{{ theme_option('phone', '0886 264 644') }}</span>
                                        @elseif(!$isTraCuu)
                                            {{ $item->title ?: ($item->name ?? '') }}
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
</nav>
                </div>
            </div>
        </header>

        <script>
            // Sticky header effect on scroll
            window.addEventListener('scroll', function() {
                const header = document.querySelector('.site-header');
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        </script>
