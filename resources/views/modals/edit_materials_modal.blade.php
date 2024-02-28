<!-- Edit Material Modal -->
<div class="modal fade" id="editMaterialModal{{ $material->material_id }}" tabindex="-1" role="dialog"
    aria-labelledby="editMaterialModal{{ $material->material_id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialModal{{ $material->material_id }}Label">Edit
                    Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing material -->
                <form {{-- action="{{ route('materials.update', $material->material_id) }}" --}} method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Form fields for editing material -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_name">Material Name</label>
                                <input type="text" class="form-control" id="material_name" name="material_name"
                                    value="{{ $material->material_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="material_category_name">Material
                                    Category</label>
                                <input type="text" class="form-control" id="material_category_name"
                                    name="material_category_name"
                                    value="{{ $material->category->material_category_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="unit_name">Unit</label>
                                <input type="text" class="form-control" id="unit_name" name="unit_name"
                                    value="{{ $material->unit->unit_name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="{{ $material->price->price }}" required>
                            </div>
                            <div class="form-group">
                                <label for="quarter">Quarter</label>
                                <input type="text" class="form-control" id="quarter" name="quarter"
                                    value="{{ $material->price->quarter->quarter }}" required>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" name="year"
                                    value="{{ $material->price->year->year }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- For example, you can add fields for material category, unit, and price -->
                    <button type="submit" class="btn btn-primary">Save
                        Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
