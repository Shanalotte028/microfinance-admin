<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class SessionController extends Controller
{
    use ThrottlesLogins;

    public function create(){
        return view("admin/auth.login");
    }

    public function store(Request $request){
        $validatedAttributes = $request->validate([
            "email" => ['email', 'string', 'required'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        // Find the user by email
        $user = User::where('email', $validatedAttributes['email'])->first();

        if ($user && $user->status === "inactive") {
            throw ValidationException::withMessages([
                'email' => 'Your account is deactivated. Please contact support.',
            ]);
        }

        if (!Auth::attempt($validatedAttributes, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Wrong Credentials'
            ]);
        }

        $user = Auth::user();

        AuditHelper::log(
            'Login', // Action
            'Authentication', // Module
            "User $user->email logged in successfully.", // Description
            null, // Old Data (not needed here)
            ['user_id' => $user->id, 'email' => $user->email, 'ip' => request()->ip()] // New Data
        );
       
        if ($user->password_reset_required) { // Assuming you have this boolean column in your User model
            // Generate a password reset token
            $token = app('auth.password.broker')->createToken($user);

            Auth::logout();

            return redirect()->route('password.reset', ['token'=>$token,'email' => $user->email]); // Route to the password reset page
        }

        request()->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(){

        $user = Auth::user();

        if ($user) {
            AuditHelper::log(
                'Logout', // Action
                'Authentication', // Module
                "User $user->email logged out successfully.", // Description
                null, // Old Data (not needed here)
                ['user_id' => $user->id, 'email' => $user->email, 'ip' => request()->ip()] // New Data
            );
        }

        Auth::guard('web')->logout();

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
