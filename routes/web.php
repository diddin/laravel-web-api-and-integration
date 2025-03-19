<?php

use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\CustomerApiFromServiceController;
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
Route::resource('customersapi', CustomerApiFromServiceController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/external_api.php';