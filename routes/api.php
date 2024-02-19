<?php

use App\Http\Controllers\API\OrdersController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!

sanctum - passport
|
*/

// not auth requests
Route::middleware('guest')->group(function () {

    // 1) Register
    Route::post('register', [RegisteredUserController::class, 'store']);

    // 2) Login
    Route::put('login', [AuthenticatedSessionController::class, 'store']);

    // 3) Get Products
    Route::get('products', [ProductsController::class, 'GetProducts']);

    // 4) Get Categories
    Route::get('categories', [ProductsController::class, 'GetCategories']);
        // Show Product

    Route::get('statistics', [ProductsController::class, 'statistics']);
});

// auth requests
Route::middleware('auth:sanctum')->group(function () {

        Route::post('add-categories', [ProductsController::class, 'createCategories']);

    Route::get('showProduct/{product}', [ProductsController::class, 'show']);


    Route::post('create-user', [UserController::class, 'createUser']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    // 1) Create orders
    Route::post('orders', [OrdersController::class, 'store']);
    // Get orders
    Route::get('orders', [OrdersController::class, 'index']);
    // Update Product
    Route::put('editProduct/{product}', [ProductsController::class, 'update']);
    // Add Product
    Route::post('addProduct', [ProductsController::class, 'store']);
    // delete Product
    Route::delete('deleteProduct/{product}', [ProductsController::class, 'destroy']);
    // 2) Get User API Requests
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    //getallusers
    Route::get('users',[UserController::class,'show']);

    //createcategory
    //destroyCategory
    Route::delete('categories/{id}', [ProductsController::class, 'destroyCategory']);


    //createcategory
    //destroyCategory
    //Route::delete('categories/{id}', [ProductsController::class, 'destroyCategory']);


    // 3)

    // 4) Modify/Update Order
    Route::put('orders', [OrdersController::class, 'update']);

    // 5) Logout User
    Route::put('logout', [AuthenticatedSessionController::class, 'logout']);



});
