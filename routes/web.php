<?php
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\UserRegistrationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Routes

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/admin', function (User $user) {
        $currentUser = $user->is(Auth::user()); 
        return view('admin/dashboard', ['user' => $currentUser]);
    })->name('dashboard');

    // Clients
    Route::get('admin/clients', [ClientController::class, 'index']);
    Route::get('admin/clients/{client}', [ClientController::class, 'show']);
    
    // Compliances
    Route::get('admin/clients/{client}/compliance-records', [ComplianceController::class, 'index']);
    Route::get('admin/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'show']);
    
    // KYC
    Route::get('admin/clients/{client}/compliance-records/{compliance}/kyc-records/{kyc}', [KycController::class, 'show']);
    
    // Financial
    Route::get('admin/clients/{client}/financial-details/{financial}', [FinancialController::class, 'show']);
    
    // Loans
    Route::get('admin/clients/{client}/financial-details/{financial}/loans/{loan}', [LoanController::class, 'show']);
    
    // Logout
    Route::post('admin/logout', [SessionController::class, 'destroy']);
});

// Routes for guest users
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('admin/login', [SessionController::class, 'create'])->name('login');
    Route::post('admin/login', [SessionController::class, 'store'])->middleware('throttle:5,1');
    
    // Registration
    Route::get('admin/register', [UserRegistrationController::class, 'create']);
    Route::post('admin/register', [UserRegistrationController::class, 'store']);
    
    // Password Reset
    Route::get('admin/password/reset', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('admin/password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('admin/password/reset/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('admin/reset', [ResetPasswordController::class, 'update'])->name('password.update');
});


// Client Routes


Route::get('/client', function(){
    return('client.index');
});
