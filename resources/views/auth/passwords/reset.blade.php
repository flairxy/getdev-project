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
                        <span class="font-size-xl text-primary-dark">D'</span><span class="font-size-xl">academi</span>
                    </a>
                    <h1 class="h4 font-w700 mt-30 mb-10">Reset Password</h1>
                </div>

                <form class="js-validation-reminder text-white px-30" action="{{ route('password.update') }}"
                    method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating mt-20">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                    autofocus>
                                <label for="reminder-credential">{{ __('E-Mail Address') }}</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-material floating">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                <label for="password">{{ __('Password') }}</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-material floating">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn my-btn btn-block btn-rounded btn-noborder text-center">
                            <i class="fa fa-asterisk mr-10"></i> {{ __('Reset Password') }}
                        </button>
                        <div class="mt-30 pb-4">
                            <a class="link-effect cl1 text-muted mr-10 mb-5 d-inline-block" href="{{route('login')}}">
                                <i class="fa fa-user text-muted mr-5"></i> Login
                            </a>
                        </div>
                    </div>
                </form>
                <!-- END Sign In Form -->
            </div>
        </div>
    </div>
</div>

@endsection
