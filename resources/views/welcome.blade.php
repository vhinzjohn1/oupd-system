<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OUPD System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/tom-select/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customStyle.css') }}">

</head>

<body class="antialiased bg-dark">

    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h3 class="text-light">OUPD SYSTEM</h3>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endauth
                </div>
            @endif
        </div>
    </div>


</body>

</html>
