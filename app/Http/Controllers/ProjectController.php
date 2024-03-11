<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{


    public function index()
    {
        $projects = Project::all();
        if (request()->ajax()) {
            return response()->json($projects);
        } else {
            return view('projects');
        }
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'project_title' => 'required|string',
            'project_location' => 'required|string',
            'project_owner' => 'required|string',
            'unit_office' => 'required|string',
            'project_description' => 'required|string',
            'project_contract_duration' => 'required|string',
            'project_date_prepared' => 'required|date',
            'project_target_start_date' => 'required|date',
            'project_appropriation' => 'required|string',
            'project_source_of_fund' => 'required|string',
            'project_mode_of_implementation' => 'required|string',
        ]);


        try {

            // Start a database transaction
            DB::beginTransaction();

            // Retrieve or create project
            $project = Project::firstOrCreate(['project_title' => $validatedData['project_title']], [
                'project_location' => $validatedData['project_location'],
                'project_owner' => $validatedData['project_owner'],
                'unit_office' => $validatedData['unit_office'],
                'project_description' => $validatedData['project_description'],
                'project_contract_duration' => $validatedData['project_contract_duration'],
                'project_date_prepared' => $validatedData['project_date_prepared'],
                'project_target_start_date' => $validatedData['project_target_start_date'],
                'project_appropriation' => $validatedData['project_appropriation'],
                'project_source_of_fund' => $validatedData['project_source_of_fund'],
                'project_mode_of_implementation' => $validatedData['project_mode_of_implementation'],
            ]);



            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($project);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add material: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add material. Please check the logs for details.']);
        }
    }

    public function update(Request $request, $projectId)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'project_title' => 'required|string',
            'project_location' => 'required|string',
            'project_owner' => 'required|string',
            'unit_office' => 'required|string',
            'project_description' => 'required|string',
            'project_contract_duration' => 'required|string',
            'project_date_prepared' => 'required|date',
            'project_target_start_date' => 'required|date',
            'project_appropriation' => 'required|string',
            'project_source_of_fund' => 'required|string',
            'project_mode_of_implementation' => 'required|string',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the project by ID
            $project = Project::findOrFail($projectId);

            // Update project details
            $project->update([
                'project_title' => $validatedData['project_title'],
                'project_location' => $validatedData['project_location'],
                'project_owner' => $validatedData['project_owner'],
                'unit_office' => $validatedData['unit_office'],
                'project_description' => $validatedData['project_description'],
                'project_contract_duration' => $validatedData['project_contract_duration'],
                'project_date_prepared' => $validatedData['project_date_prepared'],
                'project_target_start_date' => $validatedData['project_target_start_date'],
                'project_appropriation' => $validatedData['project_appropriation'],
                'project_source_of_fund' => $validatedData['project_source_of_fund'],
                'project_mode_of_implementation' => $validatedData['project_mode_of_implementation'],
            ]);

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($project);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to update project: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to update project. Please check the logs for details.']);
        }
    }

}
