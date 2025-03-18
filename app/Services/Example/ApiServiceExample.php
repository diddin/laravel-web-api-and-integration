<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\ApiServiceExampleInterface;

class ApiServiceExample implements ApiServiceExampleInterface
{
    protected $baseUrl;
    protected $apiKey;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
        $this->apiKey = config('services.external_api.api_key');
    }

    public function fetchData(string $endpoint): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . $endpoint);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Failed to fetch data from external API');
        } catch (\Exception $e) {
            // Log the error or handle it as appropriate
            return ['error' => $e->getMessage()];
        }
    }
}
