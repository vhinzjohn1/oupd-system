<div class="modal fade" id="addTechnicalPersonnelModal" tabindex="-1" role="dialog"
    aria-labelledby="addTechnicalPersonnelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTechnicalPersonnelModalLabel">Add Technical Personnel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTechnicalPersonnelForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_personnel_no">Personnel No.</label>
                        <input type="text" class="form-control" id="add_personnel_no" name="personnel_no">
                    </div>
                    <div class="form-group">
                        <label for="add_personnel_description">Description</label>
                        <input type="text" class="form-control" id="add_personnel_description"
                            name="personnel_description" placeholder="Foreman" required>
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