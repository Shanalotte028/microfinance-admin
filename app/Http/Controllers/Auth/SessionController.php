<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view("auth.login");
    }

    public function store(){
        $validatedAttributes = request()->validate([
            "email" => ['email', 'string', 'required'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($validatedAttributes)) {
            throw ValidationException::withMessages([
                'email' => 'Wrong Credentials'
            ]);
        }

        request()->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(){
        Auth::logout();

        return redirect()->route('login');
    }
}
