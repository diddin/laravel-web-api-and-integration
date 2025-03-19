<?php

namespace App\Filters\Api\V1;

use Illuminate\Http\Request;

/**
 * Invoices Filter
 * using for mapping query parameters to Eloquent query
 * http://127.0.0.1:8000/api/v1/invoices?customerId[gt]=20
 */
class InvoicesFilter
{
   
    protected $safeParams = [
        'customerId' => ['eq'],
        'amount' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'status' => ['eq', 'ne'],
        'billedDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'paidDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],
    ];
    

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' =>'billed_date',
        'paidDate' => 'paid_date'

    ];

    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'lte' => '<=',
        'gte' => '>=',
        'ne' => '<>'
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