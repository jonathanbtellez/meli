<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
Route::group(['prefix' => 'shopping', 'middleware' => ['role:user|admin'], 'controller' => ShoppingController::class], function () {
	Route::get('/',  'index');
	Route::post('/',  'store');
});


Route::group(['middleware' => ['role:admin']], function () {
	Route::group(['prefix' => 'user', 'controller' => UserController::class], function () {
		Route::get('/',  'index');
		Route::get('/get-all-dt',  'getAll');
		Route::post('/',  'store');
		Route::get('/{user}',  'show');
		Route::post('/{user}',  'update');
		Route::delete('/{user}',  'destroy');
	});

	Route::group(
		['prefix' => 'products', 'middleware' => ['role:admin'], 'controller' => ProductController::class],
		function () {
			Route::get('/',  'index');
			Route::get('/get-all-dt',  'getAllDt');
			Route::post('/',  'store');
			Route::get('/{product}', 'edit');
			Route::post('/{product}', 'update');
			Route::delete('/{product}', 'destroy');
		}
	);

	Route::group(
		['prefix' => 'categories', 'middleware' => ['role:admin'], 'controller' => CategoryController::class],
		function () {
			Route::get('/',  'index');
			Route::get('/get-all-dt',  'getAllDt');
			Route::post('/',  'store');
			Route::get('/{category}', 'edit');
			Route::put('/{category}', 'update');
			Route::delete('/{category}', 'destroy');
		}
	);
});
