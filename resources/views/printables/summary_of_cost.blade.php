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

        <div class="container" id="projectDetails">
            <div class="container text-center">
                <div class="row mt-4">
                    <div class="row mt-2">
                        <div class="d-flex flex-column align-items-start">
                            <div><strong>PROJECT TITLE:</strong> <span id="projectTitle" style="font-size: 20px;"></span>
                            </div>
                            <div><strong>LOCATION:</strong> <span id="projectLocation" style="font-size: 20px;"></span>
                            </div>
                            <div><strong>OWNER:</strong> <span id="projectOwner" style="font-size: 20px;"></span></div>
                            <div><strong>SUBJECT:</strong> <span id="projectSubject" style="font-size: 20px;">Summary of
                                    Cost</span></div> <br>
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

        <div class="container">
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h5 class="mt-3">I- Direct Cost</h5>
                            <div class="row">
                                <div class="col-3">Materials</div>
                                <div class="col">₱1,118,912.00</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Labor</div>
                                <div class="col">₱179,041.92</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Equipment Rental</div>
                                <div class="col">₱63,104.00</div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-end">Total:</div>
                                <div class="col">₱1,361,057.92</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="mt-3">II- Indirect Cost</h5>
                            <div class="row">
                                <div class="col-3">OCM (15% of Direct Cost)</div>
                                <div class="col">₱204,158.69</div>
                            </div>
                            <div class="row">
                                <div class="col-3">CP (10% of Direct Cost)</div>
                                <div class="col">₱136,105.79</div>
                            </div>
                            <div class="row">
                                <div class="col-3">VAT (5% of Total above Cost)</div>
                                <div class="col">₱85,066.12</div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-end">Total:</div>
                                <div class="col">₱425,330.60</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="mt-3">III- Mobilization Cost</h5>
                            <div class="row">
                                <div class="col-3">Moving-in</div>
                                <div class="col">₱6,805.29</div>
                            </div>
                            <div class="row">
                                <div class="col-3">Moving-out</div>
                                <div class="col">₱6,805.29</div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-end">Total:</div>
                                <div class="col">₱13,610.58</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="mt-3"></h5>
                            <div class="row">
                                <div class="col-3">TOTAL PROJECT COST</div>
                                <div class="col">₱1,799,999.10</div>
                            </div>
                        </div>
                    </div> <br>
                </div>
                {{-- <div class="d-flex flex-column align-items-center">
                    <div class="text-center">
                        <h5>SAY: TOTAL ESTIMATED COST IS ONE MILLION EIGHT HUNDED THOUSAND PESOS ONLY</h5>
                        <h5>(Php 1,800,000.00)</h5>
                    </div>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="d-flex flex-column align-items-center">

                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div class="text-center" style="white-space: nowrap;">
                                    Re-evaluated by: <br><br>
                                    <u><b>FRITZ MILDRED N. PUABEN</b> </u> <br>
                                    Draftsman I, OUPD
                                </div> <br>
                                <div class="text-center" style="white-space: nowrap;">
                                    Reviewed by: <br><br>
                                    <u><b>ROY V. AGBAYANI</b> </u> <br>
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
                </div> --}}


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

                        // Filter project by project_id
                        var projectId = 1; // Change this value to the desired project_id
                        var project = response.projects.find(p => p.project_id === projectId);

                        if (project) {
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
                                '<th colspan="6" class="text-center">SUMMARY</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="col" class="text-center">Item No.</th>' +
                                '<th scope="col" class="text-center">Description</th>' +
                                '<th scope="col" class="text-center">Materials</th>' +
                                '<th scope="col" class="text-center">Labor</th>' +
                                '<th scope="col" class="text-center">Equipment</th>' +
                                '<th scope="col" class="text-center">Total</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>';
                            // Loop through each particular to add rows to the table
                            project.particulars.forEach(function(particular, index) {
                                var materialTotal = 0;
                                var materialAmount = parseFloat(particular.particular_quantity) *
                                    parseFloat(particular.particular_unit_cost);
                                    materialTotal += materialAmount;
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + "materialTotal" +
                                    '</td>' +
                                    '<td class="text-center">' + "laborTotal" +
                                    '</td>' +
                                    '<td class="text-center">' + "equipmentTotal" +
                                    '</td>' +
                                    '<td class="text-center">' + numberWithCommas(materialTotal.toFixed(
                                    2)) + '</td>' +
                                    '</tr>';
                            });
                            // Close the table and container
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-right"><strong>Total</strong></td>' +
                                '<td class="text-center">' + +'</td>' +
                                '<td class="text-center">' + +'</td>' +
                                '<td class="text-center">' + +'</td>' +
                                '<td class="text-center">' + +'</td>' +
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
