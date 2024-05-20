@extends('layouts.app')
@section('title', 'Projects')
@section('content')

    <head>

        @if (isset($message))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!: Unable to Proceed to Transactions',
                    html: '<div style="font-size: 24px; color: #00491e;">{{ $message }}</div>'
                });
            </script>
        @endif



    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#" class="link-dark a-href">Pages</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" id="addProjectButton">
                            Add Projects
                        </button>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-12">

            </div>
        </div>
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Projects Table</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped" id="projectTable">
                            <thead>
                                <tr>
                                    <th>Project Title</th>
                                    <th>Project Owner</th>
                                    <th>Project Location</th>
                                    <th>Contract Duration</th>
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
        </div><!-- /.container-fluid -->


        {{-- Container for Project Particular Table --}}
        {{-- <div class="container-fluid">
            <div class="card" style="box-shadow: 0px 0px 10px 1px grey">
                <div class="card-header col-12 d-flex justify-content-between mb-2">
                    <h5>Project Particular Table</h5>
                    <button type="button" class="btn btn-success custom-right" id="addParticularBtn">Add
                        Particular</button>
                </div>
                <div class="col-lg-12 d-flex table-responsive">
                    <table id="projectParticularTable" class="table" border="2">
                        <thead>
                        </thead>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid --> --}}
    </div>
    @include('modals.project.add_projects_modal')
    @include('modals.project.view_project_modal')
    @include('modals.project_particular.add_project_particular_modal')
    <!-- /.content -->


    <script>
        $(document).ready(function() {
            // AJAX request to fetch formatted data from Laravel backend
            $.ajax({
                url: '/formatted-data',
                method: 'GET',
                success: function(response) {
                    // Log the formatted data to the console
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Log any errors to the console
                    console.error("Error:", error);
                }
            });

            $("#projectTable")
                .DataTable({
                    responsive: true,
                    lengthChange: true,
                    autoWidth: true,
                    paging: true,
                    ordering: true,
                    searching: true,
                    // buttons: ["copy", "csv", "excel", "pdf", "print"],
                });

            // Call the function to fetch and populate data in the table
            refreshProjectsTable();

            // Refresh Project Particular Table
            // refreshProjectParticularTable();
            // refreshProjectParticularMLE();

            // Initialize Select2
            $('#add_project_particular_name').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addProjectParticularModal'),
                tags: true,

            });


            $('#addProjectButton').click(function() {
                $('#addProjectModal').modal('show');
            });

            $('#addParticularBtn').click(function() {
                // Populate the Modal
                openAddParticularModal();

                function openAddParticularModal() {
                    // Retrieve project_id and project_title from local storage
                    const projectID = localStorage.getItem('projectID');
                    const projectTitle = localStorage.getItem('projectTitle');

                    // Populate the modal values Project Title and Project Id
                    $('#projectParticularTitle').text(projectTitle);
                    $('#projectParticularID').val(projectID);


                    // Populate the Modal Particular Name
                    $.ajax({
                        url: "{{ route('particulars.index') }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {

                            var selectParticular = $('#add_project_particular_name');
                            selectParticular.empty(); // Clear existing options

                            // Sort data by particular_name alphabetically
                            data.sort((a, b) => (a.particular_name > b.particular_name) ? 1 : -
                                1);

                            // Loop through the sorted array of objects
                            data.forEach(function(particular) {
                                // Extract particular_id and particular_name from each object
                                var particularId = particular.particular_id;
                                var particularName = particular.particular_name;
                                // Create option element and append to selectParticular
                                var option = $('<option>').val(particularId).text(
                                    particularName);
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
            });


            // Format Select Value to only numbers
            const materialQuantityContainer = document.getElementById('add_project_particular_material_quantity')
                .parentNode;

            materialQuantityContainer.addEventListener('keydown', function(event) {
                const key = event.keyCode || event.charCode;
                const input = event.target;

                if (!(
                        key === 8 || key === 46 || // backspace, delete
                        (key >= 37 && key <= 40) || // arrow keys
                        (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || // numbers
                        key === 9 // tab
                    ) || (key !== 8 && !/^\d*$/.test(input.value + String.fromCharCode(key)))) {
                    event.preventDefault();
                }
            });

        });


        function refreshProjectParticularMLE() {
            $.ajax({
                url: '{{ route('mle.index') }}', // Update this with the actual URL of your route
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data)

                    // Populate the dropdown for materials
                    const materialsDropdown = $('#add_project_particular_material_name');
                    const materialsData = data.materials.map(material => ({
                        value: material.material_id,
                        text: material.material_name
                    }));
                    materialSelect.addOption(materialsData);

                    // Populate the dropdown for labors
                    const laborsDropdown = $('#add_project_particular_labor_name');
                    const laborsData = data.labors.map(labor => ({
                        value: labor.labor_id,
                        text: labor.labor_name + " (" + labor.location + ") "
                    }));
                    laborSelect.addOption(laborsData);

                    // Populate the dropdown for Equipments
                    const equipmentsDropdown = $('#add_project_particular_equipment_name');
                    const equipmentsData = data.equipments.map(equipment => ({
                        value: equipment.equipment_id,
                        text: equipment.equipment_name
                    }));
                    equipmentSelect.addOption(equipmentsData);
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors to the console
                }
            });
        }

        function selectProject(project_id, project_title) {
            // Save project_id and project_title to local storage
            localStorage.setItem('projectID', project_id);
            localStorage.setItem('projectTitle', project_title);


            let projectID = project_id;

            // Show SweetAlert2 popup
            Swal.fire({
                title: `${project_title} Selected`,
                icon: 'success',
                confirmButtonText: 'OK'
            });

            // Perform AJAX request immediately after showing the popup
            $.ajax({
                url: "{{ route('setProject.store') }}",
                type: "POST",
                data: {
                    projectID: projectID,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = '/transactions';
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });



        }


        // Refresh Function for Projects Table
        function refreshProjectsTable() {
            // Check if data is already cached in localStorage
            var cachedData = localStorage.getItem('projectsData');

            if (cachedData) {
                // If cached data exists, parse and use it
                displayProjects(JSON.parse(cachedData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('project.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('projectsData', JSON.stringify(data));
                    // Display the fetched data
                    displayProjects(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function displayProjects(data) {
            var table = $('#projectTable').DataTable();
            var existingRows = table.rows().remove().draw(false);
            console.log(data);

            data.forEach(function(project, index) {
                // Assuming prices is always an array, even if empty
                var newRow = table.row.add([
                    // material.material_id,
                    '<a href="#" class="link-dark" style="text-decoration: none;" onclick="selectProject(' +
                    project
                    .project_id +
                    ', \'' + project.project_title + '\')">' + project.project_title +
                    '</a>',
                    project.project_owner,
                    project.project_location,
                    project.project_contract_duration,
                    '<div class="text-center d-flex">' +
                    `<button type="button" id="editProjectButton" class="btn bg-success mr-2" data-id="${project.project_id}" onclick="viewProjectModal(${project.project_id}, '${project.project_title}', '${project.project_location}', '${project.project_owner}', '${project.project_description}', '${project.project_contract_duration}', '${project.project_date_prepared}', '${project.project_target_start_date}', '${project.project_appropriation}', '${project.project_source_of_fund}', '${project.project_mode_of_implementation}', '${project.project_category}')"><i class="fas fa-edit" aria-hidden="true"></i></button>` +
                    `<button type="button" id="deleteProject" class="btn btn-danger mr-2" data-id="${project.project_id}" onclick="deleteProject(${project.project_id})" ><i class="fa fa-trash-alt"></i></button>` +
                    `<button type="button" id="selectProjectButton" class="btn btn-success mr-2" data-id="${project.project_id}" onclick="selectProject(${project.project_id}, '${project.project_title}')" > Select </button>` +
                    '</div>'
                ]).node();
            });

            table.draw();
        }

        function deleteProject(project_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Project!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('project') }}/" + project_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Project Deleted Successfully!');
                            refreshProjectsTable();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting Project. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }


        function viewProjectModal(project_id, projectTitle, projectLocation, projectOwner,
            projectDescription,
            projectContractDuration, projectDatePrepared, projectTargetStartDate, projectAppropriation,
            projectSourceOfFund,
            projectModeOfImplementation, projectCategory) {
            console.log(project_id)
            // Populate modal fields with passed values
            $('#view_project_id').val(project_id);
            $('#view_project_title').val(projectTitle);
            $('#view_project_location').val(projectLocation);
            $('#view_project_owner').val(projectOwner);
            $('#view_project_description').val(projectDescription);
            $('#view_project_contract_duration').val(projectContractDuration);
            $('#view_project_date_prepared').val(projectDatePrepared);
            $('#view_project_appropriation').val(projectAppropriation);
            $('#view_project_source_of_fund').val(projectSourceOfFund);
            $('#view_project_mode_of_implementation').val(projectModeOfImplementation);
            $('#view_project_category').val(projectCategory === null || projectCategory === "null" ? '' :
                projectCategory);


            $("#view_project_source_of_fund").select2({
                theme: "bootstrap-5",
                placeholder: "Select Project Source of Fund",
                dropdownParent: $('#viewProjectModal'),
            });
            $("#view_project_mode_of_implementation").select2({
                theme: "bootstrap-5",
                placeholder: "Select Project Mode of Implementation",
                dropdownParent: $('#viewProjectModal'),
            });
            // Show the modal
            $('#viewProjectModal').modal('show');
        }

        $(document).ready(function() {
            // Handle Adding of Projects
            $('#addProjectForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let title = $('#add_project_title').val();
                let location = $('#add_project_location').val();
                let owner = $('#add_project_owner').val();
                let description = $('#add_project_description').val();
                let contractDuration = $('#add_project_contract_duration').val();
                let datePrepared = $('#add_project_date_prepared').val();
                let appropriation = $('#add_project_appropriation').val();
                let sourceOfFund = $('#add_project_source_of_fund').val();
                let modeOfImplementation = $('#add_project_mode_of_implementation').val();
                let projectCategory = $('#add_project_category').val();

                // Make AJAX request to add new material
                $.ajax({
                    url: "{{ route('project.store') }}",
                    type: "POST",
                    data: {
                        project_title: title,
                        project_location: location,
                        project_owner: owner,
                        project_description: description,
                        project_contract_duration: contractDuration,
                        project_date_prepared: datePrepared,
                        project_appropriation: appropriation,
                        project_source_of_fund: sourceOfFund,
                        project_mode_of_implementation: modeOfImplementation,
                        project_category: projectCategory,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Project Added Successfully!');
                        console.log(response); // Log response for debugging

                        if (response) {
                            $('#addProjectForm')[0].reset();
                            $('#addProjectModal').modal('hide');

                            refreshProjectsTable();

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

            // Handle Editing of Projects
            $('#viewProjectForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let projectId = $('#view_project_id').val();
                let title = $('#view_project_title').val();
                let location = $('#view_project_location').val();
                let owner = $('#view_project_owner').val();
                let description = $('#view_project_description').val();
                let contractDuration = $('#view_project_contract_duration').val();
                let datePrepared = $('#view_project_date_prepared').val();
                let appropriation = $('#view_project_appropriation').val();
                let sourceOfFund = $('#view_project_source_of_fund').val();
                let modeOfImplementation = $('#view_project_mode_of_implementation').val();
                let projectCategory = $('#view_project_category').val();

                // Make AJAX request to update the project
                $.ajax({
                    url: "{{ route('project.update', ['id' => ':id']) }}".replace(':id',
                        projectId),
                    type: "PUT", // Assuming you are using PUT method for update, change it if needed
                    data: {
                        project_title: title,
                        project_location: location,
                        project_owner: owner,
                        project_description: description,
                        project_contract_duration: contractDuration,
                        project_date_prepared: datePrepared,
                        project_appropriation: appropriation,
                        project_source_of_fund: sourceOfFund,
                        project_mode_of_implementation: modeOfImplementation,
                        project_category: projectCategory,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Project Updated Successfully!');
                        $('#viewProjectForm')[0].reset();
                        $('#viewProjectModal').modal('hide');

                        if (response) {
                            // Optionally, you can reset the form and close the modal here


                            refreshProjectsTable(); // Update the materials table
                        } else {
                            // Show error message if project update fails
                            alert('Failed to update project: ' + response.message);
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
