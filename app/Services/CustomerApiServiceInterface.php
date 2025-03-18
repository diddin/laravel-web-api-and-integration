<?php

namespace App\Services;

interface CustomerApiServiceInterface
{
    public function getCustomer(int $id): array;
}
