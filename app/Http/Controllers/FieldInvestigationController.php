<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FieldInvestigation;
use App\Models\User;
use Illuminate\Http\Request;

class FieldInvestigationController extends Controller
{
    //

    public function assignInvestigation(Request $request){

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'officer_id' => 'required|exists:users,id',
        ]);

        FieldInvestigation::updateOrCreate(
            ['client_id' => $request->client_id], // Search condition
            ['officer_id' => $request->officer_id] // Fields to update or insert
        );
        
        return redirect()->back()->with('success','Investigation assigned to field officer.'); 
    }

    public function index(Client $client){
        $investigation_records = $client->fieldInvestigations; // Load field investigation records
        return view('admin/investigation.index', compact('client', 'investigation_records'));
    }

    public function show(Client $client, $investigation_id)
    {
        $investigation = FieldInvestigation::with(['client', 'officer'])->findOrFail($investigation_id);
        return view('admin/investigation.show', compact('client','investigation'));
    }

    public function edit(Client $client, $investigation_id)
    {
        $investigation = FieldInvestigation::with(['client', 'officer'])->findOrFail($investigation_id);
        return view('admin/investigation.edit', compact('client', 'investigation'));
    }
}
