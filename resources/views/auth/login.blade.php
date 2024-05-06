@extends('layouts.guest')

@section('content')
    <title>
        Login
    </title>

    <div>
        <p class="login-box-msg">{{ __('Login to your Account') }}</p>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="{{ __('Email') }}" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="error invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="{{ __('Password') }}" required id="passwordID">
                <div class="input-group-append" id="eyeIcon">
                    <div class="input-group-text">
                        <span class="fas fa-eye"></span>
                    </div>
                </div>
                @error('password')
                    <span class="error invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-success btn-block">{{ __('Login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        @if (Route::has('password.request'))
            <p class="mb-1">
                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            </p>
        @endif
    </div>

    <script>
        $('#eyeIcon').click(function() {
            // On click, this function toggles the visibility of the password field and the eye icon
            var passwordField = $('#passwordID');
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                $(this).find('span').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).find('span').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
    <!-- /.login-card-body -->
@endsection
