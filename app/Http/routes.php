<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'TaxiController@home');

Route::get('home', function () {
    return view('static.home');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('profile', 'UserController@profile');
Route::resource('user', 'UserController');

Route::get('report', 'TaxiController@report');
Route::get('show/{id}', 'TaxiController@show');
Route::get('report/{id}', 'TaxiController@create');
Route::post('report', 'TaxiController@store');
Route::post('mail', 'TaxiController@mail');

Route::get('search/', 'TaxiController@search');

Route::get('api/show/{taxi_id}', 'ApiController@show');
Route::get('api/search/{keyword}', 'ApiController@search');
