<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UserController;
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
Route::group(['prefix'=> 'shopping', 'middleware' => ['role:user|admin'], 'controller' => ShoppingController::class], function(){
	Route::get('/',  'index');
	Route::post('/',  'store');
});

Route::group(['prefix'=> 'user', 'middleware' => ['role:admin'], 'controller' => UserController::class], function(){
	Route::get('/',  'index');
});


