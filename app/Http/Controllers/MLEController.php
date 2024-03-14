<?php

namespace App\Http\Controllers;

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

}
