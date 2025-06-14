<?php

namespace App\Http\Controllers;

use App\Exports\ContractExport;
use App\Helpers\AuditHelper;
use App\Jobs\SendContractSigningMail;
use App\Mail\ContractsSigningMail;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\User;
use App\Notifications\ContractSignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Nullable;

class ContractController extends Controller
{
    public function showContractReportForm()
    {
        return view('admin.contracts.contract_report_form');
    }

    public function generateContractReport(Request $request)
    {
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
            $title = "Contract Report for " . date('F', mktime(0, 0, 0, $month, 1)) . " $year";
        } else {
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
            $title = "Contract Report for $year";
        }

        $records = Contract::with(['client', 'user', 'template','createdBy'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('admin.contracts.contract_reports', compact('records', 'title'));
    }

    public function exportContract(Request $request)
    {
        $request->validate([
            'export_type' => 'required|in:monthly,yearly',
            'year' => 'required|digits:4',
            'month' => 'nullable|digits_between:1,12',
        ]);

        $year = $request->input('year');
        $exportType = $request->input('export_type');

        if ($exportType === 'monthly') {
            $month = $request->input('month');
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->endOfMonth();
            $fileName = "contract_records_{$year}_{$month}.xlsx";
        } else {
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-01-01")->startOfYear();
            $endDate = Carbon::createFromFormat('Y-m-d', "$year-12-31")->endOfYear();
            $fileName = "contract_records_{$year}.xlsx";
        }

        return Excel::download(new ContractExport($startDate, $endDate), $fileName);
    }


    public function index()
    {
        $contracts = Contract::with('client', 'user', 'template')->get(); // eager load client to avoid N+1 problem
        return view('admin/contracts.index', compact('contracts'));
    }
    public function show(Contract $contract)
    {
        return view('admin/contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        return view('admin.contracts.edit', compact('contract'));
    }

    public function update(Request $request, Contract $contract)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'auto_renew' => 'boolean',
        ];

        if ($contract->status === 'draft') {
            $rules['start_date'] = 'required|date|after_or_equal:today';
            $rules['end_date'] = 'required|date|after:start_date';
            $rules['terms'] = 'required|json'; // Ensure valid JSON
        } elseif ($contract->status === 'active') {
            $rules['end_date'] = 'required|date|after:today';
        }

        $validated = $request->validate($rules);

        try {
            DB::transaction(function () use ($contract, $validated) {
                if ($contract->status === 'draft') {
                    // Handle terms - decode if it's a string
                    $terms = $validated['terms'];

                    if (is_string($terms)) {
                        $terms = json_decode($terms, true);

                        // Validate JSON decoding
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new \Exception('Invalid terms format');
                        }
                    }

                    // Process content
                    $content = $contract->template->content;
                    foreach ($terms as $key => $value) {
                        $content = str_replace("{{$key}}", $value, $content);
                    }

                    $contract->update([
                        'content' => $content,
                        'terms' => $terms // Store as array
                    ]);
                }

                $contract->update($validated);
                $authUser = Auth::user();
                AuditHelper::log(
                    'Contract Updated',
                    'Contract Management',
                    "User $authUser->id $authUser->email ($authUser->role) updated a contract for Client ID: $contract->client_id",
                    null,
                    $contract->toArray()
                );
            });

            return redirect()->route('admin.contracts.show', $contract->id)
                ->with('success', 'Contract updated successfully');
        } catch (\Exception $e) {
            Log::error("Contract update failed: {$e->getMessage()}");
            return back()->withInput()->with('error', 'Failed to update contract: ' . $e->getMessage());
        }
    }

    public function storeAmendment(Request $request, Contract $contract)
    {
        abort_if($contract->status !== 'active', 403);

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
            'new_terms' => 'required|json',
            'effective_date' => 'required|date|after_or_equal:today',
        ]);

        try {
            $amendment = $contract->amendments()->create([
                'old_terms' => $contract->terms,
                'new_terms' => json_decode($validated['new_terms'], true),
                'reason' => $validated['reason'],
                'effective_date' => $validated['effective_date'],
                'requested_by' => Auth::user()->id,
            ]);

            // Notify approvers
            // Notification::send($approvers, new ContractAmendmentRequested($amendment));

            return redirect()->route('admin.contracts.show', $contract->id)
                ->with('success', 'Amendment request submitted for approval');
        } catch (\Exception $e) {
            Log::error("Amendment creation failed: {$e->getMessage()}");
            return back()->withInput()->with('error', 'Failed to request amendment');
        }
    }
    //
    public function create()
    {
        return view('admin.contracts.create', [
            'clients' => Client::all(),
            'users'=> User::all(),
            'templates' => ContractTemplate::all()
        ]);
    }

    public function store(Request $request)
    {
        
        
        $authUser = Auth::user();
    
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'compliance_record_id' => 'nullable|exist:compliance,id',
            'template_id' => 'required|exists:contract_templates,id',
            'title' => 'required|string|max:255',
            'terms' => 'required|array',
            /* 'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'auto_renew' => 'nullable|boolean',
            'description' => 'nullable|string', */
        ]);

        try {
            DB::beginTransaction();

            // Get template and process content
            $template = ContractTemplate::findOrFail($validated['template_id']);
            $content = $template->content;

            $content = str_replace('@{{', '{{', $content); // remove '@'
            foreach ($validated['terms'] as $key => $value) {
                $content = preg_replace('/\{\{\s*' . preg_quote($key) . '\s*\}\}/', $value, $content);
            }

            // Create contract with signing fields
            $contractData = [
                'template_id' => $validated['template_id'],
                'title' => $validated['title'],
                'content' => $content,
                'terms' => $validated['terms'],
                'status' => 'pending_signature', // Set initial status
                'created_by' => Auth::user()->id,
                'signing_token' => Str()->random(40),
                'signing_expires_at' => now()->addDays(3), // Set expiry here
                'signing_sent_at' => now(),
                /* 'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'auto_renew' => $validated['auto_renew'] ?? false,
                'description' => $validated['description'], */
            ];

              // Set either client_id or user_id based on template type
                if ($template->slug === 'loan-agreement') {
                    $contractData['client_id'] = $validated['client_id'];
                } elseif ($template->slug === 'employment-agreement') {
                    $contractData['user_id'] = $validated['user_id'];
                }

            /* dd($contractData); */

            $contract = Contract::create($contractData)->load(['client', 'user']);

            AuditHelper::log(
                'Contract Created',
                'Contract Management',
                "User $authUser->id $authUser->email ($authUser->role) Created a contract",
                null,
                $contract->toArray()
            );
            
            DB::commit();

            // Send signing email
            dispatch(new SendContractSigningMail($contract));

            return redirect()->route('admin.contracts.index')
                ->with('success', 'Contract created and signing request sent!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Contract creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function showSigningPage(Contract $contract, Request $request)
    {
        if ($contract->party_signed_at) {
            return view('admin/contracts.already-signed', compact('contract'));
        }

        return view('admin/contracts.sign', [
            'contract' => $contract,
            'token' => $request->token
        ]);
    }

    public function processSignature(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'signature_data' => 'required|regex:/^data:image\/svg\+xml;base64,.+/',
            'token' => 'required'
        ]);

        $contract->update([
            'status' => 'active',
            'signature_data' => $validated['signature_data'],
            'party_signed_at' => now(),
            'signer_ip' => $request->ip(),
            'signer_user_agent' => $request->userAgent(),
            'signing_token' => null, // Invalidate token
        ]);

        $contract->createdBy->notify(new ContractSignedNotification($contract));

        // Generate signed PDF
        /* $pdf = PDF::loadView('admin/contracts.signed-pdf', [
        'contract' => $contract
    ]);

    return response()->streamDownload(
        fn () => print($pdf->output()),
        "contract-{$contract->id}-signed.pdf"
    ); */

        return redirect()->back();
    }

    public function download(Contract $contract)
    {
        $pdf = PDF::loadView('admin/contracts.signed-pdf', [
            'contract' => $contract
        ]);

        return $pdf->download("contract-{$contract->id}.pdf");
    }

    public function createContractForClient(Client $client, $user)
    {
        $loan = optional(optional($client->financial_details)->loans()->latest('submitted_at')->first());


        if (!$loan) {
            throw new \Exception('No loan found for contract generation.');
        }

        $template = ContractTemplate::where('slug', 'loan-agreement')->firstOrFail(); // or by ID

        $terms = [
            'client_name' => $client->full_name ?? "{$client->first_name} {$client->last_name}",
            'submitted_at' => Carbon::parse($loan->submitted_at)->format('F j, Y'),
            'principal_amount' => number_format($loan->principal_amount, 2),
            'interest_rate' => $loan->interest_rate,
            'loan_term' => $loan->loan_term,
            'term_type' => ucfirst($loan->term_type),
            'payment_frequency_method' => ucfirst($loan->payment_frequency_method),
            'installment' => number_format($loan->installment, 2),
            'end_date' => $loan->end_date ? Carbon::parse($loan->end_date)->format('F j, Y') : 'N/A',
            'loan_description' => $loan->loan_description ?? 'N/A',
        ];

        $content = $template->content;
        $content = str_replace('@{{', '{{', $content); // remove '@'
        foreach ($terms as $key => $value) {
            $content = preg_replace('/\{\{\s*' . preg_quote($key) . '\s*\}\}/', $value, $content);
        }

        $contract = Contract::create([
            'client_id' => $client->id,
            'template_id' => $template->id,
            'title' => "Loan Agreement for {$terms['client_name']}",
            'content' => $content,
            'terms' => $terms,
            'status' => 'pending_signature',
            'start_date' => $terms['submitted_at'],
            'end_date' => $terms['end_date'],
            'auto_renew' => false,
            'description' => $loan->loan_description,
            'created_by' => Auth::id(),
            'signing_token' => Str()->random(40),
            'signing_expires_at' => now()->addDays(3),
            'signing_sent_at' => now(),
        ]);

        AuditHelper::log(
            'Contract Created',
            'Contract Management',
            "User $user->id $user->email ($user->role) Created a contract for Client ID: $contract->client_id",
            null,
            $contract->toArray()
        );



        dispatch(new SendContractSigningMail($contract));
    }




    /* public function sendForSignature(Contract $contract){
        // Integrate with DocuSign API
        $signatureLink = DocusignService::sendContract($contract);
        $contract->update(['status' => 'pending_signature']);
        
        return redirect()->back()->with('success', 'Contract sent for signing!');
    } */
}
