<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CustomerApiServiceInterface;
use App\Services\CustomerApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerApiServiceInterface::class, CustomerApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
