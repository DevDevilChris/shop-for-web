<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('/', 'HomeController');

// Checkout routes
Route::resource('checkout', 'CheckoutController');
Route::get('checkout/update/{product_key}/{qty}', 'CheckoutController@update_qty'); //route for ajax product quantity update
Route::get('checkout/remove/{product_key}', 'CheckoutController@remove_product'); //route for ajax product removal

// Catalogue routes
Route::resource('catalogue', 'CatalogueController');
Route::get('catalogue/add/{id}/{qty}', 'CatalogueController@add_to_cart'); //route to add product to cart

// Confide routes
Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');
