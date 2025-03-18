<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Clients\CustomerApiClient;
use Inertia\Inertia;

class CustomerController extends Controller
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
            //return $customers->json();
            return response()->json($customers['data']);
        }
        return $customers;
        
        return Inertia::render('articles/index', [
            'customers' => (object) response()->json($customers['data']) //$customers['data']
        ]);
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
    public function store(Request $request)
    {
        $data = $request->only(['name', 'email']);
        $createdCustomer = $this->customerApiClient->createCustomer($data);
        // $createdUser = $this->customerApiClient->createCustomer([
        //     "name" => "McDermott, Yundt and Bogan",
        //     "type" => "business",
        //     "email" => "jerome.gutmanwn@example.net",
        //     "address" => "72654 Emard Rapids Suite 813",
        //     "city" => "Handchester",
        //     "state" => "South Carolina",
        //     "postalCode" => "21368-4823"
        // ]);
        if($createdCustomer->status() ==  200) { 
            //return $createdCustomer->json();
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
            //return $customer->json();
            return response()->json($customer['data']);
        }
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = $this->customerApiClient->getCustomer($id);
        if($customer->status() ==  200) { 
            //return $customer->json();
            return response()->json($customer['data']);
        }
        return $customer;
        return Inertia::render('articles/index', [
            'customers' => (object) response()->json($customers['data']) //$customers['data']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = $this->customerApiClient->updateCustomer($request);
        if($customer->status() ==  200) { 
            //return $customer->json();
            return response()->json($customer['data']);
        }
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = $this->customerApiClient->deleteCustomer($id);
        if($customer->status() ==  200) { 
            //return $customer->json();
            return response()->json($customer['data']);
        }
        return $customer;
    }
}
