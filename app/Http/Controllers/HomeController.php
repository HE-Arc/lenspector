<?php

namespace App\Http\Controllers;

use App\ProductType;

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
        $productType = ProductType::all()->first();
        $links = [
           [
                'title' => 'On hands inventory',
                'link' => route('inventory.index', [
                    'on-hands', $productType,
                ]),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Consignment inventory',
                'link' => route('inventory.index', [
                    'consignment', $productType,
                ]),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Sales',
                'link' => route('inventory.index', [
                    'sales', $productType,
                ]),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Move to packship',
                'link' => route('inventory.edit', ['internal']),
                'glyphicon' => 'glyphicon-inbox',
            ],
            [
                'title' => 'Move to a remote inventory',
                'link' => route('inventory.edit', ['remote']),
                'glyphicon' => 'glyphicon-inbox',
            ],
        ];

        return view('home', compact('title', 'jumbotronMessage', 'links'));
    }
}
