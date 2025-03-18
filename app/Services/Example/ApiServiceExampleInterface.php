<?php

namespace App\Services;

interface ApiServiceExampleInterface
{
    public function fetchData(string $endpoint): array;
}
