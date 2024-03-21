<div class="modal fade" id="editLaborModal" tabindex="-1" role="dialog" aria-labelledby="editLaborModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLaborModalLabel">Edit Labor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editLaborForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="edit_labor_id" name="edit_labor_id">
                            <div class="form-group">
                                <label for="edit_labor_name">Labor Name</label>
                                <input type="text" class="form-control" id="edit_labor_name" name="edit_labor_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_location">Location</label>
                                <input type="text" class="form-control" id="edit_location" name="edit_location"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_rate">Rate</label>
                            <input type="number" class="form-control" id="edit_rate" name="edit_rate" required>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_date_effective">Date Effective</label>
                                <input type="datetime" class="form-control" id="edit_date_effective" name="edit_date_effective" required>
                            </div>
                        </div> --}}
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
