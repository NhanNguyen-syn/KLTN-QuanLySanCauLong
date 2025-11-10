<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {!! Theme::header() !!}

        @php $logoMax = (int) theme_option('logo_max_height', 50); @endphp


        <style>
            :root { --qlscl-underline: linear-gradient(90deg, #ff4d4f, #ff6a3d); --logo-max-height: {{$logoMax}}px; }
            .custom-header.navbar { background-color: #f9efe6; }
            .custom-header .navbar-brand img { max-height: var(--logo-max-height); height: auto; width: auto; object-fit: contain; }
            .custom-header .navbar-nav { align-items: center; }
            .custom-header .navbar-nav .nav-link {
                position: relative;
                padding: .75rem .9rem;
                color: #eb1c3c; /* text-secondary */
                font-weight: 500;
                transition: color .25s ease, text-shadow .25s ease;
            }
            .custom-header .navbar-nav .nav-link::after {
                content: '';
                position: absolute;
                left: 10%;
                right: 10%;
                bottom: .2rem;
                height: 3px;
                background: var(--qlscl-underline);
                border-radius: 2px;
                transform: scaleX(0);
                transform-origin: left center;
                transition: transform .35s ease;
            }
            .custom-header .navbar-nav .nav-link:hover,
            .custom-header .navbar-nav .nav-link:focus,
            .custom-header .navbar-nav .nav-link.active {
                color: #dc3545; /* Bootstrap danger */
                text-shadow: 0 0 0 rgba(0,0,0,0);
            }
            .custom-header .navbar-nav .nav-link:hover::after,
            .custom-header .navbar-nav .nav-link:focus::after,
            .custom-header .navbar-nav .nav-link.active::after {
                transform: scaleX(1);
            }
            /* Account button: no underline */
            .custom-header .navbar-nav .nav-link.account-link::after,
            .custom-header .navbar-nav .nav-link.account-link:hover::after,
            .custom-header .navbar-nav .nav-link.account-link:focus::after,
            .custom-header .navbar-nav .nav-link.account-link.active::after {
                display: none !important;
                transform: none !important;
            }
            @media (max-width: 991.98px) {
                .custom-header .navbar-nav .nav-link { padding: .5rem .75rem; }
                .custom-header .navbar-nav .nav-link::after { left: 0; right: 0; }
            }
            /* Caret icon next to account text */
            .custom-header .dropdown-toggle .dropdown-caret {
                display: inline-block;
                margin-left: 6px;
                border-left: .3em solid transparent;
                border-right: .3em solid transparent;
                border-top: .35em solid currentColor;
                vertical-align: .2em;
                transition: transform .2s ease;
            }
            .custom-header .dropdown-toggle[aria-expanded="true"] .dropdown-caret { transform: rotate(180deg); }
        </style>
            @stack('styles')
    </head>
    <body {!! Theme::bodyAttributes() !!}>

        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <nav class="navbar navbar-expand-lg custom-header border-bottom">
            <div class="container">
                <a class="navbar-brand" href="{{ BaseHelper::getHomepageUrl() }}">
                    @if($logo = Theme::getLogo())
                        {{ Theme::getLogoImage(maxHeight: $logoMax) }}
                    @else
                        {{ theme_option('site_title', 'Your Site') }}
                    @endif
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    {!! Menu::renderMenuLocation('main-menu', [
                        'options' => ['class' => 'navbar-nav mx-auto gap-2 gap-lg-3'],
                        'view' => 'main-menu',
                    ]) !!}

                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle account-link" href="javascript:void(0)" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('Tài khoản') }}
                                <span class="dropdown-caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                @php
                                    $hasMemberRoutes = \Illuminate\Support\Facades\Route::has('public.member.login') || \Illuminate\Support\Facades\Route::has('public.member.dashboard');
                                @endphp

                                @if(!auth('member')->check())
                                    @php
                                        $loginUrl = \Illuminate\Support\Facades\Route::has('public.member.login') ? route('public.member.login') : url('dang-nhap');
                                        $registerUrl = \Illuminate\Support\Facades\Route::has('public.member.register') ? route('public.member.register') : url('dang-ky');
                                    @endphp
                                    <li><a class="dropdown-item" href="{{ $loginUrl }}">{{ __('Đăng nhập') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ $registerUrl }}">{{ __('Đăng ký') }}</a></li>

                                    @unless($hasMemberRoutes)
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <span class="dropdown-item-text text-muted small">{{ __('Gợi ý: Tạo 2 trang có slug /dang-nhap và /dang-ky hoặc bật plugin Member để dùng trang mặc định.') }}</span>
                                        </li>
                                    @endunless
                                @else


                                    @if(\Illuminate\Support\Facades\Route::has('public.member.dashboard'))
                                        <li><a class="dropdown-item" href="{{ route('public.member.dashboard') }}">{{ __('Tài khoản của tôi') }}</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Route::has('public.member.logout'))
                                        <li>
                                            <a class="dropdown-item" href="{{ route('public.member.logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                               {{ __('Đăng xuất') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('public.member.logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
