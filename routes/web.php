<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/inventory', 'HomeController@inventoryIndex')->name('inventory');

Route::get('product/{inventorySlug}', 'ProductController@index')->name('product.index');
Route::get('inventory/update', 'ProductController@edit')->name('product.edit');
Route::put('inventory/update', 'ProductController@update')->name('product.update');
