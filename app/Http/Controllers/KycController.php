<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function show(Client $client, $compliance_id, $kyc_id)
    {
        // Retrieve the specific compliance record for the client
        $compliance = $client->compliance_records->find($compliance_id);

        // If the compliance record is not found in the client's records, throw a 404
        if (!$compliance) {
            abort(404, 'Compliance record not found.');
        }

        // Find the specific KYC record related to this compliance record
        $kyc = $compliance->kyc_records->find($kyc_id);

        // If the KYC record is not found, throw a 404
        if (!$kyc) {
            abort(404, 'KYC record not found.');
        }

        // Pass the client, compliance, and KYC record to the view
        return view('kyc.show', compact('client', 'compliance', 'kyc'));
    }
}
