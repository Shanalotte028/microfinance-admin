<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserRegistrationController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\RiskController;
use Illuminate\Support\Facades\Log;

Route::post('admin/compliance',[ComplianceController::class, 'store'])->name('api.compliance.store')->middleware('validate-api');
// PATCH/PUT: Update an existing client
Route::patch('admin/compliance/{client}', [ComplianceController::class, 'store']);
Route::put('admin/compliance/{client}', [ComplianceController::class, 'store']);

Route::post('clients/{client}/risk_assessment',[RiskController::class, 'store'])->name('api.risk_assessment.store');



/* Route::get('test', function (Request $request) {
    return "hello";
})->middleware('validate-api'); */
