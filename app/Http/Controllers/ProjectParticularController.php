<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectParticular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProjectParticularController extends Controller
{
    public function index()
    {
        $projectParticulars = DB::select("
        SELECT
            pr.project_id,
            pr.project_title,
            IFNULL(pp.particular_id, 'Empty') AS particular_id,
            IFNULL(pa.particular_name, 'Empty') AS particular_name,
            IFNULL(pp.project_particular_id, 'Empty') AS project_particular_id
        FROM
            projects pr
        LEFT JOIN
            project_particulars pp ON pr.project_id = pp.project_id
        LEFT JOIN
            particulars pa ON pp.particular_id = pa.particular_id
        ORDER BY
            pr.project_id;
    ");

        $groupedProjects = [];

        foreach ($projectParticulars as $particular) {
            $projectId = $particular->project_id;
            $projectTitle = $particular->project_title;

            if (!isset($groupedProjects[$projectId])) {
                $groupedProjects[$projectId] = [
                    'project_id' => $projectId,
                    'project_title' => $projectTitle,
                    'project_particulars' => [],
                ];
            }

            $groupedProjects[$projectId]['project_particulars'][] = [
                'project_particular_id' => $particular->project_particular_id,
                'particular_id' => $particular->particular_id,
                'particular_name' => $particular->particular_name,
            ];
        }

        if (request()->ajax()) {
            return response()->json($groupedProjects);
        } else {
            return view('project_particular');
        }
    }



    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'project_id' => 'required',
            'particular_id' => 'required|array', // Change to array
            // 'description' => 'nullable|string',
            // 'remark' => 'nullable|string',
            // 'total' => 'nullable|numeric',
        ]);

        try {

            // Start a database transaction
            DB::beginTransaction();

            // Loop through each particular_id and create or find a ProjectParticular record for each
            foreach ($validatedData['particular_id'] as $particularId) {
                // Find existing ProjectParticular record or create a new one
                $projectParticular = ProjectParticular::firstOrCreate([
                    'project_id' => $validatedData['project_id'],
                    'particular_id' => $particularId,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Project particulars added successfully.']);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add project particulars: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add project particulars. Please check the logs for details.']);
        }
    }


    // Function to Delete Project Particular
    public function destroy($projectParticularId)
    {
        try {
            // Find the ProjectParticular record by its ID and delete it
            $projectParticular = ProjectParticular::findOrFail($projectParticularId);
            $projectParticular->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Project particular deleted successfully.']);
        } catch (\Exception $e) {
            // Log detailed error message
            Log::error('Failed to delete project particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to delete project particular. Please check the logs for details.']);
        }
    }



}
