<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('meta_title', 'Mačji boter')</title>

        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar is-secondary" role="navigation" aria-label="glavni meni">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ route('home') }}" dusk="navbar-home-link">
                    <img src="{{ asset('/img/logo.png') }}" alt="Mačji boter">
                </a>

                <a
                    role="button"
                    class="navbar-burger burger"
                    aria-label="meni"
                    aria-expanded="false"
                    data-target="navbar"
                >
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbar" class="navbar-menu">
                <div class="navbar-start">
                    <div class="navbar-item has-dropdown is-hoverable" dusk="navbar-become-regular-sponsor-category">
                        <a class="navbar-link">Postani redni boter</a>

                        <div class="navbar-dropdown">
                            <a
                                class="navbar-item"
                                href="{{ route('why_become_sponsor') }}"
                                dusk="navbar-why-become-sponsor-link"
                            >
                                Zakaj postati mačji boter?
                            </a>
                            <a class="navbar-item" href="{{ route('cat_list') }}" dusk="navbar-cat-list-link">
                                Muce, ki iščejo botra
                            </a>
                        </div>
                    </div>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            @auth
                                <a
                                    class="button is-primary"
                                    href="{{ route('user-profile') }}"
                                    dusk="nav-profile-button"
                                >
                                    Profil
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="button is-light" dusk="nav-logout-button">
                                        Odjava
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <a class="button is-primary" href="{{ route('register') }}" dusk="nav-register-button">
                                    Registracija
                                </a>
                                <a class="button is-light" href="{{ route('login') }}" dusk="nav-login-button">
                                    Prijava
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer>
            <div class="footer-links footer">
                <div class="footer-faq-link-wrapper mx-5">
                    <a
                        class="footer-faq-link"
                        href="{{ route('faq') }}"
                        dusk="footer-faq-link"
                    >
                        Pogosta vprašanja
                    </a>
                </div>

                <div class="is-flex is-align-items-center mx-5">
                    <a
                        class="footer-related-link"
                        href="{{ config('links.macja_hisa') }}"
                        dusk="footer-mh-link"
                    >
                        <img
                            class="footer-related-link__image"
                            src="{{ asset('/img/mh_logo.png') }}"
                            alt="Mačja hiša"
                        >
                    </a>
                    <a
                        class="footer-related-link"
                        href="{{ config('links.veterina_mh') }}"
                        dusk="footer-vet-link"
                    >
                        <img
                            class="footer-related-link__image"
                            src="{{ asset('/img/vet_logo.png') }}"
                            alt="Veterina MH"
                        >
                    </a>
                    <a
                        class="footer-related-link"
                        href="{{ config('links.super_combe') }}"
                        dusk="footer-combe-link"
                    >
                        <img
                            class="footer-related-link__image"
                            src="{{ asset('/img/combe_logo.png') }}"
                            alt="Super Čombe"
                        >
                    </a>
                </div>
            </div>
            <div class="footer-copyright footer" dusk="footer-bottom">
                <span class="footer-copyright__item">
                    Zavod Mačja hiša © {{ date('Y') }} Mačji boter
                </span>
                <span class="footer-copyright__divider">|</span>
                <span class="footer-copyright__item">
                    Vse pravice pridržane.
                </span>
                <span class="footer-copyright__divider">|</span>
                <span class="footer-copyright__item">
                    <a
                        class="has-text-white has-text-weight-semibold"
                        href="{{ route('privacy') }}"
                        dusk="footer-privacy-link"
                    >
                        Zasebnost
                    </a>
                </span>
                <span class="footer-copyright__divider">|</span>
                <span class="footer-copyright__item">
                    Oblikovanje: <em>Lana</em>, izvedba: <em>Jan Hacin</em>
                </span>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
        @stack('footer-scripts')
    </body>
</html>
