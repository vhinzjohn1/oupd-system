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
        try {

            // Retrieve or create project
            $projectParticular = ProjectParticular::updateOrCreate(
                [
                    'project_id' => $request['project_id'],
                    'particular_id' => $request['particular_id'],
                ],
                [
                    'quantity' => $request['detailQuantity'],
                    'unit' => $request['detailUnit'],
                    'unit_cost' => $request['detailUnitCost'],
                    'total' => $request['detailTotal'],
                ]
            );


            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Project particular added/updated successfully.',
                'projectParticular' => $projectParticular,
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add/update project particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add/update project particular. Please check the logs for details.']);
        }
    }

    public function update(Request $request, $project_particular_id)
    {
        try {

            // Retrieve or create project
            $projectPart = ProjectParticular::updateOrCreate(['particular_id' => $project_particular_id], [
                'total' => $request['projectPartTotal'],
            ]);
            // Return success response with signature data and message
            return response()->json([
                'success' => true,
                'message' => 'Project Particular Edited Successfully',
                'ProjectParticular' => $projectPart
            ]);

        } catch (\Exception $e) {

            // Log detailed error message
            Log::error('Failed to update Total: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to update Total. Please check the logs for details.']);
        }
    }


    // Function to Delete Project Particular
    public function destroy($projectParticularId)
    {
        try {
            // Find the ProjectParticular record by project_particular_id and delete it
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
