<?php

namespace App\Http\Controllers;

use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ParticularController extends Controller
{
    public function index()
    {
        $particular = Particular::all();
        if (request()->ajax()) {
            return response()->json($particular);
        } else {
            return view('particular');
        }
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'particular_name' => 'required|string',
            'description' => 'required|string',
        ]);
        try {

            // Start a database transaction
            DB::beginTransaction();

            // Retrieve or create project
            $particular = Particular::firstOrCreate(['particular_name' => $validatedData['particular_name']], [
                'description' => $validatedData['description'],
            ]);

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($particular);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to add particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add particular. Please check the logs for details.']);
        }
    }

    public function update(Request $request, $particular_id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'particular_name' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the project by ID
            $particular = Particular::findOrFail($particular_id);

            // Update project details
            $particular->update([
                'particular_name' => $validatedData['particular_name'],
                'description' => $validatedData['description'],
            ]);

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json($particular);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            // Log detailed error message
            Log::error('Failed to update particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to update patticular. Please check the logs for details.']);
        }
    }

    public function destroy($particular_id)
    {
        try {
            // Find the particular by ID
            $particular = Particular::findOrFail($particular_id);

            // Delete the particular
            $particular->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Particular deleted successfully']);
        } catch (\Exception $e) {
            // Log detailed error message
            Log::error('Failed to delete particular: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to delete particular. Please check the logs for details.']);
        }
    }



}
