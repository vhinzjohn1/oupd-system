<div class="modal fade preview-modal" id="addProjPartItemModal" tabindex="-1" role="dialog"
    aria-labelledby="addProjPartItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-height: 75vh;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjPartItemModalLabel">Add Project Item</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProjectItemFormModal">
                @csrf
                <div class="modal-body">
                    <label for="add_proj_part_item_modal">Project Item</label>
                    <select type="text" class="form-control" id="add_proj_part_item_modal"
                        name="add_proj_part_item_modal" required>
                        <option value=""></option>
                    </select>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn bg-success">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // on form submit modal prevent default

        $("#addProjectItemFormModal").on("submit", function(event) {
            event.preventDefault();

        });
    });
    $("#add_proj_part_item_modal")
        .select2({
            theme: "bootstrap-5",
            placeholder: "Add Project Item",
            dropdownParent: $('#addProjPartItemModal')
        });


    refreshParticularTableModal();

    // Adding of Project Item Section
    function refreshParticularTableModal() {
        $.ajax({
            url: "{{ route('getParticulars') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (Array.isArray(data) && data.length > 0) {
                    var selectedProjID = localStorage.getItem("projectID");
                    var selectElem = $("#add_proj_part_item_modal").empty();

                    // Filter data for the selected project ID
                    var selectedProject = data.find(function(project) {
                        return project.project_id == selectedProjID;
                    });

                    // If selected project is found
                    if (selectedProject && selectedProject.particulars_available) {
                        // Add a blank option
                        selectElem.append('<option value=""></option>');

                        selectedProject.particulars_available.forEach(function(particular) {
                            let optionText = particular.particular_name;
                            if (particular.pay_item) {
                                optionText += ' - ' + particular.pay_item;
                            }
                            selectElem.append('<option value="' + particular.particular_id + '">' +
                                optionText + '</option>');
                        });
                    } else {
                        console.error(
                            "Selected project or particulars available data not found or invalid.");
                    }
                } else {
                    console.error("No data or invalid data received.");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }
</script>
