<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function update(){
        request()->validate([
            'email' => 'required|email',
            'password' => ['required','confirmed',RulesPassword::defaults()],
            'token' => 'required',   
        ]);

        $response = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? redirect()->route('admin.login')->with('status', __($response))
                    : back()->withErrors(['email' => __($response)]);
    }
}
