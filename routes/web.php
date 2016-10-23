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

Route::get('/home', function () {
    $title = 'Homepage';
    $jumbotronMessage = 'Please choose an action in the above menu.';
    $links = [
       [
            'title' => 'Inventory',
            'link' => '',
            'glyphicon' => 'glyphicon-inbox',
        ],
        [
            'title' => 'Orders',
            'link' => '',
            'glyphicon' => 'glyphicon-briefcase',
        ],
        [
            'title' => 'Customers',
            'link' => '',
            'glyphicon' => 'glyphicon-user',
        ],
    ];

    return View::make('home', compact('title', 'jumbotronMessage', 'links'));
})->name('home');

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@login');
