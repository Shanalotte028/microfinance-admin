<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LegalCaseController extends Controller
{
    // List all legal cases
    public function index()
    {
        $cases = LegalCase::with(['client', 'assignedLawyer'])->get();
        return view('admin/legal_cases.index', compact('cases'));
    }

    // Show form to create a new legal case
    public function create()
    {
        $clients = Client::all();
        $lawyers = User::where('role', 'lawyer')->get(); // Assuming you have a 'role' column
        return view('admin/legal_cases.create', compact('clients', 'lawyers'));
    }

    // Store a new legal case
    public function store(Request $request)
    {
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

        LegalCase::create($request->all());

        AuditHelper::log('Create Legal Case',
        'Legal Management',
        "User $adminUser->id ($adminUser->email) Created a new legal with case number: $request->case_number",
        null, // ID of the affected client
        null,);

        return redirect()->route('admin.legal.index')->with('success', 'Legal case created successfully.');
    }

    // Show a specific legal case
    public function show($id)
    {
        $case = LegalCase::with(['client', 'assignedLawyer'])->findOrFail($id);
        return view('admin/legal_cases.show', compact('case'));
    }

    // Update a legal case
    public function update(Request $request, $id)
    {
        $adminUser = Auth::user();

        $case = LegalCase::findOrFail($id);
        $previousStatus = $case->status;
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $case->update($request->only(['status']));

        $newStatus = $case->status;

        AuditHelper::log('Update Legal Case',
        'Legal Management',
        "User $adminUser->id ($adminUser->email) updated a legal with case number: $case->case_number",
        $previousStatus, // ID of the affected client
        $newStatus,);
        return redirect()->back()->with('success', 'Legal case updated successfully.');
    }

    public function destroy($id)
    {
        $case = LegalCase::findOrFail($id);
        $case->delete();
        return redirect()->route('legal-cases.index')->with('success', 'Legal case deleted successfully.');
    }

}
