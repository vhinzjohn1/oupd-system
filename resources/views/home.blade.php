@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>

        <style>
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

            .btn-success.active {
                background-color: #ffc107 !important;
                /* Change background color when link is clicked */
                color: black !important;
            }

            /* Adjust checkbox size */
            input[type="checkbox"] {
                transform: scale(1.5);
                /* Increase checkbox size */
                margin-right: 5px;
                /* Add spacing between checkbox and label */
            }

            /* Make text bigger and bold */
            .form-check-label {
                font-size: 18px;
                font-weight: bold;
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
            <!------- This is the User Permission Section ------>
            <div class="btn btn-success" id="submitBtn">Submit</div>



        </div>
    </div>



    <script>
        $('#submitBtn').click(function() {
           router.visit('home');
        })
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
