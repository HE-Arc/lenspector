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

use App\Customer;
use App\ProductType;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/inventory', 'HomeController@inventoryIndex')->name('inventory');

    Route::resource('customer', 'CustomerController');
    Route::post('customer/search', 'CustomerController@search')
        ->name('customer.search');

    Route::get('inventory/{inventory}/update', 'LensController@edit')
        ->name('inventory.edit');
    Route::put('inventory/{inventory}/update', 'LensController@update')
        ->name('inventory.update');

    Route::get('inventory/{inventoryStatus}/{productType}/{diopter}',
        'LensController@show'
        )->name('inventory.show');
    Route::get('inventory/{inventoryStatus}/{productType}', 'LensController@index')
        ->name('inventory.index');

    Route::resource('order', 'OrderController', [
        'except' => [
            'index',
            ],
        ]);
    Route::get('customers', function (Request $request) {
        $customers = Customer::all();

        return response()->json(compact('customers'));
    });
    Route::get('product-types', function (Request $request) {
        $productTypes = ProductType::all();

        return response()->json(compact('productTypes'));
    });
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
