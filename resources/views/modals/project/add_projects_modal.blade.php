<div class="modal fade preview-modal" id="addProjectModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_project_title">Project Title</label>
                                <input type="text" class="form-control" id="add_project_title"
                                    name="add_project_title" required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_location">Project Location</label>
                                <input type="text" class="form-control" id="add_project_location"
                                    name="add_project_location" required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_owner">Project Owner</label>
                                <input type="text" class="form-control" id="add_project_owner"
                                    name="add_project_owner" required>
                            </div>
                            <div class="form-group">
                                <label for="add_unit_office">Unit Office</label>
                                <input type="text" class="form-control" id="add_unit_office" name="add_unit_office"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_description">Project Description</label>
                                <input type="text" class="form-control" id="add_project_description"
                                    name="add_project_description" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_project_contract_duration">Contract Duration</label>
                                <input type="text" class="form-control" id="add_project_contract_duration"
                                    name="add_project_contract_duration" required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_date_prepared">Project Date Prepared</label>
                                <input type="date" class="form-control" id="add_project_date_prepared"
                                    name="add_project_date_prepared">
                            </div>
                            <div class="form-group">
                                <label for="add_project_target_start_date">Project Target Start Date</label>
                                <input type="date" class="form-control" id="add_project_target_start_date"
                                    name="add_project_target_start_date">
                            </div>
                            <div class="form-group">
                                <label for="add_project_appropriation">Project Appropriation</label>
                                <input type="number" class="form-control" id="add_project_appropriation"
                                    name="add_project_appropriation" required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_source_of_fund">Project Source of Fund</label>
                                <input type="text" class="form-control" id="add_project_source_of_fund"
                                    name="add_project_source_of_fund" required>
                            </div>
                            <div class="form-group">
                                <label for="add_project_mode_of_implementation">Project Mode of Implementation</label>
                                <input type="text" class="form-control" id="add_project_mode_of_implementation"
                                    name="add_project_mode_of_implementation" required>
                            </div>
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



<script>
    // add the function to hide modal after submit
</script>
