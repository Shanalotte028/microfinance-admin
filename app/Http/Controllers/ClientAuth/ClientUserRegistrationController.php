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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:clients,email'],
            'phone_number' => ['required', 'string', 'min:10', 'max:15', 'unique:clients,phone_number'], // Adjust min/max as needed
            'birthday' => ['required', 'date', 'before:today'], // Ensures valid date and not a future date
            'gender' => ['required', 'string', 'in:Male,Female,Other'], // Limits to predefined values
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
