<!DOCTYPE html>
<html lang="sl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('meta_title', 'Mačji boter')</title>

        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @stack('body-start-scripts')

        @include('components.layout.header')

        <main>
            @yield('content')
        </main>

        <footer>
            <div
              class="bg-secondary text-white p-4 flex flex-col md:flex-row items-center justify-center"
            >
                <div class="mb-5 md:mb-0 mx-5">
                    <a
                      class="text-white hover:text-gray-200 inline-block border border-white py-3 px-5 font-semibold text-xl"
                      href="{{ route('faq') }}"
                      dusk="footer-faq-link"
                    >
                        Pogosta vprašanja
                    </a>
                </div>

                <div class="flex items-center mx-5">
                    <a
                      class="h-[55px] px-4"
                      href="{{ config('links.macja_hisa') }}"
                      dusk="footer-mh-link"
                    >
                        <img
                          class="max-h-full"
                          src="{{ mix('img/mh_logo.png') }}"
                          alt="Mačja hiša"
                        >
                    </a>
                    <a
                      class="h-[55px] px-4"
                      href="{{ config('links.veterina_mh') }}"
                      dusk="footer-vet-link"
                    >
                        <img
                          class="max-h-full"
                          src="{{ mix('img/vet_logo.png') }}"
                          alt="Veterina MH"
                        >
                    </a>
                    <a
                      class="h-[55px] px-4"
                      href="{{ config('links.super_combe') }}"
                      dusk="footer-combe-link"
                    >
                        <img
                          class="max-h-full"
                          src="{{ mix('img/combe_logo.png') }}"
                          alt="Super Čombe"
                        >
                    </a>
                </div>
            </div>

            <div class="bg-primary text-white text-sm text-center p-4">
                <span class="block md:inline-block">Zavod Mačja hiša © {{ date('Y') }} Mačji boter</span>
                <span class="hidden md:inline-block px-2">|</span>
                <span class="block md:inline-block">Vse pravice pridržane.</span>
                <span class="hidden md:inline-block px-2">|</span>
                <span class="block md:inline-block">
                    <a
                      class="text-white hover:text-gray-200 font-semibold"
                      href="{{ route('privacy') }}"
                      dusk="footer-privacy-link"
                    >Zasebnost</a>
                </span>
                <span class="hidden md:inline-block px-2">|</span>
                <span class="block md:inline-block">Oblikovanje: <em>Lana</em>, izvedba: <em>Jan Hacin</em></span>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
        @stack('footer-scripts')
    </body>
</html>
