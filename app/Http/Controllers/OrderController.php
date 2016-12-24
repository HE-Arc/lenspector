<?php

namespace App\Http\Controllers;

use App\Lens;
use App\Order;
use App\Customer;
use App\OrderType;
use App\OrderStatus;
use App\ProductType;
use App\OrderElement;
use App\InventoryStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function index(OrderStatus $orderStatus)
    {
        $orderStatusesCounts = OrderStatus::withCount('orders')->get();

        $orders = Order::where('order_status_id', $orderStatus->id)
            ->with('customer', 'orderStatus')
            ->get();

        return view('order/index', compact('orders', 'orderStatus', 'orderStatusesCounts'));
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

        return view('order/create', compact('orderTypes', 'productTypes', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
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
        foreach ($quantity as $key => $value) {
            for ($j = 0; $j < $value; $j++) {
                $order->orderElements()->save(new OrderElement([
                        'product_type_id' => $request->product_type_id[$key],
                        'requested_diopter' => $request->diopter[$key],
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orderElements = [];
        foreach ($order->orderElements as $element) {
            $productName = $element->productType()->get()->first()->name;
            $diopter = (string) $element->requested_diopter;

            if (array_key_exists($productName, $orderElements)) {
                if (array_key_exists($diopter, $orderElements[$productName])) {
                    array_push($orderElements[$productName][$diopter], $element);
                } else {
                    $orderElements[$productName][$diopter] = [
                        $element,
                    ];
                }
            } else {
                $orderElements[$productName] = [
                    $diopter => [
                        $element,
                    ],
                ];
            }
        }

        return view('order/show', compact('order', 'orderElements'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $orderTypes = OrderType::all();
        $productTypes = ProductType::all();
        $customers = Customer::all();

        return view('order/create', compact('order', 'orderTypes', 'productTypes', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'order_type_id' => 'required|exists:order_types,id',
        ]);

        $order->update($request->only([
            'customer_id', 'order_type_id',
        ]));

        return redirect()->route('order.show', $order)
            ->with('status', 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Show the form to set the specified resource from storage as shipped.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function shipping(Order $order)
    {
        foreach ($order->orderElements as $element) {
            if ($element->lensId == null) {
                return redirect()->route('order.show', $order)
                    ->withErrors('This order is not complete. Please assign
                        a lens to each order element before trying to ship
                        this order.
                    ');
            }
        }

        return view('order/ship', compact('order'));
    }

    /**
     * Set the specified resource from storage as shipped.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function ship(Order $order)
    {
        dd('Order shipping is not yet implemented!');
    }

    /**
     * Show the form for completing the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function completeOrder(Order $order)
    {
        return view('order/complete', compact('order'));
    }

    /**
     * Add a lens to the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderElemenent  $orderElement
     * @return \Illuminate\Http\Response
     */
    public function addLens(Request $request, OrderElement $orderElement)
    {
        $this->validate($request, [
            'serial_number' => 'required|exists:lense,sn',
        ]);
        $status = InventoryStatus::where('name', 'on hands')->first();
        $lens = Lens::where('sn', $request->serial_number)
            ->where('status', $status->id)
            ->where('sphCorrected', $orderElement->requested_diopter)
            ->where('productId', $orderElement->product_type_id)
            ->first();

        if ($lens == null) {
            return redirect()->back()
                ->withErrors('The specified lens does not exist or does not
                    match the order requirement.
                ');
        }

        $order = $orderElement->order()->first();

        $newInventoryStatus = $order->orderType()->first()
            ->inventoryStatus()->first()->id;

        $lens->update([
            'status' => $newInventoryStatus,
        ]);

        $orderElement->lens()->associate($lens);
        $orderElement->save();

        return redirect()->route('order.complete', $order)
            ->with('status', 'Lens assigned to the specified element.');
    }
}
