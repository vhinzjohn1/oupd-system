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


        <!-- Project Details -->
        <div class="container text-center">
            <!-- CMU Logo -->
            <div class="cmuLogoContainer">
                <img src="{{ asset('/img/cmu.png') }}" class="cmuLogo" />
            </div>



            <div id="projectDetails">
                <p><strong>PROJECT TITLE:</strong> <span id="projectTitle" style="font-size: 20px;"></span></p>
                <p><strong>LOCATION:</strong> <span id="projectLocation" style="font-size: 20px;"></span></p>
                <p><strong>OWNER:</strong> <span id="projectOwner" style="font-size: 20px;"></span></p>
                <p><strong>SUBJECT:</strong> <span id="projectSubject" style="font-size: 20px;"></span></p>
            </div>
            <h5>PROGRAM OF WORKS</h5> <!-- Default -->
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

                        // Filter particulars by project_id
                        var projectId = 1; // Change this value to the desired project_id
                        var project = response.projects.find(p => p.project_id === projectId);
                        if (project) {
                            project.particulars.forEach(function(particular, index) {
                                var materials = particular.details.Materials;
                                var equipment = particular.details.Equipment;
                                var labor = particular.details.Labor;

                                // Create a new div for each particular name
                                var divHTML = '<div class="col-10">' +
                                    '<h5 class="text-left">' + getRomanNumeral(index + 1) + '. ' +
                                    particular.particular_name +
                                    '</h5>';

                                // Create materials table
                                if (materials.length > 0) {
                                    var materialTotalAmount = 0;
                                    divHTML +=
                                        '<table class="table table-sm text-center table-bordered">' +
                                        '<thead>' +
                                        '<tr>' +
                                        '<th colspan="5">Materials</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th>Particulars</th>' +
                                        '<th>Quantity</th>' +
                                        '<th>Unit</th>' +
                                        '<th>Unit Cost</th>' +
                                        '<th>Amount</th>' +
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody>';
                                    // Append materials to the table
                                    materials.forEach(function(material) {
                                        var amount = parseFloat(material
                                            .material_quantity) * parseFloat(material
                                            .material_price);
                                        materialTotalAmount += amount;
                                        divHTML += '<tr>' +
                                            '<td>' + material.material_name + '</td>' +
                                            '<td>' + material.material_quantity + '</td>' +
                                            '<td>' + material.material_unit + '</td>' +
                                            '<td>' + numberWithCommas(material
                                                .material_price) + '</td>' +
                                            '<td>' + numberWithCommas(amount.toFixed(2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    // Close materials table
                                    divHTML += '</tbody>' +
                                        '<tfoot>' +
                                        '<tr>' +
                                        '<td colspan="4" class="text-right"><strong>Total</strong></td>' +
                                        '<td>' + numberWithCommas(materialTotalAmount
                                            .toFixed(2)) + '</td>' +

                                        '</tr>' +
                                        '</tfoot>' +
                                        '</table>';
                                }

                                // Create labor table
                                if (labor.length > 0) {
                                    var laborTotalAmount = 0;
                                    divHTML +=
                                        '<table class="table table-sm text-center table-bordered">' +
                                        '<thead>' +
                                        '<tr>' +
                                        '<th colspan="5">Labor</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th>Labor</th>' +
                                        '<th>Work Days</th>' +
                                        '<th>Location</th>' +
                                        '<th>Rate</th>' +
                                        '<th>Amount</th>' +
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody>';
                                    // Append labor to the table
                                    labor.forEach(function(lab) {
                                        var newRate = parseFloat(lab.labor_rate) *
                                            8; // Convert rate to per day
                                        var amount = parseFloat(lab.labor_work_days) *
                                            newRate;
                                        laborTotalAmount += amount;
                                        divHTML += '<tr>' +
                                            '<td>' + lab.labor_name + '</td>' +
                                            '<td>' + lab.labor_work_days + '</td>' +
                                            '<td>' + lab.labor_location + '</td>' +
                                            '<td>' + numberWithCommas(newRate.toFixed(2)) +
                                            '</td>' +
                                            '<td>' + numberWithCommas(amount.toFixed(2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    // Close labor table
                                    divHTML += '</tbody>' +
                                        '<tfoot>' +
                                        '<tr>' +
                                        '<td colspan="4" class="text-right"><strong>Total</strong></td>' +
                                        '<td>' + numberWithCommas(laborTotalAmount.toFixed(2)) +
                                        '</td>' +
                                        '</tr>' +
                                        '</tfoot>' +
                                        '</table>';
                                }

                                // Create equipment table
                                if (equipment.length > 0) {
                                    var equipmentTotalAmount = 0;
                                    divHTML +=
                                        '<table class="table table-sm text-center table-bordered">' +
                                        '<thead>' +
                                        '<tr>' +
                                        '<th colspan="4">Equipment</th>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<th>Equipment</th>' +
                                        '<th>Work Days</th>' +
                                        '<th>Rate</th>' +
                                        '<th>Amount</th>' +
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody>';
                                    // Append equipment to the table
                                    equipment.forEach(function(equip) {
                                        var newRate = parseFloat(equip.equipment_rate) *
                                            8; // Convert rate to per day
                                        var amount = parseFloat(equip.equipment_work_days) *
                                            newRate;
                                        equipmentTotalAmount += amount;
                                        divHTML += '<tr>' +
                                            '<td>' + equip.equipment_name + '</td>' +
                                            '<td>' + equip.equipment_work_days + '</td>' +
                                            '<td>' + numberWithCommas(newRate.toFixed(2)) +
                                            '</td>' +
                                            '<td>' + numberWithCommas(amount.toFixed(2)) +
                                            '</td>' +
                                            '</tr>';
                                    });
                                    // Close equipment table
                                    divHTML += '</tbody>' +
                                        '<tfoot>' +
                                        '<tr>' +
                                        '<td colspan="3" class="text-right"><strong>Total</strong></td>' +
                                        '<td>' + numberWithCommas(equipmentTotalAmount.toFixed(2)) +
                                        '</td>' +
                                        '</tr>' +
                                        '</tfoot>' +
                                        '</table>';
                                }
                                // Add total cost for each particular
                                divHTML += '<div class="container text-center">';
                                if (materials.length > 0) {
                                    divHTML +=
                                        '<div class="d-flex justify-content-center align-items-start"><div style="width: 200px; text-align: left;"><strong>Total Cost Material:</strong></div>';
                                    divHTML += '<div style="text-align: left;">' + numberWithCommas(
                                        materialTotalAmount.toFixed(2)) + '</div></div>';
                                }
                                if (labor.length > 0) {
                                    divHTML +=
                                        '<div class="d-flex justify-content-center align-items-start"><div style="width: 200px; text-align: left;"><strong>Total Cost Labor:</strong></div>';
                                    divHTML += '<div style="text-align: left;">' + numberWithCommas(
                                        laborTotalAmount.toFixed(2)) + '</div></div>';
                                }
                                if (equipment.length > 0) {
                                    divHTML +=
                                        '<div class="d-flex justify-content-center align-items-start"><div style="width: 200px; text-align: left;"><strong>Total Cost Equipment:</strong></div>';
                                    divHTML += '<div style="text-align: left;">' + numberWithCommas(
                                        equipmentTotalAmount.toFixed(2)) + '</div></div>';
                                }
                                divHTML +=
                                    '<div class="d-flex justify-content-center align-items-start"><div style="width: 200px; text-align: left;"><strong>Total Cost Item ' +
                                    getRomanNumeral(index + 1) +
                                    ':</strong></div>'; // Roman Numerals of that particular
                                // Calculate total cost dynamically
                                var totalCost = 0;
                                if (!isNaN(materialTotalAmount)) {
                                    totalCost += materialTotalAmount;
                                }
                                if (!isNaN(laborTotalAmount)) {
                                    totalCost += laborTotalAmount;
                                }
                                if (!isNaN(equipmentTotalAmount)) {
                                    totalCost += equipmentTotalAmount;
                                }
                                divHTML += '<div style="text-align: left;">' + numberWithCommas(
                                    totalCost.toFixed(2)) + '</div></div>';
                                divHTML += '</div>';



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
