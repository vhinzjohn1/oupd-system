<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\Unit;
use App\Models\Price;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        $materials = Material::with('category', 'unit', 'price')->get();
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
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Retrieve or create material category
            $materialCategory = MaterialCategory::firstOrCreate(['material_category_name' => $validatedData['material_category']]);

            // Retrieve or create unit
            $unit = Unit::firstOrCreate(['unit_name' => $validatedData['unit']]);

            // Create or retrieve price
            $price = Price::firstOrCreate(['price' => $validatedData['price']]);

            // Create a new material instance and assign IDs
            $material = new Material();
            $material->material_name = $validatedData['material_name'];
            $material->material_category_id = $materialCategory->id;
            $material->unit_id = $unit->id;
            $material->price_id = $price->id;

            // Save the material
            $material->save();

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Material added successfully']);
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
