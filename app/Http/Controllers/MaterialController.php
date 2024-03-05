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
        // $materials = Material::with('category', 'prices')->get();
        // return view('pages.list_of_materials', compact('materials'));
        $materials = Material::with('category', 'prices')->get();
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


            // Associate the category (assuming a belongsTo relationship called 'category')
            $material = new Material([
                'material_name' => $validatedData['material_name'],
                'unit' => $validatedData['unit'],
            ]);

            $material->category()->associate($materialCategory);
            $material->save();



            // Create a new material instance and assign IDs
            $price = new Price();
            $price->price = $validatedData['price'];
            $price->quarter = $validatedData['quarter'];
            $price->year = $validatedData['year'];
            $price->material_id = $material->material_id;
            $price->status = 1;

            // // Save the material
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

            // Retrieve existing price record
            $price = $material->prices()->where([
                'material_id' => $material->material_id,
            ])->firstOrFail();

            // Update price attributes
            $price->price = $validatedData['edit_price'];
            $price->quarter = $validatedData['edit_quarter'];
            $price->year = $validatedData['edit_year'];

            // Save changes
            $material->save();
            $price->save();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Material updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update material: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Material update failed. Check logs for details.']);
        }
    }



    // public function update(Request $request, $id)
    // {
    //     // Validate incoming request data
    //     $validatedData = $request->validate([
    //         'edit_material_name' => 'required|string',
    //         'edit_material_category_name' => 'required|string',
    //         'edit_unit' => 'required|string',
    //         'edit_price' => 'required|numeric',
    //         'edit_quarter' => 'required|string',
    //         'edit_year' => 'required|string',
    //     ]);

    //     try {
    //         // Start a database transaction
    //         DB::beginTransaction();

    //         // Retrieve the material to be updated
    //         $material = Material::findOrFail($id);

    //         // Retrieve material category
    //         $materialCategory = MaterialCategory::where('material_category_name', $validatedData['edit_material_category_name'])->first();

    //         if (!$materialCategory) {
    //             // Material category doesn't exist, handle it accordingly (e.g., abort, return error response, etc.)
    //             return response()->json(['success' => false, 'message' => 'Material category does not exist.']);
    //         }

    //         // Retrieve unit
    //         $unit = Unit::where('unit_name', $validatedData['edit_unit'])->first();

    //         if (!$unit) {
    //             // Unit doesn't exist, handle it accordingly
    //             return response()->json(['success' => false, 'message' => 'Unit does not exist.']);
    //         }

    //         // Retrieve quarter
    //         $quarter = Quarter::where('quarter', $validatedData['edit_quarter'])->first();

    //         if (!$quarter) {
    //             // Quarter doesn't exist, handle it accordingly
    //             return response()->json(['success' => false, 'message' => 'Quarter does not exist.']);
    //         }

    //         // Retrieve year
    //         $year = Year::where('year', $validatedData['edit_year'])->first();

    //         if (!$year) {
    //             // Year doesn't exist, handle it accordingly
    //             return response()->json(['success' => false, 'message' => 'Year does not exist.']);
    //         }

    //         // Update price
    //         $material->price->update([
    //             'price' => $validatedData['edit_price'],
    //             'quarter_id' => $quarter->id,
    //             'year_id' => $year->id,
    //         ]);

    //         // Update material fields
    //         $material->material_name = $validatedData['edit_material_name'];
    //         $material->material_category_id = $materialCategory->id;
    //         $material->unit_id = $unit->id;

    //         // Save the updated material
    //         $material->save();

    //         // Commit the transaction
    //         DB::commit();

    //         // Return success response
    //         return response()->json(['success' => true, 'message' => 'Material updated successfully']);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if an exception occurs
    //         DB::rollBack();

    //         // Log detailed error message
    //         Log::error('Failed to update material: ' . $e->getMessage());

    //         // Return error response
    //         return response()->json(['success' => false, 'message' => 'Failed to update material. Please check the logs for details.']);
    //     }
    // }


    // Other controller methods (create, edit, update, destroy) go here
}
