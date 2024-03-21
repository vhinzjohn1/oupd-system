<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="backstretch"
        style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 100%; width: 100%; z-index: -999999; position: fixed;">
        <img src="https://isms.cmu.edu.ph/general/getThemePhoto?tid=1&field=login_bg"
            style="position: absolute; margin: 0px; padding: 0px; border: none; width: 110%; height: 100%; max-height: none; max-width: none; z-index: -999999; left: -79.7671px; top: 0px;">
    </div>
    {{-- <span id="PING_IFRAME_FORM_DETECTION" style="display: none;"></span> --}}
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="logo" style="text-align: center;">
            <img src="https://isms.cmu.edu.ph/general/getThemePhoto?tid=1&field=login_banner" class="img-responsive"
                style="display:inline-block; height: 150px; margin-bottom:10px;">
        </div>
        <div class="login-card-body">
            @yield('content')
        </div>
    </div>
    <!-- /.login-box -->

    @vite('resources/js/app.js')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>

</html>
