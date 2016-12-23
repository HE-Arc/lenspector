<?php

namespace App\Http\Controllers;

use App\Lens;
use App\ProductType;
use App\InventoryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\InventoryStatus  $inventoryStatus
     * @return \Illuminate\Http\Response
     */
    public function index(InventoryStatus $inventoryStatus)
    {
        $types = ProductType::withCount(['product' => function ($query) use ($inventoryStatus) {
            $query->where('status', $inventoryStatus->id);
        }])
            ->get()
            ->groupBy('id');
        $products = Lens::where('status', $inventoryStatus->id)
            ->where('exclude', 0)
            ->select(DB::raw('*, count(*) as total'))
            ->groupBy('productId', 'sphCorrected')
            ->orderBy('productId', 'sphCorrected')
            ->get();

        foreach ($products as $product) {
            $types[$product->productId]->products[] = $product;
        }

        return view('inventory/inventory-index', compact('types', 'inventoryStatus'));
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
     * @param  \App\InventoryStatus  $inventoryStatus
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryStatus $inventoryStatus, $productType, $diopter)
    {
        $type = ProductType::where('slug', $productType)->first();
        if ($type == null) {
            return redirect()
                ->back()
                ->withErrors('Please choose an existing product type');
        }
        $products = Lens::where('status', $inventoryStatus->id)
            ->where('exclude', 0)
            ->where('productId', $type->id)
            ->where('SphCorrected', $diopter)
            ->orderBy('dateExpiration')
            ->paginate(15);

        $total = Lens::where('status', $inventoryStatus->id)
            ->where('exclude', 0)
            ->where('productId', $type->id)
            ->where('SphCorrected', $diopter)
            ->count();

        return view('inventory/inventory-show',
            compact('inventoryStatus', 'products', 'type', 'diopter', 'total')
        );
    }

    /**
     * Show the form for updating a ressource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($inventory)
    {
        if ($inventory === 'remote') {
            $inventoryStatuses = InventoryStatus::whereIn('name', [
                'consignment', 'sales',
            ])
            ->get();
        } elseif ($inventory === 'internal') {
            $inventoryStatuses = InventoryStatus::where('name', 'on hands')
                ->firstOrFail();
        } else {
            return redirect()->back()
                ->withErrors('Please choose an existing inventory.');
        }

        return View('inventory/inventory-update', compact('inventory', 'inventoryStatuses'));
    }

    /**
     * Update a ressource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $inventory)
    {
        if ($inventory === 'internal') {
            $this->validate($request, [
                'serial_number' => [
                    'required',
                    'regex:/F[0-9]{8}/',
                    'exists:lense,sn',
                ],
            ]);
            $inventoryStatus = InventoryStatus::where('name', 'on hands')
                ->firstOrFail();
            $request->inventory_status = $inventoryStatus->id;
        } elseif ($inventory === 'remote') {
            $func = function ($status) {
                return $status['id'];
            };

            $inventoryStatuses = InventoryStatus::whereIn('name', [
                'consignment', 'sales',
            ])
            ->get();

            $legalStatuses = implode(',', array_map($func, $inventoryStatuses->toArray()));
            $this->validate($request, [
                'inventory_status' => [
                    'required',
                    'exists:inventory_statuses,id',
                    'in:'.$legalStatuses,
                ],
                'serial_number' => [
                    'required',
                    'regex:/F[0-9]{8}/',
                    'exists:lense,sn',
                ],
            ]);
        } else {
            return redirect()->back()
                ->withErrors('Please choose an existing inventory.');
        }

        $lens = Lens::where('sn', '=', $request->serial_number)
            ->where('exclude', 0)
            ->first();

        if ($lens == null) {
            return redirect()->back()
                ->withErrors('The specified lens does not exist or is excluded.');
        }
        $lens->update([
            'status' => $request->inventory_status,
        ]);

        return redirect()->back()
            ->with('status', 'Lens\' status successfully updated');
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
