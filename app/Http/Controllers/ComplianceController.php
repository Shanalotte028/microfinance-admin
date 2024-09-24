<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{
    //
    public function index(Client $client){
        return view('admin/compliance.index', compact('client'));
    }

    public function show($client_id, $compliance_id)
    {
        // Find the client or return 404 if not found
        $client = Client::with('compliance_records')->findOrFail($client_id);

        // Find the specific compliance record or return 404 if not found
        $compliance = $client->compliance_records->find($compliance_id);

        // If the compliance record is not found in the client's records, throw a 404
        if (!$compliance) {
            abort(404);
        }

        return view('admin/compliance.show', compact('client', 'compliance'));
    }
}
