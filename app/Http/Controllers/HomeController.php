<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        return view('home', compact('title', 'jumbotronMessage', 'links'));
    }
}
