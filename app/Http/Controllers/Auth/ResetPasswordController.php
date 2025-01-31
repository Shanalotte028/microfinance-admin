<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ResetPasswordController extends Controller
{
    //
    public function create(Request $request, $token=null){
        return view('admin/auth.password-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function showResetForm(Request $request, $token=null){
        return view('admin/auth.password-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    
    public function update(Request $request){
        request()->validate([
            'email' => 'required|email',
            'password' => ['required','confirmed',RulesPassword::defaults()],
            'token' => 'required',   
        ]);

        // If the user is logged in (admin or system user), we get their ID
        $authUser = Auth::user();  // This will either be an admin or the system user who initiated the reset

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($authUser) {
                $user->password = bcrypt($password);
                $user->password_reset_required = false;
                $user->save();

                // Check if the reset was performed by the user or an admin
            if ($authUser) {
                // Admin initiated the reset
                $actor = $authUser;  // Admin user ID
            } else {
                // User initiated their own password reset (if no admin is logged in)
                $actor = $user;  // The user who initiated the reset
            }

            // Log the password reset event (either by user or admin)
            $oldData = ['password' => 'Password reset'];
            $newData = ['password' => 'Password reset'];

            // Log audit based on who performed the reset (admin or user)
            AuditHelper::log(
                'Update',
                'User Management',
                $authUser ? "User {$authUser->id} reset their own password ({$user->email})" : 
                            "User {$user->id} ($user->email) reset their own password",
                $oldData,
                $newData
            );
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', __($response))
                    : back()->withErrors(['email' => __($response)]);
    }
}
