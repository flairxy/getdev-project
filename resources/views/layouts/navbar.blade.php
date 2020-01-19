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
                    <a class="ac-link" href="/_student/dashboard">
                        <i class="si si-home"></i>Dashboard
                    </a>
                    @endcan
                    @can('staff')
                    <a class="ac-link" href="/_staff/dashboard">
                        <i class="si si-home"></i>Dashboard
                    </a>
                    @endcan
                    @can('admin')
                    <a class="ac-link" href="/_management/dashboard">
                        <i class="si si-home"></i>Dashboard
                    </a>
                    @endcan
                </li>

                @guest


                @else
                <li>
                    <a class="ac-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    localStorage.clear();
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
