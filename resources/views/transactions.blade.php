@extends('layouts.app')
@section('content')

    <head>

        <script src="{{ asset('js/ag-grid.js') }}"></script>

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
                                        <label for="add_unit_office">Unit Office</label>
                                        <input type="text" class="form-control" id="add_unit_office" required>
                                    </div>
                                    <div class="form-group margin-top">
                                        <label for="add_project_description">Project Description</label>
                                        <input type="text" class="form-control" id="add_project_description" required>
                                    </div>
                                    <div class="form-group margin-top">
                                        <label for="add_project_contract_duration">Contract Duration</label>
                                        <input type="text" class="form-control" id="add_project_contract_duration"
                                            name="add_project_contract_duration" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group margin-top">
                                        <label for="add_project_appropriation">Project Appropriation</label>
                                        <input type="text" class="form-control" id="add_project_appropriation"
                                            name="add_project_appropriation" required>
                                    </div>
                                    <div class="form-group margin-top">
                                        <label for="add_project_source_of_fund">Project Source Of Fund</label>
                                        <select type="text" class="form-control" id="add_project_source_of_fund"
                                            name="add_project_source_of_fund" placeholder="Project Source of Fund" required>
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
                                        <label for="add_project_target_start_date">Project Target Start Date</label>
                                        <input type="date" class="form-control" id="add_project_target_start_date"
                                            name="add_project_target_start_date">
                                    </div>
                                    <div class="form-group margin-top">
                                        <label for="add_project_mode_of_implementation">Project Mode of
                                            Implementation</label>
                                        <input type="text" class="form-control"
                                            id="add_project_mode_of_implementation"
                                            name="add_project_mode_of_implementation" required>

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

            @include('modals.project_particular.add_projectPart_material')

            {{-- For testing purposess --}}
            <div class="container-fluid mt-3" id="dynamicContent">
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
                refreshTransaction();
            });

            function refreshTransaction() {
                $.ajax({
                    url: "{{ route('getAllData.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const gridOptionsMaterial = {
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
                                    minWidth: 145,
                                },
                                {
                                    field: 'material_category_id',
                                    headerName: 'Category Id',
                                    hide: true,
                                    flex: 1
                                },
                                {
                                    field: 'material_category_name',
                                    headerName: 'Category',
                                    flex: 1,
                                    minWidth: 145
                                },
                                {
                                    field: 'material_unit',
                                    headerName: 'Unit',
                                    flex: 1
                                },
                                {
                                    field: 'material_quarter',
                                    headerName: 'Quarter',
                                    flex: 1
                                },
                                {
                                    field: 'material_year',
                                    headerName: 'Year',
                                    flex: 1
                                },
                                {
                                    field: 'material_quantity',
                                    headerName: 'Quantity',
                                    flex: 1
                                },
                                {
                                    field: 'material_price',
                                    headerName: 'Unit Cost',
                                    flex: 1,
                                    valueFormatter: function(params) {
                                        // Format the amount with commas for thousands separators and two decimal places
                                        return parseFloat(params.value).toFixed(2).replace(
                                            /\d(?=(\d{3})+\.)/g, '$&,');
                                    }
                                },
                                {
                                    field: 'amount',
                                    headerName: 'Amount',
                                    colId: 'materialAmount',
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
                                        return parseFloat(params.value).toFixed(2).replace(
                                            /\d(?=(\d{3})+\.)/g, '$&,');
                                    },
                                },
                                {
                                    field: '',
                                    headerName: 'Actions',
                                    cellRenderer: function(params) {
                                        const materialId = params.data.material_id;
                                        const materialName = params.data.material_name;
                                        return '<div><button onclick="editbtn(' +
                                            materialId +
                                            ', \'' +
                                            materialName +
                                            '\')" class="btn btn-success btn-header">Edit</button></div>';
                                    },
                                    flex: 1
                                },
                            ],
                            defaultColDef: {
                                filter: true,
                                minWidth: 100
                            },
                            rowDragManaged: true,
                            rowDragMultiRow: true,
                            rowSelection: 'multiple',
                            enableCellChangeFlash: true,
                        };

                        const gridOptionsLabor = {
                            columnDefs: [{
                                    field: 'labor_id',
                                    headerName: 'Labor ID',
                                    hide: true
                                },
                                {
                                    field: 'labor_name',
                                    headerName: 'Labor Name',
                                    rowDrag: true,
                                    flex: 1,
                                    minWidth: 145
                                },
                                {
                                    field: 'labor_location',
                                    headerName: 'Location',
                                    flex: 1
                                },
                                {
                                    field: 'labor_rate',
                                    headerName: 'Labor Rate',
                                    flex: 1,
                                },
                                {
                                    field: 'labor_work_days',
                                    headerName: 'Work Days',
                                },
                                {
                                    field: '',
                                    headerName: 'Actions',
                                    cellRenderer: function(params) {
                                        const laborId = params.data.labor_id;
                                        const laborName = params.data.labor_name;
                                        return '<div><button onclick="editbtn(' + laborId +
                                            ', \'' +
                                            laborName +
                                            '\')" class="btn btn-success btn-header">Edit</button></div>';
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
                        const gridOptionsEquipment = {
                            columnDefs: [{
                                    field: 'equipment_id',
                                    headerName: 'Equipment ID',
                                    hide: true
                                },
                                {
                                    field: 'equipment_name',
                                    headerName: 'Equipment Name',
                                    rowDrag: true,
                                    flex: 1,
                                    minWidth: 145
                                },
                                {
                                    field: 'equipment_rate',
                                    headerName: 'Rate',
                                    flex: 1
                                },
                                {
                                    field: 'equipment_work_days',
                                    headerName: 'Work Days',
                                    flex: 1,
                                },
                                {
                                    field: '',
                                    headerName: 'Actions',
                                    cellRenderer: function(params) {
                                        const equipmentId = params.data.equipment_id;
                                        const equipmentName = params.data.equipment_name;
                                        return '<div><button onclick="editbtn(' +
                                            equipmentId +
                                            ', \'' +
                                            equipmentName +
                                            '\')" class="btn btn-success btn-header">Edit</button></div>';
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
                                var mainCard = $(
                                    '<div class="card" id="mainCardProjectParticular">'
                                );
                                var cardHeader = $(
                                    '<div class="card-header header-hover padding-header" data-toggle="collapse" data-target="#projectPart' +
                                    particular.particular_id + '">');
                                var cardCollapse = $('<div class="collapse">').attr(
                                    'id',
                                    'projectPart' + particular.particular_id);
                                var cardBody = $('<div class="card-body col-12">');
                                var row = $('<div class="row">');
                                var col1 = $('<div class="col-1">');
                                var col11 = $('<div class="col-11">');

                                // Set up the card header
                                var headerContent = $(
                                    '<div class="d-flex justify-content-between">');
                                var title = $('<h5>').text(particular.particular_name);
                                var cardTools = $('<div class="card-tools">');
                                var collapseButton = $(
                                        '<button type="button" class="btn btn-tool">')
                                    .html('<i class="fas fa-minus"></i>');

                                // Append elements to the header
                                headerContent.append(title, cardTools.append(
                                    collapseButton));
                                cardHeader.append(headerContent);

                                // Set up the dropdown for adding details
                                var dropdownButton = $(
                                        '<button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">'
                                    )
                                    .html(
                                        '<i class="fa fa-plus"></i><span class="sr-only">Toggle Dropdown</span>'
                                    );
                                var dropdownMenu = $(
                                    '<div class="dropdown-menu" role="menu">');

                                // Create dropdown options
                                var detailTypes = ['Material', 'Labor', 'Equipment'];
                                detailTypes.forEach(function(detail) {
                                    var dropdownItem = $(
                                        '<a class="dropdown-item select-details" href="#" data-details="' +
                                        detail + '">').text(detail);
                                    dropdownMenu.append(dropdownItem);
                                });

                                // Filter out details that should not be displayed in the grid
                                const rowDataMaterial = Object.values(particular.details
                                    .Materials);
                                const rowDataLabor = Object.values(particular.details
                                    .Labor);
                                const rowDataEquipment = Object.values(particular
                                    .details
                                    .Equipment);

                                // Calculate total amount for material
                                let totalMaterialAmount = 0;
                                rowDataMaterial.forEach(function(material) {
                                    totalMaterialAmount += material
                                        .material_quantity * parseFloat(material
                                            .material_price);
                                });
                                // Format totalMaterialAmount
                                totalMaterialAmount = totalMaterialAmount.toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Calculate total amount for labor
                                let totalLaborAmount = 0;
                                rowDataLabor.forEach(function(labor) {
                                    totalLaborAmount += labor.labor_rate * labor
                                        .labor_work_days;
                                });
                                // Format totalLaborAmount
                                totalLaborAmount = totalLaborAmount.toFixed(2).replace(
                                    /\B(?=(\d{3})+(?!\d))/g, ",");

                                // Calculate total amount for equipment
                                let totalEquipmentAmount = 0;
                                rowDataEquipment.forEach(function(equipment) {
                                    totalEquipmentAmount += equipment
                                        .equipment_rate * equipment
                                        .equipment_work_days;
                                });
                                // Format totalEquipmentAmount
                                totalEquipmentAmount = totalEquipmentAmount.toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Set up the cards for Material, Labor, and Equipment
                                var materialCard = createDetailCard('Material',
                                    particular
                                    .particular_id, particular.particular_name,
                                    particular, totalMaterialAmount);
                                var laborCard = createDetailCard('Labor', particular
                                    .particular_id,
                                    particular.particular_name, particular,
                                    totalLaborAmount
                                );
                                var equipmentCard = createDetailCard('Equipment',
                                    particular
                                    .particular_id, particular.particular_name,
                                    particular, totalEquipmentAmount);

                                // Append dropdown to the card
                                col1.append($('<div class="btn-group">').append(
                                    dropdownButton,
                                    dropdownMenu));

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
                            var detailArray = filteredProjects.flatMap(project => {
                                return project.particulars.flatMap(particular => {
                                    // Combine the particular with its details
                                    return {
                                        particular_id: particular.particular_id,
                                        particular_name: particular
                                            .particular_name,
                                        details: particular.details
                                    };
                                });
                            });

                            // Sort the materials array based on the particular_id
                            detailArray.sort((a, b) => a.particular_id - b.particular_id);

                            // Loop through each item in detailArray and create a grid for each particular
                            detailArray.forEach(particular => {
                                const materialGridDiv = document.querySelector(
                                    `#materialBody_${particular.particular_id}`);
                                const laborGridDiv = document.querySelector(
                                    `#laborBody_${particular.particular_id}`);
                                const equipmentGridDiv = document.querySelector(
                                    `#equipmentBody_${particular.particular_id}`);

                                const materialGridAPI = new agGrid.createGrid(
                                    materialGridDiv,
                                    gridOptionsMaterial);
                                const laborGridAPI = new agGrid.createGrid(laborGridDiv,
                                    gridOptionsLabor);
                                const equipmentGridAPI = new agGrid.createGrid(
                                    equipmentGridDiv,
                                    gridOptionsEquipment);
                                // Filter out details that should not be displayed in the grid
                                const rowDataMaterial = Object.values(particular.details
                                    .Materials)
                                const rowDataLabor = Object.values(particular.details
                                    .Labor)
                                const rowDataEquipment = Object.values(particular
                                    .details
                                    .Equipment)

                                refreshMaterials(materialGridAPI, rowDataMaterial);

                                laborGridAPI.setGridOption('rowData', rowDataLabor);
                                equipmentGridAPI.setGridOption('rowData',
                                    rowDataEquipment);

                            });

                        });
                    }
                });
            }

            // Define the refreshMaterials function globally
            function refreshMaterials(materialGridAPI, rowDataMaterial) {
                materialGridAPI.setGridOption('rowData', rowDataMaterial);
            }

            // Define totalAmountColumn in a scope accessible outside of the function
            var totalAmountColumn;

            // Function to create detail cards
            function createDetailCard(detailType, particular_id, particular_name, particular, totalAmounts) {
                var card = $('<div class="card" id="' + detailType.toLowerCase() + 'Card_' + particular_id + '">');
                var cardHeader = $(
                    '<div class="card-header d-flex justify-content-between col-12 header-hover padding-header" data-card-widget="collapse">'
                );
                var headerContent = $('<div class="d-flex justify-content-between col-12">');
                var title = $('<h5>').text(detailType);
                var cardTools = $('<div class="card-tools">');
                // Create the collapse button with a unique ID
                var collapseButton = $('<button type="button" class="btn btn-tool" data-card-widget="collapse">')
                    .append('<i class="fas fa-toggle-on" id="iconToggle"></i>'); // Initially set to fa-toggle-on
                // Create the add detail button
                var addDetailButton = $(
                        '<div class="btn btn-success btn-header" id="' + detailType.toLowerCase() + 'Detail_' + particular_id +
                        '" onclick="addDetailBtn(' + particular_id + ', \'' + detailType +
                        '\')"><i class="fa fa-plus"></i></div>'

                    )
                    .click(function(event) {
                        event.stopPropagation();
                    });
                // Append elements to the header
                headerContent.append(title, cardTools.append(addDetailButton, collapseButton));
                cardHeader.append(headerContent);
                card.append(cardHeader);

                // Toggle collapse when card header is clicked
                cardHeader.click(function() {
                    $(this).find('#iconToggle').toggleClass('fa-toggle-on fa-toggle-off');
                });

                // Add a div for the card body with a unique id
                var cardBody = $('<div class="card-body" style="height: 350px;">');
                // Add the div inside cardBody
                cardBody.append('<div id="' + detailType.toLowerCase() + 'Body_' + particular_id +
                    '" class="ag-theme-quartz" style="height: 85%;"></div>');

                // Create the footer section within the card body
                var cardBodyFooter = $('<div class="card-body-footer">');
                var footerGridDiv = $('<div class="ag-theme-alpine" style="height: 50px;"></div>');
                cardBodyFooter.append(footerGridDiv);
                cardBody.append(cardBodyFooter);

                card.append(cardBody);

                // Set the headerName dynamically based on the rowData
                var headerName = 'Total ' + detailType + ' Amount: ' + totalAmounts; // Access the correct index


                // Create an empty row
                var emptyRow = {
                    total: ''
                }; // Add more fields as needed

                // Create Ag-Grid for the footer
                var gridOptionsFooter = {
                    columnDefs: [{
                        field: 'total',
                        headerName: headerName,
                        sortable: false,
                        resizable: false,
                        colId: 'totalAmountColumn',
                        suppressMovable: true
                    }],
                    defaultColDef: {
                        flex: 1
                    },
                    rowData: [emptyRow]
                };

                new agGrid.createGrid(footerGridDiv[0], gridOptionsFooter);
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

            let materialgridApi;


            function refreshAllData() {
                $.ajax({
                    url: "{{ route('getAllData.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const gridOptionsMaterial = {
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
                                    minWidth: 145,
                                },
                                {
                                    field: 'material_category_id',
                                    headerName: 'Category Id',
                                    hide: true,
                                    flex: 1
                                },
                                {
                                    field: 'material_category_name',
                                    headerName: 'Category',
                                    flex: 1,
                                    minWidth: 145
                                },
                                {
                                    field: 'material_unit',
                                    headerName: 'Unit',
                                    flex: 1
                                },
                                {
                                    field: 'material_quarter',
                                    headerName: 'Quarter',
                                    flex: 1
                                },
                                {
                                    field: 'material_year',
                                    headerName: 'Year',
                                    flex: 1
                                },
                                {
                                    field: 'material_quantity',
                                    headerName: 'Quantity',
                                    flex: 1
                                },
                                {
                                    field: 'material_price',
                                    headerName: 'Unit Cost',
                                    flex: 1,
                                    valueFormatter: function(params) {
                                        // Format the amount with commas for thousands separators and two decimal places
                                        return parseFloat(params.value).toFixed(2).replace(
                                            /\d(?=(\d{3})+\.)/g, '$&,');
                                    }
                                },
                                {
                                    field: 'amount',
                                    headerName: 'Amount',
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
                                        return parseFloat(params.value).toFixed(2).replace(
                                            /\d(?=(\d{3})+\.)/g, '$&,');
                                    },
                                },
                                {
                                    field: '',
                                    headerName: 'Actions',
                                    cellRenderer: function(params) {
                                        const materialId = params.data.material_id;
                                        const materialName = params.data.material_name;
                                        return '<div><button onclick="editbtn(' +
                                            materialId +
                                            ', \'' +
                                            materialName +
                                            '\')" class="btn btn-success btn-header">Edit</button></div>';
                                    },
                                    flex: 1
                                },
                            ],
                            defaultColDef: {
                                filter: true,
                                minWidth: 100
                            },
                            rowDragManaged: true,
                            rowDragMultiRow: true,
                            rowSelection: 'multiple',
                            enableCellChangeFlash: true,
                        };


                        const gridOptionsLabor = {
                            columnDefs: [{
                                    field: 'labor_id',
                                    headerName: 'Labor ID',
                                    hide: true
                                },
                                {
                                    field: 'labor_name',
                                    headerName: 'Labor Name',
                                    rowDrag: true,
                                    flex: 1,
                                    minWidth: 145
                                },
                                {
                                    field: 'labor_location',
                                    headerName: 'Location',
                                    flex: 1
                                },
                                {
                                    field: 'labor_rate',
                                    headerName: 'Labor Rate',
                                    flex: 1,
                                },
                                {
                                    field: 'labor_work_days',
                                    headerName: 'Work Days',
                                },
                                {
                                    field: '',
                                    headerName: 'Actions',
                                    cellRenderer: function(params) {
                                        const laborId = params.data.labor_id;
                                        const laborName = params.data.labor_name;
                                        return '<div><button onclick="editbtn(' + laborId +
                                            ', \'' +
                                            laborName +
                                            '\')" class="btn btn-success btn-header">Edit</button></div>';
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
                        const gridOptionsEquipment = {
                            columnDefs: [{
                                    field: 'equipment_id',
                                    headerName: 'Equipment ID',
                                    hide: true
                                },
                                {
                                    field: 'equipment_name',
                                    headerName: 'Equipment Name',
                                    rowDrag: true,
                                    flex: 1,
                                    minWidth: 145
                                },
                                {
                                    field: 'equipment_rate',
                                    headerName: 'Rate',
                                    flex: 1
                                },
                                {
                                    field: 'equipment_work_days',
                                    headerName: 'Work Days',
                                    flex: 1,
                                },
                                {
                                    field: '',
                                    headerName: 'Actions',
                                    cellRenderer: function(params) {
                                        const equipmentId = params.data.equipment_id;
                                        const equipmentName = params.data.equipment_name;
                                        return '<div><button onclick="editbtn(' +
                                            equipmentId +
                                            ', \'' +
                                            equipmentName +
                                            '\')" class="btn btn-success btn-header">Edit</button></div>';
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
                                // Filter out details that should not be displayed in the grid
                                const rowDataMaterial = Object.values(particular.details
                                    .Materials);
                                const rowDataLabor = Object.values(particular.details
                                    .Labor);
                                const rowDataEquipment = Object.values(particular
                                    .details
                                    .Equipment);

                                // Calculate total amount for material
                                let totalMaterialAmount = 0;
                                rowDataMaterial.forEach(function(material) {
                                    totalMaterialAmount += material
                                        .material_quantity * parseFloat(material
                                            .material_price);
                                });
                                // Format totalMaterialAmount
                                totalMaterialAmount = totalMaterialAmount.toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Calculate total amount for labor
                                let totalLaborAmount = 0;
                                rowDataLabor.forEach(function(labor) {
                                    totalLaborAmount += labor.labor_rate * labor
                                        .labor_work_days;
                                });
                                // Format totalLaborAmount
                                totalLaborAmount = totalLaborAmount.toFixed(2).replace(
                                    /\B(?=(\d{3})+(?!\d))/g, ",");

                                // Calculate total amount for equipment
                                let totalEquipmentAmount = 0;
                                rowDataEquipment.forEach(function(equipment) {
                                    totalEquipmentAmount += equipment
                                        .equipment_rate * equipment
                                        .equipment_work_days;
                                });
                                // Format totalEquipmentAmount
                                totalEquipmentAmount = totalEquipmentAmount.toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                            });
                            // Filter the projects based on the selected project ID
                            var filteredProjects = data.projects.filter(project => project
                                .project_id == selectedProjectID);
                            // Extract the particulars and details from the filtered projects
                            var detailArray = filteredProjects.flatMap(project => {
                                return project.particulars.flatMap(particular => {
                                    // Combine the particular with its details
                                    return {
                                        particular_id: particular.particular_id,
                                        particular_name: particular
                                            .particular_name,
                                        details: particular.details
                                    };
                                });
                            });

                            // Sort the materials array based on the particular_id
                            detailArray.sort((a, b) => a.particular_id - b.particular_id);
                            // $('#' + 'materialBody_1')
                            //     .empty();
                            // Loop through each item in detailArray and create a grid for each particular
                            detailArray.forEach(particular => {
                                const materialGridDiv = document.querySelector(
                                    `#materialBody_${particular.particular_id}`);
                                while (materialGridDiv.firstChild) {
                                    materialGridDiv.removeChild(materialGridDiv.firstChild);
                                }

                                const laborGridDiv = document.querySelector(
                                    `#laborBody_${particular.particular_id}`);
                                while (laborGridDiv.firstChild) {
                                    laborGridDiv.removeChild(laborGridDiv.firstChild);
                                }

                                const equipmentGridDiv = document.querySelector(
                                    `#equipmentBody_${particular.particular_id}`);
                                while (equipmentGridDiv.firstChild) {
                                    equipmentGridDiv.removeChild(equipmentGridDiv.firstChild);
                                }
                                const materialGridAPI = agGrid.createGrid(
                                    materialGridDiv,
                                    gridOptionsMaterial);
                                const laborGridAPI = new agGrid.createGrid(laborGridDiv,
                                    gridOptionsLabor);
                                const equipmentGridAPI = new agGrid.createGrid(
                                    equipmentGridDiv,
                                    gridOptionsEquipment);
                                // Filter out details that should not be displayed in the grid
                                const rowDataMaterial = Object.values(particular.details
                                    .Materials)
                                const rowDataLabor = Object.values(particular.details
                                    .Labor)
                                const rowDataEquipment = Object.values(particular
                                    .details
                                    .Equipment)

                                // refreshMaterials(materialGridAPI, rowDataMaterial);
                                materialGridAPI.setGridOption('rowData', rowDataMaterial);
                                laborGridAPI.setGridOption('rowData', rowDataLabor);
                                equipmentGridAPI.setGridOption('rowData',
                                    rowDataEquipment);

                            });

                        });
                    }
                });
            }
            // Add event listener to refreshTransaction on click
            $(document).on('click', '#addParticularBtn', function() {

            });

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

            function addDetailBtn(particular_id, detailType) {
                // Check the detailType
                if (detailType === 'Material') {
                    // Populate the Modal Particular Name
                    $.ajax({
                        url: '/getAllData/master-list', // URL of the route for masterList function
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response)
                            // Extract materials from the Ajax response
                            var materials = response.materials;
                            // Get the select element and empty it
                            var materialSelect = $('#add_particular_material').empty();
                            // Add a default option
                            materialSelect.append($('<option>', {
                                value: '',
                                text: 'Select Material'
                            }));
                            // Populate select options with material names using jQuery chaining and map()
                            materialSelect.append(materials.map(function(material) {
                                return $('<option>', {
                                    value: material.material_id,
                                    text: material.material_name
                                });
                            }));

                            $('#add_particular_material').select2({
                                theme: 'bootstrap-5',
                                dropdownParent: $('#addParticularMaterial'),
                                placeholder: 'Select Material', // Optional placeholder text
                                // allowClear: true, // Allow clearing the selection
                            });

                            // Add change event listener to the material select element
                            $('#add_particular_material').on('change', function() {
                                // Get the selected material id
                                var selectedMaterialId = $(this).val();

                                // Find the selected material data
                                var selectedMaterial = materials.find(function(material) {
                                    return material.material_id == selectedMaterialId;
                                });

                                // Populate category, unit, and price fields
                                $('#add_particular_category').val(selectedMaterial.material_category_name);
                                $('#add_particular_materialUnit').val(selectedMaterial.material_unit);
                                $('#add_particular_materialPrice').val(selectedMaterial.material_price);
                            });

                            // Open Add Particular Material Modal
                            $('#addParticularMaterial').modal('show')

                            // Submit the Particular Material Modal Form
                            $('#addProjectPartMaterialForm').on('submit', function(event) {
                                event.preventDefault(); // Prevent the default form submission behavior
                                // Get the selected project ID from localStorage
                                var submitProjectID = localStorage.getItem('projectID')
                                // Get form data
                                let projectId = (submitProjectID);
                                let particularId = (particular_id);
                                let materialId = $('#add_particular_material').val();
                                let materialQuantity = $('#add_particular_materialQuantity').val();

                                // AJAX request
                                $.ajax({
                                    url: '/submit-details',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        projectId: projectId,
                                        particularId: particularId,
                                        materialId: materialId,
                                        materialQuantity: materialQuantity,
                                        _token: "{{ csrf_token() }}"
                                        // Add more form data fields here if needed
                                    },
                                    success: function(response) {
                                        $('#addProjectPartMaterialForm')[0].reset();
                                        $('#addParticularMaterial').modal('hide');
                                        refreshAllData();

                                        toastr.options.progressBar = true;
                                        toastr.success('Material Added Successfully!');

                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error response from the server
                                        console.error('Error submitting form data:', xhr
                                            .responseText);
                                    }
                                });
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else if (detailType === 'Labor') {
                    console.log('Labor');
                    // Do something if detailType is Labor
                } else if (detailType === 'Equipment') {
                    console.log('Equipment');
                    // Do something if detailType is Equipment
                } else {
                    // Handle other cases
                }

            }

            function editbtn(material_id, material_name) {
                console.log('Material ID:', material_id);
                console.log('Material Name:', material_name);
            }
        </script>
        <!-- /.content -->
    @endsection
