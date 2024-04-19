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
            p.ocm,
            p.contractors_profit,
            p.vat,
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
            l.location AS labor_location,
            pp.quantity,
            pp.unit,
            pp.unit_cost,
            pp.total,
            pp.project_particular_id,
            s.fullname,
            s.degree,
            s.position,
            s.role
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
        LEFT JOIN
            signatures s ON p.project_id = s.project_id
    ");

        $formattedData = [];

        foreach ($projects as $project) {
            // Extract data from the query result
            $projectId = $project->project_id;
            $title = $project->project_title;
            $location = $project->project_location;
            $owner = $project->project_owner;
            $particularName = $project->particular_name;
            $particularId = $project->particular_id;
            $datePrepared = $project->project_date_prepared;
            $appropriation = $project->project_appropriation;
            $sourceOfFund = $project->project_source_of_fund;
            $contractDuration = $project->project_contract_duration;
            $modeOfImplementation = $project->project_mode_of_implementation;
            $description = $project->project_description;
            $ocm = $project->ocm;
            $contractors_profit = $project->contractors_profit;
            $vat = $project->vat;
            $quantity = $project->quantity;
            $unit = $project->unit;
            $unitCost = $project->unit_cost;
            $total = $project->total;
            // Extract data from the query result
            $fullname = $project->fullname;
            $degree = $project->degree;
            $position = $project->position;
            $role = $project->role;
            $projectParticularId = $project->project_particular_id;

            // Check if the role requires fetching additional data
            if (in_array($role, ['Prepared', 'Reviewed', 'Conformed', 'Recommending Approval', 'Checked', 'Submitted', 'Approved'])) {
                // Process and gather specific data for the role
                $fullname = $project->fullname;
                $degree = $project->degree;
                $position = $project->position;
            }

            // Group data by project title
            if (!isset($formattedData[$title])) {
                $formattedData[$title] = [
                    'project_id' => $projectId,
                    'project_title' => $title,
                    'project_location' => $location,
                    'project_owner' => $owner,
                    'project_date_prepared' => $datePrepared,
                    'project_appropriation' => $appropriation,
                    'project_source_of_fund' => $sourceOfFund,
                    'project_contract_duration' => $contractDuration,
                    'project_mode_of_implementation' => $modeOfImplementation,
                    'project_description' => $description,
                    'ocm' => $ocm,
                    'contractors_profit' => $contractors_profit,
                    'vat' => $vat,
                    'signatures' => [
                        'fullname' => [],
                        'degree' => [],
                        'position' => [],
                        'role' => [],
                    ],
                ];
            }

            // Add signature data to the project
            $formattedData[$title]['signatures']['fullname'] = $fullname;
            $formattedData[$title]['signatures']['degree'] = $degree;
            $formattedData[$title]['signatures']['position'] = $position;
            $formattedData[$title]['signatures']['role'] = $role;

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
                        'project_particular_id' => $projectParticularId,
                        'particular_name' => $particularName,
                        'quantity' => $quantity,
                        'unit' => $unit,
                        'unit_cost' => $unitCost,
                        'total' => $total,
                        'ocm' => $ocm,
                        'contractors_profit' => $contractors_profit,
                        'vat' => $vat,
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
                $project['particulars'] = collect($project['particulars'])->sortBy('project_particular_id')->values()->all();
            }
        }

        return response()->json(['projects' => array_values($formattedData)]);
    }
}
