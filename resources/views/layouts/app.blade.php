{{-- Базовий шаблон сторінки: шапка, мобільне меню, підключення стилів і скриптів. --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @yield('meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    @stack('styles')
</head>
<body @yield('body-class')>

    <header class="site-header">
        <div class="container header-container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo_dark_bg.png') }}" alt="Logo">
                </a>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}#news">{{ __('menu.news') }}</a></li>
                    <li><a href="{{ route('home') }}#about">{{ __('menu.about') }}</a></li>
                    <li><a href="{{ route('home') }}#activity">{{ __('menu.activities') }}</a></li>
                    <li><a href="{{ route('home') }}#capabilities">{{ __('menu.capabilities') }}</a></li>
                    <li><a href="{{ route('home') }}#contacts">{{ __('menu.contacts') }}</a></li>
                </ul>
            </nav>

            <div class="header-right">
                <span class="header-divider"></span>
                <div class="lang-switcher">
                    <a href="{{ route('lang.switch', 'ua') }}"
                       class="lang-link {{ app()->getLocale() === 'ua' ? 'active' : '' }}">UA</a>
                    <span class="lang-separator">|</span>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="lang-link {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                </div>
            </div>

            <button class="burger-btn" id="burgerBtn" aria-label="Меню" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <div class="mobile-nav-overlay" id="mobileNav" role="dialog" aria-modal="true">
        <button class="mobile-nav-close" id="mobileNavClose" aria-label="Закрити">✕</button>
        <a href="{{ route('home') }}#news" class="mobile-nav-link">{{ __('menu.news') }}</a>
        <a href="{{ route('home') }}#about" class="mobile-nav-link">{{ __('menu.about') }}</a>
        <a href="{{ route('home') }}#activity" class="mobile-nav-link">{{ __('menu.activities') }}</a>
        <a href="{{ route('home') }}#capabilities" class="mobile-nav-link">{{ __('menu.capabilities') }}</a>
        <a href="{{ route('home') }}#contacts" class="mobile-nav-link">{{ __('menu.contacts') }}</a>
        <div class="mobile-nav-lang">
            <a href="{{ route('lang.switch', 'ua') }}"
               class="mobile-nav-link {{ app()->getLocale() === 'ua' ? 'nav-active' : '' }}">UA</a>
            <a href="{{ route('lang.switch', 'en') }}"
               class="mobile-nav-link {{ app()->getLocale() === 'en' ? 'nav-active' : '' }}">EN</a>
        </div>
    </div>

    @yield('content')

    <script src="{{ asset('js/slider.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
