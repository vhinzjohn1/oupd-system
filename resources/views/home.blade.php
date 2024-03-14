@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Projects') }}</h1>
                    <div class="text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" id="addProjectButton">
                            Add Projects
                        </button>
                    </div>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card vh-75">
                    <div class="card-body table-responsive">
                        <table class="table col-12" id="projectTable">
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
        </div><!-- /.container-fluid -->


        {{-- Container for Project Particular Table --}}
        <div class="container-fluid">
            <div class="card" style="box-shadow: 0px 0px 10px 1px grey">
                <div class="text-right p-3">
                    <button type="button" class="btn btn-success" id="addParticularBtn">Add Particular</button>
                </div>
                <div class="col-lg-12 d-flex m-1">
                    <table id="projectParticularTable" class="table" border="2">
                        <thead>
                        </thead>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
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
            // Initialize DataTable
            $("#projectTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
            }).buttons().container().appendTo('#projectTable_wrapper .col-md-6:eq(0)');



            // Call the function to fetch and populate data in the table
            refreshProjectsTable();

            // Refresh Project Particular Table
            refreshProjectParticularTable();
            refreshProjectParticularMLE();

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

        // function refreshProjectParticularTable() {
        //     var jsonData = {
        //         "projects": [{
        //             "title": "COE Building",
        //             "particulars": [{
        //                     "name": "Embankment",
        //                     "details": {
        //                         "Materials": [{
        //                             "name": "Washed Sand",
        //                             "quantity": 100
        //                         }, {
        //                             "name": "Gravel",
        //                             "quantity": 200
        //                         }],
        //                         "Labor": [{
        //                             "name": "Foreman",
        //                             "work_days": 12
        //                         }, {
        //                             "name": "Panday",
        //                             "work_days": 10
        //                         }],
        //                         "Equipment": [{
        //                             "name": "Excavators",
        //                             "work_days": 13
        //                         }, {
        //                             "name": "Truck",
        //                             "work_days": 25
        //                         }]
        //                     }
        //                 },
        //                 {
        //                     "name": "Pavements",
        //                     "details": {
        //                         "Materials": [{
        //                             "name": "Washed Sand",
        //                             "quantity": 150
        //                         }, {
        //                             "name": "Gravel",
        //                             "quantity": 250
        //                         }],
        //                         "Labor": [{
        //                             "name": "Foreman",
        //                             "work_days": 8
        //                         }, {
        //                             "name": "Panday",
        //                             "work_days": 8
        //                         }],
        //                         "Equipment": [{
        //                             "name": "Excavators",
        //                             "work_days": 8
        //                         }, {
        //                             "name": "Truck",
        //                             "work_days": 8
        //                         }]
        //                     }
        //                 },
        //                 {
        //                     "name": "Concrete Pavers",
        //                     "details": {
        //                         "Materials": [{
        //                             "name": "Washed Sand",
        //                             "quantity": 120
        //                         }, {
        //                             "name": "Gravel",
        //                             "quantity": 220
        //                         }],
        //                         "Labor": [{
        //                             "name": "Foreman",
        //                             "work_days": 8
        //                         }, {
        //                             "name": "Panday",
        //                             "work_days": 8
        //                         }],
        //                         "Equipment": [{
        //                             "name": "Excavators",
        //                             "work_days": 8
        //                         }, {
        //                             "name": "Truck",
        //                             "work_days": 8
        //                         }]
        //                     }
        //                 }
        //             ]
        //         }]
        //     };

        //     // Clear the existing table content
        //     var table = $('#projectParticularTable');
        //     table.empty();

        //     // Loop through the JSON data and populate the table
        //     jsonData.projects.forEach(function(project) {
        //         var projectHeaderRow = $('<tr class="bg-navy"><th class="text-center col-12" colspan="3">' + project
        //             .title + '</th></tr>');
        //         table.append(projectHeaderRow);

        //         project.particulars.forEach(function(particular) {
        //             var particularHeaderRow = $(
        //                 '<tr class="bg-gray-dark"><th class="text-center col-12" colspan="3">' +
        //                 particular.name + '</th></tr>');
        //             table.append(particularHeaderRow);

        //             // Create header row for Materials, Labor, and Equipment
        //             var headerRow = $('<tr></tr>');
        //             headerRow.append(
        //                 '<td class="bg-olive"><div class="d-flex justify-content-between bg-olive"><span>Materials</span><span>Qty</span></div></td>'
        //             );
        //             headerRow.append(
        //                 '<td class="bg-olive"><div class="d-flex justify-content-between bg-olive"><span>Labor</span><span>Days</span></div></td>'
        //             );
        //             headerRow.append(
        //                 '<td class="bg-olive"><div class="d-flex justify-content-between bg-olive"><span>Equipment</span><span>Days</span></div></td>'
        //             );
        //             table.append(headerRow);

        //             // Iterate over details and add rows for each value
        //             var maxValues = Math.max(particular.details.Materials.length, particular.details.Labor
        //                 .length, particular.details.Equipment.length);
        //             for (var i = 0; i < maxValues; i++) {
        //                 var detailRow = $('<tr></tr>');
        //                 var materialsSpan = '<span>' + ((particular.details.Materials[i] && particular
        //                     .details.Materials[i].name) || '') + '</span>';
        //                 var laborSpan = '<span>' + ((particular.details.Labor[i] && particular.details
        //                     .Labor[i].name) || '') + '</span>';
        //                 var equipmentSpan = '<span>' + ((particular.details.Equipment[i] && particular
        //                     .details.Equipment[i].name) || '') + '</span>';
        //                 var materialsQtySpan = '<span>' + ((particular.details.Materials[i] && particular
        //                     .details.Materials[i].quantity) || '') + '</span>';
        //                 var laborHrsSpan = '<span>' + ((particular.details.Labor[i] && particular.details
        //                     .Labor[i].work_days) || '') + '</span>';
        //                 var equipmentHrsSpan = '<span>' + ((particular.details.Equipment[i] && particular
        //                     .details.Equipment[i].work_days) || '') + '</span>';

        //                 var materialsDiv = '<div class="d-flex justify-content-between">' + materialsSpan +
        //                     materialsQtySpan + '</div>';
        //                 var laborDiv = '<div class="d-flex justify-content-between">' + laborSpan +
        //                     laborHrsSpan + '</div>';
        //                 var equipmentDiv = '<div class="d-flex justify-content-between">' + equipmentSpan +
        //                     equipmentHrsSpan + '</div>';

        //                 detailRow.append('<td>' + materialsDiv + '</td>');
        //                 detailRow.append('<td>' + laborDiv + '</td>');
        //                 detailRow.append('<td>' + equipmentDiv + '</td>');
        //                 table.append(detailRow);
        //             }

        //         });
        //     });
        // }




        function refreshProjectParticularTable() {
            // Make an AJAX request to fetch the formatted data
            $.ajax({
                url: '/formatted-data',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var table = $('#projectParticularTable');
                    table.empty();
                    // Loop through the JSON data and populate the table
                    response.projects.forEach(function(project) {
                        var projectHeaderRow = $(
                            '<tr class="" style="background-color: #00491E; color: white;"><th class="text-center col-12" colspan="3">' +
                            project
                            .title + '</th></tr>');
                        table.append(projectHeaderRow);

                        project.particulars.forEach(function(particular) {
                            var particularHeaderRow = $(
                                '<tr class="bg-gray-dark"><th class="text-center col-12" colspan="3">' +
                                particular.name + '</th></tr>');
                            table.append(particularHeaderRow);

                            // Create header row for Materials, Labor, and Equipment
                            var headerRow = $('<tr></tr>');
                            headerRow.append(
                                '<td class="bg-olive"><div class="d-flex justify-content-between bg-olive"><span>Materials</span><span>Qty</span></div></td>'
                            );
                            headerRow.append(
                                '<td class="bg-olive"><div class="d-flex justify-content-between bg-olive"><span>Labor</span><span>Days</span></div></td>'
                            );
                            headerRow.append(
                                '<td class="bg-olive"><div class="d-flex justify-content-between bg-olive"><span>Equipment</span><span>Days</span></div></td>'
                            );
                            table.append(headerRow);

                            // Iterate over details and add rows for each value
                            var maxValues = Math.max(particular.details.Materials.length,
                                particular.details.Labor
                                .length, particular.details.Equipment.length);
                            for (var i = 0; i < maxValues; i++) {
                                var detailRow = $('<tr></tr>');
                                var materialsSpan = '<span>' + ((particular.details.Materials[
                                        i] && particular
                                    .details.Materials[i].name) || '') + '</span>';
                                var laborSpan = '<span>' + ((particular.details.Labor[i] &&
                                    particular.details
                                    .Labor[i].name) || '') + '</span>';
                                var equipmentSpan = '<span>' + ((particular.details.Equipment[
                                        i] && particular
                                    .details.Equipment[i].name) || '') + '</span>';
                                var materialsQtySpan = '<span>' + ((particular.details
                                    .Materials[i] && particular
                                    .details.Materials[i].quantity) || '') + '</span>';
                                var laborHrsSpan = '<span>' + ((particular.details.Labor[i] &&
                                    particular.details
                                    .Labor[i].work_days) || '') + '</span>';
                                var equipmentHrsSpan = '<span>' + ((particular.details
                                    .Equipment[i] && particular
                                    .details.Equipment[i].work_days) || '') + '</span>';

                                var materialsDiv =
                                    '<div class="d-flex justify-content-between">' +
                                    materialsSpan +
                                    materialsQtySpan + '</div>';
                                var laborDiv = '<div class="d-flex justify-content-between">' +
                                    laborSpan +
                                    laborHrsSpan + '</div>';
                                var equipmentDiv =
                                    '<div class="d-flex justify-content-between">' +
                                    equipmentSpan +
                                    equipmentHrsSpan + '</div>';

                                detailRow.append('<td>' + materialsDiv + '</td>');
                                detailRow.append('<td>' + laborDiv + '</td>');
                                detailRow.append('<td>' + equipmentDiv + '</td>');
                                table.append(detailRow);
                            }

                        });
                    });

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                }
            });
        }


        // Refresh Function for Projects Table
        function refreshProjectsTable() {
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
                            `<button type="button" id="editProjectButton" class="btn bg-gradient-success mr-2" data-id="${project.project_id}" onclick="viewProjectModal(${project.project_id}, '${project.project_title}', '${project.project_location}', '${project.project_owner}', '${project.unit_office}', '${project.project_description}', '${project.project_contract_duration}', '${project.project_date_prepared}', '${project.project_target_start_date}', '${project.project_appropriation}', '${project.project_source_of_fund}', '${project.project_mode_of_implementation}')"><i class="fa fa-eye" aria-hidden="true"></i></button>` +
                            `<button type="button" id="selectProjectButton" class="btn btn-success mr-2" data-id="${project.project_id}" onclick="selectProject(${project.project_id}, '${project.project_title}')" > Select </button>` +
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

        function selectProject(project_id, project_title) {
            // Save the selected project_id and project_title in localStorage
            // Save project_id and project_title to local storage
            localStorage.setItem('projectID', project_id);
            localStorage.setItem('projectTitle', project_title);


            // Show SweetAlert2 popup
            Swal.fire({
                title: `${project_title}  Selected`,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }

        function viewProjectModal(project_id, projectTitle, projectLocation, projectOwner, unitOffice,
            projectDescription,
            projectContractDuration, projectDatePrepared, projectTargetStartDate, projectAppropriation, projectSourceOfFund,
            projectModeOfImplementation) {
            console.log(project_id)
            // Populate modal fields with passed values
            $('#view_project_id').val(project_id);
            $('#view_project_title').val(projectTitle);
            $('#view_project_location').val(projectLocation);
            $('#view_project_owner').val(projectOwner);
            $('#view_unit_office').val(unitOffice);
            $('#view_project_description').val(projectDescription);
            $('#view_project_contract_duration').val(projectContractDuration);
            $('#view_project_date_prepared').val(projectDatePrepared);
            $('#view_project_target_start_date').val(projectTargetStartDate);
            $('#view_project_appropriation').val(projectAppropriation);
            $('#view_project_source_of_fund').val(projectSourceOfFund);
            $('#view_project_mode_of_implementation').val(projectModeOfImplementation);

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
                let office = $('#add_unit_office').val();
                let description = $('#add_project_description').val();
                let contractDuration = $('#add_project_contract_duration').val();
                let datePrepared = $('#add_project_date_prepared').val();
                let targetStartDate = $('#add_project_target_start_date').val();
                let appropriation = $('#add_project_appropriation').val();
                let sourceOfFund = $('#add_project_source_of_fund').val();
                let modeOfImplementation = $('#add_project_mode_of_implementation').val();


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
                            $('#addProjectModal').modal('hide');

                            // //setting callback function for 'hidden.bs.modal' event
                            // $('#addProjectModal').on('hidden.bs.modal', function() {
                            //     //remove the backdrop
                            //     $('.modal-backdrop').remove();
                            // })

                            console.log('successfully added');

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
                let office = $('#view_unit_office').val();
                let description = $('#view_project_description').val();
                let contractDuration = $('#view_project_contract_duration').val();
                let datePrepared = $('#view_project_date_prepared').val();
                let targetStartDate = $('#view_project_target_start_date').val();
                let appropriation = $('#view_project_appropriation').val();
                let sourceOfFund = $('#view_project_source_of_fund').val();
                let modeOfImplementation = $('#view_project_mode_of_implementation').val();

                // Make AJAX request to update the project
                $.ajax({
                    url: "{{ route('project.update', ['id' => ':id']) }}".replace(':id',
                        projectId),
                    type: "PUT", // Assuming you are using PUT method for update, change it if needed
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


        // Initialized Tom Select To Materials
        const materialSelect = new TomSelect('#add_project_particular_material_name', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="material-item-index"></span><span class="item-text"> : ${escape(data.text)}</span> </div>`;
                }
            }
        });

        const materialQuantitySelect = new TomSelect('#add_project_particular_material_quantity', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="material-quantity-item-index"></span><span class="item-text">  : ${escape(data.text)} </span></div>`;
                }
            },

        });
        // End Initialized Tom Select To Materials


        // Initialized Tom Select To labors
        const laborSelect = new TomSelect('#add_project_particular_labor_name', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="labor-item-index"></span> <span class="item-text">  : ${escape(data.text)}</span> </div>`;
                }
            }
        });

        const laborNopSelect = new TomSelect('#add_project_particular_labor_no_of_person', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="labor-nop-item-index"></span> <span class="item-text">  : ${escape(data.text)}</span></div>`;
                }
            }
        });

        const laborWorkDaysSelect = new TomSelect('#add_project_particular_labor_work_days', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="labor-workDays-item-index"></span> <span class="item-text"> : ${escape(data.text)}</span> </div>`;
                }
            }
        });
        // End of Labor Initialized Tom Select


        // Initialized Equipment Tom Select
        const equipmentSelect = new TomSelect('#add_project_particular_equipment_name', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="equipment-item-index"></span><span class="item-text"> : ${escape(data.text)}</span> </div>`;
                }
            }
        });

        const equipmentNoUSelect = new TomSelect('#add_project_particular_equipment_no_of_units', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="equipment-Nou-item-index"></span><span class="item-text"> : ${escape(data.text)}</span> </div>`;
                }
            }
        });

        const equipmentWorkDaysSelect = new TomSelect('#add_project_particular_equipment_work_days', {
            plugins: ['clear_button'],
            create: true,
            duplicates: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                item: function(data, escape) {
                    return `<div><span class="equipment-workDays-item-index"></span><span class="item-text"> : ${escape(data.text)}</span> </div>`;
                }
            }
        });

        // Function to Dynamically Change Index Material
        function updateMaterialItemIndices() {
            const itemElements = document.querySelectorAll('.material-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }

        function updateMaterialQuantityItemIndices() {
            const itemElements = document.querySelectorAll('.material-quantity-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} :  `;
            });
        }
        // End Function to Dynamically Change Index Material


        // Function to Dynamically Change Index Labor
        function updateLaborItemIndices() {
            const itemElements = document.querySelectorAll('.labor-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }

        function updateLaborNopItemIndices() {
            const itemElements = document.querySelectorAll('.labor-nop-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }

        function updateLaborWorkDaysItemIndices() {
            const itemElements = document.querySelectorAll('.labor-workDays-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }
        // End Function to Dynamically Change Index Labor

        // Function to Dynamimcaly Change Index Equipments
        function updateEquipmentItemIndices() {
            const itemElements = document.querySelectorAll('.equipment-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }

        function updateEquipmentNouItemIndices() {
            const itemElements = document.querySelectorAll('.equipment-Nou-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }

        function updateEquipmentWorkDaysItemIndices() {
            const itemElements = document.querySelectorAll('.equipment-workDays-item-index');
            itemElements.forEach((itemElement, index) => {
                itemElement.textContent = `Item ${index + 1} : `;
            });
        }

        // Material Select Event listener
        materialSelect.on('item_add', updateMaterialItemIndices);
        materialSelect.on('item_remove', updateMaterialItemIndices);

        materialQuantitySelect.on('item_add', updateMaterialQuantityItemIndices);
        materialQuantitySelect.on('item_remove', updateMaterialQuantityItemIndices);
        // End of Material Select Event Listener

        //  Labor Select Event Listener
        laborSelect.on('item_add', updateLaborItemIndices);
        laborSelect.on('item_remove', updateLaborItemIndices);

        laborNopSelect.on('item_add', updateLaborNopItemIndices);
        laborNopSelect.on('item_remove', updateLaborNopItemIndices);

        laborWorkDaysSelect.on('item_add', updateLaborWorkDaysItemIndices);
        laborWorkDaysSelect.on('item_remove', updateLaborWorkDaysItemIndices);
        // End of Labor Select Event Listener


        // Equipment Select Event Listener
        equipmentSelect.on('item_add', updateEquipmentItemIndices);
        equipmentSelect.on('item_remove', updateEquipmentItemIndices);

        equipmentNoUSelect.on('item_add', updateEquipmentNouItemIndices);
        equipmentNoUSelect.on('item_remove', updateEquipmentNouItemIndices);

        equipmentWorkDaysSelect.on('item_add', updateEquipmentWorkDaysItemIndices);
        equipmentWorkDaysSelect.on('item_remove', updateEquipmentWorkDaysItemIndices);



        // Event listener for the Combine Values button
        document.getElementById('CombineValuesButton').addEventListener('click', function() {
            const selectedValuesMaterial = materialSelect.getValue(); // Get the selected values for materials
            const selectedMaterials = selectedValuesMaterial.map((value, index) => {
                const item = materialSelect.options[value];
                const quantityValue = materialQuantitySelect.getValue()[
                    index]; // Get the quantity value based on index
                return {
                    material_id: item.value,
                    material_name: item.text,
                    quantity: quantityValue ? quantityValue :
                        null // Include quantity in the selected material object
                };
            });

            const selectedValuesLabor = laborSelect.getValue(); // Get the selected values for labor
            const selectedLabor = selectedValuesLabor.map((value, index) => {
                const item = laborSelect.options[value];
                const nopValue = laborNopSelect.getValue()[
                    index]; // Get the number of persons value based on index
                const workDaysValue = laborWorkDaysSelect.getValue()[
                    index]; // Get the work days value based on index
                return {
                    labor_id: item.value,
                    labor_name: item.text,
                    number_of_persons: nopValue ? nopValue : null,
                    work_days: workDaysValue ? workDaysValue : null
                };
            });

            const selectedValuesEquipment = equipmentSelect.getValue(); // Get the selected values for equipment
            const selectedEquipment = selectedValuesEquipment.map((value, index) => {
                const item = equipmentSelect.options[value];
                const nouValue = equipmentNoUSelect.getValue()[
                    index]; // Get the number of units value based on index
                const workDaysValue = equipmentWorkDaysSelect.getValue()[
                    index]; // Get the work days value based on index
                return {
                    equipment_id: item.value,
                    equipment_name: item.text,
                    number_of_units: nouValue ? nouValue : null,
                    work_days: workDaysValue ? workDaysValue : null
                };
            });

            // Combine all selected values into one object
            const combinedValues = {
                materials: selectedMaterials,
                labors: selectedLabor,
                equipments: selectedEquipment
            };

            console.log(combinedValues); // Log the combined values
        });
    </script>
@endsection
