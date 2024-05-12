<div class="modal fade preview-modal" id="addPartEquipmentModal" tabindex="-1" role="dialog"
    aria-labelledby="addPartEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectPartEquipmentForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="add_particular_EquipmentID">
                                <label for="add_particular_EquipmentName">Equipment Name</label>
                                <select type="text" class="form-control" id="add_particular_EquipmentName"
                                    name="add_particular_EquipmentName" required>
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_noOfUnit">No of Units</label>
                                <input type="number" class="form-control" id="add_particular_noOfUnit"
                                    name="add_particular_noOfUnit" required>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_EquipmentWorkDays">Work Days</label>
                                <input type="number" class="form-control" id="add_particular_EquipmentWorkDays"
                                    name="add_particular_EquipmentWorkDays" required>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_EquipmentCapacity">Capacity</label>
                                <input type="text" class="form-control" id="add_particular_EquipmentCapacity"
                                    name="add_particular_EquipmentCapacity" required>
                                </input>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="add_particular_equipmentRateID">
                                <label for="add_particular_EquipmentRate">Rate</label>
                                <input type="text" class="form-control" id="add_particular_EquipmentRate"
                                    name="add_particular_EquipmentRate" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_EquipmentCategory">Category</label>
                                <input type="text" class="form-control" id="add_particular_EquipmentCategory"
                                    name="add_particular_EquipmentCategory" required>
                                </input>
                            </div>
                            <div class="form-group">
                                <label for="add_particular_EquipmentModel">Model</label>
                                <input type="text" class="form-control" id="add_particular_EquipmentModel"
                                    name="add_particular_EquipmentModel" required>
                                </input>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_EquipmentAmount">Amount</label>
                                <input type="text" class="form-control" id="add_particular_EquipmentAmount"
                                    name="add_particular_EquipmentAmount" readonly required>
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

            var workDays = parseFloat($('#add_particular_EquipmentWorkDays')
                .val()); // Remove commas before parsing
            var rate = parseFloat($('#add_particular_EquipmentRate').val());
            var noOfUnit = parseFloat($('#add_particular_noOfUnit').val());
            var totalRate = rate * noOfUnit;

            var amount = totalRate * workDays;
            $('#add_particular_EquipmentAmount').val(formatNumberWithCommas(amount.toFixed(2)));
        }

        // Event listener for quantity input change
        $('#add_particular_EquipmentWorkDays').on('input', function() {
            calculateAmount();
        });

    });
</script>
