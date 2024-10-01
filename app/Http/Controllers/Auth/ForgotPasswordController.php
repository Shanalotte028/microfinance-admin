<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    //
    public function create(){
        return view('admin/auth.password-forgot');
    }

    public function store(Request $request){
    // Validate the email input
    $request->validate(['email' => ['required','string','email']]);

    // Attempt to send the password reset link to the user's email
    $status = Password::broker()->sendResetLink(
        $request->only('email')
    );
    
    // Return response based on whether the email was successfully sent
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    }
}
