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

// Route::get('/', function () {
//     return view('welcome');
// });

view()->composer(['*'], function ($view) {
    $currentUser = Auth::user();
    $view->with('currentUser', $currentUser);
});

Route::get('/admin', 'AdminController@getAdminLogin');
Route::post('/admin', 'AdminController@postAdminLogin');

Route::prefix('admin')->middleware('adminLogin')->group(function () {
    Route::get('/dashboard', 'AdminController@showDashboard');
    
});
