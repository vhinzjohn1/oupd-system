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
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="projectParticularTable" class="table" border="2">
                                <thead>
                                </thead>
                            </table>
                            @include('modals.project_particular.add_project_particular_modal')
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @include('modals.project_particular.edit_project_particular')

    <script>
        $(document).ready(function() {


            refreshProjectParticularTable();
            // Initialize Select2
            $('#add_project_particular_name').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Particular Names', // Optional placeholder text
                // allowClear: true, // Allow clearing the selection
            });


        });



        function openAddParticularModal(project_id, project_title) {

            // Populate the modal values Project Title and Project Id
            $('#projectParticularTitle').text(project_title);
            $('#projectParticularID').val(project_id);

            // Populate the Modal Particular Name
            $.ajax({
                url: "{{ route('particulars.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var selectParticular = $('#add_project_particular_name');
                    selectParticular.empty(); // Clear existing options

                    // Sort data by particular_name alphabetically
                    data.sort((a, b) => (a.particular_name > b.particular_name) ? 1 : -1);

                    // Loop through the sorted array of objects
                    data.forEach(function(particular) {
                        // Extract particular_id and particular_name from each object
                        var particularId = particular.particular_id;
                        var particularName = particular.particular_name;
                        // Create option element and append to selectParticular
                        var option = $('<option>').val(particularId).text(particularName);
                        selectParticular.append(option);
                    });

                    // After populating options, open the modal
                    $('#addProjectParticularModal').modal('show');

                    // Trigger the change event on selectParticular
                    selectParticular.trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });


        }

        function refreshProjectParticularTable() {
            $.ajax({
                url: '{{ route('projectParticulars.index') }}', // Update this with the actual URL of your route
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#projectParticularTable');
                    table.empty();

                    $.each(data, function(key, project) {
                        var projectHeaderRow = $(
                            '<tr class="bg-secondary"><th class="text-center col-12">' +
                            project.project_title +
                            '</th><th><button class="btn btn-success bg-gradient-success" onclick="openAddParticularModal(' +
                            project.project_id + ', \'' + project.project_title +
                            '\')"><i class="fa fa-plus" aria-hidden="true"></i>Add</button></th></tr>'
                        );
                        table.append(projectHeaderRow);

                        $.each(project.project_particulars, function(index, particular) {
                            var projectRow = $('<tr></tr>');

                            projectRow.append('<td><i class="nav-icon fas fa-cogs"></i> ' +
                                particular.particular_name +
                                '</td>');
                            projectRow.append(
                                '<td><button class="btn btn-danger delete-btn" onclick="deleteProjectParticular(' +
                                particular.project_particular_id + ')">Delete</button></td>'
                            );

                            table.append(projectRow);
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors to the console
                }
            });
        }



        // Delete Project Particular Function

        function deleteProjectParticular(project_particular_id) {
            console.log("Deleting project particular with ID:", project_particular_id);
            Swal.fire({
                title: 'Are you sure?',
                text: 'This Project Particular will be deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('project_particular') }}/" + project_particular_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            refreshProjectParticularTable();
                            toastr.options.progressBar = true;
                            toastr.success('Particular Deleted Successfully!');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting particular. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }



        $(document).ready(function() {

            let selectedParticularId; // Declare the variable outside the event handler

            // Listen for change event on select element
            $('#add_project_particular_name').on('change', function() {
                // Retrieve the selected particular_id
                selectedParticularId = $(this).val();
            });

            // Submit the form data asynchronously using AJAX
            $('#addProjectParticularForm').submit(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Get form data
                let projectID = $('#projectParticularID').val();
                let particularID = selectedParticularId; // Acces the variable here

                $.ajax({
                    url: "{{ route('projectParticulars.store') }}",
                    type: "POST",
                    data: {
                        project_id: projectID,
                        particular_id: particularID,
                        // description: description,
                        // remark: remark,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response) {
                            $('#addProjectParticularForm')[0].reset();
                            $('#addProjectParticularModal').modal('hide');
                            toastr.options.progressBar = true;
                            toastr.success('Project Particular Added Successfully!');

                            console.log('successfully added');

                            refreshProjectParticularTable();

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
