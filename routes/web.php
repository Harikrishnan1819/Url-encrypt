<?php

use App\Http\Controllers\CryptController;
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


Route::get('/crypt',[CryptController::class,'index'])->name('crypt');
Route::get('/decrypt/{status}', function () {
    return 'test';
})->name('decrypt');
Route::middleware('decryptParams')->group(function ($router) {
});