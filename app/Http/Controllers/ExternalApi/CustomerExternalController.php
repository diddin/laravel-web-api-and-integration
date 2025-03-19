<?php

namespace App\Http\Controllers\ExternalApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExternalApi\CustomerApiClient;

class CustomerExternalController extends Controller
{
    protected $customerApiClient;

    public function __construct(CustomerApiClient $customerApiClient)
    {
        $this->customerApiClient = $customerApiClient;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = $this->customerApiClient->getAll();

        if($customers->status() ==  200) { 
            return response()->json(
                ['data' => $customers['data']]
            );
        }
        return $customers;
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $createdCustomer = $this->customerApiClient->createCustomer($request);
        if($createdCustomer->status() ==  200) { 
            return response()->json($createdCustomer, 201);
        }
        return $createdCustomer;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = $this->customerApiClient->getCustomer($id);
        if($customer->status() ==  200) { 
            return response()->json(
                ['data' => $customer['data']]
            );
        }
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     $customer = $this->customerApiClient->getCustomer($id);
    //     if($customer->status() ==  200) {
    //         return response()->json($customer);
    //     }
    //     return $customer;
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = $this->customerApiClient->updateCustomer($request);
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = $this->customerApiClient->deleteCustomer($id);
        return $customer;
    }
}
