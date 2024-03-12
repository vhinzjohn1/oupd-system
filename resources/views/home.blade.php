@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectParticularModalLabel">Add Project Particular</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addProjectParticularForm">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <h4 class="text" id="projectParticularTitle">Project Title</h4>
                            <input type="hidden" id="projectParticularID" />
                        </div>

                        <div class="d-flex justify-content-center col-12">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="add_project_particular_name">Particular Name</label>
                                    <select class="form-control" id="add_project_particular_name"
                                        name="add_project_particular_name[]" required>
                                        <!-- Options will be dynamically populated here -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Materials</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="add_project_particular_materials">Material Name</label>
                                            <input type="text" class="form-control" id="add_project_particular_materials"
                                                name="add_project_particular_materials">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Labor</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="add_project_particular_labor">Labor Name</label>
                                            <input type="text" class="form-control" id="add_project_particular_labor"
                                                name="add_project_particular_labor">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Equipment</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="add_project_particular_equipment">Equipment Name</label>
                                            <input type="text" class="form-control" id="add_project_particular_equipment"
                                                name="add_project_particular_equipment">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.content -->

    {{-- <script>
        $(document).ready(function() {
            // Define sample project data locally for testing
            var projectsData = [{
                    project_title: 'COE Constructions',
                    particular_name: ['Embankment of COE Constructions', 'Compaction of COE Constructions',
                        'Compaction of COE Constructions', 'Compaction of COE Constructions',
                        'Compaction of COE Constructions'
                    ]
                },
                {
                    project_title: 'CISC Constructions',
                    particular_name: ['Earthworks of CISC Constructions', 'Ground Works of CISC Constructions',
                        'Compaction of CISC Constructions'
                    ]
                }
            ];

            var table = $('#projectParticularTable');

            for (var i = 0; i < projectsData.length; i++) {
                var projectHeaderRow = $('<tr class="bg-secondary"><th class="text-center col-12">' +
                    projectsData[i].project_title +
                    '</th><th><button class="btn btn-success bg-gradient-success"><i class="fa fa-plus" aria-hidden="true"></i>Add</button></th></tr>'
                );


                var projects = projectsData[i].particular_name;

                table.append(projectHeaderRow);

                for (var j = 0; j < projects.length; j++) {
                    var projectRow = $('<tr></tr>');
                    projectRow.append('<td><i class="nav-icon fas fa-cogs"></i> ' + projects[j] +
                        '</td>');
                    projectRow.append(
                        '<td><button class="btn btn-danger delete-btn">Delete</button></td>');

                    table.append(projectRow);
                }
            }

            // Delete button click event
            $(document).on('click', '.delete-btn', function() {
                $(this).closest('tr').remove();
            });



        });
    </script> --}}
@endsection
