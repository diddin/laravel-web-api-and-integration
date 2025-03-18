<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ExternalApiException extends Exception
{
    protected $message;
    protected $apiResponse;

    public function __construct($message = "An error occurred with the external API", $apiResponse = null)
    {
        $this->message = $message;
        $this->apiResponse = $apiResponse;

        // Pass the message to the parent Exception class
        parent::__construct($this->message);
    }

    // Optional: You can add custom logic to retrieve or format the error response
    public function report()
    {
        // Log the exception to the Laravel log or any external service (e.g., Sentry)
        Log::error('External API Error: ' . $this->message, [
            'api_response' => $this->apiResponse
        ]);
    }

    // You can also customize the render method for custom error responses
    public function render($request)
    {
        // Return a custom response to the client or just throw a 500 error
        return response()->json([
            'error' => $this->message,
            'api_response' => $this->apiResponse,
        ], 500);
    }
}
