<div class="modal fade preview-modal" id="editTechnicalPersonnelModal1" tabindex="-1" role="dialog"
    aria-labelledby="editTechnicalPersonnelModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTechnicalPersonnelModal1Label">Edit Technical Personnel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTechnicalPersonnelForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="editTechnicalPersonnelID">
                    <div class="form-group">
                        <label for="edit_personnel_no">Personnel No.</label>
                        <input type="text" class="form-control" id="edit_personnel_no" name="edit_personnel_no"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="edit_personnel_description">Description</label>
                        <input type="text" class="form-control" id="edit_personnel_description"
                            name="edit_personnel_description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
