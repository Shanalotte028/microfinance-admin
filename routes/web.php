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
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Routes
// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        // Fetch total registered users
        $totalUsers = Client::count();
        // Fetch total pending loans (assuming you have a status field for loans)
        $pendingLoans = Loan::where('loan_status', 'defaulted')->count();
        $pendingCompliance = Compliance::where('document_status', 'pending')->count(); 
        return view('admin/dashboard', compact('totalUsers', 'pendingLoans', 'pendingCompliance'));
    })->name('dashboard');
    
    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('admin.client.index');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('admin.client.show');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('admin.client.edit');

    Route::patch('/clients/{client}', [ClientController::class, 'update'])
    ->can('update','client')
    ->name('admin.client.update');

    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
    ->can('delete','client')
    ->name('admin.client.destroy');
    //block client
    Route::patch('/clients/{client}/toggle-block', [ClientController::class, 'toggleBlock'])->name('clients.toggleBlock');
    
    // Compliances
    Route::get('/compliances', [ComplianceController::class, 'compliance'])->name('admin.compliances');
    Route::get('/clients/{client}/compliance-records', [ComplianceController::class, 'index'])->name('admin.compliance.index');
    Route::get('/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'show'])->name('admin.compliance.show');
    Route::patch('/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'approve'])->name('admin.compliance.approve');
    
    // Financial
    Route::get('/clients/{client}/financial-details/{financial}', [FinancialController::class, 'show'])->name('admin.financial.show');
    
    // Loans
    Route::get('/clients/{client}/financial-details/{financial}/loans/{loan}', [LoanController::class, 'show'])->name('admin.loan.show');

     // account creation
    Route::get('admin/create', [UserRegistrationController::class, 'create'])->name('admin.accountCreate');
    Route::post('admin/create', [UserRegistrationController::class, 'store'])->name('admin.accountCreate.post');

    //Route::get('admin/password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.auth');
    // Logout
    Route::post('/logout', [SessionController::class, 'destroy'])->name('admin.logout');

    //settings
    Route::get('admin/settings', [SettingsController::class, 'settings'])->name('admin.settings');
    Route::get('admin/profile', [SettingsController::class, 'profile'])->name('admin.profile');
    Route::patch('admin/profile', [SettingsController::class, 'profileUpdate'])->name('admin.profile.update');

    //Audit Log/ Acitivy-Log
    Route::get('admin/activity-log', [AuditLogController::class, 'index'])->name('admin.activity-log');

    Route::get('admin/users', [UserController::class, 'index'])->name('admin.user.index');
});

// Routes for guest users
Route::middleware(['guest'])->group(function () {
    // Password Reset
    Route::get('admin/password/reset', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('admin/password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('admin/password/reset/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('admin/reset', [ResetPasswordController::class, 'update'])->name('password.update');
    // Login
    Route::get('admin/login', [SessionController::class, 'create'])->name('login');
    Route::post('admin/login', [SessionController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.post');
});


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