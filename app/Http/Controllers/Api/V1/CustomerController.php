<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use App\Http\Controllers\Controller; // noted to use controller because since moved in sub dir
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use Illuminate\Http\Request;
use App\Filters\Api\V1\CustomersFilter;
use App\Http\Requests\Api\V1\StoreCustomerRequest;
use App\Http\Requests\Api\V1\UpdateCustomerRequest;


class CustomerController extends Controller
{
    protected $resourceNotFoundException;

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request); // column, value, operator

        // if return with invoices relationship
        $includeInvoices = $request->query('includeInvoices');
        $customers = Customer::where($filterItems);
        if($includeInvoices) {
            $customers = $customers->with('invoices');
        }
        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //return new CustomerResource(Customer::create($request->all()));
        return new CustomerResource(Customer::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Customer $customer)
    {
        $includeInvoices = $request->query('includeInvoices');

        if($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        //$customer->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
