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
        <div class="container text-center" id="projectDetails">
            <div class="row mt-4">
                <div class="col-6">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-column align-items-start">
                            <div>Name of the Project: <span id="projectTitle" style="font-size: 20px;"></span></div>
                            <div>Date Prepared: <span id="projectDate" style="font-size: 20px;"></span></div>
                            <div>Appropriation: <span id="projectAppropriation" style="font-size: 20px;"></span></div>
                            <div>Owner: <span id="projectOwner" style="font-size: 20px;"></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-column align-items-start">
                            <div>Source of Fund: <span id="projectSOF" style="font-size: 20px;"></span></div>
                            <div>Location: <span id="projectLocation" style="font-size: 20px;"></span></div>
                            <div>Contract Duration: <span id="projectDuration" style="font-size: 20px;"></span></div>
                            <div>Mode of Implementation: <span id="projectImplementation" style="font-size: 20px;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <h5>DETAILED UNIT PRICE ANALYSIS (DUPA) SUMMARY</h5> <!-- Default -->
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
                        $('#projectDate').text(response.projects[0].project_date_prepared);
                        $('#projectAppropriation').text(response.projects[0].project_appropriation);
                        $('#projectOwner').text(response.projects[0].project_owner);
                        $('#projectSOF').text(response.projects[0].project_source_of_fund);
                        $('#projectLocation').text(response.projects[0].project_location);
                        $('#projectDuration').text(response.projects[0].project_contract_duration);
                        $('#projectImplementation').text(response.projects[0]
                            .project_mode_of_implementation);

                        // Filter project by project_id
                        var projectId = 1; // Change this value to the desired project_id
                        var project = response.projects.find(p => p.project_id === projectId);

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
                                var amount = parseFloat(particular.particular_quantity) *
                                    parseFloat(particular.particular_unit_cost);
                                totalAmount += amount;
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td>' + getRomanNumeral(index + 1) + '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + particular.particular_unit +
                                    '</td>' +
                                    '<td class="text-right">' + particular.particular_quantity +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(totalAmount
                                        .toFixed(
                                            2)) + '</td>' +
                                    '<td class="text-right">' + particular.particular_unit_cost +
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

        {{-- <div class="container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Item No.</th>
                        <th scope="col">Item Description</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total cost of the Item</th>
                        <th scope="col">Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="item-number">I</th>
                        <td>MOVING IN</td>
                        <td>Is</td>
                        <td>1</td>
                        <td>6,805.28</td>
                        <td>6,805.28</td>
                    </tr>
                    <tr>
                        <th scope="row" class="item-number">II</th>
                        <td>EARTHWORKS</td>
                        <td>cu.m</td>
                        <td>550</td>
                        <td>1,008.97</td>
                        <td>554,935.61</td>
                    </tr>
                    <tr>
                        <th scope="row" class="item-number">III</th>
                        <td>COMPACTION</td>
                        <td>cu.m</td>
                        <td>576</td>
                        <td>130.37</td>
                        <td>75,090.33</td>
                    </tr>
                    <tr>
                        <th scope="row" class="item-number">IV</th>
                        <td>CONCRETE PAVERS</td>
                        <td>sqm</td>
                        <td>403</td>
                        <td>2,818.92</td>
                        <td>1,136,026.71</td>
                    </tr>
                    <tr>
                        <th scope="row" class="item-number">V</th>
                        <td>Personal Protective Equipment (PPE)</td>
                        <td>Is</td>
                        <td>1</td>
                        <td>20,335.88</td>
                        <td>20,335.88</td>
                    </tr>
                    <tr>
                        <th scope="row" class="item-number">VI</th>
                        <td>MOVING OUT</td>
                        <td>Is</td>
                        <td>1</td>
                        <td>6,805.28</td>
                        <td>6,805.28</td>
                    </tr>
                    <tr>
                        <th scope="row" class="item-number"></th>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td>1,799,999.08</td>
                        <td> </td>
                    </tr>
                </tbody>
            </table>
            <div class="row mt-4">
                <div class="col-6">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-column align-items-start">
                            <div>
                                Prepared: <br><br>
                                <div style="text-align: center;">
                                    <u>FRITZ MILDRED N. PUABEN</u> <br>
                                    Draftsman I, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Reviewed: <br><br>
                                <div style="text-align: center;">
                                    <u>REYNALDO B. MABELIN</u> <br>
                                    Architect II, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Conformed: <br><br>
                                <div style="text-align: center;">
                                    <u>JOHN D. TAJONES</u> <br>
                                    Dean/End-User
                                </div>
                            </div>
                            <div class="mt-3">
                                Recommending Approval: <br><br>
                                <div style="text-align: center;">
                                    <u>HERMIE P. PAVA</u> <br>
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
                                    <u>MARIA EILANI N. NON</u> <br>
                                    Engineer II, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Submitted: <br><br>
                                <div style="text-align: center;">
                                    <u>RICHARD J. AQUINO</u> <br>
                                    Director, OUPD
                                </div>
                            </div>
                            <div class="mt-3">
                                Approved: <br><br>
                                <div style="text-align: center;">
                                    <u>ROLITO G. EBALLE, Ph.D.</u> <br>
                                    University President
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </body>

    </html>
@endsection