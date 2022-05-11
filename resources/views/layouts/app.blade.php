<!DOCTYPE html>
<html lang="sl">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <!-- CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>@yield('meta_title', 'Mačji boter')</title>

    <script
        src="https://kit.fontawesome.com/671182e2cd.js"
        crossorigin="anonymous"
    ></script>

    <!-- Styles -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
    >
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap"
        rel="stylesheet"
    >
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >
    <link
        href="{{ mix('css/app.css') }}"
        rel="stylesheet"
    >
</head>

<body>
    @stack('body-start-scripts')

    <x-header></x-header>
    <main>@yield('content')</main>
    <x-footer></x-footer>

    <script src="{{ mix('js/app.js') }}"></script>

    @stack('footer-scripts')
</body>

</html>
