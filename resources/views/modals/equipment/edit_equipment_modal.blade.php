<div class="modal fade" id="editEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="editEquipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEquipmentModalLabel">Edit Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEquipmentForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="edit_equipment_id" name="edit_equipment_id">

                            <div class="form-group">
                                <label for="edit_equipment_name">Equipment Name</label>
                                <input type="text" class="form-control" id="edit_equipment_name"
                                    name="edit_equipment_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_equipment_category_name">Equipment Category</label>
                                <input type="text" class="form-control" id="edit_equipment_category_name"
                                    name="edit_equipment_category_name" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_equipment_model">Model</label>
                                <input type="text" class="form-control" id="edit_equipment_model"
                                    name="edit_equipment_model" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_equipment_capacity">Capacity</label>
                                <input type="text" class="form-control" id="edit_equipment_capacity"
                                    name="edit_equipment_capacity" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="edit_description">Description</label>
                                <input type="text" class="form-control" id="edit_description" name="edit_description" required>
                            </div> --}}

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_rate">Rate</label>
                                <input type="number" class="form-control" id="edit_rate" name="edit_rate" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
