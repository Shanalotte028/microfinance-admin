<?php

namespace App\Http\Controllers;

use App\Models\Compliance;
use App\Models\Financial;
use App\Models\LegalCase;
use App\Models\Loan;
use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        $user = Auth::user();
        $assignedCases = $user->legalCases->count();
        // Fetch total pending loans (assuming you have a status field for loans)
        $openCase = LegalCase::where('status', 'open')->count();
        $pendingCompliance = Compliance::where('document_status', 'pending')->count();
        
        $approvedLoans = Loan::where('loan_status', 'approved')->count();
        $rejectedLoans = Loan::where('loan_status', 'rejected')->count();

        $riskTrends = Risk::selectRaw("
            DATE_FORMAT(assessment_date, '%Y-%m') as month,
            SUM(CASE WHEN risk_level = 'Low Risk' THEN 1 ELSE 0 END) as low_risk,
            SUM(CASE WHEN risk_level = 'Medium Risk' THEN 1 ELSE 0 END) as medium_risk,
            SUM(CASE WHEN risk_level = 'High Risk' THEN 1 ELSE 0 END) as high_risk
        ")
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();


        // Fetch financial details
        $financialStats = Financial::selectRaw("
            SUM(late_payments) as total_late_payments,
            SUM(loan_defaults) as total_loan_defaults
        ")->first();

        // Risk vs Credit Score (for Scatter Plot)
        $riskData = Financial::join('risk_assessments', 'financial_details.client_id', '=', 'risk_assessments.client_id')
        ->select('financial_details.credit_score', 'risk_assessments.risk_level')
        ->get();

        // High-Risk Clients
        $highRiskClients = Risk::where('risk_level', 'High Risk')->take(5)->get();

        return view('admin/dashboard', compact('openCase', 'pendingCompliance', 'assignedCases', 'approvedLoans', 
        'rejectedLoans', 'riskTrends', 'financialStats', 'riskData', 'highRiskClients'));
    }
}
