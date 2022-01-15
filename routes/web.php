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

});
