<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Mail\UserPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;
 


class UserRegistrationController extends Controller
{
    public function create()
    {
        return view("admin/auth.register");
    }

    


public function store(Request $request){
    $userAdmin = Auth::user();

    // Validate input
    $validatedAttributes = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'role' => ['required', 'string', 'in:Staff,Staff Manager,Admin,Lawyer'], 
        'microservice' => ['required', 'string', 'in:Admin,HR1,HR2,HR3,HR4,Core1,Core2,Logistic1,Logistic2,Finance'], // Define assigned service
    ]);

    // Generate a random password
    $randomPassword = Str::random(10);

    // Create user with the generated password
    $user = User::create([
        'first_name' => $validatedAttributes['first_name'],
        'last_name' => $validatedAttributes['last_name'],
        'email' => $validatedAttributes['email'],
        'access_level' => $validatedAttributes['role'],
        'password' => bcrypt($randomPassword),
        'password_reset_required' => true, 
    ]);

    // Assign Role to the New User
    $user->assignRole($validatedAttributes['role']);

    // Send Email with Password
    Mail::to($user->email)->send(new UserPasswordMail($randomPassword));

    // Notify the assigned microservice
    $this->notifyMicroservice($user, $validatedAttributes['microservice'], $randomPassword);

    // Log the Action
    AuditHelper::log(
        'Account Creation',
        'User Management',
        "User $userAdmin->id ($userAdmin->email) created account for $user->first_name $user->last_name ($user->email)",
        null,
        $user->toArray()
    );

    // Redirect with Success Message
    return redirect()->route('dashboard')->with('success', 'Account Creation successful.');
}

/**
 * Send API request to assigned microservice with API Key
 */
private function notifyMicroservice($user, $microservice, $password){
    // Define API endpoints and API keys for each microservice
    $apiConfig = [
        'HR1' => [
            'url' => env('HR_API_URL') . '/api/users',
            'key' => env('HR_API_KEY')
        ],
        'HR2' => [
            'url' => env('HR_API_URL') . '/api/users',
            'key' => env('HR_API_KEY')
        ],
        'HR3' => [
            'url' => env('HR3_API_URL') . '/api/users',
            'key' => env('HR3_API_KEY')
        ],
        'HR4' => [
            'url' => env('HR_API_URL') . '/api/users',
            'key' => env('HR_API_KEY')
        ],
        'Loans' => [
            'url' => env('LOANS_API_URL') . '/api/users',
            'key' => env('LOANS_API_KEY')
        ],
        'Finance' => [
            'url' => env('FINANCE_API_URL') . '/api/users',
            'key' => env('FINANCE_API_KEY')
        ],
        'Core2' => [
            'url' => env('CORE2_API_URL') . '/api/users',
            'key' => env('CORE2_API_KEY')
        ],
    ];

    // Check if microservice exists in the config
    if (!isset($apiConfig[$microservice])) {
        Log::error("Invalid microservice: $microservice");
        return;
    }

    try {
        // Make the request with the API key
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $apiConfig[$microservice]['key'],
            'Accept' => 'application/json',
        ])->post($apiConfig[$microservice]['url'], [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
            'password' => $password, // The microservice should enforce password reset
        ]);

        // Check if the request was successful
        if (!$response->successful()) {
            Log::error("Failed to notify $microservice: " . $response->body());
        }
    } catch (\Exception $e) {
        Log::error("Failed to notify $microservice: " . $e->getMessage());
    }
}


}
