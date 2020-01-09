<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow bg-black-op-25">
            <div class="content-header-section text-center align-parent">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="">
                        <span>
                            <img style="width: 60%" src="{{asset('gallery/whitelogotextbig.png')}}" alt="logo">
                        </span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
        </div>
        <!-- END Side Header -->

        <!-- Side Main Navigation -->
        <div class="content-side">
            <!--
                        Mobile navigation, desktop navigation can be found in #page-header

                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        -->
            <ul class="nav-main">
                <li>
                    <a href="/">
                        Discover
                    </a>
                </li>
                <li>
                    <a href="#about">
                        About
                    </a>
                </li>
                <li>
                    <a href="#services">
                        Services
                    </a>
                </li>

            </ul>
        </div>
        <!-- END Side Main Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->

<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section py-10">
            <!-- Logo -->
            <div class="content-header-item">
                <a class="font-w700 mr-5" href="/">
                    <span>
                        <img style="width: 190px;" src="{{asset('gallery/logotextwhitesmall.png')}}" alt="logo">
                    </span>
                </a>
            </div>
            <!-- END Logo -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <ul class="nav-main-header nav-main-header-no-icons">
                <li>
                    @can('student')
                    <a class="ac-link" href="/_ds/dashboard">
                        <i class="si si-home"></i>Dashboard
                    </a>
                    @endcan
                    @can('tutor')
                    <a class="ac-link" href="/_dt/dashboard">
                        <i class="si si-home"></i>Dashboard
                    </a>
                    @endcan
                    @can('admin')
                    <a class="ac-link" href="/_dmgt/dashboard">
                        <i class="si si-home"></i>Dashboard
                    </a>
                    @endcan
                </li>

                <li>
                    <a class="ac-link" href="{{ route('tutorSignup') }}">Become a
                        Tutor</a>
                </li>
                @guest

                <li>
                    <a class="ac-link" href="{{ route('login') }}">Login
                    </a>

                </li>
                <li>
                    <a class="ac-link" href="{{ route('register') }}">Register
                    </a>

                </li>
                @else
                <li>
                    <a class="ac-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                                                                     document.getElementById('logout-form').submit();">
                        <i class="si si-logout"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
            <!-- END Header Navigation -->

            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->


    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
