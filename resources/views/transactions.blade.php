@extends('layouts.app')
@section('title', 'Transaction')
@section('content')

    <head>

        <script src="{{ asset('js/ag-grid.js') }}"></script>
        <style>
            .cardNoBorder {
                border: none;
                box-shadow: none;
            }

            .totalFooter {
                background-color: #e5e5e5d8;
                height: 43px;
                font-weight: 630;
            }

            .select2Below {
                top: auto !important;
                bottom: auto !important;
            }
        </style>
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
                    <div class="btn btn-success" id="newProject" onclick="newProject()">New Project</div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card" id="addNewProject">
                <div class="card-header header-hover" data-toggle="collapse" data-target="#addProject" aria-expanded="false"
                    aria-controls="addProject">
                    <div class="d-flex justify-content-between col-12">
                        <h5 id="ProjectHeader">Add Project</h5>
                        <div class="card-tools">
                            <!-- Collapse Button -->
                            <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#addProject"
                                aria-expanded="false" aria-controls="addProject"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                {{-- Project Card Start --}}
                <div class="collapse" id="addProject">
                    <form id="projectDetailsForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="row col-12">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="hidden" id="add_project_id">
                                            <label for="add_project_title">Project Title</label>
                                            <input type="text" class="form-control" id="add_project_title" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_location">Location</label>
                                            <input type="text" class="form-control" id="add_project_location" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_owner">Owner</label>
                                            <input type="text" class="form-control" id="add_project_owner" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_description">Project Description</label>
                                            <input type="text" class="form-control" id="add_project_description"
                                                required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_contract_duration">Contract Duration</label>
                                            <input type="text" class="form-control" id="add_project_contract_duration"
                                                name="add_project_contract_duration" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_appropriation">Project Cost</label>
                                            <input type="text" class="form-control price-input"
                                                id="add_project_appropriation" name="add_project_appropriation" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group margin-top">
                                            <label for="add_project_source_of_fund">Project Source Of Fund</label>
                                            <select type="text" class="form-control" id="add_project_source_of_fund"
                                                name="add_project_source_of_fund" placeholder="Project Source of Fund"
                                                required>
                                                <option value=""></option>
                                                <option value="General Fund">General Fund</option>
                                                <option value="Trust Fund">Trust Fund</option>
                                                <option value="Special Trust Fund">Special Trust Fund</option>
                                                <option value="RGMO">RGMO</option>
                                            </select>
                                        </div>
                                        <div class="form-group margin-top mt-2">
                                            <label for="add_project_date_prepared">Project Date Prepared</label>
                                            <input type="date" class="form-control" id="add_project_date_prepared"
                                                name="add_project_date_prepared">
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_mode_of_implementation">Project Mode Of
                                                Implementation</label>
                                            <select type="text" class="form-control"
                                                id="add_project_mode_of_implementation"
                                                name="add_project_mode_of_implementation"
                                                placeholder="Project Source of Fund" required>
                                                <option value=""></option>
                                                <option value="By Admin">By Admin</option>
                                                <option value="By Contract">By Contract</option>
                                            </select>
                                        </div>
                                        <div class="card">
                                            <div class="row p-3 d-flex justify-content-center">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="add_project_ocm">OCM</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                id="add_project_ocm">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="add_project_contractProfit">Contract Profit</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                id="add_project_contractProfit">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- VAT  --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="add_project_vat">VAT</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                id="add_project_vat">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer col-12">
                                            <button type="submit" class="btn btn-success col-12">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- ./ Project Card  --->
            <!---- Signatures Section ---->
            <div class="card" id="addNewSignature">
                <div class="card-header header-hover" data-toggle="collapse" data-target="#addSignature"
                    aria-expanded="false" aria-controls="addSignature">
                    <div class="d-flex justify-content-between col-12">
                        <h5 id="ProjectHeader">Signature Detail</h5>
                        <div class="card-tools">
                            <!-- Collapse Button -->
                            <button type="button" class="btn btn-tool" data-toggle="collapse"
                                data-target="#addSignature" aria-expanded="false" aria-controls="addSignature"><i
                                    class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                {{-- Project Card Start --}}
                <div class="collapse" id="addSignature">
                    <div class="row p-3">
                        <div class="col-lg-12">
                            <div class="text-right mb-3">
                                <div class="btn btn-success" id="addSignatureBtn"><i class="fa fa-plus"></i></div>
                            </div>
                            <table class="table col-12 table-margin" id="signatureTable">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Title</th>
                                        <th>Role</th>
                                        <th>Position</th>
                                        {{-- <th>Modified By</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- ./ Project Card  --->


            <!----- Third Column for Required ----->
            <div class="d-flex col-12">
                <!------ Technical Personnel Required ------>
                <div class="col-6">
                    <div class="card" id="addNewTechnicalPersonnel">
                        <div class="card-header header-hover col-12" data-toggle="collapse"
                            data-target="#addTechnicalPersonnel" aria-expanded="false"
                            aria-controls="addTechnicalPersonnel">
                            <div class="d-flex justify-content-between col-12">
                                <h5 id="ProjectHeader">Technical Personnel</h5>
                                <div class="card-tools">
                                    <!-- Collapse Button -->
                                    <button type="button" class="btn btn-tool" data-toggle="collapse"
                                        aria-expanded="false"><i class="fas fa-minus"
                                            aria-controls="addTechnicalPersonnel"
                                            data-target="#addTechnicalPersonnel"></i></button>
                                </div>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        {{-- Project Card Start --}}
                        <div class="collapse" id="addTechnicalPersonnel">
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-success" id="addTechnicalPersonnelBtn"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    <table class="table col-12 table-margin" id="technicalPersonnelTable">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
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
                    </div> <!-- ./ Project Card  --->
                </div>

                <!------ Minimum Equipment Requirement ------>
                <div class="col-6">
                    <div class="card" id="addNewMinimumEquipment">
                        <div class="card-header header-hover col-12" data-toggle="collapse"
                            data-target="#addMinimumEquipment" aria-expanded="false" aria-controls="addMinimumEquipment">
                            <div class="d-flex justify-content-between col-12">
                                <h5 id="ProjectHeader">Minimum Equipment</h5>
                                <div class="card-tools">
                                    <!-- Collapse Button -->
                                    <button type="button" class="btn btn-tool" data-toggle="collapse"
                                        data-target="#addMinimumEquipment" aria-controls="addMinimumEquipment"
                                        aria-expanded="false"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        {{-- Project Card Start --}}
                        <div class="collapse" id="addMinimumEquipment">
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-success" id="addMinimumEquipmentBtn"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    <table class="table col-12 table-margin" id="minimumEquipmentTable">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Owned</th>
                                                <th>Lease</th>
                                                <th>Total # of Unit</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ./ Project Card  --->
                </div>
            </div>

            <!-- Your Blade view with JavaScript -->

            @include('modals.project_particular_detail.add_project_particular_detail')
            @include('modals.project_particular.add_projectPart_material')
            @include('modals.project_particular.add_projectPart_labor')
            @include('modals.project_particular.add_projectPart_equipment')
            @include('modals.project_particular.edit_projectPart_material')
            @include('modals.transactionals.add_trans_proj_modal')
            @include('modals.project_particular.edit_projectPart_labor')
            @include('modals.project_particular.edit_projectPart_equipment')
            @include('modals.signature.add_signature')
            @include('modals.signature.edit_signature')
            {{-- @include('modals.tech_personnel.add_tech_personnel')
            @include('modals.tech_personnel.edit_tech_personnel') --}}
            {{-- @include('modals.min_equipment.add_min_equipment')
            @include('modals.min_equipment.edit_min_equipment') --}}

        </div>
        {{-- For testing purposess --}}
        <div class="container-fluid mt-3" id="dynamicContent">
            <div class="d-flex">
                <h4>Project Item</h4>

                {{-- <div class="btn btn-success"></div> --}}
            </div>
            <div id="projectParticularContent" class="container-fluid col-12 d-flex flex-column"></div>
        </div>

        <div class="col-2">
            <select class="form-control" id="selectProjParticular">

            </select>
        </div>

    </div>


    <script>
        // Retrieve project_id and project_title from localStorage
        var selectedProjectID = localStorage.getItem("projectID");
        var selectedProjectTitle = localStorage.getItem("projectTitle");
        $("#selectProjParticular")
            .select2({
                theme: "bootstrap-5",
                placeholder: "Add Project Item",
                dropdownPosition: 'below'
            });

        // Populate the Table and Refresh at the same time
        function refreshParticularTable() {
            $.ajax({
                url: "{{ route('getParticulars') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    if (Array.isArray(data) && data.length > 0) {
                        var selectedProjID = localStorage.getItem("projectID");
                        var selectElem = $("#selectProjParticular").empty();

                        // Filter data for the selected project ID
                        var selectedProject = data.find(function(project) {
                            return project.project_id == selectedProjID;
                        });

                        // If selected project is found
                        if (selectedProject && selectedProject.particulars_available) {
                            // Add a blank option
                            selectElem.append('<option value=""></option>');

                            // Append options for each particular available in the project
                            selectedProject.particulars_available.forEach(function(particular) {
                                selectElem.append('<option value="' + particular.particular_id + '">' +
                                    particular.particular_name + '</option>');
                            });
                        } else {
                            console.error(
                                "Selected project or particulars available data not found or invalid.");
                        }
                    } else {
                        console.error("No data or invalid data received.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }

        // Event handler for select2 select event
        $('#selectProjParticular').on('select2:select', function(e) {
            var selectedParticularId = e.params.data.id;

            // Prepare data for AJAX request
            var requestData = {
                project_id: selectedProjectID, // Assuming selectedProjectID is defined
                particular_id: selectedParticularId,
                _token: "{{ csrf_token() }}",
            };

            // Send AJAX request to store the project particular
            $.ajax({
                url: "{{ route('projectParticulars.store') }}",
                type: "POST",
                dataType: "json",
                data: requestData,
                success: function(response) {
                    // Handle success response
                    console.log("Project particular successfully stored:", response);
                    // Reload the current page
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error("Error storing project particular:", xhr.responseText);
                }
            });
        });


        // Signature Table DataTable
        $("#signatureTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "searching": false,
            "ordering": true,
            "paging": false,
        });

        function sortProjectParticular() {
            console.log("Hello World")
        }

        // Adding Project
        function newProject() {
            $("#addTransProjModal").modal("show");
        }

        $('#addTransProjectForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            let title = $('#add_trans_project_title').val();
            let location = $('#add_trans_project_location').val();
            let owner = $('#add_trans_project_owner').val();
            let description = $('#add_trans_project_description').val();
            let contractDuration = $('#add_trans_project_contract_duration').val();
            let datePrepared = $('#add_trans_project_date_prepared').val();
            let appropriation = $('#add_trans_project_appropriation').val();
            let sourceOfFund = $('#add_trans_project_source_of_fund').val();
            let modeOfImplementation = $('#add_trans_project_mode_of_implementation').val();


            // Remove the P and commas
            let removeComma = appropriation.replace('₱', '').replace(/,/g,
                '');
            let projectCost = parseFloat(removeComma);
            console.log('This is the Cost: ', projectCost);

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
                    project_appropriation: projectCost,
                    project_source_of_fund: sourceOfFund,
                    project_mode_of_implementation: modeOfImplementation,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.options.progressBar = true;
                    toastr.success('Project Added Successfully!');
                    localStorage.setItem('projectID', response.project_id);
                    localStorage.setItem('projectTitle', response.project_title);
                    window.location.reload();

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });
        });

        const [year, quarter] = [(new Date()).getFullYear(), ["1st", "2nd", "3rd", "4th"][Math.floor(((new Date())
            .getMonth() % 12) / 3)]];
        // console.log("Current Year:", year);
        // console.log("Current Quarter (String):", quarter);

        function updateParticularTotal(projectPartID, projectPartTotal) {
            console.log(projectPartID);
            console.log(projectPartTotal);

            // Make AJAX request to update the project
            $.ajax({
                url: "{{ route('projectParticulars.update', ['projectParticular' => ':projectParticular']) }}"
                    .replace(
                        ':projectParticular',
                        projectPartID),
                type: "PUT",
                data: {
                    projectPartTotal: projectPartTotal,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });

        }

        loadTransaction();
        getProjects();
        refreshParticularTable();
        refreshSignature();
        cacheValues();

        function cacheValues() {
            var getAllData = localStorage.getItem("getAllData");
            if (getAllData) {
                // If cached data exists, parse and use it
                const data = JSON.parse(getAllData);
                console.log(data);
            }
        }
        $("#add_project_signature_role, #add_project_signature_position").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $("#addProjectSignatureModal"),
        });
        $("#edit_project_signature_role, #edit_project_signature_position")
            .select2({
                theme: "bootstrap-5",
                tags: true,
                dropdownParent: $("#editProjectSignatureModal"),
            });

        $("#add_project_signature_role").on("change", function() {

            const value = $("#add_project_signature_role").val();
            console.log(value)
        });


        $('#addSignatureForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let fullName = $('#add_project_signature_fullName').val();
            let degree = $('#add_signature_degree').val();
            let role = $('#add_project_signature_role').val();
            let position = $('#add_project_signature_position').val();
            let projectID = $('#signature_projectID').val();

            console.log(projectId);
            console.log(fullName);

            // Make AJAX request to add new paticular
            $.ajax({
                url: "{{ route('signatures.store') }}",
                type: "POST",
                data: {
                    fullName: fullName,
                    degree: degree,
                    role: role,
                    position: position,
                    projectId: projectId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    console.log(response); // Log response for debugging

                    if (response.success) {
                        $('#addSignatureForm')[0].reset();
                        $('#addProjectSignatureModal').modal('hide');
                        toastr.options.progressBar = true;
                        toastr.success('Signature Added Successfully!');

                        refreshSignature();

                    } else {
                        toastr.options.progressBar = true;
                        toastr.error('Signature Not Added!');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });
        });

        // Edit Signature
        $('#editSignatureForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let fullName = $('#edit_project_signature_fullName').val();
            let degree = $('#edit_signature_degree').val();
            let role = $('#edit_project_signature_role').val();
            let position = $('#edit_project_signature_position').val();
            let signatureID = $('#editSignatureID').val();

            console.log(signatureID);

            // Check if all values are empty
            if (position === null) {
                toastr.options.progressBar = true;
                toastr.error('Position is Required');
            } else {
                // Make AJAX request to add new paticular
                $.ajax({
                    url: "{{ route('signatures.update', ['signature' => ':signature']) }}".replace(
                        ':signature',
                        signatureID),
                    type: "PUT",
                    data: {
                        fullName: fullName,
                        degree: degree,
                        signature_id: signatureID,
                        role: role,
                        position: position,
                        projectId: projectId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        toastr.options.progressBar = true;
                        if (response.success) {
                            toastr.success(response.message);

                            $('#editSignatureForm')[0].reset();
                            $('#editProjectSignatureModal').modal('hide');

                            refreshSignature();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            }
        });

        // Delete Signature
        function deleteSignature(signature_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Signature!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('signatures') }}/" + signature_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Signature Deleted Successfully!');
                            refreshSignature();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting Signature. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }

        function editSignatureModal(project_id, fullname, degree, position, role, signature_id) {
            $('#edit_project_signature_fullName').val(fullname)

            if (degree === "null") {
                degree = "";
                $('#edit_signature_degree').val(degree)
            } else {
                $('#edit_signature_degree').val(degree)
            }


            function updateOrAppendOption($select, value) {
                // Check if the option already exists
                var optionExists = $select.find('option[value="' + value + '"]').length > 0;

                if (optionExists) {
                    // Update the existing option's text and value
                    $select.val(value).trigger('change');
                } else {
                    // Create a new option element
                    var newOption = new Option(value, value, true, true);

                    // Append the new option to the Select2 input
                    $select.append(newOption).trigger('change');
                }
            }

            // Usage
            updateOrAppendOption($('#edit_project_signature_role'), role);
            updateOrAppendOption($('#edit_project_signature_position'), position);

            $('#editSignatureID').val(signature_id)
            $('#editProjectSignatureModal').modal('show');
        }

        function refreshSignature() {
            $('#addSignatureBtn').click(function() {
                $('#addProjectSignatureModal').modal('show');
            });

            // Check if data is already cached in localStorage
            var cachedSignatureData = localStorage.getItem('signatureData');

            if (cachedSignatureData) {
                // If cached data exists, parse and use it
                displaySignature(JSON.parse(cachedSignatureData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('signatures.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('signatureData', JSON.stringify(data));
                    // Display the fetched data
                    displaySignature(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
        // Display the signature
        function displaySignature(data) {
            var submitProjectID = localStorage.getItem("projectID");

            // Filter the data to include only signatures with matching project_id
            var filteredData = data.filter(signature => signature.project_id == submitProjectID);

            var table = $('#signatureTable').DataTable();
            var existingRows = table.rows().remove().draw(false);

            filteredData.forEach(function(signature, index) {
                var newRow = table.row.add([
                    signature.fullname,
                    signature.degree,
                    signature.role,
                    signature.position,
                    '<div class="text-center d-flex">' +
                    `<button type="button" class="btn bg-success mr-2" data-id="${signature.project_id}" onclick="editSignatureModal(${signature.project_id}, '${signature.fullname}', '${signature.degree}', '${signature.position}', '${signature.role}', ${signature.signature_id} )"><i class="fas fa-edit"></i></button>` +
                    `<button type="button" class="btn bg-danger" data-id="${signature.particular_id}" onclick="deleteSignature(${signature.signature_id})"><i class="fas fa-trash-alt"></i></button>` +
                    '</div>'
                ]).node();
            });

            table.draw();
        }

        // TechnicalPersonnel Table DataTable
        $("#technicalPersonnelTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "searching": false,
            "ordering": true,
            "paging": false,
        });

        getProjects();
        refreshParticularTable();
        refreshTechnicalPersonnel();
        cacheValues();

        function cacheValues() {
            var getAllData = localStorage.getItem("getAllData");
            if (getAllData) {
                // If cached data exists, parse and use it
                const data = JSON.parse(getAllData);
                console.log(data);
            }
        }


        $('#addTechnicalPersonnelForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let personnelDescription = $('#add_personnel_description').val();
            let personnelNo = $('#add_personnel_no').val();
            let projectID = $('#technical_personnelID').val();

            // Make AJAX request to add new paticular
            $.ajax({
                url: "{{ route('technical_personnels.store') }}",
                type: "POST",
                data: {
                    projectId: projectId,
                    personnelDescription: personnelDescription,
                    personnelNo: personnelNo,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.options.progressBar = true;
                    toastr.success('Technical Personnel Added Successfully!');
                    console.log(response); // Log response for debugging

                    if (response) {
                        $('#addTechnicalPersonnelForm')[0].reset();
                        $('#addTechnicalPersonnelModal').modal('hide');

                        console.log('successfully added');

                        refreshTechnicalPersonnel();

                    } else {
                        // Show error message if material addition fails
                        alert('Failed to add technical personnel: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });
        });

        // Edit TechnicalPersonnel
        $('#editTechnicalPersonnelForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let personnelDescription = $('#edit_personnel_description').val();
            let personnelNo = $('#edit_personnel_no').val();
            let technicalPersonnelID = $('#editTechnicalPersonnelID').val();

            // // Check if all values are empty
            // if (position === null) {
            //     toastr.options.progressBar = true;
            //     toastr.error('Position is Required');
            // } else {
            // Make AJAX request to add new paticular
            $.ajax({
                url: "{{ route('technical_personnels.update', ['technical_personnel' => ':technical_personnel']) }}"
                    .replace(
                        ':technical_personnel',
                        technicalPersonnelID),
                type: "PUT",
                data: {
                    personnelDescription: personnelDescription,
                    personnelNo: personnelNo,
                    technical_personnel_id: technicalPersonnelID, // Change technical_personnel_id to id
                    projectId: projectId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.options.progressBar = true;
                    if (response.success) {
                        toastr.success(response.message);

                        $('#editTechnicalPersonnelForm')[0].reset();
                        $('#editTechnicalPersonnelModal').modal('hide');

                        refreshTechnicalPersonnel();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });
            // }
        });

        // Delete TechnicalPersonnel
        function deleteTechnicalPersonnel(technical_personnel_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Technical Personnel!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('technical_personnels') }}/" + technical_personnel_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Technical Personnel Deleted Successfully!');
                            refreshTechnicalPersonnel();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting Signature. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }

        // Function to populate and show edit modal for technical personnel
        function editTechPersonnelModal(project_id, personnel_no, personnel_description, technical_personnel_id) {
            $('#edit_personnel_description').val(personnel_description)

            // if (personnel_no === "null") {
            //     personnel_no = "0";
            //     $('#edit_personnel_no').val(personnel_no)
            // } else {
            //     $('#edit_personnel_no').val(personnel_no)
            // }


            // function updateOrAppendOption($select, value) {
            //     // Check if the option already exists
            //     var optionExists = $select.find('option[value="' + value + '"]').length > 0;

            //     if (optionExists) {
            //         // Update the existing option's text and value
            //         $select.val(value).trigger('change');
            //     } else {
            //         // Create a new option element
            //         var newOption = new Option(value, value, true, true);

            //         // Append the new option to the Select2 input
            //         $select.append(newOption).trigger('change');
            //     }
            // }

            // // Usage
            // updateOrAppendOption($('#edit_personnel_description'), personnel_description);
            // updateOrAppendOption($('#edit_personnel_no'), personnel_no);

            $('#editTechnicalPersonnelID').val(technical_personnel_id)
            $('#editTechnicalPersonnelModal').modal('show');
        }

        function refreshTechnicalPersonnel() {
            $('#addTechnicalPersonnelBtn').click(function() {
                $('#addTechnicalPersonnelModal').modal('show');
            });

            // Check if data is already cached in localStorage
            var cachedTechnicalPersonnelData = localStorage.getItem('technicalPersonnelData');

            if (cachedTechnicalPersonnelData) {
                // If cached data exists, parse and use it
                displayTechnicalPersonnel(JSON.parse(cachedTechnicalPersonnelData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('technical_personnels.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('technicalPersonnelData', JSON.stringify(data));
                    // Display the fetched data
                    displayTechnicalPersonnel(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
        // Function to display particular data in the DataTable
        function displayTechnicalPersonnel(data) {
            var table = $('#technicalPersonnelTable').DataTable();
            var existingRows = table.rows().remove().draw(false);

            data.forEach(function(technical_personnel, index) {
                var newRow = table.row.add([
                    technical_personnel.personnel_description,
                    technical_personnel.personnel_no,
                    '<div class="text-center d-flex">' +
                    `<button type="button" class="btn bg-success mr-2" data-id="${technical_personnel.project_id}" onclick="editTechPersonnelModal(${technical_personnel.project_id}, '${technical_personnel.personnel_description}', '${technical_personnel.personnel_no}', ${technical_personnel.technical_personnel_id} )"><i class="fas fa-edit"></i></button>` +
                    `<button type="button" class="btn bg-danger" data-id="${technical_personnel.particular_id}" onclick="deleteTechnicalPersonnel(${technical_personnel.technical_personnel_id})"><i class="fas fa-trash-alt"></i></button>` +
                    '</div>'
                ]).node();
            });

            table.draw();
        }

        // MinimunEquipment Table DataTable
        $("#minimumEquipmentTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "searching": false,
            "ordering": true,
            "paging": false,
        });

        getProjects();
        refreshParticularTable();
        refreshMinimumEquipment();
        cacheValues();

        function cacheValues() {
            var getAllData = localStorage.getItem("getAllData");
            if (getAllData) {
                // If cached data exists, parse and use it
                const data = JSON.parse(getAllData);
                console.log(data);
            }
        }
        // $("#add_project_signature_role, #add_project_signature_position").select2({
        //     theme: "bootstrap-5",
        //     tags: true,
        //     dropdownParent: $("#addProjectSignatureModal"),
        // });
        // $("#edit_project_signature_role, #edit_project_signature_position")
        //     .select2({
        //         theme: "bootstrap-5",
        //         tags: true,
        //         dropdownParent: $("#editProjectSignatureModal"),
        //     });


        $('#addMinimumEquipmentForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let minEquipDescription = $('#add_min_equip_description').val();
            let minEquipOwned = $('#add_min_equip_owned').val();
            let minEquipLease = $('#add_min_equip_lease').val();
            let minEquipTotalUnits = $('#add_min_equip_totalUnits').val();
            let projectID = $('#minimum_equipment_projectID').val();

            // Make AJAX request to add new paticular
            $.ajax({
                url: "{{ route('minimum_equipments.store') }}",
                type: "POST",
                data: {
                    minEquipDescription: minEquipDescription,
                    minEquipOwned: minEquipOwned,
                    minEquipLease: minEquipLease,
                    minEquipTotalUnits: minEquipTotalUnits,
                    projectId: projectId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.options.progressBar = true;
                    toastr.success('Minimum Equipment Added Successfully!');
                    console.log(response); // Log response for debugging

                    if (response) {
                        $('#addMinimumEquipmentForm')[0].reset();
                        $('#addMinimumEquipmentModal').modal('hide');

                        console.log('successfully added');

                        refreshMinimumEquipment();

                    } else {
                        // Show error message if material addition fails
                        alert('Failed to add minimum equipment: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error response for debugging
                    alert('Error occurred. Check console for details.');
                }
            });
        });

        // Edit MinimumEquipment
        $('#editMinimumEquipmentForm').submit(function(e) {
            e.preventDefault();

            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let minEquipDescription = $('#edit_min_equip_description').val();
            let minEquipOwned = $('#edit_min_equip_owned').val();
            let minEquipLease = $('#edit_min_equip_lease').val();
            let minEquipTotalUnits = $('#edit_min_equip_totalUnits').val();
            let minimum_equipmentID = $('#editMinimumEquipmentID').val();

            // // Check if all values are empty
            // if (position === null) {
            //     toastr.options.progressBar = true;
            //     toastr.error('Position is Required');
            // } else {
                // Make AJAX request to add new paticular
                $.ajax({
                    url: "{{ route('minimum_equipments.update', ['minimum_equipment' => ':minimum_equipment']) }}".replace(
                        ':minimum_equipment',
                        minimum_equipmentID),
                    type: "PUT",
                    data: {
                        minEquipDescription: minEquipDescription,
                        minEquipOwned: minEquipOwned,
                        minimum_equipment_id: minimum_equipmentID,
                        minEquipLease: minEquipLease,
                        minEquipTotalUnits: minEquipTotalUnits,
                        projectId: projectId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        if (response.success) {
                            toastr.success(response.message);

                            $('#editMinimumEquipmentForm')[0].reset();
                            $('#editMinimumEquipmentModal').modal('hide');

                            refreshMinimumEquipment();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            // }
        });

        // Delete MinimumEquipment
        function deleteMinimumEquipment(minimum_equipment_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Minimum Equipment!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('minimum_equipments') }}/" + minimum_equipment_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Minimum Equipment Deleted Successfully!');
                            refreshMinimumEquipment();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting Minimum Equipment. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }

        function editMinimumEquipmentModal(project_id, min_equip_description, min_equip_owned, min_equip_lease, min_equip_totalUnits, minimum_equipment_id) {
            $('#edit_min_equip_description').val(min_equip_description)

            // if (degree === "null") {
            //     degree = "";
            //     $('#edit_signature_degree').val(degree)
            // } else {
            //     $('#edit_signature_degree').val(degree)
            // }


            // function updateOrAppendOption($select, value) {
            //     // Check if the option already exists
            //     var optionExists = $select.find('option[value="' + value + '"]').length > 0;

            //     if (optionExists) {
            //         // Update the existing option's text and value
            //         $select.val(value).trigger('change');
            //     } else {
            //         // Create a new option element
            //         var newOption = new Option(value, value, true, true);

            //         // Append the new option to the Select2 input
            //         $select.append(newOption).trigger('change');
            //     }
            // }

            // // Usage
            // updateOrAppendOption($('#edit_project_signature_role'), role);
            // updateOrAppendOption($('#edit_project_signature_position'), position);

            $('#editMinimumEquipmentID').val(minimum_equipment_id)
            $('#editMinimumEquipmentModal').modal('show');
        }

        function refreshMinimumEquipment() {
            $('#addMinimumEquipmentBtn').click(function() {
                $('#addMinimumEquipmentModal').modal('show');
            });

            // Check if data is already cached in localStorage
            var cachedMinimumEquipmentData = localStorage.getItem('minimum_equipment_Data');

            if (cachedMinimumEquipmentData) {
                // If cached data exists, parse and use it
                displayMinimumEquipment(JSON.parse(cachedMinimumEquipmentData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('minimum_equipments.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('minimum_equipment_Data', JSON.stringify(data));
                    // Display the fetched data
                    displayMinimumEquipment(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
        // Function to display particular data in the DataTable
        function displayMinimumEquipment(data) {
            var table = $('#minimumEquipmentTable').DataTable();
            var existingRows = table.rows().remove().draw(false);

            data.forEach(function(minimum_equipment, index) {
                var newRow = table.row.add([
                    minimum_equipment.min_equip_description,
                    minimum_equipment.min_equip_owned,
                    minimum_equipment.min_equip_lease,
                    minimum_equipment.min_equip_totalUnits,
                    '<div class="text-center d-flex">' +
                    `<button type="button" class="btn bg-success mr-2" data-id="${minimum_equipment.project_id}" onclick="editMinimumEquipmentModal(${minimum_equipment.project_id}, '${minimum_equipment.min_equip_description}', '${minimum_equipment.min_equip_owned}', '${minimum_equipment.min_equip_lease}', '${minimum_equipment.min_equip_totalUnits}', ${minimum_equipment.minimum_equipment_id} )"><i class="fas fa-edit"></i></button>` +
                    `<button type="button" class="btn bg-danger" data-id="${minimum_equipment.particular_id}" onclick="deleteMinimumEquipment(${minimum_equipment.minimum_equipment_id})"><i class="fas fa-trash-alt"></i></button>` +
                    '</div>'
                ]).node();
            });

            table.draw();
        }

        function formatNumber(number) {
            return Number(number).toLocaleString('en-US');
        }

        var selectedProjectTitle = localStorage.getItem("projectTitle");

        // Check if selectedProjectTitle has a value
        if (selectedProjectTitle) {
            $("#ProjectHeader").text("Project Details");
        }

        // Submit the Particular Material Modal Form
        $("#editProjectPartMaterialForm").on("submit", function(event) {
            event.preventDefault();
            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let particularId = localStorage.getItem("particularId");
            let detail_type = 'Material';
            let materialId = $("#edit_particular_material_id").val();
            let materialQuantity = $(
                "#edit_particular_materialQuantity"
            ).val();

            let materialPriceID = $(
                "#editMaterialPriceID"
            ).val();

            // AJAX request
            $.ajax({
                url: "/submit-details",
                type: "POST",
                dataType: "json",
                data: {
                    projectId: projectId,
                    particularId: particularId,
                    materialId: materialId,
                    materialQuantity: materialQuantity,
                    materialPriceID: materialPriceID,
                    _token: "{{ csrf_token() }}",
                    // Add more form data fields here if needed
                },
                success: function(response) {
                    $("#editProjectPartMaterialForm")[0].reset();
                    $("#editParticularMaterialModal").modal("hide");

                    refreshAllData(parseInt(particularId));

                    toastr.options.progressBar = true;
                    toastr.success("Material Update Successfully!");

                },
                error: function(xhr, status, error) {
                    // Handle error response from the server
                    console.error(
                        "Error submitting form data:",
                        xhr.responseText
                    );

                },
            });
        });

        // Submit the Particular Labor Modal Form
        $("#editProjectPartLaborForm").on("submit", function(event) {
            event.preventDefault();
            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let particularId = localStorage.getItem("particularId");
            let detail_type = 'Labor';
            let laborId = $("#edit_particular_laborID").val();
            let noOfPerson = $(
                "#edit_particular_noOfPerson"
            ).val();
            let workDays = $(
                "#edit_particular_laborWorkDays"
            ).val();

            // AJAX request
            $.ajax({
                url: "/submit-details",
                type: "POST",
                dataType: "json",
                data: {
                    projectId: projectId,
                    particularId: particularId,
                    laborId: laborId,
                    noOfPerson: noOfPerson,
                    workDays: workDays,
                    _token: "{{ csrf_token() }}",
                    // Add more form data fields here if needed
                },
                success: function(response) {
                    $("#editProjectPartLaborForm")[0].reset();
                    $("#editPartLaborModal").modal("hide");

                    refreshAllData(parseInt(particularId));

                    toastr.options.progressBar = true;
                    toastr.success("Labor Update Successfully!");

                },
                error: function(xhr, status, error) {
                    // Handle error response from the server
                    console.error(
                        "Error submitting form data:",
                        xhr.responseText
                    );
                },
            });
        });

        // Submit the Particular Equipment Modal Form
        $("#editProjectPartEquipmentForm").on("submit", function(event) {
            event.preventDefault();
            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let equipmentId = localStorage.getItem("equipmentId");
            let particularId = localStorage.getItem("particularId");
            let detail_type = 'Labor';
            let noOfUnits = $(
                "#edit_particular_noOfUnit"
            ).val();
            let workDays = $(
                "#edit_particular_EquipmentWorkDays"
            ).val();

            // AJAX request
            $.ajax({
                url: "/submit-details",
                type: "POST",
                dataType: "json",
                data: {
                    projectId: projectId,
                    particularId: particularId,
                    equipmentId: equipmentId,
                    noOfUnit: noOfUnits,
                    equipmentWorkDays: workDays,
                    _token: "{{ csrf_token() }}",
                    // Add more form data fields here if needed
                },
                success: function(response) {

                    $("#editProjectPartEquipmentForm")[0].reset();
                    $("#editPartEquipmentModal").modal("hide");

                    refreshAllData(parseInt(particularId));

                    toastr.options.progressBar = true;
                    toastr.success("Equipment Update Successfully!");

                },
                error: function(xhr, status, error) {
                    // Handle error response from the server
                    console.error(
                        "Error submitting form data:",
                        xhr.responseText
                    );
                },
            });
        });

        function editDetail(detailType, materialPartID, material_id, materialName, materialUnit, materialCategoryName,
            materialPrice, materialQuantity, particular_id1, materialQuarter, materialYear, laborNoPerson) {

            if (detailType === "material") {
                // Populate modal fields with the received data
                $('#edit_particular_material_id').val(material_id);
                $('#edit_particular_material').val(materialName);
                $('#edit_particular_materialQuantity').val(materialQuantity);
                $('#edit_particular_category').val(materialCategoryName);
                $('#edit_particular_materialUnit').val(materialUnit);
                $('#edit_particular_materialPrice').val(materialPrice);
                $('#edit_particular_materialQuarter').val(materialQuarter);
                $('#edit_particular_materialYear').val(materialYear);
                $('#editMaterialPriceID').val(laborNoPerson);


                localStorage.setItem("particularId", particular_id1);

                console.log(detailType);

                calculateAmount();
                // Show the modal
                $("#editParticularMaterialModal").modal("show");
            } else if (detailType === "labor") {
                $('#edit_particular_laborID').val(materialPartID);
                $('#edit_particular_laborName').val(materialCategoryName);
                $('#edit_particular_noOfPerson').val(materialName);
                $('#edit_particular_laborWorkDays').val(material_id);
                $('#edit_particular_laborRate').val(materialUnit);

                localStorage.setItem("particularId", materialPrice);
                // calculateLaborAmount()
                $("#editPartLaborModal").modal("show");
            } else if (detailType === "equipment") {
                // detailType = detailType
                // materialPartID = laborPartID
                // material_id = equipmentID
                // materialName = equipmentName
                // materialUnit = equipmentCategory
                // materialCategoryName = equipmentModel
                // materialPrice = equipmentCapacity
                // materialQuantity = equipmentRate
                // particular_id1 = equipmentNoUnit
                // materialQuarter = equipmentWorkDays
                // materialYear = particular_id
                $('#edit_particular_EquipmentID').val(material_id);
                $('#edit_particular_EquipmentName').val(materialName);
                $('#edit_particular_EquipmentCategory').val(materialUnit);
                $('#edit_particular_EquipmentModel').val(materialCategoryName);
                $('#edit_particular_EquipmentCapacity').val(materialPrice);
                $('#edit_particular_EquipmentRate').val(materialQuantity);
                $('#edit_particular_noOfUnit').val(particular_id1);
                $('#edit_particular_EquipmentWorkDays').val(materialQuarter);

                localStorage.setItem("particularId", materialYear);
                localStorage.setItem("equipmentId", material_id);


                $("#editPartEquipmentModal").modal("show");
            }
        }


        $("#addProjectParticularDetailForm").on("submit", function(event) {
            event.preventDefault();
            // Get form data
            var submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let detailQuantity = $("#add_projectPart_detailQuantity").val();
            let particularID = $("#add_projectPart_detailID").val();
            let detailUnit = $(
                "#add_projectPart_detailUnit"
            ).val();
            let detailUnitCost = $(
                "#add_projectPart_detailUnitCost"
            ).val();
            let detailTotal = $(
                "#add_projectPart_detailTotal"
            ).val();

            console.log("======== debug here =========")
            console.log(projectId);
            console.log(particularID);
            console.log(detailQuantity);

            // AJAX request
            $.ajax({
                url: "{{ route('projectParticulars.store') }}",
                type: "POST",
                dataType: "json",
                data: {
                    project_id: projectId,
                    particular_id: particularID,
                    detailQuantity: detailQuantity,
                    detailUnit: detailUnit,
                    detailUnitCost: detailUnitCost,
                    detailTotal: detailTotal,
                    _token: "{{ csrf_token() }}",
                    // Add more form data fields here if needed
                },
                success: function(response) {
                    $("#addProjectParticularDetailForm")[0].reset();
                    $("#addProjectParticularDetailModal").modal("hide");

                    refreshAllData(parseInt(particularID));

                    toastr.options.progressBar = true;
                    toastr.success("Material Update Successfully!");

                },
                error: function(xhr, status, error) {
                    // Handle error response from the server
                    console.error(
                        "Error submitting form data:",
                        xhr.responseText
                    );

                },
            });
        });

        function editparticularDetail(particular_id, quantity, unit, unitCost, total) {
            const totalAmountValue = $('#total_' + particular_id).text();
            if (totalAmountValue !== "") {
                $("#add_projectPart_detailTotal").prop("readonly", true);
            } else {
                $("#add_projectPart_detailTotal").prop("readonly", false);
            }
            $("#add_projectPart_detailID").val(particular_id);
            $("#add_projectPart_detailQuantity").val(quantity);
            $("#add_projectPart_detailUnit").val(unit);
            // $("#add_projectPart_detailUnitCost").val(newUnitCost);
            $("#add_projectPart_detailTotal").val(totalAmountValue);
            $("#addProjectParticularDetailModal").modal("show");
        }

        function loadTransaction() {
            $.ajax({
                url: "{{ route('getAllData.index') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    localStorage.setItem('getAllData', JSON.stringify(data));
                    const gridOptionsMaterial = {
                        columnDefs: [{
                                field: "material_id",
                                headerName: "Material ID",
                                hide: true,
                            },
                            {
                                field: "material_name",
                                headerName: "Material Name",
                                rowDrag: true,
                                flex: 1,
                                minWidth: 175,
                            },
                            {
                                field: "material_category_id",
                                headerName: "Category Id",
                                hide: true,
                                flex: 1,
                            },
                            {
                                field: "material_category_name",
                                headerName: "Category",
                                flex: 1,
                                minWidth: 180,
                            },
                            {
                                field: "material_unit",
                                headerName: "Unit",
                                flex: 1,
                            },
                            {
                                field: "material_quarter",
                                headerName: "Quarter",
                                flex: 1,
                            },
                            {
                                field: "material_year",
                                headerName: "Year",
                                flex: 1,
                            },
                            {
                                field: "material_quantity",
                                headerName: "Quantity",
                                flex: 1,
                            },
                            {
                                field: "material_price",
                                headerName: "Unit Cost",
                                flex: 1,
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "amount",
                                headerName: "Amount",
                                colId: "materialAmount",
                                flex: 1,
                                valueGetter: function(params) {
                                    // Access material_quantity and material_price from the row data
                                    const quantity = params.data.material_quantity;
                                    const price = params.data.material_price;

                                    // Calculate the amount by multiplying quantity and price
                                    const materialTotalAmount = quantity * price;

                                    // Return the calculated amount
                                    return materialTotalAmount;
                                },
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "",
                                headerName: "Actions",
                                cellRenderer: function(params) {
                                    const materialPartID = params.data
                                        .project_particular_material_id;
                                    const detailType = "material";
                                    const materialId = params.data.material_id;
                                    const materialName = params.data.material_name;
                                    const materialUnit = params.data.material_unit;
                                    const materialCategoryName = params.data.material_category_name;
                                    const materialPrice = params.data.material_price;
                                    const materialQuantity = params.data.material_quantity;
                                    const materialQuarter = params.data.material_quarter;
                                    const materialYear = params.data.material_year;
                                    const particularId = params.data
                                        .particular_id; // Changed from materialPartID to particularId
                                    const materialPriceID = params.data.material_price_id

                                    // Construct the HTML string with the onclick event for edit and delete buttons
                                    const htmlString =
                                        '<div>' +
                                        '<button onclick="editDetail(\'' + detailType + '\', \'' +
                                        materialPartID + '\', \'' + materialId + '\', \'' +
                                        materialName + '\', \'' + materialUnit + '\', \'' +
                                        materialCategoryName + '\', \'' + materialPrice + '\', \'' +
                                        materialQuantity + '\', \'' + particularId + '\', \'' +
                                        materialQuarter + '\', \'' + materialYear + '\', \'' +
                                        materialPriceID +
                                        '\')" class="btn btn-success btn-header mr-1"><i class="fas fa-edit"></i></button>' +
                                        '<button onclick="deleteDetail(\'' + detailType + '\', ' +
                                        materialPartID +
                                        ')" class="btn btn-danger btn-header"><i class="fas fa-trash-alt"></i></button>' +
                                        '</div>';

                                    // Return the HTML string
                                    return htmlString;
                                },
                                flex: 1,
                            },
                        ],
                        defaultColDef: {
                            filter: true,
                            minWidth: 100,
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: "multiple",
                        enableCellChangeFlash: true,
                    };

                    const gridOptionsLabor = {
                        columnDefs: [{
                                field: "labor_id",
                                headerName: "Labor ID",
                                hide: true,
                            },
                            {
                                field: "labor_name",
                                headerName: "Labor Name",
                                rowDrag: true,
                                flex: 1,
                                minWidth: 145,
                            },
                            {
                                field: "labor_no_of_persons",
                                headerName: "No of Persons",
                                flex: 1,
                            },
                            {
                                field: "labor_rate",
                                headerName: "Labor Rate",
                                flex: 1,
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "labor_work_days",
                                headerName: "Work Days",
                            },
                            {
                                field: "amount",
                                headerName: "Amount",
                                colId: "LaborAmount",
                                flex: 1,
                                valueGetter: function(params) {
                                    // Access material_quantity and material_price from the row data
                                    const rate = params.data.labor_rate;
                                    const noOfPerson = params.data.labor_no_of_persons;
                                    const work_days = params.data.labor_work_days;

                                    // Calculate the amount by multiplying quantity and price
                                    const LaborTotalAmount =
                                        rate * noOfPerson * work_days;

                                    // Return the calculated amount
                                    return LaborTotalAmount;
                                },
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "",
                                headerName: "Actions",
                                cellRenderer: function(params) {
                                    const detailType = "labor";
                                    const laborPartID = params.data.labor_id;
                                    const particularID = params.data.particular_id;
                                    const projectPartID = params.data.project_particular_labor_id;
                                    const laborNoPerson = params.data.labor_no_of_persons;
                                    const workDays = params.data.labor_work_days;
                                    const laborRate = params.data.labor_rate;
                                    const laborName = params.data.labor_name;

                                    // Construct the HTML string with the detailType and particularID
                                    const htmlString =
                                        `<div>
                                                <button onclick="editDetail('${detailType}', ${laborPartID}, ${workDays}, ${laborNoPerson}, ${laborRate}, '${laborName}', ${particularID} )" class="btn btn-success btn-header">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteDetail('${detailType}', ${projectPartID})" class="btn btn-danger btn-header">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                            </div>`;

                                    // Return the HTML string
                                    return htmlString;
                                },


                                flex: 1,
                            },
                        ],
                        defaultColDef: {
                            filter: true,
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: "multiple",
                        enableCellChangeFlash: true,
                    };
                    const gridOptionsEquipment = {
                        columnDefs: [{
                                field: "equipment_id",
                                headerName: "Equipment ID",
                                hide: true,
                            },
                            {
                                field: "equipment_name",
                                headerName: "Equipment Name",
                                rowDrag: true,
                                flex: 1,
                                minWidth: 145,
                            },
                            {
                                field: "equipment_no_of_units",
                                headerName: "No of Unit",
                                flex: 1,
                            },
                            {
                                field: "equipment_rate",
                                headerName: "Rate",
                                flex: 1,
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "equipment_work_days",
                                headerName: "Work Days",
                                flex: 1,
                            },
                            {
                                field: "amount",
                                headerName: "Amount",
                                colId: "EquipmentAmount",
                                flex: 1,
                                valueGetter: function(params) {
                                    // Access material_quantity and material_price from the row data
                                    const rate = params.data.equipment_rate;
                                    const noOfPerson =
                                        params.data.equipment_no_of_units;
                                    const work_days = params.data.equipment_work_days;

                                    // Calculate the amount by multiplying quantity and price
                                    const EquipmentTotalAmount =
                                        rate * noOfPerson * work_days;

                                    // Return the calculated amount
                                    return EquipmentTotalAmount;
                                },
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "",
                                headerName: "Actions",
                                cellRenderer: function(params) {
                                    const detailType = "equipment";
                                    const particularID =
                                        params.data.project_particular_equipment_id;
                                    const particular_id = params.data.particular_id;
                                    const equipmentID = params.data.equipment_id;
                                    const equipmentName = params.data.equipment_name;
                                    const equipmentCategory = params.data.equipment_category_name;
                                    const equipmentModel = params.data.equipment_model;
                                    const equipmentCapacity = params.data.equipment_capacity;
                                    const equipmentRate = params.data.equipment_rate;
                                    const equipmentNoUnit = params.data.equipment_no_of_units;
                                    const equipmentWorkDays = params.data.equipment_work_days;

                                    // Construct the HTML string with the detailType and particularID
                                    const htmlString =
                                        `<div>
                                                <button onclick="editDetail('${detailType}', ${particularID}, ${equipmentID}, '${equipmentName}', '${equipmentCategory}', '${equipmentModel}', ${equipmentCapacity}, ${equipmentRate}, ${equipmentNoUnit}, ${equipmentWorkDays}, ${particular_id})" class="btn btn-success btn-header">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteDetail('${detailType}', ${particularID})" class="btn btn-danger btn-header">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                            </div>`;


                                    // Return the HTML string
                                    return htmlString;
                                },

                                flex: 1,
                            },
                        ],
                        defaultColDef: {
                            filter: true,
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: "multiple",
                        enableCellChangeFlash: true,
                    };

                    // Get the selected project ID from localStorage
                    var selectedProjectID = localStorage.getItem("projectID");

                    // Filter and sort project items
                    var sortedProjects = data.projects.filter(function(project) {
                        return project.project_id == selectedProjectID;
                    });
                    // Iterate through each filtered project item
                    sortedProjects.forEach(function(project) {
                        // Iterate through each particular item
                        project.particulars.forEach(function(particular, index) {
                            // Create a new main card for each particular
                            var mainCard = $(
                                '<div class="card" id="mainCardProjectParticular">'
                            );
                            var cardHeader = $(
                                '<div class="card-header header-hover padding-header" style="border-left: 7px solid green;" data-toggle="collapse" data-target="#projectPart' +
                                particular.particular_id +
                                '">'
                            );
                            var cardCollapse = $('<div class="collapse">').attr(
                                "id",
                                "projectPart" + particular.particular_id
                            );
                            var cardBody = $('<div class="card-body">');
                            var row = $('<div class="row">');
                            // Append main card to the dynamic content container
                            $("#projectParticularContent").append(mainCard);

                            var col11 = $('<div class="col-12">');

                            // Set up the card header
                            var headerContent = $(
                                '<div class="d-flex justify-content-between">'
                            );

                            // Project Item H5
                            var title = $("<h5>", {
                                "class": "numeralPartName",
                                "id": particular.particular_id
                            }).append(
                                $("<span>", {
                                    "id": ""
                                }).text("")
                            ).append(
                                particular.particular_name
                            );

                            var cardTools = $('<div class="card-tools">');
                            var collapseButton = $(
                                '<button type="button" class="btn btn-tool">'
                            ).html('<i class="fas fa-minus"></i>');

                            var dangerButton = $(
                                '<button type="button" class="btn btn-danger" data-project-particular-id="' +
                                particular.project_particular_id +
                                '"><i class="fas fa-trash-alt"></i></button>');
                            dangerButton.click(
                                function(event) {
                                    event.stopPropagation();
                                    var projectParticularId = $(this).data(
                                        'project-particular-id');

                                    // Call deleteParticular function with projectParticularId
                                    deleteParticular(projectParticularId);
                                });

                            // Append elements to the header
                            headerContent.append(
                                title,
                                cardTools.append(dangerButton, collapseButton)
                            );
                            cardHeader.append(headerContent);

                            // Create dropdown options
                            var detailTypes = ["Material", "Labor", "Equipment"];

                            // Filter out details that should not be displayed in the grid
                            const rowDataMaterial = Object.values(
                                particular.details.Materials
                            );
                            const rowDataLabor = Object.values(
                                particular.details.Labor
                            );
                            const rowDataEquipment = Object.values(
                                particular.details.Equipment
                            );

                            // Calculate total amount for material
                            let totalMaterialAmount = 0;
                            rowDataMaterial.forEach(function(
                                material) {
                                totalMaterialAmount +=
                                    material.material_quantity *
                                    parseFloat(material.material_price);
                            });

                            // format totalMaterialAmount
                            totalMaterialAmount = totalMaterialAmount
                                .toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            // Calculate total amount for labor
                            let totalLaborAmount = 0;
                            rowDataLabor.forEach(function(labor) {
                                totalLaborAmount +=
                                    labor.labor_rate *
                                    labor.labor_work_days *
                                    labor.labor_no_of_persons; // Update calculation
                            });
                            // Format totalLaborAmount
                            totalLaborAmount = totalLaborAmount
                                .toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            // Calculate total amount for equipment
                            let totalEquipmentAmount = 0;
                            rowDataEquipment.forEach(function(
                                equipment) {
                                totalEquipmentAmount +=
                                    equipment.equipment_rate *
                                    equipment.equipment_work_days *
                                    equipment.equipment_no_of_units;
                            });
                            // Format totalEquipmentAmount
                            totalEquipmentAmount = totalEquipmentAmount
                                .toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            const projectPartID = particular.project_particular_id;

                            // Remove commas from the values and parse them as floats
                            const parseAndSum = (value) => parseFloat(value.replace(/,/g, ''));
                            const totalProjPart = parseAndSum(totalMaterialAmount) +
                                parseAndSum(totalLaborAmount) +
                                parseAndSum(totalEquipmentAmount);

                            // Formatted Total Amount In a Particular
                            const formattedTotalProjPart = totalProjPart.toLocaleString();

                            var form = $('<div class="pd-zero pd-3" id="projectPartDetail_' +
                                    particular.particular_id + '">')
                                .addClass('card')
                                .append(
                                    $('<div>').addClass('card-body form-top').append(
                                        $('<div>').addClass('col-12').append(
                                            $('<div>').addClass('row').append(
                                                $('<div>').addClass('col-4').append(
                                                    $('<h6>').text('Quantity: ').append(
                                                        $('<span>').attr('id', 'quantity_' +
                                                            particular.particular_id).text(
                                                            particular
                                                            .project_particular_quantity)
                                                    )
                                                ),
                                                $('<div>').addClass('col-3').append(
                                                    $('<h6>').text('Unit: ').append(
                                                        $('<span>').attr('id', 'unit_' +
                                                            particular.particular_id).text(
                                                            particular.project_particular_unit)
                                                    )
                                                ),

                                                $('<div>').addClass('col-4').append(
                                                    $('<h6>').text('Total Amount: ').append(
                                                        $('<span>').attr('id', 'total_' +
                                                            particular.particular_id).text(
                                                            particular
                                                            .project_particular_total != null ?
                                                            parseFloat(particular
                                                                .project_particular_total)
                                                            .toLocaleString('en-US', {
                                                                minimumFractionDigits: 2,
                                                                maximumFractionDigits: 2
                                                            }) :
                                                            ''
                                                        )
                                                    )
                                                ),


                                                $('<div class="signature-zero">').addClass(
                                                    'col-1').append(
                                                    $('<div>').addClass('btn btn-success').attr(
                                                        'id', 'particularDetail_' + particular
                                                        .particular_id).append(
                                                        $('<i>').addClass('fa fa-plus')
                                                    ).click(function() {
                                                        editparticularDetail(particular
                                                            .particular_id, particular
                                                            .project_particular_quantity,
                                                            particular
                                                            .project_particular_unit,
                                                            particular
                                                            .project_particular_unitCost,
                                                            project
                                                            .project_particular_total
                                                        );
                                                    })
                                                )
                                            )
                                        )
                                    )
                                );
                            // Set up the cards for Material, Labor, and Equipment
                            var materialCard = createDetailCard(
                                "Material",
                                particular.particular_id,
                                particular.particular_name,
                                particular,
                                totalMaterialAmount
                            );
                            var laborCard = createDetailCard(
                                "Labor",
                                particular.particular_id,
                                particular.particular_name,
                                particular,
                                totalLaborAmount
                            );
                            var equipmentCard = createDetailCard(
                                "Equipment",
                                particular.particular_id,
                                particular.particular_name,
                                particular,
                                totalEquipmentAmount
                            );

                            // Append cards to the col11 container
                            col11.append(materialCard, laborCard, equipmentCard);

                            // Append col1 and col11 to the row
                            row.append(form, col11);

                            // Append row to the card body
                            cardBody.append(row);

                            // Append card body to the collapse container
                            cardCollapse.append(cardBody);

                            // Append card header and collapse container to the main card
                            mainCard.append(cardHeader, cardCollapse);
                            // Append main card to the dynamic content container
                            $("#projectParticularContent").append(mainCard);

                        });

                        // Filter the projects based on the selected project ID
                        var filteredProjects = data.projects.filter(
                            (project) => project.project_id == selectedProjectID
                        );
                        // Extract the particulars and details from the filtered projects
                        var detailArray = filteredProjects.flatMap((project) => {
                            return project.particulars.flatMap((particular) => {
                                // Combine the particular with its details
                                return {
                                    particular_id: particular.particular_id,
                                    particular_name: particular.particular_name,
                                    details: particular.details,
                                };
                            });
                        });

                        // Sort the materials array based on the particular_id
                        detailArray.sort((a, b) => a.particular_id - b.particular_id);

                        // Loop through each item in detailArray and create a grid for each particular
                        detailArray.forEach((particular) => {
                            const materialGridDiv = document.querySelector(
                                `#materialBody_${particular.particular_id}`
                            );
                            const laborGridDiv = document.querySelector(
                                `#laborBody_${particular.particular_id}`
                            );
                            const equipmentGridDiv = document.querySelector(
                                `#equipmentBody_${particular.particular_id}`
                            );

                            const materialGridAPI = new agGrid.createGrid(
                                materialGridDiv,
                                gridOptionsMaterial
                            );
                            const laborGridAPI = new agGrid.createGrid(
                                laborGridDiv,
                                gridOptionsLabor
                            );
                            const equipmentGridAPI = new agGrid.createGrid(
                                equipmentGridDiv,
                                gridOptionsEquipment
                            );
                            // Filter out details that should not be displayed in the grid
                            const rowDataMaterial = Object.values(
                                particular.details.Materials
                            );
                            const rowDataLabor = Object.values(
                                particular.details.Labor
                            );
                            const rowDataEquipment = Object.values(
                                particular.details.Equipment
                            );

                            materialGridAPI.setGridOption("rowData", rowDataMaterial);
                            laborGridAPI.setGridOption("rowData", rowDataLabor);
                            equipmentGridAPI.setGridOption("rowData", rowDataEquipment);


                            // const cardIds = ["materialCard_" + particular.particular_id,
                            //     "laborCard_" + particular.particular_id,
                            //     "equipmentCard_" + particular.particular_id,
                            // ];
                            // cardIds.forEach((id) => {
                            //     const cardToCollapse = document.getElementById(id);
                            //     if (cardToCollapse) {
                            //         cardToCollapse.classList.add("collapsed-card");
                            //     }
                            // });

                            // console.log('============= Checking Values ==================')
                            // if (rowDataMaterial.length === 0 && rowDataLabor.length === 0 &&
                            //     rowDataEquipment.length === 0) {
                            //     console.log("No Row Data");
                            // } else {
                            //     if (rowDataMaterial.length > 0) {
                            //         console.log("Material Has Data");
                            //     } else {
                            //         console.log("No Material Row Data");
                            //     }

                            //     if (rowDataLabor.length > 0) {
                            //         console.log("Labor Has Data")
                            //     } else {
                            //         console.log("No Labor Row Data");
                            //     }

                            //     if (rowDataEquipment.length > 0) {
                            //         console.log("Equipment Has Data");
                            //     } else {
                            //         console.log("No Equipment Row Data");
                            //     }
                            // }


                            // console.log(
                            //     '============== End Checking of Values ==================')

                        });
                    });

                },
            });
        }

        // Define totalAmountColumn in a scope accessible outside of the function
        var totalAmountColumn;

        function toggleTotal(detailType, particular_id) {
            detailType = detailType.toLowerCase();
            var $element = $(`#${detailType}CardTotal_${particular_id}`);
            if ($element.css('opacity') === '1') {
                $element.css({
                    'opacity': '0',
                    'transition': 'opacity 0.4s ease-out'
                });
            } else {
                $element.css({
                    'opacity': '1',
                    'transition': 'opacity 0.4s ease-in'
                });
            }
        }

        // Function to create detail cards
        function createDetailCard(detailType, particular_id, particular_name, particular, totalAmounts) {
            var card = $('<div>', {
                class: 'card card-refresh',
                id: `${detailType.toLowerCase()}Card_${particular_id}`
            });

            var cardHeader = $('<div>', {
                class: 'card-header d-flex justify-content-between col-12 header-hover padding-header',
                'data-toggle': 'collapse',
                'data-target': `#${detailType.toLowerCase()}CardBody_${particular_id}`,
                onclick: `toggleTotal('${detailType}', '${particular_id}')`
            });
            var headerContent = $('<div>', {
                class: 'd-flex justify-content-between col-12'
            });
            var title = $('<h5 class="col-8">').text(detailType);

            var collapse = $('<div>', {
                class: 'collapse show',
                id: `${detailType.toLowerCase()}CardBody_${particular_id}`
            });

            var collapseButton = $('<button>', {
                    type: 'button',
                    class: 'btn btn-tool',
                    'data-card-widget': 'collapse'
                })
                .append('<i class="fas fa-toggle-on" id="iconToggle"></i>');
            var addDetailButton = $('<div>', {
                    class: 'btn btn-success btn-header',
                    id: `${detailType.toLowerCase()}Detail_${particular_id}`
                })
                .click(function(event) {
                    event.stopPropagation();
                    addDetailBtn(particular_id, detailType);
                })
                .append('<i class="fa fa-plus"></i>');

            var cardBody = $('<div>', {
                class: 'card-body',
                style: 'height: 350px;'
            });
            var headerName = `Total ${detailType} Amount: ${totalAmounts}`;

            var footerCard = $('<div>', {
                class: 'card totalFooter'
            });
            var cardBodyFooter = $('<div>', {
                class: 'card-body col-11'
            });
            var footerGridDiv = $('<div>', {
                class: 'text-right',
                style: 'margin-top: -10px;'
            });
            var headerTotal = $('<div>', {
                style: 'font-weight: 500; opacity: 0;',
                id: `${detailType.toLowerCase()}CardTotal_${particular_id}`
            }).append(`<div>Total ${detailType} Amount: ${totalAmounts}</div>`);
            var cardTools = $('<div>', {
                class: 'd-flex justify-content-between col-4'
            });
            var sideButton = $('<div>', {
                class: ''
            });
            sideButton.append(addDetailButton, collapseButton);

            // headerContent.append(title, cardTools.append(headerTotal, addDetailButton, collapseButton));
            headerContent.append(title, cardTools.append(headerTotal).append(sideButton));
            cardHeader.append(headerContent).click(function() {
                $(this).find("#iconToggle").toggleClass("fa-toggle-on fa-toggle-off");
            });


            cardBody.append($('<div>', {
                id: `${detailType.toLowerCase()}Body_${particular_id}`,
                class: 'ag-theme-quartz',
                style: 'height: 85%;'
            }));

            footerGridDiv.append($('<span>', {
                class: 'total-text'
            }).text(headerName));
            cardBodyFooter.append(footerGridDiv);
            footerCard.append(cardBodyFooter);

            cardBody.append(footerCard);
            collapse.append(cardBody);
            card.append(cardHeader, collapse);

            return card;
        }

        function refreshDetailCard(detailType, particular_id, particular_name, particular, totalAmounts) {
            var card = $('<div>', {
                class: 'card',
                id: `${detailType.toLowerCase()}Card_${particular_id}`
            });
            var cardHeader = $('<div>', {
                class: 'card-header d-flex justify-content-between col-12 header-hover padding-header',
                'data-toggle': 'collapse',
                'data-target': `#${detailType.toLowerCase()}CardBody_${particular_id}`,
                onclick: `toggleTotal('${detailType}', '${particular_id}')`
            });
            var headerContent = $('<div>', {
                class: 'd-flex justify-content-between col-12'
            });
            var title = $('<h5 class="col-8">').text(detailType);
            var cardTools = $('<div>', {
                class: 'd-flex justify-content-between col-4'
            });
            var collapse = $('<div>', {
                class: 'collapse show',
                id: `${detailType.toLowerCase()}CardBody_${particular_id}`
            });
            var collapseButton = $('<button>', {
                    type: 'button',
                    class: 'btn btn-tool',
                    'data-card-widget': 'collapse'
                })
                .append('<i class="fas fa-toggle-on" id="iconToggle"></i>');
            var addDetailButton = $('<div>', {
                    class: 'btn btn-success btn-header',
                    id: `${detailType.toLowerCase()}Detail_${particular_id}`
                })
                .click(function(event) {
                    event.stopPropagation();
                    addDetailBtn(particular_id, detailType);
                })
                .append('<i class="fa fa-plus"></i>');
            var headerTotal = $('<div>', {
                style: 'font-weight: 500; opacity: 0;',
                id: `${detailType.toLowerCase()}CardTotal_${particular_id}`
            }).append(`<div>Total ${detailType} Amount: ${totalAmounts}</div>`);
            var sideButton = $('<div>', {
                class: ''
            });
            sideButton.append(addDetailButton, collapseButton);

            // headerContent.append(title, cardTools.append(headerTotal, addDetailButton, collapseButton));
            headerContent.append(title, cardTools.append(headerTotal).append(sideButton));
            cardHeader.append(headerContent).click(function() {
                $(this).find("#iconToggle").toggleClass("fa-toggle-on fa-toggle-off");
            });

            var cardBody = $('<div>', {
                class: 'card-body',
                style: 'height: 350px;'
            });
            cardBody.append($('<div>', {
                id: `${detailType.toLowerCase()}Body_${particular_id}`,
                class: 'ag-theme-quartz',
                style: 'height: 85%;'
            }));

            var headerName = `Total ${detailType} Amount: ${totalAmounts}`;
            var footerCard = $('<div>', {
                class: 'card totalFooter'
            });
            var cardBodyFooter = $('<div>', {
                class: 'card-body col-11'
            });
            var footerGridDiv = $('<div>', {
                class: 'text-right',
                style: 'margin-top: -10px;'
            });
            footerGridDiv.append($('<span>', {
                class: 'total-text'
            }).text(headerName));
            cardBodyFooter.append(footerGridDiv);
            footerCard.append(cardBodyFooter);

            cardBody.append(footerCard);
            collapse.append(cardBody);
            card.append(cardHeader, collapse);

            return card;
        }

        function getProjects() {
            // Retrieve project_id and project_title from localStorage
            var selectedProjectID = localStorage.getItem("projectID");
            var selectedProjectTitle = localStorage.getItem("projectTitle");

            console.log(selectedProjectID);
            console.log(selectedProjectTitle);

            $.ajax({
                url: "{{ route('project.index') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("This is the project data:", data);

                    // Check if there are no projects or if selectedProjectID is not found
                    if (data.length === 0 || !data.find(project => project.project_id === parseInt(
                            selectedProjectID))) {
                        console.log('Test if this shows');
                        $("#projectSelectedTitle").text('No Project Selected');
                        return;
                    }

                    // Iterate over each project
                    data.forEach(function(project) {
                        // Check if the project ID matches the selected project ID
                        if (selectedProjectID == parseInt(project.project_id)) {
                            // Set the values into the specified HTML elements
                            $("#projectSelectedID").val(selectedProjectID);
                            $("#projectSelectedTitle").text(selectedProjectTitle);
                            // Populate input fields with project data based on their IDs
                            $("#add_project_id").val(project.project_id);
                            $("#add_project_title").val(project.project_title);
                            $("#add_project_location").val(project.project_location);
                            $("#add_project_owner").val(project.project_owner);
                            $("#add_project_description").val(project.project_description);
                            $("#add_project_contract_duration").val(project.project_contract_duration);
                            $("#add_project_appropriation").val(project.project_appropriation);
                            $("#add_project_source_of_fund").val(project.project_source_of_fund);
                            $("#add_project_date_prepared").val(project.project_date_prepared);
                            $("#add_project_mode_of_implementation").val(project
                                .project_mode_of_implementation);
                            $("#add_project_ocm").val(project.ocm);
                            $("#add_project_contractProfit").val(project.contractors_profit);
                            $("#add_project_vat").val(project.vat);
                        }
                    });
                    $("#add_project_source_of_fund").select2({
                        theme: "bootstrap-5",
                        placeholder: "Select Project Source of Fund", // Optional placeholder text
                        // allowClear: true, // Allow clearing the selection
                    });
                    $("#add_project_mode_of_implementation").select2({
                        theme: "bootstrap-5",
                        placeholder: "Select Project Mode of Implementation", // Optional placeholder text
                        // allowClear: true, // Allow clearing the selection
                    });
                    initializePriceInputs();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $("#projectSelectedTitle").text('No Project Selected');
                },
            });

        }

        // Add click event listener to the button
        $("#selectDetailMaterial").click(function() {
            // Store the visibility state in local storage
            // localStorage.setItem('materialCardVisible', 'true');
        });

        $("#selectDetailLabor").click(function() {
            $("#laborCard").removeClass("d-none");
            // Store the visibility state in local storage
            // localStorage.setItem('materialCardVisible', 'true');
        });

        $("#selectDetailEquipment").click(function() {
            $("#equipmentCard").removeClass("d-none");
            // Store the visibility state in local storage
            // localStorage.setItem('materialCardVisible', 'true');
        });

        let materialgridApi;

        function refreshAllData(particularId, detail_type) {
            $.ajax({
                url: "{{ route('getAllData.index') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    const gridOptionsMaterial = {
                        columnDefs: [{
                                field: "material_id",
                                headerName: "Material ID",
                                hide: true,
                            },
                            {
                                field: "material_name",
                                headerName: "Material Name",
                                rowDrag: true,
                                flex: 1,
                                minWidth: 175,
                            },
                            {
                                field: "material_category_id",
                                headerName: "Category Id",
                                hide: true,
                                flex: 1,
                            },
                            {
                                field: "material_category_name",
                                headerName: "Category",
                                flex: 1,
                                minWidth: 180,
                            },
                            {
                                field: "material_unit",
                                headerName: "Unit",
                                flex: 1,
                            },
                            {
                                field: "material_quarter",
                                headerName: "Quarter",
                                flex: 1,
                            },
                            {
                                field: "material_year",
                                headerName: "Year",
                                flex: 1,
                            },
                            {
                                field: "material_quantity",
                                headerName: "Quantity",
                                flex: 1,
                            },
                            {
                                field: "material_price",
                                headerName: "Unit Cost",
                                flex: 1,
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "amount",
                                headerName: "Amount",
                                colId: "materialAmount",
                                flex: 1,
                                valueGetter: function(params) {
                                    // Access material_quantity and material_price from the row data
                                    const quantity = params.data.material_quantity;
                                    const price = params.data.material_price;

                                    // Calculate the amount by multiplying quantity and price
                                    const materialTotalAmount = quantity * price;

                                    // Return the calculated amount
                                    return materialTotalAmount;
                                },
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "",
                                headerName: "Actions",
                                cellRenderer: function(params) {
                                    const materialPartID = params.data
                                        .project_particular_material_id;
                                    const detailType = "material";
                                    const materialId = params.data.material_id;
                                    const materialName = params.data.material_name;
                                    const materialUnit = params.data.material_unit;
                                    const materialCategoryName = params.data
                                        .material_category_name;
                                    const materialPrice = params.data.material_price;
                                    const materialQuantity = params.data.material_quantity;
                                    const materialQuarter = params.data.material_quarter;
                                    const materialYear = params.data.material_year;
                                    const particularId = params.data
                                        .particular_id; // Changed from materialPartID to particularId
                                    const materialPriceID = params.data.material_price_id

                                    // Construct the HTML string with the onclick event for edit and delete buttons
                                    const htmlString =
                                        '<div>' +
                                        '<button onclick="editDetail(\'' + detailType +
                                        '\', \'' +
                                        materialPartID + '\', \'' + materialId + '\', \'' +
                                        materialName + '\', \'' + materialUnit + '\', \'' +
                                        materialCategoryName + '\', \'' + materialPrice +
                                        '\', \'' +
                                        materialQuantity + '\', \'' + particularId + '\', \'' +
                                        materialQuarter + '\', \'' + materialYear + '\', \'' +
                                        materialPriceID +
                                        '\')" class="btn btn-success btn-header mr-1"><i class="fas fa-edit"></i></button>' +
                                        '<button onclick="deleteDetail(\'' + detailType +
                                        '\', ' +
                                        materialPartID +
                                        ')" class="btn btn-danger btn-header"><i class="fas fa-trash-alt"></i></button>' +
                                        '</div>';

                                    // Return the HTML string
                                    return htmlString;
                                },
                                flex: 1,
                            },
                        ],
                        defaultColDef: {
                            filter: true,
                            minWidth: 100,
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: "multiple",
                        enableCellChangeFlash: true,
                    };

                    const gridOptionsLabor = {
                        columnDefs: [{
                                field: "labor_id",
                                headerName: "Labor ID",
                                hide: true,
                            },
                            {
                                field: "labor_name",
                                headerName: "Labor Name",
                                rowDrag: true,
                                flex: 1,
                                minWidth: 145,
                            },
                            {
                                field: "labor_no_of_persons",
                                headerName: "No of Persons",
                                flex: 1,
                            },
                            {
                                field: "labor_rate",
                                headerName: "Labor Rate",
                                flex: 1,
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "labor_work_days",
                                headerName: "Work Days",
                            },
                            {
                                field: "amount",
                                headerName: "Amount",
                                colId: "LaborAmount",
                                flex: 1,
                                valueGetter: function(params) {
                                    // Access material_quantity and material_price from the row data
                                    const rate = params.data.labor_rate;
                                    const noOfPerson = params.data.labor_no_of_persons;
                                    const work_days = params.data.labor_work_days;

                                    // Calculate the amount by multiplying quantity and price
                                    const LaborTotalAmount =
                                        rate * noOfPerson * work_days;

                                    // Return the calculated amount
                                    return LaborTotalAmount;
                                },
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "",
                                headerName: "Actions",
                                cellRenderer: function(params) {
                                    const detailType = "labor";
                                    const laborPartID = params.data.labor_id;
                                    const particularID = params.data.particular_id;
                                    const projectPartID = params.data
                                        .project_particular_labor_id;
                                    const laborNoPerson = params.data.labor_no_of_persons;
                                    const workDays = params.data.labor_work_days;
                                    const laborRate = params.data.labor_rate;
                                    const laborName = params.data.labor_name;

                                    // Construct the HTML string with the detailType and particularID
                                    const htmlString =
                                        `<div>
                                                <button onclick="editDetail('${detailType}', ${laborPartID}, ${workDays}, ${laborNoPerson}, ${laborRate}, '${laborName}', ${particularID} )" class="btn btn-success btn-header">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteDetail('${detailType}', ${projectPartID})" class="btn btn-danger btn-header">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                            </div>`;

                                    // Return the HTML string
                                    return htmlString;
                                },


                                flex: 1,
                            },
                        ],
                        defaultColDef: {
                            filter: true,
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: "multiple",
                        enableCellChangeFlash: true,
                    };

                    const gridOptionsEquipment = {
                        columnDefs: [{
                                field: "equipment_id",
                                headerName: "Equipment ID",
                                hide: true,
                            },
                            {
                                field: "equipment_name",
                                headerName: "Equipment Name",
                                rowDrag: true,
                                flex: 1,
                                minWidth: 145,
                            },
                            {
                                field: "equipment_no_of_units",
                                headerName: "No of Unit",
                                flex: 1,
                            },
                            {
                                field: "equipment_rate",
                                headerName: "Rate",
                                flex: 1,
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "equipment_work_days",
                                headerName: "Work Days",
                                flex: 1,
                            },
                            {
                                field: "amount",
                                headerName: "Amount",
                                colId: "EquipmentAmount",
                                flex: 1,
                                valueGetter: function(params) {
                                    // Access material_quantity and material_price from the row data
                                    const rate = params.data.equipment_rate;
                                    const noOfPerson =
                                        params.data.equipment_no_of_units;
                                    const work_days = params.data.equipment_work_days;

                                    // Calculate the amount by multiplying quantity and price
                                    const EquipmentTotalAmount =
                                        rate * noOfPerson * work_days;

                                    // Return the calculated amount
                                    return EquipmentTotalAmount;
                                },
                                valueFormatter: function(params) {
                                    // Format the amount with commas for thousands separators and two decimal places
                                    return parseFloat(params.value)
                                        .toFixed(2)
                                        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                                },
                            },
                            {
                                field: "",
                                headerName: "Actions",
                                cellRenderer: function(params) {
                                    const detailType = "equipment";
                                    const particularID =
                                        params.data.project_particular_equipment_id;
                                    const particular_id = params.data.particular_id;
                                    const equipmentID = params.data.equipment_id;
                                    const equipmentName = params.data.equipment_name;
                                    const equipmentCategory = params.data
                                        .equipment_category_name;
                                    const equipmentModel = params.data.equipment_model;
                                    const equipmentCapacity = params.data.equipment_capacity;
                                    const equipmentRate = params.data.equipment_rate;
                                    const equipmentNoUnit = params.data.equipment_no_of_units;
                                    const equipmentWorkDays = params.data.equipment_work_days;

                                    // Construct the HTML string with the detailType and particularID
                                    const htmlString =
                                        `<div>
                                                <button onclick="editDetail('${detailType}', ${particularID}, ${equipmentID}, '${equipmentName}', '${equipmentCategory}', '${equipmentModel}', ${equipmentCapacity}, ${equipmentRate}, ${equipmentNoUnit}, ${equipmentWorkDays}, ${particular_id})" class="btn btn-success btn-header">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteDetail('${detailType}', ${particularID})" class="btn btn-danger btn-header">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                            </div>`;


                                    // Return the HTML string
                                    return htmlString;
                                },

                                flex: 1,
                            },
                        ],
                        defaultColDef: {
                            filter: true,
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: "multiple",
                        enableCellChangeFlash: true,
                    };
                    // Get the selected project ID from localStorage
                    var selectedProjectID = localStorage.getItem("projectID");

                    // Filter and sort project items
                    var sortedProjects = data.projects.filter(function(project) {
                        return project.project_id == selectedProjectID;
                    });
                    $("#materialCard_" + particularId).empty();
                    $("#laborCard_" + particularId).empty();
                    $("#equipmentCard_" + particularId).empty();

                    // Array to store total amount arrays for all particulars
                    const totalAmountArray = [];

                    // Iterate through each filtered project item
                    sortedProjects.forEach(function(project) {
                        // Iterate through each particular item
                        project.particulars.forEach(function(particular) {

                            // Declaring Total Values
                            // Filter out details that should not be displayed in the grid
                            const rowDataMaterial = Object.values(
                                particular.details.Materials
                            );
                            const rowDataLabor = Object.values(
                                particular.details.Labor
                            );
                            const rowDataEquipment = Object.values(
                                particular.details.Equipment
                            );

                            // Calculate total amount for material
                            let totalMaterialAmount = 0;
                            rowDataMaterial.forEach(function(
                                material) {
                                totalMaterialAmount +=
                                    material.material_quantity *
                                    parseFloat(material.material_price);
                            });

                            // format totalMaterialAmount
                            totalPartMaterialAmount = totalMaterialAmount
                                .toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            // Calculate total amount for labor
                            let totalLaborAmount = 0;
                            rowDataLabor.forEach(function(labor) {
                                totalLaborAmount +=
                                    labor.labor_rate *
                                    labor.labor_work_days *
                                    labor.labor_no_of_persons; // Update calculation
                            });
                            // Format totalLaborAmount
                            totalPartLaborAmount = totalLaborAmount
                                .toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            // Calculate total amount for equipment
                            let totalEquipmentAmount = 0;
                            rowDataEquipment.forEach(function(
                                equipment) {
                                totalEquipmentAmount +=
                                    equipment.equipment_rate *
                                    equipment.equipment_work_days *
                                    equipment.equipment_no_of_units;
                            });
                            // Format totalEquipmentAmount
                            totalPartEquipmentAmount = totalEquipmentAmount
                                .toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            // Create an object to store the total amounts along with the particularId
                            const totalAmountObject = {
                                particular_id: particular.particular_id,
                                totalPartMaterialAmount: totalMaterialAmount,
                                totalPartLaborAmount: totalLaborAmount,
                                totalPartEquipmentAmount: totalEquipmentAmount,
                                totalPartAmount: totalMaterialAmount + totalLaborAmount +
                                    totalEquipmentAmount,
                            };
                            // Push the object to the array
                            totalAmountArray.push(totalAmountObject);

                            var form = $('<div>').addClass('card-body form-top').append(
                                $('<div>').addClass('col-12').append(
                                    $('<div>').addClass('row').append(
                                        $('<div>').addClass('col-4').append(
                                            $('<h6>').text('Quantity: ').append(
                                                $('<span>').attr('id', 'quantity_' +
                                                    particular.particular_id).text(
                                                    particular
                                                    .project_particular_quantity)
                                            )
                                        ),
                                        $('<div>').addClass('col-3').append(
                                            $('<h6>').text('Unit: ').append(
                                                $('<span>').attr('id', 'unit_' +
                                                    particular.particular_id).text(
                                                    particular.project_particular_unit)
                                            )
                                        ),

                                        $('<div>').addClass('col-4').append(
                                            $('<h6>').text('Total Amount: ').append(
                                                $('<span>').attr('id', 'total_' +
                                                    particular.particular_id).text(
                                                    particular
                                                    .project_particular_total != null ?
                                                    parseFloat(particular
                                                        .project_particular_total)
                                                    .toLocaleString('en-US', {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2
                                                    }) :
                                                    ''
                                                )
                                            )
                                        ),

                                        $('<div class="signature-zero">').addClass(
                                            'col-1').append(
                                            $('<div>').addClass('btn btn-success').attr(
                                                'id', 'particularDetail_' + particular
                                                .particular_id).append(
                                                $('<i>').addClass('fa fa-plus')
                                            ).click(function() {
                                                editparticularDetail(particular
                                                    .particular_id, particular
                                                    .project_particular_quantity,
                                                    particular
                                                    .project_particular_unit,
                                                    particular
                                                    .project_particular_unitCost,
                                                    project.project_particular_total
                                                );
                                            })
                                        )
                                    )
                                )
                            );
                            $("#projectPartDetail_" + particular.particular_id).empty();

                            // Re-append the form variable
                            $("#projectPartDetail_" + particular.particular_id).append(
                                form);
                            $('#quantity_' + particular.particular_id).text(particular
                                .project_particular_quantity)
                            $('#unit_' + particular.particular_id).text(particular
                                .project_particular_unit)
                            $('#unit_cost_' + particular.particular_id).text(parseFloat(
                                particular.project_particular_unitCost).toFixed(2));
                            $('#total_' + particular.particular_id).text(parseFloat(
                                particular
                                .project_particular_total).toFixed(2));

                            // Check if particular_id is particulardID and it's Material data
                            if (
                                particular.particular_id === particularId &&
                                particular.details.hasOwnProperty("Materials")
                            ) {
                                // Filter out details that should not be displayed in the grid
                                const rowDataMaterial = Object.values(
                                    particular.details.Materials
                                );
                                // Calculate total amount for material
                                let totalMaterialAmount = 0;
                                rowDataMaterial.forEach(function(material) {
                                    totalMaterialAmount +=
                                        material.material_quantity *
                                        parseFloat(material.material_price);

                                    const particularId = "TotalMaterialPartID_" +
                                        material
                                        .project_particular_id;
                                });
                                // Format totalMaterialAmount
                                totalMaterialAmount = totalMaterialAmount
                                    .toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Set up the card for Material
                                var materialCard;
                                try {
                                    materialCard = refreshDetailCard(
                                        "Material",
                                        particular.particular_id,
                                        particular.particular_name,
                                        particular,
                                        totalMaterialAmount
                                    );
                                    // Replace the content of #materialCard_1 with materialCard
                                    $("#materialCard_" + particularId).append(materialCard);
                                } catch (error) {
                                    console.error('Error appending materialCard:', error);
                                }
                            }
                            // Check if particular_id is particularID and it's Labor data
                            if (
                                particular.particular_id === particularId &&
                                particular.details.hasOwnProperty("Labor")
                            ) {
                                // Filter out details that should not be displayed in the grid
                                const rowDataLabor = Object.values(
                                    particular.details.Labor
                                );
                                // Calculate total amount for labor
                                let totalLaborAmount = 0;
                                rowDataLabor.forEach(function(labor) {
                                    totalLaborAmount +=
                                        labor.labor_rate *
                                        labor.labor_work_days *
                                        labor
                                        .labor_no_of_persons; // Update calculation
                                });
                                // Format totalLaborAmount
                                totalLaborAmount = totalLaborAmount
                                    .toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Set up the card for Labor
                                var laborCard = refreshDetailCard(
                                    "Labor",
                                    particular.particular_id,
                                    particular.particular_name,
                                    particular,
                                    totalLaborAmount
                                );

                                // Replace the content of #laborCard_1 with laborCard
                                $("#laborCard_" + particularId).append(laborCard);
                            }
                            // Check if particular_id is particularID and it's Equipment data
                            if (
                                particular.particular_id === particularId &&
                                particular.details.hasOwnProperty("Equipment")
                            ) {
                                // Filter out details that should not be displayed in the grid
                                const rowDataEquipment = Object.values(
                                    particular.details.Equipment
                                );
                                // Calculate total amount for labor
                                let totalEquipmentAmount = 0;
                                rowDataEquipment.forEach(function(equipment) {
                                    totalEquipmentAmount +=
                                        equipment.equipment_no_of_units *
                                        equipment.equipment_rate *
                                        equipment
                                        .equipment_work_days; // Update calculation
                                });
                                // Format totalEquipmentAmount
                                totalEquipmentAmount = totalEquipmentAmount
                                    .toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Set up the card for Labor
                                var equipmentCard = refreshDetailCard(
                                    "Equipment",
                                    particular.particular_id,
                                    particular.particular_name,
                                    particular,
                                    totalEquipmentAmount
                                );

                                // Replace the content of #equipmentCard_1 with equipmentCard
                                $("#equipmentCard_" + particularId).append(
                                    equipmentCard
                                );
                            }
                        });
                        // Filter the projects based on the selected project ID
                        var filteredProjects = data.projects.filter(
                            (project) => project.project_id == selectedProjectID
                        );
                        // Extract the particulars and details from the filtered projects
                        var detailArray = filteredProjects.flatMap((project) => {
                            return project.particulars.flatMap((particular) => {
                                // Combine the particular with its details
                                return {
                                    particular_id: particular.particular_id,
                                    particular_name: particular.particular_name,
                                    details: particular.details,
                                };
                            });
                        });

                        // Sort the materials array based on the particular_id
                        detailArray.sort((a, b) => a.particular_id - b.particular_id);
                        // Loop through each item in detailArray and create a grid for each particular
                        detailArray.forEach((particular) => {
                            const particular_id = particular
                                .particular_id; // Extract particular_id
                            const materialGridDiv = document.querySelector(
                                `#materialBody_${particular_id}`
                            );
                            while (materialGridDiv.firstChild) {
                                materialGridDiv.removeChild(materialGridDiv.firstChild);
                            }
                            const laborGridDiv = document.querySelector(
                                `#laborBody_${particular_id}`
                            );
                            while (laborGridDiv.firstChild) {
                                laborGridDiv.removeChild(laborGridDiv.firstChild);
                            }
                            const equipmentGridDiv = document.querySelector(
                                `#equipmentBody_${particular_id}`
                            );
                            while (equipmentGridDiv.firstChild) {
                                equipmentGridDiv.removeChild(
                                    equipmentGridDiv.firstChild
                                );
                            }

                            // Create grids and pass particular_id as argument
                            const materialGridAPI = agGrid.createGrid(
                                materialGridDiv,
                                gridOptionsMaterial,
                                particular_id
                            );
                            const laborGridAPI = agGrid.createGrid(
                                laborGridDiv,
                                gridOptionsLabor,
                                particular_id
                            );
                            const equipmentGridAPI = agGrid.createGrid(
                                equipmentGridDiv,
                                gridOptionsEquipment,
                                particular_id
                            );

                            // Set rowData for each grid
                            const rowDataLabor = Object.values(
                                particular.details.Labor
                            );
                            const rowDataMaterial = Object.values(
                                particular.details.Materials,
                                particular.particular_id
                            );
                            const rowDataEquipment = Object.values(
                                particular.details.Equipment
                            );
                            materialGridAPI.setGridOption("rowData", rowDataMaterial);
                            laborGridAPI.setGridOption("rowData", rowDataLabor);
                            equipmentGridAPI.setGridOption("rowData", rowDataEquipment);
                        });

                    });

                    const updateThisData = totalAmountArray.find(item => item.particular_id === particularId);
                    const totalPartAmountSorted = updateThisData.totalPartAmount;


                    updateParticularTotal(particularId, totalPartAmountSorted);
                    const parseTotalPartAmount = parseFloat(totalPartAmountSorted)
                        .toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    $("#total_" + particularId).text(parseTotalPartAmount);
                },
            });
            $("#materialCard_" + particularId).removeClass("card");
            $("#laborCard_" + particularId).removeClass("card");
            $("#equipmentCard_" + particularId).removeClass("card");
        }

        function deleteDetail(detailType, partID) {
            console.log(detailType);
            console.log(partID);
            // Show confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to delete this record!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with delete operation
                    const data = {
                        _token: "{{ csrf_token() }}",
                        detailType: detailType,
                        partID: partID,
                    };
                    $.ajax({
                        url: "{{ url('delete-datails') }}",
                        type: "DELETE",
                        data: data,
                        success: function(response) {
                            console.log(response.message);
                            refreshAllData(parseInt(partID), detailType);
                            // Show success toast with delay
                            toastr.options.progressBar = true;
                            setTimeout(function() {
                                toastr.success("Deleted Successfully!");
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Handle error response
                        },
                    });
                }
            });
        }


        // Adding of Project Particular Material
        $("#addProjectPartMaterialForm").on("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission behavior
            // Get the selected project ID from localStorage
            var submitProjectID = localStorage.getItem("projectID");
            // Get form data
            let projectId = submitProjectID;
            let particularId = localStorage.getItem("particularId");
            let detail_type = 'Material';
            let materialId = $("#add_particular_materialID").val();
            if (materialId === "") {
                materialId = "empty";
            }

            let materialName = $("#add_particular_material").val();
            let materialQuantity = $(
                "#add_particular_materialQuantity"
            ).val();
            let materialCategory = $(
                "#add_particular_category"
            ).val();
            let materialUnit = $(
                "#add_particular_materialUnit"
            ).val();
            let materialQuarter = $(
                "#add_particular_materialQuarter"
            ).val();
            let materialYear = $(
                "#add_particular_materialYear"
            ).val();

            let materialPriceID = $(
                "#add_particular_priceID"
            ).val();
            let commaPrice = $(
                "#add_particular_materialPrice"
            ).val();

            // Remove the P and commas
            let materialPriceCleaned = commaPrice.replace('₱', '').replace(/,/g,
                '');
            let materialPrice = parseFloat(materialPriceCleaned);

            // Remove materialId from the data object if it's "empty"
            let data = {
                projectId: projectId,
                particularId: particularId,
                materialName: materialName,
                materialCategory: materialCategory,
                materialUnit: materialUnit,
                materialPrice: materialPrice,
                materialQuarter: materialQuarter,
                materialYear: materialYear,
                materialQuantity: materialQuantity,
                materialPriceID: materialPriceID,
                _token: "{{ csrf_token() }}",
            };
            if (materialId !== "empty") {
                data.materialId = materialId;
            } else if (materialId === "empty") {
                data.materialId = "empty"; // or assign any other appropriate value
            }

            // AJAX request
            $.ajax({
                url: "/submit-details",
                type: "POST",
                dataType: "json",
                data: data,
                success: function(response) {
                    $("#addProjectPartMaterialForm")[0].reset();
                    $("#addParticularMaterial").modal("hide");

                    refreshAllData(parseInt(particularId), detail_type);

                    toastr.options.progressBar = true;
                    console.log(response);
                    toastr.success("Material Added Successfully!");
                },
                error: function(xhr, status, error) {
                    // Handle error response from the server
                    console.error(
                        "Error submitting form data:",
                        xhr.responseText
                    );
                },
            });
        });

        // Submit the Particular Labor Modal Form
        $("#addProjectPartLaborForm").on("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            let submitProjectID = localStorage.getItem("projectID");
            let projectId = submitProjectID;
            let particularId = localStorage.getItem("particularId");
            let laborId = $("#add_particular_laborID").val();
            let laborRate = $('#add_particular_laborRate').val();
            let laborName = $("#add_particular_laborName").val();
            let noOfPerson = $("#add_particular_noOfPerson").val();
            let workDays = $("#add_particular_laborWorkDays").val();
            if (laborId === "") {
                laborId = "empty";
            }
            let data = {
                projectId: projectId,
                particularId: particularId,
                laborId: laborId,
                laborRate: laborRate,
                laborName: laborName,
                laborLocation: "maramag",
                noOfPerson: noOfPerson,
                workDays: workDays,
                _token: "{{ csrf_token() }}",
            }
            if (laborId !== "empty") {
                data.laborId = laborId;
            } else if (laborId === "empty") {
                data.laborId = "empty";
            }

            // AJAX request to submit labor details
            $.ajax({
                url: "/submit-details",
                type: "POST",
                dataType: "json",
                data: data,
                success: function(response) {
                    $("#addProjectPartLaborForm")[0].reset();
                    $("#addPartLaborModal").modal("hide");

                    refreshAllData(parseInt(particularId));

                    toastr.options.progressBar = true;
                    toastr.success("Labor Added Successfully!");
                },
                error: function(xhr, status, error) {
                    console.error(
                        "Error submitting form data:",
                        xhr.responseText
                    );
                },
            });
        });

        // Submit the Particular Equipment Modal Form
        $("#addProjectPartEquipmentForm").on(
            "submit",
            function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                var submitProjectID = localStorage.getItem("projectID");

                let projectId = submitProjectID;
                let particularId = localStorage.getItem("particularId");
                let equipmentId = $(
                    "#add_particular_EquipmentID"
                ).val();
                if (equipmentId === "") {
                    equipmentId = "empty";
                }

                let equipmentName = $(
                    "#add_particular_EquipmentName"
                ).val();
                let equipmentRate = $("#add_particular_EquipmentRate").val();
                let equipmentCategory = $("#add_particular_EquipmentCategory").val();
                let equipmentModel = $("#add_particular_EquipmentModel").val();
                let equipmentCapacity = $("#add_particular_EquipmentCapacity").val();
                let noOfUnit = $("#add_particular_noOfUnit").val();
                let equipmentWorkDays = $(
                    "#add_particular_EquipmentWorkDays"
                ).val();

                let data = {
                    projectId: projectId,
                    particularId: particularId,
                    equipmentId: equipmentId,
                    equipmentName: equipmentName,
                    equipmentRate: equipmentRate,
                    equipmentCategory: equipmentCategory,
                    equipmentModel: equipmentModel,
                    equipmentCapacity: equipmentCapacity,
                    noOfUnit: noOfUnit,
                    equipmentWorkDays: equipmentWorkDays,
                    // Add more form data fields here if needed
                    _token: "{{ csrf_token() }}",
                };
                if (equipmentId !== "empty") {
                    data.equipmentId = equipmentId;
                } else if (equipmentId === "empty") {
                    data.equipmentId = "empty";
                }


                // AJAX request to submit equipment details
                $.ajax({
                    url: "/submit-details",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function(response) {
                        $("#addProjectPartEquipmentForm")[0].reset();
                        $("#addPartEquipmentModal").modal("hide");

                        refreshAllData(parseInt(particularId));

                        toastr.options.progressBar = true;
                        toastr.success("Equipment Added Successfully!");
                    },
                    error: function(xhr, status, error) {
                        console.error(
                            "Error submitting form data:",
                            xhr.responseText
                        );
                    },
                });
            }
        );

        function addDetailBtn(particular_id, detailType) {
            localStorage.setItem("particularId", particular_id);
            console.log(particular_id);
            // Check the detailType
            if (detailType === "Material") {
                // Populate the Modal Particular Name
                $.ajax({
                    url: "/getAllData/master-list", // URL of the route for masterList function
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        // Extract materials from the Ajax response
                        var materials = response.materials;
                        // Get the select element and empty it
                        var materialSelect = $("#add_particular_material").empty();
                        $('#addProjectPartMaterialForm').trigger('reset');
                        // Add a default option
                        materialSelect.append(
                            $("<option>", {
                                value: "",
                                text: "Select Material",
                            })
                        );
                        // Populate select options with material names using jQuery chaining and map()
                        materialSelect.append(
                            materials.map(function(material) {
                                return $("<option>", {
                                    value: material.material_id,
                                    text: material.material_name,
                                });
                            })
                        );

                        $("#add_particular_material").select2({
                            theme: "bootstrap-5",
                            tags: true,
                            dropdownParent: $("#addParticularMaterial"),
                            placeholder: "Select Material", // Optional placeholder text
                            // allowClear: true, // Allow clearing the selection
                        });

                        // Add change event listener to the material select element
                        $("#add_particular_material").on("change", function() {
                            // Get the selected material id
                            var selectedMaterialId = parseInt($(this).val()); // Convert to integer

                            // Check if a material is selected
                            if (!isNaN(selectedMaterialId)) { // Check if it's a valid number
                                // Find the selected material data
                                var selectedMaterial = materials.find(function(material) {
                                    return material.material_id === selectedMaterialId;
                                });

                                // Check if selectedMaterial is defined
                                if (selectedMaterial) {
                                    // Populate category, unit, and price fields
                                    $("#add_particular_category").val(selectedMaterial
                                        .material_category_name);
                                    $("#add_particular_materialID").val(selectedMaterial
                                        .material_id);
                                    $("#add_particular_materialUnit").val(selectedMaterial
                                        .material_unit);
                                    $("#add_particular_materialPrice").val(selectedMaterial
                                        .material_price);
                                    $("#add_particular_materialQuarter").val(selectedMaterial
                                        .material_quarter);
                                    $("#add_particular_materialYear").val(selectedMaterial
                                        .material_year);

                                    $("#add_particular_priceID").val(selectedMaterial
                                        .material_price_id);

                                    initializePriceInputs();

                                    // Chnage readonly attributte of the form
                                    $("#add_particular_category").prop("readonly", true);
                                    $("#add_particular_materialUnit").prop("readonly", true);
                                    $("#add_particular_materialPrice").prop("readonly", true);
                                    $("#add_particular_materialQuarter").prop("readonly", true);
                                    $("#add_particular_materialYear").prop("readonly", true);
                                }
                            } else {
                                $("#add_particular_materialID").val("");
                                // remove readonly attribute from category, unit, and price fields
                                $("#add_particular_category").prop("readonly", false);
                                $("#add_particular_materialUnit").prop("readonly", false);
                                $("#add_particular_materialPrice").prop("readonly", false);
                                $("#add_particular_materialQuarter").prop("readonly", false);
                                $("#add_particular_materialYear").prop("readonly", false);
                                $("#add_particular_materialQuarter").val(quarter);
                                $("#add_particular_materialYear").val(year);
                            }
                        });

                        // Open Add Particular Material Modal
                        $("#addParticularMaterial").modal("show");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            } else if (detailType === "Labor") {
                $.ajax({
                    url: "/getAllData/master-list", // URL of the route for masterList function
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        var labors = response.labors; // Extract labor data from the AJAX response

                        // Get the select element and empty it
                        var laborSelect = $("#add_particular_laborName").empty();

                        // Add a default option
                        laborSelect.append(
                            $("<option>", {
                                value: "",
                                text: "Select Labor",
                            })
                        );

                        // Populate select options with labor names using jQuery chaining and map()
                        laborSelect.append(
                            labors.map(function(labor) {
                                return $("<option>", {
                                    value: labor.labor_id,
                                    text: labor.labor_name,
                                });
                            })
                        );

                        $("#add_particular_laborName").select2({
                            tags: true,
                            theme: "bootstrap-5",
                            dropdownParent: $("#addPartLaborModal"),
                            placeholder: "Select Labor Name", // Optional placeholder text
                            // allowClear: true, // Allow clearing the selection
                        });

                        // Open Add Particular Labor Modal
                        $("#addPartLaborModal").modal("show");

                        // Add change event listener to the labor select element
                        $("#add_particular_laborName").on("change", function() {
                            var selectedLaborId = parseInt($(this).val());

                            if (!isNaN(selectedLaborId)) {
                                var selectedLabor = labors.find(function(labor) {
                                    return labor.labor_id == selectedLaborId;
                                });

                                if (selectedLabor) {
                                    // Populate fields with selected labor data
                                    $("#add_particular_laborLocation").val(
                                        selectedLabor.labor_location
                                    );
                                    $("#add_particular_laborID").val(
                                        selectedLabor.labor_id
                                    );
                                    $("#add_particular_laborRate").val(
                                        selectedLabor.labor_rate
                                    );
                                    $("#add_particular_laborWorkDays").val(
                                        selectedLabor.labor_workdays
                                    );

                                    // Chnage readonly attributte of the form
                                    $("#add_particular_laborRate").prop("readonly", true);
                                }
                            } else {
                                $("#add_particular_laborID").val("");
                                $("#add_particular_laborRate").prop("readonly", false);
                            }
                            // You may need to adjust the above lines based on the actual structure of your labor data
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            } else if (detailType === "Equipment") {
                $.ajax({
                    url: "/getAllData/master-list", // URL of the route for masterList function
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        var equipments = response
                            .equipments; // Extract equipment data from the AJAX response

                        // Get the select element and empty it
                        var equipmentSelect = $(
                            "#add_particular_EquipmentName"
                        ).empty();

                        // Add a default option
                        equipmentSelect.append(
                            $("<option>", {
                                value: "",
                                text: "Select Equipment",
                            })
                        );

                        // Populate select options with equipment names using jQuery chaining and map()
                        equipmentSelect.append(
                            equipments.map(function(equipment) {
                                return $("<option>", {
                                    value: equipment.equipment_id,
                                    text: equipment.equipment_name,
                                });
                            })
                        );

                        $("#add_particular_EquipmentName").select2({
                            theme: "bootstrap-5",
                            tags: true,
                            dropdownParent: $("#addPartEquipmentModal"),
                            placeholder: "Select Equipment Name", // Optional placeholder text
                            // allowClear: true, // Allow clearing the selection
                        });

                        // Add change event listener to the labor select element
                        $("#add_particular_EquipmentName").on("change", function() {
                            var selectedEquipmentId = parseInt($(this).val());

                            if (!isNaN(selectedEquipmentId)) {
                                var selectedEquipment = equipments.find(function(
                                    equipment
                                ) {
                                    return equipment.equipment_id == selectedEquipmentId;
                                });

                                if (selectedEquipment) {
                                    // Populate fields with selected labor data
                                    $("#add_particular_EquipmentRate").val(
                                        selectedEquipment.equipment_rate);
                                    $("#add_particular_EquipmentCategory").val(
                                        selectedEquipment.equipment_category_name);
                                    $("#add_particular_EquipmentModel").val(
                                        selectedEquipment.equipment_model);
                                    $("#add_particular_EquipmentCapacity").val(
                                        selectedEquipment.equipment_capacity);
                                    $("#add_particular_EquipmentID").val(
                                        selectedEquipment.equipment_id);
                                    // Chnage readonly attributte of the form
                                    $("#add_particular_EquipmentRate").prop('readonly', true);
                                    $("#add_particular_EquipmentCategory").prop('readonly', true);
                                    $("#add_particular_EquipmentModel").prop('readonly', true);
                                    $("#add_particular_EquipmentCapacity").prop('readonly', true);
                                }
                            } else {
                                $("#add_particular_EquipmentID").val("");
                                // Populate fields with selected labor data
                                $("#add_particular_EquipmentRate").prop('readonly', false);
                                $("#add_particular_EquipmentCategory").prop('readonly', false);
                                $("#add_particular_EquipmentModel").prop('readonly', false);
                                $("#add_particular_EquipmentCapacity").prop('readonly', false);
                            }
                        });

                        // Open Add Particular Equipment Modal
                        $("#addPartEquipmentModal").modal("show");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            } else {
                // Handle other cases
            }
        }




        $("#projectDetailsForm").submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Gather form data
            let projectID = $("#add_project_id").val();
            let projectTitle = $("#add_project_title").val();
            let projectLocation = $("#add_project_location").val();
            let projectOwner = $("#add_project_owner").val();
            let projectDescription = $("#add_project_description").val();
            let contactDuration = $("#add_project_contract_duration").val();
            let appropriation = $("#add_project_appropriation").val();
            let sourceOfFund = $("#add_project_source_of_fund").val();
            let datePrepared = $("#add_project_date_prepared").val();
            let modeOfImplementation = $("#add_project_mode_of_implementation").val();
            let ocm = $("#add_project_ocm").val();
            let cp = $("#add_project_contractProfit").val();
            let vat = $("#add_project_vat").val();

            // Remove the P and commas
            let projectCostCleaned = appropriation.replace('₱', '').replace(/,/g,
                '');
            let projectCost = parseFloat(projectCostCleaned);
            console.log(projectCost);

            // Send Ajax request
            $.ajax({
                url: "{{ route('getAllData.store') }}",
                type: "POST",
                data: {
                    add_project_id: projectID,
                    add_project_title: projectTitle,
                    add_project_location: projectLocation,
                    add_project_owner: projectOwner,
                    add_project_description: projectDescription,
                    add_project_contract_duration: contactDuration,
                    add_project_appropriation: projectCost,
                    add_project_source_of_fund: sourceOfFund,
                    add_project_date_prepared: datePrepared,
                    add_project_mode_of_implementation: modeOfImplementation,
                    add_project_ocm: ocm,
                    add_project_cp: cp,
                    add_project_vat: vat,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Reset the form
                    // $("#projectDetailsForm")[0].reset();
                    getProjects();

                    toastr.options.progressBar = true;
                    toastr.success("Project Updated Successfully!");
                    // Request succeeded, do something with the response if needed
                    console.log("Success Response:", response);
                },
                error: function(xhr, status, error) {
                    // Request failed
                    console.error("Request failed. Status:", status);
                    console.error("Error:", error);
                    console.error("Response Text:", xhr.responseText);
                },
            });
        });

        function deleteParticular(projectParticularId) {
            // Display confirmation dialog
            Swal.fire({
                title: 'Confirm Project Item Deletion',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with deletion
                    $.ajax({
                        url: "{{ url('projectParticulars') }}/" + projectParticularId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Refresh the page
                            window.location.reload();

                            // Show toastr notification for successful deletion
                            toastr.success('Project particular deleted successfully.');
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            alert("Error: " + error);
                        }
                    });
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Code to execute when the DOM is fully loaded
            const sortable = new Sortable(document.getElementById('projectParticularContent'), {
                group: 'shared', // set both lists to the same group
                animation: 150
            });

            // Function to update Roman numerals
            function updateRomanNumerals() {
                const listItems = document.querySelectorAll('#projectParticularContent .numeralPartName');
                listItems.forEach((item, index) => {
                    const romanNumeral = intToRoman(index +
                        1); // Adding 1 to index to match 1-based indexing
                    const spanElement = item.querySelector('span'); // Get the span element inside h5
                    if (spanElement) {
                        spanElement.textContent = romanNumeral; // Set the Roman numeral as the span's text
                    }
                });
            }

            // Function to save the order of list items in local storage
            function saveOrder() {
                const listItems = document.querySelectorAll('#projectParticularContent .numeralPartName');
                const order = Array.from(listItems).map(item => ({
                    id: item.id,
                    text: item.textContent
                }));
                localStorage.setItem('sortableOrder', JSON.stringify(order));
                console.log('Saved Sorted order saved locally:', order);
            }

            // Function to load the order of list items from local storage
            function loadOrder() {
                const order = JSON.parse(localStorage.getItem('sortableOrder'));
                if (order) {
                    const listItems = document.querySelectorAll('#projectParticularContent .numeralPartName');
                    listItems.forEach((item, index) => {
                        item.textContent = order[index];
                    });
                }
            }

            // Initialize Roman numerals
            function intToRoman(num) {
                const romanNumerals = [{
                        value: 100,
                        numeral: "C"
                    },
                    {
                        value: 50,
                        numeral: "L"
                    },
                    {
                        value: 10,
                        numeral: "X"
                    },
                    {
                        value: 9,
                        numeral: "IX"
                    },
                    {
                        value: 5,
                        numeral: "V"
                    },
                    {
                        value: 4,
                        numeral: "IV"
                    },
                    {
                        value: 1,
                        numeral: "I"
                    }
                ];
                let result = '';
                romanNumerals.forEach(({
                    value,
                    numeral
                }) => {
                    while (num >= value) {
                        result += numeral;
                        num -= value;
                    }
                });
                return result + ". ";
            }

            // Call updateRomanNumerals() initially
            updateRomanNumerals();

            // Listen for SortableJS events
            sortable.option("onEnd", function(evt) {
                saveOrder();
                updateRomanNumerals();
            });
        });



        function initializePriceInputs() {
            const priceInputs = document.querySelectorAll('.price-input');
            priceInputs.forEach(input => {
                const mask = IMask(input, {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: ',',
                    padFractionalZeros: true,
                    normalizeZeros: true,
                    radix: '.',
                    mapToRadix: ['.'],
                    min: 0
                });
            });
        }
    </script>
    <!-- /.content -->
@endsection
