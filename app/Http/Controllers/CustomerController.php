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
        if (request()->ajax()) {
            $customers = Customer::all();

            return response()->json(compact('customers'));
        }
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
            'country_name' => 'required|exists:countries,name',
            'vat' => 'string',
        ]);

        $request['country_id'] = Country::where('name', $request->country_name)
            ->first()->id;

        $customer = new Customer($request->only('first_name',
            'last_name', 'company_name', 'department',
            'street_name', 'building_number', 'post_code',
            'city', 'country_id', 'phone_number',
            'fax_number', 'email', 'vat')
        );

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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customer/customer-show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $countries = Country::all();

        return view('customer/customer-create', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
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
            'country_name' => 'required|exists:countries,name',
            'vat' => 'string',
        ]);

        $request['country_id'] = Country::where('name', $request->country_name)
            ->first()->id;

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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($customer)
    {
        //
    }

    /**
     * Search a matching resource from storage.
     *
     * @param  string  $term
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if ($request->search_term == null) {
            return redirect()->route('customer.index');
        } else {
            $searchTerm = $request->search_term;
        }

        $customers = Customer::join('countries', 'customers.country_id', '=', 'countries.id')
            ->select('customers.*', 'countries.name')
            ->where('last_name', 'LIKE', "%$searchTerm%")
            ->orwhere('first_name', 'LIKE', "%$searchTerm%")
            ->orwhere('customers.id', 'LIKE', "%$searchTerm%")
            ->orwhere('company_name', 'LIKE', "%$searchTerm%")
            ->orwhere('countries.name', 'LIKE', "%$searchTerm%")
            ->orwhere('city', 'LIKE', "%$searchTerm%")
            ->orwhere('department', 'LIKE', "%$searchTerm%")
            ->orderBy('company_name')
            ->get();

        $customersTotal = Customer::all()->count();

        return view('customer/customer-index', compact('customers', 'customersTotal'));
    }
}
