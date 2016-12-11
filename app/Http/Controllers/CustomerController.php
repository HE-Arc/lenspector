<?php

namespace App\Http\Controllers;

use App\Country;
use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customersTotal = Customer::count();
        $customers = Customer::orderBy('company_name')
            ->paginate(15);

        return view('customer/customer-index', compact(
            'customers', 'customersTotal')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('customer/customer-create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'first_name' => 'string',
            'last_name' => 'string',
            'department' => 'string',
            'phone_number' => 'required|string',
            'fax_number' => 'string',
            'email' => 'email',
            'post_code' => 'numeric',
            'street_name' => 'required|string',
            'building_number' => 'required|numeric',
            'city' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'vat' => 'string',
        ]);

        $customer = new Customer($request->only('first_name',
            'last_name', 'company_name', 'department',
            'street_name', 'building_number', 'post_code',
            'city', 'country_id', 'phone_number',
            'fax_number', 'email', 'vat')
        );
        // dd($customer);
        // dd("toto");
        $customer = $customer->save();
        if ($customer == null) {
            return redirect()->back()
                ->withErrors('Customer could not be created.');
        }

        return redirect()->back()
            ->with('status', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($customerSlug)
    {
        $customer = Customer::where('slug', $customerSlug)
            ->leftJoin('countries', 'customers.country_id', '=', 'countries.id')
            ->select('customers.*', 'countries.name as country_name')
            ->get()
            ->first();
        if ($customer == null) {
            return redirect()->back()
                ->withErrors('The specified customer does not exist');
        }

        return view('customer/customer-show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($customerSlug)
    {
        $customer = Customer::where('slug', $customerSlug)
            ->get()
            ->first();
        $countries = Country::all();

        return view('customer/customer-create', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customerSlug)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'first_name' => 'string',
            'last_name' => 'string',
            'department' => 'string',
            'phone_number' => 'required|string',
            'fax_number' => 'string',
            'email' => 'email',
            'post_code' => 'numeric',
            'street_name' => 'required|string',
            'building_number' => 'required|numeric',
            'city' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'vat' => 'string',
        ]);

        $customer = Customer::where('slug', $customerSlug)
            ->get()
            ->first();

        if ($customer == null) {
            return redirect()->back()
                ->withErrors('The specified customer does not exist');
        }

        $customer->update($request->only('first_name',
            'last_name', 'company_name', 'department',
            'street_name', 'building_number', 'post_code',
            'city', 'country_id', 'phone_number',
            'fax_number', 'email', 'vat')
        );

        return redirect()->route('customer.index')
            ->with('status', 'Customer successfully updated');
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
