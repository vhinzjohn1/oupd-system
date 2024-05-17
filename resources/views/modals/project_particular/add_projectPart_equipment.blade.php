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
                                <input type="hidden" id="add_projectParticularIdEquipment">
                                <input type="hidden" id="add_particularIdEquipment">
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
                                <input type="text" class="form-control price-input" id="add_particular_EquipmentRate"
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
                                <input type="text" class="form-control price-input"
                                    id="add_particular_EquipmentAmount" name="add_particular_EquipmentAmount" readonly
                                    required>
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
            var workDays = parseFloat($('#add_particular_EquipmentWorkDays').val().replace(/,/g,
                '')); // Remove commas before parsing
            var rate = parseFloat($('#add_particular_EquipmentRate').val().replace('₱', '').replace(/,/g, ''));
            var noOfUnit = parseFloat($('#add_particular_noOfUnit').val().replace(/,/g, ''));
            var totalRate = rate * noOfUnit;

            var amount = totalRate * workDays;
            $('#add_particular_EquipmentAmount').val(amount.toFixed(2));

            // Apply IMask to the amount input
            const amountInput = document.getElementById('add_particular_EquipmentAmount');
            IMask(amountInput, {
                mask: '₱num',
                blocks: {
                    num: {
                        mask: Number,
                        thousandsSeparator: ',',
                        padFractionalZeros: true,
                        normalizeZeros: true,
                        radix: '.',
                        mapToRadix: ['.'],
                        min: 0,
                        scale: 2
                    }
                }
            });
        }

        // Event listener for input changes
        $('#add_particular_EquipmentWorkDays, #add_particular_EquipmentRate, #add_particular_noOfUnit').on(
            'input',
            function() {
                calculateAmount();
            });


        // Event to Focus After opening Modal
        $('#addPartEquipmentModal').on('shown.bs.modal', function() {
            $('#add_particular_EquipmentName').focus(); // Focus on the Quantity input field
        });

        // Function to initialize rate inputs
        function initializeRateInputs() {
            const rateInputs = document.querySelectorAll('.rate-input');
            rateInputs.forEach(input => {
                IMask(input, {
                    mask: '₱num',
                    blocks: {
                        num: {
                            mask: Number,
                            thousandsSeparator: ',',
                            padFractionalZeros: true,
                            normalizeZeros: true,
                            radix: '.',
                            mapToRadix: ['.'],
                            min: 0,
                            scale: 2
                        }
                    }
                });
            });
        }

        // Initialize rate inputs on document ready
        initializeRateInputs();
    });
</script>
