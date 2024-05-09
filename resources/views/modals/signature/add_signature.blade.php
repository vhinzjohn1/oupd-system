<div class="modal fade preview-modal" id="addProjectSignatureModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjectSignatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectSignatureModalLabel">Add Project Signature</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSignatureForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="add_project_signature_fullName">Full Name</label>
                                <input placeholder="John D. Cruz" type="text" class="form-control"
                                    id="add_project_signature_fullName" name="add_project_signature_fullName" required>
                            </div>
                            <div class="form-group">
                                <label for="add_signature_degree">Title</label>
                                <input type="text" class="form-control" id="add_signature_degree"
                                    name="add_signature_degree" placeholder="Engr. / Ph.D / etc..">
                            </div>
                            <div class="form-group">
                                <label for="add_project_signature_role">Role</label>
                                <select data-placeholder="Select Role" type="text" class="form-control"
                                    id="add_project_signature_role" name="add_project_signature_role" required>
                                    <option value=""></option>
                                    <option value="Prepared by">Prepared by</option>
                                    <option value="Checked by">Checked by</option>
                                    <option value="Reviewed by">Reviewed by</option>
                                    <option value="Recommending Approval">Recommending Approval</option>
                                    <option value="Conformed by">Conformed by</option>
                                    <option value="Approved">Approved</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_project_signature_position">Position</label>
                                <select data-placeholder="Select Postion" type="text" class="form-control"
                                    id="add_project_signature_position" name="add_project_signature_position">
                                    <option value=""></option>
                                    <option value="CMU President">CMU President</option>
                                    <option value="Draftsman">Draftsman</option>
                                    <option value="President">President</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
