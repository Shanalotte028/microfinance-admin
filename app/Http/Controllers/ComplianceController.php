<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use App\Models\Compliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;

class ComplianceController extends Controller
{
    //

    public function compliance_records(){
        $client = Auth::guard('client')->user();
        $compliances = Compliance::where('client_id', $client->id)->get();
        return view('client/compliance',compact('compliances'));
    }

    public function create(){
        return view('client/create');
    }
    public function kyc(Request $request){
        //dd($request->all());
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^09[0-9]{9}$/|min:11|unique:clients,phone_number', // Phone number must start with 09
            'birthday' => 'required|date|before:today',
            'gender' => 'required|string|in:Male,Female,Other',
            'nationality' => 'required|string',
            'marital_status' => 'required|string',
            'identification_proof' => 'required|string',
            'identification_proof_upload' => ['required', File::types(['png','jpg','pdf'])],
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
            'address_proof' => 'required|string', 
            'address_proof_upload' => ['required', File::types(['png','jpg','pdf'])],
            'source_of_income' => 'required|string',
            'tin_number' => 'required|string|min:9|max:12', // TIN number must be numeric
            'income_proof' => 'required|string',
            'income_proof_upload' => ['required', File::types(['png','jpg','pdf'])],
            'clientConsent' => 'required'
        ]);

        $client = Auth::guard('client')->user();

        if (!$client || !($client instanceof Client)) {
            return redirect()->route('login')->withErrors('You must be logged in to update your information.');
        }

        // Save the personal information to the Client model
        $client->fill([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'phone_number' => $validatedData['phone_number'],
            'birthday' => $validatedData['birthday'],
            'gender' => ucfirst($validatedData['gender']), // Capitalize the first letter of gender
            'nationality' => $validatedData['nationality'],
            'marital_status' => $validatedData['marital_status'],
            'tin_number' => $validatedData['tin_number'], // Save TIN number to Client model
            'source_of_income' => $validatedData['source_of_income'], // Save Source of Income to Client model
        ])->save();

        // Save the address to the Address model
        Address::create([
            'client_id' => $client->id, // Associate address with client
            'address_line_1' => $validatedData['address_line_1'],
            'address_line_2' => $validatedData['address_line_2'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
            'postal_code' => $validatedData['postal_code'],
        ]);

    // Handle file uploads for compliance records
        $identificationProofPath = $request->file('identification_proof_upload')->store('documents/identifications');
        $addressProofPath = $request->file('address_proof_upload')->store('documents/address_proofs');
        $incomeProofPath = $request->file('income_proof_upload')->store('documents/income_proofs');

        // Create compliance records for each document
        Compliance::create([
            'client_id' => $client->id,
            'compliance_type' => 'KYC',
            'document_type' => $validatedData['identification_proof'],
            'document_path' => $identificationProofPath,
            'document_status' => 'pending',
            'submission_date' => now()
        ]);

        Compliance::create([
            'client_id' => $client->id,
            'compliance_type' => 'KYC',
            'document_type' => $validatedData['address_proof'],
            'document_path' => $addressProofPath,
            'document_status' => 'pending',
            'submission_date' => now()
        ]);

        Compliance::create([
            'client_id' => $client->id,
            'compliance_type' => 'KYC',
            'document_type' => $validatedData['income_proof'],
            'document_path' => $incomeProofPath,
            'document_status' => 'pending',
            'submission_date' => now()
        ]);

        return redirect()->route('client.compliance.compliance_records')->with('success', 'Client and compliance records saved successfully.');
    }


    // Compliance Sidebar
    public function compliance(){
        $compliances = Compliance::with('client:id,email')
                    ->select('id', 'client_id','document_type', 'document_status', 'submission_date', 'approval_date')               
                    ->get();

        return view('admin/compliance.showall', compact('compliances'));
    }

    public function index(Client $client){
        return view('admin/compliance.index', compact('client'));
    }

    public function show($client_id, $compliance_id)
    {
        // Find the client or return 404 if not found
        $client = Client::with('compliance_records')->findOrFail($client_id);
    
        // Find the specific compliance record or return 404 if not found
        $compliance = $client->compliance_records()->find($compliance_id); // Use ->() to ensure it's treated as a query builder
    
        // If the compliance record is not found in the client's records, throw a 404
        if (!$compliance) {
            abort(404);
        }
    
        return view('admin/compliance.show', compact('client', 'compliance'));
    }
}
