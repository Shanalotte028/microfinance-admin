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

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', function (User $user) {
        $currentUser = $user->is(Auth::user()); 
        return view('admin/dashboard', ['user' => $currentUser]);
    })->name('dashboard');

    // Clients
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{client}', [ClientController::class, 'show']);
    
    // Compliances
    Route::get('/clients/{client}/compliance-records', [ComplianceController::class, 'index']);
    Route::get('/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'show']);
    
    // KYC
    Route::get('/clients/{client}/compliance-records/{compliance}/kyc-records/{kyc}', [KycController::class, 'show']);
    
    // Financial
    Route::get('/clients/{client}/financial-details/{financial}', [FinancialController::class, 'show']);
    
    // Loans
    Route::get('/clients/{client}/financial-details/{financial}/loans/{loan}', [LoanController::class, 'show']);
    
    // Logout
    Route::post('/logout', [SessionController::class, 'destroy']);
});

// Routes for guest users
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:5,1');
    
    // Registration
    Route::get('/register', [UserRegistrationController::class, 'create']);
    Route::post('/register', [UserRegistrationController::class, 'store']);
    
    // Password Reset
    Route::get('password/reset', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset', [ResetPasswordController::class, 'update'])->name('password.update');
});
