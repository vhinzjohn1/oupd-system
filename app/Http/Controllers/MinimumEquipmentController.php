<?php

namespace App\Http\Controllers;

use App\Models\MinimumEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MinimumEquipmentController extends Controller
{
    public function index()
    {
        $minimum_equipments = MinimumEquipment::all();
        return $minimum_equipments;
    }

    public function store(Request $request)
    {
        try {
            $minimum_equipment = MinimumEquipment::firstOrCreate(
                ['project_id' => $request->projectId],
                [
                    'min_equip_description' => $request->minEquipDescription,
                    'min_equip_owned' => $request->minEquipOwned,
                    'min_equip_lease' => $request->minEquipLease,
                    'min_equip_totalUnits' => $request->minEquipTotalUnits,
                    'project_id' => $request->projectId,
                ]
            );
            if ($minimum_equipment->wasRecentlyCreated) {
                return response()->json(['success' => true, 'message' => 'Successfully added Minimum Equipment']);
            } else {
                return response()->json(['success' => false, 'message' => 'Minimum Equipment already exists in this project']);
            }
        } catch (\Exception $e) {
            Log::error('Failed to add Minimum Equipment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add Minimum Equipment. Please check the logs for details.']);
        }
    }

    public function show(MinimumEquipment $minimumEquipment)
    {
        //
    }

    public function update(Request $request, $minimum_equipment_id)
    {
        try {
            $minimum_equipment = MinimumEquipment::updateOrCreate(
                ['minimum_equipment_id' => $minimum_equipment_id],
                [
                    'min_equip_owned' => $request['min_equip_owned'],
                    'min_equip_lease' => $request['min_equip_lease'],
                    'min_equip_totalUnits' => $request['min_equip_totalUnits'],
                    'project_id' => $request['projectId'],
                ]
            );
            return response()->json(['success' => true, 'message' => 'Minimum Equipment Edited Successfully', 'minimum_equipment' => $minimum_equipment]);
        } catch (\Exception $e) {
            Log::error('Failed to update Minimum Equipment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update Minimum Equipment. Please check the logs for details.'], 500);
        }
    }

    public function destroy($minimum_equipment_id)
    {
        try {
            $minimum_equipment = MinimumEquipment::findOrFail($minimum_equipment_id);
            $minimum_equipment->delete();
            return response()->json(['success' => true, 'message' => 'Minimum Equipment details deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Failed to delete Minimum Equipment details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete Minimum Equipment details. Check logs for details.']);
        }
    }
}
