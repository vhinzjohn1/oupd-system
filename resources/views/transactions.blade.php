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
                    <button class="btn btn-success" id="newProject">New Project</button>
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
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group margin-top">
                                            <label for="add_project_appropriation">Project Cost</label>
                                            <input type="text" class="form-control numberInput"
                                                id="add_project_appropriation" name="add_project_appropriation" required>
                                        </div>
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
            <!-- Your Blade view with JavaScript -->

            @include('modals.project_particular.add_projectPart_material')
            @include('modals.project_particular.add_projectPart_labor')
            @include('modals.project_particular.add_projectPart_equipment')
            @include('modals.project_particular.edit_projectPart_material')

            {{-- For testing purposess --}}
            <div class="container-fluid mt-3" id="dynamicContent">
                <h4>Project Item</h4>
                <div id="projectParticularContent" class="container-fluid col-12 d-flex flex-column"></div>
            </div>

            <!-- Set up the dropdown for adding Particular -->
            <div class="dropdown" id="addPartMenu">
                <button class="btn btn-success dropdown-toggle" type="button" id="addParticularBtn"
                    data-toggle="dropdown" aria-haspopup="true  " aria-expanded="false">
                    Add Particular<span class="sr-only"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="addParticularBtn">
                    <!-- Create dropdown options -->
                </div>
            </div>
        </div>

        <script>
            const [year, quarter] = [(new Date()).getFullYear(), ["1st", "2nd", "3rd", "4th"][Math.floor(((new Date())
                .getMonth() % 12) / 3)]];
            // console.log("Current Year:", year);
            // console.log("Current Quarter (String):", quarter);

            getProjects();
            refreshTransaction();


            function formatNumber(number) {
                return Number(number).toLocaleString('en-US');
            }

            var selectedProjectTitle = localStorage.getItem("projectTitle");

            // Check if selectedProjectTitle has a value
            if (selectedProjectTitle) {
                $("#ProjectHeader").text("View Project Details");
            }

            function editDetail(detailType, materialPartID, material_id, materialName, materialUnit, materialCategoryName,
                materialPrice, materialQuantity, particular_id1) {

                // Populate modal fields with the received data
                $('#edit_particular_material_id').val(material_id);
                $('#edit_particular_material').val(materialName);
                $('#edit_particular_materialQuantity').val(materialQuantity);
                $('#edit_particular_category').val(materialCategoryName);
                $('#edit_particular_materialUnit').val(materialUnit);
                $('#edit_particular_materialPrice').val(materialPrice);
                console.log(detailType);

                calculateAmount();

                // Show the modal
                $("#editParticularMaterialModal").modal("show");

                // Submit the Particular Material Modal Form
                $("#editProjectPartMaterialForm").on("submit", function(event) {
                    event.preventDefault();
                    // Get form data
                    var submitProjectID = localStorage.getItem("projectID");
                    let projectId = submitProjectID;
                    let particularId = particular_id1;
                    let detail_type = 'Material';
                    let materialId = $("#edit_particular_material_id").val();
                    let materialQuantity = $(
                        "#edit_particular_materialQuantity"
                    ).val();


                    // Disable the form to prevent multiple submissions
                    $(this).find(":input").prop("disabled", true);

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
                            _token: "{{ csrf_token() }}",
                            // Add more form data fields here if needed
                        },
                        success: function(response) {
                            $("#editProjectPartMaterialForm")[0].reset();
                            $("#editParticularMaterialModal").modal("hide");

                            // Re-enable the form for future submissions
                            $("#editProjectPartMaterialForm")
                                .find(":input")
                                .prop("disabled", false);


                            refreshAllData(parseInt(particularId));

                            // Unbind the submit event handler to prevent multiple submissions
                            $("#editProjectPartMaterialForm").off("submit");

                            toastr.options.progressBar = true;
                            toastr.success("Material Update Successfully!");

                        },
                        error: function(xhr, status, error) {
                            // Handle error response from the server
                            console.error(
                                "Error submitting form data:",
                                xhr.responseText
                            );

                            // Re-enable the form for future submissions
                            $("#editProjectPartMaterialForm")
                                .find(":input")
                                .prop("disabled", false);
                        },
                    });
                });
            }

            function refreshTransaction() {
                $.ajax({
                    url: "{{ route('getAllData.index') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
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
                                        const particularId = params.data
                                            .particular_id; // Changed from materialPartID to particularId

                                        // Construct the HTML string with the onclick event for edit and delete buttons
                                        const htmlString =
                                            '<div>' +
                                            '<button onclick="editDetail(\'' + detailType + '\', \'' +
                                            materialPartID + '\', \'' + materialId + '\', \'' +
                                            materialName + '\', \'' + materialUnit + '\', \'' +
                                            materialCategoryName + '\', \'' + materialPrice + '\', \'' +
                                            materialQuantity + '\', \'' + particularId +
                                            // Added particularId here
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
                                        return parseFloat(params.value * 8)
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
                                        const rate = params.data.labor_rate * 8;
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
                                        const detailType = "Labor";
                                        const particularID = params.data.project_particular_labor_id;

                                        // Construct the HTML string with the detailType and particularID
                                        const htmlString =
                                            `<div>
                                                <button onclick="editDetail('${detailType}', ${particularID})" class="btn btn-success btn-header">
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

                                        // Construct the HTML string with the detailType and particularID
                                        const htmlString =
                                            "<div><button onclick=\"deleteDetail('" +
                                            detailType +
                                            "', " +
                                            particularID +
                                            ')" class="btn btn-danger btn-header"><i class="fas fa-trash-alt"></i></button></div>';

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
                                // Create a form element with a single row
                                // Create a form element with a single row
                                var form = $('<form>').addClass('row p-3 form-top').append(
                                    $('<div class="col-12">').append(
                                        $('<div class="row">').append(
                                            $('<div class="col-3">').append(
                                                $('<h6>').text('Quantity: ').append(
                                                    $('<span>').attr('id', 'quantity_' +
                                                        particular.particular_id).text('')
                                                )
                                            ),
                                            $('<div class="col-2">').append(
                                                $('<h6>').text('Unit: ').append(
                                                    $('<span>').attr('id', 'unit_' + particular
                                                        .particular_id).text('')
                                                )
                                            ),
                                            $('<div class="col-3">').append(
                                                $('<h6>').text('Unit Cost: ').append(
                                                    $('<span>').attr('id', 'unit_cost_' +
                                                        particular.particular_id).text('')
                                                )
                                            ),
                                            $('<div class="col-3">').append(
                                                $('<h6>').text('Total: ').append(
                                                    $('<span>').attr('id', 'total_' + particular
                                                        .particular_id).text('')
                                                )
                                            ),
                                            $('<div class="col-1">').append(
                                                $('<div class="btn btn-success" id="particularDetail_' +
                                                    particular.particular_id + '">details</div>'
                                                )
                                            )

                                        )
                                    )
                                );


                                // Append the form to the mainCard
                                mainCard.append(form);

                                // Append main card to the dynamic content container
                                $("#projectParticularContent").append(mainCard);

                                var col11 = $('<div class="col-12">');

                                // Set up the card header
                                var headerContent = $(
                                    '<div class="d-flex justify-content-between">'
                                );
                                var title = $("<h5>").text(intToRoman(index + 1) + ". " + particular
                                    .particular_name);
                                var cardTools = $('<div class="card-tools">');
                                var collapseButton = $(
                                    '<button type="button" class="btn btn-tool">'
                                ).html('<i class="fas fa-minus"></i>');

                                var dangerButton = $(
                                    '<button type="button" class="btn btn-danger" data-project-particular-id="' +
                                    particular.project_particular_id +
                                    '"><i class="fas fa-trash-alt"></i></button>');
                                dangerButton.click(function(event) {
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
                                rowDataMaterial.forEach(function(material) {
                                    totalMaterialAmount +=
                                        material.material_quantity *
                                        parseFloat(material.material_price);
                                });
                                // Format totalMaterialAmount
                                totalMaterialAmount = totalMaterialAmount
                                    .toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Calculate total amount for labor
                                let totalLaborAmount = 0;
                                rowDataLabor.forEach(function(labor) {
                                    totalLaborAmount +=
                                        labor.labor_rate *
                                        8 *
                                        labor.labor_work_days *
                                        labor.labor_no_of_persons; // Update calculation
                                });
                                // Format totalLaborAmount
                                totalLaborAmount = totalLaborAmount
                                    .toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                // Calculate total amount for equipment
                                let totalEquipmentAmount = 0;
                                rowDataEquipment.forEach(function(equipment) {
                                    totalEquipmentAmount +=
                                        equipment.equipment_rate *
                                        equipment.equipment_work_days *
                                        equipment.equipment_no_of_units;
                                });
                                // Format totalEquipmentAmount
                                totalEquipmentAmount = totalEquipmentAmount
                                    .toFixed(2)
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

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
                                row.append(col11);

                                // Append row to the card body
                                cardBody.append(form, row);

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


                                const cardIds = ["materialCard_" + particular.particular_id,
                                    "laborCard_" + particular.particular_id,
                                    "equipmentCard_" + particular.particular_id,
                                ];
                                cardIds.forEach((id) => {
                                    const cardToCollapse = document.getElementById(id);
                                    if (cardToCollapse) {
                                        cardToCollapse.classList.add("collapsed-card");
                                    }
                                });

                                // const cardIds = ["materialCard_" + particular.particular_id,
                                //     "laborCard_" + particular.particular_id,
                                //     "equipmentCard_" + particular.particular_id,
                                // ];

                                // cardIds.forEach((id, index) => {
                                //     const cardToCollapse = document.getElementById(id);
                                //     if (!cardToCollapse) return; // Ensure the card exists

                                //     if (index === 0 && rowDataMaterial.length ===
                                //         0) { // For material card
                                //         cardToCollapse.classList.add("collapsed-card");
                                //         console.log("No Material Row Data");
                                //     }
                                //     if (index === 1 && rowDataLabor.length ===
                                //         0) { // For labor card
                                //         cardToCollapse.classList.add("collapsed-card");
                                //         console.log("No Labor Row Data");
                                //     }
                                //     if (index === 2 && rowDataEquipment.length ===
                                //         0) { // For equipment card
                                //         cardToCollapse.classList.add("collapsed-card");
                                //         console.log("No Equipment Row Data");
                                //     }
                                // });



                            });
                        });
                    },
                });
            }

            // Define the refreshMaterials function globally
            function refreshMaterials(materialGridAPI, rowDataMaterial) {
                materialGridAPI.setGridOption("rowData", rowDataMaterial);
            }

            // Define totalAmountColumn in a scope accessible outside of the function
            var totalAmountColumn;

            // Function to create detail cards
            function createDetailCard(
                detailType,
                particular_id,
                particular_name,
                particular,
                totalAmounts
            ) {
                var card = $(
                    '<div class="card" id="' +
                    detailType.toLowerCase() +
                    "Card_" +
                    particular_id +
                    '">'
                );
                var cardHeader = $(
                    '<div class="card-header d-flex justify-content-between col-12 header-hover padding-header" data-card-widget="collapse">'
                );
                var headerContent = $(
                    '<div class="d-flex justify-content-between col-12">'
                );
                var title = $("<h5>").text(detailType);
                var cardTools = $('<div class="card-tools">');
                // Create the collapse button with a unique ID
                var collapseButton = $(
                    '<button type="button" class="btn btn-tool" data-card-widget="collapse">'
                ).append('<i class="fas fa-toggle-on" id="iconToggle"></i>'); // Initially set to fa-toggle-on
                // Create the add detail button
                var addDetailButton = $(
                    '<div class="btn btn-success btn-header" id="' +
                    detailType.toLowerCase() +
                    "Detail_" +
                    particular_id +
                    '" onclick="addDetailBtn(' +
                    particular_id +
                    ", '" +
                    detailType +
                    '\')"><i class="fa fa-plus"></i></div>'
                ).click(function(event) {
                    event.stopPropagation();
                });
                // Append elements to the header
                headerContent.append(
                    title,
                    cardTools.append(addDetailButton, collapseButton)
                );
                cardHeader.append(headerContent);
                card.append(cardHeader);

                // Toggle collapse when card header is clicked
                cardHeader.click(function() {
                    $(this).find("#iconToggle").toggleClass("fa-toggle-on fa-toggle-off");
                });

                // Add a div for the card body with a unique id
                var cardBody = $('<div class="card-body" style="height: 350px;">');
                // Add the div inside cardBody
                cardBody.append(
                    '<div id="' +
                    detailType.toLowerCase() +
                    "Body_" +
                    particular_id +
                    '" class="ag-theme-quartz" style="height: 85%;"></div>'
                );

                // Set the headerName dynamically based on the rowData
                var headerName = "Total " + detailType + " Amount: " + totalAmounts; // Access the correct index

                // Create the footer card
                var footerCard = $('<div class="card totalFooter">');
                var cardBodyFooter = $('<div class="card-body col-11">');
                var footerGridDiv = $(
                    '<div class="text-right" style="margin-top: -10px;"></div>'
                );
                var headerNameSpan = $('<span class="total-text"></span>').text(headerName);
                footerGridDiv.append(headerNameSpan);
                cardBodyFooter.append(footerGridDiv);
                footerCard.append(cardBodyFooter);

                // Append footerCard inside cardBody
                cardBody.append(footerCard);

                card.append(cardBody);
                return card;
            }
            // Function to create detail cards
            function refreshDetailCard(
                detailType,
                particular_id,
                particular_name,
                particular,
                totalAmounts
            ) {
                var card = $(
                    '<div class="card cardNoBorder" id="' +
                    detailType.toLowerCase() +
                    "Card_" +
                    particular_id +
                    '">'
                );
                var cardHeader = $(
                    '<div class="card-header d-flex justify-content-between col-12 header-hover padding-header" data-card-widget="collapse">'
                );
                var headerContent = $(
                    '<div class="d-flex justify-content-between col-12">'
                );
                var title = $("<h5>").text(detailType);
                var cardTools = $('<div class="card-tools">');
                // Create the collapse button with a unique ID
                var collapseButton = $(
                    '<button type="button" class="btn btn-tool" data-card-widget="collapse">'
                ).append('<i class="fas fa-toggle-on" id="iconToggle"></i>'); // Initially set to fa-toggle-on
                // Create the add detail button
                var addDetailButton = $(
                    '<div class="btn btn-success btn-header" id="' +
                    detailType.toLowerCase() +
                    "Detail_" +
                    particular_id +
                    '" onclick="addDetailBtn(' +
                    particular_id +
                    ", '" +
                    detailType +
                    '\')"><i class="fa fa-plus"></i></div>'
                ).click(function(event) {
                    event.stopPropagation();
                });
                // Append elements to the header
                headerContent.append(
                    title,
                    cardTools.append(addDetailButton, collapseButton)
                );
                cardHeader.append(headerContent);
                card.append(cardHeader);

                // Toggle collapse when card header is clicked
                cardHeader.click(function() {
                    $(this).find("#iconToggle").toggleClass("fa-toggle-on fa-toggle-off");
                });

                // Add a div for the card body with a unique id
                var cardBody = $('<div class="card-body" style="height: 350px;">');
                // Add the div inside cardBody
                cardBody.append(
                    '<div id="' +
                    detailType.toLowerCase() +
                    "Body_" +
                    particular_id +
                    '" class="ag-theme-quartz" style="height: 85%;"></div>'
                );

                // Set the headerName dynamically based on the rowData
                var headerName = "Total " + detailType + " Amount: " + totalAmounts; // Access the correct index

                // Create the footer card
                var footerCard = $('<div class="card totalFooter">');
                var cardBodyFooter = $('<div class="card-body col-11">');
                var footerGridDiv = $(
                    '<div class="text-right" style="margin-top: -10px;"></div>'
                );
                var headerNameSpan = $('<span class="total-text"></span>').text(headerName);
                footerGridDiv.append(headerNameSpan);
                cardBodyFooter.append(footerGridDiv);
                footerCard.append(cardBodyFooter);

                // Append footerCard inside cardBody
                cardBody.append(footerCard);

                card.append(cardBody);
                return card;
            }

            function getProjects() {
                // Retrieve the selected project ID from localStorage
                var selectedProjectID = localStorage.getItem("projectID");
                $.ajax({
                    url: "{{ route('project.index') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // Iterate over each project
                        data.forEach(function(project) {
                            // Check if the project ID matches the selected project ID
                            if (project.project_id == selectedProjectID) {
                                // Populate input fields with project data based on their IDs
                                $("#add_project_id").val(project.project_id);
                                $("#add_project_title").val(project.project_title);
                                $("#add_project_location").val(project.project_location);
                                $("#add_project_owner").val(project.project_owner);
                                $("#add_project_description").val(
                                    project.project_description
                                );
                                $("#add_project_contract_duration").val(
                                    project.project_contract_duration
                                );
                                $("#add_project_appropriation").val(
                                    project.project_appropriation
                                );
                                $("#add_project_source_of_fund").val(
                                    project.project_source_of_fund
                                );
                                $("#add_project_date_prepared").val(
                                    project.project_date_prepared
                                );
                                $("#add_project_mode_of_implementation").val(
                                    project.project_mode_of_implementation
                                );
                                // Format existing values on page load
                                $('.numberInput').each(function() {
                                    let initialValue = $(this).val().replace(/,/g, '');
                                    if (initialValue !== '') {
                                        $(this).val(formatNumber(initialValue));
                                    }
                                    // Trigger the 'input' event to apply formatting
                                    $(this).trigger('input');
                                });

                                // Handle real-time input formatting (no changes needed here)
                                $('.numberInput').on('input', function() {
                                    let formattedValue = $(this).val().replace(/,/g, '');
                                    if (formattedValue !== '') {
                                        $(this).val(formatNumber(formattedValue));
                                    }
                                });
                            }
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
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            }

            // Retrieve project_id and project_title from localStorage
            var selectedProjectID = localStorage.getItem("projectID");
            var selectedProjectTitle = localStorage.getItem("projectTitle");

            // Set the values into the specified HTML elements
            $("#projectSelectedID").val(selectedProjectID);
            $("#projectSelectedTitle").text(selectedProjectTitle);

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
                                        const materialCategoryName = params.data.material_category_name;
                                        const materialPrice = params.data.material_price;
                                        const materialQuantity = params.data.material_quantity;
                                        const particularId = params.data
                                            .particular_id; // Changed from materialPartID to particularId

                                        // Construct the HTML string with the onclick event for edit and delete buttons
                                        const htmlString =
                                            '<div>' +
                                            '<button onclick="editDetail(\'' + detailType + '\', \'' +
                                            materialPartID + '\', \'' + materialId + '\', \'' +
                                            materialName + '\', \'' + materialUnit + '\', \'' +
                                            materialCategoryName + '\', \'' + materialPrice + '\', \'' +
                                            materialQuantity + '\', \'' + particularId +
                                            // Added particularId here
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
                                        return parseFloat(params.value * 8)
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
                                        const rate = params.data.labor_rate * 8;
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
                                        const particularID =
                                            params.data.project_particular_labor_id;

                                        // Construct the HTML string with the detailType and particularID
                                        const htmlString =
                                            "<div><button onclick=\"deleteDetail('" +
                                            detailType +
                                            "', " +
                                            particularID +
                                            ')" class="btn btn-danger btn-header"><i class="fas fa-trash-alt"></i></button></div>';

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

                                        // Construct the HTML string with the detailType and particularID
                                        const htmlString =
                                            "<div><button onclick=\"deleteDetail('" +
                                            detailType +
                                            "', " +
                                            particularID +
                                            ')" class="btn btn-danger btn-header"><i class="fas fa-trash-alt"></i></button></div>';

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

                        // Iterate through each filtered project item
                        sortedProjects.forEach(function(project) {
                            // Iterate through each particular item
                            project.particulars.forEach(function(particular) {
                                // Check if particular_id is particulardID and it's Material data
                                if (
                                    particular.particular_id === particularId &&
                                    particular.details.hasOwnProperty("Materials")
                                ) {
                                    console.log(particular.details.Materials)
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
                                        console.log('Successfully Append')
                                    } catch (error) {
                                        console.error('Error appending materialCard:', error);
                                        // Handle the error here
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
                                            8 *
                                            labor.labor_work_days *
                                            labor.labor_no_of_persons; // Update calculation
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

                                const cardIds = ["materialCard_" + particular.particular_id,
                                    "laborCard_" + particular.particular_id,
                                    "equipmentCard_" + particular.particular_id,
                                ];
                                cardIds.forEach((id) => {
                                    const cardToCollapse = document.getElementById(id);
                                    if (cardToCollapse) {
                                        cardToCollapse.classList.remove("collapsed-card");
                                    }
                                });

                            });
                        });
                    },
                });
            }

            function deleteDetail(detailType, partID) {
                // Show confirmation dialog
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to delete this record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
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

                                refreshAllData();
                                // Show success toast with delay
                                toastr.options.progressBar = true;
                                setTimeout(function() {
                                    toastr.success("Material Deleted Successfully!");
                                }, 1000);

                                // Handle success response
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                // Handle error response
                            },
                        });
                    }
                });
            }

            function addDetailBtn(particular_id, detailType) {
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

                            // Submit the Particular Material Modal Form
                            $("#addProjectPartMaterialForm").on("submit", function(event) {
                                event.preventDefault(); // Prevent the default form submission behavior
                                // Get the selected project ID from localStorage
                                var submitProjectID = localStorage.getItem("projectID");

                                // Disable the form to prevent multiple submissions
                                $(this).find(":input").prop("disabled", true);

                                // Get form data
                                let projectId = submitProjectID;
                                let particularId = particular_id;
                                let detail_type = detailType;
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
                                let materialPrice = $(
                                    "#add_particular_materialPrice"
                                ).val();
                                let materialQuarter = $(
                                    "#add_particular_materialQuarter"
                                ).val();
                                let materialYear = $(
                                    "#add_particular_materialYear"
                                ).val();

                                console.log(materialId);
                                console.log(materialName);


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
                                        // Re-enable the form for future submissions
                                        $("#addProjectPartMaterialForm")
                                            .find(":input")
                                            .prop("disabled", false);
                                        console.log(response);

                                        refreshAllData(particularId, detail_type);

                                        // Unbind the submit event handler to prevent multiple submissions
                                        $("#addProjectPartMaterialForm").off("submit");

                                        toastr.options.progressBar = true;
                                        toastr.success("Material Added Successfully!");
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error response from the server
                                        console.error(
                                            "Error submitting form data:",
                                            xhr.responseText
                                        );

                                        // Re-enable the form for future submissions
                                        $("#addProjectPartMaterialForm")
                                            .find(":input")
                                            .prop("disabled", false);
                                    },
                                });
                            });
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
                            console.log(response);
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

                            // Submit the Particular Labor Modal Form
                            $("#addProjectPartLaborForm").on("submit", function(event) {
                                event.preventDefault(); // Prevent the default form submission behavior

                                // Disable the form to prevent multiple submissions
                                $(this).find(":input").prop("disabled", true);

                                let submitProjectID = localStorage.getItem("projectID");
                                let projectId = submitProjectID;
                                let particularId = particular_id;
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
                                        console.log(response);
                                        $("#addProjectPartLaborForm")[0].reset();
                                        $("#addPartLaborModal").modal("hide");
                                        $("#addProjectPartLaborForm")
                                            .find(":input")
                                            .prop("disabled", false); // Re-enable the form

                                        refreshAllData(particularId);
                                        $("#addProjectPartLaborForm").off(
                                            "submit"); // Unbind submit event handler

                                        toastr.options.progressBar = true;
                                        toastr.success("Labor Added Successfully!");
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            "Error submitting form data:",
                                            xhr.responseText
                                        );
                                        $("#addProjectPartLaborForm")
                                            .find(":input")
                                            .prop("disabled", false); // Re-enable the form
                                    },
                                });
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
                            console.log(response);
                            var equipments = response.equipments; // Extract equipment data from the AJAX response

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

                            // Submit the Particular Equipment Modal Form
                            $("#addProjectPartEquipmentForm").on(
                                "submit",
                                function(event) {
                                    event.preventDefault(); // Prevent the default form submission behavior

                                    var submitProjectID = localStorage.getItem("projectID");
                                    // Disable the form to prevent multiple submissions
                                    $(this).find(":input").prop("disabled", true);

                                    let projectId = submitProjectID;
                                    let particularId = particular_id;
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
                                            $("#addProjectPartEquipmentForm")
                                                .find(":input")
                                                .prop("disabled", false); // Re-enable the form

                                            refreshAllData(particularId);
                                            $("#addProjectPartEquipmentForm").off(
                                                "submit"); // Unbind submit event handler

                                            toastr.options.progressBar = true;
                                            toastr.success("Equipment Added Successfully!");
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(
                                                "Error submitting form data:",
                                                xhr.responseText
                                            );
                                            $("#addProjectPartEquipmentForm")
                                                .find(":input")
                                                .prop("disabled", false); // Re-enable the form
                                        },
                                    });
                                }
                            );
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        },
                    });
                } else {
                    // Handle other cases
                }
            }
            refreshParticularTable();

            // Function to convert integer to Roman numeral
            function intToRoman(num) {
                const romanNumerals = [{
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
                return result;
            }

            // Populate the Table and Refresh at the same time
            function refreshParticularTable() {
                $.ajax({
                    url: "{{ route('getParticulars') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        // Get the selected project ID from localStorage
                        var selectedProjectID = localStorage.getItem("projectID");

                        var dropdownMenu = $("#addPartMenu .dropdown-menu");

                        // Clear existing dropdown items
                        dropdownMenu.empty();

                        // Loop through the data to find particulars for the selected project ID
                        data.forEach(function(project) {
                            if (project.project_id == selectedProjectID) {
                                // Sort the particulars for this project
                                project.particulars_available.forEach(function(particular) {
                                    var dropdownItem = $(
                                        '<a class="dropdown-item" href="#" data-particular-id="' +
                                        particular.particular_id +
                                        '">' +
                                        particular.particular_name +
                                        "</a>"
                                    );

                                    // Add onchange event handler to each dropdown item
                                    dropdownItem.on('click', function() {
                                        var particularId = $(this).data('particular-id');

                                        // Prepare data for AJAX request
                                        var requestData = {
                                            project_id: selectedProjectID,
                                            particular_id: particularId,
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
                                                console.log(
                                                    "Project particular successfully stored:",
                                                    response);
                                                // Reload the current page
                                                location.reload();
                                            },
                                            error: function(xhr, status, error) {
                                                // Handle error response
                                                console.error(
                                                    "Error storing project particular:",
                                                    xhr.responseText);
                                            }
                                        });
                                    });

                                    dropdownMenu.append(dropdownItem);
                                });
                            }
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
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
                        add_project_appropriation: appropriation,
                        add_project_source_of_fund: sourceOfFund,
                        add_project_date_prepared: datePrepared,
                        add_project_mode_of_implementation: modeOfImplementation,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        // Reset the form
                        $("#projectDetailsForm")[0].reset();
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
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
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
        </script>
        <!-- /.content -->
    @endsection
