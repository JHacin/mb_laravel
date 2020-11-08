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
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar is-secondary" role="navigation" aria-label="glavni meni">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ route('home') }}">
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
                    <a class="navbar-item">O projektu</a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">Muce</a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ route('cat_list') }}">Seznam</a>
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

        <footer class="footer has-text-centered">
            Zavod Mačja hiša © {{ date('Y') }} Mačji boter |
            Vse pravice pridržane |
            Zasebnost |
            Oblikovanje: Lana, izvedba: Jan Hacin
        </footer>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
        @stack('footer-scripts')
    </body>
</html>
