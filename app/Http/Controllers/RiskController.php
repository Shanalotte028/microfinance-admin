<?php

namespace App\Http\Controllers;

use App\Exports\RiskExport;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Risk;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class RiskController extends Controller
{

    public function generateRiskReport(Request $request){
        $request->validate([
            'report_type' => 'required|in:monthly,yearly',
            'year' => 'required|digits:4',
            'month' => 'nullable|digits_between:1,12',
        ]);

        $year = $request->input('year');
        $reportType = $request->input('report_type');

        if ($reportType === 'monthly') {
            $month = $request->input('month');
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
            $title = "Risk Assessment Report for " . date('F', mktime(0, 0, 0, $month, 1)) . " $year";
        } else {
            // Yearly report
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
            $title = "Risk Assessment Report for $year";
        }

        // Prevent lazy loading
        $risks = Risk::with('client')
            ->whereBetween('assessment_date', [$startDate, $endDate])
            ->get();

        return view('admin.risk.risk_reports', compact('risks', 'title'));
    }

    public function exportRisk(Request $request){
        $exportType = $request->input('export_type');
        $year = $request->input('year');
        
        if ($exportType === 'monthly') {
            $month = $request->input('month');
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->endOfMonth();
            $fileName = "risk_case_records_{$year}_{$month}.xlsx";
        } else {
            // Yearly export
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-01-01")->startOfYear();
            $endDate = Carbon::createFromFormat('Y-m-d', "$year-12-31")->endOfYear();
            $fileName = "risk_case_records_{$year}.xlsx";
        }

        return Excel::download(new RiskExport($startDate, $endDate), $fileName);
    }

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

        // Fetch all clients with their risk assessments, ordered by latest first
        $clients = Client::with(['risk_assessments' => function ($query) use ($status) {
            if ($status) {
                $query->where('risk_level', $status);
            }
            $query->orderBy('assessment_date', 'desc'); // Order by latest first
        }])->get();

        return view('admin/risk.risks', compact('clients'));
    }
}
