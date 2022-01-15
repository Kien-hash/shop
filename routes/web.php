<?php

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

Route::get('/', 'HomeController@index');


view()->composer(['*'], function ($view) {
    $currentUser = Auth::user();
    $view->with('currentUser', $currentUser);
});

Route::get('/admin', 'AdminController@getAdminLogin');
Route::post('/admin', 'AdminController@postAdminLogin');

Route::prefix('admin')->middleware('adminLogin')->group(function () {
    Route::get('/dashboard', 'AdminController@showDashboard');
    Route::get('/logout', 'AdminController@getLogout');

    Route::prefix('category')->group(function () {
        Route::get('/add', 'CategoryController@getAdd');
        Route::get('/all', 'CategoryController@getAll');
        Route::post('/add', 'CategoryController@postAdd');
        Route::get('/inactive/{id}', 'CategoryController@getInactive');
        Route::get('/active/{id}', 'CategoryController@getActive');

        Route::get('/edit/{id}', 'CategoryController@getEdit');
        Route::post('/edit/{id}', 'CategoryController@postEdit');
        Route::get('/delete/{id}', 'CategoryController@getDelete');
    });

    Route::prefix('brand')->group(function () {
        Route::get('/add', 'BrandController@getAdd');
        Route::get('/all', 'BrandController@getAll');
        Route::post('/add', 'BrandController@postAdd');
        Route::get('/inactive/{id}', 'BrandController@getInactive');
        Route::get('/active/{id}', 'BrandController@getActive');

        Route::get('/edit/{id}', 'BrandController@getEdit');
        Route::post('/edit/{id}', 'BrandController@postEdit');
        Route::get('/delete/{id}', 'BrandController@getDelete');
    });

    Route::prefix('product')->group(function () {
        Route::get('/add', 'ProductController@getAdd');
        Route::get('/all', 'ProductController@getAll');
        Route::post('/add', 'ProductController@postAdd');
        Route::get('/inactive/{id}', 'ProductController@getInactive');
        Route::get('/active/{id}', 'ProductController@getActive');

        Route::get('/edit/{id}', 'ProductController@getEdit');
        Route::post('/edit/{id}', 'ProductController@postEdit');
        Route::get('/delete/{id}', 'ProductController@getDelete');
    });

    Route::prefix('coupon')->group(function () {
        Route::get('/all', 'CouponController@getAll');
        Route::get('/add', 'CouponController@getAdd');
        Route::get('/edit/{id}', 'CouponController@getEdit');
        Route::get('/delete/{id}', 'CouponController@getDelete');

        Route::post('/edit/{id}', 'CouponController@postEdit');
        Route::post('/add', 'CouponController@postAdd');
    });

    Route::prefix('delivery')->group(function () {
        Route::get('/all', 'DeliveryController@getAll');

        Route::get('/delete/{id}', 'DeliveryController@getDelete');

        Route::post('/edit/{id}', 'DeliveryController@postEdit');
        Route::post('/add', 'DeliveryController@postAdd');
    });
});


// Ajax Handler
Route::post('/select-delivery', 'AjaxController@postSelectDelivery');
