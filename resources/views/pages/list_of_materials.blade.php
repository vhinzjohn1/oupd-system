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

                                        <!-- Edit Material Modal -->
                                        <div class="modal fade" id="editMaterialModal{{ $material->material_id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="editMaterialModal{{ $material->material_id }}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editMaterialModal{{ $material->material_id }}Label">Edit
                                                            Material</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form for editing material -->
                                                        <form {{-- action="{{ route('materials.update', $material->material_id) }}" --}} method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Form fields for editing material -->
                                                            <div class="form-group">
                                                                <label for="material_name">Material Name</label>
                                                                <input type="text" class="form-control"
                                                                    id="material_name" name="material_name"
                                                                    value="{{ $material->material_name }}" required>
                                                            </div>
                                                            {{-- Material Category Name --}}
                                                            <div class="form-group">
                                                                <label for="material_category_name">Material
                                                                    Category</label>
                                                                <input type="text" class="form-control"
                                                                    id="material_category_name"
                                                                    name="material_category_name"
                                                                    value="{{ $material->category->material_category_name }}"
                                                                    required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="material_category_name">Unit</label>
                                                                <input type="text" class="form-control" id="unit_name"
                                                                    name="Unit_name"
                                                                    value="{{ $material->unit->unit_name }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="price">Price</label>
                                                                <input type="text" class="form-control" id="price"
                                                                    name="price" value="{{ $material->price->price }}"
                                                                    required>
                                                            </div>
                                                            <!-- For example, you can add fields for material category, unit, and price -->
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

    <!-- Add Material Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addMaterialForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Add form fields for adding a new material -->
                        <div class="form-group">
                            <label for="material_name">Material Name</label>
                            <input type="text" class="form-control" id="material_name" name="material_name" required>
                        </div>
                        <div class="form-group">
                            <label for="material_category">Material Category</label>
                            <input type="text" class="form-control" id="material_category" name="material_category"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script>
        let table = new DataTable('#example');

        $(document).ready(function() {
            // Handle form submission via AJAX
            $('#addMaterialForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                var materialName = $('#material_name').val();
                var materialCategory = $('#material_category')
                    .val(); // Make sure this corresponds to the select field for category
                var unit = $('#unit').val();
                var price = $('#price').val();

                // Make AJAX request to add new material
                $.ajax({
                    url: "{{ route('materials.store') }}",
                    type: "POST",
                    data: {
                        material_name: materialName,
                        material_category: materialCategory,
                        unit: unit,
                        price: price,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response); // Log response for debugging
                        $('#exampleModal').modal('hide');
                        // Optionally, you can reload the page or update the table with the new data
                        // Example: window.location.reload();
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
