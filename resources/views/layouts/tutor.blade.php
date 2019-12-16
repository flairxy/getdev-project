<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>D'academi | Tutor</title>

    <meta name="description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Fonts and Styles -->
    @yield('css_before')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('css/academy.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick-theme.css') }}">


    @yield('css_after')
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>
</head>

<body>

    <div id="app">
        <div id="page-container"
            class="sidebar-hidden side-scroll page-header-glass page-header-glass main-content-boxed enable-page-overlay page-header-scroll">
            {{-- <img src="{{ asset('svg/home.svg') }}" class="reader" alt=""> --}}
            <!-- Main Container -->
            {{-- @include('layouts.navbar') --}}
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->
            @include('layouts.footer')

        </div>
    </div>
    <script src="{{ asset('js/academy.app.js') }}"></script>
    <script src="{{ asset('js/vue-app.js') }}"></script>
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>


    @yield('js_after')
</body>

</html>
