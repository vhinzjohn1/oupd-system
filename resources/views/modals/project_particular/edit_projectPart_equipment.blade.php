<div class="modal fade preview-modal" id="editPartEquipmentModal" tabindex="-1" role="dialog"
    aria-labelledby="editPartEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartEquipmentModalLabel">Edit Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProjectPartEquipmentForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="edit_particular_EquipmentID">
                                <label for="edit_particular_EquipmentName">Equipment Name</label>
                                <input type="text" class="form-control" id="edit_particular_EquipmentName"
                                    name="edit_particular_EquipmentName" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_EquipmentCategory">Category</label>
                                <input type="text" class="form-control" id="edit_particular_EquipmentCategory"
                                    name="edit_particular_EquipmentCategory" required readonly>
                                </input>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_EquipmentModel">Model</label>
                                <input type="text" class="form-control" id="edit_particular_EquipmentModel"
                                    name="edit_particular_EquipmentModel" required readonly>
                                </input>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_EquipmentCapacity">Capacity</label>
                                <input type="text" class="form-control" id="edit_particular_EquipmentCapacity"
                                    name="edit_particular_EquipmentCapacity" required readonly>
                                </input>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="edit_particular_EquipmentRate">Rate</label>
                                <input type="text" class="form-control" id="edit_particular_EquipmentRate"
                                    name="edit_particular_EquipmentRate" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_noOfUnit">No of Units</label>
                                <input type="number" class="form-control" id="edit_particular_noOfUnit"
                                    name="edit_particular_noOfUnit" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_EquipmentWorkDays">Work Days</label>
                                <input type="number" class="form-control" id="edit_particular_EquipmentWorkDays"
                                    name="edit_particular_EquipmentWorkDays" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_EquipmentAmount">Amount</label>
                                <input type="text" class="form-control" id="edit_particular_EquipmentAmount"
                                    name="edit_particular_EquipmentAmount" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // JavaScript/jQuery
    $(document).ready(function() {
        // Function to format number with commas for thousands
        function formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Function to calculate amount
        function calculateAmount() {

            var workDays = parseFloat($('#edit_particular_EquipmentWorkDays')
                .val()); // Remove commas before parsing
            var rate = parseFloat($('#edit_particular_EquipmentRate').val());
            var noOfUnit = parseFloat($('#edit_particular_noOfUnit').val());
            var totalRate = rate * noOfUnit;

            var amount = totalRate * workDays;
            $('#edit_particular_EquipmentAmount').val(formatNumberWithCommas(amount.toFixed(2)));
        }

        // Event listener for quantity input change
        $('#edit_particular_EquipmentWorkDays').on('input', function() {
            calculateAmount();
        });

    });
</script>
