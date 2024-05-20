<?php

namespace App\Http\Controllers;

use App\Models\ProjectParticular;
use App\Models\ProjectParticularMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculateTotalAmount extends Controller
{
    public function index()
    {
        $projectId = session('projectID'); // Assuming you retrieve project ID from session

        $particularTotals = ProjectParticular::with([
            'materials' => function ($query) use ($projectId) {
                $query->select(
                    'project_particular_materials.*',
                    DB::raw('prices.price AS material_price'), // Get actual price using DB::raw
                    'project_particulars.project_id'
                )
                    ->leftJoin('prices', 'project_particular_materials.price_id', '=', 'prices.price_id')
                    ->leftJoin('project_particulars', 'project_particular_materials.project_particular_id', '=', 'project_particulars.project_particular_id')
                    ->where('project_particulars.project_id', $projectId);
            },
            'labors' => function ($query) use ($projectId) {
                $query->select(
                    'project_particular_labors.*',
                    DB::raw('labor_rates.rate AS rate'), // Get actual price using DB::raw
                    'project_particulars.project_id'
                )
                    ->leftJoin('labor_rates', 'project_particular_labors.labor_rate_id', '=', 'labor_rates.labor_rate_id')
                    ->leftJoin('project_particulars', 'project_particular_labors.project_particular_id', '=', 'project_particulars.project_particular_id')
                    ->where('project_particulars.project_id', $projectId);
            }
            ,
            'equipments' => function ($query) use ($projectId) {
                $query->select(
                    'project_particular_equipments.*',
                    DB::raw('equipment_rates.rate AS equipment_rate'), // Get actual price using DB::raw
                    'project_particulars.project_id'
                )
                    ->leftJoin('equipment_rates', 'project_particular_equipments.equipment_rate_id', '=', 'equipment_rates.equipment_rate_id')
                    ->leftJoin('project_particulars', 'project_particular_equipments.project_particular_id', '=', 'project_particulars.project_particular_id')
                    ->where('project_particulars.project_id', $projectId);
            }
        ])->where('project_id', $projectId)->get();

        return response()->json($particularTotals);
    }
}
