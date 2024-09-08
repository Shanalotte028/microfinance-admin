<?php

use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login', [SessionController::class,'create'])->name('login');
Route::post('/login', [SessionController::class,'store']);
Route::post('/logout', [SessionController::class,'destroy']);

Route::get('/register', [UserRegistrationController::class,'create']);
Route::post('/register', [UserRegistrationController::class,'store']);