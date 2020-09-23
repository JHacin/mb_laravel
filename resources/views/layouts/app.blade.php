<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>
    <body>
        <nav class="navbar is-primary" role="navigation" aria-label="glavni meni">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ route('homepage') }}">
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
                            <a class="navbar-item">Seznam</a>
                        </div>
                    </div>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-secondary">Registracija</a>
                            <a class="button is-light">Prijava</a>
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
    </body>
</html>
