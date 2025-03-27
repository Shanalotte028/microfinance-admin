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
        $cases = $user->legalCases()->with(['client', 'assignedLawyer'])->get();
        $investigations = $user->fieldInvestigations()->with(['client', 'officer'])->get();
        
        return view('admin.user.show', compact('user', 'cases', 'investigations'));
    }

    public function edit(User $user){

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user){
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

    public function deactivate(User $user){
        $previousStatus = $user->status;
        $adminUser = Auth::user();
        
        // Toggle the blocked status between 'yes' and 'no'
        $user->status = ($user->status === 'inactive') ? 'active' : 'inactive';
        $newStatus = $user->status;
        $user->save();

        // Prepare a success message based on the new status
        $message = $user->status === 'inactive' ? 'user has been deactivated successfully.' : 'user has been activated successfully.';
        
        //  Add Audit Log
        AuditHelper::log('Deactivate/Activate',
            'User Management',
            "User $adminUser->id ($adminUser->email) changed the status of User ID number: $user->id ($user->email)",
            $previousStatus, // ID of the affected user
            $newStatus,);

        return redirect()->back()->with('success', $message);
    }
}
