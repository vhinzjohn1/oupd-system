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
                            <div><strong>PROJECT TITLE : </strong> <span id="projectTitle" style="font-size: 20px;"></span>
                            </div>
                            <div><strong>LOCATION : </strong> <span id="projectLocation" style="font-size: 20px;"></span>
                            </div>
                            <div><strong>OWNER : </strong> <span id="projectOwner" style="font-size: 20px;"></span></div>
                            <div><strong>SUBJECT : </strong> <span id="projectSubject" style="font-size: 20px;">Summary of
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
            {{-- <!-- Signatures Section -->
            <div class="container mt-4" id="signaturesContainer">
                <!-- Signatures will be dynamically added here -->
            </div> --}}
        </div>

        <!-- this is for the signatures -->
        <div class="container">
            <div class="container">
                <div class="row mt-4 align-items-center">
                    <div class="col d-inline-block me-1">
                        <div class="">
                            <div class="">
                                <div class="text-center" style="white-space: nowrap;">
                                    Evaluated by: <br><br>
                                    <u><b><span id="approvedName"></span>, <span id="preparedDegree"></span></b></u> <br>
                                    <span id="preparedPosition"></span>
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
                </div>
            </div>
        </div>
        <div class="approvedName"></div>
        <div class="preparedDegree"></div>
        <div class="preparedPosition"></div>

        <div class="reviewedName"></div>
        <div class="reviewedDegree"></div>
        <div class="reviewedPosition"></div>
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

                        // Call renderSignatures function to update signature elements
                        // renderSignatures(response.projects[0].signatures);

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
                                // Retrieve stored values from localStorage
                                var materialTotalAmount = parseFloat(localStorage.getItem(
                                    'materialTotalAmount')) || 0;
                                var equipmentTotalAmount = parseFloat(localStorage.getItem(
                                    'equipmentTotalAmount')) || 0;
                                var laborTotalAmount = parseFloat(localStorage.getItem(
                                        'laborTotalAmount')) ||
                                    0;
                                // var materialTotal = 0;
                                // var materialAmount = parseFloat(particular.particular_quantity) *
                                //     parseFloat(particular.particular_unit_cost);
                                // materialTotal += materialAmount;
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(
                                        materialTotalAmount.toFixed(2)) + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(
                                        equipmentTotalAmount.toFixed(2)) + '</td>' +
                                    '<td class="text-center">' + +'</td>' +
                                    '<td class="text-center">' + numberWithCommas(laborTotalAmount
                                        .toFixed(
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
                                '<table class="table table-borderless">' +
                                '<tr>' +
                                '<td class="text-left">I. Direct Cost</td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Materials</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Labor</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Equipment Rental</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center">=</td>' +
                                '<td class="text-center">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-left">II. Indirect Cost</td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">OCM (15% of Direct Cost)</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">CP (10% of Direct Cost)</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">VAT (5% of Total above Cost)</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center">=</td>' +
                                '<td class="text-center">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-left">III. Mobilization Cost</td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Moving-in</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Moving-out</td>' +
                                '<td class="text-right">' + +'</td>' +
                                '<td class="text-center">=</td>' +
                                '<td class="text-center">' + +'</td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td colspan="5" class="text-center">SAY: TOTAL ESTIMATED COST IS ONE MILLION EIGHT HUNDED THOUSAND PESOS ONLY</td>' +
                                '</tr>' + // totalInWords
                                '<tr>' +
                                '<td colspan="5" class="text-center">(Php 1,800,000.00)</td>' +
                                '</tr>' + // Total cost Item
                                '</table>' +
                                '</div>';
                            // // Populate Signatures
                            // var signaturesHTML = '';
                            // response.signatures.forEach(function(signature) {
                            //     signaturesHTML +=
                            //         '<div class="col d-inline-block me-1">' +
                            //         '<div class="">' +
                            //         '<div class="">' +
                            //         '<div class="text-center" style="white-space: nowrap;">' +
                            //         signature.position + ': <br><br>' +
                            //         '<u><b>' + signature.fullname + '</b></u> <br>' +
                            //         signature.role +
                            //         '</div><br>' +
                            //         '</div>' +
                            //         '</div>' +
                            //         '</div>';
                            // });
                            // Append the complete table to the container
                            $('#particularsContainer').html(divHTML);
                            // // Append signatures HTML to the container
                            // $('#signaturesContainer').html(signaturesHTML);
                        } else {
                            console.error('Project with ID ' + projectId + ' not found in the response.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching project details:', error);
                    }
                });
            });

            // function renderSignatures(signatures) {
            //     console.log('Rendering signatures:', signatures);
            //     for (var role in signatures) {
            //         if (signatures.hasOwnProperty(role)) {
            //             updateSignature(signatures, role, role.toLowerCase()); // Pass role as prefix
            //         }
            //     }
            // }

            // function updateSignature(signatures, role, prefix) {
            //     console.log('Updating signature for role:', role);
            //     console.log('Signature details:', signatures[role]);

            //     // Check if the signature for the role exists
            //     if (signatures.hasOwnProperty(role)) {
            //         // Update HTML elements with signature details
            //         console.log('Prefix:', prefix);
            //         console.log('Fullname:', signatures[role].fullname);
            //         console.log('Degree:', signatures[role].degree);
            //         console.log('Position:', signatures[role].position);
            //         // Retrieve signature details
            //         var fullname = signatures[role].fullname || '';
            //         var degree = signatures[role].degree || '';
            //         var position = signatures[role].position || '';

            //         // Construct element IDs using the provided prefix
            //         var nameElementId = prefix + 'Name';
            //         var degreeElementId = prefix + 'Degree';
            //         var positionElementId = prefix + 'Position';

            //         // Update HTML elements with signature details
            //         $('#' + nameElementId).text(fullname);
            //         $('#' + degreeElementId).text(degree);
            //         $('#' + positionElementId).text(position);
            //     } else {
            //         console.log('Signature not found for role:', role);
            //         // Optionally handle this case, e.g., display a default message or hide elements
            //     }
            // }



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

                function capitalizeWord(word) {
                    return word.split('').map(char => char.toUpperCase()).join('');
                }

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

                if (number === 0) {
                    return 'ZERO';
                }

                const groups = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
                let groupIndex = 0;
                let words = '';

                while (number > 0) {
                    if (number % 1000 !== 0) {
                        words = convertLessThanOneThousand(number % 1000) + ' ' + groups[groupIndex] + ' ' + words;
                    }
                    number = Math.floor(number / 1000);
                    groupIndex++;
                }

                return capitalizeWord(words.trim());
            }
        </script>

    </body>

    </html>
@endsection
