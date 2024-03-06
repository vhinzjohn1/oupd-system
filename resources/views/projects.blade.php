@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Projects') }}</h1>

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

                            <table class="table col-12" id="projectTable">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#addProjectModal">
                                        Add Projects
                                    </button>
                                </div>
                                <thead>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>Project Owner</th>
                                        <th>Project Location</th>
                                        <th>Actions</th>
                                        <!-- Add other table headers here -->
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
    @include('modals.add_projects_modal')
    <!-- /.content -->


    <script>
        $(document).ready(function() {


            // Initialize DataTable
            $("#projectTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,

            }).buttons().container().appendTo('#projectTable_wrapper .col-12');

            // Call the function to fetch and populate data in the table
            refreshMaterialsTable();
        });

        function refreshMaterialsTable() {
            $.ajax({
                url: "{{ route('project.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#projectTable').DataTable();
                    var existingRows = table.rows().remove().draw(false);
                    console.log(data);

                    data.forEach(function(project, index) {
                        // Assuming prices is always an array, even if empty
                        var newRow = table.row.add([
                            // material.material_id,
                            project.project_title,
                            project.project_owner,
                            project.project_location,
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editProjectButton" class="btn btn-primary mr-2" data-id="${project.project_id}" onclick="openEditProjectModal(${project.project_id})" > View </button>` +
                            `<button type="button" id="editProjectButton" class="btn btn-success mr-2" data-id="${project.project_id}" onclick="openEditProjectModal(${project.project_id})" > Select </button>` +
                            // ... (add your delete button logic here) +
                            '</div>'
                        ]).node();

                    });

                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            // Handle Adding of Projects
            $('#addProjectForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let title = $('#add_project_title').val();
                let location = $('#add_project_location').val();
                let owner = $('#add_project_owner').val();
                let office = $('#add_unit_office').val();
                let description = $('#add_project_description').val();
                let contractDuration = $('#add_project_contract_duration').val();
                let datePrepared = $('#add_project_date_prepared').val();
                let targetStartDate = $('#add_project_target_start_date').val();
                let appropriation = $('#add_project_appropriation').val();
                let sourceOfFund = $('#add_project_source_of_fund').val();
                let modeOfImplementation = $('#add_project_mode_of_implementation').val();

                // Log the variables
                // console.log('Title:', title);
                // console.log('Location:', location);
                // console.log('Owner:', owner);
                // console.log('Office:', office);
                // console.log('Description:', description);
                // console.log('Contract Duration:', contractDuration);
                // console.log('Date Prepared:', datePrepared);
                // console.log('Target Start Date:', targetStartDate);
                // console.log('Appropriation:', appropriation);
                // console.log('Source of Fund:', sourceOfFund);
                // console.log('Mode of Implementation:', modeOfImplementation);




                // Make AJAX request to add new material
                $.ajax({
                    url: "{{ route('project.store') }}",
                    type: "POST",
                    data: {
                        project_title: title,
                        project_location: location,
                        project_owner: owner,
                        unit_office: office,
                        project_description: description,
                        project_contract_duration: contractDuration,
                        project_date_prepared: datePrepared,
                        project_target_start_date: targetStartDate,
                        project_appropriation: appropriation,
                        project_source_of_fund: sourceOfFund,
                        project_mode_of_implementation: modeOfImplementation,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Project Added Successfully!');
                        console.log(response); // Log response for debugging

                        if (response) {
                            $('#addProjectForm')[0].reset();
                            // $('#addProjectModal').modal('hide');

                            // //setting callback function for 'hidden.bs.modal' event
                            // $('#addProjectModal').on('hidden.bs.modal', function() {
                            //     //remove the backdrop
                            //     $('.modal-backdrop').remove();
                            // })

                            console.log('successfully added');

                            refreshMaterialsTable();

                        } else {
                            // Show error message if material addition fails
                            alert('Failed to add project: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });
        });
    </script>
@endsection
