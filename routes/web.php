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
Route::get('/contact', 'HomeController@getContact');

// Post pages
Route::get('/post-category/{slug}', 'HomePostController@getPostCategory');
Route::get('/post/{slug}', 'HomePostController@getPost');


// Ajax Handler
Route::post('/select-delivery', 'AjaxController@postSelectDelivery');
Route::post('/add-cart', 'AjaxController@postAddCartAjax');
Route::post('/calculate-fee', 'AjaxController@postCalculateFee');
Route::post('/ajax-search', 'AjaxController@postSearch');


// Cart Handler
Route::get('/show-cart', 'CartController@getShowCart');
Route::get('/del-all-product', 'CartController@deleteAllCartProduct');
Route::post('/update-cart', 'CartController@postUpdateCart');
Route::get('/del-product/{session_id}', 'CartController@deleteProduct');
Route::get('/del-fee', 'CartController@getDeleteFee');
Route::post('/confirm-order', 'CartController@postConfirmOrder');


// Coupon
Route::post('/check-coupon', 'AjaxController@postCheckCoupon');
Route::get('/unset-coupon', 'CartController@getUnsetCoupon');

// User login
Route::get('/login-checkout', 'CheckoutController@getLogin');
Route::get('/logout', 'CheckoutController@getLogout');
Route::post('/login', 'CheckoutController@postLogin');
Route::post('/signup', 'CheckoutController@postSignup');

// Checkout pages
Route::get('/checkout', 'CheckoutController@getCheckout');

// Add comment
Route::post('/add-comment', 'CommentController@postAdd');

// Rating
Route::post('/add-rating', 'RatingController@postAdd');

view()->composer(['*'], function ($view) {
    $currentUser = Auth::user();
    $view->with('currentUser', $currentUser);
});

Route::get('/admin', 'AdminController@getAdminLogin');
Route::post('/admin', 'AdminController@postAdminLogin');

Route::prefix('admin')->middleware('adminLogin')->group(function () {
    Route::get('/dashboard', 'AdminController@showDashboard');
    Route::get('/logout', 'AdminController@getLogout');

    Route::prefix('statistical')->group(function () {
        Route::post('/filter-by-date', 'StatisticalController@postFilterDate');
        Route::post('/filter-by-select', 'StatisticalController@postFilterSelect');
    });


    Route::prefix('contact')->group(function () {
        Route::get('/config', 'ContactController@getConfig');
        Route::post('/config', 'ContactController@postConfig');
    });


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

    Route::prefix('comment')->group(function () {
        // Route::get('/add', 'CategoryController@getAdd');
        Route::get('/all', 'CommentController@getAll');
        Route::get('/inactive/{id}', 'CommentController@getInactive');
        Route::get('/active/{id}', 'CommentController@getActive');

        Route::get('/edit/{id}', 'CommentController@getEdit');
        Route::post('/reply/{id}', 'CommentController@postReply');
        Route::get('/delete/{id}', 'CommentController@getDelete');
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

    Route::prefix('postCategory')->group(function () {
        Route::get('/add', 'PostCategoryController@getAdd');
        Route::get('/all', 'PostCategoryController@getAll');
        Route::post('/add', 'PostCategoryController@postAdd');
        Route::get('/inactive/{id}', 'PostCategoryController@getInactive');
        Route::get('/active/{id}', 'PostCategoryController@getActive');

        Route::get('/edit/{id}', 'PostCategoryController@getEdit');
        Route::post('/edit/{id}', 'PostCategoryController@postEdit');
        Route::get('/delete/{id}', 'PostCategoryController@getDelete');
    });

    Route::prefix('post')->group(function () {
        Route::get('/add', 'PostController@getAdd');
        Route::get('/all', 'PostController@getAll');
        Route::post('/add', 'PostController@postAdd');
        Route::get('/inactive/{id}', 'PostController@getInactive');
        Route::get('/active/{id}', 'PostController@getActive');

        Route::get('/edit/{id}', 'PostController@getEdit');
        Route::post('/edit/{id}', 'PostController@postEdit');
        Route::get('/delete/{id}', 'PostController@getDelete');
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

    Route::prefix('gallery')->group(function () {
        Route::get('/all/{product_id}', 'GalleryController@getAll');

        Route::get('/delete/{id}', 'GalleryController@getDelete');

        Route::post('/edit/{id}', 'GalleryController@postEdit');
        Route::post('/add', 'GalleryController@postAdd');
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

    Route::prefix('order')->group(function () {
        Route::get('/all', 'OrderController@getAll');

        Route::get('/status/{id}', 'OrderController@getStatus');
        Route::get('/detail/delete/{id}', 'OrderController@getDeleteDetail');

        Route::get('/edit/{id}', 'OrderController@getEdit');
        Route::post('/edit/{id}', 'OrderController@postEdit');
        Route::get('/delete/{id}', 'OrderController@getDelete');
    });

    Route::prefix('banner')->group(function () {
        Route::get('/add', 'BannerController@getAdd');
        Route::get('/all', 'BannerController@getAll');
        Route::post('/add', 'BannerController@postAdd');
        Route::get('/inactive/{id}', 'BannerController@getInactive');
        Route::get('/active/{id}', 'BannerController@getActive');

        Route::get('/edit/{id}', 'BannerController@getEdit');
        Route::post('/edit/{id}', 'BannerController@postEdit');
        Route::get('/delete/{id}', 'BannerController@getDelete');
    });

    Route::prefix('user')->middleware('auth.roles')->group(function () {
        Route::get('/all', 'UserController@getAll');
        Route::get('/add', 'UserController@getAdd');
        Route::get('/edit/{id}', 'UserController@getEdit');
        Route::get('/delete/{id}', 'UserController@getDelete');

        Route::post('/edit/{id}', 'UserController@postEdit');
        Route::post('/add', 'UserController@postAdd');

        Route::post('/assign-roles', 'UserController@assignRoles');
    });
});
