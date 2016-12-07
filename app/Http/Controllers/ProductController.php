<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\InventoryStatus;
use App\ProductType;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ProductType::withCount('product')->get()->groupBy('id');
        $products = Product::select(DB::raw('*, count(*) as total'))
            ->groupBy('productId', 'sphCorrected')
            ->orderBy('productId', 'sphCorrected')
            ->get();

        foreach($products as $product) {
            $types[$product->productId]->products[] = $product;
        }
        //dd($types);

        return view('inventory', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for updating a ressource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $statuses = InventoryStatus::findOrFail([1, 4]);

        return View('inventory/inventory-update', compact('statuses'));
    }

    /**
     * Update a ressource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'inventory_status' => 'required|in:1,4|exists:inventory_status,id',
            'serial_number' => [
                'required',
                'regex:/F[0-9]{8}/',
                'exists:lense,sn',
            ],
        ]);

        $lens = Product::where('sn', '=', $request->serial_number)
            ->where('exclude', '=', 0)
            ->first();
        if ($lens == null) {
            return redirect()->back()
                ->withErrors('The specified lens does not exist or is excluded');
        }
        $lens->update([
            'status' => $request->inventory_status,
        ]);

        return redirect()->back()
            ->with('status', 'Lens successfully updated');
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
