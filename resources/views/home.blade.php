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
            {{-- <div id="example1" class="list-group col">
                <div class="list-group-item" draggable="false" style="">Item 1</div>
                <div class="list-group-item" draggable="false" style="">Item 2</div>
                <div class="list-group-item" style="">Item 3</div>
                <div class="list-group-item" style="">Item 4</div>
                <div class="list-group-item" draggable="false" style="">Item 6</div>
                <div class="list-group-item" style="">Item 5</div>
            </div>
            <div id="example2" class="list-group col">
                <div class="list-group-item" draggable="false" style="">Item 1</div>
                <div class="list-group-item" style="">Item 2</div>
                <div class="list-group-item" style="">Item 3</div>
                <div class="list-group-item" style="">Item 4</div>
                <div class="list-group-item" style="">Item 5</div>
                <div class="list-group-item" style="">Item 6</div>
            </div> --}}
        </div> <!-- ./ Project Card  --->
        <!-- Your Blade view with JavaScript -->
    </div>

    <script>
        new Sortable(example1, {
            animation: 150,
            ghostClass: 'blue-background-class',
            dragClass: 'bg-blue-50',
        });

        new Sortable(example2, {
            group: 'shared', // set both lists to same group
            animation: 150,
        });
    </script>

    <!-- /.content -->
@endsection
