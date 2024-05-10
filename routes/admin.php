<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::get('/Dash', [AdminController::class, 'Dashboard'])->name('Dash');
    Route::get('/Category', [AdminController::class, 'Category'])->name('Category');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});
