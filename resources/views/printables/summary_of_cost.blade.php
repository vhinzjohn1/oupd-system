@extends('layouts.app')
@section('title', 'SUMMARY OF COST')
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

                        // // Call renderSignatures function to update signature elements
                        // renderSignatures(response.projects[0].signatures);

                        // Get the selected project ID from localStorage
                        var selectedProjectID = localStorage.getItem("projectID");

                        // Filter particulars by the selected project_id
                        var project = response.projects.find(p => p.project_id == selectedProjectID);

                        if (project) {
                            var divHTML = ''; // Initialize HTML string
                            var numberWithCommas = function(x) {
                                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            };
                            // Populate project details based on the selected project
                            $('#projectTitle').text(project.project_title);
                            $('#projectLocation').text(project.project_location);
                            $('#projectOwner').text(project.project_owner);

                            // Initialize variables for totals
                            var matAmount = 0;
                            var labAmount = 0;
                            var equipAmount = 0;
                            var matTotal = 0;
                            var equipTotal = 0;
                            var labTotal = 0;
                            var totalAmount = 0;
                            var dirTotal = 0;
                            var movingIn = 0;
                            var movingOut = 0;
                            var mobCost = 0;
                            // Create particulars table
                            divHTML +=
                                // '<div class="container text-center">' +
                                // '<div class="row mt-4">' +
                                // '<div class="row mt-2">' +
                                // '<div class="d-flex flex-column align-items-center">' +
                                // '</div>' +
                                // '<div class="d-flex flex-column align-items-start">' +
                                // '<div><strong>PROJECT TITLE: ' + project.project_title +
                                // '</strong> </div>' +
                                // '<div><strong>LOCATION: ' + project.project_location +
                                // '</strong></div>' +
                                // '<div><strong>OWNER: ' + project.project_owner + '</strong> </div>' +
                                // '<div><strong>SUBJECT : Summary of Cost</strong> </div> <br>' +
                                // '</div>' +
                                // '</div>' +
                                // '</div>' +
                                // '</div>' +
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
                            project.particulars.forEach(function(particular, index) {
                                // Calculate individual totals
                                matTotal += particular.totalMaterialAmount;
                                equipTotal += particular.totalEquipmentAmount;
                                labTotal += particular.totalLaborAmount;
                                totalAmount = particular.totalMaterialAmount + particular.totalLaborAmount + particular.totalEquipmentAmount;
                                dirTotal += totalAmount;
                                console.log('total', matAmount)
                                // Append particular details to the table
                                divHTML +=
                                    '<tr>' +
                                    '<td class="text-center">' + getRomanNumeral(index + 1) +
                                    '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(particular.totalMaterialAmount.toFixed(
                                        2)) + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(particular.totalLaborAmount.toFixed(
                                        2)) + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(particular.totalEquipmentAmount.toFixed(2)) + '</td>' +
                                    '<td class="text-center">' + numberWithCommas(totalAmount
                                        .toFixed(2)) + '</td>' +
                                    '</tr>';
                            });
                            // Calculate other totals outside the loop
                            var ocmTotal = dirTotal * (project.ocm / 100);
                            var cpTotal = dirTotal * (project.contractors_profit / 100);
                            var vatTotal = (dirTotal + ocmTotal + cpTotal) * (project.vat / 100);
                            var totalIndirCost = ocmTotal + cpTotal + vatTotal;
                            var projectCostTotal = dirTotal + totalIndirCost + mobCost;
                            var movingIn = (dirTotal * 0.01) / 2;
                            var movingOut = (dirTotal * 0.01) / 2;
                            var mobCost = movingIn + movingOut;
                            var amountInWords = convertNumberToWords(projectCostTotal);
                            // Close the table and container
                            divHTML +=
                                '</tbody>' +
                                '<tfoot>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-right"><strong>Total</strong></td>' +
                                '<td class="text-center">' + numberWithCommas(matTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center">' + numberWithCommas(labTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center">' + numberWithCommas(equipTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center">' + numberWithCommas(dirTotal.toFixed(2)) +
                                '</td>' +
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
                                '<td class="text-right">' + numberWithCommas(matTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Labor</td>' +
                                '<td class="text-right">' + numberWithCommas(labTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Equipment Rental</td>' +
                                '<td class="text-right">' + numberWithCommas(equipTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center">=</td>' +
                                '<td class="text-center">' + numberWithCommas(dirTotal.toFixed(2)) +
                                '</td>' +
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
                                '<td class="text-left">OCM (' + project.ocm + '% of Direct Cost)</td>' +
                                '<td class="text-right">' + numberWithCommas(ocmTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">CP (' + project.contractors_profit +
                                '% of Direct Cost)</td>' +
                                '<td class="text-right">' + numberWithCommas(cpTotal.toFixed(2)) + '</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">VAT (' + project.vat +
                                '% of Total above Cost)</td>' +
                                '<td class="text-right">' + numberWithCommas(vatTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center">=</td>' +
                                '<td class="text-center">' + numberWithCommas(totalIndirCost.toFixed(2)) +
                                '</td>' +
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
                                // moving in/moving out =
                                // direct cost + 0.01 / 2
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Moving-in</td>' +
                                '<td class="text-right">' + numberWithCommas(movingIn.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">Moving-out</td>' +
                                '<td class="text-right">' + numberWithCommas(movingOut.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center">=</td>' +
                                '<td class="text-center">' + numberWithCommas(mobCost.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-left">TOTAL PROJECT COST</td>' +
                                '<td class="text-right"></td>' +
                                '<td class="text-center"></td>' +
                                '<td class="text-center">' + numberWithCommas(projectCostTotal.toFixed(2)) +
                                '</td>' +
                                '<td class="text-center"></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td colspan="5" class="text-center">TOTAL ESTIMATED COST IS ' +
                                amountInWords + '</td>' +
                                '</tr>' + // totalInWords
                                '<tr>' +
                                '<td colspan="5" class="text-center">(' + numberWithCommas(projectCostTotal
                                    .toFixed(2)) + ')</td>' +
                                '</tr>' + // Total cost Item
                                '</table>' +
                                '</div>';
                            divHTML +=
                                '<div class="container">' +
                                '<div class="row mt-4">' +
                                '<div class="col-6">' +
                                '<div class="d-flex flex-column align-items-center">' +
                                '<div class="d-flex flex-column align-items-start">' +
                                '<div>' +
                                'Prepared by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Prepared by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname + '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div> <br>';
                                }
                            });
                            divHTML +=
                                '<div class="mt-3">' +
                                'Reviewed by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Reviewed by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div><br>';
                                }
                            });
                            divHTML +=
                                '<div class="mt-3">' +
                                'Conformed by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Conformed by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div><br>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                '<div class="d-flex flex-column align-items-center">' +
                                '<div class="d-flex flex-column align-items-start">' +
                                '<div>' +
                                'Checked by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Checked by') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div><br>';
                                }
                            });
                            divHTML +=
                                '<div class="mt-3">' +
                                'Recommending Approval: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Recommending Approval') {
                                    divHTML +=
                                        '<div style="text-align: center;">' +
                                        '<b><u>' + signature.fullname +
                                        '</u></b> <br>' +
                                        signature.position +
                                        '</div>' +
                                        '</div><br>';
                                }
                            });
                            divHTML +=
                                '<div class="mt-3">' +
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
                                        '</div><br>';
                                }
                            });
                            divHTML +=
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
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

                // Convert the decimal part to words
                if (decimalPart) {
                    words += ' Point';
                    for (let digit of decimalPart) {
                        words += ' ' + capitalizeWord(ones[parseInt(digit, 10)]);
                    }
                }

                return words.trim() + ' PESOS ONLY';
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
