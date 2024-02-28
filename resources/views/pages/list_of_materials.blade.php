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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Add Material
                            </button>
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
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
                                            <td>{{ $material->material_name }}</td>
                                            <td>{{ $material->category->material_category_name }}</td>
                                            <td>{{ $material->unit->unit_name }}</td>
                                            <td>{{ $material->price->price }}</td>
                                            <td>{{ $material->price->quarter->quarter }}</td>
                                            <td>{{ $material->price->year->year }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#editMaterialModal{{ $material->material_id }}">
                                                    Edit
                                                </button>
                                                <form action="" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @include('modals.edit_materials_modal')
                                    @endforeach
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


    <!-- Scripts -->
    <script>
        let table = new DataTable('#example');

        $(document).ready(function() {
            // Handle form submission via AJAX
            $('#addMaterialForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                var materialName = $('#material_name').val();
                var materialCategory = $('#material_category').val();
                var unit = $('#unit').val();
                var price = $('#price').val();
                var quarter = $('#quarter').val();
                var year = $('#year').val();

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
                        $('#exampleModal').modal('hide');
                        $('#addMaterialForm')[0].reset();

                        if (response.success) {
                            console.log('successfully added');
                            // Example of reloading entire HTML content
                            // $('.table').load(location.href + ' .table');
                            // Reload table HTML content without refreshing the page
                            $('.table').load(location.href + ' .table', function() {
                                // Reinitialize DataTable after loading content
                                $('#example').DataTable();
                                console.log('reloaded');
                            });

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
        });
    </script>
@endsection
