<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentCategory;
use App\Models\EquipmentRate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $materials = Material::with('category', 'prices')->get();
        // return view('pages.list_of_materials', compact('materials'));
        $equipments = Equipment::with('category', 'prices')->get();
        if (request()->ajax()) {
            return response()->json($equipments);
        } else {
            return view('pages.list_of_equipments');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'equipment_name' => 'required|string',
            'eq_cat_category' => 'required|string',
            'equipment_model' => 'required|string',
            'equipment_capacity' => 'required|string',
            'equipment_rate' => 'required|numeric',
            'eq_cat_desc' => 'required|string',
        ]);

        try {

            // Start a database transaction
            DB::beginTransaction();

            // Retrieve or create equipment category
            $equipmentCategory = EquipmentCategory::frstOrCreate(['material_category_name' => $validatedData['material_category']]);


            // Associate the category (assuming a belongsTo relationship called 'category')
            $equipment = new Equipment([
                'equipment_name' => $validatedData['equipment_name'],
                'equipment_model' => $validatedData['equipment_model'],
                'equipment_capacity' => $validatedData['equipment_capacity'],
            ]);

            $equipment->category()->associate($equipmentCategory);
            $equipment->save();



            // Create a new equipment instance and assign IDs
            $rate = new EquipmentRate();
            $rate->rate = $validatedData['rate'];
            $rate->equipment_id = $equipment->equipment_id;
            $rate->is_active = 1;
            $rate->date_effective = Carbon::now(); // Capture the current timestamp

            // // Save the equipment
            $rate->save();

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($equipment);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add equipment: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add equipment. Please check the logs for details.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $equipment = Equipment::with('category', 'rates')->findOrFail($id);
        return response()->json($equipment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'equipment_name' => 'required|string',
            'eq_cat_category' => 'required|string',
            'equipment_model' => 'required|string',
            'equipment_capacity' => 'required|string',
            'equipment_rate' => 'required|numeric',
            'eq_cat_desc' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Find the equipment based on ID
            $equipment = Equipment::findOrFail($id);

            // Update equipment details
            $equipment->equipment_name = $validatedData['edit_equipment_name'];
            $equipment->equipment_model = $validatedData['edit_equipment_model'];
            $equipment->equipment_capacity = $validatedData['edit_equipment_capacity'];

            // Update equipment category (retrieve if exists or create if new)
            $equipmentCategory = EquipmentCategory::firstOrCreate([
                'eq_cat_name' => $validatedData['edit_eq_cat_name'],
            ]);
            $equipment->category()->associate($equipmentCategory);

            // Retrieve existing rate record
            $rate = $equipment->rates()->where([
                'equipment_id' => $equipment->equipment_id,
            ])->firstOrFail();

            // Update rate attributes
            $rate->rate = $validatedData['edit_rate'];

            // Save changes
            $equipment->save();
            $rate->save();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Equipment updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update Equipment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Equipment update failed. Check logs for details.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(equipment $equipment)
    {
        //
    }
}
