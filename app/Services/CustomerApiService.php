<?php

namespace App\Services;
use App\Services\CustomerApiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ExternalApiException;


class CustomerApiService implements CustomerApiServiceInterface
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.customer_api.base_url');
        $this->apiKey = config('services.customer_api.api_key');
    }

    public function getCustomer(int $id) : array {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get("{$this->baseUrl}/customers/{$id}");

            if ($response->successful()) {
                return $response->json();
            } elseif ($response->status() == 404) {
                return [
                    'error' => "Failed to fetch customer data with id {$id}",
                    'status' => $response->status()
                ];
            } else {
                return [
                    'error' => "Unexpected error occurred",
                    'status' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('Customer API Error: ' . $e->getMessage());
            throw new ExternalApiException(
                "An error occurred with the Customer API",
                $e->getMessage()
            );
        }
    }
}
