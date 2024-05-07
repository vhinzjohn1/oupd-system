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
                'roles' => $request['role'],
            ]);
            $user->save();


            return response()->json($user, 201);
        } catch (\Exception $e) {
            // Handle the exception, log it, return an error response, etc.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // This is the Update Basically
    public function update(Request $request, $user_id)
    {
        try {
            // Find the user by its ID
            $user = User::find($user_id);

            // Check if the user exists
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Check if the updated first name and last name already exist for another user
            $existingUser = User::where('first_name', $request['firstName'])
                ->where('last_name', $request['lastName'])
                ->where('id', '!=', $user_id) // Exclude the current user from the check
                ->first();

            if ($existingUser) {
                // If user already exists, you can handle it accordingly
                return response()->json(['error' => 'User already exists'], 400);
            }

            // Update the user attributes
            $user->first_name = $request['firstName'];
            $user->middle_name = $request['middleName'];
            $user->last_name = $request['lastName'];
            $user->user_name = $request['userName'];
            $user->email = $request['email'];
            $user->roles = $request['role'];

            // Bcrypt the password if it's provided and not empty or null
            if ($request->filled('password')) {
                $user->password = bcrypt($request['password']);
            }


            // Save the changes
            $user->save();

            return response()->json($user, 200);
        } catch (\Exception $e) {
            // Handle the exception, log it, return an error response, etc.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            $user->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            // Log detailed error message
            Log::error('Failed to delete User: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'Failed to delete User. Please check the logs for details.']);
        }
    }


}
