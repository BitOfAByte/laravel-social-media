<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', action: [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'index'])->name('login');

Route::get('dashboard', [AuthController::class, 'dashboard']);  
Route::get('logout', [AuthController::class, 'logout'])->name('logout');