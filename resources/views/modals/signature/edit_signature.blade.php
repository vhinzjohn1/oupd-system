<div class="modal fade preview-modal" id="editProjectSignatureModal" tabindex="-1" role="dialog"
    aria-labelledby="editProjectSignatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectSignatureModalLabel">Edit Project Signature</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSignatureForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" id="editSignatureID">
                                <label for="edit_project_signature_fullName">Full Name</label>
                                <input placeholder="John D. Cruz" type="text" class="form-control"
                                    id="edit_project_signature_fullName" name="edit_project_signature_fullName"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_signature_degree">Title</label>
                                <input type="text" class="form-control" id="edit_signature_degree"
                                    name="edit_signature_degree" placeholder="Engr. / Ph.D / etc..">
                            </div>
                            <div class="form-group">
                                <label for="edit_project_signature_role">Role</label>
                                <select data-placeholder="Select Role" type="text" class="form-control"
                                    id="edit_project_signature_role" name="edit_project_signature_role" required>
                                    <option value=""></option>
                                    <option value="Prepared by">Prepared by</option>
                                    <option value="Prepared by (PPMP)">Prepared by (PPMP)</option>
                                    <option value="Checked by">Checked by</option>
                                    <option value="Reviewed by">Reviewed by</option>
                                    <option value="Reviewed by (ABC & DUPAS)">Reviewed by (ABC & DUPAS)</option>
                                    <option value="Reviewed by (PPMP)">Reviewed by (PPMP)</option>
                                    <option value="Recommending Approval">Recommending Approval</option>
                                    <option value="Conformed by">Conformed by</option>
                                    <option value="Approved by">Approved by</option>
                                    <option value="Submitted by">Submitted by</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_project_signature_position">Position</label>
                                <select data-placeholder="Select Position" type="text" class="form-control"
                                    id="edit_project_signature_position" name="edit_project_signature_position">
                                    <option value=""></option>
                                    <option value="University President">University President</option>
                                    <option value="Director, OUPD">Director, OUPD</option>
                                    <option value="Engineer, OUPD">Engineer, OUPD</option>
                                    <option value="Draftsman, OUPD">Draftsman, OUPD</option>
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
