<div class="modal fade preview-modal" id="addPartLaborModal" tabindex="-1" role="dialog"
    aria-labelledby="addPartLaborModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartLaborModalLabel">Add Labor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectPartLaborForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="add_particular_laborID">
                                <input type="hidden" id="add_projectParticularLaborId">
                                <input type="hidden" id="add_projectParticularIDLabor">
                                <label for="add_particular_laborName">Labor Name</label>
                                <select type="text" class="form-control" id="add_particular_laborName"
                                    name="add_particular_laborName" required>
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_noOfPerson">No of Person</label>
                                <input type="number" class="form-control" id="add_particular_noOfPerson"
                                    name="add_particular_noOfPerson" required>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_laborWorkDays">Work Days</label>
                                <input type="number" class="form-control" id="add_particular_laborWorkDays"
                                    name="add_particular_laborWorkDays" required>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="add_particular_labor_rateID">
                                <label for="add_particular_laborRate">Rate</label>
                                <input type="text" class="form-control price-input" id="add_particular_laborRate"
                                    name="add_particular_laborRate" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="add_particular_laborAmount">Amount</label>
                                <input type="text" class="form-control price-input" id="add_particular_laborAmount"
                                    name="add_particular_laborAmount" readonly required>
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
            var workDays = parseFloat($('#add_particular_laborWorkDays').val()); // Remove commas before parsing
            var rate = parseFloat($('#add_particular_laborRate').val().replace('₱', '').replace(/,/g, ''));
            var noOfPerson = parseFloat($('#add_particular_noOfPerson').val());
            var totalRate = rate * noOfPerson;

            var amount = totalRate * workDays;

            // Update the value and apply IMask
            $('#add_particular_laborAmount').val(amount.toFixed(2));

            // Apply IMask to the amount input
            const amountInput = document.getElementById('add_particular_laborAmount');
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

        // Event listener for quantity input change
        $('#add_particular_laborWorkDays, #add_particular_laborRate, #add_particular_noOfPerson').on('input',
            calculateAmount);

        // Event to Focus After opening Modal
        $('#addPartLaborModal').on('shown.bs.modal', function() {
            $('#add_particular_laborName').focus(); // Focus on the Quantity input field
        });

        // Function to initialize price inputs
        function initializePriceInputs() {
            const priceInputs = document.querySelectorAll('.price-input');
            priceInputs.forEach(input => {
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

        // Initialize price inputs on document ready
        initializePriceInputs();
    });
</script>
