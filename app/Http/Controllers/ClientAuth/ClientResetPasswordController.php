<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ClientResetPasswordController extends Controller
{
    // Show the password reset form
    public function create(Request $request, $token = null)
    {
        return view('client.auth.password-reset')->with([
            'token' => $token, 
            'email' => $request->email
        ]);
    }
    
    // Handle password reset
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
            'token' => 'required',   
        ]);

        // Use the client password broker instead of default
        $response = Password::broker('clients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? redirect()->route('client.login')->with('success', __($response))  // Redirect to client login
                    : back()->withErrors(['email' => __($response)]);
    }
}
