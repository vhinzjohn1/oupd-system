<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $test = DB::select("SELECT * FROM test WHERE `firstname` = 'bins'");

        if (request()->ajax()) {
            return response()->json($test);
        } else {
            // Handle non-ajax request if needed
        }
    }
}
