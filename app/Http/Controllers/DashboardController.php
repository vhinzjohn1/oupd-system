<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Labor;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $projectsCount = Project::count();
        $materialsCount = Material::count();
        $laborsCount = Labor::count();
        $equipmentsCount = Equipment::count();

        $counts = [
            'projects' => $projectsCount,
            'materials' => $materialsCount,
            'labors' => $laborsCount,
            'equipments' => $equipmentsCount,
        ];

        return response()->json($counts);
    }


}
