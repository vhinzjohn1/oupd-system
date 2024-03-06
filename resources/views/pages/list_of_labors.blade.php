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
                            <table id="laborTable" class="table table-bordered table-striped">
                                <button type="button" class="btn btn-success add-labor-btn" data-toggle="modal"
                                    data-target="#addModal">
                                    Add Labor Rate
                                </button>
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
                                    @include('modals.edit_labor_modal')
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
    @include('modals.add_labor_modal')

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

            // Attach the click handler to the table itself (or a closer static parent)
            // $('#materialTable').on('click', '.btn-edit-material', function() {
            //     console.log("Edit button clicked!");

            // });
        });

        // Fetch categories Samples
        // No categories available for labor
        // $.ajax({
        //     url: '/material-categories', // Your Laravel route
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(categories) {
        //         console.log(categories)
        //         const select = $('#add_material_category_menu');

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

        function openEditLaborModal(labor_id) {
            // Call a function to fetch labor data by labor_id
            fetchlLaborData(labor_id);
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
                    const rateData = material.rates[0] || {};
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

                        var newRow = table.row.add([
                            // material.labor_id,
                            labor.labor_name,
                            labor.location,
                            rateData.rate,
                            rateData.date_effective, // Add the date_effective here
                            '<div class="text-center d-flex">' +
                            `<button type="button" id="editButton" class="btn btn-primary btn-edit-labor mr-2" data-id="${labor.labor_id}" onclick="openEditlaborModal(${labor.labor_id})" > Edit </button>` +
                            `<button type="button" class="btn btn-danger" data-id="${labor.labor_id}"> Delete </button>` +
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
                        toastr.options.progressBar = true;
                        toastr.success('Labor Added Successfully!');
                        console.log(response); // Log response for debugging
                        refreshLaborsTable();

                        if (response.success) {
                            $('#addLaborForm')[0].reset();
                            $('#addModal').modal('hide');
                            console.log('successfully added');
                        } else {
                            // // Show error message if labor addition fails
                            // alert('Failed to add labor: ' + response.message);
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
                // console.log("Edit Material ID: " + edit_materialId);
                // console.log("Edit Material Name: " + edit_materialName);
                // console.log("Edit Material Category: " + edit_materialCategory);
                // console.log("Edit Unit: " + edit_unit);
                // console.log("Edit Price: " + edit_price);
                // console.log("Edit Quarter: " + edit_quarter);
                // console.log("Edit Year: " + edit_year);

                // // Make AJAX request to update material
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
                        toastr.success('Labor Updated Successfully!');
                        $('#editLaborModal').modal('hide');
                        $('#editLaborForm')[0].reset();
                        refreshLaborsTable();

                        if (response.success) {
                            e.preventDefault();
                            console.log('successfully updated');

                        } else {
                            // Show error message if labor update fails
                            alert('Failed to update labor: ' + response.message);
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
