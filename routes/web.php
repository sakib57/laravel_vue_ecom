<?php

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



Route::prefix('admin')->group(base_path('routes/admin.php'));
Route::prefix('user')->group(base_path('routes/user.php'));


Auth::routes();

Route::get('user-login', 'HomeController@index')->name('login');

Route::get('/', function () {
    return view('public.public_master');
});


Route::get('product-list', 'ProductController@geltAllProduct');
Route::get('product-sidebar-info', 'ProductController@sidebarInfo');

Route::get('product-filter/{data}', 'ProductController@productFilter');

Route::group(['prefix' => 'cart'], function () {
    Route::post('add-to-cart', 'CartController@addToCart')->name('addToCart');
    Route::get('cart-product-list', 'CartController@productList')->name('productList');
    Route::get('remove-product/{id}', 'CartController@removeProduct')->name('removeProduct');
    Route::post('update-cart','CartController@updateCart')->name('updateCart');
});

Route::post('checkout', 'OrderController@checkout')->name('checkout');

Route::get('/{path}', function () {
    return view('public.public_master');
});

Route::get('/{path}/{id}', function () {
    return view('public.public_master');
});


