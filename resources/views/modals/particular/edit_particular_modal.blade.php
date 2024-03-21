<div class="modal fade preview-modal" id="editParticularModal" tabindex="-1" role="dialog"
    aria-labelledby="editParticularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editParticularModalLabel">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editParticularForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" id="edit_particular_id" name="edit_particular_id">
                            <div class="form-group">
                                <label for="edit_particular_name">Particular Name</label>
                                <input type="text" class="form-control" id="edit_particular_name"
                                    name="edit_particular_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Description</label>
                                <input type="text" class="form-control" id="edit_description" name="edit_description"
                                    required>
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
