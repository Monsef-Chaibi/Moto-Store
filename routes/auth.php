<?php

use App\Http\Controllers\AuthController;



// Register route
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Logout Route
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);
