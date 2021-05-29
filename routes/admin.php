<?php

use Illuminate\Support\Facades\Route;



Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'Admin\LoginController@login')->name('admin.login.post');



Route::group(['middleware' => 'auth:admin'], function () {
    
    Route::get('/', function(){
        return view('admin.admin_master');
    })->name('admin.dashboard');
    
    Route::get('user', function () {
        return response()->json([
            'admin' => \Auth::guard('admin')->user(),
        ], 200);
    });
    Route::get( '/logout', 'Admin\LoginController@logout')->name('admin.logout');

    // Category route
    Route::resource('category', 'CategoryController');
    Route::post('/multiple-category-delete','CategoryController@mutipleDelete')->name('admin.category.multipledelete');
    Route::get('all-category','CategoryController@getAllCategory')->name('admin.allcategory');
   
    // Brand route
    Route::resource('brand', 'BrandController');
    Route::post('/multiple-brand-delete','BrandController@mutipleDelete')->name('admin.brand.multipledelete');
    Route::get('all-brand','BrandController@getAllBrand')->name('admin.allbrand');
   
    // user Route
    Route::get('user-list','HomeController@userList')->name('admin.user.list');

    // Product ROute
    Route::resource('product', 'ProductController');
    Route::post('product-update/{id}', 'ProductController@updateProduct')->name('admin.product.update');
    Route::post('/multiple-product-delete','ProductController@mutipleDelete')->name('admin.product.multipledelete');
    
    // Order Route 
    Route::resource('order', 'OrderController');
    Route::get('order-detail/{id}', 'OrderController@orderDetail');
    
});

Route::get('/{path}', function () {
    return view('admin.admin_master');
});

Route::get('/{path}/{id}', function () {
    return view('admin.admin_master');
});



