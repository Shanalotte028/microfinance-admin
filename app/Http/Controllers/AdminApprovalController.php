<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\PendingLegalCase;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminApprovalController extends Controller
{
    //
    public function pendingUsers(){
        $pendingUsers = PendingUser::all();
        return view('admin.pending.users', compact('pendingUsers'));
    }

    public function pendingLegalCases(){
        $lawyers = User::where('role', 'Lawyer')->get();
        $pendingLegalCases = PendingLegalCase::all();
        return view('admin.pending.legal_cases', compact('pendingLegalCases', 'lawyers'));
    }

    public function approveUser($id){
        $pendingUser = PendingUser::findOrFail($id);

        User::create([
            'employee_id' => $pendingUser->employee_id,
            'first_name' => $pendingUser->first_name,
            'last_name' => $pendingUser->last_name,
            'role' => $pendingUser->role,
            'email' => $pendingUser->email,
            'microservice' => $pendingUser->microservice,
            'password' => Hash::make('defaultPassword123'),
        ]);

        $pendingUser->delete();
        return redirect()->back()->with('success', 'User account approved successfully!');
    }

    public function rejectUser($id){
        PendingUser::findOrFail($id)->delete();
        return redirect()->back()->with('error', 'User request rejected.');
    }

    public function approveLegalCase(Request $request, $id){
        $pendingCase = PendingLegalCase::findOrFail($id);

        $request->validate([
            'lawyer_id' => 'required|exists:users,id', // Ensure lawyer exists
        ]);

        LegalCase::create([
            'client_id' => $pendingCase->client_id,
            'assigned_to' => $request->lawyer_id,
            'case_number' => $pendingCase->case_number,
            'title' => $pendingCase->title,
            'description' => $pendingCase->description,
            'filing_date' => $pendingCase->filing_date,
            'status' => 'open',
        ]);

        $pendingCase->delete();
        return redirect()->back()->with('success', 'Legal case approved successfully!');
    }

    public function rejectLegalCase($id){
        PendingLegalCase::findOrFail($id)->delete();
        return redirect()->back()->with('error', 'Legal case request rejected.');
    }

}
