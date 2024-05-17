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
            }
        ])->where('project_id', $projectId)->get();

        return response()->json($particularTotals);
    }
}
