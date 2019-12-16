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
                    <h1 class="h4 font-w700 mt-30 mb-10">Don’t worry, we’ve got your back</h1>
                    <h2 class="h5 font-w400 text-muted mb-0">Please enter your email</h2>
                </div>

                <form class="js-validation-reminder px-30" action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating mt-20">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="reminder-credential" value="{{ $email ?? old('email') }}" required
                                    autocomplete="email" autofocus>
                                <label for="reminder-credential">Email</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-block  btn-noborder">
                            Send Password Reset Link
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
