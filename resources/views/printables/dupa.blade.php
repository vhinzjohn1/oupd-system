@extends('layouts.app')
@section('title', 'DUPA')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Latest Bootstrap 5.3 CSS -->
        <link rel="stylesheet" href="{{ asset('plugins/tom-select/bootstrap.min.css') }}">

        <style>
            body {
                height: 100vh;
            }

            @media print {
                .hideBtn {
                    display: none;
                }

                table {
                    margin-bottom: 10px;
                    border-color: black !important;
                }
            }

            table {
                margin-bottom: 10px;
            }

            table th,
            table td {
                padding: 1px;
            }

            .btn-right {
                position: absolute;
                right: 0;
            }

            .cmuLogoContainer {
                position: relative;
                float: left;
                /* Keep the container to the left */
                margin-right: 10px;
                /* Add margin for spacing if needed */
            }

            .cmuLogo {
                position: absolute;
                border-radius: 50%;
                width: 150px;
            }
        </style>
    </head>

    <body>
        <div class="btn hideBtn btn-right btn-lg btn-outline-dark" id="printView">Print</div>


        {{-- <!-- Project Details -->
        <div class="container text-center">
            <!-- CMU Logo -->
            <div class="cmuLogoContainer">
                <img src="{{ asset('/img/cmu.png') }}" class="cmuLogo" />
            </div> --}}

        <div class="container text-center">
            <div class="row mt-4">
                <div class="row mt-2">
                    <div class="d-flex flex-column align-items-center">
                        <div class="row mt-">
                            <h5>DETAILED UNIT PRICE ANALYSIS (DUPA)</h5> <!-- Default -->
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-start">
                        <div class="row row-cols-auto">
                            <div><strong>PROJECT TITLE:</strong></div>
                            <div class="col"><span id="projectTitle" style="font-size: 20px;"></span>
                            </div>
                        </div>
                        <div class="row row-cols-auto">
                            <div><strong>LOCATION:</strong></div>
                            <div class="col"><span id="projectLocation" style="font-size: 20px;"></span>
                            </div>
                        </div>
                        <div class="row row-cols-auto">
                            <div><strong>OWNER:</strong></div>
                            <div class="col"><span id="projectOwner" style="font-size: 20px;"></span></div> <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Particulars -->
        <div class="container-fluid">
            <!-- Loop through each particular -->
            <div class="row justify-content-center" id="particularsContainer"> <!-- Center horizontally -->
                <!-- Particular tables will be appended here -->
            </div>
        </div>

        <script>
            // Add an event listener to the button
            document.getElementById('printView').addEventListener('click', function() {
                // Call the print function when the button is clicked
                window.print();
            });

            $(document).ready(function() {
                // Make AJAX call to fetch project details
                $.ajax({
                    url: "{{ route('generatePDF.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        // Get the selected project ID from localStorage
                        var selectedProjectID = localStorage.getItem("projectID");

                        // Filter particulars by the selected project_id
                        var project = response.projects.find(p => p.project_id == selectedProjectID);

                        if (project) {
                            // Populate project details based on the selected project
                            $('#projectTitle').text(project.project_title);
                            $('#projectLocation').text(project.project_location);
                            $('#projectOwner').text(project.project_owner);
                            var directCostTotal = 0;

                            var totalMaterial = 0; // Declare these variables outside the loop
                            var totalLabor = 0;
                            var totalEquipment = 0;
                            var matTotal = 0;
                            var equipTotal = 0;
                            var labTotal = 0;
                            project.particulars.forEach(function(particular, index) {
                                var isMovingParticular = (particular.particular_name ===
                                    "MOVING-IN" || particular.particular_name === "MOVING-OUT");

                                // Calculate individual totals
                                matTotal += particular.totalMaterialAmount;
                                equipTotal += particular.totalEquipmentAmount;
                                labTotal += particular.totalLaborAmount;
                                dirCostAmount = matTotal + labTotal + equipTotal;
                                movingIn = (dirCostAmount * 0.01) / 2;
                                movingOut = (dirCostAmount * 0.01) / 2;
                                console.log('moving in: ', movingIn);
                            });
                            project.particulars.forEach(function(particular, index) {
                                var isMovingParticular = (particular.particular_name ===
                                    "MOVING-IN" || particular.particular_name === "MOVING-OUT");

                                var materials = particular.details.Materials || [];
                                var equipment = particular.details.Equipment || [];
                                var labor = particular.details.Labor || [];

                                var directCostTotal = particular.totalMaterialAmount + particular
                                    .totalLaborAmount + particular.totalEquipmentAmount;
                                var ocmTotal = directCostTotal * (particular.ocm / 100);
                                var cpTotal = directCostTotal * (particular.contractors_profit /
                                    100);
                                var indirectCostTotal = ocmTotal + cpTotal;
                                var vatTotal = (directCostTotal + indirectCostTotal) * (particular
                                    .vat / 100);
                                var totalCostItem = directCostTotal + indirectCostTotal + vatTotal;
                                var unitCostTotal = isMovingParticular ? movingIn : totalCostItem /
                                    particular.quantity;
                                console.log('unitcost: ', unitCostTotal)
                                // Create a new div for each particular name
                                var divHTML =
                                    '<table class="table table-bordered table-striped">' +
                                    '<thead>' +
                                    '<tr>' +
                                    '<th>ITEM NO.</th>' +
                                    '<th class="text-center">NAME OF ITEM</th>' +
                                    '<th class="text-center" colspan="2">QUANTITY & UNIT</th>' +
                                    '<th class="text-center">Unit Cost</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    //nakabold dapat ni
                                    '</td>' +
                                    '<td class="text-center">' + particular.particular_name +
                                    '</td>' +
                                    '<td class="text-right">' + particular.quantity + '</td>' +
                                    '<td class="text-center">' + particular.unit + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(unitCostTotal
                                        .toFixed(2)) + '</td>' +
                                    '</tr>';
                                // Create materials table
                                if (materials.length > 0) {
                                    var totalMaterial = 0;
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="5" class="text-center">MATERIALS</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th class="text-center">NAME & SPECIFICATION</th>' +
                                        '<th class="text-center">QUANTITY</th>' +
                                        '<th class="text-center">UNIT</th>' +
                                        '<th class="text-center">UNIT COST</th>' +
                                        '<th class="text-center">COST</th>' +
                                        '</tr>';
                                    // Append materials to the table
                                    materials.forEach(function(material) {
                                        totalMaterial += material.matAmount;
                                        divHTML += '<tr>' +
                                            '<td>' + material.material_name + '</td>' +
                                            '<td class="text-right">' + material
                                            .material_quantity +
                                            '</td>' +
                                            '<td class="text-center">' + material
                                            .material_unit + '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                material
                                                .material_price) + '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                parseFloat(material.matAmount).toFixed(
                                                    2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    console.log('total material: ', totalMaterial)
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">A. TOTAL FOR MATERIALS</th>' +
                                        '<th class="text-right">' + numberWithCommas(totalMaterial
                                            .toFixed(2)) + '</th>' +
                                        //nakabold dapat ni
                                        '</tr>';
                                } else {
                                    // No Materials available
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">MATERIALS</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th class="text-center">NAME & SPECIFICATION</th>' +
                                        '<th class="text-center">QUANTITY</th>' +
                                        '<th class="text-center">UNIT</th>' +
                                        '<th class="text-center">UNIT COST</th>' +
                                        '<th class="text-center">COST</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>';

                                    // Explicitly set totalLabor to 0
                                    var totalMaterial = 0;

                                    directCostTotal = totalMaterial + totalLabor + totalEquipment;

                                    // Display material total as dash (-) instead of 0.00 in the table
                                    var materialCostDisplay = '-'; // Use dash as placeholder

                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">A. TOTAL FOR MATERIALS</th>' +
                                        '<th class="text-end">' + materialCostDisplay + '</th>' +
                                        '</tr>';
                                }
                                // Create labor table
                                if (labor.length > 0) {
                                    var totalLabor = 0;
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">LABOR</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th class="text-center">DESIGNATION</th>' +
                                        '<th class="text-center">NO. OF PERSONS</th>' +
                                        '<th class="text-center">NO. OF DAYS</th>' +
                                        '<th class="text-center">DAILY RATE</th>' +
                                        '<th class="text-center">COST</th>' +
                                        '</tr>';
                                    // Append labor to the table
                                    labor.forEach(function(lab) {
                                        totalLabor += lab.labAmount;
                                        divHTML += '<tr>' +
                                            '<td>' + lab.labor_name + '</td>' +
                                            '<td class="text-right">' + lab
                                            .labor_no_of_persons +
                                            '</td>' +
                                            '<td class="text-right">' + lab
                                            .labor_work_days +
                                            '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                parseFloat(lab.labor_rate)
                                                .toFixed(
                                                    2)) +
                                            '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                parseFloat(lab.labAmount)
                                                .toFixed(
                                                    2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">B. TOTAL FOR LABOR</th>' +
                                        '<th class="text-right">' + numberWithCommas(totalLabor
                                            .toFixed(2)) +
                                        //nakabold dapat ni
                                        '</th>' +
                                        '</tr>';
                                } else {
                                    // No labor available
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">LABOR</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th class="text-center">DESIGNATION</th>' +
                                        '<th class="text-center">NO. OF PERSONS</th>' +
                                        '<th class="text-center">NO. OF DAYS</th>' +
                                        '<th class="text-center">DAILY RATE</th>' +
                                        '<th class="text-center">COST</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>';

                                    // Explicitly set totalEquipment to 0
                                    var totalLabor = 0;

                                    directCostTotal = totalMaterial + totalLabor + totalEquipment;

                                    // Display material total as dash (-) instead of 0.00 in the table
                                    var laborCostDisplay = '-'; // Use dash as placeholder

                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">B. TOTAL FOR LABOR</th>' +
                                        '<th class="text-end">' + laborCostDisplay + '</th>' +
                                        '</tr>';
                                }
                                // Create equipment table
                                if (equipment.length > 0) {
                                    var totalEquipment = 0;
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">EQUIPMENT</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th class="text-center">NAME & CAPACITY</th>' +
                                        '<th class="text-center">NO. OF UNITS</th>' +
                                        '<th class="text-center">NO. OF DAYS</th>' +
                                        '<th class="text-center">DAILY RATE</th>' +
                                        '<th class="text-center">COST</th>' +
                                        '</tr>';
                                    // Append equipment to the table
                                    equipment.forEach(function(equip) {
                                        totalEquipment += equip.equipAmount;
                                        divHTML += '<tr>' +
                                            '<td>' + equip.equipment_name + '</td>' +
                                            '<td class="text-right">' + equip
                                            .equipment_no_of_units +
                                            '</td>' +
                                            '<td class="text-right">' + equip
                                            .equipment_work_days +
                                            '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                parseFloat(equip
                                                    .equipment_rate).toFixed(
                                                    2)) +
                                            '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                parseFloat(equip.equipAmount).toFixed(
                                                    2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    // Close equipment table
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">C. TOTAL FOR EQUIPMENT</th>' +
                                        '<th class="text-right">' + numberWithCommas(totalEquipment
                                            .toFixed(
                                                2)) + //nakabold dapat ni
                                        '</th>' +
                                        '</tr>';
                                } else {
                                    // No Equipment available
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">EQUIPMENT</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th class="text-center">NAME & CAPACITY</th>' +
                                        '<th class="text-center">NO. OF UNITS</th>' +
                                        '<th class="text-center">NO. OF DAYS</th>' +
                                        '<th class="text-center">DAILY RATE</th>' +
                                        '<th class="text-center">COST</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td style="height: 40px;"></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '</tr>';

                                    // Explicitly set totalEquipment to 0
                                    var totalEquipment = 0;
                                    // Calculate total for this particular (including material total as 0)
                                    directCostTotal = totalMaterial + totalLabor + totalEquipment;

                                    // Display material total as dash (-) instead of 0.00 in the table
                                    var equipmentCostDisplay = '-'; // Use dash as placeholder

                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">C. TOTAL FOR EQUIPMENT</th>' +
                                        '<th class="text-end">' + equipmentCostDisplay + '</th>' +
                                        '</tr>';
                                }
                                directCostTotal = totalMaterial + totalLabor + totalEquipment;
                                var ocmTotal = directCostTotal * (particular.ocm / 100);
                                var cpTotal = directCostTotal * (particular.contractors_profit /
                                    100);
                                var indirectCostTotal = ocmTotal + cpTotal;
                                var vatTotal = (directCostTotal + indirectCostTotal) * (particular
                                    .vat / 100);
                                var totalCostItem = directCostTotal + indirectCostTotal + vatTotal;
                                var unitCostTotal = totalCostItem / particular.quantity;
                                console.log('vat: ', directCostTotal)
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">D. ESTIMATED DIRECT COST (A+B+C)</th>' +
                                    '<th class="text-right">' + numberWithCommas(directCostTotal
                                        .toFixed(2)) +
                                    //nakabold dapat
                                    '</th>' +
                                    '</tr>';
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">E. INDIRECT COST (MARK-UPS)</th>' +
                                    '<th class="text-right">' + numberWithCommas(indirectCostTotal
                                        .toFixed(2)) + //nakabold dapat ni
                                    '</th>' +
                                    '</tr>';

                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-start"></td>' +
                                    '<td colspan="2" class="text-start">1. OVERHEAD, CONTINGENCY & MISCELLANEOUS (' +
                                    project.ocm + '% of EDC)</td>' +
                                    '<td class="text-right">' + project.ocm + '%' + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(ocmTotal.toFixed(
                                        2)) +
                                    '</td>' +
                                    '</tr>';

                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-start"></td>' +
                                    '<td colspan="2" class="text-start">2. CONTRACTORS PROFIT (' +
                                    project.contractors_profit + ' of EDC)</td>' +
                                    '<td class="text-right">' + project.contractors_profit + '%' +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(cpTotal.toFixed(
                                        2)) +
                                    '</td>' +
                                    '</tr>';
                                console.log('cp:', cpTotal)
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="3" class="text-start">F. VAT (TOTAL ABOVE COST)</th>' +
                                    '<td class="text-right">' + project.vat + '%' +
                                    '</td>' +
                                    '<th class="text-right">' + numberWithCommas(vatTotal.toFixed(
                                        2)) +
                                    //nakabold dapat ni
                                    '</th>' +
                                    '</tr>';
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">G. TOTAL COST ITEM (D+E+F)</th>' +
                                    '<th class="text-right">' + numberWithCommas(totalCostItem
                                        .toFixed(2)) +
                                    //nakabold dapat ni
                                    '</th>' +
                                    '</tr>';
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">H. UNIT COST (TOTAL COST OF ITEM/QUANTITY)</th>' +
                                    '<th class="text-right">' + numberWithCommas(unitCostTotal
                                        .toFixed(2)) +
                                    //nakabold dapat ni
                                    '</th>' +
                                    '</tr>' +
                                    '</tbody>' +
                                    '</table>' +
                                    '<div class="container">' +
                                    '<div class="row mt-4">' +
                                    '<div class="col-6">' +
                                    '<div class="d-flex flex-column align-items-center">' +
                                    '<div class="d-flex flex-column align-items-start">' +
                                    '<div>' +
                                    'Prepared by: <br><br>';
                                project.signatures.forEach(function(signature) {
                                    if (signature.role === 'Prepared by') {
                                        divHTML +=
                                            '<div style="text-align: center;">' +
                                            '<b><u>' + signature.fullname +
                                            '</u></b> <br>' +
                                            signature.position +
                                            '</div>' +
                                            '</div> <br>';
                                    }
                                });
                                divHTML +=
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                    '<div class="d-flex flex-column align-items-center">' +
                                    '<div class="d-flex flex-column align-items-start">' +
                                    '<div>' +
                                    'Checked by: <br><br>';
                                project.signatures.forEach(function(signature) {
                                    if (signature.role === 'Checked by') {
                                        divHTML +=
                                            '<div style="text-align: center;">' +
                                            '<b><u>' + signature.fullname +
                                            '</u></b> <br>' +
                                            signature.position +
                                            '</div>' +
                                            '</div><br>';
                                    }
                                });
                                divHTML +=
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div> <br>' +
                                    '</div>';
                                // Close div
                                divHTML += '</div>';

                                // Append the div to the container
                                $('#particularsContainer').append(divHTML);

                                $('#projectLocation, #projectOwner, #projectSubject').text(function(
                                    _, text) {
                                    return text.toUpperCase();
                                });

                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr);
                    }
                });
            });

            // Function to add commas to thousands
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            // Function to convert number to Roman numeral
            function getRomanNumeral(num) {
                const romanNumerals = {
                    M: 1000,
                    CM: 900,
                    D: 500,
                    CD: 400,
                    C: 100,
                    XC: 90,
                    L: 50,
                    XL: 40,
                    X: 10,
                    IX: 9,
                    V: 5,
                    IV: 4,
                    I: 1
                };
                let result = '';
                for (let key in romanNumerals) {
                    while (num >= romanNumerals[key]) {
                        result += key;
                        num -= romanNumerals[key];
                    }
                }
                return result;
            }
        </script>

    </body>

    </html>
@endsection
