<?php

use App\Http\Controllers\CryptController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/crypt', [CryptController::class, 'index'])->name('crypt');
Route::get('/greet', [CryptController::class, 'greet'])->name('greet');

// Route::resource('products', ProductController::class);

Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::post('/products', [ProductController::class,'store'])->name('products.store');
Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
Route::get('/products/{product}', [ProductController::class,'show'])->name('products.show');
Route::put('/products/{product}', [ProductController::class,'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class,'destroy'])->name('products.destroy');
Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('products.edit');