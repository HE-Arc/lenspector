<?php

namespace App\Http\Controllers;

use App\Order;
use App\Customer;
use App\OrderType;
use App\OrderStatus;
use App\ProductType;
use App\OrderElement;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderStatus $orderStatus)
    {
        $orderStatusesCounts = OrderStatus::withCount('orders')->get();

        $orders = Order::where('order_status_id', $orderStatus->id)
            ->with('customer', 'orderStatus')
            ->get();

        return view('order/order-index', compact('orders', 'orderStatus', 'orderStatusesCounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orderTypes = OrderType::all();
        $productTypes = ProductType::all();
        $customers = Customer::all();

        return view('order/order-create', compact('orderTypes', 'productTypes', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $diopters = range(5, 30, 0.5);
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'order_type_id' => 'required|exists:order_types,id',
            'product_type_id.*' => 'required|exists:product,id',
            'quantity.*' => 'required|numeric|min:1',
            'diopter.*' => 'required|in:'.implode(',', $diopters),
        ]);

        $order = new Order($request->only([
                'customer_id',
                'order_type_id',
            ])
        );

        $order->save();

        $orderElements = [];
        $quantity = $request->quantity;

        /* TODO: Might beed an optimisation. */
        for ($i = 0; $i < count($quantity); $i++) {
            for ($j = 0; $j < $quantity[$i]; $j++) {
                $order->orderElements()->save(new OrderElement([
                        'product_type_id' => $request->product_type_id[$i],
                        'requested_diopter' => $request->diopter[$i],
                    ])
                );
            }
        }

        return redirect()->back()
            ->with('status', 'Order created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
