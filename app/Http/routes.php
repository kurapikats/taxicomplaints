<?php
// Home page route
Route::get('/', 'TaxiController@home');

// Taxi Details route...
Route::get('/{id}', 'TaxiController@show')->where(['id' => '[0-9]+']);

// API endpoints...
Route::get('api/show/{taxi_id}', 'ApiController@show')
    ->where(['taxi_id' => '[0-9]+']);
Route::get('api/search/{keyword}', 'ApiController@search');
Route::put('api/validate', 'ApiController@complaintValidate');
Route::put('api/send-mail', 'ApiController@sendMail');
Route::post('api/report', 'ApiController@report');
Route::get('api/get-top-violators/{limit}', 'ApiController@getTopViolators')
    ->where(['limit' => '[0-9]+']);

// Admin page routes...
Route::get('admin/dashboard', 'AdminController@dashboard');
Route::get('admin/users', 'AdminController@users');
Route::delete('admin/delete/user', 'AdminController@deleteUser');

// User page routes...
Route::get('profile', 'UserController@profile');
Route::put('profile/update', 'UserController@profileUpdate');
Route::put('profile/change-password', 'UserController@changePassword');
Route::resource('user', 'UserController');

// Facebook Auth integration...
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/cb', 'Auth\AuthController@handleProviderCallback');

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
