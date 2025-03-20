<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    //
    public function show(Client $client, $financial_id){
        // Find the specific financial record for this client or return 404
        $financial = $client->financial_details()->where('id', $financial_id)->firstOrFail();

        return view('admin/financial.show', compact('client', 'financial'));
    }

}
