<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::get('/Dash', [AdminController::class, 'Dashboard'])->name('Dash');

});
