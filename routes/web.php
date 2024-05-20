<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd;
use App\Http\Controllers\TranslationController;
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

Route::match(['get', 'post'], '/', [FrontEnd::class, 'Index'])->name('Index');

Route::match(['get', 'post'], '/Product', [FrontEnd::class, 'Product'])->name('Product');

Route::match(['get', 'post'], '/Blog', [FrontEnd::class, 'Blog'])->name('Blog');

Route::match(['get', 'post'], '/Blog-Detail', [FrontEnd::class, 'Blog_Detail'])->name('Blog-Detail');

Route::match(['get', 'post'], '/About', [FrontEnd::class, 'About'])->name('About');

Route::match(['get', 'post'], '/Contact', [FrontEnd::class, 'Contact'])->name('Contact');

Route::match(['get', 'post'], '/login', [FrontEnd::class, 'Login'])->name('login');

Route::match(['get', 'post'], '/Register', [FrontEnd::class, 'Register'])->name('Register');

Route::match(['get', 'post'], '/Product-Details/{id}', [FrontEnd::class, 'ProductDetails']);

Route::post('/translate', [TranslationController::class, 'translate'])->name('translate');

Route::get('/productmodal/{product}', [FrontEnd::class, 'show'])->name('products.show');

Route::get('/productsAll', [FrontEnd::class, 'getProducts'])->name('products.get');

Route::get('/check-login', [FrontEnd::class, 'checkLogin']);

Route::post('/add-to-cart', [CartController::class, 'addToCart']);

Route::get('/cart-item-count', [CartController::class, 'getCartItemCount']);

Route::get('/cart-items', [CartController::class, 'getCartItems']);

Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/Check-Out', [FrontEnd::class, 'CheckOut']);

Route::get('/fetch-cart-items', [FrontEnd::class,'fetchCartItems'])->name('cart.fetch');

Route::post('/CheckoutPaid', [FrontEnd::class, 'handleCheckout'])->name('CheckoutPaid');

// Route for successful payment
Route::get('/checkout/success', [FrontEnd::class, 'checkoutSuccess'])->name('checkout.success');

// Route for cancelled payment
Route::get('/checkout/cancel', [FrontEnd::class, 'checkoutCancel'])->name('checkout.cancel');
