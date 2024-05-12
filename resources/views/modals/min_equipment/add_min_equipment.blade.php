<div class="modal fade preview-modal" id="addMinimumEquipmentModal" tabindex="-1" role="dialog"
    aria-labelledby="addMinimumEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMinimumEquipmentModalLabel">Add Minimum Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addminimumEquipmentForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="add_min_equip_description">Description</label>
                                <input placeholder="Foreman" type="text" class="form-control"
                                    id="add_min_equip_description" name="add_min_equip_description" required>
                            </div>
                            <div class="form-group">
                                <label for="add_min_equip_owned">Owned</label>
                                <input type="text" class="form-control" id="add_min_equip_owned"
                                    name="add_min_equip_owned">
                            </div>
                            <div class="form-group">
                                <label for="add_min_equip_lease">Lease</label>
                                <input type="text" class="form-control" id="add_min_equip_lease"
                                    name="add_min_equip_lease" placeholder="Engr. / Ph.D / etc..">
                            </div>
                            <div class="form-group">
                                <label for="add_min_equip_totalUnits">Total # of Unit</label>
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
</div>
