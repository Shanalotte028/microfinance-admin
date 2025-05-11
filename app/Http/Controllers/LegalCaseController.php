<?php

namespace App\Http\Controllers;

use App\Exports\LegalCaseExport;
use App\Helpers\AuditHelper;
use App\Jobs\SendLegalCaseCreatedEmail;
use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class LegalCaseController extends Controller
{
    // Generate the compliance report
    public function generateLegalReport(Request $request){
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
            $title = "Legal Case Report for " . date('F', mktime(0, 0, 0, $month, 1)) . " $year";
        } else {
            // Yearly report
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
            $title = "Legal Case Report for $year";
        }

        // Prevent lazy loading
        $cases = LegalCase::with('client', 'assignedLawyer')
            ->whereBetween('filing_date', [$startDate, $endDate])
            ->get();

        return view('admin.legal_cases.legalCase_reports', compact('cases', 'title'));
    }


    public function exportCase(Request $request){
        $exportType = $request->input('export_type');
        $year = $request->input('year');
        
        if ($exportType === 'monthly') {
            $month = $request->input('month');
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->endOfMonth();
            $fileName = "legal_case_records_{$year}_{$month}.xlsx";
        } else {
            // Yearly export
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-01-01")->startOfYear();
            $endDate = Carbon::createFromFormat('Y-m-d', "$year-12-31")->endOfYear();
            $fileName = "legal_case_records_{$year}.xlsx";
        }

        return Excel::download(new LegalCaseExport($startDate, $endDate), $fileName);
    }

    // List all legal cases
    public function index(Request $request){
        $status = $request->query('status');
        $user = Auth::user();

        if ($user->role === 'Lawyer') {
            /** @var User $user */
            $cases = $user->assignedCases()
                ->with(['client', 'employee', 'assignedLawyer'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $cases = LegalCase::with(['client', 'employee', 'assignedLawyer'])
                ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin/legal_cases.index', compact('cases'));
    }


    // Show form to create a new legal case
    public function create(){

        $clients = Client::all();
        $employees = User::all();
        $lawyers = User::where('role', 'lawyer')->get(); // Assuming you have a 'role' column

        return view('admin/legal_cases.create', compact('clients', 'lawyers', 'employees'));
    }

    // Store a new legal case
    public function store(Request $request){
        $adminUser = Auth::user();
    
        $validated = $request->validate([
            'recipient_type' => 'required|in:client,employee',
            'client_id' => 'required_if:recipient_type,client|nullable|exists:clients,id',
            'employee_id' => 'required_if:recipient_type,employee|nullable|exists:users,id',
            'assigned_to' => 'required|exists:users,id',
            'case_number' => 'required|string|unique:legal_cases',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'filing_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after:filing_date',
        ]);
    
        DB::transaction(function () use ($validated, $adminUser) {
            // Find the assigned lawyer
            $assignedLawyer = User::find($validated['assigned_to']);
            // Ensure the assigned lawyer exists
            if (!$assignedLawyer) {
                throw new \Exception("Assigned lawyer not found.");
            }

            $recipientId = ($validated['recipient_type'] === 'client') 
            ? $validated['client_id'] 
            : $validated['employee_id'];
    
            // Create the legal case
            $legalCase = LegalCase::create([
                'client_id' => ($validated['recipient_type'] === 'client') ? $validated['client_id'] : null,
                'employee_id' => ($validated['recipient_type'] === 'employee') ? $validated['employee_id'] : null,
                'assigned_to' => $validated['assigned_to'],
                'case_number' => $validated['case_number'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'filing_date' => $validated['filing_date'],
                'closing_date' => $validated['closing_date'],
            ]);
    
            // Dispatch the job to send the legal case created email
            dispatch(new SendLegalCaseCreatedEmail($legalCase, $assignedLawyer->email));
    
            // Log the audit trail
            AuditHelper::log(
                'Create Legal Case',
                'Legal Management',
                "User $adminUser->id $adminUser->email ($adminUser->role) created a new legal case with case number: $legalCase->case_number",
                null, // ID of the affected client
                null
            );
        });
    
        return redirect()->route('admin.legal.index')->with('success', 'Legal case created successfully.');
    }

    // Show a specific legal case
    public function show($id){
        $case = LegalCase::with(['client', 'employee', 'assignedLawyer'])->findOrFail($id);
        return view('admin/legal_cases.show', compact('case'));
    }


    public function edit($id){
        $case = LegalCase::with(['client', 'employee', 'assignedLawyer'])->findOrFail($id);
        $clients = Client::all();
        $employees = User::all();
        $lawyers = User::where('role', 'lawyer')->get();
        
        return view('admin/legal_cases.edit', compact('case', 'clients', 'employees', 'lawyers'));
    }

    public function update(Request $request, $id){
        $adminUser = Auth::user();
        $case = LegalCase::findOrFail($id);
        $previousStatus = $case->toArray();

        $validated = $request->validate([
            'recipient_type' => 'required|in:client,employee',
            'client_id' => 'required_if:recipient_type,client|nullable|exists:clients,id',
            'employee_id' => 'required_if:recipient_type,employee|nullable|exists:users,id',
            'assigned_to' => 'required|exists:users,id',
            'case_number' => 'required|string|unique:legal_cases,case_number,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'filing_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after:filing_date',
        ]);

        // Clear the unused recipient ID
        try{
            $updateData = $validated;
            if ($validated['recipient_type'] === 'client') {
                $updateData['employee_id'] = null;
            } else {
                $updateData['client_id'] = null;
            }

            $case->update([
                'client_id' => ($validated['recipient_type'] === 'client') ? $validated['client_id'] : null,
                'employee_id' => ($validated['recipient_type'] === 'employee') ? $validated['employee_id'] : null,
                'assigned_to' => $validated['assigned_to'],
                'case_number' => $validated['case_number'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'filing_date' => $validated['filing_date'],
                'closing_date' => $validated['closing_date'],
            ]);

            AuditHelper::log(
                'Update',
                'Legal Management',
                "User $adminUser->id $adminUser->email $adminUser->role updated legal case #$case->case_number",
                $previousStatus,
                $case->toArray()
            );

            return redirect()->route('admin.legal.show', $case->id)
                ->with('success', 'Legal case updated successfully.');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Legal case edit failed: ' . $e->getMessage());
        }
        
    }

   /*  public function destroy($id){
        $case = LegalCase::findOrFail($id);
        $case->delete();
        return redirect()->route('legal-cases.index')->with('success', 'Legal case deleted successfully.');
    } */
}
