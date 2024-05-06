@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>

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
                            <h3>10</h3>

                            <p>Projects</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-th"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>53</h3>

                            <p>List of Materials</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-tools"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>44</h3>

                            <p>Labor Rates</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-hard-hat"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3>65</h3>

                            <p>List of Equipment Rates</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-snowplow"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
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
