<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Index');
});

Route::prefix('auth')->group(function () {
    Route::inertia('/', 'Auth/Login');
    Route::inertia('login', 'Auth/Login');
    Route::inertia('signup', 'Auth/Signup');
});
