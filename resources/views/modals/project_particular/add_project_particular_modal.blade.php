<div class="modal fade preview-modal" id="addProjectParticularModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjectParticularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectParticularModalLabel">Add Particular</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectParticularForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="add_project_particular_name">Particular Name</label>
                                <input type="text" class="form-control" id="add_project_particular_name"
                                    name="add_project_particular_name" required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_particular_description">Description</label>
                                <input type="text" class="form-control" id="add_project_particular_description"
                                    name="add_project_particular_description">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
