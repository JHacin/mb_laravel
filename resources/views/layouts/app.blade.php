@php
    $isHomepage = Route::currentRouteName() === 'home'
@endphp

<!DOCTYPE html>
<html
    lang="sl"
    @if($isHomepage)class="is-homepage"@endif
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('meta_title', 'Mačji boter')</title>

        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
        <link href="{{ mix('css/app-new.css') }}" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @stack('body-start-scripts')

        @if($isHomepage)
            @include('components.layout.home-header')
        @endif

        @include('components.layout.navbar')

        <main>
            @yield('content')
        </main>

        <footer>
            <div
              class="tw-bg-secondary tw-text-white tw-p-4 tw-flex tw-flex-col md:tw-flex-row tw-items-center tw-justify-center"
            >
                <div class="tw-mb-5 md:tw-mb-0 tw-mx-5">
                    <a
                      class="tw-text-white hover:tw-text-gray-200 tw-inline-block tw-border tw-border-white tw-py-3 tw-px-5 tw-font-semibold tw-text-xl"
                      href="{{ route('faq') }}"
                      dusk="footer-faq-link"
                    >
                        Pogosta vprašanja
                    </a>
                </div>

                <div class="tw-flex tw-items-center tw-mx-5">
                    <a
                      class="tw-h-[55px] tw-px-4"
                      href="{{ config('links.macja_hisa') }}"
                      dusk="footer-mh-link"
                    >
                        <img
                          class="tw-max-h-full"
                          src="{{ mix('img/mh_logo.png') }}"
                          alt="Mačja hiša"
                        >
                    </a>
                    <a
                      class="tw-h-[55px] tw-px-4"
                      href="{{ config('links.veterina_mh') }}"
                      dusk="footer-vet-link"
                    >
                        <img
                          class="tw-max-h-full"
                          src="{{ mix('img/vet_logo.png') }}"
                          alt="Veterina MH"
                        >
                    </a>
                    <a
                      class="tw-h-[55px] tw-px-4"
                      href="{{ config('links.super_combe') }}"
                      dusk="footer-combe-link"
                    >
                        <img
                          class="tw-max-h-full"
                          src="{{ mix('img/combe_logo.png') }}"
                          alt="Super Čombe"
                        >
                    </a>
                </div>
            </div>

            <div class="tw-bg-primary tw-text-white tw-text-sm tw-text-center tw-p-4">
                <span class="tw-block md:tw-inline-block">Zavod Mačja hiša © {{ date('Y') }} Mačji boter</span>
                <span class="tw-hidden md:tw-inline-block tw-px-2">|</span>
                <span class="tw-block md:tw-inline-block">Vse pravice pridržane.</span>
                <span class="tw-hidden md:tw-inline-block tw-px-2">|</span>
                <span class="tw-block md:tw-inline-block">
                    <a
                      class="tw-text-white hover:tw-text-gray-200 tw-font-semibold"
                      href="{{ route('privacy') }}"
                      dusk="footer-privacy-link"
                    >Zasebnost</a>
                </span>
                <span class="tw-hidden md:tw-inline-block tw-px-2">|</span>
                <span class="tw-block md:tw-inline-block">Oblikovanje: <em>Lana</em>, izvedba: <em>Jan Hacin</em></span>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
        @stack('footer-scripts')
    </body>
</html>
