@extends('layouts.auths')

@section('content')

<div class="ac-bg-auth-image" style="background-image: url('{{ asset('svg/auth_user.svg') }}')">
    <div class="row mx-0 justify-content-center">
        <div class="hero-static col-lg-6 col-xl-4">
            <div class="content content-full overflow-hidden">
                <!-- Header -->
                <div class="py-30 text-center">
                    <a class="link-effect font-w700" href="/">
                        <i class="si si-book-open"></i>
                        <span class="font-size-xl text-primary-dark">Get</span><span class="font-size-xl">Dev</span>
                    </a>
                    <h1 class="h4 font-w700 mt-30 mb-10">Welcome to Your Dashboard</h1>
                </div>

                <div class="">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @elseif (session('info'))
                    <div class="alert alert-info">
                        {{ session('status') }}
                    </div>
                    @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                </div>

                <form class="js-validation-signin" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="block block-rounded block-shadow">
                        <div class="block-header ac-card-header-bg">
                            <h3 class="block-title font-w700">Sign In</h3>

                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-username">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-password">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-6 d-sm-flex align-items-center push">
                                    <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="login-remember-me">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-sm-right push">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="si si-login mr-10"></i> Sign In
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="form-group text-center">

                                {{-- <a class="link-effect text-muted mr-10 mb-5 d-inline-block"
                                    href="{{ route('password.request') }}">
                                <i class="fa fa-warning mr-5"></i> Forgot Password
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END Sign In Form -->
            </div>
        </div>
    </div>
</div>

@endsection
