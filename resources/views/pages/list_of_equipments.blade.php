@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Equipment List') }}</h1>

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
                            <table id="equipmentTable" class="table table-bordered table-striped col-12">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" id="addEquipmentButton">
                                        Add Equipment
                                    </button>
                                </div>
                                <thead>
                                    <tr>

                                        {{-- <th>Equipment Id</th> --}}
                                        <th>Equipment Name</th>
                                        <th>Equipment Category</th>
                                        <th>Model</th>
                                        <th>Capacity</th>
                                        <th>Rate</th>
                                        <th>Date Effective</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('modals.equipment.edit_equipment_modal')
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
    @include('modals.equipment.add_equipment_modal')

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $("#equipmentTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "info": true,
                // "buttons": ["copy", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#equipmentTable_wrapper .col-md-6:eq(0)');

            // Call the function to fetch and populate data in the table
            refreshEquipmentsTable();

            // Trigger to open EquipmentModal Manually
            document.getElementById('addEquipmentButton').addEventListener('click', function() {
                $('#addEquipmentModal').modal('show');
            });

            // Handle delete button click
            $('#equipmentTable').on('click', '.btn-delete-equipment', function() {
                var equipmentId = $(this).data('id');
                deleteEquipment(equipmentId);
            });

            // Attach the click handler to the table itself (or a closer static parent)
            // $('#materialTable').on('click', '.btn-edit-material', function() {
            //     console.log("Edit button clicked!");

            // });
        });

        // // Fetch categories Samples
        // $.ajax({
        //     url: '/equipment-categories', // Your Laravel route
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(categories) {
        //         console.log(categories)
        //         const select = $('#add_equipment_category_menu');

        //         // Clear any existing options before populating (optional)
        //         select.empty();

        //         $.each(categories, function(id, name) {
        //             select.append($('<a></a>').val(id).text(name));
        //         });
        //     },
        //     error: function(xhr, status, error) {
        //         console.error('Error fetching categories:', error);
        //         // Optionally display an error message to the user
        //     }
        // });

        function openEditEquipmentModal(equipment_id, equipment_rate_id, rate, equipment_name, equipment_category_name,
            equipment_model, equipment_capacity) {
            console.log("Equipment ID: " + equipment_id + ", Rate ID: " + equipment_rate_id + ", Model: " +
                equipment_model + ", Capacity: " + equipment_capacity + ", rate: " + rate);
            // Call a function to fetch equipment data by equipment_id
            $('#edit_equipment_id').val(equipment_id);
            $('#edit_equipment_category_name').val(equipment_category_name);
            $('#edit_equipment_name').val(equipment_name);
            $('#edit_equipment_model').val(equipment_model);
            $('#edit_equipment_capacity').val(equipment_capacity);
            // Assuming rates is always an array, even if empty
            $('#edit_rate').val(rate);
            $('#editEquipmentModal').modal('show');
        }

        function refreshEquipmentsTable() {
            $.ajax({
                url: "{{ route('equipments.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#equipmentTable').DataTable();
                    var existingRows = table.rows().remove().draw(false);
                    console.log(data);

                    data.forEach(function(equipment, index) {
                        console.log(equipment.equipment_rate_id);
                        console.log(equipment.rate);

                        // Assuming each equipment has a single rate associated with it
                        var newRow = table.row.add([
                            equipment.equipment_name,
                            equipment.equipment_category_name,
                            equipment.equipment_model,
                            equipment.equipment_capacity,
                            equipment.rate,
                            equipment.date_effective,
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editButton" class="btn btn-primary btn-edit-equipment mr-2"
                            data-equipment-id="${equipment.equipment_id}" data-rate-id="${equipment.equipment_rate_id}"
                            onclick="openEditEquipmentModal('${equipment.equipment_id}', '${equipment.equipment_rate_id}',
                            '${equipment.rate}', '${equipment.equipment_name}', '${equipment.equipment_category_name}',
                            '${equipment.equipment_model}', '${equipment.equipment_capacity}')"> Edit </button>` +
                            `<button type="button" class="btn btn-danger" data-id="${equipment.equipment_id}"> Delete </button>` +
                            '</div>'

                            // <button type="button" class="btn btn-danger" data-id="${equipment.equipment_id}"> Delete </button>
                        ]).node();
                    });

                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function deleteEquipment(equipmentId) {
            console.log('Deleting equipment with ID:', equipmentId);

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Equipment Entry!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('equipments') }}/" + equipmentId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Equipment Deleted Successfully!');
                            refreshEquipmentsTable();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Failed to delete equipment: ' + xhr.responseText);
                        }
                    });
                }
            });
        }

        $(document).ready(function() {

            // Handle form submission via AJAX
            $('#addEquipmentForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let equipmentName = $('#add_equipment_name').val();
                let equipmentCategory = $('#add_equipment_category').val();
                let equipment_model = $('#add_equipment_model').val();
                let equipment_capacity = $('#add_equipment_capacity').val();
                let rate = $('#add_rate').val();



                // Make AJAX request to add new equipment
                $.ajax({
                    url: "{{ route('equipments.store') }}",
                    type: "POST",
                    data: {
                        equipment_name: equipmentName,
                        equipment_category: equipmentCategory,
                        equipment_model: equipment_model,
                        equipment_capacity: equipment_capacity,
                        rate: rate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Equipment Added Successfully!');
                        $('#addEquipmentModal').modal('hide');
                        $('#addEquipmentForm')[0].reset();
                        $('.modal-backdrop').remove();
                        refreshEquipmentsTable();

                        if (response) {
                            e.preventDefault();
                            console.log('successfully added');
                        } else {
                            // Show error message if equipment addition fails
                            alert('Failed to add equipment: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });


            // edit ajax form
            $('#editEquipmentForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let edit_equipmentId = $('#edit_equipment_id').val();
                let edit_equipmentName = $('#edit_equipment_name').val();
                let edit_equipmentCategory = $('#edit_equipment_category_name').val();
                let edit_equipment_model = $('#edit_equipment_model').val();
                let edit_equipment_capacity = $('#edit_equipment_capacity').val();
                let edit_rate = $('#edit_rate').val();

                // console.log("Edit Material ID: " + edit_materialId);
                // console.log("Edit Material Name: " + edit_materialName);
                // console.log("Edit Material Category: " + edit_materialCategory);
                // console.log("Edit Unit: " + edit_unit);
                // console.log("Edit Price: " + edit_price);
                // console.log("Edit Quarter: " + edit_quarter);
                // console.log("Edit Year: " + edit_year);

                // // Make AJAX request to update equipment
                $.ajax({
                    url: "{{ route('equipments.update', ['id' => ':id']) }}".replace(':id',
                        edit_equipmentId),
                    type: "PUT",
                    data: {
                        edit_equipment_name: edit_equipmentName,
                        edit_equipment_category_name: edit_equipmentCategory,
                        edit_equipment_model: edit_equipment_model,
                        edit_equipment_capacity: edit_equipment_capacity,
                        edit_rate: edit_rate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;

                        if (response.success) {
                            toastr.success('Equipment Updated Successfully!');
                            $('#editEquipmentModal').modal('hide');
                            $('#editEquipmentForm')[0].reset();
                            refreshEquipmentsTable();
                            console.log('successfully updated');
                        } else {
                            // Show error message if equipment update fails
                            toastr.error('Failed to update equipment: ' + response.message);
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
