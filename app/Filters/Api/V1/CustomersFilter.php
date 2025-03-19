<?php

namespace App\Filters\Api\V1;

use Illuminate\Http\Request;

/**
 * Customer Filter
 * using for mapping query parameters to Eloquent query
 * http://127.0.0.1:8000/api/v1/customers?postalCode[gt]=3000&type[eq]=individual
 */
class CustomersFilter
{
    
    protected $safeParams = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt']
    ];
    

    protected $columnMap = ['postalCode' => 'postal_code'];

    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'lte' => '<=',
        'gte' => '>=',
    ];

    public function transform(Request $request): array
    {
        $eloQuery = [];
        foreach ($this->safeParams as $param => $operator) {
            $query = $request->query($param);
            if(!isset($query)) {
                continue;
            }
            $column = $this->columnMap[$param] ?? $param;

            foreach ($operator as $op) {
                if(isset($query[$op])) {
                    $eloQuery[] = [$column, $this->operatorMap[$op], $query[$op]];
                }
            }
        }
        return $eloQuery;
    }
}