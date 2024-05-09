@extends('layouts.app')
@section('content')

    <head>

    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="">{{ __('Projects') }}</h1>
                    <div>
                        <input type="hidden" id="projectSelectedID">
                        <h1 id="projectSelectedTitle"></h1>
                    </div>
                    <button class="btn btn-success">New Project</button>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid col-12">
            <table class="table table-bordered" id='testTable'></table>

        </div>

    </div>

    <script>
        $('#testTable').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            columns: [{
                    title: "Material Name"
                },
                {
                    title: "Category Name"
                },
                {
                    title: "Unit"
                },
                {
                    title: "Price",
                    className: "text-right"
                },
                {
                    title: "Quarter"
                },
                {
                    title: "Year"
                },
                {
                    title: "Actions",
                    className: "text-center"
                }
            ]
        });
    </script>


    <!-- /.content -->
@endsection
