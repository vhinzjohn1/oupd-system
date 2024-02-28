<!-- Edit Material Modal -->
<div class="modal fade" id="editMaterialModal{{ $material->material_id }}" tabindex="-1" role="dialog"
    aria-labelledby="editMaterialModal{{ $material->material_id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialModal{{ $material->material_id }}Label">Edit
                    Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing material -->
                <form id="editMaterialForm">
                    @csrf
                    <!-- Form fields for editing material -->
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="edit_material_id" name="edit_material_id"
                                value="{{ $material->material_id }}" readonly>
                            <div class="form-group">
                                <label for="edit_material_name">Material Name</label>
                                <input type="text" class="form-control" id="edit_material_name"
                                    name="edit_material_name" value="{{ $material->material_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_material_category_name">Material Category</label>
                                <input type="text" class="form-control" id="edit_material_category_name"
                                    name="edit_material_category_name"
                                    value="{{ $material->category->material_category_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_unit">Unit</label>
                                <input type="text" class="form-control" id="edit_unit" name="edit_unit"
                                    value="{{ $material->unit->unit_name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="edit_price">Price</label>
                                <input type="text" class="form-control" id="edit_price" name="edit_price"
                                    value="{{ $material->price->price }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_quarter">Quarter</label>
                                <input type="text" class="form-control" id="edit_quarter" name="edit_quarter"
                                    value="{{ $material->price->quarter->quarter }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_year">Year</label>
                                <input type="text" class="form-control" id="edit_year" name="edit_year"
                                    value="{{ $material->price->year->year }}" required>
                            </div>
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
</div>
<script>
    $('#editMaterialForm').submit(function(e) {
        e.preventDefault();

        // Get form data
        var edit_materialId = $('#edit_material_id').val();
        var edit_materialName = $('#edit_material_name').val();
        var edit_materialCategory = $('#edit_material_category_name').val();
        var edit_unit = $('#edit_unit').val();
        var edit_price = $('#edit_price').val();
        var edit_quarter = $('#edit_quarter').val();
        var edit_year = $('#edit_year').val();

        // console.log("Edit Material ID: " + edit_materialId);
        // console.log("Edit Material Name: " + edit_materialName);
        // console.log("Edit Material Category: " + edit_materialCategory);
        // console.log("Edit Unit: " + edit_unit);
        // console.log("Edit Price: " + edit_price);
        // console.log("Edit Quarter: " + edit_quarter);
        // console.log("Edit Year: " + edit_year);

        // // Make AJAX request to update material
        $.ajax({
            url: "{{ route('materials.update', ['id' => ':id']) }}".replace(':id', edit_materialId),
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
</script>
