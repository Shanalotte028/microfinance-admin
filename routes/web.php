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


Route::get('/', function (User $user) {
    $currentUser = $user->is(Auth::user()); 
    return view('dashboard', ['user'=>$currentUser]);
})->middleware('auth')->name('dashboard');

//Clients
Route::get('/clients',[ClientController::class, 'index'])->middleware('auth');
Route::get('/clients/{client}',[ClientController::class, 'show'])->middleware('auth');
//Compliances
Route::get('/clients/{client}/compliance-records',[ComplianceController::class, 'index'])->middleware('auth');
Route::get('/clients/{client}/compliance-records/{compliance}',[ComplianceController::class, 'show'])->middleware('auth');
//KYC
Route::get('/clients/{client}/compliance-records/{compliance}/kyc-records/{kyc}', [KycController::class, 'show'])->middleware('auth');
//Financial
Route::get('/clients/{client}/financial-details/{financial}',[FinancialController::class, 'show'])->middleware('auth');
//loan
route::get('/clients/{client}/financial-details/{financial}/loans/{loan}', [LoanController::class, 'show'])->middleware('auth');
//login
Route::get('/login', [SessionController::class,'create'])->name('login');
Route::post('/login', [SessionController::class,'store']);
Route::post('/logout', [SessionController::class,'destroy']);
// Reset Password Route
Route::get('password/reset', [ForgotPasswordController::class, 'create'])->name('password.request');
// Route to submit the email for a password reset link
Route::post('password/email', [ForgotPasswordController::class, 'store'])->name('password.email');
// Route to show the password reset form when the user clicks the reset link
Route::get('password/reset/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
// Route to submit the new password
Route::post('/reset', [ResetPasswordController::class, 'update'])->name('password.update');

//Registration
Route::get('/register', [UserRegistrationController::class,'create']);
Route::post('/register', [UserRegistrationController::class,'store']);