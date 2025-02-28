<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\SupplierController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
// Route::apiResource('transactions', TransactionController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('inventory', InventoryController::class);
// Route::apiResource('purchases', PurchaseController::class);