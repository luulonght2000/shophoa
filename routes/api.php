<?php
 
use App\Http\Controllers\api\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout',  [UserController::class, 'logout']);
    Route::get('details', [UserController::class, 'details']);
});

//==================Product================
Route::get('/product-details/{id}', [ProductController::class, 'api_product_detail']);
Route::put('/api-product-update/{id}', [ProductController::class, 'api_product_update']);
Route::post('/api-product-create', [ProductController::class, 'api_product_create']);
Route::delete('/api-product-delete/{id}', [ProductController::class, 'api_product_delete']);
