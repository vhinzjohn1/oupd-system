@extends('layouts.app')
@section('title', 'POW')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Generate PDF</title>

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
        </style>
    </head>

    <body>
        <div class="btn hideBtn btn-right btn-lg btn-outline-dark" id="printView">Print</div>


        {{-- <!-- Project Details -->
        <div class="container text-center">

            <div id="projectDetails">
                <p><strong>PROJECT TITLE:</strong> <span id="projectTitle" style="font-size: 20px;"></span></p>
                <p><strong>LOCATION:</strong> <span id="projectLocation" style="font-size: 20px;"></span></p>
                <p><strong>OWNER:</strong> <span id="projectOwner" style="font-size: 20px;"></span></p>
                <p><strong>SUBJECT:</strong> <span id="projectSubject" style="font-size: 20px;"></span></p>
            </div>
            <h5>PROGRAM OF WORKS</h5> <!-- Default -->
        </div> --}}

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

                        // Get The sorted Value
                        const sortedItem = JSON.parse(localStorage.getItem(
                            'sortableOrder'));
                        console.log(sortedItem);
                        if (project) {
                            project.particulars.forEach(function(particular, index) {
                                var materials = particular.details.Materials;
                                var labor = particular.details.Labor;
                                var equipment = particular.details.Equipment;
                                var divHTML =
                                    '<div class="container text-center">' +
                                    '<div>' +
                                    '<p><strong>PROJECT TITLE: ' + project.project_title +
                                    '</strong></p>' +
                                    '<p><strong>LOCATION: ' + project.project_location +
                                    '</strong></p>' +
                                    '<p><strong>OWNER: ' + project.project_owner + '</strong></p>' +
                                    '<p><strong>SUBJECT:</strong></p>' +
                                    '</div>' +
                                    '<h5>PROGRAM OF WORKS</h5>' +
                                    '</div>';


                                // Check if the particular is a moving-in or moving-out
                                if (particular.particular_name === "MOVING-IN" || particular
                                    .particular_name === "MOVING-OUT") {
                                    // Display only the Roman numeral and the particular name
                                    divHTML += '<div class="col-10">' +
                                        '<div class="row">' +
                                        '<div class="col-md-6">' +
                                        '<h5 class="text-left">' + getRomanNumeral(index + 1) +
                                        '. ' + particular.particular_name + '</h5>' +
                                        '</div>' +
                                        '<div class="col-md-6">' +
                                        '<h5 class="text-right">' + numberWithCommas(parseFloat(
                                            particular.total).toFixed(2)) + '</h5>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                                } else {

                                    // Create a new div for each particular name
                                    var divHTML = '<div class="col-10">' +
                                        '<h5 class="text-left">' + getRomanNumeral(index + 1) +
                                        '. ' +
                                        particular.particular_name +
                                        '</h5>';

                                    // Create materials table
                                    if (materials.length > 0) {
                                        var materialTotalAmount = 0;
                                        divHTML +=
                                            '<div>1.0 Materials :</div>' +
                                            '<table class="table table-sm text-center table-bordered">' +
                                            '<thead>' +
                                            '<tr>' +
                                            // '<th colspan="5">Materials</th>' +
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
                                                .material_quantity) * parseFloat(
                                                material
                                                .material_price);
                                            materialTotalAmount += amount;
                                            divHTML += '<tr>' +
                                                '<td>' + material.material_name +
                                                '</td>' +
                                                '<td>' + material.material_quantity +
                                                '</td>' +
                                                '<td>' + material.material_unit +
                                                '</td>' +
                                                '<td>' + numberWithCommas(material
                                                    .material_price) + '</td>' +
                                                '<td>' + numberWithCommas(amount
                                                    .toFixed(
                                                        2)) +
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
                                        var laborMandays = 0;
                                        divHTML +=
                                            '<div class="row">' +
                                            '<div class="col-sm-3">' + '2.0 Labor :' +
                                            '</div>' +
                                            '<div class="col-sm-3">' + particular.totalLabMandays +
                                            '&nbsp&nbsp&nbsp&nbsp Mandays</div>' +
                                            '</div>' +
                                            '<table class="table table-sm text-center table-bordered">' +
                                            '<thead>' +
                                            '<tr>' +
                                            // '<th colspan="5">Labor</th>' +
                                            '</tr>' +
                                            '<tr>' +
                                            '<th>Particulars</th>' +
                                            '<th>No. of Person</th>' +
                                            '<th>Work Days</th>' +
                                            '<th>Rate per day</th>' +
                                            '<th>Amount</th>' +
                                            '</tr>' +
                                            '</thead>' +
                                            '<tbody>';
                                        // Append labor to the table
                                        labor.forEach(function(lab) {
                                            var amount = parseFloat(lab
                                                    .labor_no_of_persons) *
                                                parseFloat(lab.labor_work_days) *
                                                parseFloat(lab.labor_rate);
                                            laborTotalAmount += amount;
                                            divHTML += '<tr>' +
                                                '<td>' + lab.labor_name + '</td>' +
                                                '<td>' + lab.labor_no_of_persons +
                                                '</td>' +
                                                '<td>' + lab.labor_work_days + '</td>' +
                                                '<td>' + numberWithCommas(parseFloat(lab
                                                    .labor_rate).toFixed(2)) +
                                                '</td>' +
                                                '<td>' + numberWithCommas(amount
                                                    .toFixed(
                                                        2)) +
                                                '</td>' +
                                                '</tr>';
                                        });
                                        // Close labor table
                                        divHTML += '</tbody>' +
                                            '<tfoot>' +
                                            '<tr>' +
                                            '<td colspan="4" class="text-right"><strong>Total</strong></td>' +
                                            '<td>' + numberWithCommas(laborTotalAmount.toFixed(
                                                2)) +
                                            '</td>' +
                                            '</tr>' +
                                            '</tfoot>' +
                                            '</table>';
                                        // console.log('total mandays:',
                                        //     laborMandays
                                        // ); // Total Mandays for all labor entries
                                        console.log('labor total amount:',
                                            laborTotalAmount
                                        ); // Total Amount for all labor entries
                                    }

                                    // Create equipment table
                                    if (equipment.length > 0) {
                                        var equipmentTotalAmount = 0;
                                        var equipmentMandays = 0;
                                        divHTML +=
                                            '<div class="row">' +
                                            '<div class="col-sm-3">' + '3.0 Equipment :' +
                                            '</div>' +
                                            '<div class="col-sm-3">' + particular
                                            .totalEquipMandays +
                                            '&nbsp&nbsp&nbsp&nbsp Mandays</div>' +
                                            '</div>' +
                                            '<table class="table table-sm text-center table-bordered">' +
                                            '<thead>' +
                                            '<tr>' +
                                            // '<th colspan="5">Equipment</th>' +
                                            '</tr>' +
                                            '<tr>' +
                                            '<th>Particulars</th>' +
                                            '<th>No. of Unit</th>' +
                                            '<th>Work Days</th>' +
                                            '<th>Rate per day</th>' +
                                            '<th>Amount</th>' +
                                            '</tr>' +
                                            '</thead>' +
                                            '<tbody>';
                                        // Append equipment to the table
                                        equipment.forEach(function(equip) {
                                            var mandays = parseFloat(equip
                                                    .equipment_no_of_units) *
                                                parseFloat(equip.equipment_work_days);
                                            equipmentMandays += mandays;
                                            var amount = parseFloat(equip
                                                    .equipment_work_days) *
                                                parseFloat(equip.equipment_rate);
                                            equipmentTotalAmount += amount;
                                            divHTML += '<tr>' +
                                                '<td>' + equip.equipment_name +
                                                '</td>' +
                                                '<td>' + equip.equipment_no_of_units +
                                                '</td>' +
                                                '<td>' + equip.equipment_work_days +
                                                '</td>' +
                                                '<td>' + numberWithCommas(parseFloat(
                                                    equip
                                                    .equipment_rate).toFixed(2)) +
                                                '</td>' +
                                                '<td>' + numberWithCommas(amount
                                                    .toFixed(
                                                        2)) +
                                                '</td>' +
                                                '</tr>';
                                        });
                                        // Close equipment table
                                        divHTML += '</tbody>' +
                                            '<tfoot>' +
                                            '<tr>' +
                                            '<td colspan="4" class="text-right"><strong>Total</strong></td>' +
                                            '<td>' + numberWithCommas(equipmentTotalAmount
                                                .toFixed(
                                                    2)) +
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
                                        divHTML += '<div style="text-align: left;">' +
                                            numberWithCommas(
                                                materialTotalAmount.toFixed(2)) +
                                            '</div></div>';
                                    }
                                    if (labor.length > 0) {
                                        divHTML +=
                                            '<div class="d-flex justify-content-center align-items-start"><div style="width: 200px; text-align: left;"><strong>Total Cost Labor:</strong></div>';
                                        divHTML += '<div style="text-align: left;">' +
                                            numberWithCommas(
                                                laborTotalAmount.toFixed(2)) + '</div></div>';
                                    }
                                    if (equipment.length > 0) {
                                        divHTML +=
                                            '<div class="d-flex justify-content-center align-items-start"><div style="width: 200px; text-align: left;"><strong>Total Cost Equipment:</strong></div>';
                                        divHTML += '<div style="text-align: left;">' +
                                            numberWithCommas(
                                                equipmentTotalAmount.toFixed(2)) +
                                            '</div></div>';
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
                                    divHTML += '<div style="text-align: left;">' +
                                        numberWithCommas(
                                            totalCost.toFixed(2)) + '</div></div>';
                                    divHTML += '</div>';



                                    // Close div
                                    divHTML += '</div>';
                                }
                                // Append the div to the container
                                $('#particularsContainer').append(divHTML);

                                $('#projectLocation, #projectOwner, #projectSubject').text(
                                    function(
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
