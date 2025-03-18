<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerApiFromServiceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::resource('posts', PostController::class)->middleware(['auth']);
Route::resource('articles', ArticleController::class)->middleware(['auth']);
Route::resource('customers', CustomerController::class)->middleware(['auth']);
Route::resource('customersapi', CustomerApiFromServiceController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/customersfromservice/{id}', [ApiController::class, 'getCustomer']);