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
                                    foreach ($mainMenu->menuNodes as $item) {
                                        if (in_array($item->title, ['Phone', 'Tra cứu'])) {
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
                                    <li class="nav-item {{ $activeClass }} {{ $hasChildrenClass }}">
                                        <a class="nav-link {{ $linkClass }}"
                                           href="{{ $item->url }}"
                                           target="{{ $item->target }}"
                                           {!! $linkAttributes !!}>
                                            @if($item->icon_font)
                                                <i class="{{ trim($item->icon_font) }}"></i>
                                            @endif
                                            {{ $item->title }}
                                        </a>
                                        @if($hasChildren)
                                            <ul class="dropdown-menu">
                                                @foreach($item->child as $child)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $child->url }}" target="{{ $child->target }}">
                                                            @if($child->icon_font)
                                                                <i class="{{ trim($child->icon_font) }}"></i>
                                                            @endif
                                                            {{ $child->title }}
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
                                        $isPhone = strtolower($item->title) === 'phone';
                                        $isTraCuu = strtolower($item->title) === 'tra cứu';

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
                                            {{ $item->title }}
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
