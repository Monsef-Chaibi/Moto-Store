<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::match(['get', 'post'], '/Product', [FrontEnd::class, 'Product'])->name('Register');

Route::match(['get', 'post'], '/Blog', [FrontEnd::class, 'Blog'])->name('Blog');

Route::match(['get', 'post'], '/Blog-Detail', [FrontEnd::class, 'Blog_Detail'])->name('Blog-Detail');

Route::match(['get', 'post'], '/About', [FrontEnd::class, 'About'])->name('About');

Route::match(['get', 'post'], '/Contact', [FrontEnd::class, 'Contact'])->name('Contact');

Route::match(['get', 'post'], '/login', [FrontEnd::class, 'Login'])->name('login');

Route::match(['get', 'post'], '/Register', [FrontEnd::class, 'Register'])->name('Register');

