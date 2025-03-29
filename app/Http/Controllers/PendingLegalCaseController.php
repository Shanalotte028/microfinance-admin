<?php

namespace App\Http\Controllers;

use App\Models\PendingLegalCase;
use Illuminate\Http\Request;

class PendingLegalCaseController extends Controller
{
    //
    public function store(Request $request){
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'case_number' => 'required|unique:pending_legal_cases,case_number',
            'title' => 'required',
            'description' => 'required',
            'filing_date' => 'required|date'
        ]);

        PendingLegalCase::create($validated);

        return response()->json(['message' => 'Legal case request stored successfully.'], 201);
    }

}
