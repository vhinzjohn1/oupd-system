<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customStyle.css') }}">


    <!------ Floating Button ------>
    <link rel="stylesheet" href="{{ asset('css/mfb.css') }}">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />


    <!-- SweetAlert2 -->
    {{-- <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> --}}


    <!-- SweetAlert2 -->
    {{-- <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>


    <!-- DataTables  & Plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">


    {{-- <script src="{{ asset('js/autonumeric.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/7.6.0/imask.min.js"
        integrity="sha512-nTNcq3y76KV0waC+4blkE81acF83+Q0wmdNlDfpXgzpswh6FbhemEYoIV3TH+tOhadNeviCA+WPD5FEuXeF6mQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Script for sortable js --}}
    <script src="{{ asset('js/sortableJS.min.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>


    {{-- Toastr Alert cdn --}}
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <!-- Select2 Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap-5-theme.min.css') }}">

    <!-- Select2 Scripts -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    {{-- Tom select Plugins --}}
    <link rel="stylesheet" href="{{ asset('plugins/tom-select/tomcss.css') }}">
    <script src="{{ asset('plugins/tom-select/tomjs.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}

    {{-- Latest Bootstrap 5.3 CSS --}}
    <link rel="stylesheet" href="{{ asset('plugins/tom-select/bootstrap.min.css') }}">



    <style>
        .mx-auto {
            margin-right: 0 !important;
        }
    </style>


    @yield('styles')
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-yellow">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            {{-- <div class="mx-auto d-none d-sm-block">
                <input type="hidden" id="setprojectID">
                <h4 id="setprojectTitle"></h4>
            </div> --}}

            {{-- <div class="navbar-nav mx-auto"> <!-- Centered section -->
                <div class="position-relative" style="width: 300px;">
                    <select class="form-control select2" id="selectedProject" name="selectedProject[]" required>
                        <!-- Options will be dynamically populated here -->
                    </select>
                </div>
            </div> --}}

            {{-- <div class="form-group col-3">
                <select class="form-control" id="selectedProject" name="selectedProject[]" multiple required>
                    <!-- Options will be dynamically populated here -->
                </select>
            </div> --}}


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->first_name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="mr-2 fas fa-file"></i>
                            {{ __('My profile') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="mr-2 fas fa-sign-out-alt"></i>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            {{-- <img src="{{ asset('img/oupd-Logo.png') }}" alt="Example Image">
            <a href="dashboard" class="brand-link text-center text-light text-decoration-none">
                <span class="brand-text">OUPD</span>
            </a> --}}



            @include('layouts.navigation')
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        {{-- <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer> --}}
    </div>


    <!-- ./wrapper -->

    {{-- @vite('resources/js/app.js') --}}
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
    @yield('scripts')
    @livewireScripts
</body>

</html>
