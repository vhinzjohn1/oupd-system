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
