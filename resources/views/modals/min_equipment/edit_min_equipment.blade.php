<div class="modal fade preview-modal" id="editMinimumEquipmentModal" tabindex="-1" role="dialog"
    aria-labelledby="editMinimumEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMinimumEquipmentModalLabel">Edit Minimum Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editMinimumEquipmentForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" id="editMinimumEquipmentID">
                                <label for="edit_min_equip_description">Description</label>
                                <input placeholder="John D. Cruz" type="text" class="form-control"
                                    id="edit_min_equip_description" name="edit_min_equip_description" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_min_equip_onwed">Owned</label>
                                <input type="text" class="form-control" id="edit_min_equip_onwed"
                                    name="edit_min_equip_onwed" placeholder="Engr. / Ph.D / etc..">
                            </div>
                            <div class="form-group">
                                <label for="edit_min_equip_lease">Lease</label>
                                <input type="text" class="form-control" id="add_min_equip_lease"
                                    name="add_min_equip_lease" placeholder="Engr. / Ph.D / etc..">
                            </div>
                            <div class="form-group">
                                <label for="edit_min_equip_totalUnits">Total # of Unit</label>
                                <input type="text" class="form-control" id="add_min_equip_totalUnits"
                                    name="add_min_equip_totalUnits" placeholder="Engr. / Ph.D / etc..">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
