<?php

namespace App\Http\Controllers;

use App\Models\Particular;
use App\Models\Project;
use App\Models\ProjectParticular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ParticularController extends Controller
{
    public function index()
    {
        $particular = DB::select('SELECT * FROM particulars');
        if (request()->ajax()) {
            return response()->json($particular);
        } else {
            return view('particular');
        }
    }
    public function getProjectParticular()
    {
        // Get all projects
        $projects = DB::select('SELECT * FROM projects');

        // Initialize array to hold project particulars data
        $projectParticularsData = [];

        // Iterate over each project
        foreach ($projects as $project) {
            // Get all Particulars associated with ProjectParticular for this project
            $particularIdsInProjectParticular = ProjectParticular::where('project_id', $project->project_id)->pluck('particular_id')->all();

            // Filter out Particulars that are not associated with ProjectParticular for this project
            $availableParticulars = Particular::whereNotIn('particular_id', $particularIdsInProjectParticular)->get();

            // Build project particulars data array
            $projectParticularsData[] = [
                'project_id' => $project->project_id,
                'project_title' => $project->project_title,
                'particulars_available' => $availableParticulars
            ];
        }

        return response()->json($projectParticularsData);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'particular_name' => 'required|string',
            'pay_item' => 'nullable|string',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Check if particular with the same name exists
            $particular = Particular::where('particular_name', $validatedData['particular_name'])->where('pay_item', $validatedData['pay_item'])->first();

            if (!$particular || $particular->pay_item != $validatedData['pay_item']) {
                // If particular does not exist or pay_item is different, create a new one
                $particular = new Particular([
                    'particular_name' => $validatedData['particular_name'],
                    'pay_item' => $validatedData['pay_item'],
                ]);
                $particular->save();
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($particular);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add particular. Please check the logs for details.']);
        }
    }

    public function update(Request $request, $particular_id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'particular_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the project by ID
            $particular = Particular::findOrFail($particular_id);

            // Update project details
            $particular->update([
                'particular_name' => $validatedData['particular_name'],
                'pay_item' => $validatedData['description'],
            ]);

            $existingparticular = Particular::where('particular_name', $validatedData['particular_name'])
                ->where('pay_item', $validatedData['description'])
                ->where('particular_id', '!=', $particular->particular_id)
                ->first();

            if ($existingparticular) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Failed to delete particular']);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($particular);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to update particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to update patticular. Please check the logs for details.']);
        }
    }

    public function destroy($particular_id)
    {
        try {
            // Find the particular by ID
            $particular = Particular::findOrFail($particular_id);

            // Delete the particular
            $particular->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Particular deleted successfully']);
        } catch (\Exception $e) {
            // Log detailed error message
            Log::error('Failed to delete particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to delete particular. Please check the logs for details.']);
        }
    }



}
