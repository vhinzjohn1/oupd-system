<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="addEquipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEquipmentForm">
                @csrf
                <div class="modal-body">
                    <!-- Add form fields for adding a new Equipment -->
                    <div class="row">
                        <div class="col-6">

                            <div class="form-group">
                                <label for="add_equipment_name">Equipment Name</label>
                                <input type="text" class="form-control" id="add_equipment_name"
                                    name="add_equipment_name" required>
                            </div>
                            <div class="form-group">
                                <label for="add_equipment_category">Equipment Category</label>
                                <input type="text" class="form-control" id="add_equipment_category"
                                    name="add_equipment_category" required>
                            </div>

                            <div class="form-group">
                                <label for="add_model">Model</label>
                                <input type="text" class="form-control" id="add_equipment_model" name="add_model"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="add_capacity">Capacity</label>
                                <input type="text" class="form-control" id="add_equipment_capacity"
                                    name="add_capacity" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="add_rate">Rate</label>
                                <input type="number" class="form-control" id="add_rate" name="add_rate" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
