@extends('layouts.app')
@section('title', 'ABC')
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

                @page {
                    size: landscape !important;
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

            <div class="container">
                <div class="row row-cols-auto">
                    <div class="col-12"><h5 class="text-center">APPROVED BUDGET FOR THE CONTRACT</h5></div>
                </div>
                <div class="row row-cols-auto">
                    <div class="col-2 text-left"><strong>PROJECT TITLE:</strong></div>
                    <div class="col"><span id="projectTitle"></span></div>
                </div>
                <div class="row row-cols-auto">
                    <div class="col-2 text-left"><strong>LOCATION:</strong></div>
                    <div class="col"><span id="projectLocation"></span></div>
                </div>
                <div class="row row-cols-auto">
                    <div class="col-2 text-left"><strong>Contract Duration:</strong></div>
                    <div class="col"><span id="projectDuration"></span></div>
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
                            var totalCostAmount = 0;
                            var totalIndirCost = 0;
                            var totalVat = 0;
                            var totMarkUpVal = 0;
                            var totalDirCost = 0;
                            var edcTotalAmount = 0;
                            var dirTotal = 0;
                            var vatTotal = 0;
                            var mobTotal = 0;
                            var matTotal = 0;
                            var equipTotal = 0;
                            var labTotal = 0;
                            var divHTML = ''; // Initialize HTML string
                            var numberWithCommas = function(x) {
                                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            };

                            // Populate project details based on the selected project
                            $('#projectTitle').text(project.project_title);
                            $('#projectLocation').text(project.project_location);
                            $('#projectDuration').text(project.project_contract_duration);

                            console.log(project.project_contract_duration)
                            if (project.project_mode_of_implementation === 'By Admin') {
                            // Create particulars table
                            divHTML +=
                                '<div class="container">' +
                                '<table class="table table-bordered table-striped">' +
                                '<thead>' +
                                '<tr class="text-center">' +
                                '<th scope="col">ITEM</th>' +
                                '<th scope="col">DESCRIPTION</th>' +
                                '<th scope="col">QUANTITY</th>' +
                                '<th scope="col">UNIT</th>' +
                                '<th scope="col">ESTIMATED</th>' +
                                '<th colspan="3">MARK-UPS IN PERCENT</th>' +
                                '<th colspan="2">TOTAL MARK-UP</th>' +
                                '<th scope="col">VAT</th>' +
                                '<th scope="col">TOTAL</th>' +
                                '<th scope="col">TOTAL</th>' +
                                '<th scope="col">UNIT</th>' +
                                '</tr>' +
                                '<tr class="text-center">' +
                                '<th scope="col">NO.</th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col">DIRECT COST</th>' +
                                '<th scope="col">OCM</th>' +
                                '<th scope="col">PROFIT</th>' +
                                '<th scope="col">MOB.</th>' +
                                '<th scope="col">%</th>' +
                                '<th scope="col">VALUE</th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col">INDIRECT COST</th>' +
                                '<th scope="col">COST</th>' +
                                '<th scope="col">COST</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<tr class="text-center">' +
                                '<td>(1)</td>' +
                                '<td>(2)</td>' +
                                '<td>(3)</td>' +
                                '<td>(4)</td>' +
                                '<td>(5)</td>' +
                                '<td>(6)</td>' +
                                '<td>(7)</td>' +
                                '<td>(8)</td>' +
                                '<td>(9)</td>' +
                                '<td>(10)</td>' +
                                '<td>(11)</td>' +
                                '<td>(12)</td>' +
                                '<td>(13)</td>' +
                                '<td>(14)</td>' +
                                '</tr>';
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
                            // Loop through each particular to add rows to the table
                            project.particulars.forEach(function(particular, index) {
                                // Check if the particular is MOVING-IN or MOVING-OUT
                                var isMovingParticular = (particular.particular_name ===
                                    "MOVING-IN" || particular.particular_name === "MOVING-OUT");


                                var mobValue = isMovingParticular ? movingIn :
                                    0;
                                mobTotal += mobValue;
                                // Calculate values based on the type of particular
                                edcTotalAmount = isMovingParticular ? movingIn :
                                    (
                                        parseFloat(particular.totalMaterialAmount) + parseFloat(
                                            particular.totalLaborAmount) +
                                        parseFloat(particular.totalEquipmentAmount));
                                unitCost = isMovingParticular ? movingIn : edcTotalAmount / particular.quantity;
                                dirTotal += edcTotalAmount;
                                totalCostAmount += edcTotalAmount;

                                console.log('mob', mobTotal);
                                console.log('dir total:', dirTotal);
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-right">' + numberWithCommas((particular.quantity === null || isNaN(particular.quantity)) ? '<span style="color: red;">Please Input a valid value</span>' : parseFloat(
                                        particular.quantity).toFixed(2)) + '</td>' +
                                    '<td>' + ((particular.unit === null || isNaN(particular.unit)) ? '<span style="color: red;">Please Input a valid value</span>' : particular.unit) + '</td>' +
                                    '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(
                                            edcTotalAmount)
                                        .toFixed(2)) + '</td>' +
                                    '<td class="text-center">' + ' ' + '</td>' +
                                    '<td class="text-center">' + ' ' + '</td>' +
                                    '<td class="text-right">' + (isMovingParticular ? '₱' + mobValue
                                        .toFixed(2) : '') +
                                    '</td>' +
                                    '<td class="text-center">' + ' ' + '</td>' +
                                    '<td class="text-right">' + ' ' + '</td>' +
                                    '<td class="text-right">' + ' ' + '</td>' +
                                    '<td class="text-right">' + ' ' + '</td>' +
                                    '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(
                                        edcTotalAmount).toFixed(
                                        2)) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas((unitCost === null || isNaN(unitCost)) || !isFinite(unitCost) ? '-' : '₱' + unitCost.toFixed(
                                        2)) + '</td>' +
                                    '</tr>';
                            });
                            // Close the table and container
                            var amountInWords = convertNumberToWords(parseFloat(totalCostAmount).toFixed(
                                2));
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td></td>' +
                                '<td class="text-center"><strong>Total</strong></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(dirTotal).toFixed(
                                    2)) +
                                '</td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(mobTotal).toFixed(
                                    2)) + '</td>' +
                                '<td></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(totalCostAmount.toFixed(2)) +
                                '</td>' +
                                '<td></td>' +
                                '</tr>' +
                                '</tfoot>' +
                                '</table>' +
                                '<div class="text-center">' +
                                '<h5>TOTAL ESTIMATED COST IS ' + amountInWords + '</h5>' +
                                '<h5>' + '₱' + numberWithCommas(totalCostAmount.toFixed(2)) + '</h5>' +
                                '</div>' +
                                '</div>';
                            divHTML +=
                                '<div class="container">' +
                                '<div class="row mt-4">' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Prepared by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Prepared by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname + '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Checked by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Checked by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Reviewed by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Reviewed by (ABC & DUPAS)') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Submitted by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Submitted by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Recommending Approval: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Recommending Approval') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Approved by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Approved by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname + ', ' + signature
                                        .degree +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '</div>' +
                                '</div>';
                            // Append the complete table to the container
                            $('#particularsContainer').html(divHTML);
                        } else {
                            // Create particulars table
                            divHTML +=
                                '<div class="container">' +
                                '<table class="table table-bordered table-striped">' +
                                '<thead>' +
                                '<tr class="text-center">' +
                                '<th scope="col">ITEM</th>' +
                                '<th scope="col">DESCRIPTION</th>' +
                                '<th scope="col">QUANTITY</th>' +
                                '<th scope="col">UNIT</th>' +
                                '<th scope="col">ESTIMATED</th>' +
                                '<th colspan="3">MARK-UPS IN PERCENT</th>' +
                                '<th colspan="2">TOTAL MARK-UP</th>' +
                                '<th scope="col">VAT</th>' +
                                '<th scope="col">TOTAL</th>' +
                                '<th scope="col">TOTAL</th>' +
                                '<th scope="col">UNIT</th>' +
                                '</tr>' +
                                '<tr class="text-center">' +
                                '<th scope="col">NO.</th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col">DIRECT COST</th>' +
                                '<th scope="col">OCM</th>' +
                                '<th scope="col">PROFIT</th>' +
                                '<th scope="col">MOB.</th>' +
                                '<th scope="col">%</th>' +
                                '<th scope="col">VALUE</th>' +
                                '<th scope="col"></th>' +
                                '<th scope="col">INDIRECT COST</th>' +
                                '<th scope="col">COST</th>' +
                                '<th scope="col">COST</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<tr class="text-center">' +
                                '<td>(1)</td>' +
                                '<td>(2)</td>' +
                                '<td>(3)</td>' +
                                '<td>(4)</td>' +
                                '<td>(5)</td>' +
                                '<td>(6)</td>' +
                                '<td>(7)</td>' +
                                '<td>(8)</td>' +
                                '<td>(9)</td>' +
                                '<td>(10)</td>' +
                                '<td>(11)</td>' +
                                '<td>(12)</td>' +
                                '<td>(13)</td>' +
                                '<td>(14)</td>' +
                                '</tr>';
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
                            // Loop through each particular to add rows to the table
                            project.particulars.forEach(function(particular, index) {
                                // Check if the particular is MOVING-IN or MOVING-OUT
                                var isMovingParticular = (particular.particular_name ===
                                    "MOVING-IN" || particular.particular_name === "MOVING-OUT");


                                var mobValue = isMovingParticular ? movingIn :
                                    0;
                                mobTotal += mobValue;
                                // Calculate values based on the type of particular
                                edcTotalAmount = isMovingParticular ? movingIn :
                                    (
                                        parseFloat(particular.totalMaterialAmount) + parseFloat(
                                            particular.totalLaborAmount) +
                                        parseFloat(particular.totalEquipmentAmount));
                                markUpTotal = isMovingParticular ? 0 : (project.ocm + project
                                    .contractors_profit);
                                markUpValue = isMovingParticular ? 0 : ((markUpTotal / 100) *
                                    edcTotalAmount);
                                vatValue = isMovingParticular ? 0 : ((project.vat / 100) * (
                                    markUpValue + edcTotalAmount));
                                indirCostTotal = isMovingParticular ? 0 : (markUpValue +
                                    vatValue);
                                totalCost = edcTotalAmount + indirCostTotal;
                                unitCost = isMovingParticular ? movingIn : totalCost / particular.quantity;
                                dirTotal += edcTotalAmount;
                                totMarkUpVal += markUpValue;
                                vatTotal += vatValue;
                                totalIndirCost += indirCostTotal;
                                totalCostAmount += totalCost;

                                console.log('mob', mobTotal);
                                console.log('dir total:', totalCostAmount);
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-right">' + numberWithCommas((particular.quantity === null || isNaN(particular.quantity)) ? '-' : parseFloat(
                                        particular.quantity).toFixed(2)) + '</td>' +
                                    '<td>' + ((particular.unit === null || isNaN(particular.unit)) ? '-' : particular.unit) + '</td>' +
                                    '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(
                                            edcTotalAmount)
                                        .toFixed(2)) + '</td>' +
                                    '<td class="text-center">' + (isMovingParticular ? '' : project
                                        .ocm.toFixed(2)) + '</td>' +
                                    '<td class="text-center">' + (isMovingParticular ? '' : project
                                        .contractors_profit.toFixed(2)) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(isMovingParticular ? '₱' + mobValue
                                        .toFixed(2) : '') +
                                    '</td>' +
                                    '<td class="text-center">' + (isMovingParticular ? '' :
                                        markUpTotal.toFixed(2)) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(
                                        isMovingParticular ? '' : '₱' + markUpValue
                                        .toFixed(2)) + '</td>' +
                                    '<td class="text-right">' + (isMovingParticular ? '' : '₱' +
                                        numberWithCommas(vatValue.toFixed(2))) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(
                                        isMovingParticular ? '' : '₱' + indirCostTotal
                                        .toFixed(2)) + '</td>' +
                                    '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(
                                        totalCost).toFixed(
                                        2)) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas((unitCost === null || isNaN(unitCost)) || !isFinite(unitCost) ? '-' : '₱' + unitCost.toFixed(
                                        2)) + '</td>' +
                                    '</tr>';
                            });
                            // Close the table and container
                            var amountInWords = convertNumberToWords(parseFloat(totalCostAmount).toFixed(
                                2));
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td></td>' +
                                '<td class="text-center"><strong>Total</strong></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(dirTotal).toFixed(
                                    2)) +
                                '</td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(parseFloat(mobTotal).toFixed(
                                    2)) + '</td>' +
                                '<td></td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(totMarkUpVal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(vatTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(totalIndirCost.toFixed(2)) +
                                '</td>' +
                                '<td class="text-right">' + '₱' + numberWithCommas(totalCostAmount.toFixed(2)) +
                                '</td>' +
                                '<td></td>' +
                                '</tr>' +
                                '</tfoot>' +
                                '</table>' +
                                '<div class="text-center">' +
                                '<h5>TOTAL ESTIMATED COST IS ' + amountInWords + '</h5>' +
                                '<h5>' + '₱' + numberWithCommas(totalCostAmount.toFixed(2)) + '</h5>' +
                                '</div>' +
                                '</div>';
                            divHTML +=
                                '<div class="container">' +
                                '<div class="row mt-4">' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Prepared by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Prepared by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname + '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Checked by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Checked by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Reviewed by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Reviewed by (ABC & DUPAS)') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Submitted by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Submitted by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Recommending Approval: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Recommending Approval') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Approved by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Approved by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname + ', ' + signature
                                        .degree +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '</div>' +
                                '</div>';
                            // Append the complete table to the container
                            $('#particularsContainer').html(divHTML);
                        }
                        } else {
                            console.error('Project with ID ' + projectId + ' not found in the response.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching project details:', error);
                    }
                });
            });

            // Function to convert a number to its English word representation with all letters capitalized
            function convertNumberToWords(number) {
                const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                const teens = [
                    'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen',
                    'Nineteen'
                ];
                const tens = [
                    '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
                ];

                // Function to capitalize all letters in a word
                function capitalizeWord(word) {
                    if (typeof word !== 'string') {
                        return '';
                    }
                    return word.split('').map(char => char.toUpperCase()).join('');
                }

                // Function to convert a number less than one thousand to words
                function convertLessThanOneThousand(num) {
                    if (num === 0) {
                        return '';
                    } else if (num < 10) {
                        return capitalizeWord(ones[num]);
                    } else if (num < 20) {
                        return capitalizeWord(teens[num - 10]);
                    } else if (num < 100) {
                        return capitalizeWord(tens[Math.floor(num / 10)]) + ' ' + capitalizeWord(ones[num % 10]);
                    } else {
                        return capitalizeWord(ones[Math.floor(num / 100)]) + ' Hundred ' + convertLessThanOneThousand(num %
                            100);
                    }
                }

                // Main function logic
                if (number === 0) {
                    return 'Zero';
                }

                // Separate the integer and decimal parts of the number
                const [integerPart, decimalPart] = number.toString().split('.');
                let words = '';

                // Convert the integer part to words
                let integerWords = '';
                let integerNum = parseInt(integerPart, 10);
                let groupIndex = 0;

                while (integerNum > 0) {
                    if (integerNum % 1000 !== 0) {
                        integerWords = convertLessThanOneThousand(integerNum % 1000) + ' ' + ['', 'Thousand', 'Million',
                            'Billion', 'Trillion'
                        ][groupIndex] + ' ' + integerWords;
                    }
                    integerNum = Math.floor(integerNum / 1000);
                    groupIndex++;
                }

                words = capitalizeWord(integerWords.trim());

                // Convert the decimal part to fraction
                if (decimalPart && parseFloat(decimalPart) !== 0) {
                    words += ` PESOS AND ${decimalPart.padEnd(2, '0')}/100`;
                } else {
                    words += ' PESOS ONLY';
                }

                return words.trim();
            }

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
