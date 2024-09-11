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
            'role'=>['required'],
            'password'=>['required','confirmed']     
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
