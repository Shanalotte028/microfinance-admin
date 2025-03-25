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

        FieldInvestigation::create([
            'client_id' => $request->client_id,
            'officer_id' => $request->officer_id,
        ]);
        
        return redirect()->back()->with('sucess','Investigation assigned to field officer.'); 
    }
}
