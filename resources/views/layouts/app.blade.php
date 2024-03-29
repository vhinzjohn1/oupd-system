<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customStyle.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">


    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>


    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


    {{-- script for number format --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

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

    {{-- Latest Bootstrap 5.3 CSS --}}
    <link rel="stylesheet" href="{{ asset('plugins/tom-select/bootstrap.min.css') }}">





    <style>
        .mx-auto {
            margin-right: 0 !important;
        }
    </style>

    @yield('styles')
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
                    <a class="nav-link dropdown-toggle" href="#" aria-expanded="false">
                        {{ Auth::user()->first_name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
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
            <a href="/" class="brand-link text-center text-light text-decoration-none">
                <span class="brand-text">OUPD System</span>
            </a>

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

    @vite('resources/js/app.js')
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // Close dropdown when clicking outside of it
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Close dropdown when clicking the dropdown toggle again
            $('.dropdown-toggle').on('click', function(e) {
                var $dropdownMenu = $(this).next('.dropdown-menu');
                var isVisible = $dropdownMenu.hasClass('show');
                if (isVisible) {
                    $dropdownMenu.removeClass('show');
                } else {
                    $('.dropdown-menu').removeClass('show');
                    $dropdownMenu.addClass('show');
                }
            });
            const select = $('#selectedProject');

            // Function to save the selected project to localStorage
            function saveSelectedProjectToLocalStorage(projectId, projectTitle) {
                localStorage.setItem('selectedProjectID', projectId);
                localStorage.setItem('selectedProjectTitle', projectTitle);
            }

            // Check if there is a selected project in localStorage
            const selectedProjectId = localStorage.getItem('selectedProjectID');
            const selectedProjectTitle = localStorage.getItem('selectedProjectTitle');

            // Fetch project data via AJAX and populate Select2 dropdown
            $.ajax({
                url: "{{ route('project.index') }}",
                method: "GET",
                success: function(response) {
                    // console.log(response)
                    // Populate Select2 dropdown with project data
                    $.each(response, function(index, project) {
                        select.append('<option value="' + project.project_id + '">' + project
                            .project_title + '</option>');
                    });

                    // Trigger Select2 initialization after options are added
                    select.select2({
                        theme: 'bootstrap-5',
                        placeholder: 'Select Project', // Optional placeholder text
                        // allowClear: true, // Allow clearing the selection
                    });



                    // If a selected project is found in localStorage, set it as the default value
                    if (selectedProjectId && selectedProjectTitle) {
                        select.val(selectedProjectId).trigger('change'); // Set the selected value
                        saveSelectedProjectToLocalStorage(selectedProjectId, selectedProjectTitle);
                    }

                    // Listen for changes in the select box and update localStorage accordingly
                    select.on('change', function() {
                        const selectedOption = $(this).find('option:selected');
                        const projectId = selectedOption.val();
                        const projectTitle = selectedOption.text();
                        saveSelectedProjectToLocalStorage(projectId, projectTitle);
                        // Log the projectId and projectTitle
                        console.log('Selected Project ID:', projectId);
                        console.log('Selected Project Title:', projectTitle);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            // Initialize Select2
            $('#selectedProject').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Project', // Optional placeholder text
                // allowClear: true, // Allow clearing the selection
            });


        });
    </script>

    @yield('scripts')
</body>

</html>
