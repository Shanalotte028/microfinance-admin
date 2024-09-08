<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserRegistrationController extends Controller
{
    //
    public function create(){
        return view("auth.register");
    }
    public function store(){
        $validatedAttributes = request()->validate([
            'first_name'=>['required'],
            'last_name'=>['required'],
            'email'=>['required','email'],
            'password'=>['required','confirmed']
        ]);
        
        $user = User::create($validatedAttributes);

        return redirect('/login');
    }
}
