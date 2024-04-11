<div class="modal fade preview-modal" id="testModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">Add Project Particular</h5>
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
                                <label for="testPart">Particular Name</label>
                                <select class="form-control" id="testPart" name="testPart" required>
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
                                        <label for="add_project_particular_material_name">Material Name</label>
                                        <input type="text" class="form-control" id="add_project_particular_materials"
                                            name="add_project_particular_materials">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_material_quantity">Quantity</label>
                                        <input type="number" class="form-control"
                                            id="add_project_particular_material_quantity"
                                            name="add_project_particular_material_quantity">
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
                                        <label for="add_project_particular_labor_name">Labor Name</label>
                                        <input type="text" class="form-control"
                                            id="add_project_particular_labor_name"
                                            name="add_project_particular_labor_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_labor_no_of_person">Number of Person</label>
                                        <input type="number" class="form-control"
                                            id="add_project_particular_labor_no_of_person"
                                            name="add_project_particular_labor_no_of_person">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_labor_work_days">Work Days</label>
                                        <input type="text" class="form-control"
                                            id="add_project_particular_labor_work_days"
                                            name="add_project_particular_labor_work_days">
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
                                        <label for="add_project_particular_equipment_name">Equipment Name</label>
                                        <input type="text" class="form-control"
                                            id="add_project_particular_equipment_name"
                                            name="add_project_particular_equipment_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_equipment_no_of_units">Number of
                                            Units</label>
                                        <input type="number" class="form-control"
                                            id="add_project_particular_equipment_no_of_units"
                                            name="add_project_particular_equipment_no_of_units">
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_equipment_work_days">Work Days</label>
                                        <input type="text" class="form-control"
                                            id="add_project_particular_equipment_work_days"
                                            name="add_project_particular_equipment_work_days">
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
