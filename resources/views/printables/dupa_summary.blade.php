@extends('layouts.app')
@section('title', 'DUPA SUMMARY')
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

                .mfb-zoomin {
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
        <!------ Floating Button ----->
        {{-- <ul id="menu" class="mfb-component--br mfb-zoomin" id="floatBtn" data-mfb-toggle="hover">
            <li class="mfb-component__wrap">
                <a href="#" class="mfb-component__button--main">
                    <i class="mfb-component__main-icon--resting ion-plus-round"></i>
                    <i class="mfb-component__main-icon--active ion-close-round"></i>
                </a>
                <ul class="mfb-component__list">
                    <li>
                        <a href="#" id="printView" data-mfb-label="Print" class="mfb-component__button--child">
                            <i class="mfb-component__child-icon"><span class="material-symbols-outlined">
                                    print
                                </span></i></i>
                        </a>
                    </li>
                </ul>
            </li>
        </ul><!------- End of Floating Button ------> --}}
        <div class="btn hideBtn btn-right btn-lg btn-outline-dark" id="printView">Print</div>


        {{-- <!-- Project Details -->
        < class="container text-center">
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
        <div class="" id="preparedBy">

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
                        console.log('This is the reponse', response);

                        // Get the selected project ID from localStorage
                        var selectedProjectID = localStorage.getItem("projectID");

                        // Filter particulars by the selected project_id
                        var project = response.projects.find(p => p.project_id == selectedProjectID);

                        if (project) {
                            var totalCostAmount = 0;
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

                            console.log('title', project.project_title)
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
                                directCostTotal = particular.totalMaterialAmount + particular
                                    .totalLaborAmount + particular.totalEquipmentAmount;
                                var ocmTotal = directCostTotal * (particular.ocm / 100);
                                var cpTotal = directCostTotal * (particular.contractors_profit /
                                    100);
                                var indirectCostTotal = ocmTotal + cpTotal;
                                var vatTotal = (directCostTotal + indirectCostTotal) * (particular
                                    .vat / 100);
                                var totalCostItem = directCostTotal + indirectCostTotal + vatTotal;
                                var unitCostTotal = totalCostItem / particular.quantity;
                                console.log('vat: ', totalCostItem)

                                totalCostAmount += totalCostItem;
                                // Add row for the particular
                                divHTML +=
                                    '<tr>' +
                                    '<td>' + getRomanNumeral(index + 1) + '</td>' +
                                    '<td>' + particular.particular_name + '</td>' +
                                    '<td class="text-center">' + particular.unit +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(parseFloat(
                                        particular.quantity).toFixed(2)) +
                                    '</td>' +
                                    '<td class="text-right">' + numberWithCommas(totalCostItem
                                        .toFixed(
                                            2)) + '</td>' +
                                    '<td class="text-right">' + numberWithCommas(parseFloat(
                                        unitCostTotal).toFixed(
                                        2)) +
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
                                '<td class="text-right">' + numberWithCommas(totalCostAmount.toFixed(2)) +
                                '</td>' +
                                '</tr>' +
                                '</tfoot>' +
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
                                'Submitted by: <br><br>';
                            project.signatures.forEach(function(signature) {
                                if (signature.role === 'Submitted by') {
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
                            // Append the complete table to the container
                            $('#particularsContainer').html(divHTML);
                            $('#preparedBy').html(preparedBy);
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
