<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ClientForgotPasswordController extends Controller
{
    // Show the forgot password form
    public function create()
    {
        return view('client.auth.password-forgot');
    }

    // Handle sending of the reset link
    public function store(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => ['required', 'string', 'email']
        ]);

        // Attempt to send the password reset link to the user's email using the 'clients' broker
        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );

        // Return response based on whether the email was successfully sent
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => __($status)])  // Email sent successfully
                    : back()->withErrors(['email' => __($status)]);  // Failed to send email
    }
}
