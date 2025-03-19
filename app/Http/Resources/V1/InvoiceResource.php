<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\CustomerResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request); // for output according database column
        return [ // custom output (modified from original output to what payload that you need)
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'billedDate' => $this->billed_date,
            'paidDate' => $this->paid_date,
            'customers' => CustomerResource::collection($this->whenLoaded('customers')), // whenLoaded
        ];
    }
}
