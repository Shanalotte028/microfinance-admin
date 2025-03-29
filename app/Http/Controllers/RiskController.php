<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RiskController extends Controller
{
    //
    public function store(Request $request, Client $client){
        // Fetch financial details
        $financial = $client->financial_details;
        if (!$financial) {
            return response()->json(['error' => 'Financial details not found'], 404);
        }

        // Fetch the latest loan record
        $loan = $financial->loans()->latest()->first();
        if (!$loan) {
            return response()->json(['error' => 'Loan details not found'], 404);
        }

        // Calculate derived values
        $age = Carbon::parse($client->birthday)->age;
        $monthlyDebtPayments = round(($loan->principal_amount * ($loan->interest_rate / 1200)) / (1 - pow(1 + $loan->interest_rate / 1200, -$loan->loan_term)), 2);
        $debtToIncomeRatio = $monthlyDebtPayments / ($financial->annual_income / 12);
        $totalDebtToIncomeRatio = ($monthlyDebtPayments + $financial->monthly_expenses) / ($financial->annual_income / 12);

        // Prepare data for API request
        $payload = [
            'ApplicationDate' => $loan->submitted_at,
            'Age' => $age,
            'EducationLevel' => $client->education_level,
            'MaritalStatus' => $client->marital_status,
            'NumberOfDependents' => $client->number_of_dependents,
            'HomeOwnershipStatus' => $client->ownership_status,
            'CreditScore' => $financial->credit_score,
            'NumberOfCreditInquiries' => $financial->loans()->count(),
            'LoanPurpose' => $loan->loan_description,
            'PreviousLoanDefaults' => $financial->loan_defaults,
            'PreviousLatePayments' => $financial->late_payments,
            'Experience' => $client->work_duration,
            'JobTenure' => $client->job_tenure,
            'EmploymentStatus' => $client->source_of_income,
            'AnnualIncome' => $financial->annual_income,
            'MonthlyIncome' => $financial->monthly_income,
            'MonthlyExpenses' => $financial->monthly_expenses,
            'LoanAmount' => $loan->principal_amount,
            'LoanDuration' => $loan->loan_term,
            'InterestRate' => $loan->interest_rate,
            'MonthlyDebtPayments' => $monthlyDebtPayments,
            'DebtToIncomeRatio' => $debtToIncomeRatio,
            'TotalDebtToIncomeRatio' => $totalDebtToIncomeRatio,
            'SavingsAccountBalance' => 6000,
            'CheckingAccountBalance' => 2000,
            'TotalAssets' => 13000,
            'Networth' => 14000,
        ];

        // Send API request
        $response = Http::post('https://risk-assessment-5d9n.onrender.com/predict', $payload);

        // Check if the response is successful
        if ($response->failed()) {
            return response()->json(['error' => 'Failed to get risk assessment'], 500);
        }
        
        // Extract the prediction and probability
        $prediction = $response->json('prediction');
        $probability = $response->json('probability') * 100;

        // Save the risk assessment
        $client->risk_assessments()->create([
            'risk_level' => $prediction,
            'confidence_level' => $probability,
            'assessment_date' => Carbon::now(),
        ]);

        /* return response()->json([
            'message' => 'Risk assessment completed successfully',
            'risk_level' => $prediction,
            'confidence_level' => $probability,
        ]); */

        return response()->json([
            'success' => true,
            'message' => "Risk assessment completed successfully. \n Risk Level: $prediction \n Confidence Level: $probability"
        ]);
        
    }

    public function index(Client $client){
        return view('admin/risk.index', compact('client'));
    }

    public function show(Client $client, $risk_id){
        // Find the specific risk record for this client or return 404
        $risk = $client->risk_assessments()->where('id', $risk_id)->firstOrFail();

        return view('admin/risk.show', compact('client', 'risk'));
    }

    public function recommendation(Request $request, Client $client, $risk_id){
        $adminUser = Auth::user();

        // Find the specific risk record for this client or return 404
        $risk = $client->risk_assessments()->where('id', $risk_id)->firstOrFail();

        $previousStatus = $risk->toArray();

        $validatedData = $request->validate([
            'recommendation' => 'required|string'
        ]);
        
        // Update the recommendation field
        $risk->update([
            'recommendation' => $validatedData['recommendation']
        ]);

        $newStatus = $risk->toArray();

        AuditHelper::log(
            'Update',
            'Risk Management',
            "User $adminUser->id $adminUser->email ($adminUser->role) Update the recommendation for (Risk Assessment ID: $risk_id)",
            $previousStatus, // Old status
            $newStatus // New status
        );

        return redirect()->back()->with('success', 'Recommendation updated successfully!');
    }

    public function risks(Request $request){
        $status = $request->query('status');

        // Fetch all clients with their compliance records
        $clients = Client::with(['risk_assessments' => function ($query) use ($status) {
            if ($status) {
                $query->where('risk_level', $status);
            }
        }])->get();

        return view('admin/risk.risks', compact('clients'));
    }
}
