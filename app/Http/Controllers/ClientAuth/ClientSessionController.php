<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Log;

class ClientSessionController extends Controller
{
    use ThrottlesLogins;

    public function create(){
        return view("client/auth.login");
    }

    public function store(Request $request){

    Log::info('Current session cookie: ' . config('session.cookie'));
    $validatedAttributes = $request->validate([
        "email" => ['email', 'string', 'required'],
        'password' => ['required', 'string'],
    ]);

    $remember = $request->has('remember');

    // Find the user by email
    $client = Client::where('email', $validatedAttributes['email'])->first();

    // Check if the client exists and if they are blocked
    if ($client && $client->blocked === "Yes") {
        throw ValidationException::withMessages([
            'email' => 'Your account is blocked. Please contact support.',
        ]);
    }

    // Attempt to authenticate the user
    if (!Auth::guard('client')->attempt($validatedAttributes, $remember)) {
        throw ValidationException::withMessages([
            'email' => 'Wrong Credentials',
        ]);
    }

    request()->session()->regenerate();

    return redirect()->route('client.dashboard');
}


    public function destroy(){
        Auth::guard('client')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('client.login');
    }


    // Define how many attempts are allowed before locking
    protected function maxAttempts()
    {
        return 5; // Number of allowed attempts
    }

    // Define how long (in minutes) the account is locked after max attempts
    protected function decayMinutes()
    {
        return 10; // Lock account for 1 minute after maxAttempts
    }

    // You can modify the error message
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return response()->json([
            'error' => 'Too many login attempts. Please try again in '.$seconds.' seconds.',
        ], 423);
    }
}
