<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if (request()->ajax()) {
            return response()->json($users);
        } else {
            return view('users.index', compact('users'));
        }

    }


    public function store(Request $request)
    {
        try {
            // Check if the user already exists
            $existingUser = User::where('first_name', $request['firstName'])
                ->where('last_name', $request['lastName'])
                ->first();

            if ($existingUser) {
                // If user already exists, you can handle it accordingly
                return response()->json(['error' => 'User already exists'], 400);
            }

            // Create a new user
            $user = new User([
                'first_name' => $request['firstName'],
                'middle_name' => $request['middleName'],
                'last_name' => $request['lastName'],
                'user_name' => $request['userName'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']), // Hash the password
                'roles' => $request['roles'],
            ]);
            $user->save();


            return response()->json($user, 201);
        } catch (\Exception $e) {
            // Handle the exception, log it, return an error response, etc.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
