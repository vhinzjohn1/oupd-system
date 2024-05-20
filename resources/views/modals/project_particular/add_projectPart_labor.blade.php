<style>
    /* Custom CSS to change link color */
    .user-link {
        color: black !important;
        text-decoration: none;
        position: relative;
    }

    .user-link::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 0%;
        height: 2px;
        background-color: #012F12;
        transition: width 0.3s ease, left 0.3s ease;
        /* Added left transition */
    }

    .user-link.click::after {
        width: 100%;
        left: 0;
        /* Reset position */
    }

    .userLink {
        cursor: pointer;
        display: block;
        padding: 0.5rem 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
        color: white;
        text-decoration: none;
    }

    .userLink:focus {
        background-color: #ffc107 !important;
        /* Change background color when link is clicked */
        color: black !important;
        /* Change text color when link is clicked */
    }
</style>

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

            <!---- Navigation Inside Modal ---->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Navbar -->
                        <div class="nav justify-content-center">
                            <h5>
                                <a href="#" class="nav-link user-link click"
                                    onclick="toggleUnderline(event, this); toggleContent('laborManual')">Manual</a>
                            </h5>
                            <h5>
                                <a href="#" class="nav-link user-link"
                                    onclick="toggleUnderline(event, this); toggleContent('laborPercent')">Percent
                                    (%)</a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <form id="addProjectPartLaborForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group shared-input percent-group">
                                <input type="hidden" id="add_particular_laborID">
                                <input type="hidden" id="add_projectParticularLaborId">
                                <input type="hidden" id="add_projectParticularIDLabor">
                                <label for="add_particular_laborName">Labor Name</label>
                                <select type="text" class="form-control" id="add_particular_laborName"
                                    name="add_particular_laborName" required>
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="form-group manual-input percent-group">
                                <label for="add_particular_noOfPerson">No of Person</label>
                                <input type="number" class="form-control" id="add_particular_noOfPerson"
                                    name="add_particular_noOfPerson" required>
                            </div>

                            <div class="form-group manual-input percent-group">
                                <label for="add_particular_laborWorkDays">Work Days</label>
                                <input type="number" class="form-control" id="add_particular_laborWorkDays"
                                    name="add_particular_laborWorkDays" required>
                            </div>

                            <div class="form-group percent-input percent-group">
                                <label for="add_particular_laborPercent">Percent (%)</label>
                                <input type="number" class="form-control" id="add_particular_laborPercent"
                                    name="add_particular_laborPercent">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group shared-input percent-group">
                                <input type="hidden" id="add_particular_labor_rateID">
                                <label for="add_particular_laborRate">Rate</label>
                                <input type="text" class="form-control price-input" id="add_particular_laborRate"
                                    name="add_particular_laborRate" readonly required>
                            </div>

                            <div class="form-group shared-input percent-group">
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
    function toggleUnderline(event, element) {
        event.preventDefault(); // Prevent default link behavior

        // Remove 'click' class from all links
        document.querySelectorAll('.user-link').forEach(link => {
            link.classList.remove('click');
        });

        // Add 'click' class to the clicked link
        element.classList.add('click');
    }

    function toggleContent(contentId) {
        // Hide all form groups initially
        document.querySelectorAll('.percent-group').forEach(group => {
            group.style.display = 'none';
        });

        // Show specific form groups based on the contentId
        if (contentId === 'laborManual') {
            document.querySelectorAll('.manual-input, .shared-input').forEach(group => {
                group.style.display = 'block';
            });
        } else if (contentId === 'laborPercent') {
            document.querySelectorAll('.percent-input, .shared-input').forEach(group => {
                group.style.display = 'block';
            });
        }
    }

    // Initialize to show 'Manual' fields by default
    document.addEventListener('DOMContentLoaded', function() {
        toggleContent('laborManual');
    });
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
