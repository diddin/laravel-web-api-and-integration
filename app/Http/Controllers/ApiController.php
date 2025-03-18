<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerApiServiceInterface;
use Illuminate\Support\Facades\Response;
use App\Exceptions\ExternalApiException;



class ApiController extends Controller
{
    protected $customerService;

    public function __construct(CustomerApiServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getCustomer($id)
    {
        try {
            // Call the service to get customer data
            $customerData = $this->customerService->getCustomer($id);

            return response()->json($customerData);

            //return view('customer.index', compact('customer'));
        } catch (ExternalApiException $e) {
            // Handle the custom exception and show an error message
            // return response()->json([
            //     'error' => $e->getMessage(),
            //     'api_response' => $e->getCode() == 500 ? 'API not reachable' : $e->getMessage()
            // ], 500);

            return response()->json([
                'error' => $e->getMessage(),
                'api_response' => $e->getCode() == 500 ? 'API not reachable' : $e->getMessage()
            ], 500);
        }
    }
}
