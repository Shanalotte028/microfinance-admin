<?php

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
use App\Http\Controllers\LegalCaseController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\LegalCase;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Routes
// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        $user = Auth::user();
        $assignedCases = $user->legalCases->count();
        // Fetch total pending loans (assuming you have a status field for loans)
        $openCase = LegalCase::where('status', 'open')->count();
        $pendingCompliance = Compliance::where('document_status', 'pending')->count(); 
        return view('admin/dashboard', compact('openCase', 'pendingCompliance', 'assignedCases'));
    })->name('dashboard');
    
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
    Route::get('/compliances', [ComplianceController::class, 'compliance'])
    ->middleware('can:compliances.index')
    ->name('admin.compliances');

    Route::get('/clients/{client}/compliance-records', [ComplianceController::class, 'index'])
        ->middleware('can:compliances.index')
        ->name('admin.compliance.index');

    Route::get('/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'show'])
        ->middleware('can:compliances.show')
        ->name('admin.compliance.show');

    Route::patch('/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'approve'])
        ->middleware('can:compliances.approve')
        ->name('admin.compliance.approve');

    Route::patch('/clients/{client}/compliance-records/{compliance}/reject', [ComplianceController::class, 'reject'])
        ->middleware('can:compliances.reject')
        ->name('admin.compliance.reject');
    
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
    Route::get('admin/legal-case', [LegalCaseController::class, 'index'])
        ->middleware('can:legal.index')
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

    //Route::post('admin/create', [UserRegistrationController::class, 'store'])->name('admin.accountCreate.post');

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


// Client Routes
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
});