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

            // Update labor details
            $labor->labor_name = $validatedData['edit_labor_name'];
            $labor->location = $validatedData['edit_location'];

            // Retrieve existing price record
            $rate = $labor->rates()->where([
                'labor_id' => $labor->labor_id,
            ])->firstOrFail();

            // Update price attributes
            $rate->rate = $validatedData['edit_rate'];

            // Save changes
            $labor->save();
            $rate->save();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Material updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update labor: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Material update failed. Check logs for details.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Labor $labor)
    {
        //
    }
}
