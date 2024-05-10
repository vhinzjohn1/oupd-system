<?php

namespace App\Http\Controllers;

use App\Models\TechnicalPersonnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TechnicalPersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technical_personnel = TechnicalPersonnel::all();
        return $technical_personnel;
    }

    public function store(Request $request)
    {
        try {
            // Create or update technical personnel
            $technical_personnel = TechnicalPersonnel::updateOrCreate(
                ['project_id' => $request->projectId],
                [
                    'personnel_description' => $request->personnelDescription,
                    'personnel_no' => $request->personnelNo,
                ]
            );
            return response()->json(['success' => true, 'message' => 'Technical Personnel Added Successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to add Technical Personnel: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add Technical Personnel']);
        }
    }

    public function update(Request $request, $technical_personnel_id)
    {
        try {
            $technical_personnel = TechnicalPersonnel::findOrFail($technical_personnel_id);
            $technical_personnel->update([
                'personnel_description' => $request->personnelDescription,
                'personnel_no' => $request->personnelNo,
            ]);
            return response()->json(['success' => true, 'message' => 'Technical Personnel Updated Successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update Technical Personnel: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update Technical Personnel']);
        }
    }

    public function destroy($technical_personnel_id)
    {
        try {
            $technical_personnel = TechnicalPersonnel::findOrFail($technical_personnel_id);
            $technical_personnel->delete();
            return response()->json(['success' => true, 'message' => 'Technical Personnel Deleted Successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to delete Technical Personnel: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete Technical Personnel']);
        }
    }
}