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

    public function getProjectData()
    {
        // Raw SQL query to fetch data
        $projects = DB::select("
        SELECT
            p.project_id,
            p.project_title,
            prt.particular_name, -- Added particular_name
            m.material_name,
            pm.quantity AS material_quantity,
            e.equipment_name,
            ppe.work_days AS equipment_work_days,
            lr.rate AS labor_rate,
            ppl.work_days AS labor_work_days,
            ppl.labor_id,
            l.labor_name
        FROM
            projects p
        LEFT JOIN
            project_particulars pp ON p.project_id = pp.project_id
        LEFT JOIN
            particulars prt ON pp.particular_id = prt.particular_id -- Added join to particulars table
        LEFT JOIN
            project_particular_materials pm ON pp.project_particular_id = pm.project_particular_id
        LEFT JOIN
            materials m ON pm.material_id = m.material_id
        LEFT JOIN
            project_particular_equipments ppe ON pp.project_particular_id = ppe.project_particular_id
        LEFT JOIN
            equipments e ON ppe.equipment_id = e.equipment_id
        LEFT JOIN
            project_particular_labors ppl ON pp.project_particular_id = ppl.project_particular_id
        LEFT JOIN
            labor_rates lr ON ppl.labor_id = lr.labor_id
        LEFT JOIN
            labors l ON ppl.labor_id = l.labor_id
    ");

        $formattedData = [];

        foreach ($projects as $project) {
            // Extract data from the query result
            $projectId = $project->project_id;
            $title = $project->project_title;
            $particularName = $project->particular_name; // Updated

            // Group data by project title
            if (!isset($formattedData[$title])) {
                $formattedData[$title] = [
                    'title' => $title,
                    'particulars' => [],
                ];
            }

            // Initialize the details array for the particular if not already set
            if (!isset($formattedData[$title]['particulars'][$particularName])) {
                $formattedData[$title]['particulars'][$particularName] = [
                    'name' => $particularName,
                    'details' => [
                        'Materials' => [],
                        'Equipment' => [],
                        'Labor' => [],
                    ],
                ];
            }

            // Add details to the formatted result
            if (!empty($project->material_name)) {
                $formattedData[$title]['particulars'][$particularName]['details']['Materials'][] = [
                    'name' => $project->material_name,
                    'quantity' => $project->material_quantity,
                ];
            }

            // Add equipment details if not already added
            if (
                !empty($project->equipment_name) &&
                !in_array(
                    ['name' => $project->equipment_name, 'work_days' => $project->equipment_work_days],
                    $formattedData[$title]['particulars'][$particularName]['details']['Equipment'],
                    true
                )
            ) {
                $formattedData[$title]['particulars'][$particularName]['details']['Equipment'][] = [
                    'name' => $project->equipment_name,
                    'work_days' => $project->equipment_work_days,
                ];
            }

            // Add labor details if not already added
            if (
                !empty($project->labor_name) &&
                !in_array(
                    ['name' => $project->labor_name, 'work_days' => $project->labor_work_days],
                    $formattedData[$title]['particulars'][$particularName]['details']['Labor'],
                    true
                )
            ) {
                $formattedData[$title]['particulars'][$particularName]['details']['Labor'][] = [
                    'name' => $project->labor_name,
                    'work_days' => $project->labor_work_days,
                ];
            }
        }

        // Convert the particulars from associative array to indexed array
        foreach ($formattedData as &$project) {
            $project['particulars'] = array_values($project['particulars']);
        }

        return response()->json(['projects' => array_values($formattedData)]);
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
