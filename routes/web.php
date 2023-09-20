<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/getByCategory/{user}', [ProductController::class, 'getByCategory']);
Route::get('/category/get-products/{category}', [CategoryController::class, 'getProducts']);
Route::get('/product/get-all', [ProductController::class, 'getAll']);
Route::get('/product/{product}', [ProductController::class, 'show']);


Auth::routes();
Route::get('/shopping', [ShoppingController::class, 'index'])->middleware('role:user|admin');
Route::post('/shopping', [ShoppingController::class, 'store'])->middleware('role:user|admin');

