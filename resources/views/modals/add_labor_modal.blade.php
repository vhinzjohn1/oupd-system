<style>
    .form-group label {
        display: block;
    }

    #add_location_input {
        display: none;
    }
</style>
<!-- Add Material Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Labor Rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addLaborForm">
                @csrf
                <div class="modal-body">
                    <!-- Add form fields for adding a new labor rate -->
                    <div class="row">
                        <div class="col-6">

                            {{-- <div class="input-group">
                                <input type="text" class="form-control" aria-label="Text input with dropdown button">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu" id="add_location_menu">
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label for="add_material_category">Material Category</label>
                                <input type="text" class="form-control" id="add_material_category"
                                    name="add_material_category" required>
                            </div> --}}
                            <div class="form-group">
                                <label for="add_labor_name">Labor Name</label>
                                <input type="text" class="form-control" id="add_labor_name" name="add_labor_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="add_location">Location</label>
                                <input type="text" class="form-control" id="add_location" name="add_location"
                                    required>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="add_rate">Rate</label>
                                <input type="text" class="form-control" id="add_rate" name="add_rate" required>
                            </div>

                            {{-- <div class="form-group">
                                <label for="date_effective">Date Effective</label>
                                <input type="datetime-local" class="form-control" id="date_effective" name="date_effective" required>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label for="add_price">Price</label>
                                <input type="number" class="form-control" id="add_price" name="add_price" required>
                            </div> --}}

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
