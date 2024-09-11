<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    //
    public function create(){
        return view("auth.login");
    }
    public function store(){

        $validatedAttributes = request()->validate([
            "email"=> ['email','required'],
            'password'=> ['required'],
        ]);

        if(! Auth::attempt($validatedAttributes)){
            throw ValidationException::withMessages([
                'email'=> 'Wrong Credentials'
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
