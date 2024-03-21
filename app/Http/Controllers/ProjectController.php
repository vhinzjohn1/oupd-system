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
        prt.particular_id,
        prt.particular_name,
        m.material_id,
        m.material_name,
        m.unit AS material_unit,
        mc.material_category_id,
        mc.material_category_name,
        pm.quantity AS material_quantity,
        pr.price AS material_price,
        pr.`quarter` AS material_quantity,
            pr.`year` AS material_year,
        ppl.work_days AS labor_work_days,
        e.equipment_id,
        e.equipment_name,
        er.rate AS equipment_rate,
        ppe.work_days AS equipment_work_days,
        l.labor_id,
        l.labor_name,
        lr.rate AS labor_rate,
        l.location AS labor_location
    FROM
        projects p
    LEFT JOIN
        project_particulars pp ON p.project_id = pp.project_id
    LEFT JOIN
        particulars prt ON pp.particular_id = prt.particular_id
    LEFT JOIN
        project_particular_materials pm ON pp.project_particular_id = pm.project_particular_id
    LEFT JOIN
        materials m ON pm.material_id = m.material_id
    LEFT JOIN
        material_categories mc ON m.material_category_id = mc.material_category_id
    LEFT JOIN
        project_particular_labors ppl ON pp.project_particular_id = ppl.project_particular_id
    LEFT JOIN
        labor_rates lr ON ppl.labor_id = lr.labor_id
    LEFT JOIN
        labors l ON ppl.labor_id = l.labor_id
    LEFT JOIN
        project_particular_equipments ppe ON pp.project_particular_id = ppe.project_particular_id
    LEFT JOIN
        equipments e ON ppe.equipment_id = e.equipment_id
    LEFT JOIN
        equipment_rates er ON ppe.equipment_id = er.equipment_id
    LEFT JOIN
        prices pr ON m.material_id = pr.material_id  -- Join with prices table
    WHERE
        m.material_id IS NOT NULL;


    ");

        $formattedData = [];

        foreach ($projects as $project) {
            // Extract data from the query result
            $projectId = $project->project_id;
            $title = $project->project_title;
            $particularName = $project->particular_name;

            // Group data by project title
            if (!isset ($formattedData[$title])) {
                $formattedData[$title] = [
                    'project_id' => $projectId, // Add projectId here
                    'project_title' => $title,
                    'particulars' => [],
                ];
            }

            // Initialize the details array for the particular if not already set
            if (!isset ($formattedData[$title]['particulars'][$particularName])) {
                $formattedData[$title]['particulars'][$particularName] = [
                    'particular_id' => $project->particular_id,
                    'particular_name' => $particularName,
                    'details' => [
                        'Materials' => [],
                        'Equipment' => [],
                        'Labor' => [],
                    ],
                ];
            }

            // Add details to the formatted result for materials, equipment, and labor
            if (!empty ($project->material_id)) {
                // Check if the material is already added
                $existingMaterial = collect($formattedData[$title]['particulars'][$particularName]['details']['Materials'])
                    ->firstWhere('material_id', $project->material_id);

                // Add the material only if it's not already present
                if (!$existingMaterial) {
                    $formattedData[$title]['particulars'][$particularName]['details']['Materials'][] = [
                        'material_id' => $project->material_id,
                        'material_name' => $project->material_name,
                        'material_category_id' => $project->material_category_id,
                        'material_category_name' => $project->material_category_name,
                        'material_quantity' => $project->material_quantity,
                        'material_price' => $project->material_price,
                        'material_year' => $project->material_year,
                        'material_unit' => $project->material_unit,
                    ];
                }
            }

            // Add equipment details if not already added
            if (
                !empty ($project->equipment_id) &&
                !in_array(
                    ['equipment_id' => $project->equipment_id, 'equipment_name' => $project->equipment_name, 'equipment_work_days' => $project->equipment_work_days, 'equipment_rate' => $project->equipment_rate],
                    array_column($formattedData[$title]['particulars'][$particularName]['details']['Equipment'], 'equipment_id'),
                    true
                )
            ) {
                // Check if the equipment entry with the same equipment_id exists
                $existingEquipment = collect($formattedData[$title]['particulars'][$particularName]['details']['Equipment'])
                    ->firstWhere('equipment_id', $project->equipment_id);

                // Add the equipment only if it's not already present
                if (!$existingEquipment) {
                    $formattedData[$title]['particulars'][$particularName]['details']['Equipment'][] = [
                        'equipment_id' => $project->equipment_id,
                        'equipment_name' => $project->equipment_name,
                        'equipment_work_days' => $project->equipment_work_days,
                        'equipment_rate' => $project->equipment_rate,
                    ];
                }
            }


            // Add labor details if not already added
            if (
                !empty ($project->labor_id) &&
                !in_array(
                    ['labor_id' => $project->labor_id, 'labor_name' => $project->labor_name, 'labor_location' => $project->labor_location, 'labor_work_days' => $project->labor_work_days],
                    array_column($formattedData[$title]['particulars'][$particularName]['details']['Labor'], 'labor_id'),
                    true
                )
            ) {
                // Check if the labor entry with the same labor_id exists
                $existingLabor = collect($formattedData[$title]['particulars'][$particularName]['details']['Labor'])
                    ->firstWhere('labor_id', $project->labor_id);

                // Add the labor only if it's not already present
                if (!$existingLabor) {
                    $formattedData[$title]['particulars'][$particularName]['details']['Labor'][] = [
                        'labor_id' => $project->labor_id,
                        'labor_name' => $project->labor_name,
                        'labor_work_days' => $project->labor_work_days,
                        'labor_location' => $project->labor_location,
                        'labor_rate' => $project->labor_rate,
                    ];
                }
            }
        }

        // Convert the particulars from associative array to indexed array
        foreach ($formattedData as &$project) {
            $project['particulars'] = array_values($project['particulars']);
        }
        if (request()->ajax()) {
            // If the request is an AJAX request, return JSON response
            return response()->json(['projects' => array_values($formattedData)]);
        } else {
            // If it's not an AJAX request, return the view with the data
            return view('/pages/projects', ['formattedData' => $formattedData]);
        }
    }

    // public function getProjectDataHome()
    // {
    //     // Raw SQL query to fetch data
    //     $projects = DB::select("
    //     SELECT
    //     p.project_id,
    //     p.project_title,
    //     prt.particular_id,
    //     prt.particular_name,
    //     m.material_id,
    //     m.material_name,
    //     m.unit AS material_unit,
    //     mc.material_category_id,
    //     mc.material_category_name,
    //     pm.quantity AS material_quantity,
    //     pr.price AS material_price,
    //     pr.`quarter` AS material_quantity,
    //         pr.`year` AS material_year,
    //     ppl.work_days AS labor_work_days,
    //     e.equipment_id,
    //     e.equipment_name,
    //     er.rate AS equipment_rate,
    //     ppe.work_days AS equipment_work_days,
    //     l.labor_id,
    //     l.labor_name,
    //     lr.rate AS labor_rate,
    //     l.location AS labor_location
    // FROM
    //     projects p
    // LEFT JOIN
    //     project_particulars pp ON p.project_id = pp.project_id
    // LEFT JOIN
    //     particulars prt ON pp.particular_id = prt.particular_id
    // LEFT JOIN
    //     project_particular_materials pm ON pp.project_particular_id = pm.project_particular_id
    // LEFT JOIN
    //     materials m ON pm.material_id = m.material_id
    // LEFT JOIN
    //     material_categories mc ON m.material_category_id = mc.material_category_id
    // LEFT JOIN
    //     project_particular_labors ppl ON pp.project_particular_id = ppl.project_particular_id
    // LEFT JOIN
    //     labor_rates lr ON ppl.labor_id = lr.labor_id
    // LEFT JOIN
    //     labors l ON ppl.labor_id = l.labor_id
    // LEFT JOIN
    //     project_particular_equipments ppe ON pp.project_particular_id = ppe.project_particular_id
    // LEFT JOIN
    //     equipments e ON ppe.equipment_id = e.equipment_id
    // LEFT JOIN
    //     equipment_rates er ON ppe.equipment_id = er.equipment_id
    // LEFT JOIN
    //     prices pr ON m.material_id = pr.material_id  -- Join with prices table
    // WHERE
    //     m.material_id IS NOT NULL;


    // ");

    //     $formattedData = [];

    //     foreach ($projects as $project) {
    //         // Extract data from the query result
    //         $projectId = $project->project_id;
    //         $title = $project->project_title;
    //         $particularName = $project->particular_name;

    //         // Group data by project title
    //         if (!isset ($formattedData[$title])) {
    //             $formattedData[$title] = [
    //                 'project_id' => $projectId, // Add projectId here
    //                 'project_title' => $title,
    //                 'particulars' => [],
    //             ];
    //         }

    //         // Initialize the details array for the particular if not already set
    //         if (!isset ($formattedData[$title]['particulars'][$particularName])) {
    //             $formattedData[$title]['particulars'][$particularName] = [
    //                 'particular_id' => $project->particular_id,
    //                 'particular_name' => $particularName,
    //                 'details' => [
    //                     'Materials' => [],
    //                     'Equipment' => [],
    //                     'Labor' => [],
    //                 ],
    //             ];
    //         }

    //         // Add details to the formatted result for materials, equipment, and labor
    //         if (!empty ($project->material_id)) {
    //             // Check if the material is already added
    //             $existingMaterial = collect($formattedData[$title]['particulars'][$particularName]['details']['Materials'])
    //                 ->firstWhere('material_id', $project->material_id);

    //             // Add the material only if it's not already present
    //             if (!$existingMaterial) {
    //                 $formattedData[$title]['particulars'][$particularName]['details']['Materials'][] = [
    //                     'material_id' => $project->material_id,
    //                     'material_name' => $project->material_name,
    //                     'material_category_id' => $project->material_category_id,
    //                     'material_category_name' => $project->material_category_name,
    //                     'material_quantity' => $project->material_quantity,
    //                     'material_price' => $project->material_price,
    //                     'material_year' => $project->material_year,
    //                     'material_unit' => $project->material_unit,
    //                 ];
    //             }
    //         }

    //         // Add equipment details if not already added
    //         if (
    //             !empty ($project->equipment_id) &&
    //             !in_array(
    //                 ['equipment_id' => $project->equipment_id, 'equipment_name' => $project->equipment_name, 'equipment_work_days' => $project->equipment_work_days, 'equipment_rate' => $project->equipment_rate],
    //                 array_column($formattedData[$title]['particulars'][$particularName]['details']['Equipment'], 'equipment_id'),
    //                 true
    //             )
    //         ) {
    //             // Check if the equipment entry with the same equipment_id exists
    //             $existingEquipment = collect($formattedData[$title]['particulars'][$particularName]['details']['Equipment'])
    //                 ->firstWhere('equipment_id', $project->equipment_id);

    //             // Add the equipment only if it's not already present
    //             if (!$existingEquipment) {
    //                 $formattedData[$title]['particulars'][$particularName]['details']['Equipment'][] = [
    //                     'equipment_id' => $project->equipment_id,
    //                     'equipment_name' => $project->equipment_name,
    //                     'equipment_work_days' => $project->equipment_work_days,
    //                     'equipment_rate' => $project->equipment_rate,
    //                 ];
    //             }
    //         }


    //         // Add labor details if not already added
    //         if (
    //             !empty ($project->labor_id) &&
    //             !in_array(
    //                 ['labor_id' => $project->labor_id, 'labor_name' => $project->labor_name, 'labor_location' => $project->labor_location, 'labor_work_days' => $project->labor_work_days],
    //                 array_column($formattedData[$title]['particulars'][$particularName]['details']['Labor'], 'labor_id'),
    //                 true
    //             )
    //         ) {
    //             // Check if the labor entry with the same labor_id exists
    //             $existingLabor = collect($formattedData[$title]['particulars'][$particularName]['details']['Labor'])
    //                 ->firstWhere('labor_id', $project->labor_id);

    //             // Add the labor only if it's not already present
    //             if (!$existingLabor) {
    //                 $formattedData[$title]['particulars'][$particularName]['details']['Labor'][] = [
    //                     'labor_id' => $project->labor_id,
    //                     'labor_name' => $project->labor_name,
    //                     'labor_work_days' => $project->labor_work_days,
    //                     'labor_location' => $project->labor_location,
    //                     'labor_rate' => $project->labor_rate,
    //                 ];
    //             }
    //         }
    //     }

    //     // Convert the particulars from associative array to indexed array
    //     foreach ($formattedData as &$project) {
    //         $project['particulars'] = array_values($project['particulars']);
    //     }
    //     if (request()->ajax()) {
    //         // If the request is an AJAX request, return JSON response
    //         return response()->json(['projects' => array_values($formattedData)]);
    //     } else {
    //         // If it's not an AJAX request, return the view with the data
    //         return view('/home', ['formattedData' => $formattedData]);
    //     }
    // }






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
