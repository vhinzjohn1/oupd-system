<div class="modal fade preview-modal" id="editParticularMaterialModal" tabindex="-1" role="dialog"
    aria-labelledby="editParticularMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editParticularMaterialModalLabel">Edit Material</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProjectPartMaterialForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" id="edit_particular_material_id" name="edit_particular_material_id">
                            <div class="form-group">
                                <label for="edit_particular_material">Material Name</label>
                                <input type="text" class="form-control" id="edit_particular_material"
                                    name="edit_particular_material" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_materialQuantity">Quantity</label>
                                <input type="number" class="form-control" id="edit_particular_materialQuantity"
                                    name="edit_particular_materialQuantity" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_category">Category Name</label>
                                <input type="text" class="form-control" id="edit_particular_category"
                                    name="edit_particular_category" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_materialUnit">Unit</label>
                                <input type="text" class="form-control" id="edit_particular_materialUnit"
                                    name="edit_particular_materialUnit" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="editParticularId">
                                <label for="edit_particular_materialPrice">Price</label>
                                <input type="text" class="form-control price-input"
                                    id="edit_particular_materialPrice" name="edit_particular_materialPrice" readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_materialQuarter">Quarter</label>
                                <input type="text" class="form-control" id="edit_particular_materialQuarter"
                                    name="edit_particular_materialQuarter" readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit_particular_materialYear">Year</label>
                                <input type="text" class="form-control" id="edit_particular_materialYear"
                                    name="edit_particular_materialYear" readonly>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_materialAmount">Amount</label>
                                <input type="text" class="form-control" id="edit_particular_materialAmount"
                                    name="edit_particular_materialAmount" readonly>
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
    $(document).ready(function() {
        // Function to format number with commas for thousands
        function formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Function to calculate amount
        function calculateEquipmentAmount() {
            var quantity = parseFloat($('#edit_particular_materialQuantity')
                .val()); // Remove commas before parsing
            var price = parseFloat($("#edit_particular_materialPrice").val().replace('₱', '').replace(/,/g,
                ''));
            var amount = quantity * price;

            // Update the value and apply IMask
            $('#edit_particular_materialAmount').val(amount.toFixed(2));

            // Apply IMask to the amount input
            const amountInput = document.getElementById('edit_particular_materialAmount');
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
        $('#edit_particular_materialQuantity, #edit_particular_materialPrice').on('input', function() {
            calculateEquipmentAmount();
        });

        // Event listener for modal shown
        $('#editParticularMaterialModal').on('shown.bs.modal', function() {
            $('#edit_particular_materialQuantity').focus(); // Focus on the Quantity input field
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
