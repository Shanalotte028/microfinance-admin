<?php

namespace App\Http\Controllers;

use App\Models\PendingUser;
use Illuminate\Http\Request;

class PendingUserController extends Controller
{
    //
    public function store(Request $request){
        $validated = $request->validate([
            'employee_id' => 'required|unique:pending_users,employee_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:pending_users,email',
            'microservice' => 'required|in:Admin,HR1,HR2,HR3,HR4,Core1,Core2,Logistic1,Logistic2,Finance'
        ]);

        PendingUser::create($validated);

        return response()->json(['message' => 'User request stored successfully.'], 201);
    }

}
