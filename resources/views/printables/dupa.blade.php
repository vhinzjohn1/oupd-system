@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Generate PDF</title>
        <!-- jQuery -->
        <script src="../../plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

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
                        <div><strong>PROJECT TITLE:</strong> <span id="projectTitle" style="font-size: 20px;"></span>
                        </div>
                        <div><strong>LOCATION:</strong> <span id="projectLocation" style="font-size: 20px;"></span>
                        </div>
                        <div><strong>OWNER:</strong> <span id="projectOwner" style="font-size: 20px;"></span></div> <br>
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
                        // Populate project details
                        $('#projectTitle').text(response.projects[0].project_title);
                        $('#projectLocation').text(response.projects[0].project_location);
                        $('#projectOwner').text(response.projects[0].project_owner);

                        // Get the selected project ID from localStorage
                        var selectedProjectID = localStorage.getItem("projectID");

                        // Filter particulars by the selected project_id
                        var project = response.projects.find(p => p.project_id == selectedProjectID);

                        if (project) {
                            var directCostTotalAmount = 0;
                            var indirectCostTotalAmount = 0;
                            var cpTotalAmount = 0;
                            var ocmTotalAmount = 0;
                            var indirectCostTotalAmount = 0;
                            project.particulars.forEach(function(particular, index, project_particular) {
                                var materials = particular.details.Materials || [];
                                var equipment = particular.details.Equipment || [];
                                var labor = particular.details.Labor || [];

                                var materialTotalAmount = 0;
                                var equipmentTotalAmount = 0;
                                var laborTotalAmount = 0;

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
                                    '<td class="text-right">' + numberWithCommas(parseFloat(
                                        particular.unit_cost).toFixed(2)) + '</td>' +
                                    '</tr>';
                                // Create materials table
                                if (materials.length > 0) {
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="5" class="text-center">Materials</th>' +
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
                                        var amount = parseFloat(material
                                            .material_quantity) * parseFloat(
                                            material
                                            .material_price);
                                        materialTotalAmount += amount;
                                        // Store total amounts in localStorage
                                        localStorage.setItem('materialTotalAmount',
                                            materialTotalAmount);
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
                                                amount.toFixed(
                                                    2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">A. TOTAL FOR MATERIALS</th>' +
                                        '<th class="text-right">' + numberWithCommas(
                                            materialTotalAmount
                                            .toFixed(2)) + '</th>' + //nakabold dapat ni
                                        '</tr>';
                                } else {
                                    // No Materials available
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">Materials</th>' +
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

                                    // Calculate total for this particular (including material total as 0)
                                    var totalAmount = materialTotalAmount + equipmentTotalAmount +
                                        laborTotalAmount;
                                    directCostTotalAmount += totalAmount;

                                    // Display material total as dash (-) instead of 0.00 in the table
                                    var materialCostDisplay = '-'; // Use dash as placeholder

                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">A. TOTAL FOR MATERIALS</th>' +
                                        '<th class="text-end">' + materialCostDisplay + '</th>' +
                                        '</tr>';
                                }

                                // Create equipment table
                                if (equipment.length > 0) {
                                    var equipmentTotalAmount = 0;
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">Equipment</th>' +
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
                                        var amount = equip
                                            .equipment_work_days * equip
                                            .equipment_no_of_units *
                                            equip.equipment_rate;
                                        equipmentTotalAmount += amount;
                                        // Store total amounts in localStorage
                                        localStorage.setItem('equipmentTotalAmount',
                                            equipmentTotalAmount);
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
                                                amount.toFixed(
                                                    2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    // Close equipment table
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">B. TOTAL FOR EQUIPMENT</th>' +
                                        '<th class="text-right">' + numberWithCommas(
                                            equipmentTotalAmount.toFixed(
                                                2)) + //nakabold dapat ni
                                        '</th>' +
                                        '</tr>';
                                } else {
                                    // No Equipment available
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">Equipment</th>' +
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

                                    // Explicitly set equipmentTotalAmount to 0
                                    var equipmentTotalAmount = 0;

                                    // Calculate total for this particular (including equipment total as 0)
                                    var totalAmount = materialTotalAmount + equipmentTotalAmount +
                                        laborTotalAmount;
                                    directCostTotalAmount += totalAmount;

                                    // Display equipment total as dash (-) instead of 0.00 in the table
                                    var equipmentCostDisplay = '-'; // Use dash as placeholder

                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">B. TOTAL FOR EQUIPMENT</th>' +
                                        '<th class="text-end">' + equipmentCostDisplay + '</th>' +
                                        '</tr>';
                                }

                                // Create labor table
                                if (labor.length > 0) {
                                    var laborTotalAmount = 0;
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">Labor</th>' +
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
                                        var newRate = lab
                                            .labor_rate *
                                            8; // Convert rate to per day
                                        var amount = lab.labor_no_of_persons * lab
                                            .labor_work_days *
                                            newRate;
                                        laborTotalAmount += amount;
                                        // Store total amounts in localStorage
                                        localStorage.setItem('laborTotalAmount',
                                            laborTotalAmount);
                                        divHTML += '<tr>' +
                                            '<td>' + lab.labor_name + '</td>' +
                                            '<td class="text-right">' + lab
                                            .labor_no_of_persons +
                                            '</td>' +
                                            '<td class="text-right">' + lab
                                            .labor_work_days +
                                            '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                newRate
                                                .toFixed(
                                                    2)) +
                                            '</td>' +
                                            '<td class="text-right">' + numberWithCommas(
                                                amount
                                                .toFixed(
                                                    2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">C. TOTAL FOR LABOR</th>' +
                                        '<th class="text-right">' + numberWithCommas(
                                            laborTotalAmount.toFixed(2)) +
                                        //nakabold dapat ni
                                        '</th>' +
                                        '</tr>';
                                } else {
                                    // No labor available
                                    divHTML +=
                                        '<tr>' +
                                        '<th class="text-center" colspan="5">Labor</th>' +
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

                                    // Explicitly set laborTotalAmount to 0
                                    var laborTotalAmount = 0;

                                    // Calculate total for this particular (including labor total as 0)
                                    var totalAmount = materialTotalAmount + equipmentTotalAmount +
                                        laborTotalAmount;
                                    directCostTotalAmount += totalAmount;

                                    // Display labor total as dash (-) instead of 0.00 in the table
                                    var laborCostDisplay = '-'; // Use dash as placeholder

                                    divHTML +=
                                        '<tr>' +
                                        '<th colspan="4" class="text-start">C. TOTAL FOR LABOR</th>' +
                                        '<th class="text-end">' + laborCostDisplay + '</th>' +
                                        '</tr>';
                                }

                                var totalAmount = materialTotalAmount +
                                    laborTotalAmount + equipmentTotalAmount;
                                directCostTotalAmount = totalAmount;
                                // Store total amounts in localStorage
                                localStorage.setItem('directCostTotalAmount',
                                    directCostTotalAmount);
                                console.log(directCostTotalAmount);
                                var ocmTotalAmount = directCostTotalAmount * (project.ocm / 100);
                                var cpTotalAmount = directCostTotalAmount * (project
                                    .contractors_profit / 100);
                                var indirectCostTotalAmount = ocmTotalAmount + cpTotalAmount;
                                console.log(indirectCostTotalAmount);
                                var vatTotalAmount = (directCostTotalAmount +
                                    indirectCostTotalAmount) * (project.vat / 100);
                                // Store total amounts in localStorage
                                localStorage.setItem('vatTotalAmount',
                                    vatTotalAmount);

                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">D. ESTIMATED DIRECT COST (A+B+C)</th>' +
                                    '<th class="text-right">' + numberWithCommas(
                                        directCostTotalAmount.toFixed(2)) +
                                    //nakabold dapat
                                    '</th>' +
                                    '</tr>';
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">E. INDIRECT COST (MARK-UPS)</th>' +
                                    '<th class="text-right">' + numberWithCommas(
                                        indirectCostTotalAmount
                                        .toFixed(2)) + //nakabold dapat ni
                                    '</th>' +
                                    '</tr>';
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-start"></td>' +
                                    '<td colspan="2" class="text-start">1. OVERHEAD, CONTINGENCY & MISCELLANEOUS (15% of DC)</td>' +
                                    '<td class="text-start">' + project.ocm + '%' + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(ocmTotalAmount
                                        .toFixed(2)) +
                                    '</td>' +
                                    '</tr>';

                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-start"></td>' +
                                    '<td colspan="2" class="text-start">2. CONTRACTORS PROFIT (10% of DC)</td>' +
                                    '<td class="text-start">' + project.contractors_profit + '%' +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(cpTotalAmount
                                        .toFixed(2)) +
                                    '</td>' +
                                    '</tr>';
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">F. VAT (TOTAL ABOVE COST)</th>' +
                                    '<th class="text-right">' + numberWithCommas(vatTotalAmount
                                        .toFixed(2)) +
                                    //nakabold dapat ni
                                    '</th>' +
                                    '</tr>';
                                var itemCostTotalAmount = 0;
                                var itemCostTotalAmount = directCostTotalAmount +
                                    indirectCostTotalAmount + vatTotalAmount;
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">G. TOTAL COST ITEM (D+E+F)</th>' +
                                    '<th class="text-right">' + numberWithCommas(itemCostTotalAmount
                                        .toFixed(2)) +
                                    //nakabold dapat ni
                                    '</th>' +
                                    '</tr>';
                                var unitCostTotalAmount = 0;
                                var totalAmount = itemCostTotalAmount / particular.quantity;
                                unitCostTotalAmount = totalAmount;
                                divHTML +=
                                    '<tr>' +
                                    '<th colspan="4" class="text-start">H. UNIT COST (TOTAL COST OF ITEM/QUANTITY)</th>' +
                                    '<th class="text-right">' + numberWithCommas(unitCostTotalAmount
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
                                    'Re-evaluated by: <br><br>' +
                                    '<div style="text-align: center;">' +
                                    '<u><b>FRITZ MILDRED N. PUABEN</b></u> <br>' +
                                    'Draftsman I, OUPD' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                    '<div class="d-flex flex-column align-items-center">' +
                                    '<div class="d-flex flex-column align-items-start">' +
                                    '<div>' +
                                    'Checked by: <br><br>' +
                                    '<div style="text-align: center;">' +
                                    '<u><b>MARIA EILANI N. NON</b></u> <br>' +
                                    'Engineer II, OUPD' +
                                    '</div>' +
                                    '</div>' +
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
