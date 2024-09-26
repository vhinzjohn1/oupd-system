<style>
    .form-group label {
        display: block;
    }

    #add_location_input {
        display: none;
    }
</style>
<!-- Add Material Modal -->
<div class="modal fade" id="addLaborModal" tabindex="-1" role="dialog" aria-labelledby="addLaborModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLaborModalLabel">Add Labor Rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addLaborForm">
                @csrf
                <div class="modal-body">
                    <!-- Add form fields for adding a new labor rate -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="add_labor_name">Labor Name</label>
                                <input type="text" class="form-control" id="add_labor_name" name="add_labor_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="add_rate">Rate</label>
                                <input type="number" class="form-control" id="add_rate" step="any" name="add_rate"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
