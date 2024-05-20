<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ProjectParticularEquipment;
use App\Models\ProjectParticularLabor;
use App\Models\ProjectParticularMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Project;
use App\Models\Particular;
use App\Models\ProjectParticular;
use App\Models\MaterialCategory;

class TestController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve project ID from the request
        $projectId = session('projectID');

        // Check if project ID exists in the session
        if (!$projectId) {
            return response()->view('pages.projects', ['message' => 'Please select a project first'], 400);
        }


        // Retrieve project details using the project ID
        $projectDetail = Project::where('project_id', $projectId)->first();

        // Fetch particulars data using Eloquent with pagination
        $particulars = ProjectParticular::select('project_particulars.*', 'particulars.particular_name', 'particulars.pay_item')
            ->leftJoin('particulars', 'project_particulars.particular_id', '=', 'particulars.particular_id')
            ->where('project_id', $projectId)
            ->paginate(8);

        // Fetch materials associated with each particular and include MaterialCategory and Price
        foreach ($particulars as $particular) {
            $particular->materials = ProjectParticularMaterial::select('project_particular_materials.*', 'materials.*', 'material_categories.*', 'prices.*')
                ->leftJoin('materials', 'project_particular_materials.material_id', '=', 'materials.material_id')
                ->leftJoin('material_categories', 'materials.material_category_id', '=', 'material_categories.material_category_id')
                ->leftJoin('prices', 'project_particular_materials.price_id', '=', 'prices.price_id')
                ->where('project_particular_id', $particular->project_particular_id)
                ->get();
            $particular->labors = ProjectParticularLabor::select('project_particular_labors.*', 'labors.*', 'labor_rates.*')
                ->leftJoin('labors', 'project_particular_labors.labor_id', '=', 'labors.labor_id')
                ->leftJoin('labor_rates', 'labor_rates.labor_rate_id', '=', 'project_particular_labors.labor_rate_id')
                ->where('project_particular_id', $particular->project_particular_id)
                ->get();
            $particular->equipments = ProjectParticularEquipment::select('project_particular_equipments.*', 'equipments.*', 'equipment_rates.*', 'equipment_categories.*')
                ->leftJoin('equipments', 'project_particular_equipments.equipment_id', '=', 'equipments.equipment_id')
                ->leftJoin('equipment_rates', 'equipment_rates.equipment_rate_id', '=', 'project_particular_equipments.equipment_rate_id')
                ->leftJoin('equipment_categories', 'equipment_categories.equipment_category_id', '=', 'equipments.equipment_id')
                ->where('project_particular_id', $particular->project_particular_id)
                ->get();
        }

        return view('transactions', compact('particulars', 'projectDetail'));
    }


    // Use for Refreshing tables
    public function create()
    {
        // Retrieve project ID from the request
        $projectId = session('projectID'); // Assuming you're hardcoding the project ID for now

        // Fetch particulars data using Eloquent with pagination
        $particulars = ProjectParticular::select('project_particulars.*', 'particulars.particular_name', 'particulars.pay_item')
            ->leftJoin('particulars', 'project_particulars.particular_id', '=', 'particulars.particular_id')
            ->where('project_id', $projectId)
            ->get();

        // Fetch materials associated with each particular and include MaterialCategory and Price
        foreach ($particulars as $particular) {
            $particular->materials = ProjectParticularMaterial::select('project_particular_materials.*', 'materials.*', 'material_categories.*', 'prices.*')
                ->leftJoin('materials', 'project_particular_materials.material_id', '=', 'materials.material_id')
                ->leftJoin('material_categories', 'materials.material_category_id', '=', 'material_categories.material_category_id')
                ->leftJoin('prices', 'project_particular_materials.price_id', '=', 'prices.price_id')
                ->where('project_particular_id', $particular->project_particular_id)
                ->get();
            $particular->labors = ProjectParticularLabor::select('project_particular_labors.*', 'labors.*', 'labor_rates.*')
                ->leftJoin('labors', 'project_particular_labors.labor_id', '=', 'labors.labor_id')
                ->leftJoin('labor_rates', 'labor_rates.labor_rate_id', '=', 'project_particular_labors.labor_rate_id')
                ->where('project_particular_id', $particular->project_particular_id)
                ->get();
            $particular->equipments = ProjectParticularEquipment::select('project_particular_equipments.*', 'equipments.*', 'equipment_rates.*', 'equipment_categories.*')
                ->leftJoin('equipments', 'project_particular_equipments.equipment_id', '=', 'equipments.equipment_id')
                ->leftJoin('equipment_rates', 'equipment_rates.equipment_rate_id', '=', 'project_particular_equipments.equipment_rate_id')
                ->leftJoin('equipment_categories', 'equipment_categories.equipment_category_id', '=', 'equipments.equipment_id')
                ->where('project_particular_id', $particular->project_particular_id)
                ->get();
        }

        return response()->json($particulars);
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
