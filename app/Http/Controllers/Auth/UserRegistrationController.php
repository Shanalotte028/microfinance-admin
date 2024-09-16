<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class UserRegistrationController extends Controller
{
    public function create()
    {
        return view("auth.register");
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedAttributes = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:Staff,Manager,Admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Determine access level based on role
        $access_level = match ($request->input('role')) {
            'Staff' => 'Basic',
            'Manager' => 'Manager',
            'Admin' => 'Admin',
            default => 'Basic',
        };

        // Hash the password
        $validatedAttributes['password'] = bcrypt($validatedAttributes['password']);

        // Create user
        User::create(array_merge($validatedAttributes, [
            'access_level' => $access_level,
        ]));

        // Redirect with a success message
        return redirect('/login')->with('status', 'Registration successful. Please login.');
    }
}
