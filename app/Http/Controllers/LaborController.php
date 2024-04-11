<?php

namespace App\Http\Controllers;

use App\Models\Labor;
use Illuminate\Http\Request;
use App\Models\LaborRate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaborController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Select labors with their associated active rates and categories
        $labors = DB::table('labors')
            ->join('labor_rates', 'labors.labor_id', '=', 'labor_rates.labor_id')
            ->select('labors.*', 'labor_rates.labor_rate_id', 'labor_rates.rate', 'labor_rates.date_effective')
            ->where('labor_rates.is_active', true)
            ->get();

        if (request()->ajax()) {
            return response()->json($labors);
        } else {
            return view('pages.list_of_labors');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'labor_name' => 'required|string',
            'location' => 'required|string',
            'rate' => 'required|numeric',

        ]);

        try {

            // Start a database transaction
            DB::beginTransaction();

            // Check if labor with the same name and location exists
            $labor = Labor::where('labor_name', $validatedData['labor_name'])
                ->where('location', $validatedData['location'])
                ->first();

            if (!$labor) {
                // If labor does not exist, create a new one
                $labor = new Labor([
                    'labor_name' => $validatedData['labor_name'],
                    'location' => $validatedData['location'],
                ]);
                $labor->save();
            }

            DB::table('labor_rates')
                ->where('labor_id', $labor->labor_id)
                ->update(['is_active' => false]);

            // Create a new rate instance
            $rate = new LaborRate();
            $rate->rate = $validatedData['rate'];
            $rate->labor_id = $labor->labor_id;

            // Save the rate
            $rate->save();

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($labor);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add labor: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add labor. Please check the logs for details.']);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $labor = Labor::with('rates')->findOrFail($id);
        return response()->json($labor);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Labor $labor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'edit_labor_name' => 'required|string',
            'edit_location' => 'required|string',
            'edit_rate' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Find the labor based on ID
            $labor = Labor::findOrFail($id);

            // Check if the updated labor name and location already exist
            $existingLabor = Labor::where('labor_name', $validatedData['edit_labor_name'])
                ->where('location', $validatedData['edit_location'])
                ->where('labor_id', '!=', $labor->labor_id)
                ->first();

            if ($existingLabor) {
                // If a labor with the same name and location already exists, return an error response
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Labor name and location already exist.']);
            }

            // Update labor details
            $labor->labor_name = $validatedData['edit_labor_name'];
            $labor->location = $validatedData['edit_location'];

            // Deactivate existing rates with the same labor_id as the labor
            DB::table('labor_rates')
                ->where('labor_id', $labor->labor_id)
                ->update(['is_active' => false]);

            // Create a new rate instance
            $newRate = new LaborRate();
            $newRate->rate = $validatedData['edit_rate'];
            $newRate->labor_id = $labor->labor_id; // Associate with the labor

            $labor->save();  // Save changes to labor table
            // Save the new rate
            $newRate->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Labor updated successfully!']);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();
            Log::error('Failed to update labor: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Labor update failed. Check logs for details.']);
        }

        // // Validate incoming request data
        // $validatedData = $request->validate([
        //     'edit_labor_name' => 'required|string',
        //     'edit_location' => 'required|string',
        //     'edit_rate' => 'required|numeric',
        // ]);

        // try {
        //     DB::beginTransaction();

        //     // Find the labor based on ID
        //     $labor = Labor::findOrFail($id);

        //     // Check if labor with the same name and location exists
        //     $existingLabor = Labor::where('labor_name', $validatedData['edit_labor_name'])
        //         ->where('location', $validatedData['edit_location'])
        //         ->where('id', '!=', $labor->id)
        //         ->first();

        //     if (!$existingLabor) {
        //         // Update labor details
        //         $labor->labor_name = $validatedData['edit_labor_name'];
        //         $labor->location = $validatedData['edit_location'];

        //         // Deactivate existing rates with the same labor_id as the labor
        //         DB::table('labor_rates')
        //             ->where('labor_id', $labor->labor_id)
        //             ->update(['is_active' => false]);

        //         // Create a new rate instance
        //         $newRate = new LaborRate();
        //         $newRate->rate = $validatedData['edit_rate'];
        //         $newRate->labor_id = $labor->labor_id; // Associate with the labor

        //         $labor->save();  // Save changes to labor table
        //         // Save the new rate
        //         $newRate->save();

        //         DB::commit();

        //         return response()->json(['success' => true, 'message' => 'Labor updated successfully!']);
        //     } else {
        //         // Labor with the same name and location already exists
        //         DB::rollBack();
        //         return response()->json(['success' => false, 'message' => 'Labor with the same name and location already exists.']);
        //     }
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     Log::error('Failed to update labor: ' . $e->getMessage());
        //     return response()->json(['success' => false, 'message' => 'Labor update failed. Check logs for details.']);
        // }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the labor based on ID
            $labor = Labor::findOrFail($id);

            // Deactivate existing rates related to the labor
            $labor->rates()->update(['is_active' => false]);

            // Update foreign key references to null in related labor_rates records
            LaborRate::where('labor_id', $labor->labor_id)->update(['labor_id' => null]);

            // Delete the labor
            $labor->delete();

            return response()->json(['success' => true, 'message' => 'Labor deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Failed to delete labor: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Labor deletion failed. Check logs for details.']);
        }

        // try {
        //     // Find the labor based on ID
        //     $labor = Labor::findOrFail($id);

        //     // Update labor_id to null in related labor_rates
        //     $labor->rates()->update(['labor_id' => null]);

        //     // Delete the labor
        //     $labor->delete();

        //     return response()->json(['success' => true, 'message' => 'Labor deleted successfully!']);
        // } catch (\Exception $e) {
        //     Log::error('Failed to delete labor: ' . $e->getMessage());
        //     return response()->json(['success' => false, 'message' => 'Labor deletion failed. Check logs for details.']);
        // }
    }
}