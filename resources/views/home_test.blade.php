@extends('layouts.app')
@section('content')

    <head>
        <style>
            .form-group>label {
                bottom: 34px;
                left: 10px;
                position: relative;
                background-color: white;
                padding: 0px 3px 0px 3px;
                font-size: 0.8em;
                transition: 0.25s;
                pointer-events: none;
            }

            .form-control:focus~label {
                bottom: 55px;
            }

            .form-control:valid~label {
                bottom: 55px;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>



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
                    <div class="card-body">
                        <div class="row">
                            <div class="row mt-4 col-12">
                                <div class="col-6">
                                    <div class="form-group margin-top">
                                        <input type="hidden" id="add_project_id">
                                        <input type="text" class="form-control" id="add_project_title" required>
                                        <label for="add_project_title">Project Title</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_location" required>
                                        <label for="add_project_location">Location</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_owner" required>
                                        <label for="add_project_owner">Owner</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_unit_office" required>
                                        <label for="add_unit_office">Unit Office</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_description" required>
                                        <label for="add_project_description">Project Description</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_contract_duration"
                                            name="add_project_contract_duration" required>
                                        <label for="add_project_contract_duration">Contract Duration</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_appropriation"
                                            name="add_project_appropriation" required>
                                        <label for="add_project_appropriation">Project Appropriation</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <select type="text" class="form-control" id="add_project_source_of_fund"
                                            name="add_project_source_of_fund" placeholder="Project Source of Fund" required>
                                            <option value=""></option>
                                            <option value="General Fund">General Fund</option>
                                            <option value="Trust Fund">Trust Fund</option>
                                            <option value="Special Trust Fund">Special Trust Fund</option>
                                            <option value="RGMO">RGMO</option>
                                        </select>
                                        <label for="add_project_source_of_fund">Project Source Of
                                            Fund</label>
                                    </div>
                                    <div class="form-group margin-top mt-2">
                                        <input type="date" class="form-control" id="add_project_date_prepared"
                                            name="add_project_date_prepared">
                                        <label for="add_project_date_prepared">Project Date Prepared</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="date" class="form-control" id="add_project_target_start_date"
                                            name="add_project_target_start_date">
                                        <label for="add_project_target_start_date">Project Target Start Date</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_mode_of_implementation"
                                            name="add_project_mode_of_implementation" required>
                                        <label for="add_project_mode_of_implementation">Project Mode of
                                            Implementation</label>
                                    </div>
                                    <div class="modal-footer col-12">
                                        <div class="btn btn-success col-12">Save Changes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./ Project Card  --->
            <!-- Your Blade view with JavaScript -->


            {{-- For testing purposess --}}
            <div class="container-fluid mt-3">
                <h4>Project Particular</h4>
                <div id="projectParticularContent" class="container-fluid col-12 d-flex flex-column"></div>
            </div>
            <div class="btn btn-success" id="addParticularBtn">Add Particular</div>
        </div>



        <script>
            getProjects();

            var selectedProjectTitle = localStorage.getItem('projectTitle');

            // Check if selectedProjectTitle has a value
            if (selectedProjectTitle) {
                $('#ProjectHeader').text('View Project Details');
            }

            $.ajax({
                url: "{{ route('getAllData.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var selectedProjectID = localStorage.getItem('projectID');
                    // Filter and sort project items
                    var sortedProjects = data.projects.filter(function(project) {
                        return project.project_id == selectedProjectID;
                    });
                    // Iterate through each filtered project item
                    sortedProjects.forEach(function(project) {
                        // Iterate through each particular item
                        project.particulars.forEach(function(particular) {
                            // Create a new main card for each particular
                            var mainCard = $('<div class="card" id="mainCardProjectParticular">');
                            var cardHeader = $(
                                '<div class="card-header header-hover" data-toggle="collapse" data-target="#projectPart' +
                                particular.particular_id + '">');
                            var cardCollapse = $('<div class="collapse">').attr('id',
                                'projectPart' + particular.particular_id);
                            var cardBody = $('<div class="card-body col-12">');
                            var row = $('<div class="row">');
                            var col1 = $('<div class="col-1">');
                            var col11 = $('<div class="col-11">');

                            // Set up the card header
                            var headerContent = $('<div class="d-flex justify-content-between">');
                            var title = $('<h5>').text(particular.particular_name);
                            var cardTools = $('<div class="card-tools">');
                            var collapseButton = $('<button type="button" class="btn btn-tool">')
                                .html('<i class="fas fa-minus"></i>');

                            // Append elements to the header
                            headerContent.append(title, cardTools.append(collapseButton));
                            cardHeader.append(headerContent);

                            // Set up the dropdown for adding details
                            var dropdownButton = $(
                                    '<button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">'
                                )
                                .html(
                                    '<i class="fa fa-plus"></i><span class="sr-only">Toggle Dropdown</span>'
                                );
                            var dropdownMenu = $('<div class="dropdown-menu" role="menu">');

                            // Create dropdown options
                            var detailTypes = ['Material', 'Labor', 'Equipment'];
                            detailTypes.forEach(function(detail) {
                                var dropdownItem = $(
                                    '<a class="dropdown-item select-details" href="#" data-details="' +
                                    detail + '">').text(detail);
                                dropdownMenu.append(dropdownItem);
                            });

                            // Append dropdown to the card
                            col1.append($('<div class="btn-group">').append(dropdownButton,
                                dropdownMenu));

                            // Set up the cards for Material, Labor, and Equipment
                            var materialCard = createDetailCard('Material', particular
                                .particular_id);
                            var laborCard = createDetailCard('Labor', particular.particular_id);
                            var equipmentCard = createDetailCard('Equipment', particular
                                .particular_id);

                            // Append cards to the col11 container
                            col11.append(materialCard, laborCard, equipmentCard);

                            // Append col1 and col11 to the row
                            row.append(col1, col11);

                            // Append row to the card body
                            cardBody.append(row);

                            // Append card body to the collapse container
                            cardCollapse.append(cardBody);

                            // Append card header and collapse container to the main card
                            mainCard.append(cardHeader, cardCollapse);

                            // Append main card to the dynamic content container
                            $('#projectParticularContent').append(mainCard);
                        });
                    });
                }
            });

            // Keep track of particular_ids for which MaterialsTable has been called
            var initializedParticulars = [];

            // Function to create detail cards
            function createDetailCard(detailType, particular_id) {
                var card = $('<div class="card" id="' + detailType.toLowerCase() + 'Card">');
                var cardHeader = $('<div class="card-header d-flex justify-content-between col-12">');
                var headerContent = $('<div class="d-flex justify-content-between col-12">');
                var title = $('<h5>').text(detailType);
                var cardTools = $('<div class="card-tools">');
                var collapseButton = $('<button type="button" class="btn btn-tool" data-card-widget="collapse">')
                    .click(function() {
                        $(this).find('i').toggleClass('fa-toggle-on fa-toggle-off');
                    })
                    .append('<i class="fas fa-toggle-on" id="iconToggle"></i>');

                // Append elements to the header
                headerContent.append(title, cardTools.append('<div class="btn btn-success"><i class="fa fa-plus"></i></div>',
                    collapseButton));
                cardHeader.append(headerContent);
                card.append(cardHeader);

                // Add a div for the card body with a unique id
                var cardBody = $('<div class="card-body" style="height: 300px;">');
                // Add the div inside cardBody
                cardBody.append('<div id="' + detailType.toLowerCase() + 'Body_' + particular_id +
                    '" class="ag-theme-quartz" style="height: 100%;"></div>');
                card.append(cardBody);

                // Call MaterialsTable function only if not already initialized for this particular_id
                if (!initializedParticulars.includes(particular_id)) {
                    MaterialsTable(particular_id);
                    initializedParticulars.push(particular_id); // Add the particular_id to the list of initialized particulars
                }

                return card;
            }


            function getProjects() {
                // Retrieve the selected project ID from localStorage
                var selectedProjectID = localStorage.getItem('projectID');
                $.ajax({
                    url: "{{ route('project.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Iterate over each project
                        data.forEach(function(project) {
                            // Check if the project ID matches the selected project ID
                            if (project.project_id == selectedProjectID) {
                                // Populate input fields with project data based on their IDs
                                $('#add_project_id').val(project.project_id);
                                $('#add_project_title').val(project.project_title);
                                $('#add_project_location').val(project.project_location);
                                $('#add_project_owner').val(project.project_owner);
                                $('#add_unit_office').val(project.unit_office);
                                $('#add_project_description').val(project.project_description);
                                $('#add_project_contract_duration').val(project.project_contract_duration);
                                $('#add_project_appropriation').val(project.project_appropriation);
                                $('#add_project_source_of_fund').val(project.project_source_of_fund);
                                $('#add_project_date_prepared').val(project.project_date_prepared);
                                $('#add_project_target_start_date').val(project.project_target_start_date);
                                $('#add_project_mode_of_implementation').val(project
                                    .project_mode_of_implementation);
                            }
                            $('#add_project_source_of_fund').select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Project Source of Fund', // Optional placeholder text
                                // allowClear: true, // Allow clearing the selection
                            });
                        });
                        // Simple initialization with default options
                        new AutoNumeric('#add_project_appropriation');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }



            // Retrieve project_id and project_title from localStorage
            var selectedProjectID = localStorage.getItem('projectID');
            var selectedProjectTitle = localStorage.getItem('projectTitle');

            // Set the values into the specified HTML elements
            $('#projectSelectedID').val(selectedProjectID);
            $('#projectSelectedTitle').text(selectedProjectTitle);



            // Add click event listener to the button
            $('#selectDetailMaterial').click(function() {
                $('#materialCard').removeClass('d-none');
                // Store the visibility state in local storage
                // localStorage.setItem('materialCardVisible', 'true');
            });

            $('#selectDetailLabor').click(function() {
                $('#laborCard').removeClass('d-none');
                // Store the visibility state in local storage
                // localStorage.setItem('materialCardVisible', 'true');
            });

            $('#selectDetailEquipment').click(function() {
                $('#equipmentCard').removeClass('d-none');
                // Store the visibility state in local storage
                // localStorage.setItem('materialCardVisible', 'true');
            });

            // Handle click event on #selectMaterial button
            // $('#addParticularBtn').click(function() {
            //     updateDynamicContent();
            // });
            // // Function to fetch new data and update the dynamic content
            // function updateDynamicContent() {
            //     $.ajax({
            //         url: "{{ route('home') }}", // Replace with your route
            //         method: 'GET',
            //         success: function(response) {
            //             // Replace the content inside #dynamicContent without affecting its structure
            //             $('#dynamicContent').empty().append($(response).find('#dynamicContent').html());
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //         }
            //     });
            // }
            $('#add_project_source_of_fund').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Project Source of Fund', // Optional placeholder text
                // allowClear: true, // Allow clearing the selection
            });
            $('#add_project_particular').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Project Particular', // Optional placeholder text
                // allowClear: true, // Allow clearing the selection
            });
            // Initialize grid outside the function
            const gridOptions = {
                columnDefs: [{
                        field: 'material_id',
                        headerName: 'Material ID',
                        hide: true
                    },
                    {
                        field: 'material_name',
                        headerName: 'Material Name',
                        rowDrag: true,
                    },
                    {
                        field: 'unit',
                        headerName: 'Unit'
                    },
                    {
                        field: 'price',
                        headerName: 'Price'
                    },
                    {
                        field: 'quarter',
                        headerName: 'Quarter'
                    },
                    {
                        field: 'year',
                        headerName: 'Year'
                    },
                    {
                        field: '',
                        headerName: 'Actions',
                        cellRenderer: function(params) {
                            const materialId = params.data.material_id;
                            const materialName = params.data.material_name;
                            return '<div><button onclick="editbtn(' + materialId + ', \'' + materialName +
                                '\')" class="btn btn-success">Edit</button></div>';
                        }
                    },
                ],
                defaultColDef: {
                    width: 150,
                    filter: true,
                },
                rowDragManaged: true,
                rowDragMultiRow: true,
                rowSelection: 'multiple',
                enableCellChangeFlash: true

            };

            function editbtn(material_id, material_name) {
                console.log('Material ID:', material_id);
                console.log('Material Name:', material_name);
            }

            function MaterialsTable(particular_id) {
                function loadData() {
                    $.ajax({
                        url: "{{ route('materials.index') }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            const gridDiv = document.querySelector('#' + 'materialBody_' +
                                particular_id); // Dynamically target gridDiv
                            const gridApi = agGrid.createGrid(gridDiv, gridOptions);

                            gridApi.setGridOption('rowData', data);
                            console.log("Data refreshed:", data);

                            // Iterate over each object in the data array
                            data.forEach(function(item) {
                                // Access the material_category_name property of each object
                                const materialCategoryName = item.material_category_name;
                                console.log("Material Category Name:", materialCategoryName);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Load data initially
                loadData();

                // Handle click event on #selectMaterial button
                $('#selectMaterial').click(function() {
                    // Toggle the 'hidden' class on #materialTitle
                    $('#materialTitle').toggleClass('hidden');
                    // Call loadData function
                    loadData();
                });
            }@extends('layouts.app')
@section('content')

    <head>
        <style>
            .form-group>label {
                bottom: 34px;
                left: 10px;
                position: relative;
                background-color: white;
                padding: 0px 3px 0px 3px;
                font-size: 0.8em;
                transition: 0.25s;
                pointer-events: none;
            }

            .form-control:focus~label {
                bottom: 55px;
            }

            .form-control:valid~label {
                bottom: 55px;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>



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
                    <div class="card-body">
                        <div class="row">
                            <div class="row mt-4 col-12">
                                <div class="col-6">
                                    <div class="form-group margin-top">
                                        <input type="hidden" id="add_project_id">
                                        <input type="text" class="form-control" id="add_project_title" required>
                                        <label for="add_project_title">Project Title</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_location" required>
                                        <label for="add_project_location">Location</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_owner" required>
                                        <label for="add_project_owner">Owner</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_unit_office" required>
                                        <label for="add_unit_office">Unit Office</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_description" required>
                                        <label for="add_project_description">Project Description</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_contract_duration"
                                            name="add_project_contract_duration" required>
                                        <label for="add_project_contract_duration">Contract Duration</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_appropriation"
                                            name="add_project_appropriation" required>
                                        <label for="add_project_appropriation">Project Appropriation</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <select type="text" class="form-control" id="add_project_source_of_fund"
                                            name="add_project_source_of_fund" placeholder="Project Source of Fund" required>
                                            <option value=""></option>
                                            <option value="General Fund">General Fund</option>
                                            <option value="Trust Fund">Trust Fund</option>
                                            <option value="Special Trust Fund">Special Trust Fund</option>
                                            <option value="RGMO">RGMO</option>
                                        </select>
                                        <label for="add_project_source_of_fund">Project Source Of
                                            Fund</label>
                                    </div>
                                    <div class="form-group margin-top mt-2">
                                        <input type="date" class="form-control" id="add_project_date_prepared"
                                            name="add_project_date_prepared">
                                        <label for="add_project_date_prepared">Project Date Prepared</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="date" class="form-control" id="add_project_target_start_date"
                                            name="add_project_target_start_date">
                                        <label for="add_project_target_start_date">Project Target Start Date</label>
                                    </div>
                                    <div class="form-group margin-top">
                                        <input type="text" class="form-control" id="add_project_mode_of_implementation"
                                            name="add_project_mode_of_implementation" required>
                                        <label for="add_project_mode_of_implementation">Project Mode of
                                            Implementation</label>
                                    </div>
                                    <div class="modal-footer col-12">
                                        <div class="btn btn-success col-12">Save Changes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ./ Project Card  --->

            @include('modals.project_particular.add_project_particular_modal')

            <!-- Your Blade view with JavaScript -->


            {{-- For testing purposess --}}
            <div class="container-fluid mt-3">
                <h4>Project Particular</h4>
                <div id="projectParticularContent" class="container-fluid col-12 d-flex flex-column"></div>
            </div>
            <div class="btn btn-success" id="addParticularBtn">Add Particular</div>
        </div>



        <script>
            getProjects();

            var selectedProjectTitle = localStorage.getItem('projectTitle');

            // Check if selectedProjectTitle has a value
            if (selectedProjectTitle) {
                $('#ProjectHeader').text('View Project Details');
            }
            document.addEventListener('DOMContentLoaded', function() {

            });


            $.ajax({
                url: "{{ route('getAllData.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    const gridOptions = {
                        columnDefs: [{
                                field: 'material_id',
                                headerName: 'Material ID',
                                hide: true
                            },
                            {
                                field: 'material_name',
                                headerName: 'Material Name',
                                rowDrag: true,
                                flex: 1,
                                minWidth: 145
                            },
                            {
                                field: 'material_category_id',
                                headerName: 'Category Id',
                                hide: true,
                                flex: 1
                            },
                            {
                                field: 'material_category_name',
                                headerName: 'Category Name',
                                flex: 1,
                                minWidth: 145
                            },
                            {
                                field: 'material_unit',
                                headerName: 'Unit',
                                flex: 1
                            },
                            {
                                field: 'material_price',
                                headerName: 'Price',
                                flex: 1
                            },
                            {
                                field: 'material_quantity',
                                headerName: 'Quarter',
                                flex: 1
                            },
                            {
                                field: 'material_year',
                                headerName: 'Year',
                                flex: 1
                            },
                            {
                                field: '',
                                headerName: 'Actions',
                                cellRenderer: function(params) {
                                    const materialId = params.data.material_id;
                                    const materialName = params.data.material_name;
                                    return '<div><button onclick="editbtn(' + materialId + ', \'' +
                                        materialName +
                                        '\')" class="btn btn-success">Edit</button></div>';
                                },
                                flex: 1
                            },
                        ],
                        defaultColDef: {
                            filter: true
                        },
                        rowDragManaged: true,
                        rowDragMultiRow: true,
                        rowSelection: 'multiple',
                        enableCellChangeFlash: true,
                    };

                    // Get the selected project ID from localStorage
                    var selectedProjectID = localStorage.getItem('projectID');


                    // Filter and sort project items
                    var sortedProjects = data.projects.filter(function(project) {
                        return project.project_id == selectedProjectID;
                    });
                    // Iterate through each filtered project item
                    sortedProjects.forEach(function(project) {
                        // Iterate through each particular item
                        project.particulars.forEach(function(particular) {
                            // Create a new main card for each particular
                            var mainCard = $('<div class="card" id="mainCardProjectParticular">');
                            var cardHeader = $(
                                '<div class="card-header header-hover" data-toggle="collapse" data-target="#projectPart' +
                                particular.particular_id + '">');
                            var cardCollapse = $('<div class="collapse">').attr('id',
                                'projectPart' + particular.particular_id);
                            var cardBody = $('<div class="card-body col-12">');
                            var row = $('<div class="row">');
                            var col1 = $('<div class="col-1">');
                            var col11 = $('<div class="col-11">');

                            // Set up the card header
                            var headerContent = $('<div class="d-flex justify-content-between">');
                            var title = $('<h5>').text(particular.particular_name);
                            var cardTools = $('<div class="card-tools">');
                            var collapseButton = $('<button type="button" class="btn btn-tool">')
                                .html('<i class="fas fa-minus"></i>');

                            // Append elements to the header
                            headerContent.append(title, cardTools.append(collapseButton));
                            cardHeader.append(headerContent);

                            // Set up the dropdown for adding details
                            var dropdownButton = $(
                                    '<button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">'
                                )
                                .html(
                                    '<i class="fa fa-plus"></i><span class="sr-only">Toggle Dropdown</span>'
                                );
                            var dropdownMenu = $('<div class="dropdown-menu" role="menu">');

                            // Create dropdown options
                            var detailTypes = ['Material', 'Labor', 'Equipment'];
                            detailTypes.forEach(function(detail) {
                                var dropdownItem = $(
                                    '<a class="dropdown-item select-details" href="#" data-details="' +
                                    detail + '">').text(detail);
                                dropdownMenu.append(dropdownItem);
                            });

                            // Append dropdown to the card
                            col1.append($('<div class="btn-group">').append(dropdownButton,
                                dropdownMenu));

                            // Set up the cards for Material, Labor, and Equipment
                            var materialCard = createDetailCard('Material', particular
                                .particular_id, particular.particular_name);
                            var laborCard = createDetailCard('Labor', particular.particular_id,
                                particular.particular_name);
                            var equipmentCard = createDetailCard('Equipment', particular
                                .particular_id, particular.particular_name);

                            // Append cards to the col11 container
                            col11.append(materialCard, laborCard, equipmentCard);

                            // Append col1 and col11 to the row
                            row.append(col1, col11);

                            // Append row to the card body
                            cardBody.append(row);

                            // Append card body to the collapse container
                            cardCollapse.append(cardBody);

                            // Append card header and collapse container to the main card
                            mainCard.append(cardHeader, cardCollapse);

                            // Append main card to the dynamic content container
                            $('#projectParticularContent').append(mainCard);
                        });
                        // Filter the projects based on the selected project ID
                        var filteredProjects = data.projects.filter(project => project
                            .project_id == selectedProjectID);
                        // Extract the particulars and details from the filtered projects
                        var materialsArray = filteredProjects.flatMap(project => {
                            return project.particulars.flatMap(particular => {
                                // Extract details from each particular
                                var details = particular.details;
                                // Combine the particular with its details
                                return {
                                    particular_id: particular.particular_id,
                                    particular_name: particular.particular_name,
                                    details: details.Materials
                                };
                            });
                        });

                        // Sort the materials array based on the particular_id
                        materialsArray.sort((a, b) => a.particular_id - b.particular_id);

                        // Loop through each item in materialsArray and create a grid for each particular
                        materialsArray.forEach(material => {
                            const gridDiv = document.querySelector(
                                `#materialBody_${material.particular_id}`);
                            if (gridDiv) {
                                const gridApi = new agGrid.createGrid(gridDiv,
                                    gridOptions);
                                gridApi.setGridOption('rowData',
                                    material.details);
                                // console.log(
                                //     `Data refreshed for particular ${material.particular_id}:`,
                                //     material
                                //     .details);
                            } else {
                                console.error(
                                    `Grid div not found for particular ${material.particular_id}`
                                );
                            }
                        });
                    });
                }
            });

            // Function to create detail cards
            function createDetailCard(detailType, particular_id, particular_name) {
                var card = $('<div class="card" id="' + detailType.toLowerCase() + 'Card">');
                var cardHeader = $(
                    '<div class="card-header d-flex justify-content-between col-12 header-hover" data-card-widget="collapse">'
                );
                var headerContent = $('<div class="d-flex justify-content-between col-12">');
                var title = $('<h5>').text(detailType);
                var cardTools = $('<div class="card-tools">');
                // Create the collapse button with a unique ID
                var collapseButton = $('<button type="button" class="btn btn-tool" data-card-widget="collapse">')
                    .append('<i class="fas fa-toggle-on" id="iconToggle"></i>'); // Initially set to fa-toggle-on
                // Create the add detail button
                var addDetailButton = $('<div class="btn btn-success" id="addDetailBtn"><i class="fa fa-plus"></i></div>')
                    .click(function(event) {
                        event.stopPropagation();
                        console.log(particular_id);
                        console.log(particular_name)
                    });
                // Append elements to the header
                headerContent.append(title, cardTools.append(addDetailButton, collapseButton));
                cardHeader.append(headerContent);
                card.append(cardHeader);

                // Toggle collapse when card header is clicked
                cardHeader.click(function() {
                    $(this).find('#iconToggle').toggleClass('fa-toggle-on fa-toggle-off');
                });

                // Add onclick event handler to the expand button
                $('#addDetailBtn').click(function(event) {

                });

                // Add a div for the card body with a unique id
                var cardBody = $('<div class="card-body" style="height: 350px;">');
                // Add the div inside cardBody
                cardBody.append('<div id="' + detailType.toLowerCase() + 'Body_' + particular_id +
                    '" class="ag-theme-quartz" style="height: 100%;"></div>');
                card.append(cardBody);


                return card;

                // Call MaterialsTable function passing particular_id and particular_name
                MaterialsTable(particular_id, particular_name);

            }

            function getProjects() {
                // Retrieve the selected project ID from localStorage
                var selectedProjectID = localStorage.getItem('projectID');
                $.ajax({
                    url: "{{ route('project.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Iterate over each project
                        data.forEach(function(project) {
                            // Check if the project ID matches the selected project ID
                            if (project.project_id == selectedProjectID) {
                                // Populate input fields with project data based on their IDs
                                $('#add_project_id').val(project.project_id);
                                $('#add_project_title').val(project.project_title);
                                $('#add_project_location').val(project.project_location);
                                $('#add_project_owner').val(project.project_owner);
                                $('#add_unit_office').val(project.unit_office);
                                $('#add_project_description').val(project.project_description);
                                $('#add_project_contract_duration').val(project.project_contract_duration);
                                $('#add_project_appropriation').val(project.project_appropriation);
                                $('#add_project_source_of_fund').val(project.project_source_of_fund);
                                $('#add_project_date_prepared').val(project.project_date_prepared);
                                $('#add_project_target_start_date').val(project.project_target_start_date);
                                $('#add_project_mode_of_implementation').val(project
                                    .project_mode_of_implementation);
                            }
                            $('#add_project_source_of_fund').select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Project Source of Fund', // Optional placeholder text
                                // allowClear: true, // Allow clearing the selection
                            });
                        });
                        // Simple initialization with default options
                        new AutoNumeric('#add_project_appropriation');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }



            // Retrieve project_id and project_title from localStorage
            var selectedProjectID = localStorage.getItem('projectID');
            var selectedProjectTitle = localStorage.getItem('projectTitle');

            // Set the values into the specified HTML elements
            $('#projectSelectedID').val(selectedProjectID);
            $('#projectSelectedTitle').text(selectedProjectTitle);



            // Add click event listener to the button
            $('#selectDetailMaterial').click(function() {
                $('#materialCard').removeClass('d-none');
                // Store the visibility state in local storage
                // localStorage.setItem('materialCardVisible', 'true');
            });

            $('#selectDetailLabor').click(function() {
                $('#laborCard').removeClass('d-none');
                // Store the visibility state in local storage
                // localStorage.setItem('materialCardVisible', 'true');
            });

            $('#selectDetailEquipment').click(function() {
                $('#equipmentCard').removeClass('d-none');
                // Store the visibility state in local storage
                // localStorage.setItem('materialCardVisible', 'true');
            });

            // Handle click event on #selectMaterial button
            // $('#addParticularBtn').click(function() {
            //     updateDynamicContent();
            // });
            // // Function to fetch new data and update the dynamic content
            // function updateDynamicContent() {
            //     $.ajax({
            //         url: "{{ route('home') }}", // Replace with your route
            //         method: 'GET',
            //         success: function(response) {
            //             // Replace the content inside #dynamicContent without affecting its structure
            //             $('#dynamicContent').empty().append($(response).find('#dynamicContent').html());
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //         }
            //     });
            // }
            $('#add_project_source_of_fund').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Project Source of Fund', // Optional placeholder text
                // allowClear: true, // Allow clearing the selection
            });
            $('#add_project_particular').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Project Particular', // Optional placeholder text
                // allowClear: true, // Allow clearing the selection
            });


            function editbtn(material_id, material_name) {
                console.log('Material ID:', material_id);
                console.log('Material Name:', material_name);
            }
        </script>
        <!-- /.content -->
    @endsection


            function getAllData() {
                $.ajax({
                    url: "{{ route('getAllData.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            getAllData();
        </script>
        <!-- /.content -->
    @endsection
