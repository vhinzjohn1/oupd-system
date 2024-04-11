<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectParticular;

class PDFController extends Controller
{
    public function index()
    {
        // Raw SQL query to fetch data
        $projects = DB::select("
         SELECT
         p.project_id,
         p.project_title,
         p.project_location,
         p.project_owner,
         p.project_date_prepared,
         p.project_appropriation,
         p.project_source_of_fund,
         p.project_contract_duration,
         p.project_mode_of_implementation,
         p.project_description,
         pm.project_particular_material_id,
         prt.particular_id,
         prt.particular_name,
         m.material_id,
         m.material_name,
         m.unit AS material_unit,
         mc.material_category_id,
         mc.material_category_name,
         pm.quantity AS material_quantity,
         pr.price AS material_price,
         pr.`quarter` AS material_quarter,
             pr.`year` AS material_year,
             pr.price_id AS material_price_id,
         ppl.work_days AS labor_work_days,
         e.equipment_id,
         e.equipment_name,
         er.rate AS equipment_rate,
         ppe.work_days AS equipment_work_days,
         ppe.no_of_units AS equipment_no_of_units,
         l.labor_id,
         l.labor_name,
         lr.rate AS labor_rate,
         l.location AS labor_location,
         ppl.no_of_persons AS labor_no_of_persons

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
            $location = $project->project_location;
            $owner = $project->project_owner;

            $particularName = $project->particular_name;
            $datePrepared = $project->project_date_prepared;
            $appropriation = $project->project_appropriation;
            $sourceOfFund = $project->project_source_of_fund;
            $contractDuration = $project->project_contract_duration;
            $modeOfImplementation = $project->project_mode_of_implementation;
            $description = $project->project_description;

            // Group data by project title
            if (!isset($formattedData[$title])) {
                $formattedData[$title] = [
                    'project_id' => $projectId,
                    'project_title' => $title,
                    'project_location' => $location,
                    'project_owner' => $owner,
                    'particulars' => [],
                    'project_date_prepared' => $datePrepared,
                    'project_appropriation' => $appropriation,
                    'project_source_of_fund' => $sourceOfFund,
                    'project_contract_duration' => $contractDuration,
                    'project_mode_of_implementation' => $modeOfImplementation,
                    'project_description' => $description,
                ];
            }

            // Initialize the details array for the particular if not already set
            if (!isset($formattedData[$title]['particulars'][$particularName])) {
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
            if (!empty($project->material_id)) {
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
                    ['equipment_id' => $project->equipment_id, 'equipment_name' => $project->equipment_name, 'equipment_no_of_units' => $project->equipment_no_of_units, 'equipment_work_days' => $project->equipment_work_days, 'equipment_rate' => $project->equipment_rate],
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
                        'equipment_no_of_units' => $project->equipment_no_of_units,
                        'equipment_work_days' => $project->equipment_work_days,
                        'equipment_rate' => $project->equipment_rate,
                    ];
                }
            }


            // Add labor details if not already added
            if (
                !empty($project->labor_id) &&
                !in_array(
                    ['labor_id' => $project->labor_id, 'labor_name' => $project->labor_name, 'labor_no_of_persons' => $project->labor_no_of_persons, 'labor_work_days' => $project->labor_work_days],
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
                        'labor_no_of_persons' => $project->labor_no_of_persons,
                        'labor_work_days' => $project->labor_work_days,
                        'labor_rate' => $project->labor_rate,
                    ];
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
}
