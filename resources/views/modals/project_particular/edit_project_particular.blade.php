<div class="modal fade preview-modal" id="editProjectParticularModal" tabindex="-1" role="dialog"
    aria-labelledby="editProjectParticularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectParticularModalLabel">Add Project Particular</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProjectParticularForm">
                @csrf
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <h4 class="text" id="projectParticularTitle">Project Title</h4>
                        <input type="hidden" id="projectParticularID" />
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit_project_particular_name">Particular Name</label>
                                <select class="form-control" id="edit_project_particular_name"
                                    name="edit_project_particular_name[]" multiple required>
                                    <!-- Options will be dynamically populated here -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_project_particular_description">Description</label>
                                <input type="text" class="form-control" id="edit_project_particular_description"
                                    name="edit_project_particular_description">
                            </div>
                            <div class="form-group">
                                <label for="edit_project_particular_remark">Remark</label>
                                <input type="text" class="form-control" id="edit_project_particular_remark"
                                    name="edit_project_particular_remark">
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
