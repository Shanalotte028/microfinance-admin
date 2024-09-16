<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class UserRegistrationController extends Controller
{
    //
    public function create(){
        return view("auth.register");
    }
    public function store(){
        $validatedAttributes = request()->validate([
            'first_name'=>['required', 'string', 'max:255'],
            'last_name'=>['required', 'string', 'max:255'],
            'email'=>['required','string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role'=>['required'],
            'password'=>['required','confirmed', Rules\Password::defaults()]     
        ]);
        
        $access_level = '';

        switch (request()->input('role')) {
            case 'Staff':
                $access_level = 'Basic';
                break;
            case 'Manager':
                $access_level = 'Manager';
                break;
            case 'Admin':
                $access_level = 'Admin';
                break;
        }

        User::create(array_merge($validatedAttributes,[
            'access_level' => $access_level
        ]));

        return redirect('/login');
    }
}
