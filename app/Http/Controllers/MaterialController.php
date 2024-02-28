<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\Unit;
use App\Models\Price;
use App\Models\Quarter;
use App\Models\Year;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use Illuminate\Http\JsonResponse;

class MaterialController extends Controller
{

    // public function index()
    // {
    //     $materials = Material::with('category', 'unit', 'price', 'quarter', 'year')->get();
    //     return response()->json($materials);
    // }
    public function index()
    {
        $materials = Material::with('category', 'unit', 'price', 'quarter', 'year')->get();
        return view('pages.list_of_materials', compact('materials'));
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'material_name' => 'required|string',
            'material_category' => 'required|string',
            'unit' => 'required|string',
            'price' => 'required|numeric',
            'quarter' => 'required|string',
            'year' => 'required|string',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();


            // // Before creating records, log or dump the validated data
            // dd($validatedData);
            // // or
            // Log::info($validatedData);

            // Retrieve or create material category
            $materialCategory = MaterialCategory::Create(['material_category_name' => $validatedData['material_category']]);

            // Retrieve or create unit
            $unit = Unit::Create(['unit_name' => $validatedData['unit']]);

            // Create or retrieve quarter
            $quarter = Quarter::Create(['quarter' => $validatedData['quarter']]);

            // Create or retrieve Year
            $year = Year::Create(['year' => $validatedData['year']]);

            //Create Price Table
            $price = Price::Create([
                'price' => $validatedData['price'],
                'quarter_id' => $quarter->id,
                'year_id' => $year->id,
            ]);


            // Create a new material instance and assign IDs
            $material = new Material();

            $material->material_name = $materialCategory->material_category_name;
            $material->material_category_id = $materialCategory->id;
            $material->unit_id = $unit->id;
            $material->price_id = $price->id;

            // Save the material
            $material->save();

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Material added successfully', 'material' => $material]);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add material: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add material. Please check the logs for details.']);
        }
    }



    // Other controller methods (create, edit, update, destroy) go here
}
