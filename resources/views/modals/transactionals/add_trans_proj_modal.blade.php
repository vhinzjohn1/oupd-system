<div class="modal fade preview-modal" id="addTransProjModal" tabindex="-1" role="dialog"
    aria-labelledby="addTransProjModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransProjModalLabel">Add Project</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addTransProjectForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="add_trans_project_title" class="add_trans_project_title">Project
                                    Title</label>
                                <input type="text" class="form-control" id="add_trans_project_title"
                                    name="add_trans_project_title" required>
                            </div>
                            <div class="form-group">
                                <label for="add_trans_project_location">Project Location</label>
                                <input type="text" class="form-control" id="add_trans_project_location"
                                    name="add_trans_project_location" required>
                            </div>
                            <div class="form-group">
                                <label for="add_trans_project_owner">Project Owner</label>
                                <input type="text" class="form-control" id="add_trans_project_owner"
                                    name="add_trans_project_owner" required>
                            </div>
                            <div class="form-group">
                                <label for="add_trans_project_description">Project Description</label>
                                <input type="text" class="form-control" id="add_trans_project_description"
                                    name="add_trans_project_description" required>
                            </div>
                            <div class="form-group">
                                <label for="add_trans_project_contract_duration">Contract Duration</label>
                                <input type="text" class="form-control" id="add_trans_project_contract_duration"
                                    name="add_trans_project_contract_duration" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="add_trans_project_date_prepared">Project Date Prepared</label>
                                <input type="date" class="form-control" id="add_trans_project_date_prepared"
                                    name="add_trans_project_date_prepared">
                            </div>
                            <div class="form-group">
                                <label for="add_trans_project_appropriation">Project Cost</label>
                                <input type="text" class="form-control price-input"
                                    id="add_trans_project_appropriation" name="add_trans_project_appropriation"
                                    required>
                            </div>
                            <div class="form-group margin-top">
                                <label for="add_trans_project_source_of_fund">Project Source Of Fund</label>
                                <select type="text" class="form-control" id="add_trans_project_source_of_fund"
                                    name="add_trans_project_source_of_fund" placeholder="Project Source of Fund"
                                    required>
                                    <option value=""></option>
                                    <option value="General Fund">General Fund</option>
                                    <option value="Trust Fund">Trust Fund</option>
                                    <option value="Special Trust Fund">Special Trust Fund</option>
                                    <option value="RGMO">RGMO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_trans_project_mode_of_implementation">Project Mode of
                                    Implementation</label>
                                <select type="text" class="form-control"
                                    id="add_trans_project_mode_of_implementation"
                                    name="add_trans_project_mode_of_implementation" required>
                                    <option disabled selected></option>
                                    <option value="By Admin">By Admin</option>
                                    <option value="By Contract">By Contract</option>
                                </select>
                            </div>
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



<script>
    $("#add_trans_project_source_of_fund").select2({
        theme: "bootstrap-5",
        placeholder: "Select Project Source of Fund",
        dropdownParent: $('#addTransProjModal'),
    });
    $("#add_trans_project_mode_of_implementation").select2({
        theme: "bootstrap-5",
        placeholder: "Select Project Mode of Implementation",
        dropdownParent: $('#addTransProjModal'),
    });
    </script>
