@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Labor Rates') }}</h1>
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
                            <table id="laborTable" class="table table-bordered table-striped col-12">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" id="addLaborButton">
                                        Add Labor Rate
                                    </button>
                                </div>
                                <thead>
                                    <tr>

                                        {{-- <th>Labor Id</th> --}}
                                        <th>Labor Name</th>
                                        <th>Location</th>
                                        <th>Rate</th>
                                        <th>Date Effective</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('modals.labor.edit_labor_modal')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    @include('modals.labor.add_labor_modal')

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $("#laborTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "info": true,
                // "buttons": ["copy", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#laborTable_wrapper .col-md-6:eq(0)');

            // Call the function to fetch and populate data in the table
            refreshLaborsTable();

            // Trigger to open LaborModal Manually
            document.getElementById('addLaborButton').addEventListener('click', function() {
                $('#addLaborModal').modal('show');
            });

            // Handle delete button click
            $('#laborTable').on('click', '.btn-delete-labor', function() {
                var laborId = $(this).data('id');
                deleteLabor(laborId);
            });

        });

        function openEditLaborModal(labor_id, labor_rate_id, rate, labor_name, location) {
            console.log("Labor ID: " + labor_id + ", Rate ID: " + labor_rate_id + ", Location: " +
                location + ", rate: " + rate);
            // Call a function to fetch labor data by labor_id
            $('#edit_labor_id').val(labor_id);
            $('#edit_labor_name').val(labor_name);
            $('#edit_location').val(location);
            // Assuming rates is always an array, even if empty
            $('#edit_rate').val(rate);
            $('#editLaborModal').modal('show');
        }
        // Function to fetch labor data by labor_id
        function fetchLaborData(labor_id) {
            $.ajax({
                url: "{{ route('labor.index') }}/" +
                    labor_id, // Adjust the route to fetch individual labor data
                type: 'GET',
                dataType: 'json',
                success: function(labor) {
                    // Populate the form fields with the fetched labor data
                    $('#edit_labor_id').val(labor.labor_id);
                    // $('#edit_material_category_name').val(material.category.material_category_name);
                    $('#edit_location').val(labor.location);
                    $('#edit_labor_name').val(labor.labor_name);
                    // $('#edit_rate').val(labor.rate);

                    // Assuming prices is always an array, even if empty
                    const rateData = labor.rates[0] || {};
                    $('#edit_rate').val(rateData.rate);
                    // $('#edit_quarter').val(rateData.quarter);
                    // $('#edit_year').val(rateData.year);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function refreshLaborsTable() {
            $.ajax({
                url: "{{ route('labors.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#laborTable').DataTable();
                    var existingRows = table.rows().remove().draw(false);
                    console.log(data);

                    data.forEach(function(labor, index) {
                        // Assuming rates is always an array, even if empty
                        const rateData = labor.rates[0] || {}; // Get rate data or an empty object

                        // Assuming each labor has a single rate associated with it
                        var newRow = table.row.add([
                            labor.labor_name,
                            labor.location,
                            labor.rate,
                            labor.date_effective,
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editButton" class="btn btn-primary btn-edit-labor mr-2"
                            data-labor-id="${labor.labor_id}" data-rate-id="${labor.labor_rate_id}"
                            onclick="openEditLaborModal('${labor.labor_id}', '${labor.labor_rate_id}',
                            '${labor.rate}', '${labor.labor_name}', '${labor.location}')"> Edit </button>` +
                            `<button type="button" class="btn btn-danger" data-id="${labor.labor_id}"> Delete </button>` +
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

        // // Function to fetch labor data by labor_id
        // function fetchLaborData(labor_id) {
        //     $.ajax({
        //         url: "{{ route('labors.index') }}/" +
        //             labor_id, // Adjust the route to fetch individual labor data
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(labor) {
        //             // Populate the form fields with the fetched labor data
        //             $('#edit_labor_id').val(labor.labor_id);
        //             // $('#edit_material_category_name').val(material.category.material_category_name);
        //             $('#edit_location').val(labor.location);
        //             $('#edit_labor_name').val(labor.labor_name);
        //             // $('#edit_rate').val(labor.rate);

        //             // Assuming prices is always an array, even if empty
        //             const rateData = labor.rates[0] || {};
        //             $('#edit_rate').val(rateData.rate);
        //             // $('#edit_quarter').val(rateData.quarter);
        //             // $('#edit_year').val(rateData.year);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // }



        // function refreshLaborsTable() {
        //     $.ajax({
        //         url: "{{ route('labors.index') }}",
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(data) {
        //             var table = $('#laborTable').DataTable();
        //             var existingRows = table.rows().remove().draw(false);
        //             console.log(data);

        //             data.forEach(function(labor, index) {
        //                 // Assuming rates is always an array, even if empty
        //                 const rateData = labor.rates[0] || {}; // Get rate data or an empty object

        //                 var newRow = table.row.add([
        //                     labor.labor_name,
        //                     labor.location,
        //                     rateData.rate,
        //                     rateData.date_effective, // Add the date_effective here
        //                     '<div class="text-center d-flex">' +
        //                     `<button type="button" id="editButton" class="btn btn-primary btn-edit-labor mr-2" data-id="${labor.labor_id},${labor.labor_rate_id},'${rateData.location}','${rateData.rate}'" onclick="openEditLaborModal(${labor.labor_id}, ${labor.labor_rate_id}, '${rateData.location}', '${rateData.rate}')"> Edit </button>` +
        //                     `<button type="button" class="btn btn-danger" data-id="${labor.labor_id}"> Delete </button>` +
        //                     // ... (add your delete button logic here) +
        //                     '</div>'
        //                 ]).node();


        //             });

        //             table.draw();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // }




        // function refreshMaterialsTable() {
        //     $.ajax({
        //         url: "{{ route('materials.index') }}",
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(data) {
        //             var table = $('#materialTable').DataTable();
        //             var existingRows = table.rows().remove().draw(false);
        //             console.log(data);

        //             data.forEach(function(material) {
        //                 // Assuming prices is always an array, even if empty
        //                 const priceData = material.prices[0] || {}; // Get price data or an empty object

        //                 table.row.add([
        //                     // material.material_id,
        //                     material.material_name,
        //                     material.category.material_category_name,
        //                     material.unit,
        //                     priceData.price,
        //                     priceData.quarter,
        //                     priceData.year,
        //                     '<div class="text-center d-flex">' +
        //                     `<button type="button" id="editButton" class="btn btn-primary btn-edit-material mr-2" data-id="${material.material_id}" onclick="openEditMaterialModal(${material.material_id})" > Edit </button>` +
        //                     `<button type="button" class="btn btn-danger" data-id="${material.material_id}"> Delete </button>` +
        //                     // ... (add your delete button logic here) +
        //                     '</div>'
        //                 ]);
        //             });

        //             table.draw();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // }

        $(document).ready(function() {

            // Handle form submission via AJAX
            $('#addLaborForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let laborName = $('#add_labor_name').val();
                let location = $('#add_location').val();
                let rate = $('#add_rate').val();


                // Make AJAX request to add new labor
                $.ajax({
                    url: "{{ route('labors.store') }}",
                    type: "POST",
                    data: {
                        labor_name: laborName,
                        location: location,
                        rate: rate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        $('#addLaborForm')[0].reset();
                        $('#addLaborModal').modal('hide');
                        toastr.options.progressBar = true;
                        toastr.success('Labor Added Successfully!');
                        console.log(response); // Log response for debugging
                        refreshLaborsTable();



                        if (response.success) {
                            $('#addLaborForm')[0].reset();
                            $('#addModal').modal('hide');
                            console.log('successfully added');
                        } else {
                            // Show error message if Labor addition fails
                            alert('Failed to add Labor: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });


            // edit ajax form
            $('#editLaborForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let edit_laborId = $('#edit_labor_id').val();
                let edit_laborName = $('#edit_labor_name').val();
                let edit_location = $('#edit_location').val();
                let edit_rate = $('#edit_rate').val();

                $.ajax({
                    url: "{{ route('labors.update', ['id' => ':id']) }}".replace(':id',
                        edit_laborId),
                    type: "PUT",
                    data: {
                        edit_labor_name: edit_laborName,
                        edit_location: edit_location,
                        edit_rate: edit_rate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;

                        if (response.success) {
                            toastr.success('Labor Updated Successfully!');
                            $('#editLaborModal').modal('hide');
                            $('#editLaborForm')[0].reset();
                            refreshLaborsTable();
                            console.log('Successfully updated');
                        } else {
                            toastr.error('Failed to update labor: ' + response.message);
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
