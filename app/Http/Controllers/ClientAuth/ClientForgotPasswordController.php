<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Notifications\ClientResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;

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

        $key = 'password-reset:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many requests, please try again later.']);
        }

        // Validate the email input
        $request->validate([
            'email' => ['required', 'string', 'email']
        ]);

        // Attempt to send the password reset link to the user's email using the 'clients' broker
        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );

        // Find the user by email
        $client = Client::where('email', $request->email)->first();

        if ($status === Password::RESET_LINK_SENT && $client) {
            // Send notification to the client

            $token = app('auth.password.broker')->createToken($client);

            $client->notify(new ClientResetPasswordNotification($token));
        }

        RateLimiter::hit($key, 60);

        // Return response based on whether the email was successfully sent
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => __($status)])  // Email sent successfully
                    : back()->withErrors(['email' => __($status)]);  // Failed to send email
    }
}
