@extends('layouts.app')
@section('title', 'List of Items')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Project Item') }}</h1>
                </div><!-- /.col -->
                {{-- <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" id="addParticularButton">
                        Add Item
                    </button>
                </div> --}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table col-12" id="particularTable">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        id="addParticularButton">
                                        Add Pay Item
                                    </button>
                                </div>
                                @include('modals.particular.add_particular_modal');
                                <thead>
                                    <tr>
                                        <th>Pay Item Name</th>
                                        <th>Pay Item (Number)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    @include('modals.particular.edit_particular_modal');
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $("#particularTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
            });

            // Call the function to fetch and populate data in the table
            refreshParticularTable();

            // Trigger to open Particular Modal Manually
            document.getElementById('addParticularButton').addEventListener('click', function() {
                $('#addParticularModal').modal('show');
            });


        });

        // Populate the Table and Refresh at the same time
        function refreshParticularTable() {
            // Check if data is already cached in localStorage
            var cachedData = localStorage.getItem('particularsData');

            if (cachedData) {
                // If cached data exists, parse and use it
                displayParticulars(JSON.parse(cachedData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('particulars.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('particularsData', JSON.stringify(data));
                    // Display the fetched data
                    displayParticulars(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to display particular data in the DataTable
        function displayParticulars(data) {
            var table = $('#particularTable').DataTable();
            table.clear().draw();

            data.forEach(function(particular, index) {
                var editButton =
                    `<button type="button" class="btn bg-success mr-2 editParticularButton" data-id="${particular.particular_id}" data-name="${particular.particular_name}" data-pay-item="${particular.pay_item}"><i class="fas fa-edit"></i></button>`;
                var deleteButton =
                    `<button type="button" class="btn bg-danger deleteParticularButton" data-id="${particular.particular_id}"><i class="fas fa-trash-alt"></i></button>`;
                var buttonsContainer = '<div class="text-center d-flex">' + editButton + deleteButton + '</div>';

                var newRow = table.row.add([
                    particular.particular_name,
                    particular.pay_item,
                    buttonsContainer
                ]).node();
            });

            table.draw();

            // Add event listeners for dynamically created buttons
            $('#particularTable').on('click', '.editParticularButton', function() {
                var particularId = $(this).data('id');
                var particularName = $(this).data('name');
                var payItem = $(this).data('pay-item');
                openParticularModal(particularId, particularName, payItem);
            });

            $('#particularTable').on('click', '.deleteParticularButton', function() {
                var particularId = $(this).data('id');
                deleteParticular(particularId);
            });
        }



        // Manually Open Particular Modal
        function openParticularModal(particular_id, particular_name, pay_item) {
            if (pay_item === "null") {
                pay_item = "";
            }
            // Populate modal fields with passed values
            $('#edit_particular_id').val(particular_id);
            $('#edit_particular_name').val(particular_name);
            $('#edit_description').val(pay_item);

            // Show the modal
            $('#editParticularModal').modal('show');

        }


        // Delete Function for Particular
        function deleteParticular(particular_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this particular!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('particulars') }}/" + particular_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Particular Deleted Successfully!');
                            refreshParticularTable();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting particular. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }



        $(document).ready(function() {
            // Handle Adding of Paticular
            $('#addParticularForm').submit(function(e) {
                e.preventDefault();
                let descriptionInput = document.getElementById('add_description');

                // Get form data
                let particularName = $('#add_particular_name').val();
                let pay_item = $('#add_description').val();


                // Make AJAX request to add new paticular
                $.ajax({
                    url: "{{ route('particulars.store') }}",
                    type: "POST",
                    data: {
                        particular_name: particularName,
                        pay_item: pay_item,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Project Added Successfully!');
                        console.log(response); // Log response for debugging

                        if (response) {
                            $('#addParticularForm')[0].reset();
                            $('#addParticularModal').modal('hide');

                            console.log('successfully added');

                            refreshParticularTable();

                        } else {
                            // Show error message if material addition fails
                            alert('Failed to add project: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });

            // Handle Editing of Paticular
            $('#editParticularForm').submit(function(e) {
                console.log('Form submit')
                e.preventDefault();

                // Get form data
                let particularID = $('#edit_particular_id').val();
                let particularName = $('#edit_particular_name').val();
                let description = $('#edit_description').val();


                // Make AJAX request to update the project
                $.ajax({
                    url: "{{ route('particulars.update', ['id' => ':id']) }}".replace(':id',
                        particularID),
                    type: "PUT", // Assuming you are using PUT method for update, change it if needed
                    data: {
                        particular_name: particularName,
                        description: description,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Project Updated Successfully!');
                        console.log(response); // Log response for debugging

                        if (response) {
                            // Optionally, you can reset the form and close the modal here
                            $('#editParticularForm')[0].reset();
                            $('#editParticularModal').modal('hide');

                            refreshParticularTable(); // Update the materials table
                        } else {
                            // Show error message if project update fails
                            alert('Failed to update project: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });

        });
    </script>
@endsection
