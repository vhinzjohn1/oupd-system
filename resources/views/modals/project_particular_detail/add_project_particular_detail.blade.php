<div class="modal fade preview-modal" id="addProjectParticularDetailModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjectParticularDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectParticularDetailModalLabel">Add Particular Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectParticularDetailForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" id="add_projectPart_detailID">
                                <label for="add_projectPart_detailQuantity">Quantity</label>
                                <input type="number" class="form-control" id="add_projectPart_detailQuantity"
                                    name="add_projectPart_detailQuantity" required>
                            </div>
                            <div class="form-group">
                                <label for="add_projectPart_detailUnit">Unit</label>
                                <input type="text" class="form-control" id="add_projectPart_detailUnit"
                                    name="add_projectPart_detailUnit" placeholder="cu.m / sq.m">
                            </div>

                            <div class="form-group">
                                <label for="add_projectPart_detailUnitCost">Unit Cost</label>
                                <input type="number" class="form-control" id="add_projectPart_detailUnitCost"
                                    name="add_projectPart_detailUnitCost">
                            </div>
                            <div class="form-group">
                                <label for="add_projectPart_detailTotal">Total</label>
                                <input type="text" class="form-control" id="add_projectPart_detailTotal"
                                    name="add_projectPart_detailTotal">
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
