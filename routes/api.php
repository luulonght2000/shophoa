<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//==================Product================
Route::get('/product-details/{id}', [ProductController::class, 'api_product_detail']);
Route::put('/api-product-update/{id}', [ProductController::class, 'api_product_update']);
Route::post('/api-product-create', [ProductController::class, 'api_product_create']);
Route::delete('/api-product-delete/{id}', [ProductController::class, 'api_product_delete']);
