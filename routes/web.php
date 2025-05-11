<?php

use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\UserRegistrationController;
use App\Http\Controllers\ClientAuth\ClientForgotPasswordController;
use App\Http\Controllers\ClientAuth\ClientResetPasswordController;
use App\Http\Controllers\ClientAuth\ClientSessionController;
use App\Http\Controllers\ClientAuth\ClientUserRegistrationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FieldInvestigationController;
use App\Http\Controllers\LegalCaseController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\FieldInvestigation;
use App\Models\LegalCase;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Routes
// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    
   // Clients
    Route::get('/clients', [ClientController::class, 'index'])
    ->middleware('can:clients.index')
    ->name('admin.client.index');

    Route::get('/clients/{client}', [ClientController::class, 'show'])
    ->middleware('can:clients.show')
    ->name('admin.client.show');

    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])
    ->middleware('can:clients.edit')
    ->name('admin.client.edit');

    Route::patch('/clients/{client}', [ClientController::class, 'update'])
    ->middleware('can:clients.update')
    ->name('admin.client.update');

    Route::patch('/clients/{client}/toggle-block', [ClientController::class, 'toggleBlock'])
    ->middleware('can:clients.block')
    ->name('clients.toggleBlock');

    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
    ->can('delete','client')
    ->name('admin.client.destroy');

    // Compliances

    Route::get('/compliance-report', [ComplianceController::class, 'showReportForm'])->name('compliance.report.form');
    Route::get('/generate-compliance-report', [ComplianceController::class, 'generateComplianceReport'])->name('compliance.report');

    Route::get('/export-compliance', [ComplianceController::class, 'exportCompliance'])->name('compliance.export');

    Route::get('/compliances', [ComplianceController::class, 'compliance'])
    ->middleware('can:compliances.index')
    ->name('admin.compliances');

    Route::patch('/clients/{client}/compliance/approve-batch', [ComplianceController::class, 'approveBatch'])
    ->name('admin.compliance.approve-batch');
    
    Route::patch('clients/{client}/compliance/reject-batch', 
    [ComplianceController::class, 'rejectBatch'])
    ->name('admin.compliance.reject-batch');

    Route::get('/clients/{client}/compliance-index', [ComplianceController::class, 'index'])
        ->middleware('can:compliances.show')
        ->name('admin.compliance.index');

    Route::get('/clients/{client}/compliance-records/{complianceType}/{submission_date}', [ComplianceController::class, 'show'])
        ->middleware('can:compliances.show')
        ->name('admin.compliance.show');

    Route::patch('/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'approve'])
        ->middleware('can:compliances.approve')
        ->name('admin.compliance.approve');

    Route::patch('/clients/{client}/compliance-records/{compliance}/reject', [ComplianceController::class, 'reject'])
        ->middleware('can:compliances.reject')
        ->name('admin.compliance.reject');

    /* Route::get('/clients/{client}/compliance-records/download/{file}', [ComplianceController::class, 'download'])->name('admin.compliance.download'); */
    
    // Financial
    Route::get('/clients/{client}/financial-details/{financial}', [FinancialController::class, 'show'])->name('admin.financial.show');
    
    // Loans
    Route::get('/clients/{client}/financial-details/{financial}/loans/{loan}', [LoanController::class, 'show'])->name('admin.loan.show');

    // Logout
    Route::post('/logout', [SessionController::class, 'destroy'])->name('admin.logout');

    //settings
    Route::get('admin/settings', [SettingsController::class, 'settings'])->name('admin.settings');
    Route::get('admin/profile', [SettingsController::class, 'profile'])->name('admin.profile');
    Route::patch('admin/profile', [SettingsController::class, 'profileUpdate'])->name('admin.profile.update');

    //Audit Log/ Acitivy-Log
    Route::get('admin/activity-log', [AuditLogController::class, 'index'])
    ->middleware('can:audit')
    ->name('admin.activity-log');

    //Legal Management
    Route::get('/generate-legal-report', [LegalCaseController::class, 'generateLegalReport'])->name('legal.report');
    Route::get('/export-case', [LegalCaseController::class, 'exportCase'])->name('legal.export');


    Route::get('admin/legal-case', [LegalCaseController::class, 'index'])
        ->middleware('can:legal.show')
        ->name('admin.legal.index');

    Route::get('admin/legal-case/create', [LegalCaseController::class, 'create'])
        ->middleware('can:legal.create')
        ->name('admin.legal.create');

    Route::post('admin/legal-case', [LegalCaseController::class, 'store'])
        ->middleware('can:legal.create')
        ->name('admin.legal.store');

    Route::get('admin/legal-case/{case}', [LegalCaseController::class, 'show'])
        ->middleware('can:legal.show')
        ->name('admin.legal.show');

    Route::get('admin/legal-case/{case}/edit', [LegalCaseController::class, 'edit'])
        ->middleware('can:legal.edit')
        ->name('admin.legal.edit');

    Route::put('admin/legal-case/{case}', [LegalCaseController::class, 'update'])
        ->middleware('can:legal.update')
        ->name('admin.legal.update');

    Route::delete('admin/legal-case', [LegalCaseController::class, 'delete'])
        ->middleware('can:legal.destroy')
        ->name('admin.legal.destroy');  

    // User Management
    Route::get('admin/create', [UserRegistrationController::class, 'create'])
    ->middleware('can:users.create')
    ->name('admin.accountCreate');

    Route::post('admin/create', [UserRegistrationController::class, 'store'])->name('admin.accountCreate.post');

    // Risk Management

    Route::get('/generate-risk_assessment-report', [RiskController::class, 'generateRiskReport'])->name('risk.report');
    Route::get('/export-risk_assessment', [RiskController::class, 'exportRisk'])->name('risk.export');

    Route::get('/risks',[RiskController::class, 'risks'])->name('admin.risk_assessment.risks');
    Route::get('clients/{client}/list_risk',[RiskController::class, 'index'])->name('admin.risk_assessment.index');
    Route::get('clients/{client}/show_risk/{risk}',[RiskController::class, 'show'])->name('admin.risk_assessment.show');
    Route::patch('clients/{client}/show_risk/{risk}/recommendation',[RiskController::class, 'recommendation'])->name('admin.risk_assessment.recommendation');


    // Credit Investigation 
    Route::get('/credit_investigations', [FieldInvestigationController::class, 'credit_investigations'])
    ->middleware('can:investigation.credit_investigations')
    ->name('admin.investigation.credit_investigations');
    Route::post('clients/assignInvestigation', [FieldInvestigationController::class, 'assignInvestigation'])
    ->middleware('can:investigation.assign')
    ->name('admin.investigation.assign');

    Route::get('clients/{client}/index', [FieldInvestigationController::class, 'index'])->name('admin.investigation.index');
    Route::get('clients/{client}/show/{investigation}', [FieldInvestigationController::class, 'show'])->name('admin.investigation.show');
    Route::get('clients/{client}/show/{investigation}/edit', [FieldInvestigationController::class, 'edit'])
    ->middleware('can:investigation.edit')
    ->name('admin.investigation.edit');
    Route::patch('clients/{client}/show/{investigation}/update', [FieldInvestigationController::class, 'update'])
    ->middleware('can:investigation.update')
    ->name('admin.investigation.update');
    // User Management 
    Route::get('admin/users', [UserController::class, 'index'])
    ->middleware('can:users.index')
    ->name('admin.user.index');

    Route::get('admin/users/{user}', [UserController::class, 'show'])
    ->middleware('can:users.show')
    ->name('admin.user.show');

    Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])
    ->middleware('can:users.edit')
    ->name('admin.user.edit');

    Route::patch('admin/users/{user}/deactivate', [UserController::class, 'deactivate'])
    ->middleware('can:users.deactivate')
    ->name('admin.user.deactivate');
    
    Route::put('admin/users/{user}', [UserController::class, 'update'])
    ->middleware('can:users.update')
    ->name('admin.user.update');

    //Approval Management
    Route::get('/admin/pending-users', [AdminApprovalController::class, 'pendingUsers'])
    ->middleware('can:approve.users')
    ->name('admin.pending.users');
    Route::post('/admin/approve-user/{id}', [AdminApprovalController::class, 'approveUser'])
    ->middleware('can:approve.users')
    ->name('admin.approve.users');
    Route::delete('/admin/reject-user/{id}', [AdminApprovalController::class, 'rejectUser'])
    ->middleware('can:approve.users')
    ->name('admin.reject.users');

    Route::get('/admin/pending-legal-cases', [AdminApprovalController::class, 'pendingLegalCases'])
    ->middleware('can:approve.legal_cases')
    ->name('admin.pending.legal_cases');
    Route::post('/admin/approve-legal-case/{id}', [AdminApprovalController::class, 'approveLegalCase'])
    ->middleware('can:approve.legal_cases')
    ->name('admin.approve.legal_cases');
    Route::delete('/admin/reject-legal-case/{id}', [AdminApprovalController::class, 'rejectLegalCase'])
    ->middleware('can:approve.legal_cases')
    ->name('admin.reject.legal_cases');

    // Contract Management
    Route::get('admin/contracts', [ContractController::class, 'index'])
    ->middleware('can:contracts.index')
    ->name('admin.contracts.index');
    Route::get('admin/contracts/create', [ContractController::class, 'create'])
    ->middleware('can:contracts.create')
    ->name('admin.contracts.create');
    Route::post('admin/contracts', [ContractController::class, 'store'])
    ->middleware('can:contracts.store')
    ->name('admin.contracts.store');
    Route::get('admin/contracts/{contract}', [ContractController::class, 'show'])
    ->middleware('can:contracts.show')
    ->name('admin.contracts.show');
    Route::get('admin/contracts/{contract}/edit', [ContractController::class, 'edit'])
    ->middleware('can:contracts.edit')
    ->name('admin.contracts.edit');
    Route::put('admin/contracts/{contract}/update', [ContractController::class, 'update'])
    ->middleware('can:contracts.update')
    ->name('admin.contracts.update');
    Route::post('admin/contracts/{contract}/send', [ContractController::class, 'sendForSignature'])->name('admin.contracts.send');

    Route::get('admin/contract-templates/{template}/fields', [ContractController::class, 'getTemplateFields']);
});

// Routes for guest users
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('admin/login', [SessionController::class, 'create'])->name('login');
    Route::post('admin/login', [SessionController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.post');
    
});

// Password Reset
Route::get('admin/password/reset', [ForgotPasswordController::class, 'create'])->name('password.request');
Route::post('admin/password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
Route::get('admin/password/reset/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('admin/reset', [ResetPasswordController::class, 'update'])->name('password.update');

// Contract Controller
Route::get('admin/contracts/{contract}/download', [ContractController::class, 'download'])->name('admin.contracts.download');
Route::get('admin/contracts/{contract}/sign', [ContractController::class, 'showSigningPage'])->name('contracts.sign');
Route::post('admin/contracts/{contract}/sign', [ContractController::class, 'processSignature'])->name('contracts.process-signature');


/* // Client Routes
Route::middleware(['client-auth'])->group(function(){
    Route::get('/client', function(){
        return view('client/dashboard');
    })->name('client.dashboard');

    //Profile update
    Route::get('client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::patch('client/profile/{client}', [ClientController::class, 'profileUpdate'])->name('client.profile.update');
    
    //Compliance Route
    Route::get('client/compliance', [ComplianceController::class, 'compliance_records'])->name('client.compliance.compliance_records');
    Route::get('client/compliance/create',[ComplianceController::class, 'create'])->name('client.compliance.create');
    Route::post('client/compliance/',[ComplianceController::class, 'kyc'])->name('client.compliance.kyc');

    //Destroy Session
    Route::post('client/logout', [ClientSessionController::class, 'destroy'])->name('client.logout');
});

Route::middleware(['client-guest'])->group(function () {
    Route::get('client/register', [ClientUserRegistrationController::class, 'create'])->name('client.register');
    Route::post('client/register', [ClientUserRegistrationController::class, 'store'])->name('client.register.post');

    Route::get('client/login', [ClientSessionController::class, 'create'])->name('client.login');
    Route::post('client/login', [ClientSessionController::class, 'store'])->middleware('throttle:5,1')->name('client.login.post');

    // Password Reset
    Route::get('client/password/reset', [ClientForgotPasswordController::class, 'create'])->name('client.password.request');
    Route::post('client/password/email', [ClientForgotPasswordController::class, 'store'])->name('client.password.email');
    Route::get('client/password/reset/{token}', [ClientResetPasswordController::class, 'create'])->name('client.password.reset');
    Route::post('client/reset', [ClientResetPasswordController::class, 'update'])->name('client.password.update');
}); */