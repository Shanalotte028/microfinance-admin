<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Jobs\SendLegalCaseCreatedEmail;
use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LegalCaseController extends Controller
{
    // List all legal cases
    public function index(Request $request){
        $status = $request->query('status');
        $user = Auth::user();

        if ($user->role === 'Lawyer') {
            /** @var User $user */
            $cases = $user->legalCases()->with(['client', 'assignedLawyer'])->get();
        } else {
                // Query the legal cases based on the status
            $cases = LegalCase::with(['client', 'assignedLawyer'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->get();
        }
        
        return view('admin/legal_cases.index', compact('cases'));
    }

    // Show form to create a new legal case
    public function create(){

        $clients = Client::all();
        $lawyers = User::where('role', 'lawyer')->get(); // Assuming you have a 'role' column

        return view('admin/legal_cases.create', compact('clients', 'lawyers'));
    }

    // Store a new legal case
    public function store(Request $request){
        $adminUser = Auth::user();
    
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'assigned_to' => 'required|exists:users,id',
            'case_number' => 'required|string|unique:legal_cases',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'filing_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after:filing_date',
        ]);
    
        DB::transaction(function () use ($request, $adminUser) {
            // Find the assigned lawyer
            $assignedLawyer = User::find($request->assigned_to);
            // Ensure the assigned lawyer exists
            if (!$assignedLawyer) {
                throw new \Exception("Assigned lawyer not found.");
            }
    
            // Create the legal case
            $legalCase = LegalCase::create($request->all());
    
            // Dispatch the job to send the legal case created email
            dispatch(new SendLegalCaseCreatedEmail($legalCase, $assignedLawyer->email));
    
            // Log the audit trail
            AuditHelper::log(
                'Create Legal Case',
                'Legal Management',
                "User $adminUser->id $adminUser->email ($adminUser->role) created a new legal case with case number: $request->case_number",
                null, // ID of the affected client
                null
            );
        });
    
        return redirect()->route('admin.legal.index')->with('success', 'Legal case created successfully.');
    }

    // Show a specific legal case
    public function show($id){
        $case = LegalCase::with(['client', 'assignedLawyer'])->findOrFail($id);
        return view('admin/legal_cases.show', compact('case'));
    }

    public function edit($id){

        $case = LegalCase::with(['client', 'assignedLawyer'])->findOrFail($id);
        $clients = Client::all(); // Fetch all clients for the dropdown
        $lawyers = User::where('role', 'lawyer')->get(); // Fetch all lawyers for the dropdown
        return view('admin/legal_cases.edit', compact('case', 'clients', 'lawyers'));
    }

    // Update a legal case
    public function update(Request $request, $id){
        $adminUser = Auth::user();

        $case = LegalCase::findOrFail($id);
        $previousStatus = $case->toArray();

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'assigned_to' => 'required|exists:users,id',
            'case_number' => 'required|string|unique:legal_cases,case_number,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'filing_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after:filing_date',
        ]);

        // Update the legal case
        $case->update($request->all());

        $newStatus = $case->toArray();

        // Log the audit trail
        AuditHelper::log(
            'Update',
            'Legal Management',
            "User $adminUser->id $adminUser->email $adminUser->role updated a legal case with case number: $case->case_number",
            $previousStatus, // Old status
            $newStatus // New status
        );

        // Redirect to the show page
        return redirect()->route('admin.legal.show', $case->id)->with('success', 'Legal case updated successfully.');
    }

   /*  public function destroy($id){
        $case = LegalCase::findOrFail($id);
        $case->delete();
        return redirect()->route('legal-cases.index')->with('success', 'Legal case deleted successfully.');
    } */
}
