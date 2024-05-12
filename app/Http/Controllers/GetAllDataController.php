<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentRate;
use App\Models\Labor;
use App\Models\LaborRate;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectParticular;

class GetAllDataController extends Controller
{
    //
    public function index(Request $request)
    {
        // Retrieve project ID from the request
        $projectID = $request->input('projectID');
        // Raw SQL query to fetch data
        $projects = DB::select("
        SELECT
            p.project_id,
            p.project_title,
            pm.project_particular_material_id,
            pp.project_particular_id,
            pp.unit AS project_particular_unit,
            pp.quantity AS project_particular_quantity,
            pp.unit_cost AS project_particular_unit_cost,
            pp.total AS project_particular_total,
            prt.particular_id,
            prt.particular_name,
            pm.quantity AS material_quantity,
            pm.price_id as project_particular_material_price_id,
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
            e.equipment_model,
            e.equipment_capacity,
            e.equipment_category_id,
            ec.equipment_category_name,
            er.rate AS equipment_rate,
            ppe.work_days AS equipment_work_days,
            ppe.no_of_units AS equipment_no_of_units,
            l.labor_id,
            l.labor_name,
            lr.rate AS labor_rate,
            lr.labor_rate_id AS labor_rate_id,
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
            equipment_categories ec ON e.equipment_category_id = ec.equipment_category_id
        LEFT JOIN
            equipment_rates er ON ppe.equipment_id = er.equipment_id AND er.is_active = 1
        LEFT JOIN
            prices pr ON pm.price_id = pr.price_id
        WHERE
            p.project_id = $projectID;
    ");

        $formattedData = [];

        foreach ($projects as $project) {
            // Extract data from the query result
            $projectId = $project->project_id;
            $title = $project->project_title;
            $particularName = $project->particular_name;
            $particularId = $project->particular_id;
            $projectParticularId = $project->project_particular_id;
            $projectParticularUnit = $project->project_particular_unit;
            $projectParticularUnitCost = $project->project_particular_unit_cost;
            $projectParticularQuantity = $project->project_particular_quantity;
            $projectParticularTotal = $project->project_particular_total;

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
                        'project_particular_id' => $projectParticularId,
                        'project_particular_unit' => $projectParticularUnit,
                        'project_particular_unitCost' => $projectParticularUnitCost,
                        'project_particular_quantity' => $projectParticularQuantity,
                        'project_particular_total' => $projectParticularTotal,
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
                            'project_particular_id' => $projectParticularId,
                            'project_particular_material_id' => $project->project_particular_material_id,
                            'material_id' => $project->material_id,
                            'material_name' => $project->material_name,
                            'material_category_id' => $project->material_category_id,
                            'material_category_name' => $project->material_category_name,
                            'material_quarter' => $project->material_quarter,
                            'material_quantity' => $project->material_quantity,
                            'material_price_id' => $project->project_particular_material_price_id,
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
                            'equipment_capacity' => $project->equipment_capacity,
                            'equipment_category_name' => $project->equipment_category_name,
                            'equipment_model' => $project->equipment_model,
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
                            'labor_rate_id' => $project->labor_rate_id,
                        ];
                    }
                }
            }
        }

        // Sort particulars alphabetically by particular_name
        foreach ($formattedData as &$project) {
            if (isset($project['particulars'])) {
                $project['particulars'] = collect($project['particulars'])->sortBy('project_particular_id')->values()->all();
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
                    'ocm' => $requestData['add_project_ocm'],
                    'contractors_profit' => $requestData['add_project_cp'],
                    'vat' => $requestData['add_project_vat'],
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
            lr.labor_rate_id AS labor_rate_id,
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
            e.equipment_model,
            e.equipment_capacity,
            e.equipment_category_id,
            ec.equipment_category_name,
            er.rate AS equipment_rate,
            er.equipment_rate_id AS equipment_rate_id
        FROM
            equipments e
        LEFT JOIN
            equipment_rates er ON e.equipment_id = er.equipment_id
        LEFT JOIN
            equipment_categories ec ON e.equipment_category_id = ec.equipment_category_id
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
        try {
            // Create or find project particular
            $projectParticular = ProjectParticular::firstOrCreate([
                'project_id' => $request->projectId, // Change 'project_id' to 'projectId'
                'particular_id' => $request->particularId, // Change 'particular_id' to 'particularId'
            ]);

            if ($request->has('materialId') && $request->materialId !== "empty") {
                // Update or create a record in the project_particular_materials table
                // Submit if it is alreadt on the masterlist
                $projectParticular->materials()->updateOrCreate([
                    'material_id' => $request->materialId,
                ], [
                    'quantity' => $request->materialQuantity,
                    'price_id' => $request->materialPriceID,
                ]);
            } elseif ($request->materialId === "empty") {
                try {
                    // Start a database transaction
                    DB::beginTransaction();

                    // Retrieve or create material category
                    $materialCategory = MaterialCategory::firstOrCreate(['material_category_name' => $request->materialCategory]);

                    // Check if material with the same name exists
                    $material = Material::where('material_name', $request->materialName)->first();

                    if (!$material) {
                        // If material does not exist, create a new one
                        $material = new Material([
                            'material_name' => $request->materialName,
                            'unit' => $request->materialUnit,
                        ]);

                        $material->category()->associate($materialCategory);
                        $material->save();
                    }

                    DB::table('prices')
                        ->where('material_id', $material->material_id)
                        ->update(['is_active' => false]);

                    // Create a new price instance
                    $price = new Price();
                    $price->price = $request->materialPrice;
                    $price->quarter = $request->materialQuarter;
                    $price->year = $request->materialYear;
                    $price->material_id = $material->material_id;

                    // Save the price
                    $price->save();

                    // Add the newly created material to the ProjectParticular
                    $projectParticular = ProjectParticular::firstOrCreate([
                        'project_id' => $request->projectId,
                        'particular_id' => $request->particularId,
                    ]);

                    $projectParticular->materials()->updateOrCreate([
                        'material_id' => $material->material_id,
                    ], [
                        'quantity' => $request->materialQuantity,
                        'price_id' => $price->price_id,
                    ]);

                    // Commit the transaction
                    DB::commit();

                    // Return success response
                    return response()->json($material);
                } catch (\Exception $e) {
                    // Rollback the transaction if an exception occurs
                    DB::rollBack();

                    // Log detailed error message
                    Log::error('Failed to add material: ' . $e->getMessage());

                    // Return error response
                    return response()->json(['success' => false, 'message' => 'Failed to add material. Please check the logs for details.']);
                }
            }

            // Insert labor into the project_particular_labors table if provided
            if ($request->has('laborId') && $request->laborId !== "empty") {
                // Update or create a record in the project_particular_labors table
                $projectParticular->labors()->updateOrCreate([
                    'labor_id' => $request->laborId,
                ], [
                    'no_of_persons' => $request->noOfPerson,
                    'work_days' => $request->workDays,
                    'labor_rate_id' => $request->laborRateID,
                ]);
            } else if ($request->laborId === "empty") {
                try {
                    // Start a database transaction
                    DB::beginTransaction();

                    // Create a new labor
                    $labor = Labor::firstOrCreate(['labor_name' => $request->laborName, 'location' => $request->laborLocation]);

                    // Add the newly created labor to the ProjectParticular
                    $projectParticular = ProjectParticular::firstOrCreate([
                        'project_id' => $request->projectId,
                        'particular_id' => $request->particularId,
                    ]);

                    // Update or create a record in the project_particular_labors table
                    $projectParticularLabor = $projectParticular->labors()->updateOrCreate([
                        'labor_id' => $labor->labor_id, // Use the newly created labor's ID
                    ], [
                        'no_of_persons' => $request->noOfPerson,
                        'work_days' => $request->workDays,
                    ]);

                    // Get the labor rate associated with the labor
                    $laborRate = $labor->laborRate()->where('is_active', 1)->first();

                    // If labor rate doesn't exist, create a new one
                    if (!$laborRate) {
                        // Handle the case where there's no active labor rate
                        throw new \Exception("No active labor rate found for the labor with ID: {$labor->labor_id}");
                    }

                    // Associate labor rate with project particular labor
                    $projectParticularLabor->update(['labor_rate_id' => $laborRate->id]);

                    // Commit the transaction
                    DB::commit();

                    // Return success response
                    return response()->json($labor);
                } catch (\Exception $e) {
                    // Rollback the transaction if an exception occurs
                    DB::rollBack();

                    // Log detailed error message
                    Log::error('Failed to add labor: ' . $e->getMessage());

                    // Return error response
                    return response()->json(['success' => false, 'message' => 'Failed to add labor. Please check the logs for details.']);
                }

            }
            // Insert equipment into the project_particular_equipments table if provided
            if ($request->has('equipmentId') && $request->equipmentId !== "empty") {
                // Update or create a record in the project_particular_equipments table
                $projectParticular->equipments()->updateOrCreate([
                    'equipment_id' => $request->equipmentId,
                ], [
                    'work_days' => $request->equipmentWorkDays,
                    'no_of_units' => $request->noOfUnit,
                    'equipment_rate_id' => $request->equipmentRateID,
                ]);
            } else if ($request->equipmentId === "empty") {
                try {
                    // Start a database transaction
                    DB::beginTransaction();

                    // Retrieve or create equipment category
                    $equipmentCategory = EquipmentCategory::firstOrCreate(['equipment_category_name' => $request->equipmentCategory]);

                    // Check if equipment with the same name exists
                    $equipment = Equipment::where('equipment_name', $request->equipmentName)->first();

                    if (!$equipment) {
                        // If equipment does not exist, create a new one
                        $equipment = new Equipment([
                            'equipment_name' => $request->equipmentName,
                            'equipment_model' => $request->equipmentModel,
                            'equipment_capacity' => $request->equipmentCapacity,
                        ]);

                        $equipment->category()->associate($equipmentCategory);
                        $equipment->save();
                    }

                    // Add the newly created material to the ProjectParticular
                    $projectParticular = ProjectParticular::firstOrCreate([
                        'project_id' => $request->projectId,
                        'particular_id' => $request->particularId,
                    ]);

                    $projectParticular->equipments()->updateOrCreate([
                        'equipment_id' => $equipment->equipment_id,
                    ], [
                        'work_days' => $request->equipmentWorkDays,
                        'no_of_units' => $request->noOfUnit,
                    ]);

                    DB::table('equipment_rates')
                        ->where('equipment_id', $equipment->equipment_id)
                        ->update(['is_active' => false]);

                    // Create a new rate instance
                    $rate = new EquipmentRate();
                    $rate->rate = $request->equipmentRate;
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

            return response()->json(['message' => 'Data submitted successfully']);
        } catch (\Exception $e) {
            // Log detailed error message
            Log::error('Failed to submit details: ' . $e->getMessage());

            // Return error response
            return response()->json(['error' => 'Failed to submit details. Please check the logs for details.'], 500);
        }
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
