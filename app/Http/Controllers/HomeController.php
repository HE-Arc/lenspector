<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
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
                'link' => route('inventory'),
                'glyphicon' => 'glyphicon-inbox',
            ],
            // [
            //     'title' => 'Orders',
            //     'link' => '',
            //     'glyphicon' => 'glyphicon-briefcase',
            // ],
            [
                'title' => 'Customers',
                'link' => route('customer.index'),
                'glyphicon' => 'glyphicon-user',
            ],
        ];

        return view('home', compact('title', 'jumbotronMessage', 'links'));
    }

    /**
     * Show the inventory dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function inventoryIndex()
    {
        $title = 'Inventory';
        $jumbotronMessage = 'Please choose an action in the above menu.';
        $links = [
           [
                'title' => 'On hands inventory',
                'link' => route('product.index', [
                    'inventorySlug' => 'on-hands',
                ]),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Consignment inventory',
                'link' => route('product.index', [
                    'inventorySlug' => 'consignment',
                ]),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Sales',
                'link' => route('product.index', [
                    'inventorySlug' => 'sales',
                ]),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Move to packship',
                'link' => '',
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Move to a remote inventory',
                'link' => '',
                'glyphicon' => 'glyphicon-inbox',
            ],
        ];

        return view('home', compact('title', 'jumbotronMessage', 'links'));
    }
}
