<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::orderBy('updated_at', 'desc')->get();
        return view('admin/client.index', compact('clients'));
    }


    public function profile(){
        $client = Auth::guard('client')->user();
        return view('client/profile', compact('client'));
    }

    public function show(Client $client){
        return view('admin/client.show',['client'=> $client]);
    }

    public function edit(Client $client){
        return view('admin/client.edit', ['client'=>$client]);
    }

    /* public function update(Request $request, Client $client){
        $userAdmin = Auth::user();
        $oldData = $client->toArray();


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

        $newData = $client->toArray();

        AuditHelper::log('Update', 
        'Client Management',
        "User $userAdmin->id ($userAdmin->email) Updated account of Client ID number: $client->id ($client->email)",
        $oldData,  
        $newData);

    
        // Redirect back with success message
        return redirect()->route('admin.client.show', $client)->with('success', 'Client Information updated successfully!');
    } */

    /* public function destroy(Request $request, Client $client){
        $client->delete();

        return redirect()->route('admin.client.index')->with('success', 'Client deleted successfully!');
    } */
    
    /* public function profileUpdate(Request $request, Client $client){
        $userAdmin = Auth::user()->id;
        $oldData = $client->toArray();

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'string|max:20|nullable',
            'gender' => 'required|in:Male,Female,Other',
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
            'gender' => $validatedData['gender'],
            'client_status' => $validatedData['client_status'],
        ]);
    
        // Update address data if it exists
        $address = $client->addresses->first();

        if ($address) {
            $address->update([
                'address_line_1' => $validatedData['address_line_1'],
                'address_line_2' => $validatedData['address_line_2'],
                'city' => $validatedData['city'],
                'province' => $validatedData['province'],
                'postal_code' => $validatedData['postal_code'],
            ]);
        } else {
            // Optionally, you can create a new address if it doesn't exist
            $client->addresses()->create([
                'address_line_1' => $validatedData['address_line_1'],
                'address_line_2' => $validatedData['address_line_2'],
                'city' => $validatedData['city'],
                'province' => $validatedData['province'],
                'postal_code' => $validatedData['postal_code'],
            ]);
        }

        $newData = $client->toArray();
    
        
        // Redirect back with success message
        return back()->with('success', 'Profile updated successfully!');
    } */

    /*  public function toggleBlock(Client $client){
    $previousStatus = $client->blocked;
    $adminUser = Auth::user();
    // Toggle the blocked status between 'yes' and 'no'
    $client->blocked = ($client->blocked === 'Yes') ? 'No' : 'Yes';
    $newStatus = $client->blocked;
    $client->save();

    // Prepare a success message based on the new status
    $message = $client->blocked === 'Yes' ? 'Client has been blocked successfully.' : 'Client has been unblocked successfully.';
    
    //  Add Audit Log
    AuditHelper::log('Block',
        'Client Management',
        "User $adminUser->id ($adminUser->email) changed blocked status of client ID number: $client->id ($client->email)",
        $previousStatus, // ID of the affected client
        $newStatus,);

    return redirect()->back()->with('success', $message);
    } */
}
