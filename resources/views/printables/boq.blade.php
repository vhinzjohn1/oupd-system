@extends('layouts.app')
@section('title', 'BOQ')
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

        <div class="container" id="projectDetails">
            <div class="container text-center"> <br><br>
            </div>
        </div>



        <!-- Project Particulars -->
        <div class="container-fluid">
            <!-- Loop through each particular -->
            <div class="row justify-content-center" id="particularsContainer"> <!-- Center horizontally -->
                <!-- Particular tables will be appended here -->
            </div>
        </div>
        <div class="container">
            <div class="container">
                <div class="row mt-4 align-items-center">
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div class="text-center" style="white-space: nowrap;">
                                    Prepared by: <br><br>
                                    <u><b>FRITZ MILDRED N. PUABEN</b> </u> <br>
                                    Draftsman I, OUPD
                                </div> <br>
                                <div class="text-center" style="white-space: nowrap;">
                                    Submitted by: <br><br>
                                    <u><b>RICHARD J. AQUINO</b> </u> <br>
                                    Director, OUPD
                                </div> <br>
                                <div class="text-center" style="white-space: nowrap;">
                                    Conformed by: <br><br>
                                    <u><b>JOHN D. TAJONES</b> </u> <br>
                                    DEAN, CISC
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div class="text-center" style="white-space: nowrap;">
                                    Checked by: <br><br>
                                    <u><b>MARIA EILANI N. NON</b> </u> <br>
                                    Engineer II, OUPD
                                </div> <br>
                                <div class="text-center" style="white-space: nowrap;">
                                    Recommending Approval: <br><br>
                                    <u><b>HERMIE P. PAVA</b> </u> <br>
                                    VP-Administration
                                </div> <br>
                                <div class="text-center" style="white-space: nowrap;">
                                    Approved: <br><br>
                                    <u><b>ROLITO G. EBALLE, PH.D</b> </u> <br>
                                    University President
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat the structure for other elements as needed -->
                </div>
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
                            var totalAmount = 0;
                            var percent = 0;
                            var totalPercent = 0;
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

                            // Create particulars table
                            divHTML +=
                                '<div class="container">' +
                                '<table class="table table-bordered table-striped">' +
                                '<thead>' +
                                '<tr>' +
                                '<th colspan="7" class="text-center">Republic  of the Phillipines <br>CENTRAL MINDANAO UNIVERSITY<br> University Town, Musuan, Bukidnon<br><h3>INDIVIDUAL PROJECT PROGRAM OF WORK</h3><br><p class="text-right"><u>04/22/2024</u><br>date</p></th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="4" class="text-center">NAME OF THE PROJECT/LOCATION:</th>' +
                                '<th colspan="2" class="text-center">Appropriation Php</th>' +
                                '<th class="text-center">' + project.project_appropriation + '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th rowspan="3" colspan="4" class="text-center">' + project.project_title +
                                '</th>' +
                                '<th colspan="2" class="text-center">Source of Funds</th>' +
                                '<th class="text-center">' + project.project_source_of_fund + '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="2" class="text-center">Issue Obligated Authority</th>' +
                                '<th class="text-center"></th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="2" class="text-center">Released</th>' +
                                '<th class="text-center"></th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="4" class="text-center">PROJECT CATEGORY:</th>' +
                                '<th colspan="2" class="text-center">Duration</th>' +
                                '<th class="text-center">' + project.project_contract_duration + '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th rowspan="2" colspan="4" class="text-center">PROJECT CATEGORY</th>' +
                                '<th colspan="2" class="text-center">Desirable Starting Date</th>' +
                                '<th class="text-center"></th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="2" class="text-center">Mode of Implementation</th>' +
                                '<th class="text-center">' + project.project_mode_of_implementation +
                                '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="7" class="text-center">PROJECT DESCRIPTION:</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="7" class="text-center">' + project.project_description +
                                '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="2" class="text-center">TECHNICAL PERSONNEL REQUIRED</th>' +
                                '<th colspan="5" class="text-center">MINIMUM EQUIPMENT REQUIREMENT</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th class="text-center">No.</th>' +
                                '<th class="text-center">DESCRIPTION</th>' +
                                '<th colspan="2" class="text-center">DESCRIPTION</th>' +
                                '<th class="text-center">#Owned</th>' +
                                '<th class="text-center">#Lease</th>' +
                                '<th class="text-center">Total # of units</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<tr>' +
                                '<td class="text-center">' + +
                                '</td>' +
                                '<td>' + +'</td>' +
                                '<td colspan="2" class="text-center">' + +
                                '</td>' +
                                '<td class="text-center">' + +
                                '</td>' +
                                '<td class="text-center">' + +
                                '</td>' +
                                '<td class="text-center">' + +'</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th colspan="7" class="text-center">ESTIMATED COST OF PROPOSED WORK</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="col" class="text-center">Item No.</th>' +
                                '<th scope="col" class="text-center">Description</th>' +
                                '<th scope="col" class="text-center">% TOTAL</th>' +
                                '<th scope="col" class="text-center">QUANTITY</th>' +
                                '<th scope="col" class="text-center">UNIT</th>' +
                                '<th scope="col" class="text-center">TOTAL ESTIMATED COST</th>' +
                                '<th scope="col" class="text-center">UNIT COST</th>' +
                                '</tr>';
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

                                // Accumulate totals
                                dirTotal += edcTotalAmount;
                                totMarkUpVal += markUpValue;
                                vatTotal += vatValue;
                                totalIndirCost += indirCostTotal;
                                totalCostAmount += totalCost;

                                // Calculate percent based on accumulated totalCostAmount
                                var percent = (totalCost / totalCostAmount) * 100;
                                totalPercent += percent;
                                console.log('total cost: ', totalCost);
                                console.log('total cost amount: ', totalCostAmount);
                                console.log('total percent: ', percent);
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(percent.toFixed(
                                        2)) +
                                    '</td>' +
                                    '<td class="text-center">' + numberWithCommas(parseFloat(
                                        particular.quantity).toFixed(2)) +
                                    '</td>' +
                                    '<td class="text-center">' + particular.unit +
                                    '</td>' +
                                    '<td class="text-center"></td>' +
                                    '<td class="text-center"></td>' +
                                    '</tr>';
                            });
                            // Close the table and container
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-right"><strong>Total</strong></td>' +
                                '<td class="text-center">' + totalPercent + '</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center">' + "-" + '</td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '</tfoot>' +
                                '</table>' +
                                '</div>';
                            // Append the complete table to the container
                            $('#particularsContainer').html(divHTML);
                        } else {
                            console.error('Project with ID ' + projectId + ' not found in the response.');
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
