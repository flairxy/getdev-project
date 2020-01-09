<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>D'academu | Management</title>

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('css/academy.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzonejs/dist/dropzone.css') }}">
    @yield('css_after')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>
</head>

<body>

    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">


        <nav id="sidebar">
            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="content-header content-header-fullrow px-15">
                    <!-- Mini Mode -->
                    <div class="content-header-section sidebar-mini-visible-b">
                        <!-- Logo -->
                        <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                            <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                        </span>
                        <!-- END Logo -->
                    </div>
                    <!-- END Mini Mode -->

                    <!-- Normal Mode -->
                    <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                            data-toggle="layout" data-action="sidebar_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <!-- END Close Sidebar -->

                        <!-- Logo -->
                        <div class="content-header-item">
                            <a class="link-effect font-w700" href="/">
                                <i class="si si-book-open"></i>
                                <span class="font-size-xl text-primary-dark">D'</span><span
                                    class="font-size-xl">academi</span>
                            </a>
                        </div>
                        <!-- END Logo -->
                    </div>
                    <!-- END Normal Mode -->
                </div>
                <!-- END Side Header -->

                <!-- Side User -->
                <div class="content-side content-side-full content-side-user px-10 align-parent">
                    <!-- Visible only in mini mode -->
                    <div class="sidebar-mini-visible-b align-v animated fadeIn">
                        <img class="img-avatar img-avatar32" src="{{ asset('images/avatar9.jpg') }}" alt="">
                    </div>
                    <!-- END Visible only in mini mode -->

                    <!-- Visible only in normal mode -->
                    <div class="sidebar-mini-hidden-b text-center">
                        <a class="img-link" href="javascript:void(0)">
                            {{-- @if($tutor->image)
                            <img class="img-avatar" src="{{ asset('images/avatars') }}/{{ $tutor->image }}" alt="">
                            @else --}}
                            <img class="img-avatar" src="{{ asset('images/avatar9.jpg') }}" alt="">
                            {{-- @endif --}}
                        </a>
                        <ul class="list-inline mt-10">
                            <li class="list-inline-item">
                                <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase"
                                    href="javascript:void(0)">{{ Auth::user()->username }}</a>
                            </li>

                        </ul>
                    </div>
                    <!-- END Visible only in normal mode -->
                </div>
                <!-- END Side User -->

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li>
                            <a class="{{ request()->is('dashboard') ? ' active' : '' }}" href="/_dmgt/dashboard">
                                <i class="si si-cup"></i><span class="sidebar-mini-hide">Dashboard</span>
                            </a>
                        </li>


                        <li class="{{ request()->is('messages/*') ? ' open' : '' }}">
                            <a href="/_dmgt/notifications/sent"><i class="si si-envelope"></i>
                                <span class="sidebar-mini-hide">Notifications</span>

                            </a>

                        </li>

                        <li class="{{ request()->is('earnings/*') ? ' open' : '' }}">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                    class="si si-credit-card"></i><span class="sidebar-mini-hide">Earnings</span></a>
                            <ul>
                                <router-link to="" tag="li">
                                    <a class="{{ request()->is('earnings/invoices') ? ' active' : '' }}"
                                        href="/_dmgt/earnings/summary">Summary</a>
                                </router-link>
                                <router-link to="" tag="li">
                                    <a class="{{ request()->is('earnings/withdrawals') ? ' active' : '' }}"
                                        href="/_dmgt/earnings/withdrawals">Withdrawals</a>
                                </router-link>
                            </ul>
                        </li>

                        <li class="{{ request()->is('earnings/*') ? ' open' : '' }}">
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-users"></i><span
                                    class="sidebar-mini-hide">Users</span></a>
                            <ul>
                                <router-link to="" tag="li">
                                    <a href="/_dmgt/users/tutors">Tutors</a>
                                </router-link>
                                <router-link to="" tag="li">
                                    <a href="/_dmgt/users/students">Students</a>
                                </router-link>
                            </ul>
                        </li>

                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                    class="si si-book-open"></i><span class="sidebar-mini-hide">Courses</span></a>
                            <ul>
                                <router-link to="" tag="li">
                                    <a href="/_dmgt/courses/approved">Approved</a>
                                </router-link>
                                <router-link to="" tag="li">
                                    <a href="/_dmgt/courses/pending">Pending</a>
                                </router-link>
                            </ul>
                        </li>

                        <li>
                            <a class="nav-menu" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">
                                <i class="si si-logout"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </div>
            <!-- Sidebar Content -->
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="content-header-section">
                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-navicon"></i>
                    </button>
                    <!-- END Toggle Sidebar -->

                </div>
                <!-- END Left Section -->


            </div>
            <!-- END Header Content -->

        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->

        <!-- Footer -->
        <footer id="page-footer" class="opacity-0">
            <div class="content py-20 font-size-xs clearfix">

                <div class="float-left">
                    <a class="font-w600" href="#" target="_blank">Bitfxt Lab</a> &copy; <span
                        class="js-year-copy">2019</span>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!-- Codebase Core JS -->
    <script src="{{ asset('js/academy.app.js') }}"></script>
    <script src="{{ asset('js/codebase.core.min.js') }}"></script>
    <script src="{{ asset('js/vue-app.js') }}"></script>
    <script src="{{ asset('js/laravel.app.js') }}"></script>
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dropzonejs/dropzone.min.js') }}"></script>

    @yield('js_after')
</body>

</html>
