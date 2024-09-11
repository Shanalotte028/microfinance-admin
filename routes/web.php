<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserRegistrationController;
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
//login
Route::get('/login', [SessionController::class,'create'])->name('login');
Route::post('/login', [SessionController::class,'store']);
Route::post('/logout', [SessionController::class,'destroy']);
//Registration
Route::get('/register', [UserRegistrationController::class,'create']);
Route::post('/register', [UserRegistrationController::class,'store']);