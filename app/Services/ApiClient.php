<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Exception;

class ApiClient
{
    protected $baseUrl;
    protected $client;
    protected $bearerToken;
    protected $apiKey;
    protected $timeout = 30; // Timeout in seconds

    /**
     * Constructor to initialize the base URL for the API service
     *
     * @param string $service
     */
    public function __construct(string $service)
    {
        $this->baseUrl = $this->getServiceBaseUrl($service);
        $this->client = Http::baseUrl($this->baseUrl);
        $this->bearerToken = $this->getBearerToken($service);
        $this->apiKey = $this->getApiKey($service);
        // Add Bearer token to all requests if provided
        if ($this->bearerToken || $this->apiKey) {
            $this->client = $this->client->withHeaders([
                'Authorization' => 'Bearer ' . $this->bearerToken || $this->apiKey,
            ]);
        }
    }

    /**
     * Dynamically retrieve the base URL for a service.
     *
     * @param string $service
     * @return string
     */
    protected function getServiceBaseUrl(string $service): string
    {
        // You can configure your services in a config file (config/services.php)
        $services = config('services');

        if (!isset($services[$service])) {
            return $this->handleException("Service {$service} is not configured.");
            //throw new \Exception("Service {$service} is not configured.");
        }

        return $services[$service]['base_url'];
    }

    /**
     * Dynamically retrieve the token for a service.
     *
     * @param string $service
     * @return string
     */
    protected function getBearerToken(string $service): string
    {
        // You can configure your services in a config file (config/services.php)
        $services = config('services');

        if (!isset($services[$service])) {
            return $this->handleException("Service {$service} is not configured.");
            //throw new \Exception("Service {$service} is not configured.");
        }

        return $services[$service]['bearer_token'];
    }

    /**
     * Dynamically retrieve the api key for a service.
     *
     * @param string $service
     * @return string
     */
    protected function getApiKey(string $service): string
    {
        // You can configure your services in a config file (config/services.php)
        $services = config('services');

        if (!isset($services[$service])) {
            return $this->handleException("Service {$service} is not configured.");
            //throw new \Exception("Service {$service} is not configured.");
        }

        return $services[$service]['api_key'];
    }

    /**
     * Send a GET request to a specified endpoint.
     *
     * @param string $endpoint
     * @param array $params
     * @return \Illuminate\Http\Client\Response
     */
    public function get(string $endpoint, array $params = [])
    {
        return $this->sendRequest('GET', $endpoint, $params);

        //return $this->client->get($endpoint, $params);
    }

    /**
     * Send a POST request to a specified endpoint.
     *
     * @param string $endpoint
     * @param array $data
     * @return \Illuminate\Http\Client\Response
     */
    public function post(string $endpoint, array $data = [])
    {
        return $this->sendRequest('POST', $endpoint, $data);
        //return $this->client->post($endpoint, $data);
    }

    /**
     * Send a PUT request to a specified endpoint.
     *
     * @param string $endpoint
     * @param array $data
     * @return \Illuminate\Http\Client\Response
     */
    public function put(string $endpoint, array $data = [])
    {
        return $this->sendRequest('PUT', $endpoint, $data);
        //return $this->client->put($endpoint, $data);
    }

    /**
     * Send a DELETE request to a specified endpoint.
     *
     * @param string $endpoint
     * @return \Illuminate\Http\Client\Response
     */
    public function delete(string $endpoint, array $params = [])
    {
        return $this->sendRequest('DELETE', $endpoint, $params);
        //return $this->client->delete($endpoint, $params);
    }

    /**
     * Send a request
     */
    protected function sendRequest(string $method, string $endpoint, array $params = [])
    {
        try {
            return $this->client->$method($endpoint, $params);
        } catch (ConnectionException $e) {
            return $this->handleException('Connection error. The API service might be offline.');
        } catch (RequestException $e) {
            // Check for timeout specifically
            if ($e->getMessage() === 'Request timed out' || strpos($e->getMessage(), 'cURL error 28') !== false) {
                return $this->handleException('Request timed out. The API service might be too slow or unresponsive.');
            }
            return $this->handleException('An error occurred while processing the request.');
        } catch (Exception $e) {
            return $this->handleException('An unexpected error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Handle exceptions and return a response message or log the error.
     *
     * @param string $message
     * @return string
     */
    private function handleException(string $message, int $statusCode = 500) : JsonResponse
    {
        // Optionally, you can log the exception details for further analysis
        // Log::error($message);

        //return response()->json();

        return response()->json([
            'error' => true,
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);
    }
}
