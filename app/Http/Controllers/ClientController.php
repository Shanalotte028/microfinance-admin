<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();
        return view('admin/client.index', compact('clients'));
    }
    
    public function show(Client $client){
        return view('admin/client.show',['client'=> $client]);
    }

    public function edit(Client $client){
        return view('admin/client.edit', ['client'=>$client]);
    }

    public function destroy(Request $request, Client $client){
        $client->delete();

        return redirect()->route('admin.client.all')->with('success', 'Client deleted successfully!');
    }

    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'string|max:20|nullable',
            'birthday' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'client_type' => 'required|string|in:Individual,Business',
            'client_status' => 'required|string|in:Verified,Unverified',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
        ]);

        // Fetch the first address for the client
        $address = $client->addresses->first();
    
        // Update client data
        $client->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'birthday' => $validatedData['birthday'],
            'gender' => $validatedData['gender'],
            'client_type' => $validatedData['client_type'],
            'client_status' => $validatedData['client_status'],
        ]);
    
        // Update address data if it exists
        if ($address) {
            $address->update([
                'address_line_1' => $validatedData['address_line_1'],
                'address_line_2' => $validatedData['address_line_2'],
                'city' => $validatedData['city'],
                'province' => $validatedData['province'],
                'postal_code' => $validatedData['postal_code'],
            ]);
        }
    
        // Redirect back with success message
        return redirect()->route('admin.client.one', $client)->with('success', 'Client and Address updated successfully!');
    }
    

}
