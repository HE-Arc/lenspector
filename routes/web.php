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
    //return view('welcome');
    $title = "Homepage";
    $jumbotronMessage = "Please choose an action in the above menu.";
    $links = array(
       array(
            'title' => 'Inventory',
            'link' => '',
            'glyphicon' => 'glyphicon-inbox'
        ),
        array(
            'title' => 'Orders',
            'link' => '',
            'glyphicon' => 'glyphicon-briefcase'
        ),
        array(
            'title' => 'Customers',
            'link' => '',
            'glyphicon' => 'glyphicon-user'
        )
    );

    return View::make("home", compact("title", "jumbotronMessage", "links"));
});
