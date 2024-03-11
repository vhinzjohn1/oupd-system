<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\Price;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{

    public function index()
    {
        // Select materials with their associated active prices and categories
        $materials = DB::table('materials')
            ->join('prices', 'materials.material_id', '=', 'prices.material_id')
            ->join('material_categories', 'materials.material_category_id', '=', 'material_categories.material_category_id')
            ->select('materials.*', 'prices.price_id', 'prices.price', 'prices.quarter', 'prices.year', 'material_categories.material_category_name')
            ->where('prices.is_active', true)
            ->get();

        if (request()->ajax()) {
            return response()->json($materials);
        } else {
            return view('pages.list_of_materials');
        }
    }

    // To populate Edit Modal Values
    public function show($id)
    {
        $material = Material::with('category', 'prices')->findOrFail($id);
        return response()->json($material);
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

            // Retrieve or create material category
            $materialCategory = MaterialCategory::firstOrCreate(['material_category_name' => $validatedData['material_category']]);

            // Check if material with the same name exists
            $material = Material::where('material_name', $validatedData['material_name'])->first();

            if (!$material) {
                // If material does not exist, create a new one
                $material = new Material([
                    'material_name' => $validatedData['material_name'],
                    'unit' => $validatedData['unit'],
                ]);

                $material->category()->associate($materialCategory);
                $material->save();
            }

            DB::table('prices')
                ->where('material_id', $material->material_id)
                ->update(['is_active' => false]);

            // Create a new price instance
            $price = new Price();
            $price->price = $validatedData['price'];
            $price->quarter = $validatedData['quarter'];
            $price->year = $validatedData['year'];
            $price->material_id = $material->material_id;

            // Save the price
            $price->save();

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




    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'edit_material_name' => 'required|string',
            'edit_material_category_name' => 'required|string',
            'edit_unit' => 'required|string',
            'edit_price' => 'required|numeric',
            'edit_quarter' => 'required|string',
            'edit_year' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Find the material based on ID
            $material = Material::findOrFail($id);

            // Update material details
            $material->material_name = $validatedData['edit_material_name'];
            $material->unit = $validatedData['edit_unit'];

            // Update material category (retrieve if exists or create if new)
            $materialCategory = MaterialCategory::firstOrCreate([
                'material_category_name' => $validatedData['edit_material_category_name'],
            ]);
            $material->category()->associate($materialCategory);

            // Deactivate existing prices with the same material_id the material
            DB::table('prices')
                ->where('material_id', $material->material_id)
                ->update(['is_active' => false]);

            // Create a new price instance
            $newPrice = new Price();
            $newPrice->price = $validatedData['edit_price'];
            $newPrice->quarter = $validatedData['edit_quarter'];
            $newPrice->year = $validatedData['edit_year'];
            $newPrice->material_id = $material->material_id; // Associate with the material

            $material->save();   // Save changes to the material
            // Save the new price
            $newPrice->save();
            $material->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Material updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update material: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Material update failed. Check logs for details.']);
        }
    }



    // Other controller methods (create, edit, update, destroy) go here
}
