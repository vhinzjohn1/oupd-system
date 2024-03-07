@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Particulars') }}</h1>
                </div><!-- /.col -->
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
                                        Add Particular
                                    </button>
                                </div>
                                @include('modals.particular.add_particular_modal');

                                <thead>
                                    <tr>
                                        <th>Particular Name</th>
                                        <th>Description</th>
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

            }).buttons().container().appendTo('#particularTable_wrapper .col-12');

            // Call the function to fetch and populate data in the table
            refreshParticularTable();

            // Trigger to open Particular Modal Manually
            document.getElementById('addParticularButton').addEventListener('click', function() {
                $('#addParticularModal').modal('show');
            });


        });

        function refreshParticularTable() {
            $.ajax({
                url: "{{ route('particulars.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#particularTable').DataTable();
                    var existingRows = table.rows().remove().draw(false);
                    console.log(data);

                    data.forEach(function(particular, index) {
                        var newRow = table.row.add([
                            particular.particular_name,
                            particular.description,
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editParticularButton" class="btn btn-primary mr-2" data-id="${particular.particular_id}" onclick="openParticularModal(${particular.particular_id}, '${particular.particular_name}', '${particular.description}')"> Edit </button>` +
                            `<button type="button" id="deleteParticularButton" class="btn btn-danger" data-id="${particular.particular_id}" onclick="deleteParticular(${particular.particular_id})"> Delete </button>` +
                            // ... (add your delete button logic here) +
                            '</div>'
                        ]).node();

                    });

                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function openParticularModal(particular_id, particular_name, description) {
            console.log(particular_id);
            // Populate modal fields with passed values
            $('#edit_particular_id').val(particular_id);
            $('#edit_particular_name').val(particular_name);
            $('#edit_description').val(description);

            // Show the modal
            $('#editParticularModal').modal('show');

        }

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
                            refreshMaterialsTable();
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
                if (descriptionInput.value.trim() === '') {
                    descriptionInput.value = 'Not specified';
                }

                // Get form data
                let particularName = $('#add_particular_name').val();
                let description = $('#add_description').val();


                // Make AJAX request to add new paticular
                $.ajax({
                    url: "{{ route('particulars.store') }}",
                    type: "POST",
                    data: {
                        particular_name: particularName,
                        description: description,
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

                            refreshMaterialsTable();

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

                            refreshMaterialsTable(); // Update the materials table
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
