<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * CustomerQuery
 * using for mapping query parameters to Eloquent query
 * /api/v1/customers?postalCode[gt]=3000&type[eq]=individual
 */
class ApiFilter
{
    
    protected $safeParams = [];
    

    protected $columnMap = [];

    protected $operatorMap = [];

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