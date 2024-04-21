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
        <table class="table table-borderless" id="projectDetails">
            <tr>
                <td>Name of tde Project :</td>
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
        <div class="container">
            <div class="row mt-4">
                <div class="col-6">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-column align-items-start">
                            <div>
                                Prepared: <br><br>
                                <div style="text-align: center;">
                                    <b><u>FRITZ MILDRED N. PUABEN</u></b> <br>
                                    Draftsman I, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Reviewed: <br><br>
                                <div style="text-align: center;">
                                    <b><u>REYNALDO B. MABELIN</u></b> <br>
                                    Architect II, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Conformed: <br><br>
                                <div style="text-align: center;">
                                    <b><u>JOHN D. TAJONES</u></b> <br>
                                    Dean/End-User
                                </div>
                            </div>
                            <div class="mt-3">
                                Recommending Approval: <br><br>
                                <div style="text-align: center;">
                                    <b><u>HERMIE P. PAVA</u></b> <br>
                                    VP for Administration
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flexflex-column align-items-center">
                        <div class="d-flex flex-column align-items-start">
                            <div>
                                Checked: <br><br>
                                <div style="text-align: center;">
                                    <b><u>MARIA EILANI N. NON</u></b> <br>
                                    Engineer II, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Submitted: <br><br>
                                <div style="text-align: center;">
                                    <b><u>RICHARD J. AQUINO</u></b> <br>
                                    Director, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Approved: <br><br>
                                <div style="text-align: center;">
                                    <b><u>ROLITO G. EBALLE, Ph.D.</u></b> <br>
                                    University President
                                </div>
                            </div>
                        </div>
                    </div>
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
                        $('#projectDate').text(response.projects[0].project_date_prepared);
                        $('#projectAppropriation').text(response.projects[0].project_appropriation);
                        $('#projectOwner').text(response.projects[0].project_owner);
                        $('#projectSOF').text(response.projects[0].project_source_of_fund);
                        $('#projectLocation').text(response.projects[0].project_location);
                        $('#projectDuration').text(response.projects[0].project_contract_duration);
                        $('#projectImplementation').text(response.projects[0]
                            .project_mode_of_implementation);

                        // Get the selected project ID from localStorage
                        var selectedProjectID = localStorage.getItem("projectID");

                        // Filter particulars by the selected project_id
                        var project = response.projects.find(p => p.project_id == selectedProjectID);

                        if (project) {
                            var totalAmount = 0;
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
                                '<th colspan="6" class="text-center">' +
                                '<h5>DETAILED UNIT PRICE ANALYSIS (DUPA) SUMMARY</h5>' +
                                '</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th class="text-center">Item No.</th>' +
                                '<th class="text-center">Item Description</th>' +
                                '<th class="text-center">Unit</th>' +
                                '<th class="text-center">Quantity</th>' +
                                '<th class="text-center">Total Cost of Item</th>' +
                                '<th class="text-center">Unit Cost</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>';
                            // Loop through each particular to add rows to the table
                            project.particulars.forEach(function(particular, index) {
                                var amount = parseFloat(particular.quantity) *
                                    parseFloat(particular.unit_cost);
                                totalAmount += amount;
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td>' + getRomanNumeral(index + 1) + '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + particular.unit +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(parseFloat(
                                        particular.quantity)) +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(amount.toFixed(
                                        2)) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(parseFloat(
                                        particular.unit_cost).toFixed(2)) +
                                    '</td>' +
                                    '</tr>';
                            });
                            // Close the table and container
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td></td>' +
                                '<td><strong>Total</strong></td>' +
                                '<td colspan="2"></td>' +
                                '<td class="text-right">' + numberWithCommas(totalAmount.toFixed(2)) +
                                '</td>' +
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
