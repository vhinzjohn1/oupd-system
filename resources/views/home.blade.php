@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>

        <script src="{{ asset('js/ag-grid.js') }}"></script>

    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Card -->
            <div class="card">
                <!-- Card Header (Clickable) -->
                <div class="card-header" data-toggle="collapse" data-target="#collapseExample">
                    Click to Collapse
                </div>
                <!-- Card Body (Collapsed by default) -->
                <div id="collapseExample" class="collapse">
                    <div class="card-body">
                        This is the content of the collapsible card body. You can put any content here.
                    </div>
                </div>
            </div>
        </div> <!-- ./ Project Card  --->
        <!-- Your Blade view with JavaScript -->
    </div>


    <!-- /.content -->
@endsection
