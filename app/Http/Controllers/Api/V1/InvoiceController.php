<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Http\Controllers\Controller; // noted to use controller because since moved in sub dir
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Resources\V1\InvoiceCollection;
use App\Filters\Api\V1\InvoicesFilter;
use App\Http\Requests\Api\V1\BulkStoreInvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request); // column, value, operator

        $includeCustomers = $request->query('includeCustomers');

        $invoices = Invoice::where($queryItems);

        if($includeCustomers) {
            $invoices = $invoices->with('customers');
        }

        // if return with customers relationship
        return new InvoiceCollection($invoices->paginate()->appends($request->query()));


        // if return without customers relationship
        if(count($queryItems) > 0) {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
        } else {
            return new InvoiceCollection(Invoice::paginate());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreInvoiceRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Invoice $invoice)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Invoice $invoice)
    // {
    //     //
    // }

    public function bulkStore(BulkStoreInvoiceRequest $request) {
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });
        Invoice::insert($bulk->toArray());
    }
}
