<div class="modal fade preview-modal" id="addProjectParticularModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjectParticularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectParticularModalLabel">Add Project Particular</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectParticularForm">
                @csrf
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <h4 class="text" id="projectParticularTitle">Project Title</h4>
                        <input type="hidden" id="projectParticularID" />
                    </div>

                    <div class="d-flex justify-content-center col-12">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="add_project_particular_name">Particular Name</label>
                                <select class="form-control" id="add_project_particular_name"
                                    name="add_project_particular_name[]" required>
                                    <!-- Options will be dynamically populated here -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Materials</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="add_project_particular_materials">Material Name</label>
                                        <input type="text" class="form-control" id="add_project_particular_materials"
                                            name="add_project_particular_materials">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Labor</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="add_project_particular_labor">Labor Name</label>
                                        <input type="text" class="form-control" id="add_project_particular_labor"
                                            name="add_project_particular_labor">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Equipment</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="add_project_particular_equipment">Equipment Name</label>
                                        <input type="text" class="form-control" id="add_project_particular_equipment"
                                            name="add_project_particular_equipment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
