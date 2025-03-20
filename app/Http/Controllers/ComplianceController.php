<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use App\Jobs\SendClientVerifiedEmail;
use App\Jobs\SendComplianceApprovedEmail;
use App\Jobs\SendComplianceRejectedEmail;
use App\Mail\KycConfirmationEmail;
use App\Models\Address;
use App\Models\Client;
use App\Models\Compliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\DB;

class ComplianceController extends Controller
{
    //

    public function compliance_records(){
        $client = Auth::guard('client')->user();
        $compliances = Compliance::where('client_id', $client->id)->get();
        return view('client/compliance',compact('compliances'));
    }

    public function create(){
        $client = Auth::guard('client')->user();

        // Check if the user already has a pending or approved KYC request
        $kycCount = Compliance::where('client_id', $client->id)->where('compliance_type', 'KYC')->count();

        if ($kycCount >= 3) {
            return redirect()->back()->with('success', 'You have already applied for KYC documents.');
        }
        // Show the KYC application form
        return view('client/create', compact('client'));
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
        $identificationProofPath = $request->file('identification_proof_upload')->store('documents/identifications', 'public');
        $addressProofPath = $request->file('address_proof_upload')->store('documents/address_proofs', 'public');
        $incomeProofPath = $request->file('income_proof_upload')->store('documents/income_proofs', 'public');
        Log::info('Document Path:', ['path' => $identificationProofPath]);
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

        // Prepare the email data
        $documentTypes = [
            'identification_proof' => $validatedData['identification_proof'],
            'address_proof' => $validatedData['address_proof'],
            'income_proof' => $validatedData['income_proof'],
        ];

    // Send the KYC confirmation email
        Mail::to($client->email)->send(new KycConfirmationEmail($client, $documentTypes));

        return redirect()->route('client.compliance.compliance_records')->with('success', 'Client and compliance records saved successfully.');
    }

        public function approve(Client $client, Compliance $compliance)
    {
        try {
            DB::transaction(function () use ($client, $compliance) {
                $userAdmin = Auth::user();
    
                $compliance->update([
                    'document_status' => 'approved',
                    'approval_date' => now(),
                ]);
    
                dispatch(new SendComplianceApprovedEmail($client, $compliance));
    
                $approvedKycCount = Compliance::where('client_id', $client->id)
                    ->where('compliance_type', 'KYC')
                    ->where('document_status', 'approved')
                    ->count();
    
                if ($approvedKycCount >= 3) {
                    $client->update(['client_status' => 'Verified']);
                    dispatch(new SendClientVerifiedEmail($client));
                }
    
                AuditHelper::log('Approve Compliance', 'Compliance Management', 
                "User $userAdmin->id ($userAdmin->email) approved $compliance->document_type of Client ID: $client->id ($client->first_name $client->last_name)");
    
            });
    
            return redirect()->route('admin.compliance.index', ['client' => $client->id])->with('success', 'Compliance document approved successfully.');
        } catch (\Exception $e) {
            Log::error('Compliance Approval Failed', ['error' => $e->getMessage()]);
    
            return redirect()->back()->with('error', 'Failed to approve the compliance document. Please try again.');
        }
    }

    public function reject(Client $client, Compliance $compliance, Request $request)
    {
        try {
            DB::transaction(function () use ($client, $compliance, $request) {
                $userAdmin = Auth::user();
    
                $request->validate([
                    'remarks' => 'nullable|string|max:255',
                ]);
    
                $compliance->update([
                    'document_status' => 'rejected',
                    'remarks' => $request->remarks,
                ]);
    
                dispatch(new SendComplianceRejectedEmail($client, $compliance, $request->remarks));
    
                AuditHelper::log('Reject Compliance', 'Compliance Management', 
                "User $userAdmin->id ($userAdmin->email) rejected $compliance->document_type of Client ID: $client->id ($client->first_name $client->last_name)");
            });
    
            return redirect()->route('admin.compliance.index', ['client' => $client->id])->with('success', 'Compliance document rejected successfully.');
        } catch (\Exception $e) {
            Log::error('Compliance Rejection Failed', ['error' => $e->getMessage()]);
    
            return redirect()->back()->with('error', 'Failed to reject the compliance document. Please try again.');
        }
    }

    public function store(Request $request, Client $client)
{
    Log::info('Request received:', $request->all());

    try {
        // Validate the request data
        $validatedData = $this->validateRequest($request);

        // Determine the HTTP method
        $method = $request->method();

        // Process and store data
        DB::transaction(function () use ($validatedData, $method, $client) {
            // Find or create the client based on the HTTP method
            if ($method === 'POST') {
                // Create a new client
                $client = $this->createOrUpdateClient($validatedData['client']);
            } else if ($method === 'PATCH' || $method === 'PUT') {
                // Update an existing client
                /* $client = Client::findOrFail($client); */
                $client = $this->createOrUpdateClient($validatedData['client'], $client);
            } else {
                throw new \Exception('Unsupported HTTP method');
            }

            // Process address, financial details, loan, and compliance documents
            $this->createOrUpdateAddress($client, $validatedData['address']);
            $this->createOrUpdateFinancialDetails($client, $validatedData['financial']);
            $this->createLoan($client, $validatedData['loan']);
            /* $this->handleComplianceDocuments($client, $validatedData['compliance']); */
        });

        return response()->json(['client' =>$client, 'message' => 'Client data processed successfully'], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error in store method:', ['error' => $e->errors()]);
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Error in store method:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'An unexpected error occurred'], 500);
    }
}

    /**
     * Validate the request data.
     */
    private function validateRequest(Request $request): array
    {
        return [
            'client' => $request->validate([
                'client_id' => 'required|integer',
                'fname' => 'required|string',
                'lname' => 'required|string',
                'month' => 'required|string',
                'day' => 'required|integer',
                'year' => 'required|integer',
                'email' => 'required|email',
                'mobilenum' => 'required|string',
                'place_of_birth' => 'required|string',
                'gender' => 'required|string',
                'civil_status' => 'required|string',
                'primary_source' => 'required|string',
                'number_of_dependents' => 'required|integer',
                'job_temporary' => 'required|string',
                'education_level' => 'required|string',
                'ownership_status' => 'required|string',
                'work_duration' => 'required|integer',
                'job_tenure' => 'required|integer',
            ]),
            'address' => $request->validate([
                'region' => 'required|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'barangay' => 'required|string',
                'permanent_street' => 'required|string',
                'postal_code' => 'required|string',
                'same_address' => 'required|string|in:Yes,No',
                'present_region' => 'required_if:same_address,No|string|nullable',
                'present_province' => 'required_if:same_address,No|string|nullable',
                'present_city' => 'required_if:same_address,No|string|nullable',
                'present_barangay' => 'required_if:same_address,No|string|nullable',
                'present_street' => 'required_if:same_address,No|string|nullable',
                'present_postal_code' => 'required_if:same_address,No|string|nullable',
            ]),
            'financial' => $request->validate([
                'late_payments' => 'required|integer',
                'number_of_default' => 'required|integer',
                'number_of_payments' => 'required|integer',
                'monthly_income' => 'required|numeric',
                'monthly_expense' => 'required|numeric',
                'savings_account_balance' => 'required|numeric',
                'checking_account_balance' => 'required|numeric',
                'total_assets' => 'required|numeric',
                'networth' => 'required|numeric',
                'acc_credit_score' => 'required|integer',
            ]),
            'loan' => $request->validate([
                'submitted_at' => 'required|date',
                'term_type' => 'required|string',
                'loan_term' => 'required|integer',
                'payment_frequency_method' => 'required|string',
                'principal_amount' => 'required|numeric',
                'installment' => 'required|numeric',
                'loan_description' => 'required|string',
                'interest_rate' => 'required|numeric',
                'loan_status' => 'required|string',
            ]),
            /* 'compliance' => $request->validate([
                'documents' => ['required', 'file', 'mimes:pdf'],
                'id_front' => ['required', 'file', 'mimes:png,jpg,pdf'],
                'id_back' => ['required', 'file', 'mimes:png,jpg,pdf'],
                'selfie_with_id' => ['required', 'file', 'mimes:png,jpg,pdf'],
            ]), */
        ];
    }

    /**
     * Create or update a client.
     */
    private function createOrUpdateClient(array $data): Client
    {
        $birthday = sprintf('%04d-%02d-%02d', $data['year'], $data['month'], $data['day']);

        return Client::updateOrCreate(
            ['client_id' => $data['client_id']],
            [
                'first_name' => $data['fname'],
                'last_name' => $data['lname'],
                'email' => $data['email'],
                'phone_number' => $data['mobilenum'],
                'birthday' => $birthday,
                'place_of_birth' => $data['place_of_birth'],
                'gender' => $data['gender'],
                'marital_status' => $data['civil_status'],
                'source_of_income' => $data['primary_source'],
                'number_of_dependents' => $data['number_of_dependents'],
                'employment_status' => $data['job_temporary'],
                'education_level' => $data['education_level'],
                'ownership_status' => $data['ownership_status'],
                'work_duration' => $data['work_duration'],
                'job_tenure' => $data['job_tenure'],
            ]
        );
    }

    /**
     * Create or update the client's address.
     */
    private function createOrUpdateAddress(Client $client, array $data): void
    {
        $processedAddress = $this->processAddress($data);
        $client->address()->updateOrCreate([], $processedAddress);
    }

    /**
     * Create or update the client's financial details.
     */
    private function createOrUpdateFinancialDetails(Client $client, array $data): void
    {
        $annualIncome = $data['monthly_income'] * 12;
        $client->financial_details()->updateOrCreate(
            [],
            [
                'total_loan_amount_borrowed' => $data['total_loan_amount_borrowed'] ?? null,
                'late_payments' => $data['late_payments'],
                'loan_defaults' => $data['number_of_default'],
                'number_of_payments' => $data['number_of_payments'],
                'annual_income' => $annualIncome,
                'monthly_income' => $data['monthly_income'],
                'monthly_expenses' => $data['monthly_expense'],
                'savings_account_balance' => $data['savings_account_balance'],
                'checking_account_balance' => $data['checking_account_balance'],
                'total_assets' => $data['total_assets'],
                'networth' => $data['networth'],
                'credit_score' => $data['acc_credit_score'],
            ]
        );
    }

    /**
     * Create or update the client's loan.
     */
        private function createLoan(Client $client, array $data): void
    {
        Log::info('Creating loan:', $data);
        // Find or create the financial detail for the client
        $financialDetail = $client->financial_details()->firstOrCreate([]);

        $loan = $financialDetail->loans()->create([
            'submitted_at' => $data['submitted_at'],
            'term_type' => $data['term_type'],
            'loan_term' => $data['loan_term'],
            'payment_frequency_method' => $data['payment_frequency_method'],
            'principal_amount' => $data['principal_amount'],
            'installment' => $data['installment'],
            'loan_description' => $data['loan_description'],
            'interest_rate' => $data['interest_rate'],
            'loan_status' => $data['loan_status'],
        ]);

        Log::info('Loan created:', $loan->toArray());
    }

    /**
     * Handle compliance documents.
     */
    private function handleComplianceDocuments(Client $client, array $files): void
    {
        foreach ($files as $type => $file) {
            $path = $file->store("documents/{$type}", 'public');
            Compliance::create([
                'client_id' => $client->client_id,
                'compliance_type' => 'KYC',
                'document_type' => $type,
                'document_path' => $path,
                'document_status' => 'pending',
                'submission_date' => now(),
            ]);
        }
    }

    /**
     * Process address data.
     */
    private function processAddress(array $addressData): array
    {
        if ($addressData['same_address'] === 'Yes') {
            $addressData['present_region'] = $addressData['region'];
            $addressData['present_province'] = $addressData['province'];
            $addressData['present_city'] = $addressData['city'];
            $addressData['present_barangay'] = $addressData['barangay'];
            $addressData['present_street'] = $addressData['permanent_street'];
            $addressData['present_postal_code'] = $addressData['postal_code'];
        }
        return $addressData;
    }
    


    // Compliance Sidebar
    public function compliance(Request $request){
        // Get the status from the request (if provided)
        $status = $request->query('status');

        $compliances = Compliance::with('client:id,email') // Load only needed fields
        ->select(['id', 'client_id', 'compliance_type', 'document_type', 'document_status', 'submission_date', 'approval_date'])
        ->when($status, function ($query, $status) { // Apply status filter only when provided
            return $query->where('document_status', $status);
        })
        ->get();

        return view('admin/compliance.showall', compact('compliances'));
    }

    public function index(Client $client){
        return view('admin/compliance.index', compact('client'));
    }

    public function show($client_id, $compliance_id){
        $client = Client::with(['compliance_records' => function ($query) use ($compliance_id) {
            $query->where('id', $compliance_id); // Filter by compliance ID
        }])->findOrFail($client_id);
    
        $compliance = $client->compliance_records->first(); // Get the filtered record

        // If the compliance record is not found in the client's records, throw a 404
        return view('admin/compliance.show', compact('client', 'compliance'));
    }
}
