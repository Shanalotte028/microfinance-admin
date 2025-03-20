<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    //
    public function show(Client $client, $financial_id, $loan_id){
        // Find the specific financial record for this client
        $financial = $client->financial_details()->where('id', $financial_id)->firstOrFail();

        // Find the specific loan related to this financial record
        $loan = $financial->loans()->where('id', $loan_id)->firstOrFail();

        return view('admin/loan.show', compact('client', 'financial', 'loan'));
    }

}
