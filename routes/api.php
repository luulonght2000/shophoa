<?php
 
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\AuthController;
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

//==================Product================
Route::get('/product-details/{id}', [ProductController::class, 'api_product_detail']);
Route::put('/api-product-update/{id}', [ProductController::class, 'api_product_update']);
Route::post('/api-product-create', [ProductController::class, 'api_product_create']);
Route::delete('/api-product-delete/{id}', [ProductController::class, 'api_product_delete']);


Route::group([ 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['middleware' => 'auth:api'], function() {
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});
