<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\UserController;
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


//Routes for all users
Route::prefix('users')->group(function () {
    Route::post('/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/index', [UserController::class, 'index'])->name('users.index');
})->middleware('auth');
