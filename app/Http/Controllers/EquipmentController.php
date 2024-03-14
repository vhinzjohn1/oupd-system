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
        // Select equipments with their associated active rates and categories
        $equipments = DB::table('equipments')
            ->join('equipment_rates', 'equipments.equipment_id', '=', 'equipment_rates.equipment_id')
            ->join('equipment_categories', 'equipments.equipment_category_id', '=', 'equipment_categories.equipment_category_id')
            ->select('equipments.*', 'equipment_rates.equipment_rate_id', 'equipment_rates.rate', 'equipment_rates.date_effective', 'equipment_categories.equipment_category_name')
            ->where('equipment_rates.is_active', true)
            ->get();

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
            'equipment_category' => 'required|string',
            'equipment_model' => 'required|string',
            'equipment_capacity' => 'required|string',
            'rate' => 'required|numeric',
            // 'equipment_category_desc' => 'required|string',
        ]);

        try {

            // Start a database transaction
            DB::beginTransaction();

            // Retrieve or create equipment category
            $equipmentCategory = EquipmentCategory::firstOrCreate(['equipment_category_name' => $validatedData['equipment_category']]);

            // Check if equipment with the same name exists
            $equipment = Equipment::where('equipment_name', $validatedData['equipment_name'])->first();

            if (!$equipment) {
                // If equipment does not exist, create a new one
                $equipment = new Equipment([
                    'equipment_name' => $validatedData['equipment_name'],
                    'equipment_model' => $validatedData['equipment_model'],
                    'equipment_capacity' => $validatedData['equipment_capacity'],
                ]);

                $equipment->category()->associate($equipmentCategory);
                $equipment->save();
            }

            DB::table('equipment_rates')
                ->where('equipment_id', $equipment->equipment_id)
                ->update(['is_active' => false]);

            // Create a new rate instance
            $rate = new EquipmentRate();
            $rate->rate = $validatedData['rate'];
            $rate->equipment_id = $equipment->equipment_id;

            // Save the rate
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
            'edit_equipment_name' => 'required|string',
            'edit_equipment_category_name' => 'required|string',
            'edit_equipment_model' => 'required|string',
            'edit_equipment_capacity' => 'required|string',
            'edit_rate' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Find the equipment based on ID
            $equipment = Equipment::findOrFail($id);

            // Check if the updated equipment name and category combination already exists
            $existingEquipment = Equipment::where('equipment_name', $validatedData['edit_equipment_name'])
                ->where('equipment_category_id', EquipmentCategory::firstOrCreate([
                    'equipment_category_name' => $validatedData['edit_equipment_category_name'],
                ])->equipment_category_id)
                ->where('equipment_id', '!=', $equipment->equipment_id)
                ->first();

            if ($existingEquipment) {
                // If equipment with the same name and category already exists, return an error response
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Equipment name and category combination already exists.']);
            }

            // Update equipment details
            $equipment->equipment_name = $validatedData['edit_equipment_name'];
            $equipment->equipment_model = $validatedData['edit_equipment_model'];
            $equipment->equipment_capacity = $validatedData['edit_equipment_capacity'];

            // Update equipment category (retrieve if exists or create if new)
            $equipmentCategory = EquipmentCategory::firstOrCreate([
                'equipment_category_name' => $validatedData['edit_equipment_category_name'],
            ]);

            // Associate the updated category with the equipment
            $equipment->equipment_category_id = $equipmentCategory->equipment_category_id;

            // Deactivate existing rates with the same equipment_id as the equipment
            DB::table('equipment_rates')
                ->where('equipment_id', $equipment->equipment_id)
                ->update(['is_active' => false]);

            // Create a new rate instance
            $newRate = new EquipmentRate();
            $newRate->rate = $validatedData['edit_rate'];
            $newRate->equipment_id = $equipment->equipment_id; // Associate with the equipment

            $equipment->save();  // Save changes to equipment table
            // Save the new rate
            $newRate->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Equipment updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update equipment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Equipment update failed. Check logs for details.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the equipment based on ID
            $equipment = Equipment::findOrFail($id);

            // Update only the specified fields to null or an empty value
            $equipment->equipment_name = null;
            $equipment->equipment_model = null;
            $equipment->equipment_capacity = null;

            // // Save the changes, it will retain the categories and rate in the table
            // $equipment->save();

            // Deactivate existing rates related to the equipment
            $equipment->rates()->update(['is_active' => false]);

            // Update foreign key references to null in related equipment_rates records
            EquipmentRate::where('equipment_id', $equipment->equipment_id)->update(['equipment_id' => null]);

            // You can choose to delete the equipment if needed
            // Comment if you only want to delete it in the table not in the database
            $equipment->delete();

            return response()->json(['success' => true, 'message' => 'Equipment details deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Failed to delete equipment details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete equipment details. Check logs for details.']);
        }
    }
}
