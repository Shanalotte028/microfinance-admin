<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    //
    public function show($client_id, $financial_id)
    {
        // Find the client or return 404 if not found
        $client = Client::with('financial_details')->findOrFail($client_id);

        // Find the specific compliance record or return 404 if not found
        $financial = $client->financial_details->find($financial_id);

        // If the compliance record is not found in the client's records, throw a 404
        if (!$financial) {
            abort(404);
        }

        return view('financial.show', compact('client', 'financial'));
    }
}
