<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    //
    public function show(Client $client, $financial_id, $loan_id)
    {
        // Retrieve the specific compliance record for the client
        $financial = $client->financial_details;
        

        // If the compliance record is not found in the client's records, throw a 404
        if (!$financial) {
            abort(404, 'Financial record not found.');
        }

        // Find the specific KYC record related to this compliance record
        $loan = $financial->loans->find($loan_id);

        // If the KYC record is not found, throw a 404
        if (!$loan) {
            abort(404, 'Loan record not found.');
        }

        

        // Pass the client, compliance, and KYC record to the view
        return view('loan.show', compact('client', 'financial', 'loan'));
    }
}
