<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetProject extends Controller
{
    public function store(Request $request)
    {
        session()->put('projectID', $request['projectID']);

        return response()->json($request['projectID']);

    }
}
