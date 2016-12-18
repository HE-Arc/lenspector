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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/inventory', 'HomeController@inventoryIndex')->name('inventory');

    Route::resource('customer', 'CustomerController');

    Route::get('product/{inventoryStatus}/{productType}/{diopter}',
        'LensController@show'
        )->name('product.show');
    Route::get('product/{inventoryStatus}', 'LensController@index')
        ->name('product.index');
    Route::get('inventory/{inventory}/update', 'LensController@edit')
        ->name('product.edit');
    Route::put('inventory/{inventory}/update', 'LensController@update')
        ->name('product.update');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
