<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-title" content="Авангард" />
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/alerts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    @stack('styles')
    <title>Авангард — @yield('title', 'Фитнес-клуб')</title>
</head>

<body>

    {{-- ══════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════ --}}
    <nav class="site-nav" id="main-navbar">
        <div class="nav-inner">

            {{-- Logo --}}
            <a class="nav-logo" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Авангард" class="nav-logo-img nav-logo-img--light">
                <img src="{{ asset('images/logo2.png') }}" alt="Авангард" class="nav-logo-img nav-logo-img--dark">
                {{-- <span class="nav-logo-text">Авангард</span> --}}
            </a>

            {{-- Desktop links --}}
            <ul class="nav-links">
                <li><a class="nav-link" href="{{ route('tariffs') }}">Тарифы</a></li>
                <li><a class="nav-link" href="{{ route('promotions') }}">Акции</a></li>
                <li><a class="nav-link" href="{{ route('group-classes') }}">Групповые</a></li>
                <li><a class="nav-link" href="{{ route('trainers') }}">Тренеры</a></li>
                <li><a class="nav-link" href="{{ route('faq') }}">FAQ</a></li>
            </ul>

            {{-- Auth actions --}}
            <div class="nav-actions">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a class="nav-action-link" href="{{ route('admin.dashboard') }}">Админ-панель</a>
                    @endif
                    <a class="nav-action-link" href="{{ route('dashboard') }}">Кабинет</a>
                    <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="nav-btn nav-btn-outline">Выйти</button>
                    </form>
                @else
                    <a class="nav-action-link" href="{{ route('login') }}">Вход</a>
                    <a class="nav-btn nav-btn-solid" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>

            {{-- Burger --}}
            <button class="nav-burger" id="navBurger" aria-label="Меню" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>

        {{-- Mobile drawer --}}
        <div class="nav-drawer" id="navDrawer">
            <ul class="drawer-links">
                <li><a href="{{ route('tariffs') }}">Тарифы</a></li>
                <li><a href="{{ route('promotions') }}">Акции</a></li>
                <li><a href="{{ route('group-classes') }}">Групповые</a></li>
                <li><a href="{{ route('trainers') }}">Тренеры</a></li>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}">Админ-панель</a></li>
                    @endif
                    <li><a href="{{ route('dashboard') }}">Личный кабинет</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="drawer-logout">Выйти</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Вход</a></li>
                    <li><a href="{{ route('register') }}" class="drawer-register">Регистрация</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════
         ALERTS
    ══════════════════════════════════════════ --}}
    @if(session('success') || session('error') || $errors->any())
    <div class="alerts-wrap">
        <div class="alerts-inner">
            @if(session('success'))
                <div class="site-alert site-alert--success">
                    <span>{{ session('success') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Закрыть">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="site-alert site-alert--error">
                    <span>{{ session('error') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Закрыть">✕</button>
                </div>
            @endif
            @if($errors->any())
                <div class="site-alert site-alert--error">
                    <ul class="alert-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Закрыть">✕</button>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════ --}}
    <main class="site-main">
        @yield('content')
    </main>

    {{-- ══════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════ --}}
    <footer class="site-footer">
        <div class="footer-inner">

            <div class="footer-top">
                {{-- Brand --}}
                <div class="footer-brand-col">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ asset('images/logo2.png') }}" alt="Авангард" class="footer-logo-img">
                        <span class="footer-logo-text">Авангард</span>
                    </a>
                    <p class="footer-desc">Фитнес-клуб в Челябинске — 2 200 м² для тренировок, СПА и бассейна.</p>
                    <div class="footer-hours">
                        <span class="footer-hours-dot"></span>
                        Ежедневно 6:00 — 24:00
                    </div>
                    <li class="footer-nav-list"><a href="{{ route('politikakonf') }}">Политика конфиденциальности</a></li>
                </div>

                {{-- Nav --}}
                <div class="footer-nav-col">
                    <div class="footer-col-label">Навигация</div>
                    <ul class="footer-nav-list">
                        <li><a href="{{ route('tariffs') }}">Тарифы</a></li>
                        <li><a href="{{ route('promotions') }}">Акции</a></li>
                        <li><a href="{{ route('group-classes') }}">Групповые занятия</a></li>
                        <li><a href="{{ route('trainers') }}">Тренеры</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </div>

                {{-- Contacts --}}
                <div class="footer-contacts-col">
                    <div class="footer-col-label">Контакты</div>
                    <ul class="footer-contact-list">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2 2h3l1.5 3.5L5 7a9 9 0 0 0 2 2l1.5-1.5L12 9v3c-5.5 0-10-4.5-10-10Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                            </svg>
                            +7 (999) 123-45-67
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <rect x="1" y="3" width="12" height="8" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
                                <path d="M1 4l6 4 6-4" stroke="currentColor" stroke-width="1.2"/>
                            </svg>
                            info@fitclub.ru
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M7 1a4.5 4.5 0 0 1 4.5 4.5C11.5 9 7 13 7 13S2.5 9 2.5 5.5A4.5 4.5 0 0 1 7 1Z" stroke="currentColor" stroke-width="1.2"/>
                                <circle cx="7" cy="5.5" r="1.5" stroke="currentColor" stroke-width="1.2"/>
                            </svg>
                            ул. Труда, 181, ТРЦ «Авангард»
                        </li>
                    </ul>
                    <div class="footer-social">
                        <a href="https://telegram.org" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Telegram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M21.5 3.4 18.2 20c-.2 1.1-.9 1.4-1.9.9l-5.1-3.8-2.5 2.4c-.3.3-.5.5-1 .5l.4-5.2 9.5-8.6c.4-.4-.1-.6-.6-.2L5.2 13.4.1 11.8c-1.1-.3-1.1-1.1.2-1.6L20.1 2.6c.9-.3 1.7.2 1.4.8Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="YouTube">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2C0 8.1 0 12 0 12s0 3.9.5 5.8a3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1c.5-1.9.5-5.8.5-5.8s0-3.9-.5-5.8ZM9.6 15.6V8.4L15.8 12l-6.2 3.6Z" fill="currentColor"/>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Instagram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2Zm0 2A3.8 3.8 0 0 0 4 7.8v8.4A3.8 3.8 0 0 0 7.8 20h8.4a3.8 3.8 0 0 0 3.8-3.8V7.8A3.8 3.8 0 0 0 16.2 4H7.8Zm8.9 2.1a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4ZM12 7.4a4.6 4.6 0 1 1 0 9.2 4.6 4.6 0 0 1 0-9.2Zm0 2a2.6 2.6 0 1 0 0 5.2 2.6 2.6 0 0 0 0-5.2Z" fill="currentColor"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© 2026 Авангард. Все права защищены.</span>
                <span class="footer-bottom-tagline">Челябинск, ТРЦ «Авангард»</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    {{-- Nav burger JS --}}
    <script>
    (function () {
        const burger = document.getElementById('navBurger');
        const drawer = document.getElementById('navDrawer');
        if (!burger || !drawer) return;
        burger.addEventListener('click', function () {
            const open = drawer.classList.toggle('open');
            burger.classList.toggle('open', open);
            burger.setAttribute('aria-expanded', open);
            document.body.style.overflow = open ? 'hidden' : '';
        });
        // Close on link click
        drawer.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('click', () => {
                drawer.classList.remove('open');
                burger.classList.remove('open');
                burger.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
    })();
    </script>

    @stack('scripts')
</body>

</html>


