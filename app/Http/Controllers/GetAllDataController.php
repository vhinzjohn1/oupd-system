<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectParticular;

class GetAllDataController extends Controller
{
    //
    public function index()
    {
        // Raw SQL query to fetch data
        $projects = DB::select("
        SELECT
            p.project_id,
            p.project_title,
            pm.project_particular_material_id,
            prt.particular_id,
            prt.particular_name,
            pm.quantity AS material_quantity,
            pr.price AS material_price,
            pr.`quarter` AS material_quarter,
            pr.`year` AS material_year,
            pr.price_id AS material_price_id,
            m.material_id,
            m.material_name,
            m.unit AS material_unit,
            mc.material_category_id,
            mc.material_category_name,
            ppl.project_particular_labor_id,
            ppl.work_days AS labor_work_days,
            ppl.no_of_persons AS labor_no_of_persons,
            ppe.project_particular_equipment_id,
            e.equipment_id,
            e.equipment_name,
            er.rate AS equipment_rate,
            ppe.work_days AS equipment_work_days,
            ppe.no_of_units AS equipment_no_of_units,
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
            labor_rates lr ON ppl.labor_id = lr.labor_id AND lr.is_active = 1
        LEFT JOIN
            labors l ON ppl.labor_id = l.labor_id
        LEFT JOIN
            project_particular_equipments ppe ON pp.project_particular_id = ppe.project_particular_id
        LEFT JOIN
            equipments e ON ppe.equipment_id = e.equipment_id
        LEFT JOIN
            equipment_rates er ON ppe.equipment_id = er.equipment_id AND er.is_active = 1
        LEFT JOIN
            prices pr ON m.material_id = pr.material_id AND pr.is_active = 1
    ");

        $formattedData = [];

        foreach ($projects as $project) {
            // Extract data from the query result
            $projectId = $project->project_id;
            $title = $project->project_title;
            $particularName = $project->particular_name;
            $particularId = $project->particular_id;

            // Group data by project title
            if (!isset($formattedData[$title])) {
                $formattedData[$title] = [
                    'project_id' => $projectId,
                    'project_title' => $title,
                ];
            }

            // If there are particulars associated with the project, add them
            if (!empty($particularName)) {
                // Initialize the particulars array if not already set
                if (!isset($formattedData[$title]['particulars'])) {
                    $formattedData[$title]['particulars'] = [];
                }

                // Initialize the details array for the particular if not already set
                if (!isset($formattedData[$title]['particulars'][$particularName])) {
                    $formattedData[$title]['particulars'][$particularName] = [
                        'particular_id' => $particularId,
                        'particular_name' => $particularName,
                        'details' => [
                            'Materials' => [],
                            'Equipment' => [],
                            'Labor' => [],
                        ],
                    ];
                }

                if (!empty($project->material_id) && $project->material_price !== null && $project->material_price !== 0) {
                    // Check if the material is already added
                    $existingMaterial = collect($formattedData[$title]['particulars'][$particularName]['details']['Materials'])
                        ->firstWhere('material_id', $project->material_id);

                    // Add the material only if it's not already present
                    if (!$existingMaterial) {
                        $formattedData[$title]['particulars'][$particularName]['details']['Materials'][] = [
                            'particular_id' => $project->particular_id,
                            'project_particular_material_id' => $project->project_particular_material_id,
                            'material_id' => $project->material_id,
                            'material_name' => $project->material_name,
                            'material_category_id' => $project->material_category_id,
                            'material_category_name' => $project->material_category_name,
                            'material_quarter' => $project->material_quarter,
                            'material_quantity' => $project->material_quantity,
                            'material_price_id' => $project->material_price_id,
                            'material_price' => $project->material_price,
                            'material_year' => $project->material_year,
                            'material_unit' => $project->material_unit,
                        ];
                    }
                }

                // Add equipment details if not already added
                if (
                    !empty($project->equipment_id) &&
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
                            'particular_id' => $project->particular_id,
                            'project_particular_equipment_id' => $project->project_particular_equipment_id,
                            'equipment_id' => $project->equipment_id,
                            'equipment_name' => $project->equipment_name,
                            'equipment_work_days' => $project->equipment_work_days,
                            'equipment_no_of_units' => $project->equipment_no_of_units,
                            'equipment_rate' => $project->equipment_rate,
                        ];
                    }
                }

                // Add labor details if not already added
                if (
                    !empty($project->labor_id) &&
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
                            'particular_id' => $project->particular_id,
                            'project_particular_labor_id' => $project->project_particular_labor_id,
                            'labor_id' => $project->labor_id,
                            'labor_name' => $project->labor_name,
                            'labor_work_days' => $project->labor_work_days,
                            'labor_no_of_persons' => $project->labor_no_of_persons,
                            'labor_location' => $project->labor_location,
                            'labor_rate' => $project->labor_rate,
                        ];
                    }
                }
            }
        }

        // Sort particulars alphabetically by particular_name
        foreach ($formattedData as &$project) {
            if (isset($project['particulars'])) {
                $project['particulars'] = collect($project['particulars'])->sortBy('particular_name')->values()->all();
            }
        }

        return response()->json(['projects' => array_values($formattedData)]);
    }

    public function store(Request $request)
    {
        try {
            // Get the incoming request data
            $requestData = $request->all();

            // Create or update the record
            Project::updateOrCreate(
                ['project_id' => $requestData['add_project_id']],
                [
                    'project_title' => $requestData['add_project_title'],
                    'project_location' => $requestData['add_project_location'],
                    'project_owner' => $requestData['add_project_owner'],
                    'project_description' => $requestData['add_project_description'],
                    'project_contract_duration' => $requestData['add_project_contract_duration'],
                    'project_date_prepared' => $requestData['add_project_date_prepared'],
                    'project_appropriation' => floatval(str_replace(',', '', $requestData['add_project_appropriation'])),
                    'project_source_of_fund' => $requestData['add_project_source_of_fund'],
                    'project_mode_of_implementation' => $requestData['add_project_mode_of_implementation'],
                ]
            );

            // Optionally, you can return a response indicating success
            return response()->json(['message' => 'Project saved successfully'], 200);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }





    public function masterList()
    {
        // Raw SQL query to fetch data
        $materials = DB::select("
        SELECT
            m.material_id,
            m.material_name,
            m.unit AS material_unit,
            mc.material_category_id,
            mc.material_category_name,
            pr.price AS material_price,
            pr.`quarter` AS material_quarter,
            pr.`year` AS material_year,
            pr.price_id AS material_price_id
        FROM
            materials m
        LEFT JOIN
            material_categories mc ON m.material_category_id = mc.material_category_id
        INNER JOIN
            prices pr ON m.material_id = pr.material_id
        WHERE
            pr.is_active = 1
        ORDER BY
            m.material_name ASC;
    ");

        $labors = DB::select("
        SELECT
            l.labor_id,
            l.labor_name,
            lr.rate AS labor_rate,
            l.location AS labor_location
        FROM
            labors l
        LEFT JOIN
            labor_rates lr ON l.labor_id = lr.labor_id
        WHERE
            lr.is_active = 1
            AND lr.rate IS NOT NULL
        ORDER BY
            l.labor_name ASC;
    ");

        $equipments = DB::select("
        SELECT
            e.equipment_id,
            e.equipment_name,
            er.rate AS equipment_rate
        FROM
            equipments e
        LEFT JOIN
            equipment_rates er ON e.equipment_id = er.equipment_id
        WHERE
            er.is_active = 1
            AND er.rate IS NOT NULL
        ORDER BY
            e.equipment_name ASC;

    ");

        // Format the fetched data
        $getAllData = [
            'materials' => $materials,
            'labors' => $labors,
            'equipments' => $equipments,
        ];

        return response()->json($getAllData);
    }

    public function submitDetails(Request $request)
    {
        // Create or find project particular
        $projectParticular = ProjectParticular::firstOrCreate([
            'project_id' => $request->projectId, // Change 'project_id' to 'projectId'
            'particular_id' => $request->particularId, // Change 'particular_id' to 'particularId'
        ]);

        // Insert materials into the project_particular_materials table if provided
        if (!empty($request->materialId)) { // Change 'materials' to 'materialId'
            // Update or create a record in the project_particular_materials table
            $projectParticular->materials()->updateOrCreate([
                'material_id' => $request->materialId,
            ], [
                'quantity' => $request->materialQuantity, // Change 'quantity' to 'materialQuantity'
            ]);
        }
        // Insert labor into the project_particular_labors table if provided
        if (!empty($request->laborId)) { // Change 'materials' to 'laborId'
            // Update or create a record in the project_particular_labors table
            $projectParticular->labors()->updateOrCreate([
                'labor_id' => $request->laborId,
            ], [
                'no_of_persons' => $request->noOfPerson,
                'work_days' => $request->workDays,
            ]);
        }

        // Insert equipment into the project_particular_equipments table if provided
        if (!empty($request->equipmentId)) { // Change 'materials' to 'equipmentId'
            // Update or create a record in the project_particular_equipments table
            $projectParticular->equipments()->updateOrCreate([
                'equipment_id' => $request->equipmentId,
            ], [
                'work_days' => $request->equipmentWorkDays,
                'no_of_units' => $request->noOfUnit,
            ]);
        }



        return response()->json(['message' => 'Data submitted successfully']);

    }
    public function destroy(Request $request)
    {
        try {
            $detailType = $request->input('detailType');

            // Check if the detailType is equal to "material"
            if ($detailType === 'material') {
                $particularMaterialId = $request->input('partID');

                // Delete the record from the project_particular_materials table
                DB::table('project_particular_materials')
                    ->where('project_particular_material_id', $particularMaterialId)
                    ->delete();

                // Return a success response
                return response()->json(['message' => 'Project particular material deleted successfully'], 200);
            } elseif ($detailType === 'labor') {
                $particularLaborId = $request->input('partID');

                // Delete the record from the project_particular_labor table
                DB::table('project_particular_labors')
                    ->where('project_particular_labor_id', $particularLaborId)
                    ->delete();

                // Return a success response
                return response()->json(['message' => 'Project particular labor deleted successfully'], 200);
            } elseif ($detailType === 'equipment') {
                $particularEquipmentId = $request->input('partID');

                // Delete the record from the project_particular_equipment table
                DB::table('project_particular_equipments')
                    ->where('project_particular_equipment_id', $particularEquipmentId)
                    ->delete();

                // Return a success response
                return response()->json(['message' => 'Project particular equipment deleted successfully'], 200);
            } else {
                // Return an error response if the detailType is invalid
                return response()->json(['message' => 'Invalid detailType'], 400);
            }
        } catch (\Exception $e) {
            // Return an error response if deletion fails
            return response()->json(['message' => 'Failed to delete project particular detail', 'error' => $e->getMessage()], 500);
        }
    }



}
