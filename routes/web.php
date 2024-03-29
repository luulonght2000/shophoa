<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AutoSearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DatatablesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('welcome');

//==================================CLIENT==================================================
Route::prefix('/')->group(function () {
    Route::get('logout', [LoginController::class, 'logout']);
    Route::resource('/', \App\Http\Controllers\HomeController::class);
    // Route::get('/product', 'App\Http\Controllers\HomeController@product');
    Route::get('/productDetail/{id}', [HomeController::class, 'productDetail']);
    Route::any('/product-shop', [HomeController::class, 'productshop'])->name('product.shop');

    Route::get('/category-page/{id}', [HomeController::class, 'category_page']);
    Route::get('/blog',               [HomeController::class, 'blog']);
    Route::get('/test',               [HomeController::class, 'count_product_category']);
    Route::get('/contact',            [HomeController::class, 'contact'])->name('contact');
    Route::resource('profile',        ClientController::class)->middleware('checkProfile');
    Route::get('order-info/{id}',        [ClientController::class, 'order_info_user'])->middleware('checkProfile');
    Route::get('order-detail/{id}',        [ClientController::class, 'order_detail_user'])->middleware('checkProfile');
});

//===============================Cart Checkout=============================================
Route::prefix('/')->middleware('checkAddCart')->group(function () {
    Route::post('/save-cart',               [ClientController::class, 'save_cart']);
    Route::get('/show-cart',                [ClientController::class, 'show_cart'])->name('show.cart');
    Route::post('/update-cart-quantity',    [ClientController::class, 'update_cart_quantity']);
    Route::get('/delete-to-cart/{rowId}',   [ClientController::class, 'delete_to_cart']);
    Route::get('/checkout',                 [ClientController::class, 'checkout']);
    Route::post('/save-checkout-user',      [ClientController::class, 'save_checkout_user']);
    Route::get('/payment',                  [ClientController::class, 'payment']);
    Route::post('/order-place',             [ClientController::class, 'order_place']);
    Route::delete('/delete-order/{shipping_id}',  [ClientController::class, 'delete_order']);
    Route::post('/checkout-atm',                [ClientController::class, 'checkout_atm']);
    Route::get('/thankyou',                [ClientController::class, 'thankyou']);
});


//================================LOGIN======================================================
Route::prefix('/')->group(function () {
    Route::get('login',     [LoginController::class, 'login'])->name('admin.auth.login')->middleware('checkGetLogin');
    Route::post('login',    [LoginController::class, 'checkLogin'])->name('admin.auth.check-login');

    Route::get('/quen-mat-khau',    [MailController::class, 'forgotPass']);
    Route::get('/update-new-pass',  [MailController::class, 'updatePass']);
    Route::post('/recover-pass',    [MailController::class, 'recoverPass']);
    Route::post('/update-new-pass', [MailController::class, 'update_new_pass']);
});


//--------------------------Login Facebook--------------------------------

Route::get('/facebook',      [SocialController::class, 'redirectToFacebook'])->name('auth.facebook')->middleware('checkGetLogin');;
Route::get('/facebook/callbackFB', [SocialController::class, 'callback_facebook']);

//---------------------------Login google-----------------------------

Route::get('/login-google',      [SocialController::class, 'login_google'])->middleware('checkGetLogin');;
Route::get('/google/callbackGG', [SocialController::class, 'callback_google']);


//================================ADMIN======================================================

Route::prefix('admin')->middleware('admin.login')->group(function () {
    Route::get('logout', [LoginController::class, 'logout']);

    Route::get('/home', 'App\Http\Controllers\AdminController@index')->name('admin.index');
    Route::resource('user',         UserController::class)->middleware('checkRole');
    Route::get('get-user',          [UserController::class, 'index'])->name('ajax.user.index')->middleware('checkRole');
    Route::post('delete-user',      [UserController::class, 'destroy']);
    Route::resource('role',         RoleController::class)->middleware('checkRole');
    Route::resource('accountadmin', AdminController::class);
    Route::resource('category',     CategoryController::class);

    //Product
    Route::resource('product', ProductController::class);
    // Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'showw']);
    Route::get('/unactive-product/{id}', [ProductController::class, 'unactive']);
    Route::get('/active-product/{id}',   [ProductController::class, 'active']);
    Route::get('/add-images/{id}',       [ProductController::class, 'view_add_images']);
    Route::post('/add-images',           [ProductController::class, 'add_images']);
    // ->middleware('auth.admin.products');
    Route::resource('style', \App\Http\Controllers\StyleController::class);
    Route::post('/import-product',  [ExcelController::class, 'import_product']);
    Route::get('/export-product',   [ExcelController::class, 'export_product']);
    Route::get('/export-user',      [ExcelController::class, 'export_user']);
    Route::get('/export-order',     [ExcelController::class, 'export_order']);

    //Order
    Route::resource('order',                OderController::class)->except(['destroy']);
    Route::resource('order',                OderController::class)->only(['destroy'])->middleware('checkPermission');
    Route::get('manage-order',              [OderController::class, 'manage_order']);
    Route::put('/order_status/{order_id}',  [OderController::class, 'order_status']);
    Route::get('/unactive-order/{id}',      [OderController::class, 'unactive']);
    Route::get('/active-order/{id}',        [OderController::class, 'active']);
});










