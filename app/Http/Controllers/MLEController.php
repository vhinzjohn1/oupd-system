<?php

namespace App\Http\Controllers;

use App\Models\ProjectParticular;
use App\Models\ProjectParticularLabor;
use App\Models\ProjectParticularMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MLEController extends Controller
{
    public function index()
    {
        // Execute the SQL queries to retrieve data from materials, labors, and equipments
        $materials = DB::select("SELECT * FROM materials");
        $labors = DB::select("SELECT * FROM labors");
        $equipments = DB::select("SELECT * FROM equipments");

        // Combine the results into a single array
        $allData = [
            'equipments' => $equipments,
            'labors' => $labors,
            'materials' => $materials,
        ];

        // Return the JSON response
        return response()->json($allData);
    }



    // Submit Data of Project Particular Details
    public function submitData(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'project_id' => 'required|exists:projects,project_id',
            'particular_id' => 'required|exists:particulars,particular_id',
            'materials' => 'nullable|array',
            'materials.*.material_id' => 'required|exists:materials,material_id',
            'materials.*.quantity' => 'nullable|numeric|min:0',
            'labors' => 'nullable|array',
            'labors.*.labor_id' => 'required|exists:labors,labor_id',
            'labors.*.number_of_persons' => 'nullable|numeric|min:0',
            'labors.*.work_days' => 'nullable|numeric|min:0',
            'equipments' => 'nullable|array',
            'equipments.*.equipment_id' => 'required|exists:equipments,equipment_id',
            'equipments.*.number_of_units' => 'nullable|numeric|min:0',
            'equipments.*.work_days' => 'nullable|numeric|min:0',
            '_token' => 'required|string', // CSRF token validation
        ]);

        // Create or find project particular
        $projectParticular = ProjectParticular::firstOrCreate([
            'project_id' => $request->project_id,
            'particular_id' => $request->particular_id,
        ]);

        // Insert materials into the project_particular_materials table if provided
        if (!empty($request->materials)) {
            foreach ($request->materials as $material) {
                $projectParticular->materials()->updateOrCreate([
                    'material_id' => $material['material_id'],
                ], [
                    'quantity' => $material['quantity'] ?? null,
                ]);
            }
        }

        // Insert labors into the project_particular_labors table if provided
        if (!empty($request->labors)) {
            foreach ($request->labors as $labor) {
                $projectParticular->labors()->updateOrCreate([
                    'labor_id' => $labor['labor_id'],
                ], [
                    'no_of_persons' => $labor['number_of_persons'] ?? null,
                    'work_days' => $labor['work_days'] ?? null,
                ]);
            }
        }

        // Insert equipment into the project_particular_equipments table if provided
        if (!empty($request->equipments)) {
            foreach ($request->equipments as $equipment) {
                $projectParticular->equipments()->updateOrCreate([
                    'equipment_id' => $equipment['equipment_id'],
                ], [
                    'no_of_units' => $equipment['number_of_units'] ?? null,
                    'work_days' => $equipment['work_days'] ?? null,
                ]);
            }
        }

        return response()->json(['message' => 'Data submitted successfully']);
    }



}
