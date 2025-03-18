<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Exception;

class BaseHttpClient
{
    protected $baseUri;
    protected $headers;

    public function __construct($baseUri = null, $headers = [])
    {
        $this->baseUri = $baseUri ?: config('services.default_api_url');
        $this->headers = $headers;
    }

    /**
     * Perform a GET request
     */
    public function get(string $endpoint, array $params = [])
    {
        return $this->sendRequest('GET', $endpoint, $params);
    }

    /**
     * Perform a POST request
     */
    public function post(string $endpoint, array $params = [])
    {
        return $this->sendRequest('POST', $endpoint, $params);
    }

    /**
     * Perform a PUT request
     */
    public function put(string $endpoint, array $params = [])
    {
        return $this->sendRequest('PUT', $endpoint, $params);
    }

    /**
     * Perform a DELETE request
     */
    public function delete(string $endpoint, array $params = [])
    {
        return $this->sendRequest('DELETE', $endpoint, $params);
    }

    /**
     * Send a request
     */
    protected function sendRequest(string $method, string $endpoint, array $params = [])
    {
        try {
            //return $this->client->$method($endpoint, $params);
            return Http::withHeaders($this->headers)
            ->baseUrl($this->baseUri)
            ->$method($endpoint, $params);
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

