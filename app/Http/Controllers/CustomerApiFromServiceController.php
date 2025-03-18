<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiClient;

class CustomerApiFromServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Create an instance for service_customer_api
        $apiClient = new ApiClient('service_customer_api');
        
        // Call a GET request to the '/customers' all endpoint
        $response = $apiClient->get('/customers');
        
        // Handle the response
        if($response->status() ==  200) { 
            return $response->json();
        }
        return $response;
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
        // Create an instance for service_customer_api
        $apiClient = new ApiClient('service_customer_api');
        
        // Call a POST request to the '/customers' endpoint with payload
        // $response = $apiClient->post('/customers', [
        //     "name" => "McDermott, Yundt and Bogan",
        //     "type" => "business",
        //     "email" => "jerome.gutmanwn@example.net",
        //     "address" => "72654 Emard Rapids Suite 813",
        //     "city" => "Handchester",
        //     "state" => "South Carolina",
        //     "postalCode" => "21368-4823"
        // ]);
        $response = $apiClient->post('/customers', [$request]);
        
        // Handle the response
        //return $response->json();

        if($response->status() ==  200) { 
            return $response->json();
        }
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Create an instance for service_customer_api
        $apiClient = new ApiClient('service_customer_api');
        
        // Call a GET request to the '/customers' endpoint
        $response = $apiClient->get('/customers/' . $id);

        if($response->status() ==  200) { 
            return $response->json();
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Create an instance for service_customer_api
        $apiClient = new ApiClient('service_customer_api');
        
        // Call a GET request to the '/customers' endpoint
        $response = $apiClient->get('/customers/' . $id);

        if($response->status() ==  200) { 
            return $response->json();
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Create an instance for service_customer_api
        $apiClient = new ApiClient('service_customer_api');

        // $response = $apiClient->put('/customers', [
        //     "id" => $id,
        //     "name" => "McDermott, Yundt and Bogan",
        //     "type" => "business",
        //     "email" => "jerome.gutmanwn@example.net",
        //     "address" => "72654 Emard Rapids Suite 813",
        //     "city" => "Handchester",
        //     "state" => "South Carolina",
        //     "
        
        // Call a PUT request to the '/customers/{id}' endpoint
        $response = $apiClient->put('/customers/' . $id, [$request]);

        if($response->status() ==  200) { 
            return $response->json();
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Create an instance for service_customer_api
        $apiClient = new ApiClient('service_customer_api');
        
        // Call a DELETE request to the '/customers/{id}' endpoint
        $response = $apiClient->delete('/customers/' . $id);

        if($response->status() ==  200) { 
            return $response->json();
        }
        return $response;
    }
}
