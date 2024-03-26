<div class="modal fade preview-modal" id="addProjectParticularModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjectParticularModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-height: 50vh;">
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

                    <div class="d-flex justify-content-center col-12" style="height: 90px;">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="add_project_particular_name">Particular Name</label>
                                <select class="form-select" id="add_project_particular_name">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Materials</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="add_project_particular_material_name">Material Name</label>
                                        <select type="text" class="form-control mySelect"
                                            id="add_project_particular_material_name"
                                            name="add_project_particular_material_name" multiple required>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_material_quantity">Quantity</label>
                                        <select class="form-control mySelect"
                                            id="add_project_particular_material_quantity"
                                            name="add_project_particular_material_quantity" multiple required>
                                        </select>
                                    </div>
                                    {{-- <div class="btn btn-success" id="CheckMaterial">Submit</div> --}}

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
                                        <select type="text" class="form-control mySelect"
                                            id="add_project_particular_labor_name"
                                            name="add_project_particular_labor_name" multiple>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_labor_no_of_person">Number of Person</label>
                                        <select type="number" class="form-control mySelect"
                                            id="add_project_particular_labor_no_of_person"
                                            name="add_project_particular_labor_no_of_person" multiple>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_labor_work_days">Work Days</label>
                                        <select type="text" class="form-control mySelect"
                                            id="add_project_particular_labor_work_days"
                                            name="add_project_particular_labor_work_days" multiple>
                                        </select>
                                    </div>
                                    {{-- <div class="btn btn-success" id="CheckLabor">Submit</div> --}}
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
                                        <select type="text" class="form-control mySelect"
                                            id="add_project_particular_equipment_name"
                                            name="add_project_particular_equipment_name" multiple>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_equipment_no_of_units">Number of
                                            Units</label>
                                        <select type="number" class="form-control mySelect"
                                            id="add_project_particular_equipment_no_of_units"
                                            name="add_project_particular_equipment_no_of_units" multiple>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="add_project_particular_equipment_work_days">Work Days</label>
                                        <select type="text" class="form-control mySelect"
                                            id="add_project_particular_equipment_work_days"
                                            name="add_project_particular_equipment_work_days" multiple>
                                        </select>
                                    </div>
                                    {{-- <div class="btn btn-success" id="CheckEquipment">Submit</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <div class="btn bg-success" id="CombineValuesButton">Save Changes</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
