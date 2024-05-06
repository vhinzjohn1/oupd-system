<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $signature = Signature::all();
        return $signature;
    }

    public function store(Request $request)
    {
        try {

            // Retrieve or create project
            $signature = Signature::firstOrCreate(
                [
                    'project_id' => $request['projectId'],
                    'role' => $request['role'],
                ],
                [
                    'fullname' => $request['fullName'],
                    'degree' => $request['degree'],
                    'position' => $request['position'],
                    'role' => $request['role'],
                    'project_id' => $request['projectId'],
                ]
            );
            if ($signature->wasRecentlyCreated) {
                // New record was created
                return response()->json(['success' => true, 'message' => 'Successfully added Signature']);
            } else {
                // Existing record was retrieved
                return response()->json(['success' => false, 'message' => 'Signature already exists for this project.']);
            }
        } catch (\Exception $e) {

            // Log detailed error message
            Log::error('Failed to add Signature: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add Signature. Please check the logs for details.']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Signature $signature)
    {
        //
    }

    public function update(Request $request, $signature_id)
    {
        try {

            // Retrieve or create project
            $signature = Signature::updateOrCreate(['signature_id' => $signature_id], [
                'fullname' => $request['fullName'],
                'degree' => $request['degree'],
                'position' => $request['position'],
                'role' => $request['role'],
                'project_id' => $request['projectId'],
            ]);
            // Return success response with signature data and message
            return response()->json([
                'success' => true,
                'message' => 'Signature Edited Successfully',
                'signature' => $signature
            ]);

        } catch (\Exception $e) {

            // Log detailed error message
            Log::error('Failed to add Signature: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to add Signature. Please check the logs for details.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($signature_id)
    {
        try {
            // Find the Signature based on signature_id
            $signature = Signature::findOrFail($signature_id);

            // You can choose to delete the Signature if needed
            $signature->delete();

            return response()->json(['success' => true, 'message' => 'Signature details deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Failed to delete Signature details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete Signature details. Check logs for details.']);
        }
    }
}
