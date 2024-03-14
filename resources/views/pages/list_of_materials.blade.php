@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Material List') }}</h1>

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
                            <table id="materialTable" class="table table-bordered table-striped col-12">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" id="addMaterialButton">
                                        Add Material
                                    </button>
                                </div>
                                <thead>
                                    <tr>

                                        {{-- <th>Material Id</th> --}}
                                        <th>Material Name</th>
                                        <th>Material Category</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Quarter</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('modals.edit_materials_modal')
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
    @include('modals.add_materials_modal')

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $("#materialTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "info": true,
                // "buttons": ["copy", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#materialTable_wrapper .col-md-6:eq(0)');

            // Call the function to fetch and populate data in the table
            refreshMaterialsTable();

            // Trigger to open MaterialModal Manually
            document.getElementById('addMaterialButton').addEventListener('click', function() {
                $('#addMaterialModal').modal('show');
            });

            // Handle delete button click
            $('#materialTable').on('click', '.btn-delete-material', function() {
                var materialId = $(this).data('id');
                deleteMaterial(materialId);
            });

            // Attach the click handler to the table itself (or a closer static parent)
            // $('#materialTable').on('click', '.btn-edit-material', function() {
            //     console.log("Edit button clicked!");

            // });
        });

        // Fetch categories Samples
        $.ajax({
            url: '/material-categories', // Your Laravel route
            type: 'GET',
            dataType: 'json',
            success: function(categories) {
                console.log(categories)
                const select = $('#add_material_category_menu');

                // Clear any existing options before populating (optional)
                select.empty();

                $.each(categories, function(id, name) {
                    select.append($('<a></a>').val(id).text(name));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching categories:', error);
                // Optionally display an error message to the user
            }
        });

        function openEditMaterialModal(material_id, price_id, price, quarter, year, material_name, material_category_name,
            unit) {
            console.log("Material ID: " + material_id + ", Price ID: " + price_id + ", Price: " + price + ", Quarter: " +
                quarter + ", Year: " + year);
            // Call a function to fetch material data by material_id
            $('#edit_material_id').val(material_id);
            $('#edit_material_category_name').val(material_category_name);
            $('#edit_material_name').val(material_name);
            $('#edit_unit').val(unit);
            // Assuming prices is always an array, even if empty
            $('#edit_price').val(price);
            $('#edit_quarter').val(quarter);
            $('#edit_year').val(year);
            $('#editMaterialModal').modal('show');
        }






        function refreshMaterialsTable() {
            $.ajax({
                url: "{{ route('materials.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#materialTable').DataTable();
                    var existingRows = table.rows().remove().draw(false);
                    console.log(data);

                    data.forEach(function(material, index) {
                        console.log(material.price_id);
                        console.log(material.price);
                        // Assuming each material has a single price associated with it
                        var newRow = table.row.add([
                            material.material_name,
                            material.material_category_name,
                            material.unit,
                            material.price,
                            material.quarter,
                            material.year,
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editButton" class="btn btn-primary btn-edit-material mr-2"
                                data-material-id="${material.material_id}" data-price-id="${material.price_id}"
                                onclick="openEditMaterialModal(${material.material_id}, ${material.price_id},
                                '${material.price}', '${material.quarter}', '${material.year}',
                                '${material.material_name}', '${material.material_category_name}', '${material.unit}')"> Edit </button>` +
                            '<button type="button" class="btn btn-danger btn-delete-material" data-id="' +
                            material.material_id + '"> Delete </button>' +
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

        function deleteMaterial(materialId) {
            console.log('Deleting material with ID:', materialId);

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Material Entry!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('materials') }}/" + materialId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Material Deleted Successfully!');
                            refreshMaterialsTable();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Failed to delete Material: ' + xhr.responseText);
                        }
                    });
                }
            });
        }

        $(document).ready(function() {

            // Handle form submission via AJAX
            $('#addMaterialForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let materialName = $('#add_material_name').val();
                let materialCategory = $('#add_material_category').val();
                let unit = $('#add_unit').val();
                let price = $('#add_price').val();
                let quarter = $('#add_quarter').val();
                let year = $('#add_year').val();



                // Make AJAX request to add new material
                $.ajax({
                    url: "{{ route('materials.store') }}",
                    type: "POST",
                    data: {
                        material_name: materialName,
                        material_category: materialCategory,
                        unit: unit,
                        price: price,
                        quarter: quarter,
                        year: year,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Material Added Successfully!');
                        $('#addMaterialModal').modal('hide');
                        $('#addMaterialForm')[0].reset();
                        $('.modal-backdrop').remove();
                        refreshMaterialsTable();

                        if (response) {
                            e.preventDefault();
                            console.log('successfully added');
                        } else {
                            // Show error message if material addition fails
                            alert('Failed to add material: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });


            // edit ajax form
            $('#editMaterialForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let edit_materialId = $('#edit_material_id').val();
                let edit_materialName = $('#edit_material_name').val();
                let edit_materialCategory = $('#edit_material_category_name').val();
                let edit_unit = $('#edit_unit').val();
                let edit_price = $('#edit_price').val();
                let edit_quarter = $('#edit_quarter').val();
                let edit_year = $('#edit_year').val();

                // console.log("Edit Material ID: " + edit_materialId);
                // console.log("Edit Material Name: " + edit_materialName);
                // console.log("Edit Material Category: " + edit_materialCategory);
                // console.log("Edit Unit: " + edit_unit);
                // console.log("Edit Price: " + edit_price);
                // console.log("Edit Quarter: " + edit_quarter);
                // console.log("Edit Year: " + edit_year);

                // // Make AJAX request to update material
                $.ajax({
                    url: "{{ route('materials.update', ['id' => ':id']) }}".replace(':id',
                        edit_materialId),
                    type: "PUT",
                    data: {
                        edit_material_name: edit_materialName,
                        edit_material_category_name: edit_materialCategory,
                        edit_unit: edit_unit,
                        edit_price: edit_price,
                        edit_quarter: edit_quarter,
                        edit_year: edit_year,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;

                        if (response.success) {
                            toastr.success('Material Updated Successfully!');
                            $('#editMaterialModal').modal('hide');
                            $('#editMaterialForm')[0].reset();
                            refreshMaterialsTable();
                            console.log('successfully updated');
                        } else {
                            // Show error message if Material update fails
                            toastr.error('Failed to update Material: ' + response.message);
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
