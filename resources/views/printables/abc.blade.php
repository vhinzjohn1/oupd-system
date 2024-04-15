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

        <div class="container text-center">
            <div class="row mt-4">
                <div class="row mt-2">
                    <div class="d-flex flex-column align-items-center">
                        <div class="text-center">
                            <h5>APPROVED BUDGET FOR THE CONTRACT</h5> <!-- Default -->
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-start">
                        <div><strong>PROJECT TITLE:</strong> <span id="projectTitle" style="font-size: 20px;"></span>
                        </div>
                        <div><strong>LOCATION:</strong> <span id="projectLocation" style="font-size: 20px;"></span>
                        </div>
                        <div><strong>Contract Duration:</strong> <span id="projectDuration" style="font-size: 20px;"></span>
                        </div> <br>
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
            {{-- <div class="container text-center">
                <div class="row mt-4">
                    <div class="row mt-2">
                        <div class="d-flex flex-column align-items-center">
                            <div class="text-center">
                                <h5>APPROVED BUDGET FOR THE CONTRACT</h5> <!-- Default -->
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-start">
                            <div class="name-of-project">PROJECT TITLE: <b>Construction of Pavers and Parking at CISC</b>
                            </div>
                            <div class="date-prepared">Location: <b>CMU, Musuan, Bukidnon</b></div>
                            <div class="owner">CONTRACT DURATION: <b>90 CD</b></div> <br>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="container">
                {{-- <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="text-center">ITEM</th>
                            <th class="text-center">DESCRIPTION</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">UNIT</th>
                            <th class="text-center">ESTIMATED</th>
                            <th class="text-center" colspan="3">MARK-UPS IN PERCENT</th>
                            <th class="text-center" colspan="2">TOTAL MARK-UP</th>
                            <th class="text-center">VAT</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center">UNIT</th>
                        </tr>
                        <tr>
                            <th class="text-center align-content-center">NO.</th>
                            <th class="text-center"></th>
                            <th class="text-center align-content-center"></th>
                            <th class="text-center align-content-center"></th>
                            <th class="text-end align-content-center">DIRECT COST</th>
                            <th class="text-center">OCM</th>
                            <th class="text-center">PROFIT</th>
                            <th class="text-center">MOB.</th>
                            <th class="text-center">%</th>
                            <th class="text-center">VALUE</th>
                            <th class="text-center"></th>
                            <th class="text-center">INDIRECT COST</th>
                            <th class="text-center">COST</th>
                            <th class="text-center">COST</th>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">(1)</td>
                            <td class="text-center">(2)</td>
                            <td class="text-center align-content-center">(3)</td>
                            <td class="text-center align-content-center">(4)</td>
                            <td class="text-end align-content-center">(5)</td>
                            <td class="text-center">(6)</td>
                            <td class="text-center">(7)</td>
                            <td class="text-center">(8)</td>
                            <td class="text-center">(9)</td>
                            <td class="text-center">(10)</td>
                            <td class="text-center">(11)</td>
                            <td class="text-center">(12)</td>
                            <td class="text-center">(13)</td>
                            <td class="text-center">(14)</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">I</td>
                            <td class="text-center">MOVING-IN</td>
                            <td class="text-center align-content-center">1</td>
                            <td class="text-center align-content-center">l.s</td>
                            <td class="text-end align-content-center">6,805.28</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">6,805.28</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">6,805.28</td>
                            <td class="text-center">6,805.28</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">II</td>
                            <td class="text-center">EARtdWORKS</td>
                            <td class="text-center align-content-center">550</td>
                            <td class="text-center align-content-center">cu.m</td>
                            <td class="text-end align-content-center">422,808.08</td>
                            <td class="text-center">15.00</td>
                            <td class="text-center">10.00</td>
                            <td class="text-center"></td>
                            <td class="text-center">25.00</td>
                            <td class="text-center">105,702.02</td>
                            <td class="text-center">26,425.51</td>
                            <td class="text-center">132,127.53</td>
                            <td class="text-center">554,935.61</td>
                            <td class="text-center">1,008.974</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">III</td>
                            <td class="text-center">COMPACTION</td>
                            <td class="text-center align-content-center">576</td>
                            <td class="text-center align-content-center">sqm</td>
                            <td class="text-end align-content-center">57,211.68</td>
                            <td class="text-center">15.00</td>
                            <td class="text-center">10.00</td>
                            <td class="text-center"></td>
                            <td class="text-center">25.00</td>
                            <td class="text-center">14,302.92</td>
                            <td class="text-center">3,575.73</td>
                            <td class="text-center">17,878.65</td>
                            <td class="text-center">75,090.33</td>
                            <td class="text-center">130.365</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">IV</td>
                            <td class="text-center">CONCRETE PAVER</td>
                            <td class="text-center align-content-center">403</td>
                            <td class="text-center align-content-center">sqm</td>
                            <td class="text-end align-content-center">865,544.16</td>
                            <td class="text-center">15.00</td>
                            <td class="text-center">10.00</td>
                            <td class="text-center"></td>
                            <td class="text-center">25.00</td>
                            <td class="text-center">216,386.04</td>
                            <td class="text-center">54,096.51</td>
                            <td class="text-center">270,482.55</td>
                            <td class="text-center">1,136,026.71</td>
                            <td class="text-center">2,818.925</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">V</td>
                            <td class="text-center">P.P.E</td>
                            <td class="text-center align-content-center">1</td>
                            <td class="text-center align-content-center">l.s</td>
                            <td class="text-end align-content-center">15,494.00</td>
                            <td class="text-center">15.00</td>
                            <td class="text-center">10.00</td>
                            <td class="text-center"></td>
                            <td class="text-center">25.00</td>
                            <td class="text-center">3,873.50</td>
                            <td class="text-center">968.38</td>
                            <td class="text-center">4,841.88</td>
                            <td class="text-center">20,335.99</td>
                            <td class="text-center">20,335.875</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center">VI</td>
                            <td class="text-center">MOVING OUT</td>
                            <td class="text-center align-content-center">1</td>
                            <td class="text-center align-content-center">l.s</td>
                            <td class="text-end align-content-center">6,805.28</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">6,805.28</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">6,805.28</td>
                            <td class="text-center">6,805.280</td>
                        </tr>
                        <tr>
                            <td class="text-center align-content-center"></td>
                            <td class="text-center">TOTAL</td>
                            <td class="text-center align-content-center"></td>
                            <td class="text-center align-content-center"></td>
                            <td class="text-end align-content-center">1,374,668.48</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">13,610.56</td>
                            <td class="text-center"></td>
                            <td class="text-center">340,264.48</td>
                            <td class="text-center">85,066.12</td>
                            <td class="text-center">425,330.60</td>
                            <td class="text-center">1,799,999.08</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2">LABOR</td>
                            <td class="text-center">10.00</td>
                            <td>MAN-DAYS</td>
                            <td class="text-center">500.00</td>
                            <td>5,000.00</td>
                        </tr>
                        <tr>
                            <td class="text-center">1.00</td>
                            <td>UNIT</td>
                            <td class="text-center">1,805.28</td>
                            <td>1,805.28</td>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-center">A. TOTAL FOR MATERIALS</th>
                        </tr>
                        <tr>
                            <th colspan="2" rowspan="3"></th>
                            <th colspan="2" rowspan="3">NAME & CAPACITY</th>
                            <th class="text-center">NO. OF UNITS</th>
                            <th class="text-center">NO. OF DAYS</th>
                            <th class="text-center">DAILY RATE</th>
                            <th>COST</th>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-center">B. TOTAL FOR EQUIPMENT</th>
                        </tr>
                        <tr>
                            <th colspan="2" rowspan="3"></th>
                            <th colspan="2" rowspan="3">DESIGNATION</th>
                            <th class="text-center">NO. OF PERSONS</th>
                            <th class="text-center">NO. OF DAYS</th>
                            <th class="text-center">DAILY RATE</th>
                            <th>COST</th>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-center">C. TOTAL FOR LABOR</th>
                        </tr>
                        <tr>
                            <th colspan="4" rowspan="4"></th>
                            <th colspan="3">D. ESTIMATED DIRECT COSTS (A+B+C)</th>
                        </tr>
                        <tr>
                            <td colspan="3">6,805.28</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="4" rowspan="6"></th>
                            <th colspan="6">E. INDIRECT COSTS / MARK-UPS</th>
                        </tr>
                        <tr>
                            <th colspan="2">1. OVERHEAD, CONTINGENCY & MISCELLANEOUS (15% of ODC)</th>
                            <td colspan="4">1,020.80</td>
                        </tr>
                        <tr>
                            <th colspan="2">2. CONTRACTORS PROFIT (10% of EDC)</th>
                            <td colspan="4">680.53</td>
                        </tr>
                        <tr>
                            <th colspan="4" rowspan="3"></th>
                            <th colspan="2">F. RV</th>
                        </tr>
                    </tbody>
                </table> --}}
                <div class="d-flexflex-column align-items-center">
                    <div class="text-center">
                        <h5>TOTAL ESTIMATED COST IS ONE MILLION EIGHT HUNDED THOUSAND PESOS ONLY</h5>
                        <h5>Php 1,800,000.00</h5>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div style="white-space: nowrap;">
                                    Re-evaluated by: <br><br>
                                    <div style="text-align: center;">
                                        <u><b>FRITZ MILDRED N. PUABEN</b> </u> <br>
                                        Draftsman I, OUPD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div style="white-space: nowrap;">
                                    Checked by: <br><br>
                                    <div style="text-align: center;">
                                        <u><b>MARIA EILANI N. NON</b> </u> <br>
                                        Engineer II, OUPD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div style="white-space: nowrap;">
                                    Reviewed by: <br><br>
                                    <div style="text-align: center;">
                                        <u><b>REYNALDO B. MABELIN</b> </u> <br>
                                        Director, OUPD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div style="white-space: nowrap;">
                                    Checked by: <br><br>
                                    <div style="text-align: center;">
                                        <u><b>ROY V. AGBAYANI</b> </u> <br>
                                        Director, OUPD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div style="white-space: nowrap;">
                                    Recommending Approval: <br><br>
                                    <div style="text-align: center;">
                                        <u><b>HERMIE P. PAVA</b> </u> <br>
                                        VP-Administration
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div style="white-space: nowrap;">
                                    Approved: <br><br>
                                    <div style="text-align: center;">
                                        <u><b>ROLITO G. EBALLE, PH.D</b> </u> <br>
                                        University President
                                    </div>
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
                        $('#projectDuration').text(response.projects[0].project_contract_duration);

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
                            // Loop through each particular to add rows to the table
                            project.particulars.forEach(function(particular, index) {
                                var amount = parseFloat(particular.particular_quantity) *
                                    parseFloat(particular.particular_unit_cost);

                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td>' + particular.particular_unit + '</td>' +
                                    '<td>' + particular.particular_quantity + '</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + +'</td>' +
                                    '<td>' + numberWithCommas(amount.toFixed(2)) + '</td>' +
                                    '</tr>';
                            });
                            // Close the table and container
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td></td>' +
                                '<td class="text-center"><strong>Total</strong></td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
                                '<td>' + +'</td>' +
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