@extends('layouts.simple')

@section('content')
<!-- Hero -->
<div class="bg-gd-primary overflow-hidden">
    <div class="hero bg-black-op-25">
        <div class="hero-inner">
            <div class="content content-full text-center">
                <h1 class="display-3 font-w700 text-white mb-10 invisible" data-toggle="appear"
                    data-class="animated fadeInDown">GetDev</h1>
                <h2 class="font-w400 text-white-op mb-50 invisible" data-toggle="appear"
                    data-class="animated fadeInDown">Assessment Project</h2>
                @guest

                <a class="btn btn-hero btn-noborder btn-rounded btn-success mr-5 mb-10 invisible" data-toggle="appear"
                    data-class="animated fadeInUp" href="{{route('login')}}">
                    <i class="fa fa-rocket mr-10"></i> Login
                </a>
                @else
                @can('student')
                <a class="btn btn-hero btn-noborder btn-rounded btn-primary mb-10 invisible" data-toggle="appear"
                    data-class="animated fadeInUp" href="/_student/dashboard">
                    <i class="si si-home"></i> Dashboard
                </a>
                @endcan
                @can('staff')
                <a class="btn btn-hero btn-noborder btn-rounded btn-primary mb-10 invisible" data-toggle="appear"
                    data-class="animated fadeInUp" href="/_staff/dashboard">
                    <i class="si si-home"></i> Dashboard
                </a>
                @endcan
                @can('admin')
                <a class="btn btn-hero btn-noborder btn-rounded btn-primary mb-10 invisible" data-toggle="appear"
                    data-class="animated fadeInUp" href="/_management/dashboard">
                    <i class="si si-home"></i> Dashboard
                </a>
                @endcan
                <a class="btn btn-hero btn-noborder btn-rounded btn-danger mb-10 invisible" data-toggle="appear"
                    data-class="animated fadeInUp" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                             localStorage.clear();                                                                               document.getElementById('logout-form').submit();">
                    <i class="si si-logout"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- END Hero -->
@endsection
