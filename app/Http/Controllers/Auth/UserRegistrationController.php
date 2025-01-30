<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Mail\UserPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRegistrationController extends Controller
{
    public function create()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }
        return view("admin/auth.register");
    }

    public function store(Request $request){
        $userAdmin = Auth::user();
        // Check if the user has admin permissions
        if (Gate::denies('admin')) {
            abort(403);
        }
        // Validate input
        $validatedAttributes = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:Staff,Manager,Admin'],
        ]);

        // Generate a random password
        $randomPassword = Str::random(10); // You can adjust the length as needed

        // Determine access level based on role
        $access_level = match ($request->input('role')) {
            'Staff' => 'Basic',
            'Manager' => 'Manager',
            'Admin' => 'Admin',
            default => 'Basic',
        };

        // Create user with the generated password
        $user = User::create(array_merge($validatedAttributes, [
            'access_level' => $access_level,
            'password' => bcrypt($randomPassword),
            'password_reset_required' => true, // Hash the random password
        ]));
        
        Mail::to($user->email)->send(new UserPasswordMail($randomPassword));

        AuditHelper::log('Account Creation', 
        'User Management', 
        "User $userAdmin->id ($userAdmin->email) created account for $user->first_name $user->last_name ($user->email)", 
        null, 
        $user->toArray());

        // Redirect with a success message
        return redirect()->route('dashboard')->with('success', 'Account Creation successful.');
    }
}
