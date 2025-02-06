<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    //

    public function index(){
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function show(User $user){
        if (Gate::denies('admin')) {
            abort(403);
        }

        return view('admin.user.show', compact('user'));
    }

        public function edit(User $user){
        if (Gate::denies('admin')) {
            abort(403);
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        if (Gate::denies('admin')) {
            abort(403);
        }
        $oldData = $user->toArray();

        $validatedAttributes = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:Staff,Manager,Admin'],
        ]);

        $access_level = match ($request->input('role')) {
            'Staff' => 'Basic',
            'Manager' => 'Manager',
            'Admin' => 'Admin',
            default => 'Basic',
        };

        $user->update(array_merge($validatedAttributes, [
            'access_level' => $access_level,
        ]));

        AuditHelper::log('Account Update', 
            'User Management', 
            "User " . Auth::user()->email . " updated account for $user->first_name $user->last_name ($user->email)", 
            $oldData, 
            $user->toArray());

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }
}
