<!-- Add Material Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" role="dialog" aria-labelledby="addMaterialModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialModalLabel">Add Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addMaterialForm">
                @csrf
                <div class="modal-body">
                    <!-- Add form fields for adding a new material -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="add_material_category">Material Category</label>
                                <input type="text" class="form-control" id="add_material_category"
                                    name="add_material_category" required>
                            </div>
                            <div class="form-group">
                                <label for="add_material_name">Material Name</label>
                                <input type="text" class="form-control" id="add_material_name"
                                    name="add_material_name" required>
                            </div>

                            <div class="form-group">
                                <label for="add_unit">Unit</label>
                                <input type="text" class="form-control" id="add_unit" name="add_unit" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="add_price">Price</label>
                                <input type="number" class="form-control" id="add_price" name="add_price" required>
                            </div>
                            <div class="form-group">
                                <label for="add_quarter">Quarter</label>
                                <input type="text" class="form-control" id="add_quarter" name="add_quarter" required>
                            </div>
                            <div class="form-group">
                                <label for="add_year">Year</label>
                                <input type="text" class="form-control" id="add_year" name="add_year" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
