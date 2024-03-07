@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Project Particulars') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table col-12" id="projectParticularTable">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        id="addProjectParticularButton">
                                        Add Particular
                                    </button>
                                </div>
                                @include('modals.project_particular.add_project_particular_modal')


                                <thead>
                                    <tr>
                                        <th>Particular Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $("#projectParticularTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,

            }).buttons().container().appendTo('#projectParticularTable_wrapper .col-12');

            // Call the function to fetch and populate data in the table
            // refreshParticularTable();

            // Trigger to open Particular Modal Manually
            document.getElementById('addProjectParticularButton').addEventListener('click', function() {
                console.log('button clicked')
                $('#addProjectParticularModal').modal('show');
            });


        });
    </script>
@endsection
