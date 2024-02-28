<!-- Add Material Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Material</h5>
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
                                <label for="material_name">Material Name</label>
                                <input type="text" class="form-control" id="material_name" name="material_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="material_category">Material Category</label>
                                <input type="text" class="form-control" id="material_category"
                                    name="material_category" required>
                            </div>
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="quarter">Quarter</label>
                                <input type="text" class="form-control" id="quarter" name="quarter" required>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" name="year" required>
                            </div>
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
