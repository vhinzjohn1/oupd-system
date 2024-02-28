<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!($user instanceof User)) {
                dd('Auth::user() does not return an instance of User model.');
            }

            // Perform the update
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->user_name = $request->user_name;
            $user->email = $request->email;

            // Check if password is being updated
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Save the changes
            $user->save();

            return redirect()->back()->with('success', 'Profile updated.');
        }

        return redirect()->back()->with('error', 'User is not authenticated.');
    }
}
