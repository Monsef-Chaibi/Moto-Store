<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::get('/Dash', [AdminController::class, 'Dashboard'])->name('Dash');
    Route::get('/Category', [AdminController::class, 'Category'])->name('Category');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/getcategories', [CategoryController::class, 'index'])->name('categories.index');
    Route::delete('/categories/{category}',  [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{category}', [CategoryController::class, 'getdetails'])->name('categories.show');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
});
