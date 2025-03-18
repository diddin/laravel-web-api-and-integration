<?php

namespace App\Http\Clients;

class CustomerApiClient extends BaseHttpClient
{
    public function __construct()
    {
        parent::__construct(config('services.customer_api.base_url'), [
            'Authorization' => 'Bearer ' . config('services.customer_api.token'),
        ]);
    }

    public function getAll()
    {
        return $this->get('/customers');
    }

    public function getCustomer($customerId)
    {
        return $this->get("/customers/{$customerId}");
    }

    public function createCustomer($data)
    {
        return $this->post('/customers', $data);
    }

    public function updateCustomer($data)
    {
        return $this->put('/customers', $data);
    }

    public function deleteCustomer($customerId)
    {
        return $this->delete("/customers/{$customerId}");
    }
}

