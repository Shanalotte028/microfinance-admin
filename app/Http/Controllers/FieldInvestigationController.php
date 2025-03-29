<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Client;
use App\Models\FieldInvestigation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldInvestigationController extends Controller
{
    //
    public function credit_investigations(Request $request){
        $user = Auth::user();
        $user->role === 'Field Investigator' ;
        /** @var User $user */
        $investigations = $user->fieldInvestigations()->with(['client', 'officer'])->get();
        return view('admin/investigation.credit_investigations', compact('investigations'));
    }

    public function assignInvestigation(Request $request){
        $authUser = Auth::user();
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'officer_id' => 'required|exists:users,id',
        ]);

        FieldInvestigation::updateOrCreate(
            ['client_id' => $request->client_id], // Search condition
            ['officer_id' => $request->officer_id] // Fields to update or insert
        );
        AuditHelper::log('Assign', 'Credit Investigation', 
        "User $authUser->id $authUser->email ($authUser->role) Assigned (Officer ID: $request->officer_id) to conduct Credit Investigation for (Client ID: $request->client_id)");
        
        return redirect()->back()->with('success','Investigation assigned to field officer.'); 
    }

    public function index(Client $client){
        $investigation_records = $client->fieldInvestigations; // Load field investigation records
        return view('admin/investigation.index', compact('client', 'investigation_records'));
    }

    public function show(Client $client, $investigation_id){
        $investigation = FieldInvestigation::with(['client', 'officer'])->findOrFail($investigation_id);
        return view('admin/investigation.show', compact('client','investigation'));
    }

    public function edit(Client $client, $investigation_id){
        $investigation = FieldInvestigation::with(['client', 'officer'])->findOrFail($investigation_id);
        return view('admin/investigation.edit', compact('client', 'investigation'));
    }

    public function update(Request $request, Client $client, $investigation_id){
        $adminUser = Auth::user();

        $investigation = FieldInvestigation::findOrFail($investigation_id);
        $previousStatus = $investigation->toArray();

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'officer_id' => 'required|exists:users,id',
            'verified' => 'required|boolean',
            'observations' => 'required|string',
        ]);

        // Update the legal case
        $investigation->update($request->all());

        $newStatus = $investigation->toArray();

        // Log the audit trail
        AuditHelper::log(
            'Update',
            'Credit Investigation',
            "User $adminUser->id $adminUser->email ($adminUser->role) Updated a Investigation Record with investigation number of: $investigation_id",
            $previousStatus, // Old status
            $newStatus // New status
        );

        // Redirect to the show page
        return redirect()->route('admin.investigation.show', ['client'=> $client, 'investigation'=> $investigation_id])->with('success', 'Investigation updated successfully.');
    }
}
