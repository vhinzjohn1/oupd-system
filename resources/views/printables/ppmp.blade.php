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
        < class="container text-center">
            <!-- CMU Logo -->
            <div class="cmuLogoContainer">
                <img src="{{ asset('/img/cmu.png') }}" class="cmuLogo" />
            </div> --}}

        <table class="table table-borderless" id="projectDetails">
            <tr>
                <td>Name of the Project :</td>
                <td><span id="projectTitle"></span></td>
                <td>Source of Fund :</td>
                <td><span id="projectSOF"></span></td>
            </tr>
            <tr>
                <td>Date Prepared :</td>
                <td><span id="projectDate"></span></td>
                <td>Location :</td>
                <td><span id="projectLocation"></span></td>
            </tr>
            <tr>
                <td>Appropriation :</td>
                <td><span id="projectAppropriation"></span></td>
                <td>Contract Duration :</td>
                <td><span id="projectDuration"></span></td>
            </tr>
            <tr>
                <td>Owner :</td>
                <td><span id="projectOwner"></span></td>
                <td>Mode of Implementation :</td>
                <td><span id="projectImplementation"></span></td>
            </tr>
        </table>

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
                            var divHTML = ''; // Initialize HTML string
                            var numberWithCommas = function(x) {
                                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            };

                            // Populate project details
                            $('#projectTitle').text(project.project_title);
                            $('#projectDate').text(project.project_date_prepared);
                            $('#projectAppropriation').text(project.project_appropriation);
                            $('#projectOwner').text(project.project_owner);
                            $('#projectSOF').text(project.project_source_of_fund);
                            $('#projectLocation').text(project.project_location);
                            $('#projectDuration').text(project.project_contract_duration);
                            $('#projectImplementation').text(project.project_mode_of_implementation);
                            // Create particulars table
                            divHTML +=
                                // '<table class="table table-borderless" id="projectDetails">' +
                                // '<tr>' +
                                // '<th>Name of the Project :</th>' +
                                // '<th>' + project.project_title + '</th>' +
                                // '<th>Source of Fund :</th>' +
                                // '<th>' + project.project_source_of_fund + '</th>' +
                                // '</tr>' +
                                // '<tr>' +
                                // '<th>Date Prepared :</th>' +
                                // '<th>' + project.project_date_prepared + '</th>' +
                                // '<th>Location :</th>' +
                                // '<th>' + project.project_location + '</th>' +
                                // '</tr>' +
                                // '<tr>' +
                                // '<th>Appropriation :</th>' +
                                // '<th>' + project.project_appropriation + '</th>' +
                                // '<th>Contract Duration :</th>' +
                                // '<th>' + project.project_contract_duration + '</th>' +
                                // '</tr>' +
                                // '<tr>' +
                                // '<th>Owner :</th>' +
                                // '<th>' + project.project_owned + '</th>' +
                                // '<th>Mode of Implementation :</th>' +
                                // '<th>' + project.project_mode_of_implementation + '</th>' +
                                // '</tr>' +
                                // '</table>' +
                                '<div class="container">' +
                                '<table class="table table-bordered table-striped">' +
                                '<thead>' +
                                '<tr>' +
                                '<th colspan="11" class="text-center">' +
                                '<h5>PROJECT PROCUREMENT MANAGEMENT PLAN</h5>' +
                                '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th class="text-center">Ref.</th>' +
                                '<th class="text-center">Contract Package (Description)</th>' +
                                '<th class="text-center">Procurement Method</th>' +
                                '<th class="text-center">ABC</th>' +
                                '<th class="text-center">Pre-Procurement Conference</th>' +
                                '<th class="text-center">Advertisement</th>' +
                                '<th class="text-center">Eligibility Screening</th>' +
                                '<th class="text-center">Submission and Receipt of Bids</th>' +
                                '<th class="text-center">Bid Evaluation</th>' +
                                '<th class="text-center">Post-Qualification</th>' +
                                '<th class="text-center">Award of Contract</th>' +

                                '</tr>' +
                                '</thead>' +
                                '<tbody>';
                            // Loop through each particular to add rows to the table
                            project.particulars.forEach(function(particular, index) {
                                // Check if the particular is MOVING-IN or MOVING-OUT
                                var isMovingParticular = (particular.particular_name ===
                                    "MOVING-IN" || particular.particular_name === "MOVING-OUT");


                                var mobValue = isMovingParticular ? parseFloat(particular.total) :
                                    0;
                                mobTotal += mobValue;
                                // Calculate values based on the type of particular
                                edcTotalAmount = isMovingParticular ? parseFloat(particular.total) :
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
                                unitCost = totalCost / particular.quantity;
                                dirTotal += edcTotalAmount;
                                totMarkUpVal += markUpValue;
                                vatTotal += vatValue;
                                totalIndirCost += indirCostTotal;
                                totalCostAmount += totalCost;
                            });
                            // Add row for the particular
                            divHTML +=
                                '<tr>' +
                                '<td></td>' +
                                '<td>' + project.project_title + '</td>' +
                                '<td class="text-center">' + 'METHOD' +
                                '</td>' +
                                '<td class="text-right">' + numberWithCommas(totalCostAmount.toFixed(2)) +
                                '</td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-right"></td>' +
                                '</tr>';

                            // Close the table and container
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td></td>' +
                                '<td colspan="2"><strong>Total Budget Amount</strong></td>' +
                                '<td colspan="9" class="text-left">' + numberWithCommas(totalCostAmount
                                    .toFixed(2)) +
                                '</td>' +
                                '</tr>' +
                                '</tfoot>' +
                                '</table>' +
                                '</div>';
                            divHTML +=
                                '<div class="container">' +
                                '<div class="row mt-4">' +
                                '<div class="col d-inline-block me-1">' +
                                '<div style="white-space: nowrap;">' +
                                'Prepared by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Prepared by (PPMP)') {
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
                                if (signature.role === 'Reviewed by (PPMP)') {
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
                            console.error('Project with ID ' + projectId +
                                ' not found in the response.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching project details:', error);
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
