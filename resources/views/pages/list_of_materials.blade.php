@extends('layouts.app')


@section('content')
    <!-- Content List of Materials -->
    <div class="content-header">
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                Add Material
                            </button>
                            <table id="materialTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Material Id</th>
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
                                    <!-- Iterate over materials data and display in rows -->
                                    @foreach ($materials as $material)
                                        <tr>
                                            <td>{{ $material->material_id }}</td>
                                            <td>{{ $material->material_name }}</td>
                                            <td>{{ $material->category->material_category_name }}</td>
                                            <td>{{ $material->unit }}</td>
                                            <td>
                                                @if ($material->prices->isNotEmpty())
                                                    {{ number_format($material->prices->first()->price, 2, '.', ',') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($material->prices->isNotEmpty())
                                                    {{ $material->prices->first()->quarter }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($material->prices->isNotEmpty())
                                                    {{ $material->prices->first()->year }}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#editMaterialModal{{ $material->material_id }}">
                                                    Edit
                                                </button>
                                                @include('modals.edit_materials_modal')
                                                <form action="" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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


    <!-- Scripts -->
    <script>
        let tdElements = document.querySelectorAll('td');
        for (let td of tdElements) {
            console.log(td.textContent);
        }
        let table = new DataTable('#materialTable');

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
                        console.log(response); // Log response for debugging
                        // $('#exampleModal').modal('hide');
                        // $('#addMaterialForm')[0].reset();

                        if (response) {
                            $('#addMaterialForm')[0].reset();
                            $('#addModal').modal('hide');

                            console.log('successfully added');
                            // // Example of reloading entire HTML content
                            // // $('.table').load(location.href + ' .table');
                            // // Reload table HTML content without refreshing the page
                            // $('.table').load(location.href + ' .table', function() {
                            //     // Reinitialize DataTable after loading content
                            //     $('#example').DataTable();
                            //     console.log('reloaded');
                            // });

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
