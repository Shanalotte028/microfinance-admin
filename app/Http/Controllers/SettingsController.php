<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    //
    public function profile(Request $request){
        return view('admin.settings.profile');
    }

    public function profileUpdate(Request $request){
       /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Fill the validated data into the user model
        $user->update($validatedData);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function settings(Request $request){
        return view('admin.settings.settings');
    }
}