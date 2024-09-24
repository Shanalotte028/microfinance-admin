<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class SessionController extends Controller
{
    use ThrottlesLogins;

    public function create(){
        return view("admin/auth.login");
    }

    public function store(Request $request){
        $validatedAttributes = request()->validate([
            "email" => ['email', 'string', 'required'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        if (!Auth::attempt($validatedAttributes, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Wrong Credentials'
            ]);
        }

        request()->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('login');
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
