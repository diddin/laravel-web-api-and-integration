<?php

use App\Http\Controllers\ExternalApi\CustomerExternalController;
use Illuminate\Support\Facades\Route;

Route::resource('customers', CustomerExternalController::class)->middleware(['auth']);
