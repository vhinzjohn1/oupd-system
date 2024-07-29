@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>
    

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
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="projectsCount"> {{ $counts['projects'] }} </h3>
                            <p>Projects</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-th"></i>
                        </div>
                        <a href="{{ route('projects') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="materialsCount"> {{ $counts['materials'] }} </h3>
                            <p>List of Materials</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-tools"></i>
                        </div>
                        <a href="{{ route('list_of_materials') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 id="laborsCount"> {{ $counts['labors'] }} </h3>
                            <p>Labor Rates</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-hard-hat"></i>
                        </div>
                        <a href="{{ route('list_of_labors') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3 id="equipmentsCount"> {{ $counts['equipments'] }} </h3>
                            <p>List of Equipment Rates</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-snowplow"></i>
                        </div>
                        <a href="{{ route('list_of_equipments') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>

    </div>

    <script>
        var counts = @json($counts);

        console.log(counts);
    </script>



    <!-- /.content -->
@endsection
