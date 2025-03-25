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
}
