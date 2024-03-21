<div class="modal fade preview-modal" id="addParticularMaterial" tabindex="-1" role="dialog"
    aria-labelledby="addParticularMaterialLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParticularMaterialLabel">Add Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addParticularMaterial">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="add_particular_material">Material Name</label>
                                <input type="text" class="form-control" id="add_particular_material"
                                    name="add_particular_material" required>
                            </div>
                            <div class="form-group">
                                <label for="add_particular_category">Category Name</label>
                                <input type="text" class="form-control" id="add_particular_category"
                                    name="add_particular_category" required>
                            </div>
                            <div class="form-group">
                                <label for="add_particular_materialUnit">Unit</label>
                                <input type="text" class="form-control" id="add_particular_materialUnit"
                                    name="add_particular_materialUnit" required>
                            </div>
                            <div class="form-group">
                                <label for="add_particular_materialPrice">Price</label>
                                <input type="text" class="form-control" id="add_particular_materialPrice"
                                    name="add_particular_materialPrice">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
