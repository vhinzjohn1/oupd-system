@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>
        <style>
            /* Custom CSS to change link color */
            .user-link {
                color: black !important;
                text-decoration: none;
                position: relative;
            }

            .user-link::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: -5px;
                width: 0%;
                height: 2px;
                background-color: #012F12;
                transition: width 0.3s ease, left 0.3s ease;
                /* Added left transition */
            }

            .user-link.click::after {
                width: 100%;
                left: 0;
                /* Reset position */
            }

            .userLink {
                cursor: pointer;
                display: block;
                padding: 0.5rem 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                margin-bottom: 0.5rem;
                color: white;
                text-decoration: none;
            }

            .userLink:focus {
                background-color: #ffc107 !important;
                /* Change background color when link is clicked */
                color: black !important;
                /* Change text color when link is clicked */
            }

            .btn-success {
                border: none !important;
            }

            .btn-success.active {
                border: none;
                background-color: #ffc107 !important;
                /* Change background color when link is clicked */
                color: black !important;
            }

            /* Adjust checkbox size */
            input[type="checkbox"] {
                transform: scale(1.5);
                /* Increase checkbox size */
                margin-right: 5px;
                border: none;
                /* Add spacing between checkbox and label */
            }

            /* Make text bigger and bold */
            .form-check-label {
                font-size: 18px;
                font-weight: bold;
            }

            /* Hide content by default */
            .user-content {
                display: none;
            }

            /* Slide animation */
            .user-content.show {
                display: block;
                animation: slideIn 0.5s ease forwards;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="projectsCount">0</h3>
                            <p>Projects</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-th"></i>
                        </div>
                        <a href="{{ route('projects') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="materialsCount">0</h3>
                            <p>List of Materials</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-tools"></i>
                        </div>
                        <a href="{{ route('list_of_materials') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 id="laborsCount">0</h3>
                            <p>Labor Rates</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-hard-hat"></i>
                        </div>
                        <a href="{{ route('list_of_labors') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3 id="equipmentsCount">0</h3>
                            <p>List of Equipment Rates</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-snowplow"></i>
                        </div>
                        <a href="{{ route('list_of_equipments') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>


        {{-- <div class="wrapper" id="wrapperId">
            <div class="card" id="testId">
                <div class="h2">Test</div>
            </div>
            <div class="card" id="testId">
                <div class="h2">Test</div>
            </div>
            <div class="card" id="testId">
                <div class="h2">Test</div>
            </div>
        </div> --}}
    </div>


    <script>
        // new Sortable(wrapperId, {
        //     animation: 150,
        //     ghostClass: 'blue-background-class'
        // });


        function toggleUnderline(event, element) {
            event.preventDefault(); // Prevent default link behavior

            // Remove 'click' class from all links
            document.querySelectorAll('.user-link').forEach(link => {
                link.classList.remove('click');
            });

            // Add 'click' class to the clicked link
            element.classList.add('click');
        }

        function toggleContent(contentId) {
            // Hide all form groups initially
            document.querySelectorAll('.form-group').forEach(group => {
                group.style.display = 'none';
            });

            // Show specific form groups based on the contentId
            if (contentId === 'laborManual') {
                document.querySelectorAll('.manual-input, .shared-input').forEach(group => {
                    group.style.display = 'block';
                });
            } else if (contentId === 'laborPercent') {
                document.querySelectorAll('.percent-input, .shared-input').forEach(group => {
                    group.style.display = 'block';
                });
            }
        }

        // Initialize to show 'Manual' fields by default
        document.addEventListener('DOMContentLoaded', function() {
            toggleContent('laborManual');
        });
    </script>


    <script>
        refreshDashboard();

        function refreshDashboard() {
            // Check if data is already cached in localStorage
            const cachedData = localStorage.getItem('dashboardData');

            if (cachedData) {
                // If cached data exists, parse and use it
                displayDashboard(JSON.parse(cachedData));
            }
            // Ajax to get the count of Dashboard
            $.ajax({
                url: "{{ route('dashboards.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('dashboardData', JSON.stringify(data));
                    // Display the fetched data
                    displayDashboard(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to display particular data in the DataTable
        function displayDashboard(data) {
            $('#projectsCount').text(data.projects);
            $('#materialsCount').text(data.materials);
            $('#laborsCount').text(data.labors);
            $('#equipmentsCount').text(data.equipments);
        }
        // Function to confirm deletion
        function confirmDeletion(id) {
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms again, trigger delete action
                    confirmFinalDeletion(id);
                }
            });
        }

        // Function to confirm deletion again
        function confirmFinalDeletion(id) {
            // Show SweetAlert final confirmation dialog
            Swal.fire({
                title: 'Are you really sure?',
                text: "This action is irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms again, proceed with deletion
                    deleteMaterial(id);
                }
            });
        }

        // Function to delete material
        function deleteMaterial(id) {
            axios.delete(`/materials/${id}`)
                .then(response => {
                    // Handle success response
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Material has been deleted.',
                        icon: 'success'
                    });
                })
                .catch(error => {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete material.',
                        icon: 'error'
                    });
                });
        }

        // Add event listener for the button
        $("#logValuesBtn").click(() => {
            // Get the current user details
            const userName = $("#userName").text();
            const currentUser = users.find(user => user.name === userName);
            if (!currentUser) {
                alert("Please select a User");
                return;
            }

            // Initialize the table values object
            const tableValues = {
                user_name: currentUser.name,
                user_id: currentUser.user_id,
                role_id: currentUser.role_id,
                descriptions: []
            };

            // Accumulate descriptions and actions
            $("#descriptionTable tbody tr").each(function() {
                const description = $(this).find("td:first-child").text();
                const actions = [];
                $(this).find("input[type='checkbox']").each(function() {
                    const privilege = $(this).attr("name");
                    const isChecked = $(this).prop("checked");
                    if (isChecked) {
                        actions.push(privilege);
                    }
                });
                tableValues.descriptions.push({
                    description,
                    actions
                });
            });

            // Log the table values
            console.log("Table Values:");
            console.log(tableValues);
        });
    </script>






    <!-- /.content -->
@endsection
