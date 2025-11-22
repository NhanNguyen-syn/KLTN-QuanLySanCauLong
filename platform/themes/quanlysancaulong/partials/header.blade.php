<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
                            {!! Menu::renderMenuLocation('main-menu', [
                                'options' => ['class' => 'navbar-nav'],
                                'view' => 'main-menu',
                            ]) !!}
                        </div>
                    </nav>
                </div>
            </div>
        </header>
