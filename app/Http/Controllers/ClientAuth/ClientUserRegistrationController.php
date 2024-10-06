<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class ClientUserRegistrationController extends Controller
{
    public function create()
    {
        return view("client/auth.register");
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedAttributes = $request->validate([
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:clients,email'],
            'client_type' => ['required', 'string', 'in:Individual,Business'], // Limits to predefined values
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Hash the password
        $validatedAttributes['password'] = bcrypt($validatedAttributes['password']);

        // Create user
        Client::create($validatedAttributes);

        // Redirect with a success message
        return redirect()->route('client.login')->with('status', 'Registration successful. Please login.');
    }
}
