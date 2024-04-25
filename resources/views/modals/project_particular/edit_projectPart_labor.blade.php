<div class="modal fade preview-modal" id="editPartLaborModal" tabindex="-1" role="dialog"
    aria-labelledby="editPartLaborModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartLaborModalLabel">Edit Labor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProjectPartLaborForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" id="edit_particular_laborID">
                                <label for="edit_particular_laborName">Labor Name</label>
                                <input type="text" class="form-control" id="edit_particular_laborName"
                                    name="edit_particular_laborName" required readonly>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_noOfPerson">No of Person</label>
                                <input type="number" class="form-control" id="edit_particular_noOfPerson"
                                    name="edit_particular_noOfPerson" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_laborWorkDays">Work Days</label>
                                <input type="number" class="form-control" id="edit_particular_laborWorkDays"
                                    name="edit_particular_laborWorkDays" required>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="edit_particular_laborRate">Rate</label>
                                <input type="text" class="form-control" id="edit_particular_laborRate"
                                    name="edit_particular_laborRate" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="edit_particular_laborAmount">Amount</label>
                                <input type="text" class="form-control" id="edit_particular_laborAmount"
                                    name="edit_particular_laborAmount" readonly required>
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
        function calculateLaborAmount() {

            var workDays = parseFloat($('#edit_particular_laborWorkDays')
                .val()); // Remove commas before parsing
            var rate = parseFloat($('#edit_particular_laborRate').val());
            var noOfPerson = parseFloat($('#edit_particular_noOfPerson').val());
            var totalRate = rate * noOfPerson;

            var amount = totalRate * workDays;
            $('#edit_particular_laborAmount').val(formatNumberWithCommas(amount.toFixed(2)));
        }

        // Event listener for input change
        $('#edit_particular_laborWorkDays, #edit_particular_laborRate, #edit_particular_noOfPerson').on('input',
            function() {
                calculateLaborAmount();
            });

    });
</script>
