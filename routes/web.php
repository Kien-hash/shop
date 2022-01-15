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
Route::get('/category/{slug}', 'HomeController@showCategory');
Route::get('/brand/{slug}', 'HomeController@showBrand');
Route::get('/details/{slug}', 'HomeController@showDetail');
Route::post('/search', 'HomeController@postSearch');

// Ajax Handler
Route::post('/select-delivery', 'AjaxController@postSelectDelivery');
Route::post('/add-cart', 'AjaxController@postAddCartAjax');

// Cart Handler
Route::get('/show-cart', 'CartController@getShowCart');
Route::get('/del-all-product', 'CartController@deleteAllCartProduct');
Route::post('/update-cart', 'CartController@postUpdateCart');
Route::get('/del-product/{session_id}', 'CartController@deleteProduct');

// Coupon
Route::post('/check-coupon', 'CartController@postCheckCoupon');
Route::get('/unset-coupon', 'CartController@getUnsetCoupon');

// User login
Route::get('/login-checkout', 'CheckoutController@getLogin');
Route::get('/logout', 'CheckoutController@getLogout');
Route::post('/login', 'CheckoutController@postLogin');
Route::post('/signup', 'CheckoutController@postSignup');

// Checkout pages
Route::get('/checkout', 'CheckoutController@getCheckout');


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

    Route::prefix('payment')->group(function () {
        Route::get('/add', 'PaymentController@getAdd');
        Route::get('/all', 'PaymentController@getAll');
        Route::post('/add', 'PaymentController@postAdd');
        Route::get('/inactive/{id}', 'PaymentController@getInactive');
        Route::get('/active/{id}', 'PaymentController@getActive');

        Route::get('/edit/{id}', 'PaymentController@getEdit');
        Route::post('/edit/{id}', 'PaymentController@postEdit');
        Route::get('/delete/{id}', 'PaymentController@getDelete');
    });
});

