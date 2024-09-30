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
use App\Http\Controllers\ClientAuth\ClientForgotPasswordController;
use App\Http\Controllers\ClientAuth\ClientResetPasswordController;
use App\Http\Controllers\ClientAuth\ClientSessionController;
use App\Http\Controllers\ClientAuth\ClientUserRegistrationController;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Routes

// Routes for authenticated users
Route::middleware(['admin-auth'])->group(function () {
    // Dashboard
    Route::get('/admin', function (User $user) {
        $currentUser = $user->is(Auth::user()); 
        return view('admin/dashboard', ['user' => $currentUser]);
    })->name('dashboard');

    // Clients
    Route::get('admin/clients', [ClientController::class, 'index'])->name('admin.client.all');
    Route::get('admin/clients/{client}', [ClientController::class, 'show'])->name('admin.client.one');
    Route::get('admin/clients/{client}/edit', [ClientController::class, 'edit'])->name('admin.client.edit');
    Route::patch('admin/clients/{client}', [ClientController::class, 'update'])->name('admin.client.update');
    
    // Compliances
    Route::get('admin/compliances', [ComplianceController::class, 'compliance'])->name('admin.compliances');
    Route::get('admin/clients/{client}/compliance-records', [ComplianceController::class, 'index']);
    Route::get('admin/clients/{client}/compliance-records/{compliance}', [ComplianceController::class, 'show'])->name('admin.compliance-one');
    
    // Financial
    Route::get('admin/clients/{client}/financial-details/{financial}', [FinancialController::class, 'show']);
    
    // Loans
    Route::get('admin/clients/{client}/financial-details/{financial}/loans/{loan}', [LoanController::class, 'show']);
    
    // Logout
    Route::post('admin/logout', [SessionController::class, 'destroy'])->name('admin.logout');
});

// Routes for guest users
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('admin/login', [SessionController::class, 'create'])->name('admin.login');
    Route::post('admin/login', [SessionController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.post');
    
    // Registration
    Route::get('admin/register', [UserRegistrationController::class, 'create'])->name('admin.register');
    Route::post('admin/register', [UserRegistrationController::class, 'store'])->name('admin.register.post');
    
    // Password Reset
    Route::get('admin/password/reset', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('admin/password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('admin/password/reset/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('admin/reset', [ResetPasswordController::class, 'update'])->name('password.update');
});


// Client Routes

Route::middleware(['client-auth'])->group(function(){
    Route::get('/client', function(){
        return view('client/dashboard');
    })->name('client.dashboard');
    
    Route::get('client/compliance', [ComplianceController::class, 'create'])->name('client.compliance.create');

    Route::post('client/logout', [ClientSessionController::class, 'destroy'])->name('client.logout');
});

Route::middleware(['guest'])->group(function () {
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