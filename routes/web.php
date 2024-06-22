<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use Illuminate\Support\Facades\Route;

//Index
Route::inertia('/', 'Index');

//Authentication
Route::prefix('auth')->group(function () {
    Route::inertia('/', 'Auth/Login');
    Route::inertia('login', 'Auth/Login');
    Route::inertia('signup', 'Auth/Signup');

    Route::post('/login/submit', [AuthController::class, 'login']);
});
//Dashboards
Route::get('/dashboard', DashBoardController::class)->name('dashboard')->middleware('auth');
