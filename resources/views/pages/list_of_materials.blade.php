@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="materialTable" class="table table-bordered table-striped">
                                <button type="button" class="btn btn-success add-material-btn" data-toggle="modal"
                                    data-target="#addModal">
                                    Add Material
                                </button>
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
                            {{-- <h3>Material Category</h3>
                        <h2>{{ $material_category = App\Models\MaterialCategory::where('material_category_id', 3)->first()->material_category_name }}
                            <h2>{{ $material = App\Models\Material::where('material_id', 2)->first()->material_name }}
                            </h2>
                        </h2> --}}
                            {{-- <h2>{{ $material->price->price_id }}</h2> --}}
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
                "buttons": ["copy", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#materialTable_wrapper .col-md-6:eq(0)');

            // Call the function to fetch and populate data in the table
            refreshMaterialsTable();

            // Attach the click handler to the table itself (or a closer static parent)
            $('#materialTable').on('click', '.btn-edit-material', function() {
                console.log("Edit button clicked!");

            });
        });

        // // Fetch categories Samples
        // $.ajax({
        //     url: '/material-categories', // Your Laravel route
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(categories) {
        //         console.log(categories)
        //         const select = $('#add_material_category');

        //         // Clear any existing options before populating (optional)
        //         select.empty();

        //         $.each(categories, function(id, name) {
        //             select.append($('<option></option>').val(id).text(name));
        //         });
        //     },
        //     error: function(xhr, status, error) {
        //         console.error('Error fetching categories:', error);
        //         // Optionally display an error message to the user
        //     }
        // });

        function openEditMaterialModal() {
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

                    data.forEach(function(material) {
                        // Assuming prices is always an array, even if empty
                        const priceData = material.prices[0] || {}; // Get price data or an empty object

                        table.row.add([
                            // material.material_id,
                            material.material_name,
                            material.category.material_category_name,
                            material.unit,
                            priceData.price,
                            priceData.quarter,
                            priceData.year,
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editButton" class="btn btn-primary btn-edit-material mr-2" data-id="${material.material_id}" onclick="openEditMaterialModal()" > Edit </button>` +
                            `<button type="button" class="btn btn-danger" data-id="${material.material_id}"> Delete </button>` +
                            // ... (add your delete button logic here) +
                            '</div>'
                        ]);
                    });

                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
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
                        toastr.success('Material added successfully!');
                        console.log(response); // Log response for debugging
                        refreshMaterialsTable();

                        if (response) {
                            $('#addMaterialForm')[0].reset();
                            $('#addModal').modal('hide');
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

                console.log("Edit Material ID: " + edit_materialId);
                console.log("Edit Material Name: " + edit_materialName);
                console.log("Edit Material Category: " + edit_materialCategory);
                console.log("Edit Unit: " + edit_unit);
                console.log("Edit Price: " + edit_price);
                console.log("Edit Quarter: " + edit_quarter);
                console.log("Edit Year: " + edit_year);

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
                        console.log(response); // Log response for debugging
                        $('#editMaterialForm').modal('hide');
                        $('#editMaterialForm')[0].reset();

                        if (response.success) {
                            e.preventDefault();
                            console.log('successfully updated');

                        } else {
                            // Show error message if material update fails
                            alert('Failed to update material: ' + response.message);
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
