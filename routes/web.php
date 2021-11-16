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


Auth::routes();

Route::get('register', 'HomeController@index');
Route::get('password/reset', 'HomeController@index');
Route::get('/', 'HomeController@index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('appUsers', 'AppUserController');
    Route::resource('userTokens', 'UserTokenController');
    Route::resource('userSubscriptions', 'UserSubscriptionController');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});





